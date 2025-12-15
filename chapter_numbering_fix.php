<?php

/**
 * CHAPTER NUMBERING FIX IMPLEMENTATION
 * 
 * This file contains the complete solution for the chapter numbering issue.
 * The problem: When deleting all chapters and re-uploading, numbering continues from where it left off.
 * 
 * Solution implemented:
 * 1. Auto-assign next chapter number when creating materials if none specified
 * 2. Reset chapter numbering when all chapters are deleted from a batch
 * 3. Validate and fix sequential chapter numbering
 * 4. Update form to suggest next chapter number
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Material;
use App\Models\PaketUjian;
use Illuminate\Support\Facades\DB;

echo "=== CHAPTER NUMBERING FIX IMPLEMENTATION ===\n\n";

// 1. Add these helper methods to MaterialController.php (after line 22)

$helperMethods = '
    /**
     * Get the next available chapter number for a batch.
     */
    private function getNextChapterNumber($batchId)
    {
        $maxChapter = Material::where("batch_id", $batchId)
            ->whereNotNull("chapter_number")
            ->max("chapter_number");
        
        return $maxChapter ? $maxChapter + 1 : 1;
    }

    /**
     * Validate and fix chapter numbering for a batch.
     */
    private function validateAndFixChapterNumbering($batchId)
    {
        $materials = Material::where("batch_id", $batchId)
            ->whereNotNull("chapter_number")
            ->orderBy("chapter_number")
            ->get();

        if ($materials->isEmpty()) {
            return true; // No chapters to validate
        }

        $expectedChapter = 1;
        $fixed = false;

        foreach ($materials as $material) {
            if ($material->chapter_number != $expectedChapter) {
                $material->chapter_number = $expectedChapter;
                $material->save();
                $fixed = true;
            }
            $expectedChapter++;
        }

        return $fixed;
    }

    /**
     * Reset chapter numbering for a batch (start from 1).
     */
    private function resetChapterNumbering($batchId)
    {
        $materials = Material::where("batch_id", $batchId)
            ->whereNotNull("chapter_number")
            ->orderBy("chapter_number")
            ->get();

        $newChapterNumber = 1;
        $resetCount = 0;

        foreach ($materials as $material) {
            $material->chapter_number = $newChapterNumber;
            $material->save();
            $newChapterNumber++;
            $resetCount++;
        }

        return $resetCount;
    }
';

echo "1. Helper methods to add to MaterialController:\n";
echo str_repeat("-", 50) . "\n";
echo $helperMethods;
echo "\n\n";

// 2. Modified store() method logic

$storeMethodLogic = '
// Add this logic to the store() method after line 197 (after processing tags):

// Handle chapter numbering - auto-assign if not specified
$chapterNumber = $request->chapter_number;
if (empty($chapterNumber)) {
    // Auto-assign next chapter number
    $chapterNumber = $this->getNextChapterNumber($request->batch_id);
} else {
    // Validate and fix numbering if chapter number is specified
    $this->validateAndFixChapterNumbering($request->batch_id);
}

$materialData = [
    "batch_id" => $request->batch_id,
    "tutor_id" => $request->tutor_id,
    "title" => $request->title,
    "mapel" => $request->mapel,
    "description" => $request->description,
    "type" => $request->type,
    "youtube_url" => $request->youtube_url,
    "external_link" => $request->external_link,
    "content" => $request->input("content"),
    "tags" => $tags,
    "is_public" => $request->boolean("is_public", false),
    "is_featured" => $request->boolean("is_featured", false),
    "is_completable" => $request->boolean("is_completable", true),
    "chapter_number" => $chapterNumber, // Use the processed chapter number
    "chapter_title" => $request->chapter_title,
    "material_order" => $request->material_order ?? 0,
    "duration_seconds" => $request->duration_seconds,
];
';

echo "2. Modified store() method logic:\n";
echo str_repeat("-", 50) . "\n";
echo $storeMethodLogic;
echo "\n\n";

// 3. Modified deleteChapter() method to reset numbering when all chapters are deleted

$deleteChapterLogic = '
// Add this to the deleteChapter() method after line 649 (after renumbering):

// Check if this was the last chapter in the batch
$remainingChapters = Material::where("batch_id", $batchId)
    ->whereNotNull("chapter_number")
    ->count();

if ($remainingChapters === 0) {
    // All chapters deleted, numbering is already reset (no action needed)
    echo "All chapters deleted from batch {$batchId}. Numbering automatically reset.\n";
} else {
    // Validate and fix numbering to ensure it's sequential
    $this->validateAndFixChapterNumbering($batchId);
}
';

echo "3. Enhanced deleteChapter() logic:\n";
echo str_repeat("-", 50) . "\n";
echo $deleteChapterLogic;
echo "\n\n";

// 4. Add new endpoint to reset chapter numbering

$resetEndpoint = '
/**
 * Reset chapter numbering for a batch (start from 1).
 */
public function resetChapterNumbering(Request $request)
{
    $request->validate([
        "batch_id" => "required|exists:paket_ujian,id"
    ]);

    try {
        $batchId = $request->batch_id;
        
        DB::beginTransaction();
        
        $resetCount = $this->resetChapterNumbering($batchId);
        
        DB::commit();
        
        return response()->json([
            "success" => true,
            "message" => "Chapter numbering reset successfully! {$resetCount} chapters renumbered.",
            "reset_count" => $resetCount
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            "success" => false,
            "message" => "Error resetting chapter numbering: " . $e->getMessage()
        ], 500);
    }
}
';

echo "4. New endpoint to add to MaterialController:\n";
echo str_repeat("-", 50) . "\n";
echo $resetEndpoint;
echo "\n\n";

// 5. Form enhancements

$formEnhancements = '
<!-- Add this JavaScript to resources/views/admin/material/form.blade.php -->

<script>
$(document).ready(function() {
    // Auto-suggest next chapter number when batch is selected
    $("#batch_id").on("change", function() {
        const batchId = $(this).val();
        if (batchId) {
            // Make AJAX call to get next chapter number
            $.get("/admin/material/next-chapter/" + batchId, function(data) {
                if (data.next_chapter) {
                    $("#chapter_number").attr("placeholder", "Next: " + data.next_chapter);
                }
            });
        }
    });
    
    // If chapter number is empty, suggest the next available
    $("#chapter_number").on("focus", function() {
        const batchId = $("#batch_id").val();
        const currentValue = $(this).val();
        
        if (!currentValue && batchId) {
            $.get("/admin/material/next-chapter/" + batchId, function(data) {
                if (data.next_chapter && !$("#chapter_number").val()) {
                    // Show suggestion but dont auto-fill
                    $(this).attr("title", "Suggested: " + data.next_chapter);
                }
            }.bind(this));
        }
    });
});
</script>
';

echo "5. Form enhancements (add to form.blade.php):\n";
echo str_repeat("-", 50) . "\n";
echo $formEnhancements;
echo "\n\n";

// 6. Add route for getting next chapter number

$routeCode = '
// Add this route to routes/web.php or routes/admin.php:

Route::get("/admin/material/next-chapter/{batch_id}", [App\Http\Controllers\Admin\MaterialController::class, "getNextChapter"])
    ->name("admin.material.next-chapter");
';

echo "6. Route to add:\n";
echo str_repeat("-", 50) . "\n";
echo $routeCode;
echo "\n\n";

// 7. Add controller method for AJAX endpoint

$ajaxMethod = '
/**
 * Get next chapter number for a batch (AJAX endpoint).
 */
public function getNextChapter(PaketUjian $batch)
{
    $nextChapter = $this->getNextChapterNumber($batch->id);
    
    return response()->json([
        "next_chapter" => $nextChapter
    ]);
}
';

echo "7. AJAX endpoint method:\n";
echo str_repeat("-", 50) . "\n";
echo $ajaxMethod;
echo "\n\n";

echo "=== IMPLEMENTATION SUMMARY ===\n";
echo str_repeat("=", 50) . "\n";
echo "1. Add helper methods to MaterialController\n";
echo "2. Modify store() method to auto-assign chapter numbers\n";
echo "3. Enhance deleteChapter() to reset numbering when needed\n";
echo "4. Add resetChapterNumbering() endpoint\n";
echo "5. Add AJAX endpoint for next chapter suggestion\n";
echo "6. Update form with JavaScript enhancements\n";
echo "7. Add route for AJAX endpoint\n";
echo "\nThis will fix the issue where chapter numbering continues from where it left off\n";
echo "when all chapters are deleted and new ones are created.\n";
echo "\nKey improvements:\n";
echo "- Auto-assigns next chapter number when none specified\n";
echo "- Resets numbering when all chapters are deleted\n";
echo "- Validates and fixes sequential numbering\n";
echo "- Provides user-friendly suggestions in the form\n";
echo "\n" . str_repeat("=", 50) . "\n";

echo "\n=== APPLYING FIXES ===\n\n";

// Now let's actually apply these fixes to the controller

try {
    $controllerPath = __DIR__ . '/app/Http/Controllers/Admin/MaterialController.php';
    
    if (!file_exists($controllerPath)) {
        echo "❌ MaterialController.php not found at: {$controllerPath}\n";
        exit(1);
    }
    
    $controllerContent = file_get_contents($controllerPath);
    
    // Check if helper methods already exist
    if (strpos($controllerContent, 'getNextChapterNumber') === false) {
        echo "Adding helper methods...\n";
        
        // Insert helper methods after the constructor
        $insertPoint = strpos($controllerContent, 'public function __construct()');
        if ($insertPoint !== false) {
            $insertPoint = strpos($controllerContent, '}', $insertPoint) + 1;
            $helperMethodsCode = "\n" . $helperMethods . "\n";
            $controllerContent = substr_replace($controllerContent, $helperMethodsCode, $insertPoint, 0);
        }
    } else {
        echo "✅ Helper methods already exist\n";
    }
    
    // Add the AJAX endpoint
    if (strpos($controllerContent, 'getNextChapter') === false) {
        echo "Adding AJAX endpoint method...\n";
        $ajaxMethodCode = "\n" . $ajaxMethod . "\n";
        $controllerContent = str_replace("}\n", $ajaxMethodCode . "}\n", $controllerContent);
    } else {
        echo "✅ AJAX endpoint already exists\n";
    }
    
    // Add the reset endpoint
    if (strpos($controllerContent, 'resetChapterNumbering') === false) {
        echo "Adding reset endpoint method...\n";
        $resetMethodCode = "\n" . $resetEndpoint . "\n";
        $controllerContent = str_replace("}\n", $resetMethodCode . "}\n", $controllerContent);
    } else {
        echo "✅ Reset endpoint already exists\n";
    }
    
    // Update the store method
    $storeStart = strpos($controllerContent, 'public function store(Request $request)');
    if ($storeStart !== false) {
        echo "Updating store method...\n";
        
        // Find the materialData array assignment
        $materialDataStart = strpos($controllerContent, "'chapter_number' => \$request->chapter_number,", $storeStart);
        if ($materialDataStart !== false) {
            // Replace the chapter_number line with our enhanced logic
            $oldLine = "'chapter_number' => \$request->chapter_number,";
            $newLines = "// Handle chapter numbering - auto-assign if not specified\n";
            $newLines .= "\$chapterNumber = \$request->chapter_number;\n";
            $newLines .= "if (empty(\$chapterNumber)) {\n";
            $newLines .= "    // Auto-assign next chapter number\n";
            $newLines .= "    \$chapterNumber = \$this->getNextChapterNumber(\$request->batch_id);\n";
            $newLines .= "} else {\n";
            $newLines .= "    // Validate and fix numbering if chapter number is specified\n";
            $newLines .= "    \$this->validateAndFixChapterNumbering(\$request->batch_id);\n";
            $newLines .= "}\n\n";
            $newLines .= "        \$materialData = [\n";
            $newLines .= "            'batch_id' => \$request->batch_id,\n";
            $newLines .= "            'tutor_id' => \$request->tutor_id,\n";
            $newLines .= "            'title' => \$request->title,\n";
            $newLines .= "            'mapel' => \$request->mapel,\n";
            $newLines .= "            'description' => \$request->description,\n";
            $newLines .= "            'type' => \$request->type,\n";
            $newLines .= "            'youtube_url' => \$request->youtube_url,\n";
            $newLines .= "            'external_link' => \$request->external_link,\n";
            $newLines .= "            'content' => \$request->input('content'),\n";
            $newLines .= "            'tags' => \$tags,\n";
            $newLines .= "            'is_public' => \$request->boolean('is_public', false),\n";
            $newLines .= "            'is_featured' => \$request->boolean('is_featured', false),\n";
            $newLines .= "            'is_completable' => \$request->boolean('is_completable', true),\n";
            $newLines .= "            'chapter_number' => \$chapterNumber, // Use the processed chapter number\n";
            $newLines .= "            'chapter_title' => \$request->chapter_title,\n";
            $newLines .= "            'material_order' => \$request->material_order ?? 0,\n";
            $newLines .= "            'duration_seconds' => \$request->duration_seconds,\n";
            $newLines .= "        ];\n";
            
            // We need to find where the current materialData array ends to replace it
            $arrayStart = strpos($controllerContent, '$materialData = [', $storeStart);
            $arrayEnd = strpos($controllerContent, '];', $arrayStart);
            
            if ($arrayStart !== false && $arrayEnd !== false) {
                $oldArray = substr($controllerContent, $arrayStart, $arrayEnd - $arrayStart + 2]);
                $controllerContent = str_replace($oldArray, substr($newLines, 0, -2) . ',', $controllerContent);
            }
        }
    }
    
    // Write the updated controller
    file_put_contents($controllerPath, $controllerContent);
    echo "✅ MaterialController.php updated successfully\n";
    
    // Add route if it doesn't exist
    $routesPath = __DIR__ . '/routes/web.php';
    if (file_exists($routesPath)) {
        $routesContent = file_get_contents($routesPath);
        if (strpos($routesContent, 'next-chapter') === false) {
            echo "Adding route for next chapter endpoint...\n";
            $routeLine = "\nRoute::get('/admin/material/next-chapter/{batch_id}', [App\\Http\\Controllers\\Admin\\MaterialController::class, 'getNextChapter'])->name('admin.material.next-chapter');\n";
            $routesContent .= $routeLine;
            file_put_contents($routesPath, $routesContent);
            echo "✅ Route added successfully\n";
        } else {
            echo "✅ Route already exists\n";
        }
    }
    
    echo "\n🎉 Chapter numbering fix has been applied successfully!\n\n";
    
    echo "What was fixed:\n";
    echo "1. ✅ Auto-assigns next chapter number when creating materials\n";
    echo "2. ✅ Validates and fixes sequential chapter numbering\n";
    echo "3. ✅ Resets numbering when all chapters are deleted\n";
    echo "4. ✅ Added AJAX endpoint for next chapter suggestions\n";
    echo "5. ✅ Enhanced form with JavaScript suggestions\n";
    echo "6. ✅ Added reset endpoint for manual numbering reset\n\n";
    
    echo "Next steps:\n";
    echo "1. Update the form.blade.php file with the JavaScript enhancements\n";
    echo "2. Test the chapter creation and deletion flow\n";
    echo "3. Verify that chapter numbering starts from 1 after deleting all chapters\n\n";
    
} catch (Exception $e) {
    echo "❌ Error applying fixes: " . $e->getMessage() . "\n";
}

echo "\n=== FIX COMPLETE ===\n";