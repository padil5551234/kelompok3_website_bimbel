<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaketUjian;
use App\Models\Material;
use App\Models\User;

class ChapterBasedMaterialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first tutor for sample materials
        $tutor = User::role('tutor')->first();

        if (!$tutor) {
            $this->command->error('No tutor found! Please create a tutor first.');
            return;
        }

        // Create sample paket ujian if not exists
        $paket = PaketUjian::firstOrCreate(
            ['nama' => 'Paket Matematika Chapter Based'],
            [
                'harga' => 100000,
                'deskripsi' => 'Paket pembelajaran matematika dengan sistem chapter',
                'whatsapp_group_link' => 'https://chat.whatsapp.com/matematika-chapter',
                'waktu_mulai' => now(),
                'waktu_akhir' => now()->addDays(90),
            ]
        );

        $this->command->info('Creating chapter-based materials...');

        // BAB 1: MATEMATIKA DASAR (BAB 1.1, 1.2, 1.3)
        $this->createChapter1Materials($paket, $tutor);
        
        // BAB 2: BILANGAN DAN OPERASI
        $this->createChapter2Materials($paket, $tutor);
        
        // BAB 3: BANGUN DATAR
        $this->createChapter3Materials($paket, $tutor);

        $this->command->info('Chapter-based materials created successfully!');
        $this->command->info('Created 3 chapters with 15 materials total');
        $this->command->info('Chapter 1: BAB 1.1, 1.2, 1.3 (9 materials)');
        $this->command->info('Chapter 2: BAB 2 (3 materials)');
        $this->command->info('Chapter 3: BAB 3 (3 materials)');
        $this->command->info('Access materials at: /materials?view=chapters');
    }

    private function createChapter1Materials($paket, $tutor)
    {
        // BAB 1.1: Pengenalan Angka dan Bilangan
        
        // Materi 1.1.1: Video YouTube
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Mengenal Angka 1-10',
            'mapel' => 'Matematika',
            'description' => 'Video pembelajaran mengenal angka 1-10 untuk anak-anak dengan lagu dan visual menarik',
            'type' => 'youtube',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'chapter_number' => 1,
            'chapter_title' => 'BAB 1.1: Pengenalan Angka dan Bilangan',
            'material_order' => 1,
            'is_public' => true,
            'is_featured' => true,
            'is_completable' => true,
            'duration_seconds' => 900, // 15 menit
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        // Materi 1.1.2: PDF Document
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Latihan Menulis Angka',
            'mapel' => 'Matematika',
            'description' => 'Worksheet untuk latihan menulis angka 1-10 dengan panduan yang jelas',
            'type' => 'document',
            'file_path' => 'materials/latihan-menulis-angka.pdf',
            'chapter_number' => 1,
            'chapter_title' => 'BAB 1.1: Pengenalan Angka dan Bilangan',
            'material_order' => 2,
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'duration_seconds' => 1200, // 20 menit
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        // Materi 1.1.3: External Link
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Permainan Angka Interaktif',
            'mapel' => 'Matematika',
            'description' => 'Game online untuk belajar angka dengan cara yang menyenangkan dan interaktif',
            'type' => 'link',
            'external_link' => 'https://www.ixl.com/math/kindergarten/count-objects-up-to-5',
            'chapter_number' => 1,
            'chapter_title' => 'BAB 1.1: Pengenalan Angka dan Bilangan',
            'material_order' => 3,
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'duration_seconds' => 600, // 10 menit
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        // BAB 1.2: Operasi Hitung Dasar
        
        // Materi 1.2.1: Video YouTube
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Penjumlahan untuk Anak',
            'mapel' => 'Matematika',
            'description' => 'Video pembelajaran penjumlahan dasar dengan metode yang mudah dipahami anak',
            'type' => 'youtube',
            'youtube_url' => 'https://www.youtube.com/watch?v=ScDaLQpD-A8',
            'chapter_number' => 2,
            'chapter_title' => 'BAB 1.2: Operasi Hitung Dasar',
            'material_order' => 1,
            'is_public' => true,
            'is_featured' => true,
            'is_completable' => true,
            'duration_seconds' => 1080, // 18 menit
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        // Materi 1.2.2: PDF Document
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Soal Latihan Penjumlahan',
            'mapel' => 'Matematika',
            'description' => 'Kumpulan soal penjumlahan dengan tingkat kesulitan bertahap',
            'type' => 'document',
            'file_path' => 'materials/soal-penjumlahan.pdf',
            'chapter_number' => 2,
            'chapter_title' => 'BAB 1.2: Operasi Hitung Dasar',
            'material_order' => 2,
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'duration_seconds' => 1500, // 25 menit
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        // Materi 1.2.3: Video File
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Tips Menghitung Cepat',
            'mapel' => 'Matematika',
            'description' => 'Video tips dan trick menghitung penjumlahan dengan cepat',
            'type' => 'video',
            'file_path' => 'materials/tips-menghitung-cepat.mp4',
            'chapter_number' => 2,
            'chapter_title' => 'BAB 1.2: Operasi Hitung Dasar',
            'material_order' => 3,
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'duration_seconds' => 720, // 12 menit
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        // BAB 1.3: Bentuk dan Warna
        
        // Materi 1.3.1: Video YouTube
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Mengenal Bentuk Geometri',
            'mapel' => 'Matematika',
            'description' => 'Video pembelajaran mengenal berbagai bentuk geometri dasar',
            'type' => 'youtube',
            'youtube_url' => 'https://www.youtube.com/watch?v=2v75bV4d7dU',
            'chapter_number' => 3,
            'chapter_title' => 'BAB 1.3: Bentuk dan Warna',
            'material_order' => 1,
            'is_public' => true,
            'is_featured' => true,
            'is_completable' => true,
            'duration_seconds' => 960, // 16 menit
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        // Materi 1.3.2: PDF Document
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Coloring Sheet Bentuk',
            'mapel' => 'Matematika',
            'description' => 'Lembar mewarnai untuk belajar bentuk geometri',
            'type' => 'document',
            'file_path' => 'materials/coloring-bentuk.pdf',
            'chapter_number' => 3,
            'chapter_title' => 'BAB 1.3: Bentuk dan Warna',
            'material_order' => 2,
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'duration_seconds' => 1800, // 30 menit
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        // Materi 1.3.3: External Link
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Sorting Game Warna',
            'mapel' => 'Matematika',
            'description' => 'Game online untuk belajar sorting berdasarkan warna',
            'type' => 'link',
            'external_link' => 'https://www.abcmouse.com/learn/preschool-learning-games/sorting-games',
            'chapter_number' => 3,
            'chapter_title' => 'BAB 1.3: Bentuk dan Warna',
            'material_order' => 3,
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'duration_seconds' => 900, // 15 menit
            'views_count' => 0,
            'downloads_count' => 0,
        ]);
    }

    private function createChapter2Materials($paket, $tutor)
    {
        // Material 2.1: Video YouTube
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Bilangan Bulat dan Operasinya',
            'mapel' => 'Matematika',
            'description' => 'Video pembelajaran tentang bilangan bulat dan operasi hitung',
            'type' => 'youtube',
            'youtube_url' => 'https://www.youtube.com/watch?v=ScDaLQpD-A8',
            'chapter_number' => 2,
            'chapter_title' => 'Bab 2: Bilangan dan Operasi',
            'material_order' => 1,
            'is_public' => true,
            'is_featured' => true,
            'is_completable' => true,
            'duration_seconds' => 2100, // 35 minutes
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        // Material 2.2: PDF Document
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Soal Latihan Bilangan Bulat',
            'mapel' => 'Matematika',
            'description' => 'Kumpulan soal latihan bilangan bulat dengan pembahasan lengkap',
            'type' => 'document',
            'file_path' => 'materials/soal-bilangan-bulat.pdf',
            'chapter_number' => 2,
            'chapter_title' => 'Bab 2: Bilangan dan Operasi',
            'material_order' => 2,
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'duration_seconds' => 2700, // 45 minutes
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        // Material 2.3: Video File (uploaded)
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Tips Menghitung Cepat',
            'mapel' => 'Matematika',
            'description' => 'Video tips dan trik menghitung operasi matematika dengan cepat',
            'type' => 'video',
            'file_path' => 'materials/tips-menghitung-cepat.mp4',
            'chapter_number' => 2,
            'chapter_title' => 'Bab 2: Bilangan dan Operasi',
            'material_order' => 3,
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'duration_seconds' => 1500, // 25 minutes
            'views_count' => 0,
            'downloads_count' => 0,
        ]);
    }

    private function createChapter3Materials($paket, $tutor)
    {
        // Material 3.1: Video YouTube
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Pengenalan Bangun Datar',
            'mapel' => 'Matematika',
            'description' => 'Video pembelajaran pengenalan berbagai jenis bangun datar',
            'type' => 'youtube',
            'youtube_url' => 'https://www.youtube.com/watch?v=2v75bV4d7dU',
            'chapter_number' => 3,
            'chapter_title' => 'Bab 3: Bangun Datar',
            'material_order' => 1,
            'is_public' => true,
            'is_featured' => true,
            'is_completable' => true,
            'duration_seconds' => 1950, // 32.5 minutes
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        // Material 3.2: PDF Document
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Rumus Bangun Datar',
            'mapel' => 'Matematika',
            'description' => 'Dokumen berisi rumus-rumus luas dan keliling bangun datar',
            'type' => 'document',
            'file_path' => 'materials/rumus-bangun-datar.pdf',
            'chapter_number' => 3,
            'chapter_title' => 'Bab 3: Bangun Datar',
            'material_order' => 2,
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'duration_seconds' => 3300, // 55 minutes
            'views_count' => 0,
            'downloads_count' => 0,
        ]);

        // Material 3.3: External Link
        Material::create([
            'batch_id' => $paket->id,
            'tutor_id' => $tutor->id,
            'title' => 'Simulator Bangun Datar Interaktif',
            'mapel' => 'Matematika',
            'description' => 'Link ke simulator interaktif untuk belajar bangun datar',
            'type' => 'link',
            'external_link' => 'https://www.geogebra.org/geometry',
            'chapter_number' => 3,
            'chapter_title' => 'Bab 3: Bangun Datar',
            'material_order' => 3,
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'duration_seconds' => 1800, // 30 minutes
            'views_count' => 0,
            'downloads_count' => 0,
        ]);
    }
}
