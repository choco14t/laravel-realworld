<?php

namespace App\UseCases\Article;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use App\UseCases\Article\Tag\AssociateTags;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

class PostArticle
{
    /**
     * @var AssociateTags
     */
    private $associateTags;

    public function __construct(AssociateTags $associateTags)
    {
        $this->associateTags = $associateTags;
    }

    /**
     * @param Authenticatable|User $user
     * @param Article $article
     * @param Collection|Tag[] $tags
     * @return Article
     */
    public function __invoke(Authenticatable $user, Article $article, Collection $tags): Article
    {
        $article->user()->associate($user);
        $article->save();

        $this->associateTags->__invoke($article, $tags);

        return $article;
    }
}
