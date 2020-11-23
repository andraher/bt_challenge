<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResendOTPController extends Controller
{
   public function resend(){

       auth()->user()->sendOTP();
       return back()->with( 'Message', 'Your new OTP is sent!');

   }
}
