<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Professional extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'bio',
        'specialization',
        'experience_years',
        'qualification',
        'profile_image',
        'hourly_rate',
        'currency',
        'is_available',
        'rating',
        'total_consultations'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(ProfessionalService::class);
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image ? asset('storage/' . $this->profile_image) : asset('media/avatars/default.jpg');
    }

    public function getCurrencySymbolAttribute()
    {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'AUD' => 'A$',
            'CAD' => 'C$',
            'CHF' => 'Fr',
            'CNY' => '¥',
            'INR' => '₹'
        ];

        return $symbols[$this->currency] ?? '$';
    }
} 