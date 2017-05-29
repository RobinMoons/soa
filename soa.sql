-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 29 mei 2017 om 19:20
-- Serverversie: 10.1.21-MariaDB
-- PHP-versie: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soa`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klantenbestand`
--

CREATE TABLE `klantenbestand` (
  `id` int(11) NOT NULL,
  `gebruikersnaam` varchar(255) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `voornaam` varchar(255) NOT NULL,
  `achternaam` varchar(255) NOT NULL,
  `licentie` varchar(255) NOT NULL,
  `locatie` varchar(255) NOT NULL,
  `owid` varchar(255) NOT NULL,
  `energieleverancier` varchar(255) NOT NULL,
  `enid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `klantenbestand`
--

INSERT INTO `klantenbestand` (`id`, `gebruikersnaam`, `wachtwoord`, `voornaam`, `achternaam`, `licentie`, `locatie`, `owid`, `energieleverancier`, `enid`) VALUES
(1, 'bampsk', '1234', 'Kobe', 'Bamps', '1', 'Hoeselt', '2795648', 'Engie', '5717271485874176'),
(3, 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', ''),
(4, 'moonsr', '1234', 'Robin', 'Moons', '1', 'Houthalen-Helchteren', '2795262', 'Lampiris', '5657382461898752');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `klantenbestand`
--
ALTER TABLE `klantenbestand`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gb` (`gebruikersnaam`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `klantenbestand`
--
ALTER TABLE `klantenbestand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
