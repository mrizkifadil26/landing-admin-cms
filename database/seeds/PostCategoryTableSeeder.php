<?php

use App\PostCategory;
use Illuminate\Database\Seeder;

class PostCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = (int) $this->command->ask('How many categories?', 10);

        $this->command->info('Creating {$count} categories');

        $categories = factory(PostCategory::class, $count)->create();

        $this->command->info('Categories created!');
    }
}
