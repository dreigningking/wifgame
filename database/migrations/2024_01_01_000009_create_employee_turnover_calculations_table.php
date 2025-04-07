<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employee_turnover_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('annual_salary', 15, 2);
            $table->decimal('benefits_cost', 15, 2);
            $table->decimal('recruitment_cost', 15, 2);
            $table->decimal('training_cost', 15, 2);
            $table->integer('productivity_loss_days');
            $table->decimal('daily_productivity_value', 15, 2);
            $table->decimal('administrative_cost', 15, 2)->nullable();
            $table->decimal('result_total_cost', 15, 2);
            $table->decimal('result_percentage_annual_salary', 5, 2);
            $table->json('additional_costs')->nullable(); // For any other specific costs
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_turnover_calculations');
    }
}; 