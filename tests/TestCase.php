<?php

namespace Tests;

use App\Eloquents\EloquentUser;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var EloquentUser
     */
    protected $loggedInUser;

    /**
     * @var EloquentUser
     */
    protected $user;

    /**
     * @var array
     */
    protected $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $users = factory(EloquentUser::class, 'test', 2)
            ->make()
            ->each(function (EloquentUser $user, int $index) {
                $user->user_name .= "_{$index}";
                $user->save();
            });

        $this->loggedInUser = $users->first();
        $this->user = $users->last();
        $this->headers = ['Authorization' => "Token {$this->loggedInUser->token}"];
    }
}
