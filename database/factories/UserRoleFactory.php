<?php

use Faker\Generator as Faker;

$factory->define(App\UserRole::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Admin', 'User']),
        'description' => $faker->randomElement(['An Admin Role', 'A User Role'])
    ];
});
