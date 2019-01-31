<?php

use App\Location;
use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = (int) $this->command->ask('How many users?', 5);
        
        $range = 0 . '-' . 10;
        $locationRange = $this->command->ask('How many posts?', $range);

        $this->command->info('Creating {userCount} users each having a post range of {$locationRange}.');
        
        $users = factory(App\User::class, $userCount)->create();

        $users->each(function($user) use ($locationRange) {
            factory(Location::class, $this->count($locationRange))
                ->create(['posted_by' => $user->id]);
        });
    }

    function count($range)
    {
        return rand(0, ...explode('-', $range));
    }
}
