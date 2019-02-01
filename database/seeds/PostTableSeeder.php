<?php

use App\Post;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = (int) $this->command->ask("How many users?", 2);
        
        $range = 0 . '-' . 10;
        $postRange = $this->command->ask("How many posts?", $range);

        $this->command->info("Creating {$userCount} users each having a post range of {$postRange}.");
        
        $users = factory(App\User::class, $userCount)->create();

        $users->each(function($user) use ($postRange) {
            factory(Post::class, $this->count($postRange))
                ->create(['posted_by' => $user->id]);
        });

    }

    function count($range)
    {
        return rand(0, ...explode('-', $range));
    }
}