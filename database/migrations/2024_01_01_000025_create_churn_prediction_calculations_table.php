<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('churn_prediction_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Customer Metrics
            $table->integer('total_customers');
            $table->integer('churned_customers');
            $table->decimal('average_customer_lifetime', 8, 2);
            $table->decimal('average_revenue_per_customer', 15, 2);
            // Engagement Metrics
            $table->decimal('usage_frequency', 5, 2);
            $table->decimal('support_tickets_per_month', 5, 2);
            $table->decimal('satisfaction_score', 5, 2);
            // Financial Metrics
            $table->decimal('acquisition_cost', 15, 2);
            $table->decimal('service_cost', 15, 2);
            $table->decimal('current_mrr', 15, 2); // Monthly Recurring Revenue
            // Results
            $table->decimal('result_churn_rate', 5, 2);
            $table->decimal('result_retention_rate', 5, 2);
            $table->decimal('result_predicted_churn', 5, 2);
            $table->decimal('result_revenue_impact', 15, 2);
            $table->decimal('result_clv_impact', 15, 2);
            $table->json('risk_factors')->nullable();
            $table->json('segment_analysis')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('churn_prediction_calculations');
    }
}; 