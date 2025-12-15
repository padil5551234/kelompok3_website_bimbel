<?php

/**
 * Chapter Statistics and Overview Script
 * Shows detailed chapter information across all courses
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "📊 Chapter Statistics and Overview Report\n";
echo "========================================\n\n";

try {
    $courses = App\Models\PaketUjian::with('materials')->get();
    $grandTotalMaterials = 0;
    $grandTotalChapters = 0;
    
    foreach ($courses as $course) {
        echo "📚 COURSE: {$course->nama}\n";
        echo "   ID: {$course->id}\n";
        echo "   Price: Rp " . number_format($course->harga) . "\n";
        echo "   Active: " . ($course->is_active ? 'Yes' : 'No') . "\n\n";
        
        $materials = $course->materials;
        $chapters = $materials->groupBy('chapter_number')->sortKeys();
        
        echo "   📊 STATISTICS:\n";
        echo "   - Total Materials: " . $materials->count() . "\n";
        echo "   - Total Chapters: " . $chapters->count() . "\n";
        echo "   - Featured Materials: " . $materials->where('is_featured', true)->count() . "\n";
        echo "   - Public Materials: " . $materials->where('is_public', true)->count() . "\n";
        echo "   - Total Views: " . $materials->sum('views_count') . "\n\n";
        
        echo "   📖 CHAPTER BREAKDOWN:\n";
        foreach ($chapters as $chapterNum => $chapterMaterials) {
            $youtubeCount = $chapterMaterials->where('type', 'youtube')->count();
            $documentCount = $chapterMaterials->where('type', 'document')->count();
            $linkCount = $chapterMaterials->where('type', 'link')->count();
            $videoCount = $chapterMaterials->where('type', 'video')->count();
            
            echo "   Chapter {$chapterNum}: {$chapterMaterials->count()} materials\n";
            echo "   Title: " . ($chapterMaterials->first()->chapter_title ?? 'Untitled') . "\n";
            echo "   Materials Breakdown:\n";
            echo "     - YouTube Videos: {$youtubeCount}\n";
            echo "     - Documents: {$documentCount}\n";
            echo "     - Links: {$linkCount}\n";
            echo "     - Videos: {$videoCount}\n";
            echo "   Featured: " . $chapterMaterials->where('is_featured', true)->count() . "\n";
            echo "   Total Views: " . $chapterMaterials->sum('views_count') . "\n\n";
        }
        
        echo "   🔗 QUICK ACCESS:\n";
        echo "   Edit Course: http://127.0.0.1:8000/admin/integrated/course/{$course->id}/edit\n\n";
        
        $grandTotalMaterials += $materials->count();
        $grandTotalChapters += $chapters->count();
        
        echo str_repeat('-', 60) . "\n\n";
    }
    
    echo "📈 GRAND TOTALS:\n";
    echo "===============\n";
    echo "Total Courses: " . $courses->count() . "\n";
    echo "Total Materials: " . $grandTotalMaterials . "\n";
    echo "Total Chapters: " . $grandTotalChapters . "\n";
    echo "Average Materials per Course: " . round($grandTotalMaterials / $courses->count(), 2) . "\n";
    echo "Average Chapters per Course: " . round($grandTotalChapters / $courses->count(), 2) . "\n\n";
    
    echo "🎯 CHAPTER DISTRIBUTION:\n";
    echo "========================\n";
    
    // Show chapter distribution across all courses
    $allChapters = collect();
    foreach ($courses as $course) {
        $chapterCount = $course->materials->groupBy('chapter_number')->count();
        $allChapters->push($chapterCount);
    }
    
    $chapterDistribution = $allChapters->countBy();
    foreach ($chapterDistribution as $count => $frequency) {
        echo "{$frequency} course(s) have {$count} chapter(s)\n";
    }
    
    echo "\n✅ Chapter statistics report completed!\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}

echo "\n🏁 Report completed!\n";