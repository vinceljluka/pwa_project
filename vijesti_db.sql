-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 21, 2025 at 12:41 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vijesti_db`
--
CREATE DATABASE IF NOT EXISTS `vijesti_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `vijesti_db`;

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

DROP TABLE IF EXISTS `korisnici`;
CREATE TABLE `korisnici` (
  `id` int NOT NULL,
  `ime` varchar(100) NOT NULL,
  `prezime` varchar(100) NOT NULL,
  `korisnicko_ime` varchar(100) NOT NULL,
  `lozinka` varchar(255) NOT NULL,
  `razina` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `korisnicko_ime`, `lozinka`, `razina`) VALUES
(1, 'Luka', 'VIncelj', 'lvincelj', '$2y$10$hhYoNpYtufsVEmYdISw.CedtiRW1LQLLEznn9IWyUhAN/b106oWbu', 1),
(2, 'Admin', 'User', 'admin', '$2y$10$vC4wFmhkN7J8hWr3H17yhe5BIdC3Z0d4kYgVxixxxAgW9rc17rHuS', 1),
(3, 'Leon', 'Vincelj', 'asd', '$2y$10$AQl2.sUGTGcywPw82GkQ9Ob7jnn5eAGLLNFNebXl/PDDTdJHBCd16', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

DROP TABLE IF EXISTS `vijesti`;
CREATE TABLE `vijesti` (
  `id` int NOT NULL,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `naslov` varchar(255) NOT NULL,
  `sazetak` text NOT NULL,
  `tekst` text NOT NULL,
  `slika` varchar(255) NOT NULL,
  `kategorija` varchar(50) NOT NULL,
  `arhiva` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `datum`, `naslov`, `sazetak`, `tekst`, `slika`, `kategorija`, `arhiva`) VALUES
(7, '2025-06-21 14:23:55', 'asd', 'asdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdas', 'asdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdasasdasdasdas', 'WhatsApp Image 2025-05-06 at 18.19.15.jpeg', 'Politics', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `korisnicko_ime` (`korisnicko_ime`);

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
