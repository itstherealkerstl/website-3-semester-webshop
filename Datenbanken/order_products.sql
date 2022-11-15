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
-- Tabellenstruktur für Tabelle `order_products`
--

CREATE TABLE `order_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT '',
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `price` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `orderId` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `order_products`
--

INSERT INTO `order_products` (`id`, `title`, `quantity`, `price`, `orderId`) VALUES
(70, 'Karpfen', 1, 1000, 93),
(71, 'TIGER', 1, 2300, 94),
(72, 'Erdbeeren', 1, 1000, 94);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ODERS_TO_ORDER_PRODUCTS` (`orderId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `FK_Bestellungen_TO_ORDER_PRODUCTS` FOREIGN KEY (`orderId`) REFERENCES `bestellungen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
