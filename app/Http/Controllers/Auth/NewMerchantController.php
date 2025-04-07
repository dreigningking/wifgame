<?php

namespace App\Http\Controllers\Auth;

use App\Merchant;

use App\Rules\UserExistRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\CreateUserTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NewMerchantController extends Controller
{
    use CreateUserTrait;

    public function __construct()
    {
        $this->middleware('auth')->only('confirmation');
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'display_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'subdomain' => ['required', 'string', 'max:255'],
            'categories' => ['array'],
            'template' => ['numeric'],
            'plan' => ['numeric'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',new UserExistRule('merchant')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return redirect()->route('merchant.register')
                        ->withErrors($validator)
                        ->withInput();
        }
        $user = $this->create($request->only(['name','email','password']),'merchant_admin');
        Auth::login($user);
        $merchant = Merchant::create([
                    'business_name'=> $request->display_name,
                    'display_name'=> $request->display_name,
                    'categories'=> $request->categories,
                    'country_id' => $user->country->id,
                    'state_id' => $user->state_id,
                    'place_id' => $user->place_id,
                    'address' => $request->address,
                    'currency_id'=> $user->country->currency->id,
                    'subdomain'=> $request->subdomain,
                    'template'=> $request->template,
                    ]);
        $merchantUser = $merchant->users()->attach($user->id,['relationship' => 'agent']);
        $subscription = $merchant->subscription()->create(['plan_id'=> $request->plan]);
        $site_about = $merchant->about()->create(['merchant_id'=> $merchant->id,'title'=> $merchant->display_name,'description'=> 'This is the description of your website. You may edit it as you wish']);
        $site_header = $merchant->header()->create(['merchant_id'=> $merchant->id,'title'=> 'Header Title','subtitle'=> 'Sub Header Title','description'=> 'This is the description of your header. You may edit it as you wish']);
        $site_contact = $merchant->contacts()->create(['merchant_id'=> $merchant->id,'country_id'=> $merchant->country_id,'state_id'=> $merchant->state_id,'place_id'=> $merchant->place_id,'address'=> $merchant->address]);
        return redirect()->route('merchant.registered');
    }
    public function confirmation(){
        $user = Auth::user();
        if($user->roles->where('name','merchant_admin')->isNotEmpty())
        $merchant = $user->merchants->firstWhere('pivot.relationship','agent');
        return view('frontend.merchant.confirmation',compact('merchant'));
    }
}
