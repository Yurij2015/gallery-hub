<?php

namespace App\Models;

use Illuminate\Support\Carbon;

class BucketObject
{

    public string $key;
    public string $lastModified;
    public string $eTag;
    public ?array $checksumAlgorithm;
    public string $size;
    public string $storageClass;
    public array $owner;
    public ?string $objectUrl;

    public ?string $objectName;

    public function __construct(array $data)
    {
        $this->key = $data['Key'];
        $this->lastModified = Carbon::parse($data['LastModified'])->diffForHumans();
        $this->eTag = $data['ETag'];
        $this->checksumAlgorithm = $data['ChecksumAlgorithm'] ?? null;
        $this->size = $data['Size'];
        $this->storageClass = $data['StorageClass'];
        $this->owner = $data['Owner'];
    }

    public function getObjectUrl(): ?string
    {
        return $this->objectUrl;
    }

    public function setObjectUrl($objectUrl): void
    {
        $this->objectUrl = $objectUrl;
    }

    public function getObjectName(): ?string
    {
        return $this->objectName;
    }

    public function setObjectName($objectName): void
    {
        $this->objectName = $objectName;
    }
}
