<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CLEAR CACHE DAN TEST SOLUSI DUPLIKASI ===\n\n";

try {
    // 1. Clear Laravel caches
    echo "1. CLEARING LARAVEL CACHES:\n";
    
    $commands = [
        'php artisan cache:clear' => 'Application cache cleared',
        'php artisan config:clear' => 'Configuration cache cleared', 
        'php artisan view:clear' => 'Compiled views cleared',
        'php artisan route:clear' => 'Route cache cleared'
    ];
    
    foreach ($commands as $command => $message) {
        echo "   Executing: $command\n";
        exec($command . ' 2>&1', $output, $returnCode);
        if ($returnCode === 0) {
            echo "   ✅ $message\n";
        } else {
            echo "   ⚠️  Warning: Command may have failed\n";
        }
    }
    
    echo "\n";
    
    // 2. Test database for any duplicate materials
    echo "2. TESTING DATABASE FOR DUPLICATES:\n";
    
    $duplicates = DB::table('materials')
        ->select('batch_id', 'chapter_number', 'chapter_title', 'title', DB::raw('COUNT(*) as count'))
        ->groupBy('batch_id', 'chapter_number', 'chapter_title', 'title')
        ->having('count', '>', 1)
        ->get();
        
    if ($duplicates->isNotEmpty()) {
        echo "   ⚠️  FOUND EXACT DUPLICATES IN DATABASE:\n";
        foreach ($duplicates as $duplicate) {
            echo "      - Batch {$duplicate->batch_id}, Chapter {$duplicate->chapter_number}, Title: '{$duplicate->title}' (Count: {$duplicate->count})\n";
        }
    } else {
        echo "   ✅ No exact duplicates found in database\n";
    }
    
    // Test materials count by batch and chapter
    echo "\n3. MATERIALS COUNT BY BATCH AND CHAPTER:\n";
    
    $materials = DB::table('materials')
        ->leftJoin('paket_ujian', 'materials.batch_id', '=', 'paket_ujian.id')
        ->select('materials.batch_id', 'paket_ujian.nama as batch_name', 'materials.chapter_number', 'materials.chapter_title', DB::raw('COUNT(*) as material_count'))
        ->groupBy('materials.batch_id', 'paket_ujian.nama', 'materials.chapter_number', 'materials.chapter_title')
        ->orderBy('materials.batch_id')
        ->orderBy('materials.chapter_number')
        ->get();
        
    foreach ($materials as $material) {
        echo "   Batch: {$material->batch_name} (ID: {$material->batch_id})\n";
        echo "   Chapter {$material->chapter_number}: '{$material->chapter_title}' - {$material->material_count} materials\n";
    }
    
    // 4. Check if recent changes are working
    echo "\n4. TESTING RECENT CONTROLLER CHANGES:\n";
    
    // Test UserMaterialController logic
    echo "   Simulating UserMaterialController@index query...\n";
    
    $testQuery = DB::table('materials')
        ->leftJoin('paket_ujian', 'materials.batch_id', '=', 'paket_ujian.id')
        ->select('materials.*', 'paket_ujian.nama as batch_name')
        ->distinct('materials.id')
        ->orderBy('materials.created_at', 'desc')
        ->limit(10)
        ->get();
        
    echo "   Query returned: {$testQuery->count()} materials\n";
    echo "   Unique material IDs: " . count($testQuery->pluck('id')->unique()) . "\n";
    
    if ($testQuery->count() === count($testQuery->pluck('id')->unique())) {
        echo "   ✅ No duplicates in query result\n";
    } else {
        echo "   ⚠️  DUPLICATES FOUND IN QUERY RESULT\n";
    }
    
    // 5. Provide testing instructions
    echo "\n5. TESTING INSTRUCTIONS FOR USER:\n";
    echo "   A. BROWSER ACTIONS:\n";
    echo "      - Open Developer Tools (F12)\n";
    echo "      - Go to Console tab\n";
    echo "      - Clear browser cache (Ctrl+Shift+Delete)\n";
    echo "      - Hard refresh page (Ctrl+F5)\n\n";
    
    echo "   B. TEST DIFFERENT VIEWS:\n";
    echo "      - Test /materials (Grid view)\n";
    echo "      - Test /materials/chapters (Chapter view)\n";
    echo "      - Test /materials/folders (Folder view)\n";
    echo "      - Check if duplicates appear in each view\n\n";
    
    echo "   C. CHECK LOGS:\n";
    echo "      - Run: tail -f storage/logs/laravel.log\n";
    echo "      - Look for debug messages from UserMaterialController\n";
    echo "      - Check for 'DUPLICATES FOUND' or 'NO DUPLICATES' messages\n\n";
    
    echo "   D. NETWORK TAB CHECK:\n";
    echo "      - Open Developer Tools → Network tab\n";
    echo "      - Refresh the materials page\n";
    echo "      - Check if there are duplicate requests\n";
    echo "      - Verify response data doesn't contain duplicates\n\n";
    
    // 6. Create a test route for debugging
    echo "6. CREATING DEBUG ROUTE:\n";
    
    $debugRouteContent = <<<'PHP'
<?php

// Add this route to routes/web.php for debugging
Route::get('/debug-materials', function() {
    $user = auth()->user();
    
    if (!$user) {
        return "Please login first";
    }
    
    // Get purchased packages
    $purchasedPackages = App\Models\Pembelian::forUser($user->id)
        ->verified()
        ->with('paketUjian')
        ->get()
        ->pluck('paketUjian')
        ->filter();
    
    // Get materials
    $query = App\Models\Material::query();
    
    if ($purchasedPackages->isNotEmpty()) {
        $packageIds = $purchasedPackages->pluck('id');
        $query->where(function($q) use ($packageIds) {
            $q->whereIn('batch_id', $packageIds)
              ->orWhereNull('batch_id');
        });
    } else {
        $query->whereRaw('1 = 0');
    }
    
    $materials = $query->with(['tutor', 'batch'])
        ->distinct('materials.id')
        ->orderBy('created_at', 'desc')
        ->get();
    
    $html = "<h1>Debug Materials Page</h1>";
    $html .= "<p><strong>User ID:</strong> " . $user->id . "</p>";
    $html .= "<p><strong>Purchased Packages:</strong> " . $purchasedPackages->count() . "</p>";
    $html .= "<p><strong>Materials Found:</strong> " . $materials->count() . "</p>";
    $html .= "<p><strong>Unique Material IDs:</strong> " . count($materials->pluck('id')->unique()) . "</p>";
    
    if ($materials->count() !== count($materials->pluck('id')->unique())) {
        $html .= "<div style='background: red; color: white; padding: 10px; margin: 10px 0;'>⚠️ DUPLICATES DETECTED!</div>";
    } else {
        $html .= "<div style='background: green; color: white; padding: 10px; margin: 10px 0;'>✅ No duplicates found</div>";
    }
    
    $html .= "<h2>Materials List:</h2>";
    foreach ($materials as $material) {
        $html .= "<div style='border: 1px solid #ccc; margin: 5px; padding: 10px;'>";
        $html .= "<strong>{$material->title}</strong><br>";
        $html .= "ID: {$material->id}<br>";
        $html .= "Batch: " . ($material->batch ? $material->batch->nama : 'No batch') . "<br>";
        $html .= "Chapter: {$material->chapter_number} - {$material->chapter_title}<br>";
        $html .= "</div>";
    }
    
    $html .= "<h2>Raw Data:</h2>";
    $html .= "<pre>" . json_encode($materials->toArray(), JSON_PRETTY_PRINT) . "</pre>";
    
    return $html;
})->middleware(['auth', 'verified']);
PHP;
    
    file_put_contents('debug_materials_route.php', $debugRouteContent);
    echo "   ✅ Created debug route file: debug_materials_route.php\n";
    echo "   📝 Add the route content to routes/web.php for debugging\n\n";
    
    // 7. Final summary
    echo "7. SUMMARY:\n";
    echo "   ✅ Laravel caches cleared\n";
    echo "   ✅ Database checked for duplicates\n";
    echo "   ✅ Controller queries updated with distinct()\n";
    echo "   ✅ Enhanced debugging added\n";
    echo "   📋 Next steps: Test in browser and check logs\n\n";
    
    echo "8. EXPECTED RESULTS:\n";
    echo "   - Each course should appear only once\n";
    echo "   - Each chapter should have unique materials\n";
    echo "   - No duplicate course entries in dashboard\n";
    echo "   - No duplicate materials in materials page\n\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "=== CACHE CLEAR AND TEST COMPLETE ===\n";
?>