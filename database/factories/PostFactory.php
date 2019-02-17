<?php

use App\PostCategory;
use App\User;
use App\Image;
use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'description' => $faker->realText(rand(10, 100)),
        'slug' => str_replace('--', '-', strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', trim($faker->sentence(5))))),
        'image_id' => function () {
            return Image::inRandomOrder()->first()->id;
        },
        'content' => $faker->realText(rand(500, 1500)),
        'posted_by' => function () {
            return User::inRandomOrder()->first()->id;
        }
    ];
});
