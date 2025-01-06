<?php

namespace App\Http\Controllers;

use App\Http\Services\BucketService;

class BucketController extends Controller
{
    public function index(BucketService $bucketService)
    {
        $listBuckets = $bucketService->listBuckets();

        return view('buckets.index', compact('listBuckets'));
    }
}
