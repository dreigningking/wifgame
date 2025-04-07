<?php

namespace App\Models\Calculations;

use App\Models\BaseCalculation;

class CybersecurityInvestmentCalculation extends BaseCalculation
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'annual_revenue',
        'data_breach_probability',
        'estimated_breach_cost',
        'security_software_costs',
        'hardware_costs',
        'training_costs',
        'personnel_costs',
        'result_risk_reduction_percentage',
        'result_annual_savings',
        'result_roi_percentage',
        'result_payback_months',
        'risk_assessment_details',
        'compliance_requirements',
        'notes'
    ];

    protected $casts = [
        'risk_assessment_details' => 'array',
        'compliance_requirements' => 'array',
        'annual_revenue' => 'decimal:2',
        'data_breach_probability' => 'decimal:2',
        'estimated_breach_cost' => 'decimal:2',
        'security_software_costs' => 'decimal:2',
        'hardware_costs' => 'decimal:2',
        'training_costs' => 'decimal:2',
        'personnel_costs' => 'decimal:2',
        'result_risk_reduction_percentage' => 'decimal:2',
        'result_annual_savings' => 'decimal:2',
        'result_roi_percentage' => 'decimal:2'
    ];

    public function calculate(): array
    {
        // Cybersecurity Investment calculation logic will be implemented here
        return [
            'risk_reduction_percentage' => 0,
            'annual_savings' => 0,
            'roi_percentage' => 0,
            'payback_months' => 0
        ];
    }
} 