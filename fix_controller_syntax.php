<?php

echo "Fixing MaterialController syntax errors...\n";

$controllerPath = __DIR__ . '/app/Http/Controllers/Admin/MaterialController.php';

if (!file_exists($controllerPath)) {
    echo "❌ Controller file not found\n";
    exit(1);
}

$content = file_get_contents($controllerPath);

// Fix 1: Remove malformed array structure at line 250-251
$malformedArray = '$materialData = [
        }';

$content = str_replace($malformedArray, '', $content);

// Fix 2: Add chapter number handling to update method
$updateMethodChapterLogic = '        // Handle chapter numbering - auto-assign if not specified
        $chapterNumber = $request->chapter_number;
        if (empty($chapterNumber)) {
            // Auto-assign next chapter number
            $chapterNumber = $this->getNextChapterNumber($request->batch_id);
        } else {
            // Validate and fix numbering if chapter number is specified
            $this->validateAndFixChapterNumbering($request->batch_id);
        }

        $materialData = [';

$content = str_replace('        $materialData = [', $updateMethodChapterLogic, $content);

// Fix 3: Remove extra closing brace at the end
$content = preg_replace('/\s*}\s*$/', '    }
}', $content);

// Write the fixed content
file_put_contents($controllerPath, $content);

echo "✅ MaterialController syntax errors fixed!\n\n";

// Test the syntax
echo "Testing PHP syntax...\n";
exec("php -l " . $controllerPath, $output, $returnCode);

if ($returnCode === 0) {
    echo "✅ PHP syntax is valid!\n\n";
} else {
    echo "❌ PHP syntax errors still exist:\n";
    foreach ($output as $line) {
        echo "  " . $line . "\n";
    }
    echo "\n";
}

?>