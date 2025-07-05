-- MySQL dump 10.13  Distrib 5.7.43, for Linux (x86_64)
--
-- Host: localhost    Database: cloakmedb
-- ------------------------------------------------------
-- Server version	5.7.43

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
-- Table structure for table `subscribers`
--

DROP TABLE IF EXISTS `subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `subscribed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscribers`
--

LOCK TABLES `subscribers` WRITE;
/*!40000 ALTER TABLE `subscribers` DISABLE KEYS */;
INSERT INTO `subscribers` VALUES (1,'test@gmail.com','2025-06-25 03:56:06'),(2,'sheetalkamble84@gmail.com','2025-06-25 03:59:04'),(3,'mandar.satam@gmail.com','2025-07-01 13:47:18'),(6,'john.smith@gmail.com','2025-07-01 17:32:41'),(7,'pkrish2508@gmail.com','2025-07-02 04:47:10'),(8,'prasadkamblekamble93@gmail.com','2025-07-03 16:39:04'),(16,'ashukjain25@gmail.com','2025-07-03 16:41:01'),(17,'rjshahkop@gmail.com','2025-07-03 17:04:35'),(21,'nyalangobey@gmail.com','2025-07-03 17:07:03'),(30,'abhishekchauhan31543@gmail.com','2025-07-04 04:05:35'),(33,'prasantaroy@gmail.com','2025-07-04 04:20:42'),(34,'shahmusa2710@gmail.com','2025-07-04 09:08:53'),(35,'ganeshraykar519@gmail.com','2025-07-04 14:12:05'),(36,'ganeshraykar519@gamil.com','2025-07-04 14:13:08'),(37,'ankitsolanki9248@gmail.com','2025-07-04 15:02:31'),(41,'jitendrabagwane@gmail.com','2025-07-04 15:05:36'),(42,'midhunrajmundur@gmail.com','2025-07-04 15:15:45');
/*!40000 ALTER TABLE `subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `breach_count` int(11) DEFAULT '0',
  `last_scan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@example.com','$2y$10$KtzZ1g4kVYuHV2jO1bMZduA8LCtU2GC1IB8mcjwnAxxTAVQ9iR/jq','admin',0,'2025-06-06 03:57:30'),(2,'mandar.satam@gmail.com','$2y$10$k19yCFA9t9GPzvR9sTv9P.87hqmigwJRq2Hl1YovlkgcXxxWe.Ovm','user',0,'2025-06-06 03:58:44'),(4,'sheetalkamble84@gmail.com','$2y$10$gTC9d634eV0AhYJa2Ca72e2fkJmo3Z1mVksLdU1V8OI3CyrUjKEy.','user',0,'2025-06-23 05:54:15'),(5,'test@example.com','$2y$10$g18ku5t8SjxezvFO9uuOre/Kwl5uDVBvQDpCruAPLUU1QjEn.YIAe','user',0,'2025-06-25 05:39:22'),(6,'pkrish2508@gmail.com','$2y$10$fwd3kA0Z79givZBDuH3rxu4RCIWZRNO6ewk.UByBkCAem/65Gv1A.','user',0,'2025-07-02 04:48:04'),(7,'nyalangobey@gmail.com','$2y$10$I9I8cE2GFx3rdgkVYB3HX.1ck/KOwnQeMTlFJhouMeKxFAYo/TRLO','user',0,'2025-07-03 17:09:43'),(8,'jpky12345@gmail.com','$2y$10$WS11hLdSG/EPJ33J1vWfqeUAYoOnrFNrt5VRL8pNw3xcPZbWFn0Lq','user',0,'2025-07-04 04:04:32'),(9,'mkrjrakib765@gmail.com','$2y$10$w4J2TPysrFvp21gddFnIM.UhXnxKd9F7J7exP3aKrG8y9e5JN7LJG','user',0,'2025-07-04 04:12:45'),(10,'mahammadshfijamadarmahammaddj@gmail.com','$2y$10$gx9yMkOdPnMz.UF22q0QEOKGDbaCCpjp.p5y0PT7n/AUwiv5EXfpq','user',0,'2025-07-04 04:25:39');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vault_files`
--

DROP TABLE IF EXISTS `vault_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vault_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `path` text NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `vault_files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vault_files`
--

LOCK TABLES `vault_files` WRITE;
/*!40000 ALTER TABLE `vault_files` DISABLE KEYS */;
INSERT INTO `vault_files` VALUES (1,2,'MandarSatam-Security_R3.pdf','../vault/2_1750053001_MandarSatam-Security_R3.pdf','2025-06-16 05:50:01'),(2,2,'MandarSatam-Security_R2 .docx','../vault/2_1750116599_MandarSatam-Security_R2 .docx','2025-06-16 23:29:59'),(3,2,'MandarSatam-Security_R3.pdf','../vault/2_1750117085_MandarSatam-Security_R3.pdf','2025-06-16 23:38:05'),(4,2,'','../vault/2_1750732621_','2025-06-24 02:37:01');
/*!40000 ALTER TABLE `vault_files` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-05 15:44:05
