<?php

namespace App\UseCases\User;

use App\Models\User;

class RegisterUser
{
    /**
     * @param User $user
     * @return User
     */
    public function __invoke(User $user)
    {
        $user->save();

        return $user;
    }
}
