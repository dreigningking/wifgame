<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('green_project_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Project Details
            $table->string('project_name');
            $table->string('project_type'); // Solar, Wind, Energy Efficiency, etc.
            $table->decimal('initial_investment', 15, 2);
            $table->integer('project_lifetime_years');
            // Environmental Impact
            $table->decimal('carbon_reduction_tons', 10, 2);
            $table->decimal('energy_savings_kwh', 15, 2);
            $table->decimal('water_savings_cubic_meters', 15, 2)->nullable();
            // Financial Metrics
            $table->decimal('annual_cost_savings', 15, 2);
            $table->decimal('maintenance_costs', 15, 2);
            $table->decimal('carbon_credit_value', 15, 2)->nullable();
            $table->decimal('tax_incentives', 15, 2)->nullable();
            // Results
            $table->decimal('result_npv', 15, 2);
            $table->decimal('result_irr', 5, 2);
            $table->decimal('result_payback_years', 5, 2);
            $table->decimal('result_carbon_roi', 5, 2);
            $table->json('environmental_benefits')->nullable();
            $table->json('financial_projections')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('green_project_calculations');
    }
}; 