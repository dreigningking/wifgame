<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

abstract class BaseCalculation extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class);
    }

    public function histories(): MorphMany
    {
        return $this->morphMany(CalculationHistory::class, 'calculation');
    }

    public function savedCalculations(): MorphMany
    {
        return $this->morphMany(SavedCalculation::class, 'calculation');
    }

    // Method that each calculator must implement
    abstract public function calculate(): array;
} 