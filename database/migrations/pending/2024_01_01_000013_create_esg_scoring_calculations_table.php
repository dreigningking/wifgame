<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('esg_scoring_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Environmental Metrics
            $table->decimal('carbon_emissions_score', 5, 2);
            $table->decimal('resource_usage_score', 5, 2);
            $table->decimal('waste_management_score', 5, 2);
            // Social Metrics
            $table->decimal('employee_satisfaction_score', 5, 2);
            $table->decimal('community_impact_score', 5, 2);
            $table->decimal('diversity_inclusion_score', 5, 2);
            // Governance Metrics
            $table->decimal('board_diversity_score', 5, 2);
            $table->decimal('ethics_compliance_score', 5, 2);
            $table->decimal('transparency_score', 5, 2);
            // Results
            $table->decimal('result_environmental_score', 5, 2);
            $table->decimal('result_social_score', 5, 2);
            $table->decimal('result_governance_score', 5, 2);
            $table->decimal('result_overall_score', 5, 2);
            $table->json('detailed_metrics')->nullable();
            $table->json('improvement_recommendations')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('esg_scoring_calculations');
    }
}; 