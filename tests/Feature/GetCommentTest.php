<?php

namespace Tests\Feature;

use App\Eloquents\EloquentArticle;
use App\Eloquents\EloquentComment;
use App\ViewModels\FormattableTimestamps;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetCommentTest extends TestCase
{
    use RefreshDatabase, FormattableTimestamps;

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
                        'createdAt' => $this->formatFrom($comment->created_at),
                        'updatedAt' => $this->formatFrom($comment->updated_at),
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
