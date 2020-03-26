<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginSuccess()
    {
        $request = [
            'user' => [
                'email' => $this->user->email,
                'password' => 'password'
            ]
        ];
        $response = $this->postJson('/api/users/login', $request);

        $response->assertStatus(200)
            ->assertJson([
                'user' => [
                    'email' => $this->user->email,
                    'username' => $this->user->user_name,
                    'bio' => $this->user->bio,
                    'image' => $this->user->image
                ]
            ])
            ->assertSeeInOrder(['email', 'token', 'username', 'bio', 'image']);
    }

    public function testLoginFailedWhenEmptyRequest()
    {
        $request = [];
        $response = $this->postJson('/api/users/login', $request);

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'email' => [],
                    'password' => []
                ]
            ]);
    }

    public function testLoginFailedWhenInvalidEmail()
    {
        $request = [
            'user' => [
                'email' => 'invalid-email',
                'password' => 'password'
            ]
        ];
        $response = $this->postJson('/api/users/login', $request);

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'email' => [],
                ]
            ]);
    }

    public function testLoginFailedWhenInvalidPassword()
    {
        $request = [
            'user' => [
                'email' => $this->user->email,
                'password' => 'invalid-password'
            ]
        ];
        $response = $this->postJson('/api/users/login', $request);

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'message' => 'email or password is invalid',
                ]
            ]);
    }
}
