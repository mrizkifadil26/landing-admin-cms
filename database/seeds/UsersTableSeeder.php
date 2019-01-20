<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Muhammad Rizki Fadillah';
        $user->email = 'mrizkifadil26@gmail.com';
        $user->password = bcrypt('rizkifadil26');
        $user->save();
    }
}
