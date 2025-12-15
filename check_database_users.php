<?php

/**
 * Script untuk memeriksa data users di database
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔍 MEMERIKSA DATABASE USERS\n";
echo "============================\n\n";

try {
    // 1. Cek semua users di database
    echo "1️⃣ SEMUA USERS DI DATABASE:\n";
    echo "============================\n";
    
    $allUsers = App\Models\User::all();
    
    if ($allUsers->count() == 0) {
        echo "❌ Tidak ada users di database!\n";
    } else {
        echo "📊 Total users: " . $allUsers->count() . "\n\n";
        
        foreach ($allUsers as $user) {
            $verified = $user->email_verified_at ? '✅' : '❌';
            $status = $user->status ? '✅' : '❌';
            echo "ID: {$user->id}\n";
            echo "Name: {$user->name}\n";
            echo "Email: {$user->email}\n";
            echo "Email Verified: {$verified}\n";
            echo "Status: {$status}\n";
            echo "Created: {$user->created_at}\n";
            echo "---\n";
        }
    }
    
    echo "\n";
    
    // 2. Cek users dengan nama "padil muhammad zaki"
    echo "2️⃣ CARI USER DENGAN NAMA 'padil muhammad zaki':\n";
    echo "===============================================\n";
    
    $zakiUsers = App\Models\User::where('name', 'like', '%padil%')->orWhere('name', 'like', '%zaki%')->get();
    
    if ($zakiUsers->count() == 0) {
        echo "❌ Tidak ada user dengan nama yang mengandung 'padil' atau 'zaki'\n";
    } else {
        echo "📊 Ditemukan: " . $zakiUsers->count() . " user\n\n";
        
        foreach ($zakiUsers as $user) {
            $verified = $user->email_verified_at ? '✅' : '❌';
            $status = $user->status ? '✅' : '❌';
            echo "ID: {$user->id}\n";
            echo "Name: {$user->name}\n";
            echo "Email: {$user->email}\n";
            echo "Email Verified: {$verified}\n";
            echo "Status: {$status}\n";
            echo "---\n";
        }
    }
    
    echo "\n";
    
    // 3. Cek users dengan email padilzaki73@gmail.com
    echo "3️⃣ CARI USER DENGAN EMAIL 'padilzaki73@gmail.com':\n";
    echo "===================================================\n";
    
    $padilEmailUser = App\Models\User::where('email', 'padilzaki73@gmail.com')->first();
    
    if ($padilEmailUser) {
        $verified = $padilEmailUser->email_verified_at ? '✅' : '❌';
        $status = $padilEmailUser->status ? '✅' : '❌';
        echo "✅ USER DITEMUKAN!\n";
        echo "ID: {$padilEmailUser->id}\n";
        echo "Name: {$padilEmailUser->name}\n";
        echo "Email: {$padilEmailUser->email}\n";
        echo "Email Verified: {$verified}\n";
        echo "Status: {$status}\n";
    } else {
        echo "❌ USER TIDAK DITEMUKAN!\n";
        echo "Email 'padilzaki73@gmail.com' tidak ada di database\n";
    }
    
    echo "\n";
    
    // 4. Cek admin users
    echo "4️⃣ ADMIN USERS SAAT INI:\n";
    echo "========================\n";
    
    $adminUsers = App\Models\User::role('admin')->get();
    
    if ($adminUsers->count() == 0) {
        echo "❌ Tidak ada admin users!\n";
    } else {
        echo "📊 Total admin users: " . $adminUsers->count() . "\n\n";
        
        foreach ($adminUsers as $admin) {
            $verified = $admin->email_verified_at ? '✅' : '❌';
            $status = $admin->status ? '✅' : '❌';
            echo "ID: {$admin->id}\n";
            echo "Name: {$admin->name}\n";
            echo "Email: {$admin->email}\n";
            echo "Email Verified: {$verified}\n";
            echo "Status: {$status}\n";
            echo "---\n";
        }
    }
    
    echo "\n";
    
    // 5. Cek apakah ada data di tabel model_has_roles
    echo "5️⃣ ROLE ASSIGNMENTS:\n";
    echo "===================\n";
    
    $roleAssignments = DB::table('model_has_roles')->get();
    echo "📊 Total role assignments: " . $roleAssignments->count() . "\n";
    
    foreach ($roleAssignments as $assignment) {
        $user = App\Models\User::find($assignment->model_id);
        $role = Spatie\Permission\Models\Role::find($assignment->role_id);
        if ($user && $role) {
            echo "User: {$user->name} ({$user->email}) → Role: {$role->name}\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n🔍 DATABASE CHECK COMPLETE\n";
echo "==========================\n";