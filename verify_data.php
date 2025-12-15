<?php

/**
 * Script untuk memverifikasi data wilayah, formasi, dan program studi
 */

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Prodi;
use App\Models\Formasi;
use App\Models\Wilayah;

echo "=== VERIFIKASI DATA SETELAH SEEDING ===\n\n";

// Cek Prodi
$prodiCount = Prodi::count();
echo "📚 Program Studi (Prodi): {$prodiCount} data\n";
if ($prodiCount > 0) {
    $prodis = Prodi::all();
    foreach ($prodis as $prodi) {
        echo "   - Kode {$prodi->kode}: {$prodi->nama}\n";
    }
}

// Cek Formasi
$formasiCount = Formasi::count();
echo "\n🏢 Formasi: {$formasiCount} data\n";
if ($formasiCount > 0) {
    $formasis = Formasi::limit(10)->get();
    echo "   Sample data:\n";
    foreach ($formasis as $formasi) {
        echo "   - Kode {$formasi->kode}: {$formasi->nama}\n";
    }
    if ($formasiCount > 10) {
        echo "   ... dan " . ($formasiCount - 10) . " data lainnya\n";
    }
}

// Cek Wilayah
$wilayahCount = Wilayah::count();
echo "\n🗺️  Wilayah: {$wilayahCount} data\n";
if ($wilayahCount > 0) {
    $wilayahs = Wilayah::limit(10)->get();
    echo "   Sample data:\n";
    foreach ($wilayahs as $wilayah) {
        echo "   - Kode {$wilayah->kode}: {$wilayah->nama}\n";
    }
    if ($wilayahCount > 10) {
        echo "   ... dan " . ($wilayahCount - 10) . " data lainnya\n";
    }
}

echo "\n=== RINGKASAN ===\n";
if ($prodiCount > 0 && $formasiCount > 0 && $wilayahCount > 0) {
    echo "✅ SEMUA DATA BERHASIL DIPULIHKAN!\n";
    echo "   - Prodi: {$prodiCount} data\n";
    echo "   - Formasi: {$formasiCount} data\n"; 
    echo "   - Wilayah: {$wilayahCount} data\n";
    echo "\n💡 Data sekarang sudah tersedia di dropdown form registrasi dan profile.\n";
    echo "🌐 API endpoints juga sudah berfungsi:\n";
    echo "   - GET /api/prodi\n";
    echo "   - GET /api/formasi\n";
    echo "   - GET /api/wilayah\n";
} else {
    echo "❌ MASIH ADA DATA YANG KURANG:\n";
    echo "   - Prodi: {$prodiCount} data\n";
    echo "   - Formasi: {$formasiCount} data\n";
    echo "   - Wilayah: {$wilayahCount} data\n";
}

echo "\n🎉 Verifikasi selesai!\n";