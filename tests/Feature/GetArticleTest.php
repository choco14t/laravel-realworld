<?php

namespace Tests\Feature;

use GetArticleTestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetArticleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(GetArticleTestSeeder::class);
    }

    public function testFilterByTag()
    {
        $response = $this->get('/api/articles?tag=test1');

        $response->assertStatus(200);
        $response->assertJson([
            'articles' => [],
            'articlesCount' => 1,
        ]);
    }

    public function testFilterByAuthor()
    {
        $response = $this->get('/api/articles?author=test_user');

        $response->assertStatus(200);
        $response->assertJson([
            'articles' => [],
            'articlesCount' => 2,
        ]);
    }

    public function testFilterByFavorited()
    {
        $response = $this->get('/api/articles?favorited=test_user');

        $response->assertStatus(200);
        $response->assertJson([
            'articles' => [],
            'articlesCount' => 2,
        ]);
    }
}
