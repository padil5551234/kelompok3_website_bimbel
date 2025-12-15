<?php

/**
 * Script untuk cek data Pembelian
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DATA PEMBELIAN ===\n\n";

try {
    $pembelians = \Illuminate\Support\Facades\DB::table('pembelian')->get();
    
    if ($pembelians->count() > 0) {
        echo "Total records: " . $pembelians->count() . "\n\n";
        
        foreach ($pembelians as $pembelian) {
            echo "ID: {$pembelian->id}\n";
            echo "User_ID: {$pembelian->user_id}\n";
            echo "Paket_ID: {$pembelian->paket_id}\n";
            echo "Status_Verifikasi: {$pembelian->status_verifikasi}\n";
            echo "Status: {$pembelian->status}\n";
            echo "---\n";
        }
    } else {
        echo "❌ TIDAK ADA DATA PEMBELIAN\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}