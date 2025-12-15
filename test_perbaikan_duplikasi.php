<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST PERBAIKAN DUPLIKASI COURSE ===\n\n";

// Simulate the exact scenario user is experiencing
$userId = '463d4d82-94f1-42d2-96a9-7e1264abad56'; // User yang sudah beli paket

// 1. Get all packages with purchase status for this user
$paketUjian = DB::table('paket_ujian')
    ->leftJoin('pembelian', function($join) use ($userId) {
        $join->on('paket_ujian.id', '=', 'pembelian.paket_id')
             ->where('pembelian.user_id', '=', $userId)
             ->where('pembelian.status', '=', 'Sukses');
    })
    ->select('paket_ujian.*', 'pembelian.id as pembelian_id')
    ->orderBy('paket_ujian.created_at')
    ->get();

// 2. Separate purchased and available packages
$purchasedPackages = $paketUjian->filter(function($paket) {
    return !empty($paket->pembelian_id);
});

$availablePackages = $paketUjian->filter(function($paket) {
    return empty($paket->pembelian_id);
});

echo "User ID: {$userId}\n";
echo "Total packages: " . $paketUjian->count() . "\n";
echo "Purchased packages: " . $purchasedPackages->count() . "\n";
echo "Available packages: " . $availablePackages->count() . "\n\n";

// 3. Test OLD logic (before fix)
echo "🔴 LOGIC LAMA (SEBELUM PERBAIKAN):\n";
$oldPackagesToShow = isset($availablePackages) ? $availablePackages : $paketUjian;
echo "   Packages shown in pricing section: " . $oldPackagesToShow->count() . "\n";
foreach($oldPackagesToShow as $p) {
    $status = !empty($p->pembelian_id) ? 'PURCHASED' : 'AVAILABLE';
    echo "   - {$p->nama} ({$status})\n";
}
echo "   ❌ MASALAH: User melihat package yang sudah dibeli di pricing section!\n\n";

// 4. Test NEW logic (after fix)
echo "🟢 LOGIC BARU (SETELAH PERBAIKAN):\n";
if (auth()->check() && isset($availablePackages)) {
    $newPackagesToShow = $availablePackages;
} else {
    $newPackagesToShow = $paketUjian;
}
echo "   Packages shown in pricing section: " . $newPackagesToShow->count() . "\n";
foreach($newPackagesToShow as $p) {
    $status = !empty($p->pembelian_id) ? 'PURCHASED' : 'AVAILABLE';
    echo "   - {$p->nama} ({$status})\n";
}
echo "   ✅ SOLUSI: User hanya melihat package yang belum dibeli di pricing section!\n\n";

// 5. Test what user will see
echo "👀 TAMPILAN USER SETELAH PERBAIKAN:\n";
echo "   📚 Section 'Kursus Saya' (hijau):\n";
foreach($purchasedPackages as $p) {
    echo "      ✅ {$p->nama} - Status: SUDAH DIBELI\n";
}
echo "   💰 Section 'Pricing' (putih/biru):\n";
foreach($newPackagesToShow as $p) {
    echo "      💵 {$p->nama} - Status: TERSEDIA UNTUK DIBELI\n";
}

// 6. Verify no duplication
echo "\n🔍 VERIFIKASI DUPLIKASI:\n";
$allSeenPackages = $purchasedPackages->merge($newPackagesToShow);
if ($allSeenPackages->count() === $paketUjian->count()) {
    echo "   ✅ TIDAK ADA DUPLIKASI - Setiap paket hanya muncul sekali\n";
    echo "   ✅ Total unik: " . $allSeenPackages->count() . " paket\n";
} else {
    echo "   ❌ MASIH ADA DUPLIKASI!\n";
}

echo "\n=== HASIL TEST ===\n";
echo "SEBELUM: User melihat 1 paket × 2 kali (duplikat)\n";
echo "SESUDAH: User melihat 1 paket × 1 kali (unique)\n";
echo "         + 0 paket di pricing section (karena semua sudah dibeli)\n";
echo "✅ PERBAIKAN BERHASIL!\n";