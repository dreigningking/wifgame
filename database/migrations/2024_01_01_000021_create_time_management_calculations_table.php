<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('time_management_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Time Analysis
            $table->integer('total_work_hours');
            $table->json('activity_breakdown'); // Array of {activity, hours, value_rating}
            $table->decimal('hourly_rate', 10, 2);
            // Productivity Metrics
            $table->decimal('current_productivity_score', 5, 2);
            $table->decimal('target_productivity_score', 5, 2);
            $table->json('time_wasters'); // Array of {activity, hours_lost, cost}
            // Improvement Measures
            $table->decimal('tool_implementation_cost', 15, 2)->nullable();
            $table->decimal('training_cost', 15, 2)->nullable();
            $table->integer('expected_hours_saved');
            // Results
            $table->decimal('result_potential_savings', 15, 2);
            $table->decimal('result_productivity_gain', 5, 2);
            $table->decimal('result_roi_percentage', 5, 2);
            $table->integer('result_payback_days');
            $table->json('time_allocation_analysis')->nullable();
            $table->json('improvement_recommendations')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('time_management_calculations');
    }
}; 