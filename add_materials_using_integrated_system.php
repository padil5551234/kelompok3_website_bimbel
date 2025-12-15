<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "📚 MENAMBAHKAN MATERI MENGGUNAKAN INTEGRATED SYSTEM\n";
echo "===================================================\n\n";

// Ambil data tutor (fixed: remove role dependency)
try {
    $tutors = App\Models\User::all();
    $tutor = $tutors->first();
    
    if (!$tutor) {
        echo "❌ Tidak ada user ditemukan. Membuat user dummy...\n";
        $tutor = App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
    }
    
    echo "✅ User selected: {$tutor->name} (ID: {$tutor->id})\n";
} catch (Exception $e) {
    echo "❌ Error accessing users: " . $e->getMessage() . "\n";
    exit;
}

echo "\n🚀 MENAMBAHKAN COURSE CONTOH DENGAN STRUKTUR LENGKAP:\n";
echo "=======================================================\n\n";

// Course 1: Fisika SMA
echo "1️⃣ MEMBUAT COURSE: FISIKA SMA\n";
try {
    $course1 = App\Models\PaketUjian::create([
        'nama' => 'Fisika SMA Lengkap',
        'deskripsi' => 'Kursus fisika komprehensif untuk tingkat SMA dengan konsep dasar hingga lanjutan',
        'kategori' => 'Fisika',
        'level' => 'Menengah',
        'harga' => 500000,
        'is_active' => true,
    ]);
    
    echo "   ✅ Course created: {$course1->nama} (ID: {$course1->id})\n";
    
    // BAB 1: Mekanika
    $materials1 = [
        [
            'title' => 'Pengenalan Mekanika',
            'description' => 'Video pembelajaran dasar-dasar mekanika dalam fisika',
            'type' => 'youtube',
            'chapter_number' => 1,
            'chapter_title' => 'BAB 1: Mekanika',
            'material_order' => 1,
            'youtube_url' => 'https://www.youtube.com/watch?v=1C1nR_QiGqU',
        ],
        [
            'title' => 'Hukum Newton',
            'description' => 'Penjelasan lengkap tentang tiga hukum Newton dengan contoh',
            'type' => 'youtube',
            'chapter_number' => 1,
            'chapter_title' => 'BAB 1: Mekanika',
            'material_order' => 2,
            'youtube_url' => 'https://www.youtube.com/watch?v=FZ0yU4qM5zE',
        ],
        [
            'title' => 'Latihan Soal Mekanika',
            'description' => 'Kumpulan soal latihan mekanika dengan pembahasan',
            'type' => 'document',
            'chapter_number' => 1,
            'chapter_title' => 'BAB 1: Mekanika',
            'material_order' => 3,
            'file_path' => 'materials/fisika/mekanika-soal.pdf',
        ],
    ];
    
    // BAB 2: Termodinamika
    $materials2 = [
        [
            'title' => 'Konsep Suhu dan Kalor',
            'description' => 'Video pembelajaran tentang suhu, kalor, dan hubungannya',
            'type' => 'youtube',
            'chapter_number' => 2,
            'chapter_title' => 'BAB 2: Termodinamika',
            'material_order' => 1,
            'youtube_url' => 'https://www.youtube.com/watch?v=6RwGczuF9eQ',
        ],
        [
            'title' => 'Hukum Termodinamika',
            'description' => 'Penjelasan hukum I dan II termodinamika',
            'type' => 'youtube',
            'chapter_number' => 2,
            'chapter_title' => 'BAB 2: Termodinamika',
            'material_order' => 2,
            'youtube_url' => 'https://www.youtube.com/watch?v=0R-FpQ2zOws',
        ],
        [
            'title' => 'Materi PDF Termodinamika',
            'description' => 'Materi lengkap termodinamika dalam format PDF',
            'type' => 'document',
            'chapter_number' => 2,
            'chapter_title' => 'BAB 2: Termodinamika',
            'material_order' => 3,
            'file_path' => 'materials/fisika/termodinamika-materi.pdf',
        ],
    ];
    
    // BAB 3: Gelombang dan Optik
    $materials3 = [
        [
            'title' => 'Pengenalan Gelombang',
            'description' => 'Video pembelajaran dasar-dasar gelombang',
            'type' => 'youtube',
            'chapter_number' => 3,
            'chapter_title' => 'BAB 3: Gelombang dan Optik',
            'material_order' => 1,
            'youtube_url' => 'https://www.youtube.com/watch?v=2Xja1wz7KPs',
        ],
        [
            'title' => 'Cahaya dan Optik',
            'description' => 'Penjelasan tentang sifat cahaya dan optik geometris',
            'type' => 'youtube',
            'chapter_number' => 3,
            'chapter_title' => 'BAB 3: Gelombang dan Optik',
            'material_order' => 2,
            'youtube_url' => 'https://www.youtube.com/watch?v=Y8lF3b8hW2k',
        ],
        [
            'title' => 'Soal Latihan Gelombang',
            'description' => 'Bank soal gelombang dengan berbagai jenis',
            'type' => 'document',
            'chapter_number' => 3,
            'chapter_title' => 'BAB 3: Gelombang dan Optik',
            'material_order' => 3,
            'file_path' => 'materials/fisika/gelombang-soal.pdf',
        ],
    ];
    
    // Simpan semua materials
    $allMaterials = array_merge($materials1, $materials2, $materials3);
    
    foreach ($allMaterials as $materialData) {
        App\Models\Material::create([
            'batch_id' => $course1->id,
            'tutor_id' => $tutor->id,
            'title' => $materialData['title'],
            'description' => $materialData['description'],
            'type' => $materialData['type'],
            'mapel' => 'Fisika',
            'chapter_number' => $materialData['chapter_number'],
            'chapter_title' => $materialData['chapter_title'],
            'material_order' => $materialData['material_order'],
            'youtube_url' => $materialData['youtube_url'] ?? null,
            'file_path' => $materialData['file_path'] ?? null,
            'is_public' => true,
            'is_featured' => $materialData['material_order'] === 1,
            'is_completable' => true,
            'views_count' => 0,
            'downloads_count' => 0,
        ]);
    }
    
    echo "   ✅ Added " . count($allMaterials) . " materials untuk Fisika SMA\n";
    
} catch (Exception $e) {
    echo "   ❌ Error creating Fisika course: " . $e->getMessage() . "\n";
}

echo "\n2️⃣ MEMBUAT COURSE: KIMIA DASAR\n";
try {
    $course2 = App\Models\PaketUjian::create([
        'nama' => 'Kimia Dasar untuk Pemula',
        'deskripsi' => 'Kursus kimia fundamental untuk siswa SMA dan mahasiswa tahun pertama',
        'kategori' => 'Kimia',
        'level' => 'Dasar',
        'harga' => 400000,
        'is_active' => true,
    ]);
    
    echo "   ✅ Course created: {$course2->nama} (ID: {$course2->id})\n";
    
    // BAB 1: Struktur Atom
    $materials1 = [
        [
            'title' => 'Pengenalan Struktur Atom',
            'description' => 'Video pembelajaran tentang partikel-partikel penyusun atom',
            'type' => 'youtube',
            'chapter_number' => 1,
            'chapter_title' => 'BAB 1: Struktur Atom',
            'material_order' => 1,
            'youtube_url' => 'https://www.youtube.com/watch?v=7uKQgn4s7ZE',
        ],
        [
            'title' => 'Tabel Periodik',
            'description' => 'Penjelasan susunan dan cara membaca tabel periodik',
            'type' => 'youtube',
            'chapter_number' => 1,
            'chapter_title' => 'BAB 1: Struktur Atom',
            'material_order' => 2,
            'youtube_url' => 'https://www.youtube.com/watch?v=5dTHF9Z9Z8Y',
        ],
        [
            'title' => 'Latihan Soal Struktur Atom',
            'description' => 'Soal-soal latihan struktur atom dan tabel periodik',
            'type' => 'document',
            'chapter_number' => 1,
            'chapter_title' => 'BAB 1: Struktur Atom',
            'material_order' => 3,
            'file_path' => 'materials/kimia/struktur-atom-soal.pdf',
        ],
    ];
    
    // BAB 2: Ikatan Kimia
    $materials2 = [
        [
            'title' => 'Jenis-jenis Ikatan Kimia',
            'description' => 'Video pembelajaran tentang ikatan ionik, kovalen, dan logam',
            'type' => 'youtube',
            'chapter_number' => 2,
            'chapter_title' => 'BAB 2: Ikatan Kimia',
            'material_order' => 1,
            'youtube_url' => 'https://www.youtube.com/watch?v=Z8Q3H2yK8Ps',
        ],
        [
            'title' => 'Geometri Molekul',
            'description' => 'Penjelasan bentuk molekul berdasarkan teori VSEPR',
            'type' => 'youtube',
            'chapter_number' => 2,
            'chapter_title' => 'BAB 2: Ikatan Kimia',
            'material_order' => 2,
            'youtube_url' => 'https://www.youtube.com/watch?v=V9Q3H2yK9Qs',
        ],
        [
            'title' => 'Materi PDF Ikatan Kimia',
            'description' => 'Materi lengkap tentang ikatan kimia',
            'type' => 'document',
            'chapter_number' => 2,
            'chapter_title' => 'BAB 2: Ikatan Kimia',
            'material_order' => 3,
            'file_path' => 'materials/kimia/ikatan-kimia-materi.pdf',
        ],
    ];
    
    // BAB 3: Asam, Basa, dan Garam
    $materials3 = [
        [
            'title' => 'Konsep Asam dan Basa',
            'description' => 'Video pembelajaran tentang teori asam-basa Arrhenius, Bronsted-Lowry, dan Lewis',
            'type' => 'youtube',
            'chapter_number' => 3,
            'chapter_title' => 'BAB 3: Asam, Basa, dan Garam',
            'material_order' => 1,
            'youtube_url' => 'https://www.youtube.com/watch?v=8Q3H2yK9Rs',
        ],
        [
            'title' => 'pH dan pOH',
            'description' => 'Penjelasan konsep pH, pOH, dan perhitungan asam-basa',
            'type' => 'youtube',
            'chapter_number' => 3,
            'chapter_title' => 'BAB 3: Asam, Basa, dan Garam',
            'material_order' => 2,
            'youtube_url' => 'https://www.youtube.com/watch?v=9Q3H2yK9Ts',
        ],
        [
            'title' => 'Referensi Kimia Online',
            'description' => 'Link ke sumber belajar kimia online yang terpercaya',
            'type' => 'link',
            'chapter_number' => 3,
            'chapter_title' => 'BAB 3: Asam, Basa, dan Garam',
            'material_order' => 3,
            'external_link' => 'https://www.khanacademy.org/science/chemistry',
        ],
    ];
    
    // Simpan semua materials
    $allMaterials = array_merge($materials1, $materials2, $materials3);
    
    foreach ($allMaterials as $materialData) {
        App\Models\Material::create([
            'batch_id' => $course2->id,
            'tutor_id' => $tutor->id,
            'title' => $materialData['title'],
            'description' => $materialData['description'],
            'type' => $materialData['type'],
            'mapel' => 'Kimia',
            'chapter_number' => $materialData['chapter_number'],
            'chapter_title' => $materialData['chapter_title'],
            'material_order' => $materialData['material_order'],
            'youtube_url' => $materialData['youtube_url'] ?? null,
            'file_path' => $materialData['file_path'] ?? null,
            'external_link' => $materialData['external_link'] ?? null,
            'is_public' => true,
            'is_featured' => $materialData['material_order'] === 1,
            'is_completable' => true,
            'views_count' => 0,
            'downloads_count' => 0,
        ]);
    }
    
    echo "   ✅ Added " . count($allMaterials) . " materials untuk Kimia Dasar\n";
    
} catch (Exception $e) {
    echo "   ❌ Error creating Kimia course: " . $e->getMessage() . "\n";
}

echo "\n3️⃣ MEMBUAT COURSE: BAHASA INGGRIS\n";
try {
    $course3 = App\Models\PaketUjian::create([
        'nama' => 'English for Academic Purposes',
        'deskripsi' => 'Kursus bahasa Inggris untuk keperluan akademik dan persiapan ujian internasional',
        'kategori' => 'Bahasa Inggris',
        'level' => 'Menengah',
        'harga' => 600000,
        'is_active' => true,
    ]);
    
    echo "   ✅ Course created: {$course3->nama} (ID: {$course3->id})\n";
    
    // BAB 1: Grammar Fundamentals
    $materials1 = [
        [
            'title' => 'Tenses Masterclass',
            'description' => 'Video pembelajaran semua jenis tenses dalam bahasa Inggris',
            'type' => 'youtube',
            'chapter_number' => 1,
            'chapter_title' => 'BAB 1: Grammar Fundamentals',
            'material_order' => 1,
            'youtube_url' => 'https://www.youtube.com/watch?v=6Q3H2yK9Us',
        ],
        [
            'title' => 'Advanced Grammar Rules',
            'description' => 'Video pembelajaran aturan grammar lanjutan',
            'type' => 'youtube',
            'chapter_number' => 1,
            'chapter_title' => 'BAB 1: Grammar Fundamentals',
            'material_order' => 2,
            'youtube_url' => 'https://www.youtube.com/watch?v=7Q3H2yK9Vs',
        ],
        [
            'title' => 'Grammar Exercise Book',
            'description' => 'PDF buku latihan grammar dengan 500+ soal',
            'type' => 'document',
            'chapter_number' => 1,
            'chapter_title' => 'BAB 1: Grammar Fundamentals',
            'material_order' => 3,
            'file_path' => 'materials/english/grammar-exercises.pdf',
        ],
    ];
    
    // BAB 2: Academic Writing
    $materials2 = [
        [
            'title' => 'Essay Writing Techniques',
            'description' => 'Video pembelajaran teknik menulis essay akademik',
            'type' => 'youtube',
            'chapter_number' => 2,
            'chapter_title' => 'BAB 2: Academic Writing',
            'material_order' => 1,
            'youtube_url' => 'https://www.youtube.com/watch?v=8Q3H2yK9Ws',
        ],
        [
            'title' => 'Research Paper Structure',
            'description' => 'Penjelasan struktur dan komponen penelitian akademik',
            'type' => 'youtube',
            'chapter_number' => 2,
            'chapter_title' => 'BAB 2: Academic Writing',
            'material_order' => 2,
            'youtube_url' => 'https://www.youtube.com/watch?v=9Q3H2yK9Xs',
        ],
        [
            'title' => 'Academic Writing Guide',
            'description' => 'Panduan lengkap menulis dalam bahasa Inggris akademik',
            'type' => 'document',
            'chapter_number' => 2,
            'chapter_title' => 'BAB 2: Academic Writing',
            'material_order' => 3,
            'file_path' => 'materials/english/academic-writing-guide.pdf',
        ],
    ];
    
    // BAB 3: Speaking and Pronunciation
    $materials3 = [
        [
            'title' => 'Pronunciation Mastery',
            'description' => 'Video pembelajaran cara pronounciation yang benar',
            'type' => 'youtube',
            'chapter_number' => 3,
            'chapter_title' => 'BAB 3: Speaking and Pronunciation',
            'material_order' => 1,
            'youtube_url' => 'https://www.youtube.com/watch?v=0Q3H2yK9Ys',
        ],
        [
            'title' => 'Presentation Skills',
            'description' => 'Video pembelajaran keterampilan presentasi dalam bahasa Inggris',
            'type' => 'youtube',
            'chapter_number' => 3,
            'chapter_title' => 'BAB 3: Speaking and Pronunciation',
            'material_order' => 2,
            'youtube_url' => 'https://www.youtube.com/watch?v=1Q3H2yK9Zs',
        ],
        [
            'title' => 'IELTS Speaking Practice',
            'description' => 'Latihan speaking untuk persiapan IELTS',
            'type' => 'link',
            'chapter_number' => 3,
            'chapter_title' => 'BAB 3: Speaking and Pronunciation',
            'material_order' => 3,
            'external_link' => 'https://www.ielts.org/about-ielts/prepare-for-ielts',
        ],
    ];
    
    // Simpan semua materials
    $allMaterials = array_merge($materials1, $materials2, $materials3);
    
    foreach ($allMaterials as $materialData) {
        App\Models\Material::create([
            'batch_id' => $course3->id,
            'tutor_id' => $tutor->id,
            'title' => $materialData['title'],
            'description' => $materialData['description'],
            'type' => $materialData['type'],
            'mapel' => 'Bahasa Inggris',
            'chapter_number' => $materialData['chapter_number'],
            'chapter_title' => $materialData['chapter_title'],
            'material_order' => $materialData['material_order'],
            'youtube_url' => $materialData['youtube_url'] ?? null,
            'file_path' => $materialData['file_path'] ?? null,
            'external_link' => $materialData['external_link'] ?? null,
            'is_public' => true,
            'is_featured' => $materialData['material_order'] === 1,
            'is_completable' => true,
            'views_count' => 0,
            'downloads_count' => 0,
        ]);
    }
    
    echo "   ✅ Added " . count($allMaterials) . " materials untuk English Course\n";
    
} catch (Exception $e) {
    echo "   ❌ Error creating English course: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "🎉 SELESAI! MATERI BERHASIL DITAMBAHKAN!\n";
echo str_repeat("=", 60) . "\n\n";

// Summary
try {
    $totalCourses = App\Models\PaketUjian::count();
    $totalMaterials = App\Models\Material::count();
    
    echo "📊 SUMMARY:\n";
    echo "Total Courses: {$totalCourses}\n";
    echo "Total Materials: {$totalMaterials}\n\n";
    
    echo "📚 COURSE YANG DIBUAT:\n";
    $courses = App\Models\PaketUjian::all();
    foreach ($courses as $course) {
        $materialsCount = App\Models\Material::where('batch_id', $course->id)->count();
        echo "- {$course->nama} ({$materialsCount} materials)\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error getting summary: " . $e->getMessage() . "\n";
}

echo "\n🎯 CARA AKSES:\n";
echo "1. Login sebagai admin\n";
echo "2. Buka: /admin/integrated-dashboard\n";
echo "3. Atau klik 'Integrated Courses' di sidebar menu\n";
echo "4. Lihat course baru yang sudah ditambahkan!\n\n";

echo "✨ FITUR YANG BISA DIGUNAKAN:\n";
echo "- 📊 View statistics di dashboard\n";
echo "- ➕ Add more chapters & materials\n";
echo "- ✏️ Edit course yang sudah ada\n";
echo "- 📋 Duplicate course untuk template\n";
echo "- 🗑️ Delete course yang tidak perlu\n\n";

echo "🚀 INTEGRATED SYSTEM SIAP DIGUNAKAN!\n";