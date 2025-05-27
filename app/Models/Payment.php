<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'email',
        'type',
        'amount',
        'currency',
        'payment_gateway',
        'payment_method',
        'payment_method_details',
        'reference',
        'provider_reference',
        'status',
        'error_message',
        'metadata',
        'refunded_amount',
        'refunded_at',
        'processed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'refunded_amount' => 'decimal:2',
        'metadata' => 'array',
        'refunded_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Status helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }

    public function isRefunded()
    {
        return $this->status === 'refunded';
    }

    // Calculate refundable amount
    public function getRefundableAmount()
    {
        return $this->amount - $this->refunded_amount;
    }

    // Check if payment is refundable
    public function isRefundable()
    {
        return $this->isCompleted() && $this->getRefundableAmount() > 0;
    }
}
