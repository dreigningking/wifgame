<?php

namespace App\Models\Calculations;

use App\Models\BaseCalculation;

class TimeManagementCalculation extends BaseCalculation
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'total_work_hours',
        'activity_breakdown',
        'hourly_rate',
        'current_productivity_score',
        'target_productivity_score',
        'time_wasters',
        'tool_implementation_cost',
        'training_cost',
        'expected_hours_saved',
        'result_potential_savings',
        'result_productivity_gain',
        'result_roi_percentage',
        'result_payback_days',
        'time_allocation_analysis',
        'improvement_recommendations',
        'notes'
    ];

    protected $casts = [
        'activity_breakdown' => 'array',
        'time_wasters' => 'array',
        'time_allocation_analysis' => 'array',
        'improvement_recommendations' => 'array',
        'hourly_rate' => 'decimal:2',
        'current_productivity_score' => 'decimal:2',
        'target_productivity_score' => 'decimal:2',
        'tool_implementation_cost' => 'decimal:2',
        'training_cost' => 'decimal:2',
        'result_potential_savings' => 'decimal:2',
        'result_productivity_gain' => 'decimal:2',
        'result_roi_percentage' => 'decimal:2'
    ];

    public function calculate(): array
    {
        // Time Management calculation logic will be implemented here
        return [
            'potential_savings' => 0,
            'productivity_gain' => 0,
            'roi_percentage' => 0,
            'payback_days' => 0
        ];
    }
} 