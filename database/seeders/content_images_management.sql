-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2024 at 06:39 PM
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
-- Table structure for table `content_images_management`
--
DROP TABLE IF EXISTS `content_images_management`;

CREATE TABLE `content_images_management` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `page` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `path` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content_images_management`
--

INSERT INTO `content_images_management` (`id`, `name`, `page`, `type`, `path`, `created_at`, `updated_at`) VALUES
(1, 'arrow_left_icon', 'vendor side', 'svg', 'https://eventinz.s3.amazonaws.com/contentsImages/arrow_left_icon_1726590711_arrow-left_icon.svg', '2024-09-17 15:31:53', '2024-09-17 15:31:53'),
(2, 'store_icon', 'vendor side', 'svg', 'https://eventinz.s3.amazonaws.com/contentsImages/store_icon_1726590758_store_icon.svg', '2024-09-17 15:32:40', '2024-09-17 15:32:40'),
(3, 'group_host', 'vendor side', 'svg', 'https://eventinz.s3.amazonaws.com/contentsImages/group_host_1726590820_group%20host.svg', '2024-09-17 15:33:41', '2024-09-17 15:33:41'),
(4, 'app_logo', 'vendor side', 'svg', 'https://eventinz.s3.amazonaws.com/contentsImages/app_logo_1726590858_app_logo.svg', '2024-09-17 15:34:21', '2024-09-17 15:34:21'),
(5, 'approve_icon', 'vendor side', 'svg', 'https://eventinz.s3.amazonaws.com/contentsImages/approve_icon_1726590907_approve_icon.svg', '2024-09-17 15:35:09', '2024-09-17 15:35:09'),
(6, 'desapprove_icon', 'vendor side', 'svg', 'https://eventinz.s3.amazonaws.com/contentsImages/desapprove_icon_1726590958_desapprove_icon.svg', '2024-09-17 15:35:59', '2024-09-17 15:35:59'),
(7, 'menu_icon', 'vendor side', 'svg', 'https://eventinz.s3.amazonaws.com/contentsImages/menu_icon_1726590980_menu_icon.svg', '2024-09-17 15:36:22', '2024-09-17 15:36:22'),
(8, 'location_icon', 'vendor side', 'svg', 'https://eventinz.s3.amazonaws.com/contentsImages/location_icon_1726591007_location_icon.svg', '2024-09-17 15:36:49', '2024-09-17 15:36:49'),
(9, 'review_average_icon', 'vendor side', 'svg', 'https://eventinz.s3.amazonaws.com/contentsImages/review_average_icon_1726591027_review_average_icon.svg', '2024-09-17 15:37:09', '2024-09-17 15:37:09'),
(10, 'flah_icon', 'vendor side', 'svg', 'https://eventinz.s3.amazonaws.com/contentsImages/flah_icon_1726591062_flah_icon.svg', '2024-09-17 15:37:44', '2024-09-17 15:37:44'),
(11, 'arrow_right_icon', 'vendor side', 'svg', 'https://eventinz.s3.amazonaws.com/contentsImages/arrow_right_icon_1726591093_arrow-right_icon.svg', '2024-09-17 15:38:15', '2024-09-17 15:38:15'),
(12, 'calendar_icon', 'vendor side', 'svg', 'https://eventinz.s3.amazonaws.com/contentsImages/calendar_icon_1726591112_calendar_icon.svg', '2024-09-17 15:38:34', '2024-09-17 15:38:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content_images_management`
--
ALTER TABLE `content_images_management`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content_images_management`
--
ALTER TABLE `content_images_management`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
