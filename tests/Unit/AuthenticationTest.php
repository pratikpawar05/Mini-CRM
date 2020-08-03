<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class AuthenticationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testBasicTest()
    {
        //Test by logging in user temporary
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/home');
    }
}
