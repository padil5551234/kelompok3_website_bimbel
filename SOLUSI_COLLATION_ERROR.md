# Solusi Error Collation MySQL: "Illegal mix of collations"

## Masalah
Error `#1267 - Illegal mix of collations (utf8mb4_unicode_ci,IMPLICIT) and (utf8mb4_general_ci,IMPLICIT) for operation '='` terjadi ketika melakukan JOIN antara tabel `formasi` dan `kabupaten` karena kolom yang dibandingkan (`f.kode` dan `k.kode_provinsi`) memiliki collation yang berbeda.

## Penyebab
- Tabel `formasi` memiliki kolom `kode` dengan collation `utf8mb4_general_ci`
- Tabel `kabupaten` memiliki kolom `kode_provinsi` dengan collation `utf8mb4_unicode_ci`
- MySQL tidak dapat membandingkan kedua kolom karena collation berbeda

## Solusi (Pilih salah satu)

### Solusi 1: Gunakan COLLATE Clause (REKOMENDASI)
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

### Solusi 2: Gunakan BINARY Comparison
```sql
SELECT 
  f.nama as provinsi,
  COUNT(k.id) as jumlah_kabupaten
FROM formasi f
LEFT JOIN kabupaten k ON BINARY f.kode = BINARY k.kode_provinsi
WHERE f.kode != '00' AND f.kode != '01'
GROUP BY f.kode, f.nama
ORDER BY f.kode;
```

### Solusi 3: Ubah Collation Tabel formasi
```sql
-- Ubah collation tabel formasi
ALTER TABLE formasi CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Ubah kolom spesifik
ALTER TABLE formasi MODIFY kode VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
```

### Solusi 4: Ubah Collation Tabel kabupaten
```sql
-- Ubah collation tabel kabupaten
ALTER TABLE kabupaten CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- Ubah kolom spesifik
ALTER TABLE kabupaten MODIFY kode_provinsi VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
```

## Solusi Permanen: Update Struktur Tabel

Saya sudah membuat file `contoh_sql_kabupaten_fixed.sql` yang berisi:

1. **Pembuatan tabel dengan collation yang konsisten**
2. **Query yang sudah diperbaiki** dengan 3 metode berbeda
3. **Dokumentasi lengkap** cara penggunaan

### Query yang diperbaiki dalam file:

```sql
-- Method 1: COLLATE clause (paling reliable)
SELECT 
  f.nama as provinsi,
  COUNT(k.id) as jumlah_kabupaten
FROM formasi f
LEFT JOIN kabupaten k ON f.kode COLLATE utf8mb4_unicode_ci = k.kode_provinsi COLLATE utf8mb4_unicode_ci
WHERE f.kode != '00' AND f.kode != '01'
GROUP BY f.kode, f.nama
ORDER BY f.kode
LIMIT 0, 25;

-- Method 2: BINARY comparison (paling cepat)
SELECT 
  f.nama as provinsi,
  COUNT(k.id) as jumlah_kabupaten
FROM formasi f
LEFT JOIN kabupaten k ON BINARY f.kode = BINARY k.kode_provinsi
WHERE f.kode != '00' AND f.kode != '01'
GROUP BY f.kode, f.nama
ORDER BY f.kode
LIMIT 0, 25;

-- Method 3: CONVERT function
SELECT 
  f.nama as provinsi,
  COUNT(k.id) as jumlah_kabupaten
FROM formasi f
LEFT JOIN kabupaten k ON CONVERT(f.kode USING utf8mb4) = CONVERT(k.kode_provinsi USING utf8mb4)
WHERE f.kode != '00' AND f.kode != '01'
GROUP BY f.kode, f.nama
ORDER BY f.kode
LIMIT 0, 25;
```

## Cara Menggunakan File yang Diperbaiki

1. **Gunakan file `contoh_sql_kabupaten_fixed.sql`**
2. **Eksekusi dengan salah satu dari 3 metode** yang tersedia
3. **Pilih Method 1 (COLLATE clause)** untuk hasil terbaik

## Verifikasi Collation

Untuk mengecek collation tabel saat ini:
```sql
SELECT TABLE_NAME, COLUMN_NAME, COLLATION_NAME 
FROM information_schema.COLUMNS 
WHERE TABLE_SCHEMA = 'your_database_name' 
AND TABLE_NAME IN ('formasi', 'kabupaten')
AND COLUMN_NAME IN ('kode', 'kode_provinsi');
```

## Rekomendasi

1. **Gunakan Method 1** dalam file `contoh_sql_kabupaten_fixed.sql` - paling reliable
2. **Jika ingin solusi permanen**, gunakan Solusi 3 atau 4 untuk menyamakan collation di level database
3. **Backup database** sebelum mengubah struktur tabel

## Troubleshooting

Jika masih ada error:
1. Cek apakah kedua tabel menggunakan charset yang sama (`utf8mb4`)
2. Pastikan tidak ada hidden characters di data
3. Gunakan `BINARY` comparison jika data sudah konsisten

File `contoh_sql_kabupaten_fixed.sql` sudah siap digunakan dan akan menyelesaikan masalah collation error Anda.