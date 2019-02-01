<?php

use App\Complaint;
use Illuminate\Database\Seeder;

class ComplaintTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = (int) $this->command->ask("How many users that complained?", 10);
        
        $range = 0 . '-' . 10;
        $complaintRange = $this->command->ask("How many complaints?", $range);

        $this->command->info("Creating {$userCount} users each having a complaint range of {$complaintRange}.");
        
        $users = factory(App\User::class, $userCount)->create();

        $users->each(function($user) use ($complaintRange) {
            factory(Complaint::class, $this->count($complaintRange))
                ->create(['complaint_by' => $user->id]);
        });

    }

    function count($range)
    {
        return rand(0, ...explode('-', $range));
    }
}
