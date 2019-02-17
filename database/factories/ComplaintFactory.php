<?php

use App\ComplaintCategory;
use App\Image;
use App\User;
use Faker\Generator as Faker;

$factory->define(\App\Complaint::class, function (Faker $faker) {
    return [
        'complaint' => $faker->word,
        'description' => $faker->realText(rand(100, 300)),
        'full_name' => $faker->name,
        'address' => $faker->streetAddress,
        'category_id' => function() {
            return ComplaintCategory::inRandomOrder()->first()->id;
        },
        'status' => $faker->randomElement(['Handled', 'Pending']),
        'complaint_by' => function() {
            return User::inRandomOrder()->first()->id;
        }
    ];
});
