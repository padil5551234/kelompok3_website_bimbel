<?php

/**
 * Test Script for Chapter-Based Material Display
 * 
 * This script demonstrates the new chapter-based material organization functionality
 * that allows users to view materials organized by chapters instead of multiple courses.
 */

echo "=== Chapter-Based Material Display Test ===\n\n";

// Simulate the chapter grouping logic from the controller
function groupMaterialsByChapters($materials) {
    $chapters = [];
    
    if ($materials->isNotEmpty()) {
        $groupedMaterials = $materials->groupBy(function($item) {
            $chapterNumber = $item->chapter_number ?? 1;
            $chapterTitle = $item->chapter_title ?: 'Bab ' . $chapterNumber;
            return $chapterNumber . '|' . $chapterTitle;
        });

        foreach ($groupedMaterials as $chapterKey => $chapterMaterials) {
            list($chapterNumber, $chapterTitle) = explode('|', $chapterKey, 2);

            $chapters[] = (object) [
                'number' => $chapterNumber,
                'title' => $chapterTitle,
                'materials' => $chapterMaterials->sortBy('material_order'),
                'total_materials' => $chapterMaterials->count(),
                'completed_materials' => rand(0, $chapterMaterials->count()), // Simulated completion
            ];
        }

        // Sort chapters by number
        usort($chapters, function($a, $b) {
            return $a->number <=> $b->number;
        });
    }

    return $chapters;
}

// Sample materials data (simulating database records)
$sampleMaterials = collect([
    (object)[
        'id' => 1,
        'title' => 'Pengantar Aljabar',
        'chapter_number' => 1,
        'chapter_title' => 'Bab 1: Konsep Dasar Aljabar',
        'material_order' => 1,
        'type' => 'youtube',
        'mapel' => 'Matematika',
        'description' => 'Materi pengantar tentang konsep dasar aljabar'
    ],
    (object)[
        'id' => 2,
        'title' => 'Bilangan Bulat dan Operasinya',
        'chapter_number' => 1,
        'chapter_title' => 'Bab 1: Konsep Dasar Aljabar',
        'material_order' => 2,
        'type' => 'document',
        'mapel' => 'Matematika',
        'description' => 'Pelajari tentang bilangan bulat dan operasi matematika'
    ],
    (object)[
        'id' => 3,
        'title' => 'Pengenalan Geometri',
        'chapter_number' => 2,
        'chapter_title' => 'Bab 2: Pengenalan Geometri',
        'material_order' => 1,
        'type' => 'link',
        'mapel' => 'Matematika',
        'description' => 'Materi dasar tentang bangun datar dan ruang'
    ],
    (object)[
        'id' => 4,
        'title' => 'Bangun Datar',
        'chapter_number' => 2,
        'chapter_title' => 'Bab 2: Pengenalan Geometri',
        'material_order' => 2,
        'type' => 'video',
        'mapel' => 'Matematika',
        'description' => 'Materi tentang berbagai jenis bangun datar'
    ],
    (object)[
        'id' => 5,
        'title' => 'Struktur Bahasa Indonesia',
        'chapter_number' => 1,
        'chapter_title' => 'Bab 1: Struktur Bahasa',
        'material_order' => 1,
        'type' => 'youtube',
        'mapel' => 'Bahasa Indonesia',
        'description' => 'Pelajari komponen-komponen dalam bahasa Indonesia'
    ]
]);

echo "Original Materials:\n";
foreach ($sampleMaterials as $material) {
    echo "- {$material->title} (Bab {$material->chapter_number}: {$material->chapter_title})\n";
}

echo "\n" . str_repeat("=", 50) . "\n\n";

// Group materials by chapters
$chapters = groupMaterialsByChapters($sampleMaterials);

echo "Chapter-Based Organization:\n";
echo "==========================\n\n";

foreach ($chapters as $chapter) {
    echo "📚 {$chapter->title}\n";
    echo "   Total Materials: {$chapter->total_materials}\n";
    echo "   Completed: {$chapter->completed_materials}\n";
    echo "   Materials:\n";
    
    foreach ($chapter->materials as $material) {
        $typeIcon = [
            'youtube' => '🎥',
            'video' => '📹',
            'document' => '📄',
            'link' => '🔗'
        ][$material->type] ?? '📎';
        
        echo "   {$typeIcon} {$material->title}\n";
    }
    echo "\n";
}

// Calculate overall progress
$totalMaterials = $sampleMaterials->count();
$totalCompleted = array_sum(array_column($chapters, 'completed_materials'));
$progressPercentage = $totalMaterials > 0 ? round(($totalCompleted / $totalMaterials) * 100, 1) : 0;

echo "📊 Overall Progress: {$totalCompleted}/{$totalMaterials} ({$progressPercentage}%)\n";

echo "\n" . str_repeat("=", 50) . "\n\n";

echo "✅ Benefits of Chapter-Based Display:\n";
echo "1. 📖 Single course view instead of multiple separate courses\n";
echo "2. 🏗️  Clear chapter organization (Bab 1, Bab 2, etc.)\n";
echo "3. 📈 Progress tracking per chapter and overall\n";
echo "4. 🎯 Easy navigation between materials in same chapter\n";
echo "5. 📱 Responsive design with collapsible chapters\n";
echo "6. 🔄 View switcher: Grid, Chapter, and Folder views\n\n";

echo "🚀 New Features Added:\n";
echo "1. ➕ New chapters() method in UserMaterialController\n";
echo "2. 📄 New chapters.blade.php view with chapter-based layout\n";
echo "3. 🔗 Added route for /materials/chapters\n";
echo "4. 🎨 Updated index view with view switcher\n";
echo "5. 📱 Enhanced UI with progress bars and chapter cards\n\n";

echo "💡 Usage:\n";
echo "- Users can now access: /materials?view=chapters\n";
echo "- Or direct: /materials/chapters\n";
echo "- View switcher in main materials page\n\n";

echo "=== Test Complete ===\n";
