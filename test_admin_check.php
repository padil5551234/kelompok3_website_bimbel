<?php

// Test script untuk cek admin dashboard access
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== ADMIN DASHBOARD CHECK ===\n\n";

// Check if route exists
try {
    $router = app('router');
    $routes = $router->getRoutes()->get('GET');
    
    $adminRoutes = [];
    foreach ($routes as $route) {
        if (strpos($route->uri(), 'admin') !== false) {
            $adminRoutes[] = $route->uri();
        }
    }
    
    echo "Admin Routes Found:\n";
    foreach ($adminRoutes as $route) {
        echo "- /$route\n";
    }
    
} catch (Exception $e) {
    echo "Error checking routes: " . $e->getMessage() . "\n";
}

// Check if user model exists and has role method
try {
    $userModel = new App\Models\User();
    echo "\nUser model methods:\n";
    $methods = get_class_methods($userModel);
    $roleMethods = array_filter($methods, function($method) {
        return strpos($method, 'role') !== false || strpos($method, 'Role') !== false;
    });
    
    foreach ($roleMethods as $method) {
        echo "- $method\n";
    }
    
} catch (Exception $e) {
    echo "Error checking user model: " . $e->getMessage() . "\n";
}

// Check if dashboard controller exists
try {
    $dashboardController = new App\Http\Controllers\DashboardController();
    echo "\nDashboardController methods:\n";
    $methods = get_class_methods($dashboardController);
    foreach ($methods as $method) {
        echo "- $method\n";
    }
    
} catch (Exception $e) {
    echo "Error checking dashboard controller: " . $e->getMessage() . "\n";
}

// Check if view exists
$dashboardView = 'resources/views/admin/dashboard.blade.php';
if (file_exists($dashboardView)) {
    echo "\n✅ Admin dashboard view EXISTS: $dashboardView\n";
} else {
    echo "\n❌ Admin dashboard view MISSING: $dashboardView\n";
}

// Check sidebar views
$adminSidebar = 'resources/views/layouts/admin/sidebar.blade.php';
if (file_exists($adminSidebar)) {
    echo "✅ Admin sidebar view EXISTS: $adminSidebar\n";
} else {
    echo "❌ Admin sidebar view MISSING: $adminSidebar\n";
}

$tutorSidebar = 'resources/views/layouts/tutor/sidebar.blade.php';
if (file_exists($tutorSidebar)) {
    echo "✅ Tutor sidebar view EXISTS: $tutorSidebar\n";
} else {
    echo "❌ Tutor sidebar view MISSING: $tutorSidebar\n";
}

echo "\n=== CHECK COMPLETE ===\n";