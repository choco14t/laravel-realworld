<?php

namespace Tests\Feature;

use App\Eloquents\EloquentTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateArticleWithoutTags()
    {
        $request = [
            'article' => [
                'title' => 'hello world!!',
                'description' => 'hello description',
                'body' => 'hello!!',
                'tagList' => []
            ]
        ];

        $response = $this->postJson('/api/articles', $request, $this->headers);

        $response->assertStatus(200)
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
        factory(EloquentTag::class, 'test', 1)->create();

        $request = [
            'article' => [
                'title' => 'hello world!!',
                'description' => 'hello description',
                'body' => 'hello!!',
                'tagList' => ['test', 'hello world']
            ]
        ];

        $response = $this->postJson('/api/articles', $request, $this->headers);

        $response->assertStatus(200)
            ->assertJson([
                'article' => [
                    'slug' => 'hello-world',
                    'title' => 'hello world!!',
                    'description' => 'hello description',
                    'body' => 'hello!!',
                    'tagList' => ['test', 'hello world'],
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

        $this->assertContains('hello world', EloquentTag::pluck('name')->all());
    }
}
