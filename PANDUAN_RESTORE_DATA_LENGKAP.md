# Panduan Restore Data Referensi Lengkap

## Overview
Dokumen ini menjelaskan cara mengisi data referensi untuk tabel `formasi`, `wilayah`, `prodi`, dan `kabupaten` dari file `dinassol_new.sql` yang telah disediakan.

## Files yang Disediakan

### 1. Script untuk Formasi, Wilayah, dan Prodi

#### SQL Script (Direkomendasikan)
**File:** `restore_data_wilayah_formasi_prodi.sql`
- **Fungsi**: Direct SQL execution untuk formasi, wilayah, dan prodi
- **Cara pakai**: Import langsung via phpMyAdmin atau command line MySQL

#### PHP Laravel Script
**File:** `restore_wilayah_formasi_prodi.php`
- **Fungsi**: Laravel Eloquent ORM untuk formasi, wilayah, dan prodi
- **Cara pakai**: `php restore_wilayah_formasi_prodi.php`

### 2. Script untuk Kabupaten/Kota

#### SQL Script (Direkomendasikan)
**File:** `restore_kabupaten_formasi.sql`
- **Fungsi**: Direct SQL execution untuk kabupaten/kota
- **Cara pakai**: Import langsung via phpMyAdmin atau command line MySQL
- **Dependensi**: Memerlukan tabel `formasi` sudah terisi

#### PHP Laravel Script
**File:** `restore_kabupaten_formasi.php`
- **Fungsi**: Laravel Eloquent ORM untuk kabupaten/kota
- **Cara pakai**: `php restore_kabupaten_formasi.php`
- **Dependensi**: Memerlukan tabel `formasi` sudah terisi

## Data yang Akan Diisi

### 1. Tabel Formasi (40 data)
Berisi informasi tentang formasi BPS (Badan Pusat Statistik):
- **Kode**: 00-39
- **Data**: Dari "Umum/Lainnya" hingga "BPS Provinsi Papua Barat Daya"
- **Contoh**:
  - 01: Badan Pusat Statistik Pusat
  - 12: BPS Provinsi DKI Jakarta
  - 35: BPS Provinsi Papua

### 2. Tabel Wilayah (77 data)
Berisi informasi tentang wilayah administratif Indonesia:
- **Kode**: Format hierarkis (11, 12, 13, ..., 96)
- **Data**: Dari Provinsi hingga Kecamatan
- **Contoh**:
  - 11: Aceh
  - 31: DKI Jakarta
  - 31.71.06: Kebayoran Baru
  - 96: Papua Barat Daya

### 3. Tabel Prodi (4 data)
Berisi informasi tentang program studi:
- **Kode**: 1-4
- **Data**:
  - 1: D3 Statistika
  - 2: D4 Statistika Terapan
  - 3: D4 Komputasi Statistik
  - 4: Lainnya

### 4. Tabel Kabupaten (514 data) 🆕
Berisi informasi tentang kabupaten/kota untuk setiap provinsi BPS:
- **Kode**: Format BPS (1101, 1201, 1301, dst.)
- **Koneksi**: Terhubung dengan tabel `formasi` melalui `kode_provinsi`
- **Cakupan**: 514 kabupaten/kota di 38 provinsi Indonesia
- **Contoh**:
  - 1101: Kabupaten Aceh Selatan (terhubung dengan BPS 02)
  - 3171: Kota Jakarta Selatan (terhubung dengan BPS 12)
  - 5104: Kabupaten Gianyar (terhubung dengan BPS 18)

## Struktur Tabel Kabupaten

```sql
CREATE TABLE `kabupaten` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) NOT NULL,
  `kode_provinsi` varchar(10) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kabupaten_kode_unique` (`kode`)
);
```

## Cara Menjalankan (Rekomendasi: SQL Script)

### Metode 1: Menggunakan phpMyAdmin (Termudah)

#### Step 1: Restore Formasi, Wilayah, dan Prodi
1. Buka phpMyAdmin
2. Pilih database Anda
3. Klik tab "Import"
4. Pilih file `restore_data_wilayah_formasi_prodi.sql`
5. Klik "Go" untuk execute

#### Step 2: Restore Kabupaten/Kota
1. Pastikan step 1 sudah selesai
2. Klik tab "Import" lagi
3. Pilih file `restore_kabupaten_formasi.sql`
4. Klik "Go" untuk execute

### Metode 2: Menggunakan Command Line MySQL
```bash
# Backup data existing (opsional)
mysqldump -u username -p database_name formasi wilayah prodi kabupaten > backup_ref_data.sql

# Restore data secara berurutan
mysql -u username -p database_name < restore_data_wilayah_formasi_prodi.sql
mysql -u username -p database_name < restore_kabupaten_formasi.sql
```

### Metode 3: Menggunakan PHP Script (Jika menggunakan Laravel)
```bash
# Pastikan sudah di directory project Laravel
php restore_wilayah_formasi_prodi.php
php restore_kabupaten_formasi.php
```

## Urutan Eksekusi yang Benar

⚠️ **PENTING**: Harus dilakukan secara berurutan:

1. **Pertama**: `restore_data_wilayah_formasi_prodi.sql`
   - Mengisi formasi, wilayah, dan prodi
   - Membuat struktur dasar referensi

2. **Kedua**: `restore_kabupaten_formasi.sql`
   - Mengisi kabupaten/kota
   - Menggunakan data formasi sebagai referensi

Jika urutan terbalik, data kabupaten tidak akan bisa diinput karena referensi `kode_provinsi` belum ada.

## Verifikasi Data

Setelah menjalankan script, Anda dapat memverifikasi data dengan query berikut:

### Verifikasi Dasar
```sql
-- Cek jumlah data per tabel
SELECT 
  'formasi' as tabel, COUNT(*) as jumlah 
FROM formasi
UNION ALL
SELECT 
  'wilayah' as tabel, COUNT(*) as jumlah 
FROM wilayah
UNION ALL
SELECT 
  'prodi' as tabel, COUNT(*) as jumlah 
FROM prodi
UNION ALL
SELECT 
  'kabupaten' as tabel, COUNT(*) as jumlah 
FROM kabupaten;
```

### Verifikasi Kabupaten per Provinsi
```sql
-- Cek jumlah kabupaten per provinsi BPS
SELECT 
  f.nama as provinsi,
  COUNT(k.id) as jumlah_kabupaten
FROM formasi f
LEFT JOIN kabupaten k ON f.kode = k.kode_provinsi
WHERE f.kode != '00' AND f.kode != '01'
GROUP BY f.kode, f.nama
ORDER BY f.kode;
```

### Sample Data
```sql
-- Sample data dari setiap tabel
SELECT * FROM formasi LIMIT 5;
SELECT * FROM wilayah LIMIT 5;
SELECT * FROM prodi;

-- Sample kabupaten dengan koneksi ke provinsi
SELECT k.nama as kabupaten, f.nama as provinsi 
FROM kabupaten k 
JOIN formasi f ON k.kode_provinsi = f.kode 
WHERE f.kode != '00' AND f.kode != '01'
LIMIT 10;
```

## Hasil yang Diharapkan

Setelah berhasil menjalankan semua script:

| Tabel | Jumlah Data | Status |
|-------|-------------|---------|
| formasi | 40 | ✅ |
| wilayah | 77 | ✅ |
| prodi | 4 | ✅ |
| kabupaten | 514 | ✅ |

## Hubungan Antar Tabel

### Diagram Relasi
```
formasi (kode) ←→ kabupaten (kode_provinsi)
    ↓
wilayah (kode)
    ↓
prodi (kode)
```

### Contoh Query dengan JOIN
```sql
-- Menampilkan kabupaten beserta provinsi BPS terkait
SELECT 
  k.nama as kabupaten,
  f.nama as provinsi_bps,
  k.kode as kode_kabupaten,
  f.kode as kode_provinsi_bps
FROM kabupaten k
JOIN formasi f ON k.kode_provinsi = f.kode
WHERE f.kode = '12'  -- DKI Jakarta
ORDER BY k.nama;

-- Statistik kabupaten per pulau
SELECT 
  CASE 
    WHEN f.kode BETWEEN '02' AND '11' THEN 'Sumatra'
    WHEN f.kode BETWEEN '12' AND '18' THEN 'Jawa & Banten'
    WHEN f.kode BETWEEN '19' AND '20' THEN 'Nusa Tenggara'
    WHEN f.kode BETWEEN '21' AND '25' THEN 'Kalimantan'
    WHEN f.kode BETWEEN '26' AND '31' THEN 'Sulawesi'
    WHEN f.kode BETWEEN '32' AND '33' THEN 'Maluku'
    WHEN f.kode >= '34' THEN 'Papua'
  END as pulau,
  COUNT(k.id) as jumlah_kabupaten
FROM formasi f
JOIN kabupaten k ON f.kode = k.kode_provinsi
WHERE f.kode != '00' AND f.kode != '01'
GROUP BY 
  CASE 
    WHEN f.kode BETWEEN '02' AND '11' THEN 'Sumatra'
    WHEN f.kode BETWEEN '12' AND '18' THEN 'Jawa & Banten'
    WHEN f.kode BETWEEN '19' AND '20' THEN 'Nusa Tenggara'
    WHEN f.kode BETWEEN '21' AND '25' THEN 'Kalimantan'
    WHEN f.kode BETWEEN '26' AND '31' THEN 'Sulawesi'
    WHEN f.kode BETWEEN '32' AND '33' THEN 'Maluku'
    WHEN f.kode >= '34' THEN 'Papua'
  END
ORDER BY jumlah_kabupaten DESC;
```

## Troubleshooting

### Error: "Table doesn't exist"
- Pastikan tabel `kabupaten` sudah dibuat (otomatis oleh PHP script)
- Untuk SQL script, buat manual jika diperlukan

### Error: "Foreign key constraint"
- Pastikan data formasi sudah terisi sebelum input kabupaten
- Cek urutan eksekusi script

### Error: "Duplicate entry"
- Normal, script menggunakan INSERT yang akan menggantikan data existing
- Data lama akan diganti dengan data baru dari file

### Error: "Access denied"
- Pastikan user database memiliki privilege INSERT, TRUNCATE, dan SELECT
- Cek konfigurasi koneksi database

## Cakupan Data Kabupaten

| Pulau | Provinsi | Jumlah Kabupaten/Kota |
|-------|----------|----------------------|
| Sumatra | 10 | 134 |
| Jawa & Banten | 7 | 119 |
| Nusa Tenggara | 2 | 34 |
| Kalimantan | 5 | 56 |
| Sulawesi | 6 | 79 |
| Maluku | 2 | 22 |
| Papua | 6 | 70 |
| **Total** | **38** | **514** |

## Keamanan Data

Kedua script menggunakan metode `TRUNCATE` untuk menghapus data existing dan `INSERT` untuk mengisi data baru. Ini berarti:

- ⚠️ **Data existing akan dihapus**
- ✅ **Data baru akan menggantikan data lama**
- ✅ **Struktur tabel tetap terjaga**

## File Tambahan

- `dinassol_new.sql`: File SQL asli dengan data referensi
- `restore_wilayah_formasi_prodi.php`: Script PHP Laravel (alternatif)
- `restore_data_wilayah_formasi_prodi.sql`: Script SQL langsung (rekomendasi)
- `restore_kabupaten_formasi.php`: Script PHP Laravel untuk kabupaten (alternatif)
- `restore_kabupaten_formasi.sql`: Script SQL langsung untuk kabupaten (rekomendasi)
- `PANDUAN_RESTORE_DATA_LENGKAP.md`: Dokumentasi lengkap ini

## Support

Jika ada masalah atau pertanyaan, silakan periksa:
1. Apakah file SQL dijalankan di database yang benar
2. Apakah struktur tabel sesuai dengan yang diharapkan
3. Apakah user database memiliki privilege yang cukup
4. Apakah urutan eksekusi script sudah benar

## Usage Tips

### Untuk Aplikasi Web
```php
// Contoh penggunaan dalam aplikasi
$kabupaten = DB::table('kabupaten')
    ->where('kode_provinsi', '12')  // DKI Jakarta
    ->orderBy('nama')
    ->get();

foreach ($kabupaten as $k) {
    echo $k->nama;  // Nama kabupaten/kota
}
```

### Untuk Form Dropdown
```html
<select name="kabupaten">
    <option value="">Pilih Kabupaten/Kota</option>
    <?php
    $kabupaten = DB::table('kabupaten')
        ->join('formasi', 'kabupaten.kode_provinsi', '=', 'formasi.kode')
        ->where('formasi.kode', $provinsi_selected)
        ->orderBy('kabupaten.nama')
        ->get();
    ?>
    @foreach($kabupaten as $k)
        <option value="{{ $k->kode }}">{{ $k->nama }}</option>
    @endforeach
</select>
```
