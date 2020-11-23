<?php

namespace Tests\Feature;

use App\Mail\OTPMail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResendOTPTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_user_can_request_new_otp(){

        $user = $this->logInUser();
        $this->get('/verifyOTP');
        $response = $this->post('/resend_otp');
        $response->assertRedirect('/verifyOTP');
    }

    /**
     * @test
     */
    public function new_mail_sent_when_new_otp_requested(){

        Mail::fake();

        $user = $this->logInUser();
        $response = $this->post('/resend_otp');
        Mail::assertSent(OTPMail::class);
    }
}
