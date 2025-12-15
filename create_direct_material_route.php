<?php

/**
 * Create a direct route for testing materials access
 * This bypasses all complex logic and directly shows materials
 */

echo "Creating direct material route...\n";

// Read the current web.php file
$webRoutes = file_get_contents('routes/web.php');

// Find the materials section and add our direct route
$directRouteCode = '
// Direct Material Test Route - Bypasses all logic
Route::get(\'/materials-test\', function() {
    require_once \'vendor/autoload.php\';
    $app = require_once \'bootstrap/app.php\';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    use App\Models\Material;
    use App\Models\PaketUjian;
    use App\Models\Pembelian;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;

    // Get the test user
    $user = User::where(\'email\', \'padilzaki73@gmail.com\')->first();
    if (!$user) {
        return "User not found!";
    }

    Auth::login($user);

    // Get user\'s purchases
    $purchasedPackages = Pembelian::forUser($user->id)
        ->verified()
        ->with(\'paketUjian\')
        ->get()
        ->pluck(\'paketUjian\')
        ->filter();

    // Get materials user should see
    $materials = collect();
    if ($purchasedPackages->isNotEmpty()) {
        $packageIds = $purchasedPackages->pluck(\'id\');
        $materials = Material::where(function($q) use ($packageIds) {
            $q->whereIn(\'batch_id\', $packageIds)
              ->orWhereNull(\'batch_id\');
        })->with([\'tutor\', \'batch\'])->get();
    }

    $html = "<!DOCTYPE html>
<html>
<head>
    <title>Direct Material Test</title>
    <link href=\'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css\' rel=\'stylesheet\'>
</head>
<body>
    <div class=\'container mt-5\'>
        <h1>Direct Material Test</h1>
        <p><strong>User:</strong> " . $user->name . " (" . $user->email . ")</p>
        <p><strong>Authenticated:</strong> " . (Auth::check() ? "Yes" : "No") . "</p>
        <p><strong>Purchased Packages:</strong> " . $purchasedPackages->count() . "</p>
        <p><strong>Materials Found:</strong> " . $materials->count() . "</p>
        
        <hr>
        
        <h2>Materials:</h2>";

    if ($materials->isEmpty()) {
        $html .= "<div class=\'alert alert-warning\'>No materials found!</div>";
    } else {
        foreach ($materials as $material) {
            $html .= "<div class=\'card mb-3\'>";
            $html .= "<div class=\'card-body\'>";
            $html .= "<h5>" . $material->title . "</h5>";
            $html .= "<p><strong>Type:</strong> " . $material->type . "</p>";
            $html .= "<p><strong>Chapter:</strong> " . ($material->chapter_number ?? "N/A") . " - " . ($material->chapter_title ?? "N/A") . "</p>";
            $html .= "<p><strong>Package:</strong> " . ($material->batch ? $material->batch->nama : "No package") . "</p>";
            $html .= "<p><strong>Public:</strong> " . ($material->is_public ? "Yes" : "No") . "</p>";
            $html .= "<p><strong>Description:</strong> " . ($material->description ?? "No description") . "</p>";
            $html .= "</div>";
            $html .= "</div>";
        }
    }
    
    $html .= "
        <hr>
        <h2>Raw Data:</h2>
        <pre>" . json_encode($materials->toArray(), JSON_PRETTY_PRINT) . "</pre>
    </div>
</body>
</html>";

    return $html;
})->middleware([\'auth\', \'verified\'])->name(\'materials.test\');
';

echo "Adding direct route to web.php...\n";

// Insert the route before the require_once statement
$insertPosition = strpos($webRoutes, "require_once __DIR__ . '/jetstream.php';");
if ($insertPosition !== false) {
    $webRoutes = substr_replace($webRoutes, $directRouteCode . "\n\n", $insertPosition, 0);
    
    // Write back to file
    file_put_contents('routes/web.php', $webRoutes);
    echo "✓ Direct route added successfully!\n";
    echo "✓ Route URL: /materials-test\n";
    echo "✓ Route name: materials.test\n";
} else {
    echo "✗ Could not find insertion point in web.php\n";
}

echo "\n=== NEXT STEPS ===\n";
echo "1. The direct test route has been added\n";
echo "2. Tell the user to go to: http://127.0.0.1:8000/materials-test\n";
echo "3. This will show materials directly without any complex logic\n";
echo "4. If materials still don't show, the issue is deeper than expected\n";
echo "5. If materials do show, then the issue is in the original controller/view logic\n";