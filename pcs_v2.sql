-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 02 juin 2024 à 22:09
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pcs_v2`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

DROP TABLE IF EXISTS `abonnement`;
CREATE TABLE IF NOT EXISTS `abonnement` (
  `id_abonnement` int NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `description` text,
  `montant` decimal(6,2) DEFAULT NULL,
  `utilisateur` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_abonnement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `abonnement_commande`
--

DROP TABLE IF EXISTS `abonnement_commande`;
CREATE TABLE IF NOT EXISTS `abonnement_commande` (
  `id_utilisateur` int NOT NULL,
  `id_paiement` int NOT NULL,
  `id_abonnement` int NOT NULL,
  `montant` decimal(6,2) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`,`id_paiement`,`id_abonnement`),
  KEY `id_paiement` (`id_paiement`),
  KEY `id_abonnement` (`id_abonnement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bien`
--

DROP TABLE IF EXISTS `bien`;
CREATE TABLE IF NOT EXISTS `bien` (
  `id_bien` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `pays` varchar(50) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `salon` int DEFAULT NULL,
  `cuisine` int DEFAULT NULL,
  `salle_de_bain` int DEFAULT NULL,
  `toilette` int DEFAULT NULL,
  `chambre` int DEFAULT NULL,
  `superficie` decimal(10,2) DEFAULT NULL,
  `creation` datetime DEFAULT NULL,
  `maj` datetime DEFAULT NULL,
  `raison_refus` text,
  `id_utilisateur` int NOT NULL,
  `id_utilisateur_1` int NOT NULL,
  PRIMARY KEY (`id_bien`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_utilisateur_1` (`id_utilisateur_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etat_des_lieux`
--

DROP TABLE IF EXISTS `etat_des_lieux`;
CREATE TABLE IF NOT EXISTS `etat_des_lieux` (
  `id_etat` int NOT NULL AUTO_INCREMENT,
  `date_etat` date DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `id_bien` int NOT NULL,
  PRIMARY KEY (`id_etat`),
  KEY `id_bien` (`id_bien`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `id_facture` int NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `service` varchar(100) DEFAULT NULL,
  `description` text,
  `id_paiement` int NOT NULL,
  PRIMARY KEY (`id_facture`),
  KEY `id_paiement` (`id_paiement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fiche_intervention`
--

DROP TABLE IF EXISTS `fiche_intervention`;
CREATE TABLE IF NOT EXISTS `fiche_intervention` (
  `id_fiche` int NOT NULL AUTO_INCREMENT,
  `url` char(255) DEFAULT NULL,
  `montant` decimal(6,2) DEFAULT NULL,
  `raison` varchar(255) DEFAULT NULL,
  `description` text,
  `id_bien` int NOT NULL,
  `id_intervention` int NOT NULL,
  `id_paiement` int NOT NULL,
  PRIMARY KEY (`id_fiche`),
  KEY `id_bien` (`id_bien`),
  KEY `id_intervention` (`id_intervention`),
  KEY `id_paiement` (`id_paiement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `habilitation`
--

DROP TABLE IF EXISTS `habilitation`;
CREATE TABLE IF NOT EXISTS `habilitation` (
  `id_habilitation` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `description` text,
  `url` varchar(255) DEFAULT NULL,
  `id_utilisateur` int NOT NULL,
  `id_utilisateur_1` int NOT NULL,
  PRIMARY KEY (`id_habilitation`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_utilisateur_1` (`id_utilisateur_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

DROP TABLE IF EXISTS `intervention`;
CREATE TABLE IF NOT EXISTS `intervention` (
  `id_intervention` int NOT NULL AUTO_INCREMENT,
  `date_debut_intervention` date DEFAULT NULL,
  `date_fin_intervention` date DEFAULT NULL,
  `raison` char(255) DEFAULT NULL,
  `description` text,
  `id_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_intervention`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `message` text,
  `id_utilisateur` int NOT NULL,
  `id_utilisateur_1` int NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_utilisateur_1` (`id_utilisateur_1`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `occupation`
--

DROP TABLE IF EXISTS `occupation`;
CREATE TABLE IF NOT EXISTS `occupation` (
  `id_occupation` int NOT NULL AUTO_INCREMENT,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `raison_indispo` text,
  `nombre_personne` int DEFAULT NULL,
  `id_bien` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_occupation`),
  KEY `id_bien` (`id_bien`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
CREATE TABLE IF NOT EXISTS `paiement` (
  `id_paiement` int NOT NULL AUTO_INCREMENT,
  `date_paiement` date DEFAULT NULL,
  `paiement_valide` tinyint(1) DEFAULT NULL,
  `paiement_methode` varchar(50) DEFAULT NULL,
  `montant` decimal(15,2) DEFAULT NULL,
  `raison_rembourssement` text,
  `id_bien` int NOT NULL,
  `id_intervention` int NOT NULL,
  PRIMARY KEY (`id_paiement`),
  KEY `id_bien` (`id_bien`),
  KEY `id_intervention` (`id_intervention`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `id_photo` int NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `id_bien` int NOT NULL,
  PRIMARY KEY (`id_photo`),
  KEY `id_bien` (`id_bien`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `prestation`
--

DROP TABLE IF EXISTS `prestation`;
CREATE TABLE IF NOT EXISTS `prestation` (
  `id_prestation` int NOT NULL AUTO_INCREMENT,
  `montant` decimal(6,2) DEFAULT NULL,
  `durée_jour` int DEFAULT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text,
  `evolution` tinyint(1) DEFAULT NULL,
  `id_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_prestation`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `prestation_commande`
--

DROP TABLE IF EXISTS `prestation_commande`;
CREATE TABLE IF NOT EXISTS `prestation_commande` (
  `id_utilisateur` int NOT NULL,
  `id_utilisateur_1` int NOT NULL,
  `id_prestation` int NOT NULL,
  `id_paiement` int NOT NULL,
  `montant` decimal(6,2) DEFAULT NULL,
  `evaluation` char(1) DEFAULT NULL,
  `url_fiche` varchar(255) DEFAULT NULL,
  `debut_prestation` date DEFAULT NULL,
  `durée` smallint DEFAULT NULL,
  `fin_prestation` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`,`id_utilisateur_1`,`id_prestation`,`id_paiement`),
  KEY `id_utilisateur_1` (`id_utilisateur_1`),
  KEY `id_prestation` (`id_prestation`),
  KEY `id_paiement` (`id_paiement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(70) DEFAULT NULL,
  `date_inscription` datetime DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `numero_telephone` char(10) DEFAULT NULL,
  `pays_telephone` varchar(10) DEFAULT NULL,
  `bloque` date DEFAULT NULL,
  `supprime` date DEFAULT NULL,
  `accepte` date DEFAULT NULL,
  `code_banque` char(5) DEFAULT NULL,
  `code_guichet` char(5) DEFAULT NULL,
  `numero_de_compte` char(11) DEFAULT NULL,
  `cle_rib` char(2) DEFAULT NULL,
  `iban` varchar(34) DEFAULT NULL,
  `bic` varchar(11) DEFAULT NULL,
  `nom_banque` varchar(100) DEFAULT NULL,
  `url_rib` varchar(100) DEFAULT NULL,
  `administrateur` date DEFAULT NULL,
  `bailleur_accept` tinyint(1) DEFAULT NULL,
  `bailleur` date DEFAULT NULL,
  `bailleur_refus` tinyint(1) DEFAULT NULL,
  `voyageur` date DEFAULT NULL,
  `prestataire_accept` tinyint(1) DEFAULT NULL,
  `prestataire` date DEFAULT NULL,
  `prestataire_refus` tinyint(1) DEFAULT NULL,
  `raison_refus` text,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
