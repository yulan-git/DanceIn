-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 17, 2020 at 01:46 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `projetnf021`

-- --------------------------------------------------------

--
-- Table structure for table `t_event`
--

CREATE TABLE `event`(
    `id_event` INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
    `Nom_event`varchar(100) NOT NULL,
    `No_street` INT  NOT NULL,
    `adresse` varchar(255) NOT NULL,
    `lat` float NOT NULL,
    `lon`float NOT NULL,
    `description` text,
    `tarif` decimal(6,2) NOT NULL
);

CREATE TABLE `categorie`(
    `id_categorie` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `nom_categorie` varchar(100) NOT NULL
);

CREATE TABLE `niveau`(
    `id_niveau` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `nom_niveau` varchar(100) NOT NULL
);

CREATE TABLE `style`(
    `id_style` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `nom_style` varchar(100) NOT NULL
);

CREATE TABLE `periode`(
    `date_debut` DATETIME NOT NULL,
    `date_fin` DATETIME NOT NULL,
    `id_event` INT NOT NULL,
    CONSTRAINT fk_EventPeriode FOREIGN KEY (id_event) REFERENCES `event`(id_event)
);

CREATE TABLE `event_style`(
    `id_style` INT NOT NULL,
    `id_event` INT NOT NULL,
    CONSTRAINT pk_event_style PRIMARY KEY(`id_event`, `id_style`),
    CONSTRAINT fk_EventStyle FOREIGN KEY (id_event) REFERENCES `event`(id_event),
    CONSTRAINT fk_StyleEvent FOREIGN KEY (id_style) REFERENCES `style`(id_style)
);

CREATE TABLE `event_niveau`(
    `id_niveau` INT NOT NULL,
    `id_event` INT NOT NULL,
    CONSTRAINT pk_event_niveau PRIMARY KEY(`id_event`, `id_niveau`),
    CONSTRAINT fk_EventNiveau FOREIGN KEY (id_event) REFERENCES `event`(id_event),
    CONSTRAINT fk_NiveauEvent FOREIGN KEY (id_niveau) REFERENCES `niveau`(id_niveau)
);

CREATE TABLE `event_categorie`(
    `id_categorie` INT NOT NULL,
    `id_event` INT NOT NULL,
    CONSTRAINT pk_event_categorie PRIMARY KEY(`id_event`, `id_categorie`),
    CONSTRAINT fk_EventCategorie FOREIGN KEY (id_event) REFERENCES `event`(id_event),
    CONSTRAINT fk_CategorieEvent FOREIGN KEY (id_categorie) REFERENCES `categorie`(id_categorie)
);

