-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 03:51 PM
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
-- Table structure for table `rights`
--
DROP TABLE IF EXISTS `rights`;

CREATE TABLE `rights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rights_types_id` varchar(191) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rights`
--

INSERT INTO `rights` (`id`, `rights_types_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, '1', 'print_list', 'print any list', NULL, NULL),
(2, '1', 'view_users_hosts_and_vendors_list', 'view users hosts and vendors list', '2024-09-24 10:22:33', '2024-09-24 10:22:33'),
(3, '1', 'view_details_about_hosts_and_vendors', 'view details about hosts and vendors', '2024-09-24 10:24:19', '2024-09-24 10:24:19'),
(4, '1', 'resend_otp', 'resend otp', '2024-09-24 10:24:44', '2024-09-24 10:24:44'),
(5, '2', 'view_list_of_staff_members', 'view list of staff members', '2024-09-24 10:25:02', '2024-09-24 10:25:02'),
(6, '2', 'view_details_of_each_staff_member', 'view details of each staff member', '2024-09-24 10:25:17', '2024-09-24 10:25:17'),
(7, '2', 'edit_staff_members', 'edit staff members', '2024-09-24 10:25:32', '2024-09-24 10:25:32'),
(8, '2', 'edit_self_staff_account_information', 'edit self staff account information', '2024-09-24 10:25:50', '2024-09-24 10:25:50'),
(9, '2', 'add_new_staff_member', 'add new staff member', '2024-09-24 10:26:03', '2024-09-24 10:26:03'),
(10, '3', 'view_events_list', 'view events list', '2024-09-24 10:26:44', '2024-09-24 10:26:44'),
(11, '3', 'view_event_details', 'view event details', '2024-09-24 10:27:08', '2024-09-24 10:27:08'),
(12, '3', 'edit_event_details', 'edit event details', '2024-09-24 10:29:52', '2024-09-24 10:29:52'),
(13, '3', 'view_event_type_list', 'view event type list', '2024-09-24 10:30:23', '2024-09-24 10:30:23'),
(14, '3', 'add_new_event_type', 'add new event type', '2024-09-24 10:30:48', '2024-09-24 10:30:48'),
(15, '3', 'edit_event_type', 'edit event type', '2024-09-24 10:31:39', '2024-09-24 10:31:39'),
(16, '3', 'delete_event_type', 'delete event type', '2024-09-24 10:32:02', '2024-09-24 10:32:02'),
(17, '3', 'view_event_subcategories_list', 'view event subcategories list', '2024-09-24 10:32:15', '2024-09-24 10:32:15'),
(18, '3', 'view_event_subcategory_details', 'view event subcategory details', '2024-09-24 10:32:28', '2024-09-24 10:32:28'),
(19, '3', 'edit_event_subcategory', 'edit event subcategory', '2024-09-24 10:32:40', '2024-09-24 10:32:40'),
(20, '3', 'delete_event_subcategory', 'delete event subcategory', '2024-09-24 10:32:50', '2024-09-24 10:32:50'),
(21, '3', 'view_reviews_list', 'view reviews list', '2024-09-24 10:33:03', '2024-09-24 10:33:03'),
(22, '3', 'view_review_details', 'view review details', '2024-09-24 10:33:15', '2024-09-24 10:33:15'),
(23, '3', 'review_edit', 'review edit', '2024-09-24 10:33:26', '2024-09-24 10:33:26'),
(24, '4', 'view_categories_list', 'view categories list', '2024-09-24 10:33:45', '2024-09-24 10:33:45'),
(25, '4', 'edit_category', 'edit category', '2024-09-24 10:34:04', '2024-09-24 10:34:04'),
(26, '4', 'delete_category', 'delete category', '2024-09-24 10:34:20', '2024-09-24 10:34:20'),
(27, '9', 'view_subscription_list', 'view subscription list', '2024-09-24 10:34:38', '2024-09-24 10:34:38'),
(28, '9', 'view_subscription_details', 'view subscription details', '2024-09-24 10:34:51', '2024-09-24 10:34:51'),
(29, '9', 'add_new_subscription', 'add new subscription', '2024-09-24 10:35:10', '2024-09-24 10:35:10'),
(30, '9', 'edit_subscription', 'edit subscription', '2024-09-24 10:35:26', '2024-09-24 10:35:26'),
(31, '9', 'delete_subscritpion', 'delete subscritpion', '2024-09-24 10:35:37', '2024-09-24 10:35:37'),
(32, '5', 'view_companies_list', 'view companies list', '2024-09-24 10:35:50', '2024-09-24 10:35:50'),
(33, '5', 'view_company_details', 'view company details', '2024-09-24 10:36:11', '2024-09-24 10:36:11'),
(34, '5', 'edit_company_details', 'edit company details', '2024-09-24 10:36:37', '2024-09-24 10:36:37'),
(35, '7', 'view_vendors_classes_list', 'view vendors classes list', '2024-09-24 10:36:56', '2024-09-24 10:36:56'),
(36, '7', 'view_vendor_class_details', 'view vendor class details', '2024-09-24 10:37:12', '2024-09-24 10:37:12'),
(37, '6', 'view_taxes_list', 'view taxes list', '2024-09-24 10:37:34', '2024-09-24 10:37:34'),
(38, '6', 'view_taxe_details', 'view taxe details', '2024-09-24 10:37:46', '2024-09-24 10:37:46'),
(39, '6', 'edit_taxe', 'edit taxe', '2024-09-24 10:37:57', '2024-09-24 10:37:57'),
(40, '6', 'delete_taxe', 'delete taxe', '2024-09-24 10:38:08', '2024-09-24 10:38:08'),
(41, '8', 'view_payments_list', 'view payments list', '2024-09-24 10:38:35', '2024-09-24 10:38:35'),
(42, '8', 'view_payment_details', 'view payment details', '2024-09-24 10:38:45', '2024-09-24 10:38:45'),
(43, '10', 'view_contents_texts_list', 'view contents texts list', '2024-09-24 10:39:03', '2024-09-24 10:39:03'),
(44, '10', 'view_content_text', 'view content text', '2024-09-24 10:39:16', '2024-09-24 10:39:16'),
(45, '10', 'edit_content_text', 'edit content text', '2024-09-24 10:39:34', '2024-09-24 10:39:34'),
(46, '11', 'view_contents_images_list', 'view contents images list', '2024-09-24 10:39:51', '2024-09-24 10:39:51'),
(47, '11', 'view_content_image', 'view content image', '2024-09-24 10:40:05', '2024-09-24 10:40:05'),
(48, '11', 'edit_content_image', 'edit content image', '2024-09-24 10:40:16', '2024-09-24 10:40:16'),
(49, '12', 'view_limits_list', 'view limits list', '2024-09-24 10:40:31', '2024-09-24 10:40:31'),
(50, '12', 'edit_limit', 'edit limit', '2024-09-24 10:40:48', '2024-09-24 10:40:48'),
(51, '4', 'add_new_category', 'add new category', '2024-09-24 13:49:32', '2024-09-24 13:49:32'),
(52, '3', 'add_new_event_subcategory', 'add new event subcategory', '2024-09-24 13:49:32', '2024-09-24 13:49:32'),
(53, '14', 'view_service_list', 'view service list', '2024-09-24 13:49:32', '2024-09-24 13:49:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rights`
--
ALTER TABLE `rights`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rights`
--
ALTER TABLE `rights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
