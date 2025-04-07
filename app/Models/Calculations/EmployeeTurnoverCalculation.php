<?php

namespace App\Models\Calculations;

use App\Models\BaseCalculation;

class EmployeeTurnoverCalculation extends BaseCalculation
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'annual_salary',
        'benefits_cost',
        'recruitment_cost',
        'training_cost',
        'productivity_loss_days',
        'daily_productivity_value',
        'administrative_cost',
        'result_total_cost',
        'result_percentage_annual_salary',
        'additional_costs',
        'notes'
    ];

    protected $casts = [
        'additional_costs' => 'array',
        'annual_salary' => 'decimal:2',
        'benefits_cost' => 'decimal:2',
        'recruitment_cost' => 'decimal:2',
        'training_cost' => 'decimal:2',
        'daily_productivity_value' => 'decimal:2',
        'administrative_cost' => 'decimal:2',
        'result_total_cost' => 'decimal:2',
        'result_percentage_annual_salary' => 'decimal:2'
    ];

    public function calculate(): array
    {
        // Employee Turnover calculation logic will be implemented here
        return [
            'total_cost' => 0,
            'percentage_annual_salary' => 0
        ];
    }
} 