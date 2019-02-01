<?php

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $range = 0 . '-' . 10;
        $commentRange = $this->command->ask("How many comments?", $range);

        $posts = Post::all();

        $this->command->info("Creating range of {$commentRange} comments for {$posts->count()} posts.");

        $posts->each(function($post) use ($commentRange) {
            factory(Comment::class, $this->count($commentRange))
                ->create([
                    'post_id' => $post->id,
                    'user_id' => User::all()->random()->id
                ]);
        });

        $this->command->info('Comments created!');

    }

    function count($range)
    {
        return rand(0, ...explode('-', $range));
    }
}
