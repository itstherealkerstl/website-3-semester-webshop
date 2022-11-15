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
-- Tabellenstruktur für Tabelle `lieferadressen`
--

CREATE TABLE `lieferadressen` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `adresse` text NOT NULL,
  `stadt` text NOT NULL,
  `strasse` text NOT NULL,
  `nummer` varchar(50) NOT NULL,
  `plz` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `lieferadressen`
--

INSERT INTO `lieferadressen` (`id`, `user_id`, `adresse`, `stadt`, `strasse`, `nummer`, `plz`) VALUES
(3, 4, 'Kerstin', 'St. Poelten', 'Campus', '1', '3100'),
(7, 22, 'Kerstin Hobart', 'Sankt Poelten', 'Campusplatz', '1', '3100'),
(8, 22, 'Hobart Kerstin', 'Gmuend', 'Schremser StraÃŸe', '4', '3950'),
(9, 4, 'Kerstin Hoebart', 'Gross Gerungs', 'Oberrosenauerwald', '29', '3920');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `lieferadressen`
--
ALTER TABLE `lieferadressen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_lieferadressen` (`user_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `lieferadressen`
--
ALTER TABLE `lieferadressen`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `lieferadressen`
--
ALTER TABLE `lieferadressen`
  ADD CONSTRAINT `FK_user_lieferadressen` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
