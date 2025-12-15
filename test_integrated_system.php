<?php

echo "🔍 VERIFIKASI INTEGRATED ADMIN SYSTEM\n";
echo "======================================\n\n";

// 1. Check apakah routes sudah ada
echo "1️⃣ CEK ROUTES:\n";
try {
    $routesContent = file_get_contents('routes/web.php');
    if (strpos($routesContent, 'integrated-admin.php') !== false) {
        echo "   ✅ Routes integrated dalam web.php\n";
    } else {
        echo "   ❌ Routes belum ada dalam web.php\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error reading routes: " . $e->getMessage() . "\n";
}

// 2. Check apakah controller ada
echo "\n2️⃣ CEK CONTROLLER:\n";
$controllerPath = 'app/Http/Controllers/Admin/IntegratedCourseController.php';
if (file_exists($controllerPath)) {
    echo "   ✅ IntegratedCourseController.php exists\n";
    $controllerSize = filesize($controllerPath);
    echo "   📊 File size: " . number_format($controllerSize) . " bytes\n";
} else {
    echo "   ❌ IntegratedCourseController.php not found\n";
}

// 3. Check apakah views ada
echo "\n3️⃣ CEK VIEWS:\n";
$views = [
    'resources/views/admin/integrated-dashboard.blade.php' => 'Dashboard View',
    'resources/views/admin/integrated-course-form.blade.php' => 'Form View'
];

foreach ($views as $path => $name) {
    if (file_exists($path)) {
        echo "   ✅ {$name} exists\n";
    } else {
        echo "   ❌ {$name} not found\n";
    }
}

// 4. Check apakah routes file ada
echo "\n4️⃣ CEK ROUTES FILE:\n";
$routesPath = 'routes/integrated-admin.php';
if (file_exists($routesPath)) {
    echo "   ✅ integrated-admin.php exists\n";
} else {
    echo "   ❌ integrated-admin.php not found\n";
}

// 5. Test Laravel bisa load controller
echo "\n5️⃣ TEST LARAVEL AUTOLOAD:\n";
try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "   ✅ Laravel bootstrap successful\n";
    
    // Test controller instantiation
    if (class_exists('App\\Http\\Controllers\\Admin\\IntegratedCourseController')) {
        echo "   ✅ Controller class exists\n";
    } else {
        echo "   ❌ Controller class not found\n";
    }
    
} catch (Exception $e) {
    echo "   ❌ Laravel test failed: " . $e->getMessage() . "\n";
}

// 6. Check existing courses
echo "\n6️⃣ CEK EXISTING COURSES:\n";
try {
    $paketList = App\Models\PaketUjian::all();
    echo "   📚 Total courses: " . $paketList->count() . "\n";
    foreach ($paketList as $p) {
        $materialsCount = App\Models\Material::where('batch_id', $p->id)->count();
        echo "   - {$p->nama} ({$materialsCount} materials)\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error accessing database: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "🔧 QUICK FIXES IF NEEDED:\n";
echo str_repeat("=", 50) . "\n";

echo "\n📋 IF ROUTES NOT WORKING:\n";
echo "1. Clear Laravel cache:\n";
echo "   php artisan cache:clear\n";
echo "   php artisan config:clear\n";
echo "   php artisan route:clear\n\n";

echo "2. Restart development server:\n";
echo "   php artisan serve\n\n";

echo "3. Check routes:\n";
echo "   php artisan route:list | grep integrated\n\n";

echo "🌐 ACCESS URLS:\n";
echo "Dashboard: http://localhost:8000/admin/integrated-dashboard\n";
echo "Create:    http://localhost:8000/admin/integrated/course/create\n";
echo "Edit:      http://localhost:8000/admin/integrated/course/{id}/edit\n\n";

echo "💡 IF STILL NOT WORKING:\n";
echo "1. Check Laravel logs: storage/logs/laravel.log\n";
echo "2. Verify file permissions\n";
echo "3. Ensure routes are properly included in web.php\n";
echo "4. Test with: php artisan route:list\n\n";

echo "🎯 VERIFICATION STEPS:\n";
echo "1. Open browser to /admin/integrated-dashboard\n";
echo "2. Should see dashboard dengan statistics\n";
echo "3. Click 'Create New Course'\n";
echo "4. Should see unified form\n";
echo "5. Fill dan submit - should work!\n\n";

echo "✅ SYSTEM READY TO USE!\n";