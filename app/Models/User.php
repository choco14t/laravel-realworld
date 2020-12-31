<?php

namespace App\Models;

use App\Extensions\HashedPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HashedPassword;

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
            ->belongsToMany(self::class, 'follow_users', 'followed_user_id', 'following_user_id')
            ->withTimestamps();
    }

    public function followers()
    {
        return $this
            ->belongsToMany(self::class, 'follow_users', 'following_user_id', 'followed_user_id')
            ->withTimestamps();
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id')->latest();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function favorites()
    {
        return $this->belongsToMany(
            Article::class,
            'favorites',
            'user_id',
            'article_id'
        );
    }
}
