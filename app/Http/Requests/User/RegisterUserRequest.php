<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Models\User;

class RegisterUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'username' => 'required|unique:users,user_name',
        ];
    }

    public function validationData()
    {
        return $this->get('user') ?? [];
    }

    public function makeUser(): User
    {
        $attributes = $this->validated();
        $attributes['user_name'] = $attributes['username'];

        unset($attributes['username']);

        return new User($attributes);
    }
}
