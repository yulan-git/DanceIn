-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 25, 2020 at 12:35 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `projetnfa021`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `get_distance_metres` (`lat1` DOUBLE, `lng1` DOUBLE, `lat2` DOUBLE, `lng2` DOUBLE) RETURNS DOUBLE BEGIN
    DECLARE rlo1 DOUBLE;
    DECLARE rla1 DOUBLE;
    DECLARE rlo2 DOUBLE;
    DECLARE rla2 DOUBLE;
    DECLARE dlo DOUBLE;
    DECLARE dla DOUBLE;
    DECLARE a DOUBLE;
    
    SET rlo1 = RADIANS(lng1);
    SET rla1 = RADIANS(lat1);
    SET rlo2 = RADIANS(lng2);
    SET rla2 = RADIANS(lat2);
    SET dlo = (rlo2 - rlo1) / 2;
    SET dla = (rla2 - rla1) / 2;
    SET a = SIN(dla) * SIN(dla) + COS(rla1) * COS(rla2) * SIN(dlo) * SIN(dlo);
    RETURN ROUND(((6378137 * 2 * ATAN2(SQRT(a), SQRT(1 - a)))/1000),2);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL,
  `nom_categorie` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom_categorie`) VALUES
(1, 'Soirées'),
(2, 'Soirées & Cours'),
(3, 'Cours école/association');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id_event` int(11) NOT NULL,
  `Nom_event` varchar(100) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `latGPS` float NOT NULL,
  `lonGPS` float NOT NULL,
  `description` text,
  `tarif` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id_event`, `Nom_event`, `adresse`, `latGPS`, `lonGPS`, `description`, `tarif`) VALUES
(1, 'Bachamia', '13, Rue de Tolbiac, Paris, Île-de-France, 75013, France', 48.8295, 2.37503, NULL, '10.00'),
(2, 'La Locura', '46, Rue des Rigoles, Quartier de Belleville, Paris, Île-de-France, France métropolitaine, 75020, France', 48.873, 2.39198, NULL, '11.00'),
(3, 'Soirée Bachata à l\'Agua', '23, Quai Anatole France, Quartier des Invalides, Paris, Île-de-France, France métropolitaine, 75007, France', 48.8617, 2.32184, NULL, '10.00'),
(4, 'Afterwork Kizomba Backstage : Kizomba Backstage', '92, Boulevard de Clichy, 75018 Paris', 48.8842, 2.33199, 'La soirée du O\'Sullivans, c\'est LA soirée où vous pouvez venir apprendre, danser, écouter du bon son, mais aussi vous reposer, discuter, rigoler, et juste passer un bon moment détente avec des gens sympa et l\'équipe de Dance Lab aux petits soins pour vous!!\r\n\r\nAu programme du bon son, de la rigolade et de la danse OF COURSE!! ', '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `event_categorie`
--

CREATE TABLE `event_categorie` (
  `id_categorie` int(11) NOT NULL,
  `id_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event_categorie`
--

INSERT INTO `event_categorie` (`id_categorie`, `id_event`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 3),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `event_niveau`
--

CREATE TABLE `event_niveau` (
  `id_niveau` int(11) NOT NULL,
  `id_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event_niveau`
--

INSERT INTO `event_niveau` (`id_niveau`, `id_event`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 3),
(4, 1),
(4, 2),
(4, 3),
(4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `event_style`
--

CREATE TABLE `event_style` (
  `id_style` int(11) NOT NULL,
  `id_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event_style`
--

INSERT INTO `event_style` (`id_style`, `id_event`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(5, 1),
(5, 2),
(5, 3),
(7, 4),
(8, 4),
(10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `niveau`
--

CREATE TABLE `niveau` (
  `id_niveau` int(11) NOT NULL,
  `nom_niveau` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `niveau`
--

INSERT INTO `niveau` (`id_niveau`, `nom_niveau`) VALUES
(1, 'Débutant'),
(2, 'Intermédiaire'),
(3, 'Avancé'),
(4, 'Tous niveaux');

-- --------------------------------------------------------

--
-- Table structure for table `organisateur`
--

CREATE TABLE `organisateur` (
  `id_organisateur` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `organisateur`
--

INSERT INTO `organisateur` (`id_organisateur`, `username`, `password`, `email`) VALUES
(1, 'floflo', '$2y$10$zp1VqmLIGc4xUTrCGGog1u9e6Bvx1RkRSTITE6CK8ODQQQc5Iw/A2', 'flora.lafferriere@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `periode`
--

CREATE TABLE `periode` (
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `id_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `periode`
--

INSERT INTO `periode` (`date_debut`, `date_fin`, `id_event`) VALUES
('2020-07-04 20:00:00', '2020-07-05 05:00:00', 1),
('2020-07-11 20:00:00', '2020-07-12 05:00:00', 1),
('2020-07-18 20:00:00', '2020-07-19 05:00:00', 1),
('2020-07-25 20:00:00', '2020-07-26 05:00:00', 1),
('2020-07-03 20:00:00', '2020-07-04 05:00:00', 2),
('2020-07-10 20:00:00', '2020-07-11 05:00:00', 2),
('2020-07-17 20:00:00', '2020-07-18 05:00:00', 2),
('2020-07-24 20:00:00', '2020-07-25 05:00:00', 2),
('2020-07-07 20:00:00', '2020-07-08 02:00:00', 3),
('2020-07-14 20:00:00', '2020-07-15 02:00:00', 3),
('2020-07-21 20:00:00', '2020-07-22 02:00:00', 3),
('2020-07-28 20:00:00', '2020-07-29 02:00:00', 3),
('2020-07-06 19:30:00', '2020-07-07 01:00:00', 4),
('2020-07-13 19:30:00', '2020-07-14 01:00:00', 4),
('2020-07-20 19:30:00', '2020-07-21 01:00:00', 4),
('2020-07-27 19:30:00', '2020-07-28 01:00:00', 4);

-- --------------------------------------------------------

--
-- Table structure for table `style`
--

CREATE TABLE `style` (
  `id_style` int(11) NOT NULL,
  `nom_style` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `style`
--

INSERT INTO `style` (`id_style`, `nom_style`) VALUES
(1, 'Bachata'),
(2, 'Bachata fusion'),
(3, 'Bachata dominicaine'),
(4, 'Bachata moderne'),
(5, 'Bachata sensuelle'),
(6, 'bachata urban'),
(7, 'Kizomba'),
(8, 'Urban Kiz'),
(9, 'Tango Kiz'),
(10, 'Taraxa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`);

--
-- Indexes for table `event_categorie`
--
ALTER TABLE `event_categorie`
  ADD PRIMARY KEY (`id_event`,`id_categorie`),
  ADD KEY `fk_CategorieEvent` (`id_categorie`);

--
-- Indexes for table `event_niveau`
--
ALTER TABLE `event_niveau`
  ADD PRIMARY KEY (`id_event`,`id_niveau`),
  ADD KEY `fk_NiveauEvent` (`id_niveau`);

--
-- Indexes for table `event_style`
--
ALTER TABLE `event_style`
  ADD PRIMARY KEY (`id_event`,`id_style`),
  ADD KEY `fk_StyleEvent` (`id_style`);

--
-- Indexes for table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`id_niveau`);

--
-- Indexes for table `organisateur`
--
ALTER TABLE `organisateur`
  ADD PRIMARY KEY (`id_organisateur`);

--
-- Indexes for table `periode`
--
ALTER TABLE `periode`
  ADD KEY `fk_EventPeriode` (`id_event`);

--
-- Indexes for table `style`
--
ALTER TABLE `style`
  ADD PRIMARY KEY (`id_style`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `niveau`
--
ALTER TABLE `niveau`
  MODIFY `id_niveau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `organisateur`
--
ALTER TABLE `organisateur`
  MODIFY `id_organisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `style`
--
ALTER TABLE `style`
  MODIFY `id_style` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_categorie`
--
ALTER TABLE `event_categorie`
  ADD CONSTRAINT `fk_CategorieEvent` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`),
  ADD CONSTRAINT `fk_EventCategorie` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`);

--
-- Constraints for table `event_niveau`
--
ALTER TABLE `event_niveau`
  ADD CONSTRAINT `fk_EventNiveau` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`),
  ADD CONSTRAINT `fk_NiveauEvent` FOREIGN KEY (`id_niveau`) REFERENCES `niveau` (`id_niveau`);

--
-- Constraints for table `event_style`
--
ALTER TABLE `event_style`
  ADD CONSTRAINT `fk_EventStyle` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`),
  ADD CONSTRAINT `fk_StyleEvent` FOREIGN KEY (`id_style`) REFERENCES `style` (`id_style`);

--
-- Constraints for table `periode`
--
ALTER TABLE `periode`
  ADD CONSTRAINT `fk_EventPeriode` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`);
