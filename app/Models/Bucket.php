<?php

namespace App\Models;

use Illuminate\Support\Carbon;

class Bucket
{
    public string $name;
    public string $creationDate;

    public function __construct($data)
    {
        $this->name = $data['Name'];
        $this->creationDate = Carbon::parse($data['CreationDate'])->diffForHumans();
    }
}
