<?php

use App\Avatar;
use Illuminate\Database\Seeder;

class AvatarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $avatarCount = (int) $this->command->ask("How many avatars?", 10);

        $this->command->info("Creating {$avatarCount} avatars");

        $image = factory(Avatar::class, $avatarCount)->create();

        $this->command->info("Avatars created!");
    }
}
