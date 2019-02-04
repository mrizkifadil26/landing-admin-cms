<?php

use Faker\Generator as Faker;

$factory->define(App\Avatar::class, function (Faker $faker) {
    return [
        'avatar_name' => $faker->word,
        'avatar_link' => $faker->imageUrl($width = 400, $height = 400, 'cats')
    ];
});
