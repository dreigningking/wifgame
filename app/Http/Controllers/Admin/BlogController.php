<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function createPost(){
        return view('admin.editor.blog.create');
    }
    public function savePost(Request $request){
        // dd($request->all());
        $post = new Post;
        $post->title = $request->title;
        $post->tags = $request->tags;
        $post->status = $request->status;
        $post->body = $request->body;
        $post->excerpts = $request->excerpts;
        if($request->hasFile('cover')){
            $cover = $request->file('cover')->getClientOriginalName();
            $request->file('cover')->storeAs('public/blog',$cover);
            $post->image = $cover;
        }
        $post->user_id = Auth::id();
        $post->save();
        return redirect()->back()->with(['flash_type' => 'success','flash_title' => 'Success','flash_msg'=>'Post Created']); //with success;
    }
    public function postimage(Request $request){
        request()->validate([
            'file' => 'required',
        ]);
        $imageName = time().'.' . $request->file('file')->getClientOriginalExtension(); //get media name
        $type = $request->file('file')->getClientMimeType(); //get the media type
        $media = Media::create(['name' => $imageName,'format' => 'image','description'=> 'post content image']); //create media to database
        $request->file('file')->storeAs('public/blog',$imageName);//save the file to public folder
        return asset('storage/blog/'.$imageName);
    }
    public function listPosts(){
        $posts = Post::orderBy('created_at','DESC')->get();
        return view('admin.editor.blog.list',compact('posts'));
    }
    public function editPost(Post $post){
        return view('admin.editor.blog.edit',compact('post'));
    }
    public function updatePost(Request $request){
        $post = Post::find($request->post_id);
        if($request->filled('title')) $post->title = $request->title;
        if($request->filled('tags')) $post->tags = $request->tags;
        if($request->filled('status')) $post->status = $request->status;
        if($request->filled('body')) $post->body = $request->body;
        if($request->filled('excerpts')) $post->excerpts = $request->excerpts;
        if($request->hasFile('cover')){
            if($post->image) Storage::delete('public/blog/'.$post->image);
            $cover = $request->file('cover')->getClientOriginalName();
            $request->file('cover')->storeAs('public/blog',$cover);
            $post->image = $cover;
        }
        $post->user_id = Auth::id();
        $post->save();
        return redirect()->back()->with(['flash_type' => 'success','flash_title' => 'Success','flash_msg'=>'Post Updated']); //with success;
    }

    public function deletePost(Request $request){
        $post = Post::find($request->post_id);
        PostComment::where('post_id',$post->id)->delete();
        $post->delete();
        return redirect()->back()->with(['flash_type' => 'success','flash_title' => 'Success','flash_msg'=>'Post Deleted']); //with success;
    }
    public function listComments(){
        $comments = PostComment::all();
        return view('admin.editor.blog.comments',compact('comments'));
    }
    // public function approveComments(){

    // }
    public function discardComments(Request $request){
        $comment = PostComment::find($request->comment_id);
        $comment->delete();
        return redirect()->back()->with(['flash_type' => 'success','flash_title' => 'Success','flash_msg'=>'Comments Deleted']); //with success;
    }

}
