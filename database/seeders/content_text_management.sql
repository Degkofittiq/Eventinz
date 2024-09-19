-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2024 at 01:36 PM
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
-- Table structure for table `content_text_management`
--
DROP TABLE IF EXISTS `content_images_management`;

CREATE TABLE `content_text_management` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `page` varchar(191) NOT NULL,
  `content_fr` text NOT NULL,
  `content_en` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content_text_management`
--

INSERT INTO `content_text_management` (`id`, `name`, `page`, `content_fr`, `content_en`, `created_at`, `updated_at`) VALUES
(1, 'terms_of_use', 'landing page', 'Bienvenue sur Eventinz. En accédant à notre application et en l\'utilisant, vous acceptez les conditions générales suivantes&nbsp;:\n\nAcceptation des conditions\nEn téléchargeant, en installant ou en utilisant l\'application, vous acceptez de vous conformer à ces conditions. Si vous ne les acceptez pas, veuillez cesser d\'utiliser l\'application.\n\nModifications des conditions\nNous nous réservons le droit de modifier ces conditions à tout moment. Les modifications seront publiées dans cette section et entreront en vigueur immédiatement après leur publication.\n\nUtilisation de l\'application\nL\'application est fournie pour un usage personnel et non commercial. Vous acceptez de ne pas utiliser l\'application d\'une manière qui violerait les lois ou réglementations applicables.\n\nPropriété intellectuelle\nTous les droits liés au contenu, à la conception et aux fonctionnalités de l\'application sont la propriété exclusive d\'ITTIQ.\n\nRésiliation\nNous nous réservons le droit de suspendre ou de résilier votre accès à l\'application à tout moment, avec ou sans préavis, pour quelque raison que ce soit.', 'Welcome to Eventinz. By accessing and using our application, you agree to the following terms and conditions:\n\nAcceptance of Terms\nBy downloading, installing, or using the app, you agree to comply with these terms. If you do not agree to them, please discontinue the use of the app.\n\nChanges to Terms\nWe reserve the right to modify these terms at any time. Changes will be posted in this section and will become effective immediately upon posting.\n\nUse of the App\nThe app is provided for personal and non-commercial use. You agree not to use the app in any way that would violate any applicable laws or regulations.\n\nIntellectual Property\nAll rights related to the content, design, and functionalities of the app are the exclusive property of ITTIQ.\n\nTermination\nWe reserve the right to suspend or terminate your access to the app at any time, with or without notice, for any reason.', '2024-09-11 14:08:57', '2024-09-11 16:07:09'),
(2, 'login_button_text', 'langing page', 'Se connecter', 'Login', '2024-09-12 07:52:32', '2024-09-12 07:57:04'),
(3, 'sign_up_button_text', 'landing page', 'S\'inscrire', 'Sign Up', '2024-09-12 07:58:13', '2024-09-12 07:58:13'),
(4, 'welcome_texte', 'login page', 'Content de vous Revoir', 'Welcome Back', '2024-09-12 08:00:46', '2024-09-12 08:00:46'),
(5, 'small_text_before_other_login_way', 'login page', 'Ou se connecter avec', 'Or sign in with', '2024-09-12 08:02:42', '2024-09-12 08:02:42'),
(6, 'forgot_password_text', 'login page', 'Mot de passe oublié', 'Forgot password', '2024-09-12 08:03:50', '2024-09-12 08:03:50'),
(7, 'user_type_selection', 'sign up page 1', 'Selectionnez un', 'Select one', '2024-09-12 08:05:56', '2024-09-12 08:05:56'),
(8, 'first_user_type', 'sign up page 1', 'Visiteur', 'Host', '2024-09-12 08:07:43', '2024-09-12 08:07:43'),
(9, 'second_user_type', 'sign up page 1', 'Prestataire', 'Vendor', '2024-09-12 08:08:15', '2024-09-12 08:08:15'),
(10, 'sign_up_option', 'sign up page 2', 'S\'inscrire avec', 'Sign-up with', '2024-09-12 08:09:15', '2024-09-12 08:09:15'),
(11, 'small_text_before_other_sign_up_way', 'sign up page 2', 'Ou s\'inscrire avec', 'Or singn-up with', '2024-09-12 08:11:44', '2024-09-12 08:11:44'),
(12, 'sign_up_vendor_text', 'sign up vendor page', 'Prestataire', 'Vendor', '2024-09-12 08:47:51', '2024-09-12 08:47:51'),
(13, 'send_otp_text', 'sign up page 3', 'Envoyer l\'OTP', 'Send OTP', '2024-09-12 08:49:48', '2024-09-12 08:49:48'),
(14, 'resend_otp_text', 'sign up page 3', 'Renvoyer l\'OTP', 'Resend OTP', '2024-09-12 08:50:30', '2024-09-12 08:50:30'),
(15, 'otp_field_text', 'Verify otp page', 'OTP', 'OTP', '2024-09-12 08:51:36', '2024-09-12 08:51:36'),
(16, 'company_name_field_text', 'vendor company registration page', 'Nom de l\'Entreprise', 'Company Name', '2024-09-12 08:53:31', '2024-09-12 08:53:31'),
(17, 'country_field_text', 'vendor company registration page', 'Pays', 'Country', '2024-09-12 08:54:16', '2024-09-12 08:54:16'),
(18, 'state_or_province_text', 'vendor company registration page', 'État/Province', 'State/Province', '2024-09-12 08:55:41', '2024-09-12 08:55:41'),
(19, 'city_field_text', 'vendor company registration page', 'Ville', 'City', '2024-09-12 08:56:46', '2024-09-12 08:56:46'),
(20, 'vendor_class_selection_text', 'vendor class selection page', 'Classe du Prestataire', 'Vendor Class', '2024-09-12 08:59:03', '2024-09-12 08:59:03'),
(21, 'vendor_class_1_text', 'vendor class selection page', 'Service Unique', 'Single Service', '2024-09-12 09:01:18', '2024-09-12 09:01:18'),
(22, 'vendor_class_2_text', 'vendor class selection page', 'Service Multiple', 'Multiple Service', '2024-09-12 09:01:55', '2024-09-12 09:01:55'),
(23, 'privacy_policy', 'landing page', 'Politique de Confidentialité\r\nChez Evetinz, nous respectons et protégeons votre vie privée. Cette politique explique comment nous collectons, utilisons et partageons vos informations personnelles.\r\n\r\nCollecte des Informations\r\nNous collectons des informations lorsque vous vous inscrivez, utilisez l\'application ou interagissez avec certaines de ses fonctionnalités. Cela inclut, sans s\'y limiter, vos nom, adresse e-mail, informations de localisation, et toute autre donnée nécessaire à l\'utilisation du service.\r\n\r\nUtilisation des Informations\r\nLes informations collectées sont utilisées pour :\r\n\r\nFournir et améliorer nos services ;\r\nCommuniquer avec vous sur les mises à jour ou offres ;\r\nProtéger la sécurité et l\'intégrité de nos services.\r\nPartage des Informations\r\nNous ne partageons pas vos informations personnelles avec des tiers, sauf dans les cas suivants :\r\n\r\nSi cela est nécessaire pour vous fournir un service ;\r\nSi nous y sommes obligés par la loi ou une demande légale.\r\nSécurité des Données\r\nNous mettons en œuvre des mesures techniques et organisationnelles pour protéger vos informations contre tout accès non autorisé ou toute divulgation accidentelle.\r\n\r\nVos Droits\r\nVous avez le droit d\'accéder, de modifier ou de supprimer vos données personnelles à tout moment. Pour exercer ces droits, veuillez nous contacter à ittiq@gmail.com.\r\n\r\nCookies\r\nNous utilisons des cookies pour améliorer l\'expérience utilisateur et analyser l\'utilisation de l\'application. Vous pouvez désactiver les cookies dans les paramètres de votre appareil, mais cela peut affecter certaines fonctionnalités de l\'application.\r\n\r\nModifications de la Politique de Confidentialité\r\nNous nous réservons le droit de mettre à jour cette politique de confidentialité à tout moment. Les modifications seront publiées dans cette section, et nous vous informerons de tout changement significatif.', 'Privacy Policy\r\nAt Evetinz, we respect and protect your privacy. This policy explains how we collect, use, and share your personal information.\r\n\r\nInformation Collection\r\nWe collect information when you register, use the App, or interact with some of its features. This includes, but is not limited to, your name, email address, location information, and any other data necessary to use the Service.\r\n\r\nUse of Information\r\nThe information collected is used to:\r\n\r\nProvide and improve our Services;\r\nCommunicate with you about updates or offers;\r\nProtect the security and integrity of our Services.\r\nSharing of Information\r\nWe do not share your personal information with third parties, except in the following cases:\r\n\r\nIf it is necessary to provide you with a service;\r\nIf we are required to do so by law or legal request.\r\nData Security\r\nWe implement technical and organizational measures to protect your information from unauthorized access or accidental disclosure.\r\n\r\nYour Rights\r\nYou have the right to access, modify or delete your personal data at any time. To exercise these rights, please contact us at ittiq@gmail.com.\r\n\r\nCookies\r\nWe use cookies to improve the user experience and analyze the use of the application. You can disable cookies in your device settings, but this may affect some features of the application.\r\n\r\nChanges to the Privacy Policy\r\nWe reserve the right to update this privacy policy at any time. Changes will be published in this section, and we will notify you of any significant changes.', '2024-09-12 09:13:41', '2024-09-12 09:13:41'),
(24, 'vendor_category_selection_text', 'vendor category selection page', 'Selectionnez votre categorie de prestation', 'Select Vendor Category', '2024-09-12 09:16:41', '2024-09-12 09:16:41'),
(25, 'subscription_validation_button', 'subscription selection', 'Souscrire', 'Subscribe', '2024-09-12 09:18:54', '2024-09-12 09:18:54'),
(26, 'payment_details_text', 'payment details page', 'Détails de paiement', 'Payment Details', '2024-09-12 09:20:29', '2024-09-12 09:20:29'),
(27, 'email_for_payment', 'payment details page', 'Adresse Email', 'Email Address', '2024-09-12 09:22:09', '2024-09-12 09:22:09'),
(28, 'phone_number_for_payment', 'payment details page', 'Numéro de téléphone', 'Phone number', '2024-09-12 09:22:59', '2024-09-12 09:22:59'),
(29, 'summary_text', 'payment details page', 'Récapitulatif', 'Order summary', '2024-09-12 09:24:19', '2024-09-12 09:24:19'),
(30, 'summary_subscription_text', 'payment details page', 'Abonnement', 'Subscription', '2024-09-12 09:25:30', '2024-09-12 09:25:30'),
(31, 'summary_subtotal_text', 'payment details page', 'Sous total', 'Subtotal', '2024-09-12 09:27:33', '2024-09-12 09:27:33'),
(32, 'success_message_for_subscription', 'payment details page', 'Abonné(e)', 'Subscribed', '2024-09-12 09:29:45', '2024-09-12 09:29:45'),
(33, 'error_for_selection_more_1', 'vendor category selection page', 'Désolé ! Les fournisseurs individuels ne peuvent sélectionner qu\'une seule catégorie de fournisseurs. Veuillez effectuer une mise à niveau vers Enterprise pour sélectionner plus d\'une catégorie de fournisseurs.', 'Sorry! Individual vendorscan only select 1 vendorcategory. Please upgrade to Enterprise to select more than 1 vendorcategory.', '2024-09-12 09:31:13', '2024-09-12 09:31:13'),
(34, 'error_for_selection_more_3', 'vendor category selection page', 'Désolé ! Les fournisseurs d\'entreprise ne peuvent sélectionner qu\'un maximum de 3 catégories de fournisseurs.', 'Sorry! Enterprise vendorscan only select maximum of3 vendor categories.', '2024-09-12 09:32:21', '2024-09-12 09:32:21'),
(35, 'error_for_selection_more_the_limit_title', 'vendor category selection page', 'Avis', 'Notice', '2024-09-12 09:33:14', '2024-09-12 09:33:14'),
(36, 'country_field_text', 'create event step one', 'Pays', 'Country', '2024-09-19 10:04:13', '2024-09-19 10:04:13'),
(37, 'state_or_province_text', 'create event step one', 'État/Province', 'State/Province', '2024-09-19 10:05:04', '2024-09-19 10:05:04'),
(38, 'city_field_text', 'create event step one', 'Ville', 'City', '2024-09-19 10:05:39', '2024-09-19 10:05:39'),
(39, 'process_title', 'create event step one', 'Créer un événement', 'Create Event', '2024-09-19 10:06:58', '2024-09-19 10:06:58'),
(40, 'first_step_title', 'create event step one', 'Première étape', 'Step One', '2024-09-19 10:08:05', '2024-09-19 10:08:05'),
(41, 'first_step_section_1_title', 'create event step one', 'Lieu de l\'événement', 'Event Location', '2024-09-19 10:09:44', '2024-09-19 10:09:44'),
(42, 'first_step_section_2_title', 'create event step one', 'Événement', 'Event', '2024-09-19 10:10:27', '2024-09-19 10:10:27'),
(43, 'event_type_text_field', 'create event step one', 'Type d\'événement', 'Event type', '2024-09-19 10:11:41', '2024-09-19 10:11:41'),
(44, 'event_subcategory_text_field', 'create event step one', 'Sous-catégorie', 'Subcategory', '2024-09-19 10:12:31', '2024-09-19 10:12:31'),
(45, 'second_step_title', 'create event step two', 'Deuxième étape', 'Step Two', '2024-09-19 10:14:10', '2024-09-19 10:15:47'),
(46, 'second_step_section_1_title', 'create event step two', 'Informations sur l\'événement', 'Event Information', '2024-09-19 10:16:51', '2024-09-19 10:16:51'),
(47, 'event_date_field_text', 'create event step two', 'Date de l\'événement', 'Event Date', '2024-09-19 10:17:53', '2024-09-19 10:17:53'),
(48, 'aproximative_budget_text', 'create event step two', 'Budget Approximatif', 'Aprx Budget', '2024-09-19 10:19:09', '2024-09-19 10:19:09'),
(49, 'guest_number_field_text', 'create event step two', 'Nombre d\'invités', 'No Guests', '2024-09-19 10:20:50', '2024-09-19 10:20:50'),
(50, 'vendor_category_field_text', 'create event step two', 'Catégorie de Fournisseur', 'Vendor Category', '2024-09-19 10:21:48', '2024-09-19 10:21:48'),
(51, 'more_vendor_total_field_text', 'create event step two', 'Fournisseur', 'Vendor', '2024-09-19 10:23:13', '2024-09-19 10:23:13'),
(52, 'travel_field_text', 'create event step two', 'Voyage Requis', 'Travel Required', '2024-09-19 10:24:46', '2024-09-19 10:24:46'),
(53, 'event_private_or_public_field_text', 'create event step two', 'Privé', 'Private', '2024-09-19 10:25:55', '2024-09-19 10:25:55'),
(54, 'poke_vendor_field_text', 'create event step two', 'Choisir un Fournisseur', 'Poke Vendor', '2024-09-19 10:27:23', '2024-09-19 10:27:23'),
(55, 'additional_comments_field_text', 'create event step two', 'Commentaires supplémentaires', 'Additional comments', '2024-09-19 10:28:19', '2024-09-19 10:28:19'),
(56, 'information_icon_for_vendor_category', 'create event step two', 'Selectionnez la catégorie de fournisseur souhaité', 'Select the desired Vendor category', '2024-09-19 10:30:19', '2024-09-19 10:30:19'),
(57, 'information_icon_for_more_vendor_category', 'create event step two', 'Sélectionnez plus de catégories de fournisseurs', 'Select more Vendors categories', '2024-09-19 10:32:12', '2024-09-19 10:32:12'),
(58, 'event_plan_confirmation_text', 'create event confirmation step', 'Prêt à planifier ?', 'Ready to plan ?', '2024-09-19 10:33:38', '2024-09-19 10:33:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content_text_management`
--
ALTER TABLE `content_text_management`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content_text_management`
--
ALTER TABLE `content_text_management`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
