<?php

namespace App\Http\Controllers\Merchant;

use App\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\CreateUserTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UserController extends Controller
{
    use AuthenticatesUsers, CreateUserTrait;

    public function __construct(){
        $domain = request()->domain ? request()->domain: request()->root();
        $this->merchant = Merchant::where(function ($query) use($domain){
            return $query->where('subdomain', $domain)
                        ->orWhere('custom_domain',$domain);
            })->first();
        \abort_if(!$this->merchant,404);
        $this->middleware('guest')->except('dashboard');
        $this->middleware('auth')->only('dashboard');
    }
    
    public function login(Request $request)
    {  
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        if ($this->attemptLogin($request)) {
            if(!$this->guard()->user()->merchants->firstWhere('id',$this->merchant->id)){
                $this->guard()->logout();
                return $this->sendFailedLoginResponse($request);
            }
            $request->session()->regenerate();
            $this->clearLoginAttempts($request); 
            return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended(route('merchant.dashboard'));
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ])->redirectTo('login');;
    }



    public function dashboard(){
        //check if the user is a customer/staff
        //staff: go merchant dashboard   --- first preference
        //customer: go to merchant customer dashboard\
        if(Auth::user()->merchants->where('id',$this->merchant->id)->firstWhere('pivot.relationship','agent'))
        return view('merchant.dashboard');
        else return redirect()->route('merchant.customer.dashboard');
    }

    public function register(Request $request){
        //dd($request->all());
        $validator = $this->validateCustomer($request->all());
        if ($validator->fails()) {
            return redirect()->route('merchant.customer.register')
                        ->withErrors($validator)
                        ->withInput();
        }
        //check if user exist, check if user is customer, check if user is merchant's customer
        $user = $this->createCustomer($request->all(),$this->merchant->id);
        $this->guard()->login($user);
        return redirect()->route('merchant.customer.dashboard');
    }

    


}
