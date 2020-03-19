<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Eloquents\EloquentArticle;
use Carbon\Carbon;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(EloquentArticle::class, function (Faker $faker) {
    $title = $faker->sentence;
    $slug = \Illuminate\Support\Str::slug($title);
    static $subSeconds = 1000;

    return [
        'slug' => $slug,
        'title' => $title,
        'description' => $faker->sentence(10),
        'body' => $faker->text,
        'created_at' => Carbon::now()->subSeconds($subSeconds--)
    ];
});
