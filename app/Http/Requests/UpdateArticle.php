<?php

namespace App\Http\Requests;

class UpdateArticle extends BaseRequest
{
    public function validationData()
    {
        return $this->get('article') ?? [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
            'body' => 'sometimes|string',
        ];
    }
}
