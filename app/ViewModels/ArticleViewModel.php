<?php

namespace App\ViewModels;

use App\Eloquents\EloquentArticle;
use App\Eloquents\EloquentTag;
use App\Eloquents\EloquentUser;
use Spatie\ViewModels\ViewModel;

class ArticleViewModel extends ViewModel
{
    /**
     * @var EloquentArticle
     */
    private $article;
    /**
     * @var EloquentUser|null
     */
    private $loggedInUser;

    public function __construct(EloquentArticle $article, ?EloquentUser $loggedInUser)
    {
        $this->article = $article;
        $this->loggedInUser = $loggedInUser;
    }

    public function article()
    {
        return [
            "slug" => $this->article->slug,
            "title" => $this->article->title,
            "description" => $this->article->description,
            "body" => $this->article->body,
            "tagList" => $this->tagNameList(),
            "createdAt" => $this->article->created_at->toAtomString(),
            "updatedAt" => $this->article->updated_at->toAtomString(),
            "favorited" => $this->article->favorited->contains(
                'id',
                $this->loggedInUser->id ?? null
            ),
            "favoritesCount" => 0,
            "author" => [
                "username" => $this->article->user->user_name,
                "bio" => $this->article->user->bio,
                "image" => $this->article->user->image,
                "following" => $this->article->user->followers->contains(
                    'id',
                    $this->loggedInUser->id ?? null
                )
            ]
        ];
    }

    private function tagNameList()
    {
        return $this->article->tags->map(function (EloquentTag $tag) {
            return $tag->name;
        })->toArray();
    }
}
