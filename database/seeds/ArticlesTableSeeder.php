<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Eloquents\Article;
use App\Eloquents\User;

class ArticlesTableSeeder extends Seeder
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

        factory(Article::class, 20)
            ->make()
            ->each(function (Article $article) use ($faker, $userIdList) {
                $article->user_id = $faker->randomElement($userIdList);
                $article->save();
            });
    }
}
