<?php

use App\Image;
use Illuminate\Database\Seeder;

class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $imgCount = (int) $this->command->ask('How many images?', 10);

        $this->command->info('Creating {$imgCount} images');

        $image = factory(Image::class, $imgCount)->create();

        $this->command->info('Images created!');
    }
}
