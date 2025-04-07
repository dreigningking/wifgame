<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsManagementController extends Controller
{
    public function index(){
        $settings = Setting::all();
        return view('admin.settings.main',compact('settings'));
    }

    public function global(Request $request){
        $fields = Setting::all()->pluck('name');
        foreach($fields as $field){
            Setting::where('name',$field)->update(
                ['value' => $request->input($field) ? $request->input($field) : 0]);
        }
        return redirect()->back()->with(['flash_type' => 'success','flash_msg'=>'Settings have been saved successfully']);
    }

    public function paymentsettings(){
        $currencies = Currency::all();
        return view('admin.settings.payment',compact('currencies'));
    }

    public function payment(Request $request){
        // dd($request->all());
        $paysetting = PaymentSetting::where('currency_id',$request->currency_id)->first();
        $paysetting->withdrawal_threshold = $request->withdrawal_threshold;
        $paysetting->withdrawal_maximum = $request->withdrawal_maximum;
        $paysetting->withdrawal_minimum = $request->withdrawal_minimum;
        $paysetting->withdrawal_per_day = $request->withdrawal_per_day;
        $paysetting->withdrawal_per_week = $request->withdrawal_per_week;
        $paysetting->withdrawal_per_month = $request->withdrawal_per_month;
        $paysetting->deposit_minimum = $request->deposit_minimum;
        $paysetting->deposit_maximum = $request->deposit_maximum;
        $paysetting->withdrawal_charge = ['flat'=> $request->withdrawal_charge_flat,'percentage' => $request->withdrawal_charge_percentage,'cap'=>$request->withdrawal_charge_cap];
        $paysetting->withdrawal_flat = ['below'=> $request->withdrawal_flat_below,'above'=>$request->withdrawal_flat_above];
        $paysetting->withdrawal_median = $request->withdrawal_median;
        $paysetting->deposit_charge = ['flat'=> $request->deposit_charge_flat,'percentage' => $request->deposit_charge_percentage,'cap'=>$request->deposit_charge_cap];
        $paysetting->deposit_flat = ['below'=> $request->deposit_flat_below,'above'=>$request->deposit_flat_above];
        $paysetting->deposit_median = $request->deposit_median;
        $paysetting->invoice_charge = ['flat'=> $request->invoice_charge_flat,'percentage' => $request->invoice_charge_percentage,'cap'=>$request->invoice_charge_cap];
        $paysetting->invoice_flat = ['below'=> $request->invoice_flat_below,'above'=>$request->invoice_flat_above];
        $paysetting->invoice_median = $request->invoice_median;
        $paysetting->escrow_charge = ['flat'=> $request->escrow_charge_flat,'percentage' => $request->escrow_charge_percentage,'cap'=>$request->escrow_charge_cap];
        $paysetting->escrow_flat = ['below'=> $request->escrow_flat_below,'above'=>$request->escrow_flat_above];
        $paysetting->escrow_median = $request->escrow_median;
        $paysetting->merchant_charge = ['flat'=> $request->merchant_charge_flat,'percentage' => $request->merchant_charge_percentage,'cap'=>$request->merchant_charge_cap];
        $paysetting->merchant_flat = ['below'=> $request->merchant_flat_below,'above'=>$request->merchant_flat_above];
        $paysetting->merchant_median = $request->merchant_median;
        $paysetting->arbitration_charge = $request->arbitration_charge;
        if($request->volume_alert) $paysetting->volume_alert = $request->volume_alert;
        $paysetting->penalty_charge = $request->penalty_charge;
        $paysetting->save();
        return redirect()->back();
        //"currency_id" => null
    }

    public function notificationsettings(){
        $settings = NotificationSetting::all();
        return view('admin.settings.notification',compact('settings'));
    }

    public function notification(Request $request){
        // dd(isset($request->input('invitation_received')['app']));
        // dd($request->all());
        $fields = NotificationSetting::all()->pluck('name');
        foreach($fields as $field){
            NotificationSetting::where('name',$field)->update(
                ['email' => isset($request->input($field)['email']) ? true:false,
                'sms' => isset($request->input($field)['sms']) ? true:false,
                'app' => isset($request->input($field)['app']) ? true:false]
            );
        }
        return redirect()->back()->with(['flash_type' => 'success','flash_msg'=>'Notification Settings have been saved successfully']);
    }

    public function countrysettings(){
        $countries = Country::all();
        return view('admin.settings.countries',compact('countries'));
    }

    public function country(Request $request){
        if(!Hash::check($request->pin, Auth::user()->pin))
        return redirect()->back()->with(['flash_type' => 'danger','flash_title' => 'Operation Failure','flash_msg'=>'We could not verify its you ']); //with success;
        $country = Country::find($request->country_id);
        if($request->unique_id_name) $country->unique_id_name = $request->unique_id_name;
        if($request->enterprise_documents) $country->enterprise_documents = $request->enterprise_documents;
        if($request->has('status')) {
            if($request->status && (!$country->unique_id_name || !$country->enterprise_documents || $country->banks->isEmpty() || $country->shippers->isEmpty()))
            return redirect()->back()->with(['flash_type' => 'danger','flash_title'=> 'Operation Failed','flash_msg'=>'You must set banks, shippers, and requirements before activation']);
            $country->status = $request->status;
        }
        $country->save();
        return redirect()->back()->with(['flash_type' => 'success','flash_msg'=>'Settings have been saved successfully']);
    }

    public function roles(){
        $roles = Role::all();
        $permissions = Permission::all();
        //dd($roles[0]->permissions);
        return view('admin.settings.roles',compact('roles','permissions'));
    }
    // public function permissions(Request $request){
    //     $permission = new Permission;
    //     $permission->name = ucwords($section);
    //     $permission->description = "Can manage ".ucwords($section)." section of the application";
    //     $permission->save();
    // }
    public function rolePermissions(Request $request){
        $role = Role::find($request->role_id);
        $role->permissions()->sync($request->permissions);
        return redirect()->back()->with(['flash_type' => 'success','flash_msg'=>'Permissions saved successfully']);
    }
    public function rolePermissionAbilities(Request $request){
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
