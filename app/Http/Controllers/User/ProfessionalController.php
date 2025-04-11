<?php

namespace App\Http\Controllers\User;

use App\Models\Consultation;
use App\Models\Professional;
use Illuminate\Http\Request;
use App\Models\ProfessionalService;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfessionalController extends Controller
{
    public function becomeProfessional(){
        return view('frontend.professionals.become');
    }

    public function storeProfessional(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:1',
            'hourly_rate' => 'required|numeric|min:0',
            'currency' => 'required|string|max:255',
            'bio' => 'required|string|min:50',
            'qualification' => 'required|string|min:50',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'services' => 'required|array|min:1',
            'services.*.calculator_type' => 'required|string|max:255',
            'services.*.service_description' => 'required|string|min:10',
            'services.*.service_rate' => 'required|numeric|min:0',
        ]);

        $data = $request->except('profile_image', 'services');
        $data['user_id'] = Auth::id();
        $data['is_available'] = true;

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('professionals', 'public');
            $data['profile_image'] = $path;
        }

        // Create professional
        $professional = Professional::create($data);

        // Create professional services
        foreach ($request->services as $service) {
            ProfessionalService::create([
                'professional_id' => $professional->id,
                'calculator_type' => $service['calculator_type'],
                'service_description' => $service['service_description'],
                'service_rate' => $service['service_rate'],
                'is_active' => true
            ]);
        }

        return redirect()->route('professionals.show', $professional)
            ->with('success', 'Professional profile created successfully!');
    }

    public function storeConsultation(Request $request, Professional $professional)
    {
        $request->validate([
            'message' => 'required|string',
            'guest_name' => 'required_if:user_id,null|string|max:255',
            'guest_email' => 'required_if:user_id,null|email|max:255',
        ]);

        
        $data = [
            'professional_id' => $professional->id,
            'message' => $request->message,
            'status' => 'pending',
        ];

        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        } else {
            $data['guest_name'] = $request->guest_name;
            $data['guest_email'] = $request->guest_email;
        }

        $consultation = Consultation::create($data);
        // TODO: Send notification to professional

        return redirect()->back()
        ->with('success', 'Your consultation request has been sent successfully.');
    }

    public function show(Professional $professional)
    {
        $professional->load('services');
        return view('frontend.professionals.show', compact('professional'));
    }
} 