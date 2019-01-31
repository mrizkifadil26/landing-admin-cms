<?php

use App\LocationCategory;
use Illuminate\Database\Seeder;

class LocationCategoryTableSeeder extends Seeder
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

        $categories = factory(LocationCategory::class, $count)->create();

        $this->command->info('Categories created!');
    }
}
