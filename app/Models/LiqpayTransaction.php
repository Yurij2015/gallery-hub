<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiqpayTransaction extends Model
{
    protected $fillable = ['payment_id', 'transaction_id', 'response_data'];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
