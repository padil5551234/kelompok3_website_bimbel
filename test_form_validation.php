<?php

require_once 'vendor/autoload.php';

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Material;
use App\Models\PaketUjian;
use App\Models\User;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING FORM VALIDATION ===\n\n";

// Test data for different material types
$testCases = [
    'link' => [
        'batch_id' => '337a4cb9-d7fc-467e-a4cc-032150ea6879',
        'tutor_id' => '1e5e1931-9a9a-4a6b-8c92-74f0bb28e994',
        'title' => 'Test Link Material',
        'type' => 'link',
        'external_link' => 'https://example.com/test',
    ],
    'youtube' => [
        'batch_id' => '337a4cb9-d7fc-467e-a4cc-032150ea6879',
        'tutor_id' => '1e5e1931-9a9a-4a6b-8c92-74f0bb28e994',
        'title' => 'Test YouTube Material',
        'type' => 'youtube',
        'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    ],
    'video_without_file' => [
        'batch_id' => '337a4cb9-d7fc-467e-a4cc-032150ea6879',
        'tutor_id' => '1e5e1931-9a9a-4a6b-8c92-74f0bb28e994',
        'title' => 'Test Video Material Without File',
        'type' => 'video',
        // Missing file - this should fail validation
    ],
    'document_without_file' => [
        'batch_id' => '337a4cb9-d7fc-467e-a4cc-032150ea6879',
        'tutor_id' => '1e5e1931-9a9a-4a6b-8c92-74f0bb28e994',
        'title' => 'Test Document Material Without File',
        'type' => 'document',
        // Missing file - this should fail validation
    ],
];

$validationRules = [
    'batch_id' => 'required|exists:paket_ujian,id',
    'tutor_id' => 'required|exists:users,id',
    'title' => 'required|string|max:255',
    'mapel' => 'nullable|string|max:100',
    'description' => 'nullable|string',
    'type' => 'required|in:video,document,link,youtube',
    'file' => 'required_if:type,video,document|file|mimes:pdf,doc,docx,mp4,avi,mov,wmv|max:102400',
    'youtube_url' => 'required_if:type,youtube|nullable|url',
    'external_link' => 'required_if:type,link|nullable|url',
    'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    'content' => 'nullable|string',
    'tags' => 'nullable|array',
    'is_public' => 'boolean',
    'is_featured' => 'boolean',
    'is_completable' => 'boolean',
    'duration_seconds' => 'nullable|integer|min:1',
];

foreach ($testCases as $testName => $data) {
    echo "Testing: $testName\n";
    echo "Data: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";

    $validator = Validator::make($data, $validationRules);

    if ($validator->fails()) {
        echo "❌ VALIDATION FAILED\n";
        echo "Errors: " . json_encode($validator->errors()->toArray(), JSON_PRETTY_PRINT) . "\n";
    } else {
        echo "✅ VALIDATION PASSED\n";
    }

    echo "\n" . str_repeat("-", 50) . "\n\n";
}

echo "=== CHECKING REQUIRED FIELDS FOR EACH TYPE ===\n";
echo "Video/Document types REQUIRE a file upload\n";
echo "YouTube type REQUIRES a youtube_url\n";
echo "Link type REQUIRES an external_link\n";
echo "\nIf you're getting validation errors, make sure:\n";
echo "1. For video/document: Upload a file\n";
echo "2. For youtube: Provide a valid YouTube URL\n";
echo "3. For link: Provide a valid external URL\n";
echo "4. All required fields (title, tutor, batch) are filled\n";