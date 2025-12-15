<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DAFTAR USER (Tutor/Admin) ===\n";
try {
    $users = App\Models\User::all();
    foreach($users as $u) {
        echo "- " . $u->name . " (ID: " . $u->id . ")\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== PAKET MATEMATIKA DASAR MATERIALS ===\n";
try {
    $paketId = '4ed59120-6a38-4120-9143-4f6689e35aaa';
    $materials = App\Models\Material::where('batch_id', $paketId)->orderBy('chapter_number')->orderBy('material_order')->get();
    echo "Total Materials: " . $materials->count() . "\n\n";
    
    foreach($materials as $m) {
        echo "Chapter " . $m->chapter_number . " - " . $m->chapter_title . "\n";
        echo "  Material: " . $m->title . " (Order: " . $m->material_order . ")\n";
        echo "  Type: " . $m->type . " | Mapel: " . $m->mapel . "\n";
        echo "---\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}