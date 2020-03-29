<?php

namespace Tests\Feature;

use App\Eloquents\EloquentUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterSuccess()
    {
        $userName = 'new_user';
        $password = 'password';
        $request = [
            'user' => [
                'email' => 'new-user@example.com',
                'password' => $password,
                'username' => $userName,
            ]
        ];
        $response = $this->postJson('/api/users', $request);

        $response->assertStatus(200)
            ->assertJson(['user' => []])
            ->assertSeeInOrder(['email', 'token', 'username', 'bio', 'image']);

        $registeredUser = EloquentUser::whereUserName($userName)->first();
        $this->assertTrue(Hash::check($password, $registeredUser->password));
    }

    public function testHasRegisteredEmail()
    {
        /** @var EloquentUser $registeredUser */
        $registeredUser = factory(EloquentUser::class, 1)->create()->first();

        $request = [
            'user' => [
                'email' => $registeredUser->email,
                'password' => 'password',
                'username' => 'new_user',
            ]
        ];
        $response = $this->postJson('/api/users', $request);

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'email' => []
                ]
            ]);
    }

    public function testHasRegisteredUserName()
    {
        /** @var EloquentUser $registeredUser */
        $registeredUser = factory(EloquentUser::class, 1)->create()->first();

        $request = [
            'user' => [
                'email' => $this->user->email,
                'password' => 'password',
                'username' => $registeredUser->user_name,
            ]
        ];
        $response = $this->postJson('/api/users', $request);

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'username' => []
                ]
            ]);
    }

    public function testRegisterFailedWhenEmptyRequest()
    {
        $request = [];
        $response = $this->postJson('/api/users', $request);

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'email' => [],
                    'username' => []
                ]
            ]);
    }
}
