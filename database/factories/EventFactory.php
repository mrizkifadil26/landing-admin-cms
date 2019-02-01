<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'event' => $faker->sentence(2),
        'description' => $faker->sentence(10),
        'date' => $faker->date('Y-m-d'),
        'location' => $faker->streetAddress,
        'posted_by' => function() {
            return User::inRandomOrder()->first()->id;
        }
    ];
});
