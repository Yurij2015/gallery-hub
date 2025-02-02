<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUserCommentRequest;
use App\Http\Requests\SaveUserDownloadRequest;
use App\Http\Requests\SaveUserLikeRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Services\BucketService;
use App\Http\Services\ProjectService;
use App\Models\Project;
use App\Models\User;
use App\Models\UserReaction;
use Auth;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public string $mainStorage;

    public function __construct()
    {
        $this->mainStorage = config('services.minio.main_storage');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(BucketService $bucketService, ProjectService $projectService)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $projects = Project::with('user')->with('userReactions')->paginate(10);
        } else {
            $projects = Project::with('user')->with('userReactions')->where('user_id', $user->id)->paginate(10);
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
            $project->setProjecImage($imgUrl);
        }

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
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
        $projectFolderName = $projectSlug;

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

        $validatedRequest['slug'] = $projectSlug;
        $validatedRequest['bucket_name'] = $bucketName;
        $validatedRequest['project_folder'] = $projectFolderName;
        $validatedRequest['date'] = (DateTime::createFromFormat('d/m/Y',
            $validatedRequest['date']))->format('Y-m-d');
        $validatedRequest['expiration_date'] = (DateTime::createFromFormat('d/m/Y',
            $validatedRequest['expiration_date']))->format('Y-m-d');
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
        $childKeyParam = $childKeyParam ?  '/'.$childKeyParam : '';
        $countOfChildKeysInUrl = $childKeyParam ? count($keySegmentsFromUrl) - 1 : null;

        if(!$childKeyParam) {
            $projectFolderObjects = $bucketService->listObjectsInFolder($bucketName, $userDirectory . '/' . $projectFolder);
        }
        else {
            $projectFolderObjects = $bucketService->listObjectsInFolder($bucketName, $userDirectory . $childKeyParam);
        }

        if(!$projectFolderObjects) {
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

            if ((count($keySegments)) > 3+ $countOfChildKeysInUrl) {
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
    public function edit(Project $project, BucketService $bucketService)
    {
        if (!$project->project_folder) {
            return view('projects.edit', compact('project'));
        }
        $bucketName = $project->bucket_name;
        $projectDirectory = $project->project_folder;
        $userDirectory = $this->getUserFolderName($project);
        $projectObjects = $bucketService->listObjectsInFolder($bucketName, $userDirectory . '/' . $projectDirectory);

        if(!$projectObjects) {
            return view('projects.edit', compact('project'));
        }

        foreach ($projectObjects as $object) {
            $key = $object->key;
            $imgUrl = $bucketService->getObjectUrl($bucketName, $key);
            $object->setObjectUrl($imgUrl);
        }

        return view('projects.edit', compact('project', 'projectObjects'));
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
                $bucketService->putObject($bucketName, $userDirectory.'/'.$project->project_folder.'/'.$objectName, $content,
                    $metaData);
            }
        }

        $validatedRequest['date'] = (DateTime::createFromFormat('d/m/Y',
            $validatedRequest['date']))->format('Y-m-d');
        $validatedRequest['expiration_date'] = (DateTime::createFromFormat('d/m/Y',
            $validatedRequest['expiration_date']))->format('Y-m-d');

        $project->update($validatedRequest);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully');
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
        $project->load('userReactions');
        return view('projects.projectStatistic', compact('project'));
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

        $projectObjects = $bucketService->listObjectsInFolder($bucketName, $userDirectory . '/' . $projectFolder);

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

    private function saveUserReaction(
        SaveUserCommentRequest|SaveUserLikeRequest|SaveUserDownloadRequest $request,
        Project $project
    ) {
        $userId = $request->get('userId');
        $projectId = $project->id;
        $object = $request->get('object');
        $objectKey = $object['key'];
        $objectUrl = $object['objectUrl'];
        $clientName = $request->get('clientName', 'Anonymous');
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

    private function getUserFolderName(Project $project): string
    {
        $user_id = $project->user_id;
        $user = User::find($user_id);
        $userEmail = $user->email;
        $userName = explode('@', $userEmail)[0];
        $emailDomain = explode('@', $userEmail)[1];
        return $userName.'.'.$emailDomain;
    }
}
