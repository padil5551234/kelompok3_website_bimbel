<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

// Simulate admin login
$user = \App\Models\User::first(); // Get first user as admin
\Auth::login($user);

echo "Testing admin material creation...\n";

// Get first batch and tutor
$batch = \App\Models\PaketUjian::first();
$tutor = \App\Models\User::first();

if (!$batch || !$tutor) {
    echo "Batch or tutor not found\n";
    exit(1);
}

echo "Using batch: {$batch->nama} (ID: {$batch->id})\n";
echo "Using tutor: {$tutor->name} (ID: {$tutor->id})\n";

// Create request data
$requestData = [
    'batch_id' => $batch->id,
    'tutor_id' => $tutor->id,
    'title' => 'Test Admin Material Creation',
    'mapel' => 'Matematika',
    'description' => 'Test description for admin material creation',
    'type' => 'youtube',
    'youtube_url' => 'https://youtube.com/watch?v=testadmincreation',
    'is_public' => '1',
    'is_featured' => '0',
    'is_completable' => '1',
    'chapter_number' => '1',
    'chapter_title' => 'Bab 1: Test Admin Creation',
    'material_order' => '1',
    'duration_seconds' => '1800',
    'tags' => ['test', 'admin', 'creation']
];

try {
    // Create request instance
    $request = new Request();
    $request->merge($requestData);

    // Create controller instance
    $controller = new \App\Http\Controllers\Admin\MaterialController();

    // Call store method
    $response = $controller->store($request);

    echo "Material creation successful!\n";
    echo "Response: " . $response . "\n";

    // Check if material was created
    $material = \App\Models\Material::where('title', 'Test Admin Material Creation')->first();
    if ($material) {
        echo "Material found in database: {$material->title} (ID: {$material->id})\n";
    } else {
        echo "Material not found in database\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}