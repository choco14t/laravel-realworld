<?php

namespace Tests\Feature;

use App\Eloquents\EloquentArticle;
use App\Eloquents\EloquentComment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCommentTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteSuccessful()
    {
        /** @var EloquentArticle $article */
        /** @var EloquentComment $comment */
        list($article, $comment) = $this->setUpResource($this->loggedInUser->id);

        $response = $this->delete(
            "/api/articles/{$article->slug}/comments/{$comment->id}",
            [],
            $this->headers
        );

        $response->assertStatus(200);
        $this->assertNull(EloquentComment::find($comment->id));
    }

    public function testReturnErrorsWhenArticleNotFound()
    {
        /** @var EloquentArticle $article */
        /** @var EloquentComment $comment */
        list($article, $comment) = $this->setUpResource($this->loggedInUser->id);

        $invalidSlug = $article->slug . '_';
        $response = $this->delete(
            "/api/articles/{$invalidSlug}/comments/{$comment->id}",
            [],
            $this->headers
        );

        $response->assertStatus(404);
        $this->assertNotNull(EloquentComment::find($comment->id));
    }

    public function testReturnErrorsWhenCommentNotFound()
    {
        /** @var EloquentArticle $article */
        /** @var EloquentComment $comment */
        list($article, $comment) = $this->setUpResource($this->loggedInUser->id);

        $invalidCommentId = $comment->id + 1;
        $response = $this->delete(
            "/api/articles/{$article->slug}/comments/{$invalidCommentId}",
            [],
            $this->headers
        );

        $response->assertStatus(404);
        $this->assertNotNull(EloquentComment::find($comment->id));
    }

    public function testReturnErrosWhenDeleteOtherUsersComment()
    {
        /** @var EloquentArticle $article */
        /** @var EloquentComment $comment */
        list($article, $comment) = $this->setUpResource($this->user->id);

        $response = $this->delete(
            "/api/articles/{$article->slug}/comments/{$comment->id}",
            [],
            $this->headers
        );

        $response->assertStatus(403);
        $this->assertNotNull(EloquentComment::find($comment->id));
    }

    private function setUpResource(int $commentUserId)
    {
        /** @var EloquentArticle $article */
        $article = $this->user
            ->articles()
            ->save(factory(EloquentArticle::class, 1)->make()->first());

        /** @var EloquentComment $comment */
        $comment = $article->comments()
            ->save(
                factory(EloquentComment::class, 1)
                    ->make(['user_id' => $commentUserId])
                    ->first()
            );

        return [$article, $comment];
    }
}
