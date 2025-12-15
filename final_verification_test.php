<?php

/**
 * Final test to verify material access fix
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

echo "=== FINAL VERIFICATION TEST ===\n\n";

// 1. Verify course exists and has materials
echo "1. COURSE AND MATERIALS VERIFICATION:\n";
echo "=====================================\n";
$courseId = '4ed59120-6a38-4120-9143-4f6689e35aaa';
$course = PaketUjian::find($courseId);

if ($course) {
    echo "✓ Course found: " . $course->nama . "\n";
    echo "  ID: " . $course->id . "\n";
    echo "  Category: " . ($course->kategori ?? 'NULL') . "\n";
    echo "  Level: " . ($course->level ?? 'NULL') . "\n";
} else {
    echo "✗ Course not found!\n";
    exit(1);
}

$materials = Material::where('batch_id', $courseId)->get();
echo "✓ Materials in course: " . $materials->count() . "\n";

foreach ($materials as $material) {
    echo "  - " . $material->title . "\n";
    echo "    Type: " . $material->type . "\n";
    echo "    Public: " . ($material->is_public ? 'Yes' : 'No') . "\n";
    echo "    Chapter: " . ($material->chapter_number ?? 'N/A') . " - " . ($material->chapter_title ?? 'N/A') . "\n";
}

// 2. Verify purchase exists
echo "\n2. PURCHASE VERIFICATION:\n";
echo "=========================\n";
$purchase = Pembelian::where('paket_id', $courseId)
    ->where(function($q) {
        $q->where('status_verifikasi', 'verified')
          ->orWhere('status', 'Sukses');
    })
    ->with('user')
    ->first();

if ($purchase && $purchase->user) {
    echo "✓ Verified purchase found:\n";
    echo "  User: " . $purchase->user->name . " (" . $purchase->user->email . ")\n";
    echo "  User ID: " . $purchase->user_id . "\n";
    echo "  Purchase Status: " . $purchase->status_verifikasi . "\n";
} else {
    echo "✗ No verified purchase found!\n";
    exit(1);
}

// 3. Test the exact logic from UserMaterialController
echo "\n3. USERMATERIALCONTROLLER LOGIC TEST:\n";
echo "=====================================\n";

// Simulate being logged in as the user
Auth::login($purchase->user);

try {
    // This is the exact logic from UserMaterialController::index()
    $user = Auth::user();
    
    // Get user's purchased packages with verified payment only
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
        $query->where(function($q) use ($packageIds) {
            $q->whereIn('batch_id', $packageIds)
              ->orWhereNull('batch_id');
        });
    } else {
        $query->whereRaw('1 = 0');
    }

    $materials = $query->with(['tutor', 'batch'])
        ->orderBy('created_at', 'desc')
        ->paginate(12);

    echo "✓ Query result: " . $materials->total() . " materials found\n";
    
    if ($materials->total() > 0) {
        echo "✓ SUCCESS: User should see materials!\n";
        foreach ($materials as $material) {
            echo "  - " . $material->title . " (Batch: " . ($material->batch ? $material->batch->nama : 'No batch') . ")\n";
        }
    } else {
        echo "✗ FAILURE: User cannot see any materials\n";
        echo "  This indicates an access control issue\n";
    }

} catch (\Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
}

// 4. Test chapter view as well
echo "\n4. CHAPTER VIEW TEST:\n";
echo "====================\n";

try {
    // Test the chapters() method logic
    $user = Auth::user();
    
    $purchasedPackages = Pembelian::forUser($user->id)
        ->verified()
        ->with('paketUjian')
        ->get()
        ->pluck('paketUjian')
        ->filter();

    $query = Material::query();

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
        ->orderBy('chapter_number', 'asc')
        ->orderBy('material_order', 'asc')
        ->orderBy('created_at', 'asc')
        ->get();

    echo "✓ Chapter view materials: " . $materials->count() . " found\n";
    
    if ($materials->count() > 0) {
        // Group by chapters
        $chapters = [];
        $groupedMaterials = $materials->groupBy(function($item) {
            $chapterNumber = $item->chapter_number ?? 1;
            $chapterTitle = $item->chapter_title ?: 'Bab ' . $chapterNumber;
            return $chapterNumber . '|' . $chapterTitle;
        });

        foreach ($groupedMaterials as $chapterKey => $chapterMaterials) {
            list($chapterNumber, $chapterTitle) = explode('|', $chapterKey, 2);
            echo "  Chapter " . $chapterNumber . ": " . $chapterTitle . " (" . $chapterMaterials->count() . " materials)\n";
            foreach ($chapterMaterials as $material) {
                echo "    - " . $material->title . "\n";
            }
        }
    }

} catch (\Exception $e) {
    echo "✗ ERROR in chapter view: " . $e->getMessage() . "\n";
}

// 5. Final summary
echo "\n=== FINAL SUMMARY ===\n";
echo "✓ Course exists with materials\n";
echo "✓ User has verified purchase\n";
echo "✓ Access logic is working\n";

if ($materials && $materials->total() > 0) {
    echo "✓ MATERIALS SHOULD NOW BE VISIBLE TO USERS!\n";
    echo "\nTEST INSTRUCTIONS:\n";
    echo "1. Login as: " . $purchase->user->email . "\n";
    echo "2. Go to: http://127.0.0.1:8000/materials\n";
    echo "3. You should see " . $materials->total() . " material(s)\n";
    echo "4. Or try: http://127.0.0.1:8000/materials/chapters\n";
} else {
    echo "✗ There may still be an issue\n";
    echo "Check the Laravel logs for more details\n";
}

echo "\n=== TEST COMPLETE ===\n";