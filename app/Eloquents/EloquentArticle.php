<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EloquentArticle extends Model
{
    protected $table = 'articles';

    protected $fillable = ['title', 'description', 'body',];

    protected $with = ['tags', 'user'];

    public function user()
    {
        return $this->belongsTo(EloquentUser::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            EloquentTag::class,
            'article_tags',
            'article_id',
            'tag_id'
        )->withTimestamps();
    }

    public function favorited()
    {
        return $this->belongsToMany(
            EloquentUser::class,
            'favorites',
            'article_id',
            'user_id'
        )->withTimestamps();
    }

    public function getTagListAttribute()
    {
        return $this->tags()->pluck('name')->toArray();
    }

    public function scopeRelations(Builder $query, ?int $userId)
    {
        return $query->with([
            'user.followers' => function (BelongsToMany $query) use ($userId) {
                return $query->where('follower_id', $userId);
            }
        ])->with([
            'favorited' => function (BelongsToMany $query) use ($userId) {
                return $query->where('user_id', $userId);
            }
        ])->withCount('favorited');
    }

    public function scopeTag(Builder $query, ?string $tagName)
    {
        if (empty($tagName)) {
            return $query;
        }

        $tag = EloquentTag::whereName($tagName)->first();
        $articleIdList = $tag ? $tag->articles()->pluck('article_id')->toArray() : [];

        return $query->whereIn('id', $articleIdList);
    }

    public function scopeAuthor(Builder $query, ?string $userName)
    {
        if (empty($userName)) {
            return $query;
        }

        $user = EloquentUser::whereUserName($userName)->first();

        return $query->where('user_id', $user->id ?? null);
    }

    public function scopeFavoritedBy(Builder $query, ?string $userName)
    {
        if (empty($userName)) {
            return $query;
        }

        $user = EloquentUser::whereUserName($userName)->first();
        $articleIdList = $user ? $user->favorites()->pluck('article_id')->toArray() : [];

        return $query->whereIn('id', $articleIdList);
    }
}
