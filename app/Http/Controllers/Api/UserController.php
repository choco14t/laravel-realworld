<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\UseCases\User\UpdateUser;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function currentUser()
    {
        return new UserResource(Auth::user());
    }

    public function update(UpdateUserRequest $request, UpdateUser $usecase)
    {
        return new UserResource($usecase($request->makeUser()));
    }
}
