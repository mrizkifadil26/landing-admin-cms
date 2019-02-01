<?php

use App\Rating;
use App\Location;
use App\User;
use Illuminate\Database\Seeder;

class RatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $range = 0 . '-' . 10;
        $ratingRange = $this->command->ask("How many ratings?", $range);

        $locations = Location::all();

        $this->command->info("Creating range of {$ratingRange} ratings for {$locations->count()} locations.");

        $locations->each(function($location) use ($ratingRange) {
            factory(Rating::class, $this->count($ratingRange))
                ->create([
                    'location_id' => $location->id,
                    'user_id' => User::all()->random()->id
                ]);
        });

        $this->command->info("Ratings created!");

    }

    function count($range)
    {
        return rand(0, ...explode('-', $range));
    }
}
