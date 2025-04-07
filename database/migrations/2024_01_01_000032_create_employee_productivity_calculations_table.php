<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employee_productivity_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            
            // Revenue Metrics
            $table->decimal('total_revenue', 15, 2);
            $table->decimal('revenue_per_employee', 15, 2);
            $table->decimal('revenue_per_department', 15, 2)->nullable();
            
            // Employee Metrics
            $table->integer('total_employees');
            $table->integer('productive_hours_per_day');
            $table->integer('working_days_per_year');
            $table->decimal('average_salary', 15, 2);
            $table->decimal('benefits_cost', 15, 2);
            
            // Output Metrics
            $table->decimal('total_units_produced', 15, 2);
            $table->decimal('units_per_employee', 15, 2);
            $table->decimal('cost_per_unit', 15, 2);
            
            // Cost Metrics
            $table->decimal('total_labor_costs', 15, 2);
            $table->decimal('total_overhead_costs', 15, 2);
            $table->decimal('total_material_costs', 15, 2);
            
            // Productivity Metrics
            $table->decimal('labor_productivity', 15, 2);
            $table->decimal('capital_productivity', 15, 2);
            $table->decimal('total_factor_productivity', 15, 2);
            
            // Results
            $table->decimal('result_revenue_per_employee', 15, 2);
            $table->decimal('result_cost_per_unit', 15, 2);
            $table->decimal('result_profit_per_employee', 15, 2);
            $table->decimal('result_productivity_score', 5, 2);
            $table->json('department_breakdown')->nullable();
            $table->json('productivity_trends')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_productivity_calculations');
    }
}; 