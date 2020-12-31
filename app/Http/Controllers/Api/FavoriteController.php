<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Http\Controllers\Controller;
use App\ViewModels\ArticleViewModel;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function favorite(string $slug)
    {
        $user = Auth::user();
        $article = Article::whereSlug($slug)->first();

        if ($article === null) {
            return response()->json([
                'errors' => [
                    'message' => 'Article not Found.'
                ]
            ], 404);
        }

        if (!$article->favorited()->get()->contains('id', $user->id)) {
            $article->favorited()->attach($user->id);
        }

        return new ArticleViewModel($article, $user);
    }

    public function unfavorite(string $slug)
    {
        $user = Auth::user();
        $article = Article::whereSlug($slug)->first();

        if ($article === null) {
            return response()->json([
                'errors' => [
                    'message' => 'Article not Found.'
                ]
            ], 404);
        }

        if ($article->favorited()->get()->contains('id', $user->id)) {
            $article->favorited()->detach($user->id);
        }

        return new ArticleViewModel($article, $user);
    }
}
