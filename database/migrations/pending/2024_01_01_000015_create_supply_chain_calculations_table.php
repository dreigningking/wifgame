<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supply_chain_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Inventory Costs
            $table->decimal('holding_cost_rate', 5, 2);
            $table->decimal('ordering_cost', 15, 2);
            $table->decimal('annual_demand', 15, 2);
            $table->decimal('unit_cost', 15, 2);
            // Lead Time Analysis
            $table->integer('lead_time_days');
            $table->decimal('daily_demand_rate', 10, 2);
            $table->decimal('stockout_cost', 15, 2);
            // Safety Stock
            $table->decimal('service_level', 5, 2);
            $table->decimal('demand_variability', 10, 2);
            // Results
            $table->decimal('result_eoq', 10, 2); // Economic Order Quantity
            $table->decimal('result_reorder_point', 10, 2);
            $table->decimal('result_safety_stock', 10, 2);
            $table->decimal('result_total_annual_cost', 15, 2);
            $table->json('cost_breakdown')->nullable();
            $table->json('sensitivity_analysis')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supply_chain_calculations');
    }
}; 