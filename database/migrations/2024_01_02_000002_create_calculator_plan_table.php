<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('calculator_plan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('calculator_id')->constrained()->cascadeOnDelete();
            $table->integer('monthly_limit')->nullable(); // null means unlimited
            $table->json('additional_features')->nullable(); // Calculator-specific features for this plan
            $table->timestamps();
            
            $table->unique(['plan_id', 'calculator_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('calculator_plan');
    }
}; 