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
        $post = new Post;
        $post->title = "Hai Teman Teman";
        $post->slug = "hai-teman-teman";
        $post->description = "Teman";
        $post->content = "Teman adalah teman";
        $post->created_by = 1;
        $post->save();
    }
}