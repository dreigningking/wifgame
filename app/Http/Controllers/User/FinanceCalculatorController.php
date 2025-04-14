<?php

namespace App\Http\Controllers\User;

use Log;
use DateTime;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FinanceCalculatorController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function processAutomationROI()
    {
        return view('frontend.operations.process_automation_roi');
    }

    public function roiCalculator()
    {
        $posts = Post::where('tags','LIKE',"%roi%")->take(5)->get();
        return view('frontend.finance.roi_calculator',compact('posts'));
    }

    /**
     * Calculate ROI based on form submission
     */
    public function calculateROI(Request $request)
    {
        $request->validate([
            'initialInvestment' => 'required|numeric|min:0',
            'investmentPeriod' => 'required|numeric|min:1',
            'annualReturns' => 'required|numeric|min:0',
            'industry' => 'required|string',
            'industryBenchmark' => 'required|numeric|min:0',
            'riskFactor' => 'required|string|in:low,medium,high',
            'additionalCosts' => 'required|array',
            'additionalCosts.*.type' => 'required|string',
            'additionalCosts.*.value' => 'required|numeric|min:0'
        ]);

        // Calculate total additional costs
        $totalAdditionalCosts = 0;
        foreach ($request->additionalCosts as $cost) {
            $totalAdditionalCosts += $cost['value'];
        }

        // Calculate total investment
        $totalInvestment = $request->initialInvestment + $totalAdditionalCosts;

        // Calculate total returns
        $totalReturns = $request->annualReturns * $request->investmentPeriod;

        // Calculate net profit
        $netProfit = $totalReturns - $totalInvestment;

        // Calculate ROI
        $roi = ($netProfit / $totalInvestment) * 100;

        // Calculate risk-adjusted ROI
        $riskAdjustment = [
            'low' => 1.1,   // 10% increase
            'medium' => 1.0, // no adjustment
            'high' => 0.9    // 10% decrease
        ];
        $riskAdjustedROI = $roi * $riskAdjustment[$request->riskFactor];

        // Calculate payback period
        $paybackPeriod = $totalInvestment / $request->annualReturns;

        // Save calculation
        // $calculation = RoiCalculation::create([
        //     'user_id' => auth()->id(),
        //     'calculator_id' => 1, // Replace with actual calculator ID
        //     'initial_investment' => $request->initialInvestment,
        //     'investment_period' => $request->investmentPeriod,
        //     'annual_returns' => $request->annualReturns,
        //     'industry' => $request->industry,
        //     'industry_benchmark' => $request->industryBenchmark,
        //     'risk_factor' => $request->riskFactor,
        //     'additional_costs' => $request->additionalCosts,
        //     'total_investment' => $totalInvestment,
        //     'total_returns' => $totalReturns,
        //     'net_profit' => $netProfit,
        //     'roi' => $roi,
        //     'risk_adjusted_roi' => $riskAdjustedROI,
        //     'payback_period' => $paybackPeriod
        // ]);

        return response()->json([
            'totalInvestment' => round($totalInvestment, 2),
            'totalReturns' => round($totalReturns, 2),
            'netProfit' => round($netProfit, 2),
            'roi' => round($roi, 2),
            'industryBenchmark' => $request->industryBenchmark,
            'riskAdjustedROI' => round($riskAdjustedROI, 2),
            'paybackPeriod' => round($paybackPeriod, 2)
        ]);
    }

    /**
     * Display the NPV Calculator view
     */
    public function npvCalculator()
    {
        return view('frontend.finance.npv_calculator');
    }

    /**
     * Calculate NPV and IRR based on form submission
     */
    public function calculateNPV(Request $request)
    {
        \Log::info('NPV Calculation Request', [
            'inputs' => $request->all()
        ]);

        try {
            // Validate the request
            $validated = $request->validate([
                'initialInvestment' => 'required|numeric|min:0',
                'discountRate' => 'required|numeric|min:0|max:100',
                'cashFlows' => 'required|array|min:1',
                'cashFlows.*' => 'required|numeric',
                'timePeriod' => 'required|string|in:monthly,quarterly,annual',
                'terminalValue' => 'nullable|numeric|min:0',
                'taxRate' => 'nullable|numeric|min:0|max:100',
                'riskPremium' => 'nullable|numeric|min:0|max:100',
                'inflationRate' => 'nullable|numeric|min:0|max:100'
            ]);

            // Initialize variables with validation
            $initialInvestment = $validated['initialInvestment'];
            if ($initialInvestment <= 0) {
                throw new \Exception('Initial investment must be greater than zero');
            }

            $baseDiscountRate = $validated['discountRate'] / 100;
            $cashFlows = $validated['cashFlows'];
            $terminalValue = $validated['terminalValue'] ?? 0;
            $taxRate = ($validated['taxRate'] ?? 0) / 100;
            $riskPremium = ($validated['riskPremium'] ?? 0) / 100;
            $inflationRate = ($validated['inflationRate'] ?? 0) / 100;

            // Validate cash flows
            if (empty($cashFlows)) {
                throw new \Exception('At least one cash flow is required');
            }

            // Adjust discount rate for risk premium
            $adjustedDiscountRate = $baseDiscountRate + $riskPremium;

            // Adjust period multiplier based on time period selection
            $periodMultiplier = 1;
            switch ($validated['timePeriod']) {
                case 'monthly':
                    $periodMultiplier = 1/12;
                    break;
                case 'quarterly':
                    $periodMultiplier = 1/4;
                    break;
                case 'annual':
                    $periodMultiplier = 1;
                    break;
            }

            // Calculate NPV
            $npv = -$initialInvestment;
            $totalCashFlows = 0;
            $cumulativeCashFlow = -$initialInvestment;
            $paybackPeriod = null;
            $foundPayback = false;
            $discountedCashFlows = [];

            foreach ($cashFlows as $year => $cashFlow) {
                // Adjust cash flow for tax and inflation
                $afterTaxCashFlow = $cashFlow * (1 - $taxRate);
                $inflationAdjustedCashFlow = $afterTaxCashFlow / pow(1 + $inflationRate, $year + 1);
                
                // Calculate discounted cash flow
                $period = ($year + 1) * $periodMultiplier;
                $discountedCashFlow = $inflationAdjustedCashFlow / pow(1 + $adjustedDiscountRate, $period);
                $discountedCashFlows[] = $discountedCashFlow;
                
                $npv += $discountedCashFlow;
                $totalCashFlows += $cashFlow;

                // Calculate payback period
                if (!$foundPayback) {
                    $cumulativeCashFlow += $cashFlow;
                    if ($cumulativeCashFlow >= 0) {
                        $paybackPeriod = $year + ($cumulativeCashFlow - $cashFlow) / $cashFlow;
                        $foundPayback = true;
                    }
                }
            }

            // Add terminal value if provided
            if ($terminalValue > 0) {
                $period = count($cashFlows) * $periodMultiplier;
                $discountedTerminalValue = $terminalValue / pow(1 + $adjustedDiscountRate, $period);
                $npv += $discountedTerminalValue;
                $totalCashFlows += $terminalValue;
            }

            // Calculate IRR
            $irr = $this->calculateIRR($initialInvestment, array_merge($cashFlows, [$terminalValue]));

            // Calculate profitability index
            $profitabilityIndex = ($npv + $initialInvestment) / $initialInvestment;

            // Determine investment decision with detailed reasoning
            $investmentDecision = [
                'decision' => $npv >= 0 ? 'Accept' : 'Reject',
                'reasoning' => []
            ];

            if ($npv >= 0) {
                $investmentDecision['reasoning'][] = 'Positive NPV indicates value creation';
                if ($irr > $adjustedDiscountRate) {
                    $investmentDecision['reasoning'][] = 'IRR exceeds required return';
                }
                if ($profitabilityIndex > 1) {
                    $investmentDecision['reasoning'][] = 'Project returns more than $1 per dollar invested';
                }
            } else {
                $investmentDecision['reasoning'][] = 'Negative NPV indicates value destruction';
                if ($irr < $adjustedDiscountRate) {
                    $investmentDecision['reasoning'][] = 'IRR below required return';
                }
                if ($profitabilityIndex < 1) {
                    $investmentDecision['reasoning'][] = 'Project returns less than $1 per dollar invested';
                }
            }

            \Log::info('NPV Calculation Result', [
                'npv' => $npv,
                'irr' => $irr,
                'paybackPeriod' => $paybackPeriod
            ]);

            return response()->json([
                'npv' => round($npv, 2),
                'irr' => round($irr * 100, 2),
                'paybackPeriod' => $paybackPeriod ? round($paybackPeriod, 1) : null,
                'totalInvestment' => round($initialInvestment, 2),
                'totalCashFlows' => round($totalCashFlows, 2),
                'profitabilityIndex' => round($profitabilityIndex, 2),
                'adjustedDiscountRate' => round($adjustedDiscountRate * 100, 2),
                'effectiveTaxRate' => round($taxRate * 100, 2),
                'inflationImpact' => round($inflationRate * 100, 2),
                'riskAdjustment' => round($riskPremium * 100, 2),
                'terminalValue' => round($terminalValue, 2),
                'investmentDecision' => $investmentDecision['decision'],
                'decisionReasoning' => $investmentDecision['reasoning']
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('NPV Calculation Error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Error calculating NPV: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate IRR using Newton-Raphson method
     */
    private function calculateIRR($initialInvestment, $cashFlows, $tolerance = 0.0001, $maxIterations = 100)
    {
        try {
            $guess = 0.1; // Initial guess of 10%
            $iteration = 0;

            while ($iteration < $maxIterations) {
                $npv = -$initialInvestment;
                $derivative = 0;

                foreach ($cashFlows as $year => $cashFlow) {
                    if ($cashFlow == 0) {
                        continue;
                    }
                    
                    $npv += $cashFlow / pow(1 + $guess, $year + 1);
                    $derivative -= ($year + 1) * $cashFlow / pow(1 + $guess, $year + 2);
                }

                // Check for division by zero
                if ($derivative == 0) {
                    throw new \Exception('Cannot calculate IRR: derivative is zero');
                }

                $newGuess = $guess - $npv / $derivative;

                if (abs($newGuess - $guess) < $tolerance) {
                    return $newGuess;
                }

                $guess = $newGuess;
                $iteration++;
            }

            throw new \Exception('IRR calculation did not converge');

        } catch (\Exception $e) {
            \Log::warning('IRR Calculation Warning: ' . $e->getMessage());
            return 0; // Return 0 as a fallback
        }
    }

    /**
     * Display the Breakeven Analysis view
     */
    public function breakevenCalculator()
    {
        return view('frontend.finance.breakeven_analysis');
    }

    /**
     * Calculate Breakeven Point based on form submission
     */
    public function calculateBreakeven(Request $request)
    {
        $validated = $request->validate([
            'fixedCosts' => 'required|numeric|min:0',
            'variableCosts' => 'required|numeric|min:0',
            'salesPrice' => 'required|numeric|min:0',
            'semiVariableCosts' => 'nullable|numeric|min:0',
            'costChangeThreshold' => 'nullable|numeric|min:0',
            'currentSalesVolume' => 'nullable|numeric|min:0',
            'productionCapacity' => 'nullable|numeric|min:0',
            'analysisPeriod' => 'nullable|string|in:monthly,quarterly,annual',
            'targetProfit' => 'nullable|numeric|min:0'
        ]);

        // Period adjustment multiplier
        $periodMultiplier = match($request->analysisPeriod) {
            'monthly' => 1/12,
            'quarterly' => 1/4,
            'annual' => 1,
            default => 1
        };

        // Adjust fixed costs for the period
        $fixedCosts = $request->fixedCosts * $periodMultiplier;
        $semiVariableCosts = ($request->semiVariableCosts ?? 0) * $periodMultiplier;

        // Calculate total fixed costs
        $totalFixedCosts = $fixedCosts + $semiVariableCosts;

        // Calculate contribution margin
        $contributionMargin = $request->salesPrice - $request->variableCosts;
        $contributionMarginRatio = ($contributionMargin / $request->salesPrice) * 100;

        // Calculate basic breakeven point
        $breakevenUnits = $totalFixedCosts / $contributionMargin;
        $breakevenRevenue = $breakevenUnits * $request->salesPrice;

        // Calculate target profit units and revenue
        $targetProfitUnits = null;
        $targetProfitRevenue = null;
        if ($request->targetProfit) {
            $targetProfitUnits = ($totalFixedCosts + $request->targetProfit) / $contributionMargin;
            $targetProfitRevenue = $targetProfitUnits * $request->salesPrice;
        }

        // Calculate margin of safety
        $marginOfSafety = 0;
        $marginOfSafetyRevenue = 0;
        if ($request->currentSalesVolume) {
            $marginOfSafety = (($request->currentSalesVolume - $breakevenUnits) / $request->currentSalesVolume) * 100;
            $marginOfSafetyRevenue = ($request->currentSalesVolume - $breakevenUnits) * $request->salesPrice;
        }

        // Calculate operating leverage
        $operatingLeverage = 0;
        if ($request->currentSalesVolume && $request->currentSalesVolume > 0) {
            $totalContribution = $contributionMargin * $request->currentSalesVolume;
            $operatingLeverage = $totalContribution / ($totalContribution - $totalFixedCosts);
        }

        // Check production capacity constraints
        $capacityUtilization = null;
        $capacityConstraint = null;
        if ($request->productionCapacity) {
            $capacityUtilization = ($breakevenUnits / $request->productionCapacity) * 100;
            $capacityConstraint = $breakevenUnits > $request->productionCapacity ? 
                'Breakeven point exceeds production capacity' : 'Production capacity sufficient';
        }

        // Calculate step-cost impact if threshold is provided
        $stepCostImpact = null;
        if ($request->costChangeThreshold && $breakevenUnits > $request->costChangeThreshold) {
            $additionalFixedCosts = $semiVariableCosts;
            $newBreakevenUnits = ($totalFixedCosts + $additionalFixedCosts) / $contributionMargin;
            $stepCostImpact = $newBreakevenUnits - $breakevenUnits;
        }

        return response()->json([
            'breakevenUnits' => round($breakevenUnits, 2),
            'breakevenRevenue' => round($breakevenRevenue, 2),
            'contributionMargin' => round($contributionMargin, 2),
            'contributionMarginRatio' => round($contributionMarginRatio, 2),
            'targetProfitUnits' => $targetProfitUnits ? round($targetProfitUnits, 2) : null,
            'targetProfitRevenue' => $targetProfitRevenue ? round($targetProfitRevenue, 2) : null,
            'marginOfSafety' => round($marginOfSafety, 2),
            'marginOfSafetyRevenue' => round($marginOfSafetyRevenue, 2),
            'operatingLeverage' => round($operatingLeverage, 2),
            'capacityUtilization' => $capacityUtilization ? round($capacityUtilization, 2) : null,
            'capacityConstraint' => $capacityConstraint,
            'stepCostImpact' => $stepCostImpact ? round($stepCostImpact, 2) : null,
            'periodAdjustedFixedCosts' => round($totalFixedCosts, 2)
        ]);
    }

    /**
     * Display the Scenario Planner view
     */
    public function scenarioPlanner()
    {
        return view('frontend.finance.scenario_planner');
    }

    /**
     * Calculate scenarios based on form submission
     */
    public function calculateScenarios(Request $request)
    {
        try {
            Log::info('Scenario Calculation Request', [
                'inputs' => $request->all()
            ]);

            $validated = $request->validate([
                'baseRevenue' => 'required|numeric|min:0',
                'baseCosts' => 'required|numeric|min:0',
                'optimisticRevenueGrowth' => 'required|numeric|min:0|max:100',
                'optimisticCostReduction' => 'required|numeric|min:0|max:100',
                'optimisticProbability' => 'required|numeric|min:0|max:100',
                'pessimisticRevenueDecline' => 'required|numeric|min:0|max:100',
                'pessimisticCostIncrease' => 'required|numeric|min:0|max:100',
                'pessimisticProbability' => 'required|numeric|min:0|max:100',
                'timePeriod' => 'required|numeric|min:1',
                'discountRate' => 'nullable|numeric|min:0|max:100',
                'inflationRate' => 'nullable|numeric|min:0|max:100',
                'marketGrowthRate' => 'nullable|numeric|min:-100|max:100',
                'competitivePressure' => 'nullable|string|in:low,medium,high',
                'operationalEfficiency' => 'nullable|numeric|min:0|max:100'
            ]);

            // Validate probability sum
            $totalProbability = $request->optimisticProbability + $request->pessimisticProbability;
            if ($totalProbability >= 100) {
                throw new \Exception('Total probability of optimistic and pessimistic scenarios cannot exceed 100%');
            }

            // Calculate base scenario metrics
            $baseProfit = $request->baseRevenue - $request->baseCosts;
            $baseProfitMargin = ($baseProfit / $request->baseRevenue) * 100;

            // Calculate optimistic scenario
            $optimisticRevenue = $request->baseRevenue * (1 + ($request->optimisticRevenueGrowth / 100));
            $optimisticCosts = $request->baseCosts * (1 - ($request->optimisticCostReduction / 100));
            $optimisticProfit = $optimisticRevenue - $optimisticCosts;
            $optimisticProfitMargin = ($optimisticProfit / $optimisticRevenue) * 100;

            // Calculate pessimistic scenario
            $pessimisticRevenue = $request->baseRevenue * (1 - ($request->pessimisticRevenueDecline / 100));
            $pessimisticCosts = $request->baseCosts * (1 + ($request->pessimisticCostIncrease / 100));
            $pessimisticProfit = $pessimisticRevenue - $pessimisticCosts;
            $pessimisticProfitMargin = ($pessimisticProfit / $pessimisticRevenue) * 100;

            // Calculate probabilities
            $optimisticProbability = $request->optimisticProbability / 100;
            $pessimisticProbability = $request->pessimisticProbability / 100;
            $baseProbability = 1 - $optimisticProbability - $pessimisticProbability;

            // Apply time value adjustments
            $discountRate = ($request->discountRate ?? 0) / 100;
            $inflationRate = ($request->inflationRate ?? 0) / 100;
            $effectiveDiscountRate = (1 + $discountRate) * (1 + $inflationRate) - 1;

            // Calculate present values
            $baseNPV = $this->calculateNPVForScenario($baseProfit, $request->timePeriod, $effectiveDiscountRate);
            $optimisticNPV = $this->calculateNPVForScenario($optimisticProfit, $request->timePeriod, $effectiveDiscountRate);
            $pessimisticNPV = $this->calculateNPVForScenario($pessimisticProfit, $request->timePeriod, $effectiveDiscountRate);

            // Calculate expected values
            $expectedProfit = ($baseProfit * $baseProbability) +
                             ($optimisticProfit * $optimisticProbability) +
                             ($pessimisticProfit * $pessimisticProbability);

            $expectedNPV = ($baseNPV * $baseProbability) +
                           ($optimisticNPV * $optimisticProbability) +
                           ($pessimisticNPV * $pessimisticProbability);

            // Calculate risk metrics
            $bestCase = max($baseProfit, $optimisticProfit, $pessimisticProfit);
            $worstCase = min($baseProfit, $optimisticProfit, $pessimisticProfit);
            $range = $bestCase - $worstCase;
            $volatility = $range / $expectedProfit;

            // Calculate scenario spreads
            $optimisticSpread = (($optimisticProfit - $baseProfit) / $baseProfit) * 100;
            $pessimisticSpread = (($pessimisticProfit - $baseProfit) / $baseProfit) * 100;

            // Determine risk level and recommendations
            $riskLevel = $this->determineRiskLevel($volatility, $range, $expectedProfit);
            $recommendations = $this->generateRecommendations(
                $riskLevel, 
                $optimisticSpread, 
                $pessimisticSpread, 
                $request->competitivePressure ?? 'medium'
            );

            \Log::info('Scenario Calculation Result', [
                'baseScenario' => [
                    'profit' => $baseProfit,
                    'profitMargin' => $baseProfitMargin
                ],
                'expectedValues' => [
                    'profit' => $expectedProfit,
                    'npv' => $expectedNPV
                ]
            ]);

            return response()->json([
                'baseScenario' => [
                    'profit' => round($baseProfit, 2),
                    'profitMargin' => round($baseProfitMargin, 2),
                    'npv' => round($baseNPV, 2),
                    'probability' => round($baseProbability * 100, 2)
                ],
                'optimisticScenario' => [
                    'profit' => round($optimisticProfit, 2),
                    'profitMargin' => round($optimisticProfitMargin, 2),
                    'npv' => round($optimisticNPV, 2),
                    'probability' => round($optimisticProbability * 100, 2),
                    'spread' => round($optimisticSpread, 2)
                ],
                'pessimisticScenario' => [
                    'profit' => round($pessimisticProfit, 2),
                    'profitMargin' => round($pessimisticProfitMargin, 2),
                    'npv' => round($pessimisticNPV, 2),
                    'probability' => round($pessimisticProbability * 100, 2),
                    'spread' => round($pessimisticSpread, 2)
                ],
                'expectedValues' => [
                    'profit' => round($expectedProfit, 2),
                    'npv' => round($expectedNPV, 2)
                ],
                'riskMetrics' => [
                    'bestCase' => round($bestCase, 2),
                    'worstCase' => round($worstCase, 2),
                    'range' => round($range, 2),
                    'volatility' => round($volatility * 100, 2),
                    'riskLevel' => $riskLevel
                ],
                'recommendations' => $recommendations
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Scenario Calculation Validation Error', [
                'errors' => $e->errors()
            ]);
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Scenario Calculation Error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Error calculating scenarios: ' . $e->getMessage()
            ], 500);
        }
    }

    private function calculateNPVForScenario($cashFlow, $periods, $discountRate)
    {
        $npv = 0;
        for ($i = 1; $i <= $periods; $i++) {
            $npv += $cashFlow / pow(1 + $discountRate, $i);
        }
        return $npv;
    }

    private function determineRiskLevel($volatility, $range, $expectedProfit)
    {
        if ($volatility > 0.5 || $range > $expectedProfit) {
            return 'High';
        } elseif ($volatility > 0.25 || $range > $expectedProfit * 0.5) {
            return 'Medium';
        }
        return 'Low';
    }

    private function generateRecommendations($riskLevel, $optimisticSpread, $pessimisticSpread, $competitivePressure)
    {
        $recommendations = [];

        // Risk-based recommendations
        if ($riskLevel === 'High') {
            $recommendations[] = 'Consider risk mitigation strategies';
            $recommendations[] = 'Develop contingency plans for downside scenarios';
        }

        // Spread-based recommendations
        if ($optimisticSpread > 50) {
            $recommendations[] = 'Identify key drivers of upside potential';
            $recommendations[] = 'Invest in growth opportunities';
        }
        if ($pessimisticSpread < -30) {
            $recommendations[] = 'Focus on cost control measures';
            $recommendations[] = 'Build financial buffers';
        }

        // Competitive pressure recommendations
        switch ($competitivePressure) {
            case 'high':
                $recommendations[] = 'Focus on competitive advantages';
                $recommendations[] = 'Consider strategic partnerships';
                break;
            case 'medium':
                $recommendations[] = 'Balance growth with risk management';
                break;
            case 'low':
                $recommendations[] = 'Explore market expansion opportunities';
                break;
        }

        return $recommendations;
    }

    /**
     * Display the Market Share Calculator view
     */
    public function marketShareCalculator()
    {
        return view('frontend.finance.market_share_calculator');
    }

    /**
     * Calculate market share based on form submission
     */
    public function calculateMarketShare(Request $request)
    {
        try {
            $validated = $request->validate([
                // Basic Market Share Data
                'companyRevenue' => 'required|numeric|min:0',
                'companyUnits' => 'required|numeric|min:0',
                'marketRevenue' => 'required|numeric|min:0',
                'marketUnits' => 'required|numeric|min:0',
                
                // Market Segmentation
                'marketSegment' => 'required|string|in:overall,premium,midrange,budget',
                'region' => 'required|string|in:global,domestic,regional',
                
                // Competitive Analysis
                'competitorCount' => 'required|numeric|min:1',
                'marketLeaderRevenue' => 'nullable|numeric|min:0',
                'industryConcentration' => 'nullable|numeric|min:0|max:10000',
                
                // Growth Metrics
                'marketGrowthRate' => 'required|numeric|min:-100|max:100',
                'expectedGrowth' => 'required|numeric|min:-100|max:100',
                
                // Marketing Metrics
                'marketingBudget' => 'required|numeric|min:0',
                'customerAcquisitionCost' => 'nullable|numeric|min:0',
                'customerLifetimeValue' => 'nullable|numeric|min:0',
                'retentionRate' => 'nullable|numeric|min:0|max:100'
            ]);

            // Basic Market Share Calculations
            $revenueMarketShare = ($request->companyRevenue / $request->marketRevenue) * 100;
            $unitMarketShare = ($request->companyUnits / $request->marketUnits) * 100;
            $avgCompetitorShare = 100 / $request->competitorCount;

            // Relative Market Share (compared to leader)
            $relativeMarketShare = $request->marketLeaderRevenue ? 
                ($request->companyRevenue / $request->marketLeaderRevenue) * 100 : null;

            // Market Concentration Analysis
            $marketConcentration = $this->determineMarketConcentration($request->industryConcentration);
            $competitivePosition = $this->determineCompetitivePosition($revenueMarketShare, $avgCompetitorShare);

            // Growth Analysis
            $marketGrowthImpact = $request->marketRevenue * ($request->marketGrowthRate / 100);
            $projectedMarketShare = $revenueMarketShare * (1 + ($request->expectedGrowth / 100));
            $shareGrowthRate = (($projectedMarketShare - $revenueMarketShare) / $revenueMarketShare) * 100;
            $marketPenetration = ($request->companyUnits / $request->marketUnits) * 100;

            // Marketing Efficiency
            $marketingROI = ($request->expectedGrowth / ($request->marketingBudget / $request->companyRevenue)) * 100;
            $clvCacRatio = $request->customerAcquisitionCost && $request->customerAcquisitionCost > 0 ? 
                $request->customerLifetimeValue / $request->customerAcquisitionCost : null;
            
            // Generate Strategic Recommendations
            $recommendations = $this->generateMarketShareRecommendations(
                $competitivePosition,
                $shareGrowthRate,
                $clvCacRatio,
                $marketConcentration,
                $request->marketSegment,
                $marketPenetration
            );

            return response()->json([
                'marketPosition' => [
                    'revenueMarketShare' => round($revenueMarketShare, 2),
                    'unitMarketShare' => round($unitMarketShare, 2),
                    'relativeMarketShare' => $relativeMarketShare ? round($relativeMarketShare, 2) : null,
                    'competitivePosition' => $competitivePosition
                ],
                'competitiveAnalysis' => [
                    'avgCompetitorShare' => round($avgCompetitorShare, 2),
                    'marketConcentration' => $marketConcentration,
                    'competitorCount' => $request->competitorCount
                ],
                'growthMetrics' => [
                    'marketGrowthImpact' => round($marketGrowthImpact, 2),
                    'projectedMarketShare' => round($projectedMarketShare, 2),
                    'shareGrowthRate' => round($shareGrowthRate, 2),
                    'marketPenetration' => round($marketPenetration, 2)
                ],
                'marketingEfficiency' => [
                    'marketingROI' => round($marketingROI, 2),
                    'customerAcquisitionCost' => $request->customerAcquisitionCost,
                    'customerLifetimeValue' => $request->customerLifetimeValue,
                    'clvCacRatio' => $clvCacRatio ? round($clvCacRatio, 2) : null
                ],
                'recommendations' => $recommendations
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error calculating market share: ' . $e->getMessage()
            ], 500);
        }
    }

    private function determineMarketConcentration($hhi)
    {
        if (!$hhi) return 'Unknown';
        if ($hhi < 1500) return 'Unconcentrated';
        if ($hhi < 2500) return 'Moderately Concentrated';
        return 'Highly Concentrated';
    }

    private function determineCompetitivePosition($marketShare, $avgShare)
    {
        if ($marketShare >= $avgShare * 2) return 'Market Leader';
        if ($marketShare >= $avgShare * 1.5) return 'Strong Competitor';
        if ($marketShare >= $avgShare * 0.75) return 'Challenger';
        return 'Small Player';
    }

    private function generateMarketShareRecommendations($position, $growthRate, $clvCacRatio, $concentration, $segment, $penetration)
    {
        $recommendations = [];

        // Position-based recommendations
        switch ($position) {
            case 'Market Leader':
                $recommendations[] = 'Focus on defending market share through innovation';
                $recommendations[] = 'Consider market expansion opportunities';
                $recommendations[] = 'Monitor competitive threats actively';
                break;
            case 'Strong Competitor':
                $recommendations[] = 'Target specific market segments for leadership';
                $recommendations[] = 'Invest in competitive advantages';
                $recommendations[] = 'Consider strategic acquisitions';
                break;
            case 'Challenger':
                $recommendations[] = 'Focus on differentiation strategy';
                $recommendations[] = 'Identify and exploit market leader weaknesses';
                $recommendations[] = 'Invest in niche market opportunities';
                break;
            case 'Small Player':
                $recommendations[] = 'Consider niche market focus';
                $recommendations[] = 'Improve operational efficiency';
                $recommendations[] = 'Evaluate strategic partnerships';
                break;
        }

        // Growth-based recommendations
        if ($growthRate < 0) {
            $recommendations[] = 'Develop market share recovery strategy';
            $recommendations[] = 'Review competitive positioning';
        } elseif ($growthRate > 20) {
            $recommendations[] = 'Prepare scaling strategy';
            $recommendations[] = 'Secure resources for growth';
        }

        // CLV/CAC-based recommendations
        if ($clvCacRatio !== null) {
            if ($clvCacRatio < 3) {
                $recommendations[] = 'Optimize customer acquisition costs';
                $recommendations[] = 'Enhance customer retention programs';
            } else {
                $recommendations[] = 'Scale customer acquisition efforts';
            }
        }

        // Market concentration recommendations
        if ($concentration === 'Highly Concentrated') {
            $recommendations[] = 'Focus on differentiation strategy';
            $recommendations[] = 'Consider regulatory implications';
        }

        // Segment-specific recommendations
        switch ($segment) {
            case 'premium':
                $recommendations[] = 'Focus on brand value and quality';
                $recommendations[] = 'Invest in premium customer experience';
                break;
            case 'midrange':
                $recommendations[] = 'Balance value and quality positioning';
                $recommendations[] = 'Focus on operational efficiency';
                break;
            case 'budget':
                $recommendations[] = 'Optimize cost structure';
                $recommendations[] = 'Focus on volume and efficiency';
                break;
        }

        // Penetration-based recommendations
        if ($penetration < 10) {
            $recommendations[] = 'Focus on market penetration strategies';
            $recommendations[] = 'Invest in brand awareness';
        }

        return array_slice($recommendations, 0, 5); // Return top 5 recommendations
    }

    /**
     * Display the Working Capital Calculator view
     */
    public function workingCapitalCalculator()
    {
        return view('frontend.finance.working_capital_calculator');
    }

    /**
     * Calculate working capital metrics based on form submission
     */
    public function calculateWorkingCapital(Request $request)
    {
        $request->validate([
            'cashAndEquivalents' => 'required|numeric|min:0',
            'accountsReceivable' => 'required|numeric|min:0',
            'inventory' => 'required|numeric|min:0',
            'otherCurrentAssets' => 'nullable|numeric|min:0',
            'accountsPayable' => 'required|numeric|min:0',
            'shortTermDebt' => 'required|numeric|min:0',
            'accruedExpenses' => 'nullable|numeric|min:0',
            'otherCurrentLiabilities' => 'nullable|numeric|min:0',
            'annualRevenue' => 'required|numeric|min:0',
            'costOfGoodsSold' => 'required|numeric|min:0'
        ]);

        // Calculate total current assets
        $totalCurrentAssets = $request->cashAndEquivalents + 
                            $request->accountsReceivable + 
                            $request->inventory + 
                            ($request->otherCurrentAssets ?? 0);

        // Calculate total current liabilities
        $totalCurrentLiabilities = $request->accountsPayable + 
                                 $request->shortTermDebt + 
                                 ($request->accruedExpenses ?? 0) + 
                                 ($request->otherCurrentLiabilities ?? 0);

        // Calculate working capital
        $workingCapital = $totalCurrentAssets - $totalCurrentLiabilities;

        // Calculate ratios
        $currentRatio = $totalCurrentAssets / $totalCurrentLiabilities;
        $quickRatio = ($request->cashAndEquivalents + $request->accountsReceivable) / $totalCurrentLiabilities;
        $cashRatio = $request->cashAndEquivalents / $totalCurrentLiabilities;
        $workingCapitalRatio = $workingCapital / $request->annualRevenue;

        // Calculate cash conversion cycle components (in days)
        $daysInventoryOutstanding = ($request->inventory / $request->costOfGoodsSold) * 365;
        $daysSalesOutstanding = ($request->accountsReceivable / $request->annualRevenue) * 365;
        $daysPayablesOutstanding = ($request->accountsPayable / $request->costOfGoodsSold) * 365;

        // Calculate cash conversion cycle
        $cashConversionCycle = $daysInventoryOutstanding + $daysSalesOutstanding - $daysPayablesOutstanding;

        // Determine liquidity status
        $liquidityStatus = 'Excellent';
        if ($currentRatio < 1.5) {
            $liquidityStatus = 'Poor';
        } elseif ($currentRatio < 2) {
            $liquidityStatus = 'Fair';
        } elseif ($currentRatio < 2.5) {
            $liquidityStatus = 'Good';
        }

        return response()->json([
            'workingCapital' => round($workingCapital, 2),
            'currentRatio' => round($currentRatio, 2),
            'quickRatio' => round($quickRatio, 2),
            'cashRatio' => round($cashRatio, 2),
            'workingCapitalRatio' => round($workingCapitalRatio, 2),
            'cashConversionCycle' => round($cashConversionCycle, 1),
            'liquidityStatus' => $liquidityStatus
        ]);
    }

    /**
     * Display the Debt vs. Equity Calculator view
     */
    public function debtEquityCalculator()
    {
        return view('frontend.finance.debt_equity_calculator');
    }

    /**
     * Calculate debt vs. equity metrics based on form submission
     */
    public function calculateDebtEquity(Request $request)
    {
        $request->validate([
            'debtAmount' => 'required|numeric|min:0',
            'interestRate' => 'required|numeric|min:0|max:100',
            'debtTerm' => 'required|numeric|min:1',
            'taxRate' => 'required|numeric|min:0|max:100',
            'equityAmount' => 'required|numeric|min:0',
            'expectedReturn' => 'required|numeric|min:0|max:100',
            'dividendRate' => 'required|numeric|min:0|max:100',
            'growthRate' => 'required|numeric|min:0|max:100',
            'debtIssuanceCosts' => 'nullable|numeric|min:0',
            'equityIssuanceCosts' => 'nullable|numeric|min:0'
        ]);

        // Calculate total capital
        $totalCapital = $request->debtAmount + $request->equityAmount;

        // Calculate weights
        $debtWeight = ($request->debtAmount / $totalCapital) * 100;
        $equityWeight = ($request->equityAmount / $totalCapital) * 100;

        // Calculate cost of debt (after tax)
        $costOfDebt = $request->interestRate * (1 - ($request->taxRate / 100));

        // Calculate cost of equity using Gordon Growth Model
        $costOfEquity = ($request->dividendRate / 100) + ($request->growthRate / 100);

        // Calculate WACC
        $wacc = ($debtWeight / 100 * $costOfDebt) + ($equityWeight / 100 * $costOfEquity);

        // Calculate annual interest payment
        $annualInterest = $request->debtAmount * ($request->interestRate / 100);

        // Determine capital structure recommendation
        $recommendation = 'Balanced Capital Structure';
        if ($debtWeight > 70) {
            $recommendation = 'High Leverage - Consider Reducing Debt';
        } elseif ($debtWeight < 30) {
            $recommendation = 'Conservative Structure - Consider Leveraging';
        } elseif ($wacc > 15) {
            $recommendation = 'High Cost of Capital - Optimize Structure';
        }

        return response()->json([
            'costOfDebt' => round($costOfDebt, 2),
            'costOfEquity' => round($costOfEquity * 100, 2),
            'debtWeight' => round($debtWeight, 2),
            'equityWeight' => round($equityWeight, 2),
            'wacc' => round($wacc, 2),
            'annualInterest' => round($annualInterest, 2),
            'recommendation' => $recommendation
        ]);
    }

    /**
     * Display the Currency Hedging Calculator view
     */
    public function currencyHedgingCalculator()
    {
        return view('frontend.finance.currency_hedging_calculator');
    }

    /**
     * Calculate currency hedging metrics based on form submission
     */
    public function calculateCurrencyHedging(Request $request)
    {
        $request->validate([
            'transactionAmount' => 'required|numeric|min:0',
            'transactionDate' => 'required|date',
            'settlementDate' => 'required|date|after:transactionDate',
            'currencyPair' => 'required|string',
            'spotRate' => 'required|numeric|min:0',
            'forwardRate' => 'required|numeric|min:0',
            'baseInterestRate' => 'required|numeric|min:0|max:100',
            'quoteInterestRate' => 'required|numeric|min:0|max:100',
            'hedgingType' => 'required|in:forward,option,swap',
            'strikePrice' => 'required_if:hedgingType,option|numeric|min:0',
            'optionPremium' => 'required_if:hedgingType,option|numeric|min:0|max:100',
            'swapRate' => 'required_if:hedgingType,swap|numeric|min:0|max:100'
        ]);

        // Calculate days to settlement
        $transactionDate = new DateTime($request->transactionDate);
        $settlementDate = new DateTime($request->settlementDate);
        $daysToSettlement = $transactionDate->diff($settlementDate)->days;

        // Calculate forward points
        $forwardPoints = $request->forwardRate - $request->spotRate;

        // Calculate interest rate differential
        $interestRateDifferential = $request->baseInterestRate - $request->quoteInterestRate;

        // Calculate hedging cost based on type
        $hedgingCost = 0;
        $effectiveRate = $request->spotRate;

        switch ($request->hedgingType) {
            case 'forward':
                $hedgingCost = $request->transactionAmount * ($request->forwardRate - $request->spotRate);
                $effectiveRate = $request->forwardRate;
                break;

            case 'option':
                $optionCost = $request->transactionAmount * ($request->optionPremium / 100);
                $hedgingCost = $optionCost;
                $effectiveRate = $request->strikePrice;
                break;

            case 'swap':
                $swapCost = $request->transactionAmount * ($request->swapRate / 100);
                $hedgingCost = $swapCost;
                $effectiveRate = $request->forwardRate;
                break;
        }

        // Calculate cost of hedging as percentage
        $costOfHedging = ($hedgingCost / $request->transactionAmount) * 100;

        // Determine hedging recommendation
        $hedgingRecommendation = 'Forward Contract Recommended';
        if ($costOfHedging > 2) {
            if ($request->hedgingType === 'forward') {
                $hedgingRecommendation = 'Consider Natural Hedging';
            } else {
                $hedgingRecommendation = 'Forward Contract May Be More Cost-Effective';
            }
        } elseif ($costOfHedging < 0.5) {
            $hedgingRecommendation = 'Current Hedging Strategy is Cost-Effective';
        }

        return response()->json([
            'daysToSettlement' => $daysToSettlement,
            'forwardPoints' => round($forwardPoints, 4),
            'interestRateDifferential' => round($interestRateDifferential, 2),
            'hedgingCost' => round($hedgingCost, 2),
            'effectiveRate' => round($effectiveRate, 4),
            'costOfHedging' => round($costOfHedging, 2),
            'hedgingRecommendation' => $hedgingRecommendation
        ]);
    }

    /**
     * Display the Tax Estimator view
     */
    public function taxEstimator()
    {
        return view('frontend.finance.tax_estimator');
    }

    /**
     * Calculate tax metrics based on form submission
     */
    public function calculateTax(Request $request)
    {
        $request->validate([
            'annualRevenue' => 'required|numeric|min:0',
            'operatingCosts' => 'required|numeric|min:0',
            'homeCountryTaxRate' => 'required|numeric|min:0|max:100',
            'foreignCountryTaxRate' => 'required|numeric|min:0|max:100',
            'foreignRevenue' => 'required|numeric|min:0',
            'foreignCosts' => 'required|numeric|min:0',
            'rdCredits' => 'nullable|numeric|min:0',
            'foreignTaxCredits' => 'nullable|numeric|min:0'
        ]);

        // Calculate domestic income and tax
        $domesticIncome = $request->annualRevenue - $request->operatingCosts;
        $domesticTax = $domesticIncome * ($request->homeCountryTaxRate / 100);

        // Calculate foreign income and tax
        $foreignIncome = $request->foreignRevenue - $request->foreignCosts;
        $foreignTax = $foreignIncome * ($request->foreignCountryTaxRate / 100);

        // Calculate total tax credits
        $totalTaxCredits = ($request->rdCredits ?? 0) + ($request->foreignTaxCredits ?? 0);

        // Calculate net tax liability
        $netTaxLiability = $domesticTax + $foreignTax - $totalTaxCredits;

        // Calculate effective tax rate
        $totalIncome = $domesticIncome + $foreignIncome;
        $effectiveTaxRate = ($totalIncome > 0) ? ($netTaxLiability / $totalIncome) * 100 : 0;

        // Determine tax optimization recommendation
        $taxRecommendation = 'Current Tax Structure is Optimal';
        if ($effectiveTaxRate > 30) {
            $taxRecommendation = 'Consider Tax Optimization Strategies';
        } elseif ($effectiveTaxRate < 15) {
            $taxRecommendation = 'Review Tax Compliance Requirements';
        }

        return response()->json([
            'domesticTax' => round($domesticTax, 2),
            'foreignTax' => round($foreignTax, 2),
            'totalTaxCredits' => round($totalTaxCredits, 2),
            'netTaxLiability' => round($netTaxLiability, 2),
            'effectiveTaxRate' => round($effectiveTaxRate, 2),
            'taxRecommendation' => $taxRecommendation
        ]);
    }
} 