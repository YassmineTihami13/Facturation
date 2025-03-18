-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 18 mars 2025 à 14:54
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionfacture`
--

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

CREATE TABLE `agent` (
  `ID_Agent` int(11) NOT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Mot_de_passe` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `ID_Client` int(11) NOT NULL,
  `Nom` varchar(50) DEFAULT NULL,
  `Prenom` varchar(50) DEFAULT NULL,
  `Adresse` text DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Mot_de_passe` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `consommation_annuelle`
--

CREATE TABLE `consommation_annuelle` (
  `ID_Consommation_Annuelle` int(11) NOT NULL,
  `ID_Client` int(11) DEFAULT NULL,
  `ID_Agent` int(11) DEFAULT NULL,
  `Année` int(11) DEFAULT NULL,
  `Consommation` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `consommation_mensuelle`
--

CREATE TABLE `consommation_mensuelle` (
  `ID_Consommation` int(11) NOT NULL,
  `ID_Client` int(11) DEFAULT NULL,
  `Mois` int(11) DEFAULT NULL CHECK (`Mois` between 1 and 12),
  `Année` int(11) DEFAULT NULL,
  `Valeur_Compteur` decimal(10,2) DEFAULT NULL,
  `Photo_Compteur` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `ID_Facture` int(11) NOT NULL,
  `ID_Client` int(11) DEFAULT NULL,
  `Date_Facture` date DEFAULT NULL,
  `Consommation` decimal(10,2) DEFAULT NULL,
  `Montant_HT` decimal(10,2) DEFAULT NULL,
  `Montant_TTC` decimal(10,2) DEFAULT NULL,
  `Photo_Compteur` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `ID_Reclamation` int(11) NOT NULL,
  `ID_Client` int(11) DEFAULT NULL,
  `Type` enum('Fuite externe','Fuite interne','Facture','Autre') DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Statut` enum('En attente','Traitée','Rejetée') DEFAULT 'En attente',
  `Date_Reclamation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tarification`
--

CREATE TABLE `tarification` (
  `ID_Tarif` int(11) NOT NULL,
  `Seuil_Min` decimal(10,2) DEFAULT NULL,
  `Seuil_Max` decimal(10,2) DEFAULT NULL,
  `Prix_KWH` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tarification`
--

INSERT INTO `tarification` (`ID_Tarif`, `Seuil_Min`, `Seuil_Max`, `Prix_KWH`) VALUES
(1, 0.00, 100.00, 0.82),
(2, 101.00, 150.00, 0.92),
(3, 151.00, 999999.00, 1.10);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`ID_Agent`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ID_Client`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Index pour la table `consommation_annuelle`
--
ALTER TABLE `consommation_annuelle`
  ADD PRIMARY KEY (`ID_Consommation_Annuelle`),
  ADD KEY `ID_Client` (`ID_Client`),
  ADD KEY `ID_Agent` (`ID_Agent`);

--
-- Index pour la table `consommation_mensuelle`
--
ALTER TABLE `consommation_mensuelle`
  ADD PRIMARY KEY (`ID_Consommation`),
  ADD KEY `ID_Client` (`ID_Client`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`ID_Facture`),
  ADD KEY `ID_Client` (`ID_Client`);

--
-- Index pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`ID_Reclamation`),
  ADD KEY `ID_Client` (`ID_Client`);

--
-- Index pour la table `tarification`
--
ALTER TABLE `tarification`
  ADD PRIMARY KEY (`ID_Tarif`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agent`
--
ALTER TABLE `agent`
  MODIFY `ID_Agent` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `ID_Client` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `consommation_annuelle`
--
ALTER TABLE `consommation_annuelle`
  MODIFY `ID_Consommation_Annuelle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `consommation_mensuelle`
--
ALTER TABLE `consommation_mensuelle`
  MODIFY `ID_Consommation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `ID_Facture` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `ID_Reclamation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tarification`
--
ALTER TABLE `tarification`
  MODIFY `ID_Tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `consommation_annuelle`
--
ALTER TABLE `consommation_annuelle`
  ADD CONSTRAINT `consommation_annuelle_ibfk_1` FOREIGN KEY (`ID_Client`) REFERENCES `client` (`ID_Client`) ON DELETE CASCADE,
  ADD CONSTRAINT `consommation_annuelle_ibfk_2` FOREIGN KEY (`ID_Agent`) REFERENCES `agent` (`ID_Agent`) ON DELETE SET NULL;

--
-- Contraintes pour la table `consommation_mensuelle`
--
ALTER TABLE `consommation_mensuelle`
  ADD CONSTRAINT `consommation_mensuelle_ibfk_1` FOREIGN KEY (`ID_Client`) REFERENCES `client` (`ID_Client`) ON DELETE CASCADE;

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`ID_Client`) REFERENCES `client` (`ID_Client`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `reclamation_ibfk_1` FOREIGN KEY (`ID_Client`) REFERENCES `client` (`ID_Client`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
