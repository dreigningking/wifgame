<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'name',
        'location',
        'ad_script',
        'ad_network',
        'is_active'
    ];

    public static function getActiveAd($location)
    {
        return self::where('location', $location)
            ->where('is_active', true)
            ->first();
    }
} 