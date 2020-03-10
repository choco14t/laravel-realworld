<?php

use App\Eloquents\EloquentArticle;
use App\Eloquents\EloquentTag;
use App\Eloquents\EloquentUser;
use Illuminate\Database\Seeder;

class GetArticleTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(EloquentUser::class, 'test', 1)->create();
        $tags = factory(EloquentTag::class, 'test', 2)
            ->make()
            ->each(function (EloquentTag $tag, $index) {
                $tag->name .= $index;
                $tag->save();
            });

        factory(EloquentArticle::class, 2)
            ->make()
            ->each(function (EloquentArticle $article, $index) use ($users, $tags) {
                $userId = $users[0]->id;
                $article->user_id = $userId;
                $article->save();
                $article->tags()->attach($tags[$index]);
                $article->favorited()->attach($userId);
            });

    }
}
