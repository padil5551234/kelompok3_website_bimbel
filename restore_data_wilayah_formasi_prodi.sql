-- SQL Script untuk mengisi data formasi, wilayah, dan prodi
-- Berdasarkan data dari dinassol_new.sql

-- =====================================================
-- 1. MENGISI DATA FORMASI
-- =====================================================

-- Hapus data existing (jika ada)
TRUNCATE TABLE formasi;

-- Insert data formasi (40 data)
INSERT INTO formasi (kode, nama) VALUES
('00', 'Umum/Lainnya'),
('01', 'Badan Pusat Statistik Pusat'),
('02', 'BPS Provinsi Aceh'),
('03', 'BPS Provinsi Sumatera Utara'),
('04', 'BPS Provinsi Sumatera Barat'),
('05', 'BPS Provinsi Riau'),
('06', 'BPS Provinsi Jambi'),
('07', 'BPS Provinsi Sumatera Selatan'),
('08', 'BPS Provinsi Bengkulu'),
('09', 'BPS Provinsi Lampung'),
('10', 'BPS Provinsi Kepulauan Bangka Belitung'),
('11', 'BPS Provinsi Kepulauan Riau'),
('12', 'BPS Provinsi DKI Jakarta'),
('13', 'BPS Provinsi Jawa Barat'),
('14', 'BPS Provinsi Jawa Tengah'),
('15', 'BPS Provinsi DI Yogyakarta'),
('16', 'BPS Provinsi Jawa Timur'),
('17', 'BPS Provinsi Banten'),
('18', 'BPS Provinsi Bali'),
('19', 'BPS Provinsi Nusa Tenggara Barat'),
('20', 'BPS Provinsi Nusa Tenggara Timur'),
('21', 'BPS Provinsi Kalimantan Barat'),
('22', 'BPS Provinsi Kalimantan Tengah'),
('23', 'BPS Provinsi Kalimantan Selatan'),
('24', 'BPS Provinsi Kalimantan Timur'),
('25', 'BPS Provinsi Kalimantan Utara'),
('26', 'BPS Provinsi Sulawesi Utara'),
('27', 'BPS Provinsi Sulawesi Tengah'),
('28', 'BPS Provinsi Sulawesi Selatan'),
('29', 'BPS Provinsi Sulawesi Tenggara'),
('30', 'BPS Provinsi Gorontalo'),
('31', 'BPS Provinsi Sulawesi Barat'),
('32', 'BPS Provinsi Maluku'),
('33', 'BPS Provinsi Maluku Utara'),
('34', 'BPS Provinsi Papua Barat'),
('35', 'BPS Provinsi Papua'),
('36', 'BPS Provinsi Papua Tengah'),
('37', 'BPS Provinsi Papua Pegunungan'),
('38', 'BPS Provinsi Papua Selatan'),
('39', 'BPS Provinsi Papua Barat Daya');

-- =====================================================
-- 2. MENGISI DATA WILAYAH
-- =====================================================

-- Hapus data existing (jika ada)
TRUNCATE TABLE wilayah;

-- Insert data wilayah (77 data)
INSERT INTO wilayah (kode, nama) VALUES
('11', 'Aceh'),
('12', 'Sumatera Utara'),
('13', 'Sumatera Barat'),
('14', 'Riau'),
('15', 'Jambi'),
('16', 'Sumatera Selatan'),
('17', 'Bengkulu'),
('18', 'Lampung'),
('19', 'Kepulauan Bangka Belitung'),
('21', 'Kepulauan Riau'),
('31', 'DKI Jakarta'),
('31.01', 'Kepulauan Seribu'),
('31.71', 'Jakarta Selatan'),
('31.71.01', 'Jagakarsa'),
('31.71.02', 'Pasar Minggu'),
('31.71.03', 'Cilandak'),
('31.71.04', 'Pesanggrahan'),
('31.71.05', 'Kebayoran Lama'),
('31.71.06', 'Kebayoran Baru'),
('31.71.07', 'Mampang Prapatan'),
('31.71.08', 'Pancoran'),
('31.71.09', 'Tebet'),
('31.71.10', 'Setiubic'),
('31.72', 'Jakarta Timur'),
('31.73', 'Jakarta Pusat'),
('31.74', 'Jakarta Barat'),
('31.75', 'Jakarta Utara'),
('32', 'Jawa Barat'),
('32.01', 'Bogor'),
('32.02', 'Sukabumi'),
('32.03', 'Cianjur'),
('32.04', 'Bandung'),
('32.71', 'Kota Bogor'),
('32.71.01', 'Bogor Selatan'),
('32.71.02', 'Bogor Timur'),
('32.71.03', 'Bogor Utara'),
('32.71.04', 'Bogor Tengah'),
('32.71.05', 'Bogor Barat'),
('32.71.06', 'Tanah Sareal'),
('32.72', 'Kota Sukabumi'),
('32.73', 'Kota Bandung'),
('32.73.01', 'Bandung Kulon'),
('32.73.02', 'Babakan Ciparay'),
('32.73.03', 'Bojongloa Kaler'),
('32.73.04', 'Bojongloa Kidul'),
('32.73.05', 'Astana Anyar'),
('32.73.06', 'Regol'),
('32.73.07', 'Lengkong'),
('32.73.08', 'Bandung Kidul'),
('32.73.09', 'Buahbatu'),
('32.73.10', 'Rancasari'),
('32.74', 'Kota Cirebon'),
('32.75', 'Kota Bekasi'),
('32.76', 'Kota Depok'),
('32.77', 'Kota Cimahi'),
('33', 'Jawa Tengah'),
('34', 'DI Yogyakarta'),
('35', 'Jawa Timur'),
('36', 'Banten'),
('51', 'Bali'),
('52', 'Nusa Tenggara Barat'),
('53', 'Nusa Tenggara Timur'),
('61', 'Kalimantan Barat'),
('62', 'Kalimantan Tengah'),
('63', 'Kalimantan Selatan'),
('64', 'Kalimantan Timur'),
('65', 'Kalimantan Utara'),
('71', 'Sulawesi Utara'),
('72', 'Sulawesi Tengah'),
('73', 'Sulawesi Selatan'),
('74', 'Sulawesi Tenggara'),
('75', 'Gorontalo'),
('76', 'Sulawesi Barat'),
('81', 'Maluku'),
('82', 'Maluku Utara'),
('91', 'Papua Barat'),
('92', 'Papua'),
('93', 'Papua Tengah'),
('94', 'Papua Pegunungan'),
('95', 'Papua Selatan'),
('96', 'Papua Barat Daya');

-- =====================================================
-- 3. MENGISI DATA PRODI
-- =====================================================

-- Hapus data existing (jika ada)
TRUNCATE TABLE prodi;

-- Insert data prodi (4 data)
INSERT INTO prodi (kode, nama) VALUES
(1, 'D3 Statistika'),
(2, 'D4 Statistika Terapan'),
(3, 'D4 Komputasi Statistik'),
(4, 'Lainnya');

-- =====================================================
-- VERIFIKASI DATA
-- =====================================================

-- Tampilkan jumlah data per tabel
SELECT 'FORMASI' as tabel, COUNT(*) as jumlah_data FROM formasi
UNION ALL
SELECT 'WILAYAH' as tabel, COUNT(*) as jumlah_data FROM wilayah
UNION ALL
SELECT 'PRODI' as tabel, COUNT(*) as jumlah_data FROM prodi;

-- Tampilkan sample data dari setiap tabel
SELECT '=== SAMPLE DATA FORMASI ===' as info;
SELECT * FROM formasi LIMIT 5;

SELECT '=== SAMPLE DATA WILAYAH ===' as info;
SELECT * FROM wilayah LIMIT 5;

SELECT '=== SAMPLE DATA PRODI ===' as info;
SELECT * FROM prodi;

-- =====================================================
-- SELESAI
-- =====================================================

SELECT 'Data berhasil diisi!' as status;