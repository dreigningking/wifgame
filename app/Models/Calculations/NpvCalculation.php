<?php

namespace App\Models\Calculations;

use App\Models\BaseCalculation;

class NpvCalculation extends BaseCalculation
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'initial_investment',
        'cash_flows',
        'discount_rate',
        'time_period',
        'result_npv',
        'result_irr',
        'result_payback_period',
        'sensitivity_analysis',
        'notes'
    ];

    protected $casts = [
        'cash_flows' => 'array',
        'sensitivity_analysis' => 'array',
        'initial_investment' => 'decimal:2',
        'discount_rate' => 'decimal:2',
        'result_npv' => 'decimal:2',
        'result_irr' => 'decimal:2',
        'result_payback_period' => 'decimal:2'
    ];

    public function calculate(): array
    {
        // NPV calculation logic will be implemented here
        return [
            'npv' => 0,
            'irr' => 0,
            'payback_period' => 0
        ];
    }
} 