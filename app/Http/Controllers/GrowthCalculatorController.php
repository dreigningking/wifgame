<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GrowthCalculatorController extends Controller
{
    /**
     * Display the CAC/CLV Analyzer view
     */
    public function cacClvAnalyzer()
    {
        return view('growth.cac_clv_analyzer');
    }

    /**
     * Calculate CAC/CLV based on form submission
     */
    public function calculateCACCLV(Request $request)
    {
        $request->validate([
            'marketingCosts' => 'required|numeric|min:0',
            'newCustomers' => 'required|numeric|min:1',
            'averageOrderValue' => 'required|numeric|min:0',
            'ordersPerCustomer' => 'required|numeric|min:1',
            'retentionRate' => 'required|numeric|min:0|max:100',
            'customerLifespan' => 'required|numeric|min:0',
            'supportCosts' => 'nullable|numeric|min:0',
            'discountRate' => 'nullable|numeric|min:0|max:100'
        ]);

        // Calculate Customer Acquisition Cost (CAC)
        $cac = $request->marketingCosts / $request->newCustomers;

        // Calculate average revenue per customer
        $avgRevenuePerCustomer = $request->averageOrderValue * $request->ordersPerCustomer;

        // Calculate Customer Lifetime Value (CLV)
        $retentionRate = $request->retentionRate / 100;
        $discountRate = ($request->discountRate ?? 0) / 100;
        $supportCosts = $request->supportCosts ?? 0;
        
        // Calculate CLV using the formula: CLV = (Average Revenue per Customer * Retention Rate * Customer Lifespan) - Support Costs
        $clv = ($avgRevenuePerCustomer * $retentionRate * $request->customerLifespan) - $supportCosts;

        // If discount rate is provided, apply present value calculation
        if ($discountRate > 0) {
            $clv = $clv / pow(1 + $discountRate, $request->customerLifespan);
        }

        // Calculate CAC/CLV ratio
        $cacClvRatio = $cac / $clv;

        // Calculate customer profitability
        $customerProfitability = $clv - $cac;

        // Calculate payback period (in months)
        $monthlyRevenue = $avgRevenuePerCustomer / 12;
        $paybackPeriod = $cac / $monthlyRevenue;

        return response()->json([
            'cac' => round($cac, 2),
            'clv' => round($clv, 2),
            'cacClvRatio' => round($cacClvRatio, 2),
            'avgRevenuePerCustomer' => round($avgRevenuePerCustomer, 2),
            'customerProfitability' => round($customerProfitability, 2),
            'paybackPeriod' => round($paybackPeriod, 1)
        ]);
    }

    /**
     * Display the Employee Turnover Cost Calculator view
     */
    public function employeeTurnoverCost()
    {
        return view('growth.employee_turnover_cost');
    }

    /**
     * Calculate Employee Turnover Cost based on form submission
     */
    public function calculateEmployeeTurnoverCost(Request $request)
    {
        $request->validate([
            'jobPostingCosts' => 'required|numeric|min:0',
            'recruitmentFees' => 'required|numeric|min:0',
            'interviewCosts' => 'required|numeric|min:0',
            'backgroundCheckCosts' => 'required|numeric|min:0',
            'trainingCosts' => 'required|numeric|min:0',
            'trainerCosts' => 'required|numeric|min:0',
            'dailySalary' => 'required|numeric|min:0',
            'daysToFill' => 'required|numeric|min:1',
            'exitInterviewCosts' => 'nullable|numeric|min:0',
            'knowledgeTransferCosts' => 'nullable|numeric|min:0'
        ]);

        // Calculate total recruitment costs
        $totalRecruitmentCosts = $request->jobPostingCosts + 
                                $request->recruitmentFees + 
                                $request->interviewCosts + 
                                $request->backgroundCheckCosts;

        // Calculate total training costs
        $totalTrainingCosts = $request->trainingCosts + $request->trainerCosts;

        // Calculate administrative costs
        $totalAdminCosts = ($request->exitInterviewCosts ?? 0);

        // Calculate lost productivity costs
        $lostProductivityCosts = $request->dailySalary * $request->daysToFill;

        // Calculate knowledge loss costs
        $knowledgeLossCosts = ($request->knowledgeTransferCosts ?? 0);

        // Calculate total turnover cost
        $totalTurnoverCost = $totalRecruitmentCosts + 
                            $totalTrainingCosts + 
                            $totalAdminCosts + 
                            $lostProductivityCosts + 
                            $knowledgeLossCosts;

        return response()->json([
            'totalRecruitmentCosts' => round($totalRecruitmentCosts, 2),
            'totalTrainingCosts' => round($totalTrainingCosts, 2),
            'totalAdminCosts' => round($totalAdminCosts, 2),
            'lostProductivityCosts' => round($lostProductivityCosts, 2),
            'knowledgeLossCosts' => round($knowledgeLossCosts, 2),
            'totalTurnoverCost' => round($totalTurnoverCost, 2)
        ]);
    }
} 