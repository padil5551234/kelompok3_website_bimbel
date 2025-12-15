<?php

/**
 * Debug Deletion Persistence Issue
 * Check why deleted chapters are coming back after refresh
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔍 Debugging Deletion Persistence Issue\n";
echo "=======================================\n\n";

try {
    echo "1️⃣ Checking current database state:\n";
    
    $materials = App\Models\Material::with(['batch'])
        ->whereNotNull('chapter_number')
        ->orderBy('batch_id')
        ->orderBy('chapter_number')
        ->get();

    echo "   📚 Total materials with chapters: " . $materials->count() . "\n";
    
    // Group by chapters
    $chapterStructure = [];
    foreach ($materials as $material) {
        $batchName = $material->batch->nama ?? 'Unknown Batch';
        $key = "{$material->batch_id}_{$material->chapter_number}";
        
        if (!isset($chapterStructure[$key])) {
            $chapterStructure[$key] = [
                'batch_id' => $material->batch_id,
                'batch_name' => $batchName,
                'chapter_number' => $material->chapter_number,
                'chapter_title' => $material->chapter_title ?? "Chapter {$material->chapter_number}",
                'materials' => []
            ];
        }
        $chapterStructure[$key]['materials'][] = $material;
    }
    
    echo "   📖 Total unique chapters: " . count($chapterStructure) . "\n";
    
    // Show details
    foreach ($chapterStructure as $key => $chapter) {
        echo "   📋 {$chapter['batch_name']} - Chapter {$chapter['chapter_number']}: " . count($chapter['materials']) . " materials\n";
        foreach ($chapter['materials'] as $material) {
            echo "      - ID: {$material->id}, Title: {$material->title}\n";
        }
        echo "\n";
    }
    
    echo "2️⃣ Testing actual deletion process:\n";
    
    if (count($chapterStructure) > 0) {
        // Get first chapter to test deletion
        $chapters = array_values($chapterStructure);
        $testChapter = $chapters[0];
        
        $batchId = $testChapter['batch_id'];
        $chapterNumber = $testChapter['chapter_number'];
        
        echo "   🧪 Testing deletion of: {$testChapter['batch_name']} - Chapter {$chapterNumber}\n";
        
        // Get materials that would be deleted
        $materialsToDelete = App\Models\Material::where('batch_id', $batchId)
            ->where('chapter_number', $chapterNumber)
            ->get();
            
        echo "   📊 Materials to delete: " . $materialsToDelete->count() . "\n";
        
        if ($materialsToDelete->count() > 0) {
            echo "   📝 Material IDs to be deleted:\n";
            $materialIds = [];
            foreach ($materialsToDelete as $material) {
                echo "      - ID: {$material->id}, Title: {$material->title}\n";
                $materialIds[] = $material->id;
            }
            
            // Simulate the actual deletion logic from controller
            echo "\n   🔄 Simulating controller deletion logic:\n";
            
            try {
                // Start transaction simulation
                echo "      🔧 Starting deletion process...\n";
                
                // Step 1: Get subsequent chapters
                $subsequentChapters = App\Models\Material::where('batch_id', $batchId)
                    ->where('chapter_number', '>', $chapterNumber)
                    ->orderBy('chapter_number')
                    ->get();
                    
                echo "      📈 Subsequent chapters found: " . $subsequentChapters->count() . "\n";
                
                // Step 2: Show renumbering plan
                if ($subsequentChapters->count() > 0) {
                    echo "      🔢 Renumbering plan:\n";
                    foreach ($subsequentChapters->groupBy('chapter_number')->sortKeys() as $oldNum => $materials) {
                        $newNum = $oldNum - 1;
                        echo "         Chapter {$oldNum} → Chapter {$newNum} (" . $materials->count() . " materials)\n";
                    }
                }
                
                // Step 3: Check if materials still exist (before deletion)
                $existingMaterials = App\Models\Material::whereIn('id', $materialIds)->count();
                echo "      ✅ Materials still exist before deletion: {$existingMaterials}/" . count($materialIds) . "\n";
                
                // Step 4: Simulate actual deletion (but don't execute)
                echo "      🗑️  SIMULATION MODE - Not actually deleting materials\n";
                echo "         (This is where the actual deletion would happen)\n";
                
                // Step 5: Check if materials exist after "deletion"
                $stillExisting = App\Models\Material::whereIn('id', $materialIds)->count();
                echo "      📊 Materials exist after 'deletion': {$stillExisting}/" . count($materialIds) . "\n";
                
                if ($stillExisting == count($materialIds)) {
                    echo "      ⚠️  ISSUE DETECTED: Materials are not being deleted!\n";
                    echo "      💡 Possible causes:\n";
                    echo "         - Database transaction is being rolled back\n";
                    echo "         - Deletion logic has an error\n";
                    echo "         - Foreign key constraints are preventing deletion\n";
                    echo "         - Soft delete is being used instead of hard delete\n";
                } else {
                    echo "      ✅ Deletion simulation completed\n";
                }
                
            } catch (Exception $e) {
                echo "      ❌ Error during deletion simulation: " . $e->getMessage() . "\n";
            }
        }
    }
    
    echo "\n3️⃣ Checking for soft deletes:\n";
    
    // Check if Material model uses SoftDeletes
    $usesSoftDeletes = in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(App\Models\Material::class));
    echo "   📋 Material model uses SoftDeletes: " . ($usesSoftDeletes ? 'YES' : 'NO') . "\n";
    
    if ($usesSoftDeletes) {
        echo "   ⚠️  If using soft deletes, deleted materials might still appear!\n";
        echo "   💡 Check for 'deleted_at' column in materials table\n";
        
        // Check for soft deleted materials
        $softDeleted = App\Models\Material::onlyTrashed()->whereNotNull('chapter_number')->count();
        echo "   📊 Soft deleted materials with chapters: {$softDeleted}\n";
    }
    
    echo "\n4️⃣ Recommendations:\n";
    echo "===================\n";
    echo "• Check Laravel logs for deletion errors\n";
    echo "• Verify database transaction handling\n";
    echo "• Ensure no foreign key constraints are blocking deletion\n";
    echo "• Check if the route is actually being called\n";
    echo "• Verify CSRF token is valid\n";
    echo "• Check if user has proper permissions\n";
    echo "• Add more detailed logging to the deleteChapter method\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n🏁 Debug completed!\n";