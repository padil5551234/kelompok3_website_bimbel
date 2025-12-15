#!/usr/bin/env php
<?php

// Test user material access
define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Material;
use App\Models\PaketUjian;
use App\Models\Pembelian;
use App\Models\User;

echo "=== TESTING USER MATERIAL ACCESS ===\n\n";

// Test 1: Check all materials in database
echo "1. All materials in database:\n";
$allMaterials = Material::all();
foreach ($allMaterials as $material) {
    echo "  - {$material->title} (batch_id: " . ($material->batch_id ?? 'NULL') . ", is_public: " . ($material->is_public ? 'Yes' : 'No') . ")\n";
}

// Test 2: Check all paket ujian
echo "\n2. All paket ujian:\n";
$allPaket = PaketUjian::all();
foreach ($allPaket as $paket) {
    echo "  - {$paket->nama} (id: {$paket->id})\n";
}

// Test 3: Check if there are any verified purchases
echo "\n3. Verified purchases:\n";
$verifiedPurchases = Pembelian::verified()->with('paketUjian')->get();
echo "Total verified purchases: " . $verifiedPurchases->count() . "\n";
foreach ($verifiedPurchases as $purchase) {
    echo "  - User: {$purchase->user_id}, Package: {$purchase->paketUjian->nama} (ID: {$purchase->paket_ujian_id})\n";
}

// Test 4: Test query logic from UserMaterialController
echo "\n4. Testing UserMaterialController query logic:\n";
try {
    // Get first verified purchase if exists
    $firstPurchase = Pembelian::verified()->first();
    
    if ($firstPurchase) {
        echo "Using first verified purchase for testing...\n";
        $userId = $firstPurchase->user_id;
        $paketId = $firstPurchase->paket_ujian_id;
        
        echo "User ID: {$userId}, Package ID: {$paketId}\n";
        
        // Simulate the query logic from UserMaterialController
        $purchasedPackages = collect([$firstPurchase->paketUjian]);
        echo "Purchased packages: " . $purchasedPackages->pluck('nama')->implode(', ') . "\n";
        
        if ($purchasedPackages->isNotEmpty()) {
            $packageIds = $purchasedPackages->pluck('id');
            echo "Package IDs: " . $packageIds->implode(', ') . "\n";
            
            // Execute the same query
            $query = Material::query();
            $query->where(function($q) use ($packageIds) {
                $q->whereIn('batch_id', $packageIds)
                  ->orWhereNull('batch_id');
            });
            
            $materials = $query->with(['tutor', 'batch'])->get();
            echo "Materials found for user: " . $materials->count() . "\n";
            
            foreach ($materials as $material) {
                echo "  - {$material->title} (batch: " . ($material->batch->nama ?? 'No batch') . ")\n";
            }
        }
    } else {
        echo "No verified purchases found.\n";
        
        // Test scenario where user has no purchases
        $query = Material::query();
        $query->whereRaw('1 = 0'); // Same logic as controller when no purchases
        $materials = $query->get();
        echo "Materials found for user with no purchases: " . $materials->count() . "\n";
    }
    
} catch (Exception $e) {
    echo "Query error: " . $e->getMessage() . "\n";
}

// Test 5: Test materials visibility
echo "\n5. Testing materials visibility:\n";
$publicMaterials = Material::where('is_public', true)->get();
echo "Public materials: " . $publicMaterials->count() . "\n";

foreach ($publicMaterials as $material) {
    echo "  - {$material->title} (batch_id: " . ($material->batch_id ?? 'NULL') . ")\n";
}

// Test 6: Test specific user scenario (if we can find a user)
echo "\n6. Testing specific user scenario:\n";
try {
    $testUser = User::first();
    if ($testUser) {
        echo "Testing with user: {$testUser->name} (ID: {$testUser->id})\n";
        
        $userPurchases = Pembelian::forUser($testUser->id)->verified()->get();
        echo "User's verified purchases: " . $userPurchases->count() . "\n";
        
        if ($userPurchases->isNotEmpty()) {
            $purchasedPackages = $userPurchases->pluck('paketUjian')->filter();
            $packageIds = $purchasedPackages->pluck('id');
            
            $userMaterials = Material::where(function($q) use ($packageIds) {
                $q->whereIn('batch_id', $packageIds)
                  ->orWhereNull('batch_id');
            })->with(['tutor', 'batch'])->get();
            
            echo "Materials user should see: " . $userMaterials->count() . "\n";
        } else {
            echo "User has no verified purchases.\n";
        }
    } else {
        echo "No users found in database.\n";
    }
} catch (Exception $e) {
    echo "User test error: " . $e->getMessage() . "\n";
}

echo "\n=== END TEST ===\n";