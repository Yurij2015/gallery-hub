<?php

namespace App\Http\Services;

class ProjectService
{
    public function sizeOfProject(array $files): int
    {

        $size = 0;
        foreach ($files as $file) {
            $size += $file->size;
        }
        return $size;
    }

    function formatProjectSize($bytes, $precision = 2): string
    {
        $units = ['Bytes', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $value = $bytes / (1024 ** $pow);

        return round($value, $precision).' '.$units[$pow];
    }
}
