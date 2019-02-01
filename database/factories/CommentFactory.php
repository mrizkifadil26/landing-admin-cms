<?php

use App\User;
use App\Post;
use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return User::inRandomOrder()->first()->id;
        },
        'post_id' => function() {
            return Post::inRandomOrder()->first()->id;
        },
        'comment' => $faker->realText(rand(10, 300))
    ];
});
