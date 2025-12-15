# Tutorial: Cara Menambahkan Materi ke Sistem Chapter-Based Materials

## 📚 Overview
Sistem materi pembelajaran berbasis chapter memungkinkan Anda mengorganisir materi dalam BAB-bab yang terstruktur. Setiap BAB dapat berisi berbagai jenis materi seperti video, dokumen PDF, link eksternal, dan file video upload.

## 🎯 Cara 1: Menambah Materi via Admin Interface

### Langkah 1: Login sebagai Admin/Tutor
1. Buka halaman login aplikasi
2. Login dengan akun yang memiliki role `admin` atau `tutor`
3. Pastikan user memiliki permission untuk menambah materi

### Langkah 2: Akses Menu Materials
1. Di dashboard admin, klik menu **"Materials"** atau **"Materi"**
2. Atau akses langsung: `/admin/materials` atau `/materials`

### Langkah 3: Klik Tombol Tambah Materi
1. Cari tombol **"Tambah Materi"** atau **"Add Material"**
2. Klik tombol tersebut

### Langkah 4: Isi Form Tambah Materi
```
📝 Field yang harus diisi:
├── Judul Materi (title)
├── Mata Pelajaran (mapel) 
├── Deskripsi (description)
├── Jenis Materi (type):
│   ├── youtube (Video YouTube)
│   ├── document (Dokumen PDF)
│   ├── video (File Video Upload)
│   └── link (Link Eksternal)
├── BAB Number (chapter_number)
├── Judul BAB (chapter_title)
├── Urutan Materi (material_order)
├── Batch/Paket (batch_id)
└── Tutor (tutor_id)
```

### Langkah 5: Isi Field Berdasarkan Jenis Materi

#### Untuk Video YouTube:
```
Type: youtube
YouTube URL: https://www.youtube.com/watch?v=EXAMPLE
```

#### Untuk Dokumen PDF:
```
Type: document
File Path: materials/nama-file.pdf
```

#### Untuk File Video Upload:
```
Type: video
File Path: materials/nama-video.mp4
```

#### Untuk Link Eksternal:
```
Type: link
External Link: https://example.com
```

### Langkah 6: Setel Opsi Tambahan
```
✅ Is Public: Ya (untuk publik)
⭐ Is Featured: Ya (untuk materi unggulan)
✔️ Is Completable: Ya (dapat ditandai selesai)
⏱️ Duration Seconds: [dalam detik]
📊 Views Count: 0 (otomatis)
📥 Downloads Count: 0 (otomatis)
```

### Langkah 7: Simpan Materi
1. Review semua field yang sudah diisi
2. Klik **"Simpan"** atau **"Save"**
3. Materi baru akan muncul di list materials

## 🎯 Cara 2: Menambah Materi via Database Seeder

### Langkah 1: Edit File Seeder
1. Buka file `database/seeders/ChapterBasedMaterialsSeeder.php`
2. Tambah method baru untuk BAB berikutnya

### Langkah 2: Tambah Method BAB Baru
```php
private function createChapter4Materials($paket, $tutor)
{
    // Material 4.1: Video YouTube
    Material::create([
        'batch_id' => $paket->id,
        'tutor_id' => $tutor->id,
        'title' => 'Judul Materi BAB 4',
        'mapel' => 'Matematika',
        'description' => 'Deskripsi materi BAB 4',
        'type' => 'youtube',
        'youtube_url' => 'https://www.youtube.com/watch?v=EXAMPLE',
        'chapter_number' => 4,
        'chapter_title' => 'Bab 4: [Nama BAB]',
        'material_order' => 1,
        'is_public' => true,
        'is_featured' => true,
        'is_completable' => true,
        'duration_seconds' => 1800,
        'views_count' => 0,
        'downloads_count' => 0,
    ]);

    // Tambah materi lainnya...
}
```

### Langkah 3: Panggil Method di run()
```php
public function run(): void
{
    // Kode existing...
    
    // BAB 4: [Nama BAB]
    $this->createChapter4Materials($paket, $tutor);
    
    // BAB 5: [Nama BAB]
    $this->createChapter5Materials($paket, $tutor);
}
```

### Langkah 4: Jalankan Seeder
```bash
php artisan db:seed --class=ChapterBasedMaterialsSeeder
```

## 📋 Struktur Chapter dan Material

### Format Penamaan BAB
```
Bab X: [Nama Topik]
```
Contoh:
- Bab 1: Konsep Dasar Matematika
- Bab 2: Bilangan dan Operasi
- Bab 3: Bangun Datar
- Bab 4: Aljabar Dasar

### Urutan Material dalam BAB
```
Material Order: 1, 2, 3, dst...
```
- Material 1: Video pembelajaran utama
- Material 2: Dokumen/Latihan
- Material 3: Referensi/Tools

## 🔧 Tips dan Best Practices

### 1. Persiapan Sebelum Menambah Materi
```
✅ Pastikan tutor user sudah ada
✅ Pastikan paket ujian sudah dibuat
✅ Siapkan file-file materi (PDF, video, dll)
✅ Tentukan struktur BAB dan urutan materi
```

### 2. Jenis Materi yang Direkomendasikan
```
📹 Video YouTube: Untuk pembelajaran visual
📄 PDF Document: Untuk materi teks dan soal latihan
🎥 Video File: Untuk konten khusus/tutor
🔗 External Link: Untuk referensi dan tools online
```

### 3. Durasi Materi
```
⏱️ Video YouTube: 15-45 menit
📄 PDF Document: 20-60 menit baca
🎥 Video File: 10-30 menit
🔗 External Link: 10-30 menit eksplorasi
```

### 4. Is Featured Materials
```
⭐ Pilih 1-2 materi terbaik per BAB sebagai featured
⭐ Biasanya video pembelajaran utama
⭐ Bermanfaat untuk menarik minat belajar
```

## 🚀 Cara Akses Materials Setelah Ditambah

### 1. Via URL
```
/materials?view=chapters
```

### 2. Via Menu Navigation
- User → Materials → Chapter View

### 3. Via Paket Ujian
- Klik paket → View Materials

## 📊 Monitoring Materials

### Cek Total Materials
```bash
php artisan tinker --execute="echo 'Total: ' . \App\Models\Material::count();"
```

### Cek Materials per BAB
```bash
php artisan tinker --execute="
\$chapters = \App\Models\Material::select('chapter_number', 'chapter_title')
    ->distinct()
    ->orderBy('chapter_number')
    ->get();
foreach(\$chapters as \$chapter) {
    \$count = \App\Models\Material::where('chapter_number', \$chapter->chapter_number)->count();
    echo \"Chapter {\$chapter->chapter_number}: {\$chapter->chapter_title} - {\$count} materials\n\";\}
"
```

## 🔍 Troubleshooting

### Error: "No tutor found!"
```bash
# Buat tutor user terlebih dahulu
php artisan db:seed --class=AdminUserSeeder
# atau buat manual via admin interface
```

### Error: "Class not found"
```bash
# Regenerate autoload
composer dump-autoload
```

### Error: "Foreign key constraint"
```bash
# Pastikan batch_id (paket ujian) sudah ada
php artisan db:seed --class=PaketUjianSeeder
```

## 📞 Support

Jika mengalami kesulitan:
1. Cek log error: `storage/logs/laravel.log`
2. Pastikan semua dependensi terpenuhi
3. Cek permission user untuk menambah materi
4. Pastikan struktur database sudah benar

---

**💡 Tips:** Mulai dengan 1-2 BAB terlebih dahulu untuk memahami sistem, lalu expand sesuai kebutuhan!