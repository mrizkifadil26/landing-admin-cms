<?php

use Faker\Generator as Faker;

$factory->define(App\PostCategory::class, function (Faker $faker) {
    return [
        'post_category' => $faker->word,
    ];
});
