-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table sewa_mobil.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.mereks
CREATE TABLE IF NOT EXISTS `mereks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.mereks: ~8 rows (approximately)
/*!40000 ALTER TABLE `mereks` DISABLE KEYS */;
INSERT INTO `mereks` (`id`, `nama`, `created_at`, `updated_at`) VALUES
	(1, 'a', NULL, NULL),
	(2, 'b', NULL, NULL),
	(3, 'c', NULL, NULL),
	(4, 'd', NULL, NULL),
	(5, 'e', NULL, NULL),
	(6, 'f', NULL, NULL),
	(7, 'g', NULL, NULL),
	(8, 'h', NULL, NULL);
/*!40000 ALTER TABLE `mereks` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.migrations: ~10 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2014_10_12_100000_create_password_resets_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2023_09_22_075747_create_permission_tables', 1),
	(7, '2023_12_18_074255_create_mereks_table', 1),
	(8, '2023_12_19_072700_create_mobils_table', 1),
	(9, '2023_12_19_073758_create_user_details_table', 1),
	(10, '2023_12_19_083956_create_peminjamen_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.mobils
CREATE TABLE IF NOT EXISTS `mobils` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `merek_id` bigint(20) unsigned NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif` bigint(20) NOT NULL,
  `status` enum('a','t') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobils_plat_unique` (`plat`),
  KEY `mobils_merek_id_foreign` (`merek_id`),
  CONSTRAINT `mobils_merek_id_foreign` FOREIGN KEY (`merek_id`) REFERENCES `mereks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.mobils: ~8 rows (approximately)
/*!40000 ALTER TABLE `mobils` DISABLE KEYS */;
INSERT INTO `mobils` (`id`, `merek_id`, `model`, `plat`, `tarif`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 'aa', 'A 123 B', 250000, 'a', NULL, NULL),
	(2, 2, 'bb', 'A 124 B', 250000, 'a', NULL, NULL),
	(3, 3, 'cc', 'G 123 K', 250000, 'a', NULL, NULL),
	(4, 4, 'dd', 'G 234 L', 250000, 'a', NULL, NULL),
	(5, 5, 'ee', 'G 2432 J', 250000, 'a', NULL, NULL),
	(6, 6, 'ff', 'A 12312 B', 250000, 'a', NULL, NULL),
	(7, 7, 'gg', 'W 898 E', 250000, 'a', NULL, NULL),
	(8, 8, 'hh', 'W 234 Y', 250000, 'a', NULL, NULL);
/*!40000 ALTER TABLE `mobils` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.model_has_permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.model_has_roles: ~2 rows (approximately)
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 2);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.password_reset_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.peminjamen
CREATE TABLE IF NOT EXISTS `peminjamen` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `mobil_id` bigint(20) unsigned NOT NULL,
  `tanggal_awal` date NOT NULL,
  `tanggal_akhir` date NOT NULL,
  `tanggal_pengembalian` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 's=sudah,b=belum',
  `tarif` bigint(20) NOT NULL,
  `total` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peminjamen_user_id_foreign` (`user_id`),
  KEY `peminjamen_mobil_id_foreign` (`mobil_id`),
  CONSTRAINT `peminjamen_mobil_id_foreign` FOREIGN KEY (`mobil_id`) REFERENCES `mobils` (`id`) ON DELETE CASCADE,
  CONSTRAINT `peminjamen_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.peminjamen: ~7 rows (approximately)
/*!40000 ALTER TABLE `peminjamen` DISABLE KEYS */;
INSERT INTO `peminjamen` (`id`, `user_id`, `mobil_id`, `tanggal_awal`, `tanggal_akhir`, `tanggal_pengembalian`, `status`, `tarif`, `total`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2023-12-19', '2023-12-20', NULL, 'b', 150000, 300000, '2023-12-19 19:00:48', '2023-12-19 19:00:50'),
	(2, 1, 5, '2024-01-03', '2024-01-25', NULL, 'b', 150000, 300000, '2023-12-19 19:00:48', '2023-12-19 19:00:50'),
	(3, 1, 5, '2024-01-28', '2024-01-30', NULL, 'b', 150000, 300000, '2023-12-19 19:00:48', '2023-12-19 19:00:50'),
	(4, 2, 1, '2023-12-17', '2023-12-18', '2023-12-19', 's', 250000, 500000, '2023-12-19 15:36:50', '2023-12-19 17:06:59'),
	(6, 2, 3, '2023-12-24', '2023-12-31', NULL, 'x', 250000, 0, '2023-12-19 16:21:18', '2023-12-19 16:57:53'),
	(7, 2, 3, '2023-12-24', '2023-12-31', NULL, 'b', 250000, 0, '2023-12-19 16:58:36', '2023-12-19 16:58:36'),
	(8, 2, 6, '2023-12-20', '2023-12-22', NULL, 'b', 250000, 0, '2023-12-19 17:08:14', '2023-12-19 17:08:14');
/*!40000 ALTER TABLE `peminjamen` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.permissions: ~7 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'dashboard', 'web', '2023-12-19 08:43:36', '2023-12-19 08:43:36'),
	(2, 'merek', 'web', '2023-12-19 08:43:36', '2023-12-19 08:43:36'),
	(3, 'mobil', 'web', '2023-12-19 08:43:37', '2023-12-19 08:43:37'),
	(4, 'peminjaman', 'web', '2023-12-19 08:43:37', '2023-12-19 08:43:37'),
	(5, 'pengembalian', 'web', '2023-12-19 08:43:37', '2023-12-19 08:43:37'),
	(6, 'pengguna', 'web', '2023-12-19 08:43:37', '2023-12-19 08:43:37'),
	(7, 'peran pengguna', 'web', '2023-12-19 08:43:37', '2023-12-19 08:43:37');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.personal_access_tokens: ~0 rows (approximately)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.roles: ~2 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'developer', 'web', '2023-12-19 08:43:37', '2023-12-19 08:43:37'),
	(2, 'penyewa', 'web', '2023-12-19 08:43:37', '2023-12-19 08:43:37');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.role_has_permissions: ~7 rows (approximately)
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(2, 1),
	(3, 1),
	(6, 1),
	(7, 1),
	(1, 2),
	(4, 2),
	(5, 2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
	(1, 'Admin', 'a@mail.com', '2023-12-19 08:43:37', '$2y$10$1m4WSI1HVgy3iZL23CGx1eB5TOEUvMJJBQvfO.fIel25JK37WY4pi', 'G5qCH2dPHSnwl654HRslPv52rAOtZe1Z37eBHgklKh9hQWzcDPkZsUvXCOTm', NULL, '2023-12-19 08:43:37', '2023-12-19 08:43:37'),
	(2, 'Penyewa', 'penyewa@mail.com', '2023-12-19 08:43:37', '$2y$10$HCesWiLiEX8AxjGF.mF1wu985pz7nY6DvV1rSfNDPm4Fd6NGcIQ5S', 'hTAam16ye6HwonhTMzg9mhfQCd5ryU1bG4LTAdU2Vr9ultS3ENbbZRfhFAuR', NULL, '2023-12-19 08:43:37', '2023-12-19 08:43:37');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table sewa_mobil.user_details
CREATE TABLE IF NOT EXISTS `user_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sim` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'surat izin mengemudi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_details_user_id_foreign` (`user_id`),
  CONSTRAINT `user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table sewa_mobil.user_details: ~1 rows (approximately)
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
INSERT INTO `user_details` (`id`, `user_id`, `alamat`, `telp`, `sim`, `created_at`, `updated_at`) VALUES
	(1, 2, 'pekalongan', '808980', '9080808', '2023-12-19 15:28:22', '2023-12-19 15:28:22');
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
