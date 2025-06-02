<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculatorUsageStat extends Model
{
    protected $fillable = [
        'calculator_id',
        'date',
        'usage_count'
    ];

    protected $casts = [
        'date' => 'date',
        'usage_count' => 'integer'
    ];

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class);
    }
} 