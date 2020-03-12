<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\EloquentArticle;
use App\Http\Controllers\Controller;
use App\ViewModels\ArticleViewModel;
use Exception;
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
        $query = EloquentArticle::relations(Auth::id())
            ->tag($request->get('tag', ''))
            ->author($request->get('author', ''))
            ->favoritedBy($request->get('favorited', ''))
            ->limit($request->get('limit', 20))
            ->offset($request->get('offset', 0));

        $articles = $query->get();
        $articlesCount = $query->count();

        return [
            'articles' => $articles->map(function (EloquentArticle $article) {
                return new ArticleViewModel($article, Auth::user());
            }),
            'articlesCount' => $articlesCount,
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

        return new ArticleViewModel($article, Auth::user());
    }

    public function create()
    {
    }

    public function update(string $slug)
    {
    }

    public function delete(string $slug)
    {
        $article = EloquentArticle::query()
            ->whereSlug($slug)
            ->first();

        if ($article === null) {
            return response()->json([
                'errors' => [
                    'message' => $slug . ' is not found.'
                ],
            ], 404);
        }

        if ($article->user_id !== Auth::id()) {
            return response()->json([
                'errors' => [
                    'message' => 'This action is unauthorized.'
                ],
            ], 403);
        }

        try {
            $article->delete();
        } catch (Exception $e) {
            return response()->json([
                'errors' => [
                    'message' => 'Deletion failed. Please try again :('
                ],
            ], 500);
        }

        return [
            'message' => $article->title . ' was deleted.'
        ];
    }
}
