<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PaketUjian;
use App\Models\Material;
use App\Models\User;

echo "=== ADDING MATERIALS TO PAKET MATEMATIKA ===\n";

// Find the matematika package
$paketMatematika = PaketUjian::where('nama', 'like', '%matematika%')->first();
if (!$paketMatematika) {
    echo "ERROR: Paket Matematika not found!\n";
    exit(1);
}

echo "Found Paket: {$paketMatematika->nama} (ID: {$paketMatematika->id})\n";

// Find a tutor
$tutor = User::role('tutor')->first();
if (!$tutor) {
    echo "ERROR: No tutor found!\n";
    exit(1);
}

echo "Found Tutor: {$tutor->name} (ID: {$tutor->id})\n";

// Sample mathematics materials
$materials = [
    [
        'title' => 'Pengantar Aljabar Linear',
        'mapel' => 'Matematika',
        'description' => 'Materi dasar tentang aljabar linear, matriks, dan vektor untuk pemula',
        'type' => 'document',
        'batch_id' => $paketMatematika->id,
        'tutor_id' => $tutor->id,
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
        'chapter_number' => 1,
        'chapter_title' => 'Bab 1: Aljabar Linear',
        'material_order' => 1,
        'duration_seconds' => 1800,
        'views_count' => 0,
        'downloads_count' => 0,
    ],
    [
        'title' => 'Kalkulus Differensial',
        'mapel' => 'Matematika',
        'description' => 'Konsep dasar kalkulus differensial dan turunan fungsi matematika',
        'type' => 'video',
        'batch_id' => $paketMatematika->id,
        'tutor_id' => $tutor->id,
        'is_public' => true,
        'is_featured' => true,
        'is_completable' => true,
        'chapter_number' => 2,
        'chapter_title' => 'Bab 2: Kalkulus',
        'material_order' => 1,
        'duration_seconds' => 2400,
        'views_count' => 0,
        'downloads_count' => 0,
    ],
    [
        'title' => 'Geometri Analitik',
        'mapel' => 'Matematika',
        'description' => 'Pelajari tentang geometri dalam bidang koordinat Kartesius',
        'type' => 'youtube',
        'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'batch_id' => $paketMatematika->id,
        'tutor_id' => $tutor->id,
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
        'chapter_number' => 3,
        'chapter_title' => 'Bab 3: Geometri',
        'material_order' => 1,
        'duration_seconds' => 2100,
        'views_count' => 0,
        'downloads_count' => 0,
    ],
    [
        'title' => 'Statistika dan Probabilitas',
        'mapel' => 'Matematika',
        'description' => 'Dasar-dasar statistika deskriptif dan teori probabilitas',
        'type' => 'link',
        'external_link' => 'https://example.com/statistics-guide',
        'batch_id' => $paketMatematika->id,
        'tutor_id' => $tutor->id,
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
        'chapter_number' => 4,
        'chapter_title' => 'Bab 4: Statistika',
        'material_order' => 1,
        'duration_seconds' => 2700,
        'views_count' => 0,
        'downloads_count' => 0,
    ],
    [
        'title' => 'Trigonometri Lanjutan',
        'mapel' => 'Matematika',
        'description' => 'Konsep trigonometri untuk tingkat lanjut dengan aplikasi praktis',
        'type' => 'document',
        'batch_id' => $paketMatematika->id,
        'tutor_id' => $tutor->id,
        'is_public' => true,
        'is_featured' => true,
        'is_completable' => true,
        'chapter_number' => 5,
        'chapter_title' => 'Bab 5: Trigonometri',
        'material_order' => 1,
        'duration_seconds' => 1950,
        'views_count' => 0,
        'downloads_count' => 0,
    ]
];

$createdCount = 0;
foreach ($materials as $materialData) {
    try {
        Material::create($materialData);
        $createdCount++;
        echo "✓ Created: {$materialData['title']}\n";
    } catch (Exception $e) {
        echo "✗ Failed to create: {$materialData['title']} - {$e->getMessage()}\n";
    }
}

echo "\n=== SUMMARY ===\n";
echo "Successfully created {$createdCount} materials for Paket Matematika!\n";

// Verify the materials were created
$materialsInPaket = Material::where('batch_id', $paketMatematika->id)->get();
echo "Total materials in Paket Matematika: {$materialsInPaket->count()}\n";

foreach ($materialsInPaket as $material) {
    echo "  - {$material->title} ({$material->type})\n";
}