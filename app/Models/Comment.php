<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int $user_id
 * @property int $article_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static Builder|Comment followers(?int $userId)
 * @method static Builder|Comment newModelQuery()
 * @method static Builder|Comment newQuery()
 * @method static Builder|Comment query()
 * @method static Builder|Comment whereArticleId($value)
 * @method static Builder|Comment whereBody($value)
 * @method static Builder|Comment whereCreatedAt($value)
 * @method static Builder|Comment whereId($value)
 * @method static Builder|Comment whereUpdatedAt($value)
 * @method static Builder|Comment whereUserId($value)
 */
class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['user_id', 'body',];

    protected $with = ['user',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFollowers(Builder $query, ?int $userId)
    {
        return $query->with([
            'user.followers' => function (BelongsToMany $query) use ($userId) {
                return $query->where('followed_user_id', $userId);
            }
        ]);
    }
}
