<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role_admin = Role::where('name', 'admin')->first();
        $role_user = Role::where('name', 'user')->first();

        $admin = new User();
        $admin->name = 'vi';
        $admin->email = 'N00220460@iadt.ie';
        $admin->password = 'password';
        $admin->friend_code = 'UNST';
        $admin->bio = '';
        $admin->image = 'cover.png';
        $admin->save();

        $admin->roles()->attach($role_admin);

    }
}
