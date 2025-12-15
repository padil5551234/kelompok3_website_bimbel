<?php

// Test materials system debugging script
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== MATERIALS SYSTEM DEBUG ===\n\n";

// Test 1: Check if migrations are up to date
echo "1. Checking migration status...\n";
try {
    $migrator = new Illuminate\Database\Migrations\Migrator(
        app()->make('db'),
        new Illuminate\Filesystem\Filesystem,
        new Illuminate\Support\Facades\Event,
        new Illuminate\Log\LogManager(app())
    );
    $migrator->getRepository()->createRepository();
    echo "Migration repository created successfully.\n";
} catch (Exception $e) {
    echo "Migration error: " . $e->getMessage() . "\n";
}

// Test 2: Check if tables exist
echo "\n2. Checking database tables...\n";
try {
    $db = app()->make('db');
    $pdo = $db->connection()->getPdo();
    
    // Check materials table
    $stmt = $pdo->query("SHOW TABLES LIKE 'materials'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Materials table exists\n";
        
        // Check structure
        $stmt = $pdo->query("DESCRIBE materials");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "  Columns: " . implode(', ', $columns) . "\n";
        
        // Check if there are materials
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM materials");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "  Total materials: " . $count . "\n";
    } else {
        echo "✗ Materials table does not exist\n";
    }
    
    // Check paket_ujian table
    $stmt = $pdo->query("SHOW TABLES LIKE 'paket_ujian'");
    if ($stmt->rowCount() > 0) {
        echo "✓ Paket_ujian table exists\n";
        
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM paket_ujian");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "  Total paket_ujian: " . $count . "\n";
    } else {
        echo "✗ Paket_ujian table does not exist\n";
    }
    
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}

// Test 3: Check Laravel models
echo "\n3. Testing Laravel models...\n";
try {
    $material = new App\Models\Material();
    echo "✓ Material model loaded\n";
    
    $paket = new App\Models\PaketUjian();
    echo "✓ PaketUjian model loaded\n";
    
    // Test query
    $materialCount = App\Models\Material::count();
    echo "Materials via model: " . $materialCount . "\n";
    
    $paketCount = App\Models\PaketUjian::count();
    echo "PaketUjian via model: " . $paketCount . "\n";
    
} catch (Exception $e) {
    echo "Model error: " . $e->getMessage() . "\n";
}

// Test 4: Check if routes exist
echo "\n4. Checking routes...\n";
try {
    $router = app()->make('router');
    
    // Check if integrated course routes exist
    $routes = $router->getRoutes();
    $integratedRoutes = [];
    foreach ($routes as $route) {
        if (strpos($route->getName(), 'integrated') !== false) {
            $integratedRoutes[] = $route->getName();
        }
    }
    
    if (count($integratedRoutes) > 0) {
        echo "✓ Integrated course routes found:\n";
        foreach ($integratedRoutes as $route) {
            echo "  - " . $route . "\n";
        }
    } else {
        echo "✗ No integrated course routes found\n";
    }
    
    // Check if material routes exist
    $materialRoutes = [];
    foreach ($routes as $route) {
        if (strpos($route->getPath(), 'material') !== false) {
            $materialRoutes[] = $route->getPath();
        }
    }
    
    if (count($materialRoutes) > 0) {
        echo "✓ Material routes found:\n";
        foreach ($materialRoutes as $route) {
            echo "  - " . $route . "\n";
        }
    } else {
        echo "✗ No material routes found\n";
    }
    
} catch (Exception $e) {
    echo "Routes error: " . $e->getMessage() . "\n";
}

echo "\n=== END DEBUG ===\n";