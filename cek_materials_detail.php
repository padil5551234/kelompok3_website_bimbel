<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CEK DETAIL MATERIALS DI DATABASE ===\n\n";

// Get all materials
$materials = DB::table('materials')
    ->orderBy('created_at')
    ->get();

echo "Total materials di database: " . $materials->count() . "\n\n";

foreach ($materials as $material) {
    echo "-----------------------------------\n";
    echo "ID: {$material->id}\n";
    echo "Title: {$material->title}\n";
    echo "Batch ID: {$material->batch_id}\n";
    echo "Chapter Number: {$material->chapter_number}\n";
    echo "Chapter Title: {$material->chapter_title}\n";
    echo "Description: {$material->description}\n";
    echo "Type: {$material->type}\n";
    echo "Mapel: {$material->mapel}\n";
    echo "Created At: {$material->created_at}\n";
    echo "Updated At: {$material->updated_at}\n";
    echo "\n";
}

// Check for duplicates
echo "\n=== CEK DUPLIKASI ===\n";
$grouped = DB::table('materials')
    ->select('title', 'batch_id', DB::raw('COUNT(*) as count'))
    ->groupBy('title', 'batch_id')
    ->having('count', '>', 1)
    ->get();

if ($grouped->count() > 0) {
    echo "❌ DITEMUKAN DUPLIKASI:\n";
    foreach ($grouped as $group) {
        echo "   - Title: {$group->title} (Muncul {$group->count} kali)\n";
    }
} else {
    echo "✅ Tidak ada duplikasi berdasarkan title + batch_id\n";
}

// Check chapter info
echo "\n=== CEK CHAPTER INFO ===\n";
$chapters = DB::table('materials')
    ->select('chapter_number', 'chapter_title', DB::raw('COUNT(*) as materials_count'))
    ->groupBy('chapter_number', 'chapter_title')
    ->get();

foreach ($chapters as $chapter) {
    echo "Chapter {$chapter->chapter_number}: {$chapter->chapter_title}\n";
    echo "   Materials count: {$chapter->materials_count}\n";
}

echo "\n=== KESIMPULAN ===\n";
if ($materials->count() == 1) {
    echo "❌ MASALAH: User upload 1 course tapi di database hanya ada 1 material\n";
    echo "            Mungkin masalah di view yang menampilkan duplikat\n";
} else if ($materials->count() == 2) {
    echo "❌ MASALAH: User upload 1 course tapi di database ada 2 materials\n";
    echo "            Kemungkinan bug di admin controller saat save/update\n";
} else {
    echo "Total materials: {$materials->count()}\n";
}
