<?php
/**
 * Script to create storage symlink or copy files for hosting without symlink support
 */

// Check if symlink is supported
$symlinkSupported = function_exists('symlink');

$publicStoragePath = __DIR__ . '/../public/storage';
$storagePublicPath = __DIR__ . '/../storage/app/public';

echo "Storage Link Setup Script\n";
echo "========================\n\n";

if ($symlinkSupported) {
    echo "Symlink is supported. Attempting to create symlink...\n";

    // Remove existing public/storage if it exists
    if (file_exists($publicStoragePath)) {
        if (is_link($publicStoragePath)) {
            unlink($publicStoragePath);
            echo "Removed existing symlink.\n";
        } elseif (is_dir($publicStoragePath)) {
            // Remove directory if it exists
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($publicStoragePath, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($files as $fileinfo) {
                $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                $todo($fileinfo->getRealPath());
            }

            rmdir($publicStoragePath);
            echo "Removed existing directory.\n";
        }
    }

    // Create symlink
    if (symlink($storagePublicPath, $publicStoragePath)) {
        echo "✓ Symlink created successfully: public/storage -> storage/app/public\n";
    } else {
        echo "✗ Failed to create symlink. Falling back to file copy method.\n";
        $symlinkSupported = false;
    }
}

if (!$symlinkSupported) {
    echo "Using file copy method (for hosting without symlink support)...\n";

    // Create directory if not exists
    if (!file_exists($publicStoragePath)) {
        mkdir($publicStoragePath, 0755, true);
        echo "Created public/storage directory.\n";
    }

    // Copy .gitignore
    if (file_exists($storagePublicPath . '/.gitignore')) {
        copy($storagePublicPath . '/.gitignore', $publicStoragePath . '/.gitignore');
    }

    // Copy all subdirectories
    $directories = ['bukti_transfer', 'soal', 'materials', 'thumbnails', 'photo-profile', 'articles'];

    foreach ($directories as $dir) {
        $sourceDir = $storagePublicPath . '/' . $dir;
        $targetDir = $publicStoragePath . '/' . $dir;

        if (file_exists($sourceDir)) {
            // Create target directory
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Copy files
            $files = glob($sourceDir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    $filename = basename($file);
                    copy($file, $targetDir . '/' . $filename);
                }
            }

            echo "✓ Copied files from $dir\n";
        }
    }

    echo "✓ File copy completed. Storage files are now accessible.\n";
}

echo "\nSetup completed!\n";
echo "You can now access uploaded files via /storage/ URL path.\n";