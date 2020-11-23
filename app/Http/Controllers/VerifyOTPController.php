<?php

namespace App\Http\Controllers;

use App\Http\Requests\OTPRequest;
use Illuminate\Support\Facades\Cache;

class VerifyOTPController extends Controller
{
    public function verify(OTPRequest $request){

        if(request('otp') == auth()->user()->otp()){

            auth()->user()->update(['isVerified' => true]);
            return redirect('/home');
        }
        return back()->withErrors('OTP is expired or invalid');
    }

    public function showVerifyForm(){

        return view('OTP.verify');
    }
}
