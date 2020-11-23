<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function logInUser($args = []){

        $user = factory(User::class)->create($args);
        $this->actingAs($user);
        return $user;
    }
}
