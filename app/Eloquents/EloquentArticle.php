<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentArticle extends Model
{
    protected $table = 'articles';

    protected $fillable = ['title', 'description', 'body',];

    protected $appends = ['tagList',];

    public function user()
    {
        return $this->belongsTo(EloquentUser::class);
    }

    public function tags()
    {
        return $this->belongsToMany(EloquentTag::class, 'article_tags', 'article_id', 'tag_id');
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

    public function scopeTag(Builder $query, ?string $tagName)
    {
        $tag = EloquentTag::whereName($tagName)->first();
        if ($tag === null) {
            return $query;
        }

        $articleIdList = $tag->articles()->pluck('article_id')->toArray();

        return $query->whereIn('id', $articleIdList);
    }

    public function scopeAuthor(Builder $query, ?string $userName)
    {
        $user = EloquentUser::whereUserName($userName)->first();
        if ($user === null) {
            return $query;
        }

        return $query->where('user_id', $user->id);
    }

    public function scopeFavoritedBy(Builder $query, ?string $userName)
    {
        $user = EloquentUser::whereUserName($userName)->first();
        if ($user === null) {
            return $query;
        }

        $articleIdList = $user->favorites()->pluck('article_id')->toArray();

        return $query->whereIn('id', $articleIdList);
    }
}
