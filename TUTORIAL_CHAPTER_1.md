# Tutorial Lengkap: Cara Menambahkan Chapter 1 dengan BAB dan Isi

## 📚 Contoh Praktis: Menambah Chapter 1 dengan 3 BAB

### 🎯 Struktur Chapter 1 yang Akan Dibuat
```
Chapter 1: Matematika Dasar
├── BAB 1.1: Pengenalan Angka dan Bilangan
│   ├── Materi 1: Video - "Mengenal Angka 1-10"
│   ├── Materi 2: PDF - "Latihan Menulis Angka"
│   └── Materi 3: Link - "Permainan Angka Interaktif"
│
├── BAB 1.2: Operasi Hitung Dasar
│   ├── Materi 1: Video - "Penjumlahan untuk Anak"
│   ├── Materi 2: PDF - "Soal Latihan Penjumlahan"
│   └── Materi 3: Video - "Tips Menghitung Cepat"
│
└── BAB 1.3: Bentuk dan Warna
    ├── Materi 1: Video - "Mengenal Bentuk Geometri"
    ├── Materi 2: PDF - "Coloring Sheet Bentuk"
    └── Materi 3: Link - "Sorting Game Warna"
```

## 🚀 Cara 1: Via Admin Interface

### Langkah 1: Login dan Akses Menu
1. Login sebagai admin/tutor
2. Buka **Materials** → **Add Material**

### Langkah 2: Isi Form untuk BAB 1.1 - Materi 1
```yaml
Judul Materi: "Mengenal Angka 1-10"
Mata Pelajaran: "Matematika"
Deskripsi: "Video pembelajaran mengenal angka 1-10 untuk anak-anak"
Type: "youtube"
YouTube URL: "https://www.youtube.com/watch?v=example1"
Chapter Number: 1
Chapter Title: "BAB 1.1: Pengenalan Angka dan Bilangan"
Material Order: 1
Batch ID: [Pilih Paket Matematika]
Tutor ID: [Pilih Tutor]
Is Public: ✅
Is Featured: ✅
Is Completable: ✅
Duration Seconds: 900
```

### Langkah 3: Ulangi untuk Semua Materi
- **BAB 1.1**: Chapter Number = 1 (3 materials)
- **BAB 1.2**: Chapter Number = 2 (3 materials)
- **BAB 1.3**: Chapter Number = 3 (3 materials)

## 🎯 Cara 2: Via Database Seeder (Recommended)

### Langkah 1: Tambah Method di Seeder
Tambahkan code ini di `ChapterBasedMaterialsSeeder.php`:

```php
private function createChapter1Materials($paket, $tutor)
{
    // BAB 1.1: Pengenalan Angka dan Bilangan
    Material::create([
        'batch_id' => $paket->id,
        'tutor_id' => $tutor->id,
        'title' => 'Mengenal Angka 1-10',
        'mapel' => 'Matematika',
        'description' => 'Video pembelajaran mengenal angka 1-10',
        'type' => 'youtube',
        'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        'chapter_number' => 1,
        'chapter_title' => 'BAB 1.1: Pengenalan Angka dan Bilangan',
        'material_order' => 1,
        'is_public' => true,
        'is_featured' => true,
        'is_completable' => true,
        'duration_seconds' => 900,
        'views_count' => 0,
        'downloads_count' => 0,
    ]);

    Material::create([
        'batch_id' => $paket->id,
        'tutor_id' => $tutor->id,
        'title' => 'Latihan Menulis Angka',
        'mapel' => 'Matematika',
        'description' => 'Worksheet untuk latihan menulis angka 1-10',
        'type' => 'document',
        'file_path' => 'materials/latihan-menulis-angka.pdf',
        'chapter_number' => 1,
        'chapter_title' => 'BAB 1.1: Pengenalan Angka dan Bilangan',
        'material_order' => 2,
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
        'duration_seconds' => 1200,
        'views_count' => 0,
        'downloads_count' => 0,
    ]);

    Material::create([
        'batch_id' => $paket->id,
        'tutor_id' => $tutor->id,
        'title' => 'Permainan Angka Interaktif',
        'mapel' => 'Matematika',
        'description' => 'Game online untuk belajar angka',
        'type' => 'link',
        'external_link' => 'https://www.ixl.com/math/kindergarten',
        'chapter_number' => 1,
        'chapter_title' => 'BAB 1.1: Pengenalan Angka dan Bilangan',
        'material_order' => 3,
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
        'duration_seconds' => 600,
        'views_count' => 0,
        'downloads_count' => 0,
    ]);

    // BAB 1.2: Operasi Hitung Dasar
    Material::create([
        'batch_id' => $paket->id,
        'tutor_id' => $tutor->id,
        'title' => 'Penjumlahan untuk Anak',
        'mapel' => 'Matematika',
        'description' => 'Video pembelajaran penjumlahan dasar',
        'type' => 'youtube',
        'youtube_url' => 'https://www.youtube.com/watch?v=ScDaLQpD-A8',
        'chapter_number' => 2,
        'chapter_title' => 'BAB 1.2: Operasi Hitung Dasar',
        'material_order' => 1,
        'is_public' => true,
        'is_featured' => true,
        'is_completable' => true,
        'duration_seconds' => 1080,
        'views_count' => 0,
        'downloads_count' => 0,
    ]);

    Material::create([
        'batch_id' => $paket->id,
        'tutor_id' => $tutor->id,
        'title' => 'Soal Latihan Penjumlahan',
        'mapel' => 'Matematika',
        'description' => 'Kumpulan soal penjumlahan',
        'type' => 'document',
        'file_path' => 'materials/soal-penjumlahan.pdf',
        'chapter_number' => 2,
        'chapter_title' => 'BAB 1.2: Operasi Hitung Dasar',
        'material_order' => 2,
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
        'duration_seconds' => 1500,
        'views_count' => 0,
        'downloads_count' => 0,
    ]);

    Material::create([
        'batch_id' => $paket->id,
        'tutor_id' => $tutor->id,
        'title' => 'Tips Menghitung Cepat',
        'mapel' => 'Matematika',
        'description' => 'Video tips menghitung cepat',
        'type' => 'video',
        'file_path' => 'materials/tips-menghitung-cepat.mp4',
        'chapter_number' => 2,
        'chapter_title' => 'BAB 1.2: Operasi Hitung Dasar',
        'material_order' => 3,
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
        'duration_seconds' => 720,
        'views_count' => 0,
        'downloads_count' => 0,
    ]);

    // BAB 1.3: Bentuk dan Warna
    Material::create([
        'batch_id' => $paket->id,
        'tutor_id' => $tutor->id,
        'title' => 'Mengenal Bentuk Geometri',
        'mapel' => 'Matematika',
        'description' => 'Video pembelajaran bentuk geometri',
        'type' => 'youtube',
        'youtube_url' => 'https://www.youtube.com/watch?v=2v75bV4d7dU',
        'chapter_number' => 3,
        'chapter_title' => 'BAB 1.3: Bentuk dan Warna',
        'material_order' => 1,
        'is_public' => true,
        'is_featured' => true,
        'is_completable' => true,
        'duration_seconds' => 960,
        'views_count' => 0,
        'downloads_count' => 0,
    ]);

    Material::create([
        'batch_id' => $paket->id,
        'tutor_id' => $tutor->id,
        'title' => 'Coloring Sheet Bentuk',
        'mapel' => 'Matematika',
        'description' => 'Lembar mewarnai bentuk geometri',
        'type' => 'document',
        'file_path' => 'materials/coloring-bentuk.pdf',
        'chapter_number' => 3,
        'chapter_title' => 'BAB 1.3: Bentuk dan Warna',
        'material_order' => 2,
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
        'duration_seconds' => 1800,
        'views_count' => 0,
        'downloads_count' => 0,
    ]);

    Material::create([
        'batch_id' => $paket->id,
        'tutor_id' => $tutor->id,
        'title' => 'Sorting Game Warna',
        'mapel' => 'Matematika',
        'description' => 'Game sorting berdasarkan warna',
        'type' => 'link',
        'external_link' => 'https://www.abcmouse.com/learn/preschool-learning-games',
        'chapter_number' => 3,
        'chapter_title' => 'BAB 1.3: Bentuk dan Warna',
        'material_order' => 3,
        'is_public' => true,
        'is_featured' => false,
        'is_completable' => true,
        'duration_seconds' => 900,
        'views_count' => 0,
        'downloads_count' => 0,
    ]);
}
```

### Langkah 2: Panggil Method di run()
Tambahkan di function `run()`:

```php
public function run(): void
{
    $tutor = User::role('tutor')->first();
    if (!$tutor) {
        $this->command->error('No tutor found! Please create a tutor first.');
        return;
    }

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

    // BAB 1: MATEMATIKA DASAR (BARU)
    $this->createChapter1Materials($paket, $tutor);
    
    // BAB 2-3: Existing
    $this->createChapter2Materials($paket, $tutor);
    $this->createChapter3Materials($paket, $tutor);

    $this->command->info('Chapter-based materials created successfully!');
    $this->command->info('Created 4 chapters with 12 materials total');
}
```

### Langkah 3: Jalankan Seeder
```bash
php artisan db:seed --class=ChapterBasedMaterialsSeeder
```

## 📊 Hasil Akhir

Setelah seeder dijalankan:

```
📚 Total Materials: 12
├── Chapter 1: BAB 1.1, 1.2, 1.3 (9 materials)
└── Chapter 2-3: Existing (3 materials)

Struktur:
├── BAB 1.1: Pengenalan Angka dan Bilangan (3 materials)
├── BAB 1.2: Operasi Hitung Dasar (3 materials)  
├── BAB 1.3: Bentuk dan Warna (3 materials)
├── BAB 2: Bilangan dan Operasi (3 materials)
└── BAB 3: Bangun Datar (3 materials)
```

## 🎯 Format Penamaan BAB yang Baik

```
✅ BAB 1.1: Pengenalan Angka dan Bilangan
✅ BAB 1.2: Operasi Hitung Dasar
✅ BAB 1.3: Bentuk dan Warna
✅ BAB 2.1: Bilangan Bulat
✅ BAB 2.2: Perkalian dan Pembagian
```

## 🔍 Verifikasi

```bash
# Cek total materials
php artisan tinker --execute="echo 'Total: ' . \App\Models\Material::count();"

# Cek materials per chapter
php artisan tinker --execute="
\$chapters = \App\Models\Material::select('chapter_number', 'chapter_title')
    ->distinct()->orderBy('chapter_number')->get();
foreach(\$chapters as \$chapter) {
    \$count = \App\Models\Material::where('chapter_number', \$chapter->chapter_number)->count();
    echo \"Chapter {\$chapter->chapter_number}: {\$chapter->chapter_title} - {\$count} materials\n\";
}
"
```

## 🌐 Akses Materials
```
http://localhost:8000/materials?view=chapters
```

---

**🎉 Selesai!** Anda sekarang bisa menambahkan Chapter 1 dengan BAB-BAB dan materi yang terstruktur dengan baik!