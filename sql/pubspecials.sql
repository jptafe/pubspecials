-- MySQL dump 10.16  Distrib 10.2.17-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: pubspecials
-- ------------------------------------------------------
-- Server version	10.2.17-MariaDB

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
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `special_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `special_id` (`special_id`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`special_id`) REFERENCES `special` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pub`
--

DROP TABLE IF EXISTS `pub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pub` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `address` varchar(255) NOT NULL,
  `suburb` varchar(32) NOT NULL,
  `state` varchar(28) NOT NULL,
  `postcode` int(5) NOT NULL,
  `logo` varchar(128) DEFAULT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pub`
--

LOCK TABLES `pub` WRITE;
/*!40000 ALTER TABLE `pub` DISABLE KEYS */;
INSERT INTO `pub` VALUES (1,'Tipplers Tap','5/182 Gray St SOUTH BRISBANE','SOUTH BRISBANE','Qld',4101,NULL,-27.4801,153.023,'2018-09-09 23:47:11'),(2,'The Fox Hotel','71-73 Melbourne Street SOUTH BRISBANE','SOUTH BRISBANE','Qld',4101,NULL,-27.4742,153.017,'2018-09-09 23:47:11'),(3,'The Archive','100 Boundary Street WEST END','WEST END','Qld',4101,NULL,-27.4791,153.013,'2018-09-09 23:47:11'),(4,'Redbrick Hotel','83 Annerley Rd, Woolloongabba QLD 4102','Woolloongabba','Qld',4101,NULL,-27.4898,153.027,'2018-09-09 23:47:11'),(6,'Junction Hotel','Ipswich Rd & Annerley Rd, Annerley QLD 4103','Annerley','Qld',4103,NULL,-27.5093,153.033,'2018-09-09 23:47:11'),(8,'Hotel West End','10 Browning St, South Brisbane QLD 4101','South Brisbane','QLD',4101,NULL,-27.4775,153.013,'2018-09-17 02:17:08'),(9,'Archive Beer Boutique','100 Boundary St, West End QLD 4101','West End','Qld',4101,NULL,-27.4792,153.013,'2018-09-17 02:20:40'),(10,'Brisbane Brewing Co','124 Boundary St, West End QLD 4101','West End','QLD',4101,NULL,-27.4801,153.012,'2018-09-17 02:22:00'),(11,'The Milk Factory Kitchen & Bar','48 Montague Rd, South Brisbane QLD 4101','South Brisbane','QLD',4101,NULL,-27.4719,153.014,'2018-09-17 02:23:58'),(12,'Peel Street Tavern','35 Peel St, South Brisbane QLD 4101','South Brisbane','QLD',4101,NULL,-27.4731,153.014,'2018-09-17 02:24:48'),(13,'Pig \'N\' Whistle West End\r\n','Merivale St, South Brisbane QLD 4101','South Brisbane','QLD',4101,NULL,-27.4755,153.016,'2018-09-17 02:26:30'),(14,'The Fox Hotel','71-73 Melbourne St, South Brisbane QLD 4101','South Brisbane QLD 4101','QLD',4101,NULL,-27.4747,153.018,'2018-09-17 02:27:23'),(15,'Saccharomyces Beer Cafe\r\n','Fish Ln, South Brisbane QLD 4101','South Brisbane','QLD',4101,NULL,-27.4745,153.017,'2018-09-17 02:28:21'),(16,'The Charming Squire\r\n','3/133 Grey St, South Brisbane QLD 4101','South Brisbane','Qld',4101,NULL,-27.4759,153.019,'2018-09-17 02:29:21'),(17,'The Plough Inn\r\n','29 Stanley St Plaza, South Brisbane QLD 4101','South Brisbane','QLD',4101,NULL,-27.4781,153.022,'2018-09-17 02:30:31'),(18,'Tippler\'s Tap\r\n','5/182 Grey St, South Brisbane QLD 4101','South Brisbane','QLD',4101,NULL,-27.4802,153.022,'2018-09-17 02:32:17'),(19,'Hop And Pickle\r\n','6e Little Stanley St, South Brisbane QLD 4101','SOUTH BRISBANE','QLD',4101,NULL,-27.4802,153.022,'2018-09-17 02:32:17'),(20,'The Ship Inn\r\n','Sidon St, South Brisbane QLD 4101','South Brisbane','QLD',4101,'',-27.4819,153.025,'2018-09-17 02:33:32'),(21,'Brewhouse','601 Stanley St, Woolloongabba QLD 4102','Woolloongabba','QLD',4102,NULL,-27.4862,153.029,'2018-09-17 02:36:14'),(22,'Morrison Hotel','640 Stanley St, Woolloongabba QLD 4102','Woolloongabba','QLD',4102,NULL,-27.4863,153.029,'2018-09-17 02:36:14'),(23,'Woolloongabba Hotel\r\n','17/803 Stanley St, Woolloongabba QLD 4102','Woolloongabba','QLD',4102,NULL,-27.4871,153.035,'2018-09-17 02:37:25'),(24,'Australian National Hotel','867 Stanley St, Woolloongabba QLD 4102','Woolloongabba','QLD',4102,NULL,-27.4877,153.036,'2018-09-17 02:39:19'),(25,'Pineapple Hotel','706 Main St, Kangaroo Point QLD 4169','Kangaroo Point','QLD',4169,NULL,-27.4818,153.033,'2018-09-17 02:39:19'),(26,'Story Bridge Hotel','200 Main St, Kangaroo Point QLD 4169','Kangaroo Point','QLD',4169,NULL,-27.4699,153.034,'2018-09-17 02:40:12'),(27,'The Bavarian Beer Cafe\r\n','1/45 Eagle St, Brisbane City QLD 4000','Brisbane','QLD',4000,NULL,-27.4688,153.032,'2018-09-17 02:41:21'),(28,'Lord Stanley Hotel\r\n','994 Stanley St E, East Brisbane QLD 4169','East Brisbane','QLD',4169,NULL,-27.4956,153.03,'2018-09-17 02:42:29'),(29,'Norman Hotel','102 Ipswich Rd, Woolloongabba QLD 4102','Woolloongabba','QLD',4102,NULL,-27.4956,153.03,'2018-09-17 02:43:16'),(30,'Stones Corner Hotel\r\n','346 Logan Rd, Stones Corner QLD 4120','Stones Corner','QLD',4120,NULL,-27.4985,153.042,'2018-09-17 02:44:15'),(31,'Chardons Corner Hotel\r\n','7 Cracknell Rd, Annerley QLD 4103','Annerley','QLD',4103,NULL,-27.5161,153.031,'2018-09-17 02:45:29'),(32,'Holland Park Hotel\r\n','945 Logan Rd, Holland Park QLD 4121','Holland Park','QLD',4121,NULL,-27.5126,153.042,'2018-09-17 02:46:27'),(33,'The Red Lion Hotel\r\n','215 Beaudesert Rd, Moorooka QLD 4105','Moorooka','QLD',4105,NULL,-27.5441,153.034,'2018-09-17 02:48:50'),(34,'Salisbury Hotel Motel\r\n','668 Toohey Rd, Salisbury QLD 4107','Salisbury','QLD',4107,NULL,-27.5441,153.034,'2018-09-17 02:49:37'),(35,'Sunnybank Hotel\r\n','275 McCullough St, Sunnybank QLD 4109','Sunnybank','QLD',4109,NULL,-27.5441,153.034,'2018-09-17 02:50:24'),(36,'The Glen Hotel\r\n','24 Gaskell St, Eight Mile Plains QLD 4113','Eight Mile Plains','QLD',4113,NULL,-27.5441,153.034,'2018-09-17 02:51:28'),(37,'Corinda Tavern','651 Oxley Rd, Corinda QLD 4075','Corinda','QLD',4075,NULL,-27.5506,152.985,'2018-09-17 02:53:21'),(38,'Oxley Hotel','Cnr Ipswich & Oxley Roads, Oxley QLD 4075','Oxley','QLD',4075,NULL,-27.5506,152.985,'2018-09-17 02:53:21'),(39,'Oxley Tavern','146 Blunder Rd, Oxley QLD 4075','Oxley','QLD',4075,NULL,-27.5506,152.985,'2018-09-17 02:54:58'),(40,'Hotel Monier','168/176 Monier Rd, Darra QLD 4076','Darra','QLD',4076,NULL,-27.5506,152.985,'2018-09-17 02:54:58'),(41,'Centenary Tavern','96 Sumners Rd, Sumner QLD 4074','Sumner','QLD',4074,NULL,-27.5506,152.985,'2018-09-17 02:56:03'),(42,'The Jindalee Hotel','Sinnamon Rd, Jindalee QLD 4074','Jindalee','QLD',4074,NULL,-27.5506,152.985,'2018-09-17 02:57:21'),(43,'The Kenmore Tavern','841 Moggill Rd, Kenmore QLD 4069','Kenmore','QLD',4069,NULL,-27.5121,152.962,'2018-09-17 02:58:56'),(44,'Indooroopilly Hotel','3 Station Rd, Indooroopilly QLD 4068','Indooroopilly','QLD',4068,NULL,27.5121,152.962,'2018-09-17 02:58:56'),(45,'Royal Exchange Hotel','10 High St, Toowong QLD 4066','Toowong','QLD',4066,NULL,-27.5121,152.962,'2018-09-17 03:00:25'),(46,'The Victory Hotel','127 Edward St, Brisbane City QLD 4000','Brisbane','QLD',4000,NULL,-27.5121,152.962,'2018-09-17 03:00:25'),(47,'Mount Gravatt Hotel','1315 Logan Rd, Mount Gravatt QLD 4122','Mount Gravatt','QLD',4122,NULL,-27.5121,152.962,'2018-09-17 03:02:15'),(48,'Camp Hill Hotel','724 Old Cleveland Rd, Camp Hill QLD 4152','Camp Hill','QLD',4152,NULL,-27.5121,152.962,'2018-09-17 03:02:15'),(49,'Belmont Tavern','185 Belmont Rd, Belmont QLD 4153','Belmont','QLD',4153,NULL,-27.5217,153.009,'2018-09-17 03:03:26'),(50,'Carindale Hotel','Westfield Shopping Centre, 14/1151 Creek Rd, Carindale QLD 4152','Carindale','QLD',4152,NULL,-27.5217,153.009,'2018-09-17 03:04:21'),(51,'The Elephant Hotel','230 Wickham St, Fortitude Valley QLD 4006','Fortitude Valley','QLD',4006,NULL,-27.4633,153.042,'2018-09-17 03:12:01'),(52,'Osbourne Hotel','766 Ann St, Fortitude Valley QLD 4006','Fortitude Valley','QLD',4006,NULL,-27.4633,153.042,'2018-09-17 03:12:01'),(53,'The Wickham','308 Wickham St, Fortitude Valley QLD 4006','Fortitude Valley','QLD',4006,NULL,-27.4633,153.042,'2018-09-17 03:13:34'),(54,'Waterloo Hotel','Ann St & Commercial Rd, Fortitude Valley QLD 4006','Fortitude Valley','QLD',4006,NULL,-27.4633,153.042,'2018-09-17 03:13:34'),(55,'Albion Hotel','300 Sandgate Rd, Albion QLD 4010','Albion','QLD',4010,NULL,-27.4468,153.087,'2018-09-17 03:15:36'),(56,'Hamilton Hotel','442 Kingsford Smith Dr, Hamilton QLD 4007','Hamilton','QLD',4007,NULL,-27.4468,153.087,'2018-09-17 03:15:36'),(57,'Prince of Wales Hotel','100 Buckland Rd, Nundah QLD 4012','Nundah','QLD',4012,NULL,-27.4468,153.087,'2018-09-17 03:17:16'),(58,'Cannon Hill Tavern','11/17 Southgate Ave, Cannon Hill QLD 4170','Cannon Hill','QLD',4170,NULL,-27.4468,153.087,'2018-09-17 03:17:16'),(59,'Breakfast Creek Hotel','2 Kingsford Smith Dr, Albion QLD 4010','Albion','QLD',4010,NULL,-27.4416,153.046,'2018-09-17 03:19:00'),(60,'The Brunswick Hotel','569 Brunswick St, New Farm QLD 4005','New Farm','QLD',4005,NULL,-27.4564,153.043,'2018-09-17 03:22:03'),(61,'Empire Hotel','339 Brunswick St, Fortitude Valley QLD 4006','Fortitude Valley','QLD',4006,NULL,-27.4606,153.039,'2018-09-17 03:22:03'),(62,'Kedron Park Hotel','693 Lutwyche Rd, Kedron Park QLD 4030','Kedron Park','QLD',4030,NULL,-27.4248,153.033,'2018-09-17 03:24:37'),(63,'Stafford Tavern','51/55 Webster Rd, Stafford QLD 4053','Stafford','QLD',4053,NULL,-27.4248,153.033,'2018-09-17 03:24:37'),(64,'Alderley Arms Hotel','2 Samford Rd, Alderley QLD 4051','Alderley','QLD',4051,NULL,-27.4248,153.033,'2018-09-17 03:25:21'),(65,'Newmarket Hotel','Enoggera Rd & Newmarket Rd, Newmarket QLD 4051','Newmarket','QLD',4051,NULL,-27.4248,153.033,'2018-09-17 03:28:05'),(66,'Brook Hotel','167 Osborne Rd, Mitchelton QLD 4053','Mitchelton','QLD',4053,NULL,-27.4186,152.993,'2018-09-17 03:28:05'),(67,'The Gap Tavern','21 Glenquarie Pl, The Gap QLD 4061','The Gap','QLD',4061,NULL,-27.434,152.98,'2018-09-17 03:29:41'),(68,'The Paddington Tavern','186 Given Terrace, Paddington QLD 4064','Paddington','QLD',4064,NULL,-27.4673,152.979,'2018-09-17 03:29:41'),(69,'Alexandra Hills Hotel','McDonald Rd & Finucane Rd, Alexandra Hills QLD 4161','Alexandra Hills','QLD',4161,NULL,-27.5544,153.129,'2018-09-17 03:32:21'),(70,'Cleveland Tavern','22/28 Shore St W, Cleveland QLD 4160','Cleveland','QLD',4160,NULL,-27.5505,153.169,'2018-09-17 03:32:21'),(71,'Grand View Hotel','49 North St, Cleveland QLD 4163','Cleveland','QLD',4163,NULL,-27.5505,153.169,'2018-09-17 03:33:22'),(72,'Birkdale Gardens Tavern','180 Birkdale Rd, Birkdale QLD 4159','Birkdale','QLD',4159,NULL,-27.4986,153.2,'2018-09-17 03:34:36'),(73,'Hogan\'s Wellington Point','381 Main Rd, Wellington Point QLD 4160','Wellington Point','QLD',4160,NULL,-27.4986,153.2,'2018-09-17 03:35:25'),(74,'Capalaba Tavern','30 Old Cleveland Rd, Capalaba QLD 4157','Capalaba','QLD',4157,NULL,-27.5134,153.197,'2018-09-17 03:37:34'),(75,'Redland Bay Hotel','167 Esplanade, Redland Bay QLD 4165','Redland Bay','QLD',4165,NULL,-27.5645,153.149,'2018-09-17 03:37:34'),(76,'The Glen Hotel','24 Gaskell St, Eight Mile Plains QLD 4113','Eight Mile Plains','QLD',4113,NULL,-27.5645,153.149,'2018-09-17 03:39:18'),(77,'Springwood Hotel','Rochedale Rd & Springwood Road, Springwood QLD 4127','Springwood','QLD',4127,NULL,-27.5645,153.149,'2018-09-17 03:39:18'),(78,'Chatswood Hills Tavern','Magellan Rd, Springwood QLD 4127','Springwood','QLD',4127,NULL,-27.5645,153.149,'2018-09-17 03:40:52'),(79,'Victoria Point Tavern','TownCentre Victoria Point, Colburn Avenue, Victoria Point QLD 4165','Victoria Point','QLD',4165,NULL,-27.5645,153.149,'2018-09-17 03:40:52'),(80,'Koala Tavern','36-40 Moreton Bay Rd, Capalaba QLD 4157','Capalaba','QLD',4157,NULL,-27.5645,153.149,'2018-09-17 03:42:50'),(81,'Logan City Tavern','108 Wembley Rd, Logan Central QLD 4114','Logan Central','QLD',4114,NULL,-27.645,153.117,'2018-09-17 03:42:50'),(82,'The Meadowbrook Hotel','1-7 Logandowns Dr, Meadowbrook QLD 4131','Meadowbrook','QLD',4131,NULL,-27.645,153.117,'2018-09-17 03:44:34'),(83,'Fitzy\'s Loganholme','Bryants Rd &, Pacific Highway, Loganholme QLD 4129','Loganholme','QLD',4129,NULL,-27.645,153.117,'2018-09-17 03:44:34'),(84,'Fitzy\'s Waterford','24-34 Albert St, Waterford QLD 4133','Waterford','QLD',4133,NULL,-27.6561,153.118,'2018-09-17 03:46:26'),(85,'Kensington Tavern','25 Julie St, Crestmead QLD 4132','Crestmead','QLD',4132,NULL,-27.6561,153.118,'2018-09-17 03:46:26'),(86,'Browns Plains Hotel','64 Browns Plains Rd, Browns Plains QLD 4118','Browns Plains','QLD',4118,NULL,-27.6421,153.075,'2018-09-17 03:48:54'),(87,'Lucky Star Tavern Sunnybank','397 Hellawell Rd, Sunnybank Hills QLD 4109','Sunnybank Hills','QLD',4109,NULL,-27.5997,153.016,'2018-09-17 03:48:54'),(88,'Hotel Richlands','132 Government Rd, Richlands QLD 4077','Richlands','QLD',4077,NULL,-27.5857,152.946,'2018-09-17 03:50:36'),(90,'Royal Mail Hotel','92 Brisbane Terrace, Goodna QLD 4300','Goodna','QLD',4300,NULL,-27.5928,152.92,'2018-09-17 03:51:54'),(91,'The Commercial Hotel','72 Brisbane Rd, Redbank QLD 4301','Redbank','QLD',4301,NULL,-27.5928,152.92,'2018-09-17 03:52:39'),(92,'Redbank Plains Tavern','339 Redbank Plains Rd, Redbank Plains QLD 4301','Redbank Plains','QLD',4301,NULL,-27.6386,152.883,'2018-09-17 03:54:47'),(93,'Springlake Hotel','1 Springfield Lakes Blvd, Springfield Lakes QLD 4300','Springfield Lakes','QLD',4300,NULL,-27.6386,152.883,'2018-09-17 03:54:47'),(94,'Springfield Tavern','Springfield Pkwy, Springfield QLD 4300','Springfield','QLD',4300,NULL,-27.6386,152.883,'2018-09-17 03:55:36'),(95,'Forest Lake Tavern','245 Forest Lake Blvd, Forest Lake QLD 4078','Forest Lake','QLD',4078,NULL,-27.6386,152.883,'2018-09-17 03:57:21'),(96,'Racehorse Hotel','215 Brisbane Rd, Booval QLD 4304','Booval','QLD',4304,NULL,-27.6305,152.829,'2018-09-17 03:57:21'),(97,'MiHi Tavern','26 Fernvale Rd, Brassall QLD 4305','Brassall','QLD',4305,NULL,-27.6127,152.798,'2018-09-17 03:58:16'),(98,'Bellbowrie Tavern','5 Birkin Rd, Bellbowrie QLD 4070','Bellbowrie','QLD',4070,NULL,-27.5709,152.801,'2018-09-17 04:00:06'),(99,'The Cecil Hotel','26 Queen St, Goodna QLD 4300','Goodna','QLD',4300,NULL,-27.5726,152.806,'2018-09-17 04:00:06'),(100,'Regatta Hotel','543 Coronation Dr, Toowong QLD 4066','Toowong','QLD',4066,NULL,-27.4825,152.994,'2018-09-17 04:41:38');
/*!40000 ALTER TABLE `pub` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rating`
--

DROP TABLE IF EXISTS `rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rating` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `special_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `special_id` (`special_id`),
  CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`special_id`) REFERENCES `special` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rating`
--

LOCK TABLES `rating` WRITE;
/*!40000 ALTER TABLE `rating` DISABLE KEYS */;
INSERT INTO `rating` VALUES (1,'up',1,2),(2,'up',1,1),(3,'up',1,3),(4,'up',1,2),(5,'up',1,2);
/*!40000 ALTER TABLE `rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `special`
--

DROP TABLE IF EXISTS `special`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `special` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pub_id` int(11) NOT NULL,
  `special_text` varchar(255) NOT NULL,
  `day_of_week` varchar(12) NOT NULL,
  `time_of_day` time NOT NULL,
  `starts` date NOT NULL,
  `expires` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `pub_id` (`pub_id`),
  CONSTRAINT `special_ibfk_1` FOREIGN KEY (`pub_id`) REFERENCES `pub` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `special_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `special`
--

LOCK TABLES `special` WRITE;
/*!40000 ALTER TABLE `special` DISABLE KEYS */;
INSERT INTO `special` VALUES (1,1,1,'Sunday Paddle Deal','Sunday','14:00:00','2018-08-13','0000-00-00'),(2,1,2,'$4 pizza night','Wednesday','14:00:00','2018-08-13','0000-00-00'),(3,1,4,'14 Steak and chips','Sunday','16:00:00','2018-08-13','0000-00-00'),(5,1,6,'two for one tuesdays','tuesday','17:00:00','2018-08-13','0000-00-00');
/*!40000 ALTER TABLE `special` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(24) NOT NULL,
  `password` varchar(24) NOT NULL,
  `privilege` int(2) NOT NULL,
  `yob` int(4) NOT NULL,
  `email` varchar(128) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'asdf','asdf',1,1939,'asdf@asdf.com','2018-08-06 01:49:08');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-17 14:47:35
