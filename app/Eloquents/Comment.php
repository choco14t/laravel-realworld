<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Eloquents\Comment
 *
 * @property int $id
 * @property int $user_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Comment whereUserId($value)
 * @mixin \Eloquent
 * @property int $article_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Comment whereArticleId($value)
 */
class Comment extends Model
{
    protected $fillable = ['body',];
}
