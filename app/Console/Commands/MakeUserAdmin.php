<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a user admin by email address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found");
            return 1;
        }

        // Ensure admin role exists
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Check if user already has admin role
        if ($user->hasRole('admin')) {
            $this->warn("User {$user->name} already has admin role");
            return 0;
        }
        
        // Assign role to user
        $user->assignRole('admin');
        
        $this->info("✅ User {$user->name} ({$user->email}) is now admin");
        
        return 0;
    }
}
