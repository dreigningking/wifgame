<?php

namespace App\Models\Calculations;

use App\Models\BaseCalculation;

class GreenProjectCalculation extends BaseCalculation
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'project_cost',
        'annual_energy_savings',
        'carbon_reduction',
        'maintenance_savings',
        'tax_incentives',
        'regulatory_compliance_savings',
        'project_lifetime',
        'discount_rate',
        'carbon_price',
        'result_npv',
        'result_irr',
        'result_payback_years',
        'result_carbon_roi',
        'environmental_benefits',
        'financial_projections',
        'notes'
    ];

    protected $casts = [
        'environmental_benefits' => 'array',
        'financial_projections' => 'array',
        'project_cost' => 'decimal:2',
        'annual_energy_savings' => 'decimal:2',
        'carbon_reduction' => 'decimal:2',
        'maintenance_savings' => 'decimal:2',
        'tax_incentives' => 'decimal:2',
        'regulatory_compliance_savings' => 'decimal:2',
        'discount_rate' => 'decimal:2',
        'carbon_price' => 'decimal:2',
        'result_npv' => 'decimal:2',
        'result_irr' => 'decimal:2',
        'result_payback_years' => 'decimal:2',
        'result_carbon_roi' => 'decimal:2'
    ];

    public function calculate(): array
    {
        // Green Project calculation logic will be implemented here
        return [
            'npv' => 0,
            'irr' => 0,
            'payback_years' => 0,
            'carbon_roi' => 0
        ];
    }
} 