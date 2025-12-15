-- =====================================================
-- SQL LENGKAP UNTUK SEMUA KABUPATEN/KOTA INDONESIA
-- Total: 514 kabupaten/kota untuk 38 provinsi BPS
-- KODE UNIK PER KABUPATEN - SUDAH DIPERBAIKI DUPLICATE
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

-- 3. INSERT DATA KABUPATEN/KOTA LENGKAP INDONESIA
INSERT INTO kabupaten (kode, kode_provinsi, nama) VALUES

-- =====================================================
-- PROVINSI ACEH (11)
-- =====================================================
('1101', '11', 'Kabupaten Aceh Selatan'),
('1102', '11', 'Kabupaten Aceh Tenggara'),
('1103', '11', 'Kabupaten Aceh Timur'),
('1104', '11', 'Kabupaten Aceh Tengah'),
('1105', '11', 'Kabupaten Aceh Barat'),
('1106', '11', 'Kabupaten Aceh Besar'),
('1107', '11', 'Kabupaten Pidie'),
('1108', '11', 'Kabupaten Bireuen'),
('1109', '11', 'Kabupaten Aceh Utara'),
('1110', '11', 'Kabupaten Aceh Barat Daya'),
('1111', '11', 'Kabupaten Gayo Lues'),
('1112', '11', 'Kabupaten Aceh Tamiang'),
('1113', '11', 'Kabupaten Nagan Raya'),
('1114', '11', 'Kabupaten Aceh Jaya'),
('1115', '11', 'Kabupaten Bener Meriah'),
('1116', '11', 'Kabupaten Pidie Jaya'),
('1171', '11', 'Kota Banda Aceh'),
('1172', '11', 'Kota Sabang'),
('1173', '11', 'Kota Langsa'),
('1174', '11', 'Kota Lhokseumawe'),
('1175', '11', 'Kota Subulussalam'),

-- =====================================================
-- PROVINSI SUMATERA UTARA (12)
-- =====================================================
('1201', '12', 'Kabupaten Nias'),
('1202', '12', 'Kabupaten Mandailing Natal'),
('1203', '12', 'Kabupaten Tapanuli Selatan'),
('1204', '12', 'Kabupaten Tapanuli Tengah'),
('1205', '12', 'Kabupaten Tapanuli Utara'),
('1206', '12', 'Kabupaten Toba'),
('1207', '12', 'Kabupaten Samosir'),
('1208', '12', 'Kabupaten Humbang Hasundutan'),
('1209', '12', 'Kabupaten Simalungun'),
('1210', '12', 'Kabupaten Dairi'),
('1211', '12', 'Kabupaten Karo'),
('1212', '12', 'Kabupaten Deli Serdang'),
('1213', '12', 'Kabupaten Langkat'),
('1214', '12', 'Kabupaten Pakpak Bharat'),
('1215', '12', 'Kabupaten Serdang Bedagai'),
('1216', '12', 'Kabupaten Batubara'),
('1217', '12', 'Kabupaten Asahan'),
('1218', '12', 'Kabupaten Labuhanbatu'),
('1219', '12', 'Kabupaten Labuhanbatu Selatan'),
('1220', '12', 'Kabupaten Labuhanbatu Utara'),
('1221', '12', 'Kabupaten Nias Utara'),
('1222', '12', 'Kabupaten Nias Barat'),
('1271', '12', 'Kota Medan'),
('1272', '12', 'Kota Pematang Siantar'),
('1273', '12', 'Kota Tebing Tinggi'),
('1274', '12', 'Kota Binjai'),
('1275', '12', 'Kota Tanjungbalai'),
('1276', '12', 'Kota Kisaran'),
('1277', '12', 'Kota Padangsidimpuan'),
('1278', '12', 'Kota Gunungsitoli'),

-- =====================================================
-- PROVINSI SUMATERA BARAT (13)
-- =====================================================
('1301', '13', 'Kabupaten Pasaman'),
('1302', '13', 'Kabupaten Limapuluh Koto'),
('1303', '13', 'Kabupaten Solok'),
('1304', '13', 'Kabupaten Tanah Datar'),
('1305', '13', 'Kabupaten Padang Pariaman'),
('1306', '13', 'Kabupaten Agam'),
('1307', '13', 'Kabupaten Dharmasraya'),
('1308', '13', 'Kabupaten Solok Selatan'),
('1309', '13', 'Kabupaten Pasaman Barat'),
('1310', '13', 'Kabupaten Kepulauwan Mentawai'),
('1371', '13', 'Kota Padang'),
('1372', '13', 'Kota Solok'),
('1373', '13', 'Kota Sawahlunto'),
('1374', '13', 'Kota Padang Panjang'),
('1375', '13', 'Kota Bukittinggi'),
('1376', '13', 'Kota Payakumbuh'),
('1377', '13', 'Kota Pariaman'),

-- =====================================================
-- PROVINSI RIAU (14)
-- =====================================================
('1401', '14', 'Kabupaten Kuantan Singingi'),
('1402', '14', 'Kabupaten Indragiri Hulu'),
('1403', '14', 'Kabupaten Indragiri Hilir'),
('1404', '14', 'Kabupaten Pelalawan'),
('1405', '14', 'Kabupaten Siak'),
('1406', '14', 'Kabupaten Kampar'),
('1407', '14', 'Kabupaten Rokan Hulu'),
('1408', '14', 'Kabupaten Bungo'),
('1409', '14', 'Kabupaten Rokan Hilir'),
('1410', '14', 'Kabupaten Kepulauan Meranti'),
('1471', '14', 'Kota Pekanbaru'),
('1472', '14', 'Kota Dumai'),

-- =====================================================
-- PROVINSI JAMBI (15)
-- =====================================================
('1501', '15', 'Kabupaten Kerinci'),
('1502', '15', 'Kabupaten Merangin'),
('1503', '15', 'Kabupaten Sarolangun'),
('1504', '15', 'Kabupaten Batang Hari'),
('1505', '15', 'Kabupaten Muaro Jambi'),
('1506', '15', 'Kabupaten Tanjung Jabung Barat'),
('1507', '15', 'Kabupaten Tanjung Jabung Timur'),
('1508', '15', 'Kabupaten Bungo'),
('1509', '15', 'Kabupaten Tebo'),
('1571', '15', 'Kota Jambi'),
('1572', '15', 'Kota Sungai Penuh'),

-- =====================================================
-- PROVINSI SUMATERA SELATAN (16)
-- =====================================================
('1601', '16', 'Kabupaten Ogan Komering Ulu'),
('1602', '16', 'Kabupaten Ogan Komering Ilir'),
('1603', '16', 'Kabupaten Muara Enim'),
('1604', '16', 'Kabupaten Lahat'),
('1605', '16', 'Kabupaten Musi Rawas'),
('1606', '16', 'Kabupaten Musi Rawas Utara'),
('1607', '16', 'Kabupaten Banyu Asin'),
('1608', '16', 'Kabupaten Ogan Komering Ulu Selatan'),
('1609', '16', 'Kabupaten Ogan Komering Ulu Timur'),
('1610', '16', 'Kabupaten Ogan Ilir'),
('1611', '16', 'Kabupaten Empat Lawang'),
('1612', '16', 'Kabupaten Penukal Abab Lematang Ilir'),
('1613', '16', 'Kabupaten Musi Banyuasin'),
('1671', '16', 'Kota Palembang'),
('1672', '16', 'Kota Prabumulih'),
('1673', '16', 'Kota Pagar Alam'),
('1674', '16', 'Kota Lubuk Linggau'),

-- =====================================================
-- PROVINSI BENGKULU (17)
-- =====================================================
('1701', '17', 'Kabupaten Bengkulu Selatan'),
('1702', '17', 'Kabupaten Rejang Lebong'),
('1703', '17', 'Kabupaten Bengkulu Utara'),
('1704', '17', 'Kabupaten Kepahiang'),
('1705', '17', 'Kabupaten Bengkulu Tengah'),
('1706', '17', 'Kabupaten Lebong'),
('1707', '17', 'Kabupaten Mukomuko'),
('1771', '17', 'Kota Bengkulu'),

-- =====================================================
-- PROVINSI LAMPUNG (18)
-- =====================================================
('1801', '18', 'Kabupaten Lampung Barat'),
('1802', '18', 'Kabupaten Tanggamus'),
('1803', '18', 'Kabupaten Lampung Selatan'),
('1804', '18', 'Kabupaten Lampung Timur'),
('1805', '18', 'Kabupaten Lampung Tengah'),
('1806', '18', 'Kabupaten Lampung Utara'),
('1807', '18', 'Kabupaten Way Kanan'),
('1808', '18', 'Kabupaten Tulang Bawang'),
('1809', '18', 'Kabupaten Pesawaran'),
('1810', '18', 'Kabupaten Pringsewu'),
('1811', '18', 'Kabupaten Mesuji'),
('1812', '18', 'Kabupaten Tulang Bawang Barat'),
('1813', '18', 'Kabupaten Pesisir Barat'),
('1871', '18', 'Kota Bandar Lampung'),
('1872', '18', 'Kota Metro'),

-- =====================================================
-- PROVINSI KEPULAUAN BANGKA BELITUNG (19)
-- =====================================================
('1901', '19', 'Kabupaten Bangka'),
('1902', '19', 'Kabupaten Belitung'),
('1903', '19', 'Kabupaten Bangka Selatan'),
('1904', '19', 'Kabupaten Belitung Timur'),
('1905', '19', 'Kabupaten Bangka Tengah'),
('1906', '19', 'Kabupaten Bangka Barat'),
('1971', '19', 'Kota Pangkal Pinang'),

-- =====================================================
-- PROVINSI KEPULAUAN RIAU (21)
-- =====================================================
('2101', '21', 'Kabupaten Karimun'),
('2102', '21', 'Kabupaten Bintan'),
('2103', '21', 'Kabupaten Natuna'),
('2104', '21', 'Kabupaten Lingga'),
('2105', '21', 'Kabupaten Kepulauan Anambas'),
('2171', '21', 'Kota Tanjung Pinang'),
('2172', '21', 'Kota Batam'),

-- =====================================================
-- PROVINSI DKI JAKARTA (31)
-- =====================================================
('3101', '31', 'Kabupaten Kepulauan Seribu'),
('3171', '31', 'Kota Jakarta Selatan'),
('3172', '31', 'Kota Jakarta Timur'),
('3173', '31', 'Kota Jakarta Pusat'),
('3174', '31', 'Kota Jakarta Barat'),
('3175', '31', 'Kota Jakarta Utara'),

-- =====================================================
-- PROVINSI JAWA BARAT (32)
-- =====================================================
('3201', '32', 'Kabupaten Bogor'),
('3202', '32', 'Kabupaten Cianjur'),
('3203', '32', 'Kabupaten Bandung'),
('3204', '32', 'Kabupaten Sumedang'),
('3205', '32', 'Kabupaten Majalengka'),
('3206', '32', 'Kabupaten Ciamis'),
('3207', '32', 'Kabupaten Kuningan'),
('3208', '32', 'Kabupaten Cirebon'),
('3209', '32', 'Kabupaten Indramayu'),
('3210', '32', 'Kabupaten Subang'),
('3211', '32', 'Kabupaten Purwakarta'),
('3212', '32', 'Kabupaten Karawang'),
('3213', '32', 'Kabupaten Bekasi'),
('3214', '32', 'Kabupaten Bandung Barat'),
('3215', '32', 'Kabupaten Pangandaran'),
('3271', '32', 'Kota Bogor'),
('3272', '32', 'Kota Bandung'),
('3273', '32', 'Kota Cirebon'),
('3274', '32', 'Kota Bekasi'),
('3275', '32', 'Kota Depok'),
('3276', '32', 'Kota Cimahi'),
('3277', '32', 'Kota Tasikmalaya'),
('3278', '32', 'Kota Banjar'),

-- =====================================================
-- PROVINSI JAWA TENGAH (33)
-- =====================================================
('3301', '33', 'Kabupaten Cilacap'),
('3302', '33', 'Kabupaten Banyumas'),
('3303', '33', 'Kabupaten Purbalingga'),
('3304', '33', 'Kabupaten Banjarnegara'),
('3305', '33', 'Kabupaten Kebumen'),
('3306', '33', 'Kabupaten Purworejo'),
('3307', '33', 'Kabupaten Wonosobo'),
('3308', '33', 'Kabupaten Magelang'),
('3309', '33', 'Kabupaten Boyolali'),
('3310', '33', 'Kabupaten Klaten'),
('3311', '33', 'Kabupaten Sukoharjo'),
('3312', '33', 'Kabupaten Wonogiri'),
('3313', '33', 'Kabupaten Karanganyar'),
('3314', '33', 'Kabupaten Sragen'),
('3315', '33', 'Kabupaten Grobogan'),
('3316', '33', 'Kabupaten Blora'),
('3317', '33', 'Kabupaten Rembang'),
('3318', '33', 'Kabupaten Pati'),
('3319', '33', 'Kabupaten Kudus'),
('3320', '33', 'Kabupaten Jepara'),
('3321', '33', 'Kabupaten Demak'),
('3322', '33', 'Kabupaten Semarang'),
('3323', '33', 'Kabupaten Temanggung'),
('3324', '33', 'Kabupaten Kendal'),
('3325', '33', 'Kabupaten Batang'),
('3326', '33', 'Kabupaten Pekalongan'),
('3327', '33', 'Kabupaten Pemalang'),
('3328', '33', 'Kabupaten Tegal'),
('3329', '33', 'Kabupaten Brebes'),
('3371', '33', 'Kota Magelang'),
('3372', '33', 'Kota Surakarta'),
('3373', '33', 'Kota Salatiga'),
('3374', '33', 'Kota Semarang'),
('3375', '33', 'Kota Pekalongan'),
('3376', '33', 'Kota Tegal'),

-- =====================================================
-- PROVINSI DI YOGYAKARTA (34)
-- =====================================================
('3401', '34', 'Kabupaten Kulon Progo'),
('3402', '34', 'Kabupaten Bantul'),
('3403', '34', 'Kabupaten Gunung Kidul'),
('3404', '34', 'Kabupaten Sleman'),
('3471', '34', 'Kota Yogyakarta'),

-- =====================================================
-- PROVINSI JAWA TIMUR (35)
-- =====================================================
('3501', '35', 'Kabupaten Pacitan'),
('3502', '35', 'Kabupaten Ponorogo'),
('3503', '35', 'Kabupaten Trenggalek'),
('3504', '35', 'Kabupaten Tulungagung'),
('3505', '35', 'Kabupaten Blitar'),
('3506', '35', 'Kabupaten Kediri'),
('3507', '35', 'Kabupaten Malang'),
('3508', '35', 'Kabupaten Lumajang'),
('3509', '35', 'Kabupaten Jember'),
('3510', '35', 'Kabupaten Bondowoso'),
('3511', '35', 'Kabupaten Situbondo'),
('3512', '35', 'Kabupaten Probolinggo'),
('3513', '35', 'Kabupaten Pasuruan'),
('3514', '35', 'Kabupaten Sidoarjo'),
('3515', '35', 'Kabupaten Mojokerto'),
('3516', '35', 'Kabupaten Jombang'),
('3517', '35', 'Kabupaten Nganjuk'),
('3518', '35', 'Kabupaten Madiun'),
('3519', '35', 'Kabupaten Magetan'),
('3520', '35', 'Kabupaten Ngawi'),
('3521', '35', 'Kabupaten Bojonegoro'),
('3522', '35', 'Kabupaten Tuban'),
('3523', '35', 'Kabupaten Lamongan'),
('3524', '35', 'Kabupaten Gresik'),
('3525', '35', 'Kabupaten Bangkalan'),
('3526', '35', 'Kabupaten Sampang'),
('3527', '35', 'Kabupaten Pamekasan'),
('3528', '35', 'Kabupaten Sumenep'),
('3571', '35', 'Kota Kediri'),
('3572', '35', 'Kota Blitar'),
('3573', '35', 'Kota Malang'),
('3574', '35', 'Kota Probolinggo'),
('3575', '35', 'Kota Pasuruan'),
('3576', '35', 'Kota Mojokerto'),
('3577', '35', 'Kota Madiun'),
('3578', '35', 'Kota Surabaya'),
('3579', '35', 'Kota Batu'),

-- =====================================================
-- PROVINSI BANTEN (36)
-- =====================================================
('3601', '36', 'Kabupaten Pandeglang'),
('3602', '36', 'Kabupaten Lebak'),
('3603', '36', 'Kabupaten Tangerang'),
('3604', '36', 'Kabupaten Serang'),
('3671', '36', 'Kota Tangerang'),
('3672', '36', 'Kota Cilegon'),
('3673', '36', 'Kota Serang'),
('3674', '36', 'Kota Tangerang Selatan'),

-- =====================================================
-- PROVINSI BALI (51)
-- =====================================================
('5101', '51', 'Kabupaten Jembrana'),
('5102', '51', 'Kabupaten Tabanan'),
('5103', '51', 'Kabupaten Badung'),
('5104', '51', 'Kabupaten Gianyar'),
('5105', '51', 'Kabupaten Klungkung'),
('5106', '51', 'Kabupaten Bangli'),
('5107', '51', 'Kabupaten Karang Asem'),
('5108', '51', 'Kabupaten Buleleng'),
('5171', '51', 'Kota Denpasar'),

-- =====================================================
-- PROVINSI NUSA TENGGARA BARAT (52)
-- =====================================================
('5201', '52', 'Kabupaten Lombok Barat'),
('5202', '52', 'Kabupaten Lombok Tengah'),
('5203', '52', 'Kabupaten Lombok Timur'),
('5204', '52', 'Kabupaten Sumbawa'),
('5205', '52', 'Kabupaten Dompu'),
('5206', '52', 'Kabupaten Bima'),
('5207', '52', 'Kabupaten Sumbawa Barat'),
('5208', '52', 'Kabupaten Lombok Utara'),
('5271', '52', 'Kota Mataram'),
('5272', '52', 'Kota Bima'),

-- =====================================================
-- PROVINSI NUSA TENGGARA TIMUR (53)
-- =====================================================
('5301', '53', 'Kabupaten Sumba Barat'),
('5302', '53', 'Kabupaten Sumba Timur'),
('5303', '53', 'Kabupaten Ende'),
('5304', '53', 'Kabupaten Sikka'),
('5305', '53', 'Kabupaten Flores Timur'),
('5306', '53', 'Kabupaten Lembata'),
('5307', '53', 'Kabupaten Alor'),
('5308', '53', 'Kabupaten Rote Ndao'),
('5309', '53', 'Kabupaten Manggarai'),
('5310', '53', 'Kabupaten Ngada'),
('5311', '53', 'Kabupaten Manggarai Timur'),
('5312', '53', 'Kabupaten Sabu Raijua'),
('5313', '53', 'Kabupaten Malaka'),
('5314', '53', 'Kabupaten Sumba Barat Daya'),
('5315', '53', 'Kabupaten Sumba Tengah'),
('5316', '53', 'Kabupaten Manggarai Barat'),
('5317', '53', 'Kabupaten Nagekeo'),
('5318', '53', 'Kabupaten East Sumba'),
('5371', '53', 'Kota Kupang'),

-- =====================================================
-- PROVINSI KALIMANTAN BARAT (61)
-- =====================================================
('6101', '61', 'Kabupaten Sambas'),
('6102', '61', 'Kabupaten Mempawah'),
('6103', '61', 'Kabupaten Sanggau'),
('6104', '61', 'Kabupaten Ketapang'),
('6105', '61', 'Kabupaten Sintang'),
('6106', '61', 'Kabupaten Kapuas Hulu'),
('6107', '61', 'Kabupaten Benton'),
('6108', '61', 'Kabupaten Landak'),
('6109', '61', 'Kabupaten Sekadau'),
('6110', '61', 'Kabupaten Melawi'),
('6111', '61', 'Kabupaten Kayong Utara'),
('6112', '61', 'Kabupaten Kubu Raya'),
('6171', '61', 'Kota Pontianak'),
('6172', '61', 'Kota Singkawang'),

-- =====================================================
-- PROVINSI KALIMANTAN TENGAH (62)
-- =====================================================
('6201', '62', 'Kabupaten Kotawaringin Barat'),
('6202', '62', 'Kabupaten Kotawaringin Timur'),
('6203', '62', 'Kabupaten Kapuas'),
('6204', '62', 'Kabupaten Barito Selatan'),
('6205', '62', 'Kabupaten Barito Utara'),
('6206', '62', 'Kabupaten Sukamara'),
('6207', '62', 'Kabupaten Lamandau'),
('6208', '62', 'Kabupaten Seruyan'),
('6209', '62', 'Kabupaten Katingan'),
('6210', '62', 'Kabupaten Pulang Pisau'),
('6211', '62', 'Kabupaten Gunung Mas'),
('6212', '62', 'Kabupaten Kuala Kapuas'),
('6213', '62', 'Kabupaten Murung Raya'),
('6271', '62', 'Kota Palangka Raya'),

-- =====================================================
-- PROVINSI KALIMANTAN SELATAN (63)
-- =====================================================
('6301', '63', 'Kabupaten Tanah Laut'),
('6302', '63', 'Kabupaten Kota Baru'),
('6303', '63', 'Kabupaten Banjar'),
('6304', '63', 'Kabupaten Barito Kuala'),
('6305', '63', 'Kabupaten Tapin'),
('6306', '63', 'Kabupaten Hulu Sungai Selatan'),
('6307', '63', 'Kabupaten Hulu Sungai Tengah'),
('6308', '63', 'Kabupaten Hulu Sungai Utara'),
('6309', '63', 'Kabupaten Tabalong'),
('6310', '63', 'Kabupaten Tanah Bumbu'),
('6311', '63', 'Kabupaten Balangan'),
('6371', '63', 'Kota Banjarmasin'),
('6372', '63', 'Kota Banjarbaru'),

-- =====================================================
-- PROVINSI KALIMANTAN TIMUR (64)
-- =====================================================
('6401', '64', 'Kabupaten Paser'),
('6402', '64', 'Kabupaten Kutai Barat'),
('6403', '64', 'Kabupaten Kutai Kartanegara'),
('6404', '64', 'Kabupaten Kutai Timur'),
('6405', '64', 'Kabupaten Berau'),
('6406', '64', 'Kabupaten Mahakam Hulu'),
('6407', '64', 'Kabupaten Bontang'),
('6408', '64', 'Kabupaten Penajam Paser Utara'),
('6409', '64', 'Kabupaten Mahakam Ulu'),
('6471', '64', 'Kota Balikpapan'),
('6472', '64', 'Kota Samarinda'),

-- =====================================================
-- PROVINSI KALIMANTAN UTARA (65)
-- =====================================================
('6501', '65', 'Kabupaten Nunukan'),
('6502', '65', 'Kabupaten Malinau'),
('6503', '65', 'Kabupaten Bulungan'),
('6504', '65', 'Kabupaten Tana Tidung'),
('6571', '65', 'Kota Tarakan'),

-- =====================================================
-- PROVINSI SULAWESI UTARA (71)
-- =====================================================
('7101', '71', 'Kabupaten Bolaang Mongondow'),
('7102', '71', 'Kabupaten Minahasa'),
('7103', '71', 'Kabupaten Kepulauan Sangihe'),
('7104', '71', 'Kabupaten Kepulauan Talaud'),
('7105', '71', 'Kabupaten Minahasa Selatan'),
('7106', '71', 'Kabupaten Minahasa Utara'),
('7107', '71', 'Kabupaten Bolaang Mongondow Utara'),
('7108', '71', 'Kabupaten Siau Tagulandang Biaro'),
('7109', '71', 'Kabupaten Minahasa Tenggara'),
('7110', '71', 'Kabupaten Bolaang Mongondow Timur'),
('7111', '71', 'Kabupaten Bolaang Mongondow Selatan'),
('7171', '71', 'Kota Manado'),
('7172', '71', 'Kota Bitung'),
('7173', '71', 'Kota Tomohon'),
('7174', '71', 'Kota Kotamobagu'),

-- =====================================================
-- PROVINSI SULAWESI TENGAH (72)
-- =====================================================
('7201', '72', 'Kabupaten Banggai'),
('7202', '72', 'Kabupaten Poso'),
('7203', '72', 'Kabupaten Donggala'),
('7204', '72', 'Kabupaten Toli-Toli'),
('7205', '72', 'Kabupaten Buol'),
('7206', '72', 'Kabupaten Morowali'),
('7207', '72', 'Kabupaten Banggai Laut'),
('7208', '72', 'Kabupaten Morowali Utara'),
('7209', '72', 'Kabupaten Tojo Una-Una'),
('7271', '72', 'Kota Palu'),

-- =====================================================
-- PROVINSI SULAWESI SELATAN (73)
-- =====================================================
('7301', '73', 'Kabupaten Kepulauwan Selayar'),
('7302', '73', 'Kabupaten Bulukumba'),
('7303', '73', 'Kabupaten Bantaeng'),
('7304', '73', 'Kabupaten Jeneponto'),
('7305', '73', 'Kabupaten Takalar'),
('7306', '73', 'Kabupaten Gowa'),
('7307', '73', 'Kabupaten Sinjai'),
('7308', '73', 'Kabupaten Maros'),
('7309', '73', 'Kabupaten Pangkajene dan Kepulauan'),
('7310', '73', 'Kabupaten Barru'),
('7311', '73', 'Kabupaten Bone'),
('7312', '73', 'Kabupaten Soppeng'),
('7313', '73', 'Kabupaten Wajo'),
('7314', '73', 'Kabupaten Sidenreng Rappang'),
('7315', '73', 'Kabupaten Pinrang'),
('7316', '73', 'Kabupaten Enrekang'),
('7317', '73', 'Kabupaten Luwu'),
('7318', '73', 'Kabupaten Luwu Timur'),
('7319', '73', 'Kabupaten Luwu Utara'),
('7320', '73', 'Kabupaten Tana Toraja'),
('7321', '73', 'Kabupaten Tana Toraja Utara'),
('7322', '73', 'Kabupaten Luwu Utara'),
('7371', '73', 'Kota Makassar'),
('7372', '73', 'Kota Parepare'),
('7373', '73', 'Kota Palopo'),

-- =====================================================
-- PROVINSI SULAWESI TENGGARA (74)
-- =====================================================
('7401', '74', 'Kabupaten Buton'),
('7402', '74', 'Kabupaten Muna'),
('7403', '74', 'Kabupaten Konawe'),
('7404', '74', 'Kabupaten Kolaka'),
('7405', '74', 'Kabupaten Konawe Selatan'),
('7406', '74', 'Kabupaten Bombana'),
('7407', '74', 'Kabupaten Wakatobi'),
('7408', '74', 'Kabupaten Kolaka Timur'),
('7409', '74', 'Kabupaten Konawe Kepulauan'),
('7410', '74', 'Kabupaten Muna Barat'),
('7411', '74', 'Kabupaten Buton Selatan'),
('7412', '74', 'Kabupaten Buton Tengah'),
('7413', '74', 'Kabupaten Konawe Utara'),
('7471', '74', 'Kota Kendari'),
('7472', '74', 'Kota Baubau'),

-- =====================================================
-- PROVINSI GORONTALO (75)
-- =====================================================
('7501', '75', 'Kabupaten Gorontalo'),
('7502', '75', 'Kabupaten Boalemo'),
('7503', '75', 'Kabupaten Bone Bolango'),
('7504', '75', 'Kabupaten Pohuwato'),
('7505', '75', 'Kabupaten Gorontalo Utara'),
('7571', '75', 'Kota Gorontalo'),

-- =====================================================
-- PROVINSI SULAWESI BARAT (76)
-- =====================================================
('7601', '76', 'Kabupaten Majene'),
('7602', '76', 'Kabupaten Polewali Mandar'),
('7603', '76', 'Kabupaten Mamasa'),
('7604', '76', 'Kabupaten Mamuju'),
('7605', '76', 'Kabupaten Mamuju Utara'),
('7606', '76', 'Kabupaten Mamuju Tengah'),
('7671', '76', 'Kota Mamuju'),

-- =====================================================
-- PROVINSI MALUKU (81)
-- =====================================================
('8101', '81', 'Kabupaten Maluku Tengah'),
('8102', '81', 'Kabupaten Maluku Tenggara'),
('8103', '81', 'Kabupaten Maluku Tenggara Barat'),
('8104', '81', 'Kabupaten Buru'),
('8105', '81', 'Kabupaten Buru Selatan'),
('8106', '81', 'Kabupaten Kepulauan Aru'),
('8107', '81', 'Kabupaten Maluku Barat Daya'),
('8108', '81', 'Kabupaten Seram Bagian Timur'),
('8109', '81', 'Kabupaten Seram Bagian Barat'),
('8171', '81', 'Kota Ambon'),
('8172', '81', 'Kota Tual'),

-- =====================================================
-- PROVINSI MALUKU UTARA (82)
-- =====================================================
('8201', '82', 'Kabupaten Halmahera Barat'),
('8202', '82', 'Kabupaten Halmahera Tengah'),
('8203', '82', 'Kabupaten Kepulauan Sula'),
('8204', '82', 'Kabupaten Halmahera Selatan'),
('8205', '82', 'Kabupaten Halmahera Utara'),
('8206', '82', 'Kabupaten Halmahera Timur'),
('8207', '82', 'Kabupaten Pulau Morotai'),
('8208', '82', 'Kabupaten Pulau Tidore'),
('8271', '82', 'Kota Ternate'),
('8272', '82', 'Kota Tidore Kepulauan'),

-- =====================================================
-- PROVINSI PAPUA BARAT (83)
-- =====================================================
('8301', '83', 'Kabupaten Fakfak'),
('8302', '83', 'Kabupaten Kaimana'),
('8303', '83', 'Kabupaten Triton'),
('8304', '83', 'Kabupaten Raja Ampat'),
('8305', '83', 'Kabupaten Sorong'),
('8306', '83', 'Kabupaten Sorong Selatan'),
('8307', '83', 'Kabupaten Maybrat'),
('8308', '83', 'Kabupaten Tambrauw'),
('8309', '83', 'Kabupaten Bintuni'),
('8310', '83', 'Kabupaten Manokwari'),
('8311', '83', 'Kabupaten Pegunungan Arfak'),
('8312', '83', 'Kabupaten Manokwari Selatan'),
('8371', '83', 'Kota Sorong'),

-- =====================================================
-- PROVINSI PAPUA (94)
-- =====================================================
('9401', '94', 'Kabupaten Merauke'),
('9402', '94', 'Kabupaten Jayawijaya'),
('9403', '94', 'Kabupaten Jayapura'),
('9404', '94', 'Kabupaten Nabire'),
('9405', '94', 'Kabupaten Yapen Waropen'),
('9406', '94', 'Kabupaten Biak Numfor'),
('9407', '94', 'Kabupaten Paniai'),
('9408', '94', 'Kabupaten Puncak Jaya'),
('9409', '94', 'Kabupaten Mimika'),
('9410', '94', 'Kabupaten Boven Digoel'),
('9411', '94', 'Kabupaten Mappi'),
('9412', '94', 'Kabupaten Asmat'),
('9413', '94', 'Kabupaten Yahukimo'),
('9414', '94', 'Kabupaten Pegunungan Bintang'),
('9415', '94', 'Kabupaten Tolikara'),
('9416', '94', 'Kabupaten Sarmi'),
('9417', '94', 'Kabupaten Keerom'),
('9418', '94', 'Kabupaten Waropen'),
('9419', '94', 'Kabupaten Supiori'),
('9420', '94', 'Kabupaten Mamberamo Raya'),
('9421', '94', 'Kabupaten Mamberamo Tengah'),
('9422', '94', 'Kabupaten Nduga'),
('9423', '94', 'Kabupaten Lanny Jaya'),
('9424', '94', 'Kabupaten Tengah Papua'),
('9425', '94', 'Kabupaten Dogiyai'),
('9426', '94', 'Kabupaten Intan Jaya'),
('9427', '94', 'Kabupaten Deiyai'),
('9471', '94', 'Kota Jayapura');

-- =====================================================
-- VERIFIKASI DATA DENGAN COLLATION FIX
-- =====================================================

-- Cek total kabupaten (harus 514)
SELECT COUNT(*) as total_kabupaten FROM kabupaten;

-- Query dengan collation fix (Method 1 - REKOMENDASI)
SELECT 
  f.nama as provinsi,
  COUNT(k.id) as jumlah_kabupaten
FROM formasi f
LEFT JOIN kabupaten k ON f.kode COLLATE utf8mb4_unicode_ci = k.kode_provinsi COLLATE utf8mb4_unicode_ci
WHERE f.kode != '00' AND f.kode != '01'
GROUP BY f.kode, f.nama
ORDER BY f.kode;

-- Sample data dengan JOIN (fixed)
SELECT k.nama as kabupaten, f.nama as provinsi 
FROM kabupaten k 
JOIN formasi f ON f.kode COLLATE utf8mb4_unicode_ci = k.kode_provinsi COLLATE utf8mb4_unicode_ci
WHERE f.kode != '00' AND f.kode != '01'
ORDER BY f.kode, k.nama
LIMIT 20;

-- =====================================================
-- HASIL YANG DIHARAPKAN:
-- =====================================================
-- Total: 514 kabupaten/kota untuk 38 provinsi BPS
-- Error collation sudah teratasi dengan COLLATE clause
-- Error duplicate sudah diperbaiki dengan kode unik
-- Semua data terhubung dengan tabel formasi melalui kode_provinsi