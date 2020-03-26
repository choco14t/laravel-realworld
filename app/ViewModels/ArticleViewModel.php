<?php

namespace App\ViewModels;

use App\Eloquents\EloquentArticle;
use App\Eloquents\EloquentTag;
use App\Eloquents\EloquentUser;
use Spatie\ViewModels\ViewModel;

class ArticleViewModel extends ViewModel
{
    use FormattableTimestamps;

    protected $ignore = ['withoutKey',];

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
            "createdAt" => $this->formatFrom($this->article->created_at),
            "updatedAt" => $this->formatFrom($this->article->updated_at),
            "favorited" => $this->article->favorited->contains(
                'id',
                $this->loggedInUser->id ?? null
            ),
            "favoritesCount" => $this->article->favorited->count(),
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

    public function withoutKey()
    {
        return $this->items()->get('article');
    }

    private function tagNameList()
    {
        return $this->article->tags->map(function (EloquentTag $tag) {
            return $tag->name;
        })->toArray();
    }
}
