<?php

namespace App\Http\Resources;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Article
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'article' => [
                'slug' => $this->slug,
                'title' => $this->title,
                'description' => $this->description,
                'body' => $this->body,
                'tagList' => $this->tagNameList(),
                'createdAt' => $this->formatFrom($this->created_at),
                'updatedAt' => $this->formatFrom($this->updated_at),
                'favorited' => $this->favorited->contains(
                    'id',
                    $this->loggedInUser->id ?? null
                ),
                'favoritesCount' => $this->favorited->count(),
                'author' => [
                    'username' => $this->user->user_name,
                    'bio' => $this->user->bio,
                    'image' => $this->user->image,
                    'following' => $this->user->followers->contains(
                        'id',
                        $this->loggedInUser->id ?? null
                    )
                ]
            ],
        ];
    }

    private function tagNameList(): array
    {
        return $this->tags->map(function (Tag $tag) {
            return $tag->name;
        })->toArray();
    }
}
