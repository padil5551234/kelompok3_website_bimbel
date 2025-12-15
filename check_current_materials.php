<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Material;
use App\Models\PaketUjian;

echo "=== CURRENT MATERIALS IN DATABASE ===\n";

$materials = Material::with('batch')->orderBy('created_at', 'desc')->get();

foreach ($materials as $material) {
    echo $material->id . ': ' . $material->title . ' (' . $material->type . ') - Batch: ' . ($material->batch ? $material->batch->nama : 'NULL') . "\n";
}

echo "\n=== PAKET MATEMATIKA STATUS ===\n";
$paketMatematika = PaketUjian::where('nama', 'like', '%matematika%')->first();
if ($paketMatematika) {
    $materialsInPaket = Material::where('batch_id', $paketMatematika->id)->count();
    echo "Paket Matematika ID: {$paketMatematika->id}\n";
    echo "Materials in Paket Matematika: {$materialsInPaket}\n";
} else {
    echo "Paket Matematika not found\n";
}