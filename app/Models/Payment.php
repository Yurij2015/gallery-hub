<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    protected $fillable = ['user_id', 'subscription_id', 'amount', 'status', 'liqpay_order_id', 'payment_date'];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function liqpayTransactions(): HasMany
    {
        return $this->hasMany(LiqpayTransaction::class);
    }
}
