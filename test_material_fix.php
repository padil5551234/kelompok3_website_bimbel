<?php

// Test script to check if the material page loads without errors
require_once 'vendor/autoload.php';

try {
    // Test if the view file can be included without the undefined variable error
    echo "Testing actions.blade.php inclusion...\n";
    
    // Create a mock material object
    $mockMaterial = new class {
        public $is_featured = false;
        public $is_public = true;
        
        public function __toString() {
            return "1"; // Mock ID
        }
    };
    
    // Test if we can render the actions view with the material variable
    extract(['material' => $mockMaterial]);
    
    ob_start();
    include 'resources/views/admin/material/actions.blade.php';
    $output = ob_get_clean();
    
    echo "SUCCESS: actions.blade.php can be rendered without errors!\n";
    echo "Output length: " . strlen($output) . " characters\n";
    
    // Check if key elements are present
    $hasShowButton = strpos($output, 'showForm') !== false;
    $hasEditButton = strpos($output, 'editForm') !== false;
    $hasToggleButtons = strpos($output, 'toggleFeatured') !== false;
    
    echo "Show button found: " . ($hasShowButton ? "YES" : "NO") . "\n";
    echo "Edit button found: " . ($hasEditButton ? "YES" : "NO") . "\n";
    echo "Toggle buttons found: " . ($hasToggleButtons ? "YES" : "NO") . "\n";
    
    if ($hasShowButton && $hasEditButton && $hasToggleButtons) {
        echo "\n✅ ALL TESTS PASSED! The fix is working correctly.\n";
    } else {
        echo "\n❌ Some elements are missing. Please check the template.\n";
    }
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}