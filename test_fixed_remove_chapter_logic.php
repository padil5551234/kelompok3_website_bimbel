<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST FIXED REMOVE CHAPTER LOGIC ===\n\n";

// Simulate form data dengan existing chapter yang akan dihapus
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
            'delete' => '1', // Chapter 1 marked for deletion
            'materials' => [
                0 => [
                    'id' => '03133a01-7173-40de-96ea-2f0a8bad2f75', // Existing material
                    'title' => 'Existing Material 1',
                    'type' => 'youtube',
                    'content_url' => 'https://youtube.com/existing1',
                    'description' => 'Existing material'
                ]
            ]
        ]
        // Chapter 2 dan 3 TIDAK ADA karena dihapus user
    ]
];

echo "1. SIMULATED SCENARIO:\n";
echo "   User menghapus Chapter 1 (existing chapter dengan materials)\n";
echo "   Chapters yang dikirim dalam form:\n";
foreach ($simulatedFormData['chapters'] as $index => $chapterData) {
    $materialCount = count($chapterData['materials']);
    $hasId = isset($chapterData['materials'][0]['id']) ? 'YES' : 'NO';
    $isDeleted = isset($chapterData['delete']) ? 'YES' : 'NO';
    echo "     - Chapter {$index}: {$chapterData['title']} ({$materialCount} materials, has ID: {$hasId}, marked for deletion: {$isDeleted})\n";
}

echo "\n2. CURRENT DATABASE STATE:\n";
$existingMaterials = DB::table('materials')->where('batch_id', $simulatedFormData['course_id'])->get();
echo "   Materials in database BEFORE form submission:\n";
foreach ($existingMaterials as $material) {
    echo "     - ID: {$material->id}\n";
    echo "       Chapter Number: {$material->chapter_number}\n";
    echo "       Title: {$material->title}\n";
}

echo "\n3. APPLYING FIXED LOGIC:\n";

// Get chapters to delete and materials to keep
$chaptersToDelete = [];
$materialsToKeep = [];
$materialsToDelete = [];
$hasNewMaterials = false;

// First pass: identify chapters and materials to delete
foreach ($simulatedFormData['chapters'] as $chapterIndex => $chapterData) {
    // Check if chapter is marked for deletion
    if (isset($chapterData['delete']) && !empty($chapterData['delete'])) {
        $chaptersToDelete[] = $chapterIndex;
        echo "   Chapter {$chapterIndex} MARKED FOR DELETION\n";
        continue; // Skip processing materials for deleted chapters
    }
    
    // Process materials for non-deleted chapters
    foreach ($chapterData['materials'] as $materialIndex => $materialData) {
        // Check if material is marked for deletion
        if (isset($materialData['delete']) && !empty($materialData['delete'])) {
            $materialsToDelete[] = $materialData['delete'];
        }
        // Check if material should be kept (has valid ID and not deleted)
        elseif (isset($materialData['id']) && !empty($materialData['id'])) {
            $materialsToKeep[] = $materialData['id'];
        }
        // New material (no ID) - will be created later
        else {
            $hasNewMaterials = true;
        }
    }
}

echo "\n   Analysis Results:\n";
echo "   - Chapters to delete: " . implode(', ', $chaptersToDelete) . "\n";
echo "   - Materials to keep: " . implode(', ', $materialsToKeep) . "\n";
echo "   - Materials to delete: " . implode(', ', $materialsToDelete) . "\n";
echo "   - Has new materials: " . ($hasNewMaterials ? 'YES' : 'NO') . "\n";
echo "   - Existing materials count: " . $existingMaterials->count() . "\n";

echo "\n4. DELETION OPERATIONS:\n";

// Delete materials from chapters marked for deletion
if (!empty($chaptersToDelete)) {
    echo "   Deleting materials from chapters: " . implode(', ', $chaptersToDelete) . "\n";
    
    // Get all materials from chapters that will be deleted
    $chapterMaterialsToDelete = [];
    foreach ($chaptersToDelete as $chapterIndex) {
        // Find materials belonging to this chapter
        $chapterMaterials = $existingMaterials->where('chapter_number', $chapterIndex + 1);
        $chapterMaterialsToDelete = array_merge($chapterMaterialsToDelete, $chapterMaterials->pluck('id')->toArray());
    }
    
    echo "   Materials to delete from chapters: " . implode(', ', $chapterMaterialsToDelete) . "\n";
    
    if (!empty($chapterMaterialsToDelete)) {
        $chapterDeletedCount = DB::table('materials')
            ->where('batch_id', $simulatedFormData['course_id'])
            ->whereIn('id', $chapterMaterialsToDelete)
            ->delete();
        
        echo "   Deleted {$chapterDeletedCount} materials from deleted chapters\n";
    }
}

// Delete materials yang explicitly marked for deletion
if (!empty($materialsToDelete)) {
    $deletedCount = DB::table('materials')
        ->where('batch_id', $simulatedFormData['course_id'])
        ->whereIn('id', $materialsToDelete)
        ->delete();
    
    echo "   Deleted {$deletedCount} explicitly marked materials\n";
}

// Only do implicit deletion if NO new materials and we have existing materials
if (!$hasNewMaterials && $existingMaterials->count() > 0) {
    echo "   Executing implicit deletion (safe to remove orphans)\n";
    $implicitDeletedCount = DB::table('materials')
        ->where('batch_id', $simulatedFormData['course_id'])
        ->whereNotIn('id', $materialsToKeep)
        ->delete();
    
    echo "   Deleted {$implicitDeletedCount} orphan materials\n";
} else {
    echo "   SKIPPING implicit deletion (form contains new materials or no existing materials)\n";
}

echo "\n5. FINAL STATE:\n";
$finalMaterials = DB::table('materials')->where('batch_id', $simulatedFormData['course_id'])->get();
echo "   Remaining materials: " . $finalMaterials->count() . "\n";
if ($finalMaterials->count() == 0) {
    echo "   ✅ SUCCESS: Chapter 1 dan materialsnya terhapus sesuai input user\n";
} else {
    foreach ($finalMaterials as $material) {
        echo "   - ID: {$material->id}, Chapter: {$material->chapter_number}, Title: {$material->title}\n";
    }
}

echo "\n=== TEST COMPLETE ===\n";