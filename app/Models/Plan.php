<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'billing_period',
        'features',
        'is_active'
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function calculators(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class)
            ->withPivot('monthly_limit', 'additional_features')
            ->withTimestamps();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function hasCalculatorAccess(Calculator $calculator): bool
    {
        return $this->calculators()
            ->where('calculator_id', $calculator->id)
            ->exists();
    }

    public function getCalculatorLimit(Calculator $calculator): ?int
    {
        $pivot = $this->calculators()
            ->where('calculator_id', $calculator->id)
            ->first()?->pivot;

        return $pivot ? $pivot->monthly_limit : null;
    }

    public function getCalculatorFeatures(Calculator $calculator): array
    {
        $pivot = $this->calculators()
            ->where('calculator_id', $calculator->id)
            ->first()?->pivot;

        return $pivot ? 
            (json_decode($pivot->additional_features, true) ?? []) : 
            [];
    }
} 