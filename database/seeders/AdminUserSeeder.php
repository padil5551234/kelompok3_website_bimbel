<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@tryout.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@tryout.com',
                'password' => 'admin2024', // Let the model handle hashing via setPasswordAttribute
                'email_verified_at' => now(),
                'status' => 1, // Active status
            ]
        );

        // Assign admin role to the user
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminUser->assignRole($adminRole);
        }

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@tryout.com');
        $this->command->info('Password: admin2024');
    }
}