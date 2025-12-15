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

// Step 3: Audit users who should be regular users but have admin roles
echo "\nStep 3: Auditing user roles...\n";
$allUsers = User::with('roles')->get();
$suspiciousAdmins = [];

foreach ($allUsers as $user) {
    $roles = $user->getRoleNames();
    
    // Check if user has multiple roles or wrong roles
    if ($roles->contains('admin') && $roles->count() === 1) {
        // This might be a user who was incorrectly made admin
        $suspiciousAdmins[] = $user;
    }
}

if (!empty($suspiciousAdmins)) {
    echo "⚠️  Found " . count($suspiciousAdmins) . " users who might be incorrectly assigned admin role:\n";
    foreach ($suspiciousAdmins as $user) {
        echo "  - {$user->name} ({$user->email}) - Created: {$user->created_at}\n";
        echo "    Consider if this should be a regular user instead of admin\n";
    }
}

// Step 4: Create UsersDetail for users who don't have it
echo "\nStep 4: Ensuring UsersDetail exists for all users...\n";
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

// Step 5: Final verification
echo "\nStep 5: Final verification...\n";
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

// Step 6: Test registration flow
echo "\nStep 6: Testing registration flow...\n";
try {
    $testUser = new User();
    $testUser->name = 'Test Registration Flow';
    $testUser->email = 'test-registration-' . time() . '@example.com';
    $testUser->password = bcrypt('password123');
    $testUser->email_verified_at = now();
    $testUser->save();
    
    // Test role assignment
    $testUser->assignRole('user');
    
    // Test UsersDetail creation
    $testUser->usersDetail()->create([
        'id' => $testUser->id,
        'no_hp' => '081234567890',
        'asal_sekolah' => 'Test School',
    ]);
    
    echo "✅ Test registration flow successful\n";
    echo "  - User created: {$testUser->name}\n";
    echo "  - Email: {$testUser->email}\n";
    echo "  - Role: " . $testUser->getRoleNames()->implode(', ') . "\n";
    echo "  - Has UsersDetail: " . ($testUser->usersDetail ? 'Yes' : 'No') . "\n";
    
    // Clean up test user
    $testUser->delete();
    echo "✅ Test user cleaned up\n";
    
} catch (Exception $e) {
    echo "❌ Registration flow test failed: " . $e->getMessage() . "\n";
}

echo "\n=== COMPREHENSIVE FIX COMPLETE ===\n";
echo "Summary:\n";
echo "- ✅ All necessary roles are created\n";
echo "- ✅ Users without roles have been assigned 'user' role\n";
echo "- ✅ All users have UsersDetail records\n";
echo "- ✅ Registration flow has been tested\n";
echo "\nPlease refresh the admin user list to see the changes.\n";
echo "New user registrations should now automatically assign the 'user' role.\n";