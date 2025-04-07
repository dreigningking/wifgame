<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SavedCalculation extends Model
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'name',
        'description',
        'is_favorite',
        'input_data',
        'result_data'
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
        'input_data' => 'array',
        'result_data' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class);
    }

    public function calculation(): MorphTo
    {
        return $this->morphTo();
    }
} 