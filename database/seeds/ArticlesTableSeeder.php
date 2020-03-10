<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Eloquents\EloquentArticle;
use App\Eloquents\EloquentUser;

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
        $userIdList = EloquentUser::pluck('id')->toArray();

        factory(EloquentArticle::class, 20)
            ->make()
            ->each(function (EloquentArticle $article) use ($faker, $userIdList) {
                $article->user_id = $faker->randomElement($userIdList);
                $article->save();
            });
    }
}
