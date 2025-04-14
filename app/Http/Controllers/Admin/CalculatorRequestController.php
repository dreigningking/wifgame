<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalculatorRequest;
use Illuminate\Http\Request;

class CalculatorRequestController extends Controller
{
    public function index()
    {
        $requests = CalculatorRequest::with('user')->latest()->paginate(10);
        return view('backend.calculators.requests', compact('requests'));
    }

    public function updateStatus(Request $request)
    {
        
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,rejected',
            'request_id' => 'required|exists:calculator_requests,id',
        ]);
        $calculatorRequest = CalculatorRequest::find($request->request_id);
        $calculatorRequest->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    public function addNotes(Request $request)
    {
        $request->validate([
            'admin_notes' => 'required|string',
            'request_id' => 'required|exists:calculator_requests,id',
        ]);
        $calculatorRequest = CalculatorRequest::find($request->request_id);

        $calculatorRequest->update([
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->back()->with('success', 'Notes added successfully');
    }
} 