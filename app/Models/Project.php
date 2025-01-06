<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'slug',
        'bucket_name',
        'project_folder',
        'date',
        'expiration_date',
        'views_statistic',
        'download_statistic',
        'user_reactions',
        'project_statistic',
        'project_link',
        'status'
    ];

    public int $objectsCount;
    public string $sizeOfProject;
    public string $sizeOfProjectFolder;
    public string $projectImage;

    public function setObjectsCount($count): void
    {
        $this->objectsCount = $count;
    }

    public function getObjectsCount()
    {
        return $this->objectsCount;
    }

    public function setSizeOfProject($size): void
    {
        $this->sizeOfProject = $size;
    }

    public function getSizeOfProject()
    {
        return $this->sizeOfProject;
    }

    public function setProjecImage($imageUrl): void
    {
        $this->projectImage = $imageUrl;
    }

    public function getProjectImage()
    {
        return $this->projectImage;
    }

    public function setSizeOfProjectFolder($size): void
    {
        $this->sizeOfProjectFolder = $size;
    }

    public function getSizeOfProjectFolder()
    {
        return $this->sizeOfProjectFolder;
    }
}
