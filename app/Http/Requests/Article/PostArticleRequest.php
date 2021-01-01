<?php

namespace App\Http\Requests\Article;

use App\Http\Requests\BaseRequest;
use App\Models\Article;
use Illuminate\Support\Collection;

class PostArticleRequest extends BaseRequest
{
    public function validationData(): array
    {
        return $this->get('article') ?? [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'body' => 'required|string',
            'tagList' => 'sometimes|array',
        ];
    }

    public function makeArticle(): Article
    {
        return new Article($this->validated());
    }

    public function makeTags(): Collection
    {
        return Collection::make(array_map(function ($name) {
            return ['name' => $name];
        }, $this->input('article.tagList') ?? []));
    }
}
