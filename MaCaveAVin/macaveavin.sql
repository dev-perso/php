-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 29 jan. 2020 à 21:41
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
-- Structure de la table `vin`
--

DROP TABLE IF EXISTS `vin`;
CREATE TABLE IF NOT EXISTS `vin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `couleur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appellation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chateau` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annee` int(11) NOT NULL,
  `prix` double DEFAULT NULL,
  `quantite` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 DEFAULT NULL,
  `image` longtext CHARACTER SET utf8 DEFAULT NULL,
  `note` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vin`
--

INSERT INTO `vin` (`id`, `region`, `couleur`, `appellation`, `chateau`, `annee`, `prix`, `nombre`, `description`, `image`, `note`) VALUES
(1, 'bourgogne', 'blanc', 'Chardonnay', NULL, 2017, 8, 0, NULL, NULL, 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
