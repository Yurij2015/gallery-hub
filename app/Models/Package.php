<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = ['name', 'price', 'description', 'status', 'duration', 'metadata'];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
