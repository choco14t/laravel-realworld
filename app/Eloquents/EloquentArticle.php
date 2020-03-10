<?php

namespace App\Eloquents;

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
}
