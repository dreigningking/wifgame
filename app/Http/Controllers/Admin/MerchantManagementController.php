<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MerchantManagementController extends Controller
{
    public function __construct(){
        
    }
    public function list_merchants(){
        return view('admin.merchants');
    }
    public function show_merchant(){
        return view('admin.merchant-single');
    }
}
