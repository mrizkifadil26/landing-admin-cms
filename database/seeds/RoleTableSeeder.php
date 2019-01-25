<?php

use App\UserRole as Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->description = 'An Admin User';
        $role_admin->save();

        $role_user = new Role();
        $role_user->name = 'user';
        $role_user->description = 'A User';
        $role_user->save();
    }
}
