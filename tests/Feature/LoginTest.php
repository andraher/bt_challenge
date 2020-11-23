<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function after_login_user_cant_access_home_page_until_verified(){

        $this->logInUser();
        $this->get('/home')->assertRedirect('/verifyOTP');

    }


    /**
     * @test
     */
    public function after_login_user_can_access_home_page_if_verified(){

        $this->logInUser(['isVerified' => 1]);
        $this->get('/home')->assertStatus(200);
    }


}
