<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('compensation_benchmark_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Position Details
            $table->string('job_title');
            $table->string('industry');
            $table->string('location');
            $table->integer('experience_years');
            // Current Compensation
            $table->decimal('base_salary', 15, 2);
            $table->decimal('bonus_percentage', 5, 2);
            $table->decimal('equity_value', 15, 2)->nullable();
            $table->json('benefits_value'); // Healthcare, 401k, etc.
            // Market Data
            $table->decimal('market_median_salary', 15, 2);
            $table->decimal('market_25th_percentile', 15, 2);
            $table->decimal('market_75th_percentile', 15, 2);
            $table->json('peer_company_data')->nullable();
            // Results
            $table->decimal('result_salary_gap', 15, 2);
            $table->decimal('result_total_comp_ratio', 5, 2);
            $table->decimal('result_percentile_position', 5, 2);
            $table->decimal('result_adjustment_needed', 15, 2);
            $table->json('market_analysis')->nullable();
            $table->json('compensation_trends')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('compensation_benchmark_calculations');
    }
}; 