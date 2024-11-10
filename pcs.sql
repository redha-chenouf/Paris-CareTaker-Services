-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 21 juin 2024 à 13:24
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
-- Base de données : `pcs`
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
  `refus_bot` tinyint(1) NOT NULL,
  `raison_refus` text,
  `id_bailleur` int NOT NULL,
  `id_administrateur` int NOT NULL,
  PRIMARY KEY (`id_bien`),
  KEY `id_bailleur` (`id_bailleur`),
  KEY `id_administrateur` (`id_administrateur`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bien`
--

INSERT INTO `bien` (`id_bien`, `title`, `description`, `address`, `city`, `code_postal`, `pays`, `prix`, `salon`, `cuisine`, `salle_de_bain`, `toilette`, `chambre`, `superficie`, `creation`, `maj`, `refus_bot`, `raison_refus`, `id_bailleur`, `id_administrateur`) VALUES
(1, 'Appartement 9 pièces', 'Appartement 9 pièce avec une vue sur la Tour Eiffel.', '22 avec jean', 'Paris', '75001', 'France', 3000.00, 2, 2, 3, 3, 3, NULL, NULL, NULL, 0, NULL, 1, 1),
(2, 'Villa 7eme arrondissement', 'Villa avec plusieurs chambres et 2 homeciné', 'test', 'test', '77500', 'France', 5000.00, 3, 4, 6, 6, 8, NULL, '2024-06-18 19:42:30', '2024-06-18 19:42:30', 0, NULL, 1, 1),
(3, 'Appartement 3 pièce', 'Appartement 3 pièce avec vu sur la montagne, à 100 mètre de tout les transports en commun de la ville. Centre commercial à 1km.', '14 av jean jores', 'Chelles', '77500', 'FRANCE', 200.00, 1, 1, 1, 1, 2, 70.00, '2024-06-18 21:52:50', '2024-06-18 21:52:50', 0, NULL, 2, 1),
(4, 'Studio moderne', 'Studio moderne en centre-ville, idéal pour une personne seule ou un couple. Proche de toutes commodités.', '5 rue de la Paix', 'Paris', '75001', 'FRANCE', 800.00, 1, 1, 1, 1, 0, 30.00, '2024-06-18 21:52:50', '2024-06-18 21:52:50', 0, NULL, 3, 2),
(5, 'Duplex avec terrasse', 'Duplex spacieux avec terrasse privée, parfait pour les familles. Vue imprenable sur la ville.', '12 rue Victor Hugo', 'Lyon', '69002', 'FRANCE', 1500.00, 1, 1, 2, 2, 3, 120.00, '2024-06-18 21:52:50', '2024-06-18 21:52:50', 0, NULL, 4, 1),
(6, 'Appartement lumineux', 'Appartement lumineux avec grande baie vitrée, situé dans un quartier calme et résidentiel.', '22 av des Champs', 'Nice', '06000', 'FRANCE', 1000.00, 1, 1, 1, 1, 1, 60.00, '2024-06-18 21:52:50', '2024-06-18 21:52:50', 0, NULL, 5, 3),
(7, 'Loft industriel', 'Loft au style industriel avec mezzanine, idéal pour les amateurs de design contemporain.', '18 rue de la Liberté', 'Marseille', '13001', 'FRANCE', 1200.00, 1, 1, 1, 1, 1, 80.00, '2024-06-18 21:52:50', '2024-06-18 21:52:50', 0, NULL, 6, 2),
(8, 'Appartement en bord de mer', 'Appartement avec vue sur la mer, à quelques pas de la plage. Idéal pour les vacances.', '3 Promenade des Anglais', 'Nice', '06000', 'FRANCE', 1800.00, 1, 1, 1, 1, 2, 90.00, '2024-06-18 21:52:50', '2024-06-18 21:52:50', 0, NULL, 7, 3),
(9, 'Appartement avec jardin', 'Appartement au rez-de-chaussée avec jardin privé, parfait pour les familles avec enfants.', '25 rue de la République', 'Bordeaux', '33000', 'FRANCE', 1100.00, 1, 1, 1, 1, 2, 85.00, '2024-06-18 21:52:50', '2024-06-18 21:52:50', 0, NULL, 8, 1),
(10, 'Penthouse de luxe', 'Penthouse de luxe avec jacuzzi sur le toit, offrant une vue panoramique sur la ville.', '1 Place Bellecour', 'Lyon', '69002', 'FRANCE', 3000.00, 1, 1, 2, 2, 4, 200.00, '2024-06-18 21:52:50', '2024-06-18 21:52:50', 0, NULL, 9, 2),
(11, 'Appartement rénové', 'Appartement récemment rénové avec cuisine équipée et salle de bain moderne.', '10 rue de la Gloire', 'Lille', '59000', 'FRANCE', 900.00, 1, 1, 1, 1, 2, 75.00, '2024-06-18 21:52:50', '2024-06-18 21:52:50', 0, NULL, 10, 1),
(12, 'Appartement proche université', 'Appartement idéalement situé proche de l\'université, parfait pour les étudiants.', '15 rue des Étudiants', 'Grenoble', '38000', 'FRANCE', 600.00, 1, 1, 1, 1, 1, 40.00, '2024-06-18 21:52:50', '2024-06-18 21:52:50', 0, 'Ne respecte pas ses engagement', 11, 3),
(13, 'Appartement familial', 'Appartement spacieux pour famille avec enfants, proche des écoles et parcs.', '30 rue de la Famille', 'Toulouse', '31000', 'FRANCE', 1300.00, 1, 1, 2, 2, 3, 110.00, '2024-06-18 21:52:50', '2024-06-18 21:52:50', 0, NULL, 12, 2);

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
-- Structure de la table `habilitation`
--

DROP TABLE IF EXISTS `habilitation`;
CREATE TABLE IF NOT EXISTS `habilitation` (
  `id_habilitation` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `description` text,
  `url` varchar(255) DEFAULT NULL,
  `id_bailleur` int NOT NULL,
  `id_administrateur` int NOT NULL,
  PRIMARY KEY (`id_habilitation`),
  KEY `id_bailleur` (`id_bailleur`),
  KEY `id_administrateur` (`id_administrateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

DROP TABLE IF EXISTS `intervention`;
CREATE TABLE IF NOT EXISTS `intervention` (
  `id_intervention` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) DEFAULT NULL,
  `description` text,
  `montant` decimal(6,2) DEFAULT NULL,
  `duree_jour` int DEFAULT NULL,
  `id_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_intervention`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `intervenu_pour`
--

DROP TABLE IF EXISTS `intervenu_pour`;
CREATE TABLE IF NOT EXISTS `intervenu_pour` (
  `id_bien` int NOT NULL,
  `id_intervention` int NOT NULL,
  `id_paiement` int NOT NULL,
  `date_debut_intervention` datetime DEFAULT NULL,
  `date_fin_intervention` datetime DEFAULT NULL,
  `description` text,
  `prix` decimal(6,2) DEFAULT NULL,
  `url_fiche_intervention` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_bien`,`id_intervention`,`id_paiement`),
  KEY `id_intervention` (`id_intervention`),
  KEY `id_paiement` (`id_paiement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `message` text,
  `id_bailleur` int NOT NULL,
  `id_voyageur` int NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `id_bailleur` (`id_bailleur`),
  KEY `id_voyageur` (`id_voyageur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nfc_log`
--

DROP TABLE IF EXISTS `nfc_log`;
CREATE TABLE IF NOT EXISTS `nfc_log` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `nfc_id` varchar(100) DEFAULT NULL,
  `log_date_time` datetime DEFAULT NULL,
  `id_bien` int NOT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `nfc_log`
--

INSERT INTO `nfc_log` (`id_log`, `nfc_id`, `log_date_time`, `id_bien`) VALUES
(1, '1368312424186', '2024-06-18 16:02:36', 1),
(2, '1368312424186', '2024-06-18 15:02:36', 1),
(3, '1368312424186', '2024-06-18 14:02:36', 2),
(4, '1368312424186', '2024-06-18 14:02:36', 1),
(5, '1368312424186', '2024-06-18 13:02:36', 1),
(6, '1368312424186', '2024-06-03 16:04:21', 3),
(7, '1368312424186', '2024-06-18 17:04:21', 1);

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
  PRIMARY KEY (`id_paiement`),
  KEY `id_bien` (`id_bien`)
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`id_photo`, `url`, `id_bien`) VALUES
(1, 'photo1111.jpg', 1),
(2, 'photo1222.jpg', 1);

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
  `id_prestataire` int NOT NULL,
  `id_bien` int NOT NULL,
  `id_prestation` int NOT NULL,
  `id_paiement` int NOT NULL,
  `montant` decimal(6,2) DEFAULT NULL,
  `evaluation` int DEFAULT NULL,
  `url_fiche` varchar(255) DEFAULT NULL,
  `debut_prestation` date DEFAULT NULL,
  `duree` smallint DEFAULT NULL,
  `fin_prestation` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `fiche_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`,`id_prestataire`,`id_bien`,`id_prestation`,`id_paiement`),
  KEY `id_prestataire` (`id_prestataire`),
  KEY `id_bien` (`id_bien`),
  KEY `id_prestation` (`id_prestation`),
  KEY `id_paiement` (`id_paiement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `refresh_tokens`
--

DROP TABLE IF EXISTS `refresh_tokens`;
CREATE TABLE IF NOT EXISTS `refresh_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `refresh_token` varchar(512) NOT NULL,
  `expiry_date` datetime NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id_reservation` int NOT NULL AUTO_INCREMENT,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `id_bien` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_reservation`),
  KEY `id_bien` (`id_bien`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `genre` tinyint(1) NOT NULL,
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
  `nfc_id` varchar(100) NOT NULL,
  `token` varchar(512) DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `genre`, `nom`, `prenom`, `email`, `mot_de_passe`, `date_inscription`, `date_naissance`, `numero_telephone`, `pays_telephone`, `bloque`, `supprime`, `accepte`, `code_banque`, `code_guichet`, `numero_de_compte`, `cle_rib`, `iban`, `bic`, `nom_banque`, `url_rib`, `administrateur`, `bailleur_accept`, `bailleur`, `bailleur_refus`, `voyageur`, `prestataire_accept`, `prestataire`, `prestataire_refus`, `raison_refus`, `nfc_id`, `token`, `newsletter`) VALUES
(1, 0, 'Sivathasan', 'Rakulan', 's.rakulan04@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 20:18:07', '2004-06-30', '33', '0766589279', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 1, '2024-06-18', 0, NULL, 1, '2024-06-03', 0, NULL, '1368312424186', NULL, NULL),
(2, 0, 'Toto', 'Toto', 'toto@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 20:26:12', '1995-06-04', '33', '0712345678', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(3, 0, 'Dupont', 'Jean', 'jean.dupont@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 20:26:12', '1990-01-15', '33', '0712345678', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(4, 1, 'Martin', 'Marie', 'marie.martin@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 20:26:12', '1992-05-22', '33', '0612345678', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(5, 0, 'Bernard', 'Paul', 'paul.bernard@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 20:26:12', '1985-03-30', '33', '0623456789', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(6, 1, 'Petit', 'Anne', 'anne.petit@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 20:26:12', '1988-07-14', '33', '0634567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(7, 0, 'Dubois', 'Pierre', 'pierre.dubois@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 20:26:12', '1993-08-19', '33', '0645678901', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(8, 1, 'Durand', 'Lucie', 'lucie.durand@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 20:26:12', '1991-11-02', '33', '0656789012', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(9, 0, 'Toto', 'Bailleur', 'toto.bailleur@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 20:31:50', '1995-06-01', '0712345678', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-15', 0, NULL, NULL, NULL, NULL, 'il est nul', '', NULL, NULL),
(10, 1, 'testBailleur', 'bailleur', 'testbailleur@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 20:48:35', '2000-06-01', '0700000000', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-15', 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(11, 1, 'Alexandrin', 'Pitre', 'AlexandrinPitre@armyspy.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 20:56:18', '2005-06-15', '0856354736', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2024-06-15', 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(12, 1, 'Alexandrin', 'Pitre', 'AlexandrinPitre@armyspy.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 20:56:18', '2005-06-15', '0856354736', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-15', 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL),
(13, 0, 'Russell', 'Parent', 'RussellParent@teleworm.us', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:01:45', '1990-06-03', '0123456789', '33', '2024-06-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-01', NULL, NULL, NULL, 'test', '', NULL, NULL),
(14, 0, 'TestVoyageur', 'Voyageur', 'test.voyageur@teleworm.us', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:01:45', '1990-06-03', '0123456789', '33', '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-01', NULL, NULL, NULL, NULL, '', NULL, NULL),
(15, 0, 'acceptTravler', 'trav', 'trav@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', '2024-06-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', NULL, NULL, NULL, 'test', '', NULL, NULL),
(16, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, '2024-06-15', 1, '2024-06-15', 0, NULL, '', NULL, NULL),
(17, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, '2024-06-15', 0, '2024-06-15', 0, NULL, '', NULL, NULL),
(18, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 0, '2024-06-15', 1, 'je ne l&#039;aime pas', '', NULL, NULL),
(19, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 0, '2024-06-15', 0, NULL, '', NULL, NULL),
(20, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 1, '2024-06-15', 0, NULL, '', NULL, NULL),
(21, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 0, '2024-06-15', 1, 'test', '', NULL, NULL),
(22, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 0, '2024-06-15', 0, NULL, '', NULL, NULL),
(23, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 1, '2024-06-15', 0, NULL, '', NULL, NULL),
(24, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, '2024-06-15', 0, '2024-06-15', 0, NULL, '', NULL, NULL),
(25, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 0, '2024-06-15', 0, NULL, '', NULL, NULL),
(26, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, '2024-06-15', 0, '2024-06-15', 1, 'le profil n&#039;est pas correct', '', NULL, NULL),
(27, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 0, '2024-06-15', 0, NULL, '', NULL, NULL),
(28, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 1, '2024-06-15', 0, NULL, '', NULL, NULL),
(29, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 1, '2024-06-15', 0, NULL, '', NULL, NULL),
(30, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 0, '2024-06-15', 1, 'au téléphone', '', NULL, NULL),
(31, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 0, '2024-06-15', 0, NULL, '', NULL, NULL),
(32, 0, 'presta', 'presta', 'presta@gmail.com', '$2y$10$ogk8uuzkzo9KuW9bgehR6OEW57u/I7Q5xZyevyjHo9/r/0AYIupDy', '2024-06-15 21:05:39', '2016-06-09', '0123456789', '33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-15', 0, '2024-06-15', 0, NULL, '', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
