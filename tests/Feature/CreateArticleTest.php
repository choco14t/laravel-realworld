<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateArticleWithoutTags()
    {
        $this->withoutExceptionHandling();
        $request = [
            'article' => [
                'title' => 'hello world!!',
                'description' => 'hello description',
                'body' => 'hello!!',
                'tagList' => []
            ]
        ];

        $response = $this->postJson('/api/articles', $request, $this->headers);

        $response->assertStatus(201)
            ->assertJson([
                'article' => [
                    'slug' => 'hello-world',
                    'title' => 'hello world!!',
                    'description' => 'hello description',
                    'body' => 'hello!!',
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

    public function testCreateArticleWithTags()
    {
        $this->withoutExceptionHandling();
        /** @var Tag $tag */
        $tag = factory(Tag::class)->create();

        $request = [
            'article' => [
                'title' => 'hello world!!',
                'description' => 'hello description',
                'body' => 'hello!!',
                'tagList' => [$tag->name, 'hello world']
            ]
        ];

        $response = $this->postJson('/api/articles', $request, $this->headers);

        $response->assertStatus(201)
            ->assertJson([
                'article' => [
                    'slug' => 'hello-world',
                    'title' => 'hello world!!',
                    'description' => 'hello description',
                    'body' => 'hello!!',
                    'tagList' => [$tag->name, 'hello world'],
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

        $this->assertContains('hello world', Tag::pluck('name')->all());
    }

    public function testReturnErrorsWhenInvalidatedRequest()
    {
        $request = [
            'article' => [
                'title' => '',
                'description' => '',
                'body' => '',
                'tagList' => ''
            ]
        ];

        $response = $this->postJson('/api/articles', $request, $this->headers);

        $response->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'title' => [],
                    'description' => [],
                    'body' => [],
                    'tagList' => []
                ]
            ]);
    }

    public function testReturnErrorsWhenNotLoggedIn()
    {
        $request = [
            'article' => [
                'title' => 'hello world!!',
                'description' => 'hello description',
                'body' => 'hello!!'
            ]
        ];

        $response = $this->postJson('/api/articles', $request);

        $response->assertStatus(401);
    }
}
