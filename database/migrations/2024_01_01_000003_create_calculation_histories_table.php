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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('calculator_id')->constrained()->cascadeOnDelete();
            $table->morphs('calculation'); // Creates calculation_type and calculation_id
            $table->json('input_data');
            $table->json('result_data');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calculation_histories');
    }
}; 