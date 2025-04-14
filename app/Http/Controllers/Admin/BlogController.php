<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class BlogController extends Controller
{

    public function index(){
        $posts = Post::orderBy('created_at','DESC')->get();
        return view('backend.blog.list',compact('posts'));
    }

    public function create(){
        return view('backend.blog.create');
    }
    public function store(Request $request){
        $post = new Post;
        $post->title = $request->title;
        $post->user_id = auth()->id();
        $post->summary = $request->summary;
        if($request->hasFile('photo')){
            $photo = time().'.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->storeAs('public/blog',$photo);
            $post->photo = 'blog/'.$photo;
        }
        $post->body = $request->body;
        $post->tags = $request->tags && is_array($request->tags) && count($request->tags) ? implode(',',$request->tags) : null;
        $post->meta_description = $request->meta_description;
        $post->main_keyphrase = $request->main_keyphrase;
        $post->related_keyphrases = $request->related_keyphrases;
        $post->status = $request->status;
        $post->save();
        return redirect()->route('admin.posts.list')->with(['flash_type' => 'success','flash_title' => 'Success','flash_msg'=>'Post Created']); //with success;
    }
    
    public function edit(Post $post){
        $tags = $post->tags ? explode(',',$post->tags) : [];
        return view('backend.blog.edit',compact('post','tags'));
    }

    public function update(Request $request){
        $post = Post::find($request->post_id);
        if($request->filled('title')) $post->title = $request->title;
        if($request->filled('summary')) $post->summary = $request->summary;
        if($request->hasFile('photo')){
            if($post->photo) Storage::delete('public/blog/'.$post->photo);
            $photo = time().'.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->storeAs('public/blog',$photo);
            $post->photo = 'blog/'.$photo;
        }
        if($request->filled('body')) $post->body = $request->body;
        $post->tags = $request->tags && is_array($request->tags) && count($request->tags) ? implode(',',$request->tags) : null;
        $post->meta_description = $request->meta_description;
        $post->main_keyphrase = $request->main_keyphrase;
        $post->related_keyphrases = $request->related_keyphrases;
        $post->status = $request->status;
        $post->save();
        return redirect()->back()->with(['flash_type' => 'success','flash_title' => 'Success','flash_msg'=>'Post Updated']); //with success;
    }

    public function destroy(Request $request){
        $post = Post::find($request->post_id);
        $post->delete();
        return redirect()->back()->with(['flash_type' => 'success','flash_title' => 'Success','flash_msg'=>'Post Deleted']); //with success;
    }

}
