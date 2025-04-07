<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cac_clv_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // CAC Components
            $table->decimal('marketing_spend', 15, 2);
            $table->decimal('sales_spend', 15, 2);
            $table->integer('new_customers');
            $table->decimal('result_cac', 15, 2);
            // CLV Components
            $table->decimal('average_purchase_value', 15, 2);
            $table->decimal('purchase_frequency', 8, 2);
            $table->decimal('customer_lifespan', 5, 2);
            $table->decimal('result_clv', 15, 2);
            $table->decimal('result_clv_cac_ratio', 8, 2);
            $table->json('segmentation_data')->nullable(); // For customer segment analysis
            $table->json('historical_trends')->nullable(); // For tracking changes over time
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cac_clv_calculations');
    }
}; 