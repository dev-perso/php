-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 28 août 2020 à 11:51
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `macaveavin`
--

-- --------------------------------------------------------

--
-- Structure de la table `cave`
--

DROP TABLE IF EXISTS `cave`;
CREATE TABLE IF NOT EXISTS `cave` (
  `id_cave` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) UNSIGNED NOT NULL,
  `note` int(5) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT 0,
  `prix` double DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `id_vin` int(11) NOT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id_cave`),
  KEY `id_vin` (`id_vin`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `cave`
--

INSERT INTO `cave` (`id_cave`, `quantite`, `note`, `description`, `archive`, `prix`, `image`, `id_user`, `id_vin`, `updated_at`) VALUES
(4, 0, 2, 'Rose d’anjou habituelle sucré', 1, NULL, NULL, 1, 21, NULL),
(6, 0, NULL, 'Je ne m\'en rappelle plus !!!', 1, NULL, NULL, 1, 22, NULL),
(7, 0, 4, 'Le rosé idéal pour l\'apéro', 1, 7.45, NULL, 1, 23, NULL),
(8, 1, NULL, NULL, 0, 7, '5ebac934748ee912445009.jpg', 2, 24, '2020-05-12'),
(9, 1, NULL, NULL, 0, NULL, '5f37d61a807bf046605190.jpg', 1, 25, '2020-08-15'),
(10, 1, NULL, 'Test desc', 0, 100, '5ed8756457022574537307.jpg', 2, 26, '2020-06-04'),
(11, 1, NULL, NULL, 0, NULL, NULL, 1, 27, NULL),
(12, 1, NULL, NULL, 0, NULL, '5f3d67e958562653786047.jpg', 1, 28, '2020-08-19'),
(13, 1, NULL, NULL, 0, NULL, '5f3d66d6c7987131408088.jpg', 1, 29, '2020-08-19'),
(14, 1, NULL, NULL, 0, NULL, '5f3d677767f46722556214.jpg', 1, 30, '2020-08-19'),
(15, 1, NULL, NULL, 0, NULL, NULL, 1, 31, NULL),
(16, 1, NULL, NULL, 0, NULL, '5f3d68f6d0063213629268.jpg', 1, 32, '2020-08-19'),
(17, 1, NULL, NULL, 0, NULL, '5f3d66f864b88987982542.jpg', 1, 33, '2020-08-19'),
(18, 1, NULL, NULL, 0, NULL, '5f3d68182135e028036015.jpg', 1, 34, '2020-08-19'),
(19, 0, 4, 'Très bon chardonnay, pas le meilleur mais très bon', 1, NULL, '5f3d671f02127590707064.jpg', 1, 35, '2020-08-19'),
(20, 1, 4, 'Bon Viognier, top pour l’apéro', 0, NULL, '5f3d67aaef549600745833.jpg', 1, 36, '2020-08-19'),
(21, 0, 3, 'Bon rosé sans plus', 1, 12, NULL, 1, 37, NULL),
(22, 0, 4, 'Très bon vin rouge, léger et fruité idéal à déguster ou pour un apréritif', 1, NULL, '5f36d626a9b8f020330574.jpg', 1, 38, '2020-08-14'),
(23, 0, 4, 'Très bonne surprise pour ce vin assez gras et qui reste en bouche.', 1, NULL, '5f36d70c38c73278068509.jpg', 1, 39, '2020-08-14'),
(24, 0, 2, 'Vin blanc avec une forte prononciation de sucre. Pas trop à mon gout, mais peut être idéal pour faire des cocktail.', 1, NULL, '5f37bd7c62660407923839.jpg', 1, 40, '2020-08-15'),
(25, 0, 4, 'Très bon vin blanc idéal à boire accompagner d\'une viande blanche ou du poisson ou bien même lors d\'un apéritif dînatoire, vin assez gras et fruité.', 1, NULL, '5f37bdfed174b695681585.jpg', 1, 41, '2020-08-15'),
(26, 0, 3, 'Rosé qualité/prix top', 1, NULL, '5f37bf380f402752631687.jpg', 1, 42, '2020-08-15'),
(27, 0, 3, NULL, 1, NULL, '5f39936bbb813536866237.jpg', 1, 43, '2020-08-16'),
(28, 0, 3, NULL, 1, NULL, '5f3d352fa4664812564738.jpg', 1, 44, '2020-08-19'),
(29, 1, NULL, NULL, 0, NULL, '5f3d47695bb07489955578.jpg', 1, 45, '2020-08-19'),
(30, 1, NULL, NULL, 0, NULL, '5f3d60083935c858760149.jpg', 1, 46, '2020-08-19'),
(31, 1, NULL, NULL, 0, NULL, '5f3d60956e2a5446885402.jpg', 1, 47, '2020-08-19'),
(32, 1, NULL, NULL, 0, NULL, '5f3d613b3b5c9593627660.jpg', 1, 48, '2020-08-19'),
(33, 1, NULL, NULL, 0, NULL, '5f3d61b427cdd940538845.jpg', 1, 49, '2020-08-19'),
(34, 1, NULL, NULL, 0, NULL, '5f3d62323f56c023186153.jpg', 1, 50, '2020-08-19'),
(35, 1, NULL, NULL, 0, NULL, '5f3d62957d5b3999876906.jpg', 1, 51, '2020-08-19'),
(36, 1, NULL, NULL, 0, NULL, '5f3d6350afc34935761915.jpg', 1, 52, '2020-08-19'),
(37, 1, NULL, NULL, 0, NULL, '5f3d63bc5eb00739408753.jpg', 1, 53, '2020-08-19'),
(38, 1, NULL, NULL, 0, NULL, '5f3d6441ad0eb775810046.jpg', 1, 54, '2020-08-19'),
(39, 1, NULL, NULL, 0, NULL, '5f3d6488dda86058498912.jpg', 1, 55, '2020-08-19'),
(40, 1, NULL, NULL, 0, NULL, '5f3d64d9ac3e2603203546.jpg', 1, 56, '2020-08-19'),
(41, 1, NULL, NULL, 0, NULL, '5f3d653bc43a1629979354.jpg', 1, 57, '2020-08-19'),
(42, 1, NULL, NULL, 0, NULL, '5f3d686346932746289898.jpg', 1, 58, '2020-08-19'),
(43, 1, NULL, NULL, 0, NULL, '5f3d697d69272982082012.jpg', 1, 59, '2020-08-19'),
(44, 1, NULL, NULL, 0, NULL, '5f3d69dd65b2c876331166.jpg', 1, 60, '2020-08-19'),
(45, 1, NULL, NULL, 0, NULL, '5f3d6a5f3dc4c187580571.jpg', 1, 61, '2020-08-19'),
(46, 1, NULL, NULL, 0, NULL, '5f3eb0d39c399989149479.jpg', 1, 62, '2020-08-20'),
(47, 1, NULL, NULL, 0, NULL, '5f3eb1240bc51371126984.jpg', 1, 63, '2020-08-20'),
(48, 1, NULL, NULL, 0, NULL, '5f3eb1a813e22957893977.jpg', 1, 64, '2020-08-20'),
(49, 1, NULL, NULL, 0, NULL, '5f3eb216ae044107030707.jpg', 1, 65, '2020-08-20'),
(50, 1, NULL, NULL, 0, NULL, '5f3eb2826455d038328660.jpg', 1, 66, '2020-08-20'),
(51, 1, NULL, NULL, 0, NULL, '5f3eb34627da6259922613.jpg', 1, 67, '2020-08-20'),
(52, 1, NULL, NULL, 0, NULL, '5f3eb39d3315f298405155.jpg', 1, 68, '2020-08-20'),
(53, 1, NULL, NULL, 0, NULL, '5f3eb3cfc7955845054384.jpg', 1, 69, '2020-08-20'),
(54, 1, NULL, NULL, 0, NULL, '5f3eb41ea6a1d027958970.jpg', 1, 70, '2020-08-20'),
(55, 0, 3, 'Bon rosé qualité/prix', 1, 2.99, '5f3eb4f4d390b668489541.jpg', 1, 71, '2020-08-20');

-- --------------------------------------------------------

--
-- Structure de la table `couleur`
--

DROP TABLE IF EXISTS `couleur`;
CREATE TABLE IF NOT EXISTS `couleur` (
  `id_couleur` int(11) NOT NULL AUTO_INCREMENT,
  `couleur` varchar(255) NOT NULL,
  PRIMARY KEY (`id_couleur`),
  UNIQUE KEY `couleur` (`couleur`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `couleur`
--

INSERT INTO `couleur` (`id_couleur`, `couleur`) VALUES
(1, 'Blanc'),
(2, 'Rosé'),
(3, 'Rouge');

-- --------------------------------------------------------

--
-- Structure de la table `domaine`
--

DROP TABLE IF EXISTS `domaine`;
CREATE TABLE IF NOT EXISTS `domaine` (
  `id_domaine` int(11) NOT NULL AUTO_INCREMENT,
  `domaine` varchar(255) NOT NULL,
  PRIMARY KEY (`id_domaine`),
  UNIQUE KEY `domaine` (`domaine`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `domaine`
--

INSERT INTO `domaine` (`id_domaine`, `domaine`) VALUES
(1, ''),
(53, 'Alphonse Mellot'),
(49, 'André Lurton'),
(3, 'Bouchard Père & Fils'),
(8, 'Capuano-Ferreri'),
(29, 'Cave de Lablachère'),
(42, 'Charles Blondeau-Danne et Harro Nijdam'),
(7, 'Charles Guyot'),
(11, 'Château Carbonnieux'),
(6, 'Château de la Charrière'),
(5, 'Château de Landiras'),
(10, 'Château de Rochemorin'),
(48, 'Chateau Lagrange SAS'),
(18, 'Chateau Millegrand'),
(9, 'Château Olivier'),
(30, 'Close de l’Abbé Dubois'),
(12, 'Comtesse du Barry'),
(38, 'Corsican'),
(61, 'Darnat-Jacquinet Henri'),
(40, 'Domaine Curot'),
(16, 'Domaine d\'Avrillé'),
(60, 'Domaine de la Milletière'),
(23, 'Domaine du vieux college'),
(46, 'Domaine Jean Monnier & Fils'),
(45, 'Domaine Jouard Gabriel & Paul'),
(2, 'Domaine Masse'),
(41, 'Domaine Mazilly Père & Fils'),
(50, 'Domaine Philippe Girard'),
(58, 'Domaine Prunier Jean Pierre & Laurent'),
(32, 'Domaine Py'),
(63, 'Domaine Varenne'),
(28, 'Domaine Vigier'),
(36, 'Domaine Yves Girardin'),
(59, 'Eric Bonnet'),
(57, 'Estandon'),
(26, 'Eurl Elian Da Ros Laclotte'),
(33, 'F. & Ph. Pairault'),
(17, 'Gérard Bertrand'),
(55, 'Jean Anney'),
(25, 'Jean lignières'),
(13, 'Jean Renaud'),
(24, 'La terrasse d’élise'),
(37, 'Les Petites Récoltes'),
(56, 'Les Vignerons du Mont Ventoux'),
(31, 'L’Abbé Dubois'),
(52, 'M. Chapoutier'),
(44, 'Max & Anne-Marye Piguet-Chouet'),
(20, 'New Zealand'),
(34, 'Pierre Chanau'),
(21, 'Piguet-Chouet'),
(4, 'Richard'),
(19, 'Roubine'),
(47, 'S.C.C.C'),
(43, 'SCEA A.Perrin & fils'),
(51, 'SCEA Chateau Millegrand'),
(54, 'SCEA les Religieuses de Larcis Jaumat'),
(22, 'Test'),
(27, 'Vignerons des Grandes Vignes'),
(64, 'Vignobles Bonfils'),
(62, 'Vignobles Dom Brial'),
(35, 'Wolfberger'),
(39, 'Yvon Mau');

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `id_pays` int(11) NOT NULL AUTO_INCREMENT,
  `pays` varchar(255) NOT NULL,
  PRIMARY KEY (`id_pays`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id_pays`, `pays`) VALUES
(1, 'France'),
(2, 'Etranger');

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

DROP TABLE IF EXISTS `region`;
CREATE TABLE IF NOT EXISTS `region` (
  `id_region` int(11) NOT NULL AUTO_INCREMENT,
  `region` varchar(255) NOT NULL,
  `id_pays` int(11) NOT NULL,
  PRIMARY KEY (`id_region`),
  UNIQUE KEY `region` (`region`),
  KEY `id_pays` (`id_pays`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`id_region`, `region`, `id_pays`) VALUES
(1, 'Alsace', 1),
(2, 'Bordeaux', 1),
(3, 'Bourgogne', 1),
(4, 'Corse', 1),
(5, 'Cote de Provence', 1),
(6, 'Côte du Rhône', 1),
(7, 'Jura', 1),
(8, 'Languedoc Roussillon', 1),
(9, 'Loire', 1),
(10, 'Savoie', 1),
(11, 'Sud Ouest', 1),
(12, 'Etranger', 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) DEFAULT NULL,
  `prenom` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `prenom`, `email`, `username`, `password`, `profile_img`, `role`, `updated_at`) VALUES
(1, 'Paris', 'Michael', 'paris.michael@hotmail.fr', 'panam', '$2y$13$RLTGRKz9rBYtKj2luWvLjOuCjRoMxlUyw7x9GpYPbe9HbQQYjtvo2', '5f44ebd0c8055967693782.jpg', 'admin', '2020-08-25'),
(2, 'Andrey', 'Gagarin', 'andreygagarinchel@gmail.com', 'andychel', '$2y$13$lj8Bh0zhBAHH6aQUhPyrFu09TETiEoC/pdJNj9b1.sCgtHI2DYSw.', '5eb85e6253360816612027.jpg', 'user', '2020-05-10');

-- --------------------------------------------------------

--
-- Structure de la table `vin`
--

DROP TABLE IF EXISTS `vin`;
CREATE TABLE IF NOT EXISTS `vin` (
  `id_vin` int(11) NOT NULL AUTO_INCREMENT,
  `appellation` varchar(255) CHARACTER SET utf8 NOT NULL,
  `annee` int(11) NOT NULL,
  `id_couleur` int(11) NOT NULL,
  `id_domaine` int(11) NOT NULL,
  `id_region` int(11) NOT NULL,
  PRIMARY KEY (`id_vin`),
  KEY `id_couleur` (`id_couleur`),
  KEY `id_domaine` (`id_domaine`),
  KEY `id_region` (`id_region`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vin`
--

INSERT INTO `vin` (`id_vin`, `appellation`, `annee`, `id_couleur`, `id_domaine`, `id_region`) VALUES
(21, 'Rosé d\'Anjou', 2018, 2, 16, 9),
(22, 'Chardonnay', 2017, 1, 17, 8),
(23, 'R de Roubine', 2019, 2, 19, 5),
(24, 'Haulashore', 2015, 1, 20, 12),
(25, 'Auxey-Duresses \"Les Boutonniers\"', 2016, 1, 21, 3),
(26, 'Test wine', 2007, 2, 22, 1),
(27, 'Marsannay les vignes marie', 2017, 1, 23, 3),
(28, 'K’yenne', 2018, 1, 24, 8),
(29, 'Cayrelières', 2018, 3, 25, 11),
(30, 'Elian da Ros', 2018, 3, 26, 11),
(31, 'Chardonnay Esprit des Lieux', 2018, 1, 27, 3),
(32, 'Gris de Grenache', 2018, 2, 28, 6),
(33, 'Cuvée Charlemagne Merlot', 2019, 3, 29, 6),
(34, 'Côtes du Vivarais', 2018, 1, 30, 6),
(35, 'Chardonnay', 2017, 1, 31, 6),
(36, 'Viognier', 2018, 1, 31, 6),
(37, 'Corbières Cuvée Jules', 2019, 2, 32, 8),
(38, 'Chateau Teynac Saint-Julien', 2013, 3, 33, 2),
(39, 'Pouilly-Fuissé', 2018, 1, 34, 3),
(40, 'Gewurztraminer', 2018, 1, 35, 1),
(41, 'Santenay Sous la Roche', 2017, 1, 36, 3),
(42, 'Coteaux de Peyriac IGP', 2019, 2, 37, 9),
(43, 'St Flo IGP', 2019, 2, 38, 4),
(44, 'Puy Vallon Medoc', 2018, 3, 39, 2),
(45, 'Sancerre', 2018, 1, 40, 9),
(46, 'Beaune 1er Cru les Cent Vignes Cuvée Léonore', 2018, 1, 41, 3),
(47, 'Saint Aubin 1er Cru en Remilly', 2018, 1, 42, 3),
(48, 'Chateau Carbonnieux Grand Cru Classé Pessac-Léognan', 2016, 1, 43, 2),
(49, 'Meursault Cuvée Anne-Marye', 2018, 1, 44, 3),
(50, '1er Cru « Les Chaumées » Chassagne-Montrachet « Clos de la Truffière »', 2015, 1, 45, 3),
(51, 'Meursault-Charmes Premier Cru', 2017, 1, 46, 3),
(52, 'Chateau Lagrange de Lescure Saint-Emilion Grand Cru', 2015, 3, 47, 2),
(53, 'Les Fiefs de Lagrange Saint Julien', 2016, 3, 48, 2),
(54, 'Chateau la Louvière Pessac-Léognan', 2016, 3, 49, 2),
(55, 'Pommard Vieilles Vignes', 2014, 3, 50, 3),
(56, 'Chateau Millegrand', 2019, 2, 51, 8),
(57, 'Schistes d’Agrumes Condrieu', 2016, 1, 52, 6),
(58, 'La Moussiere Sancerre', 2018, 1, 53, 9),
(59, 'Chateau les Religieuses Saint-Emilion Grand Cru', 2016, 3, 54, 2),
(60, 'Chateau Saint-Corbian Saint-Estèphe', 2016, 3, 55, 2),
(61, 'Chassagne Montrachet 1er Cru Morgeot', 2016, 1, 8, 3),
(62, 'Viognier', 2018, 1, 56, 6),
(63, 'Reflet', 2018, 2, 57, 5),
(64, 'Auxey-Duresses « Vieilles Vignes »', 2016, 1, 58, 3),
(65, 'Réserve Saint Dominique Châteauneuf-du-Pape', 2016, 3, 59, 6),
(66, 'Montlouis Les Renardières', 1992, 1, 60, 9),
(67, 'Meursault', 2017, 1, 61, 3),
(68, 'Chateau les Pins', 2015, 1, 62, 8),
(69, 'Gigondas', 2016, 3, 63, 6),
(70, 'Hautes-Côtes de Beaune', 2018, 1, 41, 3),
(71, 'Beach Rosé IGP', 2018, 2, 64, 5);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cave`
--
ALTER TABLE `cave`
  ADD CONSTRAINT `id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `id_vin` FOREIGN KEY (`id_vin`) REFERENCES `vin` (`id_vin`);

--
-- Contraintes pour la table `region`
--
ALTER TABLE `region`
  ADD CONSTRAINT `id_pays` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id_pays`);

--
-- Contraintes pour la table `vin`
--
ALTER TABLE `vin`
  ADD CONSTRAINT `id_couleur` FOREIGN KEY (`id_couleur`) REFERENCES `couleur` (`id_couleur`),
  ADD CONSTRAINT `id_domaine` FOREIGN KEY (`id_domaine`) REFERENCES `domaine` (`id_domaine`),
  ADD CONSTRAINT `id_region` FOREIGN KEY (`id_region`) REFERENCES `region` (`id_region`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
