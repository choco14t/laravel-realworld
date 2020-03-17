<?php

namespace Tests\Feature;

use App\Eloquents\EloquentArticle;
use App\Eloquents\EloquentComment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetCommentTest extends TestCase
{
    use RefreshDatabase;

    public function testGetArticleComments()
    {
        /** @var EloquentArticle $article */
        $article = $this->loggedInUser->articles()->save(
            factory(EloquentArticle::class, 1)->make()->first()
        );

        /** @var EloquentComment $comment */
        $comment = factory(EloquentComment::class, 1)
            ->make(['user_id' => $this->user->id])
            ->first();
        $article->comments()->save($comment);

        $this->loggedInUser->follow($this->user->id);

        $response = $this->get("/api/articles/{$article->slug}/comments", $this->headers);

        $response->assertStatus(200)
            ->assertJson([
                'comments' => [
                    [
                        'id' => $comment->id,
                        'createdAt' => $comment->created_at->toAtomString(),
                        'updatedAt' => $comment->updated_at->toAtomString(),
                        'body' => $comment->body,
                        'author' => [
                            'username' => $this->user->user_name,
                            'bio' => $this->user->bio,
                            'image' => $this->user->image,
                            'following' => true
                        ]
                    ],
                ]
            ]);
    }

    public function testReturnErrorsWhenArticleNotFound()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/api/articles/not-found/comments');

        $response->assertStatus(404);
    }
}
