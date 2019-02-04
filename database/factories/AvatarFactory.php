<?php

use Faker\Generator as Faker;

$factory->define(App\Avatar::class, function (Faker $faker) {
    return [
        'avatar_name' => $faker->word,
        'avatar_link' => $faker->imageUrl($width = 800, $height = 350, 'cats')
    ];
});
