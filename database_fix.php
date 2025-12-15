<?php
/**
 * Database Connection Fix Script
 * 
 * This script helps diagnose and fix common database connection issues
 */

echo "=== Database Connection Diagnostic Tool ===\n\n";

// Check if .env file exists
if (!file_exists('.env')) {
    echo "❌ .env file not found!\n";
    exit(1);
}

echo "✅ .env file found\n";

// Load environment variables
$env = parse_ini_file('.env');

echo "📋 Current Database Configuration:\n";
echo "   Connection: " . ($env['DB_CONNECTION'] ?? 'not set') . "\n";
echo "   Host: " . ($env['DB_HOST'] ?? 'not set') . "\n";
echo "   Port: " . ($env['DB_PORT'] ?? 'not set') . "\n";
echo "   Database: " . ($env['DB_DATABASE'] ?? 'not set') . "\n";
echo "   Username: " . ($env['DB_USERNAME'] ?? 'not set') . "\n";
echo "   Password: " . (empty($env['DB_PASSWORD']) ? '(empty)' : '(set)') . "\n\n";

// Test MySQL connection if configured
if (($env['DB_CONNECTION'] ?? '') === 'mysql') {
    echo "🔍 Testing MySQL Connection...\n";
    
    try {
        $dsn = "mysql:host={$env['DB_HOST']};port={$env['DB_PORT']}";
        $pdo = new PDO($dsn, $env['DB_USERNAME'], $env['DB_PASSWORD']);
        echo "✅ MySQL connection successful!\n";
        
        // Check if database exists
        $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
        $stmt->execute([$env['DB_DATABASE']]);
        
        if ($stmt->rowCount() > 0) {
            echo "✅ Database '{$env['DB_DATABASE']}' exists\n";
        } else {
            echo "❌ Database '{$env['DB_DATABASE']}' does not exist\n";
            echo "💡 Creating database...\n";
            
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$env['DB_DATABASE']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "✅ Database created successfully\n";
        }
        
    } catch (PDOException $e) {
        echo "❌ MySQL connection failed: " . $e->getMessage() . "\n";
        echo "\n🔧 Troubleshooting steps:\n";
        echo "1. Check if MySQL service is running\n";
        echo "2. Verify credentials in .env file\n";
        echo "3. Ensure MySQL user has proper permissions\n";
        echo "4. Try switching to SQLite for development\n";
    }
}

// Check SQLite database if configured
if (($env['DB_CONNECTION'] ?? '') === 'sqlite') {
    echo "🔍 Testing SQLite Connection...\n";
    
    $dbPath = $env['DB_DATABASE'] ?? 'database/database.sqlite';
    
    if (file_exists($dbPath)) {
        echo "✅ SQLite database file exists: $dbPath\n";
        
        try {
            $pdo = new PDO("sqlite:$dbPath");
            echo "✅ SQLite connection successful!\n";
        } catch (PDOException $e) {
            echo "❌ SQLite connection failed: " . $e->getMessage() . "\n";
        }
    } else {
        echo "❌ SQLite database file does not exist: $dbPath\n";
        echo "💡 Creating SQLite database...\n";
        
        if (touch($dbPath)) {
            echo "✅ SQLite database created successfully\n";
        } else {
            echo "❌ Failed to create SQLite database\n";
        }
    }
}

echo "\n=== Recommendations ===\n";

if (($env['DB_CONNECTION'] ?? '') === 'mysql') {
    echo "🟡 MySQL is configured. If you're having issues:\n";
    echo "   1. Ensure MySQL service is running\n";
    echo "   2. Check MySQL error logs\n";
    echo "   3. Verify user permissions\n";
    echo "   4. Consider switching to SQLite for development\n\n";
    
    echo "💡 To switch to SQLite temporarily, update .env:\n";
    echo "   DB_CONNECTION=sqlite\n";
    echo "   DB_DATABASE=" . getcwd() . "/database/database.sqlite\n\n";
}

echo "🚀 Next steps:\n";
echo "1. Fix any connection issues above\n";
echo "2. Run: php artisan config:clear\n";
echo "3. Run: php artisan migrate:fresh --seed\n";
echo "4. Test registration at /register\n";

echo "\n=== End of Diagnostic ===\n";
?>