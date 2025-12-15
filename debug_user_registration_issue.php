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

echo "=== DEBUGGING USER REGISTRATION ISSUE ===\n\n";

// Check database connection
try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/database/database.sqlite");
    echo "✅ Database connection: OK\n";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

// Check if users table exists
if (!Schema::hasTable('users')) {
    echo "❌ Users table does not exist!\n";
    exit(1);
}
echo "✅ Users table exists\n";

// Check if roles table exists
if (!Schema::hasTable('roles')) {
    echo "❌ Roles table does not exist!\n";
    exit(1);
}
echo "✅ Roles table exists\n";

// Check if model_has_roles table exists
if (!Schema::hasTable('model_has_roles')) {
    echo "❌ Model has roles table does not exist!\n";
    exit(1);
}
echo "✅ Model has roles table exists\n";

// Check available roles
echo "\n--- Available Roles ---\n";
$roles = DB::table('roles')->get();
if ($roles->isEmpty()) {
    echo "❌ No roles found in database!\n";
} else {
    foreach ($roles as $role) {
        echo "Role ID: {$role->id}, Name: {$role->name}, Guard: {$role->guard_name}\n";
    }
}

// Check total users
echo "\n--- User Statistics ---\n";
$totalUsers = User::count();
echo "Total users: {$totalUsers}\n";

// Check users by role
echo "\n--- Users by Role ---\n";
$userRole = Role::where('name', 'user')->first();
if ($userRole) {
    $usersWithUserRole = DB::table('model_has_roles')
        ->where('role_id', $userRole->id)
        ->count();
    echo "Users with 'user' role: {$usersWithUserRole}\n";
} else {
    echo "❌ 'user' role not found!\n";
}

$adminRole = Role::where('name', 'admin')->first();
if ($adminRole) {
    $usersWithAdminRole = DB::table('model_has_roles')
        ->where('role_id', $adminRole->id)
        ->count();
    echo "Users with 'admin' role: {$usersWithAdminRole}\n";
} else {
    echo "❌ 'admin' role not found!\n";
}

// Show sample users
echo "\n--- Sample Users (First 10) ---\n";
$sampleUsers = User::limit(10)->get();
foreach ($sampleUsers as $user) {
    $roles = $user->getRoleNames();
    echo "User ID: {$user->id}\n";
    echo "  Name: {$user->name}\n";
    echo "  Email: {$user->email}\n";
    echo "  Email verified: " . ($user->email_verified_at ? 'Yes' : 'No') . "\n";
    echo "  Roles: " . ($roles->isEmpty() ? 'No roles' : $roles->implode(', ')) . "\n";
    
    // Check if user has UsersDetail
    $usersDetail = UsersDetail::find($user->id);
    echo "  Has UsersDetail: " . ($usersDetail ? 'Yes' : 'No') . "\n";
    echo "  Created at: {$user->created_at}\n";
    echo "  ---\n";
}

// Test the UserController data method
echo "\n--- Testing UserController data method ---\n";
try {
    // This simulates what the admin user list does
    $users = User::with('usersDetail')
        ->role('user')
        ->orderBy('created_at', 'desc')
        ->get();
    
    echo "Users found by UserController::data() method: " . $users->count() . "\n";
    
    if ($users->isEmpty()) {
        echo "❌ No users found with 'user' role!\n";
        echo "This explains why the admin panel shows no users.\n";
    } else {
        echo "✅ Found users with 'user' role:\n";
        foreach ($users as $user) {
            echo "  - {$user->name} ({$user->email})\n";
        }
    }
} catch (Exception $e) {
    echo "❌ Error testing UserController data method: " . $e->getMessage() . "\n";
}

// Check for users without roles
echo "\n--- Users Without Roles ---\n";
$usersWithoutRoles = User::whereDoesntHave('roles')->get();
echo "Users without any role: " . $usersWithoutRoles->count() . "\n";

if ($usersWithoutRoles->isNotEmpty()) {
    echo "⚠️  These users don't have any roles assigned:\n";
    foreach ($usersWithoutRoles as $user) {
        echo "  - {$user->name} ({$user->email}) - Created: {$user->created_at}\n";
    }
    echo "\n💡 SOLUTION: These users need to be assigned the 'user' role.\n";
}

// Check for users with wrong roles
echo "\n--- Users with Other Roles ---\n";
$allRoles = Role::all();
foreach ($allRoles as $role) {
    $usersWithRole = User::role($role->name)->get();
    if ($usersWithRole->isNotEmpty() && $role->name !== 'user' && $role->name !== 'admin') {
        echo "Users with '{$role->name}' role: " . $usersWithRole->count() . "\n";
    }
}

echo "\n=== END DEBUG ===\n";