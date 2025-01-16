<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUserCommentRequest;
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
    /**
     * Display a listing of the resource.
     */
    public function index(BucketService $bucketService, ProjectService $projectService)
    {
        $projects = Project::with('user')->with('userReaction')->paginate(10);

        foreach ($projects as $project) {
            $bucketName = $project->bucket_name;

//            $bucketService->putPublicAccessBlock($bucketName);
//            $bucketService->putPublicBucketPolicy($bucketName);
//            $bucketService->createBucketIfNotExist($bucketName);

            $projectFolder = $project->project_folder;

            $projectObjects = $bucketService->listObjectsInFolder($bucketName, $projectFolder);

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
        $bucketService->createBucketIfNotExist($userName);
        $bucketName = $userName;
        $projectFolder = explode('/', reset($files)->getClientOriginalPath())[0];
        $validatedRequest = $request->validated();
        $projectSlug = Str::slug($validatedRequest['name']);

        $metaData = [
            'projectName' => $validatedRequest['name'],
            'projectSlug' => $projectSlug,
            'userEmail' => $userEmail,
        ];

        foreach ($files as $file) {
            if ($file->getClientOriginalName() === '.DS_Store') {
                continue;
            }

            $objectName = $file->getClientOriginalPath();
            $objectPath = $file->getPathname();
            $content = file_get_contents($objectPath);
            $bucketService->putObject($bucketName, $objectName, $content, $metaData);
        }

        $validatedRequest['slug'] = $projectSlug;
        $validatedRequest['bucket_name'] = $bucketName;
        $validatedRequest['project_folder'] = $projectFolder;
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
        $bucketName = $project->bucket_name;
        $projectFolder = $project->project_folder;
        $childKeyParam = $request->get('childKey');
        $keySegmentsFromUrl = explode('/', $childKeyParam);
        $childKeyParam = $childKeyParam ? '/'.$childKeyParam : '';
        $countOfChildKeysInUrl = $childKeyParam ? count($keySegmentsFromUrl) - 1 : null;
        $projectFolderObjects = $bucketService->listObjectsInFolder($bucketName, $projectFolder.$childKeyParam);

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

            if ((count($keySegments)) > 2 + $countOfChildKeysInUrl) {
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
        $bucketName = $project->bucket_name;
        $projectDirectory = $project->project_folder;
        $projectObjects = $bucketService->listObjectsInFolder($bucketName, $projectDirectory);

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
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validatedRequest = $request->validated();

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
    public function destroy(string $id)
    {
        //
    }

    public function clientGallery(
        User $user,
        Project $project,
        BucketService $bucketService,
        ProjectService $projectService
    ) {
        $projectFolder = $project->project_folder;
        $bucketName = $project->bucket_name;

        $projectObjects = $bucketService->listObjectsInFolder($bucketName, $projectFolder);

        foreach ($projectObjects as $object) {
            $key = $object->key;
            $imgUrl = $bucketService->getObjectUrl($bucketName, $key);
            $object->setObjectUrl($imgUrl);
        }

        $project->increment('views_statistic');

        $this->setSizeAndCountOfObjects($projectObjects, $projectService, $project);

        if($project->expiration_date < now()) {
            return view('projects.expired-client-gallery', compact('user', 'project'))->with('error', 'Project has expired');
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

    private function saveUserReaction(SaveUserCommentRequest|SaveUserLikeRequest $request, Project $project)
    {
        $userId = $request->get('userId');
        $projectId = $project->id;
        $object = $request->get('object');
        $objectKey = $object['key'];
        $objectUrl = $object['objectUrl'];
        $clientName = $request->get('clientName', 'Anonymous');
        $hasLike = $request->get('hasLike', false);
        $hasComment = $request->get('hasComment', false);
        $commentMessage = $request->get('commentMessage', null);
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
            'comment_message' => $commentMessage,
        ];

        if ($request instanceof SaveUserLikeRequest) {
            $reactionData['has_like'] = $hasLike;
            $reactionData['like_date'] = $likeDate;
        } else {
            $reactionData['has_comment'] = $hasComment;
            $reactionData['comment_message'] = $commentMessage;
            $reactionData['comment_date'] = $commentDate;
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

        return $bucketService->downloadFolder($project->bucket_name, $project->project_folder);
    }
}
