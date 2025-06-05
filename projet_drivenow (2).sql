-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 04 juin 2025 à 01:23
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_drivenow`
--

-- --------------------------------------------------------

--
-- Structure de la table `contrat`
--

CREATE TABLE `contrat` (
  `numContrat` int(11) NOT NULL,
  `typeContrat` varchar(50) DEFAULT NULL,
  `dateEtablissement` date DEFAULT NULL,
  `cinetutilisateur` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contrat`
--

INSERT INTO `contrat` (`numContrat`, `typeContrat`, `dateEtablissement`, `cinetutilisateur`) VALUES
(116, 'Standard', '2025-06-02', 'VA159880'),
(117, 'Standard', '2025-06-03', 'VA159880'),
(118, 'Standard', '2025-06-03', 'VA159880'),
(119, 'Standard', '2025-06-03', 'VA159880');

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

CREATE TABLE `location` (
  `id_location` int(11) NOT NULL,
  `montant_total` decimal(10,2) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `numContrat` int(11) DEFAULT NULL,
  `Matricule` varchar(20) DEFAULT NULL,
  `cinutilisateur` varchar(20) DEFAULT NULL,
  `lieu_prise` varchar(50) DEFAULT NULL,
  `lieu_retour` varchar(50) DEFAULT NULL,
  `date_retour_reel` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `location`
--

INSERT INTO `location` (`id_location`, `montant_total`, `date_debut`, `date_fin`, `status`, `numContrat`, `Matricule`, `cinutilisateur`, `lieu_prise`, `lieu_retour`, `date_retour_reel`) VALUES
(45, 495.00, '2025-01-03', '2025-05-08', 'retardé', 116, 'CAR001', 'VA159880', 'Gare', 'errachidia', '2025-06-03 14:26:17'),
(46, 396.00, '2025-06-09', '2025-06-13', 'confirmé', 117, 'CAR001', 'VA159880', 'midelt', 'errachidia', NULL),
(47, 198.00, '2025-06-03', '2025-06-05', 'confirmé', 118, 'CAR005', 'VA159880', 'midelt', 'midelt', NULL),
(48, 99.00, '2025-06-03', '2025-06-04', 'en attente', 119, 'CAR001', 'VA159880', 'errachidia', 'errachidia', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sujet` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date_envoi` date DEFAULT NULL,
  `lu` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id_paiement` int(11) NOT NULL,
  `date_paiement` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `mode_paiement` varchar(30) DEFAULT NULL,
  `id_location` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `cinutilisateur` varchar(20) NOT NULL,
  `nomutilisateur` varchar(50) DEFAULT NULL,
  `prenomutilisateur` varchar(50) DEFAULT NULL,
  `adresseutilisateur` varchar(100) DEFAULT NULL,
  `villeutilisateur` varchar(50) DEFAULT NULL,
  `telutilisateur` varchar(20) DEFAULT NULL,
  `typeutilisateur` varchar(20) DEFAULT NULL,
  `loginutilisateur` varchar(50) DEFAULT NULL,
  `passwordutilisateur` varchar(50) DEFAULT NULL,
  `Roletilutilisateur` tinyint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`cinutilisateur`, `nomutilisateur`, `prenomutilisateur`, `adresseutilisateur`, `villeutilisateur`, `telutilisateur`, `typeutilisateur`, `loginutilisateur`, `passwordutilisateur`, `Roletilutilisateur`) VALUES
('V25524', 'oubour', 'islam', 'midelt tamanochet', 'midelt', '0999988', 'Personal', 'islam@gmail.com', 'islamoubour', 1),
('VA159880', 'oubour', 'islam', 'midelt tamanochet', 'midelt', '0610185455', 'Personal', 'islamoubour@gmail.com', 'islamoubour', 0);

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `Matricule` varchar(20) NOT NULL,
  `couleur` varchar(30) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `modele` varchar(50) DEFAULT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `transmission` varchar(50) DEFAULT NULL,
  `kilometrage` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`Matricule`, `couleur`, `photo`, `prix`, `modele`, `marque`, `disponible`, `annee`, `transmission`, `kilometrage`) VALUES
('CAR001', 'Jaune', 'img/car-rent-1.png', 99.00, 'R3', 'Mercedes Benz', 1, 2015, 'AUTO', '25K'),
('CAR002', 'Gris', 'img/car-rent-2.png', 99.00, 'R3', 'BMW', 1, 2015, 'AUTO', '25K'),
('CAR003', 'Noir', 'img/car-rent-3.png', 99.00, 'R3', 'Audi', 1, 2015, 'AUTO', '25K'),
('CAR004', 'Orange', 'img/car-rent-4.png', 99.00, 'Q3', 'Audi', 1, 2015, 'AUTO', '25K'),
('CAR005', 'Bleu', 'img/car-rent-5.png', 99.00, 'R3', 'Mercedes Benz', 1, 2015, 'AUTO', '25K'),
('CAR006', 'Blanc', 'img/car-rent-6.png', 99.00, 'R8', 'Audi', 1, 2015, 'AUTO', '25K');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `contrat`
--
ALTER TABLE `contrat`
  ADD PRIMARY KEY (`numContrat`),
  ADD KEY `cinetutilisateur` (`cinetutilisateur`);

--
-- Index pour la table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id_location`),
  ADD KEY `numContrat` (`numContrat`),
  ADD KEY `Matricule` (`Matricule`),
  ADD KEY `cinetutilisateur` (`cinutilisateur`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id_paiement`),
  ADD KEY `id_location` (`id_location`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`cinutilisateur`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`Matricule`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `contrat`
--
ALTER TABLE `contrat`
  MODIFY `numContrat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT pour la table `location`
--
ALTER TABLE `location`
  MODIFY `id_location` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contrat`
--
ALTER TABLE `contrat`
  ADD CONSTRAINT `contrat_ibfk_1` FOREIGN KEY (`cinetutilisateur`) REFERENCES `utilisateur` (`cinutilisateur`);

--
-- Contraintes pour la table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`numContrat`) REFERENCES `contrat` (`numContrat`),
  ADD CONSTRAINT `location_ibfk_2` FOREIGN KEY (`Matricule`) REFERENCES `voiture` (`Matricule`),
  ADD CONSTRAINT `location_ibfk_3` FOREIGN KEY (`cinutilisateur`) REFERENCES `utilisateur` (`cinutilisateur`);

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `paiement_ibfk_1` FOREIGN KEY (`id_location`) REFERENCES `location` (`id_location`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
