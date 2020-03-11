<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\EloquentArticle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $article = EloquentArticle::whereSlug($slug)->first();

        if ($article === null) {
            return response()->json([
                'errors' => [
                    'message' => $slug . ' is not found.'
                ],
            ], 404);
        }

        $author = $article->user()->first();
        $following = Auth::check() ? Auth::user()->following($article->user->id) : false;
        $articleAuthor = [
            'author' => [
                'username' => $author->user_name,
                'bio' => $author->bio,
                'image' => $author->image,
                'following' => $following,
            ]
        ];

        return [
            'article' => array_merge($article->toArray(), $articleAuthor),
        ];
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
