<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('process_automation_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Current Process Costs
            $table->decimal('manual_labor_costs', 15, 2);
            $table->decimal('error_correction_costs', 15, 2);
            $table->decimal('processing_time_costs', 15, 2);
            $table->integer('current_process_hours');
            // Automation Costs
            $table->decimal('software_costs', 15, 2);
            $table->decimal('implementation_costs', 15, 2);
            $table->decimal('training_costs', 15, 2);
            $table->decimal('maintenance_costs', 15, 2);
            // Results
            $table->decimal('result_time_savings_hours', 8, 2);
            $table->decimal('result_cost_savings', 15, 2);
            $table->decimal('result_productivity_gain', 5, 2);
            $table->decimal('result_roi_percentage', 5, 2);
            $table->integer('result_payback_months');
            $table->json('process_metrics')->nullable();
            $table->json('efficiency_gains')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('process_automation_calculations');
    }
}; 