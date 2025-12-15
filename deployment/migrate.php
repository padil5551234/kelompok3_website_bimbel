<?php
/**
 * Helper script untuk migrasi database di InfinityFree
 * 
 * INSTRUKSI:
 * 1. Upload file ini ke folder /htdocs/ di InfinityFree
 * 2. Akses via browser: https://yourdomain.infinityfreeapp.com/migrate.php
 * 3. HAPUS file ini setelah selesai migrasi!
 */

require __DIR__.'/../laravel/vendor/autoload.php';

$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<h2>Database Migration</h2>";
echo "<pre>";

echo "Running migrations...\n";
$status = $kernel->call('migrate', ['--force' => true]);
echo "Migration status: " . $status . "\n\n";

echo "Running seeders...\n";
$status = $kernel->call('db:seed', ['--force' => true]);
echo "Seeder status: " . $status . "\n\n";

echo "</pre>";
echo "<h3 style='color: green;'>✓ Migration completed!</h3>";
echo "<p style='color: red;'><strong>IMPORTANT: Delete this file immediately for security!</strong></p>";