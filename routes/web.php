<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\FinanceCalculatorController;
use App\Http\Controllers\User\GrowthCalculatorController;
use App\Http\Controllers\User\OperationsCalculatorController;
use App\Http\Controllers\User\ProfessionalController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {return view('frontend.index'); })->name('index');
Route::get('dashboard', function () {return view('frontend.dashboard.overview'); })->name('dashboard');

// Finance Calculators
Route::prefix('finance')->as('finance.')->group(function () {
    Route::get('/roi-calculator', [FinanceCalculatorController::class, 'roiCalculator'])->name('roi-calculator');
    Route::post('/roi-calculator/calculate', [FinanceCalculatorController::class, 'calculateROI'])->name('roi-calculator.calculate');
    Route::get('/npv-calculator', [FinanceCalculatorController::class, 'npvCalculator'])->name('npv-calculator');
    Route::post('/npv-calculator/calculate', [FinanceCalculatorController::class, 'calculateNPV'])->name('npv-calculator.calculate');
    Route::get('/breakeven-calculator', [FinanceCalculatorController::class, 'breakevenCalculator'])->name('breakeven-calculator');
    Route::post('/breakeven-calculator/calculate', [FinanceCalculatorController::class, 'calculateBreakeven'])->name('breakeven-calculator.calculate');
    Route::get('/scenario-planner', [FinanceCalculatorController::class, 'scenarioPlanner'])->name('scenario-planner');
    Route::post('/scenario-planner/calculate', [FinanceCalculatorController::class, 'calculateScenarios'])->name('scenario-planner.calculate');
    Route::get('/market-share-calculator', [FinanceCalculatorController::class, 'marketShareCalculator'])->name('market-share-calculator');
    Route::post('/market-share-calculator/calculate', [FinanceCalculatorController::class, 'calculateMarketShare'])->name('market-share-calculator.calculate');
    Route::get('/working-capital-calculator', [FinanceCalculatorController::class, 'workingCapitalCalculator'])->name('working-capital-calculator');
    Route::post('/working-capital-calculator/calculate', [FinanceCalculatorController::class, 'calculateWorkingCapital'])->name('working-capital-calculator.calculate');
    Route::get('/debt-equity-calculator', [FinanceCalculatorController::class, 'debtEquityCalculator'])->name('debt-equity-calculator');
    Route::post('/debt-equity-calculator/calculate', [FinanceCalculatorController::class, 'calculateDebtEquity'])->name('debt-equity-calculator.calculate');
    Route::get('/currency-hedging-calculator', [FinanceCalculatorController::class, 'currencyHedgingCalculator'])->name('currency-hedging-calculator');
    Route::post('/currency-hedging-calculator/calculate', [FinanceCalculatorController::class, 'calculateCurrencyHedging'])->name('currency-hedging-calculator.calculate');
    Route::get('/tax-estimator', [FinanceCalculatorController::class, 'taxEstimator'])->name('tax-estimator');
    Route::post('/tax-estimator/calculate', [FinanceCalculatorController::class, 'calculateTax'])->name('tax-estimator.calculate');
});

// Growth Calculators
Route::prefix('growth')->as('growth.')->group(function () {
    Route::get('/cac-clv-analyzer', [GrowthCalculatorController::class, 'cacClvAnalyzer'])->name('cac-clv-analyzer');
    Route::post('/cac-clv-analyzer/calculate', [GrowthCalculatorController::class, 'calculateCACCLV'])->name('cac-clv-analyzer.calculate');
    Route::get('/employee-turnover-cost', [GrowthCalculatorController::class, 'employeeTurnoverCost'])->name('employee-turnover-cost');
    Route::post('/employee-turnover-cost/calculate', [GrowthCalculatorController::class, 'calculateEmployeeTurnoverCost'])->name('employee-turnover-cost.calculate');
});

// Operations Calculators Routes
Route::group(['prefix' => 'operations', 'as' => 'operations.'], function () {
    // Process Automation ROI routes
    Route::get('/process-automation-roi', [OperationsCalculatorController::class, 'processAutomationROI'])->name('process-automation-roi');
    Route::post('/process-automation-roi/calculate', [OperationsCalculatorController::class, 'calculateProcessAutomationROI'])->name('process-automation-roi.calculate');

    // Employee Productivity Analyzer routes
    Route::get('/employee-productivity', [OperationsCalculatorController::class, 'employeeProductivityAnalyzer'])->name('employee-productivity');
    Route::post('/employee-productivity/calculate', [OperationsCalculatorController::class, 'calculateEmployeeProductivity'])->name('employee-productivity.calculate');
});

// Professional Routes
Route::prefix('professionals')->name('professionals.')->group(function () {
    Route::get('become', [ProfessionalController::class, 'becomeProfessional'])->name('become');
    Route::post('store', [ProfessionalController::class, 'storeProfessional'])->name('store');
    Route::get('{professional}', [ProfessionalController::class, 'show'])->name('show');
    Route::post('{professional}/consult', [ProfessionalController::class, 'storeConsultation'])->name('consult');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

include('admin.php');
