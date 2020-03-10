<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Eloquents\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
    ];
});
