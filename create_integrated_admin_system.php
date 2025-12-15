<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🚀 MEMBUAT SISTEM ADMIN TERINTEGRASI\n";
echo "=====================================\n\n";

// 1. Buat Course Management System
echo "1️⃣ Membuat Course Management System...\n";

try {
    // Course = Paket Ujian yang lebih terstruktur
    $courses = [
        [
            'nama' => 'Matematika Dasar',
            'deskripsi' => 'Kursus matematika dasar untuk persiapan ujian',
            'kategori' => 'Matematika',
            'level' => 'Dasar',
            'durasi' => '3 bulan',
            'is_active' => true,
        ],
        [
            'nama' => 'Fisika SMA',
            'deskripsi' => 'Kursus fisika untuk tingkat SMA',
            'kategori' => 'Fisika', 
            'level' => 'Menengah',
            'durasi' => '4 bulan',
            'is_active' => true,
        ],
        [
            'nama' => 'Kimia Dasar',
            'deskripsi' => 'Konsep dasar kimia untuk pemula',
            'kategori' => 'Kimia',
            'level' => 'Dasar', 
            'durasi' => '3 bulan',
            'is_active' => true,
        ],
    ];

    foreach ($courses as $courseData) {
        $course = App\Models\PaketUjian::create($courseData);
        echo "   ✅ Course: {$course->nama} (ID: {$course->id})\n";
    }

} catch (Exception $e) {
    echo "   ❌ Error creating courses: " . $e->getMessage() . "\n";
}

echo "\n2️⃣ Membuat Chapter Structure System...\n";

// 2. Buat Chapter Templates
$chapterTemplates = [
    'Matematika' => [
        [
            'chapter_number' => 1,
            'chapter_title' => 'Konsep Dasar',
            'description' => 'Pengenalan konsep fundamental',
            'learning_objectives' => [
                'Memahami konsep dasar',
                'Mampu menerapkan rumus sederhana',
                'Dapat menyelesaikan soal basic'
            ]
        ],
        [
            'chapter_number' => 2,
            'chapter_title' => 'Aplikasi Praktis',
            'description' => 'Penerapan konsep dalam kehidupan sehari-hari',
            'learning_objectives' => [
                'Dapat mengaplikasikan konsep',
                'Mampu menganalisis masalah',
                'Dapat menemukan solusi'
            ]
        ],
        [
            'chapter_number' => 3,
            'chapter_title' => 'Soal Lanjutan',
            'description' => 'Soal-soal dengan tingkat kesulitan tinggi',
            'learning_objectives' => [
                'Mampu menyelesaikan soal complex',
                'Dapat berpikir kritis',
                ' Siap untuk ujian'
            ]
        ]
    ]
];

try {
    // Simpan templates dalam file untuk referensi
    $templateFile = fopen('chapter_templates.json', 'w');
    fwrite($templateFile, json_encode($chapterTemplates, JSON_PRETTY_PRINT));
    fclose($templateFile);
    echo "   ✅ Chapter templates saved to chapter_templates.json\n";
} catch (Exception $e) {
    echo "   ❌ Error creating templates: " . $e->getMessage() . "\n";
}

echo "\n3️⃣ Membuat Integrated Admin Controller...\n";

// 3. Buat Admin Controller yang terintegrasi
$controllerContent = <<<'PHP'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaketUjian;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IntegratedCourseController extends Controller
{
    /**
     * Display integrated course management dashboard
     */
    public function dashboard()
    {
        $courses = PaketUjian::withCount('materials')->get();
        $totalMaterials = Material::count();
        $totalTutors = User::where('role', 'tutor')->count();
        
        return view('admin.integrated-dashboard', compact('courses', 'totalMaterials', 'totalTutors'));
    }

    /**
     * Show form untuk create/edit course dengan chapters dan materials
     */
    public function showIntegratedForm($courseId = null)
    {
        $course = $courseId ? PaketUjian::findOrFail($courseId) : null;
        $tutors = User::where('role', 'tutor')->get();
        $existingMaterials = $course ? Material::where('batch_id', $course->id)->get() : collect();
        
        return view('admin.integrated-course-form', compact('course', 'tutors', 'existingMaterials'));
    }

    /**
     * Store or update integrated course dengan chapters dan materials
     */
    public function storeIntegrated(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_description' => 'required|string',
            'category' => 'required|string',
            'level' => 'required|string',
            'chapters' => 'required|array',
            'chapters.*.title' => 'required|string',
            'chapters.*.materials' => 'required|array',
            'chapters.*.materials.*.title' => 'required|string',
            'chapters.*.materials.*.type' => 'required|in:youtube,document,link,video',
        ]);

        DB::beginTransaction();
        
        try {
            // 1. Create/Update Course
            $course = PaketUjian::updateOrCreate(
                ['id' => $request->course_id],
                [
                    'nama' => $request->course_name,
                    'deskripsi' => $request->course_description,
                    'kategori' => $request->category,
                    'level' => $request->level,
                    'is_active' => true,
                ]
            );

            // 2. Delete existing materials jika update
            if ($request->course_id) {
                Material::where('batch_id', $course->id)->delete();
            }

            // 3. Create Chapters dan Materials
            foreach ($request->chapters as $chapterIndex => $chapterData) {
                foreach ($chapterData['materials'] as $materialIndex => $materialData) {
                    Material::create([
                        'batch_id' => $course->id,
                        'tutor_id' => $request->tutor_id,
                        'title' => $materialData['title'],
                        'description' => $materialData['description'] ?? '',
                        'type' => $materialData['type'],
                        'mapel' => $request->category,
                        'chapter_number' => $chapterIndex + 1,
                        'chapter_title' => $chapterData['title'],
                        'material_order' => $materialIndex + 1,
                        'youtube_url' => $materialData['type'] === 'youtube' ? $materialData['content_url'] : null,
                        'file_path' => $materialData['type'] === 'document' ? $materialData['content_url'] : null,
                        'external_link' => $materialData['type'] === 'link' ? $materialData['content_url'] : null,
                        'is_public' => true,
                        'is_featured' => $materialIndex === 0, // First material in chapter = featured
                        'is_completable' => true,
                        'views_count' => 0,
                        'downloads_count' => 0,
                    ]);
                }
            }

            DB::commit();
            
            return redirect()->route('admin.integrated-dashboard')
                ->with('success', 'Course berhasil disimpan dengan semua materials!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Delete course dengan semua materials
     */
    public function deleteCourse($courseId)
    {
        DB::beginTransaction();
        
        try {
            // Delete materials first
            Material::where('batch_id', $courseId)->delete();
            
            // Delete course
            PaketUjian::where('id', $courseId)->delete();
            
            DB::commit();
            
            return redirect()->route('admin.integrated-dashboard')
                ->with('success', 'Course dan semua materials berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Quick duplicate course
     */
    public function duplicateCourse($courseId)
    {
        $originalCourse = PaketUjian::with('materials')->findOrFail($courseId);
        
        DB::beginTransaction();
        
        try {
            // Create new course
            $newCourse = PaketUjian::create([
                'nama' => $originalCourse->nama . ' (Copy)',
                'deskripsi' => $originalCourse->deskripsi,
                'kategori' => $originalCourse->kategori,
                'level' => $originalCourse->level,
                'is_active' => true,
            ]);

            // Copy materials
            foreach ($originalCourse->materials as $material) {
                $newMaterial = $material->replicate();
                $newMaterial->batch_id = $newCourse->id;
                $newMaterial->save();
            }
            
            DB::commit();
            
            return redirect()->route('admin.integrated-dashboard')
                ->with('success', 'Course berhasil diduplikasi!');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
PHP;

try {
    file_put_contents('app/Http/Controllers/Admin/IntegratedCourseController.php', $controllerContent);
    echo "   ✅ IntegratedCourseController created\n";
} catch (Exception $e) {
    echo "   ❌ Error creating controller: " . $e->getMessage() . "\n";
}

echo "\n4️⃣ Membuat Integrated Admin View...\n";

// 4. Buat View untuk integrated form
$formView = <<<'HTML'
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Integrated Course Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">
                <i class="fas fa-graduation-cap mr-2"></i>Integrated Course Management
            </h1>

            <form id="integratedForm" method="POST" action="{{ route('admin.integrated.store') }}">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id ?? '' }}">

                <!-- Course Information -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4 text-blue-600">
                        <i class="fas fa-book mr-2"></i>Course Information
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Course Name</label>
                            <input type="text" name="course_name" value="{{ $course->nama ?? '' }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="Matematika" {{ ($course->kategori ?? '') == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                                <option value="Fisika" {{ ($course->kategori ?? '') == 'Fisika' ? 'selected' : '' }}>Fisika</option>
                                <option value="Kimia" {{ ($course->kategori ?? '') == 'Kimia' ? 'selected' : '' }}>Kimia</option>
                                <option value="Bahasa Indonesia" {{ ($course->kategori ?? '') == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Level</label>
                            <select name="level" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="Dasar" {{ ($course->level ?? '') == 'Dasar' ? 'selected' : '' }}>Dasar</option>
                                <option value="Menengah" {{ ($course->level ?? '') == 'Menengah' ? 'selected' : '' }}>Menengah</option>
                                <option value="Lanjut" {{ ($course->level ?? '') == 'Lanjut' ? 'selected' : '' }}>Lanjut</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tutor</label>
                            <select name="tutor_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach($tutors as $tutor)
                                    <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="course_description" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $course->deskripsi ?? '' }}</textarea>
                    </div>
                </div>

                <!-- Chapters and Materials -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-blue-600">
                            <i class="fas fa-list mr-2"></i>Chapters & Materials
                        </h2>
                        <button type="button" onclick="addChapter()" 
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
                            <i class="fas fa-plus mr-2"></i>Add Chapter
                        </button>
                    </div>
                    
                    <div id="chaptersContainer">
                        <!-- Dynamic chapters will be added here -->
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex space-x-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-md">
                        <i class="fas fa-save mr-2"></i>Save Course
                    </button>
                    
                    <a href="{{ route('admin.integrated-dashboard') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        let chapterCounter = 0;
        let materialCounter = 0;

        function addChapter() {
            const container = document.getElementById('chaptersContainer');
            const chapterId = `chapter-${chapterCounter}`;
            
            const chapterHTML = `
                <div class="border border-gray-200 rounded-lg p-4 mb-4" id="${chapterId}">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-700">Chapter ${chapterCounter + 1}</h3>
                        <button type="button" onclick="removeChapter('${chapterId}')" 
                                class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Chapter Title</label>
                        <input type="text" name="chapters[${chapterCounter}][title]" 
                               placeholder="e.g., Chapter 1: Basic Concepts"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Chapter Description</label>
                        <textarea name="chapters[${chapterCounter}][description]" rows="2"
                                  placeholder="Brief description of this chapter"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-medium text-gray-600">Materials</h4>
                        <button type="button" onclick="addMaterial('${chapterId}')" 
                                class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded text-sm">
                            <i class="fas fa-plus mr-1"></i>Add Material
                        </button>
                    </div>
                    
                    <div id="materials-${chapterCounter}">
                        <!-- Materials will be added here -->
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', chapterHTML);
            
            // Add first material automatically
            addMaterialToChapter(chapterCounter);
            chapterCounter++;
        }

        function addMaterial(chapterId) {
            const chapterNum = chapterId.split('-')[1];
            addMaterialToChapter(chapterNum);
        }

        function addMaterialToChapter(chapterNum) {
            const container = document.getElementById(`materials-${chapterNum}`);
            const materialId = `material-${chapterNum}-${materialCounter}`;
            
            const materialHTML = `
                <div class="bg-gray-50 rounded p-3 mb-3" id="${materialId}">
                    <div class="flex justify-between items-start mb-3">
                        <h5 class="font-medium text-gray-600">Material ${materialCounter + 1}</h5>
                        <button type="button" onclick="removeMaterial('${materialId}')" 
                                class="text-red-500 hover:text-red-700 text-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Title</label>
                            <input type="text" name="chapters[${chapterNum}][materials][${materialCounter}][title]" 
                                   placeholder="Material title"
                                   class="w-full px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Type</label>
                            <select name="chapters[${chapterNum}][materials][${materialCounter}][type]" 
                                    class="w-full px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                                <option value="youtube">YouTube Video</option>
                                <option value="document">PDF Document</option>
                                <option value="link">External Link</option>
                                <option value="video">Video File</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Content URL</label>
                        <input type="url" name="chapters[${chapterNum}][materials][${materialCounter}][content_url]" 
                               placeholder="YouTube URL, PDF link, or external link"
                               class="w-full px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>
                    
                    <div class="mt-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Description</label>
                        <textarea name="chapters[${chapterNum}][materials][${materialCounter}][description]" rows="2"
                                  placeholder="Material description"
                                  class="w-full px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-blue-500"></textarea>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', materialHTML);
            materialCounter++;
        }

        function removeChapter(chapterId) {
            if (confirm('Are you sure you want to remove this chapter?')) {
                document.getElementById(chapterId).remove();
            }
        }

        function removeMaterial(materialId) {
            if (confirm('Are you sure you want to remove this material?')) {
                document.getElementById(materialId).remove();
            }
        }

        // Initialize with one chapter
        addChapter();
    </script>
</body>
</html>
HTML;

try {
    // Create directory if not exists
    if (!file_exists('resources/views/admin')) {
        mkdir('resources/views/admin', 0755, true);
    }
    
    file_put_contents('resources/views/admin/integrated-course-form.blade.php', $formView);
    echo "   ✅ integrated-course-form.blade.php created\n";
} catch (Exception $e) {
    echo "   ❌ Error creating view: " . $e->getMessage() . "\n";
}

echo "\n5️⃣ Membuat Routes...\n";

// 5. Buat Routes untuk integrated system
$routesContent = <<<'PHP'
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IntegratedCourseController;

// Integrated Course Management Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Integrated Course Dashboard
    Route::get('/integrated-dashboard', [IntegratedCourseController::class, 'dashboard'])->name('integrated-dashboard');
    
    // Integrated Course Form
    Route::get('/integrated/course/create', [IntegratedCourseController::class, 'showIntegratedForm'])->name('integrated.create');
    Route::get('/integrated/course/{courseId}/edit', [IntegratedCourseController::class, 'showIntegratedForm'])->name('integrated.edit');
    
    // Store/Update Course dengan semua materials
    Route::post('/integrated/course', [IntegratedCourseController::class, 'storeIntegrated'])->name('integrated.store');
    
    // Delete Course
    Route::delete('/integrated/course/{courseId}', [IntegratedCourseController::class, 'deleteCourse'])->name('integrated.delete');
    
    // Duplicate Course
    Route::post('/integrated/course/{courseId}/duplicate', [IntegratedCourseController::class, 'duplicateCourse'])->name('integrated.duplicate');
});
PHP;

try {
    file_put_contents('routes/integrated-admin.php', $routesContent);
    echo "   ✅ integrated-admin.php routes created\n";
} catch (Exception $e) {
    echo "   ❌ Error creating routes: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "🎉 INTEGRATED ADMIN SYSTEM CREATED!\n";
echo str_repeat("=", 50) . "\n\n";

echo "📋 What was created:\n";
echo "1. ✅ IntegratedCourseController.php - Centralized management\n";
echo "2. ✅ integrated-course-form.blade.php - Unified form interface\n";
echo "3. ✅ integrated-admin.php - Routes configuration\n";
echo "4. ✅ chapter_templates.json - Chapter templates\n\n";

echo "🚀 Next steps:\n";
echo "1. Add routes to web.php: require_once 'routes/integrated-admin.php';\n";
echo "2. Create dashboard view for integrated-dashboard route\n";
echo "3. Test the integrated form\n";
echo "4. Start managing courses with ONE interface!\n\n";

echo "💡 Key Features:\n";
echo "- 🎯 ONE form untuk manage Course + Chapters + Materials\n";
echo "- 📊 Centralized dashboard untuk semua courses\n";
echo "- ⚡ Quick duplicate course functionality\n";
echo "- 🗑️ Integrated delete course + materials\n";
echo "- 📱 Responsive design dengan Tailwind CSS\n";
echo "- 🔄 Dynamic form (add/remove chapters dan materials)\n";