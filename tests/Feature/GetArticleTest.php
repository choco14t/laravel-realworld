<?php

namespace Tests\Feature;

use App\Eloquents\EloquentArticle;
use App\Eloquents\EloquentTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testFilterByTag()
    {
        /** @var EloquentTag $tag */
        $tag = factory(EloquentTag::class, 1)->create()->first();

        /** @var \Illuminate\Database\Eloquent\Collection $articles */
        $articles = $this->setUpArticles($count = 2);
        $articles->first()->tags()->attach($tag);

        $response = $this->get('/api/articles?tag=' . $tag->name);

        $response->assertStatus(200);
        $response->assertJson([
            'articles' => [],
            'articlesCount' => 1,
        ]);
    }

    public function testFilterByAuthor()
    {
        $this->setUpArticles($count = 2);
        $response = $this->get('/api/articles?author=' . $this->user->user_name);

        $response->assertStatus(200);
        $response->assertJson([
            'articles' => [],
            'articlesCount' => $count,
        ]);
    }

    public function testFilterByFavorited()
    {
        $this->setUpArticles($count = 2);
        $response = $this->get('/api/articles?author=' . $this->user->user_name);

        $response->assertStatus(200);
        $response->assertJson([
            'articles' => [],
            'articlesCount' => $count,
        ]);
    }

    private function setUpArticles(int $count): iterable
    {
        return $this->user
            ->articles()
            ->saveMany(factory(EloquentArticle::class, $count)->make());
    }
}
