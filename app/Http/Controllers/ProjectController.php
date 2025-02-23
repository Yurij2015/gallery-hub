<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveProjectReviewRequest;
use App\Http\Requests\SaveUserCommentRequest;
use App\Http\Requests\SaveUserDownloadRequest;
use App\Http\Requests\SaveUserLikeRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Services\BucketService;
use App\Http\Services\ProjectService;
use App\Models\Project;
use App\Models\UploadLog;
use App\Models\User;
use App\Models\UserReaction;
use Auth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Symfony\Component\HttpFoundation\File\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public string $mainStorage;
    public string $previewStorage;

    public function __construct()
    {
        $this->mainStorage = config('services.minio.main_storage');
        $this->previewStorage = config('services.minio.preview_storage');
    }

    public const TIME_OPTIONS = [
        1 => '1 month',
        2 => '2 months',
        6 => '6 months',
        12 => '1 year',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(BucketService $bucketService, ProjectService $projectService)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $projects = Project::with('user')->with('userReactions')->paginate(100);
        } else {
            $projects = Project::with('user')->with('userReactions')->where('user_id', $user->id)->paginate(100);
        }

        foreach ($projects as $project) {
            $bucketName = $project->bucket_name;
            $projectFolder = $project->project_folder;

            $userFolderName = $this->getUserFolderName($project);

            $projectObjects = $bucketService->listObjectsInFolder($bucketName, $userFolderName.'/'.$projectFolder);

            if (!$projectObjects) {
                $project->setProjecImage(url('images/empty-project.png'));
                continue;
            }

            foreach ($projectObjects as $object) {
                $key = $object->key;
                $imgUrl = $bucketService->getObjectUrl($bucketName, $key);
                break;
            }
            $this->setSizeAndCountOfObjects($projectObjects, $projectService, $project);

            $imgUrl = $project->cover_image ? $bucketService->getObjectUrl($bucketName,
                $project->cover_image) : $imgUrl;

            $project->setProjecImage($imgUrl);
        }

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $timeOptions = self::TIME_OPTIONS;

        return view('projects.create', compact('timeOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request, BucketService $bucketService)
    {
        $user = Auth::user();

        $files = $request->file('files');
        $userEmail = Auth::user()->email;
        $userName = explode('@', $userEmail)[0];
        $emailDomain = explode('@', $userEmail)[1];
        //TODO add unique userName
        $userDirectory = $userName.'.'.$emailDomain;

        $bucketName = $this->mainStorage;
        $validatedRequest = $request->validated();
        $projectSlug = Str::slug($validatedRequest['name']);
        $projectFolderName = $projectSlug.'-'.time();

        $metaData = [
            'projectName' => $validatedRequest['name'],
            'projectSlug' => $projectSlug,
            'userEmail' => $userEmail,
        ];

        if ($files) {
            foreach ($files as $file) {
                // exclude .DS_Store file
                // TODO - check and remove this condition
                if ($file->getClientOriginalName() === '.DS_Store') {
                    continue;
                }

                $objectName = $file->getClientOriginalPath();
                $objectPath = $file->getPathname();
                $content = file_get_contents($objectPath);
                $bucketService->putObject($bucketName, $userDirectory.'/'.$projectFolderName.'/'.$objectName, $content,
                    $metaData);
            }
        }

        $eventDate = Carbon::createFromFormat('m/d/Y', $validatedRequest['date']);;
        $expirationDate = $eventDate->copy()->addMonths((int) $validatedRequest['expiration_date']);

        $validatedRequest['slug'] = $projectSlug;
        $validatedRequest['bucket_name'] = $bucketName;
        $validatedRequest['project_folder'] = $projectFolderName;
        $validatedRequest['date'] = $eventDate->format('Y-m-d');
        $validatedRequest['expiration_date'] = $expirationDate->format('Y-m-d');
        $validatedRequest['user_id'] = $user->id;

        Project::create($validatedRequest);

        return redirect()->route('projects.index')->with('success', 'Project created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Project $project,
        BucketService $bucketService,
        Request $request,
        ProjectService $projectService
    ) {
        $projectFolder = $project->project_folder;

        if (!$projectFolder) {
            $emptyProjectFolder = true;
            return view('projects.show', compact('project', 'emptyProjectFolder'));
        }

        $bucketName = config('services.minio.main_storage');
        $userDirectory = $this->getUserFolderName($project);

        $childKeyParam = $request->get('childKey');
        $keySegmentsFromUrl = explode('/', $childKeyParam);
        $childKeyParam = $childKeyParam ? '/'.$childKeyParam : '';
        $countOfChildKeysInUrl = $childKeyParam ? count($keySegmentsFromUrl) - 1 : null;

        if (!$childKeyParam) {
            $projectFolderObjects = $bucketService->listObjectsInFolder($bucketName, $userDirectory.'/'.$projectFolder);
        } else {
            $projectFolderObjects = $bucketService->listObjectsInFolder($bucketName, $userDirectory.$childKeyParam);
        }

        if (!$projectFolderObjects) {
            $emptyProjectFolder = true;
            return view('projects.show', compact('project', 'emptyProjectFolder'));
        }

        if ($projectFolderObjects) {
            $objectsCount = count($projectFolderObjects);
            $sizeOfProject = $projectService->sizeOfProject($projectFolderObjects);
            $sizeOfProject = $projectService->formatProjectSize($sizeOfProject);
        } else {
            $objectsCount = 0;
            $sizeOfProject = 0;
        }

        $project->setSizeOfProjectFolder($sizeOfProject);
        $project->setObjectsCount($objectsCount);

        $childKeys = [];
        $filteredObjects = [];

        // TODO move logic to service
        foreach ($projectFolderObjects as $object) {
            $keySegments = explode('/', $object->key);
            $objectName = end($keySegments);
            $childKey = '';;

            if ((count($keySegments)) > 3 + $countOfChildKeysInUrl) {
                for ($i = 1; $i < count($keySegments) - 1; $i++) {
                    $childKey .= $keySegments[$i].'/';
                }
            } else {
                $filteredObjects[] = $object;
            }

            $key = $object->key;
            $imgUrl = $bucketService->getObjectUrl($bucketName, $key);
            $object->setObjectUrl($imgUrl);
            $object->setObjectName($objectName);
            if (!$childKey) {
                continue;
            }

            if (!in_array($childKey, $childKeys)) {
                $childKeys[] = $childKey;
            }
        }

        return view('projects.show',
            compact('project', 'projectFolderObjects', 'filteredObjects', 'childKeys', 'countOfChildKeysInUrl'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, BucketService $bucketService, Request $request)
    {
        $folderSlug = $request->get('folderSlug');

        if (!$project->project_folder) {
            return view('projects.edit', compact('project'));
        }

        $bucketName = $project->bucket_name;
        $projectDirectory = $project->project_folder;
        $userDirectory = $this->getUserFolderName($project);
        $projectObjects = $bucketService->listObjectsInFolder($bucketName,
            $userDirectory.'/'.$projectDirectory.'/'.$folderSlug);
        $projectFolders = $bucketService->getFoldersList($bucketName, $userDirectory.'/'.$projectDirectory);
        $projectFoldersWithFolderName = [];

        foreach ($projectFolders as $key => $folder) {
            $lastSegment = rtrim(basename(rtrim($folder, '/')), '/');
            $projectFoldersWithFolderName[$key]['folderKey'] = $folder;
            $projectFoldersWithFolderName[$key]['folderName'] = Str::title(str_replace('-', ' ', $lastSegment));
            $projectFoldersWithFolderName[$key]['folderSlug'] = $lastSegment;
        }

        if (!$projectObjects) {
            return view('projects.edit', compact('project'));
        }

        $projectFiles = array_filter($projectObjects, function ($object) {
            $array = explode('/', $object->key);
            return !empty(end($array));
        });

        $keys = array_map(fn($object) => $object->key, $projectFiles);
        $downloadCounts = UserReaction::whereIn('object_key', $keys)->pluck('download_statistic', 'object_key');

        foreach ($projectFiles as $object) {
            $key = $object->key;
            $keySegments = explode('/', $key);
            $objectName = end($keySegments);
            $imgUrl = $bucketService->getObjectUrl($bucketName, $key);
            $object->setObjectUrl($imgUrl);
            $object->setObjectName($objectName);
            $downloadsCount = $downloadCounts[$key] ?? 0;
            $object->setDownloadsCount($downloadsCount);;
        }

        return view('projects.edit', compact('project', 'projectFiles', 'projectFoldersWithFolderName'));
    }

    public function basicSettings(Project $project)
    {
        $timeOptions = self::TIME_OPTIONS;

        return view('projects.basic-settings', compact('project', 'timeOptions'));
    }

    public function designAndCover(Project $project)
    {
        return view('projects.design-and-cover', compact('project'));
    }

    public function reviews(Project $project)
    {
        $project->load([
            'userReactions' => function ($query) {
                $query->where('has_comment', true);
            }
        ]);

        return view('projects.reviews', compact('project'));
    }

    public function allReviews(BucketService $bucketService)
    {
        $userReactions = UserReaction::whereHas('project')
            ->with('project')
            ->where('review', '!=', '')->get();

        foreach ($userReactions as $userReaction) {
            $bucketName = $userReaction->project->bucket_name;
            $projectFolder = $userReaction->project->project_folder;
            $userFolderName = $this->getUserFolderName($userReaction->project);
            $projectObjects = $bucketService->listObjectsInFolder($bucketName, $userFolderName.'/'.$projectFolder);

            if (!$projectObjects) {
                $userReaction->project->setProjecImage(url('images/empty-project.png'));
                continue;
            }

            foreach ($projectObjects as $object) {
                $key = $object->key;
                $imgUrl = $bucketService->getObjectUrl($bucketName, $key);
                break;
            }

            $imgUrl = $userReaction->project->cover_image ? $bucketService->getObjectUrl($bucketName,
                $userReaction->project->cover_image) : $imgUrl;

            $userReaction->project->setProjecImage($imgUrl);
        }

        return view('projects.all-reviews', compact('userReactions'));
    }

    public function archive(BucketService $bucketService, ProjectService $projectService)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $projects = Project::with('user')
                ->with('userReactions')
                ->where('expiration_date', '<', now())
                ->paginate(100);
        } else {
            $projects = Project::with('user')
                ->with('userReactions')
                ->where('user_id', $user->id)
                ->where('expiration_date', '<', now())
                ->paginate(100);
        }

        foreach ($projects as $project) {
            $bucketName = $project->bucket_name;
            $projectFolder = $project->project_folder;
            $userFolderName = $this->getUserFolderName($project);
            $projectObjects = $bucketService->listObjectsInFolder($bucketName, $userFolderName.'/'.$projectFolder);

            $this->setSizeAndCountOfObjects($projectObjects, $projectService, $project);
        }

        return view('projects.archive', compact('projects'));
    }

    public function favorites(Project $project, Request $request)
    {
        $favoritesView = $request->get('favoritesView');
        $folderSlug = $request->get('folderSlug');

        $project->load([
            'userReactions' => function ($query) use ($folderSlug) {
                $query->where('has_like', true);
                if ($folderSlug) {
                    $query->where('client_name', 'like', '%'.$folderSlug.'%');
                }
            }
        ]);

        if ($favoritesView === 'table') {
            return view('projects.favorites-table', compact('project'));
        }

        $clientNames = $project->userReactions()->where('has_like', true)->pluck('client_name')->unique();

        return view('projects.favorites-grid', compact('project', 'clientNames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project, BucketService $bucketService)
    {
        $validatedRequest = $request->validated();
        $userDirectory = $this->getUserFolderName($project);
        $bucketName = $this->mainStorage;
        $userEmail = Auth::user()->email;
        $files = $request->file('files');

        $metaData = [
            'projectName' => $validatedRequest['name'],
            'projectSlug' => $project->slug,
            'userEmail' => $userEmail,
        ];

        if ($files) {
            foreach ($files as $file) {
                $objectName = $file->getClientOriginalPath();
                $objectPath = $file->getPathname();
                $content = file_get_contents($objectPath);
                $bucketService->putObject($bucketName, $userDirectory.'/'.$project->project_folder.'/'.$objectName,
                    $content,
                    $metaData);
            }
        }

        $validatedRequest['date'] = (DateTime::createFromFormat('m/d/Y',
            $validatedRequest['date']))->format('Y-m-d');

        $validatedRequest['expiration_date'] = (DateTime::createFromFormat('m/d/Y',
            $validatedRequest['expiration_date']))->format('Y-m-d');

        $project->update($validatedRequest);

        return redirect()->route('projects.basic-setting', $project->id)->with('success',
            'Project updated successfully');
    }

    public function uploadImages(Request $request, Project $project, BucketService $bucketService)
    {
        $folderSlug = $request->get('folderSlug');
        $userDirectory = $this->getUserFolderName($project);
        $bucketName = $this->mainStorage;
        $userEmail = Auth::user()->email;
        $files = $request->file('files');

        $metaData = [
            'projectName' => $project->name,
            'projectSlug' => $project->slug,
            'userEmail' => $userEmail,
        ];

        if ($files) {
            foreach ($files as $file) {
                try {
                    $objectName = $file->getClientOriginalPath();
                    $fullObjectName = $folderSlug ? $userDirectory.'/'.$project->project_folder.'/'.$folderSlug.'/'.$objectName : $userDirectory.'/'.$project->project_folder.'/'.$objectName;
                    $objectPath = $file->getPathname();
                    $content = file_get_contents($objectPath);
                    $bucketService->putObject($bucketName,
                        $fullObjectName,
                        $content,
                        $metaData);

                    $this->preparePreviewImage($file, $bucketService, $metaData, $fullObjectName);

                    $this->uploadLog($fullObjectName, $project->id, $file, 'success');

                } catch (\Exception $e) {
                    $this->uploadLog($fullObjectName, $project->id, $file, 'error', $e->getMessage());
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'images uploaded successfully',
            'project' => $project,
            'folderSlug' => $folderSlug
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully');
    }

    public function projectStatistic(Project $project)
    {
        $project->load([
            'userReactions' => function ($query) {
                $query->whereNull('review');
            }
        ]);

        return view('projects.projectStatistic', compact('project'));
    }

    public function deleteObject(Project $project, Request $request, BucketService $bucketService)
    {
        $bucketName = $project->bucket_name;
        $imageKey = $request->get('imageKey');
        $bucketService->deleteObject($bucketName, $imageKey);

        return response()->json([
            'success' => true,
            'message' => 'Object deleted successfully',
        ]);
    }

    public function setCoverImage(Project $project, Request $request)
    {
        $imageKey = $request->get('imageKey');
        $project->cover_image = $imageKey;
        $project->save();

        return response()->json([
            'success' => true,
            'message' => 'Cover image set successfully',
        ]);
    }

    public function clientGallery(
        User $user,
        Project $project,
        BucketService $bucketService,
        ProjectService $projectService
    ) {
        $projectFolder = $project->project_folder;
        $bucketName = $project->bucket_name;
        $userDirectory = $this->getUserFolderName($project);

        $sessionClientName = session('client_name');
        $projectId = $project->id;
        $userId = $user->id;

        $userReactions = UserReaction::where('user_id', $userId)
            ->where('project_id', $projectId)
            ->where('client_name', $sessionClientName)
            ->get();

        $projectObjects = $bucketService->listObjectsInFolder($bucketName, $userDirectory.'/'.$projectFolder);

        $projectObjects = array_filter($projectObjects, function ($object) {
            $array = explode('/', $object->key);
            return !empty(end($array));
        });

        foreach ($projectObjects as $object) {
            $key = $object->key;
            $imgUrl = $bucketService->getObjectUrl($bucketName, $key);
            $object->setObjectUrl($imgUrl);
            $object->setShareUrl($bucketService->genetateShareUrl($bucketName, $key));
//            $object->setBase64Image($bucketService->prepareResizedImage($bucketName, $key));

            foreach ($userReactions as $userReaction) {
                if ($object->key === $userReaction->object_key) {
                    $object->setUserLike($userReaction->has_like);
                    $object->setUserComment($userReaction->has_comment);
                    $object->setCommentMessage($userReaction->comment_message);
                }
            }
        }

        $project->increment('views_statistic');

        $this->setSizeAndCountOfObjects($projectObjects, $projectService, $project);

        if ($project->expiration_date < now()) {
            return view('projects.expired-client-gallery', compact('user', 'project'))->with('error',
                'Project has expired');
        }

        return view('projects.client-gallery', compact('user', 'project', 'projectObjects'));
    }

    public function saveUserLike(SaveUserLikeRequest $request, Project $project)
    {
        return response()->json([
            'success' => 'Like saved successfully', 'reactionData' => $this->saveUserReaction($request, $project),
        ]);
    }

    public function saveUserComment(SaveUserCommentRequest $request, Project $project)
    {
        return response()->json([
            'success' => 'Comment saved successfully', 'reactionData' => $this->saveUserReaction($request, $project)
        ]);
    }

    public function addReviewToProject(SaveProjectReviewRequest $request, Project $project)
    {
        $projectId = $project->id;
        $clientName = $request->clientName;
        $review = $request->get('review');
        $userId = $project->user_id;

        session(['client_name' => $clientName]);

        $reactionData = [
            'project_id' => $projectId,
            'client_name' => $clientName,
            'review' => $review,
            'user_id' => $userId,
            'object_key' => 'project_review',
            'object_url' => 'project_review',
        ];

        $review = UserReaction::updateOrCreate([
            'user_id' => $userId,
            'project_id' => $projectId,
            'client_name' => $clientName,
            'object_key' => 'project_review',
        ], $reactionData);

        return response()->json([
            'success' => 'Review saved successfully',
            'review' => $review
        ]);
    }

    public function getProjectReview(Project $project, Request $request)
    {
        $projectId = $project->id;
        $clientName = $request->clientName;
        $userId = $project->user_id;

        $projectReview = UserReaction::where('project_id', $projectId)
            ->where('client_name', $clientName)
            ->where('user_id', $userId)
            ->where('object_key', 'project_review')
            ->first();

        return response()->json([
            'success' => 'true',
            'projectReview' => $projectReview
        ]);
    }

    public function renewProject(Project $project)
    {
        $expirationDate = now()->addWeek();

        $project->expiration_date = $expirationDate;
        $project->save();

        return response()->json([
            'success' => 'Project renewed successfully',
            'project' => $project,
            'newExpirationDate' => $expirationDate
        ]);
    }


    private function saveUserReaction(
        SaveUserCommentRequest|SaveUserLikeRequest|SaveUserDownloadRequest $request,
        Project $project
    ) {
        $userId = $request->get('userId');
        $projectId = $project->id;
        $object = $request->get('object');
        $objectKey = $object['key'];
        $objectUrl = $object['objectUrl'];
        $clientName = isset($request->clientName) ? $request->clientName : 'Anonymous';
        $hasLike = $request->get('hasLike', false);
        $hasComment = $request->get('hasComment', false);
        $commentMessage = $request->get('comment', null);
        $commentDate = $hasComment ? now() : null;
        $likeDate = $hasLike ? now() : null;

        if ($request instanceof SaveUserCommentRequest) {
            session(['client_name' => $clientName]);
        }

        $reactionData = [
            'user_id' => $userId,
            'project_id' => $projectId,
            'object_key' => $objectKey,
            'object_url' => $objectUrl,
            'client_name' => $clientName,
        ];

        $userReaction = UserReaction::where('user_id', $userId)
            ->where('project_id', $projectId)
            ->where('object_key', $objectKey)
            ->where('client_name', $clientName)
            ->first();

        if ($request instanceof SaveUserLikeRequest) {
            $reactionData['has_like'] = $hasLike;
            $reactionData['like_date'] = $likeDate;
        } elseif ($request instanceof SaveUserCommentRequest) {
            $reactionData['has_comment'] = $hasComment;
            $reactionData['comment_message'] = $commentMessage;
            $reactionData['comment_date'] = $commentDate;
        } elseif ($request instanceof SaveUserDownloadRequest) {
            $reactionData['download_statistic'] = $userReaction ? ($userReaction->download_statistic ? $userReaction->download_statistic + 1 : 1) : 1;
        }

        return UserReaction::updateOrCreate([
            'user_id' => $userId,
            'project_id' => $projectId,
            'object_key' => $objectKey,
            'client_name' => $clientName,
        ], $reactionData);
    }

    /**
     * @param  array|null  $projectObjects
     * @param  ProjectService  $projectService
     * @param  Project  $project
     *
     * @return void
     */
    public function setSizeAndCountOfObjects(
        array|null $projectObjects,
        ProjectService $projectService,
        Project $project
    ): void {
        if ($projectObjects) {
            $objectsCount = count($projectObjects);
            $sizeOfProject = $projectService->sizeOfProject($projectObjects);
            $sizeOfProject = $projectService->formatProjectSize($sizeOfProject);
        } else {
            $objectsCount = 0;
            $sizeOfProject = 0;
        }

        foreach ($projectObjects as $object) {
            $keySegments = explode('/', $object->key);
            $objectName = end($keySegments);
            $object->setObjectName($objectName);
        }

        $project->setSizeOfProject($sizeOfProject);
        $project->setObjectsCount($objectsCount);
    }

    public function downloadFolder(BucketService $bucketService, Project $project)
    {
        $project->increment('download_statistic');

        $userDirectory = $this->getUserFolderName($project);

        return $bucketService->downloadFolder($project->bucket_name, $project->project_folder, $userDirectory);
    }

    public function downloadObjectUrlIncrement(SaveUserDownloadRequest $request, Project $project)
    {
        return response()->json([
            'success' => 'Download stat saved successfully',
            'reactionData' => $this->saveUserReaction($request, $project)
        ]);
    }

    public function storeFolder(StoreFolderRequest $request, Project $project, BucketService $bucketService)
    {
        $files = $request->file('files');
        $userEmail = Auth::user()->email;

        $userDirectory = $this->getUserFolderName($project);

        $bucketName = $this->mainStorage;
        $validatedRequest = $request->validated();
        $projectFolderName = $project->project_folder;

        $folderName = Str::slug($validatedRequest['name']);

        $metaData = [
            'folderName' => $validatedRequest['name'],
            'projectName' => $project->name,
            'userEmail' => $userEmail,
        ];

        $folderPath = $userDirectory.'/'.$projectFolderName.'/'.$folderName;

        $bucketService->createFolder($bucketName, $folderPath, $metaData);

        if ($files) {
            foreach ($files as $file) {
                try {
                    $objectName = $file->getClientOriginalPath();
                    $fullObjectName = $folderPath.'/'.$objectName;
                    $objectPath = $file->getPathname();
                    $content = file_get_contents($objectPath);
                    $bucketService->putObject($bucketName, $fullObjectName, $content, $metaData);

                    $this->preparePreviewImage($file, $bucketService, $metaData, $fullObjectName);

                    $this->uploadLog($fullObjectName, $project->id, $file, 'success');

                } catch (\Exception $e) {
                    $this->uploadLog($fullObjectName, $project->id, $file, 'error', $e->getMessage());
                }
            }
        }

        return redirect()->route('projects.edit', $project->id)->with('success', 'Folder created successfully');
    }

    public function exportFavoriteItems(Project $project)
    {
        $project->load([
            'userReactions' => function ($query) {
                $query->whereNull('review');
            }
        ]);

        $columns = ['ID', 'Project Name', 'File', 'Client Name', 'Comment', 'Review', 'Event Date'];

        return $this->generateCsv("export_faforites_$project->id.csv", $project, $columns);
    }

    public function exportConsolidatedFavoriteItems(Project $project)
    {
        $project->load('userReactions');
        $columns = ['ID', 'Project Name', 'File/ObjectName', 'Client Name', 'Comment', 'Review', 'Event Date'];

        return $this->generateCsv("export_consolidated_faforites_$project->id.csv", $project, $columns);
    }


    // TODO move private methods to service
    private function generateCsv($fileName, $data, $columns)
    {
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($data, $columns) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, $columns);

            $userReactions = $data->userReactions;

            foreach ($userReactions as $item) {
                fputcsv($handle, [
                    $item->project_id,
                    $item->project->name,
                    $item->object_key,
                    $item->client_name,
                    $item->comment_message,
                    $item->review,
                    $item->project->date,
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }

    private function getUserFolderName(Project $project): string
    {
        $user_id = $project->user_id;
        $user = User::find($user_id);
        $userEmail = $user->email;
        $userName = explode('@', $userEmail)[0];
        $emailDomain = explode('@', $userEmail)[1];
        return $userName.'.'.$emailDomain;
    }

    private function uploadLog($objectName, $projectId, File $file, $status, $errorMessage = null)
    {
        UploadLog::create([
            'user_id' => Auth::id(),
            'project_id' => $projectId,
            'original_path' => $objectName,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'status' => $status,
            'error_message' => $errorMessage,
        ]);
    }

    private function preparePreviewImage($file, BucketService $bucketService, $metaData, $fullObjectName): void
    {
        try {
            $previewBucketName = $this->previewStorage;

            $imageManager = ImageManager::imagick();
            $image = $imageManager->read($file);
            $extension = strtolower($file->getClientOriginalExtension());

            if (in_array($extension, ['jpg', 'jpeg'])) {
                $encodedImage = $image->encode(new JpegEncoder(quality: 30));
            } elseif ($extension === 'png') {
                $encodedImage = $image->encode(new PngEncoder());
            } elseif ($extension === 'webp') {
                $encodedImage = $image->encode(new WebpEncoder(quality: 80));
            } else {
                $encodedImage = $image->encode();
            }

            if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                $bucketService->putObject($previewBucketName,
                    $fullObjectName,
                    (string) $encodedImage,
                    $metaData);
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
