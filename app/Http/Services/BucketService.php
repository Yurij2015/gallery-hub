<?php

namespace App\Http\Services;

use App\Models\Bucket;
use App\Models\BucketObjects;
use App\Models\Buckets;
use Aws\Credentials\CredentialProvider;
use Aws\Result;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;


class BucketService
{

    public S3Client $s3Client;

    public function __construct()
    {
        $credentials = CredentialProvider::env();
        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region' => config("services.aws.region"),
            'credentials' => $credentials,
            'endpoint' => config("services.aws.endpoint"),
            'debug' => false,
            'use_path_style_endpoint' => true
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

    public function listObjects($bucketName): ?array
    {
        try {
            $listObjects = $this->s3Client->listObjects([
                'Bucket' => $bucketName
            ]);

            $listObjects = new BucketObjects($listObjects);
            $listObjects = $listObjects->getContents();

        } catch (S3Exception $e) {
            Log::info('S3 Exception:', [
                'message' => $e->getMessage()
            ]);
        }

        return $listObjects ?? null;
    }

    public function listObjectsInFolder($bucketName, $prefix): ?array
    {
        try {
            $listObjects = $this->s3Client->listObjects([
                'Bucket' => $bucketName,
                'Prefix' => $prefix
            ]);

            $listObjects = new BucketObjects($listObjects);
            $listObjects = $listObjects->getContents();

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

    public function putObject($bucketName, $objectName, $content, $metaData): ?Result
    {
        try {
            $object = $this->s3Client->putObject([
                'Bucket' => $bucketName,
                'Key' => $objectName,
                'Body' => $content,
                'Metadata' => $metaData
            ]);
        } catch (S3Exception $e) {
            Log::info('S3 Exception:', [
                'message' => $e->getMessage()
            ]);
        }

        return $object ?? null;
    }

    public function createFolder($bucketName, $folderName, $metaData): ?Result
    {
        try {
            $folder = $this->s3Client->putObject([
                'Bucket' => $bucketName,
                'Key' => rtrim($folderName, '/') . '/',
                'Body' => '',
                'Metadata' => $metaData
            ]);
            Log::info("Minio Folder created: {$folderName}");
        } catch (S3Exception $e) {
            Log::info('S3 Exception:', [
                'message' => $e->getMessage()
            ]);
        }

        return $folder ?? null;
    }

    public function getFoldersList($bucketName, $folderName): array
    {
        try {
            $folderName = rtrim($folderName, '/').'/';

            $result = $this->s3Client->listObjectsV2([
                'Bucket' => $bucketName,
                'Prefix' => $folderName,
                'Delimiter' => '/',
            ]);

            $folders = [];
            if (isset($result['CommonPrefixes'])) {
                foreach ($result['CommonPrefixes'] as $prefix) {
                    $folders[] = $prefix['Prefix'];
                }
            }

            Log::info('MinIO Folders:', $folders);
            return $folders;

        } catch (S3Exception $e) {
            Log::error('MinIO Exception:', ['message' => $e->getMessage()]);
            return [];
        }
    }

    public function checkBucketExist($bucketName): bool
    {
        $buckets = $this->listBuckets();

        if (!$buckets) {
            return false;
        }

        $bucketNames = array_map(function (Bucket $bucket) {
            return $bucket->name;
        }, $buckets);

        return in_array($bucketName, $bucketNames);
    }

    // TODO Add method to check and create bucket for user if it does not exist (check user package before creating bucket)
    public function createBucketIfNotExist($bucketName): ?Result
    {
        if (!$this->checkBucketExist($bucketName)) {
            return $this->createBucket($bucketName);
        }

        return null;
    }

    public function putPublicBucketPolicy($bucketName): ?Result
    {
        $bucketPolicy = [
            'Version' => '2012-10-17',
            'Statement' => [
                [
                    'Effect' => 'Allow',
                    'Principal' => '*',
                    'Action' => [
                        's3:GetObject',
                        's3:List*'
                    ],
                    'Resource' => [
                        'arn:aws:s3:::'.$bucketName,
                        'arn:aws:s3:::'.$bucketName.'/*'
                    ]
                ]
            ]
        ];

        try {
            $result = $this->s3Client->putBucketPolicy([
                'Bucket' => $bucketName,
                'Policy' => json_encode($bucketPolicy)
            ]);
        } catch (S3Exception $e) {
            Log::info('S3 Exception:', [
                'message' => $e->getMessage()
            ]);
        }

        return $result ?? null;
    }

    public function putPrivateBucketPolicy($bucketName): ?Result
    {
        $bucketPolicy = [
            'Version' => '2012-10-17',
            'Statement' => [
                [
                    'Effect' => 'Deny',
                    'Principal' => '*',
                    'Action' => [
                        's3:GetObject',
                        's3:List*'
                    ],
                    'Resource' => [
                        'arn:aws:s3:::'.$bucketName,
                        'arn:aws:s3:::'.$bucketName.'/*'
                    ]
                ]
            ]
        ];

        try {
            $result = $this->s3Client->putBucketPolicy([
                'Bucket' => $bucketName,
                'Policy' => json_encode($bucketPolicy)
            ]);
        } catch (S3Exception $e) {
            Log::info('S3 Exception:', [
                'message' => $e->getMessage()
            ]);
        }

        return $result ?? null;
    }

    public function putPublicAccessBlock($bucketName): ?Result
    {
        try {
            $result = $this->s3Client->putPublicAccessBlock([
                'Bucket' => $bucketName,
                'PublicAccessBlockConfiguration' => [
                    'BlockPublicAcls' => true,
                    'IgnorePublicAcls' => true,
                    'BlockPublicPolicy' => false,
                    'RestrictPublicBuckets' => true,
                ],
            ]);;
        } catch (S3Exception $e) {
            Log::info('S3 Exception:', [
                'message' => $e->getMessage()
            ]);
        }

        return $result ?? null;
    }

    public function getObjectUrl($bucketName, $key): string
    {
        return $this->s3Client->getObjectUrl($bucketName, $key);
    }

    public function downloadFolder($bucketName, $folderName, $userDirectory)
    {
        try {
            $localDir = storage_path('/app/public/'.$bucketName.'/'. $userDirectory . '/' .$folderName);

            if (!file_exists($localDir)) {
                mkdir($localDir, 0777, true);
            }

            $objects = $this->s3Client->listObjectsV2([
                'Bucket' => $bucketName,
                'Prefix' => $userDirectory.'/'.$folderName.'/'
            ]);

            foreach ($objects['Contents'] as $object) {
                $fileKey = $object['Key'];
                $filePath = $localDir.'/'.str_replace($folderName, '', $fileKey);
                // Ensure local subdirectory exists
                $dir = dirname($filePath);
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                // Download each file
                $result = $this->s3Client->getObject([
                    'Bucket' => $bucketName,
                    'Key' => $fileKey,
                ]);

                file_put_contents($filePath, $result['Body']);
            }

            $zip = new ZipArchive();
            $zipFileName = storage_path('/app/public/'.$bucketName.'/'.$folderName.'.zip');

            if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($localDir),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($localDir) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }

                $zip->close();

                // TODO add downloading to statistics
                return response()->download($zipFileName)->deleteFileAfterSend(true);
            }
        } catch (S3Exception $e) {
            Log::info('S3 Exception:', [
                'message' => $e->getMessage()
            ]);
        }
    }

    public function genetateShareUrl($bucketName, $key): string
    {
        $cmd = $this->s3Client->getCommand('GetObject', [
            'Bucket' => $bucketName,
            'Key' => $key,
        ]);

        $expires = 3600;
        $request = $this->s3Client->createPresignedRequest($cmd, "+{$expires} seconds");

        return (string) $request->getUri();
    }

    public function prepareResizedImage($bucketName, $key): string
    {
        $objectUrl = $this->s3Client->getObjectUrl($bucketName, $key);
        $file = file_get_contents($objectUrl);
        $manager = new ImageManager(new Driver());
        $resizedImage = $manager->read($file)->scale(300);

        return $resizedImage->toJpeg()->toDataUri();
    }

    public function deleteObject($bucketName, $key): ?Result
    {
        try {
            $result = $this->s3Client->deleteObject([
                'Bucket' => $bucketName,
                'Key' => $key
            ]);
        } catch (S3Exception $e) {
            Log::info('S3 Exception:', [
                'message' => $e->getMessage()
            ]);
        }

        return $result ?? null;
    }
}
