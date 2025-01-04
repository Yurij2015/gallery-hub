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

            if($projectObjects){
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

//        dd($projects);

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
    public function show(string $id)
    {
        //
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
