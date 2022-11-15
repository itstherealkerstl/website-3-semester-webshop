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
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `titel` varchar(191) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `titel`, `description`, `price`, `slug`) VALUES
(1, 'Erdbeeren', 'Illustration die in Photoshop bearbeitet wurde.', 1000, 'erdbeeren'),
(6, 'Portrait', 'Illustration die in Photoshop bearbeitet wurde.', 1000, 'portrait'),
(7, 'Karpfen', 'Illustration mit Photoshop bearbeitet.', 1000, 'karpfengrafik'),
(8, 'TIGER', 'Illustration die in Photoshop bearbeitet wurde. ', 2300, 'tiger');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
