<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Material;
use App\Models\PaketUjian;
use Illuminate\Support\Facades\DB;

echo "=== CHAPTER DELETION & RENUMBERING FIX ===\n\n";

try {
    DB::beginTransaction();
    
    // Get all materials with chapters
    $materials = Material::whereNotNull('chapter_number')
        ->orderBy('batch_id')
        ->orderBy('chapter_number')
        ->get();
    
    if ($materials->isEmpty()) {
        echo "No materials with chapters found to fix.\n";
        DB::rollBack();
        exit;
    }
    
    echo "Found " . $materials->count() . " materials with chapters.\n\n";
    
    // Group materials by batch
    $chaptersByBatch = $materials->groupBy('batch_id');
    $fixedBatches = 0;
    $totalRenumbered = 0;
    
    foreach ($chaptersByBatch as $batchId => $batchMaterials) {
        $batch = PaketUjian::find($batchId);
        $batchName = $batch ? $batch->nama : 'Unknown Batch';
        
        echo "Processing batch: {$batchName} (ID: {$batchId})\n";
        
        // Get unique chapter numbers and sort them
        $chapterNumbers = $batchMaterials->pluck('chapter_number')->unique()->sort()->values();
        echo "  Current chapters: " . $chapterNumbers->implode(', ') . "\n";
        
        // Check if there are gaps in chapter numbering
        $expectedChapters = range(1, $chapterNumbers->max());
        $missingChapters = array_diff($expectedChapters, $chapterNumbers->toArray());
        
        if (!empty($missingChapters)) {
            echo "  Found gaps in chapter numbering. Fixing...\n";
            
            // Create a mapping from old chapter numbers to new chapter numbers
            $chapterMapping = [];
            $newChapterNumber = 1;
            
            foreach ($chapterNumbers as $oldChapterNumber) {
                $chapterMapping[$oldChapterNumber] = $newChapterNumber;
                $newChapterNumber++;
            }
            
            echo "  Chapter mapping: " . json_encode($chapterMapping) . "\n";
            
            // Update all materials in this batch
            foreach ($batchMaterials as $material) {
                $oldChapterNumber = $material->chapter_number;
                $newChapterNumber = $chapterMapping[$oldChapterNumber];
                
                if ($oldChapterNumber != $newChapterNumber) {
                    echo "    Updating material {$material->id}: Chapter {$oldChapterNumber} -> {$newChapterNumber}\n";
                    $material->chapter_number = $newChapterNumber;
                    $material->save();
                    $totalRenumbered++;
                }
            }
            
            $fixedBatches++;
        } else {
            echo "  Chapter numbering is already sequential. No fix needed.\n";
        }
        
        echo "\n";
    }
    
    // Also fix duplicate chapter assignments within the same batch
    echo "=== Fixing duplicate chapter assignments ===\n";
    
    $duplicateFixed = 0;
    foreach ($chaptersByBatch as $batchId => $batchMaterials) {
        // Group by chapter number within each batch
        $materialsByChapter = $batchMaterials->groupBy('chapter_number');
        
        foreach ($materialsByChapter as $chapterNumber => $chapterMaterials) {
            if ($chapterMaterials->count() > 1) {
                echo "Found {$chapterMaterials->count()} materials in batch {$batchId}, chapter {$chapterNumber}\n";
                
                // Reassign materials to sequential chapter numbers
                $currentChapter = $chapterNumber;
                foreach ($chapterMaterials as $index => $material) {
                    $newChapterNumber = $chapterNumber + $index;
                    if ($material->chapter_number != $newChapterNumber) {
                        echo "  Reassigning material {$material->id}: Chapter {$material->chapter_number} -> {$newChapterNumber}\n";
                        $material->chapter_number = $newChapterNumber;
                        $material->save();
                        $duplicateFixed++;
                    }
                }
            }
        }
    }
    
    DB::commit();
    
    echo "\n=== SUMMARY ===\n";
    echo "Fixed batches: {$fixedBatches}\n";
    echo "Total materials renumbered: {$totalRenumbered}\n";
    echo "Duplicate assignments fixed: {$duplicateFixed}\n";
    echo "✅ Chapter numbering has been fixed successfully!\n";
    
    // Show the updated state
    echo "\n=== Updated Chapter State ===\n";
    
    $updatedMaterials = Material::whereNotNull('chapter_number')
        ->select('id', 'batch_id', 'chapter_number', 'chapter_title', 'title')
        ->orderBy('batch_id')
        ->orderBy('chapter_number')
        ->get();
    
    foreach ($updatedMaterials->groupBy('batch_id') as $batchId => $batchMaterials) {
        $batch = PaketUjian::find($batchId);
        $batchName = $batch ? $batch->nama : 'Unknown Batch';
        
        echo "Batch: {$batchName}\n";
        foreach ($batchMaterials as $material) {
            echo "  Chapter {$material->chapter_number}: {$material->title}\n";
        }
        echo "\n";
    }
    
} catch (Exception $e) {
    DB::rollBack();
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Transaction rolled back.\n";
}

echo "\n=== Fix Complete ===\n";