<?php

namespace App\UseCases\User;

use App\Models\User;

class UpdateUser
{
    public function __invoke(User $user): User
    {
        $user->save();

        return $user;
    }
}
