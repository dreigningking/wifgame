<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Calculations\RoiCalculation;
use App\Models\Calculations\NpvCalculation;
use App\Models\Calculations\BreakevenCalculation;
use App\Models\Calculations\WorkingCapitalCalculation;
use App\Models\Calculations\EmployeeTurnoverCalculation;
use App\Models\Calculations\CacClvCalculation;
use App\Models\Calculations\CloudMigrationCalculation;
use App\Models\Calculations\CarbonFootprintCalculation;
use App\Models\Calculations\ChurnPredictionCalculation;
use App\Models\Calculations\CrossBorderTaxCalculation;
use App\Models\Calculations\ValueAtRiskCalculation;
use App\Models\Calculations\SupplyChainRiskCalculation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Relation::morphMap([
            'roi' => RoiCalculation::class,
            'npv' => NpvCalculation::class,
            'breakeven' => BreakevenCalculation::class,
            'working_capital' => WorkingCapitalCalculation::class,
            'employee_turnover' => EmployeeTurnoverCalculation::class,
            'cac_clv' => CacClvCalculation::class,
            'cloud_migration' => CloudMigrationCalculation::class,
            'carbon_footprint' => CarbonFootprintCalculation::class,
            'churn_prediction' => ChurnPredictionCalculation::class,
            'cross_border_tax' => CrossBorderTaxCalculation::class,
            'value_at_risk' => ValueAtRiskCalculation::class,
            'supply_chain_risk' => SupplyChainRiskCalculation::class,
        ]);
    }
}
