<?php

// Test script for material show view
require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "Testing Material Show View...\n";

// Create a mock material object
$material = (object) [
    'id' => 1,
    'title' => 'Test Material',
    'type' => 'youtube',
    'youtube_url' => 'https://youtube.com/watch?v=test',
    'description' => 'This is a test material description.',
    'content' => 'Additional content for testing.',
    'tags' => ['tag1', 'tag2'],
    'mapel' => 'Mathematics',
    'tutor' => (object) ['name' => 'Test Tutor'],
    'batch' => (object) [
        'nama' => 'Test Batch',
        'modules' => [
            (object) [
                'title' => 'Chapter 1: Functions',
                'materials' => [
                    (object) [
                        'id' => 1,
                        'title' => 'Relations & Functions',
                        'type' => 'youtube',
                        'description' => 'Introduction to relations and functions',
                        'duration_seconds' => 1800,
                        'views_count' => 150,
                        'getFormattedDuration' => function() { return '30:00'; }
                    ],
                    (object) [
                        'id' => 2,
                        'title' => 'Algebra of Functions',
                        'type' => 'document',
                        'description' => 'Operations on functions',
                        'duration_seconds' => null,
                        'views_count' => 89,
                        'getFormattedDuration' => function() { return ''; }
                    ]
                ]
            ],
            (object) [
                'title' => 'Chapter 2: Types of Functions',
                'materials' => [
                    (object) [
                        'id' => 3,
                        'title' => 'Linear Functions',
                        'type' => 'video',
                        'description' => 'Understanding linear functions',
                        'duration_seconds' => 2400,
                        'views_count' => 200,
                        'getFormattedDuration' => function() { return '40:00'; }
                    ]
                ]
            ]
        ]
    ],
    'is_public' => true,
    'created_at' => new DateTime('2024-01-01'),
    'updated_at' => new DateTime('2024-01-02'),
    'views_count' => 500,
    'duration_seconds' => 3600,
    'getFormattedDuration' => function() { return '1:00:00'; },
    'isDownloadable' => function() { return true; },
    'downloads_count' => 50,
    'file_size' => 1024000,
    'getFormattedFileSize' => function() { return '1 MB'; }
];

$isPreviewMode = false;
$hasFullAccess = true;
$previousMaterial = (object) [
    'id' => 1,
    'title' => 'Previous Material Title'
];
$nextMaterial = (object) [
    'id' => 3,
    'title' => 'Next Material Title'
];

// Mock helper functions
if (!function_exists('route')) {
    function route($name, $params = null) {
        $id = '';
        if ($params) {
            if (is_object($params)) {
                $id = '/' . $params->id;
            } elseif (is_array($params)) {
                $id = '/' . implode('/', $params);
            } else {
                $id = '/' . $params;
            }
        }
        return "#{$name}{$id}";
    }
}

if (!function_exists('asset')) {
    function asset($path) {
        return "/assets{$path}";
    }
}

if (!function_exists('number_format')) {
    function number_format($number) {
        return (string) $number;
    }
}

if (!function_exists('ucfirst')) {
    function ucfirst($string) {
        return strtoupper(substr($string, 0, 1)) . substr($string, 1);
    }
}

if (!function_exists('basename')) {
    function basename($path) {
        return substr($path, strrpos($path, '/') + 1);
    }
}

if (!function_exists('Str')) {
    class Str {
        public static function limit($string, $limit) {
            return strlen($string) > $limit ? substr($string, 0, $limit) . '...' : $string;
        }
        public static function endsWith($string, $end) {
            return substr($string, -strlen($end)) === $end;
        }
    }
}

try {
    // Render the view
    $view = view('views_user.materials.show', compact(
        'material',
        'isPreviewMode',
        'hasFullAccess',
        'previousMaterial',
        'nextMaterial'
    ));

    echo "View rendered successfully!\n";
    echo "View content length: " . strlen($view) . " characters\n";

    // Check for common issues
    if (strpos($view, 'Undefined variable') !== false) {
        echo "Warning: Found undefined variable errors\n";
    }

    if (strpos($view, 'Trying to get property') !== false) {
        echo "Warning: Found property access errors\n";
    }

    echo "Test completed.\n";

} catch (Exception $e) {
    echo "Error rendering view: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}