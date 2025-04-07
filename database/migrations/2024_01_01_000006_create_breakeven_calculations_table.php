<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('breakeven_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('fixed_costs', 15, 2);
            $table->decimal('variable_cost_per_unit', 15, 2);
            $table->decimal('selling_price_per_unit', 15, 2);
            $table->decimal('result_breakeven_units', 10, 2);
            $table->decimal('result_breakeven_revenue', 15, 2);
            $table->decimal('result_breakeven_margin', 5, 2)->nullable();
            $table->json('additional_costs')->nullable(); // For any category-specific costs
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('breakeven_calculations');
    }
}; 