<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use App\Models\User;
use App\Models\PaketUjian;
use App\Models\Pembelian;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "Creating test user and verified purchase...\n";

// Get the test batch
$batch = PaketUjian::where('nama', 'Test Batch')->first();
if (!$batch) {
    echo "Test batch not found. Please run create_sample_materials.php first.\n";
    exit(1);
}

// Get or create a test user
$user = User::where('email', 'testuser@example.com')->first();
if (!$user) {
    $user = User::create([
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'password' => bcrypt('password'),
        'email_verified_at' => now(),
    ]);
    echo "Created test user: {$user->name} (ID: {$user->id})\n";
} else {
    echo "Using existing test user: {$user->name} (ID: {$user->id})\n";
}

// Create a verified purchase for the test batch
$purchase = Pembelian::where('user_id', $user->id)
    ->where('paket_id', $batch->id)
    ->first();

if (!$purchase) {
    $purchase = Pembelian::create([
        'user_id' => $user->id,
        'paket_id' => $batch->id,
        'harga' => $batch->harga,
        'status' => 'Sukses', // Set as verified so user has access
        'status_verifikasi' => 'verified',
        'metode_pembayaran' => 'test',
        'verified_at' => now(),
    ]);
    echo "Created verified purchase for batch: {$batch->nama}\n";
} else {
    // Ensure it's verified
    if ($purchase->status !== 'verified') {
        $purchase->update([
            'status' => 'verified',
            'tanggal_verifikasi' => now(),
        ]);
        echo "Updated purchase status to verified\n";
    } else {
        echo "Purchase already verified\n";
    }
}

echo "Test setup completed!\n";
echo "User: {$user->email} (password: password)\n";
echo "Batch: {$batch->nama}\n";
echo "Purchase Status: {$purchase->status}\n";

echo "\nTest URLs:\n";
echo "Login: http://localhost:8000/login\n";
echo "Materials: http://localhost:8000/user/materials\n";