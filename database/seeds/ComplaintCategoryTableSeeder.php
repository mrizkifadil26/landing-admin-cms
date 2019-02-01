<?php

use App\ComplaintCategory;
use Illuminate\Database\Seeder;

class ComplaintCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = (int) $this->command->ask("How many categories?", 10);

        $this->command->info("Creating {$count} of complaint categories");

        $categories = factory(ComplaintCategory::class, $count)->create();

        $this->command->info("Complaint categories created!");
    }
}
