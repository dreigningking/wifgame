<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Calculator extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'status',
        'config'
    ];

    protected $casts = [
        'config' => 'array',
        'status' => 'string'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(CalculatorCategory::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(CalculationHistory::class);
    }

    public function savedCalculations(): HasMany
    {
        return $this->hasMany(SavedCalculation::class);
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class)
            ->withPivot('monthly_limit', 'additional_features')
            ->withTimestamps();
    }

    public function getModelClass(): string
    {
        return "App\\Models\\Calculations\\{$this->slug}Calculation";
    }

    public function isFreeToUse(): bool
    {
        return $this->status === 'active' && !$this->plans()->exists();
    }

    public function isPremium(): bool
    {
        return $this->plans()->exists();
    }
} 