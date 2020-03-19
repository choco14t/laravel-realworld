<?php

namespace Tests\Feature;

use App\Eloquents\EloquentArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testFavoriteSuccess()
    {
        /** @var EloquentArticle $article */
        $article = $this->user->articles()
            ->save(factory(EloquentArticle::class, 1)->make()->first());

        $response = $this->postJson("/api/articles/{$article->slug}/favorite", [], $this->headers);
        $response->assertStatus(200)
            ->assertJson([
                'article' => [
                    'favorited' => true,
                    'favoritesCount' => 1,
                ]
            ]);
    }

    public function testReturnErrorsWhenArticleNotFound()
    {
        $response = $this->postJson('/api/articles/undefined/favorite', [], $this->headers);
        $response->assertStatus(404);
    }

    public function testReturnErrorsWhenNotLoggedIn()
    {
        /** @var EloquentArticle $article */
        $article = $this->user->articles()
            ->save(factory(EloquentArticle::class, 1)->make()->first());

        $response = $this->postJson("/api/articles/{$article->slug}/favorite", []);
        $response->assertStatus(401);
    }
}
