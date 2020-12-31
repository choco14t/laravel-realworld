<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnfavoriteArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testUnfavoriteSuccess()
    {
        /** @var Article $article */
        $article = $this->user->articles()
            ->save(factory(Article::class, 1)->make()->first());

        $article->favorited()->attach($this->loggedInUser->id);
        $this->assertCount($expected = 1, $article->favorited);

        $response = $this->deleteJson("/api/articles/{$article->slug}/favorite", [], $this->headers);
        $response->assertStatus(200)
            ->assertJson([
                'article' => [
                    'favorited' => false,
                    'favoritesCount' => 0,
                ]
            ]);
    }

    public function testReturnErrorsWhenArticleNotFound()
    {
        $response = $this->deleteJson('/api/articles/undefined/favorite', [], $this->headers);
        $response->assertStatus(404);
    }

    public function testReturnErrorsWhenNotLoggedIn()
    {
        /** @var Article $article */
        $article = $this->user->articles()
            ->save(factory(Article::class, 1)->make()->first());

        $response = $this->deleteJson("/api/articles/{$article->slug}/favorite", []);
        $response->assertStatus(401);
    }
}
