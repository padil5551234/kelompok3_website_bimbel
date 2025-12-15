-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 14 Des 2025 pada 04.30
-- Versi server: 10.11.13-MariaDB-cll-lve
-- Versi PHP: 8.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dinassol_new`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `articles`
--

CREATE TABLE `articles` (
  `id` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'umum',
  `author_id` char(36) DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `meta_keywords` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_keywords`)),
  `meta_description` text DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `category`, `author_id`, `status`, `is_featured`, `views_count`, `tags`, `meta_keywords`, `meta_description`, `published_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
('10657cc9-cb81-4b1e-8b9a-84487a017f57', 'Tips Jitu Menghadapi SPMB STIS', 'tips-jitu-menghadapi-spmb-stis-3', NULL, '<p>Test artikel 3 dengan judul yang sama</p>', NULL, 'tips', NULL, 'published', 0, 0, NULL, NULL, NULL, '2025-11-07 16:19:51', '2025-11-07 16:19:51', '2025-11-07 16:22:53', '2025-11-07 16:22:53'),
('1b566e7c-9391-4693-9456-1db7ea645956', 'MASUKK STISS GAJI DUA DIGIT ?, CEK FAKTANYAA DISINI', 'masukk-stiss-gaji-dua-digit-cek-faktanyaa-disini', 'Gaji lulusan stis', '<p>Gaji lulusan STIS (Politeknik Statistika) setelah menjadi CPNS di Badan Pusat Statistik (BPS) terdiri dari gaji pokok dan berbagai tunjangan.&nbsp;<mark class=\"HxTRcb\" jscontroller=\"DfH0l\" jsuid=\"r76KUe_7\" style=\"background-image: linear-gradient(90deg, rgb(52, 69, 127) 50%, rgba(0, 0, 0, 0) 50%); background-position: 75% 0px; background-size: 200% 100%; background-repeat: no-repeat; background-attachment: scroll; background-origin: padding-box; background-clip: border-box; border-radius: 4px; padding: 0px 2px; animation: 0.75s cubic-bezier(0.05, 0.7, 0.1, 1) 0.25s 1 normal forwards running highlight-animation;\">Gaji pokok untuk lulusan D4 (golongan III/a) adalah sekitar Rp2.785.700 - Rp4.575.200, sedangkan lulusan D3 (golongan IIc) adalah sekitar Rp2.485.900 - Rp3.958.200. Gaji total per bulan bisa mencapai sekitar Rp7,6 juta</mark>&nbsp;(estimasi untuk D4) karena adanya tunjangan, seperti tunjangan kinerja dan tunjangan lainnya.<span jsuid=\"r76KUe_8\" class=\"uJ19be notranslate\" jsaction=\"rcuQ6b:&amp;r76KUe_8|npT2md\" jscontroller=\"udAs2b\" data-wiz-uids=\"r76KUe_8,r76KUe_9,r76KUe_a\" style=\"\"><span class=\"vKEkVd\" data-animation-atomic=\"\" style=\"position: relative;\">&nbsp;</span></span></p>', 'articles/4PefWcdJ0HVYe3lKQzvOKtuYBP1n8uKpdp3jE3ev.jpg', 'umum', '2fc45e87-17a5-4bf4-a694-9588478ff488', 'published', 1, 22, '[\"gaji\",\"stis\",\"kedinasan\"]', NULL, 'gaji lulusan stis', '2025-12-04 06:20:36', '2025-12-04 06:20:36', '2025-12-09 13:18:13', NULL),
('27ef41ca-e8be-451a-934b-847f33613b84', 'Tips Jitu Menghadapi SPMB STIS', 'tips-jitu-menghadapi-spmb-stis-1', NULL, '<p>Test artikel 1</p>', NULL, 'tips', NULL, 'published', 0, 0, NULL, NULL, NULL, '2025-11-07 16:19:51', '2025-11-07 16:19:51', '2025-11-07 16:22:53', '2025-11-07 16:22:53'),
('3a1a7ae8-d172-4ea1-a85a-36723e5ede11', 'Strategi Mengerjakan Soal TIU dengan Cepat', 'strategi-mengerjakan-soal-tiu-dengan-cepat', 'Pelajari teknik dan strategi khusus untuk menyelesaikan soal Tes Intelegensi Umum (TIU) secara efektif dan efisien.', '<p>Tes Intelegensi Umum (TIU) seringkali menjadi momok bagi peserta ujian karena soalnya yang beragam dan waktu yang terbatas. Berikut strategi mengerjakan TIU dengan cepat:</p>\r\n                \r\n                <h3>1. Kenali Jenis Soal TIU</h3>\r\n                <p>TIU terdiri dari verbal, numerik, dan figural. Ketahui jenis soal mana yang menjadi kekuatan Anda.</p>\r\n                \r\n                <h3>2. Kerjakan yang Mudah Dulu</h3>\r\n                <p>Jangan terpaku pada soal yang sulit. Kerjakan dulu soal-soal yang mudah untuk mengamankan poin.</p>\r\n                \r\n                <h3>3. Gunakan Teknik Eliminasi</h3>\r\n                <p>Untuk soal yang membingungkan, gunakan teknik eliminasi jawaban yang jelas salah terlebih dahulu.</p>\r\n                \r\n                <h3>4. Latihan Rutin</h3>\r\n                <p>Kecepatan mengerjakan soal TIU didapat dari latihan yang konsisten. Semakin banyak berlatih, semakin cepat Anda mengenali pola soal.</p>\r\n                \r\n                <h3>5. Manajemen Waktu per Sesi</h3>\r\n                <p>Bagi waktu dengan bijak. Jangan habiskan terlalu banyak waktu di satu soal saja.</p>', NULL, 'strategi', '2fc45e87-17a5-4bf4-a694-9588478ff488', 'published', 1, 0, NULL, NULL, NULL, '2025-11-04 16:18:48', '2025-11-07 16:18:48', '2025-11-11 06:49:46', '2025-11-11 06:49:46'),
('3ccda3c0-ae3c-4e07-a4e0-b7c3a56c0d81', 'TIPS', 'tips', 'HA', '<p>TEST</p>', 'articles/8NNpNO4aPhL2FSLsbkpbCS2vvaaKTiIgowzdRcrZ.jpg', 'tips', '2fc45e87-17a5-4bf4-a694-9588478ff488', 'published', 0, 21, NULL, NULL, NULL, '2025-12-01 10:31:26', '2025-12-01 10:31:26', '2025-12-02 10:40:16', '2025-12-02 10:40:16'),
('435c7efa-0b4a-4b6a-9b76-8eb418bc51be', 'Motivasi: Jangan Menyerah dalam Mengejar Mimpi Kedinasan', 'motivasi-jangan-menyerah-dalam-mengejar-mimpi-kedinasan', 'Perjalanan menuju sekolah kedinasan penuh tantangan, namun setiap usaha keras akan membuahkan hasil yang manis.', '<p>Mengejar mimpi masuk sekolah kedinasan memang tidak mudah. Persaingan yang ketat dan materi yang luas bisa membuat kita merasa lelah dan ingin menyerah. Namun, ingatlah bahwa setiap usaha keras tidak akan pernah mengkhianati hasil.</p>\r\n                \r\n                <h3>Kisah Inspiratif Para Alumni</h3>\r\n                <p>Banyak mahasiswa STIS yang sebelumnya gagal berkali-kali namun tidak menyerah. Mereka terus belajar, mengikuti bimbel, dan mencoba lagi hingga akhirnya berhasil.</p>\r\n                \r\n                <h3>Tips Menjaga Motivasi</h3>\r\n                <p>1. <strong>Tentukan Tujuan Jelas:</strong> Ketahui mengapa Anda ingin masuk sekolah kedinasan.</p>\r\n                <p>2. <strong>Buat Jadwal Belajar:</strong> Konsistensi adalah kunci sukses.</p>\r\n                <p>3. <strong>Bergabung dengan Komunitas:</strong> Belajar bersama teman yang memiliki tujuan sama dapat meningkatkan semangat.</p>\r\n                <p>4. <strong>Evaluasi dan Perbaiki:</strong> Setiap kegagalan adalah pembelajaran. Evaluasi kesalahan dan perbaiki.</p>\r\n                <p>5. <strong>Percaya Pada Diri Sendiri:</strong> Keyakinan diri adalah fondasi kesuksesan.</p>\r\n                \r\n                <h3>Ingat Selalu</h3>\r\n                <p>\"Sukses bukan tentang tidak pernah gagal, tetapi tentang tidak pernah menyerah setelah gagal.\" Terus berjuang dan raih mimpimu!</p>', NULL, 'motivasi', '2fc45e87-17a5-4bf4-a694-9588478ff488', 'published', 0, 0, NULL, NULL, NULL, '2025-11-06 16:18:48', '2025-11-07 16:18:48', '2025-11-11 06:49:50', '2025-11-11 06:49:50'),
('6f6879d5-178d-4542-94af-dfc9a3533f8c', 'Tips Jitu Menghadapi SPMB STIS', 'tips-jitu-menghadapi-spmb-stis-2', NULL, '<p>Test artikel 2 dengan judul yang sama</p>', NULL, 'tips', NULL, 'published', 0, 0, NULL, NULL, NULL, '2025-11-07 16:19:51', '2025-11-07 16:19:51', '2025-11-07 16:22:53', '2025-11-07 16:22:53'),
('7d65a53d-6d33-4697-8c67-ea44f8d39562', 'Tips Masuk STIS', 'tips-masuk-stis', 'test', '<p>test</p>', 'articles/IPKYKsDFC97qOLxfP4IGGpPLbL46reDeedtUsiMN.jpg', 'tips', '2fc45e87-17a5-4bf4-a694-9588478ff488', 'published', 0, 3, NULL, NULL, 'TIPS', '2025-11-30 15:42:00', '2025-11-30 15:42:00', '2025-11-30 15:56:17', '2025-11-30 15:56:17'),
('910ac174-9a37-4bc2-8a12-b4975ca5dcbe', 'PEMBESAR PENIS', 'pembesar-penis', 'PEMBESAR PENIS', '<p>BLABLA</p>', 'articles/1s4v83G7D1CxvHbSGhyeDHfzPQiu4Zq6sWPr4ZeW.jpg', 'umum', '2fc45e87-17a5-4bf4-a694-9588478ff488', 'published', 0, 0, NULL, NULL, NULL, '2025-12-04 02:19:21', '2025-12-04 02:18:13', '2025-12-04 02:20:23', '2025-12-04 02:20:23'),
('aab8084a-e01e-42f9-847d-6d5aba5d7d37', 'TIPS JITU LULUS POLSTAT STIS DENGAN NILAI MEMUASKAN', 'tips-jitu-lulus-polstat-stis-dengan-nilai-memuaskan', 'Tips', '<ol><li><p><strong>Pahami Struktur Ujian</strong></p>\r\n<ul>\r\n<li>\r\n<p>Ketahui tahapan seleksi: administrasi, SKD (CAT BKN), SKB, dan tes lanjutan.</p>\r\n</li>\r\n<li>\r\n<p>Pelajari tipe soal: TWK, TIU, dan TKP untuk SKD; serta Matematika, Bahasa Inggris, dan Pengetahuan Umum Statistik untuk SKB.</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Belajar Terarah dan Konsisten</strong></p>\r\n<ul>\r\n<li>\r\n<p>Buat jadwal belajar harian dan target mingguan.</p>\r\n</li>\r\n<li>\r\n<p>Fokus pada materi yang sering muncul dan evaluasi hasil latihan secara rutin.</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Gunakan Sumber Belajar yang Tepat</strong></p>\r\n<ul>\r\n<li>\r\n<p>Manfaatkan buku resmi, modul bimbel kedinasan, dan latihan soal tahun-tahun sebelumnya.</p>\r\n</li>\r\n<li>\r\n<p>Ikuti tryout online untuk membiasakan diri dengan sistem CAT.</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Perkuat Dasar Akademik</strong></p>\r\n<ul>\r\n<li>\r\n<p>Kuasai konsep dasar Matematika (aljabar, logika, peluang).</p>\r\n</li>\r\n<li>\r\n<p>Asah kemampuan Bahasa Inggris (grammar &amp; reading comprehension).</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Tingkatkan Kecepatan dan Ketelitian</strong></p>\r\n<ul>\r\n<li>\r\n<p>Latih diri menjawab soal dengan waktu terbatas.</p>\r\n</li>\r\n<li>\r\n<p>Prioritaskan soal mudah lebih dulu agar waktu efisien.</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Jaga Kondisi Fisik dan Mental</strong></p>\r\n<ul>\r\n<li>\r\n<p>Tidur cukup, makan sehat, dan rutin olahraga ringan.</p>\r\n</li>\r\n<li>\r\n<p>Hindari stres dengan tetap tenang dan percaya diri.</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Bangun Motivasi dan Niat yang Kuat</strong></p>\r\n<ul>\r\n<li>\r\n<p>Tanamkan tujuan besar: menjadi ASN bidang statistik dan berkontribusi untuk bangsa.</p>\r\n</li>\r\n<li>\r\n<p>Lingkupi diri dengan lingkungan belajar positif dan teman seperjuangan.</p>\r\n</li>\r\n</ul>\r\n</li>\r\n</ol><p>\r\n\r\n</p><p><br></p>', 'articles/H565tU6MTRCAQxMj5Pqi2TPaXli6xTaZEBB5lzZf.jpg', 'tips', '2fc45e87-17a5-4bf4-a694-9588478ff488', 'published', 1, 8, '[\"tips\",\"strategi\",\"kedinasan\"]', NULL, NULL, '2025-11-12 05:04:03', '2025-11-12 05:04:03', '2025-11-12 08:10:14', '2025-11-12 08:10:14'),
('d09431b8-a0f6-4afa-bd34-e287b238db18', 'Tips Jitu Menghadapi SPMB STIS', 'tips-jitu-menghadapi-spmb-stis', 'Ketahui strategi efektif untuk menghadapi Seleksi Penerimaan Mahasiswa Baru STIS agar peluang lolos semakin besar.', '<p>Seleksi Penerimaan Mahasiswa Baru (SPMB) STIS merupakan salah satu seleksi masuk sekolah kedinasan yang paling kompetitif. Berikut adalah tips jitu untuk menghadapinya:</p>\r\n                \r\n                <h3>1. Pahami Materi SKD dengan Baik</h3>\r\n                <p>Materi SKD terdiri dari TWK, TIU, dan TKP. Pastikan Anda memahami konsep dasar dan berlatih soal-soal secara rutin.</p>\r\n                \r\n                <h3>2. Kuasai Matematika Dasar</h3>\r\n                <p>Matematika adalah kunci utama dalam SPMB STIS. Fokus pada aljabar, trigonometri, dan statistika.</p>\r\n                \r\n                <h3>3. Manajemen Waktu</h3>\r\n                <p>Latih diri Anda untuk mengerjakan soal dengan time management yang baik. Gunakan sistem CAT untuk terbiasa dengan kondisi ujian sebenarnya.</p>\r\n                \r\n                <h3>4. Ikuti Try Out Berkala</h3>\r\n                <p>Try out membantu Anda mengenali jenis soal dan mengukur kemampuan. Evaluasi hasil try out untuk fokus pada materi yang masih lemah.</p>\r\n                \r\n                <h3>5. Jaga Kesehatan Mental dan Fisik</h3>\r\n                <p>Persiapan yang matang harus diimbangi dengan kondisi fisik dan mental yang prima. Istirahat cukup dan kelola stres dengan baik.</p>', NULL, 'tips', '2fc45e87-17a5-4bf4-a694-9588478ff488', 'published', 1, 3, NULL, NULL, NULL, '2025-11-02 16:18:48', '2025-11-07 16:18:48', '2025-11-11 06:49:42', '2025-11-11 06:49:42'),
('edcae393-b1f5-42bd-809f-3509b5a48136', 'Cara Menyayangi Fineshyt', 'cara-menyayangi-fineshyt', 'wop wop', '<p>adudul</p>', 'articles/fABia6CP1a39gRU866XE8xIYn7ufWglVJtFgI0yI.jpg', 'tips', '2fc45e87-17a5-4bf4-a694-9588478ff488', 'published', 0, 4, NULL, NULL, NULL, '2025-11-07 16:24:35', '2025-11-07 16:22:19', '2025-11-11 06:49:36', '2025-11-11 06:49:36'),
('fc56f131-244e-4899-9cae-edb8e96d2468', 'ANAK STIS LOMPAT', 'anak-stis-lompat', 'LOMPAT', '<p>ANAK STIS LOMPAT</p>', 'articles/DGZqg6zOgvNaAgwaR71buej5GXX8Ei9ObV543mcn.png', 'strategi', '2fc45e87-17a5-4bf4-a694-9588478ff488', 'published', 1, 3, '[\"KEDINASAN. STIS\",\"FYP\"]', NULL, 'Kedinasan bagus', '2025-12-08 10:28:37', '2025-12-08 10:28:37', '2025-12-09 04:28:40', '2025-12-09 04:28:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bank_soal`
--

CREATE TABLE `bank_soal` (
  `id` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `tentor_id` char(36) NOT NULL,
  `nama_banksoal` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `mapel` varchar(255) NOT NULL,
  `file_banksoal` varchar(255) DEFAULT NULL,
  `tanggal_upload` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `faq`
--

CREATE TABLE `faq` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `author_id` char(36) NOT NULL,
  `pinned` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `faq`
--

INSERT INTO `faq` (`id`, `title`, `content`, `author_id`, `pinned`, `created_at`, `updated_at`) VALUES
(1, 'Bagaimana jika tidak bisa membayar menggunakan transfer bank ?', 'Baikk, untuk pembayaran bisa memilih transfer manual yaa teman teman \'-\'', '2fc45e87-17a5-4bf4-a694-9588478ff488', 0, '2025-11-15 11:36:09', '2025-11-15 11:36:09'),
(2, 'Bagaimana Mengakses Pembahasan Soal ?', 'Pembahasan soal dapat diakses ketika sudah mengerjakan tryoutnya&nbsp;', '2fc45e87-17a5-4bf4-a694-9588478ff488', 0, '2025-11-30 20:14:31', '2025-11-30 20:14:31'),
(3, 'Untuk mengakses pembayaran ?', 'cukup klik bagian paket lalu pilih metode pembayaran', '2fc45e87-17a5-4bf4-a694-9588478ff488', 0, '2025-12-08 09:50:10', '2025-12-08 09:50:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `formasi`
--

CREATE TABLE `formasi` (
  `kode` varchar(2) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `formasi`
--

INSERT INTO `formasi` (`kode`, `nama`) VALUES
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban`
--

CREATE TABLE `jawaban` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `soal_id` bigint(20) UNSIGNED NOT NULL,
  `jawaban` longtext NOT NULL,
  `point` smallint(6) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jawaban`
--

INSERT INTO `jawaban` (`id`, `soal_id`, `jawaban`, `point`, `created_at`, `updated_at`) VALUES
(1, 1, '3', 0, '2025-11-06 10:29:10', '2025-11-06 10:29:10'),
(2, 1, '20', 0, '2025-11-06 10:29:10', '2025-11-06 10:29:10'),
(3, 1, '14', 0, '2025-11-06 10:29:10', '2025-11-06 10:29:10'),
(4, 1, '15', 0, '2025-11-06 10:29:10', '2025-11-06 10:29:10'),
(5, 1, '12', 0, '2025-11-06 10:29:10', '2025-11-06 10:29:10'),
(6, 2, '<p style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\">Globalisasi</p>', 0, '2025-11-30 09:11:22', '2025-11-30 09:11:22'),
(7, 2, '<p style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\">Kesenjangan sosial</p>', 0, '2025-11-30 09:11:22', '2025-11-30 09:11:22'),
(8, 2, '<p style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\">Pendidikan yang kurang efektif</p>', 0, '2025-11-30 09:11:22', '2025-11-30 09:11:22'),
(9, 2, '<p style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\">Sumber daya manusia yang kurang</p>', 0, '2025-11-30 09:11:22', '2025-11-30 09:11:22'),
(10, 2, '<p style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\">Kurangnya dukungan dari pemerintah</p>', 0, '2025-11-30 09:11:22', '2025-11-30 09:11:22'),
(11, 3, '<p style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\">Menginspirasi pembuatan Pancasila sebagai dasar negara</p><p style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:49:22', '2025-12-04 02:49:22'),
(12, 3, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\">Mendorong pertumbuhan partai-partai politik di Indonesia</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:49:22', '2025-12-04 02:49:22'),
(13, 3, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\">Mendorong terbentuknya kesadaran kolektif untuk merdeka</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:49:22', '2025-12-04 02:49:22'),
(14, 3, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\">Mendorong penggunaan Bahasa Indonesia sebagai bahasa resmi</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:49:22', '2025-12-04 02:49:22'),
(15, 3, 'Menstimulasi pembentukan lembaga-lembaga pemerintahan setelah kemerdekaan', 0, '2025-12-04 02:49:22', '2025-12-04 02:49:22'),
(16, 4, '<p style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">UUD 1945 pasal 27 ayat 3</p><p style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:50:28', '2025-12-04 02:50:28'),
(17, 4, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">UUD 1945 pasal 30 ayat 3</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:50:28', '2025-12-04 02:50:28'),
(18, 4, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">UUD 1945 pasal 30 ayat 4</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:50:28', '2025-12-04 02:50:28'),
(19, 4, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">UU nomor 3 2002 pasal 9 ayat 1</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:50:28', '2025-12-04 02:50:28'),
(20, 4, 'UU nomor 3 2002 pasal 9 ayat 2', 0, '2025-12-04 02:50:28', '2025-12-04 02:50:28'),
(21, 5, '<p style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\">cinta tanah air</p><p style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:52:06', '2025-12-04 02:52:06'),
(22, 5, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\">kesadaran berbangsa dan bernegara</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:52:06', '2025-12-04 02:52:06'),
(23, 5, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\">rela berkorban</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:52:06', '2025-12-04 02:52:06'),
(24, 5, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\">memiliki kemampuan bela negara</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:52:06', '2025-12-04 02:52:06'),
(25, 5, 'memiliki kemampuan awal bela negara', 0, '2025-12-04 02:52:06', '2025-12-04 02:52:06'),
(26, 6, '1', 0, '2025-12-04 02:53:28', '2025-12-04 02:53:28'),
(27, 6, '2', 0, '2025-12-04 02:53:28', '2025-12-04 02:53:28'),
(28, 6, '3', 0, '2025-12-04 02:53:28', '2025-12-04 02:53:28'),
(29, 6, '4', 0, '2025-12-04 02:53:28', '2025-12-04 02:53:28'),
(30, 6, '5', 0, '2025-12-04 02:53:28', '2025-12-04 02:53:28'),
(31, 7, '<p style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\">UUD 1945 Pasal 2 ayat 1</p><p style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:54:28', '2025-12-04 02:54:28'),
(32, 7, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\">pembukaan UUD 1945 alinea ke 1</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:54:28', '2025-12-04 02:54:28'),
(33, 7, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\">pembukaan UUD 1945 alinea ke 4</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:54:28', '2025-12-04 02:54:28'),
(34, 7, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\">Pancasila sila ke-2</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:54:28', '2025-12-04 02:54:28'),
(35, 7, 'Pancasila sila ke-3', 0, '2025-12-04 02:54:28', '2025-12-04 02:54:28'),
(36, 8, '<p style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\">Indonesia sangat heterogen dan bentuk negara kesatuan bisa merangkul seluruh perbedaan tersebut sekaligus memastikan pengambilan kebijakan yang adil untuk setiap daerah, serta memperkecil risiko perpecahan karena otonomi yang berlebihan.</p><p style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:55:45', '2025-12-04 02:55:45'),
(37, 8, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\">Indonesia terdiri dari puluhan ribu pulau yang terbentang dari Sabang-Merauke dimana setiap pulaunya memiliki karakteristik tersendiri sehingga setiap wilayah perlu memiliki pemerintahan dan otonominya sendiri.</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:55:45', '2025-12-04 02:55:45'),
(38, 8, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\">Indonesia merupakan negara yang sangat heterogen dengan beragam suku, budaya, dan agama sehingga diperlukan adanya kekuasaan tunggal yang tidak dapat diganggu gugat.</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:55:45', '2025-12-04 02:55:45'),
(39, 8, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\">Indonesia harus bisa menyeimbangkan kepentingan nasional dan lokal, serta memberikan otonomi yang lebih besar bagi daerah.</p><p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; padding: 0px; border: 0px; vertical-align: baseline;\"><br></p>', 0, '2025-12-04 02:55:45', '2025-12-04 02:55:45'),
(40, 8, 'Indonesia pada masa itu baru merdeka dan para&nbsp;<span style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; border-style: initial; border-color: initial; border-image: initial;\">founding fathers</span>&nbsp;ingin mencegah lahirnya kelas&nbsp;<span style=\"font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; border-style: initial; border-color: initial; border-image: initial;\">borjuis</span>&nbsp;dari penjajahan dan kelas proletar dari pihak terjajah.', 0, '2025-12-04 02:55:45', '2025-12-04 02:55:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban_peserta`
--

CREATE TABLE `jawaban_peserta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pembelian_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ujian_user_id` char(36) DEFAULT NULL,
  `soal_id` bigint(20) UNSIGNED NOT NULL,
  `jawaban_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ragu_ragu` tinyint(1) DEFAULT 0,
  `poin` smallint(6) NOT NULL DEFAULT 0,
  `accessed_pembahasan_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jawaban_peserta`
--

INSERT INTO `jawaban_peserta` (`id`, `pembelian_id`, `ujian_user_id`, `soal_id`, `jawaban_id`, `ragu_ragu`, `poin`, `accessed_pembahasan_at`, `created_at`, `updated_at`) VALUES
(24, NULL, '9a394ca3-f42d-41c5-a669-1b790d6683c7', 2, 6, 0, 5, NULL, '2025-12-09 13:33:50', '2025-12-09 13:35:02'),
(25, NULL, '9a394ca3-f42d-41c5-a669-1b790d6683c7', 3, 15, 0, 0, NULL, '2025-12-09 13:33:50', '2025-12-09 13:35:17'),
(26, NULL, '9a394ca3-f42d-41c5-a669-1b790d6683c7', 4, 20, 0, 0, NULL, '2025-12-09 13:33:50', '2025-12-09 13:35:22'),
(27, NULL, '9a394ca3-f42d-41c5-a669-1b790d6683c7', 5, 25, 0, 0, NULL, '2025-12-09 13:33:50', '2025-12-09 13:35:26'),
(28, NULL, '9a394ca3-f42d-41c5-a669-1b790d6683c7', 6, 30, 0, 0, NULL, '2025-12-09 13:33:50', '2025-12-09 13:35:30'),
(29, NULL, '9a394ca3-f42d-41c5-a669-1b790d6683c7', 7, 35, 0, 0, NULL, '2025-12-09 13:33:50', '2025-12-09 13:35:34'),
(30, NULL, '9a394ca3-f42d-41c5-a669-1b790d6683c7', 8, 40, 0, 0, NULL, '2025-12-09 13:33:50', '2025-12-09 13:36:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `learning_progress`
--

CREATE TABLE `learning_progress` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `paket_id` char(36) DEFAULT NULL,
  `material_id` char(36) DEFAULT NULL,
  `ujian_id` char(36) DEFAULT NULL,
  `activity_type` enum('material_view','material_complete','tryout_attempt','tryout_complete') NOT NULL DEFAULT 'material_view',
  `duration_seconds` int(11) NOT NULL DEFAULT 0,
  `progress_percentage` int(11) NOT NULL DEFAULT 0,
  `score` decimal(5,2) DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `live_classes`
--

CREATE TABLE `live_classes` (
  `id` char(36) NOT NULL,
  `batch_id` char(36) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `tutor_id` char(36) NOT NULL,
  `meeting_link` varchar(255) DEFAULT NULL,
  `meeting_password` varchar(255) DEFAULT NULL,
  `platform` enum('zoom','google_meet','teams','other') NOT NULL DEFAULT 'zoom',
  `scheduled_at` datetime NOT NULL,
  `duration_minutes` int(11) NOT NULL DEFAULT 60,
  `max_participants` int(11) DEFAULT NULL,
  `status` enum('scheduled','ongoing','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  `materials` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `live_classes`
--

INSERT INTO `live_classes` (`id`, `batch_id`, `title`, `description`, `tutor_id`, `meeting_link`, `meeting_password`, `platform`, `scheduled_at`, `duration_minutes`, `max_participants`, `status`, `materials`, `created_at`, `updated_at`) VALUES
('5889f383-9444-4169-8a7b-3ff88b7c015f', '013eb629-4677-4ea1-8987-01ec420e2e0e', 'Kelas Pembukaan', 'pembukaan', '768dbaf2-9f04-4d5f-a03d-d41a94edfbf2', NULL, NULL, 'zoom', '2025-12-10 17:33:00', 60, 100, 'scheduled', '[null]', '2025-12-08 10:33:28', '2025-12-08 10:33:28'),
('9dc4946e-efda-4a29-bd37-d5e0f4d5e5a1', '013eb629-4677-4ea1-8987-01ec420e2e0e', 'Pembukaan matematika', NULL, 'b35c3d88-8fc3-4453-8d55-1004a47cd43d', NULL, NULL, 'zoom', '2025-12-10 20:45:00', 60, 100, 'scheduled', '[null]', '2025-12-09 13:45:54', '2025-12-09 13:45:54'),
('ca2a5273-01e1-4ecd-bb52-11f23581abda', '013eb629-4677-4ea1-8987-01ec420e2e0e', 'Matematika 1', 'matematika 1', 'b35c3d88-8fc3-4453-8d55-1004a47cd43d', 'https://us05web.zoom.us/j/84797149097?pwd=U0ch6YO8ebp230Rukz9GMtddgw9yNW.1', '888 888', 'zoom', '2025-11-18 16:14:00', 60, 100, 'scheduled', '[null]', '2025-11-17 09:14:18', '2025-11-17 09:14:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materials`
--

CREATE TABLE `materials` (
  `id` char(36) NOT NULL,
  `batch_id` char(36) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `mapel` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `tutor_id` char(36) NOT NULL,
  `type` enum('video','document','link','youtube') NOT NULL DEFAULT 'document',
  `file_path` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `external_link` varchar(255) DEFAULT NULL,
  `thumbnail_path` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `file_type` varchar(255) DEFAULT NULL,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `downloads_count` int(11) NOT NULL DEFAULT 0,
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `content` text DEFAULT NULL,
  `duration_seconds` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `materials`
--

INSERT INTO `materials` (`id`, `batch_id`, `title`, `mapel`, `description`, `tutor_id`, `type`, `file_path`, `youtube_url`, `external_link`, `thumbnail_path`, `file_size`, `file_type`, `views_count`, `downloads_count`, `is_public`, `is_featured`, `tags`, `content`, `duration_seconds`, `created_at`, `updated_at`) VALUES
('94c70ddc-d811-445e-8ce7-72bebaee2efd', '013eb629-4677-4ea1-8987-01ec420e2e0e', 'materi matematika', NULL, 'matematika', 'b35c3d88-8fc3-4453-8d55-1004a47cd43d', 'document', 'materials/1763370894_ChGOLuEda1.pdf', NULL, NULL, NULL, 302852, 'application/pdf', 3, 1, 0, 0, NULL, NULL, NULL, '2025-11-17 09:14:54', '2025-12-09 13:46:26'),
('a731610d-d900-462b-b991-69b6b6320d27', '013eb629-4677-4ea1-8987-01ec420e2e0e', 'mtk', 'mtk', NULL, '768dbaf2-9f04-4d5f-a03d-d41a94edfbf2', 'document', 'materials/1765190275_3ZBgsKpCC6.pdf', NULL, NULL, 'thumbnails/1765190275_thumb_tyyqkmoSiD.jpg', 651335, 'application/pdf', 3, 2, 1, 0, NULL, NULL, NULL, '2025-12-08 10:37:55', '2025-12-09 13:48:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_04_07_152137_create_permission_tables', 1),
(7, '2023_04_08_162328_create_ujian_table', 1),
(8, '2023_04_08_170037_rename_waktu_pengerjaan_to_lama_pengerjaan_table_ujian', 1),
(9, '2023_04_09_073245_add_jumlah_soal_to_table_ujian', 1),
(10, '2023_04_09_073915_create_soal_table', 1),
(11, '2023_04_09_151303_create_jawaban_table', 1),
(12, '2023_04_12_070302_add_is_published_to_tbl_ujian', 1),
(13, '2023_04_13_035037_create_pembelian_table', 1),
(14, '2023_04_13_150635_add_status_to_table_pembelian', 1),
(15, '2023_04_14_145647_add_jenis_pembayaran_to_table_pembelian', 1),
(16, '2023_04_16_104156_create_jawaban_peserta_table', 1),
(17, '2023_04_16_113315_add_soal_id_to_jawaban_peserta_table', 1),
(18, '2023_04_16_122014_create_status_pengerjaan_to_table_pembelian', 1),
(19, '2023_04_18_095955_add_ragu_ragu_to_jawaban_peserta_table', 1),
(20, '2023_04_19_144409_add_waktu_mulai_pengerjaan_to_pembelian_table', 1),
(21, '2023_04_27_085203_add_waktu_selesai_pengerjaan_to_pembelian_table', 1),
(22, '2023_05_23_201909_add_jenis_tryout_to_ujian_table', 1),
(23, '2023_05_24_063211_add_jenis_soal_to_soal_table', 1),
(24, '2023_05_24_071208_add_point_and_modify_jawaban_to_jawaban_table', 1),
(25, '2023_06_16_063842_create_sessions_table', 1),
(26, '2023_06_18_101245_delete_id_kunci_jawaban_in_soal_table', 1),
(27, '2024_01_18_081440_create_paket_ujian_table', 1),
(28, '2024_01_18_082036_create_paket_ujian_ujian_table', 1),
(29, '2024_01_21_152307_modify_ujian_table', 1),
(30, '2024_01_21_160131_delete_harga_in_ujian_table', 1),
(31, '2024_01_22_145816_add_poin_kosong_to_soal_table', 1),
(32, '2024_01_25_130218_add_nilai_benar_nilai_salah_to_soal_table', 1),
(33, '2024_01_28_071029_create_voucher_table', 1),
(34, '2024_01_28_152949_change_ujian_id_to_paket_id_in_pembelian_table', 1),
(35, '2024_01_30_115234_modify_pembelian_table', 1),
(36, '2024_01_30_123428_add_harga_to_pembelian_table', 1),
(37, '2024_01_30_163359_create_ujian_user_table', 1),
(38, '2024_02_01_142814_add_poin_to_jawaban_peserta_table', 1),
(39, '2024_02_01_170437_add_is_first_to_ujian_user_table', 1),
(40, '2024_02_01_185404_add_pembahasan_to_soal_table', 1),
(41, '2024_02_02_142046_add_google_id_to_users_table', 1),
(42, '2024_02_02_173939_create_users_detail_table', 1),
(43, '2024_02_02_211442_add_status_users_to_users_table', 1),
(44, '2024_03_25_054646_add_nama_kelompok_bius_to_pembelian_table', 1),
(45, '2024_03_25_070348_add_nama_kelompok_to_users_detail_table', 1),
(46, '2024_04_19_082120_create_pengumuman_table', 1),
(47, '2024_05_01_195802_create_faq_table', 1),
(48, '2024_05_02_170848_add_pinned_to_faq_table', 1),
(49, '2024_12_14_100000_create_live_classes_table', 1),
(50, '2024_12_14_110000_create_materials_table', 1),
(51, '2024_12_14_120000_add_batch_id_and_mapel_to_live_classes_and_materials', 1),
(52, '2024_12_15_100000_create_bank_soal_table', 1),
(53, '2025_01_18_000001_create_articles_table', 1),
(54, '2025_01_18_000002_create_learning_progress_table', 1),
(55, '2025_03_11_001039_create_formasi_table', 1),
(56, '2025_03_11_001039_create_prodi_table', 1),
(57, '2025_03_11_001040_create_wilayah_table', 1),
(58, '2025_10_18_001400_add_missing_columns_to_ujian_table', 1),
(59, '2025_10_19_000000_add_whatsapp_group_link_to_paket_ujian_table', 1),
(60, '2025_11_06_041320_add_is_featured_to_paket_ujian_table', 1),
(64, '2025_11_06_044100_add_ujian_user_id_to_jawaban_peserta_table', 2),
(65, '2025_11_06_044200_make_pembelian_id_nullable_in_jawaban_peserta', 2),
(69, '2025_11_06_044626_add_manual_payment_fields_to_pembelian_table', 3),
(70, '2025_11_07_000001_create_articles_table', 4),
(71, '2025_11_07_add_accessed_pembahasan_at_to_jawaban_peserta_table', 4),
(72, '2025_11_07_add_allow_pembahasan_during_test_to_ujian_table', 4),
(73, '2025_11_10_102336_add_paket_ujian_id_to_voucher_table', 5),
(74, '2025_11_12_111928_create_notifications_table', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', '2fc45e87-17a5-4bf4-a694-9588478ff488'),
(3, 'App\\Models\\User', '263cd021-6caf-4cbd-9dba-a7e5ff1e63a8'),
(3, 'App\\Models\\User', '768dbaf2-9f04-4d5f-a03d-d41a94edfbf2'),
(3, 'App\\Models\\User', '9254b961-6eff-4245-9cc5-844ad0436c99'),
(3, 'App\\Models\\User', 'b35c3d88-8fc3-4453-8d55-1004a47cd43d'),
(5, 'App\\Models\\User', '0556d0f7-ef9b-4933-a990-ec02058d4403'),
(5, 'App\\Models\\User', '2006584a-6951-406f-af25-a6405463b276'),
(5, 'App\\Models\\User', '42493610-d74a-4f95-bdc8-1b8ba310a0d3'),
(5, 'App\\Models\\User', '663ff84d-3ae7-4025-9f4d-d45cc2e07692'),
(5, 'App\\Models\\User', 'cec07405-3726-4c33-a50e-481b03e8cb8b'),
(5, 'App\\Models\\User', 'eaff20c5-aeb2-478d-ae96-0f6f04b1b044');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket_ujian`
--

CREATE TABLE `paket_ujian` (
  `id` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(10) UNSIGNED NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_akhir` datetime NOT NULL,
  `whatsapp_group_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `paket_ujian`
--

INSERT INTO `paket_ujian` (`id`, `nama`, `deskripsi`, `harga`, `waktu_mulai`, `waktu_akhir`, `whatsapp_group_link`, `created_at`, `updated_at`) VALUES
('013eb629-4677-4ea1-8987-01ec420e2e0e', 'MATEMATIKA', NULL, 10000, '2025-12-09 17:27:00', '2025-12-11 17:27:00', 'https://chat.whatsapp.com/DPbaVSPWfH4FW36gyYg64i?mode=wwt', '2025-11-06 10:27:37', '2025-12-09 13:28:48'),
('1d110009-94e7-4293-bc09-c1633981a647', 'test', '<p>test</p>', 10000, '2025-12-07 15:14:00', '2025-12-10 15:14:00', '-', '2025-11-10 08:14:00', '2025-12-08 10:46:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket_ujian_ujian`
--

CREATE TABLE `paket_ujian_ujian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paket_ujian_id` char(36) NOT NULL,
  `ujian_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `paket_ujian_ujian`
--

INSERT INTO `paket_ujian_ujian` (`id`, `paket_ujian_id`, `ujian_id`) VALUES
(1, '013eb629-4677-4ea1-8987-01ec420e2e0e', '85a7ed92-3027-45fd-ac0f-a39d0eabe81a'),
(2, '1d110009-94e7-4293-bc09-c1633981a647', 'a91313ad-0f8b-42c5-9d02-1209052b4967');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('sintai55reborn2@gmail.com', '$2y$10$Tu9gk3qw1fOCnOi8X3Fc2.6Ezqd1fxFEyimwtZFfDtpTpZoorcK8W', '2025-11-13 07:22:58'),
('sintaistore55reborn@gmail.com', '$2y$10$sfN8MyGwwY86h0uaYIDXiOTgrPjnqkv2a0V5KzWWTVxP/5GCH5Vby', '2025-11-14 14:11:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paket_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `kode_pembelian` char(36) DEFAULT NULL,
  `batas_pembayaran` datetime DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `harga` int(10) UNSIGNED NOT NULL,
  `jenis_pembayaran` varchar(50) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `catatan_pembayaran` text DEFAULT NULL,
  `status_verifikasi` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `catatan_admin` text DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `verified_by` char(36) DEFAULT NULL,
  `whatsapp_admin` varchar(255) DEFAULT NULL,
  `id_voucher` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_kelompok` varchar(255) DEFAULT NULL,
  `status_pengerjaan` varchar(30) DEFAULT 'Belum Dikerjakan',
  `waktu_mulai_pengerjaan` datetime DEFAULT NULL,
  `waktu_selesai_pengerjaan` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`id`, `paket_id`, `user_id`, `kode_pembelian`, `batas_pembayaran`, `status`, `harga`, `jenis_pembayaran`, `bukti_transfer`, `catatan_pembayaran`, `status_verifikasi`, `catatan_admin`, `verified_at`, `verified_by`, `whatsapp_admin`, `id_voucher`, `nama_kelompok`, `status_pengerjaan`, `waktu_mulai_pengerjaan`, `waktu_selesai_pengerjaan`, `created_at`, `updated_at`) VALUES
(20, '013eb629-4677-4ea1-8987-01ec420e2e0e', 'cec07405-3726-4c33-a50e-481b03e8cb8b', 'ca0061da-38d7-4881-8099-77a4fa35558e', NULL, 'Sukses', 10000, 'Transfer Manual', 'bukti_20_1765288063.png', NULL, 'verified', NULL, '2025-12-09 13:48:20', '2fc45e87-17a5-4bf4-a694-9588478ff488', '6282175155963', NULL, NULL, 'Belum Dikerjakan', NULL, NULL, '2025-12-09 07:32:49', '2025-12-09 13:48:20'),
(21, '1d110009-94e7-4293-bc09-c1633981a647', '42493610-d74a-4f95-bdc8-1b8ba310a0d3', NULL, NULL, 'Sukses', 10000, 'Transfer Manual', 'bukti_21_1765282199.png', NULL, 'verified', NULL, '2025-12-09 13:14:40', '2fc45e87-17a5-4bf4-a694-9588478ff488', '6282175155963', NULL, NULL, 'Belum Dikerjakan', NULL, NULL, '2025-12-09 12:08:14', '2025-12-09 13:14:40'),
(23, '1d110009-94e7-4293-bc09-c1633981a647', '0556d0f7-ef9b-4933-a990-ec02058d4403', NULL, NULL, 'Belum dibayar', 10000, NULL, NULL, NULL, 'pending', NULL, NULL, NULL, NULL, NULL, NULL, 'Belum Dikerjakan', NULL, NULL, '2025-12-09 13:14:53', '2025-12-09 13:14:53'),
(24, '1d110009-94e7-4293-bc09-c1633981a647', '663ff84d-3ae7-4025-9f4d-d45cc2e07692', '76a19460-82c4-4c53-b654-0ba06b104f01', NULL, 'Sukses', 10000, 'Transfer Manual', 'bukti_24_1765286667.png', NULL, 'verified', NULL, '2025-12-09 13:24:49', '2fc45e87-17a5-4bf4-a694-9588478ff488', '6282175155963', NULL, NULL, 'Belum Dikerjakan', NULL, NULL, '2025-12-09 13:21:47', '2025-12-09 13:24:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view ujian', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(2, 'create ujian', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(3, 'update ujian', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(4, 'delete ujian', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(5, 'manage users', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(6, 'manage roles', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(7, 'manage permissions', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(8, 'view dashboard', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(9, 'create live class', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(10, 'update live class', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(11, 'delete live class', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(12, 'manage materials', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(13, 'create material', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(14, 'update material', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(15, 'delete material', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(16, 'embed youtube videos', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(17, 'view tutor dashboard', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `prodi`
--

CREATE TABLE `prodi` (
  `kode` tinyint(4) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `prodi`
--

INSERT INTO `prodi` (`kode`, `nama`) VALUES
(1, 'D3 Statistika'),
(2, 'D4 Statistika Terapan'),
(3, 'D4 Komputasi Statistik'),
(4, 'Lainnya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(2, 'bendahara', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(3, 'tutor', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(4, 'panitia', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
(5, 'user', 'web', '2025-11-06 01:41:28', '2025-11-06 01:41:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(8, 2),
(9, 1),
(9, 3),
(10, 1),
(10, 3),
(11, 1),
(11, 3),
(12, 1),
(12, 3),
(13, 1),
(13, 3),
(14, 1),
(14, 3),
(15, 1),
(15, 3),
(16, 1),
(16, 3),
(17, 1),
(17, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0MLSOrmcqOORhjwzepWsBKtGM7P1PNSLTIDxL1qh', NULL, '182.253.55.105', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRHpMY1lTVmNielNZVWpQVXZhMHFxSkh3OXVMQzk4SjNmSHZiVm1SMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vd3d3LmRpbmFzc29sdXRpb24uY29tL3JlZ2lzdGVyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMDoiaHR0cHM6Ly93d3cuZGluYXNzb2x1dGlvbi5jb20vIjt9fQ==', 1765286314),
('0SF5QE1NSRiKHdDKOcWNI0yR4CaxAsixnCRY1MGy', NULL, '45.38.245.246', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0t6NEtoaWJEUWV3bk5JYUhGcnRQMjZEVVJmajlIQ2lxU2dxU1h5WSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765288054),
('2dJmCpUw5o3IYOFWELIpVF8zKnLHcfMlkWQJRV4Z', NULL, '110.138.87.235', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibGZ0SWtsQ3pXVGgwSW91bEdTWkdHd01BWDRkZzhQQUt1NHFIV0xYbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODY6Imh0dHA6Ly93d3cuZGluYXNzb2x1dGlvbi5jb20vYXJ0aWNsZXMvbWFzdWtrLXN0aXNzLWdhamktZHVhLWRpZ2l0LWNlay1mYWt0YW55YWEtZGlzaW5pIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765282929),
('2n25a4O3uFergm71lVTEySHOmGysVi0EBGvD6P02', NULL, '36.92.231.70', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibEVERldUMlBGVmVoTzhCNU8xUFNORjdDd3Voc3RKNXZqaWtYVzlHRiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMzoiaHR0cHM6Ly9kaW5hc3NvbHV0aW9uLmNvbS9wcm9maWxlIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765283498),
('46q6PZuyUOHt4JxRUIncmpKMupfzubxPM92OgVrR', NULL, '103.22.242.4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUFNDVzRMWG9VM1djT3NYWWM1bVNtTXhSZ2VDQXNjVjE0QlI2Tk5mMiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cHM6Ly9kaW5hc3NvbHV0aW9uLmNvbS9saXZlLXpvb20iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMToiaHR0cHM6Ly9kaW5hc3NvbHV0aW9uLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765283342),
('4Ym7xej8tvOpwQETxcOrSvFmYs6EyYIo17D9qNfn', NULL, '36.50.157.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN3BxenlmamxJZVh4dG0xeTR0YlFrNnZBTzJUcFpDOXRFekVFVEpQQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vcmVnaXN0ZXIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765282077),
('6S7kD87vBiAPeKGKvPDg1T2WgT3DgJCw4mfk34Yi', 'baa9159c-b756-499c-b96a-c5d22ba642ae', '180.252.167.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiTDJVZjJoMjF4b21YVjJacnIzcmlkODJSNzhmV1NCUEVhUHZ5bm1TNSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMzOiJodHRwczovL2RpbmFzc29sdXRpb24uY29tL3Byb2ZpbGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozNjoiYmFhOTE1OWMtYjc1Ni00OTljLWI5NmEtYzVkMjJiYTY0MmFlIjtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMCRoZ1d3UFppYXYwSzNnaS5qby9sRmUuS2NGbFppLnQ4MVFhaXZ6Z3BpTHU1d1E4a3VyWDM3cSI7fQ==', 1765283955),
('7E2SesPOZbF8YTCp9grYtH03ous1GiZihTMek9mT', '42493610-d74a-4f95-bdc8-1b8ba310a0d3', '110.138.87.235', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSjdZSFdkYTRLdGZsNzBMYk83dnAyUG5Fc3N5T09UUlZqdE9UQUgyZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzU6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vdHJ5b3V0L2E5MTMxM2FkLTBmOGItNDJjNS05ZDAyLTEyMDkwNTJiNDk2Ny9uaWxhaSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjM2OiI0MjQ5MzYxMC1kNzRhLTRmOTUtYmRjOC0xYjhiYTMxMGEwZDMiO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJHNDRlNnUkVhM3AwVktFOHNONjJBVGU4SVVLWTVKczd2blE5eXBjbk4xL29wcmg3RHByeFEyIjt9', 1765288262),
('AKRDcSs08xAG39vIGS2KgLXSxTPyvb6PQkjYRz23', '2fc45e87-17a5-4bf4-a694-9588478ff488', '180.252.167.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib3FxdEN3Tk1VYmxWQzVWbkw5V2xicnMxa2JSWmZzY3pkY2o3TkZPbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vYWRtaW4vdXNlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjM2OiIyZmM0NWU4Ny0xN2E1LTRiZjQtYTY5NC05NTg4NDc4ZmY0ODgiO30=', 1765289089),
('DBpR0wjJNtUGUYHCH4QnlMYfu9WdGSxdkb30PjEo', NULL, '103.26.211.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMFp2TXpNRkk2U1ZZc1VDdlNRT29rdlJvYmpublpiNUpFZXdDMXl0eiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cHM6Ly9kaW5hc3NvbHV0aW9uLmNvbS9hZG1pbi9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMToiaHR0cHM6Ly9kaW5hc3NvbHV0aW9uLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765283589),
('EGTQnnD2ZnZ011t9MRZZ3t0ZI7dhX4onwXzCHDPA', NULL, '103.154.140.86', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidm1qVVhhUmZodnA0MHRPWU10SHA0d1hBbFVCZEVLMVRWcnQwY0FPeiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vbG9naW4iO319', 1765286060),
('eoLeB9MS4gHvj4PKM1TAkdQqPJPRBWxzdCvdwvA7', NULL, '36.92.231.68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSUQ5YXlCQWZvaUtleEp6YW9SN3Bka1haekhoeHlxWWx2MHhNNkZ6MiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NToiaHR0cHM6Ly9kaW5hc3NvbHV0aW9uLmNvbS9hZG1pbi9wZXNlcnRhX3VqaWFuIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765284976),
('EWz57cpeFbkVyKR0NWSxGx3tQKJXBAXrWrtW8Sav', NULL, '17.241.219.111', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15 (Applebot/0.1; +http://www.apple.com/go/applebot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGtlTjRXcW9kRlg4UFBxUTFTN21LcVBSZWR3M1owbVlobzRURHNpaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly93d3cuZGluYXNzb2x1dGlvbi5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765283026),
('fdIwmr3NYkLYgjzFqPYdqqY3Odtdq4UbuRZzildY', NULL, '202.43.172.4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicjdTdHd3MmFTUVUwb0doREwxQ2M4Mm5HRHNLTjBZZnFGbFNOTHpTZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODc6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vc3RvcmFnZS9hcnRpY2xlcy80UGVmV2NkSjBIVlllM2xLUXp2T0t0dVlCUDFuOHVLcGRwM2pFM2V2LmpwZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765283253),
('fevwsouFpQEu74uRSAPntUCfspw8vbgESxB6Vu3M', NULL, '17.241.219.254', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15 (Applebot/0.1; +http://www.apple.com/go/applebot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUjVFcWVvOHpRTzhFeW9YWWUzRlZkelpINHVNUWZFc0RlV3RpdXJnSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9kaW5hc3NvbHV0aW9uLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765282737),
('gSRvdFMI6bworSsFHP90vfe3n5czgE1bVeAt9FMj', '663ff84d-3ae7-4025-9f4d-d45cc2e07692', '110.138.87.186', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSnNtTmxSU1RpQUVBWDEzRXdJejM0QnlXUzFZeWRCZGRuY3NOSFlhVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozNjoiNjYzZmY4NGQtM2FlNy00MDI1LTlmNGQtZDQ1Y2MyZTA3NjkyIjt9', 1765289502),
('h9gyporL9asMhqoWfvFoM6kA37iKE7GW7aFu2Eos', NULL, '91.99.127.48', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZTFNVzRGblhubWNKV1VqeGVwNkNhYUtJYU1UbXNnZ0J2N3RLcHRMUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765291053),
('HEQiLCUXpq2ID6l9GZwcVrWHvUBStdKpQF768yGS', NULL, '110.138.87.235', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieHRyRlIydjdUT0ZxVEJrYXZxenNkZmRFQkpCbXhwVUJLVFJIbkRrWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTE6Imh0dHBzOi8vd3d3LmRpbmFzc29sdXRpb24uY29tL3N0b3JhZ2UvYXJ0aWNsZXMvNFBlZldjZEowSFZZZTNsS1F6dk9LdHVZQlAxbjh1S3BkcDNqRTNldi5qcGciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765282932),
('IEyWOMALQ5cgZjcdyjmYLp5vxQkaO5FK7eHsQ2ss', NULL, '103.189.123.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ2JLY3ZqQ0ttaVZtT0xkekZoSWlnUm1vTVJzSGtTcEtwU0pDaHl3OCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODc6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vc3RvcmFnZS9hcnRpY2xlcy80UGVmV2NkSjBIVlllM2xLUXp2T0t0dVlCUDFuOHVLcGRwM2pFM2V2LmpwZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765283672),
('IMfjKZYZSpNvIuLezzdpWMr7kNx0U5RMPwvJongA', NULL, '36.71.220.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFFETnREYW55MWJsRWd5WjBCcUNIUGc3OGN1OEhNRzNoMVVJOEZWVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6ODc6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vc3RvcmFnZS9hcnRpY2xlcy80UGVmV2NkSjBIVlllM2xLUXp2T0t0dVlCUDFuOHVLcGRwM2pFM2V2LmpwZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765285572),
('JLQn8CxWjmc9fnmY3eRt950EE76oP829VKnWqWWb', NULL, '110.138.87.235', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRkhJekpTV0lXNkpwbzlzb25MRHI5SGVieG5oMm5DaWI0Q0hIdEN5aSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTY6Imh0dHBzOi8vd3d3LmRpbmFzc29sdXRpb24uY29tL2FydGljbGVzP2NhdGVnb3J5PXN0cmF0ZWdpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765282946),
('K7yUi3R6ILGYuXxR4r98bEljBWZRH3zoUVPyiKIE', NULL, '5.39.109.166', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMGVtSElGTVpNakVPWXRmb25DV0pOQ0ZwbTlFamZVdzdoeGtWSHNmZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9kaW5hc3NvbHV0aW9uLmNvbS9hcnRpY2xlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765286093),
('K9MezmTXX57ct4QiQnIqCWELHDvJoyNlbUV7c3RZ', NULL, '103.154.140.86', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUnk4aFluQ0NTZzhvOUVWdWtJSmxnWGFJM3YyVjFiczFPUjhaTXFYZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vYXV0aC9nb29nbGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU6InN0YXRlIjtzOjQwOiJHTEVFbXRvMnBzekFNbXZHS0h2bHB0azVPRjlBb1laVU9ZNTR5TG1nIjt9', 1765286122),
('KY5NrI5LUNU4Se6yj3N1Z2gGooKzOtZES2BlANyc', NULL, '17.246.23.170', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15 (Applebot/0.1; +http://www.apple.com/go/applebot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHBHY2VLOTVDRUw5NWJOdVNFT0ExRFZPV3c4aHZPUGZIbk9jQjZsSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765282823),
('NPpTkgp6PHsB2TnyYF20BESgaeTpeQxbub9IFyFz', NULL, '135.181.116.37', 'MetaInspector/5.16.0 (+https://github.com/jaimeiniesta/metainspector)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRG9Cem45dERYcWZFdkxHMUo0SkMzd1JIcFJ2dlNMVmpPcXpYdUpvcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765282672),
('nTKI9fTav4rU81XE2cqey2teRZeXgoFN8SKOJVyx', NULL, '162.120.184.229', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZE55WmlJZVpYajBqcGpKNTVKbDh1MFZ0WUZPWGhLS2p4V0R1R1lpMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vd3d3LmRpbmFzc29sdXRpb24uY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765285406),
('o1liwMDghw3wQgQJ3QOGg0BtYYQlCmOJOs1i81U7', NULL, '192.241.92.41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.3', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY1NoSFd2cElJRE5tTGUwam9LY3k1TXFvMVdZeGFmWDdJUjVPR2x2WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765282947),
('pMqO78UGjA0XWfb2NSUuSeiDRJGrtdvzE376A1aD', NULL, '155.133.7.191', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmI3WVF6anJWc29HMG56Wkd5aGhETkpwM2hKVXpuZlBRbWdyOTR1SSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765286557),
('PxSqBRfdJKSnDFTw9WSXk86cymGLFTlyR2wtxKIf', NULL, '125.166.78.90', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS2NyY3JFRUlKWG52OXo5R2psUDU5ZDYxYnlub1YxeHpMUU9kRnVYRiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vbG9naW4iO319', 1765288091),
('pZjtH3W9M7sOZbq5cOQfJijU4nJ0Vu2kGxtOaMzj', NULL, '203.78.114.31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNldiaG9tWG5CNHRDRGpQckd6eWoyMWdaM0k3UjdIWHE2ZnByTk9PRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vd3d3LmRpbmFzc29sdXRpb24uY29tL2F1dGgvZ29vZ2xlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMDoiaHR0cHM6Ly93d3cuZGluYXNzb2x1dGlvbi5jb20vIjt9czo1OiJzdGF0ZSI7czo0MDoiekRuSkEyek1OeFhqZXRUVlVjM2ljTUVNYmFKSUROMVZtUG8zcXFlYyI7fQ==', 1765286029),
('qoZB7m4pIRKeCWFqTVOAJBoFtPnPTatld3Gz5BmE', NULL, '38.43.64.53', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSVZIUE9LQ1V0bFRwVzBGRGFWQWhEZldKZ2dNd04xR3VrMEF2VVdvYSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMTA6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vZW1haWwvdmVyaWZ5L2JhYTkxNTljLWI3NTYtNDk5Yy1iOTZhLWM1ZDIyYmE2NDJhZS81YWM3YjM0OWQyMmMyNzAwNjc0YmE1OGZhYzRmMmFhMzRmYTBkZjBmP2V4cGlyZXM9MTc2NTI4NjcxMyZzaWduYXR1cmU9YWRlODJhZDFlNDk3ZmM0ZjZiM2E5Yjk4NTg5NDc5YzE0ZTIzM2RlNmYxMDRhNmJiZTBmMTY0MjdjNGM3ZTUwYSI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwczovL2RpbmFzc29sdXRpb24uY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765290323),
('qPOOsM2AIeRmrePkwcgXHoBjR2WvNK0DwVt40Xcu', NULL, '103.189.123.6', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN3FPdDBYdHlIemgxSDNNUmk2V2FyMjUyaTdUSkJEV1YzU21YQmtacyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNjoiaHR0cHM6Ly9kaW5hc3NvbHV0aW9uLmNvbS9hZG1pbi91c2VyIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765283604),
('qwtMItDq0hDGVTmfSja9owueM4J7B0RVENoNd7Fp', '663ff84d-3ae7-4025-9f4d-d45cc2e07692', '180.252.167.243', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo2OntzOjM6InVybCI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vcHJvZ3Jlcy1uaWxhaSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NjoiX3Rva2VuIjtzOjQwOiJkUGd6NFo0UklIUGFLTFV1QW40RXQ5T28wclNzb21OMXdXV2RpSXh3IjtzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozNjoiNjYzZmY4NGQtM2FlNy00MDI1LTlmNGQtZDQ1Y2MyZTA3NjkyIjtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMCQyS3VrZm5FNTVDbG0vdVpQNHlTRjRlNlRleHFUTm9hZ2x6NG13WXFIVEpZb1JKMjA2OS9hcSI7fQ==', 1765287649),
('RVZAQ9OPtdzjldKfh71siIQqVAKsdpNVFMZql2lR', NULL, '103.189.123.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTU1xTlo4cUtEdldhbUlxNnVYdUc1Q3VvODRSVHdwcEZOU3pIQ3NNWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vZmFxIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765283296),
('SOk14SQvOrm9zhqRFfZWSlESVTAfq3eOHqvkfThb', NULL, '5.39.1.249', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOXZ5ajU0UEFvUUZWZnFHZkJhakNTWFQzSVlWQlAzNXc2WlNha2Z6YyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly9kaW5hc3NvbHV0aW9uLmNvbS9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765282597),
('tDGhVljAgFpPNgdxXlDMo1sktIgJsFp5aRnomwul', '0556d0f7-ef9b-4933-a990-ec02058d4403', '203.78.114.31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNjNKN3ZHS0d3dWRkTE5tTnRFZFBRNW5rQ2NDTGgyN01xRVJGUDMwNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vcHJvZmlsZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjM2OiIwNTU2ZDBmNy1lZjliLTQ5MzMtYTk5MC1lYzAyMDU4ZDQ0MDMiO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJFhYbFc2Zm1FdWo3aTBTUm0ubmlKYXVDTERpVkRyYWMvNEZEampVQ3QxV0FRU2c0OEpkTzVtIjt9', 1765286121),
('uFWHBeMvy8c6JVYSGFMuxlaBLAzlLlmFaXJpCmMh', NULL, '117.103.171.5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWEVPS3NGdkN2V3R1RmVtZ2JrRVlmalhjMFFIeVI1TGYxc0tzcDM2ayI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMTA6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vZW1haWwvdmVyaWZ5L2JhYTkxNTljLWI3NTYtNDk5Yy1iOTZhLWM1ZDIyYmE2NDJhZS81YWM3YjM0OWQyMmMyNzAwNjc0YmE1OGZhYzRmMmFhMzRmYTBkZjBmP2V4cGlyZXM9MTc2NTI4NjcxMyZzaWduYXR1cmU9YWRlODJhZDFlNDk3ZmM0ZjZiM2E5Yjk4NTg5NDc5YzE0ZTIzM2RlNmYxMDRhNmJiZTBmMTY0MjdjNGM3ZTUwYSI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwczovL2RpbmFzc29sdXRpb24uY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765286015),
('v09Cu5YqUSZ1fvj0tggrGMGrzhSBBZ8OTbpbTDHc', NULL, '202.43.172.4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.7339.214 Spotify/1.2.77.358 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR3hRUXQzT2hLRGNrWVpyNmRRWlB6d2NQblo4TktmazdtaGZvUkZKTyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cHM6Ly9kaW5hc3NvbHV0aW9uLmNvbS9tYXRlcmlhbHMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMToiaHR0cHM6Ly9kaW5hc3NvbHV0aW9uLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765283830),
('veKLVSDhgOlyjEcIPM69VP9vUrVTlVNzbMXWdrhc', '2fc45e87-17a5-4bf4-a694-9588478ff488', '110.138.87.235', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSFhVUm9tZmY2dUxNbDNjY0U0cnkwaUZxYjQyWGlaM1EyWkFTbnY4ciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vYWRtaW4vcGVtYmVsaWFuL3ZlcmlmaWthc2kiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozNjoiMmZjNDVlODctMTdhNS00YmY0LWE2OTQtOTU4ODQ3OGZmNDg4Ijt9', 1765290887),
('vjnyOyvHqJvQtRE4V1yOa5v3PxzSm9Xf26fcdWu8', '2fc45e87-17a5-4bf4-a694-9588478ff488', '36.71.220.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWGNSNk1TdUl0VnFJZk0wSUFabVVzQ1RVMEllMU1JaWpLVHJSZmJCNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vYWRtaW4vcGVtYmVsaWFuL3ZlcmlmaWthc2kiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozNjoiMmZjNDVlODctMTdhNS00YmY0LWE2OTQtOTU4ODQ3OGZmNDg4Ijt9', 1765291627),
('wACoIe3pO6ZTXPF8sNESqJlKBZtYbik4NYLnkQEK', NULL, '157.55.39.12', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTjhlRUdiTFpGNG03N3FjR1p6THdIY01KYWhFUDlqcGNPcVBXckttbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765285739),
('wr0ucOMszef3mYCi8C1IDQSYney3yvkvp6GDCKfE', NULL, '5.104.81.235', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQkRDTDV2U1RMODlYUm5CcUtMSERERTV3MnBCU0Rnb1NHRjdUUTNXciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765282936),
('xtAIRW8jjzo73s517pDb9lZWdfSvQ1zELW3iLvSG', NULL, '5.104.85.58', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSWhOZEp1R0tPYzR6ZU02YzhrVE1qNmxwYllHaXlhSmU0QmdRY3lPWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjU6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765290129),
('YipYZAG9mCQLVpvKAmRRviMjdJam6JRGcaaJeCGB', NULL, '103.26.211.4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTk9pNEtlSnBXeGY1Z3JwWVdmMW11b3d3SU42WlRpSmNZNnpmeDRteCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMTA6Imh0dHBzOi8vZGluYXNzb2x1dGlvbi5jb20vZW1haWwvdmVyaWZ5L2JhYTkxNTljLWI3NTYtNDk5Yy1iOTZhLWM1ZDIyYmE2NDJhZS81YWM3YjM0OWQyMmMyNzAwNjc0YmE1OGZhYzRmMmFhMzRmYTBkZjBmP2V4cGlyZXM9MTc2NTI4NjcxMyZzaWduYXR1cmU9YWRlODJhZDFlNDk3ZmM0ZjZiM2E5Yjk4NTg5NDc5YzE0ZTIzM2RlNmYxMDRhNmJiZTBmMTY0MjdjNGM3ZTUwYSI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwczovL2RpbmFzc29sdXRpb24uY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765284464),
('ywl4FRifzsjhMD3rF8CUna8Vz7qLOFeqavVHsO9X', NULL, '103.189.123.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDVtazA2eVl2Zm1jU1RJeUpiYkpIMml4TzdENzhDdjVITmJtZEZabiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9kaW5hc3NvbHV0aW9uLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765283662),
('ZV2w58dheDXf1wixXVDae8vuvyEPqUMMLVKASOnq', NULL, '17.246.19.55', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.4 Safari/605.1.15 (Applebot/0.1; +http://www.apple.com/go/applebot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU25CUVlPWERHU3IyeklVQ0NDdzhNbFRkRkZKZE5uNzEzN3pBYnRqcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vd3d3LmRpbmFzc29sdXRpb24uY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765282223),
('ZWdTewxdZVUafyYTLi8ksMln9bvMMBlfXSKhlCXP', NULL, '103.189.123.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSFZLQ1lQUkpPSWNWMndwZ3VodE5QZkd3a2VtWmN4cVZTYUZWbksxQyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cHM6Ly9kaW5hc3NvbHV0aW9uLmNvbS9hZG1pbi9wZW1iZWxpYW4iO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMToiaHR0cHM6Ly9kaW5hc3NvbHV0aW9uLmNvbS9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765283881);

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal`
--

CREATE TABLE `soal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ujian_id` char(36) NOT NULL,
  `soal` text NOT NULL,
  `jenis_soal` varchar(10) DEFAULT NULL,
  `kunci_jawaban` bigint(20) UNSIGNED DEFAULT NULL,
  `poin_benar` smallint(6) NOT NULL DEFAULT 0,
  `poin_salah` smallint(6) NOT NULL DEFAULT 0,
  `poin_kosong` smallint(6) NOT NULL DEFAULT 0,
  `pembahasan` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `soal`
--

INSERT INTO `soal` (`id`, `ujian_id`, `soal`, `jenis_soal`, `kunci_jawaban`, `poin_benar`, `poin_salah`, `poin_kosong`, `pembahasan`, `created_at`, `updated_at`) VALUES
(1, '85a7ed92-3027-45fd-ac0f-a39d0eabe81a', '<p class=\"MsoNormal\"><!--[if gte msEquation 12]><m:oMathPara><m:oMath><i\r\n  style=\'mso-bidi-font-style:normal\'><span style=\'font-family:\"Cambria Math\",serif\'><m:r>∫2</m:r><m:r>x</m:r><m:r>+2</m:r></span></i></m:oMath></m:oMathPara><![endif]--><!--[if !msEquation]--><span style=\"font-size:12.0pt;line-height:115%;font-family:&quot;Calibri&quot;,sans-serif;\r\nmso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:\r\nminor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:&quot;Times New Roman&quot;;\r\nmso-bidi-theme-font:minor-bidi;mso-ansi-language:EN-ID;mso-fareast-language:\r\nEN-US;mso-bidi-language:AR-SA\"><!--[if gte vml 1]><v:shapetype id=\"_x0000_t75\"\r\n coordsize=\"21600,21600\" o:spt=\"75\" o:preferrelative=\"t\" path=\"m@4@5l@4@11@9@11@9@5xe\"\r\n filled=\"f\" stroked=\"f\">\r\n <v:stroke joinstyle=\"miter\"/>\r\n <v:formulas>\r\n  <v:f eqn=\"if lineDrawn pixelLineWidth 0\"/>\r\n  <v:f eqn=\"sum @0 1 0\"/>\r\n  <v:f eqn=\"sum 0 0 @1\"/>\r\n  <v:f eqn=\"prod @2 1 2\"/>\r\n  <v:f eqn=\"prod @3 21600 pixelWidth\"/>\r\n  <v:f eqn=\"prod @3 21600 pixelHeight\"/>\r\n  <v:f eqn=\"sum @0 0 1\"/>\r\n  <v:f eqn=\"prod @6 1 2\"/>\r\n  <v:f eqn=\"prod @7 21600 pixelWidth\"/>\r\n  <v:f eqn=\"sum @8 21600 0\"/>\r\n  <v:f eqn=\"prod @7 21600 pixelHeight\"/>\r\n  <v:f eqn=\"sum @10 21600 0\"/>\r\n </v:formulas>\r\n <v:path o:extrusionok=\"f\" gradientshapeok=\"t\" o:connecttype=\"rect\"/>\r\n <o:lock v:ext=\"edit\" aspectratio=\"t\"/>\r\n</v:shapetype><v:shape id=\"_x0000_i1025\" type=\"#_x0000_t75\" style=\'width:44pt;\r\n height:17pt\'>\r\n <v:imagedata src=\"file:///C:/Users/padil/AppData/Local/Temp/msohtmlclip1/01/clip_image001.png\"\r\n  o:title=\"\" chromakey=\"white\"/>\r\n</v:shape><![endif]--><!--[if !vml]--><img width=\"59\" height=\"23\" src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFgAAAAiCAMAAADs8u6hAAAAAXNSR0IArs4c6QAAAGxQTFRFAAAAAAAAAAA6AABmADo6ADpmADqQAGa2OgAAOgBmOjqQOmaQOpDbZgAAZjoAZjo6ZpDbZra2ZrbbZrb/kDoAkDo6kJA6kNv/tmYAttv/tv//25A627Zm27aQ2////7Zm/9uQ/9u2//+2///br/GeHwAAAAF0Uk5TAEDm2GYAAAAJcEhZcwAAFiUAABYlAUlSJPAAAAAZdEVYdFNvZnR3YXJlAE1pY3Jvc29mdCBPZmZpY2V/7TVxAAABaklEQVRIS+2U4VLDIBCEOWsb1FK1iYpGA4H3f0ePSBsOLo6pjTPOlJ8J+7EceyfEZf1ZBewOYL/AaebmtVfb84N9swA02DRQn99tILZXL4uAfUPB/uNeAlzPfcxS5hQBOwUPnbASqlnXYGROrd4ShvvKhwHyNT/EN5uOfGNkVnIIK7+tfAGOp6Qy3tti4BaGu2JPbrBQ/S6L5JTjKBv8s45jVOxt18JW4Mtk5ZoAk4SxYH10aGXFUCbAoyz0B/P+wWZciHjOEoB/eHAi48Fm5AqhYZ3G0UC6SHSIjHOMt08y2nKjhHNMZQFcZD3l8j3IgJ3KejUHHzR6mHm9elRliZkaU9kw3LKpEIedlbUwVY82NNODpeNEFutInzJkNq4azwxlwg3+KZuszKwYZRFMshcuEBf61HCH7ecaWOcTuwCnsgP4lDk/1dJJmn6wZdZgPm6Og/Q08ZTKN1X3zoTp16d4DcPzXNb/q8AnUgYbLdJohbAAAAAASUVORK5CYII=\" v:shapes=\"_x0000_i1025\">&nbsp;=<!--[endif]--></span><!--[endif]--><o:p></o:p></p><p class=\"MsoNormal\"><!--[if gte msEquation 12]><m:oMathPara><m:oMath><i\r\n  style=\'mso-bidi-font-style:normal\'><span style=\'font-family:\"Cambria Math\",serif\'><m:r>∫2</m:r><m:r>x</m:r><m:r>+2</m:r></span></i></m:oMath></m:oMathPara><![endif]--><!--[if !msEquation]--><span style=\"font-size:12.0pt;line-height:115%;font-family:&quot;Calibri&quot;,sans-serif;\r\nmso-ascii-theme-font:minor-latin;mso-fareast-font-family:Calibri;mso-fareast-theme-font:\r\nminor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:&quot;Times New Roman&quot;;\r\nmso-bidi-theme-font:minor-bidi;mso-ansi-language:EN-ID;mso-fareast-language:\r\nEN-US;mso-bidi-language:AR-SA\"><!--[if gte vml 1]><v:shapetype id=\"_x0000_t75\"\r\n coordsize=\"21600,21600\" o:spt=\"75\" o:preferrelative=\"t\" path=\"m@4@5l@4@11@9@11@9@5xe\"\r\n filled=\"f\" stroked=\"f\">\r\n <v:stroke joinstyle=\"miter\"/>\r\n <v:formulas>\r\n  <v:f eqn=\"if lineDrawn pixelLineWidth 0\"/>\r\n  <v:f eqn=\"sum @0 1 0\"/>\r\n  <v:f eqn=\"sum 0 0 @1\"/>\r\n  <v:f eqn=\"prod @2 1 2\"/>\r\n  <v:f eqn=\"prod @3 21600 pixelWidth\"/>\r\n  <v:f eqn=\"prod @3 21600 pixelHeight\"/>\r\n  <v:f eqn=\"sum @0 0 1\"/>\r\n  <v:f eqn=\"prod @6 1 2\"/>\r\n  <v:f eqn=\"prod @7 21600 pixelWidth\"/>\r\n  <v:f eqn=\"sum @8 21600 0\"/>\r\n  <v:f eqn=\"prod @7 21600 pixelHeight\"/>\r\n  <v:f eqn=\"sum @10 21600 0\"/>\r\n </v:formulas>\r\n <v:path o:extrusionok=\"f\" gradientshapeok=\"t\" o:connecttype=\"rect\"/>\r\n <o:lock v:ext=\"edit\" aspectratio=\"t\"/>\r\n</v:shapetype><v:shape id=\"_x0000_i1025\" type=\"#_x0000_t75\" style=\'width:44pt;\r\n height:17pt\'>\r\n <v:imagedata src=\"file:///C:/Users/padil/AppData/Local/Temp/msohtmlclip1/01/clip_image001.png\"\r\n  o:title=\"\" chromakey=\"white\"/>\r\n</v:shape><![endif]--><!--[if !vml]--><!--[endif]--></span><!--[endif]--><o:p></o:p></p>', NULL, 2, 5, -1, 0, 'hasilnya 20', '2025-11-06 10:29:10', '2025-11-27 17:40:04'),
(2, 'a91313ad-0f8b-42c5-9d02-1209052b4967', '<p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Negara X adalah sebuah negara yang baru saja merdeka dan sedang berusaha membangun rasa nasionalisme di kalangan warganya. Proses ini dilakukan melalui implementasi berbagai program pemerintah dan penyebaran nilai-nilai patriotisme dalam pendidikan. Namun, beberapa tantangan tampaknya menjadi penghambat dalam upaya tersebut. Antara lain:</p><ul style=\"padding: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 20px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; list-style: inherit; text-align: justify;\"><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">Banyak warga Negara X yang memilih untuk bekerja di negara lain dan mengadopsi gaya hidup serta budaya negara tersebut.</li><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">Sebagian masyarakat Negara X lebih tertarik pada barang-barang impor dibandingkan produk lokal.</li><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">Penyiaran dan media di Negara X banyak didominasi oleh konten dari luar negeri.</li><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">Konflik internal antara berbagai kelompok etnis dan agama yang berbeda.</li><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">Pengetahuan dan apresiasi terhadap sejarah dan budaya lokal cukup tinggi di kalangan masyarakat berusia.</li></ul><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Berdasarkan kasus di atas, mana faktor yang paling mungkin menjadi penghambat utama dalam membangun semangat nasionalisme di Negara X?</p>', 'twk', 6, 5, 0, 0, '<p data-start=\"63\" data-end=\"117\" style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Jawaban yang benar adalah A</span></p><p data-start=\"119\" data-end=\"385\" style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Globalisasi merupakan fenomena di mana dunia semakin terhubung dari segi teknologi, ekonomi, dan budaya. Dalam kasus Negara X, globalisasi memiliki pengaruh yang signifikan sebagai penghambat perkembangan nasionalisme.<br data-start=\"337\" data-end=\"340\">Hal ini dapat dilihat dari beberapa indikasi:</p><ol data-start=\"387\" data-end=\"1359\" style=\"padding: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 20px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; list-style-position: inherit; list-style-image: inherit; text-align: justify;\"><li data-start=\"387\" data-end=\"701\" style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\"><p data-start=\"390\" data-end=\"701\" style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Migrasi tenaga kerja:</span>&nbsp;Banyak warga Negara X yang memilih untuk bekerja di negara lain. Migrasi tenaga kerja ini cenderung membuat mereka mengadopsi gaya hidup serta budaya negara di mana mereka bekerja, yang dapat berpotensi mengurangi ikatan mereka dengan Negara X dan merusak semangat nasionalisme mereka.</p></li><li data-start=\"703\" data-end=\"1046\" style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\"><p data-start=\"706\" data-end=\"1046\" style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Dominasi barang dan layanan impor:</span>&nbsp;Ketertarikan masyarakat Negara X terhadap barang-barang impor di atas produk lokal menunjukkan dampak globalisasi dalam menciptakan preferensi masyarakat. Hal ini dapat mengurangi dukungan masyarakat terhadap produk lokal, yang adalah bagian penting dari pembangunan semangat nasionalisme di Negara X.</p></li><li data-start=\"1048\" data-end=\"1359\" style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\"><p data-start=\"1051\" data-end=\"1359\" style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Dominasi konten media asing:</span>&nbsp;Media memainkan peran penting dalam membentuk persepsi masyarakat. Penyiaran dan media di Negara X yang didominasi oleh konten dari luar negeri berarti masyarakat sering dihadapkan pada budaya dan nilai-nilai asing, yang bisa mempengaruhi identitas lokal dan nasional mereka.</p></li></ol><p data-start=\"1361\" data-end=\"1926\" style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Melalui tiga indikasi ini, dapat disimpulkan bahwa globalisasi adalah faktor utama yang menghambat pembangunan semangat nasionalisme di Negara X. Globalisasi merusak ikatan masyarakat dengan tanah air mereka dan menggerus identitas kultural nasional melalui penyebaran budaya dan gaya hidup asing, baik itu melalui media atau interaksi langsung ketika mereka bekerja di negara lain. Selain itu, dominasi produk asing juga berkontribusi pada penurunan dukungan terhadap produk dan perusahaan lokal, yang penting untuk pengembangan dan keberlanjutan ekonomi nasional.</p>', '2025-11-30 09:11:22', '2025-11-30 09:11:22'),
(3, 'a91313ad-0f8b-42c5-9d02-1209052b4967', '<p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Pada masa penjajahan, beberapa pemuda Indonesia seperti Ernest Douwes Dekker, Soewardi Soerjaningrat dan Tjipto Mangunkusumo mendirikan organisasi yang bernama Indische Party. Organisasi ini dikenal sebagai organisasi pertama yang mencetuskan konsep merdeka, yaitu bebas dari penjajahan Belanda dan menjadi fondasi penting dalam paham nasionalisme Indonesia.&nbsp;<span style=\"font-size: 1rem;\">Peran Indische Party dan konsep merdeka memiliki pengaruh yang signifikan dalam sejarah kemerdekaan Indonesia. Bagaimanakah dampak konsep merdeka dan paham nasionalisme yang ditetapkan oleh Indische Party dalam perjuangan bangsa Indonesia hingga hari ini?</span></p>', 'twk', 13, 5, 0, 0, '<p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Jawaban yang benar adalah C.</span></p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Konsep merdeka dan paham nasionalisme yang disuarakan oleh Indische Party dapat dianggap sebagai gerakan awal yang signifikan dalam mendorong terbentuknya kesadaran kolektif untuk merdeka di Indonesia. Kesadaran kolektif ini merujuk pada pemahaman bersama di antara penduduk Indonesia bahwa mereka menginginkan dan berhak atas kemerdekaan negara mereka sendiri, bebas dari penjajahan asing.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Paham nasionalisme ini meletakkan dasar bagi perjuangan Indonesia untuk mendapatkan kemerdekaan. Ide-ide dari Indische Party, termasuk konsep merdeka dan nasionalisme, membantu menguatkan perlawanan terhadap penjajah dan membentuk pergerakan nasionalis yang lebih besar yang akhirnya sukses memenangkan kemerdekaan Indonesia.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Dengan mengusung konsep merdeka dan nasionalisme, Indische Party berhasil membangkitkan semangat perlawanan dan keinginan untuk bebas dari penjajahan, yang bertahan hingga hari ini dalam bentuk kebangsaan nasional dan patriotisme.</p>', '2025-12-04 02:49:22', '2025-12-04 02:49:22'),
(4, 'a91313ad-0f8b-42c5-9d02-1209052b4967', '<span style=\"text-align: justify;\">Pada 2021 silam, seorang aparat bernama Briptu Nikmal Idwan diduga melakukan pemerkosaan terhadap seorang remaja perempuan berusia 16 tahun di Mapolsek Jailolo Selatan, Halmahera Barat, Maluku Utara. Tindakan aparat ini jelas sekali bertentangan dengan</span>', 'twk', 18, 5, 0, 0, '<p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Bunyi masing-masing pasal pada pilihan adalah sebagai berikut:</p><ul style=\"padding: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 20px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; list-style: inherit; text-align: justify;\"><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">UUD 1945 pasal 27 ayat 3:</span>&nbsp;Setiap warga negara berhak dan wajib ikut serta dalam pembelaan negara.</li><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">UUD 1945 pasal 30 ayat 3:</span>&nbsp;Tentara Nasional Indonesia terdiri atas Angkatan Darat, Angkatan Laut, dan Angkatan Udara sebagai alat negara yang bertugas mempertahankan, melindungi, dan memelihara keutuhan dan kedaulatan negara.</li><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">UUD 1945 pasal 30 ayat 4:</span>&nbsp;Kepolisian Negara Republik Indonesia sebagai alat negara yang menjaga keamanan dan ketertiban masyarakat bertugas melindungi, mengayomi, melayani masyarakat, serta menegakkan hukum.</li><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">UU nomor 3 2002 pasal 9 ayat 1:</span>&nbsp;Setiap warga negara berhak dan wajib ikut serta dalam upaya bela negara yang diwujudkan dalam penyelenggaraan pertahanan negara.</li><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">UU nomor 3 2002 pasal 9 ayat 2:</span>&nbsp;Ketentuan mengenai pendidikan kewarganegaraan, pelatihan dasar kemiliteran secara wajib, dan pengabdian sesuai dengan profesi diatur dengan undang-undang.</li></ul><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Tindakan pemerkosaan yang dilakukan oleh oknum aparat tersebut jelas melanggar&nbsp;<span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">UUD 1945 pasal 30 ayat 4</span>. Polisi seharusnya melindungi dan mengayomi masyarakat, tetapi justru menjadi ancaman dan pelaku kriminal.</p>', '2025-12-04 02:50:28', '2025-12-04 02:50:28'),
(5, 'a91313ad-0f8b-42c5-9d02-1209052b4967', '<span style=\"text-align: justify;\">Nama Pandawara Group seringkali menjadi perbincangan dan trending topik di sosial media berkat aksi-aksi heroiknya dalam membersihkan sampah. Beranggotakan lima orang pemuda, yaitu Ikhsan Destian, Gliang Rahma, Muhammad Rifqi, Rafly Pasya, dan Agung Permana, tak jarang Pandawara Group mengajak masyarakat dan netizen untuk turut serta turun ke lapangan membersihkan sampah. Aksi kelompok pemuda ini mencerminkan salah satu nilai bela negara, yaitu ….</span>', 'twk', 21, 5, 0, 0, '<p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Dalam kasus tersebut, Pandawara Group berupaya menjaga dan melestarikan lingkungan hidup. Aksi mereka ini sesuai dengan salah satu indikator&nbsp;<span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">cinta tanah air</span>. Indikatornya adalah sebagai berikut:</p><ul style=\"padding: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 20px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; list-style: inherit; text-align: justify;\"><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">Mencintai, menjaga dan melestarikan Lingkungan Hidup</li><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">Menghargai dan menggunakan karya anak bangsa</li><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">Menggunakan produk dalam negeri</li><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">Menjaga dan memahami seluruh ruang wilayah NKRI</li><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">Menjaga nama baik bangsa dan negara</li><li style=\"margin: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline;\">Mengenal wilayah tanah air tanpa rasa fanatisme kedaerahan</li></ul><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Pilihan lainnya tidak tepat</span>&nbsp;karena memiliki indikator yang berbeda.</p>', '2025-12-04 02:52:06', '2025-12-04 02:52:06'),
(6, 'a91313ad-0f8b-42c5-9d02-1209052b4967', '<span style=\"text-align: justify;\">Unjuk rasa atau demonstrasi merupakan salah satu bentuk penyampaian pendapat di muka umum dan hal ini dijamin oleh undang-undang. Sayangnya, tak jarang aksi demonstrasi disertai tindakan anarkis dari oknum-oknum tak bertanggung jawab ingin melakukan persekusi, pengrusakan dan penjarahan di kantor pemerintahan dan sarana publik. Tindakan para oknum ini jelas bertentangan dengan Pancasila sila ke ….</span>', 'twk', 29, 5, 0, 0, '<p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Jawaban yang benar adalah D</span></p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Tindakan yang dilakukan oleh oknum-oknum yang terlibat dalam demonstrasi anarkis, seperti melakukan persekusi, pengrusakan, dan penjarahan di kantor pemerintahan dan sarana publik, jelas bertentangan dengan Sila ke-4 Pancasila.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Sila ke-4 Pancasila adalah “Kerakyatan yang Dipimpin oleh Hikmat Kebijaksanaan dalam Permusyawaratan / Perwakilan”. Sila ini menekankan demokrasi yang dilandaskan pada musyawarah untuk mencapai mufakat dan kebenaran. Sikap dan tindakan oknum-oknum yang melakukan tindakan anarkis tersebut tidak menjunjung tinggi nilai musyawarah, kebijaksanaan, dan semangat keadilan dalam berdemokrasi.</p>', '2025-12-04 02:53:28', '2025-12-04 02:53:28'),
(7, 'a91313ad-0f8b-42c5-9d02-1209052b4967', '<span style=\"text-align: justify;\">Desa yang dipimpin oleh Pak Dimas terancam banjir akibat musim penghujan yang akan segera tiba dan dikhawatirkan akan menyebabkan sungai di sekitar desa meluap. Untuk mengatasi masalah ini, Pak Dimas mengusulkan pembangunan tanggul baru atau memperkuat drainase. Melalui pemungutan suara yang diadakan di desa tersebut, mayoritas warga memilih bangun tanggul baru. Perilaku Pak Dimas dan seluruh warga desa merupakan cerminan dari ….</span>', 'twk', 33, 5, 0, 0, '<p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Jawaban yang benar adalah C</span></p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Dalam kasus tersebut, Pak Dimas bersama warga desa menggunakan pemungutan suara untuk memilih solusi terbaik menghadapi ancaman banjir, mencerminkan prinsip demokratis. Pemungutan suara adalah wujud kedaulatan rakyat, sebagaimana yang dinyatakan dalam&nbsp;<span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">UUD 1945 Pasal 1 ayat 2</span>&nbsp;di mana kekuasaan negara berada di tangan rakyat&nbsp;<span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">(Kedaulatan adalah di tangan rakyat, dan dilakukan sepenuhnya oleh Majelis Permusyawaratan Rakyat)</span>.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Selain itu,&nbsp;<span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">pembukaan UUD 1945 alinea ke-4</span>&nbsp;menegaskan bahwa negara Indonesia berdasarkan kedaulatan rakyat (“… yang terbentuk dalam suatu susunan Negara Republik Indonesia yang berkedaulatan rakyat dengan berdasar kepada…” ). Keputusan yang diambil melalui pemungutan suara mencerminkan partisipasi aktif warga dalam mengelola masalah yang dihadapi, sesuai dengan nilai-nilai demokratis yang mengedepankan musyawarah.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Selaras dengan&nbsp;<span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Pancasila sila ke-4,</span>&nbsp;keputusan yang diambil melalui mekanisme pemungutan suara juga menegaskan prinsip&nbsp;<span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">kerakyatan yang dipimpin oleh hikmat kebijaksanaan dalam permusyawaratan/perwakilan.</span></p>', '2025-12-04 02:54:28', '2025-12-04 02:54:28');
INSERT INTO `soal` (`id`, `ujian_id`, `soal`, `jenis_soal`, `kunci_jawaban`, `poin_benar`, `poin_salah`, `poin_kosong`, `pembahasan`, `created_at`, `updated_at`) VALUES
(8, 'a91313ad-0f8b-42c5-9d02-1209052b4967', '<span style=\"text-align: justify;\">Dalam rapat BPUPKI yang membahas rancangan undang-undang dasar, permasalahan bentuk negara menjadi salah satu pembahasan yang diperbedatkan secara serius. Usulan bentuk negara yang muncul pada waktu itu, yaitu negara kesatuan dan negara federal. Namun kemudian disepakati bentuk Negara Indonesia ialah negara kesatuan, sebagaimana tertera dalam Pasal 1 ayat (1) Undang-Undang Dasar 1945. Mengapa negara kesatuan lebih cocok sebagai bentuk negara Indonesia?</span>', 'twk', 36, 5, 0, 0, '<p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Jawaban yang benar adalah A</span></p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\">Negara kesatuan adalah negara berdaulat yang diselenggarakan sebagai satu kesatuan tunggal, di mana pemerintah pusat adalah yang tertinggi dan satuan-satuan subnasionalnya hanya menjalankan kekuasaan-kekuasaan yang dipilih dan diberikan untuk untuk didelegasikan. Sesuai dengan definisi tersebut, negara Indonesia lebih cocok menggunakan bentuk negara kesatuan karena wilayah Indonesia yang sangat luas dan masyarakatnya sangat heterogen. Dengan negara kesatuan, pemerintah pusat dapat merangkul keberagaman ini sambil memastikan bahwa kebijakan yang diambil adil untuk setiap daerah, sehingga meminimalkan risiko perpecahan karena otonomi yang berlebihan.&nbsp;<span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Pilihan A tepat.</span></p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Pilihan B tidak tepat</span>&nbsp;karena negara yang setiap wilayahnya memiliki pemerintahan dan otonominya sendiri adalah negara serikat.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Pilihan C tidak tepat</span>&nbsp;negara dengan kekuasaan tunggal yang tidak dapat diganggu gugat adalah negara otokrasi.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Pilihan D tidak tepat</span>&nbsp;menyeimbangkan kepentingan nasional dan lokal, serta memberikan otonomi yang lebih besar bagi daerah adalah ciri negara federal.</p><p style=\"margin-right: 0px; margin-left: 0px; padding: 0px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-alternates: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit; vertical-align: baseline; overflow-wrap: break-word;\"><span style=\"border-style: initial; border-color: initial; border-image: initial; font-variant-alternates: inherit; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-variant-position: inherit; font-variant-emoji: inherit; font-stretch: inherit; line-height: inherit; font-optical-sizing: inherit; font-size-adjust: inherit; font-kerning: inherit; font-feature-settings: inherit; font-variation-settings: inherit;\">Pilihan E tidak tepat</span>&nbsp;sama sekali tidak relevan dengan soal. Kelas borjuis dan kelas proletar lahir dari paham kapitalisme.</p>', '2025-12-04 02:55:45', '2025-12-04 02:55:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `study_statistics`
--

CREATE TABLE `study_statistics` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `study_date` date NOT NULL,
  `total_study_time` int(11) NOT NULL DEFAULT 0,
  `materials_viewed` int(11) NOT NULL DEFAULT 0,
  `tryouts_completed` int(11) NOT NULL DEFAULT 0,
  `average_score` decimal(5,2) DEFAULT NULL,
  `subjects_studied` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`subjects_studied`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ujian`
--

CREATE TABLE `ujian` (
  `id` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `peraturan` text DEFAULT NULL,
  `jenis_ujian` varchar(20) DEFAULT NULL,
  `lama_pengerjaan` int(10) UNSIGNED NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_akhir` datetime NOT NULL,
  `waktu_pengumuman` datetime DEFAULT NULL,
  `isPublished` tinyint(1) NOT NULL DEFAULT 0,
  `tipe_ujian` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1. satu waktu, 2. periodik',
  `tampil_kunci` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0. tidak, 1. ya, 2. ya, setelah ditutup',
  `allow_pembahasan_during_test` tinyint(1) NOT NULL DEFAULT 0,
  `pembahasan_access_limit` int(11) DEFAULT NULL,
  `pembahasan_access_reason` text DEFAULT NULL,
  `tampil_nilai` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0. tidak, 1. ya, 2. ya, setelah ditutup',
  `tampil_poin` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0. tidak, 1. ya',
  `random` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0. tidak, 1. ya',
  `random_pilihan` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0. tidak, 1. ya',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jumlah_soal` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ujian`
--

INSERT INTO `ujian` (`id`, `nama`, `deskripsi`, `peraturan`, `jenis_ujian`, `lama_pengerjaan`, `waktu_mulai`, `waktu_akhir`, `waktu_pengumuman`, `isPublished`, `tipe_ujian`, `tampil_kunci`, `allow_pembahasan_during_test`, `pembahasan_access_limit`, `pembahasan_access_reason`, `tampil_nilai`, `tampil_poin`, `random`, `random_pilihan`, `created_at`, `updated_at`, `jumlah_soal`) VALUES
('85a7ed92-3027-45fd-ac0f-a39d0eabe81a', 'MATEMATIKA', 'Soal Matematika Testing', 'Bebas', 'mtk', 5, '2025-11-06 17:27:00', '2025-12-11 07:00:00', '2025-12-15 07:01:00', 0, 1, 0, 0, NULL, NULL, 2, 0, 0, 0, '2025-11-06 10:28:27', '2025-12-08 10:51:19', 1),
('a91313ad-0f8b-42c5-9d02-1209052b4967', 'SKD BATCH 1', NULL, NULL, 'skd', 100, '2025-12-09 07:00:00', '2025-12-11 20:30:00', '1970-01-01 07:00:00', 1, 1, 2, 0, NULL, NULL, 0, 0, 0, 0, '2025-11-30 09:03:42', '2025-12-09 13:32:02', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ujian_user`
--

CREATE TABLE `ujian_user` (
  `id` char(36) NOT NULL,
  `ujian_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: blm mengerjakan, 1: sedang mengerjakan, 2: selesai',
  `is_first` tinyint(1) NOT NULL DEFAULT 0,
  `jml_benar` smallint(6) NOT NULL DEFAULT 0,
  `jml_salah` smallint(6) NOT NULL DEFAULT 0,
  `jml_kosong` smallint(6) NOT NULL DEFAULT 0,
  `nilai` smallint(6) NOT NULL DEFAULT 0,
  `nilai_twk` smallint(6) DEFAULT NULL,
  `nilai_tiu` smallint(6) DEFAULT NULL,
  `nilai_tkp` smallint(6) DEFAULT NULL,
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_akhir` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ujian_user`
--

INSERT INTO `ujian_user` (`id`, `ujian_id`, `user_id`, `status`, `is_first`, `jml_benar`, `jml_salah`, `jml_kosong`, `nilai`, `nilai_twk`, `nilai_tiu`, `nilai_tkp`, `waktu_mulai`, `waktu_akhir`, `created_at`, `updated_at`) VALUES
('9a394ca3-f42d-41c5-a669-1b790d6683c7', 'a91313ad-0f8b-42c5-9d02-1209052b4967', '663ff84d-3ae7-4025-9f4d-d45cc2e07692', 2, 1, 0, 0, 0, 5, 5, 0, 0, '2025-12-09 20:33:50', '2025-12-09 20:37:10', '2025-12-09 13:33:50', '2025-12-09 13:37:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: belum ada detail, 1: akun, 2: peserta, 3: lengkap',
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `email_verified_at`, `status`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
('0556d0f7-ef9b-4933-a990-ec02058d4403', 'NI KADEK AYU PURNAMI SARI DEWI', '211911183@stis.ac.id', '110989672769178465227', '2025-12-09 13:14:28', 3, '$2y$10$XXlW6fmEuj7i0SRm.niJauCLDiVDrac/4FDjjUCt1WAQSg48JdO5m', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-09 13:14:29', '2025-12-09 13:15:21'),
('263cd021-6caf-4cbd-9dba-a7e5ff1e63a8', 'Azka', 'azka123@gmail.com', NULL, NULL, 0, '$2y$10$ugcDUlSXJZpZl1is.DWAQ.2mG.w4W7PtNLw.S9ZieQgz.7cEi/qSy', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-02 04:03:55', '2025-12-02 04:03:55'),
('2fc45e87-17a5-4bf4-a694-9588478ff488', 'Admin', 'admin@tryout.com', NULL, '2025-11-06 01:41:28', 1, '$2y$10$WPMw6eoOOfe1BHOTnjdBkuKeeXAfU0MgIB2fgEViPx9k9i1VH2oa.', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
('42493610-d74a-4f95-bdc8-1b8ba310a0d3', 'Alifia Deanita', 'alifiadea922@gmail.com', '115058922276256661187', '2025-12-09 06:46:32', 1, '$2y$10$sCFSgREa3p0VKE8sN62ATe8IUKY5Js7vnQ9ypcnN1/oprh7DprxQ2', NULL, NULL, NULL, NULL, NULL, 'photo-profile/image-1765282162.png', '2025-12-09 06:46:33', '2025-12-09 12:09:26'),
('663ff84d-3ae7-4025-9f4d-d45cc2e07692', 'faiz', 'haniffaizul05@gmail.com', NULL, '2025-12-09 13:20:41', 2, '$2y$10$2KukfnE55Clm/uZP4ySF4e6TexqTNoaglz4mwYqHTJYoRJ2069/aq', NULL, NULL, NULL, NULL, NULL, 'photo-profile/image-1765286572.png', '2025-12-09 13:20:09', '2025-12-09 13:22:52'),
('768dbaf2-9f04-4d5f-a03d-d41a94edfbf2', 'Siti Tutor', 'tutor2@example.com', NULL, '2025-11-06 01:41:28', 3, '$2y$10$pOlOb64ZmsVbrUCeKl5QCuilzOv1S2ilU2ZWZTRVAlhQ4nSVjbOXy', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
('9254b961-6eff-4245-9cc5-844ad0436c99', 'Budi Pengajar', 'tutor3@example.com', NULL, '2025-11-06 01:41:28', 3, '$2y$10$O7XEOwegt2vcYyacM72IYOgYbAI.1Xy59kUlWcaiE1BJaK5gqaY0q', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
('b35c3d88-8fc3-4453-8d55-1004a47cd43d', 'Ahmad Tutor', 'tutor1@example.com', NULL, '2025-11-06 01:41:28', 3, '$2y$10$iyfXQ0v8quIHcrmRlUbws.Zs9SMmTHpxfs1/rNzTyUHjlziBy0tF.', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-06 01:41:28', '2025-11-06 01:41:28'),
('cec07405-3726-4c33-a50e-481b03e8cb8b', 'Padil Muhammad Zaki', 'padilzaki73@gmail.com', '102431249243841585735', '2025-12-09 07:32:40', 1, '$2y$10$6x5v0Y1eAAhCVFRd0DhYpehjAnXvmBDGy8F8bf46B2A13GYGffz6K', NULL, NULL, NULL, NULL, NULL, 'photo-profile/image-1765265618.png', '2025-12-09 07:32:40', '2025-12-09 07:33:40'),
('eaff20c5-aeb2-478d-ae96-0f6f04b1b044', 'Dinda Putri N. W.', 'dindaputrinurwulandari2@gmail.com', '112622938042214931084', '2025-12-09 13:10:19', 0, '$2y$10$FRimlE43s2Lrf8nnUaLmz.Eq4F2IwzeCilgbyrC1QyNMwwawVrasy', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-09 13:10:19', '2025-12-09 13:10:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_detail`
--

CREATE TABLE `users_detail` (
  `id` char(36) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `provinsi` varchar(255) DEFAULT NULL,
  `kabupaten` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `asal_sekolah` varchar(255) DEFAULT NULL,
  `sumber_informasi` varchar(255) DEFAULT NULL,
  `prodi` tinyint(4) DEFAULT NULL COMMENT '1: D3, 2: D4 ST, 3: D4 KS',
  `penempatan` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `nama_kelompok` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users_detail`
--

INSERT INTO `users_detail` (`id`, `no_hp`, `provinsi`, `kabupaten`, `kecamatan`, `asal_sekolah`, `sumber_informasi`, `prodi`, `penempatan`, `instagram`, `nama_kelompok`, `created_at`, `updated_at`) VALUES
('42493610-d74a-4f95-bdc8-1b8ba310a0d3', '0895359066286', NULL, NULL, NULL, NULL, '[\"Email\"]', 3, '01', NULL, NULL, '2025-12-09 12:09:22', '2025-12-09 12:09:26'),
('663ff84d-3ae7-4025-9f4d-d45cc2e07692', '08121213131414', NULL, NULL, NULL, 'sma 1 jakarta', '[\"Instagram\"]', 3, '01', NULL, NULL, '2025-12-09 13:20:10', '2025-12-09 13:22:52'),
('cec07405-3726-4c33-a50e-481b03e8cb8b', '082175155963', NULL, NULL, NULL, NULL, '[\"WhatsApp\"]', 2, '02', NULL, NULL, '2025-12-09 07:33:38', '2025-12-09 07:33:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `voucher`
--

CREATE TABLE `voucher` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `diskon` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `himada_id` char(36) DEFAULT NULL,
  `kuota` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `paket_ujian_id` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `voucher`
--

INSERT INTO `voucher` (`id`, `kode`, `diskon`, `himada_id`, `kuota`, `paket_ujian_id`, `created_at`, `updated_at`) VALUES
(2, 'DINDAMENWA123', 10000, NULL, 29, '013eb629-4677-4ea1-8987-01ec420e2e0e', '2025-12-08 10:10:49', '2025-12-08 10:17:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wilayah`
--

CREATE TABLE `wilayah` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `wilayah`
--

INSERT INTO `wilayah` (`kode`, `nama`) VALUES
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
('31.71.10', 'Setiabudi'),
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

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`),
  ADD KEY `articles_author_id_foreign` (`author_id`),
  ADD KEY `articles_slug_index` (`slug`),
  ADD KEY `articles_status_index` (`status`),
  ADD KEY `articles_category_index` (`category`),
  ADD KEY `articles_published_at_index` (`published_at`);

--
-- Indeks untuk tabel `bank_soal`
--
ALTER TABLE `bank_soal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_soal_tentor_id_foreign` (`tentor_id`),
  ADD KEY `bank_soal_batch_id_mapel_index` (`batch_id`,`mapel`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `formasi`
--
ALTER TABLE `formasi`
  ADD PRIMARY KEY (`kode`);

--
-- Indeks untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jawaban_soal_id_foreign` (`soal_id`);

--
-- Indeks untuk tabel `jawaban_peserta`
--
ALTER TABLE `jawaban_peserta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jawaban_peserta_pembelian_id_foreign` (`pembelian_id`),
  ADD KEY `jawaban_peserta_jawaban_id_foreign` (`jawaban_id`),
  ADD KEY `jawaban_peserta_soal_id_foreign` (`soal_id`),
  ADD KEY `jawaban_peserta_ujian_user_id_foreign` (`ujian_user_id`);

--
-- Indeks untuk tabel `learning_progress`
--
ALTER TABLE `learning_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `learning_progress_material_id_foreign` (`material_id`),
  ADD KEY `learning_progress_ujian_id_foreign` (`ujian_id`),
  ADD KEY `learning_progress_user_id_index` (`user_id`),
  ADD KEY `learning_progress_paket_id_index` (`paket_id`),
  ADD KEY `learning_progress_activity_type_index` (`activity_type`),
  ADD KEY `learning_progress_created_at_index` (`created_at`);

--
-- Indeks untuk tabel `live_classes`
--
ALTER TABLE `live_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `live_classes_tutor_id_scheduled_at_index` (`tutor_id`,`scheduled_at`),
  ADD KEY `live_classes_batch_id_foreign` (`batch_id`);

--
-- Indeks untuk tabel `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `materials_tutor_id_type_index` (`tutor_id`,`type`),
  ADD KEY `materials_is_public_index` (`is_public`),
  ADD KEY `materials_is_featured_index` (`is_featured`),
  ADD KEY `materials_batch_id_foreign` (`batch_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indeks untuk tabel `paket_ujian`
--
ALTER TABLE `paket_ujian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `paket_ujian_ujian`
--
ALTER TABLE `paket_ujian_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paket_ujian_ujian_paket_ujian_id_foreign` (`paket_ujian_id`),
  ADD KEY `paket_ujian_ujian_ujian_id_foreign` (`ujian_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembelian_user_id_foreign` (`user_id`),
  ADD KEY `pembelian_paket_id_foreign` (`paket_id`),
  ADD KEY `pembelian_id_voucher_foreign` (`id_voucher`),
  ADD KEY `pembelian_verified_by_foreign` (`verified_by`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`kode`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soal_ujian_id_foreign` (`ujian_id`),
  ADD KEY `soal_kunci_jawaban_foreign` (`kunci_jawaban`);

--
-- Indeks untuk tabel `study_statistics`
--
ALTER TABLE `study_statistics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `study_statistics_user_id_study_date_unique` (`user_id`,`study_date`),
  ADD KEY `study_statistics_study_date_index` (`study_date`);

--
-- Indeks untuk tabel `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ujian_user`
--
ALTER TABLE `ujian_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ujian_user_user_id_foreign` (`user_id`),
  ADD KEY `ujian_user_ujian_id_foreign` (`ujian_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `users_detail`
--
ALTER TABLE `users_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `voucher_kode_unique` (`kode`),
  ADD KEY `voucher_himada_id_foreign` (`himada_id`),
  ADD KEY `voucher_paket_ujian_id_foreign` (`paket_ujian_id`);

--
-- Indeks untuk tabel `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`kode`),
  ADD KEY `wilayah_kode_index` (`kode`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `faq`
--
ALTER TABLE `faq`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `jawaban_peserta`
--
ALTER TABLE `jawaban_peserta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT untuk tabel `paket_ujian_ujian`
--
ALTER TABLE `paket_ujian_ujian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `soal`
--
ALTER TABLE `soal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `bank_soal`
--
ALTER TABLE `bank_soal`
  ADD CONSTRAINT `bank_soal_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bank_soal_tentor_id_foreign` FOREIGN KEY (`tentor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jawaban`
--
ALTER TABLE `jawaban`
  ADD CONSTRAINT `jawaban_soal_id_foreign` FOREIGN KEY (`soal_id`) REFERENCES `soal` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jawaban_peserta`
--
ALTER TABLE `jawaban_peserta`
  ADD CONSTRAINT `jawaban_peserta_jawaban_id_foreign` FOREIGN KEY (`jawaban_id`) REFERENCES `jawaban` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `jawaban_peserta_pembelian_id_foreign` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jawaban_peserta_soal_id_foreign` FOREIGN KEY (`soal_id`) REFERENCES `soal` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jawaban_peserta_ujian_user_id_foreign` FOREIGN KEY (`ujian_user_id`) REFERENCES `ujian_user` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `learning_progress`
--
ALTER TABLE `learning_progress`
  ADD CONSTRAINT `learning_progress_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `learning_progress_paket_id_foreign` FOREIGN KEY (`paket_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `learning_progress_ujian_id_foreign` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `learning_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `live_classes`
--
ALTER TABLE `live_classes`
  ADD CONSTRAINT `live_classes_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `live_classes_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `materials_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `paket_ujian_ujian`
--
ALTER TABLE `paket_ujian_ujian`
  ADD CONSTRAINT `paket_ujian_ujian_paket_ujian_id_foreign` FOREIGN KEY (`paket_ujian_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paket_ujian_ujian_ujian_id_foreign` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_id_voucher_foreign` FOREIGN KEY (`id_voucher`) REFERENCES `voucher` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembelian_paket_id_foreign` FOREIGN KEY (`paket_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembelian_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembelian_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `soal_kunci_jawaban_foreign` FOREIGN KEY (`kunci_jawaban`) REFERENCES `jawaban` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `soal_ujian_id_foreign` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `study_statistics`
--
ALTER TABLE `study_statistics`
  ADD CONSTRAINT `study_statistics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ujian_user`
--
ALTER TABLE `ujian_user`
  ADD CONSTRAINT `ujian_user_ujian_id_foreign` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ujian_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users_detail`
--
ALTER TABLE `users_detail`
  ADD CONSTRAINT `users_detail_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `voucher`
--
ALTER TABLE `voucher`
  ADD CONSTRAINT `voucher_himada_id_foreign` FOREIGN KEY (`himada_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `voucher_paket_ujian_id_foreign` FOREIGN KEY (`paket_ujian_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
