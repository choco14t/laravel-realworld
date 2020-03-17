<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EloquentComment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['user_id', 'body',];

    protected $with = ['user',];

    public function user()
    {
        return $this->belongsTo(EloquentUser::class);
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
