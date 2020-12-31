<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\User\LoginFailedException;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\RegisterUser;
use App\UseCases\User\LoginUser;
use App\ViewModels\UserViewModel;
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

    public function register(RegisterUser $request)
    {
        $user = User::create($request->toAttributes());

        return new UserViewModel($user);
    }
}
