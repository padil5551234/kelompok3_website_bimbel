<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== MENAMBAH MATERI MATEMATIKA DASAR ===\n\n";

// Data paket dan tutor
$paketId = '4ed59120-6a38-4120-9143-4f6689e35aaa';
$tutorId = '3de7377b-da0d-4219-b8d4-fc1c7e993f73'; // Budi Pengajar

// Materials yang akan ditambahkan
$materials = [
    // BAB 1: Relasi & Fungsi (lanjutkan dari yang sudah ada)
    [
        'title' => 'Video Pembelajaran Relasi & Fungsi',
        'description' => 'Video tutorial lengkap tentang konsep relasi dan fungsi dalam matematika',
        'type' => 'youtube',
        'mapel' => 'Matematika',
        'chapter_number' => 1,
        'chapter_title' => 'BAB 1: Relasi & Fungsi',
        'material_order' => 2,
        'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'is_public' => true,
        'is_featured' => true,
        'is_completable' => true,
    ],
    [
        'title' => 'Latihan Soal Relasi & Fungsi',
        'description' => 'Kumpulan soal latihan relasi dan fungsi dengan pembahasan lengkap',
        'type' => 'document',
        'mapel' => 'Matematika',
        'chapter_number' => 1,
        'chapter_title' => 'BAB 1: Relasi & Fungsi',
        'material_order' => 3,
        'file_path' => 'materials/latihan-relasi-fungsi.pdf',
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
    ],

    // BAB 2: Persamaan Linear
    [
        'title' => 'Pengenalan Persamaan Linear',
        'description' => 'Video pembelajaran dasar tentang persamaan linear satu variabel',
        'type' => 'youtube',
        'mapel' => 'Matematika',
        'chapter_number' => 2,
        'chapter_title' => 'BAB 2: Persamaan Linear',
        'material_order' => 1,
        'youtube_url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
        'is_public' => true,
        'is_featured' => true,
        'is_completable' => true,
    ],
    [
        'title' => 'Cara Menyelesaikan Persamaan Linear',
        'description' => 'Tutorial step-by-step menyelesaikan persamaan linear',
        'type' => 'youtube',
        'mapel' => 'Matematika',
        'chapter_number' => 2,
        'chapter_title' => 'BAB 2: Persamaan Linear',
        'material_order' => 2,
        'youtube_url' => 'https://www.youtube.com/watch?v=ScMxNdT5BsQ',
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
    ],
    [
        'title' => 'Soal Latihan Persamaan Linear',
        'description' => 'Bank soal persamaan linear dengan berbagai tingkat kesulitan',
        'type' => 'document',
        'mapel' => 'Matematika',
        'chapter_number' => 2,
        'chapter_title' => 'BAB 2: Persamaan Linear',
        'material_order' => 3,
        'file_path' => 'materials/soal-persamaan-linear.pdf',
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
    ],

    // BAB 3: Sistem Persamaan Linear
    [
        'title' => 'Konsep Dasar Sistem Persamaan',
        'description' => 'Video pembelajaran sistem persamaan linear dua variabel',
        'type' => 'youtube',
        'mapel' => 'Matematika',
        'chapter_number' => 3,
        'chapter_title' => 'BAB 3: Sistem Persamaan Linear',
        'material_order' => 1,
        'youtube_url' => 'https://www.youtube.com/watch?v=2V7JjULcQfM',
        'is_public' => true,
        'is_featured' => true,
        'is_completable' => true,
    ],
    [
        'title' => 'Metode Substitusi & Eliminasi',
        'description' => 'Tutorial menyelesaikan SPLDV dengan metode substitusi dan eliminasi',
        'type' => 'youtube',
        'mapel' => 'Matematika',
        'chapter_number' => 3,
        'chapter_title' => 'BAB 3: Sistem Persamaan Linear',
        'material_order' => 2,
        'youtube_url' => 'https://www.youtube.com/watch?v=f7LzJGHd7zI',
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
    ],
    [
        'title' => 'Latihan Soal SPLDV',
        'description' => 'Kumpulan latihan soal sistem persamaan linear dua variabel',
        'type' => 'document',
        'mapel' => 'Matematika',
        'chapter_number' => 3,
        'chapter_title' => 'BAB 3: Sistem Persamaan Linear',
        'material_order' => 3,
        'file_path' => 'materials/latihan-spldv.pdf',
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
    ],
    [
        'title' => 'Referensi Tambahan SPLDV',
        'description' => 'Link ke sumber belajar sistem persamaan linear yang lengkap',
        'type' => 'link',
        'mapel' => 'Matematika',
        'chapter_number' => 3,
        'chapter_title' => 'BAB 3: Sistem Persamaan Linear',
        'material_order' => 4,
        'external_link' => 'https://www.khanacademy.org/math/algebra/systems-of-equations',
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
    ],

    // BAB 4: Pertidaksamaan
    [
        'title' => 'Pengenalan Pertidaksamaan',
        'description' => 'Video pembelajaran konsep dasar pertidaksamaan linear',
        'type' => 'youtube',
        'mapel' => 'Matematika',
        'chapter_number' => 4,
        'chapter_title' => 'BAB 4: Pertidaksamaan',
        'material_order' => 1,
        'youtube_url' => 'https://www.youtube.com/watch?v=6V7JjULcQfM',
        'is_public' => true,
        'is_featured' => true,
        'is_completable' => true,
    ],
    [
        'title' => 'Materi PDF Pertidaksamaan',
        'description' => 'Materi lengkap pertidaksamaan linear dalam format PDF',
        'type' => 'document',
        'mapel' => 'Matematika',
        'chapter_number' => 4,
        'chapter_title' => 'BAB 4: Pertidaksamaan',
        'material_order' => 2,
        'file_path' => 'materials/materi-pertidaksamaan.pdf',
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
    ],
    [
        'title' => 'Soal Latihan Pertidaksamaan',
        'description' => 'Bank soal pertidaksamaan dengan berbagai variasi',
        'type' => 'document',
        'mapel' => 'Matematika',
        'chapter_number' => 4,
        'chapter_title' => 'BAB 4: Pertidaksamaan',
        'material_order' => 3,
        'file_path' => 'materials/soal-pertidaksamaan.pdf',
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
    ],

    // BAB 5: Program Linear
    [
        'title' => 'Pengenalan Program Linear',
        'description' => 'Video pembelajaran dasar-dasar program linear',
        'type' => 'youtube',
        'mapel' => 'Matematika',
        'chapter_number' => 5,
        'chapter_title' => 'BAB 5: Program Linear',
        'material_order' => 1,
        'youtube_url' => 'https://www.youtube.com/watch?v=7LzJGHd7zI',
        'is_public' => true,
        'is_featured' => true,
        'is_completable' => true,
    ],
    [
        'title' => 'Metode Grafik Program Linear',
        'description' => 'Tutorial menyelesaikan masalah program linear dengan metode grafik',
        'type' => 'youtube',
        'mapel' => 'Matematika',
        'chapter_number' => 5,
        'chapter_title' => 'BAB 5: Program Linear',
        'material_order' => 2,
        'youtube_url' => 'https://www.youtube.com/watch?v=2V7JjULcQfM',
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
    ],
    [
        'title' => 'Materi Program Linear',
        'description' => 'Materi lengkap program linear dalam format PDF',
        'type' => 'document',
        'mapel' => 'Matematika',
        'chapter_number' => 5,
        'chapter_title' => 'BAB 5: Program Linear',
        'material_order' => 3,
        'file_path' => 'materials/materi-program-linear.pdf',
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
    ],
    [
        'title' => 'Referensi Program Linear',
        'description' => 'Link ke sumber belajar program linear yang komprehensif',
        'type' => 'link',
        'mapel' => 'Matematika',
        'chapter_number' => 5,
        'chapter_title' => 'BAB 5: Program Linear',
        'material_order' => 4,
        'external_link' => 'https://www.mathsisfun.com/algebra/linear-programming.html',
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
    ],
];

$successCount = 0;
$errorCount = 0;

foreach ($materials as $materialData) {
    try {
        // Tambahkan field yang diperlukan
        $materialData['batch_id'] = $paketId;
        $materialData['tutor_id'] = $tutorId;
        $materialData['views_count'] = 0;
        $materialData['downloads_count'] = 0;

        // Create material
        $material = App\Models\Material::create($materialData);
        
        echo "✅ BERHASIL: " . $material->title . " (Chapter " . $material->chapter_number . ", Order " . $material->material_order . ")\n";
        $successCount++;
        
    } catch (Exception $e) {
        echo "❌ ERROR: " . $materialData['title'] . " - " . $e->getMessage() . "\n";
        $errorCount++;
    }
}

echo "\n=== RINGKASAN ===\n";
echo "Total Materials yang ditambahkan: " . count($materials) . "\n";
echo "Berhasil: " . $successCount . "\n";
echo "Gagal: " . $errorCount . "\n";

// Tampilkan total materials di paket
try {
    $totalMaterials = App\Models\Material::where('batch_id', $paketId)->count();
    echo "Total materials di Paket Matematika Dasar: " . $totalMaterials . "\n";
} catch (Exception $e) {
    echo "Error saat menghitung total: " . $e->getMessage() . "\n";
}