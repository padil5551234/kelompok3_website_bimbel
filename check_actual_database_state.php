<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECK ACTUAL DATABASE STATE ===\n\n";

// Check all materials for the course
$courseId = 'a5138937-606e-44de-ab1c-9c24f17cbc17';

echo "1. ALL MATERIALS FOR COURSE: {$courseId}\n";
$allMaterials = DB::table('materials')->where('batch_id', $courseId)->get();

if ($allMaterials->count() == 0) {
    echo "   NO MATERIALS FOUND!\n";
} else {
    echo "   Total materials: " . $allMaterials->count() . "\n";
    foreach ($allMaterials as $material) {
        echo "   - ID: {$material->id}\n";
        echo "     Chapter Number: {$material->chapter_number}\n";
        echo "     Chapter Title: {$material->chapter_title}\n";
        echo "     Title: {$material->title}\n";
        echo "     Type: {$material->type}\n";
        echo "     Created: {$material->created_at}\n";
        echo "     ---\n";
    }
}

echo "\n2. CHAPTER ANALYSIS\n";
$chapterGroups = $allMaterials->groupBy('chapter_number');
echo "   Total chapters: " . $chapterGroups->count() . "\n";
foreach ($chapterGroups as $chapterNum => $materials) {
    echo "   Chapter {$chapterNum}: " . $materials->count() . " materials\n";
    foreach ($materials as $material) {
        echo "     - {$material->title}\n";
    }
}

echo "\n3. CHECKING FOR ORPHAN CHAPTERS\n";
// Check if there are gaps in chapter numbering
$chapterNumbers = $allMaterials->pluck('chapter_number')->sort()->values();
echo "   Chapter numbers found: " . $chapterNumbers->implode(', ') . "\n";

if ($chapterNumbers->count() > 0) {
    $expectedChapters = range(1, $chapterNumbers->max());
    $missingChapters = array_diff($expectedChapters, $chapterNumbers->toArray());
    
    if (!empty($missingChapters)) {
        echo "   MISSING CHAPTERS: " . implode(', ', $missingChapters) . "\n";
        echo "   This suggests chapters were deleted but not properly handled!\n";
    } else {
        echo "   No missing chapters in sequence\n";
    }
}

echo "\n4. TESTING CHAPTER DELETION SCENARIO\n";
// Simulate what happens when user removes chapter 2 from a 3-chapter course
echo "   Scenario: User has 3 chapters, removes chapter 2\n";
echo "   Form would contain: Chapter 1, Chapter 3\n";
echo "   Database contains: Chapter 1, Chapter 2, Chapter 3\n";
echo "   Problem: Chapter 2 materials are 'orphans' and get deleted!\n";

echo "\n=== ANALYSIS COMPLETE ===\n";