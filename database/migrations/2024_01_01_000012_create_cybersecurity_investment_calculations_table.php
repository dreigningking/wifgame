<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cybersecurity_investment_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Risk Assessment
            $table->decimal('annual_revenue', 15, 2);
            $table->decimal('data_breach_probability', 5, 2);
            $table->decimal('estimated_breach_cost', 15, 2);
            // Investment Costs
            $table->decimal('security_software_costs', 15, 2);
            $table->decimal('hardware_costs', 15, 2);
            $table->decimal('training_costs', 15, 2);
            $table->decimal('personnel_costs', 15, 2);
            // Results
            $table->decimal('result_risk_reduction_percentage', 5, 2);
            $table->decimal('result_annual_savings', 15, 2);
            $table->decimal('result_roi_percentage', 5, 2);
            $table->integer('result_payback_months');
            $table->json('risk_assessment_details')->nullable();
            $table->json('compliance_requirements')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cybersecurity_investment_calculations');
    }
}; 