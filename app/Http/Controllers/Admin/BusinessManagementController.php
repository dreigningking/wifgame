<?php

namespace App\Http\Controllers\Admin;

use App\Cost;
use App\Plan;
use App\Feature;
use App\Payment;
use App\Currency;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BusinessManagementController extends Controller
{
    public function __construct(){
        
    }
    public function plan_list(){
        $plans = Plan::all();
        return view('admin.business.plans.list',compact('plans'));
    }
    public function plan_create(){
        $features = Feature::all();
        $currencies = Currency::where('status',true)->get();
        return view('admin.business.plans.create',compact('features','currencies'));
    }
    public function plan_save(Request $request){
        $validator = Validator::make($request->all(), [
            'plan_name' => 'required|string',
            'plan_description' => 'required|string',
            'features' => 'required|array',
            'commission' => 'required',
            'validity' => 'required',
            'plan_cost.*' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        dd($request->plan_cost);
        $plan = Plan::create(['name'=> $request->plan_name,'description'=> $request->plan_description,'features'=> $request->features,'commission'=> $request->commission,'validity'=> $request->validity,'status'=> $request->status]);
        foreach($request->plan_cost as $key=>$cost)
            $cost = Cost::create(['currency_id' => Currency::where('iso',$key)->first()->id,'amount'=> $cost,'costable_id'=> $plan->id,'costable_type'=>get_class($plan)]);
        return redirect()->route('admin.plans');
    }
    public function features(){
        $features = Feature::all();
        return view('admin.business.features.list',compact('features'));
    }
    public function feature_edit(Feature $feature){
        return view('admin.business.features.edit',compact('feature'));
    }
    public function coupon_list(){

    }
    public function coupon_create(){

    }
    public function subscriptions(){
        $subscriptions = Subscription::all();
        return view('admin.business.subscriptions.list',compact('subscriptions'));
    }
    public function payment_list(){
        $payments = Payment::where('created_at','!=',null);
        if(request()->query()){
            if(request()->query('currency'))
            $payments = $payments->where('currency_id',request()->query('currency'));
            if(request()->query('type')  != null)
            $payments = $payments->where('type','=',request()->query('type'));
            if(request()->query('status')  != null)
            $payments = $payments->where('status',request()->query('status'));
            if(request()->query('order')  != null)
            $payments = $payments->orderBy('created_at',request()->query('order'));
        }
        $payments = $payments->get();
        return view('admin.transactions',compact('payments'));
    }
    public function payment_view(){
        return view('admin.transaction-view');
    }
}
