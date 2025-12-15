<?php
/**
 * System Check untuk InfinityFree
 * 
 * INSTRUKSI:
 * 1. Upload file ini ke folder /htdocs/ di InfinityFree
 * 2. Akses via browser: https://yourdomain.infinityfreeapp.com/check-system.php
 * 3. Lihat status sistem dan konfigurasi
 * 4. HAPUS file ini setelah selesai pengecekan!
 */

echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
    .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    h1 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
    h2 { color: #666; margin-top: 30px; }
    .success { color: #4CAF50; font-weight: bold; }
    .error { color: #f44336; font-weight: bold; }
    .warning { color: #ff9800; font-weight: bold; }
    .info { background: #e3f2fd; padding: 10px; border-left: 4px solid #2196F3; margin: 10px 0; }
    table { width: 100%; border-collapse: collapse; margin: 15px 0; }
    td, th { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
    th { background: #f5f5f5; font-weight: bold; }
    .delete-warning { background: #ffebee; padding: 15px; border-left: 4px solid #f44336; margin: 20px 0; font-weight: bold; }
</style>";

echo "<div class='container'>";
echo "<h1>🔍 System Check - InfinityFree Deployment</h1>";

// PHP Version Check
echo "<h2>📦 PHP Configuration</h2>";
echo "<table>";
echo "<tr><th>Setting</th><th>Value</th><th>Status</th></tr>";

$phpVersion = phpversion();
$phpVersionOk = version_compare($phpVersion, '7.4.0', '>=');
echo "<tr><td>PHP Version</td><td>$phpVersion</td><td class='" . ($phpVersionOk ? 'success' : 'error') . "'>" . ($phpVersionOk ? '✓ OK' : '✗ Need >= 7.4') . "</td></tr>";

$extensions = [
    'pdo' => 'PDO',
    'pdo_mysql' => 'PDO MySQL',
    'mbstring' => 'Mbstring',
    'tokenizer' => 'Tokenizer',
    'xml' => 'XML',
    'ctype' => 'Ctype',
    'json' => 'JSON',
    'bcmath' => 'BCMath',
    'fileinfo' => 'Fileinfo',
    'openssl' => 'OpenSSL',
    'curl' => 'cURL'
];

foreach ($extensions as $ext => $name) {
    $loaded = extension_loaded($ext);
    echo "<tr><td>$name Extension</td><td>" . ($loaded ? 'Loaded' : 'Not Loaded') . "</td><td class='" . ($loaded ? 'success' : 'error') . "'>" . ($loaded ? '✓ OK' : '✗ Missing') . "</td></tr>";
}

echo "<tr><td>Memory Limit</td><td>" . ini_get('memory_limit') . "</td><td class='info'>Info</td></tr>";
echo "<tr><td>Max Execution Time</td><td>" . ini_get('max_execution_time') . "s</td><td class='info'>Info</td></tr>";
echo "<tr><td>Upload Max Filesize</td><td>" . ini_get('upload_max_filesize') . "</td><td class='info'>Info</td></tr>";
echo "<tr><td>Post Max Size</td><td>" . ini_get('post_max_size') . "</td><td class='info'>Info</td></tr>";
echo "</table>";

// Laravel Installation Check
echo "<h2>🚀 Laravel Installation</h2>";
echo "<table>";
echo "<tr><th>Component</th><th>Status</th></tr>";

$laravelPath = __DIR__.'/../laravel';
$paths = [
    'Laravel Folder' => $laravelPath,
    'Vendor Folder' => $laravelPath.'/vendor',
    'Bootstrap Folder' => $laravelPath.'/bootstrap',
    'Storage Folder' => $laravelPath.'/storage',
    '.env File' => $laravelPath.'/.env',
    'Autoload File' => $laravelPath.'/vendor/autoload.php'
];

foreach ($paths as $name => $path) {
    $exists = file_exists($path);
    echo "<tr><td>$name</td><td class='" . ($exists ? 'success' : 'error') . "'>" . ($exists ? '✓ Found' : '✗ Not Found') . "</td></tr>";
}

echo "</table>";

// Permission Check
echo "<h2>🔒 File Permissions</h2>";
echo "<table>";
echo "<tr><th>Directory</th><th>Writable</th><th>Status</th></tr>";

$writablePaths = [
    'Storage' => $laravelPath.'/storage',
    'Bootstrap Cache' => $laravelPath.'/bootstrap/cache',
    'Storage Framework' => $laravelPath.'/storage/framework',
    'Storage Logs' => $laravelPath.'/storage/logs'
];

foreach ($writablePaths as $name => $path) {
    if (file_exists($path)) {
        $writable = is_writable($path);
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        echo "<tr><td>$name</td><td>$perms - " . ($writable ? 'Yes' : 'No') . "</td><td class='" . ($writable ? 'success' : 'error') . "'>" . ($writable ? '✓ OK' : '✗ Not Writable') . "</td></tr>";
    } else {
        echo "<tr><td>$name</td><td>Not Found</td><td class='error'>✗ Missing</td></tr>";
    }
}

echo "</table>";

// Database Connection Check
echo "<h2>🗄️ Database Connection</h2>";

if (file_exists($laravelPath.'/.env')) {
    try {
        require $laravelPath.'/vendor/autoload.php';
        $app = require_once $laravelPath.'/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        
        $config = $app->make('config');
        $dbConnection = $config->get('database.default');
        $dbHost = $config->get("database.connections.$dbConnection.host");
        $dbDatabase = $config->get("database.connections.$dbConnection.database");
        $dbUsername = $config->get("database.connections.$dbConnection.username");
        
        echo "<table>";
        echo "<tr><th>Setting</th><th>Value</th></tr>";
        echo "<tr><td>Connection</td><td>$dbConnection</td></tr>";
        echo "<tr><td>Host</td><td>$dbHost</td></tr>";
        echo "<tr><td>Database</td><td>$dbDatabase</td></tr>";
        echo "<tr><td>Username</td><td>$dbUsername</td></tr>";
        
        try {
            DB::connection()->getPdo();
            echo "<tr><td colspan='2' class='success'>✓ Database Connection Successful!</td></tr>";
        } catch (\Exception $e) {
            echo "<tr><td colspan='2' class='error'>✗ Database Connection Failed: " . $e->getMessage() . "</td></tr>";
        }
        echo "</table>";
    } catch (\Exception $e) {
        echo "<div class='error'>Error loading Laravel: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='error'>✗ .env file not found</div>";
}

// Environment Info
echo "<h2>🌍 Environment Information</h2>";
echo "<table>";
echo "<tr><th>Variable</th><th>Value</th></tr>";
echo "<tr><td>Server Software</td><td>" . $_SERVER['SERVER_SOFTWARE'] . "</td></tr>";
echo "<tr><td>Document Root</td><td>" . $_SERVER['DOCUMENT_ROOT'] . "</td></tr>";
echo "<tr><td>Current Path</td><td>" . __DIR__ . "</td></tr>";
echo "<tr><td>Server Name</td><td>" . $_SERVER['SERVER_NAME'] . "</td></tr>";
echo "<tr><td>Server IP</td><td>" . $_SERVER['SERVER_ADDR'] . "</td></tr>";
echo "</table>";

// Recommendations
echo "<h2>💡 Recommendations</h2>";
echo "<div class='info'>";
echo "<ul>";

if (!$phpVersionOk) {
    echo "<li>Upgrade PHP to version 7.4 or higher</li>";
}

$missingExtensions = array_filter($extensions, function($ext) {
    return !extension_loaded($ext);
}, ARRAY_FILTER_USE_KEY);

if (!empty($missingExtensions)) {
    echo "<li>Install missing PHP extensions: " . implode(', ', array_values($missingExtensions)) . "</li>";
}

if (!file_exists($laravelPath.'/vendor')) {
    echo "<li class='error'><strong>CRITICAL:</strong> Upload vendor folder - Laravel cannot run without it!</li>";
}

if (file_exists($laravelPath.'/.env')) {
    $envContent = file_get_contents($laravelPath.'/.env');
    if (strpos($envContent, 'APP_DEBUG=true') !== false) {
        echo "<li class='warning'><strong>WARNING:</strong> Set APP_DEBUG=false in .env for production</li>";
    }
    if (strpos($envContent, 'APP_ENV=local') !== false) {
        echo "<li class='warning'><strong>WARNING:</strong> Set APP_ENV=production in .env</li>";
    }
}

echo "</ul>";
echo "</div>";

echo "<div class='delete-warning'>";
echo "⚠️ <strong>SECURITY WARNING:</strong> DELETE THIS FILE IMMEDIATELY AFTER CHECKING!";
echo "</div>";

echo "</div>";
?>