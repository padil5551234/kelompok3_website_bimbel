<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ANALISIS MASALAH DUPLIKASI COURSE ===\n\n";

// 1. Check all routes that might show materials
echo "1. MEMERIKSA ROUTES YANG MUNGKIN MENAMPILKAN MATERIALS:\n";
echo "   - /materials (UserMaterialController@index)\n";
echo "   - /materials/chapters (UserMaterialController@chapters)\n";
echo "   - /materials/folders (UserMaterialController@foldersIndex)\n";
echo "   - /materials-test (Test route)\n\n";

// 2. Check database for materials by different grouping
echo "2. MEMERIKSA DATA MATERIALS DENGAN PENGELOMPOKAN BERBEDA:\n\n";

try {
    // Get all materials with their batch info
    $materials = DB::table('materials')
        ->leftJoin('paket_ujian', 'materials.batch_id', '=', 'paket_ujian.id')
        ->select('materials.*', 'paket_ujian.nama as batch_name')
        ->orderBy('materials.batch_id')
        ->orderBy('materials.chapter_number')
        ->orderBy('materials.material_order')
        ->get();
        
    if ($materials->isEmpty()) {
        echo "   ⚠️  TIDAK ADA MATERIALS DI DATABASE\n";
        exit;
    }
    
    // Group by different criteria to find potential duplicates
    $groupedByBatch = $materials->groupBy('batch_id');
    echo "   Materials grouped by batch_id:\n";
    foreach ($groupedByBatch as $batchId => $batchMaterials) {
        echo "   Batch {$batchId} ({$batchMaterials->first()->batch_name}): " . $batchMaterials->count() . " materials\n";
        
        // Further group by chapter
        $groupedByChapter = $batchMaterials->groupBy(function($m) {
            return $m->chapter_number . '|' . ($m->chapter_title ?: 'No Title');
        });
        
        foreach ($groupedByChapter as $chapterKey => $chapterMaterials) {
            list($chapterNum, $chapterTitle) = explode('|', $chapterKey, 2);
            echo "     - Chapter {$chapterNum}: '{$chapterTitle}' - " . $chapterMaterials->count() . " materials\n";
            
            foreach ($chapterMaterials as $material) {
                echo "       * {$material->title} (ID: {$material->id})\n";
            }
        }
        echo "\n";
    }
    
    // 3. Check for potential issues in grouping logic
    echo "3. MEMERIKSA POTENTIAL ISSUES DALAM GROUPING LOGIC:\n\n";
    
    $potentialIssues = [];
    
    // Check for null chapter_title
    $nullChapterTitles = $materials->whereNull('chapter_title');
    if ($nullChapterTitles->isNotEmpty()) {
        $potentialIssues[] = "Materials dengan chapter_title NULL";
        echo "   ⚠️  Materials dengan chapter_title NULL:\n";
        foreach ($nullChapterTitles as $material) {
            echo "      - {$material->title} (Batch: {$material->batch_id}, Chapter: {$material->chapter_number})\n";
        }
        echo "\n";
    }
    
    // Check for duplicate chapter titles within same batch
    foreach ($groupedByBatch as $batchId => $batchMaterials) {
        $chapterTitles = $batchMaterials->pluck('chapter_title')->filter()->values();
        $titleCounts = $chapterTitles->countBy();
        $duplicates = $titleCounts->filter(fn($count) => $count > 1);
        
        if ($duplicates->isNotEmpty()) {
            $potentialIssues[] = "Duplicate chapter titles in batch {$batchId}";
            echo "   ⚠️  Duplicate chapter titles in batch {$batchId}:\n";
            foreach ($duplicates as $title => $count) {
                echo "      - '{$title}' appears {$count} times\n";
            }
            echo "\n";
        }
    }
    
    // Check for materials with same chapter_number but different titles
    foreach ($groupedByBatch as $batchId => $batchMaterials) {
        $chapterGroups = $batchMaterials->groupBy('chapter_number');
        foreach ($chapterGroups as $chapterNumber => $chapterMaterials) {
            $titles = $chapterMaterials->pluck('chapter_title')->filter()->unique();
            if ($titles->count() > 1) {
                $potentialIssues[] = "Chapter {$chapterNumber} in batch {$batchId} has different titles";
                echo "   ⚠️  Chapter {$chapterNumber} in batch {$batchId} has different titles:\n";
                foreach ($titles as $title) {
                    echo "      - '{$title}'\n";
                }
                echo "\n";
            }
        }
    }
    
    if (empty($potentialIssues)) {
        echo "   ✅ TIDAK ADA POTENTIAL ISSUES DITEMUKAN\n\n";
    }
    
    // 4. Simulate UserMaterialController logic
    echo "4. SIMULASI LOGIC UserMaterialController:\n\n";
    
    // Simulate index method
    echo "   A. Simulating index() method:\n";
    $indexQuery = DB::table('materials')
        ->leftJoin('paket_ujian', 'materials.batch_id', '=', 'paket_ujian.id')
        ->select('materials.*', 'paket_ujian.nama as batch_name')
        ->orderBy('materials.created_at', 'desc')
        ->limit(20)
        ->get();
    
    echo "      Query result: " . $indexQuery->count() . " materials\n";
    foreach ($indexQuery->take(5) as $material) {
        echo "      - {$material->title} (Batch: {$material->batch_name})\n";
    }
    echo "\n";
    
    // Simulate chapters method
    echo "   B. Simulating chapters() method:\n";
    $chaptersQuery = DB::table('materials')
        ->leftJoin('paket_ujian', 'materials.batch_id', '=', 'paket_ujian.id')
        ->select('materials.*', 'paket_ujian.nama as batch_name')
        ->orderBy('materials.chapter_number', 'asc')
        ->orderBy('materials.material_order', 'asc')
        ->orderBy('materials.created_at', 'asc')
        ->get();
    
    echo "      Query result: " . $chaptersQuery->count() . " materials\n";
    
    // Group by chapter (simulate UserMaterialController logic)
    $groupedMaterials = $chaptersQuery->groupBy(function($item) {
        $chapterNumber = $item->chapter_number ?? 1;
        $chapterTitle = $item->chapter_title ?: 'Bab ' . $chapterNumber;
        return $chapterNumber . '|' . $chapterTitle;
    });
    
    echo "      Grouped chapters: " . $groupedMaterials->count() . " chapters\n";
    foreach ($groupedMaterials as $chapterKey => $chapterMaterials) {
        list($chapterNumber, $chapterTitle) = explode('|', $chapterKey, 2);
        echo "      - Chapter {$chapterNumber}: '{$chapterTitle}' - " . $chapterMaterials->count() . " materials\n";
    }
    echo "\n";
    
    // 5. Check if the issue is in view rendering
    echo "5. ANALISIS VIEW RENDERING:\n\n";
    echo "   Possible causes for duplication:\n";
    echo "   A. Multiple views showing same data\n";
    echo "      - index.blade.php (Grid view)\n";
    echo "      - chapters.blade.php (Chapter view)\n";
    echo "      - folders/index.blade.php (Folder view)\n";
    echo "   B. JavaScript duplication\n";
    echo "   C. Route conflicts\n";
    echo "   D. Caching issues\n\n";
    
    // 6. Recommendations
    echo "6. REKOMENDASI SOLUSI:\n\n";
    echo "   A. Jika masalah adalah tampilan duplikat di UI:\n";
    echo "      - Periksa apakah user mengakses multiple views simultaneously\n";
    echo "      - Clear browser cache dan application cache\n";
    echo "      - Periksa JavaScript console untuk errors\n\n";
    
    echo "   B. Jika masalah adalah logic controller:\n";
    echo "      - Pastikan query distinct() ditambahkan jika perlu\n";
    echo "      - Periksa eager loading untuk menghindari N+1 queries\n";
    echo "      - Validasi grouping logic tidak menghasilkan duplikasi\n\n";
    
    echo "   C. Testing yang bisa dilakukan:\n";
    echo "      - Akses /materials dan /materials/chapters secara terpisah\n";
    echo "      - Check network tab untuk melihat apakah ada duplicate requests\n";
    echo "      - Add debugging logs di controller untuk trace data flow\n\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "=== ANALISIS SELESAI ===\n";
?>