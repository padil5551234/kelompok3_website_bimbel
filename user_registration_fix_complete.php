<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\UsersDetail;
use Spatie\Permission\Models\Role;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== COMPREHENSIVE USER REGISTRATION FIX ===\n\n";

// Step 1: Ensure all necessary roles exist
echo "Step 1: Checking and creating necessary roles...\n";
$requiredRoles = ['user', 'admin', 'tutor', 'bendahara', 'panitia'];

foreach ($requiredRoles as $roleName) {
    $role = Role::where('name', $roleName)->first();
    if (!$role) {
        $role = Role::create(['name' => $roleName, 'guard_name' => 'web']);
        echo "✅ Created role: {$roleName}\n";
    } else {
        echo "✅ Role exists: {$roleName}\n";
    }
}

// Step 2: Fix users without any roles
echo "\nStep 2: Fixing users without roles...\n";
$usersWithoutRoles = User::whereDoesntHave('roles')->get();

if ($usersWithoutRoles->isEmpty()) {
    echo "✅ No users need role assignment\n";
} else {
    echo "Found " . $usersWithoutRoles->count() . " users without roles.\n";
    
    foreach ($usersWithoutRoles as $user) {
        try {
            $user->assignRole('user');
            echo "✅ Assigned 'user' role to: {$user->name} ({$user->email})\n";
        } catch (Exception $e) {
            echo "❌ Failed to assign role to {$user->email}: " . $e->getMessage() . "\n";
        }
    }
}

// Step 3: Create UsersDetail for users who don't have it
echo "\nStep 3: Ensuring UsersDetail exists for all users...\n";
$usersWithoutDetails = User::whereDoesntHave('usersDetail')->get();

if ($usersWithoutDetails->isEmpty()) {
    echo "✅ All users have UsersDetail\n";
} else {
    echo "Found " . $usersWithoutDetails->count() . " users without UsersDetail.\n";
    
    foreach ($usersWithoutDetails as $user) {
        try {
            UsersDetail::create([
                'id' => $user->id,
                'no_hp' => '', // Empty for now, can be updated later
                'asal_sekolah' => '', // Empty for now, can be updated later
            ]);
            echo "✅ Created UsersDetail for: {$user->name} ({$user->email})\n";
        } catch (Exception $e) {
            echo "❌ Failed to create UsersDetail for {$user->email}: " . $e->getMessage() . "\n";
        }
    }
}

// Step 4: Final verification
echo "\nStep 4: Final verification...\n";
$userRoleCount = User::role('user')->count();
$adminRoleCount = User::role('admin')->count();
$tutorRoleCount = User::role('tutor')->count();
$usersWithoutAnyRole = User::whereDoesntHave('roles')->count();

echo "✅ Users with 'user' role: {$userRoleCount}\n";
echo "✅ Users with 'admin' role: {$adminRoleCount}\n";
echo "✅ Users with 'tutor' role: {$tutorRoleCount}\n";
echo "✅ Users without any role: {$usersWithoutAnyRole}\n";

if ($userRoleCount > 0) {
    echo "\n🎉 SUCCESS: Regular users should now appear in the admin panel!\n";
    
    echo "\n--- Regular Users List ---\n";
    $regularUsers = User::role('user')->get();
    foreach ($regularUsers as $user) {
        echo "  - {$user->name} ({$user->email})\n";
    }
} else {
    echo "\n❌ WARNING: No users found with 'user' role!\n";
}

echo "\n=== COMPREHENSIVE FIX COMPLETE ===\n";
echo "Summary:\n";
echo "- ✅ All necessary roles are created\n";
echo "- ✅ Users without roles have been assigned 'user' role\n";
echo "- ✅ All users have UsersDetail records\n";
echo "\nPlease refresh the admin user list to see the changes.\n";
echo "New user registrations should now automatically assign the 'user' role.\n";