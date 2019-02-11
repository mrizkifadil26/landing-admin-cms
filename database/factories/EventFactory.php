<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {

    $start = $faker->dateTimeInInterval('now', '+ 1 years');
    $end = $faker->dateTimeInInterval($start, '+ 2 days');

    return [
        'event' => $faker->sentence(2),
        'description' => $faker->sentence(10),
        'start_date' => $start,
        'end_date' => $end,
        'location' => $faker->streetAddress,
        'posted_by' => function() {
            return User::inRandomOrder()->first()->id;
        }
    ];
});
