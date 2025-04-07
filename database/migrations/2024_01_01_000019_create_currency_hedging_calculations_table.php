<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('currency_hedging_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Exposure Details
            $table->string('base_currency');
            $table->string('foreign_currency');
            $table->decimal('exposure_amount', 15, 2);
            $table->decimal('current_exchange_rate', 10, 4);
            $table->date('settlement_date');
            // Hedging Costs
            $table->decimal('forward_rate', 10, 4);
            $table->decimal('option_premium', 15, 2)->nullable();
            $table->decimal('hedging_cost_percentage', 5, 2);
            // Risk Assessment
            $table->decimal('volatility', 5, 2);
            $table->decimal('confidence_level', 5, 2);
            // Results
            $table->decimal('result_var_unhedged', 15, 2);
            $table->decimal('result_var_hedged', 15, 2);
            $table->decimal('result_cost_of_hedging', 15, 2);
            $table->decimal('result_net_benefit', 15, 2);
            $table->json('scenario_analysis')->nullable();
            $table->json('historical_rates')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('currency_hedging_calculations');
    }
};