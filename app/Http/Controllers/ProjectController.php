<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Services\BucketService;
use App\Http\Services\ProjectService;
use App\Models\Project;
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
        $projects = Project::paginate(10);

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

            if ($projectObjects) {
                $objectsCount = count($projectObjects);
                $sizeOfProject = $projectService->sizeOfProject($projectObjects);
                $sizeOfProject = $projectService->formatProjectSize($sizeOfProject);
            } else {
                $objectsCount = 0;
                $sizeOfProject = 0;
            }

            $project->setSizeOfProject($sizeOfProject);
            $project->setObjectsCount($objectsCount);
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
        $validatedRequest['date'] = (DateTime::createFromFormat('d/m/Y', $validatedRequest['date']))->format('Y-m-d');
        $validatedRequest['expiration_date'] = (DateTime::createFromFormat('d/m/Y',
            $validatedRequest['expiration_date']))->format('Y-m-d');
        Project::create($validatedRequest);

        return redirect()->route('projects.index')->with('success', 'Project created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project, BucketService $bucketService, Request $request, ProjectService $projectService)
    {
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

        return view('projects.show', compact('project', 'projectFolderObjects', 'filteredObjects', 'childKeys', 'countOfChildKeysInUrl'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
