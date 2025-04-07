<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeProductivityCalculation extends Model
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'total_revenue',
        'revenue_per_employee',
        'revenue_per_department',
        'total_employees',
        'productive_hours_per_day',
        'working_days_per_year',
        'average_salary',
        'benefits_cost',
        'total_units_produced',
        'units_per_employee',
        'cost_per_unit',
        'total_labor_costs',
        'total_overhead_costs',
        'total_material_costs',
        'labor_productivity',
        'capital_productivity',
        'total_factor_productivity',
        'result_revenue_per_employee',
        'result_cost_per_unit',
        'result_profit_per_employee',
        'result_productivity_score',
        'department_breakdown',
        'productivity_trends',
        'notes'
    ];

    protected $casts = [
        'department_breakdown' => 'array',
        'productivity_trends' => 'array',
        'total_revenue' => 'decimal:2',
        'revenue_per_employee' => 'decimal:2',
        'revenue_per_department' => 'decimal:2',
        'average_salary' => 'decimal:2',
        'benefits_cost' => 'decimal:2',
        'total_units_produced' => 'decimal:2',
        'units_per_employee' => 'decimal:2',
        'cost_per_unit' => 'decimal:2',
        'total_labor_costs' => 'decimal:2',
        'total_overhead_costs' => 'decimal:2',
        'total_material_costs' => 'decimal:2',
        'labor_productivity' => 'decimal:2',
        'capital_productivity' => 'decimal:2',
        'total_factor_productivity' => 'decimal:2',
        'result_revenue_per_employee' => 'decimal:2',
        'result_cost_per_unit' => 'decimal:2',
        'result_profit_per_employee' => 'decimal:2',
        'result_productivity_score' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function calculator(): BelongsTo
    {
        return $this->belongsTo(Calculator::class);
    }
} 