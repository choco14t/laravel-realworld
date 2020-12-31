<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class LoginUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function validationData()
    {
        return $this->get('user') ?? [];
    }
}
