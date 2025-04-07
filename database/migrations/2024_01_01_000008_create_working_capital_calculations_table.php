<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('working_capital_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('current_assets', 15, 2);
            $table->decimal('current_liabilities', 15, 2);
            $table->decimal('inventory', 15, 2);
            $table->decimal('accounts_receivable', 15, 2);
            $table->decimal('accounts_payable', 15, 2);
            $table->decimal('result_working_capital', 15, 2);
            $table->decimal('result_working_capital_ratio', 5, 2);
            $table->decimal('result_quick_ratio', 5, 2);
            $table->json('historical_data')->nullable(); // For tracking changes over time
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('working_capital_calculations');
    }
}; 