<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultation extends Model
{
    protected $fillable = [
        'professional_id',
        'user_id',
        'guest_email',
        'guest_name',
        'message',
        'status',
        'professional_response',
        'scheduled_at'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime'
    ];

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 