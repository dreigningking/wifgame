<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('revenue_forecasting_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Historical Data
            $table->json('historical_revenue'); // Monthly/quarterly data
            $table->decimal('growth_rate', 5, 2);
            $table->decimal('seasonality_factor', 5, 2);
            // Market Factors
            $table->decimal('market_growth_rate', 5, 2);
            $table->decimal('market_share', 5, 2);
            $table->json('market_trends')->nullable();
            // Revenue Components
            $table->json('revenue_streams'); // Different products/services
            $table->json('customer_segments');
            $table->decimal('recurring_revenue', 15, 2);
            // Forecast Parameters
            $table->integer('forecast_period_months');
            $table->decimal('confidence_level', 5, 2);
            // Results
            $table->decimal('result_forecasted_revenue', 15, 2);
            $table->decimal('result_best_case', 15, 2);
            $table->decimal('result_worst_case', 15, 2);
            $table->decimal('result_accuracy_score', 5, 2);
            $table->json('monthly_projections')->nullable();
            $table->json('sensitivity_analysis')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('revenue_forecasting_calculations');
    }
}; 