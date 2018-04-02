-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 02, 2018 at 08:09 PM
-- Server version: 10.0.32-MariaDB-0+deb8u1
-- PHP Version: 5.6.33-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `infohits`
--

-- --------------------------------------------------------

--
-- Table structure for table `web_counter`
--

CREATE TABLE IF NOT EXISTS `web_counter` (
  `id` bigint(21) unsigned NOT NULL,
  `views_count` bigint(21) unsigned NOT NULL,
  `ip_address` char(39) DEFAULT NULL,
  `user_agent` varchar(128) DEFAULT NULL,
  `view_date` datetime NOT NULL,
  `page_url` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `web_counter`
--
ALTER TABLE `web_counter`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `web_counter`
--
ALTER TABLE `web_counter`
  MODIFY `id` bigint(21) unsigned NOT NULL AUTO_INCREMENT;
  
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
