#!/usr/bin/env php
<?php

// Test routes and basic functionality
define('LARAVEL_START', microtime(true));

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Material;
use App\Models\PaketUjian;

echo "=== TESTING MATERIALS SYSTEM ===\n\n";

// Test 1: Check database connection and models
try {
    echo "1. Testing database connection...\n";
    
    $materialCount = Material::count();
    echo "Materials count: $materialCount\n";
    
    $paketCount = PaketUjian::count();
    echo "Paket ujian count: $paketCount\n";
    
    if ($materialCount > 0) {
        echo "Sample material:\n";
        $material = Material::first();
        echo "  Title: {$material->title}\n";
        echo "  Type: {$material->type}\n";
        echo "  Has batch_id: " . ($material->batch_id ? "Yes" : "No") . "\n";
        echo "  Is public: " . ($material->is_public ? "Yes" : "No") . "\n";
    } else {
        echo "No materials found in database.\n";
    }
    
    if ($paketCount > 0) {
        echo "Sample paket:\n";
        $paket = PaketUjian::first();
        echo "  Name: {$paket->nama}\n";
    } else {
        echo "No paket ujian found.\n";
    }
    
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}

// Test 2: Check routes
echo "\n2. Testing routes...\n";
try {
    $router = app('router');
    $routes = $router->getRoutes();
    
    $integratedRoutes = [];
    $materialRoutes = [];
    
    foreach ($routes as $route) {
        $name = $route->getName();
        $path = $route->getPath();
        
        if ($name && strpos($name, 'integrated') !== false) {
            $integratedRoutes[] = $name;
        }
        
        if (strpos($path, 'material') !== false || (strpos($path, 'materials') !== false)) {
            $materialRoutes[] = $path;
        }
    }
    
    echo "Integrated routes found (" . count($integratedRoutes) . "):\n";
    foreach ($integratedRoutes as $route) {
        echo "  - $route\n";
    }
    
    echo "Material routes found (" . count($materialRoutes) . "):\n";
    foreach ($materialRoutes as $route) {
        echo "  - $route\n";
    }
    
} catch (Exception $e) {
    echo "Routes error: " . $e->getMessage() . "\n";
}

// Test 3: Check if views exist
echo "\n3. Testing views...\n";
$viewsToCheck = [
    'admin.integrated-dashboard',
    'admin.integrated-course-form',
    'admin.material-edit',
    'admin.material.index',
    'admin.material.form'
];

foreach ($viewsToCheck as $view) {
    $exists = view()->exists($view);
    echo "$view: " . ($exists ? "✓ exists" : "✗ missing") . "\n";
}

echo "\n=== END TEST ===\n";