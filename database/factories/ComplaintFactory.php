<?php

use App\ComplaintCategory;
use App\Image;
use App\User;
use Faker\Generator as Faker;

$factory->define(\App\Complaint::class, function (Faker $faker) {
    return [
        'complaint' => $faker->word,
        'description' => $faker->sentence(10),
        'category_id' => function() {
            return ComplaintCategory::inRandomOrder()->first()->id;
        },
        'image_id' => function() {
            return Image::inRandomOrder()->first()->id;
        },
        'status' => $faker->randomElement(['Handled', 'Pending']),
        'complaint_by' => function() {
            return User::inRandomOrder()->first()->id;
        }
    ];
});
