<?php

namespace Tests\Feature;

use App\Eloquents\EloquentUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testUpdateSuccess()
    {
        $password = 'update';
        $request = [
            'user' => [
                'email' => 'update@example.com',
                'username' => 'update_user',
                'password' => $password,
                'image' => $this->faker->imageUrl(),
                'bio' => 'update user',
            ]
        ];
        $response = $this->putJson('/api/user', $request, $this->headers);

        $expectedJson = $request;
        unset($expectedJson['user']['password']);
        $response->assertStatus(200)->assertJson($expectedJson);

        $updatedUser = EloquentUser::find($this->loggedInUser->id);
        $this->assertTrue(Hash::check($password, $updatedUser->password));
    }

    public function testUpdateFailedWhenInvalidRequest()
    {
        $request = [
            'user' => [
                'email' => '',
                'username' => '',
                'password' => '',
                'image' => 'not url',
                'bio' => Str::random(256),
            ]
        ];
        $response = $this->putJson('/api/user', $request, $this->headers);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'email' => [],
                'username' => [],
                'password' => [],
                'image' => [],
                'bio' => [],
            ]
        ]);
    }

    public function testUpdateFailedWhenDuplicated()
    {
        $request = [
            'user' => [
                'email' => $this->user->email,
                'username' => $this->user->user_name,
            ]
        ];
        $response = $this->putJson('/api/user', $request, $this->headers);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                'email' => ['The email has already been taken.'],
                'username' => ['The username has already been taken.'],
            ]
        ]);
    }
}
