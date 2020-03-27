<?php

namespace App\Http\Requests;

class UpdateUser extends BaseRequest
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
            'username' => 'sometimes|max:255|unique:users,user_name,' . $this->user()->id,
            'image' => 'sometimes|max:2048|url',
            'bio' => 'sometimes|max:255',
        ];
    }
}
