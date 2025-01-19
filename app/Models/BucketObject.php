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

    public ?string $objectName = null;

    public ?string $shareUrl = null;

    public ?string $base64Image = null;

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

    public function getShareUrl(): ?string
    {
        return $this->shareUrl;
    }

    public function setShareUrl($shareUrl): void
    {
        $this->shareUrl = $shareUrl;
    }

    public function getBase64Image(): ?string
    {
        return $this->base64Image;
    }

    public function setBase64Image($base64Image): void
    {
        $this->base64Image = $base64Image;
    }
}
