<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supply_chain_risk_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Vendor Assessment
            $table->json('vendor_metrics'); // Array of {vendor_id, reliability_score, quality_score, delivery_score}
            $table->json('geographical_distribution'); // Array of {region, concentration}
            $table->decimal('supplier_concentration_ratio', 5, 2);
            // Risk Factors
            $table->decimal('geopolitical_risk_score', 5, 2);
            $table->decimal('financial_stability_score', 5, 2);
            $table->decimal('operational_risk_score', 5, 2);
            $table->decimal('environmental_risk_score', 5, 2);
            // Supply Chain Metrics
            $table->integer('lead_time_days');
            $table->decimal('inventory_coverage_days', 5, 2);
            $table->decimal('supply_disruption_rate', 5, 2);
            $table->json('alternative_sources')->nullable();
            // Results
            $table->decimal('result_overall_risk_score', 5, 2);
            $table->decimal('result_vulnerability_score', 5, 2);
            $table->decimal('result_resilience_score', 5, 2);
            $table->decimal('result_mitigation_potential', 5, 2);
            $table->json('risk_breakdown')->nullable();
            $table->json('mitigation_strategies')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supply_chain_risk_calculations');
    }
}; 