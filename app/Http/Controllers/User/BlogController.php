<?php

namespace App\Http\Controllers\User;

use App\Models\Post;
use App\Http\Controllers\Controller;


class BlogController extends Controller
{

    public function show(Post $post){
        return view('frontend.blog',compact('post'));
    }

}
