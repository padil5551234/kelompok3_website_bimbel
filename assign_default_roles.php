<?php
/**
 * Script untuk memberikan role default ke user yang belum punya role
 */

require_once "vendor/autoload.php";

$app = require_once "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔄 ASSIGNING DEFAULT ROLES TO USERS\n";
echo "===================================\n\n";

try {
    // Get all users without roles
    $usersWithoutRoles = App\Models\User::whereDoesntHave("roles")->get();
    
    echo "📊 Users tanpa role: " . $usersWithoutRoles->count() . "\n\n";
    
    foreach ($usersWithoutRoles as $user) {
        echo "🎯 Assigning role \"user\" ke: {$user->name} ({$user->email})\n";
        
        try {
            $user->assignRole("user");
            echo "✅ Berhasil!\n";
        } catch (Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n✅ Proses selesai!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>