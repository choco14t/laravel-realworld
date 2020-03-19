<?php

namespace Tests\Feature;

use App\Eloquents\EloquentArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testGetFeedSuccess()
    {
        $this->setUpResources($count = 100);

        $response = $this->getJson('api/articles/feed', $this->headers);

        $response->assertStatus(200)
            ->assertJson([
                'articlesCount' => $count
            ]);

        $limit = 20;
        $response->assertJsonCount($limit, 'articles');

        $expected = $this->user->articles()->latest()
            ->limit($limit)->pluck('slug')->all();
        $this->assertEquals(
            $expected,
            array_column($response->json('articles'), 'slug')
        );
    }

    public function testGetFeedSuccessWithLimitAndOffset()
    {
        $this->setUpResources($count = 30);

        $limit = 10;
        $offset = 20;

        $response = $this->getJson(
            "api/articles/feed?limit={$limit}&offset={$offset}",
            $this->headers
        );

        $response->assertStatus(200)
            ->assertJson([
                'articlesCount' => $count
            ]);
        $response->assertJsonCount($limit, 'articles');
    }

    public function testReturnErrorsWhenNotLoggedIn()
    {
        $response = $this->getJson('/api/articles/feed');
        $response->assertStatus(401);
    }

    private function setUpResources(int $articleCount)
    {
        $this->user->articles()
            ->saveMany(factory(EloquentArticle::class, $articleCount)->make());

        $this->loggedInUser->follow($this->user->id);
    }
}
