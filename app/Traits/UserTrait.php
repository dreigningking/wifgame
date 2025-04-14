<?php

namespace App\Traits;

use App\Models\Plan;
use App\Models\User;
use App\Models\Country;
use App\Models\Subscription;

trait UserTrait
{

    public function mtbcToCurrency($amount,$currency){
        $usd_rate = cache('settings')['1mtbc_to_usd'];
        $country = Country::where('currency_code',strtoupper($currency))->first();
        if($currency != 'usd'){
            $currency_rate = $country->usd_rate * $usd_rate * $amount;
        }else{
            $currency_rate = $usd_rate * $amount;
        }
        return $currency_rate;
        
    }

    public function mtbpToMtbc($mtbp){
        $rate = cache('settings')['1mtbc_to_mtbp'];
        $credits = $mtbp / $rate;
        return $credits;
    }

    public function addCredits(User $user,$credits){
        $wallet = $user->wallets->firstWhere('currency','mtbc');
        $wallet->balance += $credits;
        $wallet->save();
    }

    public function usdToCurrency($amount,$currency){
        $usd_rate = Country::firstwhere('currency_code',$currency)->usd_rate;
        return $usd_rate * $amount;
    }

    public function earningStatus($user,$model){
        switch($model){
            case 'App\Models\Post': $check = $user->post_earning_status;
                break;
            case 'App\Models\Forum': $check = $user->forum_earning_status;
                break;
            case 'App\Models\Occasion': $check = $user->event_earning_status;
                break;
            case 'App\Models\Tool': $check = $user->tool_earning_status;
                break;
        }
        return $check;
    }

    public function addEarnings($mtbp,User $user){
        //multiply reward by user subscription plan multiplier
        $points = $mtbp * $user->active_subscription->plan->point_multiplier;
        //get user's total earnings
        $earnings = $user->earnings->sum('mtbp');
        //check user subscription plan earning cap
        if($user->active_subscription->plan->earnings_cap && $user->active_subscription->plan->earnings_cap < ($earnings + $points) ){
            return 0;
        }
        $wallet = $user->wallets->firstWhere('currency','mtbp');
        if(!$wallet->status){
            return 0;
        }
        $wallet->balance += $points;
        $wallet->save();
        return $points;
    }

    public function createFreeSubscription($user_id){
        $plan = Plan::where('cost',0)->first();
        Subscription::create(['user_id'=> $user_id,'plan_id'=> $plan->id,
        'duration'=> 365,'auto_renew'=> 1,
        'start_at'=> now(),'end_at'=> now()->addDays(365)]);
        
    }
    
}