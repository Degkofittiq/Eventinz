-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 01:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `rights_types`
--
DROP TABLE IF EXISTS `rights_types`;

CREATE TABLE `rights_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rights_types`
--

INSERT INTO `rights_types` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Users Management', 'Magement of users functionalities', NULL, NULL),
(2, 'Staff Management', 'Management of Staff member', NULL, NULL),
(3, 'Events Management', 'Magement of events', NULL, NULL),
(4, 'Vendors Categories Management', 'Magement of Vendors Categories', NULL, NULL),
(5, 'Companies Management', 'Management of Companies', NULL, NULL),
(6, 'Taxe Management', 'Management of taxes', NULL, NULL),
(7, 'Vendors Classes Management', 'Management of vendors Classes', NULL, NULL),
(8, 'Payments Management', 'Management of payments', NULL, NULL),
(9, 'Subrcriptions plan Management', 'Magement of subscriptions', NULL, NULL),
(10, 'Site Content Text Management', 'Right for content Text Management', NULL, NULL),
(11, 'Site Content Images Management', 'Right for content Images Management', NULL, NULL),
(12, 'Data limits', 'Data limits', NULL, NULL),
(13, 'Support and Help', 'Support and Help', NULL, NULL),
(14, 'View service list', 'View service list', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rights_types`
--
ALTER TABLE `rights_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rights_types`
--
ALTER TABLE `rights_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
