<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DIAGNOSIS DUPLIKASI COURSE ===\n\n";

// 1. Check all packages
echo "1. SEMUA PAKET YANG ADA:\n";
$pakets = DB::table('paket_ujian')->orderBy('created_at')->get();
foreach($pakets as $paket) {
    echo "   - ID: {$paket->id}\n";
    echo "     Nama: {$paket->nama}\n";
    echo "     Harga: Rp " . number_format($paket->harga, 0, ',', '.') . "\n";
    echo "     Created: {$paket->created_at}\n\n";
}

// 2. Check all purchases
echo "\n2. SEMUA PEMBELIAN:\n";
$pembelians = DB::table('pembelian')->orderBy('created_at')->get();
foreach($pembelians as $pembelian) {
    echo "   - User ID: {$pembelian->user_id}\n";
    echo "     Paket ID: {$pembelian->paket_id}\n";
    echo "     Status: {$pembelian->status}\n";
    echo "     Harga: Rp " . number_format($pembelian->harga, 0, ',', '.') . "\n";
    echo "     Created: {$pembelian->created_at}\n\n";
}

// 3. Check materials per package
echo "\n3. MATERIALS PER PAKET:\n";
foreach($pakets as $paket) {
    $materials = DB::table('materials')->where('batch_id', $paket->id)->get();
    echo "   Paket: {$paket->nama} (ID: {$paket->id})\n";
    echo "   Materials Count: " . $materials->count() . "\n";
    foreach($materials as $material) {
        echo "     - {$material->title} (Chapter: {$material->chapter_number})\n";
    }
    echo "\n";
}

// 4. Simulate DashboardController logic
echo "\n4. SIMULASI LOGIC DASHBOARD CONTROLLER:\n";

$allPackages = DB::table('paket_ujian')
    ->leftJoin('pembelian', function($join) {
        $join->on('paket_ujian.id', '=', 'pembelian.paket_id')
             ->where('pembelian.user_id', '=', 1) // Simulate user ID 1
             ->where('pembelian.status', '=', 'Sukses');
    })
    ->select('paket_ujian.*', 'pembelian.id as pembelian_id')
    ->get();

echo "   Raw query result:\n";
foreach($allPackages as $package) {
    $purchased = !empty($package->pembelian_id) ? 'YES' : 'NO';
    echo "   - {$package->nama} (Purchased: {$purchased})\n";
}

// Separate purchased and available
$purchasedPackages = $allPackages->filter(function($package) {
    return !empty($package->pembelian_id);
});

$availablePackages = $allPackages->filter(function($package) {
    return empty($package->pembelian_id);
});

echo "\n   Purchased packages: " . $purchasedPackages->count() . "\n";
foreach($purchasedPackages as $p) {
    echo "   - {$p->nama}\n";
}

echo "\n   Available packages: " . $availablePackages->count() . "\n";
foreach($availablePackages as $p) {
    echo "   - {$p->nama}\n";
}

echo "\n=== END DIAGNOSIS ===\n";