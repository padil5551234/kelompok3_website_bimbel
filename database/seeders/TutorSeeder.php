<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class TutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create tutor role if it doesn't exist
        $tutorRole = Role::firstOrCreate(
            ['name' => 'tutor'],
            ['guard_name' => 'web']
        );

        // Create test tutor users
        $tutors = [
            [
                'name' => 'Ahmad Tutor',
                'email' => 'tutor1@example.com',
                'password' => 'password123',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Siti Tutor',
                'email' => 'tutor2@example.com',
                'password' => 'password123',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Budi Pengajar',
                'email' => 'tutor3@example.com',
                'password' => 'password123',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($tutors as $tutorData) {
            // Check if user already exists
            $user = User::where('email', $tutorData['email'])->first();
            
            if (!$user) {
                // Create new user (password will be auto-hashed by User model mutator)
                $user = User::create([
                    'name' => $tutorData['name'],
                    'email' => $tutorData['email'],
                    'password' => $tutorData['password'], // Will be hashed by model mutator
                    'email_verified_at' => $tutorData['email_verified_at'],
                    'status' => 3, // 3 = lengkap (complete profile)
                ]);

                echo "Created user: {$user->name} ({$user->email})\n";
            } else {
                echo "User already exists: {$user->name} ({$user->email})\n";
            }

            // Assign tutor role if not already assigned
            if (!$user->hasRole('tutor')) {
                $user->assignRole('tutor');
                echo "Assigned tutor role to: {$user->name}\n";
            } else {
                echo "User already has tutor role: {$user->name}\n";
            }
        }

        echo "\nTutor seeding completed!\n";
        echo "----------------------------------------\n";
        echo "Login credentials for testing:\n";
        echo "Email: tutor1@example.com\n";
        echo "Password: password123\n";
        echo "----------------------------------------\n";
    }
}