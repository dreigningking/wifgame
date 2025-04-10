<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdministrativeController extends Controller
{

    public function __construct()
    {
        
    }

    public function dashboard(){
        return view('backend.dashboard');
    }

    public function settings(){
        return view('admin.settings');
    }

    


}
