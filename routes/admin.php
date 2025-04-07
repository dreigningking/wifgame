<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdministrativeController;
use App\Http\Controllers\Admin\UserManagementController;

Route::group(['as' => 'admin.','prefix'=> 'admin','middleware'=> ['auth','role:admin']],function () {
    Route::get('dashboard', [AdministrativeController::class,'dashboard'])->name('dashboard');
    Route::get('settings', [AdministrativeController::class,'settings'])->name('settings');
    Route::post('settings/store', [AdministrativeController::class,'settings_store'])->name('settings.store');
    Route::get('plans', 'BusinessManagementController@plan_list')->name('plans');
    Route::get('coupons','BusinessManagementController@coupon_list')->name('coupons');
    Route::get('coupon/create','BusinessManagementController@coupon_create')->name('coupon.create');
    Route::post('coupon/save','BusinessManagementController@coupon_save')->name('coupon.save');
    
    Route::group(['prefix'=> 'categories','as'=> 'categories.'],function(){
        Route::get('/',[CategoryController::class,'index'])->name('list');
        Route::post('store',[CategoryController::class,'store'])->name('store');
        Route::post('update',[CategoryController::class,'update'])->name('update');
        Route::post('delete',[CategoryController::class,'destroy'])->name('delete');
    });
    Route::group(['prefix'=> 'posts','as'=> 'posts.'],function(){
        Route::get('/','BlogManagementController@post_list')->name('list');
        Route::get('create','BlogManagementController@post_create')->name('create');
        Route::post('store','BlogManagementController@post_save')->name('store');
        Route::get('edit/{post}','BlogManagementController@post_edit')->name('edit');
        Route::post('update','BlogManagementController@post_udpate')->name('update');
        Route::post('delete','BlogManagementController@post_delete')->name('delete');
    
    });
    
    Route::group(['prefix'=> 'comments','as'=> 'comments.'],function(){
        Route::get('/','BlogManagementController@comment_list')->name('list');
        Route::post('approve','BlogManagementController@comment_delete')->name('approve');
        Route::post('delete','BlogManagementController@comment_delete')->name('delete');    
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
    
});









