<?php

namespace App\Models\Calculations;

use App\Models\BaseCalculation;

class RoiCalculation extends BaseCalculation
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'initial_investment',
        'cash_flows',
        'time_period',
        'discount_rate',
        'industry',
        'industry_benchmark',
        'risk_factor',
        'additional_costs',
        'result_roi',
        'result_npv',
        'risk_adjusted_roi',
        'payback_period',
        'notes'
    ];

    protected $casts = [
        'cash_flows' => 'array',
        'additional_costs' => 'array',
        'initial_investment' => 'decimal:2',
        'discount_rate' => 'decimal:2',
        'industry_benchmark' => 'decimal:2',
        'result_roi' => 'decimal:2',
        'result_npv' => 'decimal:2',
        'risk_adjusted_roi' => 'decimal:2',
        'payback_period' => 'decimal:2'
    ];

    public function calculate(): array
    {
        // Calculate total additional costs
        $totalAdditionalCosts = 0;
        foreach ($this->additional_costs as $cost) {
            $totalAdditionalCosts += $cost['value'];
        }

        // Calculate total investment
        $totalInvestment = $this->initial_investment + $totalAdditionalCosts;

        // Calculate total returns from cash flows
        $totalReturns = array_sum($this->cash_flows);

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
        $riskAdjustedROI = $roi * $riskAdjustment[$this->risk_factor];

        // Calculate payback period
        $annualCashFlow = $totalReturns / $this->time_period;
        $paybackPeriod = $totalInvestment / $annualCashFlow;

        return [
            'roi' => $roi,
            'npv' => $this->calculateNPV(),
            'risk_adjusted_roi' => $riskAdjustedROI,
            'payback_period' => $paybackPeriod
        ];
    }

    private function calculateNPV(): float
    {
        $npv = -$this->initial_investment;
        $discountRate = $this->discount_rate / 100;

        foreach ($this->cash_flows as $year => $cashFlow) {
            $npv += $cashFlow / pow(1 + $discountRate, $year + 1);
        }

        return $npv;
    }
} 