<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Material;

try {
    $material = new Material();
    $material->batch_id = 'ee5b24fa-a93d-4886-9d8d-f6ecea8abcb3'; // MTK package
    $material->tutor_id = '3de7377b-da0d-4219-b8d4-fc1c7e993f73'; // Budi Pengajar
    $material->title = 'Materi Matematika Dasar - Aljabar';
    $material->mapel = 'Matematika';
    $material->description = 'Pembelajaran dasar tentang aljabar untuk pemula';
    $material->type = 'youtube';
    $material->youtube_url = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
    $material->is_public = true;
    $material->is_featured = false;
    $material->duration_seconds = 1800; // 30 minutes
    $material->views_count = 0;
    $material->downloads_count = 0;
    $material->save();

    echo "✅ Sample material created successfully!\n";
    echo "Material ID: " . $material->id . "\n";
    echo "Title: " . $material->title . "\n";
    echo "Package: MTK\n";
    echo "Tutor: Budi Pengajar\n";
} catch (Exception $e) {
    echo "❌ Error creating material: " . $e->getMessage() . "\n";
}