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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret')
    ];
});

$factory->define(App\Snippet::class, function (Faker\Generator $faker) {
    $html = preg_replace("/<\/?\X+>/iU", '$0' . PHP_EOL , $faker->randomHtml(rand(1,5),rand(1,5)));
    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'title' => $faker->sentence,
        'description' => $faker->realText(rand(100, 150)),
        'body' => $html,
        'mode' => 'htmlmixed'
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'name' => $faker->unique()->word()
    ];
});