CREATE DATABASE  IF NOT EXISTS `bitter_phoebe` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `bitter_phoebe`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: bitter_phoebe
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Table structure for table `follows`
--

DROP TABLE IF EXISTS `follows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follows` (
  `follow_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  PRIMARY KEY (`follow_id`),
  KEY `FK_follows` (`from_id`),
  KEY `FK_follows2` (`to_id`),
  CONSTRAINT `FK_follows` FOREIGN KEY (`from_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `FK_follows2` FOREIGN KEY (`to_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follows`
--

LOCK TABLES `follows` WRITE;
/*!40000 ALTER TABLE `follows` DISABLE KEYS */;
INSERT INTO `follows` VALUES (27,29,28),(28,30,29),(29,30,28),(30,28,27),(51,47,29),(52,47,48),(53,47,49),(54,47,27),(55,30,27),(56,28,30),(57,28,29),(58,48,30),(59,28,47),(60,28,49),(61,28,48),(62,48,29),(63,48,28),(64,48,47),(65,29,27),(66,29,49),(67,29,30),(68,29,47),(69,30,49),(70,27,30),(71,50,28),(72,50,29),(73,50,27),(74,29,50),(75,29,52),(76,29,48),(77,27,29),(78,29,53),(79,30,47),(80,30,52),(81,30,50),(82,30,55),(83,65,28),(84,65,30),(85,65,29);
/*!40000 ALTER TABLE `follows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`like_id`),
  KEY `FK_tweet_id_idx` (`tweet_id`),
  KEY `FK_user_id_idx` (`user_id`),
  CONSTRAINT `FK_tweet_id` FOREIGN KEY (`tweet_id`) REFERENCES `tweets` (`tweet_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (1,239,50,'2019-11-28 01:48:58'),(2,237,50,'2019-11-28 01:49:11'),(3,238,50,'2019-11-28 01:59:44'),(4,236,50,'2019-11-28 01:59:47'),(5,235,50,'2019-11-28 14:18:24'),(6,234,50,'2019-11-28 14:18:27'),(7,230,50,'2019-11-28 14:18:31'),(8,223,50,'2019-11-28 14:18:48'),(9,226,65,'2019-12-03 17:28:24'),(10,228,65,'2019-12-03 17:32:20'),(11,226,65,'2019-12-03 17:51:23'),(13,226,65,'2019-12-03 17:51:28'),(14,226,65,'2019-12-03 17:51:30'),(15,226,65,'2019-12-03 17:51:34'),(16,226,65,'2019-12-03 17:51:41'),(17,226,65,'2019-12-03 17:58:10'),(18,226,65,'2019-12-03 17:58:11'),(19,226,65,'2019-12-03 17:58:12'),(20,226,65,'2019-12-03 17:58:22'),(21,226,65,'2019-12-03 17:59:13'),(22,226,65,'2019-12-03 17:59:14'),(23,226,65,'2019-12-03 17:59:14'),(24,240,65,'2019-12-03 18:03:50'),(25,233,65,'2019-12-03 18:04:18'),(26,241,65,'2019-12-03 18:06:24'),(27,236,65,'2019-12-03 18:06:37'),(28,234,65,'2019-12-03 18:06:46'),(29,235,65,'2019-12-03 18:08:38'),(30,225,65,'2019-12-03 18:09:00'),(31,222,65,'2019-12-03 18:09:05'),(32,232,65,'2019-12-03 18:23:58'),(33,240,30,'2019-12-03 20:53:45'),(34,239,30,'2019-12-03 20:53:48'),(35,237,30,'2019-12-03 20:53:50'),(36,238,30,'2019-12-03 20:53:53'),(37,236,30,'2019-12-03 20:53:55'),(38,235,30,'2019-12-03 20:53:58'),(39,234,30,'2019-12-03 20:54:00'),(40,230,30,'2019-12-03 20:54:05'),(41,236,29,'2019-12-04 18:57:16'),(42,239,29,'2019-12-04 19:07:07');
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `message_text` varchar(255) NOT NULL,
  `date_sent` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_toid_idx` (`id`,`from_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (7,29,28,'hi','2019-12-03 14:33:01'),(8,28,29,'hi2','2019-12-03 14:50:54'),(9,29,27,'nnnn','2019-12-04 14:45:14'),(10,29,27,'Hello Nick!','2019-12-04 14:45:37'),(11,27,29,'Hi Marcus!','2019-12-04 15:06:35'),(12,29,28,'Hi Phoebe! From Marcus','2019-12-06 08:44:12'),(14,28,27,'hi','2019-12-06 11:56:57'),(15,28,27,'Hello Nick!','2019-12-06 12:36:57');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweets`
--

DROP TABLE IF EXISTS `tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweets` (
  `tweet_id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_text` varchar(280) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `original_tweet_id` int(11) NOT NULL DEFAULT '0',
  `reply_to_tweet_id` int(11) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tweet_id`),
  KEY `FK_tweets` (`user_id`),
  CONSTRAINT `FK_tweets` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=244 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweets`
--

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;
INSERT INTO `tweets` VALUES (222,'don\'t',29,0,0,'2019-11-08 02:21:37'),(223,'My tweet',29,0,0,'2019-11-08 02:39:37'),(224,'Hi Marcus, How are you?',30,0,223,'2019-11-08 02:40:20'),(225,'Hi Marina!',28,0,224,'2019-11-08 02:41:41'),(226,'My tweet',28,223,0,'2019-11-08 02:41:49'),(227,'My tweet',50,226,0,'2019-11-08 02:45:02'),(228,'Hi Phoebe',50,0,226,'2019-11-08 02:45:17'),(229,'This is my tweet',50,0,0,'2019-11-08 02:45:35'),(230,'Marina - Tim _Nick',50,0,229,'2019-11-08 02:46:02'),(231,'Marina-Tim_d d',50,0,230,'2019-11-08 02:47:35'),(232,'My first tweet',30,0,0,'2019-11-17 20:10:17'),(233,'My tweet',30,226,0,'2019-11-17 20:10:22'),(234,'My tweet',29,233,0,'2019-11-18 02:39:58'),(235,'This is my tweet',29,229,0,'2019-11-20 04:01:01'),(236,'This is my tweet',29,235,0,'2019-11-22 14:18:04'),(237,'hhh',27,0,0,'2019-11-22 14:19:26'),(238,'My reply',27,0,237,'2019-11-22 14:19:35'),(239,'My tweet',27,233,0,'2019-11-22 14:19:39'),(240,'My tweet',30,239,0,'2019-11-22 18:10:50'),(241,'My tweet',65,240,0,'2019-12-03 18:06:18'),(242,'My tweet',29,239,0,'2019-12-04 19:07:13'),(243,'Hi Marina!',29,0,240,'2019-12-04 19:07:25');
/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `screen_name` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `address` varchar(200) NOT NULL,
  `province` varchar(50) NOT NULL,
  `postal_code` varchar(7) NOT NULL,
  `contact_number` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `url` varchar(50) NOT NULL,
  `description` varchar(160) NOT NULL,
  `location` varchar(50) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_pic` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (27,'Nick','Taggart','nick','$2y$10$SZy95ydratulMUkrOZZZ1eHCufqRE07VsqA5vqEHJhLcd0yqU3wSS','Fredericton','New Brunswick','E4R4R4','888 888 8888','nick.taggart@nbcc.ca','1','1','1','2019-10-25 08:53:19','27_1571982831.png'),(28,'Phoebe','Nguyen','phoebe','$2y$10$KkjwWIDrzcquLvTmGrGb3u9LrllR7GaZ8yXqvDj5OhPqHbBZ2vEU6','1','Newfoundland and Labrador','i8i8i8','777 777 7777','pn','1','1','1','2019-10-25 08:25:37','28_1573180955.jpg'),(29,'Marcus','Balogh','marcus','$2y$10$fpfVucX5c1dVs5HvIBwTBOa/klQwf6gM/nOsRwEptWowvVgKRYynS','1','Nunavut','w2w2w2','222 222 2222','gg','1','1','1','2019-10-25 08:49:25','29_1573178390.png'),(30,'Marina','Libin','marina','$2y$10$QEm2BM673X.sXrWFX9YVH.CYwK8a31ewoNYPwB.22qFGyndYYSmoC','1','Northwest Territories','o9o9o9','999 999 9999','hh','1','1','1','2019-10-25 08:31:00','30_1571982878.png'),(47,'Tim','Smith','tim','$2y$10$o1J31.a47EsdN2XTk//OGusQw4DS.jO3UNzPQXrvnqQt0n0ENOFBO','3','Nunavut','w2w2w2','222 222 2222','dd@dd.com','3','3','3','2019-10-29 14:26:36','47_1572653016.jpg'),(48,'d','d','class1','$2y$10$m.V5OYkr/9GjlnGZKIbryOAKv0OTrE9ZQkL.jxUphLDaCfqcPiNw.','2','Nunavut','o9o9o9','000 000 0000','tt@f.com','ff','ff','ff','2019-11-01 17:32:09',NULL),(49,'d','d','class2','$2y$10$FTOpRcxhahf1douMUayVoe.DjpldcHUlOTOF8fFh3j1qbAWM5dDSe','2','Nunavut','o9o9o9','000 000 0000','tt@f.com','ff','ff','ff','2019-11-01 17:44:14',NULL),(50,'Josh','J','josh','$2y$10$ZBXAEfGy5rrYnSVD62WAeOHXMBM0knNsvgWXWmWJtCMhMyZUlELdC','1','Nunavut','i8i8i8','999 999 9999','h@dd.com','w','w','w','2019-11-08 02:44:13','50_1573181225.png'),(51,'as','s','as','$2y$10$R/C5fxIbSaxzALjturUbg.d8TGY.weaR66y/B/w6J91gMgAWY6Av.','q','New Brunswick','E3B2Y1','888 888 8888','ss@gmail.com','q','q','q','2019-11-20 03:03:06',NULL),(52,'as','s','asa','$2y$10$w21i.7j81JdvCoFoLUZKN.VVfbYFGE.H8Rh.geSVE3iIQWC7APs9m','q','New Brunswick','E3B2Y1','888 888 8888','ss@gmail.com','q','q','q','2019-11-20 03:14:42',NULL),(53,'as','as','as11','$2y$10$Yci1yAFFN1BBy3FhFpfbUOZzNk7oxaocelZtRobpT/aIePzXfitCS','as','New Brunswick','E3B2Y9','111 111 1111','PHOEBE@GMAIL.COM','AS','AS','AS','2019-11-20 03:17:19',NULL),(54,'as','as','as111','$2y$10$1NnuvtQdeVdZRU4X0heNWO4Txvug56CDJpbZ3gonHDplVFBuFPke6','as','Ontario','M4B 1B3','111 111 1111','PHOEBE@GMAIL.COM','AS','AS','AS','2019-11-20 03:18:55',NULL),(55,'d','d','peter','$2y$10$bSFoJNVa8.F9WeJiH21SzeQZV2tFhuimh9ESSWAaIleAaWsJzwzky','1','New Brunswick','e3b2y1','111 111 1111','ee@gmail.com','1','1','1','2019-11-22 14:24:40',NULL),(56,'Riley','d','riley','$2y$10$2WhVkgGgZh9TyYcbcgxwZO8JbGKuwcIVx8CRVMnwdbxQk7N0zngJ6','d','New Brunswick','e3b2y1','444 444 4444','hh@hotmail.com','a','a','a','2019-11-22 17:36:46',NULL),(57,'Riley1','d','riley1','$2y$10$xCwfVc7u8hX10GhocWKN6.wbQ6wM4YioDJH9qpnkE.poB/a3wufca','d','British Columbia','V8L 6V9','444 444 4444','hh@hotmail.com','a','a','a','2019-11-22 17:38:28',NULL),(58,'Riley1','d','riley3','$2y$10$ECE.n6me402W7.82k0R0vOgx6E9ENLqGlPZouYK1GgyOQFibiXmQa','d','Nova Scotia','B4V 9G9','444 444 4444','hh@hotmail.com','a','a','a','2019-11-22 17:40:57',NULL),(59,'Riley1','d','riley5','$2y$10$XiUQ8OYT2PHoxxB9hIupzOXYDi6aYdHQtsoPhW.YmEabPyCEYPnuq','d','Newfoundland and Labrador','A1C 1M3','444 444 4444','hh@hotmail.com','a','a','a','2019-11-22 17:48:03',NULL),(60,'Riley1','d','riley7','$2y$10$0LmV4.ZViMW/11e//bbecuLu.9bLQJj7h3YxXsgiZ5vdJf7ytudVC','d','Prince Edward Island','C1A 4R3','444 444 4444','hh@hotmail.com','a','a','a','2019-11-22 17:50:08',NULL),(61,'Riley1','d','riley8','$2y$10$RalfsM0hOrOscOhQpQY9xOrTIK0AR4S3PRXzPXFFndEQzOU56.pGS','d','Quebec','G2G 0J4','444 444 4444','hh@hotmail.com','a','a','a','2019-11-22 17:51:54',NULL),(62,'Riley1','d','riley9','$2y$10$J2JpLTdeIGGbMLs4lvoxC.oZ1jVuMelhHZVFgdKpPrqDAg1uRYdJe','d','Manitoba','R3C 1S4','444 444 4444','hh@hotmail.com','a','a','a','2019-11-22 17:52:40',NULL),(63,'Riley1','d','riley10','$2y$10$sMsMGI98RthcPWY4eTf6XOXTGgScEfOEMbHxc12jyKqjLvTiHPMiO','d','Northwest Territories','X0A 0H0','444 444 4444','hh@hotmail.com','a','a','a','2019-11-22 18:01:24',NULL),(64,'Riley1','d','riley11','$2y$10$5QVpMBWSl.pZDn3IYWlQA.48EeDW2fK1ycsQggrDdkC1r1qE2Sc7.','d','Newfoundland and Labrador','a1a0b3','444 444 4444','hh@hotmail.com','a','a','a','2019-11-22 18:03:00',NULL),(65,'fff','ffff','jen','$2y$10$DJkVQdHKLAbIZxczc8id0OsXS5cxedW5/tM/K.a2V.cnUOLBnOwKu','yy','New Brunswick','e3b2y1','999 999 9999','g@gmail.com','f','f','f','2019-12-03 02:00:34',NULL),(66,'ee','ee','kevin','$2y$10$7d.V2OfKOlf93DT01EK2Wu1PnxRkAyr7bZY3srUX/KnPAlr5Qrm9K','hh','New Brunswick','e3b2y1','(999) 999-9999','e@gmail.com','1','1','1','2019-12-04 02:03:08',NULL),(67,'Willy','Sawayn','kev','$2y$10$9xo4wfDPXmV8a0CQ6tho8.Kkgbd0SmY53FtXMj0t2yaIh3ERBlO22','01473 Maryln Route','New Brunswick','E3B2Y1','(236) 128-2071','kev@gmail.com','www.carlita-krajcik.com','All browsers support the hex definitions #chuck and #norris for the colors black and blue.','Haneland','2019-12-04 03:01:29',NULL);
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

-- Dump completed on 2019-12-06 12:40:46
