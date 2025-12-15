<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== PERBAIKAN DUPLIKASI MATERIALS ===\n\n";

echo "PILIHAN SOLUSI:\n";
echo "1. Hapus 1 material (jika memang hanya ingin 1 material)\n";
echo "2. Biarkan 2 materials (jika memang sengaja ada 2 pertemuan)\n\n";

// Show current materials
$materials = DB::table('materials')->orderBy('created_at')->get();
echo "Materials saat ini:\n";
foreach ($materials as $material) {
    echo "   - ID: {$material->id}\n";
    echo "     Title: {$material->title}\n";
    echo "     Description: {$material->description}\n";
    echo "     Chapter: {$material->chapter_number} - {$material->chapter_title}\n\n";
}

echo "PERTANYAAN:\n";
echo "- Apakah Anda memang sengaja membuat 2 materials (Pertemuan 1 dan Pertemuan 2)?\n";
echo "- Atau seharusnya hanya 1 material saja?\n\n";

echo "JIKA HANYA INGIN 1 MATERIAL:\n";
echo "Jalankan script berikut untuk menghapus salah satu material:\n";
echo "php artisan tinker\n";
echo "DB::table('materials')->where('id', '6deeac81-d110-4e82-b2ce-6f8c8c08b467')->delete();\n\n";

echo "JIKA MEMANG INGIN 2 MATERIALS (Desain yang Benar):\n";
echo "Maka tidak ada masalah di database. Ini adalah desain yang benar:\n";
echo "   - 1 Course = 1 Paket\n";
echo "   - 1 Course bisa punya BANYAK Materials/Pertemuan\n";
echo "   - Di case Anda: 1 Course dengan 2 Pertemuan\n\n";

echo "Masalah yang mungkin membingungkan:\n";
echo "   - Badge dan thumbnail terlihat sama\n";
echo "   - Keduanya sama-sama 'Bab 1'\n";
echo "   - Ini membuat terlihat seperti duplikat padahal bukan\n\n";

echo "SOLUSI VISUAL:\n";
echo "Saya akan perbaiki tampilan agar lebih jelas membedakan:\n";
echo "   - Material 1: Pertemuan 1 - Bab 1\n";
echo "   - Material 2: Pert emuan 2 - Bab 1\n";
echo "   Sehingga user tahu ini 2 pertemuan yang berbeda\n";