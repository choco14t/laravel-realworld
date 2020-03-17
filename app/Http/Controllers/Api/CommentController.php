<?php

namespace App\Http\Controllers\Api;

use App\Eloquents\EloquentArticle;
use App\Eloquents\EloquentComment;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostComment;
use App\ViewModels\CommentViewModel;
use Exception;
use Illuminate\Support\Facades\Auth;

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

    public function create(PostComment $request, string $slug)
    {
        $article = EloquentArticle::whereSlug($slug)->first();
        if ($article === null) {
            return response()->json([
                'errors' => [
                    'message' => 'Article is not found.'
                ]
            ], 404);
        }

        /** @var EloquentComment $comment */
        $comment = $article->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->input('comment.body')
        ]);

        return new CommentViewModel($comment);
    }

    public function delete(string $slug, int $id)
    {
        $article = EloquentArticle::whereSlug($slug)->first();
        if ($article === null) {
            return response()->json([
                'errors' => [
                    'message' => 'Article is not found.'
                ]
            ], 404);
        }

        /** @var EloquentComment|null $comment */
        $comment = $article->comments()->whereKey($id)->get()->first();
        if ($comment === null) {
            return response()->json([
                'errors' => [
                    'message' => 'Comment is not found.'
                ]
            ], 404);
        }

        if ($comment->user_id !== Auth::id()) {
            return response()->json([
                'errors' => [
                    'message' => 'This action is unauthorized.'
                ]
            ], 403);
        }

        try {
            $comment->delete();
        } catch (Exception $e) {
            return response()->json([
                'errors' => [
                    'message' => 'Deletion failed. Please try again :('
                ],
            ], 500);
        }

        return [
            'message' => 'Comment was successfully deleted.',
        ];
    }
}
