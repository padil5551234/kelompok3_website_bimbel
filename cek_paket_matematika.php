<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DAFTAR PAKET UJIAN ===\n";
try {
    $paketList = App\Models\PaketUjian::all();
    foreach($paketList as $p) {
        echo "- " . $p->nama . " (ID: " . $p->id . ")\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== CARI PAKET MATEMATIKA DASAR ===\n";
try {
    $paket = App\Models\PaketUjian::where('nama', 'like', '%Matematika%')->first();
    if($paket) {
        echo "Ditemukan: " . $paket->nama . " (ID: " . $paket->id . ")\n";
    } else {
        echo "Tidak ditemukan paket dengan nama Matematika\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== LIST TUTOR ===\n";
try {
    $tutors = App\Models\User::where('role', 'tutor')->get();
    foreach($tutors as $t) {
        echo "- " . $t->name . " (ID: " . $t->id . ")\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}