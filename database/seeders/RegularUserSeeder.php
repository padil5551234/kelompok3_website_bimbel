<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RegularUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create user role if it doesn't exist
        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            ['guard_name' => 'web']
        );

        // Create test regular user
        $user = User::firstOrCreate(
            ['email' => 'user@tryout.com'],
            [
                'name' => 'Regular User',
                'email' => 'user@tryout.com',
                'password' => 'user2024',
                'email_verified_at' => now(),
                'status' => 1,
            ]
        );

        // Assign user role
        if (!$user->hasRole('user')) {
            $user->assignRole('user');
        }

        $this->command->info('Regular user created successfully!');
        $this->command->info('Email: user@tryout.com');
        $this->command->info('Password: user2024');
    }
}