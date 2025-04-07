<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('software_tco_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Direct Costs
            $table->decimal('license_cost', 15, 2);
            $table->decimal('implementation_cost', 15, 2);
            $table->decimal('hardware_cost', 15, 2)->nullable();
            $table->decimal('maintenance_annual', 15, 2);
            // Indirect Costs
            $table->decimal('training_cost', 15, 2);
            $table->decimal('support_cost_annual', 15, 2);
            $table->decimal('upgrade_cost_annual', 15, 2);
            $table->integer('expected_lifetime_years');
            // Integration Costs
            $table->decimal('integration_cost', 15, 2)->nullable();
            $table->decimal('customization_cost', 15, 2)->nullable();
            $table->decimal('data_migration_cost', 15, 2)->nullable();
            // Results
            $table->decimal('result_first_year_cost', 15, 2);
            $table->decimal('result_annual_cost', 15, 2);
            $table->decimal('result_total_tco', 15, 2);
            $table->decimal('result_cost_per_user', 15, 2);
            $table->json('cost_breakdown')->nullable();
            $table->json('annual_projection')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('software_tco_calculations');
    }
}; 