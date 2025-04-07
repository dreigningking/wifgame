<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('succession_planning_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Position Details
            $table->string('position_title');
            $table->decimal('position_salary', 15, 2);
            $table->integer('criticality_score'); // 1-10
            $table->date('expected_vacancy_date')->nullable();
            // Candidate Assessment
            $table->integer('number_of_candidates');
            $table->json('candidate_scores'); // Array of {candidate_id, readiness, potential, performance}
            // Development Costs
            $table->decimal('training_cost_per_candidate', 15, 2);
            $table->decimal('mentoring_cost', 15, 2);
            $table->decimal('assessment_cost', 15, 2);
            // Risk Analysis
            $table->decimal('vacancy_risk_score', 5, 2);
            $table->integer('time_to_ready_months');
            // Results
            $table->decimal('result_total_development_cost', 15, 2);
            $table->decimal('result_risk_mitigation_score', 5, 2);
            $table->decimal('result_bench_strength_score', 5, 2);
            $table->json('candidate_rankings')->nullable();
            $table->json('development_plans')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('succession_planning_calculations');
    }
}; 