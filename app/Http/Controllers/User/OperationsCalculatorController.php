<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmployeeProductivityCalculation;

class OperationsCalculatorController extends Controller
{
    public function processAutomationROI()
    {
        return view('frontend.operations.process_automation_roi');
    }

    public function calculateProcessAutomationROI(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'annualLaborCosts' => 'required|numeric|min:0',
            'annualErrorCosts' => 'required|numeric|min:0',
            'annualProcessingTime' => 'required|numeric|min:0',
            'numberOfEmployees' => 'required|numeric|min:0',
            'softwareLicenseCost' => 'required|numeric|min:0',
            'implementationCost' => 'required|numeric|min:0',
            'trainingCost' => 'required|numeric|min:0',
            'maintenanceCost' => 'required|numeric|min:0',
            'timeReduction' => 'required|numeric|min:0|max:100',
            'errorReduction' => 'required|numeric|min:0|max:100',
            'employeeReduction' => 'required|numeric|min:0|max:100',
            'projectLife' => 'required|numeric|min:1',
        ]);

        // Calculate total investment
        $totalInvestment = $validated['softwareLicenseCost'] + 
                          $validated['implementationCost'] + 
                          $validated['trainingCost'];

        // Calculate annual cost savings
        $laborCostSavings = $validated['annualLaborCosts'] * ($validated['employeeReduction'] / 100);
        $errorCostSavings = $validated['annualErrorCosts'] * ($validated['errorReduction'] / 100);
        $timeCostSavings = ($validated['annualProcessingTime'] * $validated['timeReduction'] / 100) * 
                          ($validated['annualLaborCosts'] / $validated['annualProcessingTime']);

        $annualCostSavings = $laborCostSavings + $errorCostSavings + $timeCostSavings;

        // Calculate total cost savings over project life
        $totalCostSavings = ($annualCostSavings * $validated['projectLife']) - 
                           ($validated['maintenanceCost'] * $validated['projectLife']);

        // Calculate ROI
        $roi = ($totalCostSavings - $totalInvestment) / $totalInvestment * 100;

        // Calculate payback period
        $paybackPeriod = $totalInvestment / $annualCostSavings;

        // Generate recommendation
        $recommendation = $this->generateRecommendation($roi, $paybackPeriod);

        return response()->json([
            'totalInvestment' => round($totalInvestment, 2),
            'annualCostSavings' => round($annualCostSavings, 2),
            'totalCostSavings' => round($totalCostSavings, 2),
            'roi' => round($roi, 2),
            'paybackPeriod' => round($paybackPeriod, 2),
            'recommendation' => $recommendation
        ]);
    }

    private function generateRecommendation($roi, $paybackPeriod)
    {
        if ($roi > 100 && $paybackPeriod < 1) {
            return 'Strongly Recommended - High ROI and quick payback period';
        } elseif ($roi > 50 && $paybackPeriod < 2) {
            return 'Recommended - Good ROI and reasonable payback period';
        } elseif ($roi > 0 && $paybackPeriod < 3) {
            return 'Consider - Positive ROI but longer payback period';
        } else {
            return 'Not Recommended - Negative ROI or very long payback period';
        }
    }

    /**
     * Display the Employee Productivity Analyzer view
     */
    public function employeeProductivityAnalyzer()
    {
        return view('frontend.operations.employee_productivity_analyzer');
    }

    /**
     * Calculate employee productivity metrics based on form submission
     */
    public function calculateEmployeeProductivity(Request $request)
    {
        $request->validate([
            'total_revenue' => 'required|numeric|min:0',
            'total_employees' => 'required|numeric|min:1',
            'productive_hours_per_day' => 'required|numeric|min:1|max:24',
            'working_days_per_year' => 'required|numeric|min:1|max:365',
            'average_salary' => 'required|numeric|min:0',
            'benefits_cost' => 'required|numeric|min:0',
            'total_units_produced' => 'required|numeric|min:0',
            'total_labor_costs' => 'required|numeric|min:0',
            'total_overhead_costs' => 'required|numeric|min:0',
            'total_material_costs' => 'required|numeric|min:0',
            'department_breakdown' => 'nullable|array',
            'notes' => 'nullable|string'
        ]);

        // Calculate basic metrics
        $revenuePerEmployee = $request->total_revenue / $request->total_employees;
        $unitsPerEmployee = $request->total_units_produced / $request->total_employees;
        $costPerUnit = ($request->total_labor_costs + $request->total_overhead_costs + $request->total_material_costs) / $request->total_units_produced;

        // Calculate productivity metrics
        $laborProductivity = $request->total_units_produced / $request->total_labor_costs;
        $capitalProductivity = $request->total_revenue / ($request->total_overhead_costs + $request->total_material_costs);
        $totalFactorProductivity = $request->total_revenue / ($request->total_labor_costs + $request->total_overhead_costs + $request->total_material_costs);

        // Calculate results
        $profitPerEmployee = ($request->total_revenue - ($request->total_labor_costs + $request->total_overhead_costs + $request->total_material_costs)) / $request->total_employees;
        
        // Calculate productivity score (0-100)
        $productivityScore = $this->calculateProductivityScore(
            $laborProductivity,
            $capitalProductivity,
            $totalFactorProductivity
        );

        // Generate productivity trends
        $productivityTrends = $this->generateProductivityTrends(
            $laborProductivity,
            $capitalProductivity,
            $totalFactorProductivity
        );

        // Save calculation
        $calculation = EmployeeProductivityCalculation::create([
            'user_id' => auth()->id(),
            'calculator_id' => 1, // Replace with actual calculator ID
            'total_revenue' => $request->total_revenue,
            'revenue_per_employee' => $revenuePerEmployee,
            'total_employees' => $request->total_employees,
            'productive_hours_per_day' => $request->productive_hours_per_day,
            'working_days_per_year' => $request->working_days_per_year,
            'average_salary' => $request->average_salary,
            'benefits_cost' => $request->benefits_cost,
            'total_units_produced' => $request->total_units_produced,
            'units_per_employee' => $unitsPerEmployee,
            'cost_per_unit' => $costPerUnit,
            'total_labor_costs' => $request->total_labor_costs,
            'total_overhead_costs' => $request->total_overhead_costs,
            'total_material_costs' => $request->total_material_costs,
            'labor_productivity' => $laborProductivity,
            'capital_productivity' => $capitalProductivity,
            'total_factor_productivity' => $totalFactorProductivity,
            'result_revenue_per_employee' => $revenuePerEmployee,
            'result_cost_per_unit' => $costPerUnit,
            'result_profit_per_employee' => $profitPerEmployee,
            'result_productivity_score' => $productivityScore,
            'department_breakdown' => $request->department_breakdown,
            'productivity_trends' => $productivityTrends,
            'notes' => $request->notes
        ]);

        return response()->json([
            'revenue_per_employee' => round($revenuePerEmployee, 2),
            'cost_per_unit' => round($costPerUnit, 2),
            'profit_per_employee' => round($profitPerEmployee, 2),
            'productivity_score' => round($productivityScore, 2),
            'labor_productivity' => round($laborProductivity, 2),
            'capital_productivity' => round($capitalProductivity, 2),
            'total_factor_productivity' => round($totalFactorProductivity, 2),
            'productivity_trends' => $productivityTrends,
            'recommendations' => $this->generateRecommendations($productivityScore, $profitPerEmployee)
        ]);
    }

    /**
     * Calculate overall productivity score (0-100)
     */
    private function calculateProductivityScore($laborProductivity, $capitalProductivity, $totalFactorProductivity)
    {
        // Normalize each metric to a 0-100 scale
        $normalizedLabor = min(100, ($laborProductivity / 100) * 100);
        $normalizedCapital = min(100, ($capitalProductivity / 100) * 100);
        $normalizedTotal = min(100, ($totalFactorProductivity / 100) * 100);

        // Weight the components (can be adjusted based on importance)
        return ($normalizedLabor * 0.4) + ($normalizedCapital * 0.3) + ($normalizedTotal * 0.3);
    }

    /**
     * Generate productivity trends analysis
     */
    private function generateProductivityTrends($laborProductivity, $capitalProductivity, $totalFactorProductivity)
    {
        return [
            'labor_trend' => $this->analyzeTrend($laborProductivity),
            'capital_trend' => $this->analyzeTrend($capitalProductivity),
            'total_trend' => $this->analyzeTrend($totalFactorProductivity)
        ];
    }

    /**
     * Analyze individual trend
     */
    private function analyzeTrend($value)
    {
        if ($value > 100) {
            return 'Excellent';
        } elseif ($value > 75) {
            return 'Good';
        } elseif ($value > 50) {
            return 'Average';
        } elseif ($value > 25) {
            return 'Below Average';
        } else {
            return 'Poor';
        }
    }

    /**
     * Generate recommendations based on productivity metrics
     */
    private function generateRecommendations($productivityScore, $profitPerEmployee)
    {
        $recommendations = [];

        if ($productivityScore < 50) {
            $recommendations[] = 'Consider reviewing labor allocation and workflow processes';
        }
        if ($profitPerEmployee < 0) {
            $recommendations[] = 'Review cost structure and identify areas for optimization';
        }
        if ($productivityScore > 80) {
            $recommendations[] = 'Consider scaling operations while maintaining current productivity levels';
        }

        return $recommendations;
    }
} 