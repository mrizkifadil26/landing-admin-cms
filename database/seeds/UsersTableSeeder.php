<?php

use App\User;
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
        $role_admin = Role::where('name', 'admin')->first();
        $role_user = Role::where('name', 'user')->first();

        $user = new User;
        $user->name = 'Muhammad Rizki Fadillah';
        $user->email = 'mrizkifadil26@gmail.com';
        $user->password = bcrypt('rizkifadil26');
        $user->save();
        $user->roles()->attach($role_admin);
    }
}
