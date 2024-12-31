<?php

namespace App\Http\Controllers;

use App\Http\Services\BucketService;

class BucketsController extends Controller
{
    public function index(BucketService $bucketService)
    {
        $listBuckets = $bucketService->listBuckets();

        return view('buckets.index', compact('listBuckets'));
    }
}
