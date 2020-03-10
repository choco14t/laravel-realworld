<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Eloquents\EloquentComment
 *
 * @property int $id
 * @property int $user_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentComment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentComment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentComment whereUserId($value)
 * @mixin \Eloquent
 * @property int $article_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentComment whereArticleId($value)
 */
class EloquentComment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['body',];
}
