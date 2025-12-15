<?php

// Diagnose and fix materials system
echo "=== DIAGNOSING MATERIALS SYSTEM ===\n\n";

require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Material;
use App\Models\PaketUjian;
use App\Models\Pembelian;
use App\Models\User;

echo "1. CHECKING CURRENT DATA:\n";
echo "   Materials: " . Material::count() . "\n";
echo "   Paket Ujian: " . PaketUjian::count() . "\n";
echo "   Verified Purchases: " . Pembelian::verified()->count() . "\n";
echo "   Users: " . User::count() . "\n\n";

echo "2. DETAILED ANALYSIS:\n";

// Check all materials with their batch information
echo "   Materials Details:\n";
$materials = Material::with('batch')->get();
foreach ($materials as $material) {
    echo "   - {$material->title}\n";
    echo "     Type: {$material->type}\n";
    echo "     Batch: " . ($material->batch ? $material->batch->nama : "No batch") . "\n";
    echo "     Batch ID: " . ($material->batch_id ?? "NULL") . "\n";
    echo "     Public: " . ($material->is_public ? "Yes" : "No") . "\n";
    echo "     Chapter: " . ($material->chapter_title ?? "No chapter") . "\n\n";
}

// Check all paket ujian
echo "   Paket Ujian Details:\n";
$paketUjian = PaketUjian::withCount('materials')->get();
foreach ($paketUjian as $paket) {
    echo "   - {$paket->nama}\n";
    echo "     ID: {$paket->id}\n";
    echo "     Materials Count: {$paket->materials_count}\n\n";
}

// Check verified purchases
echo "   Verified Purchases Details:\n";
$purchases = Pembelian::verified()->with(['user', 'paketUjian'])->get();
foreach ($purchases as $purchase) {
    echo "   - Purchase ID: {$purchase->id}\n";
    echo "     User: " . ($purchase->user ? $purchase->user->name : "Unknown") . "\n";
    echo "     User ID: " . ($purchase->user_id ?? "NULL") . "\n";
    echo "     Package: " . ($purchase->paketUjian ? $purchase->paketUjian->nama : "Unknown") . "\n";
    echo "     Package ID: " . ($purchase->paket_ujian_id ?? "NULL") . "\n\n";
}

// Test the exact scenario for each verified user
echo "3. TESTING USER ACCESS SCENARIOS:\n";
foreach ($purchases as $purchase) {
    if ($purchase->user && $purchase->paketUjian) {
        echo "   Testing user: {$purchase->user->name}\n";
        echo "   User has access to package: {$purchase->paketUjian->nama}\n";
        
        // Test materials access
        $userMaterials = Material::where(function($q) use ($purchase) {
            $q->where('batch_id', $purchase->paketUjian->id)
              ->orWhereNull('batch_id');
        })->with(['tutor', 'batch'])->get();
        
        echo "   Materials user can see: " . $userMaterials->count() . "\n";
        foreach ($userMaterials as $material) {
            echo "     - {$material->title} (from " . ($material->batch ? $material->batch->nama : "no batch") . ")\n";
        }
        echo "\n";
    }
}

echo "4. POTENTIAL ISSUES IDENTIFIED:\n";

// Check for materials without batch_id
$materialsWithoutBatch = Material::whereNull('batch_id')->get();
if ($materialsWithoutBatch->count() > 0) {
    echo "   ⚠️  Found {$materialsWithoutBatch->count()} materials without batch_id\n";
    echo "      These materials won't be visible to users without verified purchases\n";
} else {
    echo "   ✅ All materials have batch_id\n";
}

// Check for packages without materials
$paketWithoutMaterials = PaketUjian::has('materials', '=', 0)->get();
if ($paketWithoutMaterials->count() > 0) {
    echo "   ⚠️  Found {$paketWithoutMaterials->count()} packages without materials\n";
    foreach ($paketWithoutMaterials as $paket) {
        echo "      - {$paket->nama}\n";
    }
} else {
    echo "   ✅ All packages have at least one material\n";
}

// Check for purchases without proper package linkage
$problematicPurchases = Pembelian::verified()
    ->whereNull('paket_ujian_id')
    ->orWhereDoesntHave('paketUjian')
    ->get();
    
if ($problematicPurchases->count() > 0) {
    echo "   ⚠️  Found {$problematicPurchases->count()} problematic purchases\n";
    echo "      These purchases may not grant proper access\n";
} else {
    echo "   ✅ All verified purchases have proper package linkage\n";
}

echo "\n=== RECOMMENDATIONS ===\n";

if ($materialsWithoutBatch->count() > 0) {
    echo "1. Materials without batch_id should be linked to appropriate packages\n";
}

if ($paketWithoutMaterials->count() > 0) {
    echo "2. Empty packages should be populated with materials or removed\n";
}

if ($problematicPurchases->count() > 0) {
    echo "3. Fix problematic purchases by linking them to proper packages\n";
}

echo "4. Ensure admin users know to use Integrated Course System for adding materials\n";
echo "5. Consider making some materials public for preview without purchase\n";

echo "\n=== END DIAGNOSIS ===\n";