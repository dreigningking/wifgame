<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cross_border_tax_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Revenue Details
            $table->string('source_country');
            $table->string('destination_country');
            $table->decimal('revenue_amount', 15, 2);
            $table->string('revenue_currency');
            // Tax Rates
            $table->decimal('corporate_tax_rate', 5, 2);
            $table->decimal('vat_rate', 5, 2)->nullable();
            $table->decimal('withholding_tax_rate', 5, 2)->nullable();
            // Deductions and Credits
            $table->decimal('deductible_expenses', 15, 2);
            $table->decimal('tax_credits', 15, 2)->nullable();
            $table->decimal('treaty_benefits', 15, 2)->nullable();
            // Transfer Pricing
            $table->decimal('transfer_price', 15, 2)->nullable();
            $table->decimal('markup_percentage', 5, 2)->nullable();
            // Results
            $table->decimal('result_taxable_income', 15, 2);
            $table->decimal('result_total_tax_liability', 15, 2);
            $table->decimal('result_effective_tax_rate', 5, 2);
            $table->decimal('result_net_profit', 15, 2);
            $table->json('tax_breakdown')->nullable();
            $table->json('compliance_requirements')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cross_border_tax_calculations');
    }
}; 