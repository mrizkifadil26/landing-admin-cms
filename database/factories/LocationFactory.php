<?php

use Faker\Generator as Faker;
use App\LocationCategory;
use App\User;

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'location' => $faker->streetName,
        'description' => $faker->realText(rand(10, 100)),    
        'address' => $faker->streetAddress,
        'image' => $faker->imageUrl($width = 800, $height = 350),
        // 'avg_rating' => $faker->randomFloat(2, 0, 5),
        'posted_by' => function () {
            return User::inRandomOrder()->first()->id;
        }
    ];
});
