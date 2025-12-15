<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== SOLUSI MASALAH DUPLIKASI COURSE ===\n\n";

// Berdasarkan analisis, masalahnya adalah:
// 1. Ada multiple materials dengan chapter_number yang sama tapi chapter_title berbeda
// 2. Ini membuat confusion di UI karena user melihat "Bab 1" muncul 2 kali

try {
    // Check current materials yang bermasalah
    echo "1. IDENTIFIKASI MATERIALS YANG BERMASALAH:\n\n";
    
    $materials = DB::table('materials')
        ->leftJoin('paket_ujian', 'materials.batch_id', '=', 'paket_ujian.id')
        ->select('materials.*', 'paket_ujian.nama as batch_name')
        ->orderBy('materials.batch_id')
        ->orderBy('materials.chapter_number')
        ->orderBy('materials.material_order')
        ->get();
        
    // Group by batch then by chapter_number to find conflicts
    $groupedByBatch = $materials->groupBy('batch_id');
    foreach ($groupedByBatch as $batchId => $batchMaterials) {
        echo "Batch {$batchId} ({$batchMaterials->first()->batch_name}):\n";
        
        $chapterGroups = $batchMaterials->groupBy('chapter_number');
        $hasConflict = false;
        
        foreach ($chapterGroups as $chapterNumber => $chapterMaterials) {
            $titles = $chapterMaterials->pluck('chapter_title')->filter()->unique();
            if ($titles->count() > 1) {
                $hasConflict = true;
                echo "  ⚠️  CONFLICT: Chapter {$chapterNumber} has multiple titles:\n";
                foreach ($titles as $title) {
                    echo "     - '{$title}'\n";
                }
                echo "     Materials in this chapter:\n";
                foreach ($chapterMaterials as $material) {
                    echo "     * {$material->title} (ID: {$material->id})\n";
                }
                echo "\n";
            }
        }
        
        if (!$hasConflict) {
            echo "  ✅ No conflicts found\n\n";
        }
    }
    
    // Check if the issue is in dashboard showing same course twice
    echo "2. CEK DASHBOARD LOGIC - PERHATIAN UNTUK DUPLIKASI COURSE:\n\n";
    
    // Simulate dashboard query
    $dashboardQuery = DB::table('paket_ujian')
        ->leftJoin('pembelian', function($join) {
            $join->on('paket_ujian.id', '=', 'pembelian.paket_id')
                 ->where('pembelian.status', '=', 'Sukses');
        })
        ->select('paket_ujian.*', 'pembelian.id as purchase_id')
        ->orderBy('paket_ujian.created_at', 'asc')
        ->get();
        
    echo "Dashboard query result:\n";
    $seenCourses = [];
    foreach ($dashboardQuery as $package) {
        $courseKey = $package->nama . '|' . $package->id;
        if (in_array($courseKey, $seenCourses)) {
            echo "  ⚠️  DUPLICATE: {$package->nama} (ID: {$package->id})\n";
        } else {
            echo "  ✅ {$package->nama} (ID: {$package->id})\n";
            $seenCourses[] = $courseKey;
        }
    }
    echo "\n";
    
    // Check if materials are being shown twice in materials page
    echo "3. CEK MATERIALS PAGE LOGIC:\n\n";
    
    // Simulate materials index query (user with purchases)
    $materialsQuery = DB::table('materials')
        ->leftJoin('paket_ujian', 'materials.batch_id', '=', 'paket_ujian.id')
        ->select('materials.*', 'paket_ujian.nama as batch_name')
        ->whereNotNull('materials.batch_id')
        ->orderBy('materials.created_at', 'desc')
        ->limit(10)
        ->get();
        
    echo "Materials index query result:\n";
    $materialCount = [];
    foreach ($materialsQuery as $material) {
        $batchKey = $material->batch_id . '|' . $material->chapter_number;
        if (!isset($materialCount[$batchKey])) {
            $materialCount[$batchKey] = 0;
        }
        $materialCount[$batchKey]++;
        
        echo "  - {$material->title} (Batch: {$material->batch_name}, Chapter: {$material->chapter_number})\n";
    }
    
    // Check if any chapter appears multiple times
    echo "\nChapter appearance count:\n";
    foreach ($materialCount as $key => $count) {
        list($batchId, $chapterNum) = explode('|', $key);
        echo "  Batch {$batchId}, Chapter {$chapterNum}: {$count} times\n";
    }
    echo "\n";
    
    // SOLUTION: Fix the chapter numbering issue
    echo "4. SOLUSI YANG AKAN DIIMPLEMENTASIKAN:\n\n";
    echo "A. PERBAIKAN CHAPTER NUMBERING:\n";
    echo "   - Ensure each chapter has unique chapter_number within a batch\n";
    echo "   - Renumber chapters if there are conflicts\n";
    echo "   - Keep material_order for ordering within chapters\n\n";
    
    echo "B. PERBAIKAN DASHBOARD:\n";
    echo "   - Ensure each course appears only once\n";
    echo "   - Separate purchased vs available courses\n\n";
    
    echo "C. PERBAIKAN MATERIALS GROUPING:\n";
    echo "   - Use chapter_number + chapter_title for unique grouping\n";
    echo "   - Add debugging logs to trace data flow\n\n";
    
    // Test the fix
    echo "5. TESTING PERBAIKAN:\n\n";
    
    // Get batches with chapter conflicts
    $batchesWithConflicts = [];
    foreach ($groupedByBatch as $batchId => $batchMaterials) {
        $chapterGroups = $batchMaterials->groupBy('chapter_number');
        foreach ($chapterGroups as $chapterNumber => $chapterMaterials) {
            $titles = $chapterMaterials->pluck('chapter_title')->filter()->unique();
            if ($titles->count() > 1) {
                $batchesWithConflicts[] = $batchId;
                break;
            }
        }
    }
    
    if (!empty($batchesWithConflicts)) {
        echo "Batches yang perlu diperbaiki:\n";
        foreach ($batchesWithConflicts as $batchId) {
            echo "  - {$batchId}\n";
        }
        echo "\n";
        
        echo "SOLUSI: Renumber chapters untuk batch-batch ini\n";
        
        foreach ($batchesWithConflicts as $batchId) {
            echo "\nProcessing batch {$batchId}:\n";
            
            $batchMaterials = $materials->where('batch_id', $batchId)
                ->sortBy('created_at');
            
            $currentChapter = 1;
            $processedChapters = [];
            
            foreach ($batchMaterials as $material) {
                // Check if this is a new chapter based on title
                $chapterTitle = $material->chapter_title ?: 'Chapter ' . $material->chapter_number;
                
                if (!in_array($chapterTitle, $processedChapters)) {
                    $processedChapters[] = $chapterTitle;
                    $newChapterNumber = $currentChapter;
                    $currentChapter++;
                } else {
                    // This material belongs to existing chapter
                    $existingChapterIndex = array_search($chapterTitle, $processedChapters);
                    $newChapterNumber = $existingChapterIndex + 1;
                }
                
                echo "  - {$material->title}: Chapter {$material->chapter_number} → Chapter {$newChapterNumber}\n";
                
                // Update the material (simulate)
                // DB::table('materials')->where('id', $material->id)->update(['chapter_number' => $newChapterNumber]);
            }
        }
    } else {
        echo "✅ Tidak ada konflik chapter numbering yang ditemukan\n";
    }
    
    echo "\n=== REKOMENDASI AKHIR ===\n\n";
    echo "1. Jika masalah adalah UI duplication:\n";
    echo "   - Clear browser cache dan application cache\n";
    echo "   - Periksa apakah user mengakses multiple tabs/routes simultaneously\n";
    echo "   - Add unique identifiers untuk each course/chapter display\n\n";
    
    echo "2. Jika masalah adalah chapter numbering:\n";
    echo "   - Implementasi renumbering logic untuk memastikan unique chapter numbers\n";
    echo "   - Add validation untuk mencegah duplicate chapter numbers\n\n";
    
    echo "3. Monitoring:\n";
    echo "   - Add logging untuk track materials grouping\n";
    echo "   - Monitor untuk duplicate course displays\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== ANALISIS SELESAI ===\n";
?>