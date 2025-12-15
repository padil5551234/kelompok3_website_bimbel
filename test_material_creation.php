<?php

require_once 'vendor/autoload.php';

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MaterialController;
use App\Models\User;
use App\Models\PaketUjian;

// Test material creation
echo "Testing Material Creation...\n";

// Create a test request
$request = new Request();
$request->merge([
    'batch_id' => 1, // Assuming paket with ID 1 exists
    'tutor_id' => 1, // Assuming tutor with ID 1 exists
    'title' => 'Test Material',
    'mapel' => 'Matematika',
    'description' => 'Test description',
    'type' => 'document',
    'is_public' => true,
    'is_featured' => false,
    'is_completable' => true,
]);

// Create controller instance
$controller = new MaterialController();

// Test the store method
try {
    $response = $controller->store($request);
    echo "Material creation test completed.\n";
    echo "Response: " . $response . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "Test completed.\n";