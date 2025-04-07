<?php

namespace App\Models\Calculations;

use App\Models\BaseCalculation;

class MeetingCostCalculation extends BaseCalculation
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'meeting_name',
        'duration_minutes',
        'number_of_attendees',
        'attendee_costs',
        'facility_costs',
        'travel_costs',
        'preparation_time_hours',
        'followup_time_hours',
        'result_labor_cost',
        'result_total_cost',
        'result_cost_per_attendee',
        'result_opportunity_cost',
        'cost_breakdown',
        'productivity_metrics',
        'notes'
    ];

    protected $casts = [
        'attendee_costs' => 'array',
        'cost_breakdown' => 'array',
        'productivity_metrics' => 'array',
        'facility_costs' => 'decimal:2',
        'travel_costs' => 'decimal:2',
        'preparation_time_hours' => 'decimal:2',
        'followup_time_hours' => 'decimal:2',
        'result_labor_cost' => 'decimal:2',
        'result_total_cost' => 'decimal:2',
        'result_cost_per_attendee' => 'decimal:2',
        'result_opportunity_cost' => 'decimal:2'
    ];

    public function calculate(): array
    {
        // Meeting Cost calculation logic will be implemented here
        return [
            'labor_cost' => 0,
            'total_cost' => 0,
            'cost_per_attendee' => 0,
            'opportunity_cost' => 0
        ];
    }
} 