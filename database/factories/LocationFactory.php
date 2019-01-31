<?php

use Faker\Generator as Faker;
use App\LocationCategory;
use App\User;

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'location' => $faker->streetName,
        'description' => $faker->realText(rand(10, 100)),
        'category' => function () {
            return LocationCategory::inRandomOrder()->first()->id;
        },
        'image' => 'https://via.placeholder.com/350x150',
        'avg_rating' => $faker->numberBetween(0, 5),
        'posted_by' => function () {
            return User::inRandomOrder()->first()->id;
        }
    ];
});
