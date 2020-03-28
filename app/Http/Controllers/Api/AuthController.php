<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\EloquentUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUser;
use App\Http\Requests\RegisterUser;
use App\ViewModels\UserViewModel;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginUser $request)
    {
        $credentials = [
            'email' => $request->input('user.email'),
            'password' => $request->input('user.password'),
        ];

        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'errors' => [
                    'message' => 'email or password is invalid'
                ]
            ], 422);
        }

        return new UserViewModel(Auth::user());
    }

    public function register(RegisterUser $request)
    {
        $user = EloquentUser::create($request->toAttributes());

        return new UserViewModel($user);
    }
}
