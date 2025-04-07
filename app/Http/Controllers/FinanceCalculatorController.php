<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use App\Models\ROICalculation;

class FinanceCalculatorController extends Controller
{
    /**
     * Display the ROI Calculator view
     */
    public function roiCalculator()
    {
        return view('finance.roi_calculator');
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
        $calculation = ROICalculation::create([
            'user_id' => auth()->id(),
            'calculator_id' => 1, // Replace with actual calculator ID
            'initial_investment' => $request->initialInvestment,
            'investment_period' => $request->investmentPeriod,
            'annual_returns' => $request->annualReturns,
            'industry' => $request->industry,
            'industry_benchmark' => $request->industryBenchmark,
            'risk_factor' => $request->riskFactor,
            'additional_costs' => $request->additionalCosts,
            'total_investment' => $totalInvestment,
            'total_returns' => $totalReturns,
            'net_profit' => $netProfit,
            'roi' => $roi,
            'risk_adjusted_roi' => $riskAdjustedROI,
            'payback_period' => $paybackPeriod
        ]);

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
        return view('finance.npv_calculator');
    }

    /**
     * Calculate NPV and IRR based on form submission
     */
    public function calculateNPV(Request $request)
    {
        $request->validate([
            'initialInvestment' => 'required|numeric|min:0',
            'discountRate' => 'required|numeric|min:0|max:100',
            'cashFlows' => 'required|array|min:1',
            'cashFlows.*' => 'required|numeric'
        ]);

        $initialInvestment = $request->initialInvestment;
        $discountRate = $request->discountRate / 100;
        $cashFlows = $request->cashFlows;
        
        // Calculate NPV
        $npv = -$initialInvestment;
        $totalCashFlows = 0;
        $cumulativeCashFlow = -$initialInvestment;
        $paybackPeriod = 0;
        $foundPayback = false;

        foreach ($cashFlows as $year => $cashFlow) {
            $discountedCashFlow = $cashFlow / pow(1 + $discountRate, $year + 1);
            $npv += $discountedCashFlow;
            $totalCashFlows += $cashFlow;
            
            // Calculate payback period
            if (!$foundPayback) {
                $cumulativeCashFlow += $cashFlow;
                if ($cumulativeCashFlow >= 0) {
                    $paybackPeriod = $year + 1;
                    $foundPayback = true;
                }
            }
        }

        // Calculate IRR using Newton-Raphson method
        $irr = $this->calculateIRR($initialInvestment, $cashFlows);

        // Determine investment decision
        $investmentDecision = $npv >= 0 ? 'Accept' : 'Reject';

        return response()->json([
            'npv' => round($npv, 2),
            'irr' => round($irr * 100, 2),
            'paybackPeriod' => round($paybackPeriod, 1),
            'totalInvestment' => round($initialInvestment, 2),
            'totalCashFlows' => round($totalCashFlows, 2),
            'investmentDecision' => $investmentDecision
        ]);
    }

    /**
     * Calculate IRR using Newton-Raphson method
     */
    private function calculateIRR($initialInvestment, $cashFlows, $tolerance = 0.0001, $maxIterations = 100)
    {
        $guess = 0.1; // Initial guess of 10%
        $iteration = 0;

        while ($iteration < $maxIterations) {
            $npv = -$initialInvestment;
            $derivative = 0;

            foreach ($cashFlows as $year => $cashFlow) {
                $npv += $cashFlow / pow(1 + $guess, $year + 1);
                $derivative -= ($year + 1) * $cashFlow / pow(1 + $guess, $year + 2);
            }

            $newGuess = $guess - $npv / $derivative;

            if (abs($newGuess - $guess) < $tolerance) {
                return $newGuess;
            }

            $guess = $newGuess;
            $iteration++;
        }

        return $guess; // Return best guess if convergence not reached
    }

    /**
     * Display the Breakeven Analysis view
     */
    public function breakevenCalculator()
    {
        return view('finance.breakeven_analysis');
    }

    /**
     * Calculate Breakeven Point based on form submission
     */
    public function calculateBreakeven(Request $request)
    {
        $request->validate([
            'fixedCosts' => 'required|numeric|min:0',
            'variableCosts' => 'required|numeric|min:0',
            'salesPrice' => 'required|numeric|min:0',
            'targetProfit' => 'nullable|numeric|min:0'
        ]);

        $fixedCosts = $request->fixedCosts;
        $variableCosts = $request->variableCosts;
        $salesPrice = $request->salesPrice;
        $targetProfit = $request->targetProfit;

        // Calculate contribution margin
        $contributionMargin = (($salesPrice - $variableCosts) / $salesPrice) * 100;

        // Calculate breakeven point in units
        $breakevenUnits = $fixedCosts / ($salesPrice - $variableCosts);

        // Calculate breakeven point in revenue
        $breakevenRevenue = $breakevenUnits * $salesPrice;

        // Calculate target profit points if provided
        $targetProfitUnits = null;
        $targetProfitRevenue = null;
        if ($targetProfit) {
            $targetProfitUnits = ($fixedCosts + $targetProfit) / ($salesPrice - $variableCosts);
            $targetProfitRevenue = $targetProfitUnits * $salesPrice;
        }

        // Calculate margin of safety (assuming current sales at breakeven point)
        $marginOfSafety = 0; // This would be calculated based on actual current sales

        return response()->json([
            'breakevenUnits' => round($breakevenUnits, 2),
            'breakevenRevenue' => round($breakevenRevenue, 2),
            'contributionMargin' => round($contributionMargin, 2),
            'targetProfitUnits' => $targetProfitUnits ? round($targetProfitUnits, 2) : null,
            'targetProfitRevenue' => $targetProfitRevenue ? round($targetProfitRevenue, 2) : null,
            'marginOfSafety' => round($marginOfSafety, 2)
        ]);
    }

    /**
     * Display the Scenario Planner view
     */
    public function scenarioPlanner()
    {
        return view('finance.scenario_planner');
    }

    /**
     * Calculate scenarios based on form submission
     */
    public function calculateScenarios(Request $request)
    {
        $request->validate([
            'baseRevenue' => 'required|numeric|min:0',
            'baseCosts' => 'required|numeric|min:0',
            'optimisticRevenueGrowth' => 'required|numeric|min:0|max:100',
            'optimisticCostReduction' => 'required|numeric|min:0|max:100',
            'optimisticProbability' => 'required|numeric|min:0|max:100',
            'pessimisticRevenueDecline' => 'required|numeric|min:0|max:100',
            'pessimisticCostIncrease' => 'required|numeric|min:0|max:100',
            'pessimisticProbability' => 'required|numeric|min:0|max:100',
            'timePeriod' => 'required|numeric|min:1',
            'discountRate' => 'nullable|numeric|min:0|max:100'
        ]);

        // Calculate base scenario profit
        $baseProfit = $request->baseRevenue - $request->baseCosts;

        // Calculate optimistic scenario
        $optimisticRevenue = $request->baseRevenue * (1 + ($request->optimisticRevenueGrowth / 100));
        $optimisticCosts = $request->baseCosts * (1 - ($request->optimisticCostReduction / 100));
        $optimisticProfit = $optimisticRevenue - $optimisticCosts;

        // Calculate pessimistic scenario
        $pessimisticRevenue = $request->baseRevenue * (1 - ($request->pessimisticRevenueDecline / 100));
        $pessimisticCosts = $request->baseCosts * (1 + ($request->pessimisticCostIncrease / 100));
        $pessimisticProfit = $pessimisticRevenue - $pessimisticCosts;

        // Calculate probabilities (ensure they sum to 100%)
        $optimisticProbability = $request->optimisticProbability / 100;
        $pessimisticProbability = $request->pessimisticProbability / 100;
        $baseProbability = 1 - $optimisticProbability - $pessimisticProbability;

        // Apply time period and discount rate if provided
        $discountRate = ($request->discountRate ?? 0) / 100;
        $timePeriod = $request->timePeriod;

        if ($discountRate > 0) {
            $baseProfit = $baseProfit / pow(1 + $discountRate, $timePeriod);
            $optimisticProfit = $optimisticProfit / pow(1 + $discountRate, $timePeriod);
            $pessimisticProfit = $pessimisticProfit / pow(1 + $discountRate, $timePeriod);
        }

        // Calculate expected value
        $expectedValue = ($baseProfit * $baseProbability) +
                        ($optimisticProfit * $optimisticProbability) +
                        ($pessimisticProfit * $pessimisticProbability);

        // Calculate risk metrics
        $bestCase = max($baseProfit, $optimisticProfit, $pessimisticProfit);
        $worstCase = min($baseProfit, $optimisticProfit, $pessimisticProfit);
        $range = $bestCase - $worstCase;

        // Determine risk level
        $riskLevel = 'Low';
        if ($range > $expectedValue * 0.5) {
            $riskLevel = 'High';
        } elseif ($range > $expectedValue * 0.25) {
            $riskLevel = 'Medium';
        }

        return response()->json([
            'baseProfit' => round($baseProfit, 2),
            'optimisticProfit' => round($optimisticProfit, 2),
            'pessimisticProfit' => round($pessimisticProfit, 2),
            'expectedValue' => round($expectedValue, 2),
            'bestCase' => round($bestCase, 2),
            'worstCase' => round($worstCase, 2),
            'range' => round($range, 2),
            'riskLevel' => $riskLevel
        ]);
    }

    /**
     * Display the Market Share Calculator view
     */
    public function marketShareCalculator()
    {
        return view('finance.market_share_calculator');
    }

    /**
     * Calculate market share based on form submission
     */
    public function calculateMarketShare(Request $request)
    {
        $request->validate([
            'companyRevenue' => 'required|numeric|min:0',
            'companyUnits' => 'required|numeric|min:0',
            'marketRevenue' => 'required|numeric|min:0',
            'marketUnits' => 'required|numeric|min:0',
            'competitorCount' => 'required|numeric|min:1',
            'marketGrowthRate' => 'required|numeric|min:0|max:100',
            'marketingBudget' => 'required|numeric|min:0',
            'expectedGrowth' => 'required|numeric|min:0|max:100'
        ]);

        // Calculate revenue market share
        $revenueMarketShare = ($request->companyRevenue / $request->marketRevenue) * 100;

        // Calculate unit market share
        $unitMarketShare = ($request->companyUnits / $request->marketUnits) * 100;

        // Calculate average market share per competitor
        $avgCompetitorShare = 100 / $request->competitorCount;

        // Calculate market growth impact
        $marketGrowthImpact = $request->marketRevenue * ($request->marketGrowthRate / 100);

        // Calculate marketing ROI
        $marketingROI = ($request->expectedGrowth / ($request->marketingBudget / $request->companyRevenue)) * 100;

        // Calculate projected market share
        $projectedMarketShare = $revenueMarketShare * (1 + ($request->expectedGrowth / 100));

        // Determine market position
        $marketPosition = 'Market Leader';
        if ($revenueMarketShare < $avgCompetitorShare * 0.5) {
            $marketPosition = 'Small Player';
        } elseif ($revenueMarketShare < $avgCompetitorShare) {
            $marketPosition = 'Challenger';
        } elseif ($revenueMarketShare < $avgCompetitorShare * 1.5) {
            $marketPosition = 'Strong Competitor';
        }

        return response()->json([
            'revenueMarketShare' => round($revenueMarketShare, 2),
            'unitMarketShare' => round($unitMarketShare, 2),
            'avgCompetitorShare' => round($avgCompetitorShare, 2),
            'marketGrowthImpact' => round($marketGrowthImpact, 2),
            'marketingROI' => round($marketingROI, 2),
            'projectedMarketShare' => round($projectedMarketShare, 2),
            'marketPosition' => $marketPosition
        ]);
    }

    /**
     * Display the Working Capital Calculator view
     */
    public function workingCapitalCalculator()
    {
        return view('finance.working_capital_calculator');
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
        return view('finance.debt_equity_calculator');
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
        return view('finance.currency_hedging_calculator');
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
        return view('finance.tax_estimator');
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