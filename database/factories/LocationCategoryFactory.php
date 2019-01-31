<?php

use Faker\Generator as Faker;

$factory->define(App\LocationCategory::class, function (Faker $faker) {
    return [
        'location_category' => $faker->word
    ];
});
