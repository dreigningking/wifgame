<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('roi_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('initial_investment', 15, 2);
            $table->json('cash_flows');
            $table->integer('time_period');
            $table->decimal('discount_rate', 5, 2);
            $table->string('industry');
            $table->decimal('industry_benchmark', 5, 2);
            $table->enum('risk_factor', ['low', 'medium', 'high']);
            $table->json('additional_costs');
            $table->decimal('result_roi', 8, 2);
            $table->decimal('result_npv', 15, 2);
            $table->decimal('risk_adjusted_roi', 8, 2);
            $table->decimal('payback_period', 8, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roi_calculations');
    }
}; 