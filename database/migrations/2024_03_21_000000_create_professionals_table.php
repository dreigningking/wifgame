<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('professionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('bio');
            $table->string('specialization');
            $table->integer('experience_years');
            $table->string('qualification');
            $table->string('currency');
            $table->string('profile_image')->nullable();
            $table->decimal('hourly_rate', 10, 2);
            $table->boolean('is_available')->default(true);
            $table->integer('rating')->default(0);
            $table->integer('total_consultations')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('professionals');
    }
}; 