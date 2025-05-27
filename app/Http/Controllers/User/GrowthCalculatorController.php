<?php

namespace App\Http\Controllers\User;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GrowthCalculatorController extends Controller
{
    /**
     * Display the CAC/CLV Analyzer view
     */
    public function cacClvAnalyzer()
    {
        $posts = Post::where('tags','LIKE',"%roi%")->take(5)->get();
        return view('frontend.growth.cac_clv_analyzer',compact('posts'));
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
            'discountRate' => 'nullable|numeric|min:0|max:100',
            'customerType' => 'required|string|in:b2b,b2c',
            'customerTier' => 'required|string|in:premium,standard,basic',
            'salesCosts' => 'nullable|numeric|min:0',
            'adCosts' => 'nullable|numeric|min:0',
            'techCosts' => 'nullable|numeric|min:0',
            'grossMargin' => 'required|numeric|min:0|max:100',
            'recurringRevenue' => 'nullable|numeric|min:0',
            'oneTimeRevenue' => 'nullable|numeric|min:0',
            'timeToPurchase' => 'nullable|numeric|min:0',
            'purchaseFrequency' => 'nullable|numeric|min:0',
            'marketCompetition' => 'required|string|in:high,medium,low',
            'industryRisk' => 'required|numeric|min:1|max:10'
        ]);

        // Calculate detailed CAC
        $totalAcquisitionCosts = $request->marketingCosts + 
                                ($request->salesCosts ?? 0) + 
                                ($request->adCosts ?? 0) + 
                                ($request->techCosts ?? 0);
        
        $cac = $totalAcquisitionCosts / $request->newCustomers;

        // Calculate segmented revenue
        $totalRevenue = ($request->recurringRevenue ?? 0) + ($request->oneTimeRevenue ?? 0);
        $avgRevenuePerCustomer = $totalRevenue > 0 ? 
            $totalRevenue / $request->newCustomers : 
            $request->averageOrderValue * $request->ordersPerCustomer;

        // Apply gross margin
        $grossMargin = $request->grossMargin / 100;
        $profitPerCustomer = $avgRevenuePerCustomer * $grossMargin;

        // Calculate adjusted CLV with risk factors
        $retentionRate = $request->retentionRate / 100;
        $discountRate = ($request->discountRate ?? 0) / 100;
        $supportCosts = $request->supportCosts ?? 0;
        
        // Risk adjustment factors
        $competitionFactor = [
            'high' => 0.8,
            'medium' => 0.9,
            'low' => 1.0
        ][$request->marketCompetition];
        
        $industryRiskFactor = 1 - (($request->industryRisk - 1) / 10);

        // Enhanced CLV calculation
        $baseClv = ($profitPerCustomer * $retentionRate * $request->customerLifespan) - $supportCosts;
        
        if ($discountRate > 0) {
            $baseClv = $baseClv / pow(1 + $discountRate, $request->customerLifespan);
        }

        // Apply risk adjustments
        $clv = $baseClv * $competitionFactor * $industryRiskFactor;

        // Calculate advanced metrics
        $cacClvRatio = $cac / $clv;
        $customerProfitability = $clv - $cac;
        $monthlyRevenue = $avgRevenuePerCustomer / 12;
        $paybackPeriod = $cac / $monthlyRevenue;

        // Calculate cohort-based metrics
        $purchaseFrequency = $request->purchaseFrequency ?? ($request->ordersPerCustomer / $request->customerLifespan);
        $customerHealth = $this->calculateCustomerHealth(
            $retentionRate,
            $purchaseFrequency,
            $customerProfitability,
            $paybackPeriod
        );

        return response()->json([
            'cac' => round($cac, 2),
            'clv' => round($clv, 2),
            'cacClvRatio' => round($cacClvRatio, 2),
            'avgRevenuePerCustomer' => round($avgRevenuePerCustomer, 2),
            'customerProfitability' => round($customerProfitability, 2),
            'paybackPeriod' => round($paybackPeriod, 1),
            'acquisitionDetails' => [
                'marketingCosts' => round($request->marketingCosts, 2),
                'salesCosts' => round($request->salesCosts ?? 0, 2),
                'adCosts' => round($request->adCosts ?? 0, 2),
                'techCosts' => round($request->techCosts ?? 0, 2)
            ],
            'customerMetrics' => [
                'grossMargin' => $request->grossMargin,
                'purchaseFrequency' => round($purchaseFrequency, 2),
                'timeToPurchase' => $request->timeToPurchase ?? 0,
                'customerHealth' => $customerHealth
            ],
            'riskMetrics' => [
                'competitionImpact' => round((1 - $competitionFactor) * 100, 1),
                'industryRiskImpact' => round((1 - $industryRiskFactor) * 100, 1),
                'adjustedValue' => round($clv - $baseClv, 2)
            ]
        ]);
    }

    private function calculateCustomerHealth($retentionRate, $purchaseFrequency, $profitability, $paybackPeriod)
    {
        $retentionScore = $retentionRate * 30;
        $frequencyScore = min(($purchaseFrequency / 12) * 25, 25);
        $profitabilityScore = $profitability > 0 ? min(($profitability / 1000) * 25, 25) : 0;
        $paybackScore = $paybackPeriod <= 12 ? (20 * (12 - $paybackPeriod) / 12) : 0;

        $totalScore = $retentionScore + $frequencyScore + $profitabilityScore + $paybackScore;

        if ($totalScore >= 80) return 'Excellent';
        if ($totalScore >= 60) return 'Good';
        if ($totalScore >= 40) return 'Fair';
        return 'Poor';
    }

    /**
     * Display the Employee Turnover Cost Calculator view
     */
    public function employeeTurnoverCost()
    {
        return view('frontend.growth.employee_turnover_cost');
    }

    /**
     * Calculate Employee Turnover Cost based on form submission
     */
    public function calculateEmployeeTurnoverCost(Request $request)
    {
        $request->validate([
            // Position Details
            'positionLevel' => 'required|string|in:entry,mid,senior,executive',
            'department' => 'required|string',
            'positionCriticality' => 'required|numeric|min:1|max:5',
            'specializedSkillLevel' => 'required|numeric|min:1|max:5',
            
            // Recruitment Costs
            'jobPostingCosts' => 'required|numeric|min:0',
            'recruitmentFees' => 'required|numeric|min:0',
            'interviewCosts' => 'required|numeric|min:0',
            'backgroundCheckCosts' => 'required|numeric|min:0',
            'relocationCosts' => 'nullable|numeric|min:0',
            'signingBonus' => 'nullable|numeric|min:0',
            'referralBonus' => 'nullable|numeric|min:0',
            'assessmentCosts' => 'nullable|numeric|min:0',
            
            // Training & Development
            'technicalTrainingCosts' => 'required|numeric|min:0',
            'softSkillsTrainingCosts' => 'nullable|numeric|min:0',
            'complianceTrainingCosts' => 'nullable|numeric|min:0',
            'mentorshipCosts' => 'nullable|numeric|min:0',
            'certificationCosts' => 'nullable|numeric|min:0',
            'productivityRampUpMonths' => 'required|numeric|min:1|max:24',
            
            // Productivity Impact
            'dailySalary' => 'required|numeric|min:0',
            'daysToFill' => 'required|numeric|min:1',
            'teamProductivityImpact' => 'required|numeric|min:0|max:100',
            'clientImpactLevel' => 'required|numeric|min:1|max:5',
            'projectDelayCosts' => 'nullable|numeric|min:0',
            'overtimeCosts' => 'nullable|numeric|min:0',
            
            // Knowledge & IP
            'exitInterviewCosts' => 'nullable|numeric|min:0',
            'knowledgeTransferCosts' => 'nullable|numeric|min:0',
            'documentationTime' => 'nullable|numeric|min:0',
            'ipImpactLevel' => 'required|numeric|min:1|max:5',
            
            // Risk Factors
            'marketCondition' => 'required|string|in:favorable,neutral,challenging',
            'seasonalImpact' => 'required|numeric|min:1|max:5',
            'successionReadiness' => 'required|numeric|min:1|max:5',
            
            // Compliance & Benefits
            'benefitsAdminCosts' => 'nullable|numeric|min:0',
            'legalReviewCosts' => 'nullable|numeric|min:0',
            'complianceCosts' => 'nullable|numeric|min:0'
        ]);

        // Calculate enhanced recruitment costs
        $totalRecruitmentCosts = $request->jobPostingCosts +
            $request->recruitmentFees +
            $request->interviewCosts +
            $request->backgroundCheckCosts +
            ($request->relocationCosts ?? 0) +
            ($request->signingBonus ?? 0) +
            ($request->referralBonus ?? 0) +
            ($request->assessmentCosts ?? 0);

        // Calculate comprehensive training costs
        $totalTrainingCosts = $request->technicalTrainingCosts +
            ($request->softSkillsTrainingCosts ?? 0) +
            ($request->complianceTrainingCosts ?? 0) +
            ($request->mentorshipCosts ?? 0) +
            ($request->certificationCosts ?? 0);

        // Calculate productivity impact
        $baseProductivityLoss = $request->dailySalary * $request->daysToFill;
        $teamImpactCost = $baseProductivityLoss * ($request->teamProductivityImpact / 100);
        $totalProductivityCosts = $baseProductivityLoss +
            $teamImpactCost +
            ($request->projectDelayCosts ?? 0) +
            ($request->overtimeCosts ?? 0);

        // Calculate knowledge and compliance costs
        $totalKnowledgeCosts = ($request->knowledgeTransferCosts ?? 0) +
            ($request->documentationTime * $request->dailySalary) +
            $this->calculateIPImpactCost($request->ipImpactLevel, $request->positionLevel);

        // Calculate administrative and compliance costs
        $totalAdminCosts = ($request->exitInterviewCosts ?? 0) +
            ($request->benefitsAdminCosts ?? 0) +
            ($request->legalReviewCosts ?? 0) +
            ($request->complianceCosts ?? 0);

        // Apply risk adjustments
        $riskFactor = $this->calculateRiskFactor(
            $request->marketCondition,
            $request->seasonalImpact,
            $request->successionReadiness
        );

        // Calculate position-specific impact
        $positionImpactFactor = $this->calculatePositionImpact(
            $request->positionLevel,
            $request->positionCriticality,
            $request->specializedSkillLevel
        );

        // Calculate total adjusted cost
        $baseTurnoverCost = $totalRecruitmentCosts +
            $totalTrainingCosts +
            $totalProductivityCosts +
            $totalKnowledgeCosts +
            $totalAdminCosts;

        $adjustedTurnoverCost = $baseTurnoverCost * $riskFactor * $positionImpactFactor;

        // Calculate ROI metrics
        $annualSalary = $request->dailySalary * 260; // Assuming 260 working days
        $turnoverROI = ($annualSalary - $adjustedTurnoverCost) / $adjustedTurnoverCost * 100;

        return response()->json([
            'costBreakdown' => [
                'recruitmentCosts' => round($totalRecruitmentCosts, 2),
                'trainingCosts' => round($totalTrainingCosts, 2),
                'productivityCosts' => round($totalProductivityCosts, 2),
                'knowledgeCosts' => round($totalKnowledgeCosts, 2),
                'adminCosts' => round($totalAdminCosts, 2)
            ],
            'impactAnalysis' => [
                'teamProductivityImpact' => round($teamImpactCost, 2),
                'positionImpactFactor' => round($positionImpactFactor, 2),
                'riskAdjustment' => round($riskFactor, 2)
            ],
            'metrics' => [
                'baseCost' => round($baseTurnoverCost, 2),
                'adjustedCost' => round($adjustedTurnoverCost, 2),
                'turnoverROI' => round($turnoverROI, 2),
                'monthsToRecover' => round($adjustedTurnoverCost / ($annualSalary / 12), 1)
            ],
            'recommendations' => $this->generateRecommendations(
                $request->positionLevel,
                $request->positionCriticality,
                $turnoverROI,
                $request->successionReadiness
            )
        ]);
    }

    private function calculateIPImpactCost($impactLevel, $positionLevel)
    {
        $baseCost = [
            'entry' => 5000,
            'mid' => 10000,
            'senior' => 20000,
            'executive' => 50000
        ][$positionLevel];

        return $baseCost * ($impactLevel / 5);
    }

    private function calculateRiskFactor($marketCondition, $seasonalImpact, $successionReadiness)
    {
        $marketMultiplier = [
            'favorable' => 1.0,
            'neutral' => 1.2,
            'challenging' => 1.5
        ][$marketCondition];

        $seasonalFactor = 1 + (($seasonalImpact - 1) / 10);
        $successionFactor = 1 + ((6 - $successionReadiness) / 10);

        return $marketMultiplier * $seasonalFactor * $successionFactor;
    }

    private function calculatePositionImpact($level, $criticality, $skillLevel)
    {
        $levelMultiplier = [
            'entry' => 1.0,
            'mid' => 1.3,
            'senior' => 1.6,
            'executive' => 2.0
        ][$level];

        return $levelMultiplier * (1 + $criticality / 5) * (1 + $skillLevel / 5);
    }

    private function generateRecommendations($level, $criticality, $roi, $successionReadiness)
    {
        $recommendations = [];

        if ($criticality >= 4) {
            $recommendations[] = "Implement immediate succession planning due to high position criticality.";
        }

        if ($roi < 0) {
            $recommendations[] = "Review compensation structure to align with turnover costs.";
        }

        if ($successionReadiness < 3) {
            $recommendations[] = "Develop comprehensive knowledge transfer protocols.";
        }

        // Add more recommendation logic based on other factors

        return $recommendations;
    }
} 