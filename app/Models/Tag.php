<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['name',];

    public function articles()
    {
        return $this->belongsToMany(
            Article::class,
            'article_tags',
            'tag_id',
            'article_id'
        );
    }
}
