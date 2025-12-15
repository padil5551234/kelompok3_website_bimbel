<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

try {
    // Test database connection
    $pdo = DB::connection()->getPdo();
    echo "Database connected successfully\n";

    // Test queries
    $batchCount = DB::table('paket_ujian')->count();
    echo "Paket Ujian count: $batchCount\n";

    $userCount = DB::table('users')->count();
    echo "Users count: $userCount\n";

    $materialCount = DB::table('materials')->count();
    echo "Materials count: $materialCount\n";

    // Get first records
    $batch = DB::table('paket_ujian')->first();
    if ($batch) {
        echo "First batch: {$batch->nama} (ID: {$batch->id})\n";
    }

    $user = DB::table('users')->first();
    if ($user) {
        echo "First user: {$user->name} (ID: {$user->id})\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}