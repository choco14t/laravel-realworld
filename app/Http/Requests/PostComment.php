<?php

namespace App\Http\Requests;

class PostComment extends BaseRequest
{
    public function validationData()
    {
        return $this->input('comment') ?? [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|string'
        ];
    }
}
