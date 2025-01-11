<?php

namespace App\Http\Controllers;

use App\Http\Services\BucketService;

class BucketController extends Controller
{
    public function index(BucketService $bucketService)
    {
        $listBuckets = $bucketService->listBuckets();

        // TODO Add form to set main image for bucket
        foreach ($listBuckets as $bucket) {
            $firstObject = $bucketService->listObjects($bucket->name)[0];
            $key = $firstObject->key;
            $imgUrl = $bucketService->getObjectUrl($bucket->name, $key);
            $firstObject->setObjectUrl($imgUrl);
            $bucket->firstObjectImageUrl = $imgUrl;
        }

        return view('buckets.index', compact('listBuckets'));
    }
}
