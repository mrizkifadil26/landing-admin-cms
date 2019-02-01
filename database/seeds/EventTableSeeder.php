<?php

use App\Event;
use Illuminate\Database\Seeder;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = (int) $this->command->ask("How many users that posted this?", 5);
        
        $range = 0 . '-' . 10;
        $eventRange = $this->command->ask("How many events?", $range);

        $this->command->info("Creating {$userCount} users each creating an event range of {$eventRange}.");
        
        $users = factory(App\User::class, $userCount)->create();

        $users->each(function($user) use ($eventRange) {
            factory(Event::class, $this->count($eventRange))
                ->create(['posted_by' => $user->id]);
        });

    }

    function count($range)
    {
        return rand(0, ...explode('-', $range));
    }
}
