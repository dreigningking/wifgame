<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageManagementController extends Controller
{
    public function __construct(){

    }
    public function list(){
        return view('admin.package');
    }
    public function show(){

    }


}
