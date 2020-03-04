-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 26 fév. 2020 à 13:52
-- Version du serveur :  5.7.21
-- Version de PHP :  7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE DATABASE macaveavin;
USE macaveavin;

ALTER DATABASE macaveavin CHARACTER SET utf8 COLLATE utf8_general_ci;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `macaveavin`
--

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `email`, `username`, `password`) VALUES
(1, 'Paris', 'Michael', 'paris.michael@hotmail.fr', 'panam', '$2y$13$RLTGRKz9rBYtKj2luWvLjOuCjRoMxlUyw7x9GpYPbe9HbQQYjtvo2');

-- --------------------------------------------------------

--
-- Structure de la table `vin`
--

DROP TABLE IF EXISTS `vin`;
CREATE TABLE IF NOT EXISTS `vin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `region` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `couleur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `appellation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `chateau` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annee` int(11) NOT NULL,
  `prix` double DEFAULT NULL,
  `quantite` int(11) NOT NULL,
  `description` text,
  `image` longtext,
  `note` smallint(6) DEFAULT NULL,
  `archive` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `vin`
--

INSERT INTO `vin` (`id`, `region`, `couleur`, `appellation`, `chateau`, `annee`, `prix`, `quantite`, `description`, `image`, `note`, `archive`) VALUES
(1, 'bourgogne', 'blanc', 'Chardonnay', NULL, 2017, 8, 2, NULL, NULL, 3, 1),
(2, 'bourgogne', 'rouge', 'Bourgogne Chardonnay', NULL, 2020, NULL, 1, NULL, NULL, NULL, NULL),
(3, 'languedoc', 'rouge', 'qzdqzd', NULL, 2020, NULL, 1, NULL, NULL, NULL, 0),
(4, 'cote_rhone', 'rose', 'qzd', NULL, 2020, NULL, 1, NULL, NULL, NULL, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
