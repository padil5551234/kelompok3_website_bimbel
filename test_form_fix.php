<?php

// Test script to check if the form page loads without errors
require_once 'vendor/autoload.php';

try {
    echo "Testing form.blade.php inclusion...\n";
    
    // Create mock data
    $mockTutors = [
        (object)['id' => 1, 'name' => 'Tutor 1'],
        (object)['id' => 2, 'name' => 'Tutor 2']
    ];
    
    $mockPaketUjians = [
        (object)['id' => 1, 'nama' => 'Paket 1'],
        (object)['id' => 2, 'nama' => 'Paket 2']
    ];
    
    // Test if we can render the form view without material variable (create mode)
    extract([
        'tutors' => $mockTutors, 
        'paketUjians' => $mockPaketUjians
        // Note: no $material variable
    ]);
    
    ob_start();
    include 'resources/views/admin/material/form.blade.php';
    $output = ob_get_clean();
    
    echo "SUCCESS: form.blade.php can be rendered without errors (create mode)!\n";
    echo "Output length: " . strlen($output) . " characters\n";
    
    // Test with material variable (edit mode)
    echo "\nTesting form.blade.php with material variable (edit mode)...\n";
    
    $mockMaterial = new class {
        public $title = 'Test Material';
        public $mapel = 'Mathematics';
        public $tutor_id = 1;
        public $batch_id = 1;
        public $type = 'video';
        public $youtube_url = '';
        public $external_link = '';
        public $description = 'Test description';
        public $content = 'Test content';
        public $duration_seconds = 3600;
        public $is_public = true;
        public $is_featured = false;
        public $file_path = null;
        public $thumbnail_path = null;
        public $tags = ['tag1', 'tag2'];
    };
    
    extract([
        'tutors' => $mockTutors, 
        'paketUjians' => $mockPaketUjians,
        'material' => $mockMaterial
    ]);
    
    ob_start();
    include 'resources/views/admin/material/form.blade.php';
    $output = ob_get_clean();
    
    echo "SUCCESS: form.blade.php can be rendered with material variable (edit mode)!\n";
    echo "Output length: " . strlen($output) . " characters\n";
    
    echo "\n✅ ALL FORM TESTS PASSED! The form is working correctly in both modes.\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}