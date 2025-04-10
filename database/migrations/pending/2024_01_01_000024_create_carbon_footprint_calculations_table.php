<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carbon_footprint_calculations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('calculator_id')->after('user_id')->constrained()->cascadeOnDelete();
            // Energy Usage
            $table->decimal('electricity_usage_kwh', 15, 2);
            $table->decimal('natural_gas_usage_therms', 15, 2);
            $table->decimal('fuel_consumption_liters', 15, 2);
            // Transportation
            $table->decimal('business_travel_km', 15, 2);
            $table->decimal('employee_commute_km', 15, 2);
            $table->decimal('freight_transport_km', 15, 2);
            // Waste and Materials
            $table->decimal('waste_generated_tons', 15, 2);
            $table->decimal('water_usage_cubic_meters', 15, 2);
            $table->decimal('paper_usage_kg', 15, 2);
            // Supply Chain
            $table->decimal('supplier_emissions', 15, 2)->nullable();
            $table->decimal('product_lifecycle_emissions', 15, 2)->nullable();
            // Results
            $table->decimal('result_scope1_emissions', 15, 2); // Direct emissions
            $table->decimal('result_scope2_emissions', 15, 2); // Indirect emissions from energy
            $table->decimal('result_scope3_emissions', 15, 2); // Other indirect emissions
            $table->decimal('result_total_emissions', 15, 2);
            $table->decimal('result_per_employee_emissions', 15, 2);
            $table->json('emission_breakdown')->nullable();
            $table->json('reduction_opportunities')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carbon_footprint_calculations');
    }
}; 