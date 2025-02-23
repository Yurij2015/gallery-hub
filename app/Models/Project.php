<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'slug',
        'bucket_name',
        'project_folder',
        'date',
        'expiration_date',
        'cover_image',
        'views_statistic',
        'download_statistic',
        'user_reactions',
        'project_statistic',
        'project_link',
        'status',
        'allow_feedback',
        'user_id',
        'objects_count',
        'project_size',
    ];

    public ?int $objectsCount = null;
    public ?string $sizeOfProject = null;
    public ?string $sizeOfProjectFolder = null;
    public ?string $projectImage = null;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userReactions(): HasMany
    {
        return $this->hasMany(UserReaction::class);
    }
}
