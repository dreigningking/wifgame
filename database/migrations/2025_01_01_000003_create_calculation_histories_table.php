<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('calculation_histories', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->foreignId('calculator_id')->constrained()->cascadeOnDelete();
            $table->json('input_data'); //{cashflow:123, discount_rate:5, time_period:10]
            $table->json('result_data');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calculation_histories');
    }
}; 