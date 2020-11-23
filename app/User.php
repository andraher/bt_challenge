<?php

namespace App;

use App\Mail\OTPMail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'isVerified',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function otp(){

        return Cache::get($this->OTPKey());
    }

    public  function OTPKey(){

        return "OTP_for_{$this->id}";
    }

    public function cacheTheOTP (){

        $otp = rand(100000,999999);
        Cache::put([$this->OTPKey() => $otp], now()->addSeconds(120));

        return $otp;
    }

    public function sendOTP(){

        Mail::to("{$this->email}")->send(new OTPMail($this->cacheTheOTP())); //new Mailable
    }
}
