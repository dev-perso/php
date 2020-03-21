-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 06 mars 2020 à 09:26
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
  `domaine` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_domaine`),
  UNIQUE KEY `domaine` (`domaine`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `domaine`
--

INSERT INTO `domaine` (`id_domaine`, `domaine`) VALUES
(1, ''),
(3, 'Bouchard Père & Fils'),
(8, 'Capuano-Ferreri'),
(7, 'Charles Guyot'),
(11, 'Château Carbonnieux'),
(6, 'Château de la Charrière'),
(5, 'Château de Landiras'),
(10, 'Château de Rochemorin'),
(9, 'Château Olivier'),
(12, 'Comtesse du Barry'),
(2, 'Domaine Masse'),
(13, 'Jean Renaud'),
(4, 'Richard');

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
  `nom` varchar(150) NOT NULL,
  `prenom` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `prenom`, `email`, `username`, `password`, `role`) VALUES
(1, 'Paris', 'Michael', 'paris.michael@hotmail.fr', 'panam', '$2y$13$RLTGRKz9rBYtKj2luWvLjOuCjRoMxlUyw7x9GpYPbe9HbQQYjtvo2', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `vin`
--

DROP TABLE IF EXISTS `vin`;
CREATE TABLE IF NOT EXISTS `vin` (
  `id_vin` int(11) NOT NULL AUTO_INCREMENT,
  `appellation` varchar(255) CHARACTER SET utf8 NOT NULL,
  `id_couleur` int(11) NOT NULL,
  `id_domaine` int(11) NOT NULL,
  `image` text CHARACTER SET utf8 DEFAULT NULL,
  `id_region` int(11) NOT NULL,
  PRIMARY KEY (`id_vin`),
  KEY `id_couleur` (`id_couleur`),
  KEY `id_domaine` (`id_domaine`),
  KEY `id_region` (`id_region`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cave`
--

DROP TABLE IF EXISTS `cave`;
CREATE TABLE IF NOT EXISTS `cave` (
  `id_cave` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) UNSIGNED NOT NULL,
  `note` enum('0','0,5','1','1,5','2','2,5','3','3,5','4','4,5','5') DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT 0,
  `prix` double DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `id_vin` int(11) NOT NULL,
  PRIMARY KEY (`id_cave`),
  KEY `id_vin` (`id_vin`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Contraintes pour les tables déchargées
--

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
