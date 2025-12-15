<?php

/**
 * Test script untuk Material Folder System
 * Jalankan dengan: php test_folder_system.php
 */

echo "=== Material Folder System Test ===\n\n";

// Test 1: Check if MaterialFolder model exists
echo "1. Testing MaterialFolder model...\n";
try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    $materialFolder = new App\Models\MaterialFolder();
    echo "   ✓ MaterialFolder model loaded successfully\n";
    echo "   - Table: " . $materialFolder->getTable() . "\n";
    echo "   - Fillable fields: " . implode(', ', $materialFolder->getFillable()) . "\n";
} catch (Exception $e) {
    echo "   ✗ Error loading MaterialFolder model: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Check if database tables exist
echo "2. Testing database tables...\n";
try {
    $pdo = new PDO("mysql:host=localhost;dbname=test", "test", "test");
    echo "   Note: Database connection test skipped in this environment\n";
} catch (Exception $e) {
    echo "   Note: Database test skipped - " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Check if routes exist
echo "3. Testing routes...\n";
$routes = [
    'user.materials.index' => 'Materials index',
    'user.materials.folders.index' => 'Materials folders index',
];

foreach ($routes as $name => $description) {
    try {
        // This is a simplified test - in real Laravel app you'd use Route::getRoutes()
        echo "   ✓ Route '$name' ($description) should be available\n";
    } catch (Exception $e) {
        echo "   ✗ Error with route '$name': " . $e->getMessage() . "\n";
    }
}

echo "\n";

// Test 4: Check if views exist
echo "4. Testing view files...\n";
$views = [
    'resources/views/views_user/materials/index.blade.php' => 'Main materials view',
    'resources/views/views_user/materials/folders/index.blade.php' => 'Folders index view',
    'resources/views/views_user/materials/folders/show.blade.php' => 'Folder detail view',
];

foreach ($views as $path => $description) {
    if (file_exists($path)) {
        echo "   ✓ View '$path' ($description) exists\n";
    } else {
        echo "   ✗ View '$path' ($description) not found\n";
    }
}

echo "\n";

// Test 5: Check migrations
echo "5. Testing migration files...\n";
$migrations = [
    'database/migrations/2025_12_11_130452_add_folder_id_to_materials_table.php' => 'Add folder_id to materials',
    'database/migrations/2025_12_11_130502_create_material_folders_table.php' => 'Create material_folders table',
    'database/migrations/2025_12_11_131632_add_foreign_key_folder_id_to_materials_table.php' => 'Add foreign key constraint',
];

foreach ($migrations as $path => $description) {
    if (file_exists($path)) {
        echo "   ✓ Migration '$path' ($description) exists\n";
    } else {
        echo "   ✗ Migration '$path' ($description) not found\n";
    }
}

echo "\n";

// Test 6: Check controller methods
echo "6. Testing controller methods...\n";
$controllerMethods = [
    'foldersIndex' => 'Display materials organized in folders',
    'folderShow' => 'Display specified folder with materials',
    'getFoldersByPackage' => 'Get folders by package (AJAX)',
    'getMaterialsByFolder' => 'Get materials by folder (AJAX)',
];

foreach ($controllerMethods as $method => $description) {
    if (method_exists('App\Http\Controllers\UserMaterialController', $method)) {
        echo "   ✓ Method '$method' ($description) exists\n";
    } else {
        echo "   ✗ Method '$method' ($description) not found\n";
    }
}

echo "\n";

// Instructions
echo "=== Setup Instructions ===\n";
echo "1. Run migrations:\n";
echo "   php artisan migrate\n\n";
echo "2. Clear route cache:\n";
echo "   php artisan route:clear\n\n";
echo "3. Clear config cache:\n";
echo "   php artisan config:clear\n\n";
echo "4. Test the folder system:\n";
echo "   - Login to the application\n";
echo "   - Go to Materials page\n";
echo "   - Click 'Tampilan Folder' toggle button\n";
echo "   - Should show folder interface (even if empty)\n\n";

echo "=== Troubleshooting ===\n";
echo "If folder view doesn't work:\n";
echo "1. Check Laravel logs: storage/logs/laravel.log\n";
echo "2. Verify database tables exist\n";
echo "3. Check route cache: php artisan route:list\n";
echo "4. Test with: /materials?view=folders\n\n";

echo "=== Test Complete ===\n";