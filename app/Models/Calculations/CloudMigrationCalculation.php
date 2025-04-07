<?php

namespace App\Models\Calculations;

use App\Models\BaseCalculation;

class CloudMigrationCalculation extends BaseCalculation
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'current_hardware_costs',
        'current_software_costs',
        'current_maintenance_costs',
        'current_labor_costs',
        'cloud_subscription_costs',
        'migration_labor_costs',
        'training_costs',
        'cloud_maintenance_costs',
        'result_first_year_savings',
        'result_annual_savings',
        'result_roi_percentage',
        'result_payback_months',
        'cost_breakdown',
        'savings_projection',
        'notes'
    ];

    protected $casts = [
        'cost_breakdown' => 'array',
        'savings_projection' => 'array',
        'current_hardware_costs' => 'decimal:2',
        'current_software_costs' => 'decimal:2',
        'current_maintenance_costs' => 'decimal:2',
        'current_labor_costs' => 'decimal:2',
        'cloud_subscription_costs' => 'decimal:2',
        'migration_labor_costs' => 'decimal:2',
        'training_costs' => 'decimal:2',
        'cloud_maintenance_costs' => 'decimal:2',
        'result_first_year_savings' => 'decimal:2',
        'result_annual_savings' => 'decimal:2',
        'result_roi_percentage' => 'decimal:2'
    ];

    public function calculate(): array
    {
        // Cloud Migration calculation logic will be implemented here
        return [
            'first_year_savings' => 0,
            'annual_savings' => 0,
            'roi_percentage' => 0,
            'payback_months' => 0
        ];
    }
} 