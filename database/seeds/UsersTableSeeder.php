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
        $role_admin = Role::where('name', 'admin')->first();
        $role_user = Role::where('name', 'user')->first();

        $admin = new User;
        $admin->name = 'Muhammad Rizki Fadillah';
        $admin->username = 'mrizkifadil26';
        $admin->password = bcrypt('rizkifadil26');
        $admin->save();
        $admin->roles()->attach($role_admin);

        $user = new User;
        $user->name = 'User';
        $user->username = 'user';
        $user->password = bcrypt('user123');
        $user->save();
        $user->roles()->attach($role_user);
    }
}
