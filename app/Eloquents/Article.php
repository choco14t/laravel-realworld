<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Eloquents\Article
 *
 * @property int $id
 * @property int $user_id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Article whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Article whereUserId($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    protected $fillable = ['title', 'description', 'body',];
}
