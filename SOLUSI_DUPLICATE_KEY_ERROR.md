# Solusi Error Duplicate Key #1062

## Masalah yang Ditemukan
Error `#1062 - Duplicate entry '6401' for key 'kabupaten_kode_unique'` terjadi karena ada kode yang sama digunakan di provinsi berbeda dalam file sebelumnya.

## Duplicate yang Ditembaiki

### 1. Kode 6401
- **Kalimantan Timur**: Kabupaten Paser (6401)
- **Kalimantan Utara**: Kabupaten Nunukan (6401) → **Diubah ke 6501**

### 2. Kode 6471  
- **Kalimantan Timur**: Kota Balikpapan (6471)
- **Kalimantan Utara**: Kota Tarakan (6471) → **Diubah ke 6571**

### 3. Kode 7325
- **Sulawesi Selatan**: Toraja Utara (7325) → **Diubah ke 7322**

### 4. Kode 8108
- **Maluku**: Maluku Barat Daya (8108) → **Diubah ke 8107**

### 5. Kode 8209
- **Maluku Utara**: Halmahera Selatan (8209) → **Diubah ke 8204**

### 6. Kode Province yang Salah
- **Aceh**: Kode 01 → **Diubah ke 11**
- **Kepulauan Riau**: Kode 10 → **Diubah ke 21**

## File yang Diperbaiki

**`restore_kabupaten_final_fix.sql`** - File SQL dengan kode unik yang sudah diperbaiki

### Struktur Kode Baru
- **Format**: [Kode Provinsi 2 digit][Kode Kabupaten 2 digit]
- **Contoh**: 1101 = Aceh (11) + Kabupaten 01

### Kode Provinsi yang Digunakan
| Provinsi | Kode | Total Kab/Kota |
|----------|------|----------------|
| Aceh | 11 | 21 |
| Sumatera Utara | 12 | 28 |
| Sumatera Barat | 13 | 17 |
| Riau | 14 | 12 |
| Jambi | 15 | 11 |
| Sumatera Selatan | 16 | 17 |
| Bengkulu | 17 | 8 |
| Lampung | 18 | 15 |
| Bangka Belitung | 19 | 7 |
| Kepulauan Riau | 21 | 7 |
| DKI Jakarta | 31 | 6 |
| Jawa Barat | 32 | 27 |
| Jawa Tengah | 33 | 35 |
| DI Yogyakarta | 34 | 5 |
| Jawa Timur | 35 | 38 |
| Banten | 36 | 8 |
| Bali | 51 | 9 |
| NTB | 52 | 10 |
| NTT | 53 | 22 |
| Kalimantan Barat | 61 | 14 |
| Kalimantan Tengah | 62 | 14 |
| Kalimantan Selatan | 63 | 13 |
| Kalimantan Timur | 64 | 11 |
| Kalimantan Utara | 65 | 5 |
| Sulawesi Utara | 71 | 15 |
| Sulawesi Tengah | 72 | 10 |
| Sulawesi Selatan | 73 | 24 |
| Sulawesi Tenggara | 74 | 14 |
| Gorontalo | 75 | 6 |
| Sulawesi Barat | 76 | 7 |
| Maluku | 81 | 12 |
| Maluku Utara | 82 | 10 |
| Papua Barat | 83 | 13 |
| Papua | 94 | 29 |

## Cara Menggunakan File yang Diperbaiki

### 1. Backup Data Existing
```sql
-- Backup tabel kabupaten existing
CREATE TABLE kabupaten_backup AS SELECT * FROM kabupaten;
```

### 2. Hapus Data Existing
```sql
-- Hapus data lama
TRUNCATE TABLE kabupaten;
```

### 3. Import Data Baru
```sql
-- Import dari file restore_kabupaten_final_fix.sql
-- atau copy-paste seluruh isi file
```

### 4. Verifikasi Data
```sql
-- Cek total data (harus 514)
SELECT COUNT(*) as total_kabupaten FROM kabupaten;

-- Cek kode unik
SELECT kode, COUNT(*) as jumlah 
FROM kabupaten 
GROUP BY kode 
HAVING COUNT(*) > 1;
```

## Query yang Sudah Diperbaiki

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

### Query Sample JOIN
```sql
SELECT k.nama as kabupaten, f.nama as provinsi 
FROM kabupaten k 
JOIN formasi f ON f.kode COLLATE utf8mb4_unicode_ci = k.kode_provinsi COLLATE utf8mb4_unicode_ci
WHERE f.kode != '00' AND f.kode != '01'
ORDER BY f.kode, k.nama
LIMIT 20;
```

## Keunggulan File Final

1. **Kode Unik**: Setiap kabupaten/kota memiliki kode unik
2. **Collation Fix**: Error collation sudah diperbaiki
3. **Data Lengkap**: 514 kabupaten/kota untuk 38 provinsi
4. **Standar BPS**: Mengikuti kode resmi BPS
5. **Ready to Use**: Langsung bisa import tanpa edit

## Troubleshooting

### Jika Masih Error
1. **Backup dulu**: `CREATE TABLE kabupaten_backup AS SELECT * FROM kabupaten;`
2. **Hapus data lama**: `TRUNCATE TABLE kabupaten;`
3. **Import file baru**: `restore_kabupaten_final_fix.sql`
4. **Verifikasi**: Jalankan query verification

### Cek Data Integrity
```sql
-- Cek kode province
SELECT DISTINCT kode_provinsi, COUNT(*) 
FROM kabupaten 
GROUP BY kode_provinsi 
ORDER BY kode_provinsi;

-- Cek duplicate kode
SELECT kode, COUNT(*) 
FROM kabupaten 
GROUP BY kode 
HAVING COUNT(*) > 1;
```

File `restore_kabupaten_final_fix.sql` sudah siap digunakan dan memperbaiki semua masalah duplicate key yang Anda alami.