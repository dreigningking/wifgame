<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('meeting_cost_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Meeting Details
            $table->string('meeting_name');
            $table->integer('duration_minutes');
            $table->integer('number_of_attendees');
            // Cost Factors
            $table->json('attendee_costs'); // Array of {role, count, hourly_rate}
            $table->decimal('facility_costs', 10, 2)->nullable();
            $table->decimal('technology_costs', 10, 2)->nullable();
            $table->decimal('travel_costs', 10, 2)->nullable();
            // Productivity
            $table->decimal('preparation_time_hours', 5, 2);
            $table->decimal('followup_time_hours', 5, 2);
            // Results
            $table->decimal('result_labor_cost', 15, 2);
            $table->decimal('result_total_cost', 15, 2);
            $table->decimal('result_cost_per_attendee', 15, 2);
            $table->decimal('result_opportunity_cost', 15, 2);
            $table->json('cost_breakdown')->nullable();
            $table->json('productivity_metrics')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meeting_cost_calculations');
    }
}; 