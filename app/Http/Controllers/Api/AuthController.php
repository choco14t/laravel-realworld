<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\EloquentUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUser;
use App\Http\Requests\RegisterUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginUser $request)
    {
        $credentials = [
            'email' => $request->input('user.email'),
            'password' => $request->input('user.password'),
        ];

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return [
            'user' => [
                'email' => Auth::user()->email,
                'password' => Auth::user()->password,
                'token' => $token,
            ],
        ];
    }

    public function register(RegisterUser $request)
    {
        $user = EloquentUser::create([
            'user_name' => $request->input('user.username'),
            'email' => $request->input('user.email'),
            'password' => Hash::make($request->input('user.password')),
        ]);

        return [
            'user' => [
                'username' => $user->user_name,
                'email' => $user->email,
                'password' => $user->password,
            ],
        ];
    }
}
