<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Eloquents\EloquentComment;
use Faker\Generator as Faker;

$factory->define(EloquentComment::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
    ];
});
