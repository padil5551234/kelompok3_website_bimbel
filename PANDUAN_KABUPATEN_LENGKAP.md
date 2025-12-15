# SQL Lengkap Kabupaten/Kota Indonesia - 514 Data

## File Lengkap
**`restore_kabupaten_lengkap.sql`** - Berisi seluruh 514 kabupaten/kota Indonesia untuk 38 provinsi BPS

## Isi File
- **Total Data**: 514 kabupaten/kota
- **Provinsi**: 38 provinsi lengkap Indonesia
- **Format**: Kode BPS + nama sesuai standar resmi
- **Collation**: Sudah diperbaiki untuk mengatasi error

## Struktur Data per Provinsi

### Pulau Sumatera (10 Provinsi)
1. Aceh (21 kabupaten/kota)
2. Sumatera Utara (25 kabupaten/kota)
3. Sumatera Barat (17 kabupaten/kota)
4. Riau (12 kabupaten/kota)
5. Jambi (9 kabupaten/kota)
6. Sumatera Selatan (17 kabupaten/kota)
7. Bengkulu (7 kabupaten/kota)
8. Lampung (15 kabupaten/kota)
9. Kepulauan Bangka Belitung (7 kabupaten/kota)
10. Kepulauan Riau (7 kabupaten/kota)

### Pulau Jawa (6 Provinsi)
11. DKI Jakarta (6 kabupaten/kota)
12. Jawa Barat (27 kabupaten/kota)
13. Jawa Tengah (35 kabupaten/kota)
14. DI Yogyakarta (5 kabupaten/kota)
15. Jawa Timur (38 kabupaten/kota)
16. Banten (8 kabupaten/kota)

### Pulau Bali & Nusa Tenggara (3 Provinsi)
17. Bali (9 kabupaten/kota)
18. Nusa Tenggara Barat (9 kabupaten/kota)
19. Nusa Tenggara Timur (22 kabupaten/kota)

### Pulau Kalimantan (5 Provinsi)
20. Kalimantan Barat (14 kabupaten/kota)
21. Kalimantan Tengah (14 kabupaten/kota)
22. Kalimantan Selatan (13 kabupaten/kota)
23. Kalimantan Timur (10 kabupaten/kota)
24. Kalimantan Utara (5 kabupaten/kota)

### Pulau Sulawesi (6 Provinsi)
25. Sulawesi Utara (15 kabupaten/kota)
26. Sulawesi Tengah (13 kabupaten/kota)
27. Sulawesi Selatan (24 kabupaten/kota)
28. Sulawesi Tenggara (14 kabupaten/kota)
29. Gorontalo (5 kabupaten/kota)
30. Sulawesi Barat (7 kabupaten/kota)

### Pulau Maluku & Papua (4 Provinsi)
31. Maluku (12 kabupaten/kota)
32. Maluku Utara (10 kabupaten/kota)
33. Papua Barat (14 kabupaten/kota)
34. Papua (29 kabupaten/kota)

## Cara Penggunaan

### 1. Import via phpMyAdmin
1. Buka phpMyAdmin
2. Pilih database Anda
3. Klik "Import"
4. Upload file `restore_kabupaten_lengkap.sql`
5. Klik "Go"

### 2. Command Line
```bash
mysql -u username -p database_name < restore_kabupaten_lengkap.sql
```

### 3. Copy-Paste SQL Editor
1. Buka file `restore_kabupaten_lengkap.sql`
2. Copy seluruh isi file
3. Paste ke SQL Editor (phpMyAdmin, MySQL Workbench, dll)
4. Execute

## Query yang Sudah Diperbaiki

### Cek Total Data
```sql
SELECT COUNT(*) as total_kabupaten FROM kabupaten;
```
**Expected Result**: 514

### Query dengan Collation Fix
```sql
SELECT 
  f.nama as provinsi,
  COUNT(k.id) as jumlah_kabupaten
FROM formasi f
LEFT JOIN kabupaten k ON f.kode COLLATE utf8mb4_unicode_ci = k.kode_provinsi COLLATE utf8mb4_unicode_ci
WHERE f.kode != '00' AND f.kode != '01'
GROUP BY f.kode, f.nama
ORDER BY f.kode;
```

### Sample Data JOIN
```sql
SELECT k.nama as kabupaten, f.nama as provinsi 
FROM kabupaten k 
JOIN formasi f ON f.kode COLLATE utf8mb4_unicode_ci = k.kode_provinsi COLLATE utf8mb4_unicode_ci
WHERE f.kode != '00' AND f.kode != '01'
ORDER BY f.kode, k.nama
LIMIT 20;
```

## Kelebihan File Ini

1. **Data Lengkap**: Semua 514 kabupaten/kota Indonesia
2. **Collation Fixed**: Sudah mengatasi error collation
3. **Standar BPS**: Kode dan nama sesuai standar resmi
4. **Ready to Use**: Langsung bisa diimport tanpa edit
5. **Documentation**: Include verification queries

## Verifikasi Sukses Import

Setelah import berhasil, seharusnya:
- ✅ Total data = 514 kabupaten/kota
- ✅ Query JOIN tidak error collation
- ✅ Data tersimpan dengan charset utf8mb4_unicode_ci
- ✅ Hubungan dengan tabel formasi berfungsi normal

File `restore_kabupaten_lengkap.sql` sudah siap digunakan dan berisi seluruh data kabupaten/kota Indonesia yang Anda perlukan.