<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaterialFolder;
use App\Models\Material;
use App\Models\User;
use App\Models\PaketUjian;

class MaterialFolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample folders for testing
        $folders = [
            [
                'title' => 'Materi Dasar',
                'description' => 'Materi pembelajaran dasar untuk pemula',
                'meeting_number' => 1,
                'meeting_title' => 'Pengenalan dan Konsep Dasar',
                'order_number' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Materi Menengah',
                'description' => 'Materi pembelajaran tingkat menengah',
                'meeting_number' => 2,
                'meeting_title' => 'Implementasi Praktis',
                'order_number' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Materi Lanjutan',
                'description' => 'Materi pembelajaran untuk level lanjut',
                'meeting_number' => 3,
                'meeting_title' => 'Proyek dan Aplikasi',
                'order_number' => 3,
                'is_published' => true,
            ],
        ];

        // Get first tutor and package for testing
        $tutor = User::where('role', 'tutor')->first();
        $package = PaketUjian::first();

        foreach ($folders as $folderData) {
            $folder = MaterialFolder::create([
                'title' => $folderData['title'],
                'description' => $folderData['description'],
                'meeting_number' => $folderData['meeting_number'],
                'meeting_title' => $folderData['meeting_title'],
                'order_number' => $folderData['order_number'],
                'is_published' => $folderData['is_published'],
                'batch_id' => $package ? $package->id : null,
                'tutor_id' => $tutor ? $tutor->id : null,
            ]);

            // Create sample materials for this folder
            $this->createSampleMaterials($folder);
        }

        $this->command->info('Sample material folders created successfully!');
    }

    private function createSampleMaterials($folder)
    {
        $materials = [
            [
                'title' => 'Video Pembelajaran ' . $folder->meeting_title,
                'description' => 'Video explainer untuk ' . $folder->meeting_title,
                'type' => 'youtube',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'mapel' => 'Matematika',
            ],
            [
                'title' => 'Materi PDF ' . $folder->meeting_title,
                'description' => 'Dokumen PDF berisi materi ' . $folder->meeting_title,
                'type' => 'document',
                'file_path' => 'materials/sample.pdf',
                'mapel' => 'Matematika',
            ],
            [
                'title' => 'Link Referensi ' . $folder->meeting_title,
                'description' => 'Link eksternal untuk referensi tambahan',
                'type' => 'link',
                'external_link' => 'https://example.com',
                'mapel' => 'Matematika',
            ],
        ];

        foreach ($materials as $materialData) {
            Material::create([
                'title' => $materialData['title'],
                'description' => $materialData['description'],
                'type' => $materialData['type'],
                'youtube_url' => $materialData['youtube_url'] ?? null,
                'file_path' => $materialData['file_path'] ?? null,
                'external_link' => $materialData['external_link'] ?? null,
                'mapel' => $materialData['mapel'],
                'folder_id' => $folder->id,
                'batch_id' => $folder->batch_id,
                'tutor_id' => $folder->tutor_id,
                'is_public' => true,
                'is_featured' => false,
                'views_count' => rand(10, 100),
                'downloads_count' => rand(0, 20),
            ]);
        }
    }
}
