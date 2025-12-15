<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first admin user as author, if not exists use first user
        $author = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->first() ?? User::first();

        $articles = [
            [
                'title' => 'Tips Jitu Menghadapi SPMB STIS',
                'excerpt' => 'Ketahui strategi efektif untuk menghadapi Seleksi Penerimaan Mahasiswa Baru STIS agar peluang lolos semakin besar.',
                'content' => '<p>Seleksi Penerimaan Mahasiswa Baru (SPMB) STIS merupakan salah satu seleksi masuk sekolah kedinasan yang paling kompetitif. Berikut adalah tips jitu untuk menghadapinya:</p>
                
                <h3>1. Pahami Materi SKD dengan Baik</h3>
                <p>Materi SKD terdiri dari TWK, TIU, dan TKP. Pastikan Anda memahami konsep dasar dan berlatih soal-soal secara rutin.</p>
                
                <h3>2. Kuasai Matematika Dasar</h3>
                <p>Matematika adalah kunci utama dalam SPMB STIS. Fokus pada aljabar, trigonometri, dan statistika.</p>
                
                <h3>3. Manajemen Waktu</h3>
                <p>Latih diri Anda untuk mengerjakan soal dengan time management yang baik. Gunakan sistem CAT untuk terbiasa dengan kondisi ujian sebenarnya.</p>
                
                <h3>4. Ikuti Try Out Berkala</h3>
                <p>Try out membantu Anda mengenali jenis soal dan mengukur kemampuan. Evaluasi hasil try out untuk fokus pada materi yang masih lemah.</p>
                
                <h3>5. Jaga Kesehatan Mental dan Fisik</h3>
                <p>Persiapan yang matang harus diimbangi dengan kondisi fisik dan mental yang prima. Istirahat cukup dan kelola stres dengan baik.</p>',
                'category' => 'tips',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Strategi Mengerjakan Soal TIU dengan Cepat',
                'excerpt' => 'Pelajari teknik dan strategi khusus untuk menyelesaikan soal Tes Intelegensi Umum (TIU) secara efektif dan efisien.',
                'content' => '<p>Tes Intelegensi Umum (TIU) seringkali menjadi momok bagi peserta ujian karena soalnya yang beragam dan waktu yang terbatas. Berikut strategi mengerjakan TIU dengan cepat:</p>
                
                <h3>1. Kenali Jenis Soal TIU</h3>
                <p>TIU terdiri dari verbal, numerik, dan figural. Ketahui jenis soal mana yang menjadi kekuatan Anda.</p>
                
                <h3>2. Kerjakan yang Mudah Dulu</h3>
                <p>Jangan terpaku pada soal yang sulit. Kerjakan dulu soal-soal yang mudah untuk mengamankan poin.</p>
                
                <h3>3. Gunakan Teknik Eliminasi</h3>
                <p>Untuk soal yang membingungkan, gunakan teknik eliminasi jawaban yang jelas salah terlebih dahulu.</p>
                
                <h3>4. Latihan Rutin</h3>
                <p>Kecepatan mengerjakan soal TIU didapat dari latihan yang konsisten. Semakin banyak berlatih, semakin cepat Anda mengenali pola soal.</p>
                
                <h3>5. Manajemen Waktu per Sesi</h3>
                <p>Bagi waktu dengan bijak. Jangan habiskan terlalu banyak waktu di satu soal saja.</p>',
                'category' => 'strategi',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Motivasi: Jangan Menyerah dalam Mengejar Mimpi Kedinasan',
                'excerpt' => 'Perjalanan menuju sekolah kedinasan penuh tantangan, namun setiap usaha keras akan membuahkan hasil yang manis.',
                'content' => '<p>Mengejar mimpi masuk sekolah kedinasan memang tidak mudah. Persaingan yang ketat dan materi yang luas bisa membuat kita merasa lelah dan ingin menyerah. Namun, ingatlah bahwa setiap usaha keras tidak akan pernah mengkhianati hasil.</p>
                
                <h3>Kisah Inspiratif Para Alumni</h3>
                <p>Banyak mahasiswa STIS yang sebelumnya gagal berkali-kali namun tidak menyerah. Mereka terus belajar, mengikuti bimbel, dan mencoba lagi hingga akhirnya berhasil.</p>
                
                <h3>Tips Menjaga Motivasi</h3>
                <p>1. <strong>Tentukan Tujuan Jelas:</strong> Ketahui mengapa Anda ingin masuk sekolah kedinasan.</p>
                <p>2. <strong>Buat Jadwal Belajar:</strong> Konsistensi adalah kunci sukses.</p>
                <p>3. <strong>Bergabung dengan Komunitas:</strong> Belajar bersama teman yang memiliki tujuan sama dapat meningkatkan semangat.</p>
                <p>4. <strong>Evaluasi dan Perbaiki:</strong> Setiap kegagalan adalah pembelajaran. Evaluasi kesalahan dan perbaiki.</p>
                <p>5. <strong>Percaya Pada Diri Sendiri:</strong> Keyakinan diri adalah fondasi kesuksesan.</p>
                
                <h3>Ingat Selalu</h3>
                <p>"Sukses bukan tentang tidak pernah gagal, tetapi tentang tidak pernah menyerah setelah gagal." Terus berjuang dan raih mimpimu!</p>',
                'category' => 'motivasi',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(1),
            ],
        ];

        foreach ($articles as $articleData) {
            // Add author
            $articleData['author_id'] = $author ? $author->id : null;
            
            // Create unique slug
            $baseSlug = Str::slug($articleData['title']);
            $slug = $baseSlug;
            $counter = 1;
            
            // Check if slug already exists, add counter if needed
            while (Article::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $articleData['slug'] = $slug;

            Article::create($articleData);
        }

        $this->command->info('Articles seeded successfully!');
    }
}
