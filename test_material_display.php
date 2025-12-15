<?php

/**
 * Simple test page to display materials directly
 * This bypasses all the complex controller logic and just shows what should be visible
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

$userEmail = 'padilzaki73@gmail.com';
$user = User::where('email', $userEmail)->first();

if (!$user) {
    die("User not found: $userEmail");
}

Auth::login($user);

// Get user's purchases
$purchasedPackages = Pembelian::forUser($user->id)
    ->verified()
    ->with('paketUjian')
    ->get()
    ->pluck('paketUjian')
    ->filter();

// Get materials user should see
$materials = collect();
if ($purchasedPackages->isNotEmpty()) {
    $packageIds = $purchasedPackages->pluck('id');
    $materials = Material::where(function($q) use ($packageIds) {
        $q->whereIn('batch_id', $packageIds)
          ->orWhereNull('batch_id');
    })->with(['tutor', 'batch'])->get();
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Material Display</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .material-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        .material-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .material-thumbnail {
            position: relative;
            height: 200px;
            overflow: hidden;
            background: #f8f9fa;
        }
        .material-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .placeholder-thumbnail {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .play-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .material-card:hover .play-overlay {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="mb-3">Test Material Display</h1>
                <p class="text-muted">This is a direct test to bypass all controller logic and show materials directly.</p>
            </div>
        </div>

        <!-- Debug Information -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-info-circle"></i> Debug Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>User:</strong> <?= $user->name ?> (<?= $user->email ?>)</p>
                        <p><strong>Authenticated:</strong> <?= Auth::check() ? 'Yes' : 'No' ?></p>
                        <p><strong>Email Verified:</strong> <?= $user->hasVerifiedEmail() ? 'Yes' : 'No' ?></p>
                        <p><strong>Purchased Packages:</strong> <?= $purchasedPackages->count() ?></p>
                        <?php if($purchasedPackages->isNotEmpty()): ?>
                            <ul>
                                <?php foreach($purchasedPackages as $package): ?>
                                    <li><?= $package->nama ?> (ID: <?= $package->id ?>)</li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <p><strong>Materials Found:</strong> <?= $materials->count() ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Materials Display -->
        <div class="row">
            <?php if($materials->isEmpty()): ?>
                <div class="col-12">
                    <div class="card text-center py-5">
                        <div class="card-body">
                            <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                            <h5>Tidak Ada Materi</h5>
                            <p class="text-muted">
                                <?php if($purchasedPackages->isEmpty()): ?>
                                    Anda belum membeli paket apapun.
                                <?php else: ?>
                                    Materi untuk paket yang Anda beli belum tersedia.
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach($materials as $material): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 material-card">
                            <div class="material-thumbnail">
                                <?php if($material->type === 'youtube' && $material->youtube_url): ?>
                                    <img src="<?= $material->getYoutubeThumbnail() ?>" alt="<?= $material->title ?>" class="card-img-top">
                                    <div class="play-overlay">
                                        <i class="fab fa-youtube fa-3x"></i>
                                    </div>
                                <?php elseif($material->thumbnail_path): ?>
                                    <img src="<?= asset('storage/' . $material->thumbnail_path) ?>" alt="<?= $material->title ?>" class="card-img-top">
                                <?php else: ?>
                                    <div class="placeholder-thumbnail">
                                        <i class="<?= $material->getTypeIcon() ?> fa-4x"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <span class="badge bg-primary"><?= ucfirst($material->type) ?></span>
                                    <?php if($material->mapel): ?>
                                        <span class="badge bg-info"><?= $material->mapel ?></span>
                                    <?php endif; ?>
                                    <?php if($material->batch): ?>
                                        <span class="badge bg-secondary"><?= $material->batch->nama ?></span>
                                    <?php endif; ?>
                                    <?php if($material->chapter_number): ?>
                                        <span class="badge bg-success">Bab <?= $material->chapter_number ?></span>
                                    <?php endif; ?>
                                </div>
                                <h5 class="card-title"><?= Str::limit($material->title, 60) ?></h5>
                                <p class="card-text text-muted small">
                                    <?= Str::limit($material->description, 100) ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-eye"></i> <?= number_format($material->views_count) ?> views
                                    </small>
                                    <?php if($material->duration_seconds): ?>
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> <?= $material->getFormattedDuration() ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                                <?php if($material->tutor): ?>
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> <?= $material->tutor->name ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-flex gap-2">
                                    <a href="/materials/<?= $material->id ?>" class="btn btn-primary btn-sm flex-grow-1">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <?php if($material->isDownloadable()): ?>
                                        <a href="/materials/<?= $material->id ?>/download" class="btn btn-secondary btn-sm" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Raw Data -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-database"></i> Raw Material Data</h5>
                    </div>
                    <div class="card-body">
                        <pre><?= htmlspecialchars(json_encode($materials->toArray(), JSON_PRETTY_PRINT)) ?></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>