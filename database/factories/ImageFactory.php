<?php

use App\Post;
use Faker\Generator as Faker;

$factory->define(App\Image::class, function (Faker $faker) {
    return [
        'image_name' => $faker->word,
        'image_link' => $faker->imageUrl($width = 800, $height = 350, 'cats')
    ];
});
