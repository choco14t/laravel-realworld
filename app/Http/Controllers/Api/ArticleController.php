<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\EloquentArticle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['fetchList', 'fetch']]);
    }

    public function fetchList(Request $request)
    {
        $articles = EloquentArticle::tag($request->get('tag', ''))
            ->author($request->get('author', ''))
            ->favoritedBy($request->get('favorited', ''))
            ->get();

        return [
            'articles' => $articles->toArray(),
            'articlesCount' => $articles->count(),
        ];
    }

    public function fetch(string $slug)
    {
    }

    public function create()
    {
    }

    public function update(string $slug)
    {
    }

    public function delete(string $slug)
    {
    }
}
