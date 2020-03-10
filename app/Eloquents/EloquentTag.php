<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

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
