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
  `description` varchar(1024) NOT NULL,
  `address` varchar(255) NOT NULL,
  `suburb` varchar(32) NOT NULL,
  `state` varchar(28) NOT NULL,
  `postcode` int(5) NOT NULL,
  `logo` varchar(128) DEFAULT NULL,
  `latitude` decimal(11,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `viewcount` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pub`
--

LOCK TABLES `pub` WRITE;
/*!40000 ALTER TABLE `pub` DISABLE KEYS */;
INSERT INTO `pub` VALUES (1,'Tipplers Tap','','5/182 Gray St SOUTH BRISBANE','SOUTH BRISBANE','Qld',4101,NULL,-27.47959870,153.02045350,'2018-09-09 23:47:11',0),(4,'Redbrick Hotel','','83 Annerley Rd, Woolloongabba QLD 4102','Woolloongabba','Qld',4101,NULL,-27.49150070,153.02344910,'2018-09-09 23:47:11',0),(6,'Junction Hotel','','Ipswich Rd & Annerley Rd, Annerley QLD 4103','Annerley','Qld',4103,NULL,-27.51058230,153.03137750,'2018-09-09 23:47:11',0),(8,'Hotel West End','','10 Browning St, South Brisbane QLD 4101','South Brisbane','QLD',4101,NULL,-27.47778480,153.01286880,'2018-09-17 02:17:08',0),(9,'Archive Beer Boutique','','100 Boundary St, West End QLD 4101','West End','Qld',4101,NULL,-27.47962460,153.01172000,'2018-09-17 02:20:40',0),(10,'Brisbane Brewing Co','','124 Boundary St, West End QLD 4101','West End','QLD',4101,NULL,-27.48038130,153.01172540,'2018-09-17 02:22:00',0),(11,'The Milk Factory Kitchen & Bar','','48 Montague Rd, South Brisbane QLD 4101','South Brisbane','QLD',4101,NULL,-27.47177540,153.01425770,'2018-09-17 02:23:58',0),(12,'Peel Street Tavern','','35 Peel St, South Brisbane QLD 4101','South Brisbane','QLD',4101,NULL,-27.47333890,153.01519110,'2018-09-17 02:24:48',0),(13,'Pig \'N\' Whistle West End\r\n','','Merivale St, South Brisbane QLD 4101','South Brisbane','QLD',4101,NULL,-27.47533900,153.01573000,'2018-09-17 02:26:30',0),(14,'The Fox Hotel','','71-73 Melbourne St, South Brisbane QLD 4101','South Brisbane QLD 4101','QLD',4101,NULL,-27.47533900,153.01573290,'2018-09-17 02:27:23',0),(15,'Saccharomyces Beer Cafe\r\n','','Fish Ln, South Brisbane QLD 4101','South Brisbane','QLD',4101,NULL,-27.47533900,153.01573290,'2018-09-17 02:28:21',0),(16,'The Charming Squire\r\n','','3/133 Grey St, South Brisbane QLD 4101','South Brisbane','Qld',4101,NULL,-27.47556980,153.01699350,'2018-09-17 02:29:21',0),(17,'The Plough Inn\r\n','','29 Stanley St Plaza, South Brisbane QLD 4101','South Brisbane','QLD',4101,NULL,-27.47902380,153.02220610,'2018-09-17 02:30:31',0),(19,'Hop And Pickle\r\n','','6e Little Stanley St, South Brisbane QLD 4101','SOUTH BRISBANE','QLD',4101,NULL,-27.48007760,153.02245710,'2018-09-17 02:32:17',0),(20,'The Ship Inn\r\n','','Sidon St, South Brisbane QLD 4101','South Brisbane','QLD',4101,'',-27.48187810,153.02244750,'2018-09-17 02:33:32',0),(21,'Brewhouse','','601 Stanley St, Woolloongabba QLD 4102','Woolloongabba','QLD',4102,NULL,-27.48576170,153.02869610,'2018-09-17 02:36:14',0),(22,'Morrison Hotel','','640 Stanley St, Woolloongabba QLD 4102','Woolloongabba','QLD',4102,NULL,-27.48618200,153.03088770,'2018-09-17 02:36:14',0),(23,'Woolloongabba Hotel\r\n','','17/803 Stanley St, Woolloongabba QLD 4102','Woolloongabba','QLD',4102,NULL,-27.48732350,153.03573130,'2018-09-17 02:37:25',0),(24,'Australian National Hotel','','867 Stanley St, Woolloongabba QLD 4102','Woolloongabba','QLD',4102,NULL,-27.48737430,153.03985620,'2018-09-17 02:39:19',0),(25,'Pineapple Hotel','','706 Main St, Kangaroo Point QLD 4169','Kangaroo Point','QLD',4169,NULL,-27.48101860,153.03405480,'2018-09-17 02:39:19',0),(26,'Story Bridge Hotel','','200 Main St, Kangaroo Point QLD 4169','Kangaroo Point','QLD',4169,NULL,-27.46893780,153.03330510,'2018-09-17 02:40:12',0),(27,'The Bavarian Beer Cafe\r\n','','1/45 Eagle St, Brisbane City QLD 4000','Brisbane','QLD',4000,NULL,27.46919450,153.02998190,'2018-09-17 02:41:21',0),(28,'Lord Stanley Hotel\r\n','','994 Stanley St E, East Brisbane QLD 4169','East Brisbane','QLD',4169,NULL,-27.48860580,153.03404260,'2018-09-17 02:42:29',0),(29,'Norman Hotel','','102 Ipswich Rd, Woolloongabba QLD 4102','Woolloongabba','QLD',4102,NULL,-27.49298640,153.03341650,'2018-09-17 02:43:16',0),(30,'Stones Corner Hotel\r\n','','346 Logan Rd, Stones Corner QLD 4120','Stones Corner','QLD',4120,NULL,-27.49925770,153.04276180,'2018-09-17 02:44:15',0),(31,'Chardons Corner Hotel\r\n','','7 Cracknell Rd, Annerley QLD 4103','Annerley','QLD',4103,NULL,-27.51920770,153.02857220,'2018-09-17 02:45:29',0),(32,'Holland Park Hotel\r\n','','945 Logan Rd, Holland Park QLD 4121','Holland Park','QLD',4121,NULL,-27.53564570,153.01371200,'2018-09-17 02:46:27',0),(33,'The Red Lion Hotel\r\n','','215 Beaudesert Rd, Moorooka QLD 4105','Moorooka','QLD',4105,NULL,-27.53332430,153.02366550,'2018-09-17 02:48:50',0),(34,'Salisbury Hotel Motel\r\n','','668 Toohey Rd, Salisbury QLD 4107','Salisbury','QLD',4107,NULL,-27.54646100,153.03954520,'2018-09-17 02:49:37',0),(35,'Sunnybank Hotel\r\n','','275 McCullough St, Sunnybank QLD 4109','Sunnybank','QLD',4109,NULL,-27.59530550,153.03540120,'2018-09-17 02:50:24',0),(37,'Corinda Tavern','','651 Oxley Rd, Corinda QLD 4075','Corinda','QLD',4075,NULL,-27.54139310,152.97888150,'2018-09-17 02:53:21',0),(38,'Oxley Hotel','','Cnr Ipswich & Oxley Roads, Oxley QLD 4075','Oxley','QLD',4075,NULL,-27.56470150,152.97780400,'2018-09-17 02:53:21',0),(39,'Oxley Tavern','','146 Blunder Rd, Oxley QLD 4075','Oxley','QLD',4075,NULL,-27.57612450,152.98035170,'2018-09-17 02:54:58',0),(40,'Hotel Monier','','168/176 Monier Rd, Darra QLD 4076','Darra','QLD',4076,NULL,-27.57121370,152.94506570,'2018-09-17 02:54:58',0),(41,'Centenary Tavern','','96 Sumners Rd, Sumner QLD 4074','Sumner','QLD',4074,NULL,-27.56817980,152.91239730,'2018-09-17 02:56:03',0),(42,'The Jindalee Hotel','','Sinnamon Rd, Jindalee QLD 4074','Jindalee','QLD',4074,NULL,-27.54483400,152.94181870,'2018-09-17 02:57:21',0),(43,'The Kenmore Tavern','','841 Moggill Rd, Kenmore QLD 4069','Kenmore','QLD',4069,NULL,-27.50790260,152.94935690,'2018-09-17 02:58:56',0),(44,'Indooroopilly Hotel','','3 Station Rd, Indooroopilly QLD 4068','Indooroopilly','QLD',4068,NULL,-27.49912630,152.97921720,'2018-09-17 02:58:56',0),(45,'Royal Exchange Hotel','','10 High St, Toowong QLD 4066','Toowong','QLD',4066,NULL,-27.48726310,152.99168410,'2018-09-17 03:00:25',0),(46,'The Victory Hotel','','127 Edward St, Brisbane City QLD 4000','Brisbane','QLD',4000,NULL,-27.46952890,153.02799440,'2018-09-17 03:00:25',0),(47,'Mount Gravatt Hotel','','1315 Logan Rd, Mount Gravatt QLD 4122','Mount Gravatt','QLD',4122,NULL,-27.53564570,153.01371200,'2018-09-17 03:02:15',0),(48,'Camp Hill Hotel','','724 Old Cleveland Rd, Camp Hill QLD 4152','Camp Hill','QLD',4152,NULL,-27.49098230,153.05760550,'2018-09-17 03:02:15',0),(50,'Carindale Hotel','','Westfield Shopping Centre, 14/1151 Creek Rd, Carindale QLD 4152','Carindale','QLD',4152,NULL,-27.50191850,153.10099840,'2018-09-17 03:04:21',0),(51,'The Elephant Hotel','','230 Wickham St, Fortitude Valley QLD 4006','Fortitude Valley','QLD',4006,NULL,-27.45918800,153.03302450,'2018-09-17 03:12:01',0),(52,'Osbourne Hotel','','766 Ann St, Fortitude Valley QLD 4006','Fortitude Valley','QLD',4006,NULL,-27.45645570,153.03440850,'2018-09-17 03:12:01',0),(53,'The Wickham','','308 Wickham St, Fortitude Valley QLD 4006','Fortitude Valley','QLD',4006,NULL,-27.45601320,153.03257230,'2018-09-17 03:13:34',0),(54,'Waterloo Hotel','','Ann St & Commercial Rd, Fortitude Valley QLD 4006','Fortitude Valley','QLD',4006,NULL,-27.45266720,153.03876930,'2018-09-17 03:13:34',0),(55,'Albion Hotel','','300 Sandgate Rd, Albion QLD 4010','Albion','QLD',4010,NULL,-27.43025200,153.04384740,'2018-09-17 03:15:36',0),(56,'Hamilton Hotel','','442 Kingsford Smith Dr, Hamilton QLD 4007','Hamilton','QLD',4007,NULL,-27.44188120,153.04698020,'2018-09-17 03:15:36',0),(57,'Prince of Wales Hotel','','100 Buckland Rd, Nundah QLD 4012','Nundah','QLD',4012,NULL,-27.40369420,153.05788930,'2018-09-17 03:17:16',0),(58,'Cannon Hill Tavern','','11/17 Southgate Ave, Cannon Hill QLD 4170','Cannon Hill','QLD',4170,NULL,-27.48654860,153.05593950,'2018-09-17 03:17:16',0),(59,'Breakfast Creek Hotel','','2 Kingsford Smith Dr, Albion QLD 4010','Albion','QLD',4010,NULL,-27.44188120,153.04698020,'2018-09-17 03:19:00',0),(60,'The Brunswick Hotel','','569 Brunswick St, New Farm QLD 4005','New Farm','QLD',4005,NULL,-27.46239260,153.03761310,'2018-09-17 03:22:03',0),(61,'Empire Hotel','','339 Brunswick St, Fortitude Valley QLD 4006','Fortitude Valley','QLD',4006,NULL,-27.45876320,153.03292630,'2018-09-17 03:22:03',0),(62,'Kedron Park Hotel','','693 Lutwyche Rd, Kedron Park QLD 4030','Kedron Park','QLD',4030,NULL,-27.41790700,153.02567060,'2018-09-17 03:24:37',0),(64,'Alderley Arms Hotel','','2 Samford Rd, Alderley QLD 4051','Alderley','QLD',4051,NULL,-27.43260130,152.98890330,'2018-09-17 03:25:21',0),(65,'Newmarket Hotel','','Enoggera Rd & Newmarket Rd, Newmarket QLD 4051','Newmarket','QLD',4051,NULL,-27.43700200,153.00495730,'2018-09-17 03:28:05',0),(66,'Brook Hotel','','167 Osborne Rd, Mitchelton QLD 4053','Mitchelton','QLD',4053,NULL,-27.40755690,152.96156820,'2018-09-17 03:28:05',0),(67,'The Gap Tavern','','21 Glenquarie Pl, The Gap QLD 4061','The Gap','QLD',4061,NULL,-27.44976180,152.94586120,'2018-09-17 03:29:41',0),(68,'The Paddington Tavern','','186 Given Terrace, Paddington QLD 4064','Paddington','QLD',4064,NULL,-27.46720270,152.96740470,'2018-09-17 03:29:41',0),(69,'Alexandra Hills Hotel','','McDonald Rd & Finucane Rd, Alexandra Hills QLD 4161','Alexandra Hills','QLD',4161,NULL,-27.52433490,153.17065450,'2018-09-17 03:32:21',0),(70,'Cleveland Tavern','','22/28 Shore St W, Cleveland QLD 4160','Cleveland','QLD',4160,NULL,-27.52375250,153.24345100,'2018-09-17 03:32:21',0),(71,'Grand View Hotel','','49 North St, Cleveland QLD 4163','Cleveland','QLD',4163,NULL,-27.52292380,153.28553060,'2018-09-17 03:33:22',0),(72,'Birkdale Gardens Tavern','','180 Birkdale Rd, Birkdale QLD 4159','Birkdale','QLD',4159,NULL,-27.50977080,153.17351040,'2018-09-17 03:34:36',0),(73,'Hogan\'s Wellington Point','','381 Main Rd, Wellington Point QLD 4160','Wellington Point','QLD',4160,NULL,-27.50174910,153.18493430,'2018-09-17 03:35:25',0),(74,'Capalaba Tavern','','30 Old Cleveland Rd, Capalaba QLD 4157','Capalaba','QLD',4157,NULL,-27.52876700,153.15399460,'2018-09-17 03:37:34',0),(75,'Redland Bay Hotel','','167 Esplanade, Redland Bay QLD 4165','Redland Bay','QLD',4165,NULL,-27.59710520,153.25507380,'2018-09-17 03:37:34',0),(76,'The Glen Hotel','','24 Gaskell St, Eight Mile Plains QLD 4113','Eight Mile Plains','QLD',4113,NULL,-27.59713980,153.02517820,'2018-09-17 03:39:18',0),(77,'Springwood Hotel','','Rochedale Rd & Springwood Road, Springwood QLD 4127','Springwood','QLD',4127,NULL,-27.59713980,153.02517820,'2018-09-17 03:39:18',0),(78,'Chatswood Hills Tavern','','Magellan Rd, Springwood QLD 4127','Springwood','QLD',4127,NULL,-27.56450000,153.14900000,'2018-09-17 03:40:52',0),(79,'Victoria Point Tavern','','TownCentre Victoria Point, Colburn Avenue, Victoria Point QLD 4165','Victoria Point','QLD',4165,NULL,-27.59710520,153.25507380,'2018-09-17 03:40:52',0),(80,'Koala Tavern','','36-40 Moreton Bay Rd, Capalaba QLD 4157','Capalaba','QLD',4157,NULL,-27.52876700,153.15399460,'2018-09-17 03:42:50',0),(81,'Logan City Tavern','','108 Wembley Rd, Logan Central QLD 4114','Logan Central','QLD',4114,NULL,-27.64407570,153.09027760,'2018-09-17 03:42:50',0),(82,'The Meadowbrook Hotel','','1-7 Logandowns Dr, Meadowbrook QLD 4131','Meadowbrook','QLD',4131,NULL,-27.64500000,153.11700000,'2018-09-17 03:44:34',0),(83,'Fitzy\'s Loganholme','','Bryants Rd &, Pacific Highway, Loganholme QLD 4129','Loganholme','QLD',4129,NULL,-27.64500000,153.11700000,'2018-09-17 03:44:34',0),(84,'Fitzy\'s Waterford','','24-34 Albert St, Waterford QLD 4133','Waterford','QLD',4133,NULL,-27.69294250,153.13958880,'2018-09-17 03:46:26',0),(85,'Kensington Tavern','','25 Julie St, Crestmead QLD 4132','Crestmead','QLD',4132,NULL,-27.12345600,153.11800000,'2018-09-17 03:46:26',0),(86,'Browns Plains Hotel','','64 Browns Plains Rd, Browns Plains QLD 4118','Browns Plains','QLD',4118,NULL,-27.64486330,153.00045850,'2018-09-17 03:48:54',0),(87,'Lucky Star Tavern Sunnybank','','397 Hellawell Rd, Sunnybank Hills QLD 4109','Sunnybank Hills','QLD',4109,NULL,-27.60079090,152.97196320,'2018-09-17 03:48:54',0),(88,'Hotel Richlands','','132 Government Rd, Richlands QLD 4077','Richlands','QLD',4077,NULL,-27.60640120,152.95568560,'2018-09-17 03:50:36',0),(90,'Royal Mail Hotel','','92 Brisbane Terrace, Goodna QLD 4300','Goodna','QLD',4300,NULL,-27.59180210,152.83358010,'2018-09-17 03:51:54',0),(91,'The Commercial Hotel','','72 Brisbane Rd, Redbank QLD 4301','Redbank','QLD',4301,NULL,-27.60061300,152.86676830,'2018-09-17 03:52:39',0),(92,'Redbank Plains Tavern','','339 Redbank Plains Rd, Redbank Plains QLD 4301','Redbank Plains','QLD',4301,NULL,-27.62465910,152.81847390,'2018-09-17 03:54:47',0),(93,'Springlake Hotel','','1 Springfield Lakes Blvd, Springfield Lakes QLD 4300','Springfield Lakes','QLD',4300,NULL,-27.66885220,152.91492740,'2018-09-17 03:54:47',0),(94,'Springfield Tavern','','Springfield Pkwy, Springfield QLD 4300','Springfield','QLD',4300,NULL,-27.62465910,152.81847390,'2018-09-17 03:55:36',0),(95,'Forest Lake Tavern','','245 Forest Lake Blvd, Forest Lake QLD 4078','Forest Lake','QLD',4078,NULL,-27.60999500,152.93045140,'2018-09-17 03:57:21',0),(96,'Racehorse Hotel','','215 Brisbane Rd, Booval QLD 4304','Booval','QLD',4304,NULL,-27.60454040,152.76386780,'2018-09-17 03:57:21',0),(97,'MiHi Tavern','','26 Fernvale Rd, Brassall QLD 4305','Brassall','QLD',4305,NULL,-27.59607340,152.68133620,'2018-09-17 03:58:16',0),(98,'Bellbowrie Tavern','','5 Birkin Rd, Bellbowrie QLD 4070','Bellbowrie','QLD',4070,NULL,-27.56825590,152.90956490,'2018-09-17 04:00:06',0),(99,'The Cecil Hotel','','26 Queen St, Goodna QLD 4300','Goodna','QLD',4300,NULL,-27.59180210,152.83358010,'2018-09-17 04:00:06',0),(100,'Regatta Hotel','','543 Coronation Dr, Toowong QLD 4066','Toowong','QLD',4066,NULL,-27.48506930,152.99150170,'2018-09-17 04:41:38',0),(101,'Crown Hotel','','446 Lutwyche Rd, Lutwyche QLD 4030','Lutwyche','QLD',4030,NULL,-27.43025200,153.04384740,'2018-09-17 06:37:02',0),(102,'Three Little Pigs Tavern','','Stafford City Shopping Centre e12/, 400 Stafford Rd, Stafford QLD 4053','Stafford','QLD',4053,NULL,-27.42876640,153.03191690,'2018-09-17 06:38:50',0),(103,'Stafford Tavern','','51/55 Webster Rd, Stafford QLD 4053','Stafford','QLD',4053,NULL,-27.42876640,153.03191690,'2018-09-17 06:39:44',0),(104,'Boundary Hotel','','Boundary street West End 4101','West End','QLD',4101,NULL,-27.47910780,153.01225150,'2018-09-17 07:01:27',0),(105,'Karalee Tavern','','84 Junction Rd, Karalee QLD 4306','Karalee','QLD',4306,NULL,-27.59607340,152.68133620,'2018-09-17 09:55:45',0),(106,'PA Hotel','','170 Brisbane Rd, Booval QLD 4304','Booval','QLD',4304,NULL,-27.60454040,152.76386780,'2018-09-17 09:55:45',0),(107,'Wynnum Tavern','','1975 Wynnum Rd, Wynnum West QLD 4178','Wynnum West','QLD',4178,NULL,-27.46056420,153.14336360,'2018-09-17 10:04:11',0),(108,'Belmont Tavern','','185 Belmont Rd, Belmont QLD 4153','Belmont','QLD',4153,NULL,-27.47377780,153.09381000,'2018-09-17 10:04:11',0),(109,'Gumdale Tavern','','277 Tilley Rd, Gumdale QLD 4154','Gumdale','QLD',4154,NULL,-27.49837140,153.11115500,'2018-09-17 10:23:35',0),(110,'Runcorn Tavern','','124 Gowan Rd, Sunnybank Hills QLD 4109','Sunnybank Hills','QLD',4109,NULL,-27.59530550,153.03540120,'2018-09-17 10:36:53',0),(111,'Uni Bar','','N71 W Creek Rd & Science Rd, Nathan QLD 4111','Nathan','QLD',4111,NULL,-27.57649980,153.00275840,'2018-09-17 10:40:09',0),(112,'Hotel HQ','','21 Kingston Rd, Underwood QLD 4119','Underwood','QLD',4119,NULL,-27.60498810,153.09613500,'2018-09-17 10:54:20',0),(113,'The Bent Elbow','','16 Old Cleveland Rd, Stones Corner QLD 4120','Stones Corner','QLD',4120,NULL,-27.49925770,153.04276180,'2018-09-17 10:59:03',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rating`
--

LOCK TABLES `rating` WRITE;
/*!40000 ALTER TABLE `rating` DISABLE KEYS */;
INSERT INTO `rating` VALUES (6,'UP',1,6);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `special`
--

LOCK TABLES `special` WRITE;
/*!40000 ALTER TABLE `special` DISABLE KEYS */;
INSERT INTO `special` VALUES (6,1,6,'Burger deal','Monday','16:00:00','2018-09-19','2018-09-26');
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

-- Dump completed on 2018-09-21  8:14:25
