<?php

// Test endpoint completeMaterial secara manual
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

try {
    echo "=== TESTING COMPLETE MATERIAL ENDPOINT ===\n\n";
    
    // Test 1: Get CSRF token
    echo "1. Testing CSRF Token Generation...\n";
    $request = Illuminate\Http\Request::create('/materials/529f54d1-b60e-40d2-8d1f-d11b015e5b25/complete', 'POST');
    $request->headers->set('X-CSRF-TOKEN', csrf_token());
    $request->headers->set('Accept', 'application/json');
    $request->headers->set('Content-Type', 'application/json');
    
    echo "   CSRF Token: " . csrf_token() . "\n";
    echo "   ✅ CSRF Token generated successfully\n\n";
    
    // Test 2: Simulate authenticated user
    echo "2. Testing with Simulated Authentication...\n";
    
    // Create a mock user
    $user = new App\Models\User();
    $user->id = '51c28366-acc4-4db2-aba5-82a581eeb061'; // User yang ada di DB
    $user->email = 'padilzaki73@gmail.com';
    
    // Login the user (simulate)
    Auth::login($user);
    echo "   User ID: " . Auth::id() . "\n";
    echo "   User Email: " . Auth::user()->email . "\n";
    echo "   ✅ User authenticated\n\n";
    
    // Test 3: Test the controller method directly
    echo "3. Testing Controller Method Directly...\n";
    
    try {
        // Get the material
        $material = App\Models\Material::find('529f54d1-b60e-40d2-8d1f-d11b015e5b25');
        
        if (!$material) {
            throw new Exception('Material not found');
        }
        
        echo "   Material ID: " . $material->id . "\n";
        echo "   Material Title: " . $material->title . "\n";
        echo "   Material Batch ID: " . $material->batch_id . "\n";
        
        // Create a request object
        $request = new Illuminate\Http\Request();
        $request->setMethod('POST');
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Content-Type', 'application/json');
        
        // Call the controller method
        $controller = new App\Http\Controllers\UserMaterialController();
        
        // Use reflection to call the private method
        $reflection = new ReflectionClass($controller);
        $method = $reflection->getMethod('completeMaterial');
        $method->setAccessible(true);
        
        $response = $method->invoke($controller, $request, $material);
        
        echo "   ✅ Controller method executed successfully\n";
        echo "   Response: " . $response->getContent() . "\n";
        
        // Check if the response is successful
        $responseData = json_decode($response->getContent(), true);
        if ($responseData && isset($responseData['success']) && $responseData['success']) {
            echo "   ✅ Material marked as complete successfully!\n";
        } else {
            echo "   ❌ Failed to mark material as complete\n";
            if (isset($responseData['message'])) {
                echo "   Error: " . $responseData['message'] . "\n";
            }
        }
        
    } catch (Exception $e) {
        echo "   ❌ Controller method failed: " . $e->getMessage() . "\n";
        echo "   Stack trace: " . $e->getTraceAsString() . "\n";
    }
    
    // Test 4: Check database for progress record
    echo "\n4. Checking Database for Progress Record...\n";
    
    try {
        $progress = \App\Models\LearningProgress::where('user_id', Auth::id())
            ->where('material_id', '529f54d1-b60e-40d2-8d1f-d11b015e5b25')
            ->first();
            
        if ($progress) {
            echo "   ✅ Progress record found:\n";
            echo "      - ID: " . $progress->id . "\n";
            echo "      - User ID: " . $progress->user_id . "\n";
            echo "      - Material ID: " . $progress->material_id . "\n";
            echo "      - Progress: " . $progress->progress_percentage . "%\n";
            echo "      - Completed at: " . $progress->completed_at . "\n";
        } else {
            echo "   ❌ No progress record found in database\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Database check failed: " . $e->getMessage() . "\n";
    }
    
    echo "\n=== TEST COMPLETED ===\n";
    
} catch (Exception $e) {
    echo "❌ Test failed with error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}