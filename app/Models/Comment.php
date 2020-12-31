<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
                return $query->where('follower_id', $userId);
            }
        ]);
    }
}
