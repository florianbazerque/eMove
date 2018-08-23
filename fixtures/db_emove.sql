-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 23 août 2018 à 07:37
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `db_emove`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse_facturation`
--

DROP TABLE IF EXISTS `adresse_facturation`;
CREATE TABLE IF NOT EXISTS `adresse_facturation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `complement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `agence`
--

DROP TABLE IF EXISTS `agence`;
CREATE TABLE IF NOT EXISTS `agence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `agence`
--

INSERT INTO `agence` (`id`, `label`) VALUES
(5, 'Paris'),
(6, 'Lyon');

-- --------------------------------------------------------

--
-- Structure de la table `dispo_vehicule`
--

DROP TABLE IF EXISTS `dispo_vehicule`;
CREATE TABLE IF NOT EXISTS `dispo_vehicule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `dispo_vehicule`
--

INSERT INTO `dispo_vehicule` (`id`, `label`) VALUES
(5, 'Disponible'),
(6, 'Indisponible');

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_id` int(11) DEFAULT NULL,
  `status_facture_id` int(11) DEFAULT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_FE86641064D218E` (`location_id`),
  KEY `IDX_FE8664107E7E0A8E` (`status_facture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `update_at` datetime NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_location_id` int(11) DEFAULT NULL,
  `vehicule_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `return_km` int(11) DEFAULT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5E9E89CB297547F` (`status_location_id`),
  KEY `IDX_5E9E89CB4A4A3511` (`vehicule_id`),
  KEY `IDX_5E9E89CBA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `location`
--

INSERT INTO `location` (`id`, `status_location_id`, `vehicule_id`, `user_id`, `start_date`, `end_date`, `return_date`, `return_km`, `price`) VALUES
(3, 9, 3, 4, '2018-08-23 10:57:00', '2018-08-31 10:57:00', NULL, NULL, 455);

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id`, `label`) VALUES
(3, 'Citroen');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `heure` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20180703152943');

-- --------------------------------------------------------

--
-- Structure de la table `promo`
--

DROP TABLE IF EXISTS `promo`;
CREATE TABLE IF NOT EXISTS `promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `legal_condition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque_id` int(11) DEFAULT NULL,
  `vehicule_id` int(11) DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B0139AFB4A4A3511` (`vehicule_id`),
  KEY `IDX_B0139AFB4827B9B2` (`marque_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `status_facture`
--

DROP TABLE IF EXISTS `status_facture`;
CREATE TABLE IF NOT EXISTS `status_facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `status_facture`
--

INSERT INTO `status_facture` (`id`, `label`) VALUES
(5, 'A signé'),
(6, 'Disponible');

-- --------------------------------------------------------

--
-- Structure de la table `status_location`
--

DROP TABLE IF EXISTS `status_location`;
CREATE TABLE IF NOT EXISTS `status_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `status_location`
--

INSERT INTO `status_location` (`id`, `label`) VALUES
(7, 'En location'),
(8, 'Réservé'),
(9, 'Retourné');

-- --------------------------------------------------------

--
-- Structure de la table `type_user`
--

DROP TABLE IF EXISTS `type_user`;
CREATE TABLE IF NOT EXISTS `type_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_user`
--

INSERT INTO `type_user` (`id`, `label`) VALUES
(5, 'Administrateur'),
(6, 'Utilisateur');

-- --------------------------------------------------------

--
-- Structure de la table `type_vehicule`
--

DROP TABLE IF EXISTS `type_vehicule`;
CREATE TABLE IF NOT EXISTS `type_vehicule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_vehicule`
--

INSERT INTO `type_vehicule` (`id`, `label`) VALUES
(5, 'Voiture'),
(6, 'Scooter');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` datetime DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fidelity_point` int(11) DEFAULT NULL,
  `tel_num` int(11) DEFAULT NULL,
  `licence_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spend_point` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8D93D6498F4FBC60` (`type_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `type_user_id`, `first_name`, `last_name`, `email`, `password`, `birth_date`, `adresse`, `fidelity_point`, `tel_num`, `licence_num`, `spend_point`) VALUES
(4, 5, 'Toto', 'Titi', 'contact@ecole-ipssi.com', '$2y$10$bSL/NJLGo..PxhoGU8zoz.N9jwIofTY4AaCssjujRKhOP1uZeJxNa', '1993-01-01 00:00:00', '17 Rue Claude Tillier,', 70, 818088966, 'AA588F6Z', NULL),
(5, 6, 'flo', 'flo', 'test2@test.com', '$2y$10$ZJ28vAykLTwxoQ70uDhrtefRjfs737uMOcfBjouNrG9/rQpj1bypa', '2018-08-22 00:00:00', '71 Ave Flandre', 0, 202020202, 'fvrev1156', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE IF NOT EXISTS `vehicule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_vehicule_id` int(11) DEFAULT NULL,
  `dispo_vehicule_id` int(11) DEFAULT NULL,
  `agence_id` int(11) DEFAULT NULL,
  `marque_id` int(11) DEFAULT NULL,
  `modele` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_serie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plaque_imma` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_km` int(11) DEFAULT NULL,
  `date_achat` datetime DEFAULT NULL,
  `prix_achat` double DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_292FFF1D153E280` (`type_vehicule_id`),
  KEY `IDX_292FFF1D96D74F5E` (`dispo_vehicule_id`),
  KEY `IDX_292FFF1DD725330D` (`agence_id`),
  KEY `IDX_292FFF1D4827B9B2` (`marque_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vehicule`
--

INSERT INTO `vehicule` (`id`, `type_vehicule_id`, `dispo_vehicule_id`, `agence_id`, `marque_id`, `modele`, `num_serie`, `couleur`, `plaque_imma`, `description`, `nb_km`, `date_achat`, `prix_achat`, `image`) VALUES
(3, 5, NULL, 5, 3, 'Audi A7', 'AAA111111', 'Noir', 'AAA111111', 'Sed tamen haec cum ita tutius observentur, \r\n        quidam vigore artuum inminuto rogati ad nuptias ubi aurum dextris manibus \r\n        cavatis offertur, inpigre vel usque Spoletium pergunt. haec nobilium sunt instituta.', 150000, '2018-08-22 14:17:24', 50.5, 'img/voiture/Audi/A7/1.jpg');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `FK_FE86641064D218E` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  ADD CONSTRAINT `FK_FE8664107E7E0A8E` FOREIGN KEY (`status_facture_id`) REFERENCES `status_facture` (`id`);

--
-- Contraintes pour la table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `FK_5E9E89CB297547F` FOREIGN KEY (`status_location_id`) REFERENCES `status_location` (`id`),
  ADD CONSTRAINT `FK_5E9E89CB4A4A3511` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id`),
  ADD CONSTRAINT `FK_5E9E89CBA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `promo`
--
ALTER TABLE `promo`
  ADD CONSTRAINT `FK_B0139AFB4827B9B2` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`),
  ADD CONSTRAINT `FK_B0139AFB4A4A3511` FOREIGN KEY (`vehicule_id`) REFERENCES `vehicule` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6498F4FBC60` FOREIGN KEY (`type_user_id`) REFERENCES `type_user` (`id`);

--
-- Contraintes pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD CONSTRAINT `FK_292FFF1D153E280` FOREIGN KEY (`type_vehicule_id`) REFERENCES `type_vehicule` (`id`),
  ADD CONSTRAINT `FK_292FFF1D4827B9B2` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`),
  ADD CONSTRAINT `FK_292FFF1D96D74F5E` FOREIGN KEY (`dispo_vehicule_id`) REFERENCES `dispo_vehicule` (`id`),
  ADD CONSTRAINT `FK_292FFF1DD725330D` FOREIGN KEY (`agence_id`) REFERENCES `agence` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
