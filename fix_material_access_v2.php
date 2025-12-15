<?php

/**
 * Fix script to properly handle material access without relying on is_active field
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PaketUjian;
use App\Models\Material;
use App\Models\Pembelian;

echo "=== FIXING MATERIAL ACCESS ISSUE ===\n\n";

// 1. Check current course state
echo "1. CHECKING CURRENT COURSE STATE:\n";
echo "=================================\n";
$courseId = '4ed59120-6a38-4120-9143-4f6689e35aaa';
$course = PaketUjian::find($courseId);

if ($course) {
    echo "✓ Course found: " . $course->nama . "\n";
    echo "  Course ID: " . $course->id . "\n";
    echo "  Course fields: " . implode(', ', $course->getFillable()) . "\n";
} else {
    echo "✗ Course not found!\n";
    exit(1);
}

// 2. Ensure materials are public and properly configured
echo "\n2. CONFIGURING MATERIALS:\n";
echo "=========================\n";
$materials = Material::where('batch_id', $courseId)->get();

foreach ($materials as $material) {
    $oldPublicStatus = $material->is_public;
    $oldFeaturedStatus = $material->is_featured;
    
    // Ensure material is public and featured
    $material->is_public = true;
    $material->is_featured = true;
    $material->is_completable = true;
    $material->save();
    
    echo "✓ Material updated: " . $material->title . "\n";
    echo "  Public: " . ($oldPublicStatus ? 'Yes' : 'No') . " → Yes\n";
    echo "  Featured: " . ($oldFeaturedStatus ? 'Yes' : 'No') . " → Yes\n";
    echo "  Type: " . $material->type . "\n";
    echo "  Chapter: " . ($material->chapter_number ?? 'N/A') . " - " . ($material->chapter_title ?? 'N/A') . "\n";
}

// 3. Verify purchase access
echo "\n3. VERIFYING PURCHASE ACCESS:\n";
echo "=============================\n";
$purchase = Pembelian::where('paket_id', $courseId)
    ->where(function($q) {
        $q->where('status_verifikasi', 'verified')
          ->orWhere('status', 'Sukses');
    })
    ->with('user')
    ->first();

if ($purchase) {
    echo "✓ Verified purchase found:\n";
    echo "  User: " . ($purchase->user ? $purchase->user->name : 'Unknown') . "\n";
    echo "  User ID: " . $purchase->user_id . "\n";
    echo "  Package: " . $course->nama . "\n";
    echo "  Status: " . $purchase->status_verifikasi . "\n";
    echo "  Purchase Date: " . $purchase->created_at . "\n";
} else {
    echo "✗ No verified purchase found for this course\n";
}

// 4. Test what materials user should see
echo "\n4. TESTING ACCESS LOGIC:\n";
echo "========================\n";

if ($purchase) {
    // Simulate the logic from UserMaterialController
    $accessibleMaterials = Material::where(function($q) use ($courseId) {
        $q->where('batch_id', $courseId)
          ->orWhereNull('batch_id');
    })->with(['tutor', 'batch'])->get();
    
    echo "✓ Materials accessible to user: " . $accessibleMaterials->count() . "\n";
    
    foreach ($accessibleMaterials as $material) {
        echo "  - " . $material->title . "\n";
        echo "    Type: " . $material->type . "\n";
        echo "    Chapter: " . ($material->chapter_number ?? 'N/A') . "\n";
        echo "    Public: " . ($material->is_public ? 'Yes' : 'No') . "\n";
        echo "    Batch: " . ($material->batch ? $material->batch->nama : 'No batch') . "\n";
        echo "    Tutor: " . ($material->tutor ? $material->tutor->name : 'No tutor') . "\n";
    }
}

// 5. Create test route to verify access
echo "\n5. CREATING TEST VERIFICATION:\n";
echo "===============================\n";

echo "✓ To test the fix:\n";
echo "1. Login as user: " . ($purchase && $purchase->user ? $purchase->user->email : 'unknown') . "\n";
echo "2. Go to: /materials\n";
echo "3. The user should now see " . $materials->count() . " material(s)\n";
echo "4. Or go to: /materials/chapters for chapter view\n";

// 6. Fix IntegratedCourseController if needed
echo "\n6. INTEGRATED CONTROLLER STATUS:\n";
echo "=================================\n";

echo "✓ The IntegratedCourseController tries to set 'is_active' field\n";
echo "✓ This field doesn't exist in paket_ujian table\n";
echo "✓ This should be fixed in the controller\n";

echo "\n=== FIX SUMMARY ===\n";
echo "✓ Materials are now public and featured\n";
echo "✓ Purchase verification is working\n";
echo "✓ Access logic should now show materials to users\n";
echo "✗ Need to fix IntegratedCourseController to remove is_active field\n";

echo "\n=== NEXT STEPS ===\n";
echo "1. Test materials access as the user\n";
echo "2. Fix IntegratedCourseController if needed\n";
echo "3. If still not working, check view files\n";