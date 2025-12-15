<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG CHAPTER INDEXING ISSUE ===\n\n";

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
    echo "       Expected Form Index: " . ($material->chapter_number - 1) . "\n";
}

echo "\n3. Issue Analysis:\n";
echo "   PROBLEM: Database chapter_number vs Form array index mismatch!\n";
echo "   - Database: Chapter 1 = chapter_number 1, Chapter 2 = chapter_number 2\n";
echo "   - Form: Chapter 1 = index 0, Chapter 2 = index 1\n";
echo "   - Controller logic: Material dengan chapter_number 3 akan dianggap orphan\n";

echo "\n4. Simulating Current Broken Logic:\n";
$materialsToKeep = [];
$materialsToDelete = [];

foreach ($simulatedFormData['chapters'] as $chapterIndex => $chapterData) {
    echo "   Processing form chapter index {$chapterIndex}: {$chapterData['title']}\n";
    
    // Current logic hanya check material IDs, tidak check chapter numbers
    foreach ($chapterData['materials'] as $materialIndex => $materialData) {
        // Check if material is marked for deletion
        if (isset($materialData['delete']) && !empty($materialData['delete'])) {
            $materialsToDelete[] = $materialData['delete'];
        }
        // Check if material should be kept (has valid ID and not deleted) 
        elseif (isset($materialData['id']) && !empty($materialData['id'])) {
            $materialsToKeep[] = $materialData['id'];
        }
        // NEW MATERIALS TIDAK ADA ID, jadi tidak masuk ke materialsToKeep!
        else {
            echo "     - NEW MATERIAL: {$materialData['title']} (no ID, not in materialsToKeep)\n";
        }
    }
}

echo "\n   Materials to keep: " . implode(', ', $materialsToKeep) . "\n";
echo "   Materials to delete: " . implode(', ', $materialsToDelete) . "\n";

echo "\n5. Implicit Deletion (Current Broken Logic):\n";
// Current logic: Delete materials yang tidak ada di materialsToKeep
// Ini akan hapus SEMUA existing materials karena mereka tidak ada di form!
$willBeDeleted = DB::table('materials')->where('batch_id', $simulatedFormData['course_id'])
    ->whereNotIn('id', $materialsToKeep)
    ->get();

echo "   Materials yang akan dihapus (BROKEN):\n";
foreach ($willBeDeleted as $material) {
    echo "     - ID: {$material->id}, Chapter: {$material->chapter_number}, Title: {$material->title}\n";
}

echo "\n6. ROOT CAUSE IDENTIFIED:\n";
echo "   1. User menambah 3 chapters baru (tanpa IDs)\n";
echo "   2. User menghapus chapter 3 (form index 2)\n";  
echo "   3. Form dikirim dengan chapters index 0, 1 (chapter 1, 2)\n";
echo "   4. Controller tidak menemukan material IDs di form\n";
echo "   5. Controller，认为 semua existing materials adalah 'orphan'\n";
echo "   6. ALL existing materials dihapus (termasuk chapter 2)!\n";

echo "\n=== DEBUG COMPLETE ===\n";