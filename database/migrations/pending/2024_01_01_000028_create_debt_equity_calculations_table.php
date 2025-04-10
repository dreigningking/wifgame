<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('debt_equity_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Current Structure
            $table->decimal('current_debt', 15, 2);
            $table->decimal('current_equity', 15, 2);
            $table->decimal('current_debt_rate', 5, 2);
            $table->decimal('current_equity_cost', 5, 2);
            // Proposed Structure
            $table->decimal('proposed_debt', 15, 2);
            $table->decimal('proposed_equity', 15, 2);
            $table->decimal('proposed_debt_rate', 5, 2);
            $table->decimal('proposed_equity_cost', 5, 2);
            // Tax Considerations
            $table->decimal('tax_rate', 5, 2);
            $table->decimal('debt_tax_shield', 15, 2);
            // Risk Metrics
            $table->decimal('beta_unlevered', 5, 2);
            $table->decimal('risk_free_rate', 5, 2);
            $table->decimal('market_risk_premium', 5, 2);
            // Results
            $table->decimal('result_current_wacc', 5, 2);
            $table->decimal('result_proposed_wacc', 5, 2);
            $table->decimal('result_optimal_debt_ratio', 5, 2);
            $table->decimal('result_value_impact', 15, 2);
            $table->json('sensitivity_analysis')->nullable();
            $table->json('capital_structure_metrics')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('debt_equity_calculations');
    }
}; 