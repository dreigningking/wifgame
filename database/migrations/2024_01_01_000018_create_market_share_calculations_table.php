<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('market_share_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Market Data
            $table->decimal('total_market_size', 15, 2);
            $table->decimal('current_market_share', 5, 2);
            $table->decimal('competitor_market_share', 5, 2);
            // Marketing Investment
            $table->decimal('marketing_budget', 15, 2);
            $table->decimal('price_point', 15, 2);
            $table->decimal('competitor_price', 15, 2);
            // Growth Factors
            $table->decimal('market_growth_rate', 5, 2);
            $table->decimal('customer_retention_rate', 5, 2);
            $table->decimal('acquisition_rate', 5, 2);
            // Results
            $table->decimal('result_projected_share', 5, 2);
            $table->decimal('result_revenue_impact', 15, 2);
            $table->decimal('result_market_penetration', 5, 2);
            $table->integer('result_months_to_target');
            $table->json('scenario_analysis')->nullable();
            $table->json('competitive_analysis')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('market_share_calculations');
    }
}; 