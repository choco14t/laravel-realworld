<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Eloquents\EloquentTag
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentTag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\EloquentTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EloquentTag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['name',];

    public function articles()
    {
        return $this->belongsToMany(
            EloquentArticle::class,
            'article_tags',
            'tag_id',
            'article_id'
        );
    }
}
