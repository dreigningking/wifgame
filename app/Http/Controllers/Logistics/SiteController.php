<?php

namespace App\Http\Controllers\Merchant;

use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    public function __construct(){
    }
    public function index(){
        switch(1){
            case 1: return view('merchant.layouts.template1');
            break;
            case 2: return view('merchant.layouts.template2');
            break;
        }
    }
    public function blog(){
        dd(request()->url());
        //dd(request()->getSchemeAndHttpHost());
        return view('merchant.outside.blog');
    }
    public function post(){
        return view('merchant.inside.posts');
    }
}
