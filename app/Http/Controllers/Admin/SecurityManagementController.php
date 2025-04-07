<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SecurityManagementController extends Controller
{
    public function ipfirewall(){
        $blacklists = Blacklist::all();
        return view('admin.security.ipfirewall',compact('blacklists'));
    }

    public function userfirewall(){
        $users = User::all();
        $blacklists = Blacklist::all();
        return view('admin.security.userfirewall',compact('blacklists','users'));
    }

    public function failed_actions(){
        $actions = FailedAction::withTrashed()->orderBy('deleted_at','ASC')->get();
        return view('admin.security.failedactions',compact('actions'));
    }

    public function ipwhitelist(Request $request){
        Blacklist::where('ipAddress',$request->ipAddress)->delete();
        return redirect()->back()->with(['flash_type' => 'success','flash_msg'=>'IP successfully whitelisted']);
    }

    public function userwhitelist(Request $request){
        $user = User::find($request->user_id);
        Blacklist::where('user_id',$user->id)->delete();
        $user->notifications->where('type','App\Notifications\UserBlacklistNotification')->delete();
        return redirect()->back()->with(['flash_type' => 'success','flash_msg'=>'User successfully whitelisted']);
    }

    public function ipblacklist(Request $request){
        $ip_address = explode(',',$request->ipaddress);
        //dd($ip_address);
        foreach($ip_address as $item){
            if(Blacklist::where('ipAddress',$item)->first() || (ip2long($item) === false))
                continue;
            $blacklist = new Blacklist;
            $blacklist->ipAddress = $item;
            $blacklist->save();
        }
        return redirect()->back()->with(['flash_type' => 'success','flash_msg'=>'IP successfully blacklisted']);
    }
    
    public function userblacklist(Request $request){
        foreach($request->newban as $ban){
            if(Blacklist::where('user_id',$ban)->first())
                continue;
            $blacklist = new Blacklist;
            $blacklist->user_id = $ban;
            if($request->filled('reason')) $blacklist->reason = $request->reason;
            $blacklist->save();
        }
        return redirect()->back()->with(['flash_type' => 'success','flash_msg'=>'User successfully banned']);
    }

    public function iphistory($ipaddress){
        $histories = Visitor::where('ip_address',$ipaddress)->paginate(20);
        return view('admin.iphistory',compact('histories'));
    }

    public function lockwallet(Request $request){
        //dd($request->all());
        if(!Hash::check($request->pin, Auth::user()->pin))
        return redirect()->back()->with(['flash_type' => 'danger','flash_title' => 'Operation Failure','flash_msg'=>'We cannot verify who you are']); //with success;
        $user = User::find($request->user_id);
        $wallet_ids = Wallet::where('user_id',$user->id)->get()->pluck('id');
        foreach($wallet_ids as $wallet_id){
            LockedWallet::create(['wallet_id'=> $wallet_id]);
        }
        $user->notify(new FreezeWalletsNotification('frozen'));
        return redirect()->back()->with(['flash_type' => 'success','flash_msg'=>'Operation successful']);

    }

    public function unlockwallet(Request $request){
        if(!Hash::check($request->pin, Auth::user()->pin))
        return redirect()->back()->with(['flash_type' => 'danger','flash_title' => 'Operation Failure','flash_msg'=>'We cannot verify who you are']); //with success;
        $user = User::find($request->user_id);
        $wallet_ids = Wallet::where('user_id',$user->id)->get()->pluck('id');
        LockedWallet::whereIn('wallet_id',$wallet_ids)->delete();
        $user->notify(new FreezeWalletsNotification('unfrozen'));
        return redirect()->back()->with(['flash_type' => 'success','flash_title'=>'Operation successful','flash_msg'=>'Wallet unlocked successfully']);
    }

}
