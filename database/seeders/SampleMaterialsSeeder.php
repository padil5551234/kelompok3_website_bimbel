<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaketUjian;
use App\Models\Material;
use App\Models\User;

class SampleMaterialsSeeder extends Seeder
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

        // Create sample paket ujian
        $paket1 = PaketUjian::create([
            'nama' => 'Paket Matematika Dasar',
            'harga' => 50000,
            'deskripsi' => 'Paket pembelajaran matematika tingkat dasar',
            'whatsapp_group_link' => 'https://chat.whatsapp.com/example1',
            'waktu_mulai' => now(),
            'waktu_akhir' => now()->addDays(30),
        ]);

        $paket2 = PaketUjian::create([
            'nama' => 'Paket Bahasa Indonesia',
            'harga' => 45000,
            'deskripsi' => 'Paket pembelajaran bahasa Indonesia lengkap',
            'whatsapp_group_link' => 'https://chat.whatsapp.com/example2',
            'waktu_mulai' => now(),
            'waktu_akhir' => now()->addDays(30),
        ]);

        // Create sample materials for paket 1 with chapters
        Material::create([
            'batch_id' => $paket1->id,
            'tutor_id' => $tutor->id,
            'title' => 'Pengantar Aljabar',
            'mapel' => 'Matematika',
            'description' => 'Materi pengantar tentang konsep dasar aljabar',
            'type' => 'youtube',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'content' => 'Materi ini menjelaskan konsep dasar aljabar termasuk variabel, konstanta, dan operasi dasar.',
            'tags' => ['aljabar', 'matematika', 'dasar'],
            'is_public' => true,
            'is_featured' => true,
            'is_completable' => true,
            'chapter_number' => 1,
            'chapter_title' => 'Bab 1: Konsep Dasar Aljabar',
            'material_order' => 1,
            'duration_seconds' => 1800, // 30 minutes
        ]);

        Material::create([
            'batch_id' => $paket1->id,
            'tutor_id' => $tutor->id,
            'title' => 'Bilangan Bulat dan Operasinya',
            'mapel' => 'Matematika',
            'description' => 'Pelajari tentang bilangan bulat dan operasi matematika',
            'type' => 'document',
            'content' => 'Bilangan bulat adalah himpunan bilangan ..., Operasi penjumlahan, pengurangan, perkalian, dan pembagian bilangan bulat.',
            'tags' => ['bilangan bulat', 'operasi', 'matematika'],
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'chapter_number' => 1,
            'chapter_title' => 'Bab 1: Konsep Dasar Aljabar',
            'material_order' => 2,
            'duration_seconds' => 2400, // 40 minutes
        ]);

        Material::create([
            'batch_id' => $paket1->id,
            'tutor_id' => $tutor->id,
            'title' => 'Pengenalan Geometri',
            'mapel' => 'Matematika',
            'description' => 'Materi dasar tentang bangun datar dan ruang',
            'type' => 'link',
            'external_link' => 'https://www.kemdikbud.go.id/geometri-dasar',
            'content' => 'Geometri adalah cabang matematika yang mempelajari tentang bentuk, ukuran, dan sifat-sifat ruang.',
            'tags' => ['geometri', 'bangun datar', 'matematika'],
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'chapter_number' => 2,
            'chapter_title' => 'Bab 2: Pengenalan Geometri',
            'material_order' => 1,
            'duration_seconds' => 1500, // 25 minutes
        ]);

        // Create sample materials for paket 2
        Material::create([
            'batch_id' => $paket2->id,
            'tutor_id' => $tutor->id,
            'title' => 'Struktur Bahasa Indonesia',
            'mapel' => 'Bahasa Indonesia',
            'description' => 'Pelajari komponen-komponen dalam bahasa Indonesia',
            'type' => 'youtube',
            'youtube_url' => 'https://www.youtube.com/watch?v=example2',
            'content' => 'Bahasa Indonesia terdiri dari fonologi, morfologi, sintaksis, dan semantik.',
            'tags' => ['bahasa indonesia', 'struktur', 'tata bahasa'],
            'is_public' => true,
            'is_featured' => true,
            'is_completable' => true,
            'duration_seconds' => 2100, // 35 minutes
        ]);

        Material::create([
            'batch_id' => $paket2->id,
            'tutor_id' => $tutor->id,
            'title' => 'Kosa Kata dan Sinonim',
            'mapel' => 'Bahasa Indonesia',
            'description' => 'Perkaya kosakata dengan mempelajari sinonim',
            'type' => 'document',
            'content' => 'Sinonim adalah kata yang memiliki arti sama atau mirip. Contoh: bahagia = gembira = riang.',
            'tags' => ['kosa kata', 'sinonim', 'bahasa indonesia'],
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => true,
            'duration_seconds' => 1800, // 30 minutes
        ]);

        // Create a material that cannot be marked as complete (for testing)
        Material::create([
            'batch_id' => $paket2->id,
            'tutor_id' => $tutor->id,
            'title' => 'Referensi Tambahan',
            'mapel' => 'Bahasa Indonesia',
            'description' => 'Daftar referensi untuk pembelajaran lebih lanjut',
            'type' => 'link',
            'external_link' => 'https://www.referensi-bahasa.go.id',
            'content' => 'Berbagai sumber referensi untuk mendalami bahasa Indonesia.',
            'tags' => ['referensi', 'bahasa indonesia'],
            'is_public' => true,
            'is_featured' => false,
            'is_completable' => false, // This material cannot be marked as complete
            'duration_seconds' => 300, // 5 minutes
        ]);

        $this->command->info('Sample materials created successfully!');
        $this->command->info('Created 2 paket ujian with 6 materials total');
        $this->command->info('1 material is set to not completable for testing');
    }
}
