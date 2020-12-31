<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Comment;
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
        $article = Article::whereSlug($slug)->first();
        if ($article === null) {
            return response()->json(['message' => 'Article not Found.'], 404);
        }

        $comments = Comment::whereArticleId($article->id)
            ->followers(Auth::id())
            ->get();

        return [
            'comments' => $comments->map(function (Comment $comment) {
                return (new CommentViewModel($comment, Auth::user()))->itemsWithoutKey();
            })
        ];
    }

    public function create(PostComment $request, string $slug)
    {
        $article = Article::whereSlug($slug)->first();
        if ($article === null) {
            return response()->json([
                'errors' => [
                    'message' => 'Article is not found.'
                ]
            ], 404);
        }

        /** @var Comment $comment */
        $comment = $article->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->input('comment.body')
        ]);

        return new CommentViewModel($comment, Auth::user());
    }

    public function delete(string $slug, int $id)
    {
        $article = Article::whereSlug($slug)->first();
        if ($article === null) {
            return response()->json([
                'errors' => [
                    'message' => 'Article is not found.'
                ]
            ], 404);
        }

        /** @var Comment|null $comment */
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
