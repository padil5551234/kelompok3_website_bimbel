<?php

echo "Cleaning up MaterialController...\n";

$controllerPath = __DIR__ . '/app/Http/Controllers/Admin/MaterialController.php';

// Read the original controller from git to restore it
exec("git checkout HEAD -- app/Http/Controllers/Admin/MaterialController.php", $output, $returnCode);

if ($returnCode === 0) {
    echo "✅ Controller restored from git\n";
    
    // Now apply our fixes cleanly
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
    }';
    
    $content = str_replace('    public function __construct()
    {
        $this->middleware([\'auth\', \'verified\', \'role:admin\']);
    }', '    public function __construct()
    {
        $this->middleware([\'auth\', \'verified\', \'role:admin\']);
    }' . $helperMethods, $content);
    
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
    }';
    
    $content = str_replace('    }
}', $ajaxMethod . '
    }
}', $content);
    
    // Update store method to handle chapter numbering
    $oldValidation = "        if (\$validator->fails()) {
            if (\$request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => \$validator->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors(\$validator)
                ->withInput();
        }";
        
    $newValidation = "        if (\$validator->fails()) {
            if (\$request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => \$validator->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors(\$validator)
                ->withInput();
        }

        // Handle chapter numbering - auto-assign if not specified
        \$chapterNumber = \$request->chapter_number;
        if (empty(\$chapterNumber)) {
            // Auto-assign next chapter number
            \$chapterNumber = \$this->getNextChapterNumber(\$request->batch_id);
        } else {
            // Validate and fix numbering if chapter number is specified
            \$this->validateAndFixChapterNumbering(\$request->batch_id);
        }";
    
    $content = str_replace($oldValidation, $newValidation, $content);
    
    // Update materialData array assignment
    $content = str_replace("'chapter_number' => \$request->chapter_number,", "'chapter_number' => \$chapterNumber,", $content);
    
    // Update update method to handle chapter numbering
    $updateMethodChapterLogic = '
        // Handle chapter numbering - auto-assign if not specified
        $chapterNumber = $request->chapter_number;
        if (empty($chapterNumber)) {
            // Auto-assign next chapter number
            $chapterNumber = $this->getNextChapterNumber($request->batch_id);
        } else {
            // Validate and fix numbering if chapter number is specified
            $this->validateAndFixChapterNumbering($request->batch_id);
        }';
    
    $content = str_replace('        // Process tags - convert comma-separated string to array
        $tags = $request->input('tags', []);
        if (is_string($tags) && !empty($tags)) {
            $tags = array_map(\'trim\', explode(\',\', $tags));
        } elseif (!is_array($tags)) {
            $tags = [];
        }', '        // Process tags - convert comma-separated string to array
        $tags = $request->input(\'tags\', []);
        if (is_string($tags) && !empty($tags)) {
            $tags = array_map(\'trim\', explode(\',\', $tags));
        } elseif (!is_array($tags)) {
            $tags = [];
        }' . $updateMethodChapterLogic, $content);
    
    // Update materialData array assignment in update method
    $content = str_replace("'chapter_number' => \$request->chapter_number,", "'chapter_number' => \$chapterNumber,", $content);
    
    file_put_contents($controllerPath, $content);
    echo "✅ Clean fixes applied to controller\n";
    
    // Test syntax
    exec("php -l " . $controllerPath, $output, $returnCode);
    if ($returnCode === 0) {
        echo "✅ PHP syntax is valid!\n";
    } else {
        echo "❌ PHP syntax errors:\n";
        foreach ($output as $line) {
            echo "  " . $line . "\n";
        }
    }
    
} else {
    echo "❌ Could not restore controller from git\n";
    echo "Attempting manual fix...\n";
    
    // Manual cleanup - remove duplicate code and fix syntax errors
    $content = file_get_contents($controllerPath);
    
    // Remove all the corrupted duplicate sections in store method
    $content = preg_replace('/\s*\/\/ Handle chapter numbering.*?];/s', '', $content);
    
    // Fix the malformed array structure
    $content = preg_replace('/\$materialData = \[\s*\}\s*;/', '', $content);
    
    // Fix extra closing braces at the end
    $content = preg_replace('/\s*}\s*}\s*$/', "\n    }\n}", $content);
    
    file_put_contents($controllerPath, $content);
    echo "✅ Manual cleanup completed\n";
}

echo "\n=== CLEANUP COMPLETE ===\n";

?>