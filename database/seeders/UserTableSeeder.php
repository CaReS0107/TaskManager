<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();
        $superAdmin = Role::where('name', 'sAdmin')->first();

        $admin = User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin')
        ]);
        $user = User::create([
            'first_name' => 'user',
            'last_name' => 'user',
            'email' => 'user@user.com',
            'password' => Hash::make('user')
        ]);
        $sAdmin = User::create([
            'first_name' => 'sadmin',
            'last_name' => 'sadmin',
            'email' => 'sadmin@sadmin.com',
            'password' => Hash::make('sadmin')
        ]);

        $admin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);
        $sAdmin->roles()->attach($superAdmin);

    }
}
