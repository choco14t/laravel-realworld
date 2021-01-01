<?php

namespace App\Models;

use App\Extensions\HasSlug;
use App\ViewModels\FormattableTimestamps;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property int $user_id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $favorited
 * @property-read int|null $favorited_count
 * @property-read mixed $tag_list
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
 * @method static Builder|Article author(?string $userName)
 * @method static Builder|Article favoritedBy(?string $userName)
 * @method static Builder|Article feed(array $followingIdList)
 * @method static Builder|Article newModelQuery()
 * @method static Builder|Article newQuery()
 * @method static Builder|Article query()
 * @method static Builder|Article relations(?int $userId)
 * @method static Builder|Article tag(?string $tagName)
 * @method static Builder|Article whereBody($value)
 * @method static Builder|Article whereCreatedAt($value)
 * @method static Builder|Article whereDescription($value)
 * @method static Builder|Article whereId($value)
 * @method static Builder|Article whereSlug($value)
 * @method static Builder|Article whereTitle($value)
 * @method static Builder|Article whereUpdatedAt($value)
 * @method static Builder|Article whereUserId($value)
 */
class Article extends Model
{
    use HasSlug, FormattableTimestamps;

    protected $table = 'articles';

    protected $fillable = ['title', 'description', 'body',];

    protected $with = ['tags', 'user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'article_tags',
            'article_id',
            'tag_id'
        )->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id');
    }

    public function favorited()
    {
        return $this->belongsToMany(
            User::class,
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
                return $query->where('followed_user_id', $userId);
            }
        ])->with([
            'favorited' => function (BelongsToMany $query) use ($userId) {
                return $query->where('user_id', $userId);
            }
        ])->withCount('favorited');
    }

    public function scopeFeed(Builder $query, array $followingIdList)
    {
        return $query->whereIn('user_id', $followingIdList);
    }

    public function scopeTag(Builder $query, ?string $tagName)
    {
        if (empty($tagName)) {
            return $query;
        }

        $tag = Tag::whereName($tagName)->first();
        $articleIdList = $tag ? $tag->articles()->pluck('article_id')->toArray() : [];

        return $query->whereIn('id', $articleIdList);
    }

    public function scopeAuthor(Builder $query, ?string $userName)
    {
        if (empty($userName)) {
            return $query;
        }

        $user = User::whereUserName($userName)->first();

        return $query->where('user_id', $user->id ?? null);
    }

    public function scopeFavoritedBy(Builder $query, ?string $userName)
    {
        if (empty($userName)) {
            return $query;
        }

        $user = User::whereUserName($userName)->first();
        $articleIdList = $user ? $user->favorites()->pluck('article_id')->toArray() : [];

        return $query->whereIn('id', $articleIdList);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
