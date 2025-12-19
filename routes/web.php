<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\PaketUjianController;
use App\Http\Controllers\Admin\PesertaUjianController;
use App\Http\Controllers\Admin\SoalController as SoalController_Admin;
use App\Http\Controllers\Admin\UjianController as UjianController_Admin;
use App\Http\Controllers\Admin\PembelianController as PembelianController_Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/sendEmail', [DashboardController::class, 'sendEmail'])->name(
    'sendEmail'
);
Route::get('/admin/dashboard', [DashboardController::class, 'adminIndex'])
    ->middleware('auth', 'verified', 'role:admin')
    ->name('admin.dashboard');

//route data user
Route::prefix('admin')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/user/data', [UserController::class, 'data'])->name(
            'user.data'
        );
        Route::get('/user/showDetails/{id}', [
            UserController::class,
            'showDetails',
        ])->name('user.showDetails');
        Route::get('/user/export', [UserController::class, 'export'])->name(
            'user.export'
        );
        Route::resource('user', UserController::class);
        Route::post('/user/resetPassword/{id}', [
            UserController::class,
            'resetPassword',
        ])->name('user.resetpassword');
        Route::post('/user/makeAdmin/{action}/{id}', [
            UserController::class,
            'makeAdmin',
        ])->name('user.makeAdmin');
    });

//route data admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/admin/data', [AdminController::class, 'data'])->name(
            'admin.data'
        );
        Route::post('/admin/getUser', [
            AdminController::class,
            'getUser',
        ])->name('admin.getUser');
        Route::resource('admin', AdminController::class);
        Route::post('/admin/resetPassword/{id}', [
            UserController::class,
            'resetPassword',
        ])->name('admin.resetpassword');
        Route::post('/admin/makeAdmin/{action}/{id}', [
            AdminController::class,
            'makeAdmin',
        ])->name('admin.makeAdmin');
    });

//route data tutor
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/tutor/data', [\App\Http\Controllers\Admin\TutorController::class, 'data'])->name(
            'tutor.data'
        );
        Route::get('/tutor/{tutor}/profile', [\App\Http\Controllers\Admin\TutorController::class, 'profile'])->name(
            'tutor.profile'
        );
        Route::put('/tutor/{tutor}/profile', [\App\Http\Controllers\Admin\TutorController::class, 'updateProfile'])->name(
            'tutor.updateProfile'
        );
        Route::resource('tutor', \App\Http\Controllers\Admin\TutorController::class);
        Route::post('/tutor/resetPassword/{tutor}', [
            \App\Http\Controllers\Admin\TutorController::class,
            'resetPassword',
        ])->name('tutor.resetpassword');
    });

// Chapter Pagination Routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/material/chapters', [\App\Http\Controllers\Admin\MaterialController::class, 'chapterPagination'])->name(
            'material.chapters'
        );
        Route::get('/material/chapter-stats', [\App\Http\Controllers\Admin\MaterialController::class, 'getChapterStats'])->name(
            'material.chapter-stats'
        );
        Route::post('/material/chapter/delete', [\App\Http\Controllers\Admin\MaterialController::class, 'deleteChapter'])->name(
            'material.chapter.delete'
        );
        Route::post('/material/chapter/renumber', [\App\Http\Controllers\Admin\MaterialController::class, 'renumberChapters'])->name(
            'material.chapter.renumber'
        );
    });

// route data material (Admin) - DISABLED: Using Integrated Course System instead
// Route::prefix('admin')
//     ->name('admin.')
//     ->middleware(['auth', 'verified', 'role:admin'])
//     ->group(function () {
//         Route::get('/material/data', [\App\Http\Controllers\Admin\MaterialController::class, 'data'])->name(
//             'material.data'
//         );
//         Route::post('/material/get-tutors', [\App\Http\Controllers\Admin\MaterialController::class, 'getTutors'])->name(
//             'material.get-tutors'
//         );
//         Route::get('/material/tutor/{tutor}', [\App\Http\Controllers\Admin\MaterialController::class, 'getMaterialsByTutor'])->name(
//             'material.by-tutor'
//         );
//         Route::post('/material/{material}/toggle-featured', [\App\Http\Controllers\Admin\MaterialController::class, 'toggleFeatured'])->name(
//             'material.toggle-featured'
//         );
//         Route::post('/material/{material}/toggle-public', [\App\Http\Controllers\Admin\MaterialController::class, 'togglePublic'])->name(
//             'material.toggle-public'
//         );
//         Route::resource('material', \App\Http\Controllers\Admin\MaterialController::class);
//     });

//route data voucher
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/voucher/data', [VoucherController::class, 'data'])->name(
            'voucher.data'
        );
        Route::resource('voucher', VoucherController::class);
    });

//route data paket ujian
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/paket/data', [PaketUjianController::class, 'data'])->name(
            'paket.data'
        );
        Route::resource('paket', PaketUjianController::class);
    });

//route data faq
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/faq/data', [
            \App\Http\Controllers\Admin\FaqController::class,
            'data',
        ])->name('faq.data');
        Route::post('/faq/{id}/pin', [
            \App\Http\Controllers\Admin\FaqController::class,
            'pin',
        ])->name('faq.pin');
        Route::resource(
            'faq',
            \App\Http\Controllers\Admin\FaqController::class
        );
    });

//route data testimonial
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/testimonial/data', [
            \App\Http\Controllers\Admin\TestimonialController::class,
            'data',
        ])->name('testimonial.data');
        Route::resource(
            'testimonial',
            \App\Http\Controllers\Admin\TestimonialController::class
        );
    });

//route data ujian
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/ujian/data', [UjianController_Admin::class, 'data'])->name(
            'ujian.data'
        );
        Route::get('/ujian/{id}/publish', [
            UjianController_Admin::class,
            'publish',
        ])->name('ujian.publish');
        Route::get('/ujian/{id}/preview', [
            UjianController_Admin::class,
            'preview',
        ])->name('ujian.preview');
        Route::post('/ujian/{id}/duplicate', [
            UjianController_Admin::class,
            'duplicate',
        ])->name('ujian.duplicate');
        Route::get('/ujian/{id}/packages', [
            UjianController_Admin::class,
            'getPackages',
        ])->name('ujian.packages');
        Route::resource('ujian', UjianController_Admin::class);
    });

//route data pembelian
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/pembelian/data', [
            PembelianController_Admin::class,
            'data',
        ])->name('pembelian.data');
        Route::post('/pembelian/getUser', [
            PembelianController_Admin::class,
            'getUser',
        ])->name('pembelian.getUser');
        Route::get('/pembelian/dataPaket', [
            PembelianController_Admin::class,
            'dataPaket',
        ])->name('pembelian.dataPaket');
        Route::get('/pembelian/getSummary/{id}', [
            PembelianController_Admin::class,
            'getSummary',
        ])->name('pembelian.getSummary');

        // Verifikasi pembayaran manual routes
        Route::get('/pembelian/verifikasi', [
            PembelianController_Admin::class,
            'verifikasi',
        ])->name('pembelian.verifikasi');
        Route::get('/pembelian/verifikasi/data', [
            PembelianController_Admin::class,
            'dataVerifikasi',
        ])->name('pembelian.verifikasi.data');
        Route::get('/pembelian/{id}/bukti', [
            PembelianController_Admin::class,
            'buktiTransfer',
        ])->name('pembelian.bukti');
        Route::post('/pembelian/{id}/proses-verifikasi', [
            PembelianController_Admin::class,
            'prosesVerifikasi',
        ])->name('pembelian.proses-verifikasi');

        Route::resource('pembelian', PembelianController_Admin::class);
    });

//route data peserta ujian
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/peserta_ujian/data', [
            PesertaUjianController::class,
            'data',
        ])->name('peserta_ujian.data');
        Route::get('/peserta_ujian/showdata/{id}', [
            PesertaUjianController::class,
            'showData',
        ])->name('peserta_ujian.show_data');
        Route::get('/peserta_ujian/{id}/rekap', [
            PesertaUjianController::class,
            'showPeserta',
        ])->name('peserta_ujian.show_peserta');
        Route::get('/peserta_ujian/showdatapeserta/{id}', [
            PesertaUjianController::class,
            'showDataPeserta',
        ])->name('peserta_ujian.show_data_peserta');
        Route::get('/peserta_ujian/{id}/refresh', [
            PesertaUjianController::class,
            'refresh',
        ])->name('peserta_ujian.refresh');
        Route::resource('peserta_ujian', PesertaUjianController::class, [
            'except' => 'destroy',
        ]);
        Route::delete('peserta_ujian/{ujian_id}/{user_id}', [
            PesertaUjianController::class,
            'destroy',
        ])
            ->middleware('role:admin')
            ->name('peserta_ujian.destroy');
    });

//route data soal
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/ujian/soal/data/{id}', [
            SoalController_Admin::class,
            'data',
        ])->name('soal.data');
        Route::post('/ujian/soal/upload-image', [SoalController_Admin::class, 'uploadImage'])->name('soal.upload-image');
        // Bulk import routes
        Route::get('/ujian/{id}/soal/bulk-import', [
            SoalController_Admin::class,
            'bulkImportForm',
        ])->name('ujian.soal.bulk-import');
        Route::post('/ujian/{id}/soal/bulk-import', [
            SoalController_Admin::class,
            'bulkImportStore',
        ])->name('ujian.soal.bulk-import.store');
        // Route::get('/ujian/soal/{id}', [SoalController::class, 'index'])->name('soal.index');
        Route::resource('ujian.soal', SoalController_Admin::class)->shallow();
    });

//route pembelian
Route::middleware(['auth', 'verified', 'profiled'])->group(function () {
    Route::resource('pembelian', PembelianController::class, [
        'only' => ['index', 'store', 'show'],
    ]);
    Route::post('/pembelian/pay', [PembelianController::class, 'pay'])->name(
        'pembelian.pay'
    );
    Route::post('/pembelian/applyVoucher', [
        PembelianController::class,
        'applyVoucher',
    ])->name('pembelian.applyVoucher');
    Route::post('/pembelian/upload-bukti', [
        PembelianController::class,
        'uploadBuktiTransfer',
    ])->name('pembelian.upload-bukti');
});

//route tryout
Route::middleware(['auth', 'verified', 'profiled'])->group(function () {
    Route::get('/tryout', [UjianController::class, 'index'])->name(
        'tryout.index'
    );
    Route::get('/tryout/{id}', [UjianController::class, 'show'])->name(
        'tryout.show'
    );
    Route::post('/tryout', [UjianController::class, 'post'])->name(
        'tryout.post'
    );
    Route::get('/{id}/tryout', [UjianController::class, 'index'])->name(
        'tryout.index.with.id'
    );
    Route::get('/tryout/{id}/pembahasan', [
        UjianController::class,
        'pembahasan',
    ])->name('tryout.pembahasan');
    Route::get('/tryout/{id}/nilai', [UjianController::class, 'nilai'])->name(
        'tryout.nilai'
    );
    Route::get('/ranking/global', [UjianController::class, 'rankingGlobal'])->name(
        'ranking.global'
    );
    Route::get('/progres-nilai', [UjianController::class, 'progresNilai'])->name(
        'progres.nilai'
    );
    // Route::resource('tryout', UjianController::class);
});

// Raport routes
Route::middleware(['auth', 'profiled'])->group(function () {
    Route::get('/raport', [RaportController::class, 'index'])->name('raport.index');
    Route::get('/raport/export-pdf', [RaportController::class, 'exportPdf'])->name('raport.export-pdf');
    Route::get('/raport/detail/{ujianUserId}', [RaportController::class, 'detailExam'])->name('raport.detail-exam');
});

//route ujian
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/ujian/{id}', [UjianController::class, 'ujian'])->name(
        'ujian.index'
    );
    Route::post('/ujian/store', [UjianController::class, 'store'])->name(
        'ujian.store'
    );
    Route::put('/ujian/mulaiujian/{id}', [
        UjianController::class,
        'mulaiUjian',
    ])->name('ujian.mulai');
    Route::put('/ujian/selesaiujian/{id}', [
        UjianController::class,
        'selesaiUjian',
    ])->name('ujian.selesai');
    Route::put('/ujian/storeragu/{id}', [
        UjianController::class,
        'storeRagu',
    ])->name('ujian.ragu');
    
    // Discussion access during test routes
    Route::get('/ujian/{ujianId}/pembahasan/{soalId}', [
        UjianController::class,
        'showPembahasanDuringTest',
    ])->name('ujian.pembahasan.during_test');
    Route::get('/ujian/{ujianId}/pembahasan-status', [
        UjianController::class,
        'getPembahasanAccessStatus',
    ])->name('ujian.pembahasan.status');
    // Discussion access after test completion
    Route::get('/ujian/{ujianId}/pembahasan-after/{soalId}', [
        UjianController::class,
        'showPembahasanAfterTest',
    ])->name('ujian.pembahasan.after_test');
    // Route::get('/ujian/nilai/{id}', [UjianController::class, 'nilai'])->name('ujian.nilai');
});

//route profile
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/profile/account', [UserController::class, 'account'])->name(
        'profile.account'
    );
    Route::post('/profile/peserta', [UserController::class, 'peserta'])->name(
        'profile.peserta'
    );
    Route::post('/profile/pendaftar', [
        UserController::class,
        'pendaftar',
    ])->name('profile.pendaftar');
    // Route::post('/profile/photo', [UserController::class, 'photo'])->name('profile.photo');
});

// Profile Detail dengan Integrasi Wilayah
use App\Http\Controllers\ProfileDetailController;
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/detail', [ProfileDetailController::class, 'edit'])->name('profile.detail.edit');
    Route::post('/profile/detail', [ProfileDetailController::class, 'update'])->name('profile.detail.update');
    Route::get('/profile/detail/kabupaten', [ProfileDetailController::class, 'getKabupaten'])->name('profile.detail.kabupaten');
    Route::get('/profile/detail/api/data', [ProfileDetailController::class, 'getProfileData'])->name('profile.detail.api.data');
});

//route faq
Route::get('/faq', [\App\Http\Controllers\FaqController::class, 'index'])->name(
    'faq.index'
);


//route pengumuman
Route::get('/pengumuman', [\App\Http\Controllers\PengumumanController::class, 'index'])->name(
    'pengumuman.index'
);

//route articles (public)
Route::get('/articles', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');

// SEO Routes
Route::get('/sitemap.xml', function () {
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // Homepage
    $sitemap .= '<url><loc>' . url('/') . '</loc><priority>1.0</priority><changefreq>daily</changefreq></url>' . "\n";

    // FAQ
    $sitemap .= '<url><loc>' . route('faq.index') . '</loc><priority>0.8</priority><changefreq>weekly</changefreq></url>' . "\n";

    // Pengumuman
    $sitemap .= '<url><loc>' . route('pengumuman.index') . '</loc><priority>0.8</priority><changefreq>weekly</changefreq></url>' . "\n";

    // Articles
    $articles = \App\Models\Article::where('is_published', true)->get();
    foreach ($articles as $article) {
        $sitemap .= '<url><loc>' . route('articles.show', $article->slug) . '</loc><priority>0.7</priority><changefreq>monthly</changefreq><lastmod>' . $article->updated_at->toISOString() . '</lastmod></url>' . "\n";
    }

    // Paket Ujian (jika ada)
    try {
        $paketUjian = \App\Models\PaketUjian::where('is_active', true)->get();
        foreach ($paketUjian as $paket) {
            $sitemap .= '<url><loc>' . route('tryout.index', ['paket' => $paket->id]) . '</loc><priority>0.8</priority><changefreq>weekly</changefreq></url>' . "\n";
        }
    } catch (\Exception $e) {
        // Skip if model doesn't exist
    }

    // Ranking Global
    $sitemap .= '<url><loc>' . route('ranking.global') . '</loc><priority>0.6</priority><changefreq>daily</changefreq></url>' . "\n";

    $sitemap .= '</urlset>';

    return response($sitemap, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

// Admin Article routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->group(function () {
        Route::get('/article/data', [\App\Http\Controllers\Admin\ArticleController::class, 'data'])->name('article.data');
        Route::resource('article', \App\Http\Controllers\Admin\ArticleController::class);
    });

// Learning Progress routes
Route::middleware(['auth', 'verified', 'profiled'])->group(function () {
    Route::get('/progress', [\App\Http\Controllers\LearningProgressController::class, 'index'])->name('progress.index');
    Route::post('/progress/record', [\App\Http\Controllers\LearningProgressController::class, 'record'])->name('progress.record');
    Route::get('/progress/data', [\App\Http\Controllers\LearningProgressController::class, 'getProgressData'])->name('progress.data');
});


Route::get('sessiondestroy', [UjianController::class, 'sessionDestroy'])->name(
    'session_destroy'
);
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name(
    'google.login'
);
Route::get('/auth/google/callback', [
    GoogleController::class,
    'handleGoogleCallback',
])->name('google.callback');

Route::get('/redirects', function () {
    $user = Auth::user();

    // If user is not authenticated, redirect to login
    if (!$user) {
        return redirect()->route('login');
    }

    // Role-based redirection
    if ($user->hasRole('tutor')) {
        return redirect()->route('tutor.dashboard');
    } elseif ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } else {
        // Regular user - redirect to main dashboard
        return redirect()->route('dashboard');
    }
});

// Tutor routes
Route::prefix('tutor')
    ->name('tutor.')
    ->middleware(['auth', 'verified', 'role:tutor'])
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Tutor\TutorController::class, 'dashboard'])
            ->name('dashboard');

        // Profile management
        Route::get('/profile', [App\Http\Controllers\Tutor\TutorController::class, 'profile'])
            ->name('profile');
        Route::put('/profile', [App\Http\Controllers\Tutor\TutorController::class, 'updateProfile'])
            ->name('profile.update');
        
        // Live Classes
        Route::resource('live-classes', App\Http\Controllers\Tutor\LiveClassController::class);
        Route::post('/live-classes/{liveClass}/start', [App\Http\Controllers\Tutor\LiveClassController::class, 'start'])
            ->name('live-classes.start');
        Route::post('/live-classes/{liveClass}/end', [App\Http\Controllers\Tutor\LiveClassController::class, 'end'])
            ->name('live-classes.end');
        Route::post('/live-classes/{liveClass}/cancel', [App\Http\Controllers\Tutor\LiveClassController::class, 'cancel'])
            ->name('live-classes.cancel');
        
        // Materials - DISABLED: Using Integrated Course System instead
        Route::resource('materials', App\Http\Controllers\Tutor\MaterialController::class);
        Route::get('/materials/{material}/download', [App\Http\Controllers\Tutor\MaterialController::class, 'download'])
            ->name('materials.download');
        Route::post('/materials/{material}/toggle-featured', [App\Http\Controllers\Tutor\MaterialController::class, 'toggleFeatured'])
            ->name('materials.toggle-featured');
        Route::post('/materials/{material}/toggle-public', [App\Http\Controllers\Tutor\MaterialController::class, 'togglePublic'])
            ->name('materials.toggle-public');
        Route::post('/materials/youtube-info', [App\Http\Controllers\Tutor\MaterialController::class, 'getYouTubeInfo'])
            ->name('materials.youtube-info');
        
    });

// User Material routes
Route::prefix('materials')
    ->name('user.materials.')
    ->middleware(['auth', 'verified', 'profiled'])
    ->group(function () {
        Route::get('/', [App\Http\Controllers\UserMaterialController::class, 'index'])
            ->name('index');
        Route::get('/{material}', [App\Http\Controllers\UserMaterialController::class, 'show'])
            ->name('show');
        Route::get('/{material}/download', [App\Http\Controllers\UserMaterialController::class, 'download'])
            ->name('download');
        Route::get('/package/{packageId}', [App\Http\Controllers\UserMaterialController::class, 'getMaterialsByPackage'])
            ->name('by-package');

        // Folders routes
        Route::get('/folders', [App\Http\Controllers\UserMaterialController::class, 'foldersIndex'])
            ->name('folders.index');
        Route::get('/folders/{folder}', [App\Http\Controllers\UserMaterialController::class, 'folderShow'])
            ->name('folders.show');
        Route::get('/folders/package/{packageId}', [App\Http\Controllers\UserMaterialController::class, 'getFoldersByPackage'])
            ->name('folders.by-package');
        Route::get('/folders/{folder}/materials', [App\Http\Controllers\UserMaterialController::class, 'getMaterialsByFolder'])
            ->name('folders.materials');

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


// User Live Zoom routes
Route::prefix('live-zoom')
    ->name('user.live-zoom.')
    ->middleware(['auth', 'verified', 'profiled'])
    ->group(function () {
        Route::get('/', [App\Http\Controllers\UserLiveClassController::class, 'index'])
            ->name('index');
        Route::get('/{liveClass}', [App\Http\Controllers\UserLiveClassController::class, 'show'])
            ->name('show');
    });

// Learning Module routes
Route::prefix('learning-modules')
    ->name('learning-modules.')
    ->middleware(['auth', 'verified', 'profiled'])
    ->group(function () {
        Route::get('/', [App\Http\Controllers\LearningModuleController::class, 'index'])
            ->name('index');
        Route::get('/{learningModule}', [App\Http\Controllers\LearningModuleController::class, 'show'])
            ->name('show');
        Route::get('/section/{section}', [App\Http\Controllers\LearningModuleController::class, 'showSection'])
            ->name('section');
        Route::get('/lesson/{lesson}', [App\Http\Controllers\LearningModuleController::class, 'showLesson'])
            ->name('lesson');
        
        // AJAX routes
        Route::get('/category/{category}', [App\Http\Controllers\LearningModuleController::class, 'getByCategory'])
            ->name('by-category');
        Route::get('/subject/{subject}', [App\Http\Controllers\LearningModuleController::class, 'getBySubject'])
            ->name('by-subject');
        Route::get('/{learningModule}/sections', [App\Http\Controllers\LearningModuleController::class, 'getSections'])
            ->name('sections');
        Route::get('/section/{section}/lessons', [App\Http\Controllers\LearningModuleController::class, 'getLessons'])
            ->name('lessons');
        Route::get('/featured', [App\Http\Controllers\LearningModuleController::class, 'featured'])
            ->name('featured');
        Route::post('/search', [App\Http\Controllers\LearningModuleController::class, 'search'])
            ->name('search');
        Route::get('/{learningModule}/progress', [App\Http\Controllers\LearningModuleController::class, 'getProgress'])
            ->name('progress');
    });

use App\Models\Material;
use App\Models\PaketUjian;
use App\Models\Pembelian;
use App\Models\User;

// Direct Material Test Route - Bypasses all logic
Route::get('/materials-test', function() {
    // Get the test user
    $user = User::where('email', 'padilzaki73@gmail.com')->first();
    if (!$user) {
        return "User not found!";
    }

    \Illuminate\Support\Facades\Auth::login($user);

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

    $html = "<!DOCTYPE html>
<html>
<head>
    <title>Direct Material Test</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body>
    <div class='container mt-5'>
        <h1>Direct Material Test</h1>
        <p><strong>User:</strong> " . $user->name . " (" . $user->email . ")</p>
        <p><strong>Authenticated:</strong> " . (\Illuminate\Support\Facades\Auth::check() ? "Yes" : "No") . "</p>
        <p><strong>Purchased Packages:</strong> " . $purchasedPackages->count() . "</p>
        <p><strong>Materials Found:</strong> " . $materials->count() . "</p>
        
        <hr>
        
        <h2>Materials:</h2>";

    if ($materials->isEmpty()) {
        $html .= "<div class='alert alert-warning'>No materials found!</div>";
    } else {
        foreach ($materials as $material) {
            $html .= "<div class='card mb-3'>";
            $html .= "<div class='card-body'>";
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
})->middleware(['auth', 'verified'])->name('materials.test');



require_once __DIR__ . '/jetstream.php';

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::group(['middleware' => ['can:publish articles']], function () {
//     //
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// Storage file serving route (alternative for hosting without symlink support)
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);

    if (!file_exists($fullPath)) {
        abort(404);
    }

    return response()->file($fullPath);
})->where('path', '.*');

// Integrated Admin Routes
require_once __DIR__ . '/integrated-admin.php';

// Integrated Tutor Routes
require_once __DIR__ . '/integrated-tutor.php';

Route::get('/admin/material/next-chapter/{batch_id}', [App\Http\Controllers\Admin\MaterialController::class, 'getNextChapter'])->name('admin.material.next-chapter');
