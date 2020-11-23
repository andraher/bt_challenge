<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VerifyOTPTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->logInUser();
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */

    /**
     * @test
     */
    public function a_user_can_submit_otp_and_get_verified(){

        $otp = auth()->user()->cacheTheOTP();
        $this->post('/verifyOTP', ['otp' => $otp])->assertRedirect('/home');
        $this->assertDatabaseHas('users', ['isVerified' => 1]);
    }

    /**
     * @test
     */
    public function user_can_see_otp_verify_page(){

        $this->get('/verifyOTP')
             ->assertStatus(200)
             ->assertSee('Enter OTP');
    }

    /**
     * @test
     */
    public function invalid_otp_returns_error_message(){

        $this->post('/verifyOTP', ['otp' => 'Invalid OTP'])->assertSessionHasErrors();
    }

    /**
     * @test
     */
    public function if_no_otp_is_given_then_return_with_error(){

        $this->withExceptionHandling();
        $this->post('/verifyOTP', ['otp' => null])->assertSessionHasErrors(['otp']);
    }

}
