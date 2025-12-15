<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== FIX ADMIN ACCESS SOLUTION ===\n\n";

try {
    // 1. Get users without roles
    echo "1. IDENTIFYING USERS WITHOUT ROLES:\n";
    
    $usersWithoutRoles = DB::table('users')
        ->leftJoin('model_has_roles', function($join) {
            $join->on('users.id', '=', 'model_has_roles.model_id')
                 ->where('model_has_roles.model_type', '=', 'App\\Models\\User');
        })
        ->whereNull('model_has_roles.role_id')
        ->select('users.*')
        ->get();
    
    if ($usersWithoutRoles->isNotEmpty()) {
        echo "   Found " . $usersWithoutRoles->count() . " users without roles:\n";
        foreach ($usersWithoutRoles as $user) {
            echo "   - {$user->name} ({$user->email})\n";
        }
    } else {
        echo "   ✅ All users have roles assigned\n";
    }
    
    echo "\n";
    
    // 2. Get all users
    echo "2. ALL USERS IN DATABASE:\n";
    
    $allUsers = DB::table('users')->get();
    foreach ($allUsers as $user) {
        $userRoles = DB::table('model_has_roles')
            ->where('model_id', $user->id)
            ->where('model_type', 'App\\Models\\User')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('roles.name as role_name')
            ->get();
            
        echo "   {$user->name} ({$user->email})\n";
        if ($userRoles->isNotEmpty()) {
            echo "     Roles: " . $userRoles->pluck('role_name')->implode(', ') . "\n";
        } else {
            echo "     ⚠️  No roles assigned\n";
        }
    }
    
    echo "\n";
    
    // 3. Create admin role function
    echo "3. CREATING ADMIN ROLE ASSIGNMENT FUNCTION:\n";
    
    function assignAdminRole($userId) {
        try {
            $user = DB::table('users')->where('id', $userId)->first();
            if (!$user) {
                return "User not found";
            }
            
            // Check if admin role exists
            $adminRole = DB::table('roles')->where('name', 'admin')->first();
            if (!$adminRole) {
                return "Admin role not found in database";
            }
            
            // Check if user already has admin role
            $existingRole = DB::table('model_has_roles')
                ->where('model_id', $userId)
                ->where('model_type', 'App\\Models\\User')
                ->where('role_id', $adminRole->id)
                ->first();
                
            if ($existingRole) {
                return "User {$user->name} already has admin role";
            }
            
            // Assign admin role
            DB::table('model_has_roles')->insert([
                'role_id' => $adminRole->id,
                'model_type' => 'App\\Models\\User',
                'model_id' => $userId
            ]);
            
            return "✅ User {$user->name} ({$user->email}) is now admin";
            
        } catch (Exception $e) {
            return "❌ Error: " . $e->getMessage();
        }
    }
    
    // 4. Auto-assign admin role to specific users
    echo "4. AUTO-ASSIGNING ADMIN ROLES:\n";
    
    // Target users who should be admin
    $targetEmails = [
        'padilzaki73@gmail.com',
        '222313311@stis.ac.id',
        'testuser@example.com'
    ];
    
    foreach ($targetEmails as $email) {
        $user = DB::table('users')->where('email', $email)->first();
        if ($user) {
            $result = assignAdminRole($user->id);
            echo "   $result\n";
        } else {
            echo "   ❌ User with email {$email} not found\n";
        }
    }
    
    echo "\n";
    
    // 5. Verify admin role assignments
    echo "5. VERIFYING ADMIN ROLE ASSIGNMENTS:\n";
    
    $adminUsers = DB::table('model_has_roles')
        ->where('model_type', 'App\\Models\\User')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->join('users', 'model_has_roles.model_id', '=', 'users.id')
        ->where('roles.name', 'admin')
        ->select('users.name', 'users.email')
        ->get();
        
    echo "   Current admin users:\n";
    foreach ($adminUsers as $admin) {
        echo "   ✅ {$admin->name} ({$admin->email})\n";
    }
    
    echo "\n";
    
    // 6. Test admin route access
    echo "6. ADMIN ROUTE ACCESS TEST:\n";
    
    echo "   Admin routes require: ['auth', 'verified', 'role:admin']\n";
    echo "   To test admin access:\n";
    echo "   1. Login as admin user\n";
    echo "   2. Go to: /admin/dashboard\n";
    echo "   3. Should redirect to admin dashboard if access granted\n";
    echo "   4. If 403 error, check email verification status\n\n";
    
    // 7. Check email verification status
    echo "7. EMAIL VERIFICATION STATUS:\n";
    
    foreach ($allUsers as $user) {
        $hasAdminRole = DB::table('model_has_roles')
            ->where('model_id', $user->id)
            ->where('model_type', 'App\\Models\\User')
            ->whereIn('role_id', DB::table('roles')->where('name', 'admin')->pluck('id'))
            ->exists();
            
        if ($hasAdminRole) {
            $verified = $user->email_verified_at ? '✅ Verified' : '❌ Not verified';
            echo "   {$user->name}: $verified\n";
        }
    }
    
    echo "\n";
    
    // 8. Provide manual assignment function
    echo "8. MANUAL ADMIN ASSIGNMENT FUNCTION:\n";
    
    echo "   If you need to manually assign admin role, use this SQL:\n\n";
    
    foreach ($usersWithoutRoles as $user) {
        echo "   -- Make {$user->name} ({$user->email}) an admin\n";
        echo "   INSERT INTO model_has_roles (role_id, model_type, model_id)\n";
        echo "   SELECT id, 'App\\\\Models\\\\User', '{$user->id}'\n";
        echo "   FROM roles WHERE name = 'admin';\n\n";
    }
    
    // 9. Create Laravel command for admin assignment
    echo "9. LARAVEL ARTISAN COMMAND:\n";
    
    $commandContent = <<<'PHP'
<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class MakeUserAdmin extends Command
{
    protected $signature = 'user:make-admin {email}';
    protected $description = 'Make a user admin by email';

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
        
        // Assign role to user
        $user->assignRole('admin');
        
        $this->info("User {$user->name} ({$user->email}) is now admin");
        
        return 0;
    }
}
PHP;
    
    file_put_contents('MakeUserAdmin.php', $commandContent);
    echo "   ✅ Created Laravel command: MakeUserAdmin.php\n";
    echo "   📝 Move to app/Console/Commands/ and run: php artisan user:make-admin {email}\n\n";
    
    // 10. Final summary
    echo "10. SUMMARY AND NEXT STEPS:\n";
    echo "   ✅ Identified users without admin roles\n";
    echo "   ✅ Auto-assigned admin roles to target users\n";
    echo "   ✅ Verified current admin assignments\n";
    echo "   ✅ Provided manual assignment methods\n";
    echo "   ✅ Created Laravel artisan command\n\n";
    
    echo "   🎯 TO TEST ADMIN ACCESS:\n";
    echo "   1. Login as: padilzaki73@gmail.com or 222313311@stis.ac.id\n";
    echo "   2. Go to: http://your-domain.com/admin/dashboard\n";
    echo "   3. Should now have admin access\n";
    echo "   4. If still getting 403, check email verification\n\n";
    
    echo "   🔧 IF STILL HAVING ISSUES:\n";
    echo "   1. Clear cache: php artisan cache:clear\n";
    echo "   2. Clear route cache: php artisan route:clear\n";
    echo "   3. Check middleware: ensure 'role:admin' is working\n";
    echo "   4. Verify user email is verified\n\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "=== ADMIN ACCESS FIX COMPLETE ===\n";
?>