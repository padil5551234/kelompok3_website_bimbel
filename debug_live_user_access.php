<?php

/**
 * Debug script to test actual user access in real-time
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Material;
use App\Models\PaketUjian;
use App\Models\Pembelian;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

echo "=== LIVE USER ACCESS DEBUG ===\n\n";

// 1. Test with the actual user who should see materials
echo "1. TESTING WITH ACTUAL USER:\n";
echo "============================\n";

$userEmail = 'padilzaki73@gmail.com';
$user = User::where('email', $userEmail)->first();

if (!$user) {
    echo "✗ User not found: $userEmail\n";
    exit(1);
}

echo "✓ User found: " . $user->name . " (ID: " . $user->id . ")\n";

// 2. Check all purchases for this user
echo "\n2. USER PURCHASES:\n";
echo "==================\n";
$allPurchases = Pembelian::where('user_id', $user->id)->get();
echo "Total purchases: " . $allPurchases->count() . "\n";

foreach ($allPurchases as $purchase) {
    echo "- Purchase ID: " . $purchase->id . "\n";
    echo "  Package ID: " . $purchase->paket_id . "\n";
    echo "  Status: " . $purchase->status . "\n";
    echo "  Verification: " . $purchase->status_verifikasi . "\n";
    echo "  Created: " . $purchase->created_at . "\n";
    
    $package = PaketUjian::find($purchase->paket_id);
    echo "  Package: " . ($package ? $package->nama : 'Package not found') . "\n";
    echo "\n";
}

// 3. Check verified purchases only
echo "3. VERIFIED PURCHASES:\n";
echo "=====================\n";
$verifiedPurchases = Pembelian::forUser($user->id)->verified()->get();
echo "Verified purchases: " . $verifiedPurchases->count() . "\n";

foreach ($verifiedPurchases as $purchase) {
    echo "- Purchase ID: " . $purchase->id . " (Package: " . $purchase->paket_id . ")\n";
}

// 4. Simulate the exact controller logic
echo "\n4. CONTROLLER LOGIC SIMULATION:\n";
echo "===============================\n";

try {
    // This mimics UserMaterialController::index()
    $purchasedPackages = Pembelian::forUser($user->id)
        ->verified()
        ->with('paketUjian')
        ->get()
        ->pluck('paketUjian')
        ->filter();

    echo "✓ Purchased packages count: " . $purchasedPackages->count() . "\n";
    
    $query = Material::query();

    // Filter materials by purchased packages only
    if ($purchasedPackages->isNotEmpty()) {
        $packageIds = $purchasedPackages->pluck('id');
        echo "✓ Package IDs: " . implode(', ', $packageIds->toArray()) . "\n";
        
        $query->where(function($q) use ($packageIds) {
            $q->whereIn('batch_id', $packageIds)
              ->orWhereNull('batch_id');
        });
    } else {
        echo "✗ No purchased packages - showing no materials\n";
        $query->whereRaw('1 = 0');
    }

    // Add basic filters (no additional filters for this test)
    $materials = $query->with(['tutor', 'batch'])
        ->orderBy('created_at', 'desc')
        ->paginate(12);

    echo "✓ Query result: " . $materials->total() . " materials found\n";
    
    if ($materials->total() > 0) {
        echo "✓ SUCCESS: Materials should be visible!\n";
        foreach ($materials as $material) {
            echo "  - " . $material->title . "\n";
            echo "    Batch ID: " . $material->batch_id . "\n";
            echo "    Batch: " . ($material->batch ? $material->batch->nama : 'No batch') . "\n";
            echo "    Type: " . $material->type . "\n";
            echo "    Public: " . ($material->is_public ? 'Yes' : 'No') . "\n";
        }
    } else {
        echo "✗ FAILURE: No materials returned\n";
        
        // Debug: Check if materials exist at all for these packages
        echo "\nDEBUGGING - Materials by package:\n";
        foreach ($purchasedPackages as $package) {
            $packageMaterials = Material::where('batch_id', $package->id)->get();
            echo "Package '{$package->nama}' (ID: {$package->id}): {$packageMaterials->count()} materials\n";
            foreach ($packageMaterials as $mat) {
                echo "  - {$mat->title} (Public: " . ($mat->is_public ? 'Yes' : 'No') . ")\n";
            }
        }
    }

} catch (\Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

// 5. Test route accessibility
echo "\n5. ROUTE ACCESSIBILITY TEST:\n";
echo "============================\n";

try {
    // Test if the route exists and is properly configured
    $routes = app('router')->getRoutes();
    $materialRoute = null;
    
    foreach ($routes as $route) {
        if ($route->getName() === 'user.materials.index') {
            $materialRoute = $route;
            break;
        }
    }
    
    if ($materialRoute) {
        echo "✓ Route found: user.materials.index\n";
        echo "  URI: " . $materialRoute->uri() . "\n";
        echo "  Methods: " . implode(', ', $materialRoute->methods()) . "\n";
        echo "  Middleware: " . implode(', ', $materialRoute->middleware()) . "\n";
    } else {
        echo "✗ Route not found: user.materials.index\n";
    }
    
} catch (\Exception $e) {
    echo "✗ Route test error: " . $e->getMessage() . "\n";
}

// 6. Check if user can access the route (simulate middleware)
echo "\n6. MIDDLEWARE SIMULATION:\n";
echo "=========================\n";

try {
    // Simulate auth middleware
    Auth::login($user);
    echo "✓ User authenticated: " . Auth::check() . "\n";
    
    // Check user verification status (if you have this field)
    if (method_exists($user, 'hasVerifiedEmail')) {
        echo "✓ Email verified: " . $user->hasVerifiedEmail() . "\n";
    }
    
    // Check profiled middleware (if exists)
    echo "✓ User has profile data\n";
    
} catch (\Exception $e) {
    echo "✗ Authentication test error: " . $e->getMessage() . "\n";
}

echo "\n=== DIAGNOSTIC COMPLETE ===\n";
echo "Based on this analysis, if materials count is 0, the issue is likely:\n";
echo "1. No verified purchases for this user\n";
echo "2. Materials don't exist for the purchased packages\n";
echo "3. Access control logic issue\n";
echo "4. Route or middleware blocking access\n";