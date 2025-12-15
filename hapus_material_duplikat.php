<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== MENGHAPUS MATERIAL DUPLIKAT ===\n\n";

// Show current materials
$materials = DB::table('materials')->orderBy('created_at')->get();
echo "Materials SEBELUM dihapus:\n";
foreach ($materials as $i => $material) {
    echo "   " . ($i + 1) . ". ID: {$material->id}\n";
    echo "      Title: {$material->title}\n";
    echo "      Description: {$material->description}\n\n";
}

// Keep the first one, delete the second
$firstMaterial = $materials->first();
$secondMaterial = $materials->last();

echo "Akan MENYIMPAN:\n";
echo "   - {$firstMaterial->title} (ID: {$firstMaterial->id})\n\n";

echo "Akan MENGHAPUS:\n";
echo "   - {$secondMaterial->title} (ID: {$secondMaterial->id})\n\n";

// Delete the second material
$deleted = DB::table('materials')
    ->where('id', $secondMaterial->id)
    ->delete();

if ($deleted) {
    echo "✅ Material '{$secondMaterial->title}' berhasil dihapus!\n\n";
} else {
    echo "❌ Gagal menghapus material\n\n";
}

// Show remaining materials
$remainingMaterials = DB::table('materials')->get();
echo "Materials SESUDAH dihapus:\n";
foreach ($remainingMaterials as $material) {
    echo "   - {$material->title}\n";
    echo "     Description: {$material->description}\n\n";
}

echo "Total materials sekarang: " . $remainingMaterials->count() . "\n";
echo "✅ SELESAI! Sekarang hanya ada 1 material.\n";