<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUser;
use App\ViewModels\UserViewModel;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function currentUser()
    {
        return new UserViewModel(Auth::user());
    }

    public function update(UpdateUser $request)
    {
        $user = Auth::user();
        $user->fill($request->toAttributes())->save();

        return new UserViewModel($user);
    }
}
