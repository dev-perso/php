-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: macaveavin
-- ------------------------------------------------------
-- Server version	8.0.21-0ubuntu0.20.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cave`
--

DROP TABLE IF EXISTS `cave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cave` (
  `id_cave` int NOT NULL AUTO_INCREMENT,
  `quantite` int unsigned NOT NULL,
  `note` int DEFAULT NULL,
  `description` longtext,
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `prix` double DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `id_user` int NOT NULL,
  `id_vin` int NOT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id_cave`),
  KEY `id_vin` (`id_vin`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  CONSTRAINT `id_vin` FOREIGN KEY (`id_vin`) REFERENCES `vin` (`id_vin`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cave`
--

LOCK TABLES `cave` WRITE;
/*!40000 ALTER TABLE `cave` DISABLE KEYS */;
INSERT INTO `cave` VALUES (4,0,2,'Rose d’anjou habituelle sucré',1,NULL,NULL,1,21,NULL),(6,0,NULL,'Je ne m\'en rappelle plus !!!',1,NULL,NULL,1,22,NULL),(7,0,4,'Le rosé idéal pour l\'apéro',1,7.45,NULL,1,23,NULL),(8,1,NULL,NULL,0,7,'5ebac934748ee912445009.jpg',2,24,'2020-05-12'),(9,0,4,'Très bon auxey duresses',1,23,'5f54e569049ae068185540.png',1,25,'2020-09-06'),(10,1,NULL,'Test desc',0,100,'5ed8756457022574537307.jpg',2,26,'2020-06-04'),(11,1,4,'C\'est tout simplement excellent.\r\nUn vin très épais idéal pour un bon repas entre ami',0,NULL,'5f54ea15c5cce793408252.jpg',1,27,'2020-09-06'),(12,1,NULL,NULL,0,NULL,'5f3d67e958562653786047.jpg',1,28,'2020-08-19'),(13,1,NULL,NULL,0,NULL,'5f3d66d6c7987131408088.jpg',1,29,'2020-08-19'),(14,0,3,'Vin léger idéal pour un apéritif',1,NULL,'5f3d677767f46722556214.jpg',1,30,'2020-08-19'),(15,1,NULL,NULL,0,NULL,'5f54e9e99de80986983206.jpg',1,31,'2020-09-06'),(16,1,NULL,NULL,0,NULL,'5f3d68f6d0063213629268.jpg',1,32,'2020-08-19'),(17,1,NULL,NULL,0,NULL,'5f3d66f864b88987982542.jpg',1,33,'2020-08-19'),(18,1,3,'Un vin très particulier.\r\nVin léger avec une légère note sucré très agréable en bouche.\r\nIdéal pour un apéritif.',0,NULL,'5f3d68182135e028036015.jpg',1,34,'2020-08-19'),(19,0,4,'Très bon chardonnay, pas le meilleur mais très bon',1,NULL,'5f3d671f02127590707064.jpg',1,35,'2020-08-19'),(20,1,4,'Bon Viognier, top pour l’apéro',0,NULL,'5f3d67aaef549600745833.jpg',1,36,'2020-08-19'),(21,0,3,'Bon rosé sans plus',1,12,NULL,1,37,NULL),(22,0,4,'Très bon vin rouge, léger et fruité idéal à déguster ou pour un apréritif',1,NULL,'5f36d626a9b8f020330574.jpg',1,38,'2020-08-14'),(23,0,4,'Très bonne surprise pour ce vin assez gras et qui reste en bouche.',1,NULL,'5f36d70c38c73278068509.jpg',1,39,'2020-08-14'),(24,0,2,'Vin blanc avec une forte prononciation de sucre. Pas trop à mon gout, mais peut être idéal pour faire des cocktail.',1,NULL,'5f37bd7c62660407923839.jpg',1,40,'2020-08-15'),(25,0,4,'Très bon vin blanc idéal à boire accompagner d\'une viande blanche ou du poisson ou bien même lors d\'un apéritif dînatoire, vin assez gras et fruité.',1,NULL,'5f37bdfed174b695681585.jpg',1,41,'2020-08-15'),(26,0,3,'Rosé qualité/prix top',1,NULL,'5f37bf380f402752631687.jpg',1,42,'2020-08-15'),(27,0,3,NULL,1,NULL,'5f39936bbb813536866237.jpg',1,43,'2020-08-16'),(28,0,3,NULL,1,NULL,'5f3d352fa4664812564738.jpg',1,44,'2020-08-19'),(29,1,NULL,NULL,0,NULL,'5f3d47695bb07489955578.jpg',1,45,'2020-08-19'),(30,0,5,'L\'excellence, un vin complex.\r\nTrès épais et qui reste en bouche',1,NULL,'5f3d60083935c858760149.jpg',1,46,'2020-08-19'),(31,1,NULL,NULL,0,NULL,'5f3d60956e2a5446885402.jpg',1,47,'2020-08-19'),(32,0,4,'Un vin très intéressant, extrêmement fruité avec une bonne longueur en bouche.',1,NULL,'5f3d613b3b5c9593627660.jpg',1,48,'2020-08-19'),(33,1,NULL,NULL,0,NULL,'5f3d61b427cdd940538845.jpg',1,49,'2020-08-19'),(34,1,5,'C\'est tout simplement parfait, on ne demande qu\'à en reboire !',0,NULL,'5f3d62323f56c023186153.jpg',1,50,'2020-08-19'),(35,1,5,'Vin qui comporte des nuances très complexe entre le fruité et le gras.\r\nLe début en bouche est fruité puis on sent le gras arriver qui permet d\'avoir une excellente longueur en bouche',0,NULL,'5f3d62957d5b3999876906.jpg',1,51,'2020-08-19'),(36,1,NULL,NULL,0,NULL,'5f3d6350afc34935761915.jpg',1,96,'2020-08-19'),(37,1,NULL,NULL,0,NULL,'5f3d63bc5eb00739408753.jpg',1,53,'2020-08-19'),(38,1,NULL,NULL,0,NULL,'5f3d6441ad0eb775810046.jpg',1,54,'2020-08-19'),(39,0,4,'Très bon vin rouge pour l\'apéro léger et fruité idéal',1,NULL,'5f3d6488dda86058498912.jpg',1,55,'2020-08-19'),(40,1,NULL,NULL,0,NULL,'5f3d64d9ac3e2603203546.jpg',1,56,'2020-08-19'),(41,1,NULL,NULL,0,NULL,'5f3d653bc43a1629979354.jpg',1,57,'2020-08-19'),(42,1,NULL,NULL,0,NULL,'5f3d686346932746289898.jpg',1,58,'2020-08-19'),(43,1,NULL,NULL,0,NULL,'5f3d697d69272982082012.jpg',1,59,'2020-08-19'),(44,1,NULL,NULL,0,NULL,'5f3d69dd65b2c876331166.jpg',1,60,'2020-08-19'),(45,1,5,'C\'est parfait',0,NULL,'5f3d6a5f3dc4c187580571.jpg',1,61,'2020-08-19'),(46,1,3,'Bon vin blanc pour apéritif',0,NULL,'5f3eb0d39c399989149479.jpg',1,62,'2020-08-20'),(47,1,NULL,NULL,0,NULL,'5f3eb1240bc51371126984.jpg',1,63,'2020-08-20'),(48,1,5,'C\'est tout simplement excellent.\r\nUn vin complexe avec des notes très prononcées sur le gras',0,NULL,'5f3eb1a813e22957893977.jpg',1,64,'2020-08-20'),(49,0,4,'Très bon, combine la fruit et la puissance sans être trop tannique.\r\nTrès bon Châteauneuf du Pape',1,NULL,'5f3eb216ae044107030707.jpg',1,65,'2020-08-20'),(50,1,NULL,NULL,0,NULL,'5f3eb2826455d038328660.jpg',1,66,'2020-08-20'),(51,1,4,'Assez déçu de ce Meursault, je pense qu\'il est nécessaire de le laisser un peu en cave.',0,NULL,'5f3eb34627da6259922613.jpg',1,67,'2020-08-20'),(52,1,3,NULL,0,NULL,'5f3eb39d3315f298405155.jpg',1,68,'2020-08-20'),(53,1,NULL,NULL,0,NULL,'5f3eb3cfc7955845054384.jpg',1,69,'2020-08-20'),(54,0,5,'Le meilleur qualité prix que j\'ai pu gouter jusqu\'à présent c\'est tout simplement un vin merveilleux',1,15,'5f3eb41ea6a1d027958970.jpg',1,70,'2020-08-20'),(55,0,3,'Bon rosé qualité/prix',1,2.99,'5f3eb4f4d390b668489541.jpg',1,71,'2020-08-20'),(56,1,NULL,NULL,0,9.35,'5f54e6d3b6477672938942.jpg',1,72,'2020-09-06'),(57,0,3,'4,95€ en promo à 20%\r\nBon rosé',1,4.95,'5f54ec3bbb38a240342782.jpg',1,73,'2020-09-06'),(58,0,3,'Rosé classique',1,5.09,'5f54e6f8e812c545238485.jpg',1,74,'2020-09-06'),(59,0,3,'Vin mousseux, ca change et c\'est pas mal à l\'apéritif',1,5.39,'5f54e7926d474927667564.jpg',1,75,'2020-09-06'),(60,0,3,'Bon qualite prix',1,4.29,'5f54e8edcf43d939825736.jpg',1,76,'2020-09-06'),(61,0,5,'Tout simplement excellent. Bien beurré comme j’aime',1,16.5,'5f54e886b249e289539601.jpg',1,77,'2020-09-06'),(62,0,3,'Un des meilleurs qualité / prix que je connaisse',1,NULL,'5f54e8bd65f74581085193.jpg',1,78,'2020-09-06'),(65,3,4,'Très bon vin avec une bonne longueur et assez épais comme j’aime',1,8.95,'5f5caf73afb18323449335.jpg',1,81,'2020-09-12'),(66,1,4,'4 étoiles pour la qualité / prix\r\nUn vin légèrement gras qui reste bien en bouche.\r\nIdéal pour l\'apéritif',0,4.95,'5f5cb0333cedd879378999.jpg',1,82,'2020-09-12'),(67,0,3,'Je m\'attendais à mieux, un peu décevant, peut être un peu jeune, car on sent légèrement la minéralité mais ce vin est aussi très vif',1,4.5,'5f5cb082defd7656763481.jpg',1,83,'2020-09-12'),(68,1,4,'Vin gras idéal pour l\'apéritif.\r\nQualité / Prix excellent',0,6.95,'5f5cb0fd628d9817942731.jpg',1,84,'2020-09-12'),(69,0,3,'Vin qui passe très bien en apéritif.\r\nUne légère épaisseur dans le vin avec un joli bouquet en bouche',1,10,'5f5cb164ce496398597648.jpg',1,85,'2020-09-12'),(70,0,3,'Très bon qualité / prix.\r\nJe recommande pour un apéritif assurément réussi',1,6.8,'5f5cb1be412c6945692815.jpg',1,86,'2020-09-12'),(71,1,NULL,NULL,0,8.95,'5f5cb2910a0d2356611138.jpg',1,87,'2020-09-12'),(72,0,3,'2 x 8€ et 50% de promo sur la deuxième.\r\nVin très léger et frais avec des notes de fleur.\r\nTrès agréable à boire.',1,6,'5f5cb2ea342e1861970330.jpg',1,88,'2020-09-12'),(73,1,NULL,NULL,0,32.7,'5f73bdbd5454f966216564.jpg',1,93,'2020-09-29'),(74,1,NULL,NULL,0,8.95,'5f78e50332c08173176746.jpg',18,90,'2020-10-03'),(75,1,NULL,NULL,0,12.3,'5f78e5c09b10f676291248.jpg',18,91,'2020-10-03'),(76,0,4,'Un vin complexe, c\'est très intéressant.\r\nEn nez on sent les agrumes puis la bouche reste bien grasse.',1,10.95,'5f7c5a1dae296111359481.jpg',1,92,'2020-10-06'),(77,0,4,'Un excellent vin rouge, épais et très fruité, vin très gourmand et idéal sur un plat léger tel un aperitif ou une viande blanche.',1,15.5,'5f80a211b28d5746762143.jpg',1,94,'2020-10-09'),(78,1,3,'Ca manque un peu de caractère mais c’est assez bon pour boire tout seul.\r\nVin fort en alcool mais pas très tannique.\r\nUn bon rapport qualité / prix',1,NULL,'5f81c69fe3465909472851.jpg',1,95,'2020-10-10'),(79,1,NULL,NULL,0,NULL,'5f81cf2782109495655917.jpg',1,97,'2020-10-10'),(80,1,NULL,NULL,0,NULL,'5f81cf9a3c27b797779954.jpg',1,98,'2020-10-10'),(81,1,NULL,NULL,0,NULL,'5f81d0117c398987953124.jpg',1,99,'2020-10-10'),(82,1,NULL,NULL,0,NULL,'5f81d0904a13e806311280.jpg',1,100,'2020-10-10'),(83,1,NULL,NULL,0,NULL,'5f81d0f798ef2392827012.jpg',1,101,'2020-10-10'),(84,1,NULL,'Promo : 39 - 7,8 (20%) = 31,20',0,31.2,'5f81d133b77c3009027791.jpg',1,102,'2020-10-10'),(85,1,NULL,NULL,0,8.99,'5f8deecf430e9152420570.jpg',1,103,'2020-10-19'),(86,1,NULL,NULL,0,9.79,'5f8def409e668648330336.jpg',1,104,'2020-10-19'),(87,0,4,'Très surprenant, une très bonne surprise.\r\nAssez vif en premier lieu puis une bonne minéralité sur la fin.',1,6.2,'5f8df002a7456496456153.jpg',1,105,'2020-10-19'),(88,0,3,'Bon et léger mais un peu décevant je m’attendais à beaucoup mieux.',1,17.15,'5f8df0e3702a7776210685.jpg',1,106,'2020-10-19');
/*!40000 ALTER TABLE `cave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `couleur`
--

DROP TABLE IF EXISTS `couleur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `couleur` (
  `id_couleur` int NOT NULL AUTO_INCREMENT,
  `couleur` varchar(255) NOT NULL,
  PRIMARY KEY (`id_couleur`),
  UNIQUE KEY `couleur` (`couleur`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `couleur`
--

LOCK TABLES `couleur` WRITE;
/*!40000 ALTER TABLE `couleur` DISABLE KEYS */;
INSERT INTO `couleur` VALUES (1,'Blanc'),(2,'Rosé'),(3,'Rouge');
/*!40000 ALTER TABLE `couleur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `domaine`
--

DROP TABLE IF EXISTS `domaine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `domaine` (
  `id_domaine` int NOT NULL AUTO_INCREMENT,
  `domaine` varchar(255) NOT NULL,
  PRIMARY KEY (`id_domaine`),
  UNIQUE KEY `domaine` (`domaine`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `domaine`
--

LOCK TABLES `domaine` WRITE;
/*!40000 ALTER TABLE `domaine` DISABLE KEYS */;
INSERT INTO `domaine` VALUES (1,''),(53,'Alphonse Mellot'),(49,'André Lurton'),(3,'Bouchard Père & Fils'),(87,'Camille Villard'),(8,'Capuano-Ferreri'),(29,'Cave de Lablachère'),(73,'Cave de Tain'),(78,'CD Chanzy'),(42,'Charles Blondeau-Danne et Harro Nijdam'),(7,'Charles Guyot'),(11,'Château Carbonnieux'),(92,'Château de Fesles'),(6,'Château de la Charrière'),(5,'Château de Landiras'),(10,'Château de Rochemorin'),(85,'Château Lagrange de Lescure'),(48,'Chateau Lagrange SAS'),(18,'Chateau Millegrand'),(9,'Château Olivier'),(84,'Chateau Rivière'),(30,'Close de l’Abbé Dubois'),(79,'Clotilde Davenne'),(12,'Comtesse du Barry'),(38,'Corsican'),(82,'Couly-Dutheil'),(61,'Darnat-Jacquinet Henri'),(88,'Domaine Albert Morot'),(40,'Domaine Curot'),(16,'Domaine d\'Avrillé'),(76,'Domaine de la Croix Salain'),(91,'Domaine de la Lysardière'),(60,'Domaine de la Milletière'),(72,'DOMAINE DU REMPART'),(23,'Domaine du vieux college'),(46,'Domaine Jean Monnier & Fils'),(80,'Domaine Jean-Marie Bouzereau'),(45,'Domaine Jouard Gabriel & Paul'),(2,'Domaine Masse'),(41,'Domaine Mazilly Père & Fils'),(74,'Domaine Petit Chateau'),(50,'Domaine Philippe Girard'),(58,'Domaine Prunier Jean Pierre & Laurent'),(70,'Domaine Prunier Jean-Pierre & Laurent'),(32,'Domaine Py'),(71,'Domaine Roc de Châteauvieux'),(63,'Domaine Varenne'),(28,'Domaine Vigier'),(36,'Domaine Yves Girardin'),(59,'Eric Bonnet'),(57,'Estandon'),(26,'Eurl Elian Da Ros Laclotte'),(33,'F. & Ph. Pairault'),(68,'GCF'),(17,'Gérard Bertrand'),(55,'Jean Anney'),(25,'Jean lignières'),(13,'Jean Renaud'),(86,'Jean-Claude Leclerc'),(77,'Jean-Marc Brocard'),(24,'La terrasse d’élise'),(75,'Les Petites Parcelles de Dolia'),(37,'Les Petites Récoltes'),(67,'Les Vignerons de Grimaud VAR'),(56,'Les Vignerons du Mont Ventoux'),(31,'L’Abbé Dubois'),(52,'M. Chapoutier'),(81,'Maurice Lecestre'),(44,'Max & Anne-Marye Piguet-Chouet'),(65,'Miraval'),(69,'Montagnac'),(20,'New Zealand'),(90,'Philippe et Frédéric Jeanjean'),(34,'Pierre Chanau'),(21,'Piguet-Chouet'),(66,'Ravoire & Fils'),(4,'Richard'),(19,'Roubine'),(47,'S.C.C.C'),(43,'SCEA A.Perrin & fils'),(51,'SCEA Chateau Millegrand'),(89,'SCEA Château Puech-Haut'),(54,'SCEA les Religieuses de Larcis Jaumat'),(83,'Sophie et Matthieu Woillez'),(22,'Test'),(27,'Vignerons des Grandes Vignes'),(64,'Vignobles Bonfils'),(62,'Vignobles Dom Brial'),(35,'Wolfberger'),(39,'Yvon Mau');
/*!40000 ALTER TABLE `domaine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pays`
--

DROP TABLE IF EXISTS `pays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pays` (
  `id_pays` int NOT NULL AUTO_INCREMENT,
  `pays` varchar(255) NOT NULL,
  PRIMARY KEY (`id_pays`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pays`
--

LOCK TABLES `pays` WRITE;
/*!40000 ALTER TABLE `pays` DISABLE KEYS */;
INSERT INTO `pays` VALUES (1,'France'),(2,'Etranger');
/*!40000 ALTER TABLE `pays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `region`
--

DROP TABLE IF EXISTS `region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `region` (
  `id_region` int NOT NULL AUTO_INCREMENT,
  `region` varchar(255) NOT NULL,
  `id_pays` int NOT NULL,
  PRIMARY KEY (`id_region`),
  UNIQUE KEY `region` (`region`),
  KEY `id_pays` (`id_pays`) USING BTREE,
  CONSTRAINT `id_pays` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id_pays`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `region`
--

LOCK TABLES `region` WRITE;
/*!40000 ALTER TABLE `region` DISABLE KEYS */;
INSERT INTO `region` VALUES (1,'Alsace',1),(2,'Bordeaux',1),(3,'Bourgogne',1),(4,'Corse',1),(5,'Cote de Provence',1),(6,'Côte du Rhône',1),(7,'Jura',1),(8,'Languedoc Roussillon',1),(9,'Loire',1),(10,'Savoie',1),(11,'Sud Ouest',1),(12,'Etranger',2);
/*!40000 ALTER TABLE `region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `prenom` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Paris','Michael','paris.michael@hotmail.fr','$2y$13$RLTGRKz9rBYtKj2luWvLjOuCjRoMxlUyw7x9GpYPbe9HbQQYjtvo2','5f44ebd0c8055967693782.jpg','admin','2020-08-25'),(2,'Andrey','Gagarin','andreygagarinchel@gmail.com','$2y$13$lj8Bh0zhBAHH6aQUhPyrFu09TETiEoC/pdJNj9b1.sCgtHI2DYSw.','5f86a1d89e088857871606.png','user','2020-10-14'),(18,'Nataly','Gagarina','nataly.gagarina.y@gmail.com','$2y$13$zKQV76CLOvJ6DCUw9wBLLOsHYAot05JfpJL5IJVyKpuz/iZkGZ3tm','5f78e78068fa9249249916.jpg','user','2020-10-03');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vin`
--

DROP TABLE IF EXISTS `vin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vin` (
  `id_vin` int NOT NULL AUTO_INCREMENT,
  `appellation` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `annee` int NOT NULL,
  `id_couleur` int NOT NULL,
  `id_domaine` int NOT NULL,
  `id_region` int NOT NULL,
  PRIMARY KEY (`id_vin`),
  KEY `id_couleur` (`id_couleur`),
  KEY `id_domaine` (`id_domaine`),
  KEY `id_region` (`id_region`),
  CONSTRAINT `id_couleur` FOREIGN KEY (`id_couleur`) REFERENCES `couleur` (`id_couleur`),
  CONSTRAINT `id_domaine` FOREIGN KEY (`id_domaine`) REFERENCES `domaine` (`id_domaine`),
  CONSTRAINT `id_region` FOREIGN KEY (`id_region`) REFERENCES `region` (`id_region`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vin`
--

LOCK TABLES `vin` WRITE;
/*!40000 ALTER TABLE `vin` DISABLE KEYS */;
INSERT INTO `vin` VALUES (21,'Rosé d\'Anjou',2018,2,16,9),(22,'Chardonnay',2017,1,17,8),(23,'R de Roubine',2019,2,19,5),(24,'Haulashore',2015,1,20,12),(25,'Auxey-Duresses \"Les Boutonniers\"',2016,1,21,3),(26,'Test wine',2007,2,22,1),(27,'Marsannay les vignes marie',2017,1,23,3),(28,'K’yenne',2018,1,24,8),(29,'Cayrelières',2018,3,25,11),(30,'Elian da Ros',2018,3,26,11),(31,'Chardonnay Esprit des Lieux',2018,1,27,3),(32,'Gris de Grenache',2018,2,28,6),(33,'Cuvée Charlemagne Merlot',2019,3,29,6),(34,'Côtes du Vivarais',2018,1,30,6),(35,'Chardonnay',2017,1,31,6),(36,'Viognier',2018,1,31,6),(37,'Corbières Cuvée Jules',2019,2,32,8),(38,'Chateau Teynac Saint-Julien',2013,3,33,2),(39,'Pouilly-Fuissé',2018,1,34,3),(40,'Gewurztraminer',2018,1,35,1),(41,'Santenay Sous la Roche',2017,1,36,3),(42,'Coteaux de Peyriac IGP',2019,2,37,9),(43,'St Flo IGP',2019,2,38,4),(44,'Puy Vallon Medoc',2018,3,39,2),(45,'Sancerre',2018,1,40,9),(46,'Beaune 1er Cru les Cent Vignes Cuvée Léonore',2018,1,41,3),(47,'Saint Aubin 1er Cru en Remilly',2018,1,42,3),(48,'Chateau Carbonnieux Grand Cru Classé Pessac-Léognan',2016,1,43,2),(49,'Meursault Cuvée Anne-Marye',2018,1,44,3),(50,'1er Cru « Les Chaumées » Chassagne-Montrachet « Clos de la Truffière »',2015,1,45,3),(51,'Meursault-Charmes Premier Cru',2017,1,46,3),(52,'Chateau Lagrange de Lescure Saint-Emilion Grand Cru',2015,3,47,2),(53,'Les Fiefs de Lagrange Saint Julien',2016,3,48,2),(54,'Chateau la Louvière Pessac-Léognan',2016,3,49,2),(55,'Pommard Vieilles Vignes',2014,3,50,3),(56,'Chateau Millegrand',2019,2,51,8),(57,'Schistes d’Agrumes Condrieu',2016,1,52,6),(58,'La Moussiere Sancerre',2018,1,53,9),(59,'Chateau les Religieuses Saint-Emilion Grand Cru',2016,3,54,2),(60,'Chateau Saint-Corbian Saint-Estèphe',2016,3,55,2),(61,'Chassagne Montrachet 1er Cru Morgeot',2016,1,8,3),(62,'Viognier',2018,1,56,6),(63,'Reflet',2018,2,57,5),(64,'Auxey-Duresses « Vieilles Vignes »',2016,1,58,3),(65,'Réserve Saint Dominique Châteauneuf-du-Pape',2016,3,59,6),(66,'Montlouis Les Renardières',1992,1,60,9),(67,'Meursault',2017,1,61,3),(68,'Chateau les Pins',2015,1,62,8),(69,'Gigondas',2016,3,63,6),(70,'Hautes-Côtes de Beaune',2018,1,41,3),(71,'Beach Rosé IGP',2018,2,64,5),(72,'Studio by Miraval',2019,2,65,5),(73,'Manon',2019,2,66,5),(74,'Cuvée du Golfe de Saint-Tropez',2019,2,67,5),(75,'Fleurs de Prairie',2019,2,68,5),(76,'Les Roches Saintes Picpoul de Pinet IGP',2018,1,69,8),(77,'Auxey-Duresses « Vieilles Vignes »',2018,1,70,3),(78,'Touraine',2018,1,71,9),(79,'Pinot noit',2012,3,72,1),(80,'Bourgogne Chardonnay',2018,1,3,2),(81,'Saint Joseph Les Hauts de Pavières',2018,1,73,6),(82,'Eclat de Pierre Chardonnay',2018,1,74,9),(83,'Chardonnay',2019,1,74,9),(84,'Laudun',2018,1,75,6),(85,'Macon-Villages',2018,1,76,3),(86,'Chardonnay Portlandien',2018,1,77,3),(87,'Bouzeron',2017,1,78,3),(88,'Saint-Bris',2019,1,79,3),(89,'Volnay Champans',2015,3,80,3),(90,'Petit Chablis',2018,1,81,3),(91,'La closerie Chinon',2018,1,82,9),(92,'Vézelay terre de calcaire',2017,1,83,3),(93,'Volnay Champans Premier Cru',2015,3,80,3),(94,'Fixin les champs des charmes',2017,3,23,3),(95,'Cuvée Prestige Minervois',2018,3,84,8),(96,'Saint-Emilion Grand Cru',2015,3,85,2),(97,'Menetou-Salon',2019,1,86,9),(98,'Santenay 1er Cru « Beauregard »',2017,3,87,3),(99,'Savigny-les-Beaune La Bataillère Premier Cru',2018,3,88,3),(100,'Pic Saint-Loup La Closerie',2017,3,89,8),(101,'Mas de Lunès',2017,3,90,8),(102,'Aigle Royal',2018,1,17,8),(103,'Chinon',2018,1,91,9),(104,'Empreinte du Rhône Saint-Peray',2019,1,73,6),(105,'Anjou Blanc Chenin sec Vieilles Vignes',2017,1,92,9),(106,'Givry 1er Cru La Brûlée',2018,3,2,3);
/*!40000 ALTER TABLE `vin` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-19 21:53:06
