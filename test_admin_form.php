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

echo "Testing Admin Material Form Submission...\n";
echo "Paket: {$paket->nama} (ID: {$paket->id})\n";
echo "Tutor: {$tutor->name} (ID: {$tutor->id})\n\n";

// Create a test request that simulates AJAX submission
$request = new Request();
$request->merge([
    'batch_id' => $paket->id,
    'tutor_id' => $tutor->id,
    'title' => 'Test Manual Admin Form',
    'mapel' => 'Matematika',
    'description' => 'Test materi yang dibuat melalui form admin manual',
    'type' => 'link',
    'external_link' => 'https://example.com/test-material',
    'is_public' => true,
    'is_featured' => false,
    'is_completable' => true,
    'chapter_number' => 1,
    'chapter_title' => 'Bab 1: Test',
    'material_order' => 1,
    'duration_seconds' => 600,
]);

// Set AJAX header
$request->headers->set('X-Requested-With', 'XMLHttpRequest');

// Create controller instance
$controller = new MaterialController();

// Test the store method
try {
    $response = $controller->store($request);

    if ($response->getStatusCode() == 200) {
        $data = json_decode($response->getContent(), true);
        if (isset($data['success']) && $data['success']) {
            echo "✅ SUCCESS: Material created successfully!\n";
            echo "Response: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
        } else {
            echo "❌ FAILED: " . ($data['message'] ?? 'Unknown error') . "\n";
        }
    } else {
        echo "❌ HTTP ERROR: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";
    }
} catch (Exception $e) {
    echo "❌ EXCEPTION: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== VERIFYING MATERIAL WAS CREATED ===\n";
$createdMaterial = \App\Models\Material::where('title', 'Test Manual Admin Form')->first();
if ($createdMaterial) {
    echo "✅ VERIFIED: Material exists in database\n";
    echo "ID: {$createdMaterial->id}\n";
    echo "Title: {$createdMaterial->title}\n";
    echo "Type: {$createdMaterial->type}\n";
    echo "Batch: " . ($createdMaterial->batch ? $createdMaterial->batch->nama : 'NULL') . "\n";
} else {
    echo "❌ VERIFICATION FAILED: Material not found in database\n";
}