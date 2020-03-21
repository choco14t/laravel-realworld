<?php

namespace Tests\Feature;

use App\Eloquents\EloquentArticle;
use App\Eloquents\EloquentTag;
use App\Eloquents\EloquentUser;
use App\ViewModels\ArticleViewModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllArticles()
    {
        $this->setUpArticles($this->user, $count = 3);

        $response = $this->get('/api/articles');
        $articles = $this->user->articles()->latest()->get();
        $expected = $articles->map(function (EloquentArticle $article) {
            return (new ArticleViewModel($article, null))->withoutKey();
        });

        $response->assertStatus(200)
            ->assertJson([
                'articles' => $expected->all(),
                'articlesCount' => $count
            ]);
    }

    public function testFilterByTag()
    {
        /** @var EloquentTag $tag */
        $tag = factory(EloquentTag::class, 1)->create()->first();

        /** @var \Illuminate\Database\Eloquent\Collection $articles */
        $articles = $this->setUpArticles($this->user, $count = 2);
        $articles->first()->tags()->attach($tag);

        $response = $this->get('/api/articles?tag=' . $tag->name);

        $response->assertStatus(200)
            ->assertJson([
                'articles' => [],
                'articlesCount' => 1,
            ]);
    }

    public function testFilterByAuthor()
    {
        $this->setUpArticles($this->loggedInUser, $count = 2);

        $this->setUpArticles($this->user, $count);
        $response = $this->get('/api/articles?author=' . $this->user->user_name);

        $response->assertStatus(200)
            ->assertJson([
                'articles' => [],
                'articlesCount' => $count,
            ]);
    }

    public function testFilterByFavorited()
    {
        $articles = $this->setUpArticles($this->loggedInUser, $count = 2);
        $articles->map(function (EloquentArticle $article) {
            $article->favorited()->attach($this->user->id);
        });

        $response = $this->get('/api/articles?favorited=' . $this->user->user_name);

        $response->assertStatus(200)
            ->assertJson([
                'articles' => [],
                'articlesCount' => $count,
            ]);
    }

    public function testGetArticlesWithLimitAndOffset()
    {
        $this->setUpArticles($this->user, $count = 20);

        $limit = 10;
        $offset = 15;
        $response = $this->getJson("/api/articles?limit={$limit}&offset={$offset}");

        $response->assertStatus(200)
            ->assertJson([
                'articlesCount' => $count
            ])
            ->assertJsonCount($count - $offset, 'articles');
    }

    private function setUpArticles(EloquentUser $user, int $count): iterable
    {
        return $user->articles()
            ->saveMany(factory(EloquentArticle::class, $count)->make());
    }
}
