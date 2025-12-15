<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "📚 STRUKTUR MATERI PAKET MATEMATIKA DASAR\n";
echo "===========================================\n\n";

$paketId = '4ed59120-6a38-4120-9143-4f6689e35aaa';

try {
    $materials = App\Models\Material::where('batch_id', $paketId)
        ->orderBy('chapter_number')
        ->orderBy('material_order')
        ->get();
    
    $currentChapter = 0;
    $totalMaterials = $materials->count();
    
    echo "📊 TOTAL MATERI: " . $totalMaterials . "\n\n";
    
    foreach ($materials as $material) {
        // Tampilkan header BAB jika berbeda dari sebelumnya
        if ($material->chapter_number != $currentChapter) {
            $currentChapter = $material->chapter_number;
            echo "\n" . str_repeat("=", 50) . "\n";
            echo "📖 " . strtoupper($material->chapter_title) . "\n";
            echo str_repeat("=", 50) . "\n";
        }
        
        // Tampilkan materi
        $typeIcon = '';
        switch ($material->type) {
            case 'youtube':
                $typeIcon = '🎥';
                break;
            case 'document':
                $typeIcon = '📄';
                break;
            case 'link':
                $typeIcon = '🔗';
                break;
            case 'video':
                $typeIcon = '📹';
                break;
            default:
                $typeIcon = '📚';
        }
        
        echo "\n";
        echo "{$typeIcon} [{$material->material_order}] {$material->title}\n";
        echo "   📝 Deskripsi: {$material->description}\n";
        echo "   🎯 Mapel: {$material->mapel}\n";
        
        if ($material->type == 'youtube' && $material->youtube_url) {
            echo "   🔗 Link: {$material->youtube_url}\n";
        }
        
        if ($material->type == 'document' && $material->file_path) {
            echo "   📁 File: {$material->file_path}\n";
        }
        
        if ($material->type == 'link' && $material->external_link) {
            echo "   🌐 URL: {$material->external_link}\n";
        }
        
        echo "   ✅ Publik: " . ($material->is_public ? 'Ya' : 'Tidak') . "\n";
        echo "   ⭐ Unggulan: " . ($material->is_featured ? 'Ya' : 'Tidak') . "\n";
        echo "   🎯 Dapat Ditandai Selesai: " . ($material->is_completable ? 'Ya' : 'Tidak') . "\n";
    }
    
    echo "\n\n" . str_repeat("=", 50) . "\n";
    echo "📊 RINGKASAN PER BAB:\n";
    echo str_repeat("=", 50) . "\n";
    
    // Hitung materi per bab
    $chapterSummary = [];
    foreach ($materials as $material) {
        $chapterKey = $material->chapter_title;
        if (!isset($chapterSummary[$chapterKey])) {
            $chapterSummary[$chapterKey] = 0;
        }
        $chapterSummary[$chapterKey]++;
    }
    
    foreach ($chapterSummary as $chapterTitle => $count) {
        echo "📖 {$chapterTitle}: {$count} materi\n";
    }
    
    echo "\n🎯 STRUKTUR SELESAI!\n";
    echo "Sistem BAB sudah siap digunakan di user interface.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}