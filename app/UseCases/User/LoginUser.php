<?php

namespace App\UseCases\User;

use App\Exceptions\User\LoginFailedException;
use App\Http\Requests\User\LoginUserRequest;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class LoginUser
{
    /**
     * @param LoginUserRequest $request
     * @return Authenticatable|null
     * @throws LoginFailedException
     */
    public function __invoke(LoginUserRequest $request): ?Authenticatable
    {
        $credentials = [
            'email' => $request->input('user.email'),
            'password' => $request->input('user.password'),
        ];

        if (!Auth::attempt($credentials)) {
            throw new LoginFailedException('email or password is invalid');
        }

        return Auth::user();
    }
}
