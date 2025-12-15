<?php

/**
 * Fix script to activate course and improve material access
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PaketUjian;
use App\Models\Material;

echo "=== FIXING MATERIAL ACCESS ISSUE ===\n\n";

// 1. Activate the course
echo "1. ACTIVATING COURSE:\n";
echo "====================\n";
$courseId = '4ed59120-6a38-4120-9143-4f6689e35aaa';
$course = PaketUjian::find($courseId);

if ($course) {
    $oldStatus = $course->is_active;
    $course->is_active = true;
    $course->save();
    
    echo "✓ Course activated successfully!\n";
    echo "  Course: " . $course->nama . "\n";
    echo "  Old Status: " . ($oldStatus ? 'Active' : 'Inactive') . "\n";
    echo "  New Status: Active\n\n";
} else {
    echo "✗ Course not found!\n\n";
}

// 2. Ensure materials are public
echo "2. ENSURING MATERIALS ARE PUBLIC:\n";
echo "================================\n";
$materials = Material::where('batch_id', $courseId)->get();

foreach ($materials as $material) {
    $oldPublicStatus = $material->is_public;
    $material->is_public = true;
    $material->save();
    
    echo "✓ Material updated: " . $material->title . "\n";
    echo "  Old Public Status: " . ($oldPublicStatus ? 'Yes' : 'No') . "\n";
    echo "  New Public Status: Yes\n";
}

// 3. Verify the fix
echo "\n3. VERIFICATION:\n";
echo "================\n";
$course = PaketUjian::find($courseId);
echo "Course Status: " . ($course->is_active ? '✓ Active' : '✗ Inactive') . "\n";

$materials = Material::where('batch_id', $courseId)->get();
echo "Materials Count: " . $materials->count() . "\n";
foreach ($materials as $material) {
    echo "  - " . $material->title . " (" . ($material->is_public ? 'Public' : 'Private') . ")\n";
}

// 4. Test access logic
echo "\n4. ACCESS LOGIC TEST:\n";
echo "====================\n";
use App\Models\Pembelian;

$purchase = Pembelian::where('paket_id', $courseId)->where('status_verifikasi', 'verified')->first();
if ($purchase) {
    echo "✓ Verified purchase found for user: " . $purchase->user_id . "\n";
    
    $accessibleMaterials = Material::where(function($q) use ($courseId) {
        $q->where('batch_id', $courseId)
          ->orWhereNull('batch_id');
    })->get();
    
    echo "✓ User should have access to " . $accessibleMaterials->count() . " materials\n";
} else {
    echo "✗ No verified purchase found for this course\n";
}

echo "\n=== FIX COMPLETED ===\n";
echo "Users should now be able to see materials in the course!\n";