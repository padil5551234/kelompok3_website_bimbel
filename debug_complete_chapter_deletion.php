<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG COMPLETE CHAPTER DELETION ISSUE ===\n\n";

// Simulate COMPLETE scenario: User has existing chapters, removes one chapter
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
echo "   User menghapus Chapter 2 dan Chapter 3\n";
echo "   Form hanya mengirim Chapter 1 dengan existing material\n";
echo "   Chapters yang dikirim:\n";
foreach ($simulatedFormData['chapters'] as $index => $chapterData) {
    $materialCount = count($chapterData['materials']);
    $hasId = isset($chapterData['materials'][0]['id']) ? 'YES' : 'NO';
    echo "     - Chapter {$index}: {$chapterData['title']} ({$materialCount} materials, has ID: {$hasId})\n";
}

echo "\n2. CURRENT DATABASE STATE:\n";
$existingMaterials = DB::table('materials')->where('batch_id', $simulatedFormData['course_id'])->get();
echo "   Materials in database BEFORE form submission:\n";
foreach ($existingMaterials as $material) {
    echo "     - ID: {$material->id}\n";
    echo "       Chapter Number: {$material->chapter_number}\n";
    echo "       Title: {$material->title}\n";
    echo "       Expected Form Index: " . ($material->chapter_number - 1) . "\n";
}

echo "\n3. ANALYZING THE PROBLEM:\n";
echo "   CURRENT BROKEN LOGIC:\n";

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
            echo "     NEW MATERIAL: {$materialData['title']}\n";
        }
    }
}

echo "\n   Analysis Results:\n";
echo "   - Chapters to delete: " . implode(', ', $chaptersToDelete) . "\n";
echo "   - Materials to keep: " . implode(', ', $materialsToKeep) . "\n";
echo "   - Materials to delete: " . implode(', ', $materialsToDelete) . "\n";
echo "   - Has new materials: " . ($hasNewMaterials ? 'YES' : 'NO') . "\n";
echo "   - Existing materials count: " . $existingMaterials->count() . "\n";

echo "\n4. DELETION DECISION:\n";
if (!$hasNewMaterials && $existingMaterials->count() > 0) {
    echo "   DECISION: Execute implicit deletion\n";
    echo "   REASON: No new materials, existing materials present\n";
    
    $willBeDeleted = DB::table('materials')->where('batch_id', $simulatedFormData['course_id'])
        ->whereNotIn('id', $materialsToKeep)
        ->get();
    
    echo "   Materials yang AKAN DIHAPUS:\n";
    foreach ($willBeDeleted as $material) {
        echo "     - ID: {$material->id}\n";
        echo "       Chapter: {$material->chapter_number}, Title: {$material->title}\n";
        echo "       REASON: Not in materialsToKeep array\n";
    }
} else {
    echo "   DECISION: SKIP implicit deletion\n";
    echo "   REASON: Form contains new materials or no existing materials\n";
}

echo "\n5. THE REAL PROBLEM:\n";
echo "   1. User memiliki 3 chapters dengan materials\n";
echo "   2. User menghapus chapter 2 dan 3 (dari form UI)\n";
echo "   3. Form dikirim hanya dengan chapter 1\n";
echo "   4. Controller melihat chapter 2 dan 3 TIDAK ADA di form\n";
echo "   5. Controller认为 semua materials dari chapter 2 & 3 adalah 'orphan'\n";
echo "   6. Materials dari chapter 2 & 3 DIHAPUS!\n";
echo "   7. RESULT: Chapter 2 & 3 materials hilang total\n";

echo "\n6. CHAPTER vs MATERIAL MISMATCH:\n";
echo "   Database: Chapter 1, 2, 3 dengan materials\n";
echo "   Form: Hanya Chapter 1\n";
echo "   Problem: Controller tidak tahu mana yang di-delete vs mana yang tidak ada\n";

echo "\n=== DEBUG COMPLETE ===\n";