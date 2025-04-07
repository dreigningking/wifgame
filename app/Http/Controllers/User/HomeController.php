<?php

namespace App\Http\Controllers\User;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(auth()->user()->businesses->isEmpty()){
            if(auth()->user()->role->name == 'individual'){
                $business = Business::create(['business_name'=> str_replace(' ','_',auth()->user()->name),
                'display_name'=> auth()->user()->name,'category_id'=> 1,'email'=> auth()->user()->email,'payment_option'=> 'payasyougo']);
                return redirect()->route('business.dashboard',auth()->user()->business);
            }else{
                return redirect()->route('business.create');
            }
        }else{
            return redirect()->route('business.dashboard',auth()->user()->business);
        }
    }


    public function profile(){
        return view('user.profile');
    }
}
