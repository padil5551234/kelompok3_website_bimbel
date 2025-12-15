<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Ujian;
use App\Models\UjianUser;
use Carbon\Carbon;

echo "Creating test raport data...\n";

try {
    $user = User::first();
    if (!$user) {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        echo "Created test user: {$user->id}\n";
    }

    $ujian = Ujian::first();
    if (!$ujian) {
        $ujian = Ujian::create([
            'nama' => 'Test Ujian',
            'deskripsi' => 'Test ujian description',
            'paket_ujian_id' => null,
            'jumlah_soal' => 10,
            'lama_pengerjaan' => 60,
            'is_published' => true,
            'jenis_tryout' => 'free',
            'waktu_mulai' => now(),
            'waktu_akhir' => now()->addDays(7),
        ]);
        echo "Created test ujian: {$ujian->id}\n";
    }
    
    echo "Using user: {$user->name} (ID: {$user->id})\n";
    echo "Using ujian: {$ujian->nama} (ID: {$ujian->id})\n";
    
    // Clear existing test data
    UjianUser::where('user_id', $user->id)->delete();
    
    // Create test UjianUser records
    for ($i = 1; $i <= 5; $i++) {
        $ujianUser = new UjianUser();
        $ujianUser->user_id = $user->id;
        $ujianUser->ujian_id = $ujian->id;
        $ujianUser->nilai = rand(60, 95);
        $ujianUser->waktu_mulai = now()->subDays(rand(1, 30));
        $ujianUser->waktu_akhir = now()->subDays(rand(1, 30))->addMinutes(rand(30, 120));
        $ujianUser->save();
        
        echo "Created UjianUser #{$i} with nilai: {$ujianUser->nilai}\n";
    }
    
    echo "\nTotal UjianUser records: " . UjianUser::count() . "\n";
    echo "Test data created successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}