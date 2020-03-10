<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Eloquents\EloquentArticle;
use App\Eloquents\EloquentComment;
use App\Eloquents\EloquentUser;

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
        $userIdList = EloquentUser::pluck('id')->toArray();
        $articleIdList = EloquentArticle::pluck('id')->toArray();

        factory(EloquentComment::class, 20)
            ->make()
            ->each(function (EloquentComment $comment) use ($faker, $userIdList, $articleIdList) {
                $comment->user_id = $faker->randomElement($userIdList);
                $comment->article_id = $faker->randomElement($articleIdList);
                $comment->save();
            });

    }
}
