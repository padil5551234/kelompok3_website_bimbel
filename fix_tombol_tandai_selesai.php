<?php

/**
 * Script untuk mengaktifkan tombol "Tandai Selesai" 
 * dengan memastikan is_completable = true
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== MENGATASI TOMBOL TANDAI SELESAI ===\n\n";

try {
    // Target paket Matematika Dasar
    $targetPaketId = '4ed59120-6a38-4120-9143-4f6689e35aaa';
    
    echo "1. CHECKING MATERIALS IN PAKET:\n";
    echo "-----------------------------\n";
    
    $materials = \App\Models\Material::where('batch_id', $targetPaketId)->get();
    
    if ($materials->count() == 0) {
        echo "❌ Tidak ada material di paket ini!\n";
        exit;
    }
    
    echo "✅ Ditemukan " . $materials->count() . " materials\n\n";
    
    echo "2. CHECKING is_completable STATUS:\n";
    echo "-----------------------------\n";
    
    foreach ($materials as $material) {
        $isCompletable = $material->is_completable ? 'YES' : 'NO';
        echo "   {$material->title}: is_completable = {$isCompletable}\n";
    }
    
    echo "\n";
    
    echo "3. SETTING is_completable = true FOR ALL MATERIALS:\n";
    echo "-----------------------------\n";
    
    $updated = 0;
    foreach ($materials as $material) {
        $wasCompletable = $material->is_completable;
        
        $material->is_completable = true;
        $material->save();
        
        $updated++;
        echo "✅ Updated: {$material->title} (was: " . ($wasCompletable ? 'true' : 'false') . " → now: true)\n";
    }
    
    echo "\n";
    
    echo "4. VERIFICATION:\n";
    echo "-----------------------------\n";
    
    $verifiedMaterials = \App\Models\Material::where('batch_id', $targetPaketId)->get();
    
    foreach ($verifiedMaterials as $material) {
        $isCompletable = $material->is_completable ? '✅ YES' : '❌ NO';
        echo "   {$material->title}: {$isCompletable}\n";
    }
    
    echo "\n";
    
    echo "5. TEST USER ACCESS:\n";
    echo "-----------------------------\n";
    
    $testUser = \App\Models\User::find('51c28366-acc4-4db2-aba5-82a581eeb061');
    if ($testUser) {
        echo "✅ Test user: {$testUser->name}\n";
        
        $hasAccess = \App\Models\Pembelian::forUser($testUser->id)
            ->forPackage($targetPaketId)
            ->verified()
            ->exists();
            
        echo "🎯 Has access: " . ($hasAccess ? 'YES' : 'NO') . "\n";
        
        if ($hasAccess) {
            echo "\n🎉 TOMBOL TANDAI SELESAI SEKARANG AKTIF!\n";
            echo "✅ User punya akses ke paket\n";
            echo "✅ Semua material设置为 is_completable = true\n";
            echo "✅ Tombol akan muncul di sidebar dan module list\n\n";
            
            echo "📋 URLS UNTUK TEST:\n";
            foreach ($verifiedMaterials as $material) {
                echo "   {$material->title}: /materials/{$material->id}\n";
            }
        } else {
            echo "⚠️  User tidak punya akses ke paket ini\n";
        }
    }
    
    echo "\n=== PERBAIKAN SELESAI ===\n";
    echo "✅ Updated {$updated} materials dengan is_completable = true\n";
    echo "✅ Tombol 'Tandai Selesai' sekarang akan muncul untuk user yang punya akses\n";
    echo "✅ Fungsi tandai selesai siap untuk di-test\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}