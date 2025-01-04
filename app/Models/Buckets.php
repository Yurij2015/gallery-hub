<?php

namespace App\Models;

use Aws\Result;
class Buckets
{
    public ?array $buckets = null;

    public function __construct(Result $data)
    {
        foreach ($data->get('Buckets') as $bucket) {
            $this->buckets[] = new Bucket($bucket);
        }
    }

    public function getBuckets(): ?array
    {
        return $this->buckets;
    }
}
