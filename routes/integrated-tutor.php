<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tutor\IntegratedCourseController;

// Integrated Course Management Routes for Tutors
Route::prefix('tutor')->name('tutor.')->middleware(['auth', 'verified', 'role:tutor', 'profiled'])->group(function () {
    // Integrated Course Dashboard
    Route::get('/integrated-dashboard', [IntegratedCourseController::class, 'dashboard'])->name('integrated-dashboard');

    // Integrated Course Form
    Route::get('/integrated/course/create', [IntegratedCourseController::class, 'showIntegratedForm'])->name('integrated.create');
    Route::get('/integrated/course/{courseId}/edit', [IntegratedCourseController::class, 'showIntegratedForm'])->name('integrated.edit');

    // Store/Update Course dengan semua materials
    Route::post('/integrated/course', [IntegratedCourseController::class, 'storeIntegrated'])->name('integrated.store');

    // Quick Add Materials
    Route::get('/integrated/quick-add', [IntegratedCourseController::class, 'showQuickAddForm'])->name('integrated.quick-add');
    Route::post('/integrated/quick-add', [IntegratedCourseController::class, 'storeQuickAdd'])->name('integrated.quick-add.store');

    // Individual Material Management
    Route::get('/integrated/material/{materialId}/edit', [IntegratedCourseController::class, 'editMaterial'])->name('integrated.material.edit');
    Route::put('/integrated/material/{materialId}', [IntegratedCourseController::class, 'updateMaterial'])->name('integrated.material.update');
    Route::delete('/integrated/material/{materialId}', [IntegratedCourseController::class, 'deleteMaterial'])->name('integrated.material.delete');
});