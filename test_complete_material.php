<?php

// Test script untuk debugging completeMaterial function
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

try {
    echo "=== TESTING COMPLETE MATERIAL FUNCTION ===\n\n";
    
    // Test 1: Check if table structure is correct
    echo "1. Checking database table structure...\n";
    $pdo = new PDO("mysql:host=localhost;dbname=tryout", "root", "");
    
    $stmt = $pdo->query("DESCRIBE learning_progress");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "   Table columns: " . implode(', ', $columns) . "\n";
    
    // Test 2: Check if we have materials
    echo "\n2. Checking materials...\n";
    $stmt = $pdo->query("SELECT id, title, batch_id FROM materials LIMIT 3");
    $materials = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($materials)) {
        echo "   ❌ No materials found in database!\n";
        exit;
    }
    
    echo "   Found " . count($materials) . " materials:\n";
    foreach ($materials as $material) {
        echo "   - ID: {$material['id']}, Title: {$material['title']}, Batch: " . ($material['batch_id'] ?: 'NULL') . "\n";
    }
    
    // Test 3: Check if we have users
    echo "\n3. Checking users...\n";
    $stmt = $pdo->query("SELECT id, email FROM users LIMIT 3");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($users)) {
        echo "   ❌ No users found in database!\n";
        exit;
    }
    
    echo "   Found " . count($users) . " users:\n";
    foreach ($users as $user) {
        echo "   - ID: {$user['id']}, Email: {$user['email']}\n";
    }
    
    // Test 4: Check if we have purchases
    echo "\n4. Checking purchases...\n";
    $stmt = $pdo->query("SELECT user_id, paket_id, status FROM pembelian LIMIT 3");
    $purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "   Found " . count($purchases) . " purchases:\n";
    foreach ($purchases as $purchase) {
        echo "   - User: {$purchase['user_id']}, Package: {$purchase['paket_id']}, Status: {$purchase['status']}\n";
    }
    
    // Test 5: Test direct SQL insert to learning_progress
    echo "\n5. Testing direct SQL insert...\n";
    
    $materialId = $materials[0]['id'];
    $userId = $users[0]['id'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO learning_progress (id, user_id, material_id, activity_type, progress_percentage, completed_at, created_at, updated_at) VALUES (UUID(), ?, ?, 'material_complete', 100, NOW(), NOW(), NOW())");
        $stmt->execute([$userId, $materialId]);
        echo "   ✅ Direct SQL insert successful!\n";
        
        // Verify insert
        $stmt = $pdo->prepare("SELECT * FROM learning_progress WHERE user_id = ? AND material_id = ?");
        $stmt->execute([$userId, $materialId]);
        $progress = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($progress) {
            echo "   ✅ Progress record verified:\n";
            echo "      - ID: {$progress['id']}\n";
            echo "      - User ID: {$progress['user_id']}\n";
            echo "      - Material ID: {$progress['material_id']}\n";
            echo "      - Progress: {$progress['progress_percentage']}%\n";
            echo "      - Completed at: {$progress['completed_at']}\n";
        }
        
    } catch (Exception $e) {
        echo "   ❌ Direct SQL insert failed: " . $e->getMessage() . "\n";
    }
    
    // Test 6: Check if LearningProgress model works
    echo "\n6. Testing LearningProgress model...\n";
    
    try {
        // Clear previous test data
        $pdo->prepare("DELETE FROM learning_progress WHERE user_id = ? AND material_id = ?")->execute([$userId, $materialId]);
        
        // Test Eloquent model
        $progress = new \App\Models\LearningProgress();
        $progress->user_id = $userId;
        $progress->material_id = $materialId;
        $progress->activity_type = 'material_complete';
        $progress->progress_percentage = 100;
        $progress->completed_at = now();
        $progress->save();
        
        echo "   ✅ Eloquent model save successful!\n";
        
        // Verify
        $progressCheck = \App\Models\LearningProgress::where('user_id', $userId)
            ->where('material_id', $materialId)
            ->first();
            
        if ($progressCheck) {
            echo "   ✅ Eloquent record verified:\n";
            echo "      - ID: {$progressCheck->id}\n";
            echo "      - Progress: {$progressCheck->progress_percentage}%\n";
        }
        
    } catch (Exception $e) {
        echo "   ❌ Eloquent model test failed: " . $e->getMessage() . "\n";
        echo "   Stack trace: " . $e->getTraceAsString() . "\n";
    }
    
    echo "\n=== TEST COMPLETED ===\n";
    
} catch (Exception $e) {
    echo "❌ Test failed with error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}