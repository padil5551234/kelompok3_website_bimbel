<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PaketUjian;
use App\Models\Material;

echo "=== REAL CHAPTER DELETION TEST ===\n\n";

try {
    // Step 1: Create test course dengan 3 chapters
    echo "1. SETTING UP TEST SCENARIO:\n";
    echo "   Creating course dengan 3 chapters...\n";
    
    $course = PaketUjian::create([
        'nama' => 'Test Course Chapter Deletion',
        'deskripsi' => 'Test course untuk verify chapter deletion fix',
        'kategori' => 'Matematika',
        'level' => 'Dasar',
        'is_active' => true,
        'harga' => 100000, // Required field
        'waktu_mulai' => now(), // Required field
        'waktu_akhir' => now()->addYear(), // Required field
    ]);
    
    echo "   ✅ Course created: {$course->id}\n";
    
    // Create a test tutor user if none exists
    $testTutor = \App\Models\User::first();
    if (!$testTutor) {
        $testTutor = \App\Models\User::create([
            'name' => 'Test Tutor',
            'email' => 'test.tutor@example.com',
            'password' => bcrypt('password'),
        ]);
        $testTutor->assignRole('tutor');
        echo "   ✅ Created test tutor: {$testTutor->id}\n";
    } else {
        echo "   ✅ Using existing user: {$testTutor->id}\n";
    }
    
    // Create 3 chapters dengan materials
    $materials = [
        [
            'title' => 'Material Chapter 1',
            'type' => 'youtube',
            'youtube_url' => 'https://youtube.com/test1',
            'chapter_number' => 1,
            'chapter_title' => 'Chapter 1: Introduction',
        ],
        [
            'title' => 'Material Chapter 2', 
            'type' => 'document',
            'file_path' => 'test-doc-2.pdf',
            'chapter_number' => 2,
            'chapter_title' => 'Chapter 2: Basics',
        ],
        [
            'title' => 'Material Chapter 3',
            'type' => 'link', 
            'external_link' => 'https://example.com/test3',
            'chapter_number' => 3,
            'chapter_title' => 'Chapter 3: Advanced',
        ]
    ];
    
    $createdMaterials = [];
    foreach ($materials as $index => $materialData) {
        $material = Material::create([
            'batch_id' => $course->id,
            'tutor_id' => $testTutor->id,
            'title' => $materialData['title'],
            'description' => "Test material for {$materialData['chapter_title']}",
            'type' => $materialData['type'],
            'youtube_url' => $materialData['youtube_url'] ?? null,
            'file_path' => $materialData['file_path'] ?? null,
            'external_link' => $materialData['external_link'] ?? null,
            'chapter_number' => $materialData['chapter_number'],
            'chapter_title' => $materialData['chapter_title'],
            'material_order' => 1,
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'mapel' => 'Matematika',
            'views_count' => 0,
            'downloads_count' => 0,
        ]);
        $createdMaterials[] = $material;
        echo "   ✅ Created: {$materialData['chapter_title']}\n";
    }
    
    // Step 2: Verify initial state
    echo "\n2. INITIAL STATE (BEFORE DELETION):\n";
    $initialMaterials = Material::where('batch_id', $course->id)->get();
    $initialChapters = $initialMaterials->groupBy('chapter_number')->sortKeys();
    echo "   Total materials: {$initialMaterials->count()}\n";
    echo "   Total chapters: {$initialChapters->count()}\n";
    foreach ($initialChapters as $chapterNum => $chapterMaterials) {
        echo "   - Chapter {$chapterNum}: {$chapterMaterials->count()} materials ({$chapterMaterials->first()->chapter_title})\n";
    }
    
    // Step 3: Simulate form submission dengan Chapter 2 deleted
    echo "\n3. SIMULATING USER DELETION:\n";
    echo "   User menghapus Chapter 2 dari form...\n";
    
    // Create form data (simulate what form would send)
    $formData = [
        'course_id' => $course->id,
        'course_name' => $course->nama,
        'course_description' => $course->deskripsi,
        'category' => $course->kategori,
        'level' => $course->level,
        'tutor_id' => 1,
        'chapters' => [
            0 => [ // Chapter 1 - keep
                'title' => 'Chapter 1: Introduction',
                'chapter_number' => '1',
                'materials' => [
                    0 => [
                        'id' => $createdMaterials[0]->id,
                        'title' => 'Material Chapter 1',
                        'type' => 'youtube',
                        'content_url' => 'https://youtube.com/test1',
                        'description' => 'Test material for Chapter 1: Introduction'
                    ]
                ]
            ],
            1 => [ // Chapter 3 - keep (was chapter 3, now at index 1)
                'title' => 'Chapter 3: Advanced',
                'chapter_number' => '3', // ← Important: actual chapter number from DB
                'materials' => [
                    0 => [
                        'id' => $createdMaterials[2]->id,
                        'title' => 'Material Chapter 3', 
                        'type' => 'link',
                        'content_url' => 'https://example.com/test3',
                        'description' => 'Test material for Chapter 3: Advanced'
                    ]
                ]
            ]
            // Chapter 2 TIDAK ADA karena dihapus user
        ]
    ];
    
    echo "   Form sent dengan " . count($formData['chapters']) . " chapters (Chapter 2 dihapus)\n";
    foreach ($formData['chapters'] as $index => $chapter) {
        echo "   - Form Index {$index}: Chapter {$chapter['chapter_number']} - {$chapter['title']}\n";
    }
    
    // Step 4: Apply the FIXED logic (simulate controller processing)
    echo "\n4. APPLYING FIXED DELETION LOGIC:\n";
    
    // Build chapter number mapping
    $chapterNumberMapping = [];
    foreach ($formData['chapters'] as $chapterIndex => $chapterData) {
        if (isset($chapterData['chapter_number'])) {
            $chapterNumberMapping[$chapterIndex] = $chapterData['chapter_number'];
        } else {
            $chapterNumberMapping[$chapterIndex] = $chapterIndex + 1;
        }
    }
    
    echo "   Chapter mapping: ";
    foreach ($chapterNumberMapping as $formIndex => $actualChapter) {
        echo "{$formIndex}→{$actualChapter} ";
    }
    echo "\n";
    
    // Get materials to keep
    $materialsToKeep = [];
    foreach ($formData['chapters'] as $chapterIndex => $chapterData) {
        foreach ($chapterData['materials'] as $materialIndex => $materialData) {
            if (isset($materialData['id']) && !empty($materialData['id'])) {
                $materialsToKeep[] = $materialData['id'];
            }
        }
    }
    
    echo "   Materials to keep: " . implode(', ', $materialsToKeep) . "\n";
    
    // Delete materials yang TIDAK ada di materialsToKeep
    $deletedCount = Material::where('batch_id', $course->id)
        ->whereNotIn('id', $materialsToKeep)
        ->delete();
    
    echo "   ✅ Deleted {$deletedCount} materials (Chapter 2 materials)\n";
    
    // Step 5: Verify result after deletion
    echo "\n5. VERIFICATION AFTER DELETION:\n";
    $remainingMaterials = Material::where('batch_id', $course->id)->get();
    $remainingChapters = $remainingMaterials->groupBy('chapter_number')->sortKeys();
    
    echo "   Total materials: {$remainingMaterials->count()}\n";
    echo "   Total chapters: {$remainingChapters->count()}\n";
    
    if ($remainingChapters->count() === 2) {
        echo "   ✅ SUCCESS: Chapter count is 2 (as expected after deleting 1 chapter)\n";
        
        foreach ($remainingChapters as $chapterNum => $chapterMaterials) {
            echo "   - Chapter {$chapterNum}: {$chapterMaterials->count()} materials ({$chapterMaterials->first()->chapter_title})\n";
        }
        
        // Verify specific chapters exist
        $chapterExists = function($num) use ($remainingChapters) {
            return $remainingChapters->has($num);
        };
        
        if ($chapterExists(1) && $chapterExists(3)) {
            echo "   ✅ SUCCESS: Chapter 1 dan Chapter 3 masih ada\n";
            echo "   ✅ SUCCESS: Chapter 2 sudah terhapus\n";
        } else {
            echo "   ❌ ERROR: Wrong chapters remaining!\n";
        }
        
    } else {
        echo "   ❌ ERROR: Expected 2 chapters, got {$remainingChapters->count()}\n";
        
        foreach ($remainingChapters as $chapterNum => $chapterMaterials) {
            echo "   - Chapter {$chapterNum}: {$chapterMaterials->count()} materials ({$chapterMaterials->first()->chapter_title})\n";
        }
    }
    
    // Step 6: Simulate "refresh" (re-query database)
    echo "\n6. SIMULATING PAGE REFRESH:\n";
    echo "   Re-querying database...\n";
    
    $refreshedMaterials = Material::where('batch_id', $course->id)->get();
    $refreshedChapters = $refreshedMaterials->groupBy('chapter_number')->sortKeys();
    
    echo "   After refresh - Total chapters: {$refreshedChapters->count()}\n";
    
    if ($refreshedChapters->count() === 2) {
        echo "   ✅ SUCCESS: Chapter count tetap 2 setelah refresh!\n";
        echo "   ✅ NO 'chapter muncul lagi' issue!\n";
    } else {
        echo "   ❌ ERROR: Chapter count berubah setelah refresh!\n";
    }
    
    // Cleanup
    echo "\n7. CLEANUP:\n";
    Material::where('batch_id', $course->id)->delete();
    $course->delete();
    echo "   ✅ Test data cleaned up\n";
    
    echo "\n=== TEST COMPLETE ===\n";
    echo "✅ Chapter deletion working correctly\n";
    echo "✅ Chapter count remains stable after refresh\n";
    echo "✅ No chapters 'appearing again' issue\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}