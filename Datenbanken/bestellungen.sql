-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: mysql5
-- Erstellungszeit: 24. Feb 2022 um 20:56
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
-- Tabellenstruktur für Tabelle `bestellungen`
--

CREATE TABLE `bestellungen` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` enum('neu','gesendet') NOT NULL DEFAULT 'neu',
  `userId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `bestellungen`
--

INSERT INTO `bestellungen` (`id`, `status`, `userId`) VALUES
(93, 'neu', 4),
(94, 'neu', 22);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `userId` (`userId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `bestellungen`
--
ALTER TABLE `bestellungen`
  ADD CONSTRAINT `FK_ORDER_TO_USER` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
