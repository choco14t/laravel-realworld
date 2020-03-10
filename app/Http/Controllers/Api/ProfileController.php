<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'fetch']);
    }

    public function show(string $userName)
    {
        $user = User::query()->where('user_name', '=', $userName)->first();

        if ($user === null) {
            return response()->json([
                'errors' => [
                    'message' => $userName . ' is not found.'
                ],
            ], 404);
        }

        $following = Auth::check() ? Auth::user()->following($user->id) : false;
        return [
            'profile' => [
                'username' => $user->user_name,
                'bio' => $user->bio,
                'image' => $user->image,
                'following' => $following,
            ]
        ];
    }

    public function follow(string $userName)
    {
        $user = User::query()->where('user_name', '=', $userName)->first();

        if ($user === null) {
            return response()->json([
                'errors' => [
                    'message' => $userName . ' is not found.'
                ],
            ], 404);
        }

        Auth::user()->follow($user->id);
        return [
            'profile' => [
                'username' => $user->user_name,
                'bio' => $user->bio,
                'image' => $user->image,
                'following' => true,
            ]
        ];
    }

    public function unfollow(string $userName)
    {
        $user = User::query()->where('user_name', '=', $userName)->first();

        if ($user === null) {
            return response()->json([
                'errors' => [
                    'message' => $userName . ' is not found.'
                ],
            ], 404);
        }

        Auth::user()->unfollow($user->id);
        return [
            'profile' => [
                'username' => $user->user_name,
                'bio' => $user->bio,
                'image' => $user->image,
                'following' => false,
            ]
        ];
    }
}
