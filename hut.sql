-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 10:18 PM
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
-- Database: `hut`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_comments`
--

CREATE TABLE `admin_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('1b6453892473a467d07372d45eb05abc2031647a', 'i:1;', 1730291610),
('1b6453892473a467d07372d45eb05abc2031647a:timer', 'i:1730291610;', 1730291610),
('2e01e17467891f7c933dbaa00e1459d23db3fe4f', 'i:3;', 1730304430),
('2e01e17467891f7c933dbaa00e1459d23db3fe4f:timer', 'i:1730304430;', 1730304430),
('356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1730291632),
('356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1730291632;', 1730291632),
('632667547e7cd3e0466547863e1207a8c0c0c549', 'i:1;', 1730301098),
('632667547e7cd3e0466547863e1207a8c0c0c549:timer', 'i:1730301098;', 1730301098),
('64e095fe763fc62418378753f9402623bea9e227', 'i:6;', 1730304340),
('64e095fe763fc62418378753f9402623bea9e227:timer', 'i:1730304340;', 1730304340),
('80e28a51cbc26fa4bd34938c5e593b36146f5e0c', 'i:2;', 1730305622),
('80e28a51cbc26fa4bd34938c5e593b36146f5e0c:timer', 'i:1730305622;', 1730305622),
('827bfc458708f0b442009c9c9836f7e4b65557fb', 'i:2;', 1730304147),
('827bfc458708f0b442009c9c9836f7e4b65557fb:timer', 'i:1730304147;', 1730304147),
('887309d048beef83ad3eabf2a79a64a389ab1c9f', 'i:1;', 1730294571),
('887309d048beef83ad3eabf2a79a64a389ab1c9f:timer', 'i:1730294571;', 1730294571),
('92cfceb39d57d914ed8b14d0e37643de0797ae56', 'i:2;', 1730302929),
('92cfceb39d57d914ed8b14d0e37643de0797ae56:timer', 'i:1730302929;', 1730302929),
('98fbc42faedc02492397cb5962ea3a3ffc0a9243', 'i:1;', 1730303467),
('98fbc42faedc02492397cb5962ea3a3ffc0a9243:timer', 'i:1730303467;', 1730303467),
('a9334987ece78b6fe8bf130ef00b74847c1d3da6', 'i:2;', 1730305063),
('a9334987ece78b6fe8bf130ef00b74847c1d3da6:timer', 'i:1730305063;', 1730305063),
('b7eb6c689c037217079766fdb77c3bac3e51cb4c', 'i:4;', 1730304762),
('b7eb6c689c037217079766fdb77c3bac3e51cb4c:timer', 'i:1730304762;', 1730304762),
('c5b76da3e608d34edb07244cd9b875ee86906328', 'i:2;', 1730305529),
('c5b76da3e608d34edb07244cd9b875ee86906328:timer', 'i:1730305529;', 1730305529),
('e1822db470e60d090affd0956d743cb0e7cdf113', 'i:3;', 1730304679),
('e1822db470e60d090affd0956d743cb0e7cdf113:timer', 'i:1730304679;', 1730304679),
('f6e1126cedebf23e1463aee73f9df08783640400', 'i:1;', 1730294279),
('f6e1126cedebf23e1463aee73f9df08783640400:timer', 'i:1730294279;', 1730294279);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_09_10_081213_add_role_to_users_table', 1),
(5, '2024_09_11_112918_add_phone_to_users_table', 1),
(6, '2024_09_11_121950_modify_phone_nullable_in_users_table', 1),
(7, '2024_09_11_123846_add_profile_photo_to_users_table', 1),
(8, '2024_09_11_131308_rename_photo_to_picture_in_users_table', 1),
(9, '2024_09_16_132829_add_deleted_at_to_users', 1),
(10, '2024_09_16_155718_create_reservations_table', 1),
(11, '2024_09_17_101139_add_nights_to_reservations_table', 1),
(12, '2024_09_24_092701_add_second_person', 1),
(13, '2024_09_24_095827_create_options_table', 1),
(14, '2024_09_24_095910_create_option_reservation_table', 1),
(15, '2024_09_24_103816_add_preselected_to_options_table', 1),
(16, '2024_09_24_110205_make_price_nullable_in_options_table', 1),
(17, '2024_09_26_165205_create_prices_table', 1),
(18, '2024_09_27_103846_add_res_price_to_reservations_table', 1),
(19, '2024_09_27_115526_add_by_day_and_by_day_preselected_to_options_table', 1),
(20, '2024_09_27_162347_modify_foreign_key_on_option_reservation', 1),
(21, '2024_10_04_143639_add_res_comment', 1),
(22, '2024_10_04_152424_update_res_comment_length_in_reservations_table', 1),
(23, '2024_10_05_222545_modify_res_comment_nullable_in_reservations_table', 2),
(24, '2024_10_07_122943_add_by_day_display_to_options_table', 3),
(25, '2024_10_07_123559_update_by_day_display_default_value_on_options_table', 4),
(26, '2024_10_07_205814_add_last_login_to_users_table', 5),
(27, '2024_10_07_232216_add_by_day_to_option_reservation_table', 6),
(28, '2024_10_07_233527_remove_by_day_from_option_reservation_table', 7),
(29, '2024_10_07_234821_remove_by_day_from_option_reservation_table2', 8),
(30, '2024_10_08_090745_add_by_day_to_option_reservation_table', 9),
(32, '2024_10_21_105942_add_default_value_to_name_in_users_table', 10),
(34, '2024_10_22_150554_make_name_nullable_in_users_table', 11),
(35, '2024_10_24_153821_create_admin_comments_table', 12),
(36, '2024_10_30_123814_update_user_id_foreign_in_reservations_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `preselected` tinyint(1) NOT NULL DEFAULT 0,
  `by_day_display` tinyint(1) NOT NULL DEFAULT 1,
  `by_day` tinyint(1) NOT NULL DEFAULT 0,
  `by_day_preselected` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name`, `description`, `price`, `available`, `created_at`, `updated_at`, `preselected`, `by_day_display`, `by_day`, `by_day_preselected`) VALUES
(1, 'Jaccuzi', 'Quoi de mieux qu\'un jaccuzi pour profiter de la vue exceptionnelle ?', 0.00, 1, '2024-10-06 13:52:51', '2024-10-30 16:48:21', 1, 0, 0, 0),
(2, 'Petit-déjeuner', 'Petit déjeuné complet pour deux personnes.', 14.00, 1, '2024-10-06 14:07:10', '2024-10-30 19:16:14', 0, 1, 0, 1),
(3, 'Plateau Dégustation - Fromages', 'Une séléction délicieuse de fromages régionnaux.\nPréparez vos papilles ! 🧀', 14.50, 1, '2024-10-06 14:08:22', '2024-10-23 13:45:38', 0, 1, 0, 0),
(9, 'aze', 'aze', NULL, 1, '2024-10-13 21:00:10', '2024-10-23 15:11:35', 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `option_reservation`
--

CREATE TABLE `option_reservation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `by_day` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `option_reservation`
--

INSERT INTO `option_reservation` (`id`, `reservation_id`, `option_id`, `created_at`, `updated_at`, `by_day`) VALUES
(6, 6, 1, NULL, NULL, 0),
(8, 7, 1, NULL, NULL, 0),
(27, 10, 1, NULL, NULL, 0),
(32, 12, 1, NULL, NULL, 0),
(38, 17, 1, NULL, NULL, 0),
(39, 18, 1, NULL, NULL, 0),
(79, 36, 1, NULL, NULL, 0),
(80, 36, 2, NULL, NULL, 0),
(81, 36, 3, NULL, NULL, 1),
(82, 37, 1, NULL, NULL, 0),
(83, 37, 2, NULL, NULL, 0),
(84, 37, 3, NULL, NULL, 1),
(85, 38, 1, NULL, NULL, 0),
(86, 38, 2, NULL, NULL, 0),
(87, 38, 3, NULL, NULL, 1),
(88, 39, 1, NULL, NULL, 0),
(89, 39, 2, NULL, NULL, 0),
(90, 39, 3, NULL, NULL, 0),
(91, 40, 1, NULL, NULL, 0),
(92, 40, 2, NULL, NULL, 0),
(93, 40, 3, NULL, NULL, 1),
(94, 41, 1, NULL, NULL, 0),
(95, 41, 2, NULL, NULL, 1),
(96, 41, 3, NULL, NULL, 1),
(97, 42, 1, NULL, NULL, 0),
(98, 42, 2, NULL, NULL, 1),
(99, 42, 3, NULL, NULL, 1),
(100, 43, 1, NULL, NULL, 0),
(101, 43, 2, NULL, NULL, 1),
(102, 43, 3, NULL, NULL, 0),
(103, 44, 1, NULL, NULL, 0),
(104, 44, 2, NULL, NULL, 0),
(105, 44, 3, NULL, NULL, 1),
(106, 45, 1, NULL, NULL, 0),
(107, 45, 2, NULL, NULL, 0),
(108, 45, 3, NULL, NULL, 1),
(109, 46, 3, NULL, NULL, 1),
(113, 48, 1, NULL, NULL, 0),
(114, 48, 2, NULL, NULL, 1),
(115, 48, 3, NULL, NULL, 0),
(116, 49, 1, NULL, NULL, 0),
(117, 49, 2, NULL, NULL, 1),
(118, 49, 3, NULL, NULL, 0),
(119, 50, 1, NULL, NULL, 0),
(120, 50, 2, NULL, NULL, 0),
(121, 50, 3, NULL, NULL, 1),
(125, 52, 1, NULL, NULL, 0),
(126, 52, 2, NULL, NULL, 1),
(127, 52, 3, NULL, NULL, 0),
(132, 54, 1, NULL, NULL, 0),
(133, 54, 2, NULL, NULL, 1),
(135, 55, 1, NULL, NULL, 0),
(136, 56, 1, NULL, NULL, 0),
(137, 56, 2, NULL, NULL, 0),
(138, 56, 3, NULL, NULL, 1),
(139, 46, 1, NULL, NULL, 0),
(140, 46, 2, NULL, NULL, 0),
(141, 57, 1, NULL, NULL, 0),
(142, 57, 3, NULL, NULL, 1),
(143, 58, 2, NULL, NULL, 1),
(144, 58, 3, NULL, NULL, 0),
(146, 59, 3, NULL, NULL, 1),
(147, 59, 1, NULL, NULL, 0),
(149, 47, 3, NULL, NULL, 1),
(150, 47, 1, NULL, NULL, 0),
(154, 61, 1, NULL, NULL, 0),
(155, 61, 2, NULL, NULL, 0),
(156, 61, 3, NULL, NULL, 0),
(158, 62, 1, NULL, NULL, 0),
(159, 62, 2, NULL, NULL, 1),
(160, 62, 3, NULL, NULL, 0),
(162, 63, 1, NULL, NULL, 0),
(163, 63, 3, NULL, NULL, 1),
(164, 64, 1, NULL, NULL, 0),
(165, 64, 2, NULL, NULL, 1),
(170, 6, 3, NULL, NULL, 1),
(171, 66, 1, NULL, NULL, 0),
(172, 66, 2, NULL, NULL, 1),
(173, 67, 1, NULL, NULL, 0),
(174, 67, 2, NULL, NULL, 0),
(175, 67, 3, NULL, NULL, 1),
(177, 35, 2, NULL, NULL, 0),
(178, 35, 3, NULL, NULL, 1),
(179, 68, 1, NULL, NULL, 0),
(180, 68, 3, NULL, NULL, 0),
(181, 69, 1, NULL, NULL, 0),
(182, 69, 2, NULL, NULL, 1),
(183, 69, 3, NULL, NULL, 1),
(187, 71, 1, NULL, NULL, 0),
(188, 71, 2, NULL, NULL, 0),
(189, 71, 3, NULL, NULL, 1),
(190, 72, 1, NULL, NULL, 0),
(191, 72, 3, NULL, NULL, 0),
(192, 73, 1, NULL, NULL, 0),
(193, 73, 2, NULL, NULL, 1),
(237, 54, 9, NULL, NULL, 1),
(239, 91, 1, NULL, NULL, 0),
(240, 91, 2, NULL, NULL, 1),
(241, 91, 3, NULL, NULL, 0),
(242, 92, 2, NULL, NULL, 1),
(243, 92, 3, NULL, NULL, 0),
(260, 98, 2, NULL, NULL, 1),
(261, 98, 3, NULL, NULL, 0),
(262, 98, 9, NULL, NULL, 1),
(264, 99, 1, NULL, NULL, 0),
(265, 99, 2, NULL, NULL, 1),
(267, 100, 2, NULL, NULL, 0),
(268, 100, 3, NULL, NULL, 1),
(270, 101, 1, NULL, NULL, 0),
(271, 101, 3, NULL, NULL, 0),
(273, 102, 2, NULL, NULL, 0),
(274, 102, 3, NULL, NULL, 1),
(276, 103, 1, NULL, NULL, 0),
(277, 103, 2, NULL, NULL, 0),
(278, 103, 9, NULL, NULL, 1),
(280, 104, 1, NULL, NULL, 0),
(281, 104, 2, NULL, NULL, 0),
(282, 104, 3, NULL, NULL, 1),
(284, 105, 1, NULL, NULL, 0),
(286, 106, 1, NULL, NULL, 0),
(287, 106, 3, NULL, NULL, 0),
(289, 107, 1, NULL, NULL, 0),
(290, 107, 2, NULL, NULL, 1),
(291, 107, 3, NULL, NULL, 0),
(292, 107, 9, NULL, NULL, 1),
(294, 108, 1, NULL, NULL, 0),
(296, 109, 1, NULL, NULL, 0),
(297, 109, 3, NULL, NULL, 1),
(302, 111, 1, NULL, NULL, 0),
(304, 112, 1, NULL, NULL, 0),
(306, 113, 1, NULL, NULL, 0),
(307, 113, 2, NULL, NULL, 1),
(308, 113, 3, NULL, NULL, 1),
(309, 113, 9, NULL, NULL, 0),
(315, 35, 1, NULL, NULL, 0),
(317, 115, 1, NULL, NULL, 0),
(319, 114, 2, NULL, NULL, 1),
(368, 129, 1, NULL, NULL, 0),
(382, 12, 2, NULL, NULL, 1),
(383, 112, 2, NULL, NULL, 1),
(384, 134, 2, NULL, NULL, 1),
(385, 134, 3, NULL, NULL, 0),
(386, 134, 9, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('aze@aze.aze', '$2y$12$Vafj8Dat4sY37dt5j7Rnv.DY4H0BgryvU4XYyn4u/UCOw/8Mhvuqq', '2024-10-24 11:35:52');

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'price_per_night', 160, NULL, NULL),
(2, 'price_per_night_for_2_and_more_nights', 120, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `nights` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `res_price` decimal(8,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `res_comment` varchar(510) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `start_date`, `end_date`, `nights`, `user_id`, `res_price`, `status`, `created_at`, `updated_at`, `res_comment`) VALUES
(6, '2024-10-27', '2024-10-28', 1, 3, 268.00, 'pending', '2024-10-07 07:39:27', '2024-10-09 14:27:05', NULL),
(7, '2024-10-29', '2024-10-30', 1, 3, 160.00, 'pending', '2024-10-07 07:51:33', '2024-10-07 07:51:33', NULL),
(10, '2024-10-24', '2024-10-25', 1, 3, 160.00, 'pending', '2024-10-07 10:11:47', '2024-10-07 10:11:47', NULL),
(11, '2024-10-08', '2024-10-10', 2, 3, 282.50, 'pending', '2024-10-07 10:37:22', '2024-10-07 10:37:22', NULL),
(12, '2024-10-30', '2024-10-31', 1, 3, 174.00, 'pending', '2024-10-07 12:29:07', '2024-10-30 16:49:09', 'qd'),
(17, '2024-11-14', '2024-11-15', 1, 1, 160.00, 'pending', '2024-10-07 15:50:39', '2024-10-07 15:50:39', NULL),
(18, '2024-10-10', '2024-10-11', 1, 3, 160.00, 'pending', '2024-10-07 15:51:18', '2024-10-07 15:51:18', NULL),
(35, '2024-11-10', '2024-11-11', 1, 1, 204.16, 'pending', '2024-10-08 07:16:34', '2024-10-22 18:03:13', 'bvo'),
(36, '2024-12-06', '2024-12-08', 2, 1, 283.00, 'pending', '2024-10-08 07:58:28', '2024-10-08 14:18:18', 'qsd'),
(37, '2024-11-29', '2024-12-01', 2, 1, 283.00, 'pending', '2024-10-08 08:03:30', '2024-10-08 08:03:30', 'wxc\r\n\r\ncvxb'),
(38, '2024-12-09', '2024-12-11', 2, 1, 283.00, 'pending', '2024-10-08 08:05:25', '2024-10-08 08:05:25', NULL),
(39, '2024-12-18', '2024-12-20', 2, 1, 268.50, 'pending', '2024-10-08 08:05:49', '2024-10-08 08:05:49', NULL),
(40, '2024-12-23', '2024-12-25', 2, 1, 283.00, 'pending', '2024-10-08 08:07:50', '2024-10-08 08:07:50', NULL),
(41, '2024-12-26', '2024-12-28', 2, 1, 297.00, 'pending', '2024-10-08 08:08:58', '2024-10-08 08:08:58', NULL),
(42, '2024-12-16', '2024-12-18', 2, 1, 297.00, 'pending', '2024-10-08 08:09:14', '2024-10-08 08:09:14', NULL),
(43, '2024-12-13', '2024-12-15', 2, 1, 282.50, 'pending', '2024-10-08 08:10:00', '2024-10-08 08:10:00', NULL),
(44, '2024-12-02', '2024-12-04', 2, 1, 283.00, 'pending', '2024-10-08 08:16:52', '2024-10-08 08:16:52', NULL),
(45, '2024-12-20', '2024-12-22', 2, 1, 283.00, 'pending', '2024-10-08 08:18:09', '2024-10-08 08:18:09', NULL),
(46, '2024-12-30', '2025-01-02', 3, 1, 417.50, 'pending', '2024-10-08 08:18:30', '2024-10-08 12:26:34', 'azes'),
(47, '2025-01-15', '2025-01-16', 1, 1, 174.50, 'pending', '2024-10-08 08:19:52', '2024-10-08 14:26:11', 'qsd\r\n\r\nwsqd'),
(48, '2025-01-08', '2025-01-09', 1, 1, 188.50, 'pending', '2024-10-08 08:28:56', '2024-10-08 08:28:56', NULL),
(49, '2025-01-22', '2025-01-23', 1, 1, 188.50, 'pending', '2024-10-08 08:29:28', '2024-10-08 08:29:28', NULL),
(50, '2025-01-02', '2025-01-04', 2, 1, 283.00, 'pending', '2024-10-08 08:43:00', '2024-10-08 08:43:00', 'qsd\r\n\r\nwxc\r\nwxcgfdsf'),
(52, '2024-12-28', '2024-12-30', 2, 1, 282.50, 'pending', '2024-10-08 08:49:53', '2024-10-08 08:49:53', 'wxc'),
(54, '2024-10-16', '2024-10-17', 1, 1, 218.00, 'pending', '2024-10-08 10:25:55', '2024-10-16 13:28:19', NULL),
(55, '2025-01-24', '2025-01-25', 1, 1, 160.00, 'pending', '2024-10-08 12:20:22', '2024-10-08 12:20:22', NULL),
(56, '2025-01-09', '2025-01-10', 1, 1, 188.50, 'pending', '2024-10-08 12:25:11', '2024-10-08 12:25:11', 'aze'),
(57, '2024-12-25', '2024-12-26', 1, 1, 174.50, 'pending', '2024-10-08 14:07:49', '2024-10-08 14:07:49', NULL),
(58, '2025-01-29', '2025-01-30', 1, 1, 188.50, 'pending', '2024-10-08 14:08:41', '2024-10-08 14:08:41', NULL),
(59, '2025-01-20', '2025-01-22', 2, 1, 269.00, 'pending', '2024-10-08 14:21:41', '2024-10-08 14:22:58', NULL),
(61, '2024-11-03', '2024-11-04', 1, 3, 188.50, 'pending', '2024-10-09 11:57:53', '2024-10-09 11:57:53', NULL),
(62, '2025-02-04', '2025-02-12', 8, 3, 1086.50, 'pending', '2024-10-09 14:16:15', '2024-10-09 14:16:15', 'wxc'),
(63, '2025-02-01', '2025-02-04', 3, 1, 403.50, 'pending', '2024-10-09 14:20:05', '2024-10-09 14:20:05', 'wxc'),
(64, '2025-02-12', '2025-02-14', 2, 1, 268.00, 'pending', '2024-10-09 14:20:36', '2024-10-09 14:20:36', 'i'),
(66, '2024-11-17', '2024-11-18', 1, 5, 174.00, 'pending', '2024-10-09 16:11:45', '2024-10-09 16:11:45', 'qsd'),
(67, '2025-01-04', '2025-01-08', 4, 5, 552.00, 'pending', '2024-10-09 16:12:26', '2024-10-09 16:12:26', 'qsd\r\n\r\nIs here !'),
(68, '2024-10-28', '2024-10-29', 1, 1, 174.50, 'pending', '2024-10-10 08:41:08', '2024-10-10 08:41:08', NULL),
(69, '2024-10-19', '2024-10-20', 1, 3, 188.50, 'pending', '2024-10-10 09:02:02', '2024-10-10 09:02:02', NULL),
(71, '2025-01-10', '2025-01-15', 5, 1, 742.50, 'pending', '2024-10-10 09:04:32', '2024-10-10 09:04:32', 'dd'),
(72, '2025-02-14', '2025-02-15', 1, 1, 174.50, 'pending', '2024-10-10 09:13:18', '2024-10-10 09:13:18', NULL),
(73, '2025-01-16', '2025-01-17', 1, 1, 174.00, 'pending', '2024-10-10 10:05:41', '2024-10-10 10:05:41', NULL),
(91, '2024-10-18', '2024-10-19', 1, 1, 188.50, 'pending', '2024-10-18 08:09:25', '2024-10-18 08:09:25', NULL),
(92, '2024-10-20', '2024-10-21', 1, 1, 188.50, 'pending', '2024-10-18 08:22:28', '2024-10-18 08:22:28', NULL),
(98, '2024-11-12', '2024-11-14', 2, 3, 401.82, 'pending', '2024-10-22 14:29:51', '2024-10-22 14:29:51', 'qsd'),
(99, '2024-11-23', '2024-11-24', 1, 3, 189.66, 'pending', '2024-10-22 14:31:11', '2024-10-22 14:31:11', 'dsdds'),
(100, '2024-11-19', '2024-11-21', 2, 3, 314.32, 'pending', '2024-10-22 15:03:32', '2024-10-22 15:03:32', NULL),
(101, '2024-11-28', '2024-11-29', 1, 3, 190.16, 'pending', '2024-10-22 15:04:43', '2024-10-22 15:04:43', NULL),
(102, '2024-11-26', '2024-11-28', 2, 3, 314.32, 'pending', '2024-10-22 15:07:26', '2024-10-22 15:07:26', NULL),
(103, '2024-11-05', '2024-11-06', 1, 3, 233.66, 'pending', '2024-10-22 15:11:09', '2024-10-22 15:11:09', NULL),
(104, '2025-02-18', '2025-02-20', 2, 3, 314.32, 'pending', '2024-10-22 15:12:38', '2024-10-22 15:12:38', 'qsd'),
(105, '2024-11-25', '2024-11-26', 1, 3, 175.66, 'pending', '2024-10-22 15:14:06', '2024-10-22 15:14:06', NULL),
(106, '2025-01-23', '2025-01-24', 1, 1, 190.16, 'pending', '2024-10-22 17:44:09', '2024-10-22 17:44:09', 'aze'),
(107, '2025-01-31', '2025-02-01', 1, 1, 248.16, 'pending', '2024-10-22 17:44:58', '2024-10-22 17:44:58', 'aze'),
(108, '2024-11-11', '2024-11-12', 1, 1, 175.66, 'pending', '2024-10-22 17:48:00', '2024-10-22 17:48:00', NULL),
(109, '2025-02-20', '2025-02-21', 1, 1, 190.16, 'pending', '2024-10-22 17:48:42', '2024-10-22 17:48:42', NULL),
(111, '2024-10-25', '2024-10-26', 1, 1, 175.66, 'pending', '2024-10-22 17:57:46', '2024-10-22 17:57:46', NULL),
(112, '2024-10-31', '2024-11-01', 1, 1, 174.00, 'pending', '2024-10-22 17:59:00', '2024-10-30 16:49:33', 'd'),
(113, '2024-11-01', '2024-11-02', 1, 1, 232.50, 'pending', '2024-10-22 18:01:10', '2024-10-22 18:01:10', NULL),
(114, '2024-10-22', '2024-10-23', 1, 1, 189.66, 'pending', '2024-10-22 18:02:05', '2024-10-22 18:04:52', NULL),
(115, '2024-10-26', '2024-10-27', 1, 1, 175.66, 'pending', '2024-10-22 18:04:05', '2024-10-22 18:04:05', NULL),
(129, '2024-11-06', '2024-11-07', 1, 3, 175.66, 'pending', '2024-10-22 19:53:33', '2024-10-22 19:53:33', 'aez'),
(134, '2024-12-12', '2024-12-13', 1, 54, 188.50, 'pending', '2024-10-30 16:53:44', '2024-10-30 16:54:42', 'aeazeu');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('GmiYbDbdmNG4O90bZjNsQL3fwCzUf5q8BggTauhr', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiS0Q2cFdPZmlBUXJpeGMyUWgzZ01FcDdUS1JvWFg5R1lhOXlySWsxNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91dGlsaXNhdGV1ci8xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1730320529);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `phone` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `name2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `last_login`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `phone`, `picture`, `deleted_at`, `name2`) VALUES
(1, 'Aze', 'aze@aze.aze', '2024-10-30 11:31:30', '2024-10-30 12:44:04', '$2y$12$T6ZelGPfKrEE.YgSagM3dO/qpl7Cxfp1L5K0N1QcUK6M.V9qu.4rW', 'sxHfrCH7ECniYO60ZB33hXg9iQpj7KJEomiiI6oWwK9UbG2nAEIQS02CwyPT', '2024-10-05 20:22:04', '2024-10-30 12:44:04', 'user', '0615166554', 'L5hunwRq3iHZ9vvjpgTIXNXHYxOJnowLM6JciZU9.png', NULL, 'Aze2'),
(3, 'M&C', 'moelleux@gmail.com', '2024-10-30 11:31:30', '2024-10-30 19:12:25', '$2y$12$iK1zEjzRsfHbCOqKA9bXQ.vNFUWSqJkAYF9juzErAOyX5CqBed8Bq', 'QrQIVbWFhlY0NPiuk7b9evC6NWoltWbh84xUduv9wm0YIdXeQykkZBSuNWvm', '2024-10-05 20:33:26', '2024-10-30 19:12:25', 'admin', '0615166111', 'WbSimk07TG9d6wz4QsNzoG6Htz8psjeIRZRPHQgW.jpg', NULL, 'RIPERT'),
(5, 'qsd qsd', 'qsd@qsd.qsd', '2024-10-30 11:31:30', '2024-10-30 11:18:50', '$2y$12$2R0xusPIvj9a7Esh.bguE.lNI9.MMpBkdHmrOwdSgCNR.fnId3C6C', NULL, '2024-10-09 16:09:05', '2024-10-30 11:18:50', 'user', '0615161237', 'FHaWkjuEGAcK7FXiauAzukMc473tBXDxViur61Na.jpg', NULL, 'qsd2'),
(8, 'Admin', 'fake_admin@fake.admin', '2024-10-30 11:31:30', NULL, '$2y$12$QA0al68Mu7DBj9HqIPfSbO/Y0X9EOzk/Pv04t/fdjy9HLRzYM.Z26', NULL, '2024-10-15 15:23:14', '2024-10-15 15:32:35', 'fake_admin', NULL, 've4ED3XV5g4CSUX5Xh6m8OFN8q5YmzmdGRLnE9LC.jpg', NULL, NULL),
(53, NULL, 'leo.ripert0@gmail.com_soft_deleted_1654', '2024-10-30 15:24:29', NULL, '$2y$12$fTrbxPqy5RCOCaAhX.tuLuADjS8I0n2DsWLC1ucZqCQu2LOjwMfKS', NULL, '2024-10-30 15:24:21', '2024-10-30 15:25:47', 'user', '0615166412', 'default_user.png', '2024-10-30 16:25:47', NULL),
(54, NULL, 'leo.ripert0@gmail.com', '2024-10-30 15:26:08', '2024-10-30 16:53:06', '$2y$12$6zQRGqWHdLRxGnRGs.s5QuYxYdK01twuBzQG.ivA/Nh121o05NAla', '9SNpkkXp6YQ6KyqrMT78Dt9IAj96qvopL25ZCLHSYg1AjcaAFMtm120pT8TE', '2024-10-30 15:25:55', '2024-10-30 16:53:06', 'user', '0615166490', 'default_user.png', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_comments`
--
ALTER TABLE `admin_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `option_reservation`
--
ALTER TABLE `option_reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_reservation_reservation_id_foreign` (`reservation_id`),
  ADD KEY `option_reservation_option_id_foreign` (`option_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prices_key_unique` (`key`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_comments`
--
ALTER TABLE `admin_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `option_reservation`
--
ALTER TABLE `option_reservation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=387;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_comments`
--
ALTER TABLE `admin_comments`
  ADD CONSTRAINT `admin_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `option_reservation`
--
ALTER TABLE `option_reservation`
  ADD CONSTRAINT `option_reservation_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `option_reservation_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
