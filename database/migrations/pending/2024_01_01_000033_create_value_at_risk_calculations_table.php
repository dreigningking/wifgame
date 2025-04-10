<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('value_at_risk_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Portfolio Details
            $table->decimal('portfolio_value', 15, 2);
            $table->json('asset_allocation'); // Array of {asset_type, value, weight}
            $table->integer('time_horizon_days');
            // Risk Parameters
            $table->decimal('confidence_level', 5, 2);
            $table->decimal('historical_volatility', 5, 2);
            $table->json('correlation_matrix')->nullable();
            // Market Data
            $table->json('historical_returns');
            $table->decimal('risk_free_rate', 5, 2);
            $table->json('market_conditions')->nullable();
            // Monte Carlo Simulation
            $table->integer('simulation_runs');
            $table->json('simulation_results')->nullable();
            // Results
            $table->decimal('result_var_amount', 15, 2);
            $table->decimal('result_var_percentage', 5, 2);
            $table->decimal('result_expected_shortfall', 15, 2);
            $table->decimal('result_diversification_benefit', 5, 2);
            $table->json('stress_test_results')->nullable();
            $table->json('risk_decomposition')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('value_at_risk_calculations');
    }
}; 