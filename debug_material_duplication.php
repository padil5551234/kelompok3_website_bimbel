<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Check for materials with potential duplication
    $materials = DB::table('materials')
        ->select('batch_id', 'chapter_number', 'chapter_title', 'title', 'id', 'material_order')
        ->orderBy('batch_id')
        ->orderBy('chapter_number')
        ->orderBy('material_order')
        ->get();
        
    echo "=== MATERIALS ANALYSIS ===\n\n";
    
    $currentBatch = null;
    $chapterMaterials = [];
    
    foreach ($materials as $material) {
        if ($material->batch_id !== $currentBatch) {
            if (!empty($chapterMaterials)) {
                // Analyze previous batch
                echo "Batch ID: " . $currentBatch . "\n";
                $grouped = collect($chapterMaterials)->groupBy(function($m) {
                    return $m->chapter_number . '|' . ($m->chapter_title ?: 'Bab ' . $m->chapter_number);
                });
                
                foreach ($grouped as $chapterKey => $chapterItems) {
                    echo "  Chapter: " . $chapterKey . " (" . $chapterItems->count() . " materials)\n";
                    foreach ($chapterItems as $item) {
                        echo "    - " . $item->title . " (ID: " . $item->id . ", Order: " . $item->material_order . ")\n";
                    }
                    if ($chapterItems->count() > 2) {
                        echo "    ⚠️  WARNING: More than 2 materials in this chapter!\n";
                    }
                }
                echo "\n";
            }
            $chapterMaterials = [];
            $currentBatch = $material->batch_id;
        }
        $chapterMaterials[] = $material;
    }
    
    // Handle last batch
    if (!empty($chapterMaterials)) {
        echo "Batch ID: " . $currentBatch . "\n";
        $grouped = collect($chapterMaterials)->groupBy(function($m) {
            return $m->chapter_number . '|' . ($m->chapter_title ?: 'Bab ' . $m->chapter_number);
        });
        
        foreach ($grouped as $chapterKey => $chapterItems) {
            echo "  Chapter: " . $chapterKey . " (" . $chapterItems->count() . " materials)\n";
            foreach ($chapterItems as $item) {
                echo "    - " . $item->title . " (ID: " . $item->id . ", Order: " . $item->material_order . ")\n";
            }
            if ($chapterItems->count() > 2) {
                echo "    ⚠️  WARNING: More than 2 materials in this chapter!\n";
            }
        }
    }
    
    // Check for exact duplicates
    echo "\n=== CHECKING FOR EXACT DUPLICATES ===\n";
    $duplicates = DB::table('materials')
        ->select('batch_id', 'chapter_number', 'chapter_title', 'title', DB::raw('COUNT(*) as count'))
        ->groupBy('batch_id', 'chapter_number', 'chapter_title', 'title')
        ->having('count', '>', 1)
        ->get();
        
    if ($duplicates->isNotEmpty()) {
        echo "⚠️  FOUND EXACT DUPLICATES:\n";
        foreach ($duplicates as $duplicate) {
            echo "  - Batch {$duplicate->batch_id}, Chapter {$duplicate->chapter_number}, Title: {$duplicate->title} (Count: {$duplicate->count})\n";
        }
    } else {
        echo "✅ No exact duplicates found\n";
    }
    
    // Check for similar chapter titles that might cause grouping issues
    echo "\n=== CHECKING FOR SIMILAR CHAPTER TITLES ===\n";
    $allChapters = DB::table('materials')
        ->select('batch_id', 'chapter_number', 'chapter_title')
        ->distinct()
        ->orderBy('batch_id')
        ->orderBy('chapter_number')
        ->get();
        
    $batchGroups = $allChapters->groupBy('batch_id');
    foreach ($batchGroups as $batchId => $chapters) {
        echo "Batch {$batchId}:\n";
        foreach ($chapters as $chapter) {
            echo "  Chapter {$chapter->chapter_number}: '" . ($chapter->chapter_title ?: 'NULL') . "'\n";
        }
        
        // Check for potential similar titles
        $titles = $chapters->pluck('chapter_title')->filter()->values();
        $similarTitles = [];
        for ($i = 0; $i < count($titles); $i++) {
            for ($j = $i + 1; $j < count($titles); $j++) {
                $title1 = trim($titles[$i]);
                $title2 = trim($titles[$j]);
                if (strcasecmp($title1, $title2) === 0 || 
                    strpos(strtolower($title1), strtolower($title2)) !== false ||
                    strpos(strtolower($title2), strtolower($title1)) !== false) {
                    $similarTitles[] = "'{$title1}' vs '{$title2}'";
                }
            }
        }
        
        if (!empty($similarTitles)) {
            echo "  ⚠️  POTENTIAL SIMILAR TITLES: " . implode(', ', $similarTitles) . "\n";
        }
        echo "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?>