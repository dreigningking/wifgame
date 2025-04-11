<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Professional;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share professionals data with calculator views
        View::composer('frontend.layouts.professionals', function ($view) {
            
            $professionals = Professional::with(['user', 'services'])
                ->where('is_available', true)
                ->whereHas('services', function ($query) {
                    $query->where('is_active', true);
                })
                ->latest()
                ->take(4)
                ->get();

            $view->with('professionals', $professionals);
        });
    }
} 