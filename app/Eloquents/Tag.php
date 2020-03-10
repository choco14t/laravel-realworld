<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Eloquents\Tag
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eloquents\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    protected $fillable = ['name',];
}
