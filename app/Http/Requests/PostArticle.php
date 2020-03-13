<?php

namespace App\Http\Requests;

class PostArticle extends BaseRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'body' => 'required|string',
            'tagList' => 'sometimes|array',
        ];
    }
}
