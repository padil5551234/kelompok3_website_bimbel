<?php

/**
 * Test Script untuk Debug Fungsi "Tandai Selesai"
 * Menjalankan diagnosis lengkap terhadap semua komponen yang diperlukan
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== DEBUG FUNGSI TANDAI SELESAI MATERIAL ===\n\n";

try {
    // Bootstrap Laravel
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    echo "✅ Laravel berhasil di-bootstrapping\n\n";

    // 1. Test Database Tables
    echo "1. DATABASE TABLES CHECK:\n";
    echo "-----------------------------\n";
    
    $tables = ['learning_progress', 'pembelian', 'materials', 'users', 'paket_ujian'];
    
    foreach ($tables as $table) {
        $exists = Schema::hasTable($table);
        echo "Table '$table': " . ($exists ? "✅ ADA" : "❌ TIDAK ADA") . "\n";
        
        if ($exists && $table === 'learning_progress') {
            $columns = DB::getSchemaBuilder()->getColumnListing($table);
            echo "   Columns: " . implode(', ', $columns) . "\n";
        }
    }
    
    echo "\n";

    // 2. Test Routes
    echo "2. ROUTES CHECK:\n";
    echo "-----------------------------\n";
    
    $routes = app('router')->getRoutes();
    $completeRouteFound = false;
    
    foreach ($routes as $route) {
        if (strpos($route->uri(), '{material}/complete') !== false) {
            echo "✅ Route ditemukan: " . $route->methods()[0] . " " . $route->uri() . "\n";
            echo "   Name: " . $route->getName() . "\n";
            echo "   Action: " . $route->getActionName() . "\n";
            $completeRouteFound = true;
            break;
        }
    }
    
    if (!$completeRouteFound) {
        echo "❌ Route untuk complete material TIDAK DITEMUKAN\n";
    }
    
    echo "\n";

    // 3. Test Models
    echo "3. MODELS CHECK:\n";
    echo "-----------------------------\n";
    
    try {
        $material = \App\Models\Material::first();
        echo "Material model: " . ($material ? "✅ OK - Total: " . \App\Models\Material::count() . " materials" : "❌ TIDAK ADA MATERIAL") . "\n";
    } catch (Exception $e) {
        echo "❌ Error Material model: " . $e->getMessage() . "\n";
    }
    
    try {
        $user = \App\Models\User::first();
        echo "User model: " . ($user ? "✅ OK - Total: " . \App\Models\User::count() . " users" : "❌ TIDAK ADA USER") . "\n";
    } catch (Exception $e) {
        echo "❌ Error User model: " . $e->getMessage() . "\n";
    }
    
    try {
        $progress = new \App\Models\LearningProgress();
        echo "LearningProgress model: ✅ OK\n";
    } catch (Exception $e) {
        echo "❌ Error LearningProgress model: " . $e->getMessage() . "\n";
    }
    
    echo "\n";

    // 4. Test Controller
    echo "4. CONTROLLER CHECK:\n";
    echo "-----------------------------\n";
    
    try {
        $controller = new \App\Http\Controllers\UserMaterialController();
        echo "UserMaterialController: ✅ Berhasil di-instantiate\n";
        
        // Check if completeMaterial method exists
        if (method_exists($controller, 'completeMaterial')) {
            echo "completeMaterial method: ✅ ADA\n";
        } else {
            echo "completeMaterial method: ❌ TIDAK ADA\n";
        }
    } catch (Exception $e) {
        echo "❌ Error Controller: " . $e->getMessage() . "\n";
    }
    
    echo "\n";

    // 5. Test Data Sample
    echo "5. SAMPLE DATA CHECK:\n";
    echo "-----------------------------\n";
    
    try {
        $materials = \App\Models\Material::take(3)->get();
        echo "Materials sample:\n";
        foreach ($materials as $material) {
            echo "   - ID: {$material->id}, Title: {$material->title}, Batch_ID: " . ($material->batch_id ?? 'NULL') . "\n";
        }
    } catch (Exception $e) {
        echo "❌ Error getting materials: " . $e->getMessage() . "\n";
    }
    
    try {
        $pembelians = \App\Models\Pembelian::where('status_verifikasi', 'Sukses')->take(3)->get();
        echo "Pembelians verified sample:\n";
        foreach ($pembelians as $pembelian) {
            echo "   - User_ID: {$pembelian->user_id}, Paket_ID: {$pembelian->paket_id}, Status: {$pembelian->status_verifikasi}\n";
        }
    } catch (Exception $e) {
        echo "❌ Error getting purchases: " . $e->getMessage() . "\n";
    }
    
    echo "\n";

    // 6. Test LearningProgress Table
    echo "6. LEARNING PROGRESS TABLE TEST:\n";
    echo "-----------------------------\n";
    
    try {
        $progressCount = \App\Models\LearningProgress::count();
        echo "Total learning_progress records: " . $progressCount . "\n";
        
        if ($progressCount > 0) {
            $latestProgress = \App\Models\LearningProgress::latest()->first();
            echo "Latest progress:\n";
            echo "   - User_ID: {$latestProgress->user_id}\n";
            echo "   - Material_ID: {$latestProgress->material_id}\n";
            echo "   - Progress_Percentage: {$latestProgress->progress_percentage}\n";
            echo "   - Completed_At: " . ($latestProgress->completed_at ?? 'NULL') . "\n";
        }
    } catch (Exception $e) {
        echo "❌ Error accessing learning_progress: " . $e->getMessage() . "\n";
    }
    
    echo "\n";

    // 7. Test Pembelian Model Methods
    echo "7. PEMBELIAN MODEL METHODS CHECK:\n";
    echo "-----------------------------\n";
    
    try {
        $user = \App\Models\User::first();
        if ($user) {
            // Test Pembelian::forUser method
            $pembelianForUser = \App\Models\Pembelian::forUser($user->id);
            echo "Pembelian::forUser method: ✅ OK\n";
            
            // Test verified method
            $verifiedPembelian = $pembelianForUser->verified();
            echo "Pembelian::verified method: ✅ OK\n";
            
            // Test pluck paket_id
            $paketIds = $pembelianForUser->verified()->pluck('paket_id');
            echo "Pluck paket_id result: " . $paketIds->toJson() . "\n";
        }
    } catch (Exception $e) {
        echo "❌ Error testing Pembelian methods: " . $e->getMessage() . "\n";
    }
    
    echo "\n";

    // 8. Simulate Complete Material Process
    echo "8. SIMULATE COMPLETE MATERIAL PROCESS:\n";
    echo "-----------------------------\n";
    
    try {
        // Find a user with verified purchase
        $user = \App\Models\User::has('pembelian', function($q) {
            $q->where('status_verifikasi', 'Sukses');
        })->first();
        
        if ($user) {
            echo "✅ Found user with verified purchase: {$user->name} (ID: {$user->id})\n";
            
            // Find material user has access to
            $userPaketIds = \App\Models\Pembelian::forUser($user->id)->verified()->pluck('paket_id')->toArray();
            $material = \App\Models\Material::whereIn('batch_id', $userPaketIds)->first();
            
            if ($material) {
                echo "✅ Found accessible material: {$material->title} (ID: {$material->id})\n";
                
                // Test access check logic
                $hasAccess = \App\Models\Pembelian::forUser($user->id)
                    ->forPackage($material->batch_id)
                    ->verified()
                    ->exists();
                    
                echo "Access check result: " . ($hasAccess ? "✅ HAS ACCESS" : "❌ NO ACCESS") . "\n";
                
                if ($hasAccess) {
                    // Test LearningProgress creation
                    echo "Testing LearningProgress creation...\n";
                    
                    $progress = new \App\Models\LearningProgress([
                        'user_id' => $user->id,
                        'material_id' => $material->id,
                        'progress_percentage' => 100,
                        'completed_at' => now(),
                        'activity_type' => 'material_complete'
                    ]);
                    
                    $progress->save();
                    echo "✅ LearningProgress created successfully! ID: {$progress->id}\n";
                    
                    // Clean up test data
                    $progress->delete();
                    echo "✅ Test data cleaned up\n";
                }
            } else {
                echo "❌ No accessible material found for user\n";
            }
        } else {
            echo "❌ No user with verified purchase found\n";
        }
    } catch (Exception $e) {
        echo "❌ Error in simulation: " . $e->getMessage() . "\n";
        echo "Stack trace: " . $e->getTraceAsString() . "\n";
    }
    
    echo "\n";

    // 9. JavaScript and CSRF Check
    echo "9. FRONTEND CHECK:\n";
    echo "-----------------------------\n";
    
    $viewFile = __DIR__ . '/resources/views/views_user/materials/show.blade.php';
    if (file_exists($viewFile)) {
        $content = file_get_contents($viewFile);
        
        // Check for CSRF token
        if (strpos($content, 'csrf-token') !== false) {
            echo "✅ CSRF token meta tag: DITEMUKAN\n";
        } else {
            echo "❌ CSRF token meta tag: TIDAK DITEMUKAN\n";
        }
        
        // Check for markAsComplete function
        if (strpos($content, 'function markAsComplete') !== false) {
            echo "✅ markAsComplete function: DITEMUKAN\n";
        } else {
            echo "❌ markAsComplete function: TIDAK DITEMUKAN\n";
        }
        
        // Check for fetch call
        if (strpos($content, 'fetch(') !== false && strpos($content, '/complete') !== false) {
            echo "✅ Fetch API call: DITEMUKAN\n";
        } else {
            echo "❌ Fetch API call: TIDAK DITEMUKAN\n";
        }
    } else {
        echo "❌ Material show view file tidak ditemukan\n";
    }
    
    echo "\n";

    echo "=== DIAGNOSIS SELESAI ===\n";
    echo "Periksa hasil di atas untuk mengidentifikasi masalah spesifik.\n";

} catch (Exception $e) {
    echo "❌ CRITICAL ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}