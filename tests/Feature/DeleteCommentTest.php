<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCommentTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteSuccessful()
    {
        /** @var Article $article */
        /** @var Comment $comment */
        list($article, $comment) = $this->setUpResource($this->loggedInUser->id);

        $response = $this->delete(
            "/api/articles/{$article->slug}/comments/{$comment->id}",
            [],
            $this->headers
        );

        $response->assertStatus(200);
        $this->assertNull(Comment::find($comment->id));
    }

    public function testReturnErrorsWhenArticleNotFound()
    {
        /** @var Article $article */
        /** @var Comment $comment */
        list($article, $comment) = $this->setUpResource($this->loggedInUser->id);

        $invalidSlug = $article->slug . '_';
        $response = $this->delete(
            "/api/articles/{$invalidSlug}/comments/{$comment->id}",
            [],
            $this->headers
        );

        $response->assertStatus(404);
        $this->assertNotNull(Comment::find($comment->id));
    }

    public function testReturnErrorsWhenCommentNotFound()
    {
        /** @var Article $article */
        /** @var Comment $comment */
        list($article, $comment) = $this->setUpResource($this->loggedInUser->id);

        $invalidCommentId = $comment->id + 1;
        $response = $this->delete(
            "/api/articles/{$article->slug}/comments/{$invalidCommentId}",
            [],
            $this->headers
        );

        $response->assertStatus(404);
        $this->assertNotNull(Comment::find($comment->id));
    }

    public function testReturnErrosWhenDeleteOtherUsersComment()
    {
        /** @var Article $article */
        /** @var Comment $comment */
        list($article, $comment) = $this->setUpResource($this->user->id);

        $response = $this->delete(
            "/api/articles/{$article->slug}/comments/{$comment->id}",
            [],
            $this->headers
        );

        $response->assertStatus(403);
        $this->assertNotNull(Comment::find($comment->id));
    }

    private function setUpResource(int $commentUserId)
    {
        /** @var Article $article */
        $article = $this->user
            ->articles()
            ->save(factory(Article::class, 1)->make()->first());

        /** @var Comment $comment */
        $comment = $article->comments()
            ->save(
                factory(Comment::class, 1)
                    ->make(['user_id' => $commentUserId])
                    ->first()
            );

        return [$article, $comment];
    }
}
