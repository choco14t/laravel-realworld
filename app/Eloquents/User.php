<?php

namespace App\Eloquents;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * App\Eloquents\User
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string|null $bio
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User whereUsername($value)
 * @mixin \Eloquent
 * @property-read mixed $token
 * @property string $user_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\User whereUserName($value)
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

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
        return $this->hasMany(Article::class)->latest();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}
