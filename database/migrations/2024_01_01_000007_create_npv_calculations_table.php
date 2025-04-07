<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('npv_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('initial_investment', 15, 2);
            $table->json('cash_flows'); // Array of yearly/periodic cash flows
            $table->decimal('discount_rate', 5, 2);
            $table->integer('time_period');
            $table->decimal('result_npv', 15, 2);
            $table->decimal('result_irr', 6, 2); // Internal Rate of Return
            $table->decimal('result_payback_period', 5, 2)->nullable();
            $table->json('sensitivity_analysis')->nullable(); // For different scenario results
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('npv_calculations');
    }
}; 