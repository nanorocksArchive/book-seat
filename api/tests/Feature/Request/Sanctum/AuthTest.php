<?php

namespace Tests\Feature\Request\Sanctum;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_user_who_can_login_and_get_token()
    {
        // when
        $csrfCookie = $this->get('/sanctum/csrf-cookie')->getCookie('XSRF-TOKEN');

        $tokenResponse = $this->withCookie($csrfCookie->getName(), $csrfCookie->getValue())->postJson('/api/login', [
            'email' => 'admin@test.com',
            'password' => 'admin',
            'device_name' => 'Admin Profile'
        ]);

        $accessToken = json_decode($tokenResponse->getContent());

        $profile = $this->withHeader('Authorization', 'Bearer ' . $accessToken->token)->getJson('/api/user');

        $userProfileEmail = $profile->getData()->email;

        // then
        $this->assertDatabaseHas('users', [
            'email' => $userProfileEmail,
        ]);
    }

    public function test_that_user_who_not_exist()
    {
        $this->assertTrue(true);
    }

    public function test_that_user_who_can_logout()
    {
        $this->assertTrue(true);
    }

    public function test_that_user_who_is_not_autorized_to_logout()
    {
        $this->assertTrue(true);
    }
}
