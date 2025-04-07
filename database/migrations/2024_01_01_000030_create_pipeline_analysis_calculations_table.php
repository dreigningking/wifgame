<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pipeline_analysis_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Pipeline Stages
            $table->json('pipeline_stages'); // Array of {stage, deals, value, probability}
            $table->integer('total_opportunities');
            $table->decimal('total_pipeline_value', 15, 2);
            // Conversion Metrics
            $table->decimal('lead_to_opportunity_rate', 5, 2);
            $table->decimal('opportunity_to_close_rate', 5, 2);
            $table->integer('average_sales_cycle_days');
            // Velocity Metrics
            $table->decimal('conversion_velocity', 5, 2);
            $table->decimal('deal_velocity', 5, 2);
            $table->decimal('revenue_velocity', 15, 2);
            // Historical Performance
            $table->decimal('historical_win_rate', 5, 2);
            $table->decimal('average_deal_size', 15, 2);
            // Results
            $table->decimal('result_expected_revenue', 15, 2);
            $table->decimal('result_weighted_pipeline', 15, 2);
            $table->integer('result_deals_needed');
            $table->decimal('result_forecast_accuracy', 5, 2);
            $table->json('stage_analysis')->nullable();
            $table->json('bottleneck_identification')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pipeline_analysis_calculations');
    }
}; 