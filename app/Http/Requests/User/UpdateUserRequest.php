<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Models\User;

class UpdateUserRequest extends BaseRequest
{
    public function validationData()
    {
        return $this->get('user') ?? [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'sometimes|max:255|email|unique:users,email,' . $this->user()->id,
            'password' => 'sometimes|min:6|max:255',
            'username' => 'sometimes|filled|max:255|unique:users,user_name,' . $this->user()->id,
            'image' => 'sometimes|max:2048|url',
            'bio' => 'sometimes|max:255',
        ];
    }

    public function makeUser(): User
    {
        $attributes = $this->validated();

        if ($this->has('user.username')) {
            $attributes['user_name'] = $attributes['username'];
        }

        /** @var User $user */
        $user = $this->user();
        $user->fill($attributes);

        return $user;
    }
}
