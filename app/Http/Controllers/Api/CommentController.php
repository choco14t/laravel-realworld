<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\EloquentArticle;
use App\Eloquents\EloquentComment;
use App\Http\Controllers\Controller;
use App\ViewModels\CommentViewModel;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'fetch']);
    }

    public function fetch(string $slug)
    {
        $article = EloquentArticle::whereSlug($slug)->first();
        if ($article === null) {
            return response()->json(['message' => 'Article not Found.'], 404);
        }

        $comments = $article->comments()->get();

        return [
            'comments' => $comments->map(function (EloquentComment $comment) {
                return (new CommentViewModel($comment))->itemsWithoutKey();
            })
        ];
    }

    public function create(string $slug)
    {
    }

    public function delete(string $slug, int $id)
    {
    }
}
