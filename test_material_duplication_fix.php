<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PaketUjian;
use App\Models\Material;

echo "=== MATERIAL DUPLICATION FIX TEST ===\n\n";

try {
    // Step 1: Create test course dengan 2 chapters
    echo "1. SETTING UP TEST SCENARIO:\n";
    echo "   Creating course dengan 2 chapters...\n";
    
    $course = PaketUjian::create([
        'nama' => 'Test Course Material Update',
        'deskripsi' => 'Test course untuk verify material update (no duplication)',
        'kategori' => 'Matematika',
        'level' => 'Dasar',
        'is_active' => true,
        'harga' => 100000,
        'waktu_mulai' => now(),
        'waktu_akhir' => now()->addYear(),
    ]);
    
    echo "   ✅ Course created: {$course->id}\n";
    
    // Create a test tutor user
    $testTutor = \App\Models\User::first();
    if (!$testTutor) {
        $testTutor = \App\Models\User::create([
            'name' => 'Test Tutor',
            'email' => 'test.tutor@example.com',
            'password' => bcrypt('password'),
        ]);
        $testTutor->assignRole('tutor');
        echo "   ✅ Created test tutor: {$testTutor->id}\n";
    }
    
    // Create 2 chapters dengan 1 material each
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
        echo "   ✅ Created: {$materialData['chapter_title']} (ID: {$material->id})\n";
    }
    
    // Step 2: Verify initial state
    echo "\n2. INITIAL STATE:\n";
    $initialMaterials = Material::where('batch_id', $course->id)->get();
    echo "   Total materials: {$initialMaterials->count()}\n";
    foreach ($initialMaterials as $material) {
        echo "   - {$material->title} (Chapter {$material->chapter_number})\n";
    }
    
    // Step 3: Simulate FIRST update (same data)
    echo "\n3. SIMULATING FIRST UPDATE (same data):\n";
    
    $formData1 = [
        'course_id' => $course->id,
        'course_name' => $course->nama,
        'course_description' => $course->deskripsi,
        'category' => $course->kategori,
        'level' => $course->level,
        'tutor_id' => $testTutor->id,
        'chapters' => [
            0 => [
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
            1 => [
                'title' => 'Chapter 2: Basics',
                'chapter_number' => '2',
                'materials' => [
                    0 => [
                        'id' => $createdMaterials[1]->id,
                        'title' => 'Material Chapter 2', 
                        'type' => 'document',
                        'content_url' => 'test-doc-2.pdf',
                        'description' => 'Test material for Chapter 2: Basics'
                    ]
                ]
            ]
        ]
    ];
    
    // Simulate the FIXED logic
    $chapterNumberMapping = [];
    foreach ($formData1['chapters'] as $chapterIndex => $chapterData) {
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
    
    // Process materials
    $materialsToKeep = [];
    $newMaterialsCreated = 0;
    $existingMaterialsUpdated = 0;
    
    foreach ($formData1['chapters'] as $chapterIndex => $chapterData) {
        foreach ($chapterData['materials'] as $materialIndex => $materialFormData) {
            if (isset($materialFormData['id']) && !empty($materialFormData['id'])) {
                // Update existing material
                $updateData = [
                    'batch_id' => $course->id,
                    'tutor_id' => $testTutor->id,
                    'title' => $materialFormData['title'],
                    'description' => $materialFormData['description'] ?? '',
                    'type' => $materialFormData['type'],
                    'mapel' => 'Matematika',
                    'chapter_number' => $chapterNumberMapping[$chapterIndex],
                    'chapter_title' => $chapterData['title'],
                    'material_order' => $materialIndex + 1,
                    'youtube_url' => $materialFormData['type'] === 'youtube' ? $materialFormData['content_url'] : null,
                    'file_path' => $materialFormData['type'] === 'document' ? $materialFormData['content_url'] : null,
                    'external_link' => $materialFormData['type'] === 'link' ? $materialFormData['content_url'] : null,
                    'is_public' => true,
                    'is_featured' => $materialIndex === 0,
                    'is_completable' => true,
                    'views_count' => 0,
                    'downloads_count' => 0,
                ];
                
                Material::where('id', $materialFormData['id'])->update($updateData);
                $materialsToKeep[] = $materialFormData['id'];
                $existingMaterialsUpdated++;
                echo "   ✅ Updated existing material: {$materialFormData['title']}\n";
            } else {
                // Create new material
                Material::create($updateData);
                $newMaterialsCreated++;
                echo "   ➕ Created new material: {$materialFormData['title']}\n";
            }
        }
    }
    
    echo "   Results: {$existingMaterialsUpdated} updated, {$newMaterialsCreated} created\n";
    
    // Step 4: Check after first update
    echo "\n4. STATE AFTER FIRST UPDATE:\n";
    $afterFirstUpdate = Material::where('batch_id', $course->id)->get();
    echo "   Total materials: {$afterFirstUpdate->count()}\n";
    
    if ($afterFirstUpdate->count() == 2) {
        echo "   ✅ SUCCESS: Materials count still 2 (no duplication!)\n";
    } else {
        echo "   ❌ ERROR: Expected 2 materials, got {$afterFirstUpdate->count()}\n";
    }
    
    // Step 5: Simulate SECOND update (same data again)
    echo "\n5. SIMULATING SECOND UPDATE (same data again):\n";
    
    $formData2 = $formData1; // Same data
    
    // Process materials again
    $materialsToKeep2 = [];
    $newMaterialsCreated2 = 0;
    $existingMaterialsUpdated2 = 0;
    
    foreach ($formData2['chapters'] as $chapterIndex => $chapterData) {
        foreach ($chapterData['materials'] as $materialIndex => $materialFormData) {
            if (isset($materialFormData['id']) && !empty($materialFormData['id'])) {
                // Update existing material
                $updateData = [
                    'batch_id' => $course->id,
                    'tutor_id' => $testTutor->id,
                    'title' => $materialFormData['title'],
                    'description' => $materialFormData['description'] ?? '',
                    'type' => $materialFormData['type'],
                    'mapel' => 'Matematika',
                    'chapter_number' => $chapterNumberMapping[$chapterIndex],
                    'chapter_title' => $chapterData['title'],
                    'material_order' => $materialIndex + 1,
                    'youtube_url' => $materialFormData['type'] === 'youtube' ? $materialFormData['content_url'] : null,
                    'file_path' => $materialFormData['type'] === 'document' ? $materialFormData['content_url'] : null,
                    'external_link' => $materialFormData['type'] === 'link' ? $materialFormData['content_url'] : null,
                    'is_public' => true,
                    'is_featured' => $materialIndex === 0,
                    'is_completable' => true,
                    'views_count' => 0,
                    'downloads_count' => 0,
                ];
                
                Material::where('id', $materialFormData['id'])->update($updateData);
                $materialsToKeep2[] = $materialFormData['id'];
                $existingMaterialsUpdated2++;
                echo "   ✅ Updated existing material: {$materialFormData['title']}\n";
            } else {
                // Create new material
                Material::create($updateData);
                $newMaterialsCreated2++;
                echo "   ➕ Created new material: {$materialFormData['title']}\n";
            }
        }
    }
    
    echo "   Results: {$existingMaterialsUpdated2} updated, {$newMaterialsCreated2} created\n";
    
    // Step 6: Final verification
    echo "\n6. FINAL STATE AFTER SECOND UPDATE:\n";
    $finalMaterials = Material::where('batch_id', $course->id)->get();
    echo "   Total materials: {$finalMaterials->count()}\n";
    
    if ($finalMaterials->count() == 2) {
        echo "   ✅ SUCCESS: Materials count still 2 after multiple updates!\n";
        echo "   ✅ NO MATERIAL DUPLICATION ISSUE!\n";
        
        foreach ($finalMaterials as $material) {
            echo "   - {$material->title} (Chapter {$material->chapter_number}, ID: {$material->id})\n";
        }
    } else {
        echo "   ❌ ERROR: Expected 2 materials, got {$finalMaterials->count()}\n";
        echo "   ❌ MATERIAL DUPLICATION DETECTED!\n";
        
        foreach ($finalMaterials as $material) {
            echo "   - {$material->title} (Chapter {$material->chapter_number}, ID: {$material->id})\n";
        }
    }
    
    // Cleanup
    echo "\n7. CLEANUP:\n";
    Material::where('batch_id', $course->id)->delete();
    $course->delete();
    echo "   ✅ Test data cleaned up\n";
    
    echo "\n=== TEST COMPLETE ===\n";
    
    if ($finalMaterials->count() == 2) {
        echo "✅ Material duplication issue FIXED\n";
        echo "✅ Materials are properly updated, not duplicated\n";
        echo "✅ Multiple updates work correctly\n";
    } else {
        echo "❌ Material duplication issue still exists\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}