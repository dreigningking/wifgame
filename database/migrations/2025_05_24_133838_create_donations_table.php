<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_name')->nullable(); // Donor's name
            $table->string('donor_email')->nullable(); // Donor's email
            $table->decimal('amount', 10, 2); // Donation amount
            $table->string('payment_method'); // Payment method (e.g., PayPal, Stripe)
            $table->string('status')->default('pending'); // Status of the donation
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donations');
    }
}