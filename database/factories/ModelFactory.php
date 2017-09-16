<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Faker\Generator;
use App\User;
use App\Post;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('mktvirtual'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Post::class, function (Generator $faker) {
   return [
       'title' => $faker->text(25),
       'image' => $faker->imageUrl()
   ];
});

