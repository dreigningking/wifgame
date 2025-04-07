<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Calculator;

class CalculatorSeeder extends Seeder
{
    public function run()
    {
        // Free calculators (not attached to any plan)
        Calculator::create([
            'name' => 'Simple ROI Calculator',
            'slug' => 'simple-roi',
            'description' => 'Basic Return on Investment calculator',
            'status' => 'active',
            'config' => [
                'features' => ['basic_report']
            ]
        ]);

        Calculator::create([
            'name' => 'Break-Even Calculator',
            'slug' => 'break-even',
            'description' => 'Basic Break-Even Point calculator',
            'status' => 'active',
            'config' => [
                'features' => ['basic_report']
            ]
        ]);

        // Premium calculators (will be attached to plans in PlanSeeder)
        Calculator::create([
            'name' => 'Advanced ROI Calculator',
            'slug' => 'advanced-roi',
            'description' => 'Advanced Return on Investment calculator with detailed analysis',
            'status' => 'active',
            'config' => [
                'features' => ['detailed_report', 'scenario_analysis']
            ]
        ]);

        // ... other calculators
    }
} 