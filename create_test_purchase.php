<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use App\Models\User;
use App\Models\PaketUjian;
use App\Models\Pembelian;
use Illuminate\Support\Str;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "Creating test purchase for sample materials...\n";

// Get the test tutor
$tutor = User::where('email', 'tutor@example.com')->first();
if (!$tutor) {
    echo "Tutor not found. Run create_sample_materials.php first.\n";
    exit(1);
}

// Get the test batch
$batch = PaketUjian::where('nama', 'Test Batch')->first();
if (!$batch) {
    echo "Batch not found. Run create_sample_materials.php first.\n";
    exit(1);
}

// Get or create a regular user for testing
$testUser = User::where('email', 'user@example.com')->first();
if (!$testUser) {
    $testUser = User::create([
        'name' => 'Test User',
        'email' => 'user@example.com',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
    ]);
    echo "Created test user: {$testUser->name}\n";
}

// Create a verified purchase for the test user
$purchase = Pembelian::where('user_id', $testUser->id)
    ->where('paket_id', $batch->id)
    ->first();

if (!$purchase) {
    $purchase = Pembelian::create([
        'user_id' => $testUser->id,
        'paket_id' => $batch->id,
        'harga' => $batch->harga,
        'status' => 'Sukses', // Status for purchase (matches the scopeVerified)
        'jenis_pembayaran' => 'manual',
        'nama_kelompok_bius' => 'Test Group',
        'waktu_mulai_pengerjaan' => now(),
        'waktu_selesai_pengerjaan' => now()->addDays(30),
        'status_verifikasi' => 'verified', // This is what the controller checks
    ]);
    echo "Created verified purchase for test user\n";
} else {
    echo "Purchase already exists\n";
}

echo "Test setup complete!\n";
echo "Test User: {$testUser->email} (ID: {$testUser->id})\n";
echo "Batch: {$batch->nama} (ID: {$batch->id})\n";
echo "Purchase Status: {$purchase->status}\n";

echo "\nTo test the materials, login as user@example.com and visit:\n";
echo "http://localhost:8000/user/materials\n";