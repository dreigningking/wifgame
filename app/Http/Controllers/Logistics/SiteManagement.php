<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteManagement extends Controller
{
    public function post_create(){
        return view('merchant.inside.create-post');
    }
    public function post_list(){
        return view('merchant.outside.single-blog-article');
    }
}
