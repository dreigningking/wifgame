<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\Calculator;

class PlanSeeder extends Seeder
{
    public function run()
    {
        // Create Basic Plan
        $basicPlan = Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'price' => 0,
            'features' => ['export_pdf' => false, 'api_access' => false]
        ]);

        // Create Pro Plan
        $proPlan = Plan::create([
            'name' => 'Pro',
            'slug' => 'pro',
            'price' => 29.99,
            'features' => ['export_pdf' => true, 'api_access' => false]
        ]);

        // Create Enterprise Plan
        $enterprisePlan = Plan::create([
            'name' => 'Enterprise',
            'slug' => 'enterprise',
            'price' => 99.99,
            'features' => ['export_pdf' => true, 'api_access' => true]
        ]);

        // Assign calculators to plans
        $roiCalculator = Calculator::where('slug', 'roi')->first();
        $npvCalculator = Calculator::where('slug', 'npv')->first();
        $marketShareCalculator = Calculator::where('slug', 'market-share')->first();

        $basicPlan->calculators()->attach([
            $roiCalculator->id => ['monthly_limit' => 5],
            $npvCalculator->id => ['monthly_limit' => 5],
        ]);

        $proPlan->calculators()->attach([
            $roiCalculator->id => [
                'monthly_limit' => 50,
                'additional_features' => json_encode(['detailed_reports' => true])
            ],
            $npvCalculator->id => [
                'monthly_limit' => 50,
                'additional_features' => json_encode(['detailed_reports' => true])
            ],
            $marketShareCalculator->id => ['monthly_limit' => 25],
        ]);

        $enterprisePlan->calculators()->attach([
            $roiCalculator->id => [
                'monthly_limit' => null,
                'additional_features' => json_encode(['detailed_reports' => true, 'api_access' => true])
            ],
            $npvCalculator->id => [
                'monthly_limit' => null,
                'additional_features' => json_encode(['detailed_reports' => true, 'api_access' => true])
            ],
            $marketShareCalculator->id => [
                'monthly_limit' => null,
                'additional_features' => json_encode(['detailed_reports' => true, 'api_access' => true])
            ],
        ]);
    }
} 