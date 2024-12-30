<?php

namespace App\Http\Services;

use App\Models\Buckets;
use Aws\Credentials\CredentialProvider;
use Aws\Result;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Log;

class BucketService
{

    public S3Client $s3Client;

    public function __construct()
    {
        $credentials = CredentialProvider::env();
        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region' => 'eu-central-1',
            'credentials' => $credentials
        ]);
    }

    public function listBuckets(): ?array
    {
        try {
            $listBuckets = $this->s3Client->listBuckets();
            $listBuckets = new Buckets($listBuckets);
            $listBuckets = $listBuckets->getBuckets();

        } catch (S3Exception $e) {
            Log::info('S3 Exception:', [
                'message' => $e->getMessage()
            ]);
        }


        return $listBuckets ?? null;
    }

    public function listObjects($bucketName): ?Result
    {
        try {
            $listObjects = $this->s3Client->listObjects([
                'Bucket' => $bucketName
            ]);

        } catch (S3Exception $e) {
            Log::info('S3 Exception:', [
                'message' => $e->getMessage()
            ]);
        }

        return $listObjects ?? null;
    }

    public function createBucket($bucketName): ?Result
    {
        try {
            $bucket = $this->s3Client->createBucket([
                'Bucket' => $bucketName
            ]);
        } catch (S3Exception $e) {
            Log::info('S3 Exception:', [
                'message' => $e->getMessage()
            ]);
        }

        return $bucket ?? null;
    }
}
