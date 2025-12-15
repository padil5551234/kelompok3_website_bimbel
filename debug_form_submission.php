<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MaterialController;
use App\Models\PaketUjian;
use App\Models\User;

// Get the first paket and tutor
$paket = PaketUjian::first();
$tutor = User::role('tutor')->first();

if (!$paket || !$tutor) {
    echo "ERROR: Missing paket or tutor data\n";
    exit(1);
}

echo "=== DEBUGGING FORM SUBMISSION ===\n";
echo "Paket: {$paket->nama} (ID: {$paket->id})\n";
echo "Tutor: {$tutor->name} (ID: {$tutor->id})\n\n";

// Test 1: Check if route exists
echo "=== CHECKING ROUTES ===\n";
try {
    $url = route('admin.material.store');
    echo "Route exists: {$url}\n";
} catch (Exception $e) {
    echo "Route error: {$e->getMessage()}\n";
}

// Test 2: Simulate form submission with minimal data
echo "\n=== TESTING MINIMAL FORM SUBMISSION ===\n";
$request = new Request();
$request->merge([
    'batch_id' => $paket->id,
    'tutor_id' => $tutor->id,
    'title' => 'Debug Test Material',
    'type' => 'link',
    'external_link' => 'https://example.com/debug',
]);

// Set AJAX header
$request->headers->set('X-Requested-With', 'XMLHttpRequest');

$controller = new MaterialController();

try {
    $response = $controller->store($request);

    if ($response->getStatusCode() == 200) {
        $data = json_decode($response->getContent(), true);
        if (isset($data['success']) && $data['success']) {
            echo "✅ SUCCESS: Form submission works!\n";
            echo "Response: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
        } else {
            echo "❌ FAILED: " . ($data['message'] ?? 'Unknown error') . "\n";
            if (isset($data['errors'])) {
                echo "Validation Errors:\n";
                foreach ($data['errors'] as $field => $messages) {
                    echo "  {$field}: " . implode(', ', $messages) . "\n";
                }
            }
        }
    } elseif ($response->getStatusCode() == 422) {
        $data = json_decode($response->getContent(), true);
        echo "❌ VALIDATION ERROR (422):\n";
        if (isset($data['errors'])) {
            foreach ($data['errors'] as $field => $messages) {
                echo "  {$field}: " . implode(', ', $messages) . "\n";
            }
        }
    } else {
        echo "❌ HTTP ERROR: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";
    }
} catch (Exception $e) {
    echo "❌ EXCEPTION: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// Test 3: Check if material was created
echo "\n=== VERIFYING MATERIAL CREATION ===\n";
$createdMaterial = \App\Models\Material::where('title', 'Debug Test Material')->first();
if ($createdMaterial) {
    echo "✅ VERIFIED: Material exists in database\n";
    echo "ID: {$createdMaterial->id}\n";
    echo "Title: {$createdMaterial->title}\n";
    echo "Type: {$createdMaterial->type}\n";
    echo "Batch: " . ($createdMaterial->batch ? $createdMaterial->batch->nama : 'NULL') . "\n";
} else {
    echo "❌ VERIFICATION FAILED: Material not found in database\n";
}

echo "\n=== POSSIBLE ISSUES TO CHECK ===\n";
echo "1. CSRF Token: Make sure the form includes @csrf\n";
echo "2. Form Action: Make sure the form has correct action URL\n";
echo "3. JavaScript: Check browser console for JavaScript errors\n";
echo "4. Validation: Check if required fields are filled\n";
echo "5. AJAX Headers: Make sure X-Requested-With header is sent\n";