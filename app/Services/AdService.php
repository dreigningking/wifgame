<?php

namespace App\Services;

use App\Models\Ad;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

class AdService
{
    public function getAdScript($location)
    {
        // In development, return placeholder content
        if (App::environment('local')) {
            return $this->getDevelopmentPlaceholder($location);
        }

        return Cache::remember("ad_{$location}", 3600, function () use ($location) {
            $ad = Ad::getActiveAd($location);
            return $ad ? $ad->ad_script : null;
        });
    }

    public function displayAd($location)
    {
        $script = $this->getAdScript($location);
        return $script ? $script : $this->getDefaultAd($location);
    }

    protected function getDefaultAd($location)
    {
        // Return default ad HTML if no active ad is found
        return '<div class="ad-placeholder">Advertisement</div>';
    }

    protected function getDevelopmentPlaceholder($location)
    {
        $dimensions = [
            'toolbar_ads' => '600x50',
            'right_side_ads' => '480x250'
        ];

        $dimension = $dimensions[$location] ?? '300x250';
        
        return <<<HTML
<div class="ad-placeholder" style="
    background: #f5f8fa;
    border: 1px dashed #e4e6ef;
    border-radius: 0.475rem;
    padding: 1rem;
    text-align: center;
    color: #7e8299;
    font-size: 0.9rem;
    margin: 1rem 0;
">
    <div style="margin-bottom: 0.5rem;">Ad Placeholder</div>
    <div style="font-size: 0.8rem;">{$dimension}</div>
</div>
HTML;
    }
} 