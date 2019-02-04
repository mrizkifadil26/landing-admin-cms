<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        if ($this->command->confirm("Do you wish to refresh migration before seeding, it will clear all old data?")) {
            $this->command->call('migrate:fresh');
            $this->command->line("Database cleared");
        }

        $this->call([
            AvatarTableSeeder::class,
            RoleTableSeeder::class,
            UsersTableSeeder::class,
            PostCategoryTableSeeder::class,
            ImageTableSeeder::class,
            PostTableSeeder::class,
            LocationCategoryTableSeeder::class,
            LocationTableSeeder::class,
            RoleTableSeeder::class,
            CommentTableSeeder::class,
            ComplaintCategoryTableSeeder::class,
            ComplaintTableSeeder::class,
            EventTableSeeder::class,
            RatingTableSeeder::class
        ]);

        $this->command->info("Database seeded.");

        Eloquent::reguard();
    }
}
