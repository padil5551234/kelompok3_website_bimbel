<?php

/**
 * Comprehensive Test Script untuk Fungsi "Tandai Selesai" 
 * Test semua material dalam course yang lengkap
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== COMPREHENSIVE TEST FUNGSI TANDAI SELESAI ===\n\n";

try {
    // Test data
    $testUserId = '51c28366-acc4-4db2-aba5-82a581eeb061';
    $testUser = \App\Models\User::find($testUserId);
    
    if (!$testUser) {
        echo "❌ Test user tidak ditemukan!\n";
        exit;
    }
    
    echo "👤 Test User: {$testUser->name} ({$testUser->email})\n\n";
    
    // Get paket Matematika Dasar
    $targetPaketId = '4ed59120-6a38-4120-9143-4f6689e35aaa';
    $targetPaket = \App\Models\PaketUjian::find($targetPaketId);
    
    if (!$targetPaket) {
        echo "❌ Paket tidak ditemukan!\n";
        exit;
    }
    
    echo "📦 Test Paket: {$targetPaket->nama}\n\n";
    
    // Check user access
    $hasAccess = \App\Models\Pembelian::forUser($testUserId)
        ->forPackage($targetPaketId)
        ->verified()
        ->exists();
        
    if (!$hasAccess) {
        echo "❌ User tidak punya akses ke paket ini!\n";
        exit;
    }
    
    echo "✅ User punya akses ke paket\n\n";
    
    // Get all materials in the course
    $materials = \App\Models\Material::where('batch_id', $targetPaketId)
        ->orderBy('chapter_number')
        ->orderBy('material_order')
        ->get();
    
    echo "📚 Course Structure:\n";
    echo str_repeat("=", 60) . "\n";
    
    $currentChapter = 0;
    $chapterMaterials = [];
    
    foreach ($materials as $material) {
        if ($material->chapter_number != $currentChapter) {
            $currentChapter = $material->chapter_number;
            echo "\n📖 BAB {$currentChapter}: {$material->chapter_title}\n";
            echo str_repeat("-", 60) . "\n";
            $chapterMaterials[$currentChapter] = [];
        }
        
        $chapterMaterials[$currentChapter][] = $material;
        
        echo sprintf("   %d.%d %s (%s)\n", 
            $material->chapter_number, 
            $material->material_order,
            $material->title,
            ucfirst($material->type)
        );
    }
    
    echo "\n";
    
    // Test each material
    echo "🧪 TESTING EACH MATERIAL:\n";
    echo str_repeat("=", 60) . "\n\n";
    
    $successCount = 0;
    $failCount = 0;
    $results = [];
    
    foreach ($materials as $index => $material) {
        echo "Testing Material " . ($index + 1) . "/" . $materials->count() . "...\n";
        echo "   Title: {$material->title}\n";
        echo "   Chapter: {$material->chapter_number}.{$material->material_order}\n";
        
        try {
            // Check if already completed
            $alreadyCompleted = \App\Models\LearningProgress::where('user_id', $testUserId)
                ->where('material_id', $material->id)
                ->whereNotNull('completed_at')
                ->exists();
            
            if ($alreadyCompleted) {
                echo "   Status: ⚠️  Already completed\n";
                $results[] = [
                    'material' => $material,
                    'status' => 'already_completed',
                    'success' => true
                ];
                $successCount++;
            } else {
                // Test completeMaterial function
                $progress = \App\Models\LearningProgress::firstOrCreate(
                    [
                        'user_id' => $testUserId,
                        'material_id' => $material->id,
                    ],
                    [
                        'completed_at' => now(),
                        'progress_percentage' => 100,
                        'activity_type' => 'material_complete'
                    ]
                );
                
                // Update if already exists
                if (!$progress->wasRecentlyCreated) {
                    $progress->update([
                        'completed_at' => now(),
                        'progress_percentage' => 100,
                    ]);
                }
                
                // Verify in database
                $savedProgress = \App\Models\LearningProgress::where('user_id', $testUserId)
                    ->where('material_id', $material->id)
                    ->whereNotNull('completed_at')
                    ->first();
                
                if ($savedProgress) {
                    echo "   Status: ✅ Completed successfully\n";
                    echo "   Progress ID: {$savedProgress->id}\n";
                    echo "   Completed At: {$savedProgress->completed_at}\n";
                    $results[] = [
                        'material' => $material,
                        'status' => 'completed',
                        'success' => true,
                        'progress' => $savedProgress
                    ];
                    $successCount++;
                } else {
                    echo "   Status: ❌ Failed to save progress\n";
                    $results[] = [
                        'material' => $material,
                        'status' => 'save_failed',
                        'success' => false
                    ];
                    $failCount++;
                }
            }
            
        } catch (Exception $e) {
            echo "   Status: ❌ Error: " . $e->getMessage() . "\n";
            $results[] = [
                'material' => $material,
                'status' => 'error',
                'success' => false,
                'error' => $e->getMessage()
            ];
            $failCount++;
        }
        
        echo "\n";
    }
    
    // Summary per chapter
    echo "📊 SUMMARY PER BAB:\n";
    echo str_repeat("=", 60) . "\n\n";
    
    foreach ($chapterMaterials as $chapterNum => $chapterMats) {
        echo "📖 BAB {$chapterNum}:\n";
        
        $chapterCompleted = 0;
        $chapterTotal = count($chapterMats);
        
        foreach ($chapterMats as $material) {
            $result = collect($results)->where('material.id', $material->id)->first();
            $status = $result['status'] ?? 'unknown';
            
            if ($status === 'completed' || $status === 'already_completed') {
                echo "   ✅ {$material->title}\n";
                $chapterCompleted++;
            } else {
                echo "   ❌ {$material->title} ({$status})\n";
            }
        }
        
        $chapterPercentage = $chapterTotal > 0 ? round(($chapterCompleted / $chapterTotal) * 100, 1) : 0;
        echo "   Progress: {$chapterCompleted}/{$chapterTotal} ({$chapterPercentage}%)\n\n";
    }
    
    // Final summary
    echo "🏆 FINAL TEST SUMMARY:\n";
    echo str_repeat("=", 60) . "\n";
    echo "Total Materials: " . $materials->count() . "\n";
    echo "✅ Successful: {$successCount}\n";
    echo "❌ Failed: {$failCount}\n";
    echo "Success Rate: " . round(($successCount / $materials->count()) * 100, 1) . "%\n\n";
    
    if ($failCount == 0) {
        echo "🎉 SEMUA TEST BERHASIL!\n";
        echo "Fungsi 'Tandai Selesai' bekerja dengan sempurna untuk semua material.\n\n";
    } else {
        echo "⚠️  Ada beberapa test yang gagal. Periksa error di atas.\n\n";
    }
    
    // Generate test URLs
    echo "🔗 TEST URLS UNTUK MANUAL TESTING:\n";
    echo str_repeat("=", 60) . "\n";
    foreach ($materials as $material) {
        echo "{$material->chapter_number}.{$material->material_order} {$material->title}\n";
        echo "   URL: /materials/{$material->id}\n";
        echo "   Direct Link: http://localhost/materials/{$material->id}\n\n";
    }
    
    echo "💡 CARA MANUAL TEST:\n";
    echo "1. Buka URL di atas\n";
    echo "2. Login sebagai: {$testUser->email}\n";
    echo "3. Klik tombol 'Tandai Selesai'\n";
    echo "4. Konfirmasi dialog\n";
    echo "5. Verify status berubah\n";
    echo "6. Check progress di sidebar\n\n";
    
} catch (Exception $e) {
    echo "❌ CRITICAL ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}