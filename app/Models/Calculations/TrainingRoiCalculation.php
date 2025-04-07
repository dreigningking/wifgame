<?php

namespace App\Models\Calculations;

use App\Models\BaseCalculation;

class TrainingRoiCalculation extends BaseCalculation
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'development_costs',
        'delivery_costs',
        'materials_costs',
        'facility_costs',
        'travel_costs',
        'participant_count',
        'participant_hourly_rate',
        'training_hours',
        'productivity_improvement',
        'error_reduction',
        'employee_retention_impact',
        'result_total_costs',
        'result_total_benefits',
        'result_net_benefit',
        'result_roi_percentage',
        'result_payback_months',
        'benefit_metrics',
        'participant_feedback',
        'notes'
    ];

    protected $casts = [
        'benefit_metrics' => 'array',
        'participant_feedback' => 'array',
        'development_costs' => 'decimal:2',
        'delivery_costs' => 'decimal:2',
        'materials_costs' => 'decimal:2',
        'facility_costs' => 'decimal:2',
        'travel_costs' => 'decimal:2',
        'participant_hourly_rate' => 'decimal:2',
        'productivity_improvement' => 'decimal:2',
        'error_reduction' => 'decimal:2',
        'employee_retention_impact' => 'decimal:2',
        'result_total_costs' => 'decimal:2',
        'result_total_benefits' => 'decimal:2',
        'result_net_benefit' => 'decimal:2',
        'result_roi_percentage' => 'decimal:2'
    ];

    public function calculate(): array
    {
        // Training ROI calculation logic will be implemented here
        return [
            'total_costs' => 0,
            'total_benefits' => 0,
            'net_benefit' => 0,
            'roi_percentage' => 0,
            'payback_months' => 0
        ];
    }
} 