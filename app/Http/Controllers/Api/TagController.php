<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\EloquentTag;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function fetch()
    {
        $tags = EloquentTag::all()->pluck('name');

        return [
            'tags' => $tags,
        ];
    }
}
