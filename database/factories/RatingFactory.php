<?php

use App\User;
use App\Location;
use Faker\Generator as Faker;

$factory->define(App\Rating::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return User::inRandomOrder()->first()->id;
        },
        'location_id' => function() {
            return Location::inRandomOrder()->first()->id;
        },
        'rating' => $faker->numberBetween(0, 5),
    ];
});
