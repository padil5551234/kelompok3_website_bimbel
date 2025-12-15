<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST MATERIAL DELETION FIX ===\n\n";

// Simulate form data yang dikirim dari frontend
$simulatedFormData = [
    'course_id' => 'a5138937-606e-44de-ab1c-9c24f17cbc17',
    'course_name' => 'Test Course',
    'course_description' => 'Test Description',
    'category' => 'Matematika',
    'level' => 'Dasar',
    'tutor_id' => '1',
    'chapters' => [
        0 => [
            'title' => 'Chapter 1',
            'materials' => [
                0 => [
                    'id' => '03133a01-7173-40de-96ea-2f0a8bad2f75', // Keep this material
                    'title' => 'Material 1',
                    'type' => 'youtube',
                    'content_url' => 'https://youtube.com/test1',
                    'description' => 'Test material 1'
                ],
                1 => [
                    'delete' => '1250882c-3fb7-4b42-8e2a-3a2139160adb' // Mark this for deletion
                ]
            ]
        ]
    ]
];

echo "1. Simulated Form Data:\n";
echo "   Course ID: " . $simulatedFormData['course_id'] . "\n";
echo "   Materials in Chapter 1:\n";
foreach ($simulatedFormData['chapters'][0]['materials'] as $materialIndex => $materialData) {
    if (isset($materialData['delete'])) {
        echo "     - Material ID {$materialData['delete']}: MARKED FOR DELETION\n";
    } elseif (isset($materialData['id'])) {
        echo "     - Material ID {$materialData['id']}: KEEP\n";
    }
}

echo "\n2. Applying Fixed Deletion Logic:\n";

// Get current materials
$existingMaterials = DB::table('materials')->where('batch_id', $simulatedFormData['course_id'])->get();
echo "   Existing materials before: " . $existingMaterials->count() . "\n";

foreach ($existingMaterials as $material) {
    echo "     - ID: {$material->id}, Title: {$material->title}\n";
}

// Apply the fixed logic from controller
$materialsToKeep = [];
$materialsToDelete = [];

foreach ($simulatedFormData['chapters'] as $chapterIndex => $chapterData) {
    foreach ($chapterData['materials'] as $materialIndex => $materialData) {
        // Check if material is marked for deletion
        if (isset($materialData['delete']) && !empty($materialData['delete'])) {
            $materialsToDelete[] = $materialData['delete'];
        }
        // Check if material should be kept (has valid ID and not deleted)
        elseif (isset($materialData['id']) && !empty($materialData['id'])) {
            $materialsToKeep[] = $materialData['id'];
        }
    }
}

echo "\n   Materials to keep: " . implode(', ', $materialsToKeep) . "\n";
echo "   Materials to delete: " . implode(', ', $materialsToDelete) . "\n";

// Delete materials yang explicitly marked for deletion
if (!empty($materialsToDelete)) {
    $deletedCount = DB::table('materials')
        ->where('batch_id', $simulatedFormData['course_id'])
        ->whereIn('id', $materialsToDelete)
        ->delete();
    echo "   Explicit deletions: $deletedCount materials\n";
}

// Delete materials yang tidak ada di form (removed materials)
$remainingDeleted = DB::table('materials')
    ->where('batch_id', $simulatedFormData['course_id'])
    ->whereNotIn('id', $materialsToKeep)
    ->delete();
echo "   Implicit deletions (not in form): $remainingDeleted materials\n";

// Check final state
$finalMaterials = DB::table('materials')->where('batch_id', $simulatedFormData['course_id'])->get();
echo "\n3. Final State:\n";
echo "   Remaining materials: " . $finalMaterials->count() . "\n";
foreach ($finalMaterials as $material) {
    echo "     - ID: {$material->id}, Title: {$material->title}\n";
}

echo "\n=== TEST COMPLETE ===\n";