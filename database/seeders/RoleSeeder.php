<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $userRole = Role::create(['name' => 'User']);
        $permissions = Permission::all();
        $adminRole->syncPermissions($permissions);

        // Create a user and assign the admin role
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('1234'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);
        $user->assignRole($adminRole);

        // Create a user and assign the user
        $user = User::create([
            'name' => 'walking customer',
            'email' => 'walking@user.com',
            'password' => bcrypt('1234'),
            'email_verified_at' => now(),
            'role' => 'user',
        ]);

        $user->assignRole('user');
    }
}
