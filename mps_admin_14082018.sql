-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: mps_admin
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `audit`
--

DROP TABLE IF EXISTS `audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('SUBSCRIBED','UNSUBSCRIBED','COMPANY-EXPIRE','COMPANY-RENEW') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SUBSCRIBED',
  `user_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_user_id_foreign` (`user_id`),
  KEY `audit_company_id_foreign` (`company_id`),
  CONSTRAINT `audit_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  CONSTRAINT `audit_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit`
--

LOCK TABLES `audit` WRITE;
/*!40000 ALTER TABLE `audit` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stub` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `licences` int(11) NOT NULL,
  `licence_status` enum('PENDING','ACTIVE','SUSPENDED','CANCELLED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `auto_renew` tinyint(1) NOT NULL DEFAULT '1',
  `licence_start_date` timestamp NULL DEFAULT NULL,
  `licence_end_date` timestamp NULL DEFAULT NULL,
  `employee_register_passkey` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` enum('PENDING','ACTIVE','SUSPENDED','CANCELLED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  PRIMARY KEY (`id`),
  UNIQUE KEY `companies_name_unique` (`name`),
  UNIQUE KEY `companies_stub_unique` (`stub`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `companies`
--

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;
INSERT INTO `companies` VALUES (1,'Company A','compa',NULL,2000,'ACTIVE',1,'2018-08-14 00:00:00','2019-08-13 00:00:00','eyJpdiI6InYxQkVOa3c3VlhnaktCOVwvd3A1YUNRPT0iLCJ2YWx1ZSI6IlR4NlNBR3pIeW00YVpJeFVVZTNRUVpkdkoraStuY1hESk1LeUhXU3hNalU9IiwibWFjIjoiYTJjNWQ2MDFjODg3MjBhMzllZjA3MDNhMjY5Mjk2Y2JlOWQ5NmMyZWJjYjllZGJlMTdiZDdkMjk1OWVjMjE0ZCJ9','2018-08-14 09:03:06','2018-08-14 09:03:06',NULL,'ACTIVE');
/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_admins`
--

DROP TABLE IF EXISTS `company_admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_admins_user_id_foreign` (`user_id`),
  KEY `company_admins_company_id_foreign` (`company_id`),
  CONSTRAINT `company_admins_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `company_admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_admins`
--

LOCK TABLES `company_admins` WRITE;
/*!40000 ALTER TABLE `company_admins` DISABLE KEYS */;
INSERT INTO `company_admins` VALUES (1,3,1,'Comp A','Compa admin','1','2018-08-14 09:03:06','2018-08-14 09:03:31',NULL);
/*!40000 ALTER TABLE `company_admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_domains`
--

DROP TABLE IF EXISTS `company_domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_domains` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_domains_company_id_foreign` (`company_id`),
  CONSTRAINT `company_domains_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_domains`
--

LOCK TABLES `company_domains` WRITE;
/*!40000 ALTER TABLE `company_domains` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_domains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_emails`
--

DROP TABLE IF EXISTS `company_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_emails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_emails_company_id_foreign` (`company_id`),
  CONSTRAINT `company_emails_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_emails`
--

LOCK TABLES `company_emails` WRITE;
/*!40000 ALTER TABLE `company_emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_05_01_112346_create_companies_table',1),(4,'2018_05_01_132001_create_company_admins_table',1),(5,'2018_05_01_141741_create_company_domains_table',1),(6,'2018_05_09_111002_add_notes_to_company_admin_table',1),(7,'2018_05_11_112156_create_sessions_table',1),(8,'2018_05_15_125538_add_logo_to_company_table',1),(9,'2018_05_16_093856_add_company_id_to_user',1),(10,'2018_05_17_092757_add_licence_start_end_date_to_company',1),(11,'2018_05_21_135216_create_restricted_domain_table',1),(12,'2018_05_21_143159_add_licence_active_date_to_company',1),(13,'2018_05_24_110026_add_auto_renew_to_company',1),(14,'2018_05_30_142914_add_licence_status_to_company',1),(15,'2018_06_01_134245_create_company_email_address_table',1),(16,'2018_06_06_094302_insert_superuser_into_user',1),(17,'2018_07_03_095252_add_grr_to_restricted_domains',1),(18,'2018_07_05_144507_remove_company_id_from_user',1),(19,'2018_07_12_151845_add_desc_to_emails_and_domains',1),(20,'2018_07_20_104016_create_audit_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `restricted_domains`
--

DROP TABLE IF EXISTS `restricted_domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restricted_domains` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `restricted_domains`
--

LOCK TABLES `restricted_domains` WRITE;
/*!40000 ALTER TABLE `restricted_domains` DISABLE KEYS */;
INSERT INTO `restricted_domains` VALUES (1,'gmail\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(2,'googlemail\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(3,'hotmail\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(4,'yahoo\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(5,'aol\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(6,'icloud\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(7,'gmx\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(8,'sharklasers\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(9,'guerillamail\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(10,'pokemail\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(11,'spam4\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(12,'mailinator\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(13,'nwytg\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(14,'20email\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36'),(15,'grr\\..*',NULL,'2018-08-14 09:00:36','2018-08-14 09:00:36');
/*!40000 ALTER TABLE `restricted_domains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('kLmQxqA0sEo38nJIwBei0Rm8gk6ZU06nly5YB3V8',3,'192.168.10.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36','YTo1OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoidnhqWEJobkZJWW9hQjdRQXVqTkM3dTZpWWs2dHdhR0ttdHVZUUFBbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly9tcHNhZG1pbi5pbnRlY2hub2xvZ3l3aWZpLnRlc3QvY29tcGEvYWNjb3VudC1hZG1pbnMiO31zOjc6ImNvbXBhbnkiO086MTE6IkFwcFxDb21wYW55IjoyODp7czoxMDoidXNhZ2VDb3VudCI7TjtzOjExOiIAKgBmaWxsYWJsZSI7YToxMjp7aTowO3M6MTA6ImRlbGV0ZWRfYXQiO2k6MTtzOjQ6Im5hbWUiO2k6MjtzOjQ6InN0dWIiO2k6MztzOjU6ImltYWdlIjtpOjQ7czo4OiJsaWNlbmNlcyI7aTo1O3M6MTg6ImxpY2VuY2Vfc3RhcnRfZGF0ZSI7aTo2O3M6MTY6ImxpY2VuY2VfZW5kX2RhdGUiO2k6NztzOjE0OiJsaWNlbmNlX3N0YXR1cyI7aTo4O3M6MjU6ImVtcGxveWVlX3JlZ2lzdGVyX3Bhc3NrZXkiO2k6OTtzOjY6InN0YXR1cyI7aToxMDtzOjEwOiJjcmVhdGVkX2F0IjtpOjExO3M6MTA6InVwZGF0ZWRfYXQiO31zOjg6IgAqAGRhdGVzIjthOjU6e2k6MDtzOjEwOiJjcmVhdGVkX2F0IjtpOjE7czoxMDoidXBkYXRlZF9hdCI7aToyO3M6MTA6ImRlbGV0ZWRfYXQiO2k6MztzOjE4OiJsaWNlbmNlX3N0YXJ0X2RhdGUiO2k6NDtzOjE2OiJsaWNlbmNlX2VuZF9kYXRlIjt9czoxMzoiACoAY29ubmVjdGlvbiI7czo1OiJteXNxbCI7czo4OiIAKgB0YWJsZSI7TjtzOjEzOiIAKgBwcmltYXJ5S2V5IjtzOjI6ImlkIjtzOjEwOiIAKgBrZXlUeXBlIjtzOjM6ImludCI7czoxMjoiaW5jcmVtZW50aW5nIjtiOjE7czo3OiIAKgB3aXRoIjthOjA6e31zOjEyOiIAKgB3aXRoQ291bnQiO2E6MDp7fXM6MTA6IgAqAHBlclBhZ2UiO2k6MTU7czo2OiJleGlzdHMiO2I6MTtzOjE4OiJ3YXNSZWNlbnRseUNyZWF0ZWQiO2I6MDtzOjEzOiIAKgBhdHRyaWJ1dGVzIjthOjE0OntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjk6IkNvbXBhbnkgQSI7czo0OiJzdHViIjtzOjU6ImNvbXBhIjtzOjU6ImltYWdlIjtOO3M6ODoibGljZW5jZXMiO2k6MjAwMDtzOjE0OiJsaWNlbmNlX3N0YXR1cyI7czo2OiJBQ1RJVkUiO3M6MTA6ImF1dG9fcmVuZXciO2k6MTtzOjE4OiJsaWNlbmNlX3N0YXJ0X2RhdGUiO3M6MTk6IjIwMTgtMDgtMTQgMDA6MDA6MDAiO3M6MTY6ImxpY2VuY2VfZW5kX2RhdGUiO3M6MTk6IjIwMTktMDgtMTMgMDA6MDA6MDAiO3M6MjU6ImVtcGxveWVlX3JlZ2lzdGVyX3Bhc3NrZXkiO3M6MjE2OiJleUpwZGlJNkluWXhRa1ZPYTNjM1ZsaG5ha3RDT1Z3dmQzQTFZVU5SUFQwaUxDSjJZV3gxWlNJNklsUjRObE5CUjNwSWVXMDBZVnBKZUZWVlpUTlJVVnBrZGtvcmFTdHVZMWhFU2sxTGVVaFhVM2hOYWxVOUlpd2liV0ZqSWpvaVlUSmpOV1EyTURGak9EZzNNakJoTXpsbFpqQTNNRE5oTWpZNU1qazJZMkpsT1dRNU5tTXlaV0pqWWpsbFpHSmxNVGRpWkRka01qazFPV1ZqTWpFMFpDSjkiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMTgtMDgtMTQgMDk6MDM6MDYiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMTgtMDgtMTQgMDk6MDM6MDYiO3M6MTA6ImRlbGV0ZWRfYXQiO047czo2OiJzdGF0dXMiO3M6NjoiQUNUSVZFIjt9czoxMToiACoAb3JpZ2luYWwiO2E6MTQ6e3M6MjoiaWQiO2k6MTtzOjQ6Im5hbWUiO3M6OToiQ29tcGFueSBBIjtzOjQ6InN0dWIiO3M6NToiY29tcGEiO3M6NToiaW1hZ2UiO047czo4OiJsaWNlbmNlcyI7aToyMDAwO3M6MTQ6ImxpY2VuY2Vfc3RhdHVzIjtzOjY6IkFDVElWRSI7czoxMDoiYXV0b19yZW5ldyI7aToxO3M6MTg6ImxpY2VuY2Vfc3RhcnRfZGF0ZSI7czoxOToiMjAxOC0wOC0xNCAwMDowMDowMCI7czoxNjoibGljZW5jZV9lbmRfZGF0ZSI7czoxOToiMjAxOS0wOC0xMyAwMDowMDowMCI7czoyNToiZW1wbG95ZWVfcmVnaXN0ZXJfcGFzc2tleSI7czoyMTY6ImV5SnBkaUk2SW5ZeFFrVk9hM2MzVmxobmFrdENPVnd2ZDNBMVlVTlJQVDBpTENKMllXeDFaU0k2SWxSNE5sTkJSM3BJZVcwMFlWcEplRlZWWlROUlVWcGtka29yYVN0dVkxaEVTazFMZVVoWFUzaE5hbFU5SWl3aWJXRmpJam9pWVRKak5XUTJNREZqT0RnM01qQmhNemxsWmpBM01ETmhNalk1TWprMlkySmxPV1E1Tm1NeVpXSmpZamxsWkdKbE1UZGlaRGRrTWprMU9XVmpNakUwWkNKOSI7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAxOC0wOC0xNCAwOTowMzowNiI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAxOC0wOC0xNCAwOTowMzowNiI7czoxMDoiZGVsZXRlZF9hdCI7TjtzOjY6InN0YXR1cyI7czo2OiJBQ1RJVkUiO31zOjEwOiIAKgBjaGFuZ2VzIjthOjA6e31zOjg6IgAqAGNhc3RzIjthOjA6e31zOjEzOiIAKgBkYXRlRm9ybWF0IjtOO3M6MTA6IgAqAGFwcGVuZHMiO2E6MDp7fXM6MTk6IgAqAGRpc3BhdGNoZXNFdmVudHMiO2E6MDp7fXM6MTQ6IgAqAG9ic2VydmFibGVzIjthOjA6e31zOjEyOiIAKgByZWxhdGlvbnMiO2E6MDp7fXM6MTA6IgAqAHRvdWNoZXMiO2E6MDp7fXM6MTA6InRpbWVzdGFtcHMiO2I6MTtzOjk6IgAqAGhpZGRlbiI7YTowOnt9czoxMDoiACoAdmlzaWJsZSI7YTowOnt9czoxMDoiACoAZ3VhcmRlZCI7YToxOntpOjA7czoxOiIqIjt9czoxNjoiACoAZm9yY2VEZWxldGluZyI7YjowO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=',1534237505);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super User','suser@mypossibleself.com','$2y$10$WjjyIuikjTnw2TL1F65EFuSz66Y0vFQ21kMNpxfkj6j4wVLBRVv4u',1,'RAKkXOCIZRdJoFcnqt704nTY7jdMLYAxyvuSAV1fSdNMvo2Z2kpdJokoKinn','2018-08-14 09:00:36','2018-08-14 09:00:36',NULL),(2,'Michael Cooper','m@c.com','$2y$10$c6MCF2ACkezs7H0zWobX4eoWNUoSPV/gMkPHeL2nU0tg1s6ihrM6K',1,NULL,'2018-08-14 09:02:19','2018-08-14 09:02:19',NULL),(3,'Company A','comp@a.com','$2y$10$lDUnOIbiugF5JE9En8ZjAeK9u6Wgsxs.yjxyKfh8GOOfoEJgA2Q9.',2,NULL,'2018-08-14 09:03:06','2018-08-14 09:03:06',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-14  9:06:11
