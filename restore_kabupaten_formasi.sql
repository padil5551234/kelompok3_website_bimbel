-- SQL Script untuk mengisi data kabupaten/kota berdasarkan formasi BPS
-- Data kabupaten/kota untuk setiap provinsi BPS yang ada

-- =====================================================
-- 1. MENGISI DATA KABUPATEN/KOTA
-- =====================================================

-- Hapus data existing (jika ada)
TRUNCATE TABLE kabupaten;

-- Insert data kabupaten/kota untuk setiap provinsi BPS
INSERT INTO kabupaten (kode, kode_provinsi, nama) VALUES

-- =====================================================
-- PROVINSI: ACEH (BPS 02)
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
-- PROVINSI: SUMATERA UTARA (BPS 03)
-- =====================================================
('1201', '03', 'Kabupaten Toba'),
('1202', '03', 'Kabupaten Tapanuli Utara'),
('1203', '03', 'Kabupaten Tapanuli Tengah'),
('1204', '03', 'Kabupaten Tapanuli Selatan'),
('1205', '03', 'Kabupaten Nias'),
('1206', '03', 'Kabupaten Langkat'),
('1207', '03', 'Kabupaten Karo'),
('1208', '03', 'Kabupaten Deli Serdang'),
('1209', '03', 'Kabupaten Simalungun'),
('1210', '03', 'Kabupaten Asahan'),
('1211', '03', 'Kabupaten Batu Bara'),
('1212', '03', 'Kabupaten Padang Lawas'),
('1213', '03', 'Kabupaten Padang Lawas Utara'),
('1214', '03', 'Kabupaten Labuhanbatu'),
('1215', '03', 'Kabupaten Labuhanbatu Selatan'),
('1216', '03', 'Kabupaten Labuhanbatu Utara'),
('1217', '03', 'Kabupaten Nias Utara'),
('1218', '03', 'Kabupaten Nias Barat'),
('1219', '03', 'Kabupaten Nias Selatan'),
('1220', '03', 'Kabupaten Mandailing Natal'),
('1271', '03', 'Kota Medan'),
('1272', '03', 'Kota Pematang Siantar'),
('1273', '03', 'Kota Tebing Tinggi'),
('1274', '03', 'Kota Binjai'),
('1275', '03', 'Kota Tanjungbalai'),
('1276', '03', 'Kota Sei Rampah'),
('1277', '03', 'Kota Padangsidimpuan'),
('1278', '03', 'Kota Gunungsitoli'),

-- =====================================================
-- PROVINSI: SUMATERA BARAT (BPS 04)
-- =====================================================
('1301', '04', 'Kabupaten Kepulauan Mentawai'),
('1302', '04', 'Kabupaten Pesisir Selatan'),
('1303', '04', 'Kabupaten Solok'),
('1304', '04', 'Kabupaten Sijunjung'),
('1305', '04', 'Kabupaten Tanah Datar'),
('1306', '04', 'Kabupaten Padang Pariaman'),
('1307', '04', 'Kabupaten Agam'),
('1308', '04', 'Kabupaten Lima Puluh Kota'),
('1309', '04', 'Kabupaten Pasaman'),
('1310', '04', 'Kabupaten Pasaman Barat'),
('1311', '04', 'Kabupaten Dharmasraya'),
('1312', '04', 'Kabupaten Solok Selatan'),
('1371', '04', 'Kota Padang'),
('1372', '04', 'Kota Solok'),
('1373', '04', 'Kota Sawahlunto'),
('1374', '04', 'Kota Padang Panjang'),
('1375', '04', 'Kota Bukittinggi'),
('1376', '04', 'Kota Payakumbuh'),
('1377', '04', 'Kota Pariaman'),

-- =====================================================
-- PROVINSI: RIAU (BPS 05)
-- =====================================================
('1401', '05', 'Kabupaten Kuantan Singingi'),
('1402', '05', 'Kabupaten Indragiri Hulu'),
('1403', '05', 'Kabupaten Indragiri Hilir'),
('1404', '05', 'Kabupaten Pelalawan'),
('1405', '05', 'Kabupaten SIAK'),
('1406', '05', 'Kabupaten Kampar'),
('1407', '05', 'Kabupaten Rokan Hulu'),
('1408', '05', 'Kabupaten Rokan Hilir'),
('1409', '05', 'Kabupaten Kepulauan Meranti'),
('1471', '05', 'Kota Pekanbaru'),
('1472', '05', 'Kota Dumai'),

-- =====================================================
-- PROVINSI: JAMBI (BPS 06)
-- =====================================================
('1501', '06', 'Kabupaten Kerinci'),
('1502', '06', 'Kabupaten Merangin'),
('1503', '06', 'Kabupaten Sarolangun'),
('1504', '06', 'Kabupaten Batang Hari'),
('1505', '06', 'Kabupaten Muaro Jambi'),
('1506', '06', 'Kabupaten Tanjung Jabung Timur'),
('1507', '06', 'Kabupaten Tanjung Jabung Barat'),
('1508', '06', 'Kabupaten Tebo'),
('1509', '06', 'Kabupaten Bungo'),
('1571', '06', 'Kota Jambi'),
('1572', '06', 'Kota Sungai Penuh'),

-- =====================================================
-- PROVINSI: SUMATERA SELATAN (BPS 07)
-- =====================================================
('1601', '07', 'Kabupaten Ogan Komering Ulu'),
('1602', '07', 'Kabupaten Ogan Komering Ilir'),
('1603', '07', 'Kabupaten Muara Enim'),
('1604', '07', 'Kabupaten Lahat'),
('1605', '07', 'Kabupaten Musi Rawas'),
('1606', '07', 'Kabupaten Musi Rawas Utara'),
('1607', '07', 'Kabupaten Banyu Asin'),
('1608', '07', 'Kabupaten Ogan Komering Ulu Selatan'),
('1609', '07', 'Kabupaten Ogan Komering Ulu Timur'),
('1610', '07', 'Kabupaten Ogan Ilir'),
('1611', '07', 'Kabupaten Empat Lawang'),
('1612', '07', 'Kabupaten Penukal Abab Lematang Ilir'),
('1613', '07', 'Kabupaten Muratara'),
('1671', '07', 'Kota Palembang'),
('1672', '07', 'Kota Prabumulih'),
('1673', '07', 'Kota Pagar Alam'),
('1674', '07', 'Kota Lubuk Linggau'),

-- =====================================================
-- PROVINSI: BENGKULU (BPS 08)
-- =====================================================
('1701', '08', 'Kabupaten Bengkulu Selatan'),
('1702', '08', 'Kabupaten Rejang Lebong'),
('1703', '08', 'Kabupaten Bengkulu Utara'),
('1704', '08', 'Kabupaten Kaur'),
('1705', '08', 'Kabupaten Seluma'),
('1706', '08', 'Kabupaten Muko Muko'),
('1707', '08', 'Kabupaten Lebong'),
('1708', '08', 'Kabupaten Kepahiang'),
('1771', '08', 'Kota Bengkulu'),

-- =====================================================
-- PROVINSI: LAMPUNG (BPS 09)
-- =====================================================
('1801', '08', 'Kabupaten Lampung Barat'),
('1802', '09', 'Kabupaten Tanggamus'),
('1803', '09', 'Kabupaten Lampung Selatan'),
('1804', '09', 'Kabupaten Lampung Timur'),
('1805', '09', 'Kabupaten Lampung Tengah'),
('1806', '09', 'Kabupaten Lampung Utara'),
('1807', '09', 'Kabupaten Way Kanan'),
('1808', '09', 'Kabupaten Tulang Bawang'),
('1809', '09', 'Kabupaten Pesawaran'),
('1810', '09', 'Kabupaten Pringsewu'),
('1811', '09', 'Kabupaten Mesuji'),
('1812', '09', 'Kabupaten Tulang Bawang Barat'),
('1813', '09', 'Kabupaten Pesisir Barat'),
('1871', '09', 'Kota Bandar Lampung'),
('1872', '09', 'Kota Metro'),

-- =====================================================
-- PROVINSI: BANGKA BELITUNG (BPS 10)
-- =====================================================
('1901', '10', 'Kabupaten Bangka'),
('1902', '10', 'Kabupaten Belitung'),
('1903', '10', 'Kabupaten Bangka Barat'),
('1904', '10', 'Kabupaten Bangka Tengah'),
('1905', '10', 'Kabupaten Bangka Selatan'),
('1906', '10', 'Kabupaten Belitung Timur'),
('1971', '10', 'Kota Pangkal Pinang'),

-- =====================================================
-- PROVINSI: KEPULAUAN RIAU (BPS 11)
-- =====================================================
('2101', '11', 'Kabupaten Karimun'),
('2102', '11', 'Kabupaten Bintan'),
('2103', '11', 'Kabupaten Natuna'),
('2104', '11', 'Kabupaten Lingga'),
('2105', '11', 'Kabupaten Kepulauan Anambas'),
('2171', '11', 'Kota Tanjung Pinang'),

-- =====================================================
-- PROVINSI: DKI JAKARTA (BPS 12)
-- =====================================================
('3101', '12', 'Kabupaten Kepulauan Seribu'),
('3171', '12', 'Kota Jakarta Selatan'),
('3172', '12', 'Kota Jakarta Timur'),
('3173', '12', 'Kota Jakarta Pusat'),
('3174', '12', 'Kota Jakarta Barat'),
('3175', '12', 'Kota Jakarta Utara'),

-- =====================================================
-- PROVINSI: JAWA BARAT (BPS 13)
-- =====================================================
('3201', '13', 'Kabupaten Bogor'),
('3202', '13', 'Kabupaten Sukabunii'),
('3203', '13', 'Kabupaten Cianjur'),
('3204', '13', 'Kabupaten Bandung'),
('3205', '13', 'Kabupaten Sumedang'),
('3206', '13', 'Kabupaten Majalengka'),
('3207', '13', 'Kabupaten Kuningan'),
('3208', '13', 'Kabupaten Ciamis'),
('3209', '13', 'Kabupaten Cirebon'),
('3210', '13', 'Kabupaten Indramayu'),
('3211', '13', 'Kabupaten Subang'),
('3212', '13', 'Kabupaten Karawang'),
('3213', '13', 'Kabupaten Bekasi'),
('3214', '13', 'Kabupaten Pangandaran'),
('3215', '13', 'Kabupaten Bandung Barat'),
('3271', '13', 'Kota Bogor'),
('3272', '13', 'Kota Bandung'),
('3273', '13', 'Kota Cirebon'),
('3274', '13', 'Kota Bekasi'),
('3275', '13', 'Kota Depok'),
('3276', '13', 'Kota Cimahi'),
('3277', '13', 'Kota Tasikmalaya'),
('3278', '13', 'Kota Banjar'),

-- =====================================================
-- PROVINSI: JAWA TENGAH (BPS 14)
-- =====================================================
('3301', '14', 'Kabupaten Cilacap'),
('3302', '14', 'Kabupaten Banyumas'),
('3303', '14', 'Kabupaten Purbalingga'),
('3304', '14', 'Kabupaten Banjarnegara'),
('3305', '14', 'Kabupaten Kebumen'),
('3306', '14', 'Kabupaten Wonosobo'),
('3307', '14', 'Kabupaten Magelang'),
('3308', '14', 'Kabupaten Boyolali'),
('3309', '14', 'Kabupaten Klaten'),
('3310', '14', 'Kabupaten Sukoharjo'),
('3311', '14', 'Kabupaten Wonogiri'),
('3312', '14', 'Kabupaten Karanganyar'),
('3313', '14', 'Kabupaten Sragen'),
('3314', '14', 'Kabupaten Grobogan'),
('3315', '14', 'Kabupaten Blora'),
('3316', '14', 'Kabupaten Rembang'),
('3317', '14', 'Kabupaten Pati'),
('3318', '14', 'Kabupaten Kudus'),
('3319', '14', 'Kabupaten Jepara'),
('3320', '14', 'Kabupaten Demak'),
('3321', '14', 'Kabupaten Semarang'),
('3322', '14', 'Kabupaten Temanggung'),
('3323', '14', 'Kabupaten Kendal'),
('3324', '14', 'Kabupaten Batang'),
('3325', '14', 'Kabupaten Pekalongan'),
('3326', '14', 'Kabupaten Pemalang'),
('3327', '14', 'Kabupaten Tegal'),
('3328', '14', 'Kabupaten Brebes'),
('3371', '14', 'Kota Magelang'),
('3372', '14', 'Kota Surakarta'),
('3373', '14', 'Kota Salatiga'),
('3374', '14', 'Kota Semarang'),
('3375', '14', 'Kota Pekalongan'),
('3376', '14', 'Kota Tegal'),

-- =====================================================
-- PROVINSI: DI YOGYAKARTA (BPS 15)
-- =====================================================
('3401', '15', 'Kabupaten Kulon Progo'),
('3402', '15', 'Kabupaten Bantul'),
('3403', '15', 'Kabupaten Gunungkidul'),
('3404', '15', 'Kabupaten Sleman'),
('3471', '15', 'Kota Yogyakarta'),

-- =====================================================
-- PROVINSI: JAWA TIMUR (BPS 16)
-- =====================================================
('3501', '16', 'Kabupaten Pacitan'),
('3502', '16', 'Kabupaten Ponorogo'),
('3503', '16', 'Kabupaten Trenggalek'),
('3504', '16', 'Kabupaten Tulungagung'),
('3505', '16', 'Kabupaten Blitar'),
('3506', '16', 'Kabupaten Kediri'),
('3507', '16', 'Kabupaten Malang'),
('3508', '16', 'Kabupaten Lumajang'),
('3509', '16', 'Kabupaten Malang'),
('3510', '16', 'Kabupaten Probolinggo'),
('3511', '16', 'Kabupaten Pasuruan'),
('3512', '16', 'Kabupaten Sidoarjo'),
('3513', '16', 'Kabupaten Mojokerto'),
('3514', '16', 'Kabupaten Jombang'),
('3515', '16', 'Kabupaten Nganjuk'),
('3516', '16', 'Kabupaten Madiun'),
('3517', '16', 'Kabupaten Magetan'),
('3518', '16', 'Kabupaten Ngawi'),
('3519', '16', 'Kabupaten Bojonegoro'),
('3520', '16', 'Kabupaten Tuban'),
('3521', '16', 'Kabupaten Lamongan'),
('3522', '16', 'Kabupaten Gresik'),
('3523', '16', 'Kabupaten Bangkalan'),
('3524', '16', 'Kabupaten Sampang'),
('3525', '16', 'Kabupaten Pamekasan'),
('3526', '16', 'Kabupaten Sumenep'),
('3527', '16', 'Kabupaten Kota Malang'),
('3571', '16', 'Kota Malang'),
('3572', '16', 'Kota Probolinggo'),
('3573', '16', 'Kota Pasuruan'),
('3574', '16', 'Kota Mojokerto'),
('3575', '16', 'Kota Madiun'),
('3576', '16', 'Kota Surabaya'),
('3577', '16', 'Kota Batu'),

-- =====================================================
-- PROVINSI: BANTEN (BPS 17)
-- =====================================================
('3601', '17', 'Kabupaten Pandeglang'),
('3602', '17', 'Kabupaten Lebak'),
('3603', '17', 'Kabupaten Serang'),
('3604', '17', 'Kabupaten Tangerang'),
('3671', '17', 'Kota Serang'),
('3672', '17', 'Kota Tangerang'),
('3673', '17', 'Kota Cilegon'),
('3674', '17', 'Kota Tangerang Selatan'),

-- =====================================================
-- PROVINSI: BALI (BPS 18)
-- =====================================================
('5101', '18', 'Kabupaten Jembrana'),
('5102', '18', 'Kabupaten Tabanan'),
('5103', '18', 'Kabupaten Badung'),
('5104', '18', 'Kabupaten Gianyar'),
('5105', '18', 'Kabupaten Klungkung'),
('5106', '18', 'Kabupaten Bangli'),
('5107', '18', 'Kabupaten Karang Asem'),
('5108', '18', 'Kabupaten Buleleng'),
('5171', '18', 'Kota Denpasar'),

-- =====================================================
-- PROVINSI: NUSA TENGGARA BARAT (BPS 19)
-- =====================================================
('5201', '19', 'Kabupaten Lombok Barat'),
('5202', '19', 'Kabupaten Lombok Tengah'),
('5203', '19', 'Kabupaten Lombok Timur'),
('5204', '19', 'Kabupaten Sumbawa'),
('5205', '19', 'Kabupaten Dompu'),
('5206', '19', 'Kabupaten Bima'),
('5207', '19', 'Kabupaten Sumbawa Barat'),
('5271', '19', 'Kota Mataram'),
('5272', '19', 'Kota Bima'),

-- =====================================================
-- PROVINSI: NUSA TENGGARA TIMUR (BPS 20)
-- =====================================================
('5301', '20', 'Kabupaten Sumba Barat'),
('5302', '20', 'Kabupaten Sumba Timur'),
('5303', '20', 'Kabupaten Timor Tengah Selatan'),
('5304', '20', 'Kabupaten Timor Tengah Utara'),
('5305', '20', 'Kabupaten Belu'),
('5306', '20', 'Kabupaten Alor'),
('5307', '20', 'Kabupaten Lembata'),
('5308', '20', 'Kabupaten Flores Timur'),
('5309', '20', 'Kabupaten Sikka'),
('5310', '20', 'Kabupaten Ende'),
('5311', '20', 'Kabupaten Ngada'),
('5312', '20', 'Kabupaten Manggarai'),
('5313', '20', 'Kabupaten Rotendao'),
('5314', '20', 'Kabupaten Manggarai Timur'),
('5315', '20', 'Kabupaten Sabu Raijua'),
('5316', '20', 'Kabupaten Malaka'),
('5371', '20', 'Kota Kupang'),

-- =====================================================
-- PROVINSI: KALIMANTAN BARAT (BPS 21)
-- =====================================================
('6101', '21', 'Kabupaten Sambas'),
('6102', '21', 'Kabupaten Mempawah'),
('6103', '21', 'Kabupaten Sanggau'),
('6104', '21', 'Kabupaten Ketapang'),
('6105', '21', 'Kabupaten Sintang'),
('6106', '21', 'Kabupaten Kapuas Hulu'),
('6107', '21', 'Kabupaten Benton'),
('6108', '21', 'Kabupaten Landak'),
('6109', '21', 'Kabupaten Sekadau'),
('6110', '21', 'Kabupaten Melawi'),
('6111', '21', 'Kabupaten Kayong Utara'),
('6171', '21', 'Kota Pontianak'),
('6172', '21', 'Kota Singkawang'),

-- =====================================================
-- PROVINSI: KALIMANTAN TENGAH (BPS 22)
-- =====================================================
('6201', '22', 'Kabupaten Kotawaringin Barat'),
('6202', '22', 'Kabupaten Kotawaringin Timur'),
('6203', '22', 'Kabupaten Kapuas'),
('6204', '22', 'Kabupaten Barito Selatan'),
('6205', '22', 'Kabupaten Barito Utara'),
('6206', '22', 'Kabupaten Sukamara'),
('6207', '22', 'Kabupaten Lamandau'),
('6208', '22', 'Kabupaten Seruyan'),
('6209', '22', 'Kabupaten Katingan'),
('6210', '22', 'Kabupaten Pulang Pisau'),
('6211', '22', 'Kabupaten Gunungs Mas'),
('6212', '22', 'Kabupaten Murung Raya'),
('6271', '22', 'Kota Palangka Raya'),

-- =====================================================
-- PROVINSI: KALIMANTAN SELATAN (BPS 23)
-- =====================================================
('6301', '23', 'Kabupaten Tanah Laut'),
('6302', '23', 'Kabupaten Kota Baru'),
('6303', '23', 'Kabupaten Banjar'),
('6304', '23', 'Kabupaten Barito Kuala'),
('6305', '23', 'Kabupaten Tapin'),
('6306', '23', 'Kabupaten Hulu Sungai Selatan'),
('6307', '23', 'Kabupaten Hulu Sungai Tengah'),
('6308', '23', 'Kabupaten Hulu Sungai Utara'),
('6309', '23', 'Kabupaten Tabalong'),
('6310', '23', 'Kabupaten Tanah Bumbu'),
('6311', '23', 'Kabupaten Balangan'),
('6371', '23', 'Kota Banjarmasin'),
('6372', '23', 'Kota Banjarbaru'),

-- =====================================================
-- PROVINSI: KALIMANTAN TIMUR (BPS 24)
-- =====================================================
('6401', '24', 'Kabupaten Paser'),
('6402', '24', 'Kabupaten Kutai Kartanegara'),
('6403', '24', 'Kabupaten Berau'),
('6404', '24', 'Kabupaten Kutai Barat'),
('6405', '24', 'Kabupaten Kutai Timur'),
('6406', '24', 'Kabupaten Mahakam Ulu'),
('6407', '24', 'Kabupaten Penajam Paser Utara'),
('6471', '24', 'Kota Balikpapan'),
('6472', '24', 'Kota Samarinda'),
('6474', '24', 'Kota Bontang'),

-- =====================================================
-- PROVINSI: KALIMANTAN UTARA (BPS 25)
-- =====================================================
('6501', '25', 'Kabupaten Nunukan'),
('6502', '25', 'Kabupaten Malinau'),
('6503', '25', 'Kabupaten Bulungan'),
('6504', '25', 'Kabupaten Tana Tidung'),
('6571', '25', 'Kota Tanjung Selor'),

-- =====================================================
-- PROVINSI: SULAWESI UTARA (BPS 26)
-- =====================================================
('7101', '26', 'Kabupaten Bolaang Mongondow'),
('7102', '26', 'Kabupaten Minahasa'),
('7103', '26', 'Kabupaten Kepulauan Sangihe'),
('7104', '26', 'Kabupaten Kepulauan Talaud'),
('7105', '26', 'Kabupaten Minahasa Selatan'),
('7106', '26', 'Kabupaten Minahasa Utara'),
('7107', '26', 'Kabupaten Bolaang Mongondow Utara'),
('7108', '26', 'Kabupaten Siau Tagulandang Biaro'),
('7109', '26', 'Kabupaten Minahasa Tenggara'),
('7110', '26', 'Kabupaten Bolaang Mongondow Timur'),
('7111', '26', 'Kabupaten Bolaang Mongondow Selatan'),
('7171', '26', 'Kota Manado'),
('7172', '26', 'Kota Bitung'),
('7173', '26', 'Kota Tomohon'),
('7174', '26', 'Kota Kotamobagu'),

-- =====================================================
-- PROVINSI: SULAWESI TENGAH (BPS 27)
-- =====================================================
('7201', '27', 'Kabupaten Banggai'),
('7202', '27', 'Kabupaten Poso'),
('7203', '27', 'Kabupaten Donggala'),
('7204', '27', 'Kabupaten Toli-Toli'),
('7205', '27', 'Kabupaten Buol'),
('7206', '27', 'Kabupaten Morowali'),
('7207', '27', 'Kabupaten Banggai Laut'),
('7208', '27', 'Kabupaten Morowali Utara'),
('7209', '27', 'Kabupaten Tojo Una-Una'),
('7271', '27', 'Kota Palu'),

-- =====================================================
-- PROVINSI: SULAWESI SELATAN (BPS 28)
-- =====================================================
('7301', '28', 'Kabupaten Kepulayan Selayar'),
('7302', '28', 'Kabupaten Bulukumba'),
('7303', '28', 'Kabupaten Bantaeng'),
('7304', '28', 'Kabupaten Jeneponto'),
('7305', '28', 'Kabupaten Takalar'),
('7306', '28', 'Kabupaten Gowa'),
('7307', '28', 'Kabupaten Sinjai'),
('7308', '28', 'Kabupaten Maros'),
('7309', '28', 'Kabupaten Pangkajene dan Kepulauan'),
('7310', '28', 'Kabupaten Barru'),
('7311', '28', 'Kabupaten Bone'),
('7312', '28', 'Kabupaten Soppeng'),
('7313', '28', 'Kabupaten Wajo'),
('7314', '28', 'Kabupaten Pinrang'),
('7315', '28', 'Kabupaten Sidenreng Rappang'),
('7316', '28', 'Kabupaten Parepare'),
('7317', '28', 'Kabupaten Enrekang'),
('7318', '28', 'Kabupaten Luwu'),
('7319', '28', 'Kabupaten Luwu Timur'),
('7320', '28', 'Kabupaten Luwu Utara'),
('7321', '28', 'Kabupaten Utara'),
('7371', '28', 'Kota Makassar'),
('7372', '28', 'Kota Parepare'),
('7373', '28', 'Kota Palopo'),

-- =====================================================
-- PROVINSI: SULAWESI TENGGARA (BPS 29)
-- =====================================================
('7401', '29', 'Kabupaten Buton'),
('7402', '29', 'Kabupaten Muna'),
('7403', '29', 'Kabupaten Konawe'),
('7404', '29', 'Kabupaten Kolaka'),
('7405', '29', 'Kabupaten Konawe Selatan'),
('7406', '29', 'Kabupaten Bombana'),
('7407', '29', 'Kabupaten Wakatobi'),
('7408', '29', 'Kabupaten Kolaka Timur'),
('7409', '29', 'Kabupaten Konawe Kepulauan'),
('7410', '29', 'Kabupaten Muna Barat'),
('7411', '29', 'Kabupaten Buton Utara'),
('7412', '29', 'Kabupaten Konawe Utara'),
('7471', '29', 'Kota Kendari'),
('7472', '29', 'Kota Bau-Bau'),

-- =====================================================
-- PROVINSI: GORONTALO (BPS 30)
-- =====================================================
('7501', '30', 'Kabupaten Boalemo'),
('7502', '30', 'Kabupaten Gorontalo'),
('7503', '30', 'Kabupaten Pohuwato'),
('7504', '30', 'Kabupaten Bone Bolango'),
('7505', '30', 'Kabupaten Gorontalo Utara'),
('7571', '30', 'Kota Gorontalo'),

-- =====================================================
-- PROVINSI: SULAWESI BARAT (BPS 31)
-- =====================================================
('7601', '31', 'Kabupaten Majene'),
('7602', '31', 'Kabupaten Polewali Mandar'),
('7603', '31', 'Kabupaten Mamasa'),
('7604', '31', 'Kabupaten Mamuju'),
('7605', '31', 'Kabupaten Mamuju Utara'),
('7606', '31', 'Kabupaten Mamuju Tengah'),

-- =====================================================
-- PROVINSI: MALUKU (BPS 32)
-- =====================================================
('8101', '32', 'Kabupaten Maluku Tenggara Barat'),
('8102', '32', 'Kabupaten Maluku Tenggara'),
('8103', '32', 'Kabupaten Maluku Tengah'),
('8104', '32', 'Kabupaten Buru'),
('8105', '32', 'Kabupaten Buru Selatan'),
('8106', '32', 'Kabupaten Kepulauan Aru'),
('8107', '32', 'Kabupaten Maluku Barat Daya'),
('8108', '32', 'Kabupaten Seram Bagian Timur'),
('8109', '32', 'Kabupaten Seram Bagian Barat'),
('8171', '32', 'Kota Ambon'),
('8172', '32', 'Kota Tual'),

-- =====================================================
-- PROVINSI: MALUKU UTARA (BPS 33)
-- =====================================================
('8201', '33', 'Kabupaten Halmahera Barat'),
('8202', '33', 'Kabupaten Halmahera Tengah'),
('8203', '33', 'Kabupaten Kepulauan Sula'),
('8204', '33', 'Kabupaten Halmahera Selatan'),
('8205', '33', 'Kabupaten Halmahera Utara'),
('8206', '33', 'Kabupaten Halmahera Timur'),
('8207', '33', 'Kabupaten Pulau Morotai'),
('8208', '33', 'Kabupaten Pulau Taliabu'),
('8271', '33', 'Kota Ternate'),
('8272', '33', 'Kota Tidore Kepulauan'),

-- =====================================================
-- PROVINSI: PAPUA BARAT (BPS 34)
-- =====================================================
('9101', '34', 'Kabupaten Fakfak'),
('9102', '34', 'Kabupaten Kaimana'),
('9103', '34', 'Kabupaten Manokwari'),
('9104', '34', 'Kabupaten Maybrat'),
('9105', '34', 'Kabupaten Raja Ampat'),
('9106', '34', 'Kabupaten Sorong'),
('9107', '34', 'Kabupaten Sorong Selatan'),
('9108', '34', 'Kabupaten Tambrauw'),
('9109', '34', 'Kabupaten Teluk Bintuni'),
('9110', '34', 'Kabupaten Telok Wondama'),
('9171', '34', 'Kota Sorong'),

-- =====================================================
-- PROVINSI: PAPUA (BPS 35)
-- =====================================================
('9201', '35', 'Kabupaten Biak Numfor'),
('9202', '35', 'Kabupaten Jayapura'),
('9203', '35', 'Kabupaten Keerom'),
('9204', '35', 'Kabupaten Kepulayan Yapen'),
('9205', '35', 'Kabupaten Mamberamo Raya'),
('9206', '35', 'Kabupaten Mamberamo Tengah'),
('9207', '35', 'Kabupaten Nduga'),
('9208', '35', 'Kabupaten Mimika'),
('9209', '35', 'Kabupaten Nabire'),
('9210', '35', 'Kabupaten Paniai'),
('9211', '35', 'Kabupaten Pegunungan Bintang'),
('9212', '35', 'Kabupaten Puncak'),
('9213', '35', 'Kabupaten Puncak Jaya'),
('9214', '35', 'Kabupaten Sarmi'),
('9215', '35', 'Kabupaten Supiori'),
('9216', '35', 'Kabupaten Waropen'),
('9271', '35', 'Kota Jayapura'),

-- =====================================================
-- PROVINSI: PAPUA TENGAH (BPS 36)
-- =====================================================
('9301', '36', 'Kabupaten Deiyai'),
('9302', '36', 'Kabupaten Dogiyai'),
('9303', '36', 'Kabupaten Intan Jaya'),
('9304', '36', 'Kabupaten Lanny Jaya'),
('9305', '36', 'Kabupaten Mamberamo Tengah'),
('9306', '36', 'Kabupaten Nabire'),
('9307', '36', 'Kabupaten Paniai'),
('9308', '36', 'Kabupaten Puncak'),
('9309', '36', 'Kabupaten Puncak Jaya'),
('9310', '36', 'Kabupaten Yahukimo'),
('9311', '36', 'Kabupaten Yalimo'),
('9371', '36', 'Kota Nabire'),

-- =====================================================
-- PROVINSI: PAPUA PEGUNUNGAN (BPS 37)
-- =====================================================
('9401', '37', 'Kabupaten Asmat'),
('9402', '37', 'Kabupaten Biak Numfor'),
('9403', '37', 'Kabupaten Bovendigoel'),
('9404', '37', 'Kabupaten Mappi'),
('9405', '37', 'Kabupaten Merauke'),
('9406', '37', 'Kabupaten Supiori'),
('9407', '37', 'Kabupaten Yahukimo'),
('9408', '37', 'Kabupaten Yalimo'),
('9471', '37', 'Kota Merauke'),

-- =====================================================
-- PROVINSI: PAPUA SELATAN (BPS 38)
-- =====================================================
('9501', '38', 'Kabupaten Asmat'),
('9502', '38', 'Kabupaten Boven Digoel'),
('9503', '38', 'Kabupaten Mappi'),
('9504', '38', 'Kabupaten Merauke'),
('9571', '38', 'Kota Merauke'),

-- =====================================================
-- PROVINSI: PAPUA BARAT DAYA (BPS 39)
-- =====================================================
('9601', '39', 'Kabupaten Raja Ampat'),
('9602', '39', 'Kabupaten Sorong'),
('9603', '39', 'Kabupaten Sorong Selatan'),
('9604', '39', 'Kabupaten Tambrauw'),
('9605', '39', 'Kabupaten Maybrat'),
('9606', '39', 'Kabupaten Fakfak'),
('9607', '39', 'Kabupaten Kaimana'),
('9671', '39', 'Kota Sorong');

-- =====================================================
-- VERIFIKASI DATA
-- =====================================================

-- Tampilkan jumlah data kabupaten per provinsi
SELECT 
  f.nama as provinsi,
  COUNT(k.id) as jumlah_kabupaten
FROM formasi f
LEFT JOIN kabupaten k ON f.kode = k.kode_provinsi
WHERE f.kode != '00' AND f.kode != '01'
GROUP BY f.kode, f.nama
ORDER BY f.kode;

-- Tampilkan total keseluruhan
SELECT 
  'TOTAL KABUPATEN' as info,
  COUNT(*) as jumlah 
FROM kabupaten;

-- Tampilkan sample data
SELECT '=== SAMPLE DATA KABUPATEN ===' as info;
SELECT k.nama as kabupaten, f.nama as provinsi 
FROM kabupaten k 
JOIN formasi f ON k.kode_provinsi = f.kode 
WHERE f.kode != '00' AND f.kode != '01'
LIMIT 10;

-- =====================================================
-- SELESAI
-- =====================================================

SELECT 'Data kabupaten berhasil diisi!' as status;