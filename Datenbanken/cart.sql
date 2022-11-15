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
-- Tabellenstruktur für Tabelle `cart`
--

CREATE TABLE `cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created`) VALUES
(119, 10, 6, 1, '2022-02-22 15:21:26');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id_user_id` (`product_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
