<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\EloquentArticle;
use App\Http\Controllers\Controller;
use App\ViewModels\ArticleViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function fetch(Request $request)
    {
        $user = Auth::user();
        $query = EloquentArticle::relations($user->id)
            ->feed($user->followings->pluck('id')->all())
            ->latest();

        $articlesCount = $query->count();
        $articles = $query
            ->limit($request->get('limit', 20))
            ->offset($request->get('offset', 0))
            ->get();

        return [
            'articles' => $articles->map(function (EloquentArticle $article) use ($user) {
                return (new ArticleViewModel($article, $user))->withoutKey();
            }),
            'articlesCount' => $articlesCount,
        ];
    }
}
