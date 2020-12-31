<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostCommentTest extends TestCase
{
    use RefreshDatabase;

    public function testPostSuccessful()
    {
        /** @var Article $article */
        $article = $this->user
            ->articles()
            ->save(factory(Article::class, 1)->make()->first());
        $request = [
            'comment' => [
                'body' => 'test'
            ]
        ];

        $response = $this->postJson("/api/articles/{$article->slug}/comments", $request, $this->headers);
        $response->assertStatus(200)
            ->assertJson([
                'comment' => [
                    'body' => 'test',
                    'author' => [
                        'username' => $this->loggedInUser->user_name,
                        'bio' => $this->loggedInUser->bio,
                        'image' => $this->loggedInUser->image,
                        'following' => false
                    ]
                ]
            ]);
    }

    public function testReturnErrorsWhenArticleNotFound()
    {
        $request = [
            'comment' => [
                'body' => 'test'
            ]
        ];

        $response = $this->post("/api/articles/undefined/comments", $request, $this->headers);
        $response->assertStatus(404);
    }

    public function testReturnErrorsWhenInvalidatedRequest()
    {
        /** @var Article $article */
        $article = $this->user
            ->articles()
            ->save(factory(Article::class, 1)->make()->first());
        $request = [
            'comment' => [
                'body' => ''
            ]
        ];

        $response = $this->postJson("/api/articles/{$article->slug}/comments", $request, $this->headers);
        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'body' => []
                ]
            ]);
    }

    public function testReturnErrorsWhenNotLoggedIn()
    {
        /** @var Article $article */
        $article = $this->user
            ->articles()
            ->save(factory(Article::class, 1)->make()->first());
        $request = [
            'comment' => [
                'body' => 'test'
            ]
        ];

        $response = $this->postJson("/api/articles/{$article->slug}/comments", $request);
        $response->assertStatus(401);
    }
}
