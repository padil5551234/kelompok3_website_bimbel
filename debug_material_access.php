<?php

/**
 * Debug script to check materials access issue
 * Run this to understand why materials don't appear for users
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Material;
use App\Models\PaketUjian;
use App\Models\Pembelian;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== DEBUG MATERIAL ACCESS ISSUE ===\n\n";

// 1. Check materials in database
echo "1. MATERIALS IN DATABASE:\n";
echo "========================\n";
$materials = Material::with('batch')->get();
echo "Total materials: " . $materials->count() . "\n";

foreach($materials as $material) {
    echo "- Material ID: " . $material->id . "\n";
    echo "  Title: " . $material->title . "\n";
    echo "  Batch ID: " . ($material->batch_id ?? 'NULL') . "\n";
    echo "  Batch Name: " . ($material->batch ? $material->batch->nama : 'No batch') . "\n";
    echo "  Type: " . $material->type . "\n";
    echo "  Mapel: " . ($material->mapel ?? 'NULL') . "\n";
    echo "  Chapter: " . ($material->chapter_number ?? 'NULL') . " - " . ($material->chapter_title ?? 'No title') . "\n";
    echo "  Is Public: " . ($material->is_public ? 'Yes' : 'No') . "\n";
    echo "\n";
}

// 2. Check paket ujian (courses)
echo "2. PAKET UJIAN (COURSES):\n";
echo "========================\n";
$courses = PaketUjian::withCount('materials')->get();
echo "Total courses: " . $courses->count() . "\n";

foreach($courses as $course) {
    echo "- Course ID: " . $course->id . "\n";
    echo "  Name: " . $course->nama . "\n";
    echo "  Category: " . $course->kategori . "\n";
    echo "  Materials Count: " . $course->materials_count . "\n";
    echo "  Is Active: " . ($course->is_active ? 'Yes' : 'No') . "\n";
    echo "\n";
}

// 3. Check purchases
echo "3. PURCHASES IN DATABASE:\n";
echo "========================\n";
$purchases = Pembelian::with(['user', 'paketUjian'])->get();
echo "Total purchases: " . $purchases->count() . "\n";

foreach($purchases as $purchase) {
    echo "- Purchase ID: " . $purchase->id . "\n";
    echo "  User: " . ($purchase->user ? $purchase->user->name : 'No user') . "\n";
    echo "  Package: " . ($purchase->paketUjian ? $purchase->paketUjian->nama : 'No package') . "\n";
    echo "  Package ID: " . $purchase->paket_id . "\n";
    echo "  Status: " . $purchase->status . "\n";
    echo "  Verification: " . $purchase->status_verifikasi . "\n";
    echo "  Is Verified: " . ($purchase->isVerified() ? 'Yes' : 'No') . "\n";
    echo "\n";
}

// 4. Check access logic simulation
echo "4. ACCESS LOGIC SIMULATION:\n";
echo "==========================\n";

if ($purchases->isNotEmpty()) {
    // Take first verified purchase for simulation
    $verifiedPurchase = $purchases->filter(function($p) { return $p->isVerified(); })->first();
    
    if ($verifiedPurchase) {
        echo "Simulating access for purchase ID: " . $verifiedPurchase->id . "\n";
        echo "User ID: " . $verifiedPurchase->user_id . "\n";
        echo "Package ID: " . $verifiedPurchase->paket_id . "\n";
        
        // Check what materials this user should see
        $accessibleMaterials = Material::where(function($q) use ($verifiedPurchase) {
            $q->where('batch_id', $verifiedPurchase->paket_id)
              ->orWhereNull('batch_id');
        })->with('batch')->get();
        
        echo "Accessible materials count: " . $accessibleMaterials->count() . "\n";
        
        foreach($accessibleMaterials as $material) {
            echo "- " . $material->title . " (Batch: " . ($material->batch ? $material->batch->nama : 'NULL') . ")\n";
        }
    } else {
        echo "No verified purchases found.\n";
    }
} else {
    echo "No purchases found.\n";
}

echo "\n=== END DEBUG ===\n";