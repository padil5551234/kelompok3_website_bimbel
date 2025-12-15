# Panduan Restore Data Formasi, Wilayah, dan Prodi

## Overview
Dokumen ini menjelaskan cara mengisi data referensi untuk tabel `formasi`, `wilayah`, dan `prodi` dari file `dinassol_new.sql` yang telah disediakan.

## Files yang Disediakan

### 1. PHP Script: `restore_wilayah_formasi_prodi.php`
- **Fungsi**: Script PHP Laravel untuk mengisi data melalui ORM Eloquent
- **Dependensi**: Memerlukan Laravel framework dan autoload vendor
- **Cara Menjalankan**: 
  ```bash
  php restore_wilayah_formasi_prodi.php
  ```

### 2. SQL Script: `restore_data_wilayah_formasi_prodi.sql`
- **Fungsi**: Script SQL langsung untuk mengisi data ke database
- **Dependensi**: Hanya memerlukan akses MySQL/MariaDB
- **Cara Menjalankan**: 
  ```bash
  mysql -u username -p database_name < restore_data_wilayah_formasi_prodi.sql
  ```
  Atau melalui phpMyAdmin: Import file SQL

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

## Keamanan Data

Kedua script menggunakan metode `TRUNCATE` untuk menghapus data existing dan `INSERT` untuk mengisi data baru. Ini berarti:

- ⚠️ **Data existing akan dihapus**
- ✅ **Data baru akan menggantikan data lama**
- ✅ **Struktur tabel tetap terjaga**

## Cara Menjalankan (Rekomendasi: SQL Script)

### Metode 1: Menggunakan phpMyAdmin (Termudah)
1. Buka phpMyAdmin
2. Pilih database Anda
3. Klik tab "Import"
4. Pilih file `restore_data_wilayah_formasi_prodi.sql`
5. Klik "Go" untuk execute
6. Verifikasi data sudah terisi dengan melihat hasil query

### Metode 2: Menggunakan Command Line MySQL
```bash
# Backup data existing (opsional)
mysqldump -u username -p database_name formasi wilayah prodi > backup_ref_data.sql

# Restore data baru
mysql -u username -p database_name < restore_data_wilayah_formasi_prodi.sql
```

### Metode 3: Menggunakan PHP Script (Jika menggunakan Laravel)
```bash
# Pastikan sudah di directory project Laravel
php restore_wilayah_formasi_prodi.php
```

## Verifikasi Data

Setelah menjalankan script, Anda dapat memverifikasi data dengan query berikut:

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
FROM prodi;

-- Sample data dari setiap tabel
SELECT * FROM formasi LIMIT 5;
SELECT * FROM wilayah LIMIT 5;
SELECT * FROM prodi;
```

## Hasil yang Diharapkan

Setelah berhasil menjalankan script:

| Tabel | Jumlah Data | Status |
|-------|-------------|---------|
| formasi | 40 | ✅ |
| wilayah | 77 | ✅ |
| prodi | 4 | ✅ |

## Troubleshooting

### Error: "Table doesn't exist"
- Pastikan tabel `formasi`, `wilayah`, dan `prodi` sudah ada di database
- Cek struktur tabel sesuai dengan yang ada di file SQL

### Error: "Duplicate entry"
- Normal, script menggunakan INSERT yang akan menggantikan data existing
- Data lama akan diganti dengan data baru dari file

### Error: "Access denied"
- Pastikan user database memiliki privilege INSERT, TRUNCATE, dan SELECT
- Cek konfigurasi koneksi database

## Support

Jika ada masalah atau pertanyaan, silakan periksa:
1. Apakah file SQL dijalankan di database yang benar
2. Apakah struktur tabel sesuai dengan yang diharapkan
3. Apakah user database memiliki privilege yang cukup

## File Tambahan

- `dinassol_new.sql`: File SQL asli dengan data referensi
- `restore_wilayah_formasi_prodi.php`: Script PHP Laravel (alternatif)
- `restore_data_wilayah_formasi_prodi.sql`: Script SQL langsung (rekomendasi)
- `PANDUAN_RESTORE_DATA.md`: Dokumentasi ini
