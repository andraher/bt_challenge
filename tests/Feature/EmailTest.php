<?php

namespace Tests\Feature;

use App\Mail\OTPMail;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    /**
     * @test
     */
    public function an_otp_email_is_sent_when_logged_in(){

        Mail::fake();
        $user = factory(User::class)->create();
        $res = $this->post('/login',['email' => $user->email, 'password' => 'secret']);
        Mail::assertSent(OTPMail::class);
    }

    /**
     * @test
     */
    public function an_otp_email_not_sent_if_credentials_incorrect(){

        Mail::fake();
        $this->withExceptionHandling();
        $user = factory(User::class)->create();
        $res = $this->post('/login',['email' => $user->email, 'password' => 'secret']);
        Mail::assertNotSent(OTPMail::class);
    }

    /**
     * @test
     */
    public function otp_stored_in_cache_for_user(){

        $user = factory(User::class)->create();
        $res = $this->post('/login', ['email' => $user->email, 'password' => 'secret']);
        $this->assertNotNull($user->otp());
    }

}
