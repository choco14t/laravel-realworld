<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function currentUser()
    {
        $user = Auth::user();
        return [
            'user' => [
                'email' => $user->email,
                'token' => $user->token,
                'username' => $user->user_name,
                'bio' => $user->bio,
                'image' => $user->image,
            ]
        ];
    }

    public function update(UpdateUser $request)
    {
        $user = Auth::user();
        $user->fill($request->validated())->save();

        return [
            'user' => [
                'email' => $user->email,
                'token' => $user->token,
                'username' => $user->user_name,
                'bio' => $user->bio,
                'image' => $user->image,
            ]
        ];
    }
}
