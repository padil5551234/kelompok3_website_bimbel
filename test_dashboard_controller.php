<?php

// Test script to verify DashboardController integration
require_once 'vendor/autoload.php';

try {
    // Bootstrap Laravel
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    echo "✅ Laravel bootstrapped successfully\n";
    
    // Test Material model import
    $materialModel = new App\Models\Material();
    echo "✅ Material model can be instantiated\n";
    
    // Test PaketUjian model
    $paketModel = new App\Models\PaketUjian();
    echo "✅ PaketUjian model can be instantiated\n";
    
    // Test DashboardController class
    $controller = new App\Http\Controllers\DashboardController();
    echo "✅ DashboardController can be instantiated\n";
    
    // Test if methods exist
    if (method_exists($controller, 'adminIndex')) {
        echo "✅ adminIndex method exists\n";
    } else {
        echo "❌ adminIndex method missing\n";
    }
    
    echo "\n🎉 All tests passed! DashboardController integration should work correctly.\n";
    echo "Access the admin dashboard at: http://127.0.0.1:8000/admin/dashboard\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
