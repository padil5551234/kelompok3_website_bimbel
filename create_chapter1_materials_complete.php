<?php

/**
 * Create Chapter 1 Materials Script
 * This script creates a comprehensive course with Chapter 1 containing multiple lessons/materials
 * Using the integrated course system
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🚀 Creating Chapter 1 Materials with Multiple Lessons...\n\n";

// Start database transaction
DB::beginTransaction();

try {
    // 1. Create or get a test admin user
    $adminUser = App\Models\User::firstOrCreate(
        ['email' => 'admin@course.com'],
        [
            'name' => 'Admin Course',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]
    );
    
    echo "✅ Admin user created/found: {$adminUser->name} ({$adminUser->email})\n";
    
    // 2. Create a comprehensive course for Chapter 1
    $courseData = [
        'nama' => 'Matematika Dasar - Chapter 1: Bilangan dan Operasi',
        'deskripsi' => 'Course komprehensif untuk Chapter 1 Matematika Dasar yang mencakup bilangan bulat, pecahan, desimal, dan operasi dasar. Dilengkapi dengan video pembelajaran, latihan soal, dan materi interaktif.',
        'harga' => 500000, // Price in IDR
        'waktu_mulai' => now(), // Start time
        'waktu_akhir' => now()->addYear(), // End time (1 year from now)
        'kategori' => 'Matematika',
        'level' => 'Dasar',
        'is_active' => true,
    ];
    
    $course = App\Models\PaketUjian::create($courseData);
    echo "✅ Course created: {$course->nama}\n";
    
    // 3. Create Chapter 1 with Multiple Materials
    $chapter1Materials = [
        [
            'title' => 'Pengenalan Bilangan Bulat',
            'description' => 'Video pembelajaran tentang konsep dasar bilangan bulat, garis bilangan, dan cara membaca bilangan negatif.',
            'type' => 'youtube',
            'content_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Sample YouTube URL
            'material_order' => 1,
            'is_featured' => true,
            'is_public' => true,
            'is_completable' => true,
        ],
        [
            'title' => 'Operasi Penjumlahan Bilangan Bulat',
            'description' => 'Cara menjumlahkan bilangan bulat positif dan negatif dengan contoh-contoh praktis.',
            'type' => 'youtube',
            'content_url' => 'https://www.youtube.com/watch?v=oHg5SJYRHA0', // Sample YouTube URL
            'material_order' => 2,
            'is_featured' => false,
            'is_public' => true,
            'is_completable' => true,
        ],
        [
            'title' => 'Operasi Pengurangan Bilangan Bulat',
            'description' => 'Teknik pengurangan bilangan bulat dan cara mengubah pengurangan menjadi penjumlahan.',
            'type' => 'youtube',
            'content_url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0', // Sample YouTube URL
            'material_order' => 3,
            'is_featured' => false,
            'is_public' => true,
            'is_completable' => true,
        ],
        [
            'title' => 'Latihan Soal Bilangan Bulat',
            'description' => 'Kumpulan soal latihan untuk mengasah kemampuan operasi bilangan bulat dengan tingkat kesulitan bervariasi.',
            'type' => 'document',
            'content_url' => '/documents/latihan-bilangan-bulat.pdf', // Sample document path
            'material_order' => 4,
            'is_featured' => false,
            'is_public' => true,
            'is_completable' => true,
        ],
        [
            'title' => 'Kalkulator Bilangan Bulat Interaktif',
            'description' => 'Alat bantu interaktif untuk menghitung operasi bilangan bulat secara real-time.',
            'type' => 'link',
            'content_url' => 'https://www.calculatorsoup.com/calculators/math/basic.php',
            'material_order' => 5,
            'is_featured' => false,
            'is_public' => true,
            'is_completable' => true,
        ],
        [
            'title' => 'Tips dan Trik Menghitung Cepat',
            'description' => 'Video rahasia untuk menghitung operasi bilangan bulat dengan cepat dan akurat.',
            'type' => 'youtube',
            'content_url' => 'https://www.youtube.com/watch?v=3JZ_D3ELwOQ', // Sample YouTube URL
            'material_order' => 6,
            'is_featured' => true,
            'is_public' => true,
            'is_completable' => true,
        ],
    ];
    
    // Create all Chapter 1 materials
    foreach ($chapter1Materials as $index => $materialData) {
        $material = App\Models\Material::create([
            'batch_id' => $course->id,
            'tutor_id' => $adminUser->id,
            'title' => $materialData['title'],
            'description' => $materialData['description'],
            'type' => $materialData['type'],
            'mapel' => $course->kategori,
            'chapter_number' => 1,
            'chapter_title' => 'Bilangan Bulat dan Operasi Dasar',
            'material_order' => $materialData['material_order'],
            'youtube_url' => $materialData['type'] === 'youtube' ? $materialData['content_url'] : null,
            'file_path' => $materialData['type'] === 'document' ? $materialData['content_url'] : null,
            'external_link' => $materialData['type'] === 'link' ? $materialData['content_url'] : null,
            'is_public' => $materialData['is_public'],
            'is_featured' => $materialData['is_featured'],
            'is_completable' => $materialData['is_completable'],
            'views_count' => 0,
            'downloads_count' => 0,
            'tags' => ['matematika', 'bilangan-bulat', 'operasi-dasar', 'chapter-1'],
        ]);
        
        echo "✅ Material created: {$material->title} (Order: {$material->material_order})\n";
    }
    
    // 4. Create Chapter 2 with additional materials
    $chapter2Materials = [
        [
            'title' => 'Pengenalan Pecahan',
            'description' => 'Konsep dasar pecahan, jenis-jenis pecahan, dan cara membaca notasi pecahan.',
            'type' => 'youtube',
            'content_url' => 'https://www.youtube.com/watch?v=fJ9eH_qXhXk',
            'material_order' => 1,
            'is_featured' => true,
        ],
        [
            'title' => 'Menyederhanakan Pecahan',
            'description' => 'Cara menyederhanakan pecahan dengan mencari FPB dari pembilang dan penyebut.',
            'type' => 'document',
            'content_url' => '/documents/menyederhanakan-pecahan.pdf',
            'material_order' => 2,
            'is_featured' => false,
        ],
    ];
    
    foreach ($chapter2Materials as $index => $materialData) {
        $material = App\Models\Material::create([
            'batch_id' => $course->id,
            'tutor_id' => $adminUser->id,
            'title' => $materialData['title'],
            'description' => $materialData['description'],
            'type' => $materialData['type'],
            'mapel' => $course->kategori,
            'chapter_number' => 2,
            'chapter_title' => 'Pecahan dan Operasinya',
            'material_order' => $materialData['material_order'],
            'youtube_url' => $materialData['type'] === 'youtube' ? $materialData['content_url'] : null,
            'file_path' => $materialData['type'] === 'document' ? $materialData['content_url'] : null,
            'is_public' => true,
            'is_featured' => $materialData['is_featured'],
            'is_completable' => true,
            'views_count' => 0,
            'downloads_count' => 0,
            'tags' => ['matematika', 'pecahan', 'penyederhanaan', 'chapter-2'],
        ]);
        
        echo "✅ Chapter 2 Material created: {$material->title}\n";
    }
    
    // 5. Create Chapter 3 with additional materials
    $chapter3Materials = [
        [
            'title' => 'Bilangan Desimal',
            'description' => 'Konversi antara pecahan dan desimal, operasi dasar bilangan desimal.',
            'type' => 'youtube',
            'content_url' => 'https://www.youtube.com/watch?v=L-Lf_kE6cK0',
            'material_order' => 1,
            'is_featured' => true,
        ],
        [
            'title' => 'Latihan Soal Desimal',
            'description' => 'Soal-soal latihan untuk menguasai operasi bilangan desimal.',
            'type' => 'document',
            'content_url' => '/documents/latihan-desimal.pdf',
            'material_order' => 2,
            'is_featured' => false,
        ],
        [
            'title' => 'Perbandingan Desimal',
            'description' => 'Cara membandingkan dua bilangan desimal dengan benar.',
            'type' => 'link',
            'content_url' => 'https://www.mathsisfun.com/numbers/decimal-comparison.html',
            'material_order' => 3,
            'is_featured' => false,
        ],
    ];
    
    foreach ($chapter3Materials as $index => $materialData) {
        $material = App\Models\Material::create([
            'batch_id' => $course->id,
            'tutor_id' => $adminUser->id,
            'title' => $materialData['title'],
            'description' => $materialData['description'],
            'type' => $materialData['type'],
            'mapel' => $course->kategori,
            'chapter_number' => 3,
            'chapter_title' => 'Bilangan Desimal dan Konversi',
            'material_order' => $materialData['material_order'],
            'youtube_url' => $materialData['type'] === 'youtube' ? $materialData['content_url'] : null,
            'file_path' => $materialData['type'] === 'document' ? $materialData['content_url'] : null,
            'external_link' => $materialData['type'] === 'link' ? $materialData['content_url'] : null,
            'is_public' => true,
            'is_featured' => $materialData['is_featured'],
            'is_completable' => true,
            'views_count' => 0,
            'downloads_count' => 0,
            'tags' => ['matematika', 'desimal', 'konversi', 'chapter-3'],
        ]);
        
        echo "✅ Chapter 3 Material created: {$material->title}\n";
    }
    
    // Commit transaction
    DB::commit();
    
    echo "\n🎉 SUCCESS! Chapter 1 Materials Created Successfully!\n\n";
    
    // Display summary
    echo "📊 SUMMARY:\n";
    echo "===========\n";
    echo "Course: {$course->nama}\n";
    echo "Total Materials: " . App\Models\Material::where('batch_id', $course->id)->count() . "\n";
    echo "Chapter 1 Materials: " . App\Models\Material::where('batch_id', $course->id)->where('chapter_number', 1)->count() . "\n";
    echo "Chapter 2 Materials: " . App\Models\Material::where('batch_id', $course->id)->where('chapter_number', 2)->count() . "\n";
    echo "Chapter 3 Materials: " . App\Models\Material::where('batch_id', $course->id)->where('chapter_number', 3)->count() . "\n\n";
    
    echo "🔗 ACCESS THE COURSE:\n";
    echo "Admin Dashboard: http://127.0.0.1:8000/admin/integrated-dashboard\n";
    echo "Edit Course: http://127.0.0.1:8000/admin/integrated/course/{$course->id}/edit\n\n";
    
    echo "📝 CHAPTER 1 DETAILS:\n";
    echo "===================\n";
    $chapter1MaterialsList = App\Models\Material::where('batch_id', $course->id)
        ->where('chapter_number', 1)
        ->orderBy('material_order')
        ->get();
        
    foreach ($chapter1MaterialsList as $material) {
        echo ($material->material_order) . ". {$material->title} ({$material->type})\n";
        echo "   Description: {$material->description}\n";
        echo "   Featured: " . ($material->is_featured ? 'Yes' : 'No') . "\n\n";
    }
    
} catch (Exception $e) {
    DB::rollback();
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n🏁 Script completed!\n";