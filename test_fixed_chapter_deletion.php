<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST FIXED CHAPTER DELETION ===\n\n";

// Simulate scenario: User adds 3 chapters, removes chapter 3
// Form data yang dikirim setelah remove chapter 3
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
            'delete' => null,
            'materials' => [
                0 => [
                    'title' => 'Material 1.1',
                    'type' => 'youtube',
                    'content_url' => 'https://youtube.com/test1',
                    'description' => 'Material 1.1'
                ]
            ]
        ],
        1 => [
            'title' => 'Chapter 2', 
            'delete' => null,
            'materials' => [
                0 => [
                    'title' => 'Material 2.1',
                    'type' => 'youtube', 
                    'content_url' => 'https://youtube.com/test2',
                    'description' => 'Material 2.1'
                ]
            ]
        ]
        // Chapter 3 (index 2) tidak ada karena dihapus
    ]
];

echo "1. Form Data Analysis:\n";
echo "   Chapters yang dikirim dalam form:\n";
foreach ($simulatedFormData['chapters'] as $index => $chapterData) {
    echo "     - Form Index: {$index}, Title: {$chapterData['title']}\n";
}
echo "     - Chapter 3 (index 2) TIDAK ADA dalam form\n";

echo "\n2. Current Database State:\n";
$existingMaterials = DB::table('materials')->where('batch_id', $simulatedFormData['course_id'])->get();
echo "   Materials in database:\n";
foreach ($existingMaterials as $material) {
    echo "     - ID: {$material->id}\n";
    echo "       Chapter Number: {$material->chapter_number}\n";
    echo "       Title: {$material->title}\n";
}

echo "\n3. Applying FIXED Logic:\n";

// Get chapters to delete and materials to keep
$chaptersToDelete = [];
$materialsToKeep = [];
$materialsToDelete = [];
$hasNewMaterials = false; // Track if form contains new materials

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
            echo "   NEW MATERIAL DETECTED: {$materialData['title']}\n";
        }
    }
}

echo "\n   Analysis Results:\n";
echo "   - Chapters to delete: " . implode(', ', $chaptersToDelete) . "\n";
echo "   - Materials to keep: " . implode(', ', $materialsToKeep) . "\n";
echo "   - Materials to delete: " . implode(', ', $materialsToDelete) . "\n";
echo "   - Has new materials: " . ($hasNewMaterials ? 'YES' : 'NO') . "\n";
echo "   - Existing materials count: " . $existingMaterials->count() . "\n";

echo "\n4. Deletion Logic Decision:\n";
if (!$hasNewMaterials && $existingMaterials->count() > 0) {
    echo "   DECISION: Execute implicit deletion\n";
    echo "   REASON: No new materials, existing materials present - safe to remove orphans\n";
    
    $willBeDeleted = DB::table('materials')->where('batch_id', $simulatedFormData['course_id'])
        ->whereNotIn('id', $materialsToKeep)
        ->get();
    
    echo "   Materials yang akan dihapus:\n";
    foreach ($willBeDeleted as $material) {
        echo "     - ID: {$material->id}, Chapter: {$material->chapter_number}, Title: {$material->title}\n";
    }
} else {
    echo "   DECISION: SKIP implicit deletion\n";
    echo "   REASON: Form contains new materials or no existing materials\n";
    echo "   - hasNewMaterials: " . ($hasNewMaterials ? 'true' : 'false') . "\n";
    echo "   - existingMaterialsCount: " . $existingMaterials->count() . "\n";
}

echo "\n5. Expected Result:\n";
echo "   ✅ Chapter 1: KEPT (form index 0)\n";
echo "   ✅ Chapter 2: KEPT (form index 1)\n"; 
echo "   ✅ Chapter 3: NOT PRESENT (hapus dari form, tidak ada di database)\n";
echo "   ✅ Materials: Semua materials existing TIDAK dihapus karena ada new materials\n";

echo "\n=== TEST COMPLETE ===\n";