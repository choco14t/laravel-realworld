<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var User
     */
    protected $loggedInUser;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var array
     */
    protected $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $users = factory(User::class, 2)
            ->state('test')
            ->make()
            ->each(function (User $user, int $index) {
                $user->user_name .= "_{$index}";
                $user->save();
            });

        $this->loggedInUser = $users->first();
        $this->user = $users->last();
        $this->headers = ['Authorization' => "Token {$this->loggedInUser->token}"];
    }
}
