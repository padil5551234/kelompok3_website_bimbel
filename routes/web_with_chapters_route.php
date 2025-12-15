// User Material routes
Route::prefix('materials')
    ->name('user.materials.')
    ->middleware(['auth', 'verified', 'profiled'])
    ->group(function () {
        Route::get('/', [App\Http\Controllers\UserMaterialController::class, 'index'])
            ->name('index');
        Route::get('/chapters', [App\Http\Controllers\UserMaterialController::class, 'chapters'])
            ->name('chapters');
        Route::get('/{material}', [App\Http\Controllers\UserMaterialController::class, 'show'])
            ->name('show');
        Route::get('/{material}/download', [App\Http\Controllers\UserMaterialController::class, 'download'])
            ->name('download');
        Route::get('/package/{packageId}', [App\Http\Controllers\UserMaterialController::class, 'getMaterialsByPackage'])
            ->name('by-package');
        
        // New routes for enhanced functionality
        Route::post('/upload', [App\Http\Controllers\UserMaterialController::class, 'uploadMaterial'])
            ->name('upload');
        Route::post('/{material}/complete', [App\Http\Controllers\UserMaterialController::class, 'completeMaterial'])
            ->name('complete');
        Route::get('/progress', [App\Http\Controllers\UserMaterialController::class, 'getProgress'])
            ->name('progress');
        Route::post('/certificate/{material?}', [App\Http\Controllers\UserMaterialController::class, 'generateCertificate'])
            ->name('certificate');
    });