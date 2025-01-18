<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReaction extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'object_key',
        'object_url',
        'client_name',
        'has_like',
        'has_comment',
        'comment_message',
        'comment_date',
        'like_date',
        'download_statistic',
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
