<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG ADMIN ACCESS ISSUE ===\n\n";

try {
    // 1. Check if Spatie Permission is installed and configured
    echo "1. CHECKING SPATIE PERMISSION CONFIGURATION:\n";
    
    if (class_exists('Spatie\Permission\PermissionServiceProvider')) {
        echo "   ✅ Spatie Permission is installed\n";
    } else {
        echo "   ❌ Spatie Permission not found\n";
        echo "   📝 Install with: composer require spatie/laravel-permission\n";
    }
    
    // 2. Check permission tables
    echo "\n2. CHECKING PERMISSION TABLES:\n";
    
    $tables = ['permissions', 'roles', 'role_has_permissions', 'model_has_roles', 'model_has_permissions'];
    foreach ($tables as $table) {
        try {
            $count = DB::table($table)->count();
            echo "   ✅ Table '$table': $count records\n";
        } catch (Exception $e) {
            echo "   ❌ Table '$table': " . $e->getMessage() . "\n";
        }
    }
    
    // 3. Check existing roles
    echo "\n3. EXISTING ROLES:\n";
    try {
        $roles = DB::table('roles')->get();
        if ($roles->isNotEmpty()) {
            foreach ($roles as $role) {
                echo "   - {$role->name} (ID: {$role->id})\n";
            }
        } else {
            echo "   ⚠️  No roles found in database\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Error checking roles: " . $e->getMessage() . "\n";
    }
    
    // 4. Check existing permissions
    echo "\n4. EXISTING PERMISSIONS:\n";
    try {
        $permissions = DB::table('permissions')->get();
        if ($permissions->isNotEmpty()) {
            echo "   Found " . $permissions->count() . " permissions:\n";
            foreach ($permissions->take(10) as $permission) {
                echo "   - {$permission->name}\n";
            }
            if ($permissions->count() > 10) {
                echo "   ... and " . ($permissions->count() - 10) . " more\n";
            }
        } else {
            echo "   ⚠️  No permissions found in database\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Error checking permissions: " . $e->getMessage() . "\n";
    }
    
    // 5. Check users and their roles
    echo "\n5. USERS AND THEIR ROLES:\n";
    try {
        $users = DB::table('users')->get();
        foreach ($users as $user) {
            $userRoles = DB::table('model_has_roles')
                ->where('model_id', $user->id)
                ->where('model_type', 'App\\Models\\User')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select('roles.name as role_name')
                ->get();
                
            echo "   User: {$user->name} ({$user->email})\n";
            if ($userRoles->isNotEmpty()) {
                echo "     Roles: " . $userRoles->pluck('role_name')->implode(', ') . "\n";
            } else {
                echo "     ⚠️  No roles assigned\n";
            }
            echo "\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Error checking user roles: " . $e->getMessage() . "\n";
    }
    
    // 6. Test admin route access
    echo "6. TESTING ADMIN ROUTE ACCESS:\n";
    echo "   Admin routes require: ['auth', 'verified', 'role:admin']\n";
    echo "   Key routes:\n";
    echo "   - GET /admin/dashboard → DashboardController@adminIndex\n";
    echo "   - POST /admin/admin/makeAdmin/{action}/{id} → AdminController@makeAdmin\n\n";
    
    // 7. Check middleware configuration
    echo "7. MIDDLEWARE CONFIGURATION:\n";
    try {
        $middlewareConfig = config('permission');
        if ($middlewareConfig) {
            echo "   ✅ Permission middleware config exists\n";
            echo "   Middleware name: " . ($middlewareConfig['middleware']['role'] ?? 'role') . "\n";
            echo "   Cache expiration: " . ($middlewareConfig['cache_expiration'] ?? 'N/A') . " minutes\n";
        } else {
            echo "   ⚠️  No permission middleware config found\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Error checking middleware config: " . $e->getMessage() . "\n";
    }
    
    // 8. Solutions and recommendations
    echo "\n8. SOLUTIONS AND RECOMMENDATIONS:\n";
    
    echo "   A. IF NO ROLES FOUND:\n";
    echo "      - Run: php artisan db:seed --class=RolePermissionSeeder\n";
    echo "      - Or manually create roles in database\n\n";
    
    echo "   B. IF USERS HAVE NO ADMIN ROLE:\n";
    echo "      - Use AdminController@makeAdmin method\n";
    echo "      - Or manually assign role in model_has_roles table\n\n";
    
    echo "   C. COMMON ISSUES:\n";
    echo "      - User email not verified (check email_verified_at)\n";
    echo "      - Role name mismatch ('admin' vs 'Admin')\n";
    echo "      - Middleware cache not cleared\n";
    echo "      - Permission tables not migrated\n\n";
    
    // 9. Create admin user function
    echo "9. CREATE ADMIN USER FUNCTION:\n";
    
    $createAdminFunction = <<<'PHP'
// Add this to AdminController or run as a command
public function makeUserAdmin($userId) {
    $user = User::find($userId);
    if (!$user) {
        return "User not found";
    }
    
    // Ensure admin role exists
    $adminRole = Role::firstOrCreate(['name' => 'admin']);
    
    // Assign role to user
    $user->assignRole('admin');
    
    return "User {$user->name} is now admin";
}
PHP;
    
    echo "   Function to make user admin:\n";
    echo "   ```php\n";
    echo $createAdminFunction;
    echo "   ```\n\n";
    
    // 10. Check specific user admin access
    echo "10. CHECK SPECIFIC USER ADMIN ACCESS:\n";
    
    if (isset($users) && $users->isNotEmpty()) {
        $firstUser = $users->first();
        echo "   Testing with user: {$firstUser->name} ({$firstUser->email})\n";
        
        try {
            // Check if user can access admin routes
            $canAccessAdmin = DB::table('model_has_roles')
                ->where('model_id', $firstUser->id)
                ->where('model_type', 'App\\Models\\User')
                ->whereIn('role_id', DB::table('roles')->where('name', 'admin')->pluck('id'))
                ->exists();
                
            if ($canAccessAdmin) {
                echo "   ✅ User can access admin routes\n";
            } else {
                echo "   ❌ User cannot access admin routes (no admin role)\n";
            }
            
            // Check email verification
            if ($firstUser->email_verified_at) {
                echo "   ✅ Email is verified\n";
            } else {
                echo "   ❌ Email is not verified\n";
            }
            
        } catch (Exception $e) {
            echo "   ❌ Error testing admin access: " . $e->getMessage() . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== DEBUG COMPLETE ===\n";
?>