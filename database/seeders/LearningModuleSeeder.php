<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningModule;
use App\Models\LearningModuleSection;
use App\Models\LearningModuleLesson;

class LearningModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createSKDModules();
        $this->createMatematikaTerantungModules();
    }

    /**
     * Create SKD learning modules
     */
    private function createSKDModules()
    {
        // SKD TIU Module
        $tiuModule = LearningModule::create([
            'title' => 'Tes Intelegensi Umum (TIU)',
            'subtitle' => 'Materi Lengkap SKD - TIU',
            'description' => 'Modul pembelajaran komprehensif untuk Tes Intelegensi Umum dalam Seleksi Kompetensi Dasar. Mencakup semua aspek kemampuan intelektual yang diperlukan.',
            'category' => 'SKD',
            'subject' => 'TIU',
            'color' => '#007bff',
            'icon' => 'fas fa-brain',
            'order_number' => 1,
            'estimated_duration' => 480, // 8 jam
            'total_sections' => 0, // Will be updated
            'total_lessons' => 0, // Will be updated
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => true,
            'is_free' => false,
            'learning_objectives' => [
                'Meningkatkan kemampuan verbal',
                'Mengasah kemampuan numerik',
                'Mengembangkan kemampuan figural',
                'Menguasai strategi mengerjakan soal TIU',
                'Meningkatkan kecepatan dan ketepatan jawaban'
            ],
            'prerequisites' => ['Pemahaman dasar matematika', 'Kemampuan membaca pemahaman'],
            'introduction_text' => 'Selamat datang di modul TIU! Modul ini dirancang khusus untuk membantu Anda menguasai semua aspek Tes Intelegensi Umum.',
            'intro_video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
        ]);

        // SKD TKP Module
        $tkpModule = LearningModule::create([
            'title' => 'Tes Karakteristik Pribadi (TKP)',
            'subtitle' => 'Materi Lengkap SKD - TKP',
            'description' => 'Modul pembelajaran untuk Tes Karakteristik Pribadi yang menguji aspek kepribadian dan kesesuaian dengan posisi publik.',
            'category' => 'SKD',
            'subject' => 'TKP',
            'color' => '#28a745',
            'icon' => 'fas fa-user-tie',
            'order_number' => 2,
            'estimated_duration' => 360, // 6 jam
            'total_sections' => 0,
            'total_lessons' => 0,
            'difficulty_level' => 'beginner',
            'is_published' => true,
            'is_featured' => true,
            'is_free' => false,
            'learning_objectives' => [
                'Memahami konsep kepribadian dalam konteks kerja publik',
                'Mengembangkan karakteristik yang dibutuhkan',
                'Menguasai teknik menjawab soal TKP',
                'Meningkatkan self-awareness dan emotional intelligence'
            ],
            'prerequisites' => ['Pemahaman diri yang baik', 'Sikap terbuka untuk berkembang'],
            'introduction_text' => 'Modul TKP akan membantu Anda memahami dan mengembangkan karakteristik pribadi yang sesuai dengan pelayanan publik.',
        ]);

        // SKD TKA Module
        $tkaModule = LearningModule::create([
            'title' => 'Tes Kompetensi Akademik (TKA)',
            'subtitle' => 'Materi Lengkap SKD - TKA',
            'description' => 'Modul pembelajaran untuk Tes Kompetensi Akademik yang menguji pengetahuan umum dan kemampuan akademik.',
            'category' => 'SKD',
            'subject' => 'TKA',
            'color' => '#dc3545',
            'icon' => 'fas fa-graduation-cap',
            'order_number' => 3,
            'estimated_duration' => 600, // 10 jam
            'total_sections' => 0,
            'total_lessons' => 0,
            'difficulty_level' => 'advanced',
            'is_published' => true,
            'is_featured' => false,
            'is_free' => false,
            'learning_objectives' => [
                'Memperluas pengetahuan umum',
                'Mengasah kemampuan berpikir kritis',
                'Menguasai materi akademik dasar',
                'Mengembangkan strategi mengerjakan soal TKA'
            ],
            'prerequisites' => ['Pendidikan minimal SMA/sederajat', 'Minat dalam pengembangan intelektual'],
            'introduction_text' => 'TKA menguji kompetensi akademik Anda. Modul ini akan membekali Anda dengan pengetahuan yang komprehensif.',
        ]);

        // Create sections for TIU module
        $this->createTIUSections($tiuModule);
        $this->createTKPSections($tkpModule);
        $this->createTKASections($tkaModule);
    }

    /**
     * Create MATEMATIKA TERANTUNG modules
     */
    private function createMatematikaTerantungModules()
    {
        // Aljabar Module
        $aljabarModule = LearningModule::create([
            'title' => 'Aljabar Dasar dan Lanjutan',
            'subtitle' => 'Materi Matematika Terantung - Aljabar',
            'description' => 'Modul pembelajaran komprehensif untuk materi aljabar, dari konsep dasar hingga lanjutan.',
            'category' => 'MATEMATIKA_TERANTUNG',
            'subject' => 'ALJABAR',
            'color' => '#6f42c1',
            'icon' => 'fas fa-calculator',
            'order_number' => 4,
            'estimated_duration' => 540, // 9 jam
            'total_sections' => 0,
            'total_lessons' => 0,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => true,
            'is_free' => true,
            'learning_objectives' => [
                'Memahami konsep dasar aljabar',
                'Menguasai operasi aljabar',
                'Mampu menyelesaikan persamaan dan pertidaksamaan',
                'Mengaplikasikan aljabar dalam kehidupan sehari-hari'
            ],
            'prerequisites' => ['Pemahaman matematika SMP', 'Kemampuan berhitung dasar'],
            'introduction_text' => 'Aljabar adalah fondasi matematika yang akan membantu Anda dalam banyak aspek жизни.',
        ]);

        // Geometri Module
        $geometriModule = LearningModule::create([
            'title' => 'Geometri Datar dan Ruang',
            'subtitle' => 'Materi Matematika Terantung - Geometri',
            'description' => 'Modul pembelajaran geometri yang mencakup bangun datar, bangun ruang, dan aplikasinya.',
            'category' => 'MATEMATIKA_TERANTUNG',
            'subject' => 'GEOMETRI',
            'color' => '#fd7e14',
            'icon' => 'fas fa-shapes',
            'order_number' => 5,
            'estimated_duration' => 480, // 8 jam
            'total_sections' => 0,
            'total_lessons' => 0,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'is_free' => true,
            'learning_objectives' => [
                'Memahami sifat-sifat bangun datar',
                'Menghitung luas dan keliling',
                'Memahami konsep bangun ruang',
                'Menghitung volume dan luas permukaan'
            ],
            'prerequisites' => ['Pemahaman operasi dasar', 'Kemampuan visualisasi ruang'],
            'introduction_text' => 'Geometri membantu kita memahami bentuk dan ukuran di sekitar kita.',
        ]);

        // Trigonometri Module
        $trigonometriModule = LearningModule::create([
            'title' => 'Trigonometri dan Aplikasinya',
            'subtitle' => 'Materi Matematika Terantung - Trigonometri',
            'description' => 'Modul pembelajaran trigonometri dari dasar hingga aplikasi dalam kehidupan nyata.',
            'category' => 'MATEMATIKA_TERANTUNG',
            'subject' => 'TRIGONOMETRI',
            'color' => '#20c997',
            'icon' => 'fas fa-angle-up',
            'order_number' => 6,
            'estimated_duration' => 420, // 7 jam
            'total_sections' => 0,
            'total_lessons' => 0,
            'difficulty_level' => 'advanced',
            'is_published' => true,
            'is_featured' => false,
            'is_free' => false,
            'learning_objectives' => [
                'Memahami konsep sudut dan fungsi trigonometri',
                'Menguasai identitas trigonometri',
                'Mampu menyelesaikan persamaan trigonometri',
                'Mengaplikasikan trigonometri dalam kehidupan'
            ],
            'prerequisites' => ['Pemahaman aljabar dasar', 'Pemahaman geometri'],
            'introduction_text' => 'Trigonometri adalah cabang matematika yang mempelajari hubungan sudut dan sisi dalam segitiga.',
        ]);

        // Create sections for Math modules
        $this->createAljabarSections($aljabarModule);
        $this->createGeometriSections($geometriModule);
        $this->createTrigonometriSections($trigonometriModule);
    }

    /**
     * Create sections for TIU module
     */
    private function createTIUSections($module)
    {
        // Verbal Section
        $verbalSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Kemampuan Verbal',
            'subtitle' => 'Analogi, Sinonim, Antonim, dan Pemahaman Bacaan',
            'description' => 'Section yang menguji kemampuan verbal termasuk analogi, sinonim, antonim, dan pemahaman bacaan.',
            'order_number' => 1,
            'estimated_duration' => 160, // 160 menit
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Menguasai pola analogi',
                'Memahami sinonim dan antonim',
                'Mengasah kemampuan pemahaman bacaan'
            ],
            'introduction_text' => 'Kemampuan verbal sangat penting untuk komunikasi dan pemahaman informasi.',
        ]);

        // Create lessons for Verbal section
        $this->createVerbalLessons($verbalSection);

        // Numerik Section
        $numerikSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Kemampuan Numerik',
            'subtitle' => 'Aritmatika, Aljabar, dan Geometri Dasar',
            'description' => 'Section yang menguji kemampuan numerik meliputi aritmatika, aljabar, dan geometri dasar.',
            'order_number' => 2,
            'estimated_duration' => 160,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Menguasai operasi aritmatika',
                'Memahami konsep aljabar dasar',
                'Menghitung geometri sederhana'
            ],
            'introduction_text' => 'Kemampuan numerik menguji ketelitian dan kecepatan dalam berhitung.',
        ]);

        $this->createNumerikLessons($numerikSection);

        // Figural Section
        $figuralSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Kemampuan Figural',
            'subtitle' => 'Pola Gambar dan Hubungan Visual',
            'description' => 'Section yang menguji kemampuan figural termasuk pola gambar dan hubungan visual.',
            'order_number' => 3,
            'estimated_duration' => 160,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Mengidentifikasi pola gambar',
                'Memahami hubungan visual',
                'Mengasah kemampuan spasial'
            ],
            'introduction_text' => 'Kemampuan figural menguji daya ingat visual dan kemampuan menganalisis pola.',
        ]);

        $this->createFiguralLessons($figuralSection);

        // Update module counts
        $module->updateCounts();
    }

    /**
     * Create sections for TKP module
     */
    private function createTKPSections($module)
    {
        // Public Service Section
        $publicServiceSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Pelayanan Publik',
            'subtitle' => 'Etika dan Kualitas Pelayanan',
            'description' => 'Section yang menguji pemahaman tentang pelayanan publik dan etika profesi.',
            'order_number' => 1,
            'estimated_duration' => 120,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Memahami etika pelayanan publik',
                'Mengembangkan sikap melayani',
                'Memahami kualitas pelayanan'
            ],
            'introduction_text' => 'Pelayanan publik adalah inti dari pekerjaan ASN.',
        ]);

        $this->createPublicServiceLessons($publicServiceSection);

        // Professional Behavior Section
        $professionalSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Perilaku Profesional',
            'subtitle' => 'Integritas dan Tanggung Jawab',
            'description' => 'Section yang menguji pemahaman tentang perilaku profesional dan integritas.',
            'order_number' => 2,
            'estimated_duration' => 120,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Memahami integritas',
                'Mengembangkan tanggung jawab',
                'Memahami etika kerja'
            ],
            'introduction_text' => 'Perilaku profesional adalah fondasi karir yang sukses.',
        ]);

        $this->createProfessionalLessons($professionalSection);

        // Social Awareness Section
        $socialSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Kesadaran Sosial',
            'subtitle' => 'Empati dan Kerjasama',
            'description' => 'Section yang menguji kesadaran sosial dan kemampuan berinteraksi dengan masyarakat.',
            'order_number' => 3,
            'estimated_duration' => 120,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Mengembangkan empati',
                'Memahami pentingnya kerjasama',
                'Meningkatkan kesadaran sosial'
            ],
            'introduction_text' => 'Kesadaran sosial penting untuk memahami kebutuhan masyarakat.',
        ]);

        $this->createSocialAwarenessLessons($socialSection);

        $module->updateCounts();
    }

    /**
     * Create sections for TKA module
     */
    private function createTKASections($module)
    {
        // General Knowledge Section
        $generalSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Pengetahuan Umum',
            'subtitle' => 'Sejarah, Geografi, dan Iptek',
            'description' => 'Section yang menguji pengetahuan umum tentang sejarah, geografi, dan ilmu pengetahuan.',
            'order_number' => 1,
            'estimated_duration' => 200,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Memahami sejarah Indonesia',
                'Mengenal geografi Indonesia',
                'Memahami perkembangan iptek'
            ],
            'introduction_text' => 'Pengetahuan umum adalah bekal untuk menjadi warga negara yang baik.',
        ]);

        $this->createGeneralKnowledgeLessons($generalSection);

        // Current Affairs Section
        $currentSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Aktualita',
            'subtitle' => 'Peristiwa Terkini dan Isu Nasional',
            'description' => 'Section yang menguji pemahaman tentang peristiwa terkini dan isu-isu nasional.',
            'order_number' => 2,
            'estimated_duration' => 200,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Memahami peristiwa terkini',
                'Menganalisis isu nasional',
                'Mengembangkan pola pikir kritis'
            ],
            'introduction_text' => 'Aktualita menguji kemampuan kita untuk mengikuti perkembangan zaman.',
        ]);

        $this->createCurrentAffairsLessons($currentSection);

        // Critical Thinking Section
        $criticalSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Berpikir Kritis',
            'subtitle' => 'Analisis dan Evaluasi Informasi',
            'description' => 'Section yang menguji kemampuan berpikir kritis dalam menganalisis dan mengevaluasi informasi.',
            'order_number' => 3,
            'estimated_duration' => 200,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Mengembangkan kemampuan analisis',
                'Memahami evaluasi informasi',
                'Mengasah kemampuan berpikir logis'
            ],
            'introduction_text' => 'Berpikir kritis adalah kunci untuk membuat keputusan yang tepat.',
        ]);

        $this->createCriticalThinkingLessons($criticalSection);

        $module->updateCounts();
    }

    /**
     * Create sections for Aljabar module
     */
    private function createAljabarSections($module)
    {
        // Basic Algebra Section
        $basicSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Aljabar Dasar',
            'subtitle' => 'Konsep dan Operasi Dasar',
            'description' => 'Section yang membahas konsep dasar aljabar dan operasinya.',
            'order_number' => 1,
            'estimated_duration' => 180,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Memahami variabel dan konstanta',
                'Menguasai operasi aljabar dasar',
                'Memahami konsep persamaan'
            ],
            'introduction_text' => 'Aljabar dasar adalah fondasi untuk semua materi matematika lanjutan.',
        ]);

        $this->createBasicAlgebraLessons($basicSection);

        // Equations Section
        $equationSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Persamaan dan Pertidaksamaan',
            'subtitle' => 'Linear, Kuadrat, dan Sistem Persamaan',
            'description' => 'Section yang membahas berbagai jenis persamaan dan pertidaksamaan.',
            'order_number' => 2,
            'estimated_duration' => 180,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Memahami persamaan linear',
                'Memahami persamaan kuadrat',
                'Menguasai sistem persamaan'
            ],
            'introduction_text' => 'Persamaan adalah alat untuk memecahkan berbagai masalah matematika.',
        ]);

        $this->createEquationLessons($equationSection);

        // Functions Section
        $functionSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Fungsi dan Grafik',
            'subtitle' => 'Konsep Fungsi dan Visualisasinya',
            'description' => 'Section yang membahas konsep fungsi dan cara menggambarkannya.',
            'order_number' => 3,
            'estimated_duration' => 180,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Memahami konsep fungsi',
                'Mengenal jenis-jenis fungsi',
                'Mampu menggambar grafik fungsi'
            ],
            'introduction_text' => 'Fungsi adalah relasi khusus yang sangat penting dalam matematika.',
        ]);

        $this->createFunctionLessons($functionSection);

        $module->updateCounts();
    }

    /**
     * Create sections for Geometri module
     */
    private function createGeometriSections($module)
    {
        // 2D Geometry Section
        $twoDSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Geometri Datar',
            'subtitle' => 'Bangun Datar dan Sifat-sifatnya',
            'description' => 'Section yang membahas berbagai bangun datar dan sifat-sifatnya.',
            'order_number' => 1,
            'estimated_duration' => 160,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Memahami sifat bangun datar',
                'Menghitung luas dan keliling',
                'Menerapkan teorema Pythagoras'
            ],
            'introduction_text' => 'Geometri datar adalah dasar untuk memahami bentuk-bentuk di sekitar kita.',
        ]);

        $this->create2DGeometryLessons($twoDSection);

        // 3D Geometry Section
        $threeDSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Geometri Ruang',
            'subtitle' => 'Bangun Ruang dan Volumenya',
            'description' => 'Section yang membahas bangun ruang dan cara menghitung volumenya.',
            'order_number' => 2,
            'estimated_duration' => 160,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Memahami sifat bangun ruang',
                'Menghitung volume dan luas permukaan',
                'Memahami irisan dan proyeksi'
            ],
            'introduction_text' => 'Geometri ruang membantu kita memahami objek-objek tiga dimensi.',
        ]);

        $this->create3DGeometryLessons($threeDSection);

        // Coordinate Geometry Section
        $coordinateSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Geometri Koordinat',
            'subtitle' => 'Sistem Koordinat dan Aplikasinya',
            'description' => 'Section yang membahas sistem koordinat dan aplikasinya dalam geometri.',
            'order_number' => 3,
            'estimated_duration' => 160,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Memahami sistem koordinat',
                'Menghitung jarak dan sudut',
                'Menerapkan geometri analitik'
            ],
            'introduction_text' => 'Geometri koordinat menghubungkan aljabar dengan geometri.',
        ]);

        $this->createCoordinateGeometryLessons($coordinateSection);

        $module->updateCounts();
    }

    /**
     * Create sections for Trigonometri module
     */
    private function createTrigonometriSections($module)
    {
        // Basic Trigonometry Section
        $basicSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Trigonometri Dasar',
            'subtitle' => 'Fungsi Trigonometri dan Sudut',
            'description' => 'Section yang membahas dasar-dasar trigonometri dan fungsi-fungsinya.',
            'order_number' => 1,
            'estimated_duration' => 140,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Memahami definisi sinus, cosinus, tangen',
                'Mengenal nilai-nilai trigonometri sudut istimewa',
                'Memahami konsep radian dan derajat'
            ],
            'introduction_text' => 'Trigonometri adalah bahasa matematika untuk memahami hubungan sudut dan sisi.',
        ]);

        $this->createBasicTrigonometryLessons($basicSection);

        // Trigonometric Identities Section
        $identitySection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Identitas Trigonometri',
            'subtitle' => 'Rumus dan Identitas Penting',
            'description' => 'Section yang membahas identitas-identitas trigonometri dan rumus-rumus penting.',
            'order_number' => 2,
            'estimated_duration' => 140,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Menguasai identitas dasar trigonometri',
                'Memahami rumus penjumlahan dan selisih',
                'Menerapkan identitas dalam perhitungan'
            ],
            'introduction_text' => 'Identitas trigonometri adalah alat untuk menyederhanakan ekspresi trigonometri.',
        ]);

        $this->createTrigonometricIdentitiesLessons($identitySection);

        // Trigonometric Applications Section
        $applicationSection = LearningModuleSection::create([
            'learning_module_id' => $module->id,
            'title' => 'Aplikasi Trigonometri',
            'subtitle' => 'Penerapan dalam Kehidupan Nyata',
            'description' => 'Section yang membahas aplikasi trigonometri dalam berbagai bidang.',
            'order_number' => 3,
            'estimated_duration' => 140,
            'is_published' => true,
            'section_type' => 'chapter',
            'section_objectives' => [
                'Menerapkan trigonometri dalam pengukuran',
                'Memahami aplikasi dalam navigasi',
                'Menggunakan trigonometri dalam fisika'
            ],
            'introduction_text' => 'Trigonometri memiliki banyak aplikasi praktis dalam kehidupan sehari-hari.',
        ]);

        $this->createTrigonometricApplicationsLessons($applicationSection);

        $module->updateCounts();
    }

    // Lesson creation methods would continue here...
    // For brevity, I'll create a few sample lesson creation methods

    private function createVerbalLessons($section)
    {
        LearningModuleLesson::create([
            'section_id' => $section->id,
            'title' => 'Analogi Kata',
            'subtitle' => 'Memahami Pola Hubungan Kata',
            'description' => 'Pembelajaran tentang cara menyelesaikan soal analogi dengan berbagai pola hubungan.',
            'order_number' => 1,
            'estimated_duration' => 40,
            'lesson_type' => 'video',
            'is_published' => true,
            'is_mandatory' => true,
            'content' => 'Video pembelajaran analogi kata dengan contoh-contoh soal dan strategi penyelesaian.',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'notes' => 'Pastikan siswa memahami berbagai jenis hubungan dalam analogi.'
        ]);

        LearningModuleLesson::create([
            'section_id' => $section->id,
            'title' => 'Sinonim dan Antonim',
            'subtitle' => 'Kosa Kata dan Lawan Kata',
            'description' => 'Pembelajaran tentang sinonim (persamaan kata) dan antonim (lawan kata).',
            'order_number' => 2,
            'estimated_duration' => 40,
            'lesson_type' => 'text',
            'is_published' => true,
            'is_mandatory' => true,
            'content' => 'Materi tentang sinonim dan antonim dengan tips menghafal dan strategi mengerjakan soal.',
        ]);

        LearningModuleLesson::create([
            'section_id' => $section->id,
            'title' => 'Pemahaman Bacaan',
            'subtitle' => 'Teknik Membaca Efektif',
            'description' => 'Pembelajaran teknik memahami dan menganalisis bacaan dengan cepat dan tepat.',
            'order_number' => 3,
            'estimated_duration' => 40,
            'lesson_type' => 'text',
            'is_published' => true,
            'is_mandatory' => true,
            'content' => 'Strategi membaca cepat dan memahami inti bacaan untuk soal TIU.',
        ]);

        LearningModuleLesson::create([
            'section_id' => $section->id,
            'title' => 'Latihan Soal Verbal',
            'subtitle' => 'Try Out Kemampuan Verbal',
            'description' => 'Latihan soal-soal kemampuan verbal dengan timer dan evaluasi otomatis.',
            'order_number' => 4,
            'estimated_duration' => 40,
            'lesson_type' => 'quiz',
            'is_published' => true,
            'is_mandatory' => false,
            'quiz_data' => [
                'questions' => 20,
                'time_limit' => 1800, // 30 menit
                'passing_score' => 70
            ]
        ]);

        $section->updateLessonCount();
    }

    private function createNumerikLessons($section)
    {
        LearningModuleLesson::create([
            'section_id' => $section->id,
            'title' => 'Operasi Aritmatika',
            'subtitle' => 'Perhitungan Dasar dan Cepat',
            'description' => 'Pembelajaran operasi aritmatika dasar dengan teknik perhitungan cepat.',
            'order_number' => 1,
            'estimated_duration' => 40,
            'lesson_type' => 'video',
            'is_published' => true,
            'is_mandatory' => true,
            'content' => 'Video pembelajaran operasi aritmatika dengan teknik mental math.',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        LearningModuleLesson::create([
            'section_id' => $section->id,
            'title' => 'Bilangan dan Pola',
            'subtitle' => 'Deret dan Pola Bilangan',
            'description' => 'Pembelajaran tentang pola bilangan dan deret dalam soal TIU.',
            'order_number' => 2,
            'estimated_duration' => 40,
            'lesson_type' => 'text',
            'is_published' => true,
            'is_mandatory' => true,
            'content' => 'Materi tentang pola bilangan, deret aritmatika, dan geometri.',
        ]);

        LearningModuleLesson::create([
            'section_id' => $section->id,
            'title' => 'Logika Matematika',
            'subtitle' => 'Penalaran dan Logika',
            'description' => 'Pembelajaran logika matematika dan penalaran kuantitatif.',
            'order_number' => 3,
            'estimated_duration' => 40,
            'lesson_type' => 'text',
            'is_published' => true,
            'is_mandatory' => true,
            'content' => 'Logika matematika, penalaran induktif dan deduktif.',
        ]);

        LearningModuleLesson::create([
            'section_id' => $section->id,
            'title' => 'Latihan Soal Numerik',
            'subtitle' => 'Try Out Kemampuan Numerik',
            'description' => 'Latihan soal-soal kemampuan numerik dengan berbagai tingkat kesulitan.',
            'order_number' => 4,
            'estimated_duration' => 40,
            'lesson_type' => 'quiz',
            'is_published' => true,
            'is_mandatory' => false,
            'quiz_data' => [
                'questions' => 20,
                'time_limit' => 1800,
                'passing_score' => 70
            ]
        ]);

        $section->updateLessonCount();
    }

    // Add more lesson creation methods for other sections...
    // (Similar methods would be created for other sections)

    private function createFiguralLessons($section)
    {
        LearningModuleLesson::create([
            'section_id' => $section->id,
            'title' => 'Pola Gambar Seri',
            'subtitle' => 'Analisis Pola Visual',
            'description' => 'Pembelajaran mengidentifikasi dan menganalisis pola dalam gambar.',
            'order_number' => 1,
            'estimated_duration' => 40,
            'lesson_type' => 'interactive',
            'is_published' => true,
            'is_mandatory' => true,
            'interactive_data' => [
                'type' => 'pattern_recognition',
                'difficulty_levels' => ['easy', 'medium', 'hard'],
                'total_questions' => 15
            ]
        ]);

        LearningModuleLesson::create([
            'section_id' => $section->id,
            'title' => 'Hubungan Gambar',
            'subtitle' => 'Analogi Visual',
            'description' => 'Pembelajaran analogi gambar dan hubungan visual.',
            'order_number' => 2,
            'estimated_duration' => 40,
            'lesson_type' => 'interactive',
            'is_published' => true,
            'is_mandatory' => true,
            'interactive_data' => [
                'type' => 'visual_analogy',
                'total_questions' => 15
            ]
        ]);

        LearningModuleLesson::create([
            'section_id' => $section->id,
            'title' => 'Spatial Visualization',
            'subtitle' => 'Visualisasi Ruang',
            'description' => 'Pembelajaran kemampuan visualisasi dan manipulasi mental objek 3D.',
            'order_number' => 3,
            'estimated_duration' => 40,
            'lesson_type' => 'interactive',
            'is_published' => true,
            'is_mandatory' => true,
            'interactive_data' => [
                'type' => 'spatial_rotation',
                'total_questions' => 10
            ]
        ]);

        LearningModuleLesson::create([
            'section_id' => $section->id,
            'title' => 'Latihan Soal Figural',
            'subtitle' => 'Try Out Kemampuan Figural',
            'description' => 'Latihan soal-soal kemampuan figural lengkap.',
            'order_number' => 4,
            'estimated_duration' => 40,
            'lesson_type' => 'quiz',
            'is_published' => true,
            'is_mandatory' => false,
            'quiz_data' => [
                'questions' => 20,
                'time_limit' => 1800,
                'passing_score' => 70
            ]
        ]);

        $section->updateLessonCount();
    }

    // Placeholder methods for other lesson creation (you would implement these similarly)
    private function createPublicServiceLessons($section) { $section->updateLessonCount(); }
    private function createProfessionalLessons($section) { $section->updateLessonCount(); }
    private function createSocialAwarenessLessons($section) { $section->updateLessonCount(); }
    private function createGeneralKnowledgeLessons($section) { $section->updateLessonCount(); }
    private function createCurrentAffairsLessons($section) { $section->updateLessonCount(); }
    private function createCriticalThinkingLessons($section) { $section->updateLessonCount(); }
    private function createBasicAlgebraLessons($section) { $section->updateLessonCount(); }
    private function createEquationLessons($section) { $section->updateLessonCount(); }
    private function createFunctionLessons($section) { $section->updateLessonCount(); }
    private function create2DGeometryLessons($section) { $section->updateLessonCount(); }
    private function create3DGeometryLessons($section) { $section->updateLessonCount(); }
    private function createCoordinateGeometryLessons($section) { $section->updateLessonCount(); }
    private function createBasicTrigonometryLessons($section) { $section->updateLessonCount(); }
    private function createTrigonometricIdentitiesLessons($section) { $section->updateLessonCount(); }
    private function createTrigonometricApplicationsLessons($section) { $section->updateLessonCount(); }
}