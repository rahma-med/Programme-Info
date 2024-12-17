-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 17, 2024 at 09:12 PM
-- Server version: 11.2.2-MariaDB
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `programme_informatique`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_creation` timestamp NULL DEFAULT current_timestamp(),
  `statut` enum('actif','inactif') DEFAULT 'actif',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `administrateur`
--

INSERT INTO `administrateur` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `date_creation`, `statut`) VALUES
(3, 'Abdi', 'Nasteho', 'nastehoabdi@gmail.com', '$2y$10$n6uwqMAWbGpxoIjhKHpxuedE6G0S3cBBa8AWD9pNimZ5npDDMyy/y', '2024-12-15 11:52:07', 'actif');

-- --------------------------------------------------------

--
-- Table structure for table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE IF NOT EXISTS `etudiants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_inscription` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `etudiants`
--

INSERT INTO `etudiants` (`id`, `nom`, `prenom`, `email`, `password`, `date_inscription`) VALUES
(1, 'Abdi', 'nasteho', 'nasra@gmail.com', '123', '2024-12-12 15:46:46'),
(2, 'Ali', 'Hassan', 'naziyxaabdi@gmail.com', '1234', '2024-12-12 15:50:28'),
(4, 'hamda', 'farah', 'hamd@gmail.com', 'hamda', '2024-12-13 12:00:40'),
(5, 'Asad', 'Saad', 'saad@gmail.com', 'loved', '2024-12-13 12:07:37'),
(6, 'Salah', 'Noura', 'nour@gmail.com', '1234', '2024-12-13 12:34:54'),
(7, 'Osman', 'Hawa', 'Haw@gmail.com', '$2y$10$syzMCd.V1FqlmTRbvolICOrCslH5Qno5a.xW6rV7YBdqcleApKDwi', '2024-12-13 12:42:48'),
(8, 'Rachid', 'Nasra', 'nasrachid@gmail.com', '$2y$10$/U3HA4COP0kksHbnuHTzauGEacdQ.ZjgvgCjIpat8lBu5p3rU6Y6O', '2024-12-17 02:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `programme`
--

DROP TABLE IF EXISTS `programme`;
CREATE TABLE IF NOT EXISTS `programme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `niveau` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  `matiere` varchar(255) NOT NULL,
  `cours_pdf` varchar(255) NOT NULL,
  `td_pdf` varchar(255) DEFAULT NULL,
  `tp_pdf` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `programme`
--

INSERT INTO `programme` (`id`, `niveau`, `semestre`, `matiere`, `cours_pdf`, `td_pdf`, `tp_pdf`) VALUES
(83, 1, 2, 'Introduction aux reseaux informatique', 'uploads/RÃ©seauxInformatiqueCOURS.pdf', 'uploads/tpreseau.pdf', 'uploads/tpreseau.pdf'),
(94, 2, 1, 'Reseaux et protocoles', 'uploads/CMs-Reseaux.pdf', 'uploads/tpRP.pdf', 'uploads/tpRP.pdf'),
(89, 2, 2, 'Systeme d exploitation II', 'uploads/COURSE1.pdf', 'uploads/tdSE.pdf', 'uploads/tpSE2.pdf'),
(41, 2, 1, 'Structure des donnees lineaires', 'uploads/coursSDL.pdf', 'uploads/tpSDL.pdf', 'uploads/tpSDL.pdf'),
(36, 1, 2, 'programmation procedural', 'uploads/cours_programmation_procedurale.pdf', 'uploads/tdprogrammation.pdf', 'uploads/tpprogrammation.pdf'),
(75, 1, 1, 'Logique&Arithmetique', 'uploads/cours de Logiques Arithmetique.pdf', 'uploads/tdlogique&arithmetique.pdf', 'uploads/tp logique arith.pdf'),
(31, 1, 1, 'Introduction Algorithme', 'uploads/cours algorithme 2022-2023.pdf', 'uploads/Algorithmique.pdf', 'uploads/Tpalgo.pdf'),
(79, 1, 2, 'Analyse II', 'uploads/cour_analyse2.pdf', 'uploads/tdanalyse2.pdf', 'uploads/tdanalyse2.pdf'),
(78, 1, 2, 'Algebre lineaire', 'uploads/cours_algebre.pdf', 'uploads/tdalgebre.pdf', 'uploads/TP algebre lineaire.pdf'),
(71, 1, 1, 'analyse I', 'uploads/Cours_analyse.pdf', 'uploads/tdanalyse.pdf', 'uploads/Analyse tp.pdf'),
(42, 2, 1, 'Introduction de base des donnees', 'uploads/coursbd.pdf', 'uploads/tpbd.pdf', 'uploads/tpbd.pdf'),
(44, 2, 2, 'Introduction de programmation orientee objet', 'uploads/coursPOO.pdf', 'uploads/tdPOO.pdf', 'uploads/tpPOO.pdf'),
(88, 2, 2, 'Structure des donnees Arborescence', 'uploads/coursSDA.pdf', 'uploads/tdSDA.pdf', 'uploads/tdSDA.pdf'),
(47, 3, 1, 'Architectures des ordinateurs II', 'uploads/coursAO.pdf', 'uploads/tdAO.pdf', 'uploads/tdAO.pdf'),
(95, 3, 1, 'Programmation et conception orient objet', 'uploads/coursCPOO.PDF', 'uploads/tdCPOO.pdf', 'uploads/tpPOO.pdf'),
(97, 3, 1, 'Gestion dU projet', 'uploads/Chap 1-PrÃ©sentation generale de Gestion des projets.ppt', 'uploads/tdGP.pdf', 'uploads/Plan Cahier des charges.pdf'),
(50, 3, 1, 'Base de donnees avancee', 'uploads/coursABD.pdf', 'uploads/tdABD.pdf', 'uploads/tpbda.pdf'),
(91, 3, 2, 'Intelligence Artificielle', 'uploads/coursIA.pdf', 'uploads/tdIA.pdf', 'uploads/tpIA.pdf'),
(60, 2, 1, 'Probabilite & Statistique', 'uploads/courspro&stat.pdf', 'uploads/tdpro&stat.pdf', 'uploads/tpPS.pdf'),
(53, 3, 2, 'Fondements Theorique', 'uploads/coursFT.pdf', 'uploads/tdFT.pdf', 'uploads/tpFT.pdf'),
(90, 3, 2, 'Langages et Compilation', 'uploads/coursLC.pdf', 'uploads/tdLC.pdf', 'uploads/tdLC.pdf'),
(77, 1, 1, 'Representation des Donnees', 'uploads/coursrepresentation.pdf', 'uploads/tdrepresentation.pdf', 'uploads/tprepresentation.pdf'),
(64, 2, 2, 'Administration de base donnees', 'uploads/coursABD.pdf', 'uploads/tdABD.pdf', 'uploads/tdABD.pdf'),
(68, 3, 2, 'Genie Logiciel', 'uploads/coursGL.pdf', 'uploads/tdGL.pdf', 'uploads/tdGL.pdf'),
(96, 3, 2, 'Administration des Systeme', 'uploads/Cours S0 Virtualisation L3 informatique.pdf', 'uploads/tdAS.pdf', 'uploads/tdAS.pdf'),
(76, 1, 1, 'outils informatique', 'uploads/cour outil informatique.pdf', 'uploads/td outills informatique.pdf', 'uploads/TP_outils_informatique.pdf'),
(87, 2, 2, 'Programmation web', 'uploads/courshtml.pdf', 'uploads/td1PROGWEB.pdf', 'uploads/PWtp1.pdf');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
