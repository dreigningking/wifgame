<?php

namespace App\Models\Calculations;

use App\Models\BaseCalculation;

class CarbonFootprintCalculation extends BaseCalculation
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'electricity_usage_kwh',
        'natural_gas_usage_therms',
        'fuel_consumption_liters',
        'business_travel_km',
        'employee_commute_km',
        'freight_transport_km',
        'waste_generated_tons',
        'water_usage_cubic_meters',
        'paper_usage_kg',
        'supplier_emissions',
        'product_lifecycle_emissions',
        'result_scope1_emissions',
        'result_scope2_emissions',
        'result_scope3_emissions',
        'result_total_emissions',
        'result_per_employee_emissions',
        'emission_breakdown',
        'reduction_opportunities',
        'notes'
    ];

    protected $casts = [
        'emission_breakdown' => 'array',
        'reduction_opportunities' => 'array',
        'electricity_usage_kwh' => 'decimal:2',
        'natural_gas_usage_therms' => 'decimal:2',
        'fuel_consumption_liters' => 'decimal:2',
        'business_travel_km' => 'decimal:2',
        'employee_commute_km' => 'decimal:2',
        'freight_transport_km' => 'decimal:2',
        'waste_generated_tons' => 'decimal:2',
        'water_usage_cubic_meters' => 'decimal:2',
        'paper_usage_kg' => 'decimal:2',
        'supplier_emissions' => 'decimal:2',
        'product_lifecycle_emissions' => 'decimal:2',
        'result_scope1_emissions' => 'decimal:2',
        'result_scope2_emissions' => 'decimal:2',
        'result_scope3_emissions' => 'decimal:2',
        'result_total_emissions' => 'decimal:2',
        'result_per_employee_emissions' => 'decimal:2'
    ];

    public function calculate(): array
    {
        // Carbon Footprint calculation logic will be implemented here
        return [
            'scope1_emissions' => 0,
            'scope2_emissions' => 0,
            'scope3_emissions' => 0,
            'total_emissions' => 0,
            'per_employee_emissions' => 0
        ];
    }
} 