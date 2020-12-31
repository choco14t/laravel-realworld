<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $userIdList = User::pluck('id')->toArray();
        $articleIdList = Article::pluck('id')->toArray();

        factory(Comment::class, 20)
            ->make()
            ->each(function (Comment $comment) use ($faker, $userIdList, $articleIdList) {
                $comment->user_id = $faker->randomElement($userIdList);
                $comment->article_id = $faker->randomElement($articleIdList);
                $comment->save();
            });

    }
}
