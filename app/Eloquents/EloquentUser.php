<?php

namespace App\Eloquents;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

class EloquentUser extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'email', 'password', 'bio', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getTokenAttribute()
    {
        return JWTAuth::fromUser($this);
    }

    public function follow(int $userId)
    {
        if ($this->following($userId)) {
            return;
        }

        $this->followings()->attach($userId);
    }

    public function unfollow(int $userId)
    {
        if (!$this->following($userId)) {
            return;
        }

        $this->followings()->detach($userId);
    }

    public function following(int $userId): bool
    {
        return $this->followings()->find($userId) !== null;
    }

    public function followings()
    {
        return $this
            ->belongsToMany(self::class, 'follows', 'follower_id', 'followed_id')
            ->withTimestamps();
    }

    public function followers()
    {
        return $this
            ->belongsToMany(self::class, 'follows', 'followed_id', 'follower_id')
            ->withTimestamps();
    }

    public function articles()
    {
        return $this->hasMany(EloquentArticle::class, 'user_id')->latest();
    }

    public function comments()
    {
        return $this->hasMany(EloquentComment::class)->latest();
    }

    public function favorites()
    {
        return $this->belongsToMany(
            EloquentArticle::class,
            'favorites',
            'user_id',
            'article_id'
        );
    }
}
