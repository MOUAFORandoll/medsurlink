-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: localhost    Database: stagingmedicalink
-- ------------------------------------------------------
-- Server version	5.7.28-0ubuntu0.18.04.4

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
-- Table structure for table `affiliations`
--

DROP TABLE IF EXISTS `affiliations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `affiliations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned NOT NULL,
  `nom` enum('One shot','Annuelle') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `affiliations_slug_unique` (`slug`),
  KEY `affiliations_patient_id_foreign` (`patient_id`),
  CONSTRAINT `affiliations_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `affiliations`
--

LOCK TABLES `affiliations` WRITE;
/*!40000 ALTER TABLE `affiliations` DISABLE KEYS */;
INSERT INTO `affiliations` VALUES (1,4,'Annuelle','2101-03-12','2102-03-12',NULL,'2019-10-09 14:32:35','2019-10-09 14:32:35','annuelle-1570638755'),(2,4,'Annuelle','2019-10-16','2020-10-16',NULL,'2019-10-15 08:16:06','2019-10-15 08:16:06','annuelle-1571134566'),(3,41,'One shot','2019-11-30','2019-11-30',NULL,'2019-10-15 09:19:48','2019-10-15 09:19:48','one-shot-1571138388'),(4,50,'Annuelle','2019-10-22','2020-10-22',NULL,'2019-10-21 06:46:03','2019-10-21 06:46:03','annuelle-1571647563');
/*!40000 ALTER TABLE `affiliations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `allergies`
--

DROP TABLE IF EXISTS `allergies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `allergies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `allergies_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `allergies`
--

LOCK TABLES `allergies` WRITE;
/*!40000 ALTER TABLE `allergies` DISABLE KEYS */;
INSERT INTO `allergies` VALUES (1,'rererer','2019-06-15','2019-10-11 07:23:37','2019-10-11 07:23:37',NULL,'rerer-1570785817'),(2,'hgjhggfhf',NULL,'2019-11-04 11:54:59','2019-11-04 11:54:59',NULL,'hgjhg-1572872099'),(3,'dgdfgdfg','2019-11-07','2019-11-07 11:05:13','2019-11-07 11:05:24',NULL,'dgdfg-1573128313'),(4,'tomate','2018-11-03','2019-11-21 11:07:19','2019-11-21 11:07:30',NULL,'tomat-1574338039'),(5,'allergie au sucre','2019-11-04','2019-11-23 16:31:36','2019-11-23 16:31:36',NULL,'aller-1574530296'),(6,'Iode',NULL,'2019-11-23 18:01:43','2019-11-23 18:01:43',NULL,'iode-1574535703'),(7,'Nouvelle allergies','2019-11-04','2019-11-23 18:03:37','2019-11-23 18:03:37',NULL,'nouve-1574535817');
/*!40000 ALTER TABLE `allergies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `antecedents`
--

DROP TABLE IF EXISTS `antecedents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `antecedents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dossier_medical_id` bigint(20) unsigned NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `antecedents_slug_unique` (`slug`),
  KEY `antecedents_dossier_medical_id_foreign` (`dossier_medical_id`),
  CONSTRAINT `antecedents_dossier_medical_id_foreign` FOREIGN KEY (`dossier_medical_id`) REFERENCES `dossier_medicals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `antecedents`
--

LOCK TABLES `antecedents` WRITE;
/*!40000 ALTER TABLE `antecedents` DISABLE KEYS */;
INSERT INTO `antecedents` VALUES (1,2,'ghjghj',NULL,'jhgjgh','2019-10-11 12:51:59','2019-10-11 13:28:16','2019-10-11 13:28:16','jhgjgh-1570805519'),(2,3,'Pneumonie',NULL,'Médical','2019-10-15 10:58:12','2019-10-15 14:32:53','2019-10-15 14:32:53','medical-1571144292'),(3,3,'Appendicectomie',NULL,'Chirurgical-Coeliosocpie','2019-10-19 15:34:24','2019-10-19 15:34:24',NULL,'chirurgical-coeliosocpie-1571506464'),(4,3,'sdfsdfds','2019-02-02','Chirugical','2019-11-08 13:29:23','2019-11-08 13:29:23',NULL,'chirugical-1573223363'),(5,3,'sdsddsf','2018-12-20','Familial','2019-11-08 13:29:43','2019-11-08 13:29:43',NULL,'familial-1573223383'),(6,11,'erezrze','2019-02-03','Chirugical','2019-11-19 17:46:22','2019-11-21 11:38:01','2019-11-21 11:38:01','chirugical-1574189182'),(7,10,'Fausse couche','2019-07-02','Gynéco-obstétrique','2019-11-20 19:58:44','2019-11-20 19:58:44',NULL,'gyneco-obstetrique-1574283524'),(8,9,'tombé tombé','2000-05-03','Familial','2019-11-21 11:08:28','2019-11-21 11:08:28',NULL,'familial-1574338108'),(9,7,'Antecedent de personne tres cool mais colerique','2019-11-04','Médical','2019-11-23 16:31:57','2019-11-23 16:31:57',NULL,'medical-1574530317'),(10,5,'Appendicectomie','1988-10-05','Chirugical','2019-11-23 18:01:14','2019-11-23 18:01:14',NULL,'chirugical-1574535674'),(11,7,'Nouvelle antecedent','2019-11-04','Médical','2019-11-23 18:03:57','2019-11-23 18:03:57',NULL,'medical-1574535837'),(12,9,'Migraine','2019-02-20','Médical','2019-11-24 11:27:43','2019-11-24 11:27:43',NULL,'medical-1574598463'),(13,9,'Artérite oblitérante des membres inférieurs','1991-02-02','Médical','2019-11-24 11:29:40','2019-11-24 11:29:40',NULL,'medical-1574598580'),(14,9,'Angioplastie stenting artère poplitée gauche','1991-05-03','Chirugical','2019-11-24 11:30:25','2019-11-24 11:30:25',NULL,'chirugical-1574598625'),(15,9,'HTA','2015-01-12','Médical','2019-11-24 11:31:52','2019-11-24 11:31:52',NULL,'medical-1574598712');
/*!40000 ALTER TABLE `antecedents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auteurs`
--

DROP TABLE IF EXISTS `auteurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auteurs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `auteurable_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auteurable_id` bigint(20) unsigned DEFAULT NULL,
  `operationable_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operationable_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `auteurs_auteurable_type_auteurable_id_index` (`auteurable_type`,`auteurable_id`),
  KEY `auteurs_operationable_type_operationable_id_index` (`operationable_type`,`operationable_id`),
  KEY `auteurs_user_id_foreign` (`user_id`),
  KEY `auteurs_patient_id_foreign` (`patient_id`),
  CONSTRAINT `auteurs_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  CONSTRAINT `auteurs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=596 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auteurs`
--

LOCK TABLES `auteurs` WRITE;
/*!40000 ALTER TABLE `auteurs` DISABLE KEYS */;
INSERT INTO `auteurs` VALUES (51,1,'Admin',NULL,'Gestionnaire',25,'create',NULL,'2019-10-10 09:52:56','2019-10-10 09:52:56',NULL),(52,1,'Admin',NULL,'Gestionnaire',26,'create',NULL,'2019-10-10 11:14:58','2019-10-10 11:14:58',NULL),(53,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-10 11:17:56','2019-10-10 11:17:56',NULL),(54,1,'Admin',NULL,'Souscripteur',27,'create',NULL,'2019-10-10 11:18:33','2019-10-10 11:18:33',NULL),(55,1,'Admin',NULL,'Gestionnaire',28,'create',NULL,'2019-10-10 11:19:45','2019-10-10 11:19:45',NULL),(56,1,'Admin',NULL,'Gestionnaire',29,'create',NULL,'2019-10-10 11:21:21','2019-10-10 11:21:21',NULL),(57,1,'Admin',NULL,'Gestionnaire',30,'create',NULL,'2019-10-10 11:25:47','2019-10-10 11:25:47',NULL),(58,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-10 11:43:27','2019-10-10 11:43:27',NULL),(59,1,'Admin',NULL,'Gestionnaire',31,'create',NULL,'2019-10-10 11:44:02','2019-10-10 11:44:02',NULL),(60,1,'Admin',NULL,'Gestionnaire',32,'create',NULL,'2019-10-10 11:44:20','2019-10-10 11:44:20',NULL),(61,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-10 11:44:47','2019-10-10 11:44:47',NULL),(62,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-10 11:45:57','2019-10-10 11:45:57',NULL),(64,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-10 12:01:10','2019-10-10 12:01:10',NULL),(65,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-10 12:05:23','2019-10-10 12:05:23',NULL),(66,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-10 12:07:20','2019-10-10 12:07:20',NULL),(67,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-10 13:53:23','2019-10-10 13:53:23',NULL),(68,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-10 14:06:41','2019-10-10 14:06:41',NULL),(69,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 05:36:27','2019-10-11 05:36:27',NULL),(70,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 06:42:29','2019-10-11 06:42:29',NULL),(71,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 06:44:07','2019-10-11 06:44:07',NULL),(72,1,'Admin',NULL,'Gestionnaire',33,'create',NULL,'2019-10-11 06:48:46','2019-10-11 06:48:46',NULL),(73,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 06:50:09','2019-10-11 06:50:09',NULL),(74,1,'Admin',NULL,'Gestionnaire',34,'create',NULL,'2019-10-11 06:50:42','2019-10-11 06:50:42',NULL),(75,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:06:32','2019-10-11 07:06:32',NULL),(76,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:07:36','2019-10-11 07:07:36',NULL),(77,1,'Admin',NULL,'Gestionnaire',35,'create',NULL,'2019-10-11 07:08:08','2019-10-11 07:08:08',NULL),(78,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:15:12','2019-10-11 07:15:12',NULL),(79,1,'Admin',NULL,'DossierMedical',2,'create',NULL,'2019-10-11 07:22:43','2019-10-11 07:22:43',NULL),(80,1,'Admin',NULL,'Allergie',1,'create',NULL,'2019-10-11 07:23:37','2019-10-11 07:23:37',NULL),(81,1,'Admin',NULL,'DossierAllergie',2,'attach',NULL,'2019-10-11 07:23:37','2019-10-11 07:23:37',NULL),(82,1,'Admin',NULL,'TraitementActuel',1,'create',NULL,'2019-10-11 07:23:56','2019-10-11 07:23:56',NULL),(83,1,'Admin',NULL,'TraitementActuel',2,'create',NULL,'2019-10-11 07:24:03','2019-10-11 07:24:03',NULL),(84,1,'Admin',NULL,'TraitementActuel',3,'create',NULL,'2019-10-11 07:24:16','2019-10-11 07:24:16',NULL),(85,1,'Admin',NULL,'ConsultationObstetrique',1,'create',NULL,'2019-10-11 07:25:11','2019-10-11 07:25:11',NULL),(86,1,'Admin',NULL,'ConsultationObstetrique',1,'transmettre',NULL,'2019-10-11 07:25:27','2019-10-11 07:25:27',NULL),(87,1,'Admin',NULL,'ConsultationObstetrique',1,'archive',NULL,'2019-10-11 07:25:32','2019-10-11 07:25:32',NULL),(88,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:33:52','2019-10-11 07:33:52',NULL),(89,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:36:36','2019-10-11 07:36:36',NULL),(90,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:37:32','2019-10-11 07:37:32',NULL),(91,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:41:49','2019-10-11 07:41:49',NULL),(92,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:42:14','2019-10-11 07:42:14',NULL),(93,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:44:22','2019-10-11 07:44:22',NULL),(94,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:45:49','2019-10-11 07:45:49',NULL),(95,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:47:36','2019-10-11 07:47:36',NULL),(96,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:54:48','2019-10-11 07:54:48',NULL),(97,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:58:08','2019-10-11 07:58:08',NULL),(98,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 07:58:50','2019-10-11 07:58:50',NULL),(99,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 08:14:29','2019-10-11 08:14:29',NULL),(100,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 08:21:52','2019-10-11 08:21:52',NULL),(101,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 08:41:46','2019-10-11 08:41:46',NULL),(102,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 08:48:42','2019-10-11 08:48:42',NULL),(103,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 08:51:20','2019-10-11 08:51:20',NULL),(104,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 08:51:56','2019-10-11 08:51:56',NULL),(105,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 08:55:57','2019-10-11 08:55:57',NULL),(106,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 09:33:48','2019-10-11 09:33:48',NULL),(107,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 09:33:53','2019-10-11 09:33:53',NULL),(108,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 09:38:24','2019-10-11 09:38:24',NULL),(109,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 10:26:24','2019-10-11 10:26:24',NULL),(110,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 10:49:42','2019-10-11 10:49:42',NULL),(111,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 10:49:59','2019-10-11 10:49:59',NULL),(112,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 10:50:04','2019-10-11 10:50:04',NULL),(113,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 10:56:30','2019-10-11 10:56:30',NULL),(114,1,'Admin',NULL,'Gestionnaire',36,'create',NULL,'2019-10-11 10:57:32','2019-10-11 10:57:32',NULL),(115,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 11:24:06','2019-10-11 11:24:06',NULL),(116,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 11:31:13','2019-10-11 11:31:13',NULL),(117,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 11:35:38','2019-10-11 11:35:38',NULL),(118,1,'Admin',NULL,'ConsultationPrenatale',1,'create',NULL,'2019-10-11 11:48:12','2019-10-11 11:48:12',NULL),(119,1,'Admin',NULL,'ConsultationPrenatale',1,'transmettre',NULL,'2019-10-11 11:50:42','2019-10-11 11:50:42',NULL),(120,1,'Admin',NULL,'ConsultationMedecineGenerale',1,'create',NULL,'2019-10-11 11:54:08','2019-10-11 11:54:08',NULL),(121,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 11:56:00','2019-10-11 11:56:00',NULL),(122,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 12:01:02','2019-10-11 12:01:02',NULL),(123,1,'Admin',NULL,'Gestionnaire',37,'create',NULL,'2019-10-11 12:02:10','2019-10-11 12:02:10',NULL),(124,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 12:03:43','2019-10-11 12:03:43',NULL),(125,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 12:06:03','2019-10-11 12:06:03',NULL),(126,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 12:08:18','2019-10-11 12:08:18',NULL),(127,1,'Admin',NULL,'Motif',2,'create',NULL,'2019-10-11 12:17:11','2019-10-11 12:17:11',NULL),(128,1,'Admin',NULL,'ConsultationMotif',2,'attach',NULL,'2019-10-11 12:17:11','2019-10-11 12:17:11',NULL),(129,1,'Admin',NULL,'Antecedent',1,'create',NULL,'2019-10-11 12:51:59','2019-10-11 12:51:59',NULL),(130,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 13:05:11','2019-10-11 13:05:11',NULL),(131,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 13:11:56','2019-10-11 13:11:56',NULL),(132,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 13:14:26','2019-10-11 13:14:26',NULL),(133,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 13:16:59','2019-10-11 13:16:59',NULL),(134,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 13:18:30','2019-10-11 13:18:30',NULL),(135,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 13:23:24','2019-10-11 13:23:24',NULL),(136,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 13:25:28','2019-10-11 13:25:28',NULL),(137,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 13:27:02','2019-10-11 13:27:02',NULL),(138,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 13:29:46','2019-10-11 13:29:46',NULL),(139,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 13:34:02','2019-10-11 13:34:02',NULL),(140,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-11 13:37:06','2019-10-11 13:37:06',NULL),(141,1,'Admin',NULL,'ConsultationPrenatale',1,'archive',NULL,'2019-10-11 13:39:12','2019-10-11 13:39:12',NULL),(142,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-13 08:11:01','2019-10-13 08:11:01',NULL),(143,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-13 08:18:35','2019-10-13 08:18:35',NULL),(144,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-14 08:48:57','2019-10-14 08:48:57',NULL),(145,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-14 09:06:55','2019-10-14 09:06:55',NULL),(146,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-14 09:16:25','2019-10-14 09:16:25',NULL),(147,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-15 08:07:13','2019-10-15 08:07:13',NULL),(148,1,'Admin',NULL,'Affiliation',2,'create',NULL,'2019-10-15 08:16:06','2019-10-15 08:16:06',NULL),(149,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-15 08:21:48','2019-10-15 08:21:48',NULL),(150,1,'Admin',NULL,'Profession',3,'create',NULL,'2019-10-15 08:28:23','2019-10-15 08:28:23',NULL),(151,1,'Admin',NULL,'Profession',4,'create',NULL,'2019-10-15 08:28:48','2019-10-15 08:28:48',NULL),(152,1,'Admin',NULL,'Profession',5,'create',NULL,'2019-10-15 08:29:02','2019-10-15 08:29:02',NULL),(153,1,'Admin',NULL,'Specialite',1,'create',NULL,'2019-10-15 08:29:55','2019-10-15 08:29:55',NULL),(154,1,'Admin',NULL,'Specialite',2,'create',NULL,'2019-10-15 08:30:14','2019-10-15 08:30:14',NULL),(155,1,'Admin',NULL,'Specialite',3,'create',NULL,'2019-10-15 08:30:33','2019-10-15 08:30:33',NULL),(156,1,'Admin',NULL,'Specialite',4,'create',NULL,'2019-10-15 08:30:46','2019-10-15 08:30:46',NULL),(157,1,'Admin',NULL,'Specialite',5,'create',NULL,'2019-10-15 08:30:59','2019-10-15 08:30:59',NULL),(158,1,'Admin',NULL,'EtablissementExercice',2,'create',NULL,'2019-10-15 08:31:46','2019-10-15 08:31:46',NULL),(159,1,'Admin',NULL,'EtablissementExercice',3,'create',NULL,'2019-10-15 08:32:03','2019-10-15 08:32:03',NULL),(160,1,'Admin',NULL,'Souscripteur',38,'create',NULL,'2019-10-15 08:38:29','2019-10-15 08:38:29',NULL),(161,1,'Admin',NULL,'Souscripteur',39,'create',NULL,'2019-10-15 08:40:31','2019-10-15 08:40:31',NULL),(162,1,'Admin',NULL,'Patient',40,'create',NULL,'2019-10-15 08:45:12','2019-10-15 08:45:12',NULL),(163,1,'Admin',NULL,'Patient',41,'create',NULL,'2019-10-15 08:48:17','2019-10-15 08:48:17',NULL),(164,1,'Admin',NULL,'Gestionnaire',42,'create',NULL,'2019-10-15 08:51:13','2019-10-15 08:51:13',NULL),(165,1,'Admin',NULL,'Praticien',43,'create',NULL,'2019-10-15 09:15:57','2019-10-15 09:15:57',NULL),(166,1,'Admin',NULL,'Specialite',6,'create',NULL,'2019-10-15 09:17:05','2019-10-15 09:17:05',NULL),(167,1,'Admin',NULL,'Affiliation',3,'create',NULL,'2019-10-15 09:19:48','2019-10-15 09:19:48',NULL),(168,1,'Admin',NULL,'ConsultationMedecineGenerale',2,'create',NULL,'2019-10-15 10:11:32','2019-10-15 10:11:32',NULL),(169,1,'Admin',NULL,'ConsultationObstetrique',2,'create',NULL,'2019-10-15 10:18:41','2019-10-15 10:18:41',NULL),(170,1,'Admin',NULL,'ConsultationObstetrique',3,'create',NULL,'2019-10-15 10:25:29','2019-10-15 10:25:29',NULL),(171,1,'Admin',NULL,'ConsultationMedecineGenerale',2,'transmettre',NULL,'2019-10-15 10:28:38','2019-10-15 10:28:38',NULL),(172,1,'Admin',NULL,'ConsultationPrenatale',2,'create',NULL,'2019-10-15 10:45:45','2019-10-15 10:45:45',NULL),(173,1,'Admin',NULL,'Echographie',1,'create',NULL,'2019-10-15 10:54:12','2019-10-15 10:54:12',NULL),(174,1,'Admin',NULL,'Antecedent',2,'create',NULL,'2019-10-15 10:58:12','2019-10-15 10:58:12',NULL),(175,1,'Admin',NULL,'ParametreCommun',1,'create',NULL,'2019-10-15 10:59:25','2019-10-15 10:59:25',NULL),(176,42,'Gestionnaire',42,'Gestionnaire',42,'Connexion',NULL,'2019-10-15 11:05:22','2019-10-15 11:05:22',NULL),(177,42,'Gestionnaire',42,'Praticien',44,'create',NULL,'2019-10-15 11:09:03','2019-10-15 11:09:03',NULL),(178,42,'Gestionnaire',42,'Praticien',45,'create',NULL,'2019-10-15 11:15:10','2019-10-15 11:15:10',NULL),(179,42,'Gestionnaire',42,'Souscripteur',46,'create',NULL,'2019-10-15 11:19:23','2019-10-15 11:19:23',NULL),(180,44,'Praticien',44,'Praticien',44,'Connexion',NULL,'2019-10-15 11:21:41','2019-10-15 11:21:41',NULL),(181,45,'Praticien',45,'Praticien',45,'Connexion',NULL,'2019-10-15 11:24:44','2019-10-15 11:24:44',NULL),(182,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-15 13:39:23','2019-10-15 13:39:23',NULL),(183,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-15 13:40:01','2019-10-15 13:40:01',NULL),(184,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-15 14:22:44','2019-10-15 14:22:44',NULL),(185,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-15 14:30:50','2019-10-15 14:30:50',NULL),(186,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-15 14:50:27','2019-10-15 14:50:27',NULL),(187,1,'Admin',NULL,'Gestionnaire',47,'create',NULL,'2019-10-15 16:40:17','2019-10-15 16:40:17',NULL),(188,1,'Admin',NULL,'Patient',48,'create',NULL,'2019-10-15 16:46:02','2019-10-15 16:46:02',NULL),(189,1,'Admin',NULL,'ConsultationMedecineGenerale',3,'create',NULL,'2019-10-15 16:52:34','2019-10-15 16:52:34',NULL),(190,1,'Admin',NULL,'ConsultationMedecineGenerale',3,'transmettre',NULL,'2019-10-15 16:53:03','2019-10-15 16:53:03',NULL),(191,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-16 05:34:30','2019-10-16 05:34:30',NULL),(192,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-16 07:28:25','2019-10-16 07:28:25',NULL),(193,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-16 09:44:28','2019-10-16 09:44:28',NULL),(194,1,'Admin',NULL,'Patient',49,'create',NULL,'2019-10-16 09:46:36','2019-10-16 09:46:36',NULL),(195,1,'Admin',NULL,'ConsultationObstetrique',4,'create',NULL,'2019-10-16 12:11:05','2019-10-16 12:11:05',NULL),(196,1,'Admin',NULL,'TraitementActuel',4,'create',NULL,'2019-10-16 12:12:36','2019-10-16 12:12:36',NULL),(197,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-16 14:55:19','2019-10-16 14:55:19',NULL),(198,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-16 15:21:00','2019-10-16 15:21:00',NULL),(199,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-16 15:57:27','2019-10-16 15:57:27',NULL),(200,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-16 20:01:52','2019-10-16 20:01:52',NULL),(201,1,'Admin',NULL,'ConsultationObstetrique',2,'transmettre',NULL,'2019-10-16 20:02:40','2019-10-16 20:02:40',NULL),(202,1,'Admin',NULL,'ConsultationObstetrique',2,'archive',NULL,'2019-10-16 20:02:51','2019-10-16 20:02:51',NULL),(203,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-16 20:48:12','2019-10-16 20:48:12',NULL),(204,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-17 06:28:20','2019-10-17 06:28:20',NULL),(205,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-17 10:22:52','2019-10-17 10:22:52',NULL),(206,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-17 15:38:52','2019-10-17 15:38:52',NULL),(207,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-17 15:40:31','2019-10-17 15:40:31',NULL),(208,1,'Admin',NULL,'ConsultationObstetrique',5,'create',NULL,'2019-10-17 15:42:00','2019-10-17 15:42:00',NULL),(209,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-18 06:50:03','2019-10-18 06:50:03',NULL),(210,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-18 12:38:14','2019-10-18 12:38:14',NULL),(211,1,'Admin',NULL,'Motif',3,'create',NULL,'2019-10-18 13:03:59','2019-10-18 13:03:59',NULL),(212,1,'Admin',NULL,'ConsultationMotif',3,'attach',NULL,'2019-10-18 13:03:59','2019-10-18 13:03:59',NULL),(213,1,'Admin',NULL,'TraitementActuel',5,'create',NULL,'2019-10-18 13:04:38','2019-10-18 13:04:38',NULL),(214,1,'Admin',NULL,'ConsultationMedecineGenerale',1,'transmettre',NULL,'2019-10-18 13:05:20','2019-10-18 13:05:20',NULL),(215,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-18 14:01:14','2019-10-18 14:01:14',NULL),(216,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-18 14:47:02','2019-10-18 14:47:02',NULL),(217,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-18 16:47:49','2019-10-18 16:47:49',NULL),(218,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-18 16:49:50','2019-10-18 16:49:50',NULL),(219,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-18 16:50:29','2019-10-18 16:50:29',NULL),(220,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-18 16:53:15','2019-10-18 16:53:15',NULL),(221,1,'Admin',NULL,'Patient',50,'create',NULL,'2019-10-18 16:55:20','2019-10-18 16:55:20',NULL),(222,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-18 16:57:27','2019-10-18 16:57:27',NULL),(223,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-18 17:00:46','2019-10-18 17:00:46',NULL),(224,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-18 17:17:18','2019-10-18 17:17:18',NULL),(225,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-18 17:18:40','2019-10-18 17:18:40',NULL),(226,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-18 17:20:36','2019-10-18 17:20:36',NULL),(227,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-19 15:33:12','2019-10-19 15:33:12',NULL),(228,1,'Admin',NULL,'Antecedent',3,'create',NULL,'2019-10-19 15:34:24','2019-10-19 15:34:24',NULL),(229,1,'Admin',NULL,'ConsultationMedecineGenerale',4,'create',NULL,'2019-10-19 15:37:05','2019-10-19 15:37:05',NULL),(230,1,'Admin',NULL,'ConsultationObstetrique',6,'create',NULL,'2019-10-19 15:43:17','2019-10-19 15:43:17',NULL),(231,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-19 19:00:51','2019-10-19 19:00:51',NULL),(232,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-19 19:02:06','2019-10-19 19:02:06',NULL),(233,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-20 08:07:29','2019-10-20 08:07:29',NULL),(234,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-21 05:45:33','2019-10-21 05:45:33',NULL),(235,1,'Admin',NULL,'Affiliation',4,'create',NULL,'2019-10-21 06:46:03','2019-10-21 06:46:03',NULL),(236,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-21 10:55:28','2019-10-21 10:55:28',NULL),(237,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-21 17:53:56','2019-10-21 17:53:56',NULL),(238,1,'Admin',NULL,'ConsultationMedecineGenerale',5,'create',NULL,'2019-10-21 17:56:35','2019-10-21 17:56:35',NULL),(239,1,'Admin',NULL,'ConsultationMedecineGenerale',3,'archive',NULL,'2019-10-21 17:58:12','2019-10-21 17:58:12',NULL),(240,1,'Admin',NULL,'Resultat',1,'create',NULL,'2019-10-21 18:03:15','2019-10-21 18:03:15',NULL),(241,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-22 06:56:23','2019-10-22 06:56:23',NULL),(242,1,'Admin',NULL,'Resultat',1,'create',NULL,'2019-10-22 06:57:49','2019-10-22 06:57:49',NULL),(243,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-22 07:12:24','2019-10-22 07:12:24',NULL),(244,48,'Patient',48,'Patient',48,'Connexion',NULL,'2019-10-22 16:04:01','2019-10-22 16:04:01',NULL),(245,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-24 12:07:52','2019-10-24 12:07:52',NULL),(246,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-25 09:18:22','2019-10-25 09:18:22',NULL),(247,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-25 09:18:42','2019-10-25 09:18:42',NULL),(248,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-25 09:59:23','2019-10-25 09:59:23',NULL),(249,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-25 10:13:20','2019-10-25 10:13:20',NULL),(250,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-10-25 10:15:43','2019-10-25 10:15:43',NULL),(251,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-25 10:18:05','2019-10-25 10:18:05',NULL),(252,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-25 11:07:10','2019-10-25 11:07:10',NULL),(253,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-25 11:17:48','2019-10-25 11:17:48',NULL),(254,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-25 11:46:41','2019-10-25 11:46:41',NULL),(255,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-25 12:25:24','2019-10-25 12:25:24',NULL),(256,1,'Admin',NULL,'TraitementActuel',6,'create',NULL,'2019-10-25 12:25:37','2019-10-25 12:25:37',NULL),(257,1,'Admin',NULL,'Conclusion',1,'create',NULL,'2019-10-25 12:26:28','2019-10-25 12:26:28',NULL),(258,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-28 10:35:08','2019-10-28 10:35:08',NULL),(259,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-28 10:42:01','2019-10-28 10:42:01',NULL),(260,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-30 18:14:52','2019-10-30 18:14:52',NULL),(261,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-30 18:15:46','2019-10-30 18:15:46',NULL),(262,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-10-31 13:38:31','2019-10-31 13:38:31',NULL),(263,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-01 13:23:03','2019-11-01 13:23:03',NULL),(264,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-04 11:37:22','2019-11-04 11:37:22',NULL),(265,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-04 11:44:10','2019-11-04 11:44:10',NULL),(266,1,'Admin',NULL,'Allergie',2,'create',NULL,'2019-11-04 11:54:59','2019-11-04 11:54:59',NULL),(267,1,'Admin',NULL,'DossierAllergie',3,'attach',NULL,'2019-11-04 11:54:59','2019-11-04 11:54:59',NULL),(268,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-05 08:37:29','2019-11-05 08:37:29',NULL),(269,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-06 22:27:52','2019-11-06 22:27:52',NULL),(270,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-07 11:04:49','2019-11-07 11:04:49',NULL),(271,1,'Admin',NULL,'Allergie',3,'create',NULL,'2019-11-07 11:05:13','2019-11-07 11:05:13',NULL),(272,1,'Admin',NULL,'DossierAllergie',7,'attach',NULL,'2019-11-07 11:05:13','2019-11-07 11:05:13',NULL),(273,1,'Admin',NULL,'ConsultationObstetrique',7,'create',NULL,'2019-11-07 11:06:49','2019-11-07 11:06:49',NULL),(274,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-07 16:06:45','2019-11-07 16:06:45',NULL),(275,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-08 07:19:40','2019-11-08 07:19:40',NULL),(276,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-08 07:27:08','2019-11-08 07:27:08',NULL),(277,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-08 13:18:36','2019-11-08 13:18:36',NULL),(278,1,'Admin',NULL,'ConsultationPrenatale',3,'create',NULL,'2019-11-08 13:25:10','2019-11-08 13:25:10',40),(279,1,'Admin',NULL,'Echographie',2,'create',NULL,'2019-11-08 13:27:53','2019-11-08 13:27:53',49),(280,1,'Admin',NULL,'Antecedent',4,'create',NULL,'2019-11-08 13:29:23','2019-11-08 13:29:23',40),(281,1,'Admin',NULL,'Antecedent',5,'create',NULL,'2019-11-08 13:29:43','2019-11-08 13:29:43',40),(282,1,'Admin',NULL,'Hospitalisation',2,'create',NULL,'2019-11-08 13:31:12','2019-11-08 13:31:12',41),(283,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-08 16:22:51','2019-11-08 16:22:51',NULL),(284,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-09 23:35:03','2019-11-09 23:35:03',NULL),(285,1,'Admin',NULL,'ConsultationMedecineGenerale',6,'create',NULL,'2019-11-09 23:37:25','2019-11-09 23:37:25',48),(286,1,'Admin',NULL,'TraitementActuel',7,'create',NULL,'2019-11-09 23:39:24','2019-11-09 23:39:24',48),(287,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-10 08:49:58','2019-11-10 08:49:58',NULL),(288,1,'Admin',NULL,'Resultat',1,'transmettre',NULL,'2019-11-10 12:21:37','2019-11-10 12:21:37',NULL),(289,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-11 10:52:51','2019-11-11 10:52:51',NULL),(290,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-11 11:07:47','2019-11-11 11:07:47',NULL),(291,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-11 11:08:13','2019-11-11 11:08:13',NULL),(292,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-11 11:16:22','2019-11-11 11:16:22',NULL),(293,1,'Admin',NULL,'Patient',51,'create',NULL,'2019-11-11 12:42:40','2019-11-11 12:42:40',51),(294,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-11 14:53:09','2019-11-11 14:53:09',NULL),(295,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-11 14:58:37','2019-11-11 14:58:37',NULL),(296,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-11 15:09:38','2019-11-11 15:09:38',NULL),(297,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-11 15:12:58','2019-11-11 15:12:58',NULL),(298,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-11 15:27:11','2019-11-11 15:27:11',NULL),(299,1,'Admin',NULL,'Patient',52,'create',NULL,'2019-11-11 23:19:43','2019-11-11 23:19:43',52),(300,1,'Admin',NULL,'Patient',53,'create',NULL,'2019-11-11 23:19:45','2019-11-11 23:19:45',53),(301,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-12 00:44:12','2019-11-12 00:44:12',NULL),(302,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-12 00:55:34','2019-11-12 00:55:34',NULL),(303,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-12 02:21:01','2019-11-12 02:21:01',NULL),(304,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-12 06:48:57','2019-11-12 06:48:57',NULL),(305,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-12 14:35:04','2019-11-12 14:35:04',NULL),(306,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-12 14:58:11','2019-11-12 14:58:11',NULL),(307,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-12 15:45:18','2019-11-12 15:45:18',NULL),(308,1,'Admin',NULL,'Patient',54,'create',NULL,'2019-11-12 15:47:07','2019-11-12 15:47:07',54),(309,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-12 16:31:29','2019-11-12 16:31:29',NULL),(310,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-12 16:33:27','2019-11-12 16:33:27',NULL),(311,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-12 17:14:37','2019-11-12 17:14:37',NULL),(312,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-12 17:47:32','2019-11-12 17:47:32',NULL),(313,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-12 17:54:58','2019-11-12 17:54:58',NULL),(314,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-13 08:31:11','2019-11-13 08:31:11',NULL),(315,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-13 10:00:09','2019-11-13 10:00:09',NULL),(316,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-13 11:19:37','2019-11-13 11:19:37',NULL),(317,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-13 13:04:43','2019-11-13 13:04:43',NULL),(318,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-13 13:27:03','2019-11-13 13:27:03',NULL),(319,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-13 13:59:47','2019-11-13 13:59:47',NULL),(320,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-13 18:35:48','2019-11-13 18:35:48',NULL),(321,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-13 19:11:50','2019-11-13 19:11:50',NULL),(322,45,'Praticien',45,'Praticien',45,'Connexion',NULL,'2019-11-13 19:30:50','2019-11-13 19:30:50',NULL),(323,45,'Praticien',45,'Hospitalisation',2,'transmettre',NULL,'2019-11-13 19:35:31','2019-11-13 19:35:31',NULL),(324,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-13 19:36:17','2019-11-13 19:36:17',NULL),(325,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-13 19:38:17','2019-11-13 19:38:17',NULL),(326,1,'Admin',NULL,'ConsultationMedecineGenerale',6,'transmettre',NULL,'2019-11-13 19:56:21','2019-11-13 19:56:21',NULL),(327,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-14 14:36:08','2019-11-14 14:36:08',NULL),(328,1,'Admin',NULL,'Praticien',55,'create',NULL,'2019-11-14 14:47:30','2019-11-14 14:47:30',NULL),(329,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-14 14:52:12','2019-11-14 14:52:12',NULL),(330,1,'Admin',NULL,'Praticien',56,'create',NULL,'2019-11-14 14:53:10','2019-11-14 14:53:10',NULL),(331,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-14 15:03:49','2019-11-14 15:03:49',NULL),(332,55,'Praticien',55,'Resultat',2,'create',NULL,'2019-11-14 15:47:57','2019-11-14 15:47:57',4),(333,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-14 16:07:55','2019-11-14 16:07:55',NULL),(334,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-14 16:11:17','2019-11-14 16:11:17',NULL),(335,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-14 16:17:29','2019-11-14 16:17:29',NULL),(336,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-14 16:17:47','2019-11-14 16:17:47',NULL),(337,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-14 16:18:19','2019-11-14 16:18:19',NULL),(338,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-14 16:18:36','2019-11-14 16:18:36',NULL),(339,1,'Admin',NULL,'Souscripteur',57,'create',NULL,'2019-11-14 16:19:34','2019-11-14 16:19:34',NULL),(340,57,'Souscripteur',57,'Souscripteur',57,'Connexion',NULL,'2019-11-14 16:21:36','2019-11-14 16:21:36',NULL),(341,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-14 16:22:37','2019-11-14 16:22:37',NULL),(342,1,'Admin',NULL,'Gestionnaire',58,'create',NULL,'2019-11-14 16:23:19','2019-11-14 16:23:19',NULL),(343,58,'Gestionnaire',58,'Gestionnaire',58,'Connexion',NULL,'2019-11-14 16:24:50','2019-11-14 16:24:50',NULL),(344,57,'Souscripteur',57,'Souscripteur',57,'Connexion',NULL,'2019-11-14 17:14:23','2019-11-14 17:14:23',NULL),(345,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-14 17:18:00','2019-11-14 17:18:00',NULL),(346,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-14 17:19:27','2019-11-14 17:19:27',NULL),(347,1,'Admin',NULL,'Patient',50,'add to etablissement',NULL,'2019-11-14 17:19:45','2019-11-14 17:19:45',50),(348,1,'Admin',NULL,'Patient',52,'add to etablissement',NULL,'2019-11-14 17:19:56','2019-11-14 17:19:56',52),(349,1,'Admin',NULL,'Patient',54,'add to etablissement',NULL,'2019-11-14 17:20:16','2019-11-14 17:20:16',54),(350,1,'Admin',NULL,'Patient',4,'add to etablissement',NULL,'2019-11-14 17:20:37','2019-11-14 17:20:37',4),(351,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-14 17:21:03','2019-11-14 17:21:03',NULL),(352,58,'Gestionnaire',58,'Gestionnaire',58,'Connexion',NULL,'2019-11-14 17:25:58','2019-11-14 17:25:58',NULL),(353,58,'Gestionnaire',58,'MedecinControle',59,'create',NULL,'2019-11-14 17:27:11','2019-11-14 17:27:11',NULL),(354,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-14 19:29:05','2019-11-14 19:29:05',NULL),(355,59,'Medecin controle',59,'Medecin controle',59,'Connexion',NULL,'2019-11-14 19:30:06','2019-11-14 19:30:06',NULL),(356,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-14 19:43:40','2019-11-14 19:43:40',NULL),(357,59,'Medecin controle',59,'Medecin controle',59,'Connexion',NULL,'2019-11-14 19:46:59','2019-11-14 19:46:59',NULL),(358,59,'Medecin controle',59,'Medecin controle',59,'Connexion',NULL,'2019-11-14 19:47:00','2019-11-14 19:47:00',NULL),(359,59,'Medecin controle',59,'Medecin controle',59,'Connexion',NULL,'2019-11-14 19:48:22','2019-11-14 19:48:22',NULL),(360,59,'Medecin controle',59,'Medecin controle',59,'Connexion',NULL,'2019-11-14 19:49:34','2019-11-14 19:49:34',NULL),(361,59,'Medecin controle',59,'Medecin controle',59,'Connexion',NULL,'2019-11-14 20:03:26','2019-11-14 20:03:26',NULL),(362,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-14 20:04:38','2019-11-14 20:04:38',NULL),(363,57,'Souscripteur',57,'Souscripteur',57,'Connexion',NULL,'2019-11-14 20:05:29','2019-11-14 20:05:29',NULL),(364,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-14 20:08:43','2019-11-14 20:08:43',NULL),(365,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-15 09:21:15','2019-11-15 09:21:15',NULL),(366,58,'Gestionnaire',58,'Gestionnaire',58,'Connexion',NULL,'2019-11-15 09:21:36','2019-11-15 09:21:36',NULL),(367,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-15 09:50:03','2019-11-15 09:50:03',NULL),(368,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-15 10:24:03','2019-11-15 10:24:03',NULL),(369,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-15 10:25:13','2019-11-15 10:25:13',NULL),(370,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-15 14:45:58','2019-11-15 14:45:58',NULL),(371,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-15 14:46:35','2019-11-15 14:46:35',NULL),(372,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-15 14:47:18','2019-11-15 14:47:18',NULL),(373,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-15 14:50:34','2019-11-15 14:50:34',NULL),(374,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-16 14:06:20','2019-11-16 14:06:20',NULL),(375,45,'Praticien',45,'Praticien',45,'Connexion',NULL,'2019-11-17 08:51:33','2019-11-17 08:51:33',NULL),(376,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-18 06:03:52','2019-11-18 06:03:52',NULL),(377,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-18 06:03:59','2019-11-18 06:03:59',NULL),(378,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-18 06:06:55','2019-11-18 06:06:55',NULL),(379,59,'Medecin controle',59,'Medecin controle',59,'Connexion',NULL,'2019-11-18 06:07:20','2019-11-18 06:07:20',NULL),(380,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-18 11:16:35','2019-11-18 11:16:35',NULL),(381,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-18 11:17:27','2019-11-18 11:17:27',NULL),(382,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-18 11:17:43','2019-11-18 11:17:43',NULL),(383,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-18 11:21:04','2019-11-18 11:21:04',NULL),(384,57,'Souscripteur',57,'Souscripteur',57,'Connexion',NULL,'2019-11-18 12:52:12','2019-11-18 12:52:12',NULL),(385,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-18 12:52:45','2019-11-18 12:52:45',NULL),(386,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-18 12:54:12','2019-11-18 12:54:12',NULL),(387,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-18 12:54:51','2019-11-18 12:54:51',NULL),(388,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-18 13:14:39','2019-11-18 13:14:39',NULL),(389,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-18 13:19:15','2019-11-18 13:19:15',NULL),(390,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-18 13:22:23','2019-11-18 13:22:23',NULL),(391,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-18 13:34:32','2019-11-18 13:34:32',NULL),(392,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-18 13:55:22','2019-11-18 13:55:22',NULL),(393,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-18 13:55:33','2019-11-18 13:55:33',NULL),(394,58,'Gestionnaire',58,'Gestionnaire',58,'Connexion',NULL,'2019-11-18 14:49:49','2019-11-18 14:49:49',NULL),(395,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-19 11:12:01','2019-11-19 11:12:01',NULL),(396,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-19 11:13:39','2019-11-19 11:13:39',NULL),(397,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-19 12:33:53','2019-11-19 12:33:53',NULL),(398,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-19 13:09:50','2019-11-19 13:09:50',NULL),(399,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-19 13:10:49','2019-11-19 13:10:49',NULL),(400,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-19 13:13:28','2019-11-19 13:13:28',NULL),(401,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-19 13:13:48','2019-11-19 13:13:48',NULL),(402,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-19 13:40:56','2019-11-19 13:40:56',NULL),(403,57,'Souscripteur',57,'Souscripteur',57,'Connexion',NULL,'2019-11-19 13:41:35','2019-11-19 13:41:35',NULL),(404,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-19 14:01:22','2019-11-19 14:01:22',NULL),(405,57,'Souscripteur',57,'Souscripteur',57,'Connexion',NULL,'2019-11-19 14:01:34','2019-11-19 14:01:34',NULL),(406,58,'Gestionnaire',58,'Gestionnaire',58,'Connexion',NULL,'2019-11-19 14:01:42','2019-11-19 14:01:42',NULL),(407,58,'Gestionnaire',58,'Gestionnaire',58,'Connexion',NULL,'2019-11-19 14:03:12','2019-11-19 14:03:12',NULL),(408,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-19 14:08:42','2019-11-19 14:08:42',NULL),(409,57,'Souscripteur',57,'Souscripteur',57,'Connexion',NULL,'2019-11-19 14:32:39','2019-11-19 14:32:39',NULL),(410,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-19 15:25:20','2019-11-19 15:25:20',NULL),(411,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-19 17:29:05','2019-11-19 17:29:05',NULL),(412,55,'Praticien',55,'Antecedent',6,'create',NULL,'2019-11-19 17:46:22','2019-11-19 17:46:22',54),(413,45,'Praticien',45,'Praticien',45,'Connexion',NULL,'2019-11-19 19:54:58','2019-11-19 19:54:58',NULL),(414,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-20 09:36:49','2019-11-20 09:36:49',NULL),(415,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-20 09:37:59','2019-11-20 09:37:59',NULL),(416,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-20 09:41:48','2019-11-20 09:41:48',NULL),(417,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-20 09:43:17','2019-11-20 09:43:17',NULL),(418,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-20 12:32:10','2019-11-20 12:32:10',NULL),(419,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-20 12:36:26','2019-11-20 12:36:26',NULL),(420,58,'Gestionnaire',58,'Gestionnaire',58,'Connexion',NULL,'2019-11-20 12:37:30','2019-11-20 12:37:30',NULL),(421,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-20 12:42:36','2019-11-20 12:42:36',NULL),(422,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-20 12:57:12','2019-11-20 12:57:12',NULL),(423,55,'Praticien',55,'ConsultationMedecineGenerale',7,'create',NULL,'2019-11-20 12:58:31','2019-11-20 12:58:31',51),(424,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-20 14:24:45','2019-11-20 14:24:45',NULL),(425,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-20 15:17:07','2019-11-20 15:17:07',NULL),(426,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-20 15:50:25','2019-11-20 15:50:25',NULL),(427,1,'Admin',NULL,'TraitementActuel',8,'create',NULL,'2019-11-20 15:51:54','2019-11-20 15:51:54',48),(428,1,'Admin',NULL,'TraitementActuel',9,'create',NULL,'2019-11-20 15:51:54','2019-11-20 15:51:54',48),(429,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-20 19:10:41','2019-11-20 19:10:41',NULL),(430,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-20 19:11:44','2019-11-20 19:11:44',NULL),(431,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-20 19:12:02','2019-11-20 19:12:02',NULL),(432,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-20 19:15:51','2019-11-20 19:15:51',NULL),(433,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-20 19:17:40','2019-11-20 19:17:40',NULL),(434,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-20 19:25:43','2019-11-20 19:25:43',NULL),(435,55,'Praticien',55,'ConsultationMedecineGenerale',8,'create',NULL,'2019-11-20 19:53:59','2019-11-20 19:53:59',52),(436,55,'Praticien',55,'Antecedent',7,'create',NULL,'2019-11-20 19:58:44','2019-11-20 19:58:44',53),(437,58,'Gestionnaire',58,'Gestionnaire',58,'Connexion',NULL,'2019-11-21 06:54:06','2019-11-21 06:54:06',NULL),(438,57,'Souscripteur',57,'Souscripteur',57,'Connexion',NULL,'2019-11-21 06:54:51','2019-11-21 06:54:51',NULL),(439,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-21 08:45:34','2019-11-21 08:45:34',NULL),(440,55,'Praticien',55,'Allergie',4,'create',NULL,'2019-11-21 11:07:19','2019-11-21 11:07:19',52),(441,55,'Praticien',55,'DossierAllergie',9,'attach',NULL,'2019-11-21 11:07:19','2019-11-21 11:07:19',NULL),(442,55,'Praticien',55,'Antecedent',8,'create',NULL,'2019-11-21 11:08:28','2019-11-21 11:08:28',52),(443,58,'Gestionnaire',58,'Gestionnaire',58,'Connexion',NULL,'2019-11-21 11:32:39','2019-11-21 11:32:39',NULL),(444,57,'Souscripteur',57,'Souscripteur',57,'Connexion',NULL,'2019-11-21 11:32:53','2019-11-21 11:32:53',NULL),(445,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-21 11:37:26','2019-11-21 11:37:26',NULL),(446,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-21 11:37:28','2019-11-21 11:37:28',NULL),(447,55,'Praticien',55,'Motif',4,'create',NULL,'2019-11-21 11:40:40','2019-11-21 11:40:40',NULL),(448,55,'Praticien',55,'ConsultationMotif',4,'attach',NULL,'2019-11-21 11:40:40','2019-11-21 11:40:40',48),(449,55,'Praticien',55,'Motif',5,'create',NULL,'2019-11-21 11:40:56','2019-11-21 11:40:56',NULL),(450,55,'Praticien',55,'ConsultationMotif',5,'attach',NULL,'2019-11-21 11:40:56','2019-11-21 11:40:56',48),(451,55,'Praticien',55,'Motif',6,'create',NULL,'2019-11-21 11:41:31','2019-11-21 11:41:31',NULL),(452,55,'Praticien',55,'ConsultationMotif',6,'attach',NULL,'2019-11-21 11:41:31','2019-11-21 11:41:31',48),(453,55,'Praticien',55,'TraitementActuel',10,'create',NULL,'2019-11-21 11:49:02','2019-11-21 11:49:02',52),(454,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-21 18:34:46','2019-11-21 18:34:46',NULL),(455,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-22 07:04:58','2019-11-22 07:04:58',NULL),(456,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-22 07:56:32','2019-11-22 07:56:32',NULL),(457,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-22 08:29:02','2019-11-22 08:29:02',NULL),(458,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-22 09:31:32','2019-11-22 09:31:32',NULL),(459,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-22 09:32:00','2019-11-22 09:32:00',NULL),(460,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-22 09:44:59','2019-11-22 09:44:59',NULL),(461,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-22 11:04:18','2019-11-22 11:04:18',NULL),(462,55,'Praticien',55,'Motif',7,'create',NULL,'2019-11-22 11:07:41','2019-11-22 11:07:41',NULL),(463,55,'Praticien',55,'ConsultationMotif',7,'attach',NULL,'2019-11-22 11:07:41','2019-11-22 11:07:41',48),(464,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-22 12:16:24','2019-11-22 12:16:24',NULL),(465,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-22 14:17:58','2019-11-22 14:17:58',NULL),(466,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-22 15:49:47','2019-11-22 15:49:47',NULL),(467,55,'Praticien',55,'Resultat',3,'create',NULL,'2019-11-22 15:51:00','2019-11-22 15:51:00',52),(468,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-22 16:56:41','2019-11-22 16:56:41',NULL),(469,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-22 16:57:30','2019-11-22 16:57:30',NULL),(470,45,'Praticien',45,'Praticien',45,'Connexion',NULL,'2019-11-22 21:53:51','2019-11-22 21:53:51',NULL),(471,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-22 21:54:51','2019-11-22 21:54:51',NULL),(472,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-23 09:22:59','2019-11-23 09:22:59',NULL),(473,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-23 09:33:19','2019-11-23 09:33:19',NULL),(474,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-23 09:44:15','2019-11-23 09:44:15',NULL),(475,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-23 09:50:06','2019-11-23 09:50:06',NULL),(476,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-23 10:14:00','2019-11-23 10:14:00',NULL),(477,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-23 10:14:52','2019-11-23 10:14:52',NULL),(478,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-23 14:50:53','2019-11-23 14:50:53',NULL),(479,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-23 15:16:34','2019-11-23 15:16:34',NULL),(480,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-23 16:29:39','2019-11-23 16:29:39',NULL),(481,1,'Admin',NULL,'ConsultationMedecineGenerale',9,'create',NULL,'2019-11-23 16:30:52','2019-11-23 16:30:52',50),(482,1,'Admin',NULL,'Motif',8,'create',NULL,'2019-11-23 16:30:52','2019-11-23 16:30:52',NULL),(483,1,'Admin',NULL,'ConsultationMotif',8,'attach',NULL,'2019-11-23 16:30:52','2019-11-23 16:30:52',50),(484,1,'Admin',NULL,'Conclusion',2,'create',NULL,'2019-11-23 16:30:52','2019-11-23 16:30:52',50),(485,1,'Admin',NULL,'Allergie',5,'create',NULL,'2019-11-23 16:31:36','2019-11-23 16:31:36',50),(486,1,'Admin',NULL,'DossierAllergie',7,'attach',NULL,'2019-11-23 16:31:36','2019-11-23 16:31:36',NULL),(487,1,'Admin',NULL,'Antecedent',9,'create',NULL,'2019-11-23 16:31:57','2019-11-23 16:31:57',50),(488,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-23 17:09:47','2019-11-23 17:09:47',NULL),(489,55,'Praticien',55,'ConsultationMedecineGenerale',10,'create',NULL,'2019-11-23 17:58:46','2019-11-23 17:58:46',52),(490,55,'Praticien',55,'ConsultationMotif',3,'attach',NULL,'2019-11-23 17:58:46','2019-11-23 17:58:46',52),(491,55,'Praticien',55,'Conclusion',3,'create',NULL,'2019-11-23 17:58:46','2019-11-23 17:58:46',52),(492,55,'Praticien',55,'Antecedent',10,'create',NULL,'2019-11-23 18:01:14','2019-11-23 18:01:14',48),(493,55,'Praticien',55,'Allergie',6,'create',NULL,'2019-11-23 18:01:43','2019-11-23 18:01:43',48),(494,55,'Praticien',55,'DossierAllergie',5,'attach',NULL,'2019-11-23 18:01:43','2019-11-23 18:01:43',NULL),(495,55,'Praticien',55,'ConsultationMedecineGenerale',11,'create',NULL,'2019-11-23 18:01:54','2019-11-23 18:01:54',48),(496,55,'Praticien',55,'ConsultationMotif',3,'attach',NULL,'2019-11-23 18:01:54','2019-11-23 18:01:54',48),(497,55,'Praticien',55,'Conclusion',4,'create',NULL,'2019-11-23 18:01:54','2019-11-23 18:01:54',48),(498,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-23 18:02:54','2019-11-23 18:02:54',NULL),(499,1,'Admin',NULL,'Allergie',7,'create',NULL,'2019-11-23 18:03:37','2019-11-23 18:03:37',50),(500,1,'Admin',NULL,'DossierAllergie',7,'attach',NULL,'2019-11-23 18:03:37','2019-11-23 18:03:37',NULL),(501,1,'Admin',NULL,'Antecedent',11,'create',NULL,'2019-11-23 18:03:57','2019-11-23 18:03:57',50),(502,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-23 18:08:53','2019-11-23 18:08:53',NULL),(503,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-23 18:20:06','2019-11-23 18:20:06',NULL),(504,55,'Praticien',55,'Resultat',4,'create',NULL,'2019-11-23 18:21:42','2019-11-23 18:21:42',48),(505,55,'Praticien',55,'Resultat',5,'create',NULL,'2019-11-23 18:22:04','2019-11-23 18:22:04',48),(506,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 09:58:29','2019-11-24 09:58:29',NULL),(507,57,'Souscripteur',57,'Souscripteur',57,'Connexion',NULL,'2019-11-24 10:43:32','2019-11-24 10:43:32',NULL),(508,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 10:47:26','2019-11-24 10:47:26',NULL),(509,45,'Praticien',45,'Praticien',45,'Connexion',NULL,'2019-11-24 11:18:37','2019-11-24 11:18:37',NULL),(510,45,'Praticien',45,'TraitementActuel',11,'create',NULL,'2019-11-24 11:24:45','2019-11-24 11:24:45',52),(511,45,'Praticien',45,'TraitementActuel',12,'create',NULL,'2019-11-24 11:24:45','2019-11-24 11:24:45',52),(512,45,'Praticien',45,'TraitementActuel',13,'create',NULL,'2019-11-24 11:24:45','2019-11-24 11:24:45',52),(513,45,'Praticien',45,'TraitementActuel',14,'create',NULL,'2019-11-24 11:24:45','2019-11-24 11:24:45',52),(514,45,'Praticien',45,'Antecedent',12,'create',NULL,'2019-11-24 11:27:43','2019-11-24 11:27:43',52),(515,45,'Praticien',45,'Antecedent',13,'create',NULL,'2019-11-24 11:29:40','2019-11-24 11:29:40',52),(516,45,'Praticien',45,'Antecedent',14,'create',NULL,'2019-11-24 11:30:25','2019-11-24 11:30:25',52),(517,45,'Praticien',45,'Antecedent',15,'create',NULL,'2019-11-24 11:31:52','2019-11-24 11:31:52',52),(518,45,'Praticien',45,'ConsultationMedecineGenerale',12,'create',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',52),(519,45,'Praticien',45,'Motif',9,'create',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',NULL),(520,45,'Praticien',45,'ConsultationMotif',9,'attach',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',52),(521,45,'Praticien',45,'Motif',10,'create',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',NULL),(522,45,'Praticien',45,'ConsultationMotif',10,'attach',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',52),(523,45,'Praticien',45,'Motif',11,'create',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',NULL),(524,45,'Praticien',45,'ConsultationMotif',11,'attach',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',52),(525,45,'Praticien',45,'Motif',12,'create',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',NULL),(526,45,'Praticien',45,'ConsultationMotif',12,'attach',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',52),(527,45,'Praticien',45,'Motif',13,'create',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',NULL),(528,45,'Praticien',45,'ConsultationMotif',13,'attach',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',52),(529,45,'Praticien',45,'Motif',14,'create',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',NULL),(530,45,'Praticien',45,'ConsultationMotif',14,'attach',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',52),(531,45,'Praticien',45,'Motif',15,'create',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',NULL),(532,45,'Praticien',45,'ConsultationMotif',15,'attach',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',52),(533,45,'Praticien',45,'Conclusion',5,'create',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58',52),(534,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-24 12:45:42','2019-11-24 12:45:42',NULL),(535,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-24 12:59:02','2019-11-24 12:59:02',NULL),(536,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 13:03:01','2019-11-24 13:03:01',NULL),(537,58,'Gestionnaire',58,'Gestionnaire',58,'Connexion',NULL,'2019-11-24 13:52:22','2019-11-24 13:52:22',NULL),(538,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 13:52:34','2019-11-24 13:52:34',NULL),(539,57,'Souscripteur',57,'Souscripteur',57,'Connexion',NULL,'2019-11-24 13:52:42','2019-11-24 13:52:42',NULL),(540,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-24 13:52:54','2019-11-24 13:52:54',NULL),(541,59,'Medecin controle',59,'Medecin controle',59,'Connexion',NULL,'2019-11-24 13:53:44','2019-11-24 13:53:44',NULL),(542,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 13:56:26','2019-11-24 13:56:26',NULL),(543,55,'Praticien',55,'TraitementActuel',15,'create',NULL,'2019-11-24 13:56:44','2019-11-24 13:56:44',50),(544,59,'Medecin controle',59,'Medecin controle',59,'Connexion',NULL,'2019-11-24 14:45:19','2019-11-24 14:45:19',NULL),(545,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 15:04:21','2019-11-24 15:04:21',NULL),(546,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-24 15:05:34','2019-11-24 15:05:34',NULL),(547,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-24 15:05:55','2019-11-24 15:05:55',NULL),(548,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-24 15:06:36','2019-11-24 15:06:36',NULL),(549,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-24 15:06:42','2019-11-24 15:06:42',NULL),(550,1,'Admin',NULL,'ConsultationMedecineGenerale',9,'transmettre',NULL,'2019-11-24 15:06:54','2019-11-24 15:06:54',NULL),(551,1,'Admin',NULL,'ConsultationMedecineGenerale',9,'archive',NULL,'2019-11-24 15:07:03','2019-11-24 15:07:03',NULL),(552,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-24 15:07:17','2019-11-24 15:07:17',NULL),(553,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-24 15:32:39','2019-11-24 15:32:39',NULL),(554,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 16:57:55','2019-11-24 16:57:55',NULL),(555,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 17:03:36','2019-11-24 17:03:36',NULL),(556,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 17:08:22','2019-11-24 17:08:22',NULL),(557,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-24 17:08:45','2019-11-24 17:08:45',NULL),(558,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 17:10:41','2019-11-24 17:10:41',NULL),(559,57,'Souscripteur',57,'Souscripteur',57,'Connexion',NULL,'2019-11-24 17:11:38','2019-11-24 17:11:38',NULL),(560,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-24 17:13:05','2019-11-24 17:13:05',NULL),(561,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-24 17:14:59','2019-11-24 17:14:59',NULL),(562,57,'Souscripteur',57,'Souscripteur',57,'Connexion',NULL,'2019-11-24 17:15:08','2019-11-24 17:15:08',NULL),(563,58,'Gestionnaire',58,'Gestionnaire',58,'Connexion',NULL,'2019-11-24 17:15:44','2019-11-24 17:15:44',NULL),(564,1,'Admin',NULL,'Patient',60,'create',NULL,'2019-11-24 17:16:06','2019-11-24 17:16:06',60),(565,1,'Admin',NULL,'Souscripteur',61,'create',NULL,'2019-11-24 17:21:06','2019-11-24 17:21:06',NULL),(566,61,'Souscripteur',61,'Souscripteur',61,'Connexion',NULL,'2019-11-24 17:21:49','2019-11-24 17:21:49',NULL),(567,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-24 17:23:41','2019-11-24 17:23:41',NULL),(568,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-24 17:26:07','2019-11-24 17:26:07',NULL),(569,1,'Admin',NULL,'Souscripteur',63,'create',NULL,'2019-11-24 17:30:42','2019-11-24 17:30:42',NULL),(570,63,'Souscripteur',63,'Souscripteur',63,'Connexion',NULL,'2019-11-24 17:31:35','2019-11-24 17:31:35',NULL),(571,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 17:32:33','2019-11-24 17:32:33',NULL),(572,63,'Souscripteur',63,'Souscripteur',63,'Connexion',NULL,'2019-11-24 17:32:48','2019-11-24 17:32:48',NULL),(573,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-24 17:33:15','2019-11-24 17:33:15',NULL),(574,63,'Souscripteur',63,'Souscripteur',63,'Connexion',NULL,'2019-11-24 17:33:31','2019-11-24 17:33:31',NULL),(575,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-24 17:45:39','2019-11-24 17:45:39',NULL),(576,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 17:45:47','2019-11-24 17:45:47',NULL),(577,63,'Souscripteur',63,'Souscripteur',63,'Connexion',NULL,'2019-11-24 17:46:39','2019-11-24 17:46:39',NULL),(578,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 17:49:27','2019-11-24 17:49:27',NULL),(579,63,'Souscripteur',63,'Souscripteur',63,'Connexion',NULL,'2019-11-24 17:50:20','2019-11-24 17:50:20',NULL),(580,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 17:50:37','2019-11-24 17:50:37',NULL),(581,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-24 18:16:27','2019-11-24 18:16:27',NULL),(582,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 18:17:24','2019-11-24 18:17:24',NULL),(583,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 18:18:07','2019-11-24 18:18:07',NULL),(584,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-24 18:18:46','2019-11-24 18:18:46',NULL),(585,50,'Patient',50,'Patient',50,'Connexion',NULL,'2019-11-24 18:19:29','2019-11-24 18:19:29',NULL),(586,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-24 18:19:48','2019-11-24 18:19:48',NULL),(587,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-24 18:20:37','2019-11-24 18:20:37',NULL),(588,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-24 18:21:44','2019-11-24 18:21:44',NULL),(589,1,'Admin',NULL,'Admin',NULL,'Connexion',NULL,'2019-11-24 18:22:05','2019-11-24 18:22:05',NULL),(590,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 18:22:12','2019-11-24 18:22:12',NULL),(591,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 18:22:31','2019-11-24 18:22:31',NULL),(592,55,'Praticien',55,'Praticien',55,'Connexion',NULL,'2019-11-24 22:58:56','2019-11-24 22:58:56',NULL),(593,55,'Praticien',55,'Hospitalisation',3,'create',NULL,'2019-11-25 00:54:14','2019-11-25 00:54:14',48),(594,55,'Praticien',55,'Hospitalisation',4,'create',NULL,'2019-11-25 00:54:14','2019-11-25 00:54:14',48),(595,55,'Praticien',55,'Hospitalisation',3,'transmettre',NULL,'2019-11-25 00:55:23','2019-11-25 00:55:23',NULL);
/*!40000 ALTER TABLE `auteurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conclusions`
--

DROP TABLE IF EXISTS `conclusions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conclusions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `consultation_medecine_generale_id` bigint(20) unsigned NOT NULL,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `conclusions_slug_unique` (`slug`),
  KEY `conclusions_consultation_medecine_generale_id_foreign` (`consultation_medecine_generale_id`),
  CONSTRAINT `conclusions_consultation_medecine_generale_id_foreign` FOREIGN KEY (`consultation_medecine_generale_id`) REFERENCES `consultation_medecine_generales` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conclusions`
--

LOCK TABLES `conclusions` WRITE;
/*!40000 ALTER TABLE `conclusions` DISABLE KEYS */;
INSERT INTO `conclusions` VALUES (1,5,'reere','zerzerzerzerzerzerzer','2019-10-25 12:26:28','2019-10-25 12:26:28',NULL,'reere-1572013588'),(2,9,'2019-11-23','Trop fort pour avoir beaucoup d\'argent','2019-11-23 16:30:52','2019-11-23 16:40:56',NULL,'1574530252'),(3,10,NULL,'sdfds','2019-11-23 17:58:46','2019-11-23 17:58:46',NULL,'1574535526'),(4,11,NULL,'Ulcère gastrique sub-Chronique post-Stress et AINS chronique','2019-11-23 18:01:54','2019-11-23 18:01:54',NULL,'1574535714'),(5,12,NULL,'Pneumonie basale gauche','2019-11-24 11:51:58','2019-11-24 11:51:58',NULL,'1574599918');
/*!40000 ALTER TABLE `conclusions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consult_traitement`
--

DROP TABLE IF EXISTS `consult_traitement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consult_traitement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `consultation_medecine_generale_id` bigint(20) unsigned NOT NULL,
  `traitement_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consult_traitement_consultation_medecine_generale_id_foreign` (`consultation_medecine_generale_id`),
  KEY `consult_traitement_traitement_id_foreign` (`traitement_id`),
  CONSTRAINT `consult_traitement_consultation_medecine_generale_id_foreign` FOREIGN KEY (`consultation_medecine_generale_id`) REFERENCES `consultation_medecine_generales` (`id`),
  CONSTRAINT `consult_traitement_traitement_id_foreign` FOREIGN KEY (`traitement_id`) REFERENCES `traitements` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consult_traitement`
--

LOCK TABLES `consult_traitement` WRITE;
/*!40000 ALTER TABLE `consult_traitement` DISABLE KEYS */;
/*!40000 ALTER TABLE `consult_traitement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultation_medecine_generales`
--

DROP TABLE IF EXISTS `consultation_medecine_generales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consultation_medecine_generales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dossier_medical_id` bigint(20) unsigned NOT NULL,
  `date_consultation` date DEFAULT NULL,
  `anamese` text COLLATE utf8mb4_unicode_ci,
  `mode_de_vie` text COLLATE utf8mb4_unicode_ci,
  `examen_clinique` text COLLATE utf8mb4_unicode_ci,
  `examen_complementaire` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archieved_at` timestamp NULL DEFAULT NULL,
  `passed_at` timestamp NULL DEFAULT NULL,
  `traitement_propose` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `consultation_medecine_generales_slug_unique` (`slug`),
  KEY `consultation_medecine_generales_dossier_medical_id_foreign` (`dossier_medical_id`),
  CONSTRAINT `consultation_medecine_generales_dossier_medical_id_foreign` FOREIGN KEY (`dossier_medical_id`) REFERENCES `dossier_medicals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultation_medecine_generales`
--

LOCK TABLES `consultation_medecine_generales` WRITE;
/*!40000 ALTER TABLE `consultation_medecine_generales` DISABLE KEYS */;
INSERT INTO `consultation_medecine_generales` VALUES (1,2,'2019-10-13',NULL,NULL,NULL,NULL,NULL,'2019-10-11 11:54:08','2019-10-18 13:05:20','eric-1570634615-94015818-1570802048',NULL,'2019-10-18 13:05:20',NULL),(2,4,'2019-10-15','Patient se plaignant de fièvre depuis 3 semaines. On note aussi la présence de sueurs nocturnes ainsi que de l’asthénie.','Normale','Présence de multiples adénopathies cervicales','Bio\nEcho',NULL,'2019-10-15 10:11:32','2019-10-15 10:28:38','rambo-rambo-1571136496-79322917-1571141492',NULL,'2019-10-15 10:28:38','Chimiothérapie RCHOP'),(3,5,'2019-10-15','Patient de 50 Ans se présente pour une douleur au processus styloide ulnaire depuis 3 jours sans notion de trauma.','Aime beaucoup manger le Nkui. \nEt le plantain prune','Pas de tuméfaction\nPas d\'hémaotme \nPas de blessure ouverte','Radio du poignet face et profil',NULL,'2019-10-15 16:52:34','2019-10-21 17:58:12','jesusfictif-1571165162-37317794-1571165554','2019-10-21 17:58:12','2019-10-15 16:53:03','Repos, Glace etc'),(4,2,'2019-10-19','douleurs abdo depuis 3 jours, date de début des règles','alcolo-tabagique','BOTE','NFS + Avis gynéco',NULL,'2019-10-19 15:37:05','2019-10-19 15:37:05','eric-1570634615-94015818-1571506625',NULL,NULL,'Nurofen'),(5,3,'2019-10-21','Douleur langue et rebord','Aime le piment','Rouge chaud douloureux','Prise de sang',NULL,'2019-10-21 17:56:35','2019-10-21 17:56:35','dino-louis-1571136312-53882262-1571687795',NULL,NULL,'Repos'),(6,5,'2019-11-10','Depuis deux jours le patient hallucine et pense avoir gagner le loto','FUME LE Banga','Test Psycho adaptatif','PAREIL',NULL,'2019-11-09 23:37:25','2019-11-13 19:56:21','jesusfictif-1571165162-37317794-1573346245',NULL,'2019-11-13 19:56:21','Psychotherapie'),(7,8,'2019-11-20',NULL,NULL,NULL,NULL,NULL,'2019-11-20 12:58:31','2019-11-20 12:58:31','eric-1573479759-28061838-1574258311',NULL,NULL,NULL),(8,9,'2019-11-20','jfhgfghdgfdgfd','jhfhgfghfh','xvcxvcxvcxvc','kyuyiuyuyiu',NULL,'2019-11-20 19:53:59','2019-11-20 19:53:59','azongmo-1573517982-20549509-1574283239',NULL,NULL,'hgcgfxgfsfdswfswfwfw'),(9,7,'2019-11-23','sdfsdfdf','sdfdsf','sdfsdf','sdfsdfsdf',NULL,'2019-11-23 16:30:52','2019-11-24 15:07:03','nkouekam-1571424920-12329665-1574530252','2019-11-24 15:07:03','2019-11-24 15:06:54','Donner beaucoup d\'argent a ce petit'),(10,9,'2019-11-23','sdfsdf','dsfsdfsdf','sdfdsf','sdfsdf',NULL,'2019-11-23 17:58:46','2019-11-23 17:58:46','azongmo-1573517982-20549509-1574535526',NULL,NULL,'sdfdsf'),(11,5,'2019-11-23','Patient en bon état général et nutritionnel.\nSe plaint depuis 1 an environs de reflux gastrique juste avant le coucher et à chaque repas copieux. Pas de notions de nausée, de vomissement, de trouble digestif.','- Boit régulièrement du champagne. \n- Prends depuis 3 ans des AINS sans notion de protection gastrique\n- A perdu son emploi et son premier fils il y 3 mois en l\'espace de 2 semaines. Depuis lors, n\'est plus respecté par son épouse.','--','Test à l\'Urée, OED, Biologie, Echo abdominale',NULL,'2019-11-23 18:01:54','2019-11-23 18:01:54','jesusfictif-1571165162-37317794-1574535714',NULL,NULL,'Stop AINS et shift vers Antalgique pur\nProtection gastrique \nSchema d\'éradication Hpilori'),(12,9,'2019-11-24','Patient de 69 ans qui consulte pour fièvre depuis 5 jours accompagné de courbature. Les 2 derniers jours il a commencé à avoir de la toux avec expectoration rouillé, ainsi que de la thoracique. Présence aussi de frissons, de mal de tête et de vomissement par moment. \nSe sent de plus en plus fatigué et faible.\nAvait pris au début du paracétamol 500 mg 4 x par jour ainsi que de l\'arthémeter en traitement empirique car croyait qu\'il s\'agissait d\'un paludisme.','Vit avec son épouse. 2 enfants. Ne fume pas. Consomme occasionnellement de l\'alcool. Pratique du sport chaque dimanche matin. Financièrement indépendant. Profession: Enseignant.','Etat général peu altéré, bien orienté dans le temps et dans l\'espace, normohydraté, normocoloré, dyspnéique au repos.\nExam cardiovasc: B1 B2 audibles et réguliers, tachycarde, pas de souffle cardiaque ni carotidien, pour pédieux et tibiaux postérieurs palpés.\nExam pneumo: Hypoventilation basale gauche avec crépitent fins. Matité à la percussion basale gauche.\nExam abdo: Souple, dépressible, indolore, péristaltisme présent, pas d\'HSM\nExam neuro: sp\nExam ORL: sp\nExam Urogénital: sp\nExam ostéoart: sp\nExam ophtalmo: sp','Biologie (NFS, CRP, iono), hémoc, expecto, RXTh f/p',NULL,'2019-11-24 11:51:58','2019-11-24 11:52:32','azongmo-1573517982-20549509-1574599918',NULL,NULL,'Paracetamol 1 g max 3 x/j si douleur ou fièvre\nAugmentin 1 g 3 x/j pendant 7 jours.');
/*!40000 ALTER TABLE `consultation_medecine_generales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultation_motif`
--

DROP TABLE IF EXISTS `consultation_motif`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consultation_motif` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `consultation_medecine_generale_id` bigint(20) unsigned NOT NULL,
  `motif_id` bigint(20) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consultation_motif_consultation_medecine_generale_id_foreign` (`consultation_medecine_generale_id`),
  KEY `consultation_motif_motif_id_foreign` (`motif_id`),
  CONSTRAINT `consultation_motif_consultation_medecine_generale_id_foreign` FOREIGN KEY (`consultation_medecine_generale_id`) REFERENCES `consultation_medecine_generales` (`id`),
  CONSTRAINT `consultation_motif_motif_id_foreign` FOREIGN KEY (`motif_id`) REFERENCES `motifs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultation_motif`
--

LOCK TABLES `consultation_motif` WRITE;
/*!40000 ALTER TABLE `consultation_motif` DISABLE KEYS */;
INSERT INTO `consultation_motif` VALUES (1,1,2,NULL,NULL,NULL),(2,1,3,NULL,NULL,NULL),(3,6,4,NULL,NULL,NULL),(4,6,5,NULL,NULL,NULL),(5,6,6,NULL,NULL,NULL),(6,3,7,NULL,NULL,NULL),(7,9,8,NULL,NULL,NULL),(8,10,3,NULL,NULL,NULL),(9,11,3,NULL,NULL,NULL),(10,12,9,NULL,NULL,NULL),(11,12,10,NULL,NULL,NULL),(12,12,11,NULL,NULL,NULL),(13,12,12,NULL,NULL,NULL),(14,12,13,NULL,NULL,NULL),(15,12,14,NULL,NULL,NULL),(16,12,15,NULL,NULL,NULL);
/*!40000 ALTER TABLE `consultation_motif` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultation_obstetriques`
--

DROP TABLE IF EXISTS `consultation_obstetriques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consultation_obstetriques` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dossier_medical_id` bigint(20) unsigned NOT NULL,
  `date_creation` date NOT NULL DEFAULT '2019-10-08',
  `numero_grossesse` int(11) NOT NULL,
  `ddr` date NOT NULL,
  `antecedent_conjoint` text COLLATE utf8mb4_unicode_ci,
  `serologie` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groupe_sanguin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut_socio_familiale` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assuetudes` text COLLATE utf8mb4_unicode_ci,
  `antecedent_de_transfusion` text COLLATE utf8mb4_unicode_ci,
  `facteur_de_risque` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archieved_at` timestamp NULL DEFAULT NULL,
  `passed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `consultation_obstetriques_slug_unique` (`slug`),
  KEY `consultation_obstetriques_dossier_medical_id_foreign` (`dossier_medical_id`),
  CONSTRAINT `consultation_obstetriques_dossier_medical_id_foreign` FOREIGN KEY (`dossier_medical_id`) REFERENCES `dossier_medicals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultation_obstetriques`
--

LOCK TABLES `consultation_obstetriques` WRITE;
/*!40000 ALTER TABLE `consultation_obstetriques` DISABLE KEYS */;
INSERT INTO `consultation_obstetriques` VALUES (1,2,'2019-10-08',1,'2019-10-11','zerzer','rerz','A+','zerzer','zerz',NULL,'zerzer',NULL,'2019-10-11 07:25:11','2019-10-11 07:25:32','eric-1570634615-94015818-1570785911','2019-10-11 07:25:32','2019-10-11 07:25:27'),(2,3,'2019-10-08',2,'2019-10-15','Aucun','Toxo -, HIV -','B+','femme seule. Revenu très bas.','Tabac-\nAlcool-',NULL,'Patiente âgée',NULL,'2019-10-15 10:18:41','2019-10-16 20:02:51','dino-louis-1571136312-53882262-1571141921','2019-10-16 20:02:51','2019-10-16 20:02:40'),(3,2,'2019-10-08',3,'2019-10-16',NULL,NULL,'B-',NULL,NULL,NULL,NULL,NULL,'2019-10-15 10:25:29','2019-10-16 07:30:36','eric-1570634615-94015818-1571142329',NULL,NULL),(4,6,'2019-10-08',4,'2019-10-17','sdfsdf','A','A-','sdfsdf','sdfsdfsdf',NULL,'sdfsd',NULL,'2019-10-16 12:11:05','2019-10-16 12:11:05','dfgdfgdfgdf-1571226396-80401155-1571235065',NULL,NULL),(5,5,'2019-10-08',5,'2019-10-17','Ras','Ifjr','AB+','Celib','Drogue dure',NULL,'HTA vasculaure',NULL,'2019-10-17 15:42:00','2019-10-17 15:42:00','jesusfictif-1571165162-37317794-1571334120',NULL,NULL),(6,3,'2019-10-08',6,'2019-10-19','violence conjugale','Rub-P; CMV-P; Toxo-NP','A+','marié, vie en appartement, sans revenus','tabac 10 cig/j\nJoint 1/j',NULL,'tabagique',NULL,'2019-10-19 15:43:17','2019-10-19 15:43:17','dino-louis-1571136312-53882262-1571506997',NULL,NULL),(7,7,'2019-10-08',7,'2019-12-07','bcvbcvb','cvbcvb','A-','cvbcvb','cvbcvb',NULL,'cvbcv',NULL,'2019-11-07 11:06:49','2019-11-07 11:06:49','nkouekam-1571424920-12329665-1573128409',NULL,NULL);
/*!40000 ALTER TABLE `consultation_obstetriques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consultation_prenatales`
--

DROP TABLE IF EXISTS `consultation_prenatales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consultation_prenatales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `consultation_obstetrique_id` bigint(20) unsigned NOT NULL,
  `date_creation` date NOT NULL DEFAULT '2019-10-08',
  `type_de_consultation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plaintes` text COLLATE utf8mb4_unicode_ci,
  `recommandations` text COLLATE utf8mb4_unicode_ci,
  `examen_clinique` text COLLATE utf8mb4_unicode_ci,
  `examen_complementaire` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archieved_at` timestamp NULL DEFAULT NULL,
  `passed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `consultation_prenatales_slug_unique` (`slug`),
  KEY `consultation_prenatales_consultation_obstetrique_id_foreign` (`consultation_obstetrique_id`),
  CONSTRAINT `consultation_prenatales_consultation_obstetrique_id_foreign` FOREIGN KEY (`consultation_obstetrique_id`) REFERENCES `consultation_obstetriques` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultation_prenatales`
--

LOCK TABLES `consultation_prenatales` WRITE;
/*!40000 ALTER TABLE `consultation_prenatales` DISABLE KEYS */;
INSERT INTO `consultation_prenatales` VALUES (1,1,'2019-10-08','1 CPN',NULL,NULL,NULL,NULL,NULL,'2019-10-11 11:48:12','2019-10-11 13:39:12','1-cpn-1570801692','2019-10-11 13:39:12','2019-10-11 11:50:42'),(2,2,'2019-10-08','1 CPN','Fatigue,\nNausées+++,\nVomissements','Repos relatif,\nFractionner les repas,\nAntimétil au besoin',NULL,NULL,NULL,'2019-10-15 10:45:45','2019-10-15 10:46:23','1-cpn-1571143545',NULL,NULL),(3,6,'2019-10-08','1 CPN','rezrzer','zrzrz','rzerzer','zerzer',NULL,'2019-11-08 13:25:10','2019-11-08 13:25:10','1-cpn-1573223109',NULL,NULL);
/*!40000 ALTER TABLE `consultation_prenatales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dossier_allergie`
--

DROP TABLE IF EXISTS `dossier_allergie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dossier_allergie` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dossier_medical_id` bigint(20) unsigned NOT NULL,
  `allergie_id` bigint(20) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dossier_allergie_dossier_medical_id_foreign` (`dossier_medical_id`),
  KEY `dossier_allergie_allergie_id_foreign` (`allergie_id`),
  CONSTRAINT `dossier_allergie_allergie_id_foreign` FOREIGN KEY (`allergie_id`) REFERENCES `allergies` (`id`),
  CONSTRAINT `dossier_allergie_dossier_medical_id_foreign` FOREIGN KEY (`dossier_medical_id`) REFERENCES `dossier_medicals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dossier_allergie`
--

LOCK TABLES `dossier_allergie` WRITE;
/*!40000 ALTER TABLE `dossier_allergie` DISABLE KEYS */;
INSERT INTO `dossier_allergie` VALUES (1,2,1,NULL,NULL,NULL),(2,3,2,NULL,NULL,NULL),(3,7,3,NULL,NULL,NULL),(4,9,4,NULL,NULL,NULL),(5,7,5,NULL,NULL,NULL),(6,5,6,NULL,NULL,NULL),(7,7,7,NULL,NULL,NULL);
/*!40000 ALTER TABLE `dossier_allergie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dossier_medicals`
--

DROP TABLE IF EXISTS `dossier_medicals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dossier_medicals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned NOT NULL,
  `date_de_creation` date NOT NULL,
  `numero_dossier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dossier_medicals_numero_dossier_unique` (`numero_dossier`),
  UNIQUE KEY `dossier_medicals_slug_unique` (`slug`),
  KEY `dossier_medicals_patient_id_foreign` (`patient_id`),
  CONSTRAINT `dossier_medicals_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dossier_medicals`
--

LOCK TABLES `dossier_medicals` WRITE;
/*!40000 ALTER TABLE `dossier_medicals` DISABLE KEYS */;
INSERT INTO `dossier_medicals` VALUES (1,4,'2019-10-09','96985919','2019-10-09 13:23:35','2019-10-09 15:34:27','2019-10-09 15:34:27','eric-1570634615-96985919'),(2,4,'2019-10-11','94015818','2019-10-11 07:22:43','2019-10-11 07:22:43',NULL,'eric-1570634615-94015818'),(3,40,'2019-10-15','53882262','2019-10-15 08:45:12','2019-10-15 08:45:12',NULL,'dino-louis-1571136312-53882262'),(4,41,'2019-10-15','79322917','2019-10-15 08:48:16','2019-10-15 08:48:16',NULL,'rambo-rambo-1571136496-79322917'),(5,48,'2019-10-15','37317794','2019-10-15 16:46:02','2019-10-15 16:46:02',NULL,'jesusfictif-1571165162-37317794'),(6,49,'2019-10-16','80401155','2019-10-16 09:46:36','2019-10-16 09:46:36',NULL,'dfgdfgdfgdf-1571226396-80401155'),(7,50,'2019-10-18','12329665','2019-10-18 16:55:20','2019-10-18 16:55:20',NULL,'nkouekam-1571424920-12329665'),(8,51,'2019-11-11','28061838','2019-11-11 12:42:40','2019-11-11 12:42:40',NULL,'eric-1573479759-28061838'),(9,52,'2019-11-12','20549509','2019-11-11 23:19:42','2019-11-11 23:19:42',NULL,'azongmo-1573517982-20549509'),(10,53,'2019-11-12','71149334','2019-11-11 23:19:45','2019-11-11 23:19:45',NULL,'azongmo-1573517985-71149334'),(11,54,'2019-11-12','94912839','2019-11-12 15:47:07','2019-11-12 15:47:07',NULL,'bekolo-1573577227-94912839'),(12,60,'2019-11-24','24405055','2019-11-24 17:16:06','2019-11-24 17:16:06',NULL,'nde-1574619366-24405055');
/*!40000 ALTER TABLE `dossier_medicals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `echographies`
--

DROP TABLE IF EXISTS `echographies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `echographies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `consultation_obstetrique_id` bigint(20) unsigned NOT NULL,
  `date_creation` date NOT NULL DEFAULT '2019-10-08',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ddr` date NOT NULL,
  `dpa` date NOT NULL,
  `semaine_amenorrhee` int(11) DEFAULT NULL,
  `biometrie` text COLLATE utf8mb4_unicode_ci,
  `annexe` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archieved_at` timestamp NULL DEFAULT NULL,
  `passed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `echographies_slug_unique` (`slug`),
  KEY `echographies_consultation_obstetrique_id_foreign` (`consultation_obstetrique_id`),
  CONSTRAINT `echographies_consultation_obstetrique_id_foreign` FOREIGN KEY (`consultation_obstetrique_id`) REFERENCES `consultation_obstetriques` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `echographies`
--

LOCK TABLES `echographies` WRITE;
/*!40000 ALTER TABLE `echographies` DISABLE KEYS */;
INSERT INTO `echographies` VALUES (1,2,'2019-10-08','1er trimestre','2019-10-15','2020-07-15',1,NULL,NULL,NULL,NULL,'2019-10-15 10:54:12','2019-10-15 10:54:12','1er-trimestre-1571144052',NULL,NULL),(2,4,'2019-10-08','3eme trimesstre','2019-01-20','2020-12-20',9,'sdfsd','sdfsdd','sdfsdf',NULL,'2019-11-08 13:27:53','2019-11-08 13:27:53','3eme-trimesstre-1573223273',NULL,NULL);
/*!40000 ALTER TABLE `echographies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etablissement_exercice_patient`
--

DROP TABLE IF EXISTS `etablissement_exercice_patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etablissement_exercice_patient` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `etablissement_id` bigint(20) unsigned NOT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `etablissement_exercice_patient_etablissement_id_foreign` (`etablissement_id`),
  KEY `etablissement_exercice_patient_patient_id_foreign` (`patient_id`),
  CONSTRAINT `etablissement_exercice_patient_etablissement_id_foreign` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissement_exercices` (`id`),
  CONSTRAINT `etablissement_exercice_patient_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etablissement_exercice_patient`
--

LOCK TABLES `etablissement_exercice_patient` WRITE;
/*!40000 ALTER TABLE `etablissement_exercice_patient` DISABLE KEYS */;
INSERT INTO `etablissement_exercice_patient` VALUES (1,2,50,NULL,NULL,NULL),(2,3,52,NULL,NULL,NULL),(3,3,54,NULL,NULL,NULL),(4,2,4,NULL,NULL,NULL);
/*!40000 ALTER TABLE `etablissement_exercice_patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etablissement_exercice_praticien`
--

DROP TABLE IF EXISTS `etablissement_exercice_praticien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etablissement_exercice_praticien` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `etablissement_id` bigint(20) unsigned NOT NULL,
  `praticien_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `etablissement_exercice_praticien_etablissement_id_foreign` (`etablissement_id`),
  KEY `etablissement_exercice_praticien_praticien_id_foreign` (`praticien_id`),
  CONSTRAINT `etablissement_exercice_praticien_etablissement_id_foreign` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissement_exercices` (`id`),
  CONSTRAINT `etablissement_exercice_praticien_praticien_id_foreign` FOREIGN KEY (`praticien_id`) REFERENCES `praticiens` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etablissement_exercice_praticien`
--

LOCK TABLES `etablissement_exercice_praticien` WRITE;
/*!40000 ALTER TABLE `etablissement_exercice_praticien` DISABLE KEYS */;
INSERT INTO `etablissement_exercice_praticien` VALUES (1,3,43,NULL,NULL,NULL),(2,2,44,NULL,NULL,NULL),(3,3,45,NULL,NULL,NULL),(4,2,55,NULL,NULL,NULL),(5,2,56,NULL,NULL,NULL);
/*!40000 ALTER TABLE `etablissement_exercice_praticien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etablissement_exercices`
--

DROP TABLE IF EXISTS `etablissement_exercices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etablissement_exercices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `etablissement_exercices_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etablissement_exercices`
--

LOCK TABLES `etablissement_exercices` WRITE;
/*!40000 ALTER TABLE `etablissement_exercices` DISABLE KEYS */;
INSERT INTO `etablissement_exercices` VALUES (1,'sdfsdfsdfds','sdfsdfsdfsd','2019-10-09 14:37:37','2019-10-15 13:41:40','2019-10-15 13:41:40','sdfsdfsdfds-1570639057'),(2,'Kutenda Médical','Centre de santé','2019-10-15 08:31:46','2019-10-15 08:31:46',NULL,'kutenda-medical-1571135506'),(3,'MEC','Clinique de la MEC','2019-10-15 08:32:03','2019-10-15 08:32:03',NULL,'mec-1571135523');
/*!40000 ALTER TABLE `etablissement_exercices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestionnaires`
--

DROP TABLE IF EXISTS `gestionnaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gestionnaires` (
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `civilite` enum('M.','Mme/Mlle.','Dr.','Pr.') COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `gestionnaires_slug_unique` (`slug`),
  KEY `gestionnaires_user_id_foreign` (`user_id`),
  CONSTRAINT `gestionnaires_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestionnaires`
--

LOCK TABLES `gestionnaires` WRITE;
/*!40000 ALTER TABLE `gestionnaires` DISABLE KEYS */;
INSERT INTO `gestionnaires` VALUES ('dfdsfsdfsd-1570802530',37,'Dr.','2019-11-08 16:24:20','2019-10-11 12:02:10','2019-11-08 16:24:20'),('eezerzer-1570697838',8,'Dr.','2019-10-11 07:09:23','2019-10-10 06:57:18','2019-10-11 07:09:23'),('el-presidente-1571136673',42,'M.',NULL,'2019-10-15 08:51:13','2019-10-16 07:31:55'),('eric-1570784888',35,'Dr.',NULL,'2019-10-11 07:08:08','2019-11-13 13:47:17'),('gestionnaire-1570798652',36,'M.','2019-10-11 10:57:42','2019-10-11 10:57:32','2019-10-11 10:57:42'),('pepsi-charly-1571164817',47,'Dr.',NULL,'2019-10-15 16:40:17','2019-11-12 17:53:30'),('wilfried-1573752199',58,'M.',NULL,'2019-11-14 16:23:19','2019-11-14 16:23:19');
/*!40000 ALTER TABLE `gestionnaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospitalisation_motif`
--

DROP TABLE IF EXISTS `hospitalisation_motif`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hospitalisation_motif` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hospitalisation_id` bigint(20) unsigned NOT NULL,
  `motif_id` bigint(20) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hospitalisation_motif_hospitalisation_id_foreign` (`hospitalisation_id`),
  KEY `hospitalisation_motif_motif_id_foreign` (`motif_id`),
  CONSTRAINT `hospitalisation_motif_hospitalisation_id_foreign` FOREIGN KEY (`hospitalisation_id`) REFERENCES `hospitalisations` (`id`),
  CONSTRAINT `hospitalisation_motif_motif_id_foreign` FOREIGN KEY (`motif_id`) REFERENCES `motifs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospitalisation_motif`
--

LOCK TABLES `hospitalisation_motif` WRITE;
/*!40000 ALTER TABLE `hospitalisation_motif` DISABLE KEYS */;
INSERT INTO `hospitalisation_motif` VALUES (1,1,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `hospitalisation_motif` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospitalisations`
--

DROP TABLE IF EXISTS `hospitalisations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hospitalisations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dossier_medical_id` bigint(20) unsigned NOT NULL,
  `date_entree` date NOT NULL DEFAULT '2019-10-08',
  `date_sortie` date DEFAULT NULL,
  `histoire_clinique` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mode_de_vie` text COLLATE utf8mb4_unicode_ci,
  `evolution` text COLLATE utf8mb4_unicode_ci,
  `conclusion` text COLLATE utf8mb4_unicode_ci,
  `avis` text COLLATE utf8mb4_unicode_ci,
  `traitement_sortie` text COLLATE utf8mb4_unicode_ci,
  `rendez_vous` text COLLATE utf8mb4_unicode_ci,
  `examen_clinique` text COLLATE utf8mb4_unicode_ci,
  `examen_complementaire` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `passed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hospitalisations_slug_unique` (`slug`),
  KEY `hospitalisations_dossier_medical_id_foreign` (`dossier_medical_id`),
  CONSTRAINT `hospitalisations_dossier_medical_id_foreign` FOREIGN KEY (`dossier_medical_id`) REFERENCES `dossier_medicals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hospitalisations`
--

LOCK TABLES `hospitalisations` WRITE;
/*!40000 ALTER TABLE `hospitalisations` DISABLE KEYS */;
INSERT INTO `hospitalisations` VALUES (1,1,'0004-05-04',NULL,'45\n45','eterte','ertert','ertertertert','ertert','ertert','61899-02-08',NULL,NULL,'2019-10-09 14:36:58','2019-10-09 13:28:40','2019-10-09 14:36:58','eric-1570634615-96985919-1570634920','2019-10-09 13:29:26','2019-10-09 13:29:12'),(2,4,'2018-02-12','2020-05-15','compliqué','fdf','sdfs','sdfsd','sdfsdf','sdfsd','2020-12-02',NULL,NULL,NULL,'2019-11-08 13:31:12','2019-11-13 19:35:31','rambo-rambo-1571136496-79322917-1573223472',NULL,'2019-11-13 19:35:31'),(3,5,'2019-10-01','2019-11-24','Patient pour malaria sévère','Ne dort pas sous MILDA','Evolution favorable de l\'état clinique après traitement par voie intraveineuse','Malaria sévère','/','Trimalaril','2019-11-16',NULL,NULL,NULL,'2019-11-25 00:54:14','2019-11-25 00:55:23','jesusfictif-1571165162-37317794-1574646854',NULL,'2019-11-25 00:55:23'),(4,5,'2019-10-01','2019-11-24','Patient pour malaria sévère','Ne dort pas sous MILDA','Evolution favorable de l\'état clinique après traitement par voie intraveineuse','Malaria sévère','/','Trimalaril','2019-11-16',NULL,NULL,NULL,'2019-11-25 00:54:14','2019-11-25 00:54:14','jesusfictif-1571165162-37317794-1574646854-1',NULL,NULL);
/*!40000 ALTER TABLE `hospitalisations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medecin_controles`
--

DROP TABLE IF EXISTS `medecin_controles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medecin_controles` (
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialite_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `civilite` enum('M.','Mme/Mlle.','Dr.','Pr.') COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_ordre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `medecin_controles_slug_unique` (`slug`),
  KEY `medecin_controles_specialite_id_foreign` (`specialite_id`),
  KEY `medecin_controles_user_id_foreign` (`user_id`),
  CONSTRAINT `medecin_controles_specialite_id_foreign` FOREIGN KEY (`specialite_id`) REFERENCES `specialites` (`id`),
  CONSTRAINT `medecin_controles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medecin_controles`
--

LOCK TABLES `medecin_controles` WRITE;
/*!40000 ALTER TABLE `medecin_controles` DISABLE KEYS */;
INSERT INTO `medecin_controles` VALUES ('mbouga-1573756031',6,59,'Pr.','132465798',NULL,'2019-11-14 17:27:11','2019-11-14 17:27:11');
/*!40000 ALTER TABLE `medecin_controles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2016_06_01_000001_create_oauth_auth_codes_table',1),(4,'2016_06_01_000002_create_oauth_access_tokens_table',1),(5,'2016_06_01_000003_create_oauth_refresh_tokens_table',1),(6,'2016_06_01_000004_create_oauth_clients_table',1),(7,'2016_06_01_000005_create_oauth_personal_access_clients_table',1),(8,'2019_06_25_092926_create_permission_tables',1),(9,'2019_07_15_090920_create_souscripteurs_table',1),(10,'2019_07_15_090921_create_patients_table',1),(11,'2019_07_15_090922_create_professions_table',1),(12,'2019_07_15_090923_create_etabissement_exercices_table',1),(13,'2019_07_15_090924_create_specialites_table',1),(14,'2019_07_15_100923_create_praticiens_table',1),(15,'2019_07_15_110146_create_medecin_controles_table',1),(16,'2019_07_15_110727_create_gestionnaires_table',1),(17,'2019_07_16_120654_create_etablissement_exercice_praticiens_table',1),(18,'2019_07_18_093551_create_affiliations_table',1),(19,'2019_07_18_104653_create_dossier_medicals_table',1),(20,'2019_07_19_110315_create_consultation_medecine_generales_table',1),(21,'2019_07_19_125537_create_motifs_table',1),(22,'2019_07_23_133324_create_consultation_motifs_table',1),(23,'2019_07_24_082541_create_antecedents_table',1),(24,'2019_07_24_101042_create_allergies_table',1),(25,'2019_07_24_103326_create_dossier_allergies_table',1),(26,'2019_07_24_130500_create_traitements_table',1),(27,'2019_07_24_131828_create_consultation_traitements_table',1),(28,'2019_07_24_144806_create_parametre_communs_table',1),(29,'2019_07_25_104647_create_conclusions_table',1),(30,'2019_07_26_095815_create_consultation_obstetriques_table',1),(31,'2019_07_26_114204_create_consultation_prenatales_table',1),(32,'2019_07_26_120941_create_parametre_obstetriques_table',1),(33,'2019_07_30_091543_create_echographies_table',1),(34,'2019_07_30_094929_create_hospitalisations_table',1),(35,'2019_08_01_083610_create_auteurs_table',1),(36,'2019_08_05_103641_add_archieved_at_and_passed_at_to_consultation_medecine_generales_table',1),(37,'2019_08_05_103751_add_archieved_at_and_passed_at_to_consultation_obstetriques_table',1),(38,'2019_08_05_103906_add_archieved_at_and_passed_at_to_consultation_prenatales_table',1),(39,'2019_09_16_104047_create_etablissement_exercice_patients_table',1),(40,'2019_09_17_074456_create_hospitalisation_motifs_table',1),(41,'2019_09_17_141900_create_resultat_labos_table',1),(42,'2019_09_17_143257_create_resultat_imageries_table',1),(43,'2019_09_20_080707_create_traitement_actuels_table',1),(44,'2019_09_20_080844_create_traitement_proposes_table',1),(45,'2019_10_02_092029_add_archieved_at_and_passed_at_to_hospitalisation_table',1),(46,'2019_10_02_103743_add_traitement_propose_to_consultation_medecine_table',1),(47,'2019_10_04_083833_add_archieved_and_passed_to_echographies_table',1),(48,'2019_10_16_151517_add_adresse_to_users_table',2),(49,'2019_11_04_175646_add_patient_id_to_auteurs_table',3),(50,'2019_11_11_142520_set_email_to_not_unique_to_users_table',4),(51,'2019_11_23_082813_set_reference_nullable_to_conclusions_table',5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\User',1),(3,'App\\User',2),(3,'App\\User',3),(2,'App\\User',4),(6,'App\\User',5),(6,'App\\User',6),(3,'App\\User',7),(6,'App\\User',8),(6,'App\\User',10),(6,'App\\User',11),(6,'App\\User',12),(6,'App\\User',13),(6,'App\\User',14),(6,'App\\User',15),(6,'App\\User',16),(6,'App\\User',17),(6,'App\\User',18),(6,'App\\User',19),(6,'App\\User',20),(6,'App\\User',21),(6,'App\\User',22),(6,'App\\User',23),(6,'App\\User',24),(6,'App\\User',25),(6,'App\\User',26),(3,'App\\User',27),(6,'App\\User',28),(6,'App\\User',29),(6,'App\\User',30),(6,'App\\User',31),(6,'App\\User',32),(6,'App\\User',33),(6,'App\\User',34),(6,'App\\User',35),(6,'App\\User',36),(6,'App\\User',37),(3,'App\\User',38),(3,'App\\User',39),(2,'App\\User',40),(2,'App\\User',41),(6,'App\\User',42),(4,'App\\User',43),(4,'App\\User',44),(4,'App\\User',45),(3,'App\\User',46),(6,'App\\User',47),(2,'App\\User',48),(2,'App\\User',49),(2,'App\\User',50),(2,'App\\User',51),(2,'App\\User',52),(2,'App\\User',53),(2,'App\\User',54),(4,'App\\User',55),(4,'App\\User',56),(3,'App\\User',57),(6,'App\\User',58),(5,'App\\User',59),(2,'App\\User',60),(3,'App\\User',61),(3,'App\\User',62),(3,'App\\User',63);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motifs`
--

DROP TABLE IF EXISTS `motifs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motifs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `motifs_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motifs`
--

LOCK TABLES `motifs` WRITE;
/*!40000 ALTER TABLE `motifs` DISABLE KEYS */;
INSERT INTO `motifs` VALUES (1,'sdezefsdf','sdfsdfsdfzzeze',NULL,'2019-10-09 14:36:34','2019-10-21 12:08:09','sdfsdf-1570638994'),(2,'rty','rtyry','2019-10-21 12:08:16','2019-10-11 12:17:11','2019-10-21 12:08:16','rty-1570803431'),(3,'erer','Mal gastrique',NULL,'2019-10-18 13:03:59','2019-10-18 13:03:59','erer-1571411039'),(4,'dssdfsd','fsdfsdfsdf','2019-11-22 09:47:42','2019-11-21 11:40:40','2019-11-22 09:47:42','dssdfsd-1574340040'),(5,'Sorcelerie','sdf','2019-11-21 11:41:50','2019-11-21 11:40:56','2019-11-21 11:41:50','sorcelerie-1574340056'),(6,'Sorcelerie','Est réputé très grand sorcier',NULL,'2019-11-21 11:41:31','2019-11-21 11:41:31','sorcelerie-1574340091'),(7,'Hallucinations','Voit le saint esprit quand il a mangé',NULL,'2019-11-22 11:07:41','2019-11-22 11:08:05','hallucinations-1574424461'),(8,'2019-11-23','maux de poche chaque mois',NULL,'2019-11-23 16:30:52','2019-11-23 16:30:52','2019-11-23-1574530252'),(9,'2019-11-24','Fièvre',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58','2019-11-24-1574599918'),(10,'2019-11-24','Courbatures',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58','2019-11-24-1574599918-1'),(11,'2019-11-24','Rhinorrhée',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58','2019-11-24-1574599918-2'),(12,'2019-11-24','Toux',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58','2019-11-24-1574599918-3'),(13,'2019-11-24','Frissons',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58','2019-11-24-1574599918-4'),(14,'2019-11-24','Maux de tête',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58','2019-11-24-1574599918-5'),(15,'2019-11-24','Vomissements',NULL,'2019-11-24 11:51:58','2019-11-24 11:51:58','2019-11-24-1574599918-6');
/*!40000 ALTER TABLE `motifs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('00fb39e05466dffb957825001fb28caf5a627281b2308553d1608ff304183ad0a6012e823e3a22c5',1,2,NULL,'[]',1,'2019-10-18 16:50:29','2019-10-18 16:50:29','2019-10-19 18:50:29'),('01f0f4bdcf8894432552f29f1179af9d1a9804285184c459622717f3b8896ef8b94afe90882e6ea5',1,2,NULL,'[]',1,'2019-11-19 14:08:41','2019-11-19 14:08:41','2019-11-20 15:08:41'),('02174a7d36d963cb446467b457811b6d36898f9afeb3c105e18e4c506a421fee5153400d2e67c5cb',1,2,NULL,'[]',0,'2019-10-16 15:57:26','2019-10-16 15:57:26','2019-10-17 17:57:26'),('026571704d356dde3b711dc15a8404a6b7d3afa01c18d3c16df540b77a5d418b8d78eda289b4c178',1,2,NULL,'[]',0,'2019-10-18 06:50:03','2019-10-18 06:50:03','2019-10-19 08:50:03'),('0274cfef5e2acd3e079b3b2cf0bfd045570f2d7e3ed71998219441f29f77dbb6b038a41c1be88c30',1,2,NULL,'[]',0,'2019-10-09 11:09:10','2019-10-09 11:09:10','2019-10-10 13:09:10'),('03b92e71df5e1c9334d1e61f4c9f974214a941dbbbd0e95c956cf8e3795143fd2497e52717ff5220',57,2,NULL,'[]',1,'2019-11-24 17:11:38','2019-11-24 17:11:38','2019-11-25 18:11:38'),('03dd47bf8fdedfbb411ac968ca33a4a1b7fa4263f2c2d68621022788550694fe856b9835cbb0ce68',1,2,NULL,'[]',1,'2019-11-24 17:33:15','2019-11-24 17:33:15','2019-11-25 18:33:15'),('044428d4f430f5eb8d20330f167688c1a80001a0aa94189b9ddf6326ca33509290573bfd8b3799dd',1,2,NULL,'[]',0,'2019-10-09 11:21:47','2019-10-09 11:21:47','2019-10-10 13:21:47'),('061694aeed91b01afcae4f08f776a9de485ad93523aa76742cb54da36600de79e697d08154b38f22',1,2,NULL,'[]',0,'2019-11-22 14:17:58','2019-11-22 14:17:58','2019-11-23 15:17:58'),('06504a5b553644c1773bcba4aaa9746e165c3e23895056942ea41c0a88fbb30e3b36ca1e367879bf',55,2,NULL,'[]',1,'2019-11-24 16:57:55','2019-11-24 16:57:55','2019-11-25 17:57:55'),('077a9a221698755ed1484812df9da9d4dec13ce31f0e1ceaf196be44d351ddb079b2ffd0aaaae1b4',50,2,NULL,'[]',1,'2019-11-14 16:17:47','2019-11-14 16:17:47','2019-11-15 17:17:47'),('07d19a34d1986ced16f74f05289fb1d351cb93e28d76b9519ca4cdd684075a7812a0c69bee895c57',58,2,NULL,'[]',1,'2019-11-21 06:54:06','2019-11-21 06:54:06','2019-11-22 07:54:06'),('081970d72cd0d6d7fffe42ed6e3370c9dd243aaaf3503e3ffc2f3c5cda63e82e75388608a2e35181',55,2,NULL,'[]',0,'2019-11-14 20:08:43','2019-11-14 20:08:43','2019-11-15 21:08:43'),('08626629a0d60851bf94d9c5874f30b622f8a22db462ba0274624b3c5c2f3129f7646bc56711dc89',1,2,NULL,'[]',0,'2019-10-11 08:51:55','2019-10-11 08:51:55','2019-10-12 10:51:55'),('088d6a1379b298bf4fafff0af3c6c1348f44d1633d119a1382549f161fca5346a5017f84f3a1fe99',1,2,NULL,'[]',0,'2019-10-11 10:50:04','2019-10-11 10:50:04','2019-10-12 12:50:04'),('0960a191f47f8319fd8aaf99b52460fc923a8444eeb4c558fe7a997683effc652765160625150087',1,2,NULL,'[]',0,'2019-10-11 13:23:24','2019-10-11 13:23:24','2019-10-12 15:23:24'),('0a2d7a68564e2c7b3e50499387153b248026fed8cb6084238f8a1f52d8602c2a4370ef2a0e4d99d4',58,2,NULL,'[]',1,'2019-11-21 11:32:39','2019-11-21 11:32:39','2019-11-22 12:32:39'),('0b472d41a87597e2c3a89bf03ed4e9f7fc5dc34349c65996a8e839baf5e1009d881673f29c89f2df',1,2,NULL,'[]',0,'2019-10-15 08:07:13','2019-10-15 08:07:13','2019-10-16 10:07:13'),('0bda358503e2706cb7657920f50ef5bd049490357b70570cf9233f06a174d21ea666d060e8be8278',1,2,NULL,'[]',1,'2019-10-18 17:00:46','2019-10-18 17:00:46','2019-10-19 19:00:46'),('0d4787260385897434acb39cb65009cb9a34a044e76c7a514b8b0baf7c6ddb0d1068a8ac0953b196',1,2,NULL,'[]',0,'2019-10-11 11:24:05','2019-10-11 11:24:05','2019-10-12 13:24:05'),('0d4d59eb9df67717a49f310e3908307d20b9a5731b08818740afe7dcb24619904c1201868e4ed163',1,2,NULL,'[]',0,'2019-10-09 13:54:52','2019-10-09 13:54:52','2019-10-10 15:54:52'),('0db41d711a504b19602c11340aa2af64133b8a87f24699c94d4e1d809a935d3a2daea28a2e4edf07',1,2,NULL,'[]',0,'2019-10-15 14:30:49','2019-10-15 14:30:49','2019-10-16 16:30:49'),('0dc74f8269ca6cbefa3c26ea6c74d699af580883ad6b8784f8e81b4f48973e903e4c279c4d7e4311',1,2,NULL,'[]',1,'2019-11-13 11:19:37','2019-11-13 11:19:37','2019-11-14 12:19:37'),('0df5f8e0c24a47937926e53d64c6659d6a9a87f757664ebb8c47b969e0346155d1e9fd0473de45cd',1,2,NULL,'[]',0,'2019-11-18 12:52:44','2019-11-18 12:52:44','2019-11-19 13:52:44'),('0e4e31df2942e23ed32ab8f64b4bc06752d1dc672a836b54f1bcd7a35f5570b63120b894775eb4d7',1,2,NULL,'[]',0,'2019-10-15 13:39:23','2019-10-15 13:39:23','2019-10-16 15:39:23'),('0fdcdcc801f7a85e7e7b577136a8056cab66142030ec349ba69a61b0b9b6b8405b55aa0c44d7caa2',55,2,NULL,'[]',0,'2019-11-24 17:08:22','2019-11-24 17:08:22','2019-11-25 18:08:22'),('10468a5299ef622fe5d0acdd1a72f296c516a8fe4cac55612d82dc474a46fe9838bbd1e844a0fdeb',1,2,NULL,'[]',0,'2019-10-10 11:45:57','2019-10-10 11:45:57','2019-10-11 13:45:57'),('1101d88a01805b8276c1db1e90faa41ae88d659686a86fc91f9cf7ede31c38800f413b8f7c4dd3e3',1,2,NULL,'[]',0,'2019-10-18 14:47:02','2019-10-18 14:47:02','2019-10-19 16:47:02'),('11711dfba070d5514e117d3fa596513c63599ed7a6f03c8fbadf333bf5e3b5d10912614f275af470',1,2,NULL,'[]',1,'2019-10-25 10:13:19','2019-10-25 10:13:19','2019-10-26 12:13:19'),('117f10db3d2a6b57a11e748465d71ff6c26bb6d43188d2b1e832371d8dc946561ab5c0bf4661b450',1,2,NULL,'[]',1,'2019-10-17 10:22:51','2019-10-17 10:22:51','2019-10-18 12:22:51'),('1199bbf76ca0b0c4ca4bad3b8a1573e0606c000cbeb86884fb32457ad8db7336a8bc9ad4a8fe9826',1,2,NULL,'[]',0,'2019-10-11 07:58:50','2019-10-11 07:58:50','2019-10-12 09:58:50'),('12096ea5c8696fc22c0b21f8c46c5d62f94542c14c3e5f6e423e97f5dfcda81b199c51f2e3c25811',57,2,NULL,'[]',1,'2019-11-24 10:43:31','2019-11-24 10:43:31','2019-11-25 11:43:31'),('12a2bc9cdc8842a67074db43b0601b39232376f92223387ee4e3f1c6732ecc6774b5de6078c3dfb3',1,2,NULL,'[]',0,'2019-11-18 12:54:12','2019-11-18 12:54:12','2019-11-19 13:54:12'),('12ee70953d90b9cebcb82c00d8ad6908d9ecb0aa00681b105e46696e7a76de18ce8f28219a2747fa',1,2,NULL,'[]',0,'2019-10-22 06:56:22','2019-10-22 06:56:22','2019-10-23 08:56:22'),('130ef66f2dc3112cd789830b2ceba616a63f4ac71daf9cd5fb7dba4162d9dfe84934dd698362448c',1,2,NULL,'[]',1,'2019-10-14 09:16:25','2019-10-14 09:16:25','2019-10-15 11:16:25'),('133c3cb6d2f3e22d59004f38bf002b0533795d080c79585bbcfdb57c4785a5105845075fa911961d',1,2,NULL,'[]',0,'2019-10-11 10:49:42','2019-10-11 10:49:42','2019-10-12 12:49:42'),('138da2404730288e8fdbf0a930bd89ba8d85fcd7b61d63d23b842abc87ebedf6c475e1cbb7b65247',1,2,NULL,'[]',1,'2019-11-24 18:16:27','2019-11-24 18:16:27','2019-11-25 19:16:27'),('140f76d7db14512664fdcd216ba649ea898362436c3b16d91cd78bd0b462cf071fb3d5a3384f245c',63,2,NULL,'[]',1,'2019-11-24 17:50:19','2019-11-24 17:50:19','2019-11-25 18:50:19'),('1426b85d6fa4a8ddd7b0e30dc3acbbc5bd563e06160be44d96af5b2a8d1d3cd81ad9c866156900ed',1,2,NULL,'[]',1,'2019-11-14 17:19:26','2019-11-14 17:19:26','2019-11-15 18:19:26'),('162d1fc3a9949aebc7bacd61fc4a0dddd6ea109cfb465307b693969690c380d5a08ad0faff4936d6',55,2,NULL,'[]',1,'2019-11-24 10:47:26','2019-11-24 10:47:26','2019-11-25 11:47:26'),('16be0e0690309d95e810c262143b627d80cc53b8593da935c1d808c571ddf8ad05fa46846d6dbf3d',1,2,NULL,'[]',0,'2019-10-10 11:44:46','2019-10-10 11:44:46','2019-10-11 13:44:46'),('1785b839b8c93c5e0addde4b2d1e7e7352816cacde915ad1b9972db362042db20b0c6614d6aabcef',1,2,NULL,'[]',0,'2019-11-18 12:54:51','2019-11-18 12:54:51','2019-11-19 13:54:51'),('17d28e7e130307e12ed64ea3d658f1b7b34a58d9696a40c43f89bfc3c73e5d3c79fb01298fcaf5a1',1,2,NULL,'[]',1,'2019-10-25 11:07:09','2019-10-25 11:07:09','2019-10-26 13:07:09'),('17d2fac60b51fc4b5eda133b3d58a086415e953ec2b6847d2518f5210bfe9de7e2a8f387ed22ef58',55,2,NULL,'[]',1,'2019-11-23 09:33:19','2019-11-23 09:33:19','2019-11-24 10:33:19'),('17da29e73d0e82d973f768c05e5aac1b869b2c9439fef7e885ed6303573f0284f04d93b9f7aeb3c5',55,2,NULL,'[]',1,'2019-11-22 12:16:24','2019-11-22 12:16:24','2019-11-23 13:16:24'),('17fdefd22b9783842815b9d7508e129c06148e3bf17392545984bbc9271d2a5223d2b47c204379e3',1,2,NULL,'[]',0,'2019-10-13 08:11:00','2019-10-13 08:11:00','2019-10-14 10:11:00'),('18178e348daa4c70b4e8ab5570301d799586bbac99b42dce9583650459115fd5742042749dd75775',1,2,NULL,'[]',1,'2019-11-14 14:52:12','2019-11-14 14:52:12','2019-11-15 15:52:12'),('182ab5677aa29763914a2d39da5267560edc0049aa735db9b60b9bdd0824df01ea25f9469672b9f3',1,2,NULL,'[]',0,'2019-10-10 12:01:09','2019-10-10 12:01:09','2019-10-11 14:01:09'),('18b7e7a676220b9a1c35c0651e4d8defa786e03868945fe071f3ef4365fdedc6e32d091e70fc3bc8',1,2,NULL,'[]',1,'2019-11-11 14:58:36','2019-11-11 14:58:36','2019-11-12 15:58:36'),('1a951890c0d756b31e6233ecaddd5538b29a96517fa974537addaad39f002548c14b013b0839dcf0',50,2,NULL,'[]',1,'2019-11-19 13:13:48','2019-11-19 13:13:48','2019-11-20 14:13:48'),('1ab48f72470e5fef751b2e5794e645353071ee5766823301436a9944726f276b1e482ba587fe9ba9',1,2,NULL,'[]',0,'2019-10-10 14:06:40','2019-10-10 14:06:40','2019-10-11 16:06:40'),('1af5d3620fd7b6404a7eb003fb528c9c87822ad33b5e6414c159f9f81cfe54e91de88b37797ac134',1,2,NULL,'[]',0,'2019-10-10 12:05:22','2019-10-10 12:05:22','2019-10-11 14:05:22'),('1b7a617df0ee1b33ca1c1f3342587a2c03cd7156b73854f109d8d57f9852dde061ff6f06ae5094e4',1,2,NULL,'[]',0,'2019-10-25 12:25:24','2019-10-25 12:25:24','2019-10-26 14:25:24'),('1b8d1cc1f2afcc4b055b4cb1bc6744c79d2c9dc1310fe8d9a925beca8b56440bc426947a6c677615',1,2,NULL,'[]',0,'2019-10-11 13:05:10','2019-10-11 13:05:10','2019-10-12 15:05:10'),('1bb0622f8b7f2e9a17325d5b56c4d93a5de584e7f76a6fdcb7ab48ec341293b9f98f1d9c6a514a4a',50,2,NULL,'[]',1,'2019-11-15 14:46:34','2019-11-15 14:46:34','2019-11-16 15:46:34'),('1cc3b1d2c5e64176b77f836041bd8d7701421ba959b686c3eab43a5da23db8c10e0718df2fb9684e',1,2,NULL,'[]',0,'2019-10-10 09:31:54','2019-10-10 09:31:54','2019-10-11 11:31:54'),('1cff88dc67a92a9603505470fde9f84562ff84f377925f710037c62332ab624fd5d1d3c7493a6ebd',1,2,NULL,'[]',0,'2019-11-04 11:44:10','2019-11-04 11:44:10','2019-11-05 12:44:10'),('1d215395933b2dac2a9f0470ed05afe4f13d7e49e06946f63f4bcc31317c26b0e5e69241562dba5b',1,2,NULL,'[]',0,'2019-11-23 10:13:59','2019-11-23 10:13:59','2019-11-24 11:13:59'),('1d94aeef70a28122cb5ec737f549a7312478e987e380555343f04567f46c9c1291f08d38b7a62310',1,2,NULL,'[]',0,'2019-10-11 10:56:29','2019-10-11 10:56:29','2019-10-12 12:56:29'),('1db22a021a8faecb42474a85b48c3c07c09a6c2f6a343b8ee2d13e67a4070185b1bffdc9b657d222',63,2,NULL,'[]',1,'2019-11-24 17:33:31','2019-11-24 17:33:31','2019-11-25 18:33:31'),('1efcba20d11a62e62a9cd27a41ba82e0bddbb621c65052ebc4f2231280a88c9f74ff4d968da44df2',1,2,NULL,'[]',1,'2019-11-19 12:33:53','2019-11-19 12:33:53','2019-11-20 13:33:53'),('1f48483e67e4a624db5ac80faadca47f3e579ec7ad37eb9fb65e382c238bae077574eb094a7cc81c',57,2,NULL,'[]',1,'2019-11-14 17:14:23','2019-11-14 17:14:23','2019-11-15 18:14:23'),('1f75f858fd5c259068cb10128552ae987b0dd281f8ae3c00596902f1b51ed3db8284b6c33f26551b',1,2,NULL,'[]',1,'2019-11-20 19:15:50','2019-11-20 19:15:50','2019-11-21 20:15:50'),('1fe56b93348f460cb353eb3170956735877cdf73947d59f6fd5e889285b3ad9d60d93447488b1524',1,2,NULL,'[]',0,'2019-11-18 11:16:35','2019-11-18 11:16:35','2019-11-19 12:16:35'),('202930eefc9c7e6591c6d7bc9f48f7b5524d5a2851bfd9413f35ad62513aa7ea00a8021a09eb09a0',1,2,NULL,'[]',0,'2019-10-09 12:52:42','2019-10-09 12:52:42','2019-10-10 14:52:42'),('207c728d9b688cc4b1649ad637f28f4c05754e91b41365ee2e46c31fa82d4ad9e698774555a1fb14',1,2,NULL,'[]',0,'2019-10-19 15:33:11','2019-10-19 15:33:11','2019-10-20 17:33:11'),('20a460058f252cbec80891e9f2f9bab12a3b898395e188404739249f84b9ebaf18c6be1b03b95ebf',1,2,NULL,'[]',0,'2019-10-18 17:20:36','2019-10-18 17:20:36','2019-10-19 19:20:36'),('21121f52672de93cd6abb9a7e7c8214dd54fb743d33e334d9688b65422b1f7afd4b82f883db9e3b6',50,2,NULL,'[]',1,'2019-11-14 20:04:38','2019-11-14 20:04:38','2019-11-15 21:04:38'),('2121159f7987012451a62e0d0ee16e42454a071e9c8e81e36d4be22c8d120f0440adca9c2210924c',1,2,NULL,'[]',0,'2019-10-11 13:34:01','2019-10-11 13:34:01','2019-10-12 15:34:01'),('242832c48b8f86d47007f94f9324292ca920a68bd5e961c34e8765bc6459eda7c29acc489b2ed152',1,2,NULL,'[]',1,'2019-10-28 10:35:08','2019-10-28 10:35:08','2019-10-29 11:35:08'),('24a2975bd11fde9a69272326520ae023c7fe121751f624fe826aef49d35ea00e39217f1dc23617d8',1,2,NULL,'[]',0,'2019-11-06 22:27:51','2019-11-06 22:27:51','2019-11-07 23:27:51'),('25648b87ee8ad18df99071e8fcf09da343874fc25838724041b44d34f2d2b70f2cf48f5cf103cc91',1,2,NULL,'[]',0,'2019-10-16 20:01:52','2019-10-16 20:01:52','2019-10-17 22:01:52'),('2575e2d586ef67010f132e3bdd2197daab794e9d19bfecc9a972dddafd92b9440664958c9660f44b',1,2,NULL,'[]',0,'2019-10-11 08:14:29','2019-10-11 08:14:29','2019-10-12 10:14:29'),('25a7507df0cff856e0f83c1ce9a221ebec74f65eed0799821dd62e9cb99398f750665b4daeb93cd5',55,2,NULL,'[]',1,'2019-11-24 17:49:27','2019-11-24 17:49:27','2019-11-25 18:49:27'),('26df9584f12f5d8084a9cca73cb8692eddac1273bbb57cd0ea710080bf526155c253d41d3d6f2a30',63,2,NULL,'[]',0,'2019-11-24 17:31:35','2019-11-24 17:31:35','2019-11-25 18:31:35'),('2705e529ed798369e6df3ae263537c96035e0f1d2e40a74bae78e6f643eb55b03686e64edd649ae4',1,2,NULL,'[]',0,'2019-11-18 13:19:15','2019-11-18 13:19:15','2019-11-19 14:19:15'),('2858ca0e08fc7fee37d2fa94fcc6e061c8fd44e0e91180107f06bf5d086e662bc56e9d942d36fb98',55,2,NULL,'[]',1,'2019-11-20 19:17:40','2019-11-20 19:17:40','2019-11-21 20:17:40'),('29bb02fb7fab585b7c67ba459e74ca1f8821c12e3f97bc2d7d342bc718a13c8e4b0e423a13c4fbe5',1,2,NULL,'[]',1,'2019-11-14 16:07:54','2019-11-14 16:07:54','2019-11-15 17:07:54'),('29e87240052e3e651af9ebdca4c8f0f7ca3a3c802c55ad5d2fd728808f9b538009d24dcd9f68a96e',1,2,NULL,'[]',0,'2019-10-15 14:50:26','2019-10-15 14:50:26','2019-10-16 16:50:26'),('2a518db27c0e8382cc4bf5b5f32aebef0a017566b089ba1117c33cf4f39198469e18e7922f1a41c5',50,2,NULL,'[]',1,'2019-11-14 16:11:17','2019-11-14 16:11:17','2019-11-15 17:11:17'),('2aefc69c4a671ae7f6762d1712c655176474c79a034c6b43b97860fa2537f51a74f17a5ceb0a9a90',1,2,NULL,'[]',0,'2019-11-13 19:38:17','2019-11-13 19:38:17','2019-11-14 20:38:17'),('2afce1c2fd0bfc3ee5ac69c9c9d7eaf91bb1a4495276556ac3f187fb417960cf9183cda6332168a5',55,2,NULL,'[]',0,'2019-11-18 06:03:52','2019-11-18 06:03:52','2019-11-19 07:03:52'),('2bdd6d1244d4b7a689081cf5bbd3f1f0cff33d1f96541d2f48a581da448e5d78c0efdee20f28c5ad',1,2,NULL,'[]',1,'2019-10-18 16:47:48','2019-10-18 16:47:48','2019-10-19 18:47:48'),('2bedb7c3a3efbc836a68b0f363e8d35dfcb12f30c4f57c6dbc235e1d6b0b58cbe3e8ed99070b3ac7',1,2,NULL,'[]',0,'2019-10-18 12:38:14','2019-10-18 12:38:14','2019-10-19 14:38:14'),('2beeb1b72f4e7ebeb58115b09af489cd617c6c16afc9348a8dd749a342a538b723c94868584c7736',1,2,NULL,'[]',1,'2019-11-19 11:13:38','2019-11-19 11:13:38','2019-11-20 12:13:38'),('2c419587d527edb63df7ed24d627e2abaa9e158d3acbfaf007a151ca938ce306c58f3ceaea2722e3',1,2,NULL,'[]',0,'2019-10-11 12:06:03','2019-10-11 12:06:03','2019-10-12 14:06:03'),('2c7c24002902ca4d1a0856df9ee12c1a19c40ec6e2773f3f19e7c06771350ab6e5de0ca9e095eeaf',1,2,NULL,'[]',1,'2019-11-13 13:04:43','2019-11-13 13:04:43','2019-11-14 14:04:43'),('2cb1a214e2c7307e7f511464a53271cf2e6ea4cef0c066b516c18dd079762350562dac6c7ada1004',1,2,NULL,'[]',1,'2019-11-20 15:50:25','2019-11-20 15:50:25','2019-11-21 16:50:25'),('2d0aebbef434a453e9efbf1d8b7b9d81feb8d5c20b3874cdd815f8d85e6720570d332de4cfe0fef2',55,2,NULL,'[]',1,'2019-11-20 09:36:49','2019-11-20 09:36:49','2019-11-21 10:36:49'),('2d3a67b15df3b63c5d490f59722891fbab8c9e082f795d0b3799c9a3cb2368b3d0fe7444679f0fe3',57,2,NULL,'[]',1,'2019-11-24 13:52:41','2019-11-24 13:52:41','2019-11-25 14:52:41'),('2dab2a11b16bd4e7e42fb9907acec746838e5b4d472a6662b9662313246a3e15aad6b701b46bc809',1,2,NULL,'[]',1,'2019-11-12 15:45:17','2019-11-12 15:45:17','2019-11-13 16:45:17'),('2dfd3fa5b1aa4665a52b126e529db8aa5ec89366d3f5f4c6781c4536cad88a82bbbf19190a8f8f7a',55,2,NULL,'[]',1,'2019-11-20 15:17:06','2019-11-20 15:17:06','2019-11-21 16:17:06'),('2e40ded554399f6d1d1c657e8cfa7f5357a3a9e8498dd4b026827733c6c8ed17fa49e4bc9b7acaec',1,2,NULL,'[]',1,'2019-10-11 13:27:01','2019-10-11 13:27:01','2019-10-12 15:27:01'),('2ea025511aba7445cbf81e0b49727b10f37a2b510005529200de7a7933f3b9158d8004c8a428360a',1,2,NULL,'[]',0,'2019-10-09 14:30:36','2019-10-09 14:30:36','2019-10-10 16:30:36'),('2f3a6370284ee949156f5c3fe9a5078fe63c171f9732ea589d63609a80c5783ef6673a583c47b45f',1,2,NULL,'[]',1,'2019-10-16 20:48:11','2019-10-16 20:48:11','2019-10-17 22:48:11'),('2fa6f3334c40fdd705c431ea489416125b0171d3a220728bde23c748391ed813da4b0fa2f3862ac0',1,2,NULL,'[]',1,'2019-11-13 13:59:47','2019-11-13 13:59:47','2019-11-14 14:59:47'),('30025e8d994ae5a7e5b2cabc99eb68d2fdd29aa2c6875b2faf59152856e2af3892ca62f1c7ef83b9',50,2,NULL,'[]',0,'2019-11-22 07:56:32','2019-11-22 07:56:32','2019-11-23 08:56:32'),('353a7e3122ae635ebec5342580683c3345cfbf4014668d995962b9e51e44482c913bf946bf7a73ec',1,2,NULL,'[]',0,'2019-10-11 11:56:00','2019-10-11 11:56:00','2019-10-12 13:56:00'),('35ac4d812a2c71e00c35a38736e6b38372cc933ff52257437b2ccdafcdf1a04846d47266c95c4c63',1,2,NULL,'[]',0,'2019-11-15 10:25:13','2019-11-15 10:25:13','2019-11-16 11:25:13'),('3614800ecfd2ef640368b3584ca6d3cdf2f70787e0c6aec138de90b9b39267289865c1294d81fa3a',1,2,NULL,'[]',0,'2019-10-11 13:25:28','2019-10-11 13:25:28','2019-10-12 15:25:28'),('365136544aea0a745fd5111749ccd345ea12a86d5c914726cfc21fb2cc08d0d291d0ad2b29466727',1,2,NULL,'[]',1,'2019-11-12 00:55:33','2019-11-12 00:55:33','2019-11-13 01:55:33'),('368df5dc8704aa08ad1226bfdb40c308af1171b0c2f6e7d3ee0a185967b8f1a5a6bedda42d69820f',1,2,NULL,'[]',0,'2019-10-11 06:50:09','2019-10-11 06:50:09','2019-10-12 08:50:09'),('36e9d59f6e96ce9c8ca8d32de1f7991cfb30cb5aff8471db20a627acc7fb1eddb65901e50e071d40',1,2,NULL,'[]',0,'2019-11-12 16:31:29','2019-11-12 16:31:29','2019-11-13 17:31:29'),('379f7748d8db0734063d8b9c8b7acd7b41a5a13f90b42a8b743b72e3eb6359077821011b9e786db4',50,2,NULL,'[]',1,'2019-11-24 15:32:38','2019-11-24 15:32:38','2019-11-25 16:32:38'),('39e5ae8e2bea6c895b88439798f6abb8819636e76b68486ea8d1d1f1b881b909268e7cd199a8619c',55,2,NULL,'[]',1,'2019-11-14 16:17:29','2019-11-14 16:17:29','2019-11-15 17:17:29'),('3bd2810a3109bda8d2a5982c33ba55b05137195711efadaacec65f0dae376458aa251bc525a9ae8a',50,2,NULL,'[]',1,'2019-11-24 18:18:46','2019-11-24 18:18:46','2019-11-25 19:18:46'),('3c02572db2fc44c2019409a2cda34705b8b70d797584e75c3d4485ca4fa964dd73ca1db1654b56a9',42,2,NULL,'[]',1,'2019-10-15 11:05:21','2019-10-15 11:05:21','2019-10-16 13:05:21'),('3c1245fc3e9d0a4ebba2057c6efe8e8a5b9f1ae7e923b6ef36e8bd161cf497286f62779ed0a18376',1,2,NULL,'[]',0,'2019-10-10 06:03:35','2019-10-10 06:03:35','2019-10-11 08:03:35'),('3c27e04fceea5188bb5e6a45fa38ca273e79ea68f1edcbf3f25e760654eb7e07f44da0349bab841d',1,2,NULL,'[]',1,'2019-11-15 14:45:58','2019-11-15 14:45:58','2019-11-16 15:45:58'),('3c6c256617c09f8738c3eb6200f568567d016882f0197c276b88a14efb8ee2b4d485fd514c6c0532',50,2,NULL,'[]',1,'2019-11-19 13:40:56','2019-11-19 13:40:56','2019-11-20 14:40:56'),('3dee179138d3575a3cdf8ecdedf1de936d3df1de7c1a0c60afefa7273b8eee5431808a9f8263d9cf',1,2,NULL,'[]',0,'2019-10-10 06:45:54','2019-10-10 06:45:54','2019-10-11 08:45:54'),('4068cfb47071b5a2fe0d50b31fcf8d9f0f8c10312f6a6e27d30def46544b628aadbfec7f620cec9c',55,2,NULL,'[]',1,'2019-11-22 09:44:59','2019-11-22 09:44:59','2019-11-23 10:44:59'),('40a5113391dc7f316ebe46758fd4f39d6c0eda0204c7478e7133d58b2eebd35b310d4ed904037759',55,2,NULL,'[]',1,'2019-11-20 09:43:16','2019-11-20 09:43:16','2019-11-21 10:43:16'),('40f616bbae00704c49c1492ff94c01decd7fc3ebb9046632db541604cac51b75c170560a028cda98',58,2,NULL,'[]',0,'2019-11-18 14:49:48','2019-11-18 14:49:48','2019-11-19 15:49:48'),('41dcd78bcd4a25b08642103dcaac843d6d6f69eceafc706ec5ff9b7c1dcbfcdbd3a8a4e4ccad3f54',58,2,NULL,'[]',0,'2019-11-19 14:03:12','2019-11-19 14:03:12','2019-11-20 15:03:12'),('421db67884b17c81a28b20424d178a3f580e965d8481b2b91d899f0b1fb700d10583158197979acc',1,2,NULL,'[]',0,'2019-10-11 07:07:36','2019-10-11 07:07:36','2019-10-12 09:07:36'),('432a3766e31fdb252c3aa2d90a071906acb447fdbea717ccd68789433627688bc77e8e5d97ec3cf5',1,2,NULL,'[]',1,'2019-11-24 12:45:41','2019-11-24 12:45:41','2019-11-25 13:45:41'),('44645065a483d4f233ff2feac788aa5443a641fa4d3e9ddb877d4f119b3a1b1c8c498c62181ef9d3',50,2,NULL,'[]',1,'2019-10-25 10:15:43','2019-10-25 10:15:43','2019-10-26 12:15:43'),('4487470d414b3385ff1526e4be85385debf9e9a0af65d8ade6d02e159ef6bb2ffd3d6c33708138f6',1,2,NULL,'[]',0,'2019-10-30 18:15:46','2019-10-30 18:15:46','2019-10-31 19:15:46'),('44bdf4bc667bc3e5b32dc94c8d92f3c11f175876e5fe24348e79c97ef73d43b3b9d0987f5cbe8eac',1,2,NULL,'[]',1,'2019-11-24 17:14:58','2019-11-24 17:14:58','2019-11-25 18:14:58'),('44d6f51bb6b0505d56e6cc83823d3be722a84208545686dcd24df10bb321e8b292bed42e95716dac',55,2,NULL,'[]',1,'2019-11-19 11:12:01','2019-11-19 11:12:01','2019-11-20 12:12:00'),('4676d3beec07dc3644ac2ee5d79c0b8bf2380ccea8a3747751255998c6ee9a348ff2bdbbc4a3de60',1,2,NULL,'[]',0,'2019-10-11 07:41:49','2019-10-11 07:41:49','2019-10-12 09:41:49'),('46e00395683891467e48320dc79bc33bedeee04bee3d9842b002ce922d8ff4d3e42117e5675fbf58',1,2,NULL,'[]',0,'2019-10-09 15:34:16','2019-10-09 15:34:16','2019-10-10 17:34:16'),('479533daa2f4f0425dae79b4955019d79023c20c3d1121ee23716bbbf85189ebe4aeb6e56fd2cbc3',1,2,NULL,'[]',1,'2019-11-12 17:14:37','2019-11-12 17:14:37','2019-11-13 18:14:37'),('47ff0a7d617ed3d41723c58c3e1f727935551a76eacaad9f24f05860caa7195573ceecfac90b6a68',1,2,NULL,'[]',0,'2019-10-25 10:18:05','2019-10-25 10:18:05','2019-10-26 12:18:05'),('49076d1e15bc76e6583d71be1b8e79e1d98ffaddc9571f0272f3b4a6a45b5fd81782d6ba1d758a3d',55,2,NULL,'[]',1,'2019-11-18 11:21:04','2019-11-18 11:21:04','2019-11-19 12:21:04'),('4908c43d9b269dca096bfcfaf46d556ae5a77eb2ad2ad6355025e3d0aeeaed4cbf1ba8ab01c7c8fc',1,2,NULL,'[]',0,'2019-11-01 13:23:03','2019-11-01 13:23:03','2019-11-02 14:23:03'),('49ea6c6d23fe73f7df48bc06a2ae122236aaa873be828a0c11bf364306853cf54802cf246fcaaa9a',50,2,NULL,'[]',0,'2019-11-24 15:06:36','2019-11-24 15:06:36','2019-11-25 16:06:36'),('4a61f5ac18cba27f93a52c9d80f9287205a7f7525002d163568ad94e31e4ce004a341f81fb670854',1,2,NULL,'[]',1,'2019-11-11 10:52:51','2019-11-11 10:52:51','2019-11-12 11:52:51'),('4a85aa61ea9a4c6fb6f30ebd1a1366cc315d4b766e8410166db5fea56b53b03fbc525011104b82b0',1,2,NULL,'[]',0,'2019-10-10 11:17:56','2019-10-10 11:17:56','2019-10-11 13:17:56'),('4ac0ebd8c894a2b9fce5c211c4b64114f458eb9b9a3dcfe5cbb36ead9558a4586ab6e17e4f07a37d',55,2,NULL,'[]',1,'2019-11-24 17:45:47','2019-11-24 17:45:47','2019-11-25 18:45:47'),('4ac42761099270b25be7ce4c913a9c0db26184a18cdcadedb2152c179ff4794ba7498e948b47b048',1,2,NULL,'[]',0,'2019-11-04 11:37:22','2019-11-04 11:37:22','2019-11-05 12:37:22'),('4b915c97f46ac384af2823b6b99adf601e94754e13db821b9eff89fcda56b5a0c5e86882a22aaa29',1,2,NULL,'[]',1,'2019-11-11 15:09:38','2019-11-11 15:09:38','2019-11-12 16:09:38'),('4caae9e4096b041f3c48b46648552ed55462661569a789b90110c88f59a8b7b0afe26d164bc43e24',1,2,NULL,'[]',0,'2019-10-11 07:45:49','2019-10-11 07:45:49','2019-10-12 09:45:49'),('4cb627c8d065e5678ac360bc76e0d064955da54350bb8041bf33f74cd3547c3ec3a0f9daf9e1118f',1,2,NULL,'[]',1,'2019-11-14 16:18:35','2019-11-14 16:18:35','2019-11-15 17:18:35'),('4d4e2f112842b50b9ea074119bcab9b3f5d9d3900cc92e3020a53106d10f10da77acf2482d7f2686',1,2,NULL,'[]',0,'2019-10-11 08:48:42','2019-10-11 08:48:42','2019-10-12 10:48:42'),('4d8521531e248931f5ac9ade579939639d47336ffa29268c302e104be09c64d78b41a9bb842ba149',1,2,NULL,'[]',1,'2019-11-24 17:26:06','2019-11-24 17:26:06','2019-11-25 18:26:06'),('4e7ae6ef1c249508fd1fb2c2c11e118c7000544e9b0521d2d3a3f332fd719117be10861ced3a26a4',1,2,NULL,'[]',0,'2019-10-11 13:18:30','2019-10-11 13:18:30','2019-10-12 15:18:30'),('4f3f776333bdda3094b362e21976d206e9a78082008e999c997c91e8f5731a4c653d1f2924d0474a',1,2,NULL,'[]',0,'2019-10-25 11:17:48','2019-10-25 11:17:48','2019-10-26 13:17:48'),('51c2983561ab5b63ee5f1c25b14ca893648c50f48a4386334e2fca4c5a2364a16ffe21d50d2cc105',1,2,NULL,'[]',1,'2019-10-21 10:55:28','2019-10-21 10:55:28','2019-10-22 12:55:28'),('52022168a6b1036529846cc2bf48310b90a744dcf0f93d6df69370e86ee9370c0dc3defd037c0fe3',45,2,NULL,'[]',0,'2019-11-19 19:54:58','2019-11-19 19:54:58','2019-11-20 20:54:58'),('52b7acd41810a496f061b932c1d013574f2735d9322b84a3c4bff6bcbd0344d96527ce5ade0059d7',50,2,NULL,'[]',1,'2019-11-14 16:18:18','2019-11-14 16:18:18','2019-11-15 17:18:18'),('546a5753a5b53ecda452a30285fe2fe346af68e7379abec00d5491712b2c297f7c4b92fdf391c138',55,2,NULL,'[]',0,'2019-11-18 13:22:23','2019-11-18 13:22:23','2019-11-19 14:22:23'),('55b763d9fab31714beb85264798b150fb5f25f241b929389a6998fab9dd3619f6a732295d9e944c8',1,2,NULL,'[]',0,'2019-11-08 07:27:08','2019-11-08 07:27:08','2019-11-09 08:27:08'),('58063a3f48cd1af54d9d765bfd35c24718d3faf5908e8bca6012627d8014f9c631f1dec682dd90bb',1,2,NULL,'[]',0,'2019-11-15 14:50:34','2019-11-15 14:50:34','2019-11-16 15:50:34'),('5814faedbb96a2952d8937cef09c3b06b64cb10e0cb8ce64c6997a25bb095c9f6e348d60a394498d',1,2,NULL,'[]',1,'2019-10-18 16:49:49','2019-10-18 16:49:49','2019-10-19 18:49:49'),('58302a9d4d191a684ac4afb09abfe015ba165a9e21c8980c645f2718e367c4681c498b5a37d5717e',1,2,NULL,'[]',0,'2019-10-30 18:14:52','2019-10-30 18:14:52','2019-10-31 19:14:52'),('591b9ba5cf2578044b642fd5bb3017399b7f50c7ae25e2a5dd716004633c0182b64659c9cefb0f79',57,2,NULL,'[]',1,'2019-11-14 16:21:35','2019-11-14 16:21:35','2019-11-15 17:21:35'),('5927f9ee0190428c67e3ba069d30d4a02882940b5109dbb16fb17cc7aa81104978466b2bb64c2179',1,2,NULL,'[]',0,'2019-11-18 11:17:26','2019-11-18 11:17:26','2019-11-19 12:17:26'),('5a172ec0a32ddc4a0009fcd28f6d3a752779d5c996a3eea221d216ff1e49bfb8ffaad9f6ddf71a31',1,2,NULL,'[]',1,'2019-11-07 16:06:44','2019-11-07 16:06:44','2019-11-08 17:06:44'),('5a86a8c592265bfc0966c54ddd12ca106b556e00557f016f046df7792331817e816e54ebbeee6cfd',1,2,NULL,'[]',1,'2019-11-08 13:18:36','2019-11-08 13:18:36','2019-11-09 14:18:36'),('5aeb8ebe82c0c9f789ef1e332f02e99aabe9b49888e598ed4031d7cf632dc30490657ec705d55528',55,2,NULL,'[]',0,'2019-11-24 18:22:12','2019-11-24 18:22:12','2019-11-25 19:22:12'),('5b869bc8cece085668039883871729b99d7553ca7d2f50607d000b1ce0709fede5df154e09827756',45,2,NULL,'[]',0,'2019-10-15 11:24:44','2019-10-15 11:24:44','2019-10-16 13:24:44'),('5cb17fb39a5068d71400f39afdd924ce5291596cf154bf8e7676aca5d4d934fb7f959c7df49dd8fb',1,2,NULL,'[]',0,'2019-11-21 18:34:45','2019-11-21 18:34:45','2019-11-22 19:34:45'),('5cefd77e70e4ce654508425d6c6f4d385cac9ee209cb77d8a8dd3a5abeb215c1972303a67b49670c',57,2,NULL,'[]',0,'2019-11-14 20:05:28','2019-11-14 20:05:28','2019-11-15 21:05:28'),('5e9d7cc3431f16f3e61ba6fd2168e0cf8552b71d0dc086f194023f464c947303a014736a1acb8fc6',1,2,NULL,'[]',0,'2019-10-11 07:44:22','2019-10-11 07:44:22','2019-10-12 09:44:22'),('5f624309a701acc4ecd168978fcf79d30d3715570e6be3c1d765009154b54b8f9731bd04122ce116',1,2,NULL,'[]',0,'2019-10-28 10:42:01','2019-10-28 10:42:01','2019-10-29 11:42:01'),('60196ffc3d58d0c2fbbcda6b7a3201edf837eebddbbf223117b1b975d1d38fb3ff9bc99624152ba7',59,2,NULL,'[]',1,'2019-11-24 14:45:19','2019-11-24 14:45:19','2019-11-25 15:45:19'),('607992ec4e48830f7eaa5d7155a8582f9fc9111335a8d408abc5cf81609c689d703fad4713dcf83d',1,2,NULL,'[]',1,'2019-10-18 16:57:26','2019-10-18 16:57:26','2019-10-19 18:57:26'),('62a9d71ab15a61950fca2bd6d5b3cf5458b3b36ae9ec71d9b4a1f3b347873479dec4e9bc692b10a3',1,2,NULL,'[]',1,'2019-11-14 14:36:08','2019-11-14 14:36:08','2019-11-15 15:36:07'),('6300fb9cfd040755da5cbc7a5397a7d5fdb14eed16048b551e51e27fc51cdb988ba531895d635ece',1,2,NULL,'[]',1,'2019-11-18 06:06:55','2019-11-18 06:06:55','2019-11-19 07:06:54'),('63d22aed5ac6c0cbe32cf566218a216c6298b15de3d390ae3b187a1fd7969534c4eab9c56057453a',1,2,NULL,'[]',0,'2019-10-11 05:36:27','2019-10-11 05:36:27','2019-10-12 07:36:26'),('64330ca27cf542877243b532c2336d868f48396036a95be06a80eb88c4006c50ece61d386b4039b1',59,2,NULL,'[]',1,'2019-11-14 20:03:26','2019-11-14 20:03:26','2019-11-15 21:03:26'),('643c6c87360a6aef123c948321df3b7f4c0695943c32f157c4c05363ae4c09f84704afc3d2dd3e78',1,2,NULL,'[]',0,'2019-10-18 17:18:40','2019-10-18 17:18:40','2019-10-19 19:18:40'),('647b1285817300acc8be94b8848fd777bf40427724487035e3e150f4fe492baefebe2a21b9e18ca0',63,2,NULL,'[]',0,'2019-11-24 17:32:47','2019-11-24 17:32:47','2019-11-25 18:32:47'),('64d47721f1ee156188d07cbf31557e88245c11285d2e9b47535ef8f754423b62db42da9c2a9be30b',1,2,NULL,'[]',0,'2019-10-10 05:42:35','2019-10-10 05:42:35','2019-10-11 07:42:35'),('664b323f3fd6c5e7151a11eb6354df60f3d93061e2b6f27127870511a0795654c12b187fff420565',1,2,NULL,'[]',0,'2019-11-15 10:24:03','2019-11-15 10:24:03','2019-11-16 11:24:03'),('68bb52e5ccb90182303dd7e787ca202d9ef96136492b8f07e6130cafb38c968d64587b15779c2547',1,2,NULL,'[]',0,'2019-10-17 15:40:31','2019-10-17 15:40:31','2019-10-18 17:40:31'),('68c6ccd16126907640eadb6c102416d6a8738826eba3776dadce30f8bebfee0b46999b7a690ae83a',1,2,NULL,'[]',1,'2019-10-11 10:49:58','2019-10-11 10:49:58','2019-10-12 12:49:58'),('69b2289d41c54c9b5ac7c1fa5247c7d7de2e98415eaf0f17f440e4007aa76773602084fdba022dff',1,2,NULL,'[]',0,'2019-10-11 11:31:13','2019-10-11 11:31:13','2019-10-12 13:31:13'),('69c545cbc3f3b2e5a18f927b4541ca2073b78ddd19cc23ebc681b1e5aad337bbdc5d90e0268104ff',1,2,NULL,'[]',1,'2019-10-25 09:18:41','2019-10-25 09:18:41','2019-10-26 11:18:41'),('6a4ade3114228ff782c7edab555dba3899e65d63236f1423c43a7ee08a944ec9f40f851f82cd46f7',1,2,NULL,'[]',0,'2019-11-05 08:37:29','2019-11-05 08:37:29','2019-11-06 09:37:29'),('6b3f7e6802d8e8c87b31ad88bb0f72f30ec51041e5ba85c64c57e37df92ed0f1b6888b6418ada85d',55,2,NULL,'[]',1,'2019-11-24 09:58:29','2019-11-24 09:58:29','2019-11-25 10:58:29'),('6c16e6a4bf3cc7f3adca34eef9e28afa99bbd54db62a36967bac4eb04546bf259f9234aef7109434',55,2,NULL,'[]',1,'2019-11-24 22:58:56','2019-11-24 22:58:56','2019-11-25 23:58:56'),('6c90a6e8b0aba155f785cef867d0d316124fa9f94ca98b03fd215dd39d3fbd0f95508f096186189d',1,2,NULL,'[]',1,'2019-10-11 07:54:48','2019-10-11 07:54:48','2019-10-12 09:54:48'),('6d59e5b6835d3769ea91d9a7cc31c4206209eeebcc89002370847eb166298c85f327dae6d465c6ed',1,2,NULL,'[]',0,'2019-10-10 12:07:19','2019-10-10 12:07:19','2019-10-11 14:07:19'),('6e96036ef996f0aa768cae0cd895a5f281a7f716decb53b9506f763084e496224f2cfc4bd29cb77b',1,2,NULL,'[]',0,'2019-10-11 08:51:19','2019-10-11 08:51:19','2019-10-12 10:51:19'),('6ea9feb06392bbd6d0168216703f96085fcc6ff3ba82a8f6c7d4d5961890ea5f80d26d793d062314',1,2,NULL,'[]',1,'2019-10-15 13:40:01','2019-10-15 13:40:01','2019-10-16 15:40:01'),('6fdb4ea8305229e81ba43cbeab9317f749d24523c3d4a6af1775b2496534d6b7c98feb46215e35c3',1,2,NULL,'[]',1,'2019-10-18 16:53:15','2019-10-18 16:53:15','2019-10-19 18:53:15'),('708f0f6b5f4a7c83be644814ea93fa266507ee2ce567a1f03935049b531d0d482375a6998243f92f',1,2,NULL,'[]',0,'2019-10-21 05:45:32','2019-10-21 05:45:32','2019-10-22 07:45:32'),('70be183b7b22eed7a743ebbacef5ee24c685a370c70a9a0989465b75de173ad4bd32cf9a80130a32',1,2,NULL,'[]',0,'2019-11-12 06:48:57','2019-11-12 06:48:57','2019-11-13 07:48:57'),('735d23ac2e428c4b3b2f4fe2d0cd45232f833a09d9f1067897f5303aea5d412216b1200fa8b47fa4',50,2,NULL,'[]',1,'2019-11-20 12:42:36','2019-11-20 12:42:36','2019-11-21 13:42:36'),('75d9f94538a8efbbf8d153e37614c868e59a7358005a66296beee3bfc368e473a9a3cb96ead310bb',1,2,NULL,'[]',0,'2019-11-13 13:27:03','2019-11-13 13:27:03','2019-11-14 14:27:03'),('768440144eac9f0d08686e37021e657e549fa5a84e39c438ccffc0923ff7a8550b1849998b762dde',1,2,NULL,'[]',0,'2019-10-10 11:43:26','2019-10-10 11:43:26','2019-10-11 13:43:26'),('7730c28bc42ac6f8d41e767b45a0a4a602aa35c81031d649c1397f8478870baa8e75072ab44fbed4',1,2,NULL,'[]',0,'2019-10-11 10:26:23','2019-10-11 10:26:23','2019-10-12 12:26:23'),('7786e05a062d755c84aaa2b8b0c6c2f05b5db7540f091ff49c6a1d03764fdec277cfdf81bec5ff60',57,2,NULL,'[]',1,'2019-11-24 17:15:08','2019-11-24 17:15:08','2019-11-25 18:15:08'),('77ed50112d1e85217a0eb13b102d9ebb7e4e7bef81d3401825648426cb0ea937ad734e0f67ac942d',1,2,NULL,'[]',0,'2019-10-11 06:42:29','2019-10-11 06:42:29','2019-10-12 08:42:29'),('78f54363ab3c847ff4451b38466bb40e7cc8a0a5eaff518abe4337fb198bb1fd7187c6ad2a53969e',1,2,NULL,'[]',0,'2019-10-11 08:21:51','2019-10-11 08:21:51','2019-10-12 10:21:51'),('793db8028d7c188a2353f724f13a42953f72ae11d8fab6af39c60c4cb869b5a1c7a6485315a12d2b',1,2,NULL,'[]',0,'2019-10-11 07:47:36','2019-10-11 07:47:36','2019-10-12 09:47:36'),('7a9cfcaa28cce1a336e0ec1517a0ec9687f6ba47579f1e56a84ab56c548acc006c95056b91771608',1,2,NULL,'[]',1,'2019-10-25 09:18:22','2019-10-25 09:18:22','2019-10-26 11:18:22'),('7ae95408c5f6140a417bd11eb6f2e9c33318b44fda857a4d5a0721b3a56a579408a2d0ddbe9939f5',1,2,NULL,'[]',1,'2019-11-20 09:37:59','2019-11-20 09:37:59','2019-11-21 10:37:59'),('7b2e9ba5c0b80448e2c703997c9755b29510c4cc6c449f330d7ee95f380d8a06d2f5a70ad1aa02a1',1,2,NULL,'[]',0,'2019-10-11 13:29:46','2019-10-11 13:29:46','2019-10-12 15:29:46'),('7bca00bc20b879b2a67364288900d027b948be05db1dcffe80f5480ce6220b0df0a13a02fa0e3b37',55,2,NULL,'[]',1,'2019-11-20 19:25:42','2019-11-20 19:25:42','2019-11-21 20:25:42'),('7cb1f8bd809b407adfde1094da52e071a1d2ca19e307547fcbd1aa03dff8653015c73af0b123ec7b',1,2,NULL,'[]',1,'2019-11-14 16:22:36','2019-11-14 16:22:36','2019-11-15 17:22:36'),('7d16e9b21fa3863483b9ac17aeb7788d68a71dc38406273ac415abd31a9a85311e9072b94b8eb813',55,2,NULL,'[]',1,'2019-11-24 17:03:36','2019-11-24 17:03:36','2019-11-25 18:03:36'),('7d75659c9ab2327dbacf99e098023d48d0102087b61579130b03b37f0f1c439b0b3ff014fe67d765',1,2,NULL,'[]',0,'2019-10-11 11:35:38','2019-10-11 11:35:38','2019-10-12 13:35:38'),('809b1cf42bbd59a01977aa13a2ac444b1291b4cdec98aebd957bc5fc721e1a8de30151e5a98d60ac',55,2,NULL,'[]',1,'2019-11-22 11:04:17','2019-11-22 11:04:17','2019-11-23 12:04:17'),('811299c9da7b9f13351ba7f96d3af8eafdeab198c4c27546d6be9983624e12cd8761050001c33b0c',1,2,NULL,'[]',0,'2019-10-13 08:18:35','2019-10-13 08:18:35','2019-10-14 10:18:35'),('829b67567bae9fc24791b04f653503162f60920b65103e1d246466db849528ee7bc00237f1535eae',55,2,NULL,'[]',1,'2019-11-14 19:43:39','2019-11-14 19:43:39','2019-11-15 20:43:39'),('8307e28ab6313a011c339e047fd544c6775bc241db90d5ede5317c6c06816579a9c14e579c2ed56a',1,2,NULL,'[]',0,'2019-11-11 14:53:09','2019-11-11 14:53:09','2019-11-12 15:53:09'),('83705ae7a3060102ff7facbc2720528a4f3794f44ebdaf534d85d435d3885cbb297f403c3a835674',1,2,NULL,'[]',0,'2019-11-13 08:31:11','2019-11-13 08:31:11','2019-11-14 09:31:11'),('841e3b9df27a4c64951f308258fa4b49f95d731f763d2de0fb8a13660db24cf1c666eb268d0dd37d',1,2,NULL,'[]',0,'2019-11-12 17:54:58','2019-11-12 17:54:58','2019-11-13 18:54:58'),('84b81faf99cf31337b0f30c956f59c39ba7456ef4851b5e549114a583f6c0185cc902fe5701a3b5a',1,2,NULL,'[]',0,'2019-10-11 13:37:05','2019-10-11 13:37:05','2019-10-12 15:37:05'),('851fb9183a3f7f2f38bc1f0abb54940ce6293c80b7efb901b62f18db7fe811597051df436b7ca617',1,2,NULL,'[]',1,'2019-11-23 09:44:15','2019-11-23 09:44:15','2019-11-24 10:44:15'),('8568a57f5a0d24e5f5e088d2066c43523a9cdac336f61367ef435c814d2fd1553224d1bc1d1dfbef',1,2,NULL,'[]',0,'2019-11-08 07:19:40','2019-11-08 07:19:40','2019-11-09 08:19:40'),('857bb80365bbf81310344a61337b4ab11c7b3c57c79668ae18c4a0ba15607cf6a1e1ff9d9d680d35',1,2,NULL,'[]',1,'2019-10-11 07:15:12','2019-10-11 07:15:12','2019-10-12 09:15:12'),('8614e3e3fda2a26bcc86fb8570850f259c6e4922e220416f30b5bf3d333116a8854163a2f911675a',1,2,NULL,'[]',1,'2019-10-11 09:33:48','2019-10-11 09:33:48','2019-10-12 11:33:48'),('865df97cb2cf1eca36d74e87da1740f9db28d99a70480e2b30a7577d362f20c8b3e724a687e3819b',1,2,NULL,'[]',0,'2019-11-22 09:32:00','2019-11-22 09:32:00','2019-11-23 10:32:00'),('86859063981e3df4ad3b360810276d417609d2af987d040ed4cd6803125e5093801a994be4493a5b',1,2,NULL,'[]',1,'2019-11-20 09:41:48','2019-11-20 09:41:48','2019-11-21 10:41:48'),('86ae5f573a9750857ecb02ecf873394312f6921d02a7b39c0aed9cc48dc3eb879a644717aaeddebd',1,2,NULL,'[]',0,'2019-11-10 08:49:57','2019-11-10 08:49:57','2019-11-11 09:49:57'),('887f0e2b32585926470d789c4ff1ff24bf369cfec9a6761ba240825c012dafe8a8c7a760ce588972',50,2,NULL,'[]',1,'2019-11-22 09:31:31','2019-11-22 09:31:31','2019-11-23 10:31:31'),('8890bea337bce05c27298e3232a5ac7bada66fa1b14d2e2208c5011408b0a2949fee74070ec8fd05',1,2,NULL,'[]',1,'2019-11-11 15:12:58','2019-11-11 15:12:58','2019-11-12 16:12:57'),('88f5e8ec3e677fac10dbf13ca729357f3a91b922bd708e2ffb3d55d72132d5ee071e45e2e1b9332b',55,2,NULL,'[]',0,'2019-11-18 13:55:22','2019-11-18 13:55:22','2019-11-19 14:55:22'),('8919aad1edf92dc47f7ea9bbc9a43890271f9ccbe5c090d7c47b320b6b9b33314be0f021be460e5b',1,2,NULL,'[]',1,'2019-11-24 18:22:04','2019-11-24 18:22:04','2019-11-25 19:22:04'),('893a902ad8c9f147e07078d00fca3cf91e2f917470a7516c0989441c5b9da275b54c08802e412e86',1,2,NULL,'[]',0,'2019-10-11 08:55:57','2019-10-11 08:55:57','2019-10-12 10:55:57'),('8a2c9176326bafe1b4317601ba041ac78ab34446abbd19347e34fe55c055c39922529eddd6342d6a',1,2,NULL,'[]',1,'2019-10-22 07:12:23','2019-10-22 07:12:23','2019-10-23 09:12:23'),('8aae72dbf712df59d70b5629f5098527208ed7f844e4a5b0080fbeca51046ffabce832d78fa898e7',55,2,NULL,'[]',1,'2019-11-14 17:21:03','2019-11-14 17:21:03','2019-11-15 18:21:03'),('8aaf081199d39e8196d7f59573aaf28cd636cf608f1c63d26f2de14e8ed04f7c5bfebe98a078d7b3',57,2,NULL,'[]',0,'2019-11-18 12:52:12','2019-11-18 12:52:12','2019-11-19 13:52:12'),('8bf11c99a928dfe37094d591bb86fae9d9e01117f478bbca11191c25cf5833120bef0f8173f89a52',55,2,NULL,'[]',1,'2019-11-24 18:17:23','2019-11-24 18:17:23','2019-11-25 19:17:23'),('8c0f0d3a5a1c3a519dc525a551dd117b959bbc7fcf6dc47df4ed38868501fe33500299ea676b3fc3',55,2,NULL,'[]',1,'2019-11-22 15:49:47','2019-11-22 15:49:47','2019-11-23 16:49:47'),('8c8aa59650fccf2f417804b1ab085e9f1dcb1011085cedd81793242d959af00302bdd6b4fee14e19',55,2,NULL,'[]',1,'2019-11-24 18:18:07','2019-11-24 18:18:07','2019-11-25 19:18:07'),('8ca85ef30190ec8a00a79d7f680a0cea36497549e69a7ac6dc05b9f551eac38e5f65f64c55927297',55,2,NULL,'[]',1,'2019-11-22 16:56:41','2019-11-22 16:56:41','2019-11-23 17:56:41'),('923b5b16ca63bed1d406eddd45c3c649b343d713507c785b278c3838243332728511afccdf223c2d',55,2,NULL,'[]',1,'2019-11-24 13:52:34','2019-11-24 13:52:34','2019-11-25 14:52:34'),('92965d533caec38f23e33e8cdb9ac62be2ba530048883f422f69f1fb0f51a2d699f47dccfe44e9d8',1,2,NULL,'[]',0,'2019-10-11 12:03:43','2019-10-11 12:03:43','2019-10-12 14:03:43'),('92dd95ca85b4683990bf52836a500655c13537ad8a0b22b3d5fcd6ca2966aeeeac03e22e0b794df4',32,2,NULL,'[]',0,'2019-10-10 11:49:43','2019-10-10 11:49:43','2019-10-11 13:49:43'),('94f267436986ac2fa8f3362612cfbe0f122aa314260d35ffe7ed4982202075323f3defd331eedb11',59,2,NULL,'[]',1,'2019-11-24 13:53:44','2019-11-24 13:53:44','2019-11-25 14:53:44'),('95631670458627834921627a4f4f79076d967da0df200a66e9a4efa7c227bd51d9f5abfb543e42fa',59,2,NULL,'[]',0,'2019-11-14 19:48:21','2019-11-14 19:48:21','2019-11-15 20:48:21'),('97c1ed4f2f5f28971dd435ebc5ba381da2c65b349e8c0c965be2eefb6fbed9294a97f996f912cafd',50,2,NULL,'[]',1,'2019-11-24 15:05:55','2019-11-24 15:05:55','2019-11-25 16:05:55'),('984f882ce1a2cd0989a60deef9b7b2823b16a5e8472793682f7577205ee02730c6836621fd58953e',55,2,NULL,'[]',0,'2019-11-19 13:10:49','2019-11-19 13:10:49','2019-11-20 14:10:49'),('98a515523a62a6c20134fb03709c7d3755cabb2e579807dbbd69bc5247d2dcc048a504242d2e9a17',45,2,NULL,'[]',0,'2019-11-22 21:53:51','2019-11-22 21:53:51','2019-11-23 22:53:51'),('98c288ee9712c1ac0b1fc75e590b71cca5f2c0c1b2254056cac3738f9aedb05a176245fed712fa3f',1,2,NULL,'[]',1,'2019-11-13 18:35:47','2019-11-13 18:35:47','2019-11-14 19:35:47'),('98c8732203c78c6c77e971014d730e264fd80c05553150ca74947c1f3ba7dc5fd6ab7a9e63c53b76',1,2,NULL,'[]',0,'2019-10-10 09:47:07','2019-10-10 09:47:07','2019-10-11 11:47:07'),('9ab8f36f4f9f755b6330ec11c618bcfb13fef60f2a862b2a58ac722640836e6feaa15ee9f7598b4b',57,2,NULL,'[]',1,'2019-11-19 14:32:39','2019-11-19 14:32:39','2019-11-20 15:32:39'),('9abfd49042a24f044f4b0e29ffbd5fba15e73a978d058d3f2d37ded677e5fb86726a5e5c32f6cb93',55,2,NULL,'[]',1,'2019-11-15 09:21:15','2019-11-15 09:21:15','2019-11-16 10:21:15'),('9ba2431a7df2759ca3d570b32dd7742759db4685058823b71227bc43b8d7701cf01d5a9bcafc19f7',1,2,NULL,'[]',0,'2019-11-18 13:14:39','2019-11-18 13:14:39','2019-11-19 14:14:39'),('9cd59658a8d5e25ea0553169c2a7a1d80dc9f86065bf49e6b99bde1ce6f131047dcb81ddf59133d3',1,2,NULL,'[]',1,'2019-10-11 07:42:14','2019-10-11 07:42:14','2019-10-12 09:42:14'),('9cf4c6f83dcb6d93a1ed70d6a8b7b7a964ad6eef3ec4fe3ab6be96bed0796cac95024192e0a09f67',1,2,NULL,'[]',1,'2019-10-31 13:38:30','2019-10-31 13:38:30','2019-11-01 14:38:30'),('9dfce55ab631097595bd7c5b590aba160f64dbf8e7198cf21106db34e0f230b646d501bef18fdf5e',50,2,NULL,'[]',1,'2019-11-24 15:05:33','2019-11-24 15:05:33','2019-11-25 16:05:33'),('9e8e28aec5c579afd9700f7905164628aca96da7204051617f24a31bddb89cc1c30e8a7cb85055a1',1,2,NULL,'[]',0,'2019-10-10 07:26:14','2019-10-10 07:26:14','2019-10-11 09:26:14'),('9ed9f29078bc050e0e2071793ace266f7492efe6696ff046778f05b93a7b5a1aa9c28d70adb23913',55,2,NULL,'[]',1,'2019-11-19 15:25:20','2019-11-19 15:25:20','2019-11-20 16:25:20'),('9ef317aaaa2ca490c9c64e5611d5829fa3f0d25738bf7ff3cf2113db25a5fdb25f55cc233bdc030a',1,2,NULL,'[]',1,'2019-11-13 19:36:16','2019-11-13 19:36:16','2019-11-14 20:36:16'),('9f8ad4988a03c50fd9785ee5e99ba0570eb2b20a99d17be2f54b298ad985c98d3d0533f8bd31d383',57,2,NULL,'[]',1,'2019-11-19 14:01:34','2019-11-19 14:01:34','2019-11-20 15:01:34'),('9fb8aef037d1b681b7b64c6dc5cc8659d9079b70e94179cc306c9096e5368c4e3079e090ea1e0af6',1,2,NULL,'[]',0,'2019-10-21 17:53:56','2019-10-21 17:53:56','2019-10-22 19:53:56'),('a0c01fc64617763dd8421fd476c3a68bba5349aab9d32edc90a5e4c02a59a639287f9dfbdd6a163a',58,2,NULL,'[]',1,'2019-11-24 13:52:22','2019-11-24 13:52:22','2019-11-25 14:52:22'),('a1bf61125932151059023977dd8e4b82688fe9e7b0461edd1a11c59930e257f08f6f13014e5f369c',1,2,NULL,'[]',1,'2019-11-12 02:21:01','2019-11-12 02:21:01','2019-11-13 03:21:01'),('a236fb0cd326903c9306f7a8ae0f94c04270de89e981647ac311c7d1c20c5f4da82355e32239269b',1,2,NULL,'[]',1,'2019-11-12 16:33:27','2019-11-12 16:33:27','2019-11-13 17:33:27'),('a31111b5f457e1b89a8640e44e1fb6d94ba078eee8dcda36989963eb145c9ce68d48429bb7d23260',1,2,NULL,'[]',0,'2019-10-11 09:38:24','2019-10-11 09:38:24','2019-10-12 11:38:24'),('a4b85fe2f9a01694ae3ad308f1ee523fe28519e66cea68e2b44bc61678763101f43e8d2e52a805ae',55,2,NULL,'[]',1,'2019-11-20 12:57:11','2019-11-20 12:57:11','2019-11-21 13:57:11'),('a534f222e847dd35cefae220efca06a9f74e293ce911bd9b1d87ded8da6229df6debfb24d430176e',55,2,NULL,'[]',1,'2019-11-24 17:50:37','2019-11-24 17:50:37','2019-11-25 18:50:37'),('a567f533c2731bcb6ee8807c03c12f2acb05ca3c74dfe2ac226daeb60a78f43de789d0b1ec28a9c5',1,2,NULL,'[]',1,'2019-10-14 08:48:56','2019-10-14 08:48:56','2019-10-15 10:48:56'),('a62a776cfca3216f460fdcde75ebc0b13b7cac4b7465a7590c0ab82ef3d604f76b0fa80473d45687',1,2,NULL,'[]',1,'2019-11-24 17:23:41','2019-11-24 17:23:41','2019-11-25 18:23:41'),('a7e85f6aea2600736052d81642f3fe20c7303b8cc17af9fa20870c6bd1c8365c0969e0ba696edd7a',58,2,NULL,'[]',1,'2019-11-14 16:24:50','2019-11-14 16:24:50','2019-11-15 17:24:50'),('a8b82badc5ae5b36d1c076395c15e445fc857b8a81661f310f24ade2a545f52a11c5d248f754ce7e',55,2,NULL,'[]',0,'2019-11-23 17:09:47','2019-11-23 17:09:47','2019-11-24 18:09:47'),('aaddfaf1c05c059624cab8112d2707dc972af08568ff704e376d070ed95b55249c98c3806cfe5e34',1,2,NULL,'[]',0,'2019-10-25 11:46:41','2019-10-25 11:46:41','2019-10-26 13:46:41'),('ab58bed8e055e7e24b3b8f1fa8f11d4f60cb54c92be76d1cb32776cbfa4bde28fa55d4c91fbcfb3f',1,2,NULL,'[]',0,'2019-11-15 09:50:03','2019-11-15 09:50:03','2019-11-16 10:50:03'),('ac99d9a97f6c75afa08475d5038655e55d0b51a0dc386e770ff558c673ced0c573ce6fbefa2c5344',55,2,NULL,'[]',0,'2019-11-23 18:20:06','2019-11-23 18:20:06','2019-11-24 19:20:06'),('acda827185643bfba4c9f9aa38a4205bf432e202c918ebe530e5ef3b630beeed674050c27c781f2d',1,2,NULL,'[]',1,'2019-11-18 13:34:32','2019-11-18 13:34:32','2019-11-19 14:34:32'),('acf27520d021e7502df1a5e0909589a581764deeba17ce3f2de5cba903986b711cb6098ab9dea7df',1,2,NULL,'[]',0,'2019-11-22 16:57:30','2019-11-22 16:57:30','2019-11-23 17:57:30'),('ad22f0259d9f40deb1ed0cebb303bb461d95225b066c7bd0c169e800450d7634a1406c2cb553165d',45,2,NULL,'[]',0,'2019-11-13 19:30:49','2019-11-13 19:30:49','2019-11-14 20:30:49'),('afbe58eda0f54284f8a20f26e5ee89cb11add52b38cd1c87f9ce0660c9309229fc2800dab133a71f',1,2,NULL,'[]',0,'2019-11-12 17:47:32','2019-11-12 17:47:32','2019-11-13 18:47:32'),('affcf7cb92277fdfe9bdcfd0dbda2176340232f6559cc1e30395a1f0b193db6ba92ac828a7d87811',58,2,NULL,'[]',0,'2019-11-15 09:21:36','2019-11-15 09:21:36','2019-11-16 10:21:36'),('b01ca4a96474c0e8133abb65cf7271a07526a37a194654ef38c8f966923674ddf32751ff9da37ee2',1,2,NULL,'[]',0,'2019-10-19 19:00:50','2019-10-19 19:00:50','2019-10-20 21:00:50'),('b0daa263b24620621e38e31d518e5b3d0cf7ce17ebfa20607d7b9c5e28f95ecdea6d1d2e29a0aa72',1,2,NULL,'[]',0,'2019-10-11 06:44:07','2019-10-11 06:44:07','2019-10-12 08:44:07'),('b281bfb0b181ef21134762dc030825cf300840daad9f70257031c300d88c17e8867a3e9040206885',1,2,NULL,'[]',0,'2019-10-10 07:18:09','2019-10-10 07:18:09','2019-10-11 09:18:09'),('b3c520000e2f7c7c816891e67b0bc0a0c629d0ee8fb802c1fe53d9294704aeb5190d7ebcd3045844',55,2,NULL,'[]',1,'2019-11-23 10:14:52','2019-11-23 10:14:52','2019-11-24 11:14:52'),('b43bf1213a95f9b4b6337129b6bf861aeac8e79bbb72a3722d1e7f584300962d7eaec6fa9ab2b720',55,2,NULL,'[]',1,'2019-11-24 13:56:26','2019-11-24 13:56:26','2019-11-25 14:56:26'),('b4580a167bb0674da85311c79e751ab0be0a2ff7bb71ee2a83008ff993235358a14c9ed584aaf783',45,2,NULL,'[]',0,'2019-11-24 11:18:37','2019-11-24 11:18:37','2019-11-25 12:18:37'),('b5a9d92d4926572aab32e4b8ec8680e8540c97257089ee3ac33f18fe967ac41169cc829dca6a2c44',1,2,NULL,'[]',0,'2019-11-08 16:22:51','2019-11-08 16:22:51','2019-11-09 17:22:51'),('b65d87cd510999d54081face739468531b4d0c1a82a85c8deb9db447488a487cc56f20a4ebbda4b1',1,2,NULL,'[]',0,'2019-10-11 07:36:36','2019-10-11 07:36:36','2019-10-12 09:36:36'),('b6e2f29dff171ba9f8d28e7bf3c4ed65ee9ff83724bc1a71f1264ab3951de44d6e92d90a865dcb0c',55,2,NULL,'[]',1,'2019-11-23 14:50:53','2019-11-23 14:50:53','2019-11-24 15:50:53'),('b7b0c45d4adabe27115eaf66e833f704df76655e2a887252c58ac734071e0c435436297c74cf266e',55,2,NULL,'[]',1,'2019-11-18 13:55:33','2019-11-18 13:55:33','2019-11-19 14:55:33'),('b7c0b5c3574f470f6997bd2448816233c41a101125b298ec0f78db488f125fddf2347b577f2875c7',55,2,NULL,'[]',1,'2019-11-19 17:29:05','2019-11-19 17:29:05','2019-11-20 18:29:05'),('b7c6a566b9e0e9b689c3aca833d8f678784c9e27b24083684aaf4cf1f5bcda2e56d76c66fdb1fa4d',1,2,NULL,'[]',0,'2019-10-19 19:02:06','2019-10-19 19:02:06','2019-10-20 21:02:06'),('b83108b0d0ea2aac34da94e080f81856a50be7817552be1f16b4c5097cccac8dbac17aae0d104428',1,2,NULL,'[]',1,'2019-11-12 00:44:12','2019-11-12 00:44:12','2019-11-13 01:44:12'),('b9a3d3dede15d982a665509928bea2df1813ac6eac3224b98b7258236297b817e6b9de66cce39052',1,2,NULL,'[]',0,'2019-10-16 09:44:28','2019-10-16 09:44:28','2019-10-17 11:44:28'),('bb9ba98fe99710722701fb1d967ab44fec944851ead91789e418ff602b9464551e5a47e4949bafe8',1,2,NULL,'[]',0,'2019-10-11 12:08:18','2019-10-11 12:08:18','2019-10-12 14:08:18'),('bc58d6b2d6065e4611a22a9c59dfda3ad3af3fd480672c75ad1d148e80fadd570e632ce7d0c32d22',1,2,NULL,'[]',0,'2019-10-09 11:10:36','2019-10-09 11:10:36','2019-10-10 13:10:36'),('be17fe98654ba80079595ba99a534d8f5382e06f5ba402ccd2968c61fb9e7cc6b3c94edbc8c74f41',1,2,NULL,'[]',0,'2019-10-18 17:17:18','2019-10-18 17:17:18','2019-10-19 19:17:18'),('bf0e437b7f1d5ffab27d7c4bcedff87c9917e7dda3f47cd2588876a7f69cbbea480abce0a74c3361',55,2,NULL,'[]',1,'2019-11-14 17:18:00','2019-11-14 17:18:00','2019-11-15 18:18:00'),('bf6ca7056d2996a4a1f94131179ec1c291fee9b2707a21fb59eeec0184c91dc7646e59824b28b807',58,2,NULL,'[]',1,'2019-11-20 12:37:30','2019-11-20 12:37:30','2019-11-21 13:37:30'),('c02a2af6adbddd3ff48eca4d923d0a6b6943fb22dab487e478b21d252b05c75bc4c52b0ff1b36367',1,2,NULL,'[]',1,'2019-11-11 11:08:13','2019-11-11 11:08:13','2019-11-12 12:08:13'),('c13c9a3ecb32ec04f7c458d0f4ee7b0417c5b9e9c3071a2a9769e9a051e20132facd8615151f19a9',45,2,NULL,'[]',0,'2019-11-17 08:51:33','2019-11-17 08:51:33','2019-11-18 09:51:33'),('c182a32a84aaaedb90953523a475de1f32325917f99fca8f3e20c63e05f548993316af1ecf0ebaca',1,2,NULL,'[]',1,'2019-10-11 12:01:01','2019-10-11 12:01:01','2019-10-12 14:01:01'),('c215601d1f646bced1a6267249934fd395c17fafa7f84b13b1996b5ea2ddd34548b13cfa473ef4f6',61,2,NULL,'[]',1,'2019-11-24 17:21:49','2019-11-24 17:21:49','2019-11-25 18:21:49'),('c2928df206711efc56c4f671e5c8daaf79cb29448768dbf9b5913c1bc083e244daffa094a5e91f72',1,2,NULL,'[]',0,'2019-11-18 11:17:42','2019-11-18 11:17:42','2019-11-19 12:17:42'),('c362850cc5426b0bd1d880272129a2a755b11f86aee1128b01ee0cced4577113466954e6196d1325',1,2,NULL,'[]',1,'2019-11-20 12:32:10','2019-11-20 12:32:10','2019-11-21 13:32:10'),('c3b5b28efe2d982bde757f67ac9f4cd92fbc5a52ccdfda2fc2a3543c081dc1abb3b5cc0ec249d082',50,2,NULL,'[]',1,'2019-11-24 12:59:02','2019-11-24 12:59:02','2019-11-25 13:59:02'),('c4cf6b7be6c712f93aab7f9e543353fc131e610356ca02aa8ec181f08073e031e89c1c4975ea19fb',1,2,NULL,'[]',0,'2019-11-11 11:07:47','2019-11-11 11:07:47','2019-11-12 12:07:47'),('c790967af09a87baaf8522aadd4a7f820a3e34837dcbbf943b4048c8aacb421b9576ea0d346123bd',58,2,NULL,'[]',0,'2019-11-14 17:25:58','2019-11-14 17:25:58','2019-11-15 18:25:58'),('c7a4c56dbf0be08bff0471e08e73df385113eddeb5f6c0b8937c0ef56ae106eb3f0a7a8bb324c2c3',1,2,NULL,'[]',0,'2019-11-09 23:35:02','2019-11-09 23:35:02','2019-11-11 00:35:02'),('c7b2bfe638d5966d3c6903e8fd259236e81d04b60d3085f73fdacffdea65a503c7a87416596cbb0b',55,2,NULL,'[]',1,'2019-11-23 15:16:34','2019-11-23 15:16:34','2019-11-24 16:16:34'),('c962ee34a41edd9ac3b69530122b64f5f3631054ffc8fe9f355abc185205ed6b34292cea9600d23f',1,2,NULL,'[]',0,'2019-10-20 08:07:29','2019-10-20 08:07:29','2019-10-21 10:07:29'),('c9dbaa5889fe66744b47709ba78235c8ce1ab1c0331fd1b4e4d78adc92f111b1a668bae09b8dd908',55,2,NULL,'[]',1,'2019-11-18 06:03:59','2019-11-18 06:03:59','2019-11-19 07:03:59'),('ca3e3effefd567e70ffa1a4e28c0cad5f40c5db59b2f3645bc3d76e0cb8ca8231eda85f3dda57056',1,2,NULL,'[]',0,'2019-11-23 09:22:59','2019-11-23 09:22:59','2019-11-24 10:22:59'),('caa45cff50fca91ce18ea072d8c9b795eead8ffafa907027a8b7c484324eb6524c3ef3f9d044d074',55,2,NULL,'[]',0,'2019-11-23 09:50:06','2019-11-23 09:50:06','2019-11-24 10:50:06'),('cb69c1ddd6d4f1f51ac7560370049543fedef8a3965ffca980f9d7a186b03ba707212706f637111d',59,2,NULL,'[]',1,'2019-11-14 19:47:00','2019-11-14 19:47:00','2019-11-15 20:47:00'),('cbd92010f2651823a1f769aa46e950a1740590fdda03bd62f5ca5a060aeb3eed7c9dc00778a46caa',1,2,NULL,'[]',1,'2019-10-17 06:28:19','2019-10-17 06:28:19','2019-10-18 08:28:19'),('cc7e0504dafbfe6342870c569ec92268c5608fdd2037a0c67ca82fb4cc79595c64d678e737b10017',58,2,NULL,'[]',1,'2019-11-24 17:15:44','2019-11-24 17:15:44','2019-11-25 18:15:44'),('cd58826836c94068b7e30d579ea633a01547db9bb9b29d938e751cfa2bbf4a32ae554d376d112f21',1,2,NULL,'[]',0,'2019-10-16 14:55:19','2019-10-16 14:55:19','2019-10-17 16:55:19'),('ce33f82f3f9cbcdab0bf874d7ab363640403be0bb2a1453c3bf27ec475753be5b46fc11bc2af6994',59,2,NULL,'[]',1,'2019-11-18 06:07:20','2019-11-18 06:07:20','2019-11-19 07:07:20'),('cf624565ce220b50b84b8bb9a37f48f7fdf9f08a855019e76463121409d08a802cf030df711249eb',1,2,NULL,'[]',1,'2019-11-24 15:06:42','2019-11-24 15:06:42','2019-11-25 16:06:42'),('d039d9943df82240503f5bb37a30ce302d927a1e434b2930a623637b7a2bb2dbabb2bf6727837ab3',55,2,NULL,'[]',0,'2019-11-19 13:09:50','2019-11-19 13:09:50','2019-11-20 14:09:50'),('d0f3d99ec4566e05082be59a6a74a8419af289b01c66c57b25e91ec41925b79a3ced77b705bb0660',1,2,NULL,'[]',0,'2019-11-11 15:27:10','2019-11-11 15:27:10','2019-11-12 16:27:10'),('d1090ddea00d7e49925f8a18e796cd670e755da323b52ba2b1e1600fe55c8672136584b744da34b6',55,2,NULL,'[]',1,'2019-11-24 15:04:20','2019-11-24 15:04:20','2019-11-25 16:04:20'),('d1de16a3be8383e8ed2cebf50ee27b418af3cf696afdb1fbcee79bdc1361752fc9db93c00e5dadd1',55,2,NULL,'[]',1,'2019-11-22 07:04:58','2019-11-22 07:04:58','2019-11-23 08:04:58'),('d1e3cba297b76fb94f84d5e5b6bb628872c310ddbc615e9acce662309837d8e95b9325de861f01e7',48,2,NULL,'[]',0,'2019-10-22 16:04:01','2019-10-22 16:04:01','2019-10-23 18:04:01'),('d231a03a7e6b2beb0ff8f4f5246f01a08afa7e770d57b4faa78223e01c1a641a422cdb4eea2ab948',1,2,NULL,'[]',1,'2019-11-16 14:06:20','2019-11-16 14:06:20','2019-11-17 15:06:20'),('d2866765bd74445116060fa63e66f6bb149342092a4d25a6c54788c007ebb476e81a37cb7b8c4af1',1,2,NULL,'[]',1,'2019-11-13 10:00:09','2019-11-13 10:00:09','2019-11-14 11:00:09'),('d2c465709e98cd73d3d71dbaf2ac432cf9b5e3c3753735236867b9099a54a15b25e483e26231d72f',50,2,NULL,'[]',1,'2019-11-24 13:52:53','2019-11-24 13:52:53','2019-11-25 14:52:53'),('d335040bc6310f2de192ab398eba56e5612184ee13fc85cdc467c4433d6d7b6342e9b5c918b8d959',1,2,NULL,'[]',1,'2019-11-24 17:45:39','2019-11-24 17:45:39','2019-11-25 18:45:39'),('d3d57e5274d2da41f084de6b26c7c071344a8c2858bedf1238b7df36eb98a5c2f5072a8858884064',1,2,NULL,'[]',0,'2019-10-09 13:40:56','2019-10-09 13:40:56','2019-10-10 15:40:56'),('d3f5a86334268cf7e41df5b8f864a574042478ffa74bd659e2e1e4836ed4f46db920a665f3446488',1,2,NULL,'[]',1,'2019-10-16 07:28:25','2019-10-16 07:28:25','2019-10-17 09:28:25'),('d431f74e42c7b31956ca256df2d05ebaedd0bcc12ac54cf0ac2b3f358f21d9071af1eced2aac497d',1,2,NULL,'[]',1,'2019-10-11 07:37:32','2019-10-11 07:37:32','2019-10-12 09:37:32'),('d58ce644ea0eb137306a1dbfb18c6385e0612437759ccca81f07f5ccf17169d9556b267e112f9db2',1,2,NULL,'[]',0,'2019-11-15 14:47:17','2019-11-15 14:47:17','2019-11-16 15:47:17'),('d5b8fd152abdac34ff69efd6cf7d20801ab551e2576db044322367e3486580c5631302acf63fdc78',1,2,NULL,'[]',0,'2019-10-09 11:38:31','2019-10-09 11:38:31','2019-10-10 13:38:31'),('d6f290377c56752ffe54be3bee8ff8009ec54546e559d496fd95b5e95c2a93d171783bb71f41f20f',1,2,NULL,'[]',1,'2019-11-13 19:11:50','2019-11-13 19:11:50','2019-11-14 20:11:50'),('d6feb8b64330fa8fe5adc4618bb18c12a06a3e323e42428b34785a70d8687fdcdec92b8a6a7eda72',57,2,NULL,'[]',1,'2019-11-19 13:41:35','2019-11-19 13:41:35','2019-11-20 14:41:35'),('d780068ec605381e225ecad0ae6eac35da03e44dd4c6522264fb4c7f40eb3f023b7c610bb042e631',55,2,NULL,'[]',0,'2019-11-20 14:24:44','2019-11-20 14:24:44','2019-11-21 15:24:44'),('d86814be6cb890fcd3375902a4799ad8517024ca34ea84a2ef8ceac1dbea4376b4d38d652e02043e',1,2,NULL,'[]',0,'2019-11-07 11:04:49','2019-11-07 11:04:49','2019-11-08 12:04:49'),('d8a3dbea23d7cc9c224d01c6c43c0f68b2ff0f83f7b6046ed159add5f4a550aa44b9ca6c13fde3a9',59,2,NULL,'[]',0,'2019-11-14 19:30:05','2019-11-14 19:30:05','2019-11-15 20:30:05'),('d8dddaf04e2de9010ef2b2799bbcff71cdd30e859e5670267bc71eaba04ff043b371a436e3b4513e',55,2,NULL,'[]',1,'2019-11-19 13:13:27','2019-11-19 13:13:27','2019-11-20 14:13:27'),('d91f98683474ab8994cad8b04ea19270ff8daab8aabf708c1900d3a88c1a199dadb4c211a7917430',59,2,NULL,'[]',1,'2019-11-14 19:49:34','2019-11-14 19:49:34','2019-11-15 20:49:34'),('d9f91e1adf947b502056aad962d68f1ce24309d99ce4fd894ddc69a1094b8fc9d65286f7cc52a6c0',1,2,NULL,'[]',0,'2019-10-09 11:31:51','2019-10-09 11:31:51','2019-10-10 13:31:51'),('dac80372d6373d0712677de48e0dae73db3b6a6b0cb16cdc6197bfec2bc27b45c37bda11d1549a25',1,2,NULL,'[]',0,'2019-10-11 09:33:52','2019-10-11 09:33:52','2019-10-12 11:33:52'),('daf5159cd127be7e692889e16a8552f1d11b68d90fae59126194ced1952b658076dbc6be2fc896d3',55,2,NULL,'[]',1,'2019-11-22 08:29:02','2019-11-22 08:29:02','2019-11-23 09:29:02'),('dc3df918893c4f4520c3b6232e8f77d0fa181b67a6ae3c0124e016ae673cc0e473d04315ee84ebc7',1,2,NULL,'[]',1,'2019-10-15 08:21:48','2019-10-15 08:21:48','2019-10-16 10:21:48'),('dcf281938bccfc01e7b613cc371d0cb8120e7dc072e50ce8b05b741f4d4a41a070191cd72345ad89',55,2,NULL,'[]',1,'2019-11-24 13:03:01','2019-11-24 13:03:01','2019-11-25 14:03:01'),('dd151c2fd2f6b59cf86011d5b24ef9cfd90f087c3246bbee35b9bdc6ea89993127a3c9001588f735',1,2,NULL,'[]',0,'2019-10-10 13:53:22','2019-10-10 13:53:22','2019-10-11 15:53:22'),('de4058c479113f80485c1bdb0f7728eb09a71adc0255a6bdb6a3a00934dcd21b52dc734af0ba9adb',63,2,NULL,'[]',1,'2019-11-24 17:46:39','2019-11-24 17:46:39','2019-11-25 18:46:39'),('df721c1b90f8e5a34aca980bef9482533fb7a50850eb84e8eb3e86cc7a8feb48108f7031acbce996',55,2,NULL,'[]',0,'2019-11-24 18:22:31','2019-11-24 18:22:31','2019-11-25 19:22:31'),('e008ed0eb2ea99379b9ce27f8e6f4c28295d6b5dcc12adc9f2a5b3eae7bf58fc661537d63db58753',1,2,NULL,'[]',1,'2019-11-24 17:13:05','2019-11-24 17:13:05','2019-11-25 18:13:05'),('e023e9ab359901f8371b4c9c0d0df03ed6655934e1c6af978a28f1aa5d7be7d0a8d597e4d13bb6be',50,2,NULL,'[]',1,'2019-11-24 18:19:28','2019-11-24 18:19:28','2019-11-25 19:19:28'),('e0666115fe17d14dd03d50688f68fd783a38c729bc546f783e0ff7aca25ebdc8fbe6876426b84fbe',1,2,NULL,'[]',0,'2019-11-21 11:37:27','2019-11-21 11:37:27','2019-11-22 12:37:27'),('e135f57cc346d2d43cc202c3aa9d3ac3e56884e15124591794ac59883945d785abf453a6aadc8080',1,2,NULL,'[]',0,'2019-10-17 15:38:51','2019-10-17 15:38:51','2019-10-18 17:38:51'),('e13a344b4cbc6adeacd11116d442c808b33d1ac1131cfd643cc2bb11245c4d7629708f02ad57e7e0',1,2,NULL,'[]',0,'2019-10-11 07:33:51','2019-10-11 07:33:51','2019-10-12 09:33:51'),('e19b6663e827e41b1521d788107a0ec7dbcec670fbc61eaccd10371b275ed52f9acb4545bd5a52a4',44,2,NULL,'[]',1,'2019-10-15 11:21:41','2019-10-15 11:21:41','2019-10-16 13:21:41'),('e2379d56c5450bb319a794297c4eb6eb3a22e05e9bb97b2be084c4329af0fc89391e5bb63d096c03',55,2,NULL,'[]',1,'2019-11-14 19:29:05','2019-11-14 19:29:05','2019-11-15 20:29:05'),('e277f84de768d64e81b99319e6d3f7c2d72bb635e389d7b33487ecb05bfc4a40f87d8d6396dbed15',1,2,NULL,'[]',1,'2019-11-23 18:02:54','2019-11-23 18:02:54','2019-11-24 19:02:54'),('e30879af58b6762183debb567347942acb1de1cdf76877b242503e4115228a9f596222196ad2dacb',1,2,NULL,'[]',1,'2019-10-15 14:22:44','2019-10-15 14:22:44','2019-10-16 16:22:44'),('e4864d99032e6417c0240b9e1daef7f4c3cd22fb49f3417ea7045525df5009de113b0e9ce4cfef80',50,2,NULL,'[]',1,'2019-11-20 19:10:41','2019-11-20 19:10:41','2019-11-21 20:10:41'),('e558a5f96ed7156cd95c27e9de1b6c91e402b860efbb62f429c744c1f9671658f7ff9fe5caf318db',55,2,NULL,'[]',1,'2019-11-20 12:36:26','2019-11-20 12:36:26','2019-11-21 13:36:26'),('e605f82d0602f681f1b9b0ca1b508ffeb5c5dfce13bdd1e40cbd5f430379a3d70b43a8cca3a5f714',55,2,NULL,'[]',1,'2019-11-19 14:01:21','2019-11-19 14:01:21','2019-11-20 15:01:21'),('e7a8d14eb848cd7aea8105760d21e2ffeb917d9ae1ec8eff6fcec94024b2423944302a85296a4aaf',1,2,NULL,'[]',0,'2019-10-11 13:11:55','2019-10-11 13:11:55','2019-10-12 15:11:55'),('e7be57f573dfaf898af9af1a01341108a508a39112e54f9c4d15d6a0a6caf14a4f3b9fe69b175579',1,2,NULL,'[]',0,'2019-10-09 20:47:53','2019-10-09 20:47:53','2019-10-10 22:47:53'),('e947a526661a5b39ebd0c861285e8df19b036874ff41d7c307ca4c3e80c30092818c474a9f2f6a04',59,2,NULL,'[]',0,'2019-11-14 19:46:59','2019-11-14 19:46:59','2019-11-15 20:46:59'),('e99d5d3aed537774afe2e67fb1601a2ea59761dd656e5f553c70521a203ab6c8afb2cf8127e33616',1,2,NULL,'[]',1,'2019-11-24 18:19:47','2019-11-24 18:19:47','2019-11-25 19:19:47'),('eb7e8f1be2e93963707625c1ad686518ce9185b8ba67a1764052856c71857efeb9c18d577e3241dc',1,2,NULL,'[]',0,'2019-10-14 09:06:54','2019-10-14 09:06:54','2019-10-15 11:06:54'),('ec49f3de4f5dfaaf8e21d538ef4f617a4586a7eeaca213f9fe3c3e12e78596ffe10982f0eb29b3d7',1,2,NULL,'[]',0,'2019-10-24 12:07:52','2019-10-24 12:07:52','2019-10-25 14:07:52'),('ec623feb01bac74393363a3c50878baf9d5c58ac6a720c28c88f7f2406a790939ca1379c40ced9bb',55,2,NULL,'[]',1,'2019-11-22 21:54:51','2019-11-22 21:54:51','2019-11-23 22:54:51'),('ec96f8e7b776ef650d0559a50bfe954b52c18de417e1e5c910643186f363b27391891f2c71e56f09',55,2,NULL,'[]',1,'2019-11-14 15:03:49','2019-11-14 15:03:49','2019-11-15 16:03:49'),('ecb9c32f5ae163adf6f3ebce276e2b88d9143c5bd1b71d91f4d65b26d91d6ebb6c4711a647edfbf8',1,2,NULL,'[]',1,'2019-11-12 14:35:04','2019-11-12 14:35:04','2019-11-13 15:35:04'),('ecbe740b6f2f08b6a77f3434abd4e39c447dc285ab8088349907e8045691ab1e087a9e646d98f26b',1,2,NULL,'[]',0,'2019-11-23 16:29:39','2019-11-23 16:29:39','2019-11-24 17:29:39'),('ecfa9a19a0b524e5dccc06320b10c544768c8573fed71ff6ee9b29813b87b4a3b009ef8c87bbd8b2',1,2,NULL,'[]',1,'2019-10-16 15:21:00','2019-10-16 15:21:00','2019-10-17 17:21:00'),('ef3c39badc309ce9ad3a0fb3758123fa03009cc44ac9e4cd8c635f21318675cc92c058f458f72d34',50,2,NULL,'[]',1,'2019-11-24 17:08:44','2019-11-24 17:08:44','2019-11-25 18:08:44'),('efbd468feab6388a4674876aa70945f4aa11193079a732e91a593b52c1d6b92bca105c5a2cb2cb59',1,2,NULL,'[]',1,'2019-11-20 19:11:44','2019-11-20 19:11:44','2019-11-21 20:11:44'),('f1bd1ab8b4090312d05309017c427c5a755516c9a6e6be7b0d92b4690ccfb831160a965c288833ac',1,2,NULL,'[]',0,'2019-10-11 13:14:25','2019-10-11 13:14:25','2019-10-12 15:14:25'),('f36f7a7590886295ddca4ec980fffa85bad05d713c2ec932654092d994cfca0c305b6dec29974a9c',1,2,NULL,'[]',0,'2019-10-11 07:06:32','2019-10-11 07:06:32','2019-10-12 09:06:32'),('f39cf4e5c48fb4703792f4acc1e33dbb61c20c91eacf24f55b829f43e80755c532a049af7f5516c9',57,2,NULL,'[]',1,'2019-11-21 06:54:50','2019-11-21 06:54:50','2019-11-22 07:54:50'),('f3de578ba168051e8efe7375c1fd678685e4474a82bd93c98638ced086fd8012032d1027e26d4d8f',1,2,NULL,'[]',1,'2019-10-11 08:41:46','2019-10-11 08:41:46','2019-10-12 10:41:46'),('f44622fa11bcd78c9576be1e4647dbdf59db327803c44a1a9a35bba605bac2958c5a80c74a0c3ec6',57,2,NULL,'[]',1,'2019-11-21 11:32:53','2019-11-21 11:32:53','2019-11-22 12:32:53'),('f551967a6dbd616ab65f0a2b879c346db46dee38f775f568ccb912912fe38ae4c15672a93df60ba5',55,2,NULL,'[]',1,'2019-11-21 08:45:34','2019-11-21 08:45:34','2019-11-22 09:45:34'),('f5c84a5052f8b8b9daebf4af6251066c1199a52ece38019cb03c09ce4598c3bf2490f54cead74a37',1,2,NULL,'[]',1,'2019-11-24 18:20:37','2019-11-24 18:20:37','2019-11-25 19:20:37'),('f65f6e4bb029ef17fd87a6f7f7b9a8d64319a93543ea297dbdf8c273aaffe46cd3d6e3ef329cb88c',50,2,NULL,'[]',1,'2019-11-24 15:07:17','2019-11-24 15:07:17','2019-11-25 16:07:17'),('f6bc2427d3e979e119f532ea7f455f5e9908f33ede9352266f36de1b3d8de17d5048b9ca963edb12',55,2,NULL,'[]',1,'2019-11-24 17:32:33','2019-11-24 17:32:33','2019-11-25 18:32:33'),('f7f140d8d43a3541e3243d1a897ddb9ad89888ce061923cb23617257ce67403b64cbccdc17ec027c',1,2,NULL,'[]',0,'2019-10-18 14:01:14','2019-10-18 14:01:14','2019-10-19 16:01:14'),('f819614057fd2b9b0091b16984767fe86091a7206117561c756a8b636059d5234fb17e441fb24e12',1,2,NULL,'[]',1,'2019-10-25 09:59:23','2019-10-25 09:59:23','2019-10-26 11:59:23'),('f87d0449c8afc307a91cef438118860c6a979244a6d9b8c13cb8ed2c66f594864e5f1e2d18a3981d',55,2,NULL,'[]',0,'2019-11-23 18:08:53','2019-11-23 18:08:53','2019-11-24 19:08:53'),('f92a0d2fa95adb66d2109b605c0d5a3e6e2d3ac19f277a95da2131d15b88edd407c5f9430a236655',1,2,NULL,'[]',0,'2019-10-11 13:16:59','2019-10-11 13:16:59','2019-10-12 15:16:59'),('f95a77cfb45bca9408fc622cce5938a8ca3d2f3e18af697402d530e99901c64a698cf178ffe7e6f1',55,2,NULL,'[]',1,'2019-11-20 19:12:02','2019-11-20 19:12:02','2019-11-21 20:12:02'),('fa4282f29e02f7f7e031bc5a050ad766c9992175834ae51f1b6dfb985e86a63dc5cecd9fd3867c74',55,2,NULL,'[]',1,'2019-11-21 11:37:25','2019-11-21 11:37:25','2019-11-22 12:37:25'),('faaa985b47ec2b20bf3f56c93ae3bcd05f02cca77efff67c560ba1628d5fe4a20f44bdf13673dd54',55,2,NULL,'[]',1,'2019-11-24 17:10:41','2019-11-24 17:10:41','2019-11-25 18:10:41'),('faf192abd0207cf2d4e8554e2f420aa46afd19a9631c33896a347bbe53f948aba2cf448ef99d852c',1,2,NULL,'[]',1,'2019-11-11 11:16:22','2019-11-11 11:16:22','2019-11-12 12:16:22'),('fcf2ea4f49dd1783a0343a3bae3a5cfede3bb312ed8b76978e914f2b89d802e475f522017e51e5ca',1,2,NULL,'[]',0,'2019-10-11 07:58:08','2019-10-11 07:58:08','2019-10-12 09:58:08'),('fd32d2ced5ab2cac6a6d49b974922af52d6de3e307cb0b44414f8defc918a948b872aa574dee14ce',58,2,NULL,'[]',0,'2019-11-19 14:01:41','2019-11-19 14:01:41','2019-11-20 15:01:41'),('fd4166e421b538814182f4826f05ea49ff93df3df8acb95e8d3a20461683b0d9d66381283c75b256',1,2,NULL,'[]',0,'2019-10-10 05:46:41','2019-10-10 05:46:41','2019-10-11 07:46:41'),('fda8e2b7b60695fca8fe533875119ce3c7e2c35c1f0babd94aead42e7570dba29da5827bf9cc76d9',1,2,NULL,'[]',0,'2019-11-12 14:58:11','2019-11-12 14:58:11','2019-11-13 15:58:11'),('febb5127bf088d9d624e073d36f4dfc74e93480e9db58124153f3a2404adb67dc5a3182eb8b93b13',1,2,NULL,'[]',1,'2019-11-24 18:21:44','2019-11-24 18:21:44','2019-11-25 19:21:44'),('fefb850f7240897bf26a4aec0a894b313d646d4e3b0d8b0308b3be5a4c5fa1a8d45e8eb4673983f6',1,2,NULL,'[]',0,'2019-10-16 05:34:30','2019-10-16 05:34:30','2019-10-17 07:34:29');
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES (1,NULL,'Laravel Personal Access Client','jsv6OPPq93V5D4ltZ07zWNzemXHDjA7dAQ2aRujg','http://localhost',1,0,0,'2019-10-09 10:57:01','2019-10-09 10:57:01'),(2,NULL,'Laravel Password Grant Client','EgDwYss1HthxUbAjbRViO0QaNF82gsJIyCiKXiZr','http://localhost',0,1,0,'2019-10-09 10:57:01','2019-10-09 10:57:01');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2019-10-09 10:57:01','2019-10-09 10:57:01');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
INSERT INTO `oauth_refresh_tokens` VALUES ('01651ae2e597ba64171978964f65ec1726b92d288073427e07ac4576a9213c500df3989380af8821','b7b0c45d4adabe27115eaf66e833f704df76655e2a887252c58ac734071e0c435436297c74cf266e',0,'2019-12-18 14:55:33'),('01b4c7544fde0be3cfc4d63cc1a8bb90d012e65f3b5656919c58341dcd4eff109299c1217771c7b8','bf0e437b7f1d5ffab27d7c4bcedff87c9917e7dda3f47cd2588876a7f69cbbea480abce0a74c3361',0,'2019-12-14 18:18:00'),('028bb9aa158d2d1a7f19290f0371e1ff816439766981709558710d5b682d22e80ccc671a21dead66','18178e348daa4c70b4e8ab5570301d799586bbac99b42dce9583650459115fd5742042749dd75775',0,'2019-12-14 15:52:12'),('02ec97fdf0fb286c24cdae0e3be9a1a7bd8c8c02ce4df6be6a8f82697839572dd8e89ae08ec510e6','92965d533caec38f23e33e8cdb9ac62be2ba530048883f422f69f1fb0f51a2d699f47dccfe44e9d8',0,'2019-11-10 14:03:43'),('033234745d976e1e05ebf86659656519681c2464e2c7e893a901817b82d3b470226a45df8f3953b6','9ab8f36f4f9f755b6330ec11c618bcfb13fef60f2a862b2a58ac722640836e6feaa15ee9f7598b4b',0,'2019-12-19 15:32:39'),('034af6c959982d726dbfbeed2b4ff3ed770f9955b4892ddfe91be0b7d380750f22993599794fc1c9','e2379d56c5450bb319a794297c4eb6eb3a22e05e9bb97b2be084c4329af0fc89391e5bb63d096c03',0,'2019-12-14 20:29:05'),('041a4a946664ae8138afdd0c352859f0aeee4d276275e1a28929ed76ed2e9edc780da5ee544aa77c','f87d0449c8afc307a91cef438118860c6a979244a6d9b8c13cb8ed2c66f594864e5f1e2d18a3981d',0,'2019-12-23 19:08:53'),('0442e63ef36cdbae6b2e9e2226ac122413ccfa967f51efb9b778e27f0532f678d49199abdad30351','1f48483e67e4a624db5ac80faadca47f3e579ec7ad37eb9fb65e382c238bae077574eb094a7cc81c',0,'2019-12-14 18:14:23'),('047d0df165ca2bcc163a3edee30630ba94aabe1e353b69497ae355d2b791b0c9de756a6d1f9163cc','cb69c1ddd6d4f1f51ac7560370049543fedef8a3965ffca980f9d7a186b03ba707212706f637111d',0,'2019-12-14 20:47:00'),('05567f6b5f606bfb171faaab80c1c5e1a3f4d81e056fc53dfbedfbeef48226bce83526d944e52ba4','1199bbf76ca0b0c4ca4bad3b8a1573e0606c000cbeb86884fb32457ad8db7336a8bc9ad4a8fe9826',0,'2019-11-10 09:58:50'),('062dad48584675846da294eca494c6c83b1757bf94e30bd8f54027453e741b3d2af39722a3290fe4','01f0f4bdcf8894432552f29f1179af9d1a9804285184c459622717f3b8896ef8b94afe90882e6ea5',0,'2019-12-19 15:08:41'),('0705a6dcbdd79340c971119f81ab6fd897a6861635c9a08e865de07b351fbe2ba95e4db621a4401a','b4580a167bb0674da85311c79e751ab0be0a2ff7bb71ee2a83008ff993235358a14c9ed584aaf783',0,'2019-12-24 12:18:37'),('08134a6435ce983af82a77581b1595238f763f3ae32ef6c0f7e79a6d2025b1c5d6b9cf6a0875ea8f','1d94aeef70a28122cb5ec737f549a7312478e987e380555343f04567f46c9c1291f08d38b7a62310',0,'2019-11-10 12:56:29'),('08b5a5feb69318413feca7b261c4128e91b990bd109d0f281d2b9f0fce66c458a0f9f3e66c0425c9','6e96036ef996f0aa768cae0cd895a5f281a7f716decb53b9506f763084e496224f2cfc4bd29cb77b',0,'2019-11-10 10:51:19'),('0967077b4c4b0bc22c612e132a48a6d3a532f12f2849a5c4109a89764e394306d7eacbf4dae97bc8','851fb9183a3f7f2f38bc1f0abb54940ce6293c80b7efb901b62f18db7fe811597051df436b7ca617',0,'2019-12-23 10:44:15'),('09cc8b5ab62381ac0a59ea9c3b2b7dfd9331e1464bcfb27b4e38b70f89f817e0dbfc3f4712a100fd','d3d57e5274d2da41f084de6b26c7c071344a8c2858bedf1238b7df36eb98a5c2f5072a8858884064',0,'2019-11-08 15:40:56'),('0a586c72ae80443199846fced0d1144cb2f86bc0ad3d59abe1453ee63856f169015532d80a4c2aab','efbd468feab6388a4674876aa70945f4aa11193079a732e91a593b52c1d6b92bca105c5a2cb2cb59',0,'2019-12-20 20:11:44'),('0c925f9408962c8b4fffbf5a3a1c5e312fc9602f266df23a19d1e1f4e94bb557377a4e304b2b756a','18b7e7a676220b9a1c35c0651e4d8defa786e03868945fe071f3ef4365fdedc6e32d091e70fc3bc8',0,'2019-12-11 15:58:36'),('0cd0a8b7754d830b4c6d63ffd18ae458b7ca06ec6f5edba3a7b6f6d09eda07fd72634e41e55e1599','9ed9f29078bc050e0e2071793ace266f7492efe6696ff046778f05b93a7b5a1aa9c28d70adb23913',0,'2019-12-19 16:25:20'),('0d2e62fd57d4379f08e0acacb75e2686a22e7ba9a14bd863c3340399f5f85086a8e97f2fb8f39580','8aae72dbf712df59d70b5629f5098527208ed7f844e4a5b0080fbeca51046ffabce832d78fa898e7',0,'2019-12-14 18:21:03'),('0dc06bcb7c6fc089490407aa3948dc199b9a1456c33fc48bc3a899af1ba4ae6c9ec8f0c83bde3a1f','b6e2f29dff171ba9f8d28e7bf3c4ed65ee9ff83724bc1a71f1264ab3951de44d6e92d90a865dcb0c',0,'2019-12-23 15:50:53'),('0edb51ea9b6740ae6c2e815fefbe04516a768fc5bb82cc44b629c45df107ae8a6e4bc4b97b30ad59','10468a5299ef622fe5d0acdd1a72f296c516a8fe4cac55612d82dc474a46fe9838bbd1e844a0fdeb',0,'2019-11-09 13:45:57'),('10ae29232de4f6d8c1ad4195d42a3911b8863e38aa1199f10c4ede6fcf0d250818b3855bc10cf01c','46e00395683891467e48320dc79bc33bedeee04bee3d9842b002ce922d8ff4d3e42117e5675fbf58',0,'2019-11-08 17:34:16'),('12a274b43ab0cb594e9a041323c5b550fc905fec9207cf6e1699b23e048234cb7a0a2994d2ba9f1f','aaddfaf1c05c059624cab8112d2707dc972af08568ff704e376d070ed95b55249c98c3806cfe5e34',0,'2019-11-24 13:46:41'),('12a81f8f93427f797cdf846d19890ac2af0d38568614dea3be3d658c557d66c75cb52e079e9872bb','f3de578ba168051e8efe7375c1fd678685e4474a82bd93c98638ced086fd8012032d1027e26d4d8f',0,'2019-11-10 10:41:46'),('12c7636fce7d740134b47ac505a72fe83822ed859e89884022c2fe2b598038fcf51bcf6e1ff374fc','0d4787260385897434acb39cb65009cb9a34a044e76c7a514b8b0baf7c6ddb0d1068a8ac0953b196',0,'2019-11-10 13:24:05'),('12e7157c312e2f13463d92ab743c7ff4f7881d7b83a6e61022bb683be5db09a9c0561d61686b19d0','4487470d414b3385ff1526e4be85385debf9e9a0af65d8ade6d02e159ef6bb2ffd3d6c33708138f6',0,'2019-11-29 19:15:46'),('12eadb6ffa9cbd60fad5278c263bde35710be16d90ae1631eb60809f2fd79a4fad66572c2c96ffc9','0fdcdcc801f7a85e7e7b577136a8056cab66142030ec349ba69a61b0b9b6b8405b55aa0c44d7caa2',0,'2019-12-24 18:08:22'),('12eba786183d3f9b2d4c3f55c37a1a9147d6ca0e8a171ef93486a9bd014976e1b877b683fb1abbca','f551967a6dbd616ab65f0a2b879c346db46dee38f775f568ccb912912fe38ae4c15672a93df60ba5',0,'2019-12-21 09:45:34'),('156c042804fb155daa8e94140fe37f866b1355efce57261a5b92a012471344e7494fd7282e9983d7','664b323f3fd6c5e7151a11eb6354df60f3d93061e2b6f27127870511a0795654c12b187fff420565',0,'2019-12-15 11:24:03'),('158e6bbbec7462fadaf5b08dbc345de8b3d5a2007d6618a259f18abe264952b23af4db2a662be3cd','8568a57f5a0d24e5f5e088d2066c43523a9cdac336f61367ef435c814d2fd1553224d1bc1d1dfbef',0,'2019-12-08 08:19:40'),('15b3cd8da952bb2501543b2aebb4255c8840b80a4daa196b9383a4711365d727884308c08e7ade7b','f44622fa11bcd78c9576be1e4647dbdf59db327803c44a1a9a35bba605bac2958c5a80c74a0c3ec6',0,'2019-12-21 12:32:53'),('15d1da26f8de83e4dd423b2d79be403891b579cf87f75322c277180624a8eb3e36da8ab02c3e8bf0','29bb02fb7fab585b7c67ba459e74ca1f8821c12e3f97bc2d7d342bc718a13c8e4b0e423a13c4fbe5',0,'2019-12-14 17:07:54'),('16310312441c4bebbcf80736361597a3f2378f406439961f1512bfaa3135ddc1ce3fe6db8f4def42','64330ca27cf542877243b532c2336d868f48396036a95be06a80eb88c4006c50ece61d386b4039b1',0,'2019-12-14 21:03:26'),('16ac1b7219e3d1f9db87a9d3c037a5975e210fa781bbbd56697d2d6714755e1a08b3801058fbb6c4','c2928df206711efc56c4f671e5c8daaf79cb29448768dbf9b5913c1bc083e244daffa094a5e91f72',0,'2019-12-18 12:17:42'),('16bf556280f077df2370405750d74bd910660ae179a75591bbfccd8fb32e7408705fcdcad1acdb30','b43bf1213a95f9b4b6337129b6bf861aeac8e79bbb72a3722d1e7f584300962d7eaec6fa9ab2b720',0,'2019-12-24 14:56:26'),('16d636765abb39728addffa934500a4326dd9d87f56363860f86412cf177ed81379978ce9a4b2227','dcf281938bccfc01e7b613cc371d0cb8120e7dc072e50ce8b05b741f4d4a41a070191cd72345ad89',0,'2019-12-24 14:03:01'),('16e1ef031d5e15909c3c9eec091b74d7e2278c4c780f46b1309c4ab2a40fb02a20b8734707f62294','d3f5a86334268cf7e41df5b8f864a574042478ffa74bd659e2e1e4836ed4f46db920a665f3446488',0,'2019-11-15 09:28:25'),('17679ad12ae17fa2d5ed1f4f01a8b457600a5c07a51b09282b3582d9f1844375cea94ab3f1df90d6','35ac4d812a2c71e00c35a38736e6b38372cc933ff52257437b2ccdafcdf1a04846d47266c95c4c63',0,'2019-12-15 11:25:13'),('177ac4b5bae04e8e439503b1dbe7610de54cb49e39d02274176696b3fe9e7c64502e33698f101be1','ad22f0259d9f40deb1ed0cebb303bb461d95225b066c7bd0c169e800450d7634a1406c2cb553165d',0,'2019-12-13 20:30:49'),('18147cf75ed4d23385bcede63094d5e2dd5c07f3621affd75b517be3175090fd71ca1de85a6513a1','f1bd1ab8b4090312d05309017c427c5a755516c9a6e6be7b0d92b4690ccfb831160a965c288833ac',0,'2019-11-10 15:14:25'),('185d39df1830bdce1e109036f46a4fcfe630a1a47488418a54873b0823f2f0efd62fca9d495b7fe1','ecbe740b6f2f08b6a77f3434abd4e39c447dc285ab8088349907e8045691ab1e087a9e646d98f26b',0,'2019-12-23 17:29:39'),('19cd1b46a6cfdd4758596c311f54b6f5d5f2a68245c70d9239e0e81608f2e78e9f76d0d4631516ae','d231a03a7e6b2beb0ff8f4f5246f01a08afa7e770d57b4faa78223e01c1a641a422cdb4eea2ab948',0,'2019-12-16 15:06:20'),('1ac1504ca3b9132ca72a1517e42e907f823936a805d48713b60b35225ce47f933918d6ea8b19c987','e558a5f96ed7156cd95c27e9de1b6c91e402b860efbb62f429c744c1f9671658f7ff9fe5caf318db',0,'2019-12-20 13:36:26'),('1adea46b87f46906f21bb46f4a76d98615c03bcf0fbf9adfa81bd1b0aa6e297cfca8da2e3be84918','4cb627c8d065e5678ac360bc76e0d064955da54350bb8041bf33f74cd3547c3ec3a0f9daf9e1118f',0,'2019-12-14 17:18:35'),('1c5ad8b6b29581b25b60aafd865a7cc7e1cabd130589b7f69715c0c76340175157e8d8189bff6198','d6feb8b64330fa8fe5adc4618bb18c12a06a3e323e42428b34785a70d8687fdcdec92b8a6a7eda72',0,'2019-12-19 14:41:35'),('1c6f6d6cee8c41fb7849c708edc5dd6d4db41fb752fecd93855245d5e1e403663c92cd1d1c009e86','70be183b7b22eed7a743ebbacef5ee24c685a370c70a9a0989465b75de173ad4bd32cf9a80130a32',0,'2019-12-12 07:48:57'),('1f280f2dacb165ae83bdc9408f5acf971dcf58b839ccd7250d2b18fbd6de339a5da8e73e08ef4b72','5aeb8ebe82c0c9f789ef1e332f02e99aabe9b49888e598ed4031d7cf632dc30490657ec705d55528',0,'2019-12-24 19:22:12'),('1ffa173846364db492a7287b9e3f45125965fb0aafbc748cdfdf8ba3bd4235906a10c70259eaf1cf','86859063981e3df4ad3b360810276d417609d2af987d040ed4cd6803125e5093801a994be4493a5b',0,'2019-12-20 10:41:48'),('20be2589f88e53a2af209b09071e1917d271b416ed3f2a34cbfbf171e71b985d77596d8fcc5cf746','1b8d1cc1f2afcc4b055b4cb1bc6744c79d2c9dc1310fe8d9a925beca8b56440bc426947a6c677615',0,'2019-11-10 15:05:10'),('2169e90b9638be9c727eb3ccb6fd8a791ca5e045f6a78b660af6d4eff5f091b8f776f7af6e01c0cb','138da2404730288e8fdbf0a930bd89ba8d85fcd7b61d63d23b842abc87ebedf6c475e1cbb7b65247',0,'2019-12-24 19:16:27'),('21dbbb3b51e257592caa0d072cc68aaa1dedb235e8c8f0586bba0d10f55c59ec1eef7705c491cfb7','708f0f6b5f4a7c83be644814ea93fa266507ee2ce567a1f03935049b531d0d482375a6998243f92f',0,'2019-11-20 07:45:32'),('24a81cfc8640ca52c4039ddc965eb0a2a066620b93a8fd45863133b71ed85574a05f45289b957847','1101d88a01805b8276c1db1e90faa41ae88d659686a86fc91f9cf7ede31c38800f413b8f7c4dd3e3',0,'2019-11-17 16:47:02'),('2534a1d2890ac17bbfa0f75406e962f70bb392d58a7183306511af80bcbff78d68b0fe89161d26f1','2beeb1b72f4e7ebeb58115b09af489cd617c6c16afc9348a8dd749a342a538b723c94868584c7736',0,'2019-12-19 12:13:38'),('2560c815a30318186085c60cd7743bd3a51c7ed041b2cee21228bbc2f7cf4b5a581d3a4747eac41f','49076d1e15bc76e6583d71be1b8e79e1d98ffaddc9571f0272f3b4a6a45b5fd81782d6ba1d758a3d',0,'2019-12-18 12:21:04'),('258430381dee960c7a3702700eed1aeb7f6569ef5db888e0f9b6083d7492ff51dd61e79d373d5da1','faaa985b47ec2b20bf3f56c93ae3bcd05f02cca77efff67c560ba1628d5fe4a20f44bdf13673dd54',0,'2019-12-24 18:10:41'),('25a35a57dc555c7a7cc535877c044fbe9f8aa8e2a204030642654525e21d550cdf166b46729b6267','3c02572db2fc44c2019409a2cda34705b8b70d797584e75c3d4485ca4fa964dd73ca1db1654b56a9',0,'2019-11-14 13:05:21'),('2662bc7e59c8d948fba97d88c6c8406c23a598f1171ad1263c0dd33120d680a8d5331ae20d6c7300','d1090ddea00d7e49925f8a18e796cd670e755da323b52ba2b1e1600fe55c8672136584b744da34b6',0,'2019-12-24 16:04:20'),('28418e8d4f95ebd532d40adef6400ada3294d2e7627d24b9fdf989b182996b44a8042d4f7c467251','94f267436986ac2fa8f3362612cfbe0f122aa314260d35ffe7ed4982202075323f3defd331eedb11',0,'2019-12-24 14:53:44'),('2878defb14f912486e45a34daf8713b1c0639ea1f1b5949208186e89da8c3df296b0e05e4959562c','49ea6c6d23fe73f7df48bc06a2ae122236aaa873be828a0c11bf364306853cf54802cf246fcaaa9a',0,'2019-12-24 16:06:36'),('291d41b9efd73bc8f60775751cd904ed638a72e93d3fdf45a45940f47deb9cb31ebc9bf15b7af8ed','e0666115fe17d14dd03d50688f68fd783a38c729bc546f783e0ff7aca25ebdc8fbe6876426b84fbe',0,'2019-12-21 12:37:27'),('2955716daff23dfa724dee44052e7949d8ab78a51e8dd8cf0aa860a90188b58e85060fa53f4950af','55b763d9fab31714beb85264798b150fb5f25f241b929389a6998fab9dd3619f6a732295d9e944c8',0,'2019-12-08 08:27:08'),('29f202382b17846403fde3dee54744ef1f5e9621cb4287857b1447bce5eacc426892e4a42678003f','17fdefd22b9783842815b9d7508e129c06148e3bf17392545984bbc9271d2a5223d2b47c204379e3',0,'2019-11-12 10:11:00'),('2a08f902c347104ad682cd655cfa32746a770f3384d084f21fe5a54d620ee3122814b2e662660896','d58ce644ea0eb137306a1dbfb18c6385e0612437759ccca81f07f5ccf17169d9556b267e112f9db2',0,'2019-12-15 15:47:17'),('2b8e0bd0aa310cdc47803c342c565b467436b42e79395cffef8357c4a7bff4f181ce11cb937be538','d9f91e1adf947b502056aad962d68f1ce24309d99ce4fd894ddc69a1094b8fc9d65286f7cc52a6c0',0,'2019-11-08 13:31:51'),('2c51131a1c2f2faef4114f3c76e01315fe3e1c0c5f61aa68733e9202092a26cd221192ca70571b83','29e87240052e3e651af9ebdca4c8f0f7ca3a3c802c55ad5d2fd728808f9b538009d24dcd9f68a96e',0,'2019-11-14 16:50:26'),('2cbe7fedfffa728b219e5974f762a110aa12e537708bffbd7c78b81ebdee0f8a6677dc6c78f07055','a31111b5f457e1b89a8640e44e1fb6d94ba078eee8dcda36989963eb145c9ce68d48429bb7d23260',0,'2019-11-10 11:38:24'),('2e4f4f6183e650d671318b28cffcd9892c26878c926126abc273a16596c11973ea12fccdda2af7ab','923b5b16ca63bed1d406eddd45c3c649b343d713507c785b278c3838243332728511afccdf223c2d',0,'2019-12-24 14:52:34'),('2e722c5518ad11111d8c46c1a1b056ff20c02d4e4a78e145605bdc1d9e3a2ef2cde947f1f2e67562','a4b85fe2f9a01694ae3ad308f1ee523fe28519e66cea68e2b44bc61678763101f43e8d2e52a805ae',0,'2019-12-20 13:57:11'),('3055494debf9425bddb3cea5c47fd64445320cf30a1dbe17c188278fc03ba1378036711cb29dd9d8','f6bc2427d3e979e119f532ea7f455f5e9908f33ede9352266f36de1b3d8de17d5048b9ca963edb12',0,'2019-12-24 18:32:33'),('30a67f92e15b7c9036da8044c1ef7ad86529ee2c238f0b35a5b6eef630fe7b889949418f4c7047bf','98c8732203c78c6c77e971014d730e264fd80c05553150ca74947c1f3ba7dc5fd6ab7a9e63c53b76',0,'2019-11-09 11:47:07'),('30c64d502f0de8802dfe6446ba70dd81f9632580e060a5c59f967a3006b13ff37fae681a6b387878','7a9cfcaa28cce1a336e0ec1517a0ec9687f6ba47579f1e56a84ab56c548acc006c95056b91771608',0,'2019-11-24 11:18:22'),('30fbe3ac956be85391f47107411a11f62abc8a455aa73ae874d476189580e1be64d3ed807498c770','30025e8d994ae5a7e5b2cabc99eb68d2fdd29aa2c6875b2faf59152856e2af3892ca62f1c7ef83b9',0,'2019-12-22 08:56:32'),('31c2209ecee60cbbc449c6081f7bbcbeb0fef43b05a6728c897c93e15177671d7b939c23207c686f','e7a8d14eb848cd7aea8105760d21e2ffeb917d9ae1ec8eff6fcec94024b2423944302a85296a4aaf',0,'2019-11-10 15:11:55'),('328a2b6a2fd4cfb0194d8ea68708292a2ba12a15493b7fcb338387ee621bf3544aa567e147b83b75','2c7c24002902ca4d1a0856df9ee12c1a19c40ec6e2773f3f19e7c06771350ab6e5de0ca9e095eeaf',0,'2019-12-13 14:04:43'),('334e33487ea0c54c661ba007fa03dbfa099caeff7e53a35570643042dd97a254bbf5645312120b9a','2afce1c2fd0bfc3ee5ac69c9c9d7eaf91bb1a4495276556ac3f187fb417960cf9183cda6332168a5',0,'2019-12-18 07:03:52'),('334e71a182ce84a78c4627af47922122af2bdd8c213922cb0cb7edf1579a4f5d5d907af64b61bdb4','12096ea5c8696fc22c0b21f8c46c5d62f94542c14c3e5f6e423e97f5dfcda81b199c51f2e3c25811',0,'2019-12-24 11:43:31'),('35948afd416d23ce8f9da81b75f85a67180ff60633d0b7d3f19bdc98ca645b323a9758a475c011ff','7786e05a062d755c84aaa2b8b0c6c2f05b5db7540f091ff49c6a1d03764fdec277cfdf81bec5ff60',0,'2019-12-24 18:15:08'),('35fc61c7d18bd7266b6ccd5b6e901aacb889d27c51d2c40b7d26a722d907ef8684546ddd43212add','95631670458627834921627a4f4f79076d967da0df200a66e9a4efa7c227bd51d9f5abfb543e42fa',0,'2019-12-14 20:48:21'),('36a1f99d1101d9535e321ddfbe6bd630d4a5b69ae1ec4a9797e4961b43e9237495da38580379afa8','353a7e3122ae635ebec5342580683c3345cfbf4014668d995962b9e51e44482c913bf946bf7a73ec',0,'2019-11-10 13:56:00'),('36afd482748ee7b7f2629f3fe0c43224b270ce46ff31a10467d022f5040a625821b72fd864040a14','1db22a021a8faecb42474a85b48c3c07c09a6c2f6a343b8ee2d13e67a4070185b1bffdc9b657d222',0,'2019-12-24 18:33:31'),('382f00c373e73b6681c1776a58ba1503deab108c3c128dc0ec3bec870010a319a6637ff0c00c7500','3c27e04fceea5188bb5e6a45fa38ca273e79ea68f1edcbf3f25e760654eb7e07f44da0349bab841d',0,'2019-12-15 15:45:58'),('3831f4b287005a57b4a0098a7ea546285a4bc7f28ebb32f915da9fdefc8b8d1c28e19f4dc65a1c2a','735d23ac2e428c4b3b2f4fe2d0cd45232f833a09d9f1067897f5303aea5d412216b1200fa8b47fa4',0,'2019-12-20 13:42:36'),('3946c91b940cb7d9181899c2edeab1feb2ae89389fa24701297a3df2d8f0833243de461bf2a6d15a','893a902ad8c9f147e07078d00fca3cf91e2f917470a7516c0989441c5b9da275b54c08802e412e86',0,'2019-11-10 10:55:57'),('39fed3eaeb10982636e8bdad916c59a271b370215721b7824e85e93365d8e204ef694b45ff7e2c07','58302a9d4d191a684ac4afb09abfe015ba165a9e21c8980c645f2718e367c4681c498b5a37d5717e',0,'2019-11-29 19:14:52'),('3b055f50c5de7b41293c20a2362b374f29e73b202a30d28f9b15bb7e490ece1137e722cf50a11d44','1b7a617df0ee1b33ca1c1f3342587a2c03cd7156b73854f109d8d57f9852dde061ff6f06ae5094e4',0,'2019-11-24 14:25:24'),('3b36f261a4cc217f8ba202024dff2bf4b13d83bce0374d2a6810f6b9f7797103320d8fce2e62e181','479533daa2f4f0425dae79b4955019d79023c20c3d1121ee23716bbbf85189ebe4aeb6e56fd2cbc3',0,'2019-12-12 18:14:37'),('3c0c88ab9ef9c380de1533354f90331e667b33962f16808bfdc78baad6f2fb9402f3722fa93f01f5','162d1fc3a9949aebc7bacd61fc4a0dddd6ea109cfb465307b693969690c380d5a08ad0faff4936d6',0,'2019-12-24 11:47:26'),('3c762da42c98ee58808d99c063f467dbd78aa328d0132f520f455f3f4fb7ddb4ced058c995f95d54','4d8521531e248931f5ac9ade579939639d47336ffa29268c302e104be09c64d78b41a9bb842ba149',0,'2019-12-24 18:26:06'),('3c7a41819b1ca472dba8b96c88593f6cbcfa9ac0de0170c9f2302f57757aeade4d5c71c0ea024f7f','4676d3beec07dc3644ac2ee5d79c0b8bf2380ccea8a3747751255998c6ee9a348ff2bdbbc4a3de60',0,'2019-11-10 09:41:49'),('3d32e3df85e2d055f47afcc238e67203cb998da329a11123dc9a96a61fa42286ea6608c1db7d55a2','9fb8aef037d1b681b7b64c6dc5cc8659d9079b70e94179cc306c9096e5368c4e3079e090ea1e0af6',0,'2019-11-20 19:53:56'),('3d777e95e91aeb7ce08f856166ab693e9b5dadf640a78e4d6ccdfed386d55f8be27a3208458e3a65','809b1cf42bbd59a01977aa13a2ac444b1291b4cdec98aebd957bc5fc721e1a8de30151e5a98d60ac',0,'2019-12-22 12:04:17'),('3df1b033d0d7c3917c76a35db11ac34747102ed494572e9f80733d1d8d9df111fd94fa565012c177','4d4e2f112842b50b9ea074119bcab9b3f5d9d3900cc92e3020a53106d10f10da77acf2482d7f2686',0,'2019-11-10 10:48:42'),('3ec2d8f48cbe2df3923ba2122c220d61020ac29bebc1265cd9f3fe2c620f4cd36eb6e172a8a1313b','fd4166e421b538814182f4826f05ea49ff93df3df8acb95e8d3a20461683b0d9d66381283c75b256',0,'2019-11-09 07:46:41'),('411d6721039994bd0a313ec27ba1dd2406128cda526ba245850f38b4ed6a5236287dc1f51deb7830','9cf4c6f83dcb6d93a1ed70d6a8b7b7a964ad6eef3ec4fe3ab6be96bed0796cac95024192e0a09f67',0,'2019-11-30 14:38:30'),('41352a9ba780dd1f304de0ce08357662a14521727a14c802f6b01e5bfafe187e6fe1e4e79aeac73b','44d6f51bb6b0505d56e6cc83823d3be722a84208545686dcd24df10bb321e8b292bed42e95716dac',0,'2019-12-19 12:12:01'),('41fa6e0b16841d1f5c7b05cc5942e3f2f7425151b16112b8fff1748bd6a45d12d6cd2c534e4843ff','08626629a0d60851bf94d9c5874f30b622f8a22db462ba0274624b3c5c2f3129f7646bc56711dc89',0,'2019-11-10 10:51:55'),('424652650302de06a76f361d5ed935e57070a2dd8487beef6ffed40900822a70552fe70ffb67ce4e','7bca00bc20b879b2a67364288900d027b948be05db1dcffe80f5480ce6220b0df0a13a02fa0e3b37',0,'2019-12-20 20:25:42'),('424f51c455d6339017b5eda2a048d3b5a5e89285fc5437f1351a23daa5858c3d9083376e5ca76b72','03dd47bf8fdedfbb411ac968ca33a4a1b7fa4263f2c2d68621022788550694fe856b9835cbb0ce68',0,'2019-12-24 18:33:15'),('4259ababe4d20e9b532e119185b3cef501df2916e07219f773cc9ec46adde5afcd6fa94322bdbd52','8a2c9176326bafe1b4317601ba041ac78ab34446abbd19347e34fe55c055c39922529eddd6342d6a',0,'2019-11-21 09:12:24'),('438dec030e3a2d3f5a1feaab272366208de2a9a4709d103dddc5b9aecdd613644acc3400817c2e71','faf192abd0207cf2d4e8554e2f420aa46afd19a9631c33896a347bbe53f948aba2cf448ef99d852c',0,'2019-12-11 12:16:22'),('4414930f29ed3aa2ebddb5e63a2ddfbbd1a5ba7cee819c2d157b275f0832b63b784b3329641b59ec','9f8ad4988a03c50fd9785ee5e99ba0570eb2b20a99d17be2f54b298ad985c98d3d0533f8bd31d383',0,'2019-12-19 15:01:34'),('4579b76253c33c44630892ae401c61da78de042090ac8357d7a5ac9703e3502f18f2ae44fc44270a','3c6c256617c09f8738c3eb6200f568567d016882f0197c276b88a14efb8ee2b4d485fd514c6c0532',0,'2019-12-19 14:40:56'),('458d4f3f8ee2d19ee07170b05793b8e7789604c11e591e07b676661d3ac0628e3aa809ddcd1f5a65','1cff88dc67a92a9603505470fde9f84562ff84f377925f710037c62332ab624fd5d1d3c7493a6ebd',0,'2019-12-04 12:44:10'),('46e7129ad667174d556d6e6e8a73e59eb3fdd10a24bf2d45734798ce25b1f8b7d69393b5211122cc','088d6a1379b298bf4fafff0af3c6c1348f44d1633d119a1382549f161fca5346a5017f84f3a1fe99',0,'2019-11-10 12:50:04'),('490804de2699955c0b0220ee611977e49a2bd7966489abe040cf337bd40b2503f2018eb00c2ff0cc','e7be57f573dfaf898af9af1a01341108a508a39112e54f9c4d15d6a0a6caf14a4f3b9fe69b175579',0,'2019-11-08 22:47:53'),('4a5d0e61ad9556a5de3e2167ef586949e79ffd426d094face8fc7deddbed3738aa1cf128aa5c4ba8','2f3a6370284ee949156f5c3fe9a5078fe63c171f9732ea589d63609a80c5783ef6673a583c47b45f',0,'2019-11-15 22:48:11'),('4a612be4cb56dea253d78c930cfba35b1342f139a449b0777d8e82f93bc46b29fd4f889cfa83147a','ac99d9a97f6c75afa08475d5038655e55d0b51a0dc386e770ff558c673ced0c573ce6fbefa2c5344',0,'2019-12-23 19:20:06'),('4aa742f489b016c805623d35d798ef3f1ff8fcbec89aaf2b05706d690d7352cf5890d80fa084821a','3bd2810a3109bda8d2a5982c33ba55b05137195711efadaacec65f0dae376458aa251bc525a9ae8a',0,'2019-12-24 19:18:46'),('4acf04fef4efb513a5c34aa48f4a324ec6a5bc8dc32990b13f06c18fff214bd53561e2c4ca9ddf2c','2dfd3fa5b1aa4665a52b126e529db8aa5ec89366d3f5f4c6781c4536cad88a82bbbf19190a8f8f7a',0,'2019-12-20 16:17:06'),('4b501f74fa5bffdee1fcc64cc474af4eb1e1c8110c8eccb1bebb4189199f40d71b8f6650c0f73ed8','5b869bc8cece085668039883871729b99d7553ca7d2f50607d000b1ce0709fede5df154e09827756',0,'2019-11-14 13:24:44'),('4d2c24e102d94143fcd7da3847ae0308e89df6f630d4479f01c0cffc8ecc686e70cc9aa2ee8ca14c','1af5d3620fd7b6404a7eb003fb528c9c87822ad33b5e6414c159f9f81cfe54e91de88b37797ac134',0,'2019-11-09 14:05:22'),('4ddcea4b3a0ce32833ae12a77e7e16dfd932049644166920c1146fdc568681a4c98cc2fcc281ed39','dc3df918893c4f4520c3b6232e8f77d0fa181b67a6ae3c0124e016ae673cc0e473d04315ee84ebc7',0,'2019-11-14 10:21:48'),('4e14585a2e7af3d289d1557139f54d4ce8a8dc63b8d26235006209bf9a0a1459123c953a94167de7','6a4ade3114228ff782c7edab555dba3899e65d63236f1423c43a7ee08a944ec9f40f851f82cd46f7',0,'2019-12-05 09:37:29'),('4ee4649a2aaff07e6f89a466129bca2ee828b2ddab2dc92bf01aefafd8bc7e93b7b793dd94fc69a0','2e40ded554399f6d1d1c657e8cfa7f5357a3a9e8498dd4b026827733c6c8ed17fa49e4bc9b7acaec',0,'2019-11-10 15:27:01'),('4f441a3b542aea3bf8b283c4ea536e4aefe8656f25025942f17b3a32aa2db154b09d2a1f6b2bf9ee','c13c9a3ecb32ec04f7c458d0f4ee7b0417c5b9e9c3071a2a9769e9a051e20132facd8615151f19a9',0,'2019-12-17 09:51:33'),('508cff69d25b4ed013d09c9ff6e78f10e3dbc5aa06336c5bf4c4dce79f35f2f00675e99ef5b11cf3','8307e28ab6313a011c339e047fd544c6775bc241db90d5ede5317c6c06816579a9c14e579c2ed56a',0,'2019-12-11 15:53:09'),('511d128c9511e47538f3d5e834390df0cec56229a19fab3ba29ae4a8644d2192e0f5e9b359b29f10','63d22aed5ac6c0cbe32cf566218a216c6298b15de3d390ae3b187a1fd7969534c4eab9c56057453a',0,'2019-11-10 07:36:27'),('528c7d84b61667edb365dc0d2f55eef319e9f2ad8cf97f6ee6d6f41f66fec53bc165b961eb774a40','e008ed0eb2ea99379b9ce27f8e6f4c28295d6b5dcc12adc9f2a5b3eae7bf58fc661537d63db58753',0,'2019-12-24 18:13:05'),('534e048957ffc39ae18421f02a2c99bf7ecbda0747014a7d9e8bea740ffe2c2069b33a3d8375cae1','69c545cbc3f3b2e5a18f927b4541ca2073b78ddd19cc23ebc681b1e5aad337bbdc5d90e0268104ff',0,'2019-11-24 11:18:41'),('54b09e4bc1cee5334b3d3fda5d284e9151885f45431d817e82a1c2d7402a7e5b47c2675c9064508e','fefb850f7240897bf26a4aec0a894b313d646d4e3b0d8b0308b3be5a4c5fa1a8d45e8eb4673983f6',0,'2019-11-15 07:34:29'),('5725d1a3ed446d3df790fb9da7d23f612204462aba62f251d6d4d34d799bb589dabac2b395e2fe06','2cb1a214e2c7307e7f511464a53271cf2e6ea4cef0c066b516c18dd079762350562dac6c7ada1004',0,'2019-12-20 16:50:25'),('573fc60141fa07afe488411423477f88217a972a73068a9ef1c58e6a045bb6929555b7ad2200ab9c','ecfa9a19a0b524e5dccc06320b10c544768c8573fed71ff6ee9b29813b87b4a3b009ef8c87bbd8b2',0,'2019-11-15 17:21:00'),('5780b5051fae0b9608e88c7d4c6cc873e07312a7330e133bd60f3afab8554d39a1f1970c464e9fa1','061694aeed91b01afcae4f08f776a9de485ad93523aa76742cb54da36600de79e697d08154b38f22',0,'2019-12-22 15:17:58'),('5795ec4eeb4fef296d4787c3ca6ad04e98b6a4b1eb2b146733c941ea3b6958569b88f2a7154a007d','5e9d7cc3431f16f3e61ba6fd2168e0cf8552b71d0dc086f194023f464c947303a014736a1acb8fc6',0,'2019-11-10 09:44:22'),('5816a88b7838fe84679f9f93cfc3bec8e8d464321cada29596b3599ee33bbad3caf50dfba114e02f','9ef317aaaa2ca490c9c64e5611d5829fa3f0d25738bf7ff3cf2113db25a5fdb25f55cc233bdc030a',0,'2019-12-13 20:36:16'),('58931e77400379c18d1ad1078ed64e55e4de0c731ff22c97f9d1d1b438fcee43371a65f0ab263b27','d0f3d99ec4566e05082be59a6a74a8419af289b01c66c57b25e91ec41925b79a3ced77b705bb0660',0,'2019-12-11 16:27:10'),('590a1b93c5635aabd82ba8bab52ffef6d8aa9f72675ba624106966721fbcc4d019ea1e9a6e74115c','207c728d9b688cc4b1649ad637f28f4c05754e91b41365ee2e46c31fa82d4ad9e698774555a1fb14',0,'2019-11-18 17:33:11'),('591a838d7c1549b26293b09a0f1204367db325c3f6741b3d0ad612fb848f98e08ed15fddaddfeb9b','affcf7cb92277fdfe9bdcfd0dbda2176340232f6559cc1e30395a1f0b193db6ba92ac828a7d87811',0,'2019-12-15 10:21:36'),('5aee820b5c5f6538b8f477c27edbc3b5bccc8a3d36c5e40308002e230af98e2ec289bf1a4948215e','d6f290377c56752ffe54be3bee8ff8009ec54546e559d496fd95b5e95c2a93d171783bb71f41f20f',0,'2019-12-13 20:11:50'),('5bce99dc99c8dce4f6c50748849bf3660fc750f0b7474ce9334d06381439ae7491eedfaa94cc5c2d','e13a344b4cbc6adeacd11116d442c808b33d1ac1131cfd643cc2bb11245c4d7629708f02ad57e7e0',0,'2019-11-10 09:33:51'),('5cd67339e2dde3642a4eecc21f04e15a7a613ae37780b4b2ce5303f8257c67ff5f725fbd7cd04281','a236fb0cd326903c9306f7a8ae0f94c04270de89e981647ac311c7d1c20c5f4da82355e32239269b',0,'2019-12-12 17:33:27'),('5f02f907864ceee1ca405576859c4f26a03e653d7f7cf4a578e1988207f469cb7dd0131d2660198a','4f3f776333bdda3094b362e21976d206e9a78082008e999c997c91e8f5731a4c653d1f2924d0474a',0,'2019-11-24 13:17:48'),('5f8c341168ef01af398d84b8953f616ece943c99e594816382385884ed4b5c5c21d7882bda96df43','7ae95408c5f6140a417bd11eb6f2e9c33318b44fda857a4d5a0721b3a56a579408a2d0ddbe9939f5',0,'2019-12-20 10:37:59'),('5faefbf539e3e7c6cb0cb1bc96bcf8211eba634f05bc0c4dafc56f3e13944d9d1ca96d2c995c25c2','8919aad1edf92dc47f7ea9bbc9a43890271f9ccbe5c090d7c47b320b6b9b33314be0f021be460e5b',0,'2019-12-24 19:22:04'),('5fbe9c98a345ab0065ab0854ac797ab346a69f52f93ea76ac72887d99f97b03c0980eccbab6d328c','768440144eac9f0d08686e37021e657e549fa5a84e39c438ccffc0923ff7a8550b1849998b762dde',0,'2019-11-09 13:43:26'),('61da4cd2a7f39c24b74f5c689129aef76f9dcae4a81307831c71732f8a5fc7e33ababc02fbfcba01','e135f57cc346d2d43cc202c3aa9d3ac3e56884e15124591794ac59883945d785abf453a6aadc8080',0,'2019-11-16 17:38:51'),('636416b08ae4fa5ad044c713471a773dacaf79516d8ea2c759dba838a8bda0489454935a8a3141c9','0db41d711a504b19602c11340aa2af64133b8a87f24699c94d4e1d809a935d3a2daea28a2e4edf07',0,'2019-11-14 16:30:49'),('647584ef9a70bd102b7b9985181c8a422d10698fc7f18d420c23086b382e631699e4fb368d284424','b7c6a566b9e0e9b689c3aca833d8f678784c9e27b24083684aaf4cf1f5bcda2e56d76c66fdb1fa4d',0,'2019-11-18 21:02:06'),('654f3a9ae61175756e13d9e0284256be4be56dda2feb1a998b5ab6e14267085c30af725e8bb358f9','41dcd78bcd4a25b08642103dcaac843d6d6f69eceafc706ec5ff9b7c1dcbfcdbd3a8a4e4ccad3f54',0,'2019-12-19 15:03:12'),('65a10fcbed01a67ee7b66a0497a8d5baa8f2c8c5b0c118969bbba76c4b019046335f53e26c88e2d2','68bb52e5ccb90182303dd7e787ca202d9ef96136492b8f07e6130cafb38c968d64587b15779c2547',0,'2019-11-16 17:40:31'),('66790624d11ed343aa1996beacc76220b95f28d68d704994cc22a64d093409945811c3eb0280a32c','2bdd6d1244d4b7a689081cf5bbd3f1f0cff33d1f96541d2f48a581da448e5d78c0efdee20f28c5ad',0,'2019-11-17 18:47:48'),('66914e9c0075d8d130f68d78e2c31824603a40d6a46c147455677e847f6a9c98e7f7c05b1032a645','2d0aebbef434a453e9efbf1d8b7b9d81feb8d5c20b3874cdd815f8d85e6720570d332de4cfe0fef2',0,'2019-12-20 10:36:49'),('67f31431099282443a58f61658cce6334bbf20776ff0c666a4fc603098759c9ce4077850a7b8f3f3','5cb17fb39a5068d71400f39afdd924ce5291596cf154bf8e7676aca5d4d934fb7f959c7df49dd8fb',0,'2019-12-21 19:34:45'),('689db366d20772aa4995939e5474635180d167cedf2171acef587d96a0ac455f78c54373a942865c','5cefd77e70e4ce654508425d6c6f4d385cac9ee209cb77d8a8dd3a5abeb215c1972303a67b49670c',0,'2019-12-14 21:05:28'),('6a69982706293e5bc08c7e67aba41e25a14f6ffa10f4b1a9b1680ed85c3ec0165f21c9cd12b6a8b0','a7e85f6aea2600736052d81642f3fe20c7303b8cc17af9fa20870c6bd1c8365c0969e0ba696edd7a',0,'2019-12-14 17:24:50'),('6a9ddbe939c3c94fe7949d3705fcd7b6cfac3743ed7dc894e54da2c15d78e41a77f3d02ab6153bb1','1426b85d6fa4a8ddd7b0e30dc3acbbc5bd563e06160be44d96af5b2a8d1d3cd81ad9c866156900ed',0,'2019-12-14 18:19:26'),('6aa0abcd8e90d66c97675ca7e70a5260c92d832b1315dc03cbbd90efc35572b7ccf03f26b15797c5','829b67567bae9fc24791b04f653503162f60920b65103e1d246466db849528ee7bc00237f1535eae',0,'2019-12-14 20:43:39'),('6b6d4b8b7047906afb3dcf88dc24a0174c5659eb340aa9e2ac12c6740c719eeef3c80f7302da5ac7','e19b6663e827e41b1521d788107a0ec7dbcec670fbc61eaccd10371b275ed52f9acb4545bd5a52a4',0,'2019-11-14 13:21:41'),('6b763236d65bc292fc7980ed599e4d86027b7ecc107077ab1bd0ecaad68115bf90f305512e3c9606','7cb1f8bd809b407adfde1094da52e071a1d2ca19e307547fcbd1aa03dff8653015c73af0b123ec7b',0,'2019-12-14 17:22:36'),('6bf7d3eeef6db03a1e69de52338784c03b713618b1f5ec63f31e93c893f428616b09bfcf7aa2ee10','d780068ec605381e225ecad0ae6eac35da03e44dd4c6522264fb4c7f40eb3f023b7c610bb042e631',0,'2019-12-20 15:24:44'),('6c22e43203140f4bf623ff3391972c223121ff449740252a8dda659d6e8778ce158108ea5a2e0e35','e277f84de768d64e81b99319e6d3f7c2d72bb635e389d7b33487ecb05bfc4a40f87d8d6396dbed15',0,'2019-12-23 19:02:54'),('6c3ea6cabc6d1c12034844afdf80649a7ef3ddd702e44d04153f412f204af867c46c04295aaaf465','8890bea337bce05c27298e3232a5ac7bada66fa1b14d2e2208c5011408b0a2949fee74070ec8fd05',0,'2019-12-11 16:12:57'),('6c58f6330afce4f3501420e5335cca513cbe239a13fea7299d2e846e4439660b42c000484a488c12','40f616bbae00704c49c1492ff94c01decd7fc3ebb9046632db541604cac51b75c170560a028cda98',0,'2019-12-18 15:49:48'),('6d050c5e96e80fad9019a34661469382f7ce904955d0d78bc51a757c7fb6a1cc139e744a62552bf7','11711dfba070d5514e117d3fa596513c63599ed7a6f03c8fbadf333bf5e3b5d10912614f275af470',0,'2019-11-24 12:13:19'),('6d513a14f1f8ef333b3eb13845c01d515037465f278d97e3468d9e999d7b1b44a83c5815dbe24528','0a2d7a68564e2c7b3e50499387153b248026fed8cb6084238f8a1f52d8602c2a4370ef2a0e4d99d4',0,'2019-12-21 12:32:39'),('6ee97e7a4b755d6cbce4b9c802804420b03c6d1283184bb99f91ddfe4f213606b3f148a51555d5bd','130ef66f2dc3112cd789830b2ceba616a63f4ac71daf9cd5fb7dba4162d9dfe84934dd698362448c',0,'2019-11-13 11:16:25'),('6f4d4a7241328946e2b0cc1820a10423dc1bffb7dab26182074cb013d338f351f0845487c8a10920','d5b8fd152abdac34ff69efd6cf7d20801ab551e2576db044322367e3486580c5631302acf63fdc78',0,'2019-11-08 13:38:31'),('71139c4b76df74131fcfad0fafcc8086166ddee99c03eb58641964e6de105344b01edeebe83f83e3','2fa6f3334c40fdd705c431ea489416125b0171d3a220728bde23c748391ed813da4b0fa2f3862ac0',0,'2019-12-13 14:59:47'),('714e4373c2ffad3f972b9f9db36d7812da2b47e59108afd756dba797ab0d32c5d63ca22e559d80b0','47ff0a7d617ed3d41723c58c3e1f727935551a76eacaad9f24f05860caa7195573ceecfac90b6a68',0,'2019-11-24 12:18:05'),('7184b8e363df6c7e2e7ddf7587b8769e269c89f47d7d6a3206f8e4d6053ea1b85b9c9d6deef86229','4068cfb47071b5a2fe0d50b31fcf8d9f0f8c10312f6a6e27d30def46544b628aadbfec7f620cec9c',0,'2019-12-22 10:44:59'),('7257d96c1aac51104ac2748045e94c078be42dd264a0fd686f5f717dc8c849140dd30eb84bc3adb5','ab58bed8e055e7e24b3b8f1fa8f11d4f60cb54c92be76d1cb32776cbfa4bde28fa55d4c91fbcfb3f',0,'2019-12-15 10:50:03'),('72de995a18a06a7c20d442ccf39e0757a05af31da4e5d355f0f3af65227d5093a7f7d79ee9b5df83','d039d9943df82240503f5bb37a30ce302d927a1e434b2930a623637b7a2bb2dbabb2bf6727837ab3',0,'2019-12-19 14:09:50'),('73bbe497a633e603d50da9b66c224af49d6e9083f7d238a5c954e28e12aab26fd73832cae10b824a','51c2983561ab5b63ee5f1c25b14ca893648c50f48a4386334e2fca4c5a2364a16ffe21d50d2cc105',0,'2019-11-20 12:55:28'),('746400948960cde113b2c15d71313471de42ca3f312564500d66ef88c6eac24c28f88dffd61d44f2','b65d87cd510999d54081face739468531b4d0c1a82a85c8deb9db447488a487cc56f20a4ebbda4b1',0,'2019-11-10 09:36:36'),('747bec207400cb5ab0c0435d6e75f02b8097a0d2a3a62a582f27ddef7c92f11f139803002500beec','60196ffc3d58d0c2fbbcda6b7a3201edf837eebddbbf223117b1b975d1d38fb3ff9bc99624152ba7',0,'2019-12-24 15:45:19'),('75a0a2a35b0df3308e5cbcadbe66b0a9a93371bfd89421bf9a14cc01c0113fa97f7a78caca13e64d','f5c84a5052f8b8b9daebf4af6251066c1199a52ece38019cb03c09ce4598c3bf2490f54cead74a37',0,'2019-12-24 19:20:37'),('75f408f9d2986b2d665a64d43cc6075bea8c8ad984e676615c62e9acade0570af6a36cd555fbfe5a','17d28e7e130307e12ed64ea3d658f1b7b34a58d9696a40c43f89bfc3c73e5d3c79fb01298fcaf5a1',0,'2019-11-24 13:07:09'),('7632096209ae6ae091f0be163bf8abd8b04fefe68bace9fb017e59f47c753c88b6d722e99fb22fdc','865df97cb2cf1eca36d74e87da1740f9db28d99a70480e2b30a7577d362f20c8b3e724a687e3819b',0,'2019-12-22 10:32:00'),('777bdf377fe613a08fecb00aeb2fca45b0127bfce500047ba467a2d9f5640d573e37e17b51fb05e3','52022168a6b1036529846cc2bf48310b90a744dcf0f93d6df69370e86ee9370c0dc3defd037c0fe3',0,'2019-12-19 20:54:58'),('77bf3ef2df22e429ea7bce1f3e0bf0eef7be8779e101a5d56acfb5c08ea9b30f5515eb07f0f8b407','793db8028d7c188a2353f724f13a42953f72ae11d8fab6af39c60c4cb869b5a1c7a6485315a12d2b',0,'2019-11-10 09:47:36'),('787566e4feb20ca6fae6a3383f00dda15a3ef0c48ff1c7d5f4cfd115977637febb4a42ba5ab4074b','117f10db3d2a6b57a11e748465d71ff6c26bb6d43188d2b1e832371d8dc946561ab5c0bf4661b450',0,'2019-11-16 12:22:51'),('79972a598df9be6c6ee916d1196d59e12e402961921112be81ddf25370b39d056d987cba2a4f8dbc','b9a3d3dede15d982a665509928bea2df1813ac6eac3224b98b7258236297b817e6b9de66cce39052',0,'2019-11-15 11:44:28'),('7a95445504b493f588c494d959657eca9586f8486f01cb104b6b2c0ed69ce0e2ff3b339e8a3510ed','16be0e0690309d95e810c262143b627d80cc53b8593da935c1d808c571ddf8ad05fa46846d6dbf3d',0,'2019-11-09 13:44:46'),('7b22e841b04239fc862f714c27e17616b680907e18498dfe136ec7d4d1d79909053cf75685b0ec0e','841e3b9df27a4c64951f308258fa4b49f95d731f763d2de0fb8a13660db24cf1c666eb268d0dd37d',0,'2019-12-12 18:54:58'),('7b65ba1bd8ac5586998479e019f9a82b8a07b6e4867c836614d9fe6e5165598d809b237b09f67aef','6300fb9cfd040755da5cbc7a5397a7d5fdb14eed16048b551e51e27fc51cdb988ba531895d635ece',0,'2019-12-18 07:06:54'),('7b74088f74f138a3986f6c3e2a5770bcf62dda482ed67cf952f754e65bf3f22b11f792a115d58da7','77ed50112d1e85217a0eb13b102d9ebb7e4e7bef81d3401825648426cb0ea937ad734e0f67ac942d',0,'2019-11-10 08:42:29'),('7c153f9453e51bbcff42ec46a8fd3e4d75b054da61d4078c9cbcd546bde5472183ead24ea04a830d','7b2e9ba5c0b80448e2c703997c9755b29510c4cc6c449f330d7ee95f380d8a06d2f5a70ad1aa02a1',0,'2019-11-10 15:29:46'),('7c33d5d4361d98e733bb521da733b9426ed463c0861ff5bdef34224c62c7f21cdb7cb67ced105383','a567f533c2731bcb6ee8807c03c12f2acb05ca3c74dfe2ac226daeb60a78f43de789d0b1ec28a9c5',0,'2019-11-13 10:48:56'),('7c49e6003526380e7e5e6a5bb17305832bcd39cf89a4f2a149b8082281902c17257bf84eea119f51','c7b2bfe638d5966d3c6903e8fd259236e81d04b60d3085f73fdacffdea65a503c7a87416596cbb0b',0,'2019-12-23 16:16:34'),('7c8df6141d3a37afcd369d19acfef001ae7645ff43b5343d514a25ffa534b31a9f175cb4edeb9f7c','c962ee34a41edd9ac3b69530122b64f5f3631054ffc8fe9f355abc185205ed6b34292cea9600d23f',0,'2019-11-19 10:07:29'),('7cc82a10743d924ec38d283959fd8f3d0f9a21efdd3ab7d0e0f41857994ff91da80823038e4dfa9c','368df5dc8704aa08ad1226bfdb40c308af1171b0c2f6e7d3ee0a185967b8f1a5a6bedda42d69820f',0,'2019-11-10 08:50:09'),('7cfd898e7d11f6f7adf55ff3cda8cac9e8a6e6ea6aaf879aa0d2a684258d516b8879dbdd2dfd8cd0','f92a0d2fa95adb66d2109b605c0d5a3e6e2d3ac19f277a95da2131d15b88edd407c5f9430a236655',0,'2019-11-10 15:16:59'),('7d2518eea6bd35290f417770d1f0931317cbffe75f6e6f9824f2768cb4fec493ad9cdb4c7125695d','caa45cff50fca91ce18ea072d8c9b795eead8ffafa907027a8b7c484324eb6524c3ef3f9d044d074',0,'2019-12-23 10:50:06'),('7fa845c806b3e730e6f4c01c20691f5e5eba9c3d6b59813836491b41e28909492e608e4878c068ab','69b2289d41c54c9b5ac7c1fa5247c7d7de2e98415eaf0f17f440e4007aa76773602084fdba022dff',0,'2019-11-10 13:31:13'),('80a500f58e4b5a05445d58a37d4a8c2d66b20fad84516f6c026ed1f6f8a7ec1b0d49d1d3cff84859','2858ca0e08fc7fee37d2fa94fcc6e061c8fd44e0e91180107f06bf5d086e662bc56e9d942d36fb98',0,'2019-12-20 20:17:40'),('81b9cea2c5c6d822fcbe7c4a5c5de9721cf3346ae0bd1372c1ee3dc39e0f8789ce1312a747f28dae','9e8e28aec5c579afd9700f7905164628aca96da7204051617f24a31bddb89cc1c30e8a7cb85055a1',0,'2019-11-09 09:26:14'),('81faaac91287040aab70ea1b3c5e41099d5bb8bc5072d805381cbbdcaeec233d7931b48f4d301c80','8c8aa59650fccf2f417804b1ab085e9f1dcb1011085cedd81793242d959af00302bdd6b4fee14e19',0,'2019-12-24 19:18:07'),('8252c4139cc78041094f069b0bde1f33112e9a47d38e6d0e28c9c3bcb0eb34252b8e5ca8ffee351f','fda8e2b7b60695fca8fe533875119ce3c7e2c35c1f0babd94aead42e7570dba29da5827bf9cc76d9',0,'2019-12-12 15:58:11'),('82e33f1d843e4b2861cf09417de0dea78102a832a058f4340c7b76759b62ca29ce762fb4824cfe82','4a85aa61ea9a4c6fb6f30ebd1a1366cc315d4b766e8410166db5fea56b53b03fbc525011104b82b0',0,'2019-11-09 13:17:56'),('82e3e3301475ff263b0546d0d7efc4daaf46d64daa27a1352b1e1f1b128a3c9466f5bb84d95d997b','2bedb7c3a3efbc836a68b0f363e8d35dfcb12f30c4f57c6dbc235e1d6b0b58cbe3e8ed99070b3ac7',0,'2019-11-17 14:38:14'),('831324fe49f17fb4f0be1d3ef6db3312e2b29a88186dfa9abcb5fce403e825066e15c2c745d2a326','2c419587d527edb63df7ed24d627e2abaa9e158d3acbfaf007a151ca938ce306c58f3ceaea2722e3',0,'2019-11-10 14:06:03'),('8393a2a5314a4c099c1cfe1eac0222374a1efd7d950ae76d9ff9c112b45037019bb223a0931a0837','21121f52672de93cd6abb9a7e7c8214dd54fb743d33e334d9688b65422b1f7afd4b82f883db9e3b6',0,'2019-12-14 21:04:38'),('841f73b905de21c211ee63b8c0d7f8a617ed36f0b43cc2ae8dd1329bf3ca2f7739d8c69916a2cea5','58063a3f48cd1af54d9d765bfd35c24718d3faf5908e8bca6012627d8014f9c631f1dec682dd90bb',0,'2019-12-15 15:50:34'),('861286272518ab747445cf5b7f5cf2d80760f721b054f72723c8f1287c6e78d528df98e00317f666','98c288ee9712c1ac0b1fc75e590b71cca5f2c0c1b2254056cac3738f9aedb05a176245fed712fa3f',0,'2019-12-13 19:35:47'),('86b5821ed996d634c1b202627b5b2217c885ad5bedc400310de90de6afd8b394a4f60d3821d197cb','044428d4f430f5eb8d20330f167688c1a80001a0aa94189b9ddf6326ca33509290573bfd8b3799dd',0,'2019-11-08 13:21:47'),('8755e3c816f74bce88b3850aba6a2404bbdcfecb9a780fa8f999e7f79c141e2d5d0d7ef45a35fc33','36e9d59f6e96ce9c8ca8d32de1f7991cfb30cb5aff8471db20a627acc7fb1eddb65901e50e071d40',0,'2019-12-12 17:31:29'),('87864372d575a304435c5b0387d6537483dd26f23de62d04bd3d15627c68347a1f53b8494eba67d5','07d19a34d1986ced16f74f05289fb1d351cb93e28d76b9519ca4cdd684075a7812a0c69bee895c57',0,'2019-12-21 07:54:06'),('882789679c235d1a166608dbfa30a09c878b58823d70c3a320bdd9564eff67e0135230c3e8aa4b7f','03b92e71df5e1c9334d1e61f4c9f974214a941dbbbd0e95c956cf8e3795143fd2497e52717ff5220',0,'2019-12-24 18:11:38'),('89d88a2ad8989d967b1d87dcb0d134e4836053a15fffa28e36598829a333c478c1851e87df7ad7ee','432a3766e31fdb252c3aa2d90a071906acb447fdbea717ccd68789433627688bc77e8e5d97ec3cf5',0,'2019-12-24 13:45:42'),('8bfa268fc9b45846f385932459b88cb8bb8bed4a6c780b53764ad098a725ef9d60c4864769f25153','5f624309a701acc4ecd168978fcf79d30d3715570e6be3c1d765009154b54b8f9731bd04122ce116',0,'2019-11-27 11:42:01'),('8c6e643f81b3f2d0be6f3ec3e61eb14b1d43c1f8297fa37c27dbc37e05d501b62cb87f6f2ebb6386','ecb9c32f5ae163adf6f3ebce276e2b88d9143c5bd1b71d91f4d65b26d91d6ebb6c4711a647edfbf8',0,'2019-12-12 15:35:04'),('8d1b7523e78723710b80378404abd40660bbee3bb5ff6cefe2e34b70bb41ce4e8a7d5deb18dec8af','1cc3b1d2c5e64176b77f836041bd8d7701421ba959b686c3eab43a5da23db8c10e0718df2fb9684e',0,'2019-11-09 11:31:54'),('8deadf7d7da4ecfee4cf36bc24fe4c6b48aef7720161ff25606386cd25fdf2bd5bf7a71ec9eebcce','0dc74f8269ca6cbefa3c26ea6c74d699af580883ad6b8784f8e81b4f48973e903e4c279c4d7e4311',0,'2019-12-13 12:19:37'),('8e8698e45b59eb0a2a66db5c86ee7c8e8cdea8c4e4895b953a8ab28505967bb2e4021505d02384f5','7d75659c9ab2327dbacf99e098023d48d0102087b61579130b03b37f0f1c439b0b3ff014fe67d765',0,'2019-11-10 13:35:38'),('8f7f3f8323580692cb1693c768fae35273a9292497bf5275d316fec2d77d159aa24af252af8070b1','26df9584f12f5d8084a9cca73cb8692eddac1273bbb57cd0ea710080bf526155c253d41d3d6f2a30',0,'2019-12-24 18:31:35'),('903c6358e794b8bccd16fc72c6c1b40ff0722de339efdb98b9501052eb7be123825e41eae694b258','f7f140d8d43a3541e3243d1a897ddb9ad89888ce061923cb23617257ce67403b64cbccdc17ec027c',0,'2019-11-17 16:01:14'),('90ee2f8569f5889ab5fb8559db334b721cd2a190398c02e30ec360158fd4274d51741cafc3502897','c790967af09a87baaf8522aadd4a7f820a3e34837dcbbf943b4048c8aacb421b9576ea0d346123bd',0,'2019-12-14 18:25:58'),('92403fac1de3b918300bcd0309bda10e633ef84261c79460aed253a04a317dd4b815e471277a5e35','c215601d1f646bced1a6267249934fd395c17fafa7f84b13b1996b5ea2ddd34548b13cfa473ef4f6',0,'2019-12-24 18:21:49'),('92fe556395f354d1f2f792bc2ff736eecb4ee64cc2d7c60884a3cc303e467f2467992bc05687c7fa','acda827185643bfba4c9f9aa38a4205bf432e202c918ebe530e5ef3b630beeed674050c27c781f2d',0,'2019-12-18 14:34:32'),('9395ba0479790e0f083d4bd0658437cce599a148b07d144cd81a94ac7d805a3b42fb833297af0262','75d9f94538a8efbbf8d153e37614c868e59a7358005a66296beee3bfc368e473a9a3cb96ead310bb',0,'2019-12-13 14:27:03'),('948faff87e48af46bf6018a31004894eff0f49b495f4d5972128c79a532d33c26f20829db5bd0b53','06504a5b553644c1773bcba4aaa9746e165c3e23895056942ea41c0a88fbb30e3b36ca1e367879bf',0,'2019-12-24 17:57:55'),('94e1fcf732536ac2aec25da0fe82420d0a2cc79107bdd46419f580e54a727dc2a03250709ec66b30','b01ca4a96474c0e8133abb65cf7271a07526a37a194654ef38c8f966923674ddf32751ff9da37ee2',0,'2019-11-18 21:00:50'),('95676de75496264c782d39e1b8913d92b91fe9a6cb404c1198e3c7a03550ff39b5afad506b6804af','ec623feb01bac74393363a3c50878baf9d5c58ac6a720c28c88f7f2406a790939ca1379c40ced9bb',0,'2019-12-22 22:54:51'),('9714967f8274f4ac9c26f5976ecf301f4b228250d72238404f0d41184e647dd25e8aa1a444accd70','e4864d99032e6417c0240b9e1daef7f4c3cd22fb49f3417ea7045525df5009de113b0e9ce4cfef80',0,'2019-12-20 20:10:41'),('978349b12606450c1388bba6f44ef8a6efcbeb5ede577d04655eb1b8b4e0f8dae0b924cbe7b38cbf','62a9d71ab15a61950fca2bd6d5b3cf5458b3b36ae9ec71d9b4a1f3b347873479dec4e9bc692b10a3',0,'2019-12-14 15:36:08'),('97bcb97cf8c60c051030055bf575e655d1b2bd4ceb65b56ceda0b78b35cf2cdc54b792a61dc304c3','f36f7a7590886295ddca4ec980fffa85bad05d713c2ec932654092d994cfca0c305b6dec29974a9c',0,'2019-11-10 09:06:32'),('982f6afb95fa2508e1591213e2d922ca9f0e8d79de66f7860715082fb47f82727ca7d25ed0279cc7','026571704d356dde3b711dc15a8404a6b7d3afa01c18d3c16df540b77a5d418b8d78eda289b4c178',0,'2019-11-17 08:50:03'),('996092cdc46f651fda71ab1e340c13f02e2309c3d6ca7aa79d4687df27c4d667363b25452884a3c9','140f76d7db14512664fdcd216ba649ea898362436c3b16d91cd78bd0b462cf071fb3d5a3384f245c',0,'2019-12-24 18:50:19'),('9963143d42a97c539aa5d8b65b4ca8ea36e01584e5e8bc0dedd1d20bc4130a2e9be364492b6dae04','cbd92010f2651823a1f769aa46e950a1740590fdda03bd62f5ca5a060aeb3eed7c9dc00778a46caa',0,'2019-11-16 08:28:19'),('9bd16234fe22050786a63deac2e9875a5b2cbd845366396adca71a64f11c68fecbecb32ccc4b4ee3','fa4282f29e02f7f7e031bc5a050ad766c9992175834ae51f1b6dfb985e86a63dc5cecd9fd3867c74',0,'2019-12-21 12:37:25'),('9c71816fbf730c53d70479dd6244091d879b763a228effd72a125df43f0f1277009278a44c929d2b','607992ec4e48830f7eaa5d7155a8582f9fc9111335a8d408abc5cf81609c689d703fad4713dcf83d',0,'2019-11-17 18:57:26'),('9d85a19bc67bd0638722233acebe1a0421aa17e1be3586ec3253b971fad7c558b6774dee6b6dad1a','c02a2af6adbddd3ff48eca4d923d0a6b6943fb22dab487e478b21d252b05c75bc4c52b0ff1b36367',0,'2019-12-11 12:08:13'),('9dd474d262128d9799d61c637e42ff40c61739f8adabd8f5146f33448cdca171927e61cef3033a10','d2c465709e98cd73d3d71dbaf2ac432cf9b5e3c3753735236867b9099a54a15b25e483e26231d72f',0,'2019-12-24 14:52:53'),('9dedb98d103ca8147ae02df828085e4fe0c58e8eee0a3899553fdf31a2894dc2ed591ee46b1a843d','bc58d6b2d6065e4611a22a9c59dfda3ad3af3fd480672c75ad1d148e80fadd570e632ce7d0c32d22',0,'2019-11-08 13:10:36'),('9e97314af5f9c3b7ffbab54719c9224216a6787e00b22dce95b1589b682e91cb01c0afd830af3631','a1bf61125932151059023977dd8e4b82688fe9e7b0461edd1a11c59930e257f08f6f13014e5f369c',0,'2019-12-12 03:21:01'),('9ea3ccb7a165ed42448e4069a85cf2962b1709f9a5c1dda889069cbe3b3aa1e6b5f3edd915f8a421','4caae9e4096b041f3c48b46648552ed55462661569a789b90110c88f59a8b7b0afe26d164bc43e24',0,'2019-11-10 09:45:49'),('a058bcb7a33356db8ccbe0211026c52b2eff57afff5a2a96584bf7a97ae80bf1cdaa133cd1f5efba','88f5e8ec3e677fac10dbf13ca729357f3a91b922bd708e2ffb3d55d72132d5ee071e45e2e1b9332b',0,'2019-12-18 14:55:22'),('a068c3c4db016f1e619a2578d83abccf70c259c582cefb224d4e071578be65870c3a1aff045ed146','cd58826836c94068b7e30d579ea633a01547db9bb9b29d938e751cfa2bbf4a32ae554d376d112f21',0,'2019-11-15 16:55:19'),('a0c742f70b34a868c154927f97512c705da286065c05450793b166e3e8a7464ec2e09c96d54c6e4b','d8a3dbea23d7cc9c224d01c6c43c0f68b2ff0f83f7b6046ed159add5f4a550aa44b9ca6c13fde3a9',0,'2019-12-14 20:30:05'),('a1ba8da8b3df006f05c482f6c38dfc6d62cbb4b4f92680dd3816f173f1e29523e2e62eb1b90d7523','811299c9da7b9f13351ba7f96d3af8eafdeab198c4c27546d6be9983624e12cd8761050001c33b0c',0,'2019-11-12 10:18:35'),('a1ce811104850375e162a16dc4be690847190f7da72f571119fb990349c9f9b1acb9a52a8cb4b075','20a460058f252cbec80891e9f2f9bab12a3b898395e188404739249f84b9ebaf18c6be1b03b95ebf',0,'2019-11-17 19:20:36'),('a27226c4f7a4177b0b63de5151efb43cf7b6abad4189514d869786eb768d7616f09ea985514951c4','c362850cc5426b0bd1d880272129a2a755b11f86aee1128b01ee0cced4577113466954e6196d1325',0,'2019-12-20 13:32:10'),('a2c3bfc535e23c6e3f263096c866fde81773db5b45f9c1cb16fe05c798bdb78fdffef6dc75c01744','643c6c87360a6aef123c948321df3b7f4c0695943c32f157c4c05363ae4c09f84704afc3d2dd3e78',0,'2019-11-17 19:18:40'),('a2dc3abf6034d235f6d2d141516ea94eba307335bd82f2e6cc250eeffa37656de3a3cd308c16b02c','857bb80365bbf81310344a61337b4ab11c7b3c57c79668ae18c4a0ba15607cf6a1e1ff9d9d680d35',0,'2019-11-10 09:15:12'),('a38e91e09af811b90693dbf0845e17ef4daa8638a6f96988d0dffd876c87e900079c2b7a32dbfeab','0960a191f47f8319fd8aaf99b52460fc923a8444eeb4c558fe7a997683effc652765160625150087',0,'2019-11-10 15:23:24'),('a5ad6aab1719738e478a0181b558ff29b629a0ce79fe461278643c76d1202e7c59f345c9f876411b','eb7e8f1be2e93963707625c1ad686518ce9185b8ba67a1764052856c71857efeb9c18d577e3241dc',0,'2019-11-13 11:06:54'),('a5c16b3a0ce452438d43620a7fb7b58d91740c1592fe2d29d9404eaa8d54fb9ea3f4e451ac322f65','ec49f3de4f5dfaaf8e21d538ef4f617a4586a7eeaca213f9fe3c3e12e78596ffe10982f0eb29b3d7',0,'2019-11-23 14:07:52'),('a5c8c8473ac5c3ac42d97d3b64bfbd46827356b4054650f6ac8e874534f12a4c0b318c4909d93610','6fdb4ea8305229e81ba43cbeab9317f749d24523c3d4a6af1775b2496534d6b7c98feb46215e35c3',0,'2019-11-17 18:53:15'),('a5e336d9d8f365bf6f81ef599d09ef9c2b89580007cdcb7db3cccb5c04ca79b4a17a2558f967f211','1fe56b93348f460cb353eb3170956735877cdf73947d59f6fd5e889285b3ad9d60d93447488b1524',0,'2019-12-18 12:16:35'),('a5ecac0578173859e5b248b4bc70cff8aef59b7786b5d7530770afdd958b3098d149399d26393416','546a5753a5b53ecda452a30285fe2fe346af68e7379abec00d5491712b2c297f7c4b92fdf391c138',0,'2019-12-18 14:22:23'),('a5f6c99d09d22dd777b8810ee7ab16099722601b551569fa852920d8c11b4dd1d993acc98fe4a6ac','421db67884b17c81a28b20424d178a3f580e965d8481b2b91d899f0b1fb700d10583158197979acc',0,'2019-11-10 09:07:36'),('a696b74438af75256db3c2168bef0daddf0929707797417024b7cc2b38da4b6eaa478eaaf396e3ff','f819614057fd2b9b0091b16984767fe86091a7206117561c756a8b636059d5234fb17e441fb24e12',0,'2019-11-24 11:59:23'),('a815b80fc45b44b6757ab62319b76a2185da03e7fa6f99cb08cd1bf247788e7ee34d3b91c9513f41','92dd95ca85b4683990bf52836a500655c13537ad8a0b22b3d5fcd6ca2966aeeeac03e22e0b794df4',0,'2019-11-09 13:49:43'),('a872d1cf6539cfd16c842b0a9fdb19c8021c72abd6afb4b8b5ef74d52a329beb3b1b327142afed01','0bda358503e2706cb7657920f50ef5bd049490357b70570cf9233f06a174d21ea666d060e8be8278',0,'2019-11-17 19:00:46'),('a99014448200ada1c8336f1546bbd369f4f76bd2a07cbabad0dbd48c2e7c925c9fd04c3e361173a4','8ca85ef30190ec8a00a79d7f680a0cea36497549e69a7ac6dc05b9f551eac38e5f65f64c55927297',0,'2019-12-22 17:56:41'),('a996e5026eec8785a6687378143fe67a6b760e5788cb9dda8c9b0a415741961fe4aac0c915f002fb','6c90a6e8b0aba155f785cef867d0d316124fa9f94ca98b03fd215dd39d3fbd0f95508f096186189d',0,'2019-11-10 09:54:48'),('aa09c297b33c9e5f64f761b27454fbc177e845a741117b41244ba6076f3aee9cbf83108069daf85a','98a515523a62a6c20134fb03709c7d3755cabb2e579807dbbd69bc5247d2dcc048a504242d2e9a17',0,'2019-12-22 22:53:51'),('abfb53e1d027e7a24493cfb1f41065afe52ec0c1f4344b6d7a4b2c15b375c3c85053c79d9ccd35cf','4e7ae6ef1c249508fd1fb2c2c11e118c7000544e9b0521d2d3a3f332fd719117be10861ced3a26a4',0,'2019-11-10 15:18:30'),('ac360e5398caa160943832326b7a75d7798199a1aaca2c02e57c77994c8d3569ca951166686ff1b5','5927f9ee0190428c67e3ba069d30d4a02882940b5109dbb16fb17cc7aa81104978466b2bb64c2179',0,'2019-12-18 12:17:26'),('ad87de3a39611a78499a1d378e04580a56eb4ec3e94db48c137d6f59ffc9aa8371ffc4d1e2433a34','0df5f8e0c24a47937926e53d64c6659d6a9a87f757664ebb8c47b969e0346155d1e9fd0473de45cd',0,'2019-12-18 13:52:44'),('ae4b73a73f95595f5b67ff14c4fbe9776defad2d8a6d1ceff1ed08e91bc6be39f2e3146cfa0fc8b6','bf6ca7056d2996a4a1f94131179ec1c291fee9b2707a21fb59eeec0184c91dc7646e59824b28b807',0,'2019-12-20 13:37:30'),('ae695b6cf2e309a3bfb81c175968f79525900d8f9cd8840990f7396cd2eaf8ced24b155cc2ace414','c9dbaa5889fe66744b47709ba78235c8ce1ab1c0331fd1b4e4d78adc92f111b1a668bae09b8dd908',0,'2019-12-18 07:03:59'),('ae87c26a8ae3515a14a1addbb0d88add4c0a16547d52e829daace50f6ec714e7c407a2ce4fca7494','b3c520000e2f7c7c816891e67b0bc0a0c629d0ee8fb802c1fe53d9294704aeb5190d7ebcd3045844',0,'2019-12-23 11:14:52'),('af384e7094cb81162ebab8da0e02705d12ee8d056ad50bd27691404310192754c6909cf6a5c82fca','2ea025511aba7445cbf81e0b49727b10f37a2b510005529200de7a7933f3b9158d8004c8a428360a',0,'2019-11-08 16:30:36'),('b0c4fd54f8f4e1a227c82a985b7ee2c78d4d7ef5b1276af498ec8ed660e4eafc40cfa5611d7a2141','081970d72cd0d6d7fffe42ed6e3370c9dd243aaaf3503e3ffc2f3c5cda63e82e75388608a2e35181',0,'2019-12-14 21:08:43'),('b2108ee9e7ff1c3c6c39c59b46d923ed52ef8a71e004f5d70aa15d4d52982524bf5b3a7dc1d980ee','365136544aea0a745fd5111749ccd345ea12a86d5c914726cfc21fb2cc08d0d291d0ad2b29466727',0,'2019-12-12 01:55:33'),('b2ddb3fcb1118e06af2c413cdb2fd8f58431c4af1ed5103571a3e8ecc71f8df1f7e2324ea9a91384','12a2bc9cdc8842a67074db43b0601b39232376f92223387ee4e3f1c6732ecc6774b5de6078c3dfb3',0,'2019-12-18 13:54:12'),('b32afa903cef1429cf672de7323f5fda9283a289a4974c6abe5d68438b339cb25f6e2b42ec4c076f','dac80372d6373d0712677de48e0dae73db3b6a6b0cb16cdc6197bfec2bc27b45c37bda11d1549a25',0,'2019-11-10 11:33:52'),('b349b18a507f113dbce32abcbf5e273b265e7e1ec39fa544a45226e083fd31d2b83b590d23389f3f','8c0f0d3a5a1c3a519dc525a551dd117b959bbc7fcf6dc47df4ed38868501fe33500299ea676b3fc3',0,'2019-12-22 16:49:47'),('b433ae9fcefb1d7a555c69db58f620c5fa193b3da4e1994f6a57b2db5de372be9fb303219e1f65a8','5a172ec0a32ddc4a0009fcd28f6d3a752779d5c996a3eea221d216ff1e49bfb8ffaad9f6ddf71a31',0,'2019-12-07 17:06:44'),('b4a63ccc01d3702c460b4878f24f540df327c3720b55ac94743c4dc4a6b662b3cd11a2b0322df4fd','b7c0b5c3574f470f6997bd2448816233c41a101125b298ec0f78db488f125fddf2347b577f2875c7',0,'2019-12-19 18:29:05'),('b4c3d624b642549ac9182aabe24822afbd54972ec374b827f15e5ebdadbd8c0848627d635375f888','8aaf081199d39e8196d7f59573aaf28cd636cf608f1c63d26f2de14e8ed04f7c5bfebe98a078d7b3',0,'2019-12-18 13:52:12'),('b4ede6b05801d0dc8145f9c51b1f7bdb049680a8c89a322cc86ea20909c225b8771f156127940f2c','d2866765bd74445116060fa63e66f6bb149342092a4d25a6c54788c007ebb476e81a37cb7b8c4af1',0,'2019-12-13 11:00:09'),('b53854d4ead09339e1a3b025b72a52e306b266735c23703096dc30bf298144e0fff0b8a094989136','acf27520d021e7502df1a5e0909589a581764deeba17ce3f2de5cba903986b711cb6098ab9dea7df',0,'2019-12-22 17:57:30'),('b54a0c6fd9c5dc727fe248de0dff786cb0977530cdce0752095def829aa15bccce708005e9462e7b','17d2fac60b51fc4b5eda133b3d58a086415e953ec2b6847d2518f5210bfe9de7e2a8f387ed22ef58',0,'2019-12-23 10:33:19'),('b5d5afa6886982e2b568dab71a980207a0bac097476d758f08715321b3cd92b5701bc2e285dd7a59','6ea9feb06392bbd6d0168216703f96085fcc6ff3ba82a8f6c7d4d5961890ea5f80d26d793d062314',0,'2019-11-14 15:40:01'),('b648f8bfc4ecc5c3cadc44c2799205597efaa2ef4fc0c2caa126327919dda114146132133403bf1d','44bdf4bc667bc3e5b32dc94c8d92f3c11f175876e5fe24348e79c97ef73d43b3b9d0987f5cbe8eac',0,'2019-12-24 18:14:58'),('b685220689db71e0ca2a89ffa2f7abe820219e4de6f4a327fb6abe09e138bd7124e441840382c721','9dfce55ab631097595bd7c5b590aba160f64dbf8e7198cf21106db34e0f230b646d501bef18fdf5e',0,'2019-12-24 16:05:33'),('b6cb5cc649be9954abddfbcb0adb8250f587674627ff3f0bacfc1adad27504effcc07a9a38ba13a5','b0daa263b24620621e38e31d518e5b3d0cf7ce17ebfa20607d7b9c5e28f95ecdea6d1d2e29a0aa72',0,'2019-11-10 08:44:07'),('b97413a20fcb0bd15c716cda6766827f832cb925adb0d21d1615f0db9645b3527b00e6ec02cc1aa6','68c6ccd16126907640eadb6c102416d6a8738826eba3776dadce30f8bebfee0b46999b7a690ae83a',0,'2019-11-10 12:49:58'),('b9ae896713d797e0e5224a206ef69ea20b35f07b9402a5e3d9225d15b2ccca5157ca71db03a51173','984f882ce1a2cd0989a60deef9b7b2823b16a5e8472793682f7577205ee02730c6836621fd58953e',0,'2019-12-19 14:10:49'),('ba2894b752e804d73b249c111b16a5776176ec34e4670ea782edacbba00b2530477f607c6b36136e','2dab2a11b16bd4e7e42fb9907acec746838e5b4d472a6662b9662313246a3e15aad6b701b46bc809',0,'2019-12-12 16:45:17'),('baaf4f5976a2f8671f68026f901ae44b5024fd757141897b4671184a3dc5c142d942b984bfae4428','2a518db27c0e8382cc4bf5b5f32aebef0a017566b089ba1117c33cf4f39198469e18e7922f1a41c5',0,'2019-12-14 17:11:17'),('bb5c144bc7f69577cdeffe156b2f6ab24b50ac76c69ac3cd0d48d6485eaaba89872a80bc7c3a841a','b83108b0d0ea2aac34da94e080f81856a50be7817552be1f16b4c5097cccac8dbac17aae0d104428',0,'2019-12-12 01:44:12'),('bc0f0906901d27e3d1f70c8b30ad6054711cff9759ad75174e218f3a273c006a19ecb5f55fd56a73','c7a4c56dbf0be08bff0471e08e73df385113eddeb5f6c0b8937c0ef56ae106eb3f0a7a8bb324c2c3',0,'2019-12-10 00:35:02'),('bc652f9710e9fef02a1a063b86fee5414505bd2939a0268738c5cef2c4fd7414c04fc6eadc15adbb','1bb0622f8b7f2e9a17325d5b56c4d93a5de584e7f76a6fdcb7ab48ec341293b9f98f1d9c6a514a4a',0,'2019-12-15 15:46:34'),('bd8a2cf2b1c9e050a781dbf1429f9c04039ca4ac7ec6fde266b5f7976a6079d2e53d5d5e86d27ffc','1d215395933b2dac2a9f0470ed05afe4f13d7e49e06946f63f4bcc31317c26b0e5e69241562dba5b',0,'2019-12-23 11:13:59'),('bdcdce8a7f235e7adb6525a5f08cc9d5c1d484871b6ec72f993fde0eab574beee1505a589033442b','e023e9ab359901f8371b4c9c0d0df03ed6655934e1c6af978a28f1aa5d7be7d0a8d597e4d13bb6be',0,'2019-12-24 19:19:28'),('be28edab1b1c98eb5c73cd61c48f283335c7c12803f4c037010699fda314ce7f28ae24ef4b0dfbaf','1a951890c0d756b31e6233ecaddd5538b29a96517fa974537addaad39f002548c14b013b0839dcf0',0,'2019-12-19 14:13:48'),('be51ef8f35540b109f5821a102a19f898f71b12ea1be54b909aa23dbe3bca5d7c36eb7896ea30d69','d431f74e42c7b31956ca256df2d05ebaedd0bcc12ac54cf0ac2b3f358f21d9071af1eced2aac497d',0,'2019-11-10 09:37:32'),('bef606aa9a8e87919b273dfdac5e36b2ae112ccc63d097609456ef9de983854a8599b917a2767724','7d16e9b21fa3863483b9ac17aeb7788d68a71dc38406273ac415abd31a9a85311e9072b94b8eb813',0,'2019-12-24 18:03:36'),('bf57835c256ac805f8b45ebc558bf69035968f67a2601e832eb8a62ce4b828353d23b1f5fc98cdb1','00fb39e05466dffb957825001fb28caf5a627281b2308553d1608ff304183ad0a6012e823e3a22c5',0,'2019-11-17 18:50:29'),('bfa1f02549c2aa4ee14de37f7eede53311f7afa0e901ad6612ab23dd94c14215835c3b8bdcb34ac9','2121159f7987012451a62e0d0ee16e42454a071e9c8e81e36d4be22c8d120f0440adca9c2210924c',0,'2019-11-10 15:34:01'),('c2818eeebe70ae4dc51a7c8e1d55441b86281eb4496319ebe07671635f50a8a9f4352c04905fceb8','1785b839b8c93c5e0addde4b2d1e7e7352816cacde915ad1b9972db362042db20b0c6614d6aabcef',0,'2019-12-18 13:54:51'),('c2a5b77ff45c12f94d93667ef95633eed5793c78344ba64900072ee1d207f5c089f9c2ebe7c7f723','3dee179138d3575a3cdf8ecdedf1de936d3df1de7c1a0c60afefa7273b8eee5431808a9f8263d9cf',0,'2019-11-09 08:45:54'),('c303ed65cd5ae69b16a96206e337ffad7b8dae8a13c3075055069932096768c490fcdc4d7d3c5ef2','b5a9d92d4926572aab32e4b8ec8680e8540c97257089ee3ac33f18fe967ac41169cc829dca6a2c44',0,'2019-12-08 17:22:51'),('c357c6749924dd1ae73a151f33c662dad2ee971bcec4b4b7f30b901a8e721ac7d7a6e944b0124489','077a9a221698755ed1484812df9da9d4dec13ce31f0e1ceaf196be44d351ddb079b2ffd0aaaae1b4',0,'2019-12-14 17:17:47'),('c46deafd30e4acce432c67d3fc0ca90fd13d10f4525a6e98ff2d96737e89f9d8f81cb8cc437f1a8e','3614800ecfd2ef640368b3584ca6d3cdf2f70787e0c6aec138de90b9b39267289865c1294d81fa3a',0,'2019-11-10 15:25:28'),('c4eb172614a4a62c6ba730a1cbaf4437bc22b7ab6962e5fb914fb117d45229459ced289fe1b6a8a7','17da29e73d0e82d973f768c05e5aac1b869b2c9439fef7e885ed6303573f0284f04d93b9f7aeb3c5',0,'2019-12-22 13:16:24'),('c5e90e6ac5b52c7eb20d9247222fcdc0fa0bea529a193a9fe673ccca6f08442faeb08b8624943a26','a8b82badc5ae5b36d1c076395c15e445fc857b8a81661f310f24ade2a545f52a11c5d248f754ce7e',0,'2019-12-23 18:09:47'),('c6f1e3942023b2cd8d6e5c35bea2fe74b14981ffcb1a236ebfb11ee880f5c086a3ab33373b630d30','6b3f7e6802d8e8c87b31ad88bb0f72f30ec51041e5ba85c64c57e37df92ed0f1b6888b6418ada85d',0,'2019-12-24 10:58:29'),('c749fb981c480dc980556cd82f1ba317ceae501d8c676b43393115a3394f20e5aaa7715a1bd6e59c','a534f222e847dd35cefae220efca06a9f74e293ce911bd9b1d87ded8da6229df6debfb24d430176e',0,'2019-12-24 18:50:37'),('c7af42b41c307de73c8e9d817578639a1429a02119e7be9bdac3bd5ae9e80c3a8120a12eb2773842','cc7e0504dafbfe6342870c569ec92268c5608fdd2037a0c67ca82fb4cc79595c64d678e737b10017',0,'2019-12-24 18:15:44'),('c830ca7f705c0454170bbf45c277bd20744275e8c5eb14f8f144a694bde947699b144142161affc4','0b472d41a87597e2c3a89bf03ed4e9f7fc5dc34349c65996a8e839baf5e1009d881673f29c89f2df',0,'2019-11-14 10:07:13'),('c8461caf835d9dbf7f2a34639996a43f955ba525ded9de9afe5c1b1c95f609cf83386f8c248059f3','379f7748d8db0734063d8b9c8b7acd7b41a5a13f90b42a8b743b72e3eb6359077821011b9e786db4',0,'2019-12-24 16:32:38'),('c8e8778a78610ad819ae237d3e2051e42e14c087e3f727e701e4011d4b7d8d938543ea41ce2a79cd','c4cf6b7be6c712f93aab7f9e543353fc131e610356ca02aa8ec181f08073e031e89c1c4975ea19fb',0,'2019-12-11 12:07:47'),('c925224bb2e505b28b4a2568859a74cc9ca796cf3fbfcec7f4f00564c690722075743713ff83a5af','2705e529ed798369e6df3ae263537c96035e0f1d2e40a74bae78e6f643eb55b03686e64edd649ae4',0,'2019-12-18 14:19:15'),('c94c90873e1ea3c1ed61402df4b90f674d9b906a1acdd7707d4689d64d23d499fa12ff1545080b4a','0274cfef5e2acd3e079b3b2cf0bfd045570f2d7e3ed71998219441f29f77dbb6b038a41c1be88c30',0,'2019-11-08 13:09:10'),('c95234729b5c350b969bf40f0ca50dfabc12824f0a7c93bd8d0e1fc801702435e51d7123047def1f','f95a77cfb45bca9408fc622cce5938a8ca3d2f3e18af697402d530e99901c64a698cf178ffe7e6f1',0,'2019-12-20 20:12:02'),('c9a4661013e34d568065a26b1886bbc51958116d00198abba0bec9855b6691573867ab0fb794a3c0','25a7507df0cff856e0f83c1ce9a221ebec74f65eed0799821dd62e9cb99398f750665b4daeb93cd5',0,'2019-12-24 18:49:27'),('cab0c5706c3a152fcf6eab899b7fabfcd1ec75a2adb256a3849de3f74be08af664c1df61e42dd95f','78f54363ab3c847ff4451b38466bb40e7cc8a0a5eaff518abe4337fb198bb1fd7187c6ad2a53969e',0,'2019-11-10 10:21:51'),('cac5b20a1cee35516c16e76b96090e02ba66cf5ced0843928fdd87422d3a1c6d2b8b794bde75ea24','4a61f5ac18cba27f93a52c9d80f9287205a7f7525002d163568ad94e31e4ce004a341f81fb670854',0,'2019-12-11 11:52:51'),('cafb3d8cd947dc8fa6cc843920f6198def29dce29b6a8760558a385452ff12c96c72a25544090a44','e947a526661a5b39ebd0c861285e8df19b036874ff41d7c307ca4c3e80c30092818c474a9f2f6a04',0,'2019-12-14 20:46:59'),('cb06e8de64a9949501a30065400a9721538c36e57609bb34ad90a0a3660ffc4af9a367ee99e37f38','dd151c2fd2f6b59cf86011d5b24ef9cfd90f087c3246bbee35b9bdc6ea89993127a3c9001588f735',0,'2019-11-09 15:53:22'),('cb38aa0306c2989dcb1ab579c5ceeec61cd5a38af498975b4200ec064d77cc3efc7554d827e3d69e','daf5159cd127be7e692889e16a8552f1d11b68d90fae59126194ced1952b658076dbc6be2fc896d3',0,'2019-12-22 09:29:02'),('cc7b13717930c486c26cd37b30e12f14aed3c9b28357f780e46aacd34c4a361a0d228c2a0f638043','a0c01fc64617763dd8421fd476c3a68bba5349aab9d32edc90a5e4c02a59a639287f9dfbdd6a163a',0,'2019-12-24 14:52:22'),('ccb4d0ebea5764beda6c0616c38007dff41c5412ffd184060cfd5c572486ab2b209deec32dc3fc07','24a2975bd11fde9a69272326520ae023c7fe121751f624fe826aef49d35ea00e39217f1dc23617d8',0,'2019-12-06 23:27:51'),('cf2b37b8119250907fb8b72972ac3bf97dd27a8245b81e9d40f700b8216481a987d4d01aa42fd78f','cf624565ce220b50b84b8bb9a37f48f7fdf9f08a855019e76463121409d08a802cf030df711249eb',0,'2019-12-24 16:06:42'),('d113a88062ca3ab4aed069feaf21efa3909d81b34cab09ae5cd9f086d3d6edba09fc543288144647','d86814be6cb890fcd3375902a4799ad8517024ca34ea84a2ef8ceac1dbea4376b4d38d652e02043e',0,'2019-12-07 12:04:49'),('d1b926c2aba08142cc9c11c150ef60352fb9bc7e8fad7893252487162a219f9532f8f90b09047b36','3c1245fc3e9d0a4ebba2057c6efe8e8a5b9f1ae7e923b6ef36e8bd161cf497286f62779ed0a18376',0,'2019-11-09 08:03:35'),('d1cb12b84e43620fee01063e2ac2f8eac8d644c2dd3942354e3e883f92f9cd5f5cadccca980b2ce6','44645065a483d4f233ff2feac788aa5443a641fa4d3e9ddb877d4f119b3a1b1c8c498c62181ef9d3',0,'2019-11-24 12:15:43'),('d23459a9f7383b2a058b7dcc1b6f4de7cead9c0b58c8420fc02cca1c072383373845e58c3268dd5e','591b9ba5cf2578044b642fd5bb3017399b7f50c7ae25e2a5dd716004633c0182b64659c9cefb0f79',0,'2019-12-14 17:21:35'),('d238e413d1aa6ced3ebb613ffea6c319fcab43b3b8951c3dd1715ca7a0aba191ac431ea17f048763','d91f98683474ab8994cad8b04ea19270ff8daab8aabf708c1900d3a88c1a199dadb4c211a7917430',0,'2019-12-14 20:49:34'),('d241df65d4dde22a0a5b47d38eabd80493753b4ef179c571a8b5ef4558592d38e42d456a8530d77d','647b1285817300acc8be94b8848fd777bf40427724487035e3e150f4fe492baefebe2a21b9e18ca0',0,'2019-12-24 18:32:47'),('d27bcf66aac2fc1155967999adf0dc483f36941b732b24143e02c27e183d6c30372eb1d4d37d0b75','242832c48b8f86d47007f94f9324292ca920a68bd5e961c34e8765bc6459eda7c29acc489b2ed152',0,'2019-11-27 11:35:08'),('d2bc1f0bdffc817c110e4dfd1b82f3f8f39143bfcb2a9826523a3a25e6a6d04bf6d543b546c6f0a8','2aefc69c4a671ae7f6762d1712c655176474c79a034c6b43b97860fa2537f51a74f17a5ceb0a9a90',0,'2019-12-13 20:38:17'),('d2deea98b84a950313230aaaa5dce80eebe1683031f366dbddb09b1538445f939f1fa89c8d8697bf','887f0e2b32585926470d789c4ff1ff24bf369cfec9a6761ba240825c012dafe8a8c7a760ce588972',0,'2019-12-22 10:31:31'),('d42c6a11c22b920385477aa96c3bb90d01819aeb3766b6417cf2df5090916890e193375651f10a98','133c3cb6d2f3e22d59004f38bf002b0533795d080c79585bbcfdb57c4785a5105845075fa911961d',0,'2019-11-10 12:49:42'),('d6e07821df3690f7ca4624e75860ae52b98d0c9e3a2bd30b07ef548fb3156b1f0a739370ee3b5110','6d59e5b6835d3769ea91d9a7cc31c4206209eeebcc89002370847eb166298c85f327dae6d465c6ed',0,'2019-11-09 14:07:19'),('d770492d5fe387250e4c197924e417d432dfc21a8a2cf5ae709e6fdd35b5d9b714f9f94bb73f0e1e','fd32d2ced5ab2cac6a6d49b974922af52d6de3e307cb0b44414f8defc918a948b872aa574dee14ce',0,'2019-12-19 15:01:41'),('d7e4caae1f4f09db8bc5c33368855ca5b8275258a64fde28eefa939ac37b5d0f328d324fbb5b26d7','d1de16a3be8383e8ed2cebf50ee27b418af3cf696afdb1fbcee79bdc1361752fc9db93c00e5dadd1',0,'2019-12-22 08:04:58'),('d816135c52aa87067cdc6feb9c4eea82cabc9706df75ece0ba224c5fd12ffca507d4a48d7fbe6878','39e5ae8e2bea6c895b88439798f6abb8819636e76b68486ea8d1d1f1b881b909268e7cd199a8619c',0,'2019-12-14 17:17:29'),('d8731563987ea3bf1d89ad92a0afd2b95590f3aef79d6deb404f1c8347b5b21562020c7d49249682','1f75f858fd5c259068cb10128552ae987b0dd281f8ae3c00596902f1b51ed3db8284b6c33f26551b',0,'2019-12-20 20:15:50'),('d877fc20b8b05489f3903d234a2f7f741dd89e90d8bbb9e7cd6b640b2100ee8352de5400be73674d','ca3e3effefd567e70ffa1a4e28c0cad5f40c5db59b2f3645bc3d76e0cb8ca8231eda85f3dda57056',0,'2019-12-23 10:22:59'),('d9cdd5e007c1c1ff2d54ef9370f74d209eb7cf61bac0b9964857c485604b0b497fa5aefeee47a9df','6c16e6a4bf3cc7f3adca34eef9e28afa99bbd54db62a36967bac4eb04546bf259f9234aef7109434',0,'2019-12-24 23:58:56'),('da8056c8fc3e6774859c60975c0609c706cd01a86bae30ae958d7f2028cd142792d6c3d8d3dcb2ad','be17fe98654ba80079595ba99a534d8f5382e06f5ba402ccd2968c61fb9e7cc6b3c94edbc8c74f41',0,'2019-11-17 19:17:18'),('da8d6310f867b9220dae261242762ad614e6eaf8b949ccc5d1aac12e27e1fd70d327aa37507f0f54','2575e2d586ef67010f132e3bdd2197daab794e9d19bfecc9a972dddafd92b9440664958c9660f44b',0,'2019-11-10 10:14:29'),('db8a37bda21a981f16530298999f5610f8e348d35cad9bcaea8dec5d371e0eec3ff195d220c6bd77','4ac0ebd8c894a2b9fce5c211c4b64114f458eb9b9a3dcfe5cbb36ead9558a4586ab6e17e4f07a37d',0,'2019-12-24 18:45:47'),('db99b8b1f0e17fddb0d0dcdb6cf6c773b7fb4fcd40faf080624defb3e61aec85fc5bc9d570612281','febb5127bf088d9d624e073d36f4dfc74e93480e9db58124153f3a2404adb67dc5a3182eb8b93b13',0,'2019-12-24 19:21:44'),('dc63dbf391c9d6fb9ad04f96d5e32235733a4f85c408685f6d56460e4aa4258839dcd57fd956f492','5814faedbb96a2952d8937cef09c3b06b64cb10e0cb8ce64c6997a25bb095c9f6e348d60a394498d',0,'2019-11-17 18:49:49'),('dd13d563446739e39cc75c1039da00423547c0e6a605e613412f6c521fd7d8939c8e31afab17a478','1efcba20d11a62e62a9cd27a41ba82e0bddbb621c65052ebc4f2231280a88c9f74ff4d968da44df2',0,'2019-12-19 13:33:53'),('dfc6cfac070fb358fbe3d9432940ffe64bf4641bf4e3865ba0bdf22985081f765686f35de0ec6063','ce33f82f3f9cbcdab0bf874d7ab363640403be0bb2a1453c3bf27ec475753be5b46fc11bc2af6994',0,'2019-12-18 07:07:20'),('e1078b257a0d6ec66511834b1e2b6ffe1ab6a2883986c85ce832b2ed0e478ae64a44929579f8ea29','f65f6e4bb029ef17fd87a6f7f7b9a8d64319a93543ea297dbdf8c273aaffe46cd3d6e3ef329cb88c',0,'2019-12-24 16:07:17'),('e120dcfdb80307a379f468b628f23c696ec0d78eb9c72fcc97cbe0ddf2a0c03aaeb463fe9092b1bf','ec96f8e7b776ef650d0559a50bfe954b52c18de417e1e5c910643186f363b27391891f2c71e56f09',0,'2019-12-14 16:03:49'),('e1911055efbc50bfdc882670d4e266ed26330d76bd6be111418cce24f41be05e9cd86dd7447d49de','afbe58eda0f54284f8a20f26e5ee89cb11add52b38cd1c87f9ce0660c9309229fc2800dab133a71f',0,'2019-12-12 18:47:32'),('e1f9135c9080e6397ea201ec009d4e108757ced2ee40ae0849561a64237223cb9410ede9f93f3131','c182a32a84aaaedb90953523a475de1f32325917f99fca8f3e20c63e05f548993316af1ecf0ebaca',0,'2019-11-10 14:01:01'),('e210cfff83c81684f8bc0a1fb5b04f79ef5bb0ab4b2b0ae5092fc8857fc0834df40af6a701c71762','a62a776cfca3216f460fdcde75ebc0b13b7cac4b7465a7590c0ab82ef3d604f76b0fa80473d45687',0,'2019-12-24 18:23:41'),('e215fb0ee2cb7c980742b8b4d1f93f4be83dbf95d6cf9dbcccf2b281e635d09890a0f42fa851ab6d','7730c28bc42ac6f8d41e767b45a0a4a602aa35c81031d649c1397f8478870baa8e75072ab44fbed4',0,'2019-11-10 12:26:23'),('e343ac7ab52526c879ed7337cd84289dae24847e89077bfc3bbb4d75209e6f232afa9f48265a78b5','d335040bc6310f2de192ab398eba56e5612184ee13fc85cdc467c4433d6d7b6342e9b5c918b8d959',0,'2019-12-24 18:45:39'),('e4f3d91540de5a36161e498c647d5fc8db3b57e576d92c8849041f6600e7ba158e261964bd1a23b3','86ae5f573a9750857ecb02ecf873394312f6921d02a7b39c0aed9cc48dc3eb879a644717aaeddebd',0,'2019-12-10 09:49:57'),('e511dd83a2aed82633b8760d9d8da04defb7e0d23094f1d47f245e33823d084d94732526e26d80e0','4ac42761099270b25be7ce4c913a9c0db26184a18cdcadedb2152c179ff4794ba7498e948b47b048',0,'2019-12-04 12:37:22'),('e5b6447d2d31177f2a033e46ce9efc432e947c32546c642387bbeb21711f4b82d163c73ab0b42fe5','9cd59658a8d5e25ea0553169c2a7a1d80dc9f86065bf49e6b99bde1ce6f131047dcb81ddf59133d3',0,'2019-11-10 09:42:14'),('e608de39451239da87de8b89087f2c950ecc3c6ca9e6c1cb95c8bdd5c93ea54059aeaba26e879aca','4908c43d9b269dca096bfcfaf46d556ae5a77eb2ad2ad6355025e3d0aeeaed4cbf1ba8ab01c7c8fc',0,'2019-12-01 14:23:03'),('e7566715d489f01cb40295a4d855244c20683eab5bead4382b313ead1174e7e4b04f79edd74f2025','ef3c39badc309ce9ad3a0fb3758123fa03009cc44ac9e4cd8c635f21318675cc92c058f458f72d34',0,'2019-12-24 18:08:44'),('e7622719f1ce692f7c56f84b02d53f75017e4ae96b728abc908baa37c6524e105a861f5ed6d72088','83705ae7a3060102ff7facbc2720528a4f3794f44ebdaf534d85d435d3885cbb297f403c3a835674',0,'2019-12-13 09:31:11'),('e79a1ca3bbe2eb2ff5f6769ea846c96882138b8540f2f2f1cbcc1227297d9bee029c956e69917b0f','b281bfb0b181ef21134762dc030825cf300840daad9f70257031c300d88c17e8867a3e9040206885',0,'2019-11-09 09:18:09'),('e869f1bec768f20de2bda10d974943108719c64e7d09c980b5d68084e9d353676009086d356f2eee','d1e3cba297b76fb94f84d5e5b6bb628872c310ddbc615e9acce662309837d8e95b9325de861f01e7',0,'2019-11-21 18:04:01'),('e918424e76ca6349ef2c384a366780fd16e1a0035c869511edf0d1c7e7274793084efb2776c80ca2','1ab48f72470e5fef751b2e5794e645353071ee5766823301436a9944726f276b1e482ba587fe9ba9',0,'2019-11-09 16:06:40'),('e99b515f71213c4efe194d70e22e7f5b1426c6c5b2ea6e9e0b019268adf9c1bbb7c57df813e0c9b4','25648b87ee8ad18df99071e8fcf09da343874fc25838724041b44d34f2d2b70f2cf48f5cf103cc91',0,'2019-11-15 22:01:52'),('e9cd5bb4bad7f4a133570effcb2dff44678c3934f32c5c985e52917dbffd9329b6bf41a34bfddb59','e30879af58b6762183debb567347942acb1de1cdf76877b242503e4115228a9f596222196ad2dacb',0,'2019-11-14 16:22:44'),('ea31f4bad9d3c1dfcacf7aa85ec9ea0d7b6260ed81600f044bc2edfbc4da7488b057159b3c6df4dc','9ba2431a7df2759ca3d570b32dd7742759db4685058823b71227bc43b8d7701cf01d5a9bcafc19f7',0,'2019-12-18 14:14:39'),('ea7a70afba574fd48952bb8bea90ceca7e64336c9bc33664326a3dccd6ce5f3d9475bf9d923af096','52b7acd41810a496f061b932c1d013574f2735d9322b84a3c4bff6bcbd0344d96527ce5ade0059d7',0,'2019-12-14 17:18:18'),('ebea8b14be6b320187998e6baeff994f3791e6df12c6a8dd6dc3faf47a6ad4a8579a72b3f26fa83b','40a5113391dc7f316ebe46758fd4f39d6c0eda0204c7478e7133d58b2eebd35b310d4ed904037759',0,'2019-12-20 10:43:16'),('eca2218e2e55f257969ba29e77b451d35eeedb93096150f7e0b4283e9b49bda112adce42b1004aae','0e4e31df2942e23ed32ab8f64b4bc06752d1dc672a836b54f1bcd7a35f5570b63120b894775eb4d7',0,'2019-11-14 15:39:23'),('ef81d499c4485572c72fc5c6c60af57433f49a5d2af870a3ad44e0696f2f6ea9d27f2a78df7e45cc','182ab5677aa29763914a2d39da5267560edc0049aa735db9b60b9bdd0824df01ea25f9469672b9f3',0,'2019-11-09 14:01:09'),('f074ea3e712fdc2c1fb08ae24195181556f518bcbd6fe1db26db58190ce24fe11ac98aed32b6f403','8614e3e3fda2a26bcc86fb8570850f259c6e4922e220416f30b5bf3d333116a8854163a2f911675a',0,'2019-11-10 11:33:48'),('f1286ea95653d34f003d0031372ade1a9ba5106739a7f1827c7cf0c711ce2dc15618d1574fcf8926','02174a7d36d963cb446467b457811b6d36898f9afeb3c105e18e4c506a421fee5153400d2e67c5cb',0,'2019-11-15 17:57:26'),('f21c30a47d87bba60adf2b4e0d805efc34c0dd43419a35b700958cec8238879f30124c1d86b8885a','0d4d59eb9df67717a49f310e3908307d20b9a5731b08818740afe7dcb24619904c1201868e4ed163',0,'2019-11-08 15:54:52'),('f4498d3655cf432c71ff6bb0a044ffc62c35a0e44400a93e7bcb0800892d882795e4c03de54010e2','df721c1b90f8e5a34aca980bef9482533fb7a50850eb84e8eb3e86cc7a8feb48108f7031acbce996',0,'2019-12-24 19:22:31'),('f469f2184dea988c1fb09ab4e7f9ad9a75fcfa9f787199570dd1897f84eb9e7cce37786aae911fe2','9abfd49042a24f044f4b0e29ffbd5fba15e73a978d058d3f2d37ded677e5fb86726a5e5c32f6cb93',0,'2019-12-15 10:21:15'),('f4767d818d826bd9c501c7c828cf65c9dd6bdf4001214c9a5940885354c6f40fbb35f70a3cd0a597','84b81faf99cf31337b0f30c956f59c39ba7456ef4851b5e549114a583f6c0185cc902fe5701a3b5a',0,'2019-11-10 15:37:05'),('f53ba8c0e0b5c3d3b94c81f95abf833090237a2712360dea000e945cef5d596072535c328a56d33d','c3b5b28efe2d982bde757f67ac9f4cd92fbc5a52ccdfda2fc2a3543c081dc1abb3b5cc0ec249d082',0,'2019-12-24 13:59:02'),('f56ab5c1c9b73e162d27d1147d371ad6d9cf5f4f1168706606067f2684de5c9de1a9933f2ecac454','4b915c97f46ac384af2823b6b99adf601e94754e13db821b9eff89fcda56b5a0c5e86882a22aaa29',0,'2019-12-11 16:09:38'),('f75b9796121add557168fac6b3e75cb3db8b2ae87d164752179e706c1bb3bb932d92e237abd748f1','e99d5d3aed537774afe2e67fb1601a2ea59761dd656e5f553c70521a203ab6c8afb2cf8127e33616',0,'2019-12-24 19:19:47'),('fa2f155008581e84f8695c376cc163c496e0fd6fd31189e96e4110773244697b9482931ccb3b2a80','f39cf4e5c48fb4703792f4acc1e33dbb61c20c91eacf24f55b829f43e80755c532a049af7f5516c9',0,'2019-12-21 07:54:50'),('fa79b7a9d2e8842bda8cd692ccac90e75624b600d024337f9fbdecc69c67fe26f38e9483c086aa5e','64d47721f1ee156188d07cbf31557e88245c11285d2e9b47535ef8f754423b62db42da9c2a9be30b',0,'2019-11-09 07:42:35'),('fa9d69b6fa43130d34d812f20ff009c272e34be1cac1ed0528f9d2385b260e98a01f355c2190b8cd','8bf11c99a928dfe37094d591bb86fae9d9e01117f478bbca11191c25cf5833120bef0f8173f89a52',0,'2019-12-24 19:17:23'),('fb4e3ae7196f21502b8ebf3cadfee374ac522aea1dd9f5f9a5d88af050c872d418ab293e8c5674dc','d8dddaf04e2de9010ef2b2799bbcff71cdd30e859e5670267bc71eaba04ff043b371a436e3b4513e',0,'2019-12-19 14:13:27'),('fcdaa360a6da65cdd3a40b3fb5d3575812ac070a1ff16f6744d05bea655a9bc8c3e10af0e5d50513','de4058c479113f80485c1bdb0f7728eb09a71adc0255a6bdb6a3a00934dcd21b52dc734af0ba9adb',0,'2019-12-24 18:46:39'),('fd132f6af8cb27b7ccaef91cc180dcc65f97a9dad6592121f4972af0c5ab137c444052a00bc89c07','97c1ed4f2f5f28971dd435ebc5ba381da2c65b349e8c0c965be2eefb6fbed9294a97f996f912cafd',0,'2019-12-24 16:05:55'),('fd19e0001be46c91321b6325bb785017e7047235e98b0884a83adf05d4b1cb9527734baf11a63563','fcf2ea4f49dd1783a0343a3bae3a5cfede3bb312ed8b76978e914f2b89d802e475f522017e51e5ca',0,'2019-11-10 09:58:08'),('fddc1eb5869ca2c3fc6918089ad8636df2b315568029062dc8e82db4b2bc8bb1cb03eb4828526e68','202930eefc9c7e6591c6d7bc9f48f7b5524d5a2851bfd9413f35ad62513aa7ea00a8021a09eb09a0',0,'2019-11-08 14:52:42'),('fdeed7948155285c8746502540578b9890ab9af2338d6c844c566b4336aa0b212178497205e2d3e2','5a86a8c592265bfc0966c54ddd12ca106b556e00557f016f046df7792331817e816e54ebbeee6cfd',0,'2019-12-08 14:18:36'),('fe320104ed98bf0d237a0562bf0be810878bd6387e4c30874473d97ec52251344d0020fdc3d4d85c','bb9ba98fe99710722701fb1d967ab44fec944851ead91789e418ff602b9464551e5a47e4949bafe8',0,'2019-11-10 14:08:18'),('fe48af8ae6a7f80001085bf01ec573576b178f124e24107d56d4b8a5563d2073ad2ac46da049788d','e605f82d0602f681f1b9b0ca1b508ffeb5c5dfce13bdd1e40cbd5f430379a3d70b43a8cca3a5f714',0,'2019-12-19 15:01:21'),('fece887586f044698efab612d6a150b660c37e98135f2390c217a9b40e0afe826e338b48f9a38a28','2d3a67b15df3b63c5d490f59722891fbab8c9e082f795d0b3799c9a3cb2368b3d0fe7444679f0fe3',0,'2019-12-24 14:52:41'),('ff3a5e7aae13adec4a7f7a32eeabcef370223a71100c646284bd9dc5bb9608cb62858626c35305a2','12ee70953d90b9cebcb82c00d8ad6908d9ecb0aa00681b105e46696e7a76de18ce8f28219a2747fa',0,'2019-11-21 08:56:22');
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametre_communs`
--

DROP TABLE IF EXISTS `parametre_communs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametre_communs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `consultation_medecine_generale_id` bigint(20) unsigned NOT NULL,
  `poids` double DEFAULT NULL,
  `taille` double DEFAULT NULL,
  `bmi` double DEFAULT NULL,
  `ta_systolique` int(11) DEFAULT NULL,
  `ta_diastolique` int(11) DEFAULT NULL,
  `temperature` double DEFAULT NULL,
  `frequence_cardiaque` int(11) DEFAULT NULL,
  `frequence_respiratoire` int(11) DEFAULT NULL,
  `sato2` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parametre_communs_slug_unique` (`slug`),
  KEY `parametre_communs_consultation_medecine_generale_id_foreign` (`consultation_medecine_generale_id`),
  CONSTRAINT `parametre_communs_consultation_medecine_generale_id_foreign` FOREIGN KEY (`consultation_medecine_generale_id`) REFERENCES `consultation_medecine_generales` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametre_communs`
--

LOCK TABLES `parametre_communs` WRITE;
/*!40000 ALTER TABLE `parametre_communs` DISABLE KEYS */;
INSERT INTO `parametre_communs` VALUES (1,2,50,114,38.47,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-10-15 10:59:25','2019-10-15 10:59:25','rambo-rambo-1571136496-79322917-1571141492-1571144365');
/*!40000 ALTER TABLE `parametre_communs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametre_obs`
--

DROP TABLE IF EXISTS `parametre_obs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parametre_obs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `consultation_prenatale_id` bigint(20) unsigned NOT NULL,
  `poids` double DEFAULT NULL,
  `ta_systolique` int(11) DEFAULT NULL,
  `ta_diastolique` int(11) DEFAULT NULL,
  `hauteur_urine` int(11) DEFAULT NULL,
  `toucher_vaginal` int(11) DEFAULT NULL,
  `bruit_du_coeur` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parametre_obs_slug_unique` (`slug`),
  KEY `parametre_obs_consultation_prenatale_id_foreign` (`consultation_prenatale_id`),
  CONSTRAINT `parametre_obs_consultation_prenatale_id_foreign` FOREIGN KEY (`consultation_prenatale_id`) REFERENCES `consultation_prenatales` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametre_obs`
--

LOCK TABLES `parametre_obs` WRITE;
/*!40000 ALTER TABLE `parametre_obs` DISABLE KEYS */;
/*!40000 ALTER TABLE `parametre_obs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patients` (
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `souscripteur_id` bigint(20) unsigned DEFAULT NULL,
  `date_de_naissance` date NOT NULL,
  `sexe` enum('M','F') COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) DEFAULT NULL,
  `nom_contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel_contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lien_contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `patients_slug_unique` (`slug`),
  KEY `patients_user_id_foreign` (`user_id`),
  KEY `patients_souscripteur_id_foreign` (`souscripteur_id`),
  CONSTRAINT `patients_souscripteur_id_foreign` FOREIGN KEY (`souscripteur_id`) REFERENCES `souscripteurs` (`user_id`),
  CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES ('azongmo-1573517982',52,27,'1950-08-09','M',69,NULL,NULL,NULL,NULL,'2019-11-11 23:19:42','2019-11-11 23:19:42'),('azongmo-1573517985',53,27,'1950-08-09','M',69,NULL,NULL,NULL,NULL,'2019-11-11 23:19:45','2019-11-11 23:19:45'),('bekolo-1573577227',54,2,'1977-12-09','M',41,NULL,NULL,NULL,NULL,'2019-11-12 15:47:07','2019-11-12 15:47:07'),('dfgdfgdfgdf-1571226396',49,2,'2019-09-30','F',0,NULL,NULL,NULL,NULL,'2019-10-16 09:46:36','2019-10-16 09:46:36'),('dino-louis-1571136312',40,39,'1965-11-13','M',53,NULL,NULL,NULL,NULL,'2019-10-15 08:45:12','2019-10-15 08:45:12'),('eric-1570634615',4,2,'2000-04-09','M',19,NULL,NULL,NULL,NULL,'2019-10-09 13:23:35','2019-10-14 09:19:12'),('eric-1573479759',51,38,'1995-04-09','M',24,NULL,NULL,NULL,NULL,'2019-11-11 12:42:40','2019-11-11 12:42:40'),('jesusfictif-1571165162',48,46,'1997-12-30','M',21,NULL,NULL,NULL,NULL,'2019-10-15 16:46:02','2019-10-16 07:29:16'),('nde-1574619366',60,57,'1990-05-03','M',29,NULL,NULL,NULL,NULL,'2019-11-24 17:16:06','2019-11-24 17:16:06'),('nkouekam-1571424920',50,57,'2019-10-14','F',0,NULL,NULL,NULL,NULL,'2019-10-18 16:55:20','2019-11-14 17:14:00'),('rambo-rambo-1571136496',41,38,'1990-12-28','M',28,NULL,NULL,NULL,NULL,'2019-10-15 08:48:16','2019-10-16 07:29:54');
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'Administrer les roles & permissions','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(2,'Consulter profils patient','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(3,'Consulter consultations archivees','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(4,'Consulter resultats laboratoire archives','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(5,'Consulter resultats imagerie archives','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(6,'Imprimer rapports medicaux','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(7,'Imprimer resultats laboratoire','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(8,'Imprimer resultats imagerie','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(9,'Consulter profils souscripteur','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(10,'Imprimer consultations','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(11,'Consulter profils praticien','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(12,'Consulter consultations','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(13,'Creer consultations','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(14,'Modifier consultations','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(15,'Supprimer consultations','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(16,'Transmettre consultation','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(17,'Consulter resultats laboratoire','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(18,'Creer résultats laboratoire','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(19,'Modifier resultats laboratoire','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(20,'Supprimer resultats laboratoire','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(21,'Transmettre resultats laboratoire','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(22,'Consulter resultats imagerie','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(23,'Creer resultats imagerie','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(24,'Modifier resultats imagerie','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(25,'Supprimer  resultats imagerie','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(26,'Transmettre résultats imagerie','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(27,'Imprimer résultats imagerie','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(28,'Consulter profils medecin controle','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(29,'Consulter consultations transmises','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(30,'Consulter resultats laboratoire transmises','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(31,'Consulter resultats imagerie transmises','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(32,'Archiver consultations transmises','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(33,'Archiver resultats laboratoire transmises','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(34,'Archiver resultats imagerie transmises','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(35,'Creer profils utilisateurs','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(36,'Consulter profils utilisateurs','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(37,'Modifier profils utilisateurs','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(38,'Desactiver  profils utilisateurs','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(39,'Consulter dossier médical','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(40,'Creer  dossier médical','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(41,'Modifier dossier médical','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(42,'Consulter souscriptions affiliations','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(43,'Creer souscriptions affiliations','web','2019-10-08 11:26:37','2019-10-08 11:26:37'),(44,'Modifier souscriptions affiliations','web','2019-10-08 11:26:37','2019-10-08 11:26:37');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `praticiens`
--

DROP TABLE IF EXISTS `praticiens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `praticiens` (
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `specialite_id` bigint(20) unsigned NOT NULL,
  `civilite` enum('M.','Mme/Mlle.','Dr.','Pr.') COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `numero_ordre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `praticiens_slug_unique` (`slug`),
  KEY `praticiens_specialite_id_foreign` (`specialite_id`),
  KEY `praticiens_user_id_foreign` (`user_id`),
  CONSTRAINT `praticiens_specialite_id_foreign` FOREIGN KEY (`specialite_id`) REFERENCES `specialites` (`id`),
  CONSTRAINT `praticiens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `praticiens`
--

LOCK TABLES `praticiens` WRITE;
/*!40000 ALTER TABLE `praticiens` DISABLE KEYS */;
INSERT INTO `praticiens` VALUES (43,1,'Dr.',NULL,'563547','2019-10-15 09:15:57','2019-10-15 11:17:06','docta-1571138157'),(44,6,'Dr.',NULL,'659854','2019-10-15 11:09:03','2019-10-15 11:09:03','ledoc-1571144943'),(55,1,'Dr.',NULL,'123456789','2019-11-14 14:47:30','2019-11-14 14:47:30','ndefo-1573746450'),(56,6,'Dr.',NULL,'2013456879','2019-11-14 14:53:10','2019-11-14 14:53:10','praticien-1573746790'),(45,1,'Dr.',NULL,'456987','2019-10-15 11:15:10','2019-10-15 11:15:10','test-1571145310');
/*!40000 ALTER TABLE `praticiens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professions`
--

DROP TABLE IF EXISTS `professions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `professions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `professions_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professions`
--

LOCK TABLES `professions` WRITE;
/*!40000 ALTER TABLE `professions` DISABLE KEYS */;
INSERT INTO `professions` VALUES (1,'rodriguologue',NULL,'2019-10-09 21:43:07','2019-10-09 13:24:56','2019-10-09 21:43:07','cardiologue-1570634696'),(2,'rihanalogue',NULL,'2019-10-16 16:02:58','2019-10-09 13:25:06','2019-10-16 16:02:58','urologue-1570634706'),(3,'Médecine',NULL,NULL,'2019-10-15 08:28:23','2019-10-15 08:28:23','medecine-1571135303'),(4,'Infirmier(ère)',NULL,NULL,'2019-10-15 08:28:48','2019-10-15 08:28:48','infirmier-ere-1571135328'),(5,'TMS',NULL,NULL,'2019-10-15 08:29:02','2019-10-15 08:29:02','tms-1571135342');
/*!40000 ALTER TABLE `professions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resultat_imageries`
--

DROP TABLE IF EXISTS `resultat_imageries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resultat_imageries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dossier_medical_id` bigint(20) unsigned NOT NULL,
  `consultation_medecine_generale_id` bigint(20) unsigned NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `passed_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resultat_imageries_slug_unique` (`slug`),
  KEY `resultat_imageries_dossier_medical_id_foreign` (`dossier_medical_id`),
  KEY `resultat_imageries_consultation_medecine_generale_id_foreign` (`consultation_medecine_generale_id`),
  CONSTRAINT `resultat_imageries_consultation_medecine_generale_id_foreign` FOREIGN KEY (`consultation_medecine_generale_id`) REFERENCES `consultation_medecine_generales` (`id`),
  CONSTRAINT `resultat_imageries_dossier_medical_id_foreign` FOREIGN KEY (`dossier_medical_id`) REFERENCES `dossier_medicals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resultat_imageries`
--

LOCK TABLES `resultat_imageries` WRITE;
/*!40000 ALTER TABLE `resultat_imageries` DISABLE KEYS */;
INSERT INTO `resultat_imageries` VALUES (1,4,2,'khkjhlhln','2019-01-01','Dossier Medicale/79322917/Consultation/2/i9cR6wjgsuTkV2eF0Qc8oCPgOjL8l4mQuSM7UrFZ.pdf','1571734669','2019-10-22 06:57:49','2019-11-10 12:21:37',NULL,'2019-11-10 12:21:37',NULL);
/*!40000 ALTER TABLE `resultat_imageries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resultat_labos`
--

DROP TABLE IF EXISTS `resultat_labos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resultat_labos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dossier_medical_id` bigint(20) unsigned NOT NULL,
  `consultation_medecine_generale_id` bigint(20) unsigned NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `passed_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `resultat_labos_slug_unique` (`slug`),
  KEY `resultat_labos_dossier_medical_id_foreign` (`dossier_medical_id`),
  KEY `resultat_labos_consultation_medecine_generale_id_foreign` (`consultation_medecine_generale_id`),
  CONSTRAINT `resultat_labos_consultation_medecine_generale_id_foreign` FOREIGN KEY (`consultation_medecine_generale_id`) REFERENCES `consultation_medecine_generales` (`id`),
  CONSTRAINT `resultat_labos_dossier_medical_id_foreign` FOREIGN KEY (`dossier_medical_id`) REFERENCES `dossier_medicals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resultat_labos`
--

LOCK TABLES `resultat_labos` WRITE;
/*!40000 ALTER TABLE `resultat_labos` DISABLE KEYS */;
INSERT INTO `resultat_labos` VALUES (1,5,4,'Voilà','2019-10-21','Dossier Medicale/37317794/Consultation/4/6RQvPGgUv9AAAjPKmTidk2QRChCEOFBwT0RSRh3o.pdf','1571688195','2019-10-21 18:03:15','2019-11-13 19:52:45',NULL,NULL,NULL),(2,2,1,'Description faite par ...','2019-11-04','DossierMedicale/94015818/Consultation/1/0fVAnskuRO2xHYRnElTrBkW2niKOiAteCX7l3qOm.png','1573750077','2019-11-14 15:47:57','2019-11-14 15:47:57',NULL,NULL,NULL),(3,9,8,'ddsdf','2019-05-03','DossierMedicale/20549509/Consultation/8/3ETWS7BhQCRJ0W0V88DAIP6XK4wSt5jporOcRkhP.png','1574441460','2019-11-22 15:51:00','2019-11-22 15:51:00',NULL,NULL,NULL),(4,5,3,'Labo N°1','2019-11-12','DossierMedicale/37317794/Consultation/3/HLHlADXlbpL9rmBCWKCPakexT1oBepyoTg0L7BeO.jpeg','1574536902','2019-11-23 18:21:42','2019-11-23 18:23:11',NULL,NULL,'2019-11-23 18:23:11'),(5,5,3,'hfdfgdgfdghdfhf','2019-11-04','DossierMedicale/37317794/Consultation/3/j6isn6yxm8pAHdV8Cv97wmMsBsD17qZDIwZmJazu.png','1574536924','2019-11-23 18:22:04','2019-11-23 18:22:04',NULL,NULL,NULL);
/*!40000 ALTER TABLE `resultat_labos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(2,3),(3,3),(4,3),(5,3),(7,3),(8,3),(9,3),(10,3),(2,4),(7,4),(10,4),(11,4),(12,4),(13,4),(14,4),(15,4),(16,4),(17,4),(18,4),(19,4),(20,4),(21,4),(22,4),(23,4),(24,4),(25,4),(26,4),(27,4),(2,5),(28,5),(29,5),(30,5),(31,5),(32,5),(33,5),(34,5),(35,6),(36,6),(37,6),(38,6),(39,6),(40,6),(41,6),(42,6),(43,6),(44,6);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','api','2019-10-08 11:26:37','2019-10-08 11:26:37'),(2,'Patient','api','2019-10-08 11:26:37','2019-10-08 11:26:37'),(3,'Souscripteur','api','2019-10-08 11:26:37','2019-10-08 11:26:37'),(4,'Praticien','api','2019-10-08 11:26:37','2019-10-08 11:26:37'),(5,'Medecin controle','api','2019-10-08 11:26:37','2019-10-08 11:26:37'),(6,'Gestionnaire','api','2019-10-08 11:26:37','2019-10-08 11:26:37'),(7,'Docteur','api','2019-10-08 11:26:37','2019-10-08 11:26:37'),(8,'Garant','api','2019-10-08 11:26:37','2019-10-08 11:26:37'),(9,'Partenaire','api','2019-10-08 11:26:37','2019-10-08 11:26:37');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `souscripteurs`
--

DROP TABLE IF EXISTS `souscripteurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `souscripteurs` (
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `sexe` enum('M','F') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_de_naissance` date NOT NULL,
  `age` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `souscripteurs_slug_unique` (`slug`),
  KEY `souscripteurs_user_id_foreign` (`user_id`),
  CONSTRAINT `souscripteurs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `souscripteurs`
--

LOCK TABLES `souscripteurs` WRITE;
/*!40000 ALTER TABLE `souscripteurs` DISABLE KEYS */;
INSERT INTO `souscripteurs` VALUES (57,'M','2019-10-28',0,'2019-11-14 16:19:34','2019-11-14 16:19:34','emmanuel-1573751974',NULL),(2,'M','2000-04-09',19,'2019-10-09 13:18:47','2019-11-13 13:56:40','eric-1570634327',NULL),(63,'M','2019-10-28',0,'2019-11-24 17:30:42','2019-11-24 17:30:42','eric-1574620242',NULL),(3,'M','1777-02-04',242,'2019-10-09 13:21:01','2019-10-09 13:21:35','erzzezer-1570634461','2019-10-09 13:21:35'),(39,'M','1991-10-27',27,'2019-10-15 08:40:31','2019-10-15 08:40:31','lelievre-michael-1571136031',NULL),(61,'M','1995-05-03',24,'2019-11-24 17:21:06','2019-11-24 17:24:02','ndefo-1574619666','2019-11-24 17:24:02'),(38,'M','1990-12-28',28,'2019-10-15 08:38:29','2019-10-15 08:38:29','nlend-rostand-1571135909',NULL),(7,'F','2000-10-01',19,'2019-10-10 06:18:36','2019-10-10 08:15:49','souscripteur-1570695516','2019-10-10 08:15:49'),(27,'F','2000-10-01',19,'2019-10-10 11:18:33','2019-10-10 11:18:33','souscripteur-1570713513',NULL),(46,'M','1997-12-30',21,'2019-10-15 11:19:23','2019-10-15 11:19:23','testsouscrip-1571145563',NULL);
/*!40000 ALTER TABLE `souscripteurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specialites`
--

DROP TABLE IF EXISTS `specialites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specialites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `profession_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `specialites_slug_unique` (`slug`),
  KEY `specialites_profession_id_foreign` (`profession_id`),
  CONSTRAINT `specialites_profession_id_foreign` FOREIGN KEY (`profession_id`) REFERENCES `professions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specialites`
--

LOCK TABLES `specialites` WRITE;
/*!40000 ALTER TABLE `specialites` DISABLE KEYS */;
INSERT INTO `specialites` VALUES (1,3,'Généraliste',NULL,NULL,'2019-10-15 08:29:55','2019-10-15 08:29:55','generaliste-1571135395'),(2,3,'Rhumatologue',NULL,NULL,'2019-10-15 08:30:14','2019-10-15 08:30:14','rhumatologue-1571135414'),(3,3,'ORL',NULL,NULL,'2019-10-15 08:30:33','2019-10-15 08:30:33','orl-1571135433'),(4,4,'IDE',NULL,NULL,'2019-10-15 08:30:46','2019-10-15 08:30:46','ide-1571135446'),(5,5,'TMS',NULL,NULL,'2019-10-15 08:30:59','2019-10-15 08:30:59','tms-1571135459'),(6,3,'Gynéco-Obstétrique',NULL,NULL,'2019-10-15 09:17:05','2019-10-15 09:17:05','gyneco-obstetrique-1571138225');
/*!40000 ALTER TABLE `specialites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `traitement_actuels`
--

DROP TABLE IF EXISTS `traitement_actuels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `traitement_actuels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dossier_medical_id` bigint(20) unsigned NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `traitement_actuels_slug_unique` (`slug`),
  KEY `traitement_actuels_dossier_medical_id_foreign` (`dossier_medical_id`),
  CONSTRAINT `traitement_actuels_dossier_medical_id_foreign` FOREIGN KEY (`dossier_medical_id`) REFERENCES `dossier_medicals` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `traitement_actuels`
--

LOCK TABLES `traitement_actuels` WRITE;
/*!40000 ALTER TABLE `traitement_actuels` DISABLE KEYS */;
INSERT INTO `traitement_actuels` VALUES (1,2,'rter-1570785836','rterteret','2019-10-11 07:23:56','2019-10-11 07:23:56',NULL),(2,2,'fdfg-1570785843','fdfgfdgdfg','2019-10-11 07:24:03','2019-10-11 07:24:03',NULL),(3,2,'rter-1570785856','rtertereteffdgdf','2019-10-11 07:24:16','2019-10-11 07:24:16',NULL),(4,5,'sdfs-1571235156','sdfsfsfsdfsfsdf','2019-10-16 12:12:36','2019-11-20 15:51:58','2019-11-20 15:51:58'),(5,2,'amox-1571411078','amoxiciline','2019-10-18 13:04:38','2019-10-18 13:04:38',NULL),(6,3,'erer-1572013537','ererer','2019-10-25 12:25:37','2019-10-25 12:25:37',NULL),(7,5,'peni-1573346364','Penicille 200 mg 1-0-1','2019-11-09 23:39:24','2019-11-09 23:39:24',NULL),(8,5,'eree-1574268714','ereezz','2019-11-20 15:51:54','2019-11-20 15:51:54',NULL),(9,5,'sdfs-1574268714','sdfsdfsdf','2019-11-20 15:51:54','2019-11-20 15:52:02','2019-11-20 15:52:02'),(10,9,'amox-1574340542','amoxiciline','2019-11-21 11:49:02','2019-11-21 11:49:02',NULL),(11,9,'para-1574598285','Paracetamol 1 g 1-1-1-0','2019-11-24 11:24:45','2019-11-24 11:24:45',NULL),(12,9,'clop-1574598285','Clopidogrel 75 mg 0-0-0-1','2019-11-24 11:24:45','2019-11-24 11:24:45',NULL),(13,9,'simv-1574598285','Simvastatine 20 mg 0-0-0-1','2019-11-24 11:24:45','2019-11-24 11:24:45',NULL),(14,9,'aspi-1574598285','Aspirine 100 mg 0-0-0-1','2019-11-24 11:24:45','2019-11-24 11:24:45',NULL),(15,7,'para-1574607404','Paracetamool 500','2019-11-24 13:56:44','2019-11-24 13:56:44',NULL);
/*!40000 ALTER TABLE `traitement_actuels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `traitement_proposes`
--

DROP TABLE IF EXISTS `traitement_proposes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `traitement_proposes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `consultation_medecine_generale_id` bigint(20) unsigned NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intitule` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `traitement_proposes_slug_unique` (`slug`),
  KEY `traitement_proposes_consultation_medecine_generale_id_foreign` (`consultation_medecine_generale_id`),
  CONSTRAINT `traitement_proposes_consultation_medecine_generale_id_foreign` FOREIGN KEY (`consultation_medecine_generale_id`) REFERENCES `consultation_medecine_generales` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `traitement_proposes`
--

LOCK TABLES `traitement_proposes` WRITE;
/*!40000 ALTER TABLE `traitement_proposes` DISABLE KEYS */;
/*!40000 ALTER TABLE `traitement_proposes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `traitements`
--

DROP TABLE IF EXISTS `traitements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `traitements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `intitule` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `traitements_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `traitements`
--

LOCK TABLES `traitements` WRITE;
/*!40000 ALTER TABLE `traitements` DISABLE KEYS */;
/*!40000 ALTER TABLE `traitements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationalite` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quartier` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_postal` int(11) DEFAULT NULL,
  `ville` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `adresse` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin','Camerounaise','Akwa',4615,'Douala','Cameroun','698900294','admin@medicasure.com',NULL,'$2y$10$HhalUPBaWXh7QgFolSCS0emmkuCazgaAGd8gjB0rbeV5TQLZDJmHG','admin-1',NULL,NULL,NULL,NULL,NULL),(2,'ndefo dfdf','ERIC','eerezrz',NULL,NULL,'Bruxelles','Belgium','66565656565','tamarezo@yahoo.fr',NULL,'$2y$10$H3rTtxufs.APgwIiuiQ6YeVB.P4spyJ64LCLO6RJvWVqisVj1lp/6','eric-1570634327',NULL,'2019-10-09 13:18:47','2019-11-13 13:56:40',NULL,'Boulevard Leopold II, 219'),(3,'erzzezer',NULL,'sdfsdfsdf',NULL,NULL,'sdfsdfsdf','Australia','zerzerzerzerzerzer','nzo@yahoo.fr',NULL,'$2y$10$Cem9aGXwZemHPsG2dnL6vus5RbKaG2GBuVG9CwEuBPn2TQpLyhg1.','erzzezer-1570634461',NULL,'2019-10-09 13:21:01','2019-10-09 13:21:01',NULL,NULL),(4,'Eric',NULL,'sdsdf',NULL,NULL,'sdfsd','Antigua and Barbuda','sdfsdfddsfsd','tamarez4@yahoo.fr',NULL,'$2y$10$y7StMCHo1N8qXrTGmgYvguRBE4AKss5WbulhEyAVjRHEi9hZPJc1e','eric-1570634615',NULL,'2019-10-09 13:23:35','2019-10-14 09:19:12',NULL,NULL),(5,'zeazeaez',NULL,'fdfd',NULL,NULL,'dfdfd','Australia','zerzezerzerze','nzongang@yahoo.fr',NULL,'$2y$10$rE/r4fiqDkYmCfwEnigzaOBjkD1Pf6wfmjuFOolkZa4gh4yE3u58e','zeazeaez-1570638678',NULL,'2019-10-09 14:31:18','2019-10-09 14:31:18',NULL,NULL),(6,'zeazeaezdf',NULL,'fdfd',NULL,NULL,'dfdfd','Australia','zerzezerzerze','nzongan@yahoo.fr',NULL,'$2y$10$K1pS7oQJ/c5L5yGZJ1g4cODvOKTAM5f3UzhG0S/GZWB50rFPsLTlu','zeazeaezdf-1570638729',NULL,'2019-10-09 14:32:09','2019-10-09 14:32:09',NULL,NULL),(7,'Souscripteur',NULL,'Camerounaise',NULL,NULL,'Douala','Canada','691447817','souscripteur@test.com',NULL,'$2y$10$f5vfq3GhQ9SOd40T8VJtA.fV6zUX.UJD9xGDZZENQgRPDXzcEqxAC','souscripteur-1570695516',NULL,'2019-10-10 06:18:36','2019-10-10 06:18:36',NULL,NULL),(8,'eezerzer',NULL,'ertertert',NULL,NULL,'ertertert','Antigua and Barbuda','ertertetert','ned@eeere.be',NULL,'$2y$10$fWVN4nkx1afNQl7a8FP6IulYm4BsDmEcuavE/mDS3Ii8AM47XfKG6','eezerzer-1570697838',NULL,'2019-10-10 06:57:18','2019-10-10 06:57:18',NULL,NULL),(27,'Souscripteur',NULL,'Camerounaise',NULL,NULL,'Douala','Cameroon','691447817','souscripteur2@test.com',NULL,'$2y$10$9cXCYPcfKpS3Mv95svh4tuSOykN9kWUC4T58IKL6UW7HCPD9w8f1C','souscripteur-1570713513',NULL,'2019-10-10 11:18:33','2019-10-10 11:18:33',NULL,NULL),(28,'dfgdfgdfg',NULL,'sdfsdf',NULL,NULL,'sdfsd','Australia','321654987','df@sef.df',NULL,'$2y$10$qrUOXhnic1U.y/Lr3NGfO.G9KJdynIuR8Eex95z7ctkaqHnkbcl2a','dfgdfgdfg-1570713584',NULL,'2019-10-10 11:19:44','2019-10-10 11:19:44',NULL,NULL),(31,'dfsdfsd',NULL,'dsfsd',NULL,NULL,'sdfsd','Benin','sdfsddsfsdfds','nedz@eeere.be',NULL,'$2y$10$thfFxKc4tRVDdqlRuRfii.QDGijLKNhEfJxlWHCig7S9EdqX0tpwW','dfsdfsd-1570715042',NULL,'2019-10-10 11:44:02','2019-10-10 11:44:02',NULL,NULL),(34,'gestionnaire',NULL,'sdfsd',NULL,NULL,'fsdfsdf','Saint Barthélemy','dfgdfgdfgdfg','vgdhfgh@medicasure.com',NULL,'$2y$10$HJ9ickWCRvKip7u4ZBhNguJIRrlRliFcHneWNA1CC5BduDwNGcpr.','gestionnaire-1570783842',NULL,'2019-10-11 06:50:42','2019-10-11 06:50:42',NULL,NULL),(35,'eric','NDEFO','Camerounaise',NULL,NULL,'Douala','Belgium','685471235','ndefo@medicasure.com',NULL,'$2y$10$6EKYZzm/OUF6H0Tsba1EmOIaJ2aJXnhy7zZJpjosT2oquKJ7UFbk.','eric-1570784888',NULL,'2019-10-11 07:08:08','2019-11-13 13:47:17',NULL,'SFSDFSD'),(36,'gestionnaire',NULL,'dfgdf',NULL,NULL,'dfgdfg','Djibouti','698547423','ddgdfgdfg@medicasure.com',NULL,'$2y$10$PrIRRvjS0FfZ3oRVMkFiouGdW2dj0RLPU/h0oMvXA6Spc0ZcxWwMS','gestionnaire-1570798652',NULL,'2019-10-11 10:57:32','2019-10-11 10:57:32',NULL,NULL),(37,'dfdsfsdfsd','Tu','dsfdsfdsf',NULL,NULL,'sdfsdf','American Samoa','123878688','nzo@medicasure.com',NULL,'$2y$10$vFvSAX1w.UMoabBNdO2TmOoVdV/C05wMz9POOq2D5XeEEesstwI/i','dfdsfsdfsd-1570802530',NULL,'2019-10-11 12:02:10','2019-11-08 16:24:06',NULL,'Boulevard léopold II'),(38,'NLEND Rostand',NULL,'France',NULL,NULL,'Marseille','France','+237658965847','rostandnlend@test.test',NULL,'$2y$10$5h5coATDzxACz2vjPrsDEeAiBnuz1NfS/8Vnlla5kZKZC6aGOKZJq','nlend-rostand-1571135909',NULL,'2019-10-15 08:38:29','2019-10-15 08:38:29',NULL,NULL),(39,'LELIEVRE Michael',NULL,'Belgique',NULL,NULL,'Bruxelles','Belgium','+336589754125','lelievremichael@test.tes',NULL,'$2y$10$Ulv/eBlvHLb2w7Wcxgq0iuw/H.0vzBA4SiYPztKrGGvUyPamjzVhe','lelievre-michael-1571136031',NULL,'2019-10-15 08:40:31','2019-10-15 08:40:31',NULL,NULL),(40,'DINO Louis',NULL,'Cameroun',NULL,NULL,'Yaoundé','Cameroon','+237695869632','dino@test.test',NULL,'$2y$10$w0756xGeMcGAwJqbdvqWR.zgRVWX90AmkSasYQqh5DAtWZEy0GMBy','dino-louis-1571136312',NULL,'2019-10-15 08:45:12','2019-10-15 08:45:12',NULL,NULL),(41,'RAMBO Rambo',NULL,'Cameroun',NULL,NULL,'Douala','Cameroon','+237652362541','rambo@test.tes',NULL,'$2y$10$gsAEGE1dv1/Y9zsI1KezseQO81ICmVAeqSZOOpJ4xQEhyb19Gk3he','rambo-rambo-1571136496',NULL,'2019-10-15 08:48:16','2019-10-16 07:29:54',NULL,NULL),(42,'EL PRESIDENTE',NULL,'Italie',NULL,NULL,'Torino fd','Belgium','+12563547896','elpresidentemaestro@gmail.com',NULL,'$2y$10$sNrCBLZKEeX14ngJPpfJDucP1U9JJahwoUzErVTT64eAFyTVUvoQ6','el-presidente-1571136673',NULL,'2019-10-15 08:51:13','2019-10-16 07:31:55',NULL,NULL),(43,'Docta','Doc','USA',NULL,NULL,'Vice city','United States Minor Outlying Islands','+1256354126','test@test.test',NULL,'$2y$10$bz7cXUiMALsWERc1/umZ5efJy9SPugs/g7.yE1oHkj20gfM7yJDPy','docta-1571138157',NULL,'2019-10-15 09:15:57','2019-10-15 11:17:06',NULL,NULL),(44,'LEDOC','Ledoc','Cameroun',NULL,NULL,'Douala','Cameroon','+23758969585','roosvelttresor@yahoo.fr',NULL,'$2y$10$0Yanc2H7wwEoaQ2W0OI5nOH.euxqD.aE3U7OgN8cWI0bsx1CwdV1u','ledoc-1571144943',NULL,'2019-10-15 11:09:03','2019-10-15 11:09:03',NULL,NULL),(45,'TEST','Test','Cameroun',NULL,NULL,'Yaoundé','Cameroon','+237654123652','tessa@medicasure.com',NULL,'$2y$10$T9LyoJGAtiLsRV9FlbgSaOUi2Hfwq/2DxDhVsoIUCWHJUVUOFyA2m','test-1571145310',NULL,'2019-10-15 11:15:10','2019-10-15 11:15:10',NULL,NULL),(46,'TESTSOUSCRIP',NULL,'Cuba',NULL,NULL,'mangekan','Cuba','+12563958478','texroos@live.be',NULL,'$2y$10$yv80PmNwNX6C5sW0A.vkL..vRJS0xfKjBYNMtltsJQwLVWbebkWXu','testsouscrip-1571145563',NULL,'2019-10-15 11:19:23','2019-10-15 11:19:23',NULL,NULL),(47,'Kadji','Charly','Allemand',NULL,NULL,'lambert','Algeria','0475623236','charly.ka@live.be',NULL,'$2y$10$NnDqlS10I1I4zedz0uvLpefyofT1XeBp8XLtFtQcXpny9/mq4iKnq','pepsi-charly-1571164817',NULL,'2019-10-15 16:40:17','2019-11-12 17:53:30',NULL,'Boulevard léopold II'),(48,'JESUSfictif',NULL,'syrien',NULL,NULL,'douala','Brazil','2572525776','passypass@yahoo.fr',NULL,'$2y$10$SFTG5VPfiyDZqbOp.WWU8OBFezYsIfPG3E/x/uxi75AW4l23qIqxq','jesusfictif-1571165162',NULL,'2019-10-15 16:46:02','2019-10-16 07:29:16',NULL,NULL),(49,'dfgdfgdfgdf',NULL,'dfgdfgdf',NULL,NULL,'dfgdfgd','Azerbaijan','dfgdfgdfgdfgdfg','dfgdfgdfg@dfsf.df',NULL,'$2y$10$ycV1pZaMfZ9OTDrE9n0gk.Uh4.oiwKxVjCgCMpXZZbRgkCyKoowAG','dfgdfgdfgdf-1571226396',NULL,'2019-10-16 09:46:36','2019-10-16 09:46:36',NULL,NULL),(50,'Nkouekam','wilfried','Camerounaise',NULL,NULL,'zcsdf','Anguilla','6710326565','nkouekam@medicasure.com',NULL,'$2y$10$HhalUPBaWXh7QgFolSCS0emmkuCazgaAGd8gjB0rbeV5TQLZDJmHG','nkouekam-1571424920',NULL,'2019-10-18 16:55:20','2019-11-14 17:14:00',NULL,'sdfsdfsdfsdf'),(51,'Eric','NDEFO','Belgique',NULL,NULL,'HYUbhg','Anguilla','+32489393214','NZoWarlock@gmail.com',NULL,'$2y$10$KLFSgp7t3J/LzFW1XXTcFe8hnc6brHaubIfGeWm4htfqp9WM349l6','eric-1573479759',NULL,'2019-11-11 12:42:40','2019-11-11 12:42:40',NULL,'KIHN'),(52,'azongmo','Michel','Belgique',NULL,NULL,'Molenbeek','Cameroon','+32489393214','souscripteur2@test.com',NULL,'$2y$10$LeL8q1DojHFpPWUNNlL.x.fwFIZ78Rt19iQzXQuIBAx46sKva332C','azongmo-1573517982',NULL,'2019-11-11 23:19:42','2019-11-11 23:19:42',NULL,'Boulevard leopold II 219'),(53,'azongmo','Michel','Belgique',NULL,NULL,'Molenbeek','Cameroon','+32489393214','souscripteur2@test.com',NULL,'$2y$10$4DzqIJxVI1U.mfTdtqpnmeefIrF0fW7eCq2FUkqh8XNfjZoO5tQXq','azongmo-1573517985',NULL,'2019-11-11 23:19:45','2019-11-11 23:19:45',NULL,'Boulevard leopold II 219'),(54,'Bekolo','Jean Jambon','Belgique',NULL,NULL,'Bruxelles','Aruba','+32489393214','tamarez@yahoo.fr',NULL,'$2y$10$Lg8UMAeDxTmOthWjUIlQ8.5M8hfxxyEyO4i8njmMMow6MudOkKqLq','bekolo-1573577227',NULL,'2019-11-12 15:47:07','2019-11-12 15:47:07',NULL,'Rue Moris'),(55,'NDEFO','Eric','Belgique',NULL,NULL,'Molenbeek','Belgium','32489393214','eric@medicasure.com',NULL,'$2y$10$HhalUPBaWXh7QgFolSCS0emmkuCazgaAGd8gjB0rbeV5TQLZDJmHG','ndefo-1573746450',NULL,'2019-11-14 14:47:30','2019-11-14 14:47:30',NULL,'Boulevard leopold II 219'),(57,'Emmanuel','Emmanuel','sfsdfsdfsdf',NULL,NULL,'sdfdsf','Åland Islands','684571231','emmanuel@medicasure.com',NULL,'$2y$10$HhalUPBaWXh7QgFolSCS0emmkuCazgaAGd8gjB0rbeV5TQLZDJmHG','emmanuel-1573751974',NULL,'2019-11-14 16:19:34','2019-11-14 16:19:34',NULL,'sdfsdf'),(58,'Wilfried','Gestionnaire','sdfsfsdfsdf',NULL,NULL,'sdfsdf','Åland Islands','654132798','wilfried@medicasure.com',NULL,'$2y$10$HhalUPBaWXh7QgFolSCS0emmkuCazgaAGd8gjB0rbeV5TQLZDJmHG','wilfried-1573752199',NULL,'2019-11-14 16:23:19','2019-11-14 16:23:19',NULL,'sdfsdfsd'),(59,'Mbouga','Wilfried','Camerounaise',NULL,NULL,'qwerty','Armenia','6987452123','mbouga@medicasure.com',NULL,'$2y$10$HhalUPBaWXh7QgFolSCS0emmkuCazgaAGd8gjB0rbeV5TQLZDJmHG','mbouga-1573756031',NULL,'2019-11-14 17:27:11','2019-11-14 17:27:11',NULL,'ddfgdfg'),(60,'Nde','martial','Belgique',NULL,NULL,'Bruxelles','Belgium','+32489393214','emmanuel@medicasure.com',NULL,'$2y$10$05O/VYG/SpVXd1hCkicn.uFZM/eouf5R4xSXfuEFGQ8ZNhxzwszH6','nde-1574619366',NULL,'2019-11-24 17:16:06','2019-11-24 17:16:06',NULL,'Rue Moris'),(63,'eric','eric','fghtyruutuyiu',NULL,NULL,'gghfhgg','Anguilla','312654987','eric@sense-agency.eu',NULL,'$2y$10$uRFXogIZCUn98qgd59X5dOKvA.OM/KVJKJgFHbfdBEqaHzSD5xAe6','eric-1574620242',NULL,'2019-11-24 17:30:42','2019-11-24 17:30:42',NULL,'ghfdghdhgdg');
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

-- Dump completed on 2019-11-25 10:04:01
