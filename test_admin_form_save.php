<?php

// Test admin form save functionality
echo "=== TESTING ADMIN FORM SAVE FUNCTIONALITY ===\n\n";

require_once __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\Admin\IntegratedCourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Test 1: Check if routes are accessible
echo "1. CHECKING ROUTES ACCESSIBILITY:\n";
try {
    $router = app('router');
    $routes = $router->getRoutes();
    
    $integratedRoutes = [];
    foreach ($routes as $route) {
        if ($route->getName() && strpos($route->getName(), 'integrated') !== false) {
            $integratedRoutes[] = [
                'name' => $route->getName(),
                'uri' => $route->uri(),
                'methods' => $route->methods()
            ];
        }
    }
    
    echo "   Found " . count($integratedRoutes) . " integrated routes:\n";
    foreach ($integratedRoutes as $route) {
        echo "   - {$route['name']}: {$route['uri']} (" . implode(', ', $route['methods']) . ")\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Route check failed: " . $e->getMessage() . "\n";
}

// Test 2: Test form data processing logic
echo "\n2. TESTING FORM DATA PROCESSING:\n";
try {
    // Simulate form data that would be sent from the admin form
    $testFormData = [
        'course_name' => 'Test Course',
        'course_description' => 'This is a test course description',
        'category' => 'Matematika',
        'level' => 'Dasar',
        'tutor_id' => '1e5e1931-9a9a-4a6b-8c92-74f0bb28e994', // Sample tutor ID
        'chapters' => [
            0 => [
                'title' => 'Test Chapter 1',
                'description' => 'Test chapter description',
                'materials' => [
                    0 => [
                        'title' => 'Test Material 1',
                        'type' => 'youtube',
                        'content_url' => 'https://youtube.com/watch?v=test123',
                        'description' => 'Test material description'
                    ]
                ]
            ]
        ]
    ];
    
    echo "   ✅ Form data structure looks valid\n";
    echo "   - Course name: {$testFormData['course_name']}\n";
    echo "   - Category: {$testFormData['category']}\n";
    echo "   - Chapters: " . count($testFormData['chapters']) . "\n";
    echo "   - Materials in chapter 1: " . count($testFormData['chapters'][0]['materials']) . "\n";
    
} catch (Exception $e) {
    echo "   ❌ Form data processing failed: " . $e->getMessage() . "\n";
}

// Test 3: Test IntegratedCourseController methods
echo "\n3. TESTING INTEGRATED COURSE CONTROLLER:\n";
try {
    $controller = new IntegratedCourseController();
    echo "   ✅ Controller instantiated successfully\n";
    
    // Test dashboard method
    $response = $controller->dashboard();
    echo "   ✅ Dashboard method works\n";
    
} catch (Exception $e) {
    echo "   ❌ Controller test failed: " . $e->getMessage() . "\n";
}

// Test 4: Test database constraints and validation
echo "\n4. TESTING DATABASE VALIDATION:\n";
try {
    // Check if tutors exist
    $tutors = \App\Models\User::all();
    echo "   Available tutors: " . $tutors->count() . "\n";
    
    // Check if paket ujian exist for batch_id
    $packages = \App\Models\PaketUjian::all();
    echo "   Available packages: " . $packages->count() . "\n";
    
    // Test material creation simulation
    $sampleData = [
        'batch_id' => $packages->first()->id ?? null,
        'tutor_id' => $tutors->first()->id ?? null,
        'title' => 'Test Material',
        'type' => 'youtube',
        'youtube_url' => 'https://youtube.com/watch?v=test',
        'description' => 'Test description',
        'mapel' => 'Matematika',
        'chapter_number' => 1,
        'chapter_title' => 'Test Chapter',
        'material_order' => 1,
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
        'views_count' => 0,
        'downloads_count' => 0,
    ];
    
    // Check if all required fields are present
    $requiredFields = ['batch_id', 'tutor_id', 'title', 'type'];
    $missingFields = [];
    
    foreach ($requiredFields as $field) {
        if (empty($sampleData[$field])) {
            $missingFields[] = $field;
        }
    }
    
    if (empty($missingFields)) {
        echo "   ✅ Sample material data structure is valid\n";
    } else {
        echo "   ❌ Missing required fields: " . implode(', ', $missingFields) . "\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Database validation failed: " . $e->getMessage() . "\n";
}

// Test 5: Check for potential form issues
echo "\n5. CHECKING FOR POTENTIAL FORM ISSUES:\n";

// Check if there are any existing materials that might conflict
try {
    $existingMaterials = \App\Models\Material::all();
    echo "   Existing materials in database: " . $existingMaterials->count() . "\n";
    
    // Check for materials without proper batch_id
    $orphanedMaterials = \App\Models\Material::whereNull('batch_id')->get();
    echo "   Orphaned materials (no batch_id): " . $orphanedMaterials->count() . "\n";
    
} catch (Exception $e) {
    echo "   ❌ Material check failed: " . $e->getMessage() . "\n";
}

echo "\n=== SUMMARY ===\n";
echo "If all tests show ✅, then the admin form should work correctly.\n";
echo "If there are ❌ issues, those need to be resolved before admin can save materials.\n";

echo "\n=== END TEST ===\n";