<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CalculatorController;
use App\Http\Controllers\Admin\ProfessionalController;
use App\Http\Controllers\Admin\AdministrativeController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CalculatorRequestController;
Route::group(['as' => 'admin.','prefix'=> 'admin','middleware'=> ['auth','role:superadmin']],function () {
    Route::get('dashboard', [AdministrativeController::class,'dashboard'])->name('dashboard');
   
    Route::get('/calculator-requests', [CalculatorRequestController::class, 'index'])->name('calculator-requests.index');
    Route::post('/calculator-requests/update-status', [CalculatorRequestController::class, 'updateStatus'])->name('calculator-requests.update-status');
    Route::post('/calculator-requests/add-notes', [CalculatorRequestController::class, 'addNotes'])->name('calculator-requests.add-notes');
   
    Route::get('settings', [AdministrativeController::class,'settings'])->name('settings');
    Route::post('settings/store', [AdministrativeController::class,'settings_store'])->name('settings.store');
    Route::get('plans', 'BusinessManagementController@plan_list')->name('plans');
    
    Route::resource('ads', AdController::class);
    
    Route::prefix('professionals')->name('professionals.')->group(function () {
        Route::get('/', [ProfessionalController::class, 'index'])->name('index');
        Route::get('{professional}', [ProfessionalController::class, 'show'])->name('show');
        Route::post('{professional}/update-status', [ProfessionalController::class, 'updateStatus'])->name('update-status');
        Route::delete('{professional}', [ProfessionalController::class, 'destroy'])->name('destroy');
    });
    
    Route::group(['prefix'=> 'categories','as'=> 'categories.'],function(){
        Route::get('/',[CategoryController::class,'index'])->name('list');
        Route::post('store',[CategoryController::class,'store'])->name('store');
        Route::post('update',[CategoryController::class,'update'])->name('update');
        Route::post('delete',[CategoryController::class,'destroy'])->name('delete');
    });
    
    Route::group(['prefix'=> 'posts','as'=> 'posts.'],function(){
        Route::get('/',[BlogController::class,'index'])->name('list');
        Route::get('create',[BlogController::class,'create'])->name('create');
        Route::post('store',[BlogController::class,'store'])->name('store');
        Route::get('edit/{post}',[BlogController::class,'edit'])->name('edit');
        Route::post('update',[BlogController::class,'update'])->name('update');
        Route::post('delete',[BlogController::class,'destroy'])->name('delete');
    
    });
    
    Route::group(['prefix'=> 'comments','as'=> 'comments.'],function(){
        Route::get('/','BlogController@comment_list')->name('list');
        Route::post('approve','BlogController@comment_delete')->name('approve');
        Route::post('delete','BlogController@comment_delete')->name('delete');    
    });
    
    Route::group(['prefix'=> 'users','as'=> 'users.'],function(){
        
        Route::get('/', [UserManagementController::class,'index'])->name('list');
        Route::post('store',[UserManagementController::class,'store'] )->name('store'); 
        Route::post('update', [UserManagementController::class,'update'])->name('update');
        Route::post('delete', [UserManagementController::class,'delete'])->name('delete');
    });
    
    Route::get('clients', function () {return view('admin.settings'); })->name('clients');
   

    Route::group(['prefix'=> 'packages','as'=> 'packages.'],function(){
        Route::get('/', 'PackageManagementController@package_list')->name('list');
        Route::get('view', 'PackageManagementController@package_list')->name('view');
    });
    Route::group(['prefix'=> 'hires','as'=> 'hires.'],function(){
        Route::get('/', function () { return view('admin.consignments');})->name('list');
        Route::get('view', function () { return view('admin.consignments');})->name('view');
    });
    Route::group(['prefix'=> 'wares','as'=> 'wares.'],function(){
        Route::get('/', function () { return view('admin.consignments');})->name('list');
        Route::get('view', function () { return view('admin.consignments');})->name('view');
    });
    Route::group(['prefix'=> 'transactions','as'=> 'transactions.'],function(){
        Route::get('/', function () { return view('admin.consignments');})->name('list');
        Route::get('view', function () { return view('admin.consignments');})->name('view');
    });

    Route::get('subscriptions','BusinessManagementController@subscriptions')->name('merchant.subscriptions');
    
    Route::prefix('calculators')->group(function () {
        Route::get('/', [CalculatorController::class, 'index'])->name('admin.calculators.index');
        Route::get('/{calculator}', [CalculatorController::class, 'show'])->name('admin.calculators.show');
        Route::post('/{calculator}/toggle', [CalculatorController::class, 'toggleActive'])->name('admin.calculators.toggle');
        Route::put('/{calculator}/code', [CalculatorController::class, 'updateCode'])->name('admin.calculators.update-code');
        Route::get('/{calculator}/stats', [CalculatorController::class, 'getUsageStats'])->name('admin.calculators.stats');
        Route::get('/{calculator}/requests', [CalculatorController::class, 'getRecentRequests'])->name('admin.calculators.requests');
    });
});









