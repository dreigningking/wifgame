<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserManagementController extends Controller
{
    public function __construct(){

    }
    public function index(){
        // dd(request()->query());
        $users = User::where('created_at','!=',null);
        if(request()->query()){
            if(request()->query('role') != null){
                $role_id= Role::where('name',request()->query('role'))->first()->id;;
                $users = $users->where('role_id',$role_id);
            }
            if(request()->query('order')  != null && request()->query('order')  != 'all'){
                $users = $users->orderBy('name',request()->query('order'));
            }  
        }
        $users = $users->get();
        return view('admin.users',compact('users'));
    }
    
    public function show_user(){
        return view('admin.user-single');
    }
    public function create_user(){
        return view('admin.user-create');
    }
    public function saveUser(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'pin' => ['required', 'numeric'],
            'role_id' => 'required',
            'country_id' => 'required',
            'password' => ['required','confirmed',new PasswordLengthRule,new StrongPasswordRule],
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // 'pin' => Hash::make($request->pin),
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'country_id' => $request->country_id,
        ]);
        return redirect()->back()->with(['flash_type' => 'success','flash_msg'=>'User Created successfully']);
    }
    
}
