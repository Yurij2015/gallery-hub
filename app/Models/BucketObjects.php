<?php

namespace App\Models;

use Aws\Result;

class BucketObjects
{

    public ?array $contents;

    public function __construct(Result $data)
    {
        if (!array_key_exists('Contents', $data->toArray())) {
            $this->contents = null;
            return;
        }

        foreach ($data->get('Contents') as $content) {
            $this->contents[] = new BucketObject($content);
        }
    }

    public function getContents(): ?array
    {
        return $this->contents;
    }
}
