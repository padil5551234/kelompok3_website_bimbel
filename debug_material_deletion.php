<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG MATERIAL DELETION PROCESS ===\n\n";

// 1. Check current materials
echo "1. Current Materials in Database:\n";
$materials = DB::table('materials')->orderBy('batch_id', 'asc')->orderBy('chapter_number', 'asc')->orderBy('material_order', 'asc')->get();
foreach ($materials as $material) {
    echo "   - ID: {$material->id}, Batch: {$material->batch_id}, Chapter: {$material->chapter_number}, Title: {$material->title}\n";
}

echo "\n2. Current Courses (PaketUjian):\n";
$courses = DB::table('paket_ujian')->get();
foreach ($courses as $course) {
    echo "   - ID: {$course->id}, Name: {$course->nama}, Active: " . ($course->is_active ? 'Yes' : 'No') . "\n";
}

// 3. Test deletion logic from IntegratedCourseController
echo "\n3. Testing Deletion Logic:\n";

// Get first course as test
$testCourse = DB::table('paket_ujian')->first();
if ($testCourse) {
    echo "   Testing with Course ID: {$testCourse->id}\n";
    
    // Get existing materials for this course
    $existingMaterials = DB::table('materials')->where('batch_id', $testCourse->id)->get();
    echo "   Existing materials: " . $existingMaterials->count() . "\n";
    
    // Simulate form data where we want to keep only first material
    if ($existingMaterials->count() > 1) {
        $materialsToKeep = [$existingMaterials->first()->id];
        echo "   Materials to keep: " . implode(', ', $materialsToKeep) . "\n";
        
        // Execute deletion
        $deletedCount = DB::table('materials')->where('batch_id', $testCourse->id)
            ->whereNotIn('id', $materialsToKeep)
            ->delete();
        
        echo "   Deleted materials count: $deletedCount\n";
        
        // Check remaining materials
        $remainingMaterials = DB::table('materials')->where('batch_id', $testCourse->id)->get();
        echo "   Remaining materials: " . $remainingMaterials->count() . "\n";
        foreach ($remainingMaterials as $material) {
            echo "     - ID: {$material->id}, Title: {$material->title}\n";
        }
    }
} else {
    echo "   No courses found for testing\n";
}

// 4. Check for soft deletes
echo "\n4. Checking for Soft Deletes:\n";
$softDeletedMaterials = DB::table('materials')->onlyTrashed()->get();
echo "   Soft deleted materials: " . $softDeletedMaterials->count() . "\n";
foreach ($softDeletedMaterials as $material) {
    echo "   - ID: {$material->id}, Deleted at: {$material->deleted_at}\n";
}

echo "\n=== DEBUG COMPLETE ===\n";