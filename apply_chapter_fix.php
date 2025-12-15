<?php

echo "Applying chapter numbering fixes...\n";

$controllerPath = __DIR__ . '/app/Http/Controllers/Admin/MaterialController.php';

if (!file_exists($controllerPath)) {
    echo "❌ MaterialController.php not found\n";
    exit(1);
}

$content = file_get_contents($controllerPath);

// Add helper methods after constructor
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
            return true;
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
';

if (strpos($content, 'getNextChapterNumber') === false) {
    echo "Adding helper methods...\n";
    $content = str_replace('    public function __construct()
    {
        $this->middleware([\'auth\', \'verified\', \'role:admin\']);
    }', '    public function __construct()
    {
        $this->middleware([\'auth\', \'verified\', \'role:admin\']);
    }' . $helperMethods, $content);
} else {
    echo "✅ Helper methods already exist\n";
}

// Add AJAX endpoint method
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

if (strpos($content, 'getNextChapter(PaketUjian $batch)') === false) {
    echo "Adding AJAX endpoint...\n";
    $content = str_replace('    }
}', $ajaxMethod . '    }
}', $content);
} else {
    echo "✅ AJAX endpoint already exists\n";
}

// Update store method to handle chapter numbering
echo "Updating store method...\n";

$oldChapterLine = "'chapter_number' => \$request->chapter_number,";
$newChapterLogic = '// Handle chapter numbering - auto-assign if not specified
        $chapterNumber = $request->chapter_number;
        if (empty($chapterNumber)) {
            // Auto-assign next chapter number
            $chapterNumber = $this->getNextChapterNumber($request->batch_id);
        } else {
            // Validate and fix numbering if chapter number is specified
            $this->validateAndFixChapterNumbering($request->batch_id);
        }

        $materialData = [';
        
$newChapterAssignment = "'chapter_number' => \$chapterNumber,";

if (strpos($content, $oldChapterLine) !== false) {
    // Find the materialData array and replace it
    $materialDataStart = strpos($content, '$materialData = [');
    $materialDataEnd = strpos($content, '];', $materialDataStart);
    
    if ($materialDataStart !== false && $materialDataEnd !== false) {
        $oldMaterialData = substr($content, $materialDataStart, $materialDataEnd - $materialDataStart + 2);
        
        // Build new materialData array
        $newMaterialData = '$materialData = [
            \'batch_id\' => $request->batch_id,
            \'tutor_id\' => $request->tutor_id,
            \'title\' => $request->title,
            \'mapel\' => $request->mapel,
            \'description\' => $request->description,
            \'type\' => $request->type,
            \'youtube_url\' => $request->youtube_url,
            \'external_link\' => $request->external_link,
            \'content\' => $request->input(\'content\'),
            \'tags\' => $tags,
            \'is_public\' => $request->boolean(\'is_public\', false),
            \'is_featured\' => $request->boolean(\'is_featured\', false),
            \'is_completable\' => $request->boolean(\'is_completable\', true),
            \'chapter_number\' => $chapterNumber,
            \'chapter_title\' => $request->chapter_title,
            \'material_order\' => $request->material_order ?? 0,
            \'duration_seconds\' => $request->duration_seconds,
        ];';
        
        $content = str_replace($oldMaterialData, $newMaterialData, $content);
        
        // Add the chapter numbering logic before the materialData assignment
        $chapterLogicPos = strpos($content, '$tags = [];');
        if ($chapterLogicPos !== false) {
            $chapterLogicPos = strpos($content, "\n", $chapterLogicPos) + 1;
            $content = substr_replace($content, "\n        " . $newChapterLogic . "\n", $chapterLogicPos, 0);
        }
    }
}

// Add route for the AJAX endpoint
$routesPath = __DIR__ . '/routes/web.php';
if (file_exists($routesPath)) {
    $routesContent = file_get_contents($routesPath);
    if (strpos($routesContent, 'next-chapter') === false) {
        echo "Adding route...\n";
        $route = "\nRoute::get('/admin/material/next-chapter/{batch_id}', [App\\Http\\Controllers\\Admin\\MaterialController::class, 'getNextChapter'])->name('admin.material.next-chapter');\n";
        $routesContent .= $route;
        file_put_contents($routesPath, $routesContent);
    } else {
        echo "✅ Route already exists\n";
    }
}

// Write the updated controller
file_put_contents($controllerPath, $content);

echo "✅ Chapter numbering fixes applied successfully!\n\n";

echo "What was fixed:\n";
echo "1. ✅ Auto-assigns next chapter number when none specified\n";
echo "2. ✅ Validates and fixes sequential chapter numbering\n";
echo "3. ✅ Added AJAX endpoint for next chapter suggestions\n";
echo "4. ✅ Added route for AJAX endpoint\n\n";

echo "Next steps:\n";
echo "1. Update form.blade.php with JavaScript for suggestions\n";
echo "2. Test the chapter creation and deletion\n";
echo "3. Verify numbering resets to 1 after deleting all chapters\n";

?>