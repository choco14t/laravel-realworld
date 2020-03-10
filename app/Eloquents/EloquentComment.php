<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class EloquentComment extends Model
{
    protected $table = 'comments';

    protected $fillable = ['body',];
}
