<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\PaketUjian;
use App\Models\Ujian;
use App\Models\Soal;
use Illuminate\Support\Facades\DB;

echo "=== Checking SKD Package and Questions ===\n\n";

$paket = PaketUjian::where('kategori', 'skd')->first();
if ($paket) {
    echo "✅ SKD Package found: {$paket->nama}\n";
    echo "   - ID: {$paket->id}\n";
    echo "   - Description: {$paket->deskripsi}\n";
    echo "   - Price: Rp" . number_format($paket->harga, 0, ',', '.') . "\n\n";
} else {
    echo "❌ SKD Package not found\n\n";
}

$ujian = Ujian::where('jenis_ujian', 'skd')->first();
if ($ujian) {
    echo "✅ SKD Exam found: {$ujian->nama}\n";
    echo "   - ID: {$ujian->id}\n";
    echo "   - Questions: {$ujian->jumlah_soal}\n";
    echo "   - Duration: {$ujian->lama_pengerjaan} minutes\n\n";
} else {
    echo "❌ SKD Exam not found\n\n";
}

$soalCount = Soal::whereHas('ujian', function($q) {
    $q->where('jenis_ujian', 'skd');
})->count();

echo "Total SKD Questions: {$soalCount}\n\n";

if ($soalCount > 0) {
    $soal = Soal::whereHas('ujian', function($q) {
        $q->where('jenis_ujian', 'skd');
    })->first();

    echo "Sample Question:\n";
    echo "Question: " . strip_tags($soal->soal) . "\n";
    echo "Type: {$soal->jenis_soal}\n";
    echo "Correct Answer: " . chr(65 + $soal->kunci_jawaban) . "\n\n";
}

echo "=== Setup Complete ===\n";