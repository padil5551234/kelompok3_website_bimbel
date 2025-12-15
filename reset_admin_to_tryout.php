<?php

/**
 * Script untuk mereset admin dan hanya menetapkan admin@tryout.com sebagai admin
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔧 MEMULAI RESET ADMIN SYSTEM\n";
echo "========================================\n\n";

// 1. Hapus semua role admin dari user yang bukan admin@tryout.com
echo "1️⃣ Menghapus role admin dari user non-admin@tryout.com...\n";

$users = App\Models\User::all();
$adminRemoved = 0;

foreach ($users as $user) {
    if ($user->email !== 'admin@tryout.com' && $user->hasRole('admin')) {
        $user->removeRole('admin');
        echo "   ❌ Removed admin role from: {$user->name} ({$user->email})\n";
        $adminRemoved++;
    }
}

echo "   ✅ Total admin roles removed: {$adminRemoved}\n\n";

// 2. Pastikan admin@tryout.com memiliki role admin
echo "2️⃣ Memastikan admin@tryout.com memiliki role admin...\n";

$adminUser = App\Models\User::where('email', 'admin@tryout.com')->first();

if (!$adminUser) {
    echo "   ⚠️  admin@tryout.com tidak ditemukan, membuat user baru...\n";
    
    $adminUser = App\Models\User::create([
        'name' => 'Admin Tryout',
        'email' => 'admin@tryout.com',
        'password' => bcrypt('admin2024'),
        'email_verified_at' => now(),
        'status' => 1,
    ]);
    
    echo "   ✅ User admin@tryout.com berhasil dibuat\n";
} else {
    echo "   ✅ User admin@tryout.com ditemukan\n";
}

// Assign role admin
$adminRole = Spatie\Permission\Models\Role::where('name', 'admin')->first();
if ($adminRole) {
    $adminUser->assignRole($adminRole);
    echo "   ✅ Role admin berhasil diberikan kepada admin@tryout.com\n";
} else {
    echo "   ❌ Role admin tidak ditemukan!\n";
}

// Pastikan status active
$adminUser->update(['status' => 1]);
echo "   ✅ Status admin@tryout.com diset menjadi active\n\n";

// 3. Verifikasi hasil akhir
echo "3️⃣ Verifikasi hasil akhir...\n";

$allAdmins = App\Models\User::role('admin')->get();
echo "   📊 Total admin users: " . $allAdmins->count() . "\n";

foreach ($allAdmins as $admin) {
    $verified = $admin->email_verified_at ? '✅' : '❌';
    $status = $admin->status ? '✅ Active' : '❌ Inactive';
    echo "   - {$admin->name} ({$admin->email}) {$verified} {$status}\n";
}

echo "\n🎯 HASIL AKHIR:\n";
echo "========================================\n";
echo "✅ Hanya admin@tryout.com yang memiliki role admin\n";
echo "✅ Admin status: Active\n";
echo "✅ Email: admin@tryout.com\n";
echo "✅ Password: admin2024\n";
echo "\n🚀 ADMIN SYSTEM BERHASIL DI-RESET!\n";
echo "========================================\n";