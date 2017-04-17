-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 12 apr 2017 om 19:18
-- Serverversie: 5.5.41-MariaDB
-- PHP-versie: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Tablestructure for table `personal_data`
--

CREATE TABLE `personal_data` (
  `personal_id` int(10) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `BSN` int(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `wage` int(10) NOT NULL,
  `phonenumber` int(10) NOT NULL,
  `zipcode` varchar(6) NOT NULL,
  `housenumber` varchar(5) NOT NULL,
  `street` text NOT NULL,
  `placeofresidence` text NOT NULL,
  `car` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablestructure for table `employees`
--

CREATE TABLE `employees` (
  `personal_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablestructure for table `workingtimes`
--

CREATE TABLE `workingtimes` (
  `time_id` int(10) NOT NULL,
  `personal_id` int(20) NOT NULL,
  `start_time` datetime NOT NULL,
  `stop_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `personal_data`
  ADD PRIMARY KEY (`personal_id`);

ALTER TABLE `employees`
  ADD PRIMARY KEY (`personal_id`);

ALTER TABLE `workingtimes`
  ADD PRIMARY KEY (`time_id`);

ALTER TABLE `personal_data`
  MODIFY `personal_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT voor een tabel `werknemers`
--
ALTER TABLE `employees`
  MODIFY `personal_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `workingtimes`
  MODIFY `time_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
