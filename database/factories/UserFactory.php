<?php

use App\Avatar;
use App\UserRole as Role;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'password' => bcrypt('secret'), // secret
        'avatar_id' => function() {
            return Avatar::inRandomOrder()->first()->id;
        },
        'role_id' => function() {
            return Role::inRandomOrder()->first()->id;
        },
        'remember_token' => str_random(10),
    ];
});
