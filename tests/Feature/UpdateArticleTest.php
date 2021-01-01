<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateArticleWithoutTitle()
    {
        /** @var Article $article */
        $article = $this->loggedInUser
            ->articles()
            ->save(factory(Article::class, 1)->make()->first());

        $request = [
            'article' => [
                'description' => 'update test',
                'body' => 'update test',
            ]
        ];
        $response = $this->put('/api/articles/' . $article->slug, $request, $this->headers);

        $response->assertStatus(200)
            ->assertJson([
                'article' => [
                    'slug' => $article->slug,
                    'title' => $article->title,
                    'description' => 'update test',
                    'body' => 'update test',
                    'tagList' => [],
                    'favorited' => false,
                    'favoritesCount' => 0,
                    'author' => [
                        'username' => $this->loggedInUser->user_name,
                        'bio' => $this->loggedInUser->bio,
                        'image' => $this->loggedInUser->image,
                        'following' => false
                    ]
                ]
            ]);
    }

    public function testUpdateArticleWithTitle()
    {
        /** @var Article $article */
        $article = $this->loggedInUser
            ->articles()
            ->save(factory(Article::class, 1)->make()->first());

        $request = [
            'article' => [
                'title' => 'update title'
            ]
        ];
        $response = $this->put('/api/articles/' . $article->slug, $request, $this->headers);

        $response->assertStatus(200)
            ->assertJson([
                'article' => [
                    'slug' => 'update-title',
                    'title' => 'update title',
                    'description' => $article->description,
                    'body' => $article->body,
                    'tagList' => [],
                    'favorited' => false,
                    'favoritesCount' => 0,
                    'author' => [
                        'username' => $this->loggedInUser->user_name,
                        'bio' => $this->loggedInUser->bio,
                        'image' => $this->loggedInUser->image,
                        'following' => false
                    ]
                ]
            ]);
    }

    public function testReturnErrorsWhenRequestWithEmptyAttributes()
    {
        /** @var Article $article */
        $article = $this->loggedInUser
            ->articles()
            ->save(factory(Article::class, 1)->make()->first());

        $request = [
            'article' => [
                'title' => '',
                'description' => '',
                'body' => ''
            ]
        ];
        $response = $this->put('/api/articles/' . $article->slug, $request, $this->headers);

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'title' => [],
                    'description' => [],
                    'body' => [],
                ]
            ]);
    }

    public function testReturnErrorsWhenUpdateOtherUsersArticle()
    {
        /** @var Article $article */
        $article = $this->user
            ->articles()
            ->save(factory(Article::class, 1)->make()->first());

        $request = [
            'article' => [
                'description' => 'update other users article.',
            ]
        ];
        $response = $this->put('/api/articles/' . $article->slug, $request, $this->headers);

        $response->assertStatus(403);
    }
}
