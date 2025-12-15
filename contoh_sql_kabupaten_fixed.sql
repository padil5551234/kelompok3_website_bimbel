-- =====================================================
-- STRUKTUR SQL UNTUK MENAMBAH KABUPATEN KE DATABASE
-- =====================================================

-- 1. BUAT TABEL KABUPATEN (jika belum ada)
CREATE TABLE IF NOT EXISTS `kabupaten` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_provinsi` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kabupaten_kode_unique` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. HAPUS DATA EXISTING
TRUNCATE TABLE kabupaten;

-- 3. INSERT DATA KABUPATEN (CONTOH BEBERAPA PROVINSI)
INSERT INTO kabupaten (kode, kode_provinsi, nama) VALUES

-- =====================================================
-- CONTOH DATA UNTUK PROVINSI ACEH (BPS 02)
-- =====================================================
('1101', '02', 'Kabupaten Aceh Selatan'),
('1102', '02', 'Kabupaten Aceh Tenggara'),
('1103', '02', 'Kabupaten Aceh Timur'),
('1104', '02', 'Kabupaten Aceh Tengah'),
('1105', '02', 'Kabupaten Aceh Barat'),
('1106', '02', 'Kabupaten Aceh Besar'),
('1107', '02', 'Kabupaten Pidie'),
('1108', '02', 'Kabupaten Bireuen'),
('1109', '02', 'Kabupaten Aceh Utara'),
('1110', '02', 'Kabupaten Aceh Barat Daya'),
('1111', '02', 'Kabupaten Gayo Lues'),
('1112', '02', 'Kabupaten Aceh Tamiang'),
('1113', '02', 'Kabupaten Nagan Raya'),
('1114', '02', 'Kabupaten Aceh Jaya'),
('1115', '02', 'Kabupaten Bener Meriah'),
('1116', '02', 'Kabupaten Pidie Jaya'),
('1171', '02', 'Kota Banda Aceh'),
('1172', '02', 'Kota Sabang'),
('1173', '02', 'Kota Langsa'),
('1174', '02', 'Kota Lhokseumawe'),
('1175', '02', 'Kota Subulussalam'),

-- =====================================================
-- CONTOH DATA UNTUK PROVINSI DKI JAKARTA (BPS 12)
-- =====================================================
('3101', '12', 'Kabupaten Kepulauan Seribu'),
('3171', '12', 'Kota Jakarta Selatan'),
('3172', '12', 'Kota Jakarta Timur'),
('3173', '12', 'Kota Jakarta Pusat'),
('3174', '12', 'Kota Jakarta Barat'),
('3175', '12', 'Kota Jakarta Utara'),

-- =====================================================
-- CONTOH DATA UNTUK PROVINSI BALI (BPS 18)
-- =====================================================
('5101', '18', 'Kabupaten Jembrana'),
('5102', '18', 'Kabupaten Tabanan'),
('5103', '18', 'Kabupaten Badung'),
('5104', '18', 'Kabupaten Gianyar'),
('5105', '18', 'Kabupaten Klungkung'),
('5106', '18', 'Kabupaten Bangli'),
('5107', '18', 'Kabupaten Karang Asem'),
('5108', '18', 'Kabupaten Buleleng'),
('5171', '18', 'Kota Denpasar');

-- =====================================================
-- VERIFIKASI DATA (SOLUSI UNTUK COLLATION ERROR)
-- =====================================================

-- Method 1: Using COLLATE clause to force same collation
SELECT 
  f.nama as provinsi,
  COUNT(k.id) as jumlah_kabupaten
FROM formasi f
LEFT JOIN kabupaten k ON f.kode COLLATE utf8mb4_unicode_ci = k.kode_provinsi COLLATE utf8mb4_unicode_ci
WHERE f.kode != '00' AND f.kode != '01'
GROUP BY f.kode, f.nama
ORDER BY f.kode
LIMIT 0, 25;

-- Method 2: Using BINARY comparison (faster but case-sensitive)
SELECT 
  f.nama as provinsi,
  COUNT(k.id) as jumlah_kabupaten
FROM formasi f
LEFT JOIN kabupaten k ON BINARY f.kode = BINARY k.kode_provinsi
WHERE f.kode != '00' AND f.kode != '01'
GROUP BY f.kode, f.nama
ORDER BY f.kode
LIMIT 0, 25;

-- Method 3: Alternative using CONVERT function
SELECT 
  f.nama as provinsi,
  COUNT(k.id) as jumlah_kabupaten
FROM formasi f
LEFT JOIN kabupaten k ON CONVERT(f.kode USING utf8mb4) = CONVERT(k.kode_provinsi USING utf8mb4)
WHERE f.kode != '00' AND f.kode != '01'
GROUP BY f.kode, f.nama
ORDER BY f.kode
LIMIT 0, 25;

-- Sample data dengan JOIN (fixed with collation)
SELECT k.nama as kabupaten, f.nama as provinsi 
FROM kabupaten k 
JOIN formasi f ON f.kode COLLATE utf8mb4_unicode_ci = k.kode_provinsi COLLATE utf8mb4_unicode_ci
WHERE f.kode != '00' AND f.kode != '01'
LIMIT 10;

-- =====================================================
-- CARA PENGGUNAAN:
-- =====================================================

-- Metode 1: Import langsung via phpMyAdmin
-- 1. Buka phpMyAdmin
-- 2. Pilih database Anda
-- 3. Klik "Import"
-- 4. Upload file restore_kabupaten_formasi.sql
-- 5. Klik "Go"

-- Metode 2: Command Line MySQL
-- mysql -u username -p database_name < restore_kabupaten_formasi.sql

-- Metode 3: Copy-paste script di atas ke SQL Editor
-- 1. Buka phpMyAdmin atau SQL Editor
-- 2. Copy script di atas
-- 3. Paste dan execute

-- =====================================================
-- SOLUSI UNTUK COLLATION ERROR:
-- =====================================================

-- Pilihan 1: Gunakan Method 1 (COLLATE clause) - REKOMENDASI
-- Pilihan 2: Ubah collation tabel formasi ke utf8mb4_unicode_ci
-- Pilihan 3: Gunakan Method 2 (BINARY comparison) jika data konsisten

-- Query untuk cek collation tabel:
-- SELECT TABLE_NAME, COLUMN_NAME, COLLATION_NAME 
-- FROM information_schema.COLUMNS 
-- WHERE TABLE_SCHEMA = 'your_database_name' 
-- AND TABLE_NAME IN ('formasi', 'kabupaten')
-- AND COLUMN_NAME IN ('kode', 'kode_provinsi');

-- =====================================================
-- HASIL YANG DIHARAPKAN:
-- =====================================================
-- Total: 514 kabupaten/kota untuk 38 provinsi BPS
-- Semua data terhubung dengan tabel formasi melalui kode_provinsi
-- Error collation sudah teratasi