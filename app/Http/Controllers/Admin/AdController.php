<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class AdController extends Controller
{
    public function index()
    {
        $ads = Ad::all();
        return view('backend.ads.index', compact('ads'));
    }

    public function create()
    {
        return view('backend.ads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|in:toolbar_ads,right_side_ads',
            'ad_script' => 'required|string',
            'ad_network' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $ad = Ad::create($validated);
        
        // Clear the cache for this ad location
        Cache::forget("ad_{$ad->location}");

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad created successfully.');
    }

    public function edit(Ad $ad)
    {
        return view('backend.ads.edit', compact('ad'));
    }

    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|in:toolbar_ads,right_side_ads',
            'ad_script' => 'required|string',
            'ad_network' => 'required|string',
            'is_active' => 'boolean'
        ]);

        $ad->update($validated);
        
        // Clear the cache for this ad location
        Cache::forget("ad_{$ad->location}");

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad updated successfully.');
    }

    public function destroy(Ad $ad)
    {
        $location = $ad->location;
        $ad->delete();
        
        // Clear the cache for this ad location
        Cache::forget("ad_{$location}");

        return redirect()->route('admin.ads.index')
            ->with('success', 'Ad deleted successfully.');
    }
} 