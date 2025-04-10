<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('geopolitical_risk_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Country Risk Metrics
            $table->string('country');
            $table->decimal('political_stability_score', 5, 2);
            $table->decimal('economic_stability_score', 5, 2);
            $table->decimal('regulatory_risk_score', 5, 2);
            // Business Exposure
            $table->decimal('revenue_exposure', 15, 2);
            $table->decimal('asset_exposure', 15, 2);
            $table->decimal('supply_chain_exposure', 15, 2);
            // Risk Factors
            $table->json('political_factors'); // Elections, conflicts, etc.
            $table->json('economic_factors'); // Currency, inflation, etc.
            $table->json('regulatory_factors'); // Policy changes, trade barriers
            // Mitigation Costs
            $table->decimal('insurance_cost', 15, 2)->nullable();
            $table->decimal('hedging_cost', 15, 2)->nullable();
            $table->decimal('contingency_cost', 15, 2)->nullable();
            // Results
            $table->decimal('result_risk_score', 5, 2);
            $table->decimal('result_value_at_risk', 15, 2);
            $table->decimal('result_mitigation_cost', 15, 2);
            $table->decimal('result_adjusted_return', 5, 2);
            $table->json('risk_matrix')->nullable();
            $table->json('mitigation_strategies')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('geopolitical_risk_calculations');
    }
}; 