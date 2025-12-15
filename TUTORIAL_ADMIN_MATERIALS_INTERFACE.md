# Tutorial: Input Materials via Admin Interface

## 🎯 Panduan Lengkap Cara Input Materials di Admin Panel

### 📋 Overview
Tutorial ini menjelaskan step-by-step cara menambahkan materials melalui interface admin, dengan fokus pada cara menentukan **Chapter**, **BAB**, dan **Material** dengan benar.

## 🚀 Langkah 1: Akses Admin Materials

### 1.1 Login ke Admin Panel
```
1. Buka browser dan akses: http://localhost:8000/admin
2. Login dengan akun yang memiliki role 'admin' atau 'tutor'
3. Setelah login, Anda akan masuk ke dashboard admin
```

### 1.2 Navigasi ke Materials
```
1. Di sidebar admin, cari menu "Materials" atau "Materi"
2. Klik menu tersebut
3. Anda akan melihat halaman list materials yang sudah ada
```

### 1.3 Akses Form Tambah Material
```
1. Cari tombol "Tambah Material" atau "Add Material"
2. Klik tombol tersebut
3. Form tambah material akan terbuka
```

## 📝 Langkah 2: Mengisi Form Materials

### 2.1 Field Wajib yang Harus Diisi

```yaml
📌 INFORMASI DASAR:
├── Judul Materi (title)           # Nama materi yang akan tampil
├── Mata Pelajaran (mapel)         # Subject (Matematika, IPA, dll)
├── Deskripsi (description)        # Penjelasan singkat materi
└── Jenis Materi (type)            # Jenis konten
    ├── youtube                   # Video YouTube
    ├── document                  # Dokumen PDF
    ├── video                     # File Video Upload
    └── link                      # Link Eksternal
```

### 2.2 Field Chapter dan BAB

```yaml
📌 ORGANISASI CHAPTER & BAB:
├── Chapter Number (chapter_number)    # Nomor urut chapter
├── Chapter Title (chapter_title)      # Nama lengkap BAB
└── Material Order (material_order)    # Urutan materi dalam BAB
```

### 2.3 Field Tambahan

```yaml
📌 PENGATURAN LAINNYA:
├── Batch ID (batch_id)           # Paket/Ujian yang terkait
├── Tutor ID (tutor_id)           # Tutor yang membuat materi
├── Is Public                     # Publik atau tidak
├── Is Featured                   # Materi unggulan
├── Is Completable                # Bisa ditandai selesai
└── Duration Seconds              # Durasi dalam detik
```

## 🎯 Langkah 3: Panduan Penentuan Chapter, BAB, dan Material

### 3.1 Sistem Penomoran Chapter

```yaml
📊 FORMAT PENOMORAN:
├── Chapter Number: 1, 2, 3, dst...
└── Chapter Title: "BAB X.X: [Nama Topik]"

📝 CONTOH PENOMORAN:
├── Chapter 1 = BAB 1.1, 1.2, 1.3
├── Chapter 2 = BAB 2.1, 2.2, 2.3  
├── Chapter 3 = BAB 3.1, 3.2, 3.3
└── Chapter 4 = BAB 4.1, 4.2, 4.3
```

### 3.2 Cara Menentukan Chapter Number

```yaml
🔢 LOGIKA PENOMORAN:
├── 1 = Chapter 1 (BAB 1.1, 1.2, 1.3)
├── 2 = Chapter 1 (BAB 1.2 - lanjutan dari Chapter 1)
├── 3 = Chapter 1 (BAB 1.3 - lanjutan dari Chapter 1)
├── 4 = Chapter 2 (BAB 2.1)
├── 5 = Chapter 2 (BAB 2.2)
├── 6 = Chapter 2 (BAB 2.3)
└── dst...
```

### 3.3 Contoh Praktis Penentuan Chapter & BAB

#### 📚 Contoh 1: Matematika Kelas 1

```yaml
🏫 BAB 1.1: Pengenalan Angka
├── Chapter Number: 1
├── Chapter Title: "BAB 1.1: Pengenalan Angka"
├── Material Order: 1 (Video), 2 (PDF), 3 (Link)
└── Type: youtube, document, link

🏫 BAB 1.2: Operasi Hitung  
├── Chapter Number: 2
├── Chapter Title: "BAB 1.2: Operasi Hitung"
├── Material Order: 1 (Video), 2 (PDF), 3 (Video)
└── Type: youtube, document, video

🏫 BAB 1.3: Bentuk dan Warna
├── Chapter Number: 3
├── Chapter Title: "BAB 1.3: Bentuk dan Warna"  
├── Material Order: 1 (Video), 2 (PDF), 3 (Link)
└── Type: youtube, document, link
```

#### 📚 Contoh 2: Matematika Kelas 2

```yaml
🏫 BAB 2.1: Bilangan Bulat
├── Chapter Number: 4
├── Chapter Title: "BAB 2.1: Bilangan Bulat"
├── Material Order: 1, 2, 3
└── Type: youtube, document, video

🏫 BAB 2.2: Perkalian
├── Chapter Number: 5
├── Chapter Title: "BAB 2.2: Perkalian"
├── Material Order: 1, 2, 3
└── Type: youtube, document, link

🏫 BAB 2.3: Pembagian
├── Chapter Number: 6
├── Chapter Title: "BAB 2.3: Pembagian"
├── Material Order: 1, 2, 3
└── Type: youtube, document, video
```

## 📝 Langkah 4: Panduan Mengisi Field Berdasarkan Jenis Materi

### 4.1 Video YouTube

```yaml
🎥 JENIS: youtube
├── Type: "youtube"
├── YouTube URL: "https://www.youtube.com/watch?v=..."
└── Field Tambahan: Semua field standar
```

**Contoh Lengkap:**
```
Judul Materi: "Belajar Penjumlahan untuk Anak"
Mata Pelajaran: "Matematika"
Deskripsi: "Video pembelajaran penjumlahan dasar dengan metode yang mudah dipahami anak"
Type: "youtube"
YouTube URL: "https://www.youtube.com/watch?v=ScDaLQpD-A8"
Chapter Number: 2
Chapter Title: "BAB 1.2: Operasi Hitung Dasar"
Material Order: 1
Batch ID: [Pilih Paket Matematika]
Tutor ID: [Pilih Tutor Anda]
Is Public: ✅ (Yes)
Is Featured: ✅ (Yes)
Is Completable: ✅ (Yes)
Duration Seconds: 1080 (18 menit)
```

### 4.2 Dokumen PDF

```yaml
📄 JENIS: document
├── Type: "document"
├── File Path: "materials/nama-file.pdf"
└── Field Tambahan: Semua field standar
```

**Contoh Lengkap:**
```
Judul Materi: "Soal Latihan Penjumlahan"
Mata Pelajaran: "Matematika"
Deskripsi: "Kumpulan soal penjumlahan dengan tingkat kesulitan bertahap"
Type: "document"
File Path: "materials/soal-penjumlahan.pdf"
Chapter Number: 2
Chapter Title: "BAB 1.2: Operasi Hitung Dasar"
Material Order: 2
Batch ID: [Pilih Paket Matematika]
Tutor ID: [Pilih Tutor Anda]
Is Public: ✅ (Yes)
Is Featured: ❌ (No)
Is Completable: ✅ (Yes)
Duration Seconds: 1500 (25 menit)
```

### 4.3 File Video Upload

```yaml
🎬 JENIS: video
├── Type: "video"
├── File Path: "materials/nama-video.mp4"
└── Field Tambahan: Semua field standar
```

### 4.4 Link Eksternal

```yaml
🔗 JENIS: link
├── Type: "link"
├── External Link: "https://..."
└── Field Tambahan: Semua field standar
```

## 🎯 Langkah 5: Contoh Lengkap Input 1 BAB (3 Materials)

### 5.1 Materi 1: Video YouTube

```
📋 FORM 1 - VIDEO PEMBELAJARAN:
├── Judul: "Mengenal Angka 1-10"
├── Mapel: "Matematika"
├── Deskripsi: "Video pembelajaran mengenal angka 1-10 untuk anak-anak"
├── Type: "youtube"
├── YouTube URL: "https://www.youtube.com/watch?v=dQw4w9WgXcQ"
├── Chapter Number: 1
├── Chapter Title: "BAB 1.1: Pengenalan Angka dan Bilangan"
├── Material Order: 1
├── Batch ID: [Pilih Paket Matematika]
├── Tutor ID: [Pilih Tutor]
├── Is Public: ✅
├── Is Featured: ✅
├── Is Completable: ✅
└── Duration: 900 (15 menit)
```

### 5.2 Materi 2: PDF Document

```
📋 FORM 2 - WORKSHOP PDF:
├── Judul: "Latihan Menulis Angka"
├── Mapel: "Matematika"
├── Deskripsi: "Worksheet untuk latihan menulis angka 1-10"
├── Type: "document"
├── File Path: "materials/latihan-menulis-angka.pdf"
├── Chapter Number: 1
├── Chapter Title: "BAB 1.1: Pengenalan Angka dan Bilangan"
├── Material Order: 2
├── Batch ID: [Pilih Paket Matematika]
├── Tutor ID: [Pilih Tutor]
├── Is Public: ✅
├── Is Featured: ❌
├── Is Completable: ✅
└── Duration: 1200 (20 menit)
```

### 5.3 Materi 3: Link Eksternal

```
📋 FORM 3 - GAME INTERAKTIF:
├── Judul: "Permainan Angka Interaktif"
├── Mapel: "Matematika"
├── Deskripsi: "Game online untuk belajar angka dengan cara menyenangkan"
├── Type: "link"
├── External Link: "https://www.ixl.com/math/kindergarten"
├── Chapter Number: 1
├── Chapter Title: "BAB 1.1: Pengenalan Angka dan Bilangan"
├── Material Order: 3
├── Batch ID: [Pilih Paket Matematika]
├── Tutor ID: [Pilih Tutor]
├── Is Public: ✅
├── Is Featured: ❌
├── Is Completable: ✅
└── Duration: 600 (10 menit)
```

## ✅ Langkah 6: Checklist Sebelum Submit

### 6.1 Validasi Data

```yaml
🔍 CEK SEBELUM SUBMIT:
├── ✅ Judul materi sudah sesuai dan deskriptif
├── ✅ Mata pelajaran sudah benar
├── ✅ Chapter Number mengikuti urutan (1, 2, 3, dst...)
├── ✅ Chapter Title menggunakan format "BAB X.X: [Nama]"
├── ✅ Material Order sudah benar (1, 2, 3 untuk setiap BAB)
├── ✅ Batch ID sudah dipilih (paket yang sesuai)
├── ✅ Tutor ID sudah dipilih
├── ✅ Type sesuai dengan konten (youtube/document/video/link)
├── ✅ URL atau file path sudah valid
├── ✅ Is Public, Is Featured, Is Completable sudah sesuai
└── ✅ Duration dalam satuan detik sudah合理
```

### 6.2 Tips Penting

```yaml
💡 BEST PRACTICES:
├── Gunakan nama BAB yang konsisten: "BAB 1.1", "BAB 1.2", dst...
├── Material Order: 1=Video utama, 2=PDF/latihan, 3=Referensi/link
├── Is Featured: Pilih 1 materi terbaik per BAB sebagai featured
├── Durasi: Video (10-30 menit), PDF (15-45 menit), Link (5-15 menit)
└── Deskripsi: Buat deskripsi yang menarik dan informatif
```

## 🔄 Langkah 7: Lanjutkan untuk BAB Berikutnya

### 7.1 Untuk BAB 1.2 (Chapter Number = 2)

```
📝 GANTI:
├── Chapter Number: 2 (bukan 1)
├── Chapter Title: "BAB 1.2: [Nama BAB]"
└── Material Order: 1, 2, 3 (mulai dari 1 lagi)
```

### 7.2 Untuk BAB 1.3 (Chapter Number = 3)

```
📝 GANTI:
├── Chapter Number: 3 (bukan 1 atau 2)
├── Chapter Title: "BAB 1.3: [Nama BAB]"
└── Material Order: 1, 2, 3 (mulai dari 1 lagi)
```

### 7.3 Untuk BAB 2.1 (Chapter Number = 4)

```
📝 GANTI:
├── Chapter Number: 4
├── Chapter Title: "BAB 2.1: [Nama BAB]"
└── Material Order: 1, 2, 3 (mulai dari 1 lagi)
```

## 🎉 Langkah 8: Verifikasi Hasil

### 8.1 Cek di List Materials
```
1. Setelah submit semua materials
2. Kembali ke list materials
3. Filter berdasarkan Chapter Number
4. Pastikan urutan BAB sudah benar
5. Pastikan setiap BAB memiliki 3 materials
```

### 8.2 Test di User Interface
```
1. Buka halaman materials sebagai user
2. Pilih view "chapters"
3. Pastikan BAB-BAB tampil dengan benar
4. Pastikan urutan materials sudah sesuai
```

## 📞 Troubleshooting

### Error: "Chapter number sudah ada"
```
✅ SOLUSI: Gunakan nomor chapter yang belum digunakan
📝 CONTOH: Jika 1,2,3 sudah digunakan, lanjutkan dengan 4,5,6
```

### Error: "Material order harus unik per BAB"
```
✅ SOLUSI: Pastikan Material Order 1,2,3 untuk setiap BAB
📝 CONTOH: BAB 1.1: Order 1,2,3 | BAB 1.2: Order 1,2,3 | dst...
```

### Error: "Batch ID tidak valid"
```
✅ SOLUSI: Pastikan paket ujian sudah dibuat
📝 CONTOH: Jalankan seeder terlebih dahulu: PaketUjianSeeder
```

---

**🎯 Ingat!** Kunci sukses input materials yang terstruktur adalah konsistensi dalam penomoran chapter dan penamaan BAB. Selalu gunakan format "BAB X.X: [Nama]" dan pastikan Material Order dimulai dari 1 untuk setiap BAB baru!