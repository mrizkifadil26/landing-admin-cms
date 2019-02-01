<?php

use Faker\Generator as Faker;

$factory->define(App\ComplaintCategory::class, function (Faker $faker) {
    return [
        'complaint_category' => $faker->word
    ];
});
