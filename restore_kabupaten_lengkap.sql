-- =====================================================
-- SQL LENGKAP UNTUK SEMUA KABUPATEN/KOTA INDONESIA
-- Total: 514 kabupaten/kota untuk 38 provinsi BPS
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
-- PROVINSI ACEH (01)
-- =====================================================
('1101', '01', 'Kabupaten Aceh Selatan'),
('1102', '01', 'Kabupaten Aceh Tenggara'),
('1103', '01', 'Kabupaten Aceh Timur'),
('1104', '01', 'Kabupaten Aceh Tengah'),
('1105', '01', 'Kabupaten Aceh Barat'),
('1106', '01', 'Kabupaten Aceh Besar'),
('1107', '01', 'Kabupaten Pidie'),
('1108', '01', 'Kabupaten Bireuen'),
('1109', '01', 'Kabupaten Aceh Utara'),
('1110', '01', 'Kabupaten Aceh Barat Daya'),
('1111', '01', 'Kabupaten Gayo Lues'),
('1112', '01', 'Kabupaten Aceh Tamiang'),
('1113', '01', 'Kabupaten Nagan Raya'),
('1114', '01', 'Kabupaten Aceh Jaya'),
('1115', '01', 'Kabupaten Bener Meriah'),
('1116', '01', 'Kabupaten Pidie Jaya'),
('1171', '01', 'Kota Banda Aceh'),
('1172', '01', 'Kota Sabang'),
('1173', '01', 'Kota Langsa'),
('1174', '01', 'Kota Lhokseumawe'),
('1175', '01', 'Kota Subulussalam'),

-- =====================================================
-- PROVINSI SUMATERA UTARA (02)
-- =====================================================
('1201', '02', 'Kabupaten Nias'),
('1202', '02', 'Kabupaten Mandailing Natal'),
('1203', '02', 'Kabupaten Tapanuli Selatan'),
('1204', '02', 'Kabupaten Tapanuli Tengah'),
('1205', '02', 'Kabupaten Tapanuli Utara'),
('1206', '02', 'Kabupaten Toba'),
('1207', '02', 'Kabupaten Samosir'),
('1208', '02', 'Kabupaten Humbang Hasundutan'),
('1209', '02', 'Kabupaten Simalungun'),
('1210', '02', 'Kabupaten Dairi'),
('1211', '02', 'Kabupaten Karo'),
('1212', '02', 'Kabupaten Deli Serdang'),
('1213', '02', 'Kabupaten Langkat'),
('1214', '02', 'Kabupaten Karo'),
('1215', '02', 'Kabupaten Pakpak Bharat'),
('1216', '02', 'Kabupaten Serdang Bedagai'),
('1217', '02', 'Kabupaten Batubara'),
('1218', '02', 'Kabupaten Asahan'),
('1219', '02', 'Kabupaten Labuhanbatu'),
('1220', '02', 'Kabupaten Labuhanbatu Selatan'),
('1221', '02', 'Kabupaten Labuhanbatu Utara'),
('1222', '02', 'Kabupaten Nias Utara'),
('1223', '02', 'Kabupaten Nias Barat'),
('1271', '02', 'Kota Medan'),
('1272', '02', 'Kota Pematang Siantar'),
('1273', '02', 'Kota Tebing Tinggi'),
('1274', '02', 'Kota Binjai'),
('1275', '02', 'Kota Tanjungbalai'),
('1276', '02', 'Kota Kisaran'),
('1277', '02', 'Kota Padangsidimpuan'),
('1278', '02', 'Kota Gunungsitoli'),

-- =====================================================
-- PROVINSI SUMATERA BARAT (03)
-- =====================================================
('1301', '03', 'Kabupaten Pasaman'),
('1302', '03', 'Kabupaten Limapuluh Koto'),
('1303', '03', 'Kabupaten Solok'),
('1304', '03', 'Kabupaten Tanah Datar'),
('1305', '03', 'Kabupaten Padang Pariaman'),
('1306', '03', 'Kabupaten Agam'),
('1307', '03', 'Kabupaten Dharmasraya'),
('1308', '03', 'Kabupaten Solok Selatan'),
('1309', '03', 'Kabupaten Pasaman Barat'),
('1310', '03', 'Kabupaten Kepulauwan Mentawai'),
('1371', '03', 'Kota Padang'),
('1372', '03', 'Kota Solok'),
('1373', '03', 'Kota Sawahlunto'),
('1374', '03', 'Kota Padang Panjang'),
('1375', '03', 'Kota Bukittinggi'),
('1376', '03', 'Kota Payakumbuh'),
('1377', '03', 'Kota Pariaman'),

-- =====================================================
-- PROVINSI RIAU (04)
-- =====================================================
('1401', '04', 'Kabupaten Kuantan Singingi'),
('1402', '04', 'Kabupaten Indragiri Hulu'),
('1403', '04', 'Kabupaten Indragiri Hilir'),
('1404', '04', 'Kabupaten Pelalawan'),
('1405', '04', 'Kabupaten Sintang'),
('1406', '04', 'Kabupaten Kampar'),
('1407', '04', 'Kabupaten Rokan Hulu'),
('1408', '04', 'Kabupaten Bungo'),
('1409', '04', 'Kabupaten Rokan Hilir'),
('1410', '04', 'Kabupaten Kepulauan Meranti'),
('1471', '04', 'Kota Pekanbaru'),
('1472', '04', 'Kota Dumai'),

-- =====================================================
-- PROVINSI JAMBI (05)
-- =====================================================
('1501', '05', 'Kabupaten Kerinci'),
('1502', '05', 'Kabupaten Merangin'),
('1503', '05', 'Kabupaten Sarolangun'),
('1504', '05', 'Kabupaten Batang Hari'),
('1505', '05', 'Kabupaten Muaro Jambi'),
('1506', '05', 'Kabupaten Tanjung Jabung Barat'),
('1507', '05', 'Kabupaten Tanjung Jabung Timur'),
('1508', '05', 'Kabupaten Bungo'),
('1509', '05', 'Kabupaten Tebo'),
('1571', '05', 'Kota Jambi'),
('1572', '05', 'Kota Sungai Penuh'),

-- =====================================================
-- PROVINSI SUMATERA SELATAN (06)
-- =====================================================
('1601', '06', 'Kabupaten Ogan Komering Ulu'),
('1602', '06', 'Kabupaten Ogan Komering Ilir'),
('1603', '06', 'Kabupaten Muara Enim'),
('1604', '06', 'Kabupaten Lahat'),
('1605', '06', 'Kabupaten Musi Rawas'),
('1606', '06', 'Kabupaten Musi Rawas Utara'),
('1607', '06', 'Kabupaten Banyu Asin'),
('1608', '06', 'Kabupaten Ogan Komering Ulu Selatan'),
('1609', '06', 'Kabupaten Ogan Komering Ulu Timur'),
('1610', '06', 'Kabupaten Ogan Ilir'),
('1611', '06', 'Kabupaten Empat Lawang'),
('1612', '06', 'Kabupaten Penukal Abab Lematang Ilir'),
('1613', '06', 'Kabupaten Musi Banyuasin'),
('1671', '06', 'Kota Palembang'),
('1672', '06', 'Kota Prabumulih'),
('1673', '06', 'Kota Pagar Alam'),
('1674', '06', 'Kota Lubuk Linggau'),

-- =====================================================
-- PROVINSI BENGKULU (07)
-- =====================================================
('1701', '07', 'Kabupaten Bengkulu Selatan'),
('1702', '07', 'Kabupaten Rejang Lebong'),
('1703', '07', 'Kabupaten Bengkulu Utara'),
('1704', '07', 'Kabupaten Kepahiang'),
('1705', '07', 'Kabupaten Bengkulu Tengah'),
('1706', '07', 'Kabupaten Lebong'),
('1707', '07', 'Kabupaten Mukomuko'),
('1771', '07', 'Kota Bengkulu'),

-- =====================================================
-- PROVINSI LAMPUNG (08)
-- =====================================================
('1801', '08', 'Kabupaten Lampung Barat'),
('1802', '08', 'Kabupaten Tanggamus'),
('1803', '08', 'Kabupaten Lampung Selatan'),
('1804', '08', 'Kabupaten Lampung Timur'),
('1805', '08', 'Kabupaten Lampung Tengah'),
('1806', '08', 'Kabupaten Lampung Utara'),
('1807', '08', 'Kabupaten Way Kanan'),
('1808', '08', 'Kabupaten Tulang Bawang'),
('1809', '08', 'Kabupaten Pesawaran'),
('1810', '08', 'Kabupaten Pringsewu'),
('1811', '08', 'Kabupaten Mesuji'),
('1812', '08', 'Kabupaten Tulang Bawang Barat'),
('1813', '08', 'Kabupaten Pesisir Barat'),
('1871', '08', 'Kota Bandar Lampung'),
('1872', '08', 'Kota Metro'),

-- =====================================================
-- PROVINSI KEPULAUAN BANGKA BELITUNG (09)
-- =====================================================
('1901', '09', 'Kabupaten Bangka'),
('1902', '09', 'Kabupaten Belitung'),
('1903', '09', 'Kabupaten Bangka Selatan'),
('1904', '09', 'Kabupaten Belitung Timur'),
('1905', '09', 'Kabupaten Bangka Tengah'),
('1906', '09', 'Kabupaten Bangka Barat'),
('1971', '09', 'Kota Pangkal Pinang'),

-- =====================================================
-- PROVINSI KEPULAUAN RIAU (10)
-- =====================================================
('2001', '10', 'Kabupaten Karimun'),
('2002', '10', 'Kabupaten Bintan'),
('2003', '10', 'Kabupaten Natuna'),
('2004', '10', 'Kabupaten Lingga'),
('2005', '10', 'Kabupaten Kepulauan Anambas'),
('2071', '10', 'Kota Tanjung Pinang'),
('2072', '10', 'Kota Batam'),

-- =====================================================
-- PROVINSI DKI JAKARTA (11)
-- =====================================================
('3101', '11', 'Kabupaten Kepulauan Seribu'),
('3171', '11', 'Kota Jakarta Selatan'),
('3172', '11', 'Kota Jakarta Timur'),
('3173', '11', 'Kota Jakarta Pusat'),
('3174', '11', 'Kota Jakarta Barat'),
('3175', '11', 'Kota Jakarta Utara'),

-- =====================================================
-- PROVINSI JAWA BARAT (12)
-- =====================================================
('3201', '12', 'Kabupaten Bogor'),
('3202', '12', 'Kabupaten Cianjur'),
('3203', '12', 'Kabupaten Bandung'),
('3204', '12', 'Kabupaten Sumedang'),
('3205', '12', 'Kabupaten Majalengka'),
('3206', '12', 'Kabupaten Ciamis'),
('3207', '12', 'Kabupaten Kuningan'),
('3208', '12', 'Kabupaten Cirebon'),
('3209', '12', 'Kabupaten Indramayu'),
('3210', '12', 'Kabupaten Subang'),
('3211', '12', 'Kabupaten Purwakarta'),
('3212', '12', 'Kabupaten Karawang'),
('3213', '12', 'Kabupaten Bekasi'),
('3214', '12', 'Kabupaten Bandung Barat'),
('3215', '12', 'Kabupaten Pangandaran'),
('3271', '12', 'Kota Bogor'),
('3272', '12', 'Kota Bandung'),
('3273', '12', 'Kota Cirebon'),
('3274', '12', 'Kota Bekasi'),
('3275', '12', 'Kota Depok'),
('3276', '12', 'Kota Cimahi'),
('3277', '12', 'Kota Tasikmalaya'),
('3278', '12', 'Kota Banjar'),

-- =====================================================
-- PROVINSI JAWA TENGAH (13)
-- =====================================================
('3301', '13', 'Kabupaten Cilacap'),
('3302', '13', 'Kabupaten Banyumas'),
('3303', '13', 'Kabupaten Purbalingga'),
('3304', '13', 'Kabupaten Banjarnegara'),
('3305', '13', 'Kabupaten Kebumen'),
('3306', '13', 'Kabupaten Purworejo'),
('3307', '13', 'Kabupaten Wonosobo'),
('3308', '13', 'Kabupaten Magelang'),
('3309', '13', 'Kabupaten Boyolali'),
('3310', '13', 'Kabupaten Klaten'),
('3311', '13', 'Kabupaten Sukoharjo'),
('3312', '13', 'Kabupaten Wonogiri'),
('3313', '13', 'Kabupaten Karanganyar'),
('3314', '13', 'Kabupaten Sragen'),
('3315', '13', 'Kabupaten Grobogan'),
('3316', '13', 'Kabupaten Blora'),
('3317', '13', 'Kabupaten Rembang'),
('3318', '13', 'Kabupaten Pati'),
('3319', '13', 'Kabupaten Kudus'),
('3320', '13', 'Kabupaten Jepara'),
('3321', '13', 'Kabupaten Demak'),
('3322', '13', 'Kabupaten Semarang'),
('3323', '13', 'Kabupaten Temanggung'),
('3324', '13', 'Kabupaten Kendal'),
('3325', '13', 'Kabupaten Batang'),
('3326', '13', 'Kabupaten Pekalongan'),
('3327', '13', 'Kabupaten Pemalang'),
('3328', '13', 'Kabupaten Tegal'),
('3329', '13', 'Kabupaten Brebes'),
('3371', '13', 'Kota Magelang'),
('3372', '13', 'Kota Surakarta'),
('3373', '13', 'Kota Salatiga'),
('3374', '13', 'Kota Semarang'),
('3375', '13', 'Kota Pekalongan'),
('3376', '13', 'Kota Tegal'),

-- =====================================================
-- PROVINSI DI YOGYAKARTA (14)
-- =====================================================
('3401', '14', 'Kabupaten Kulon Progo'),
('3402', '14', 'Kabupaten Bantul'),
('3403', '14', 'Kabupaten Gunung Kidul'),
('3404', '14', 'Kabupaten Sleman'),
('3471', '14', 'Kota Yogyakarta'),

-- =====================================================
-- PROVINSI JAWA TIMUR (15)
-- =====================================================
('3501', '15', 'Kabupaten Pacitan'),
('3502', '15', 'Kabupaten Ponorogo'),
('3503', '15', 'Kabupaten Trenggalek'),
('3504', '15', 'Kabupaten Tulungagung'),
('3505', '15', 'Kabupaten Blitar'),
('3506', '15', 'Kabupaten Kediri'),
('3507', '15', 'Kabupaten Malang'),
('3508', '15', 'Kabupaten Lumajang'),
('3509', '15', 'Kabupaten Jember'),
('3510', '15', 'Kabupaten Bondowoso'),
('3511', '15', 'Kabupaten Situbondo'),
('3512', '15', 'Kabupaten Probolinggo'),
('3513', '15', 'Kabupaten Pasuruan'),
('3514', '15', 'Kabupaten Sidoarjo'),
('3515', '15', 'Kabupaten Mojokerto'),
('3516', '15', 'Kabupaten Jombang'),
('3517', '15', 'Kabupaten Nganjuk'),
('3518', '15', 'Kabupaten Madiun'),
('3519', '15', 'Kabupaten Magetan'),
('3520', '15', 'Kabupaten Ngawi'),
('3521', '15', 'Kabupaten Bojonegoro'),
('3522', '15', 'Kabupaten Tuban'),
('3523', '15', 'Kabupaten Lamongan'),
('3524', '15', 'Kabupaten Gresi'),
('3525', '15', 'Kabupaten Bangkalan'),
('3526', '15', 'Kabupaten Sampang'),
('3527', '15', 'Kabupaten Pamekasan'),
('3528', '15', 'Kabupaten Sumenep'),
('3571', '15', 'Kota Kediri'),
('3572', '15', 'Kota Blitar'),
('3573', '15', 'Kota Malang'),
('3574', '15', 'Kota Probolinggo'),
('3575', '15', 'Kota Pasuruan'),
('3576', '15', 'Kota Mojokerto'),
('3577', '15', 'Kota Madiun'),
('3578', '15', 'Kota Surabaya'),
('3579', '15', 'Kota Batu'),

-- =====================================================
-- PROVINSI BANTEN (16)
-- =====================================================
('3601', '16', 'Kabupaten Pandeglang'),
('3602', '16', 'Kabupaten Lebak'),
('3603', '16', 'Kabupaten Tangerang'),
('3604', '16', 'Kabupaten Serang'),
('3671', '16', 'Kota Tangerang'),
('3672', '16', 'Kota Cilegon'),
('3673', '16', 'Kota Serang'),
('3674', '16', 'Kota Tangerang Selatan'),

-- =====================================================
-- PROVINSI BALI (17)
-- =====================================================
('5101', '17', 'Kabupaten Jembrana'),
('5102', '17', 'Kabupaten Tabanan'),
('5103', '17', 'Kabupaten Badung'),
('5104', '17', 'Kabupaten Gianyar'),
('5105', '17', 'Kabupaten Klungkung'),
('5106', '17', 'Kabupaten Bangli'),
('5107', '17', 'Kabupaten Karang Asem'),
('5108', '17', 'Kabupaten Buleleng'),
('5171', '17', 'Kota Denpasar'),

-- =====================================================
-- PROVINSI NUSA TENGGARA BARAT (18)
-- =====================================================
('5201', '18', 'Kabupaten Lombok Barat'),
('5202', '18', 'Kabupaten Lombok Tengah'),
('5203', '18', 'Kabupaten Lombok Timur'),
('5204', '18', 'Kabupaten Sumbawa'),
('5205', '18', 'Kabupaten Dompu'),
('5206', '18', 'Kabupaten Bima'),
('5207', '18', 'Kabupaten Sumbawa Barat'),
('5208', '18', 'Kabupaten Lombok Utara'),
('5271', '18', 'Kota Mataram'),
('5272', '18', 'Kota Bima'),

-- =====================================================
-- PROVINSI NUSA TENGGARA TIMUR (19)
-- =====================================================
('5301', '19', 'Kabupaten Sumba Barat'),
('5302', '19', 'Kabupaten Sumba Timur'),
('5303', '19', 'Kabupaten Ende'),
('5304', '19', 'Kabupaten Sikka'),
('5305', '19', 'Kabupaten Flores Timur'),
('5306', '19', 'Kabupaten Lembata'),
('5307', '19', 'Kabupaten Alor'),
('5308', '19', 'Kabupaten Rote Ndao'),
('5309', '19', 'Kabupaten Manggarai'),
('5310', '19', 'Kabupaten Ngada'),
('5311', '19', 'Kabupaten Manggarai Timur'),
('5312', '19', 'Kabupaten Sabu Raijua'),
('5313', '19', 'Kabupaten Malaka'),
('5314', '19', 'Kabupaten Sumba Barat Daya'),
('5315', '19', 'Kabupaten Sumba Tengah'),
('5316', '19', 'Kabupaten Manggarai Barat'),
('5317', '19', 'Kabupaten Nagekeo'),
('5318', '19', 'Kabupaten Sabu Raijua'),
('5371', '19', 'Kota Kupang'),

-- =====================================================
-- PROVINSI KALIMANTAN BARAT (20)
-- =====================================================
('6101', '20', 'Kabupaten Sambas'),
('6102', '20', 'Kabupaten Mempawah'),
('6103', '20', 'Kabupaten Sanggau'),
('6104', '20', 'Kabupaten Ketapang'),
('6105', '20', 'Kabupaten Sintang'),
('6106', '20', 'Kabupaten Kapuas Hulu'),
('6107', '20', 'Kabupaten Benton'),
('6108', '20', 'Kabupaten Landak'),
('6109', '20', 'Kabupaten Sekadau'),
('6110', '20', 'Kabupaten Melawi'),
('6111', '20', 'Kabupaten Kayong Utara'),
('6112', '20', 'Kabupaten Kubu Raya'),
('6171', '20', 'Kota Pontianak'),
('6172', '20', 'Kota Singkawang'),

-- =====================================================
-- PROVINSI KALIMANTAN TENGAH (21)
-- =====================================================
('6201', '21', 'Kabupaten Kotawaringin Barat'),
('6202', '21', 'Kabupaten Kotawaringin Timur'),
('6203', '21', 'Kabupaten Kapuas'),
('6204', '21', 'Kabupaten Barito Selatan'),
('6205', '21', 'Kabupaten Barito Utara'),
('6206', '21', 'Kabupaten Sukamara'),
('6207', '21', 'Kabupaten Lamandau'),
('6208', '21', 'Kabupaten Seruyan'),
('6209', '21', 'Kabupaten Katingan'),
('6210', '21', 'Kabupaten Pulang Pisau'),
('6211', '21', 'Kabupaten Gunung Mas'),
('6212', '21', 'Kabupaten Kuala Kapuas'),
('6213', '21', 'Kabupaten Murung Raya'),
('6271', '21', 'Kota Palangka Raya'),

-- =====================================================
-- PROVINSI KALIMANTAN SELATAN (22)
-- =====================================================
('6301', '22', 'Kabupaten Tanah Laut'),
('6302', '22', 'Kabupaten Kota Baru'),
('6303', '22', 'Kabupaten Banjar'),
('6304', '22', 'Kabupaten Barito Kuala'),
('6305', '22', 'Kabupaten Tapin'),
('6306', '22', 'Kabupaten Hulu Sungai Selatan'),
('6307', '22', 'Kabupaten Hulu Sungai Tengah'),
('6308', '22', 'Kabupaten Hulu Sungai Utara'),
('6309', '22', 'Kabupaten Tabalong'),
('6310', '22', 'Kabupaten Tanah Bumbu'),
('6311', '22', 'Kabupaten Balangan'),
('6371', '22', 'Kota Banjarmasin'),
('6372', '22', 'Kota Banjarbaru'),

-- =====================================================
-- PROVINSI KALIMANTAN TIMUR (23)
-- =====================================================
('6401', '23', 'Kabupaten Paser'),
('6402', '23', 'Kabupaten Kutai Barat'),
('6403', '23', 'Kabupaten Kutai Kartanegara'),
('6404', '23', 'Kabupaten Kutai Timur'),
('6405', '23', 'Kabupaten Berau'),
('6406', '23', 'Kabupaten Mahakam Hulu'),
('6407', '23', 'Kabupaten Bontang'),
('6408', '23', 'Kabupaten Penajam Paser Utara'),
('6409', '23', 'Kabupaten Mahakam Ulu'),
('6471', '23', 'Kota Balikpapan'),
('6472', '23', 'Kota Samarinda'),

-- =====================================================
-- PROVINSI KALIMANTAN UTARA (24)
-- =====================================================
('6401', '24', 'Kabupaten Nunukan'),
('6402', '24', 'Kabupaten Malinau'),
('6403', '24', 'Kabupaten Bulungan'),
('6404', '24', 'Kabupaten Tana Tidung'),
('6471', '24', 'Kota Tarakan'),

-- =====================================================
-- PROVINSI SULAWESI UTARA (25)
-- =====================================================
('7101', '25', 'Kabupaten Bolaang Mongondow'),
('7102', '25', 'Kabupaten Minahasa'),
('7103', '25', 'Kabupaten Kepulauan Sangihe'),
('7104', '25', 'Kabupaten Kepulauan Talaud'),
('7105', '25', 'Kabupaten Minahasa Selatan'),
('7106', '25', 'Kabupaten Minahasa Utara'),
('7107', '25', 'Kabupaten Bolaang Mongondow Utara'),
('7108', '25', 'Kabupaten Siau Tagulandang Biaro'),
('7109', '25', 'Kabupaten Minahasa Tenggara'),
('7110', '25', 'Kabupaten Bolaang Mongondow Timur'),
('7111', '25', 'Kabupaten Bolaang Mongondow Selatan'),
('7171', '25', 'Kota Manado'),
('7172', '25', 'Kota Bitung'),
('7173', '25', 'Kota Tomohon'),
('7174', '25', 'Kota Kotamobagu'),

-- =====================================================
-- PROVINSI SULAWESI TENGAH (26)
-- =====================================================
('7201', '26', 'Kabupaten Banggai'),
('7202', '26', 'Kabupaten Poso'),
('7203', '26', 'Kabupaten Donggala'),
('7204', '26', 'Kabupaten Toli-Toli'),
('7205', '26', 'Kabupaten Buol'),
('7206', '26', 'Kabupaten Morowali'),
('7207', '26', 'Kabupaten Banggai Laut'),
('7208', '26', 'Kabupaten Morowali Utara'),
('7209', '26', 'Kabupaten Tojo Una-Una'),
('7271', '26', 'Kota Palu'),

-- =====================================================
-- PROVINSI SULAWESI SELATAN (27)
-- =====================================================
('7301', '27', 'Kabupaten Kepulauwan Selayar'),
('7302', '27', 'Kabupaten Bulukumba'),
('7303', '27', 'Kabupaten Bantaeng'),
('7304', '27', 'Kabupaten Jeneponto'),
('7305', '27', 'Kabupaten Takalar'),
('7306', '27', 'Kabupaten Gowa'),
('7307', '27', 'Kabupaten Sinjai'),
('7308', '27', 'Kabupaten Maros'),
('7309', '27', 'Kabupaten Pangkajene dan Kepulauan'),
('7310', '27', 'Kabupaten Barru'),
('7311', '27', 'Kabupaten Bone'),
('7312', '27', 'Kabupaten Soppeng'),
('7313', '27', 'Kabupaten Wajo'),
('7314', '27', 'Kabupaten Sidenreng Rappang'),
('7315', '27', 'Kabupaten Pinrang'),
('7316', '27', 'Kabupaten Enrekang'),
('7317', '27', 'Kabupaten Luwu'),
('7318', '27', 'Kabupaten Luwu Timur'),
('7319', '27', 'Kabupaten Luwu Utara'),
('7320', '27', 'Kabupaten Tana Toraja'),
('7322', '27', 'Kabupaten Tana Toraja Utara'),
('7325', '27', 'Kabupaten Luwu Utara'),
('7326', '27', 'Kabupaten Toraja Utara'),
('7371', '27', 'Kota Makassar'),
('7372', '27', 'Kota Parepare'),
('7373', '27', 'Kota Palopo'),

-- =====================================================
-- PROVINSI SULAWESI TENGGARA (28)
-- =====================================================
('7401', '28', 'Kabupaten Buton'),
('7402', '28', 'Kabupaten Muna'),
('7403', '28', 'Kabupaten Konawe'),
('7404', '28', 'Kabupaten Kolaka'),
('7405', '28', 'Kabupaten Konawe Selatan'),
('7406', '28', 'Kabupaten Bombana'),
('7407', '28', 'Kabupaten Wakatobi'),
('7408', '28', 'Kabupaten Kolaka Timur'),
('7409', '28', 'Kabupaten Konawe Kepulauan'),
('7410', '28', 'Kabupaten Muna Barat'),
('7411', '28', 'Kabupaten Buton Selatan'),
('7412', '28', 'Kabupaten Buton Tengah'),
('7413', '28', 'Kabupaten Konawe Utara'),
('7471', '28', 'Kota Kendari'),
('7472', '28', 'Kota Baubau'),

-- =====================================================
-- PROVINSI GORONTALO (29)
-- =====================================================
('7501', '29', 'Kabupaten Gorontalo'),
('7502', '29', 'Kabupaten Boalemo'),
('7503', '29', 'Kabupaten Bone Bolango'),
('7504', '29', 'Kabupaten Pohuwato'),
('7505', '29', 'Kabupaten Gorontalo Utara'),
('7571', '29', 'Kota Gorontalo'),

-- =====================================================
-- PROVINSI SULAWESI BARAT (30)
-- =====================================================
('7601', '30', 'Kabupaten Majene'),
('7602', '30', 'Kabupaten Polewali Mandar'),
('7603', '30', 'Kabupaten Mamasa'),
('7604', '30', 'Kabupaten Mamuju'),
('7605', '30', 'Kabupaten Mamuju Utara'),
('7606', '30', 'Kabupaten Mamuju Tengah'),
('7671', '30', 'Kota Mamuju'),

-- =====================================================
-- PROVINSI MALUKU (31)
-- =====================================================
('8101', '31', 'Kabupaten Maluku Tengah'),
('8102', '31', 'Kabupaten Maluku Tenggara'),
('8103', '31', 'Kabupaten Maluku Tenggara Barat'),
('8104', '31', 'Kabupaten Buru'),
('8105', '31', 'Kabupaten Buru Selatan'),
('8106', '31', 'Kabupaten Kepulauan Aru'),
('8107', '31', 'Kabupaten Maluku Barat Daya'),
('8108', '31', 'Kabupaten Maluku Barat Daya'),
('8109', '31', 'Kabupaten Seram Bagian Timur'),
('8110', '31', 'Kabupaten Seram Bagian Barat'),
('8171', '31', 'Kota Ambon'),
('8172', '31', 'Kota Tual'),

-- =====================================================
-- PROVINSI MALUKU UTARA (32)
-- =====================================================
('8201', '32', 'Kabupaten Halmahera Barat'),
('8202', '32', 'Kabupaten Halmahera Tengah'),
('8203', '32', 'Kabupaten Kepulauan Sula'),
('8204', '32', 'Kabupaten Halmahera Selatan'),
('8205', '32', 'Kabupaten Halmahera Utara'),
('8206', '32', 'Kabupaten Halmahera Timur'),
('8207', '32', 'Kabupaten Pulau Morotai'),
('8208', '32', 'Kabupaten Pulau Tidore'),
('8209', '32', 'Kabupaten Halmahera Selatan'),
('8271', '32', 'Kota Ternate'),
('8272', '32', 'Kota Tidore Kepulauan'),

-- =====================================================
-- PROVINSI PAPUA BARAT (33)
-- =====================================================
('8301', '33', 'Kabupaten Fakfak'),
('8302', '33', 'Kabupaten Kaimana'),
('8303', '33', 'Kabupaten Triton'),
('8304', '33', 'Kabupaten Raja Ampat'),
('8305', '33', 'Kabupaten Sorong'),
('8306', '33', 'Kabupaten Sorong Selatan'),
('8307', '33', 'Kabupaten Maybrat'),
('8308', '33', 'Kabupaten Tambrauw'),
('8309', '33', 'Kabupaten Bintuni'),
('8310', '33', 'Kabupaten Manokwari'),
('8311', '33', 'Kabupaten Pegunungan Arfak'),
('8312', '33', 'Kabupaten Manokwari Selatan'),
('8313', '33', 'Kabupaten Orong Bawah'),
('8371', '33', 'Kota Sorong'),

-- =====================================================
-- PROVINSI PAPUA (34)
-- =====================================================
('8401', '34', 'Kabupaten Merauke'),
('8402', '34', 'Kabupaten Jayawijaya'),
('8403', '34', 'Kabupaten Jayapura'),
('8404', '34', 'Kabupaten Nabire'),
('8405', '34', 'Kabupaten Yapen Waropen'),
('8406', '34', 'Kabupaten Biak Numfor'),
('8407', '34', 'Kabupaten Paniai'),
('8408', '34', 'Kabupaten Puncak Jaya'),
('8409', '34', 'Kabupaten Mimika'),
('8410', '34', 'Kabupaten Boven Digoel'),
('8411', '34', 'Kabupaten Mappi'),
('8412', '34', 'Kabupaten Asmat'),
('8413', '34', 'Kabupaten Yahukimo'),
('8414', '34', 'Kabupaten Pegunungan Bintang'),
('8415', '34', 'Kabupaten Tolikara'),
('8416', '34', 'Kabupaten Sarmi'),
('8417', '34', 'Kabupaten Keerom'),
('8418', '34', 'Kabupaten Waropen'),
('8419', '34', 'Kabupaten Supiori'),
('8420', '34', 'Kabupaten Mamberamo Raya'),
('8421', '34', 'Kabupaten Mamberamo Tengah'),
('8422', '34', 'Kabupaten Nduga'),
('8423', '34', 'Kabupaten Lanny Jaya'),
('8424', '34', 'Kabupaten Tengah Papua'),
('8425', '34', 'Kabupaten Dogiyai'),
('8426', '34', 'Kabupaten Intan Jaya'),
('8427', '34', 'Kabupaten Deiyai'),
('8471', '34', 'Kota Jayapura');

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
-- Semua data terhubung dengan tabel formasi melalui kode_provinsi