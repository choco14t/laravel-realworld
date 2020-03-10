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
    protected $fillable = ['name',];
}
