<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('calculators', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_used_at')->nullable();
            $table->integer('usage_count')->default(0);
            $table->text('code')->nullable();
            $table->json('parameters')->nullable();
        });

        Schema::create('calculator_usage_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calculator_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->integer('usage_count')->default(0);
            $table->timestamps();

            $table->unique(['calculator_id', 'date']);
        });

        Schema::create('calculator_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calculator_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->json('input_data');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calculator_requests');
        Schema::dropIfExists('calculator_usage_stats');
        
        Schema::table('calculators', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'last_used_at',
                'usage_count',
                'code',
                'parameters'
            ]);
        });
    }
}; 