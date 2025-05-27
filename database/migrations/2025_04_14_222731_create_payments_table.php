<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // User information
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('email');
            
            // Payment details
            $table->string('type')->default('donation'); // donation, subscription, etc.
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            
            // Payment gateway information
            $table->string('payment_gateway'); // stripe, paypal, etc.
            $table->string('payment_method')->nullable(); // card, bank_transfer, etc.
            $table->string('payment_method_details')->nullable(); // JSON encoded details
            
            // Transaction tracking
            $table->string('reference')->unique(); // Our internal reference
            $table->string('provider_reference')->nullable(); // Payment provider's reference
            $table->string('status')->default('pending'); // pending, completed, failed, refunded
            
            // Error handling
            $table->text('error_message')->nullable();
            $table->json('metadata')->nullable(); // Additional information
            
            // Refund tracking
            $table->decimal('refunded_amount', 10, 2)->default(0);
            $table->timestamp('refunded_at')->nullable();
            
            // Timestamps
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['payment_gateway', 'provider_reference']);
            $table->index(['email', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
