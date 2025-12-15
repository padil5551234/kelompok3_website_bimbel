<?php

// Add this route to routes/web.php for debugging
Route::get('/debug-materials', function() {
    $user = auth()->user();
    
    if (!$user) {
        return "Please login first";
    }
    
    // Get purchased packages
    $purchasedPackages = App\Models\Pembelian::forUser($user->id)
        ->verified()
        ->with('paketUjian')
        ->get()
        ->pluck('paketUjian')
        ->filter();
    
    // Get materials
    $query = App\Models\Material::query();
    
    if ($purchasedPackages->isNotEmpty()) {
        $packageIds = $purchasedPackages->pluck('id');
        $query->where(function($q) use ($packageIds) {
            $q->whereIn('batch_id', $packageIds)
              ->orWhereNull('batch_id');
        });
    } else {
        $query->whereRaw('1 = 0');
    }
    
    $materials = $query->with(['tutor', 'batch'])
        ->distinct('materials.id')
        ->orderBy('created_at', 'desc')
        ->get();
    
    $html = "<h1>Debug Materials Page</h1>";
    $html .= "<p><strong>User ID:</strong> " . $user->id . "</p>";
    $html .= "<p><strong>Purchased Packages:</strong> " . $purchasedPackages->count() . "</p>";
    $html .= "<p><strong>Materials Found:</strong> " . $materials->count() . "</p>";
    $html .= "<p><strong>Unique Material IDs:</strong> " . count($materials->pluck('id')->unique()) . "</p>";
    
    if ($materials->count() !== count($materials->pluck('id')->unique())) {
        $html .= "<div style='background: red; color: white; padding: 10px; margin: 10px 0;'>⚠️ DUPLICATES DETECTED!</div>";
    } else {
        $html .= "<div style='background: green; color: white; padding: 10px; margin: 10px 0;'>✅ No duplicates found</div>";
    }
    
    $html .= "<h2>Materials List:</h2>";
    foreach ($materials as $material) {
        $html .= "<div style='border: 1px solid #ccc; margin: 5px; padding: 10px;'>";
        $html .= "<strong>{$material->title}</strong><br>";
        $html .= "ID: {$material->id}<br>";
        $html .= "Batch: " . ($material->batch ? $material->batch->nama : 'No batch') . "<br>";
        $html .= "Chapter: {$material->chapter_number} - {$material->chapter_title}<br>";
        $html .= "</div>";
    }
    
    $html .= "<h2>Raw Data:</h2>";
    $html .= "<pre>" . json_encode($materials->toArray(), JSON_PRETTY_PRINT) . "</pre>";
    
    return $html;
})->middleware(['auth', 'verified']);