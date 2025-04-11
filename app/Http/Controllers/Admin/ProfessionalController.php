<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfessionalController extends Controller
{
    public function index()
    {
        $professionals = Professional::with('user')->latest()->paginate(10);
        return view('backend.professionals.index', compact('professionals'));
    }

    public function show(Professional $professional)
    {
        $professional->load('user', 'consultations');
        return view('backend.professionals.show', compact('professional'));
    }

    public function updateStatus(Request $request, Professional $professional)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $professional->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Professional status updated successfully!');
    }

    public function destroy(Professional $professional)
    {
        if ($professional->profile_image) {
            Storage::disk('public')->delete($professional->profile_image);
        }

        $professional->delete();

        return redirect()->route('admin.professionals.index')
            ->with('success', 'Professional deleted successfully!');
    }
} 