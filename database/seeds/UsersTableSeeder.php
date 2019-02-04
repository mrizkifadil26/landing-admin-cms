<?php

use App\User;
use App\UserRole as Role;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = new User;
        $admin->name = 'Muhammad Rizki Fadillah';
        $admin->username = 'mrizkifadil26';
        $admin->password = bcrypt('rizkifadil26');
        $admin->avatar_id = 1;
        $admin->role_id = 1;
        $admin->save();

        $user = new User;
        $user->name = 'User';
        $user->username = 'user';
        $user->password = bcrypt('user123');
        $user->avatar_id = 2;
        $user->role_id = 2;
        $user->save();
    }
}
