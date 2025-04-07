<?php

namespace App\Http\Controllers\User;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusinessController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create()
    {
        abort_if(auth()->user()->businesses->isNotEmpty() && auth()->user()->role->name != 'merchant',404);
        return view('business.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('business.location');
    }

    /**
     * Display the specified resource.
     */
    public function dashboard(Business $business){
        switch(auth()->user()->role->name){
            case 'admin': return view('admin.dashboard',$business);
            break;
            case 'individual': return view('business.consumer.dashboard',$business);
            break;
            case 'merchant': return view('business.consumer.dashboard',$business);
            break;
            case 'logistics': return view('business.logistics.dashboard',$business);
            break;
            case 'insurance': return view('insurance.dashboard',$business);
            break;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function locations(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
