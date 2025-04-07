<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculatorCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description'
    ];

    public function calculators(): HasMany
    {
        return $this->hasMany(Calculator::class, 'category_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(CalculatorCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(CalculatorCategory::class, 'parent_id');
    }
} 