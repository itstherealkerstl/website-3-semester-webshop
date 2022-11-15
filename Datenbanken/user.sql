-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: mysql5
-- Erstellungszeit: 24. Feb 2022 um 20:55
-- Server-Version: 5.7.33-0ubuntu0.16.04.1
-- PHP-Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `db_mt201002_1`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL DEFAULT '0',
  `password` varchar(100) NOT NULL DEFAULT '0',
  `email` varchar(100) NOT NULL DEFAULT '0',
  `activationKey` varchar(8) CHARACTER SET utf8 COLLATE utf8_german2_ci DEFAULT NULL,
  `userRights` enum('USER','ADMIN') DEFAULT 'USER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `activationKey`, `userRights`) VALUES
(4, 'kerstin', '$2y$10$HimHxiDkTiFfsIaawAiYkOFmEKxB8UL4jwowSrklGyR9V6WgAa5xa', 'kerstin.hobart@gmail.com', NULL, 'ADMIN'),
(22, 'eisklat', '$2y$10$E6w.czj0wmCQrsxrMC6tBORBHbn6o0048csblpRCIJroGYstKxrSq', 'eiskalt.agekay@gmail.com', NULL, 'USER');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `activationKey` (`activationKey`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
