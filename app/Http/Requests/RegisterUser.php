<?php

namespace App\Http\Requests;

class RegisterUser extends BaseRequest
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

    public function toAttributes(): array
    {
        $attributes = $this->validated();
        $attributes['user_name'] = $attributes['username'];
        unset($attributes['username']);

        return $attributes;
    }
}
