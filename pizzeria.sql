-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 23 okt 2023 om 11:38
-- Serverversie: 10.4.28-MariaDB
-- PHP-versie: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizzeria`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelling`
--

CREATE TABLE `bestelling` (
  `bestelid` int(11) NOT NULL,
  `klantid` int(11) DEFAULT NULL,
  `datumuur` datetime DEFAULT NULL,
  `opmerking` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelregel`
--

CREATE TABLE `bestelregel` (
  `bestelregid` int(11) NOT NULL,
  `bestelid` int(11) DEFAULT NULL,
  `prodid` int(11) DEFAULT NULL,
  `aantal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
--

CREATE TABLE `klant` (
  `klantid` int(11) NOT NULL,
  `naam` varchar(255) DEFAULT NULL,
  `voornaam` varchar(255) DEFAULT NULL,
  `straat` varchar(255) DEFAULT NULL,
  `nummer` varchar(10) DEFAULT NULL,
  `postid` int(11) DEFAULT NULL,
  `telnr` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `wachtwoord` varchar(255) DEFAULT NULL,
  `bemerkingen` text DEFAULT NULL,
  `promotie` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `plaats`
--

CREATE TABLE `plaats` (
  `postid` int(11) NOT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `woonplaats` varchar(255) DEFAULT NULL,
  `isleverbaar` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `plaats`
--

INSERT INTO `plaats` (`postid`, `postcode`, `woonplaats`, `isleverbaar`) VALUES
(1, '9000', 'Gent', 1),
(2, '9020', 'Destelbergen', 0),
(3, '9025', 'Heusden', 1),
(4, '9030', 'Mariakerke', 1),
(5, '9035', 'Gentbrugge', 1),
(6, '9040', 'Sint-Amandsberg', 1),
(7, '9045', 'Oostakker', 0),
(8, '9050', 'Ledeberg', 1),
(9, '9055', 'Wondelgem', 1),
(10, '9060', 'Zelzate', 1),
(11, '9065', 'Ertvelde', 1),
(12, '9070', 'Evergem', 1),
(13, '9075', 'Sleidinge', 0),
(14, '9080', 'Lochristi', 1),
(15, '9085', 'Beervelde', 1),
(16, '9090', 'Melle', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--

CREATE TABLE `product` (
  `prodid` int(11) NOT NULL,
  `naam` varchar(255) DEFAULT NULL,
  `productinformatie` text DEFAULT NULL,
  `prijs` decimal(10,2) DEFAULT NULL,
  `promotieprijs` decimal(10,2) DEFAULT NULL,
  `beschikbaar` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `product`
--

INSERT INTO `product` (`prodid`, `naam`, `productinformatie`, `prijs`, `promotieprijs`, `beschikbaar`) VALUES
(1, 'Margarita', 'Tomatensaus, mozzarella, basilicum', 8.50, NULL, 1),
(2, 'Pepperoni', 'Tomatensaus, mozzarella, pepperoni', 9.00, 8.00, 1),
(3, 'Hawaiian', 'Tomatensaus, mozzarella, ham, ananas', 9.50, NULL, 1),
(4, 'Vegetarisch', 'Tomatensaus, mozzarella, paprika, champignons, ui', 9.00, 8.00, 1),
(5, 'Vier Kazen', 'Tomatensaus, mozzarella, parmezaan, blauwe kaas, geitenkaas', 10.00, NULL, 1),
(6, 'BBQ Kip', 'BBQ-saus, mozzarella, kip, rode ui', 9.50, 8.50, 1),
(7, 'Pittige Worst', 'Tomatensaus, mozzarella, pittige worst, jalapeños', 9.50, NULL, 0),
(8, 'Zeevruchten', 'Tomatensaus, mozzarella, garnalen, mosselen, tonijn', 11.00, 10.00, 1),
(9, 'Calzone', 'Tomatensaus, mozzarella, ham, champignons, gevouwen pizza', 10.50, NULL, 1),
(10, 'Carbonara', 'Roomsaus, mozzarella, pancetta, ei', 10.00, 9.00, 1);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bestelling`
--
ALTER TABLE `bestelling`
  ADD PRIMARY KEY (`bestelid`),
  ADD KEY `klantid` (`klantid`);

--
-- Indexen voor tabel `bestelregel`
--
ALTER TABLE `bestelregel`
  ADD PRIMARY KEY (`bestelregid`),
  ADD KEY `bestelid` (`bestelid`),
  ADD KEY `prodid` (`prodid`);

--
-- Indexen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`klantid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `postid` (`postid`);

--
-- Indexen voor tabel `plaats`
--
ALTER TABLE `plaats`
  ADD PRIMARY KEY (`postid`);

--
-- Indexen voor tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prodid`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bestelling`
--
ALTER TABLE `bestelling`
  MODIFY `bestelid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT voor een tabel `bestelregel`
--
ALTER TABLE `bestelregel`
  MODIFY `bestelregid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

--
-- AUTO_INCREMENT voor een tabel `klant`
--
ALTER TABLE `klant`
  MODIFY `klantid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT voor een tabel `plaats`
--
ALTER TABLE `plaats`
  MODIFY `postid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT voor een tabel `product`
--
ALTER TABLE `product`
  MODIFY `prodid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `bestelling`
--
ALTER TABLE `bestelling`
  ADD CONSTRAINT `bestelling_ibfk_1` FOREIGN KEY (`klantid`) REFERENCES `klant` (`klantid`);

--
-- Beperkingen voor tabel `bestelregel`
--
ALTER TABLE `bestelregel`
  ADD CONSTRAINT `bestelregel_ibfk_1` FOREIGN KEY (`bestelid`) REFERENCES `bestelling` (`bestelid`),
  ADD CONSTRAINT `bestelregel_ibfk_2` FOREIGN KEY (`prodid`) REFERENCES `product` (`prodid`);

--
-- Beperkingen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD CONSTRAINT `klant_ibfk_1` FOREIGN KEY (`postid`) REFERENCES `plaats` (`postid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
