<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Eloquents\EloquentArticle
 *
 * @property int $id
 * @property int $user_id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentArticle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentArticle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentArticle query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentArticle whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentArticle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentArticle whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentArticle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentArticle whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentArticle whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentArticle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentArticle whereUserId($value)
 * @mixin \Eloquent
 */
class EloquentArticle extends Model
{
    protected $table = 'articles';

    protected $fillable = ['title', 'description', 'body',];

    protected $appends = ['tagList',];

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
