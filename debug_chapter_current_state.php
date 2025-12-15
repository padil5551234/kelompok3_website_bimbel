<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Material;
use App\Models\PaketUjian;

echo "=== DEBUG: Current Chapter State ===\n\n";

// Check materials with chapters
$materials = Material::whereNotNull('chapter_number')
    ->select('id', 'batch_id', 'chapter_number', 'chapter_title', 'title', 'type', 'created_at')
    ->orderBy('batch_id')
    ->orderBy('chapter_number')
    ->get();

if ($materials->isEmpty()) {
    echo "No materials with chapters found.\n";
} else {
    echo "Materials with chapters:\n";
    foreach ($materials as $material) {
        $batch = PaketUjian::find($material->batch_id);
        $batchName = $batch ? $batch->nama : 'Unknown Batch';
        echo sprintf(
            "ID: %s, Batch: %s (%s), Chapter: %d, Title: %s, Type: %s, Created: %s\n",
            $material->id,
            $material->batch_id,
            $batchName,
            $material->chapter_number,
            $material->title,
            $material->type,
            $material->created_at->format('Y-m-d H:i:s')
        );
    }
}

echo "\n=== Chapter Statistics ===\n";

// Group by batch
$chaptersByBatch = $materials->groupBy('batch_id');
foreach ($chaptersByBatch as $batchId => $batchMaterials) {
    $batch = PaketUjian::find($batchId);
    $batchName = $batch ? $batch->nama : 'Unknown Batch';
    
    $chapterNumbers = $batchMaterials->pluck('chapter_number')->sort()->values();
    echo "Batch: {$batchName} (ID: {$batchId})\n";
    echo "  Chapters: " . $chapterNumbers->implode(', ') . "\n";
    echo "  Chapter count: " . $chapterNumbers->count() . "\n";
    
    // Check for gaps in chapter numbering
    $expectedChapters = range(1, $chapterNumbers->max());
    $missingChapters = array_diff($expectedChapters, $chapterNumbers->toArray());
    if (!empty($missingChapters)) {
        echo "  Missing chapters: " . implode(', ', $missingChapters) . "\n";
    }
    
    echo "\n";
}

echo "=== Test Chapter Deletion Function ===\n";

// Let's test the deleteChapter method logic
if (!$materials->isEmpty()) {
    $firstMaterial = $materials->first();
    $testBatchId = $firstMaterial->batch_id;
    $testChapterNumber = $firstMaterial->chapter_number;
    
    echo "Testing with Batch ID: {$testBatchId}, Chapter Number: {$testChapterNumber}\n";
    
    // Get materials in the test chapter
    $chapterMaterials = Material::where('batch_id', $testBatchId)
        ->where('chapter_number', $testChapterNumber)
        ->get();
    
    echo "Materials in test chapter: " . $chapterMaterials->count() . "\n";
    
    // Get subsequent chapters
    $subsequentChapters = Material::where('batch_id', $testBatchId)
        ->where('chapter_number', '>', $testChapterNumber)
        ->orderBy('chapter_number')
        ->get();
    
    echo "Subsequent chapters: " . $subsequentChapters->count() . "\n";
    foreach ($subsequentChapters as $material) {
        echo "  - Material ID: {$material->id}, Current Chapter: {$material->chapter_number}, Would become: " . ($material->chapter_number - 1) . "\n";
    }
}

echo "\n=== End Debug ===\n";