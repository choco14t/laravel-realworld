<?php

namespace App\UseCases\Article\Tag;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Support\Collection;

class AssociateTags
{
    public function __invoke(Article $article, Collection $tags)
    {
        if ($tags->isNotEmpty()) {
            $existingTags = Tag::query()
                ->select(['name'])
                ->whereIn('name', $tags)
                ->get();
            $notCreatedTags = $tags->whereNotIn('name', $existingTags->pluck('name'))->all();

            Tag::query()->insert($notCreatedTags);

            $attachedTags = Tag::query()
                ->select(['id'])
                ->whereIn('name', $tags->pluck('name'))
                ->get();

            $article->tags()->attach($attachedTags);
        }
    }
}
