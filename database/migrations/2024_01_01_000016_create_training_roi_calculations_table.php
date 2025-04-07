<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('training_roi_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Training Costs
            $table->decimal('development_costs', 15, 2);
            $table->decimal('delivery_costs', 15, 2);
            $table->decimal('materials_costs', 15, 2);
            $table->decimal('facility_costs', 15, 2);
            $table->decimal('travel_costs', 15, 2);
            $table->integer('participant_count');
            $table->decimal('participant_hourly_rate', 10, 2);
            $table->integer('training_hours');
            // Benefits
            $table->decimal('productivity_improvement', 5, 2);
            $table->decimal('error_reduction', 5, 2);
            $table->decimal('employee_retention_impact', 15, 2);
            // Results
            $table->decimal('result_total_costs', 15, 2);
            $table->decimal('result_total_benefits', 15, 2);
            $table->decimal('result_net_benefit', 15, 2);
            $table->decimal('result_roi_percentage', 5, 2);
            $table->integer('result_payback_months');
            $table->json('benefit_metrics')->nullable();
            $table->json('participant_feedback')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_roi_calculations');
    }
}; 