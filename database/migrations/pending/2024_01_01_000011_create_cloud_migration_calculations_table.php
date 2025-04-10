<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cloud_migration_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Current Infrastructure Costs
            $table->decimal('current_hardware_costs', 15, 2);
            $table->decimal('current_software_costs', 15, 2);
            $table->decimal('current_maintenance_costs', 15, 2);
            $table->decimal('current_labor_costs', 15, 2);
            // Cloud Migration Costs
            $table->decimal('cloud_subscription_costs', 15, 2);
            $table->decimal('migration_labor_costs', 15, 2);
            $table->decimal('training_costs', 15, 2);
            $table->decimal('cloud_maintenance_costs', 15, 2);
            // Results
            $table->decimal('result_first_year_savings', 15, 2);
            $table->decimal('result_annual_savings', 15, 2);
            $table->decimal('result_roi_percentage', 5, 2);
            $table->integer('result_payback_months');
            $table->json('cost_breakdown')->nullable(); // Detailed cost analysis
            $table->json('savings_projection')->nullable(); // Multi-year projection
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cloud_migration_calculations');
    }
}; 