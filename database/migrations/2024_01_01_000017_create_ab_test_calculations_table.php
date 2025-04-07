<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ab_test_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Test Parameters
            $table->string('test_name');
            $table->integer('control_visitors');
            $table->integer('control_conversions');
            $table->integer('variant_visitors');
            $table->integer('variant_conversions');
            $table->decimal('minimum_detectable_effect', 5, 2);
            $table->decimal('confidence_level', 5, 2);
            // Results
            $table->decimal('control_conversion_rate', 5, 2);
            $table->decimal('variant_conversion_rate', 5, 2);
            $table->decimal('absolute_difference', 5, 2);
            $table->decimal('relative_difference', 5, 2);
            $table->decimal('statistical_significance', 5, 2);
            $table->boolean('is_significant');
            $table->decimal('result_confidence_interval', 5, 2);
            $table->json('test_details')->nullable();
            $table->json('segment_analysis')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ab_test_calculations');
    }
}; 