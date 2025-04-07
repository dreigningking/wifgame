<?php

namespace App\Models\Calculations;

use App\Models\BaseCalculation;

class SoftwareTcoCalculation extends BaseCalculation
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'license_cost',
        'implementation_cost',
        'hardware_cost',
        'maintenance_annual',
        'training_cost',
        'support_cost',
        'integration_cost',
        'customization_cost',
        'data_migration_cost',
        'result_first_year_cost',
        'result_annual_cost',
        'result_total_tco',
        'result_cost_per_user',
        'cost_breakdown',
        'annual_projection',
        'notes'
    ];

    protected $casts = [
        'cost_breakdown' => 'array',
        'annual_projection' => 'array',
        'license_cost' => 'decimal:2',
        'implementation_cost' => 'decimal:2',
        'hardware_cost' => 'decimal:2',
        'maintenance_annual' => 'decimal:2',
        'training_cost' => 'decimal:2',
        'support_cost' => 'decimal:2',
        'integration_cost' => 'decimal:2',
        'customization_cost' => 'decimal:2',
        'data_migration_cost' => 'decimal:2',
        'result_first_year_cost' => 'decimal:2',
        'result_annual_cost' => 'decimal:2',
        'result_total_tco' => 'decimal:2',
        'result_cost_per_user' => 'decimal:2'
    ];

    public function calculate(): array
    {
        // Software TCO calculation logic will be implemented here
        return [
            'first_year_cost' => 0,
            'annual_cost' => 0,
            'total_tco' => 0,
            'cost_per_user' => 0
        ];
    }
} 