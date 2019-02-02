<?php

use Faker\Generator as Faker;
use App\LocationCategory;
use App\User;
use App\Image;

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'location' => $faker->streetName,
        'description' => $faker->realText(rand(10, 100)),    
        'address' => $faker->streetAddress,
        'image_id' => function () {
            return Image::inRandomOrder()->first()->id;
        },
        // 'avg_rating' => $faker->randomFloat(2, 0, 5),
        'posted_by' => function () {
            return User::inRandomOrder()->first()->id;
        }
    ];
});
