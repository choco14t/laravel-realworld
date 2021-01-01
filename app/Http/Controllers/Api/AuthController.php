<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\User\LoginFailedException;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\UseCases\User\LoginUser;
use App\UseCases\User\RegisterUser;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request, LoginUser $usecase)
    {
        try {
            $usecase($request);
        } catch (LoginFailedException $exception) {
            return response()->json([
                'errors' => [
                    'message' => 'email or password is invalid'
                ]
            ], 422);
        }

        return new UserResource(Auth::user());
    }

    public function register(RegisterUserRequest $request, RegisterUser $usecase)
    {
        return new UserResource($usecase($request->makeUser()));
    }
}
