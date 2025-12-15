<?php

/**
 * Test Actual Deletion Through Controller
 * Test if the controller deletion method actually works
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🧪 Testing Actual Controller Deletion\n";
echo "=====================================\n\n";

try {
    // Get current state
    echo "1️⃣ Current State Before Deletion:\n";
    
    $materialsBefore = App\Models\Material::with(['batch'])
        ->whereNotNull('chapter_number')
        ->orderBy('batch_id')
        ->orderBy('chapter_number')
        ->get();

    echo "   📚 Materials with chapters: " . $materialsBefore->count() . "\n";
    
    if ($materialsBefore->count() == 0) {
        echo "   ❌ No materials found to test deletion!\n";
        exit;
    }
    
    // Group by chapters
    $chaptersBefore = [];
    foreach ($materialsBefore as $material) {
        $key = "{$material->batch_id}_{$material->chapter_number}";
        if (!isset($chaptersBefore[$key])) {
            $chaptersBefore[$key] = [
                'batch_id' => $material->batch_id,
                'chapter_number' => $material->chapter_number,
                'materials' => []
            ];
        }
        $chaptersBefore[$key]['materials'][] = $material;
    }
    
    echo "   📖 Unique chapters: " . count($chaptersBefore) . "\n";
    
    // Show details
    foreach ($chaptersBefore as $key => $chapter) {
        echo "   📋 Chapter {$chapter['chapter_number']}: " . count($chapter['materials']) . " materials\n";
    }
    
    // Test deletion
    echo "\n2️⃣ Testing Actual Deletion:\n";
    
    $controller = new App\Http\Controllers\Admin\MaterialController();
    
    // Get first chapter to delete
    $chapters = array_values($chaptersBefore);
    $testChapter = $chapters[0];
    
    $batchId = $testChapter['batch_id'];
    $chapterNumber = $testChapter['chapter_number'];
    
    echo "   🗑️  Testing deletion of Chapter {$chapterNumber} from batch {$batchId}\n";
    echo "   📄 Materials in chapter: " . count($testChapter['materials']) . "\n";
    
    // Create a request object to simulate the HTTP request
    $request = new Illuminate\Http\Request();
    $request->replace([
        'batch_id' => $batchId,
        'chapter_number' => $chapterNumber
    ]);
    
    // Get material IDs before deletion
    $materialIdsBefore = $testChapter['materials']->pluck('id')->toArray();
    echo "   📝 Material IDs to delete: " . implode(', ', $materialIdsBefore) . "\n";
    
    // Check if materials exist before deletion
    $existingBefore = App\Models\Material::whereIn('id', $materialIdsBefore)->count();
    echo "   ✅ Materials existing before deletion: {$existingBefore}/" . count($materialIdsBefore) . "\n";
    
    // Call the actual controller method
    echo "\n3️⃣ Calling Controller Method:\n";
    echo "   🔄 Executing deleteChapter method...\n";
    
    try {
        $response = $controller->deleteChapter($request);
        
        echo "   📊 Response received:\n";
        if ($response instanceof Illuminate\Http\JsonResponse) {
            $data = $response->getData();
            echo "      Success: " . ($data->success ? 'YES' : 'NO') . "\n";
            echo "      Message: " . $data->message . "\n";
            
            if ($data->success) {
                echo "   ✅ Deletion reported as successful!\n";
            } else {
                echo "   ❌ Deletion failed: " . $data->message . "\n";
            }
        } else {
            echo "      Response type: " . get_class($response) . "\n";
            echo "      Response content: " . $response->getContent() . "\n";
        }
        
    } catch (Exception $e) {
        echo "   ❌ Exception during deletion: " . $e->getMessage() . "\n";
        echo "   📋 Stack trace: " . $e->getTraceAsString() . "\n";
    }
    
    // Check if materials still exist after deletion
    echo "\n4️⃣ Checking Results After Deletion:\n";
    
    $existingAfter = App\Models\Material::whereIn('id', $materialIdsBefore)->count();
    echo "   📊 Materials existing after deletion: {$existingAfter}/" . count($materialIdsBefore) . "\n";
    
    // Get updated material count
    $materialsAfter = App\Models\Material::whereNotNull('chapter_number')->count();
    echo "   📚 Total materials with chapters after deletion: {$materialsAfter}\n";
    
    // Check final state
    if ($existingAfter == 0) {
        echo "   ✅ SUCCESS: All materials were deleted!\n";
    } elseif ($existingAfter < count($materialIdsBefore)) {
        echo "   ⚠️  PARTIAL: Some materials were deleted ({$existingAfter}/" . count($materialIdsBefore) . " remain)\n";
    } else {
        echo "   ❌ FAILED: No materials were deleted\n";
    }
    
    // Show remaining chapters
    $chaptersAfter = App\Models\Material::with(['batch'])
        ->whereNotNull('chapter_number')
        ->orderBy('batch_id')
        ->orderBy('chapter_number')
        ->get()
        ->groupBy(function($material) {
            return "{$material->batch_id}_{$material->chapter_number}";
        });
    
    echo "   📖 Remaining chapters: " . $chaptersAfter->count() . "\n";
    
    echo "\n5️⃣ Summary:\n";
    echo "===========\n";
    
    if ($existingAfter == 0) {
        echo "🎉 DELETION WORKS PERFECTLY!\n";
        echo "💡 The controller deletion method successfully deletes materials.\n";
        echo "🔧 If chapters are coming back, the issue might be:\n";
        echo "   - Cache not being cleared\n";
        echo "   - Database transaction rollback\n";
        echo "   - Multiple chapter deletion attempts\n";
        echo "   - Frontend not properly refreshing\n";
    } else {
        echo "⚠️  DELETION NOT WORKING!\n";
        echo "💡 The controller method is not deleting materials properly.\n";
        echo "🔧 Check for:\n";
        echo "   - Database constraints\n";
        echo "   - Model relationships\n";
        echo "   - Transaction handling\n";
        echo "   - Exception handling\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n🏁 Test completed!\n";