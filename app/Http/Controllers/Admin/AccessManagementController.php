<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccessManagementController extends Controller
{
    public function __construct(){

    }
    public function roles(){
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.roles',compact('roles','permissions'));
    }
    // public function permissions(Request $request){
    //     $permission = new Permission;
    //     $permission->name = ucwords($section);
    //     $permission->description = "Can manage ".ucwords($section)." section of the application";
    //     $permission->save();
    // }
    public function role_permissions(Request $request){
        $role = Role::find($request->role_id);
        $role->permissions()->sync($request->permissions);
        return redirect()->back()->with(['flash_type' => 'success','flash_msg'=>'Permissions saved successfully']);
    }
    public function permissions(){
        
    }

    public function permission_abilities(Request $request){
        $role = Role::find($request->role_id);
        foreach($request->abilities as $permission=>$abilities){
            $attributes['create'] = isset(array_flip($abilities)['create']);
            $attributes['read'] = isset(array_flip($abilities)['read']);
            $attributes['update'] = isset(array_flip($abilities)['update']);
            $attributes['delete'] = isset(array_flip($abilities)['delete']);
            $attributes['restore'] = isset(array_flip($abilities)['restore']);
            $attributes['list'] = isset(array_flip($abilities)['list']);
            $attributes['download'] = isset(array_flip($abilities)['download']);
            $role->permissions()->updateExistingPivot(Permission::find($permission),$attributes);
        }
        return redirect()->back()->with(['flash_type' => 'success','flash_msg'=>'Permissions saved successfully']);
    }

}
