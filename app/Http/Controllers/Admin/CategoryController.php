<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $file = $request->file('photo') ;
        $fileName = time().'.'.$request->file('photo')->getClientOriginalExtension();
        $destinationPath = public_path().'/img/categories' ;
        $file->move($destinationPath,$fileName);
        Category::create(['name'=> $request->name,'description'=> $request->description,'photo'=> $fileName]);
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($request->category_id);
        if($request->hasFile('photo')){
            $image_path = public_path("/img/categories/{{$category->photo}}");
            if(File::exists($image_path)) {
                unlink($image_path);
            }
            $file = $request->file('photo');
            $fileName = time().'.'.$request->file('photo')->getClientOriginalExtension();
            $destinationPath = public_path().'/img/categories' ;
            $file->move($destinationPath,$fileName);
            $category->photo = $fileName;
        }
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $category = Category::find($request->category_id);
        if($category->businesses->isEmpty()){
            $image_path = public_path("img/categories/{{$category->photo}}");
            if (File::exists($image_path)) {
                unlink($image_path);
            }
            $category->delete();
        }
        
        return redirect()->back();
    }
}
