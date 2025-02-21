<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UploadLog extends Model
{
    protected $table = 'upload_images_logs';

    protected $fillable = [
        'user_id',
        'project_id',
        'original_path',
        'preview_path',
        'size',
        'preview_size',
        'mime_type',
        'status',
        'error_message',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
