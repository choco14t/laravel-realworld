<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function fetch()
    {
        $tags = Tag::all()->pluck('name');

        return [
            'tags' => $tags,
        ];
    }
}
