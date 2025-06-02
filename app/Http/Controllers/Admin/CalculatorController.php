<?php

namespace App\Http\Controllers\Admin;

use App\Models\Calculator;
use App\Models\CalculatorCategory;
use App\Models\CalculationHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CalculatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    
    /**
     * Display a listing of all calculators
     */
    public function index()
    {
        $calculators = Calculator::with('category')->get();
        return view('backend.calculators.index', compact('calculators'));
    }
    
    /**
     * Show calculator details and usage statistics
     */
    public function show($id)
    {
        $calculator = Calculator::findOrFail($id);
        
        // Get usage statistics
        $totalUsage = CalculationHistory::where('calculator_id', $id)->count();
        $todayUsage = CalculationHistory::where('calculator_id', $id)
            ->whereDate('created_at', today())
            ->count();
        
        $lastUsed = CalculationHistory::where('calculator_id', $id)
            ->latest()
            ->first();
        
        // Get daily usage for the last 30 days
        $dailyUsage = CalculationHistory::where('calculator_id', $id)
            ->where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        return view('backend.calculators.show', compact(
            'calculator', 
            'totalUsage', 
            'todayUsage', 
            'lastUsed',
            'dailyUsage'
        ));
    }
    
    /**
     * Toggle calculator status (active/inactive)
     */
    public function toggleStatus(Request $request, $id)
    {
        $calculator = Calculator::findOrFail($id);
        $calculator->status = $calculator->status === 'active' ? 'inactive' : 'active';
        $calculator->save();
        
        return redirect()
            ->back()
            ->with('success', "Calculator '{$calculator->name}' is now {$calculator->status}.");
    }
    
    /**
     * Display the form to create a new calculator
     */
    public function create()
    {
        $categories = CalculatorCategory::all();
        return view('backend.calculators.create', compact('categories'));
    }
    
    /**
     * Store a newly created calculator
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:calculators',
            'category_id' => 'required|exists:calculator_categories,id',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'config' => 'nullable|json'
        ]);
        
        Calculator::create($validated);
        
        return redirect()
            ->route('admin.calculators.index')
            ->with('success', 'Calculator created successfully.');
    }
    
    /**
     * Display the form to edit a calculator
     */
    public function edit($id)
    {
        $calculator = Calculator::findOrFail($id);
        $categories = CalculatorCategory::all();
        
        return view('backend.calculators.edit', compact('calculator', 'categories'));
    }
    
    /**
     * Update the specified calculator
     */
    public function update(Request $request, $id)
    {
        $calculator = Calculator::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:calculators,slug,' . $id,
            'category_id' => 'required|exists:calculator_categories,id',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'config' => 'nullable|json'
        ]);
        
        $calculator->update($validated);
        
        return redirect()
            ->route('admin.calculators.index')
            ->with('success', 'Calculator updated successfully.');
    }
}
