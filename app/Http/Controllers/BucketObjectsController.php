<?php

namespace App\Http\Controllers;

use App\Http\Services\BucketService;

class BucketObjectsController extends Controller
{
    public function index(string $bucketName, BucketService $bucketService)
    {
        $bucketObjects = $bucketService->listObjects($bucketName);

        return view('bucket-objects.index', compact('bucketObjects', 'bucketName'));
    }
}
