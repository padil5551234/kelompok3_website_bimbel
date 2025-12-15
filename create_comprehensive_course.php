<?php

/**
 * Script untuk menambah material course yang lebih lengkap
 * - Bab 1 dengan 2-3 materi
 * - Bab 2 dengan 2-3 materi
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== MENAMBAH MATERIAL COURSE LENGKAP ===\n\n";

try {
    // 1. Cek paket ujian yang ada
    echo "1. CHECKING EXISTING PAKET:\n";
    echo "-----------------------------\n";
    
    $pakets = \App\Models\PaketUjian::all();
    if ($pakets->count() > 0) {
        echo "✅ Ditemukan " . $pakets->count() . " paket ujian:\n";
        foreach ($pakets as $paket) {
            echo "   - ID: {$paket->id}\n";
            echo "     Nama: {$paket->nama}\n";
            echo "     Harga: {$paket->harga}\n";
            echo "     Active: " . ($paket->is_active ? 'Yes' : 'No') . "\n";
        }
        
        // Gunakan paket yang ada
        $targetPaket = $pakets->first();
        echo "\n📦 Using paket: {$targetPaket->nama} (ID: {$targetPaket->id})\n";
    } else {
        echo "❌ Tidak ada paket ujian ditemukan\n";
        exit;
    }
    
    echo "\n";
    
    // 2. Cek material yang sudah ada
    echo "2. CHECKING EXISTING MATERIALS:\n";
    echo "-----------------------------\n";
    
    $existingMaterials = \App\Models\Material::where('batch_id', $targetPaket->id)->get();
    echo "✅ Ditemukan " . $existingMaterials->count() . " material existing:\n";
    foreach ($existingMaterials as $material) {
        echo "   - {$material->title} (Chapter: {$material->chapter_number})\n";
    }
    
    echo "\n";
    
    // 3. Cek tutor/user yang ada
    echo "3. CHECKING AVAILABLE USERS:\n";
    echo "-----------------------------\n";
    
    // Gunakan user pertama yang ada
    $tutor = \App\Models\User::first();
    if (!$tutor) {
        echo "❌ Tidak ada user ditemukan\n";
        exit;
    }
    echo "✅ Using user as tutor: {$tutor->name} (ID: {$tutor->id})\n";
    
    echo "\n";
    
    // 4. Tambah material untuk Bab 1
    echo "4. CREATING CHAPTER 1 MATERIALS:\n";
    echo "-----------------------------\n";
    
    $chapter1Materials = [
        [
            'title' => 'Pengenalan Matematika Dasar',
            'type' => 'youtube',
            'description' => 'Materi pengenalan untuk matematika dasar yang akan dipelajari dalam course ini.',
            'mapel' => 'Matematika',
            'chapter_number' => 1,
            'chapter_title' => 'Konsep Dasar',
            'material_order' => 1,
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Dummy URL
            'duration_seconds' => 600, // 10 menit
        ],
        [
            'title' => 'Operasi Hitung Dasar',
            'type' => 'video',
            'description' => 'Pembelajaran tentang operasi hitung dasar: penjumlahan, pengurangan, perkalian, dan pembagian.',
            'mapel' => 'Matematika',
            'chapter_number' => 1,
            'chapter_title' => 'Konsep Dasar',
            'material_order' => 2,
            'url' => 'https://example.com/materi-operasi-hitung',
            'duration_seconds' => 900, // 15 menit
        ],
        [
            'title' => 'Latihan Soal Bab 1',
            'type' => 'document',
            'description' => 'Kumpulan latihan soal untuk menguji pemahaman konsep dasar matematika.',
            'mapel' => 'Matematika',
            'chapter_number' => 1,
            'chapter_title' => 'Konsep Dasar',
            'material_order' => 3,
            'external_link' => 'https://example.com/latihan-soal-bab1.pdf',
            'duration_seconds' => 0,
        ]
    ];
    
    $createdChapter1 = [];
    foreach ($chapter1Materials as $materialData) {
        $material = \App\Models\Material::create([
            'title' => $materialData['title'],
            'type' => $materialData['type'],
            'description' => $materialData['description'],
            'mapel' => $materialData['mapel'],
            'batch_id' => $targetPaket->id,
            'tutor_id' => $tutor->id,
            'chapter_number' => $materialData['chapter_number'],
            'chapter_title' => $materialData['chapter_title'],
            'material_order' => $materialData['material_order'],
            'youtube_url' => $materialData['youtube_url'] ?? null,
            'external_link' => $materialData['external_link'] ?? null,
            'url' => $materialData['url'] ?? null,
            'duration_seconds' => $materialData['duration_seconds'],
            'views_count' => 0,
            'downloads_count' => 0,
            'is_published' => true,
            'is_public' => false,
        ]);
        
        $createdChapter1[] = $material;
        echo "✅ Created: {$material->title} (Order: {$material->material_order})\n";
    }
    
    echo "\n";
    
    // 5. Tambah material untuk Bab 2
    echo "5. CREATING CHAPTER 2 MATERIALS:\n";
    echo "-----------------------------\n";
    
    $chapter2Materials = [
        [
            'title' => 'Pecahan dan Desimal',
            'type' => 'youtube',
            'description' => 'Pembelajaran tentang konsep pecahan, desimal, dan konversi antar keduanya.',
            'mapel' => 'Matematika',
            'chapter_number' => 2,
            'chapter_title' => 'Bilangan Pecahan',
            'material_order' => 1,
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Dummy URL
            'duration_seconds' => 720, // 12 menit
        ],
        [
            'title' => 'Operasi Pecahan',
            'type' => 'video',
            'description' => 'Cara melakukan operasi matematika pada bilangan pecahan.',
            'mapel' => 'Matematika',
            'chapter_number' => 2,
            'chapter_title' => 'Bilangan Pecahan',
            'material_order' => 2,
            'url' => 'https://example.com/operasi-pecahan',
            'duration_seconds' => 1080, // 18 menit
        ],
        [
            'title' => 'Persentase',
            'type' => 'document',
            'description' => 'Materi lengkap tentang persentase dan aplikasinya dalam kehidupan sehari-hari.',
            'mapel' => 'Matematika',
            'chapter_number' => 2,
            'chapter_title' => 'Bilangan Pecahan',
            'material_order' => 3,
            'external_link' => 'https://example.com/persentase-guide.pdf',
            'duration_seconds' => 0,
        ],
        [
            'title' => 'Latihan Soal Bab 2',
            'type' => 'document',
            'description' => 'Latihan soal komprehensif untuk bab bilangan pecahan dan persentase.',
            'mapel' => 'Matematika',
            'chapter_number' => 2,
            'chapter_title' => 'Bilangan Pecahan',
            'material_order' => 4,
            'external_link' => 'https://example.com/latihan-soal-bab2.pdf',
            'duration_seconds' => 0,
        ]
    ];
    
    $createdChapter2 = [];
    foreach ($chapter2Materials as $materialData) {
        $material = \App\Models\Material::create([
            'title' => $materialData['title'],
            'type' => $materialData['type'],
            'description' => $materialData['description'],
            'mapel' => $materialData['mapel'],
            'batch_id' => $targetPaket->id,
            'tutor_id' => $tutor->id,
            'chapter_number' => $materialData['chapter_number'],
            'chapter_title' => $materialData['chapter_title'],
            'material_order' => $materialData['material_order'],
            'youtube_url' => $materialData['youtube_url'] ?? null,
            'external_link' => $materialData['external_link'] ?? null,
            'url' => $materialData['url'] ?? null,
            'duration_seconds' => $materialData['duration_seconds'],
            'views_count' => 0,
            'downloads_count' => 0,
            'is_published' => true,
            'is_public' => false,
        ]);
        
        $createdChapter2[] = $material;
        echo "✅ Created: {$material->title} (Order: {$material->material_order})\n";
    }
    
    echo "\n";
    
    // 6. Summary
    echo "6. COURSE STRUCTURE SUMMARY:\n";
    echo "-----------------------------\n";
    
    $allMaterials = \App\Models\Material::where('batch_id', $targetPaket->id)
        ->orderBy('chapter_number')
        ->orderBy('material_order')
        ->get();
        
    echo "📚 Total materials in course: " . $allMaterials->count() . "\n\n";
    
    $currentChapter = 0;
    foreach ($allMaterials as $material) {
        if ($material->chapter_number != $currentChapter) {
            $currentChapter = $material->chapter_number;
            echo "\n📖 BAB {$currentChapter}: {$material->chapter_title}\n";
            echo str_repeat('-', 50) . "\n";
        }
        
        echo sprintf("   %d.%d %s (%s) - %s\n", 
            $material->chapter_number, 
            $material->material_order,
            $material->title,
            ucfirst($material->type),
            $material->duration_seconds > 0 ? gmdate("H:i:s", $material->duration_seconds) : 'No duration'
        );
    }
    
    echo "\n";
    
    // 7. Test data untuk user
    echo "7. TEST USER ACCESS:\n";
    echo "-----------------------------\n";
    
    $testUser = \App\Models\User::find('51c28366-acc4-4db2-aba5-82a581eeb061');
    if ($testUser) {
        echo "✅ Test user: {$testUser->name}\n";
        echo "📧 Email: {$testUser->email}\n";
        
        $userPurchases = \App\Models\Pembelian::forUser($testUser->id)
            ->forPackage($targetPaket->id)
            ->verified()
            ->exists();
            
        echo "🎯 Has access to course: " . ($userPurchases ? 'YES' : 'NO') . "\n";
        
        if ($userPurchases) {
            echo "\n🎮 READY FOR TESTING!\n";
            echo "User dapat test fungsi 'Tandai Selesai' pada semua material di atas.\n";
            echo "URL: /materials/{material_id}\n";
            
            // List material IDs untuk testing
            echo "\n📋 MATERIAL IDs FOR TESTING:\n";
            foreach ($allMaterials as $material) {
                echo "   {$material->title}: /materials/{$material->id}\n";
            }
        } else {
            echo "⚠️  User tidak punya akses ke paket ini\n";
        }
    }
    
    echo "\n=== COURSE CREATION COMPLETED ===\n";
    echo "✅ Successfully created comprehensive course structure!\n";
    echo "✅ Chapter 1: " . count($createdChapter1) . " materials (Konsep Dasar)\n";
    echo "✅ Chapter 2: " . count($createdChapter2) . " materials (Bilangan Pecahan)\n";
    echo "✅ Total: " . $allMaterials->count() . " materials in course\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}