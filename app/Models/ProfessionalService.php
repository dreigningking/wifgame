<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfessionalService extends Model
{
    protected $fillable = [
        'professional_id',
        'calculator_type',
        'service_description',
        'service_rate',
        'is_active'
    ];

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }
} 