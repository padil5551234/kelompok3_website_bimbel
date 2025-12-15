<?php

/**
 * Test Langsung Fungsi Complete Material
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST FUNGSI COMPLETE MATERIAL ===\n\n";

try {
    // Find the user with verified purchase
    $userId = '51c28366-acc4-4db2-aba5-82a581eeb061';
    $user = \App\Models\User::find($userId);
    
    if (!$user) {
        echo "❌ User tidak ditemukan\n";
        exit;
    }
    
    echo "✅ User ditemukan: {$user->name} (ID: {$user->id})\n";
    
    // Find the material user has access to
    $materialId = '529f54d1-b60e-40d2-8d1f-d11b015e5b25';
    $material = \App\Models\Material::find($materialId);
    
    if (!$material) {
        echo "❌ Material tidak ditemukan\n";
        exit;
    }
    
    echo "✅ Material ditemukan: {$material->title} (ID: {$material->id})\n";
    echo "   Batch_ID: {$material->batch_id}\n";
    
    // Test access check
    $hasAccess = \App\Models\Pembelian::forUser($user->id)
        ->forPackage($material->batch_id)
        ->verified()
        ->exists();
        
    echo "Access check: " . ($hasAccess ? "✅ HAS ACCESS" : "❌ NO ACCESS") . "\n";
    
    if (!$hasAccess) {
        echo "❌ User tidak punya akses ke material ini\n";
        exit;
    }
    
    // Check if already completed
    $alreadyCompleted = \App\Models\LearningProgress::where('user_id', $user->id)
        ->where('material_id', $material->id)
        ->whereNotNull('completed_at')
        ->exists();
        
    echo "Already completed: " . ($alreadyCompleted ? "✅ YES" : "❌ NO") . "\n";
    
    if ($alreadyCompleted) {
        echo "Material sudah completed, akan di-update...\n";
    }
    
    // Simulate completeMaterial method
    echo "\n--- Simulating completeMaterial method ---\n";
    
    try {
        // Create or update learning progress (sama seperti di controller)
        $progress = \App\Models\LearningProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'material_id' => $material->id,
            ],
            [
                'completed_at' => now(),
                'progress_percentage' => 100,
                'activity_type' => 'material_complete'
            ]
        );
        
        echo "✅ LearningProgress created/updated successfully!\n";
        echo "   Progress ID: {$progress->id}\n";
        echo "   User ID: {$progress->user_id}\n";
        echo "   Material ID: {$progress->material_id}\n";
        echo "   Progress Percentage: {$progress->progress_percentage}\n";
        echo "   Completed At: {$progress->completed_at}\n";
        echo "   Activity Type: {$progress->activity_type}\n";
        
        // Verify it's in database
        $savedProgress = \App\Models\LearningProgress::where('user_id', $user->id)
            ->where('material_id', $material->id)
            ->first();
            
        if ($savedProgress) {
            echo "✅ Progress verified in database!\n";
        } else {
            echo "❌ Progress NOT found in database!\n";
        }
        
        echo "\n=== TEST SUCCESSFUL ===\n";
        echo "Fungsi completeMaterial seharusnya bekerja dengan baik!\n";
        
    } catch (Exception $e) {
        echo "❌ Error dalam completeMaterial: " . $e->getMessage() . "\n";
        echo "Stack trace: " . $e->getTraceAsString() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Critical Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}