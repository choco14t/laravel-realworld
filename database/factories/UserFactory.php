<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Eloquents\EloquentUser;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(EloquentUser::class, function (Faker $faker) {
    return [
        'user_name' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'bio' => $faker->text,
        'image' => $faker->imageUrl(120, 120),
        'email_verified_at' => now(),
        'remember_token' => Str::random(10),
    ];
});

$factory->define(EloquentUser::class, function (Faker $faker) {
    return [
        'user_name' => 'test_user',
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'bio' => $faker->text,
        'image' => $faker->imageUrl(120, 120),
        'email_verified_at' => now(),
        'remember_token' => Str::random(10),
    ];
}, 'test');
