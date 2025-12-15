/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`),
  KEY `articles_author_id_foreign` (`author_id`),
  KEY `articles_slug_index` (`slug`),
  KEY `articles_status_index` (`status`),
  KEY `articles_category_index` (`category`),
  KEY `articles_published_at_index` (`published_at`),
  CONSTRAINT `articles_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bank_soal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bank_soal_tentor_id_foreign` (`tentor_id`),
  KEY `bank_soal_batch_id_mapel_index` (`batch_id`,`mapel`),
  CONSTRAINT `bank_soal_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bank_soal_tentor_id_foreign` FOREIGN KEY (`tentor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `author_id` char(36) NOT NULL,
  `pinned` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `formasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `formasi` (
  `kode` varchar(2) NOT NULL,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jawaban`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jawaban` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `soal_id` bigint(20) unsigned NOT NULL,
  `jawaban` longtext NOT NULL,
  `point` smallint(6) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jawaban_soal_id_foreign` (`soal_id`),
  CONSTRAINT `jawaban_soal_id_foreign` FOREIGN KEY (`soal_id`) REFERENCES `soal` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jawaban_peserta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jawaban_peserta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pembelian_id` bigint(20) unsigned DEFAULT NULL,
  `ujian_user_id` char(36) DEFAULT NULL,
  `soal_id` bigint(20) unsigned NOT NULL,
  `jawaban_id` bigint(20) unsigned DEFAULT NULL,
  `ragu_ragu` tinyint(1) DEFAULT 0,
  `poin` smallint(6) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jawaban_peserta_pembelian_id_foreign` (`pembelian_id`),
  KEY `jawaban_peserta_jawaban_id_foreign` (`jawaban_id`),
  KEY `jawaban_peserta_soal_id_foreign` (`soal_id`),
  KEY `jawaban_peserta_ujian_user_id_foreign` (`ujian_user_id`),
  CONSTRAINT `jawaban_peserta_jawaban_id_foreign` FOREIGN KEY (`jawaban_id`) REFERENCES `jawaban` (`id`) ON DELETE SET NULL,
  CONSTRAINT `jawaban_peserta_pembelian_id_foreign` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelian` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jawaban_peserta_soal_id_foreign` FOREIGN KEY (`soal_id`) REFERENCES `soal` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jawaban_peserta_ujian_user_id_foreign` FOREIGN KEY (`ujian_user_id`) REFERENCES `ujian_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `learning_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `learning_progress_material_id_foreign` (`material_id`),
  KEY `learning_progress_ujian_id_foreign` (`ujian_id`),
  KEY `learning_progress_user_id_index` (`user_id`),
  KEY `learning_progress_paket_id_index` (`paket_id`),
  KEY `learning_progress_activity_type_index` (`activity_type`),
  KEY `learning_progress_created_at_index` (`created_at`),
  CONSTRAINT `learning_progress_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`) ON DELETE CASCADE,
  CONSTRAINT `learning_progress_paket_id_foreign` FOREIGN KEY (`paket_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE,
  CONSTRAINT `learning_progress_ujian_id_foreign` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE,
  CONSTRAINT `learning_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `live_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `live_classes_tutor_id_scheduled_at_index` (`tutor_id`,`scheduled_at`),
  KEY `live_classes_batch_id_foreign` (`batch_id`),
  CONSTRAINT `live_classes_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE,
  CONSTRAINT `live_classes_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materials_tutor_id_type_index` (`tutor_id`,`type`),
  KEY `materials_is_public_index` (`is_public`),
  KEY `materials_is_featured_index` (`is_featured`),
  KEY `materials_batch_id_foreign` (`batch_id`),
  CONSTRAINT `materials_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE,
  CONSTRAINT `materials_tutor_id_foreign` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` char(36) NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` char(36) NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `paket_ujian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paket_ujian` (
  `id` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(10) unsigned NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_akhir` datetime NOT NULL,
  `whatsapp_group_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `paket_ujian_ujian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paket_ujian_ujian` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `paket_ujian_id` char(36) NOT NULL,
  `ujian_id` char(36) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `paket_ujian_ujian_paket_ujian_id_foreign` (`paket_ujian_id`),
  KEY `paket_ujian_ujian_ujian_id_foreign` (`ujian_id`),
  CONSTRAINT `paket_ujian_ujian_paket_ujian_id_foreign` FOREIGN KEY (`paket_ujian_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `paket_ujian_ujian_ujian_id_foreign` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pembelian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembelian` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `paket_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `kode_pembelian` char(36) DEFAULT NULL,
  `batas_pembayaran` datetime DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `harga` int(10) unsigned NOT NULL,
  `jenis_pembayaran` varchar(50) DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `catatan_pembayaran` text DEFAULT NULL,
  `status_verifikasi` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `catatan_admin` text DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `verified_by` char(36) DEFAULT NULL,
  `whatsapp_admin` varchar(255) DEFAULT NULL,
  `id_voucher` bigint(20) unsigned DEFAULT NULL,
  `nama_kelompok` varchar(255) DEFAULT NULL,
  `status_pengerjaan` varchar(30) DEFAULT 'Belum Dikerjakan',
  `waktu_mulai_pengerjaan` datetime DEFAULT NULL,
  `waktu_selesai_pengerjaan` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembelian_user_id_foreign` (`user_id`),
  KEY `pembelian_paket_id_foreign` (`paket_id`),
  KEY `pembelian_id_voucher_foreign` (`id_voucher`),
  KEY `pembelian_verified_by_foreign` (`verified_by`),
  CONSTRAINT `pembelian_id_voucher_foreign` FOREIGN KEY (`id_voucher`) REFERENCES `voucher` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pembelian_paket_id_foreign` FOREIGN KEY (`paket_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pembelian_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pembelian_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pengumuman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengumuman` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `author_id` char(36) NOT NULL,
  `paket_id` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengumuman_author_id_foreign` (`author_id`),
  KEY `pengumuman_paket_id_foreign` (`paket_id`),
  CONSTRAINT `pengumuman_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengumuman_paket_id_foreign` FOREIGN KEY (`paket_id`) REFERENCES `paket_ujian` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `prodi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prodi` (
  `kode` tinyint(4) NOT NULL,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `soal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `soal` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ujian_id` char(36) NOT NULL,
  `soal` text NOT NULL,
  `jenis_soal` varchar(10) DEFAULT NULL,
  `kunci_jawaban` bigint(20) unsigned DEFAULT NULL,
  `poin_benar` smallint(6) NOT NULL DEFAULT 0,
  `poin_salah` smallint(6) NOT NULL DEFAULT 0,
  `poin_kosong` smallint(6) NOT NULL DEFAULT 0,
  `pembahasan` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `soal_ujian_id_foreign` (`ujian_id`),
  KEY `soal_kunci_jawaban_foreign` (`kunci_jawaban`),
  CONSTRAINT `soal_kunci_jawaban_foreign` FOREIGN KEY (`kunci_jawaban`) REFERENCES `jawaban` (`id`) ON DELETE SET NULL,
  CONSTRAINT `soal_ujian_id_foreign` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `study_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `study_statistics_user_id_study_date_unique` (`user_id`,`study_date`),
  KEY `study_statistics_study_date_index` (`study_date`),
  CONSTRAINT `study_statistics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ujian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ujian` (
  `id` char(36) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `peraturan` text DEFAULT NULL,
  `jenis_ujian` varchar(20) DEFAULT NULL,
  `lama_pengerjaan` int(10) unsigned NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_akhir` datetime NOT NULL,
  `waktu_pengumuman` datetime DEFAULT NULL,
  `isPublished` tinyint(1) NOT NULL DEFAULT 0,
  `tipe_ujian` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1. satu waktu, 2. periodik',
  `tampil_kunci` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0. tidak, 1. ya, 2. ya, setelah ditutup',
  `tampil_nilai` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0. tidak, 1. ya, 2. ya, setelah ditutup',
  `tampil_poin` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0. tidak, 1. ya',
  `random` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0. tidak, 1. ya',
  `random_pilihan` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0. tidak, 1. ya',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jumlah_soal` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `ujian_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ujian_user_user_id_foreign` (`user_id`),
  KEY `ujian_user_ujian_id_foreign` (`ujian_id`),
  CONSTRAINT `ujian_user_ujian_id_foreign` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ujian_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `current_team_id` bigint(20) unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `users_detail_id_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `voucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `voucher` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) NOT NULL,
  `diskon` int(10) unsigned NOT NULL DEFAULT 0,
  `himada_id` char(36) DEFAULT NULL,
  `kuota` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `voucher_kode_unique` (`kode`),
  KEY `voucher_himada_id_foreign` (`himada_id`),
  CONSTRAINT `voucher_himada_id_foreign` FOREIGN KEY (`himada_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `wilayah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wilayah` (
  `kode` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  PRIMARY KEY (`kode`),
  KEY `wilayah_kode_index` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` VALUES (2,'2014_10_12_100000_create_password_reset_tokens_table',1);
INSERT INTO `migrations` VALUES (3,'2014_10_12_200000_add_two_factor_columns_to_users_table',1);
INSERT INTO `migrations` VALUES (4,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` VALUES (5,'2019_12_14_000001_create_personal_access_tokens_table',1);
INSERT INTO `migrations` VALUES (6,'2023_04_07_152137_create_permission_tables',1);
INSERT INTO `migrations` VALUES (7,'2023_04_08_162328_create_ujian_table',1);
INSERT INTO `migrations` VALUES (8,'2023_04_08_170037_rename_waktu_pengerjaan_to_lama_pengerjaan_table_ujian',1);
INSERT INTO `migrations` VALUES (9,'2023_04_09_073245_add_jumlah_soal_to_table_ujian',1);
INSERT INTO `migrations` VALUES (10,'2023_04_09_073915_create_soal_table',1);
INSERT INTO `migrations` VALUES (11,'2023_04_09_151303_create_jawaban_table',1);
INSERT INTO `migrations` VALUES (12,'2023_04_12_070302_add_is_published_to_tbl_ujian',1);
INSERT INTO `migrations` VALUES (13,'2023_04_13_035037_create_pembelian_table',1);
INSERT INTO `migrations` VALUES (14,'2023_04_13_150635_add_status_to_table_pembelian',1);
INSERT INTO `migrations` VALUES (15,'2023_04_14_145647_add_jenis_pembayaran_to_table_pembelian',1);
INSERT INTO `migrations` VALUES (16,'2023_04_16_104156_create_jawaban_peserta_table',1);
INSERT INTO `migrations` VALUES (17,'2023_04_16_113315_add_soal_id_to_jawaban_peserta_table',1);
INSERT INTO `migrations` VALUES (18,'2023_04_16_122014_create_status_pengerjaan_to_table_pembelian',1);
INSERT INTO `migrations` VALUES (19,'2023_04_18_095955_add_ragu_ragu_to_jawaban_peserta_table',1);
INSERT INTO `migrations` VALUES (20,'2023_04_19_144409_add_waktu_mulai_pengerjaan_to_pembelian_table',1);
INSERT INTO `migrations` VALUES (21,'2023_04_27_085203_add_waktu_selesai_pengerjaan_to_pembelian_table',1);
INSERT INTO `migrations` VALUES (22,'2023_05_23_201909_add_jenis_tryout_to_ujian_table',1);
INSERT INTO `migrations` VALUES (23,'2023_05_24_063211_add_jenis_soal_to_soal_table',1);
INSERT INTO `migrations` VALUES (24,'2023_05_24_071208_add_point_and_modify_jawaban_to_jawaban_table',1);
INSERT INTO `migrations` VALUES (25,'2023_06_16_063842_create_sessions_table',1);
INSERT INTO `migrations` VALUES (26,'2023_06_18_101245_delete_id_kunci_jawaban_in_soal_table',1);
INSERT INTO `migrations` VALUES (27,'2024_01_18_081440_create_paket_ujian_table',1);
INSERT INTO `migrations` VALUES (28,'2024_01_18_082036_create_paket_ujian_ujian_table',1);
INSERT INTO `migrations` VALUES (29,'2024_01_21_152307_modify_ujian_table',1);
INSERT INTO `migrations` VALUES (30,'2024_01_21_160131_delete_harga_in_ujian_table',1);
INSERT INTO `migrations` VALUES (31,'2024_01_22_145816_add_poin_kosong_to_soal_table',1);
INSERT INTO `migrations` VALUES (32,'2024_01_25_130218_add_nilai_benar_nilai_salah_to_soal_table',1);
INSERT INTO `migrations` VALUES (33,'2024_01_28_071029_create_voucher_table',1);
INSERT INTO `migrations` VALUES (34,'2024_01_28_152949_change_ujian_id_to_paket_id_in_pembelian_table',1);
INSERT INTO `migrations` VALUES (35,'2024_01_30_115234_modify_pembelian_table',1);
INSERT INTO `migrations` VALUES (36,'2024_01_30_123428_add_harga_to_pembelian_table',1);
INSERT INTO `migrations` VALUES (37,'2024_01_30_163359_create_ujian_user_table',1);
INSERT INTO `migrations` VALUES (38,'2024_02_01_142814_add_poin_to_jawaban_peserta_table',1);
INSERT INTO `migrations` VALUES (39,'2024_02_01_170437_add_is_first_to_ujian_user_table',1);
INSERT INTO `migrations` VALUES (40,'2024_02_01_185404_add_pembahasan_to_soal_table',1);
INSERT INTO `migrations` VALUES (41,'2024_02_02_142046_add_google_id_to_users_table',1);
INSERT INTO `migrations` VALUES (42,'2024_02_02_173939_create_users_detail_table',1);
INSERT INTO `migrations` VALUES (43,'2024_02_02_211442_add_status_users_to_users_table',1);
INSERT INTO `migrations` VALUES (44,'2024_03_25_054646_add_nama_kelompok_bius_to_pembelian_table',1);
INSERT INTO `migrations` VALUES (45,'2024_03_25_070348_add_nama_kelompok_to_users_detail_table',1);
INSERT INTO `migrations` VALUES (46,'2024_04_19_082120_create_pengumuman_table',1);
INSERT INTO `migrations` VALUES (47,'2024_05_01_195802_create_faq_table',1);
INSERT INTO `migrations` VALUES (48,'2024_05_02_170848_add_pinned_to_faq_table',1);
INSERT INTO `migrations` VALUES (49,'2024_12_14_100000_create_live_classes_table',1);
INSERT INTO `migrations` VALUES (50,'2024_12_14_110000_create_materials_table',1);
INSERT INTO `migrations` VALUES (51,'2024_12_14_120000_add_batch_id_and_mapel_to_live_classes_and_materials',1);
INSERT INTO `migrations` VALUES (52,'2024_12_15_100000_create_bank_soal_table',1);
INSERT INTO `migrations` VALUES (53,'2025_01_18_000001_create_articles_table',1);
INSERT INTO `migrations` VALUES (54,'2025_01_18_000002_create_learning_progress_table',1);
INSERT INTO `migrations` VALUES (55,'2025_03_11_001039_create_formasi_table',1);
INSERT INTO `migrations` VALUES (56,'2025_03_11_001039_create_prodi_table',1);
INSERT INTO `migrations` VALUES (57,'2025_03_11_001040_create_wilayah_table',1);
INSERT INTO `migrations` VALUES (58,'2025_10_18_001400_add_missing_columns_to_ujian_table',1);
INSERT INTO `migrations` VALUES (59,'2025_10_19_000000_add_whatsapp_group_link_to_paket_ujian_table',1);
INSERT INTO `migrations` VALUES (60,'2025_11_06_041320_add_is_featured_to_paket_ujian_table',1);
INSERT INTO `migrations` VALUES (64,'2025_11_06_044100_add_ujian_user_id_to_jawaban_peserta_table',2);
INSERT INTO `migrations` VALUES (65,'2025_11_06_044200_make_pembelian_id_nullable_in_jawaban_peserta',2);
INSERT INTO `migrations` VALUES (69,'2025_11_06_044626_add_manual_payment_fields_to_pembelian_table',3);
