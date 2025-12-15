<?php
/**
 * Helper script untuk clear cache di InfinityFree
 * 
 * INSTRUKSI:
 * 1. Upload file ini ke folder /htdocs/ di InfinityFree
 * 2. Akses via browser: https://yourdomain.infinityfreeapp.com/clear-cache.php
 * 3. HAPUS file ini setelah selesai clear cache!
 */

require __DIR__.'/../laravel/vendor/autoload.php';

$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<h2>Clear Application Cache</h2>";
echo "<pre>";

echo "Clearing config cache...\n";
$kernel->call('config:clear');
echo "✓ Config cache cleared\n\n";

echo "Clearing route cache...\n";
$kernel->call('route:clear');
echo "✓ Route cache cleared\n\n";

echo "Clearing view cache...\n";
$kernel->call('view:clear');
echo "✓ View cache cleared\n\n";

echo "Clearing application cache...\n";
$kernel->call('cache:clear');
echo "✓ Application cache cleared\n\n";

echo "</pre>";
echo "<h3 style='color: green;'>✓ All caches cleared successfully!</h3>";
echo "<p style='color: red;'><strong>IMPORTANT: Delete this file immediately for security!</strong></p>";