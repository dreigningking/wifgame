<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiManagementController extends Controller
{
    public function subscriptions(){
        return view('admin.subscriptions');
    }
    
}
