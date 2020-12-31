<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostArticle;
use App\Http\Requests\UpdateArticle;
use App\ViewModels\ArticleViewModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['fetchList', 'fetch']]);
    }

    public function fetchList(Request $request)
    {
        $query = Article::relations(Auth::id())
            ->tag($request->get('tag', ''))
            ->author($request->get('author', ''))
            ->favoritedBy($request->get('favorited', ''));

        $articlesCount = $query->count();
        $articles = $query
            ->limit($request->get('limit', 20))
            ->offset($request->get('offset', 0))
            ->latest()
            ->get();

        return [
            'articles' => $articles->map(function (Article $article) {
                return (new ArticleViewModel($article, Auth::user()))->withoutKey();
            }),
            'articlesCount' => $articlesCount,
        ];
    }

    public function fetch(string $slug)
    {
        $article = Article::whereSlug($slug)->first();

        if ($article === null) {
            return response()->json([
                'errors' => [
                    'message' => $slug . ' is not found.'
                ],
            ], 404);
        }

        return new ArticleViewModel($article, Auth::user());
    }

    public function create(PostArticle $request)
    {
        $user = Auth::user();

        /** @var Article $article */
        $article = $user->articles()->create([
            'title' => $request->input('article.title'),
            'description' => $request->input('article.description'),
            'body' => $request->input('article.body'),
        ]);

        $tags = Collection::make(array_map(function ($name) {
            return ['name' => $name];
        }, $request->input('article.tagList') ?? []));

        if ($tags->isNotEmpty()) {
            $existsTags = Tag::query()
                ->select(['name'])
                ->whereIn('name', $tags)
                ->get();
            $notCreatedTags = $tags->whereNotIn('name', $existsTags->pluck('name'))->all();
            Tag::insert($notCreatedTags);

            $attachedTags = Tag::query()
                ->select(['id'])
                ->whereIn('name', $tags->pluck('name'))
                ->get();
            $article->tags()->attach($attachedTags);
        }

        return new ArticleViewModel($article, Auth::user());
    }

    public function update(UpdateArticle $request, string $slug)
    {
        $article = Article::query()
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

        $article->fill($request->input('article'))->save();

        return new ArticleViewModel($article, Auth::user());
    }

    public function delete(string $slug)
    {
        $article = Article::query()
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
