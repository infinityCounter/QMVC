-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 14, 2016 at 06:49 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `national_school_registrar`
--
CREATE DATABASE IF NOT EXISTS `national_school_registrar` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `national_school_registrar`;

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `Id` int(11) NOT NULL,
  `Name` varchar(64) DEFAULT NULL,
  `Telephone` varchar(16) DEFAULT NULL,
  `Address` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`Id`, `Name`, `Telephone`, `Address`) VALUES
(1, 'Greshalin High', '615.18', '8124 Grimes Forest'),
(2, 'Monroe County Elementary', '137.02', '986 Easter Cliffs'),
(3, 'Mayln National High School', '744-30', '8654 Nicolas Glen'),
(4, 'Ardenne High School', '093-18', '648 Rahsaan Cliff'),
(5, 'Stella Maris Peparatory', '(829)1', '8228 Willms Brook'),
(6, 'St. Peter and Paul Preparatory', '585.73', '2105 Abdiel Viaduct'),
(7, 'Campion College', '(967)7', '57424 Bogisich Rue'),
(8, 'Immaculate Conception High School', '649-23', '74385 Roosevelt Neck'),
(9, 'Holy Childhood High School', '1-171-', '1181 Etha Square'),
(10, 'Southborough Primary', '866-23', '6246 Leffler Isle'),
(11, 'Mona Preparatory', '(294)1', '38552 Aniyah Ville'),
(12, 'Quest Preparatory', '1-782-', '604 Hayes Ridges'),
(13, 'Mona High School', '(280)8', '8131 Cole Spur'),
(14, 'Camperdown High School', '1-416-', '48209 Bridie Mountains'),
(15, 'Papine Primary School', '1-439-', '74642 Enrico Walks'),
(16, 'Papine High School', '275.00', '72703 King Oval'),
(17, 'St. Catherine High School', '513-87', '9378 Reggie Pine'),
(18, 'St. Jago High School', '632-99', '79630 Schmeler Road'),
(19, 'Portmore Community College', '757-35', '93405 Schmitt Rue'),
(20, 'Excelsior High School', '(430)5', '3174 Neoma Plains'),
(21, 'Excelsior Community College', '1-393-', '5338 Cassandra Ranch'),
(22, 'Cumberland High School', '(238)3', '80367 Herman Lake'),
(23, 'Nago Primary School', '521.68', '31830 Leola Spurs'),
(24, 'Old Harbour High School', '(046)0', '64253 Wintheiser Route'),
(25, 'Yahlas High School', '1-428-', '9240 Harvey Crest'),
(26, 'University of Technology', '976-42', '61610 Santiago Roads'),
(27, 'University of the West Indies', '1-595-', '8071 Gerlach View'),
(28, 'St. Andrews High School', '1-317-', '0956 Rau Viaduct'),
(29, 'Liberty Academy High School', '1-166-', '9625 Jast Wells'),
(30, 'AISK', '693.99', '3466 Dariana Overpass'),
(31, 'Hillel High School', '(207)9', '301 Zakary Vista'),
(32, 'St. Hugh''s High', '599-40', '757 Nader Station'),
(33, 'Nort Caribbean University', '571.77', '445 Dario Ridges'),
(34, 'University College of the Caribbean', '(994)3', '10369 Lang Island'),
(35, 'Wolmer''s Boy''s High School', '1-424-', '042 Trantow Causeway'),
(36, 'Wolmer''s Girl''s High School', '969-0081', '07999 Simonis Creek'),
(37, 'Jamaica College', '394.55', '4282 Mitchell Lights'),
(38, 'Kingston College', '299-85', '40309 Kessler Club'),
(39, 'George''s College', '(190)4', '1077 Schmitt Crest'),
(40, 'Queen''s High School', '016-49', '843 Miller Cove');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
