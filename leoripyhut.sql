-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 06:49 PM
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
-- Database: `leoripyhut`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(30, '2024_10_08_090745_add_by_day_to_option_reservation_table', 9);

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
(1, 'Jaccuzi', 'Quoi de mieux qu\'un jaccuzi pour profiter de la vue exceptionnelle ?', 0.00, 1, '2024-10-06 13:52:51', '2024-10-10 10:24:25', 1, 0, 0, 0),
(2, 'Petit déjeuné', 'Petit déjeuné complet pour deux personnes.', 14.00, 1, '2024-10-06 14:07:10', '2024-10-07 15:15:50', 0, 1, 0, 1),
(3, 'Plateau de Fromage', 'Une séléction délicieuse de fromages régionnaux.\nPréparez vos papilles ! 🧀', 14.50, 1, '2024-10-06 14:08:22', '2024-10-10 10:25:45', 0, 0, 0, 0);

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
(26, 9, 2, NULL, NULL, 0),
(27, 10, 1, NULL, NULL, 0),
(28, 9, 1, NULL, NULL, 0),
(32, 12, 1, NULL, NULL, 0),
(37, 16, 1, NULL, NULL, 0),
(38, 17, 1, NULL, NULL, 0),
(39, 18, 1, NULL, NULL, 0),
(40, 19, 1, NULL, NULL, 0),
(41, 19, 2, NULL, NULL, 0),
(42, 20, 1, NULL, NULL, 0),
(43, 20, 2, NULL, NULL, 0),
(44, 21, 2, NULL, NULL, 0),
(45, 21, 3, NULL, NULL, 0),
(46, 22, 1, NULL, NULL, 0),
(47, 22, 2, NULL, NULL, 0),
(48, 22, 3, NULL, NULL, 0),
(49, 23, 1, NULL, NULL, 0),
(50, 23, 2, NULL, NULL, 0),
(51, 23, 3, NULL, NULL, 0),
(52, 24, 2, NULL, NULL, 0),
(53, 24, 3, NULL, NULL, 0),
(54, 25, 1, NULL, NULL, 0),
(55, 25, 2, NULL, NULL, 0),
(56, 25, 3, NULL, NULL, 0),
(57, 26, 1, NULL, NULL, 0),
(58, 26, 2, NULL, NULL, 0),
(59, 26, 3, NULL, NULL, 0),
(60, 27, 1, NULL, NULL, 0),
(61, 27, 2, NULL, NULL, 0),
(62, 27, 3, NULL, NULL, 0),
(63, 28, 2, NULL, NULL, 0),
(64, 28, 3, NULL, NULL, 0),
(65, 29, 1, NULL, NULL, 0),
(66, 29, 3, NULL, NULL, 0),
(67, 29, 2, NULL, NULL, 0),
(68, 30, 1, NULL, NULL, 0),
(69, 31, 2, NULL, NULL, 0),
(70, 31, 3, NULL, NULL, 0),
(71, 32, 1, NULL, NULL, 0),
(72, 32, 2, NULL, NULL, 0),
(73, 32, 3, NULL, NULL, 0),
(74, 33, 2, NULL, NULL, 0),
(75, 33, 3, NULL, NULL, 0),
(76, 19, 3, NULL, NULL, 0),
(77, 34, 2, NULL, NULL, 0),
(78, 34, 3, NULL, NULL, 0),
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
(134, 54, 3, NULL, NULL, 1),
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
(151, 60, 1, NULL, NULL, 0),
(152, 60, 2, NULL, NULL, 0),
(153, 60, 3, NULL, NULL, 0),
(154, 61, 1, NULL, NULL, 0),
(155, 61, 2, NULL, NULL, 0),
(156, 61, 3, NULL, NULL, 0),
(158, 62, 1, NULL, NULL, 0),
(159, 62, 2, NULL, NULL, 1),
(160, 62, 3, NULL, NULL, 0),
(161, 16, 3, NULL, NULL, 0),
(162, 63, 1, NULL, NULL, 0),
(163, 63, 3, NULL, NULL, 1),
(164, 64, 1, NULL, NULL, 0),
(165, 64, 2, NULL, NULL, 1),
(166, 1, 1, NULL, NULL, 0),
(167, 1, 2, NULL, NULL, 1),
(168, 1, 3, NULL, NULL, 0),
(169, 65, 1, NULL, NULL, 0),
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
(184, 70, 1, NULL, NULL, 0),
(185, 70, 2, NULL, NULL, 0),
(186, 70, 3, NULL, NULL, 1),
(187, 71, 1, NULL, NULL, 0),
(188, 71, 2, NULL, NULL, 0),
(189, 71, 3, NULL, NULL, 1),
(190, 72, 1, NULL, NULL, 0),
(191, 72, 3, NULL, NULL, 0),
(192, 73, 1, NULL, NULL, 0),
(193, 73, 2, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2024-10-18', '2024-10-19', 1, 1, 282.50, 'pending', '2024-10-05 20:26:08', '2024-10-09 14:23:42', '222cf'),
(6, '2024-10-27', '2024-10-28', 1, 3, 268.00, 'pending', '2024-10-07 07:39:27', '2024-10-09 14:27:05', NULL),
(7, '2024-10-29', '2024-10-30', 1, 3, 160.00, 'pending', '2024-10-07 07:51:33', '2024-10-07 07:51:33', NULL),
(9, '2024-10-25', '2024-10-27', 2, 1, 268.00, 'pending', '2024-10-07 10:09:09', '2024-10-07 10:12:45', 'wxcwxc\r\n\r\n\r\nwxcwxcd'),
(10, '2024-10-24', '2024-10-25', 1, 3, 160.00, 'pending', '2024-10-07 10:11:47', '2024-10-07 10:11:47', NULL),
(11, '2024-10-08', '2024-10-10', 2, 3, 282.50, 'pending', '2024-10-07 10:37:22', '2024-10-07 10:37:22', NULL),
(12, '2024-10-30', '2024-10-31', 1, 3, 160.00, 'pending', '2024-10-07 12:29:07', '2024-10-07 12:29:07', NULL),
(13, '2024-10-31', '2024-11-01', 1, 1, 160.00, 'pending', '2024-10-07 12:38:41', '2024-10-08 09:06:07', NULL),
(16, '2024-10-21', '2024-10-23', 2, 1, 268.00, 'pending', '2024-10-07 15:06:14', '2024-10-09 14:19:34', 'xwc'),
(17, '2024-11-14', '2024-11-15', 1, 1, 160.00, 'pending', '2024-10-07 15:50:39', '2024-10-07 15:50:39', NULL),
(18, '2024-10-10', '2024-10-11', 1, 3, 160.00, 'pending', '2024-10-07 15:51:18', '2024-10-07 15:51:18', NULL),
(19, '2024-10-11', '2024-10-13', 2, 4, 297.00, 'pending', '2024-10-07 20:37:10', '2024-10-07 22:26:31', 'Hello dudes.\r\n\r\nNicely done !'),
(20, '2024-11-02', '2024-11-03', 1, 4, 174.00, 'pending', '2024-10-07 20:43:44', '2024-10-07 20:43:44', NULL),
(21, '2024-10-13', '2024-10-16', 3, 4, 416.50, 'pending', '2024-10-07 21:13:40', '2024-10-07 21:13:40', 'aze\r\n\r\nqsd'),
(22, '2024-11-12', '2024-11-14', 2, 4, 282.50, 'pending', '2024-10-07 21:21:24', '2024-10-07 21:21:24', 'wxc\r\n\r\nwxc\r\n\r\nvbvcbb'),
(23, '2024-11-07', '2024-11-09', 2, 4, 282.50, 'pending', '2024-10-07 21:23:28', '2024-10-07 21:23:28', 'qsd\r\n\r\nqsdf\r\n\r\nwxcwxcwxc'),
(24, '2024-11-27', '2024-11-29', 2, 4, 282.50, 'pending', '2024-10-07 21:45:10', '2024-10-07 21:45:10', 'qsd\r\n\r\nxc\r\n\r\nbnvbnvbnvbn'),
(25, '2024-11-20', '2024-11-22', 2, 4, 282.50, 'pending', '2024-10-07 22:05:02', '2024-10-07 22:05:02', 'qsd\r\n\r\nxcv\r\nbvn'),
(26, '2024-11-18', '2024-11-20', 2, 4, 282.50, 'pending', '2024-10-07 22:05:58', '2024-10-07 22:05:58', 'qsd\r\n\r\ndfg'),
(27, '2024-11-25', '2024-11-27', 2, 4, 283.00, 'pending', '2024-10-07 22:06:54', '2024-10-07 22:06:54', 'qsdxwc\r\n\r\nbv\r\n\r\nbncvb\r\nfvgxd'),
(28, '2024-11-22', '2024-11-24', 2, 4, 282.50, 'pending', '2024-10-07 22:10:09', '2024-10-07 22:10:09', NULL),
(29, '2024-11-15', '2024-11-17', 2, 4, 282.50, 'pending', '2024-10-07 22:20:10', '2024-10-07 22:20:10', 'ert'),
(30, '2024-12-12', '2024-12-13', 1, 4, 160.00, 'pending', '2024-10-07 22:21:00', '2024-10-07 22:21:00', NULL),
(31, '2024-11-04', '2024-11-06', 2, 4, 282.50, 'pending', '2024-10-07 22:22:12', '2024-10-07 22:22:12', 'sqs'),
(32, '2024-11-06', '2024-11-07', 1, 4, 188.50, 'pending', '2024-10-07 22:22:30', '2024-10-07 22:22:30', NULL),
(33, '2024-12-04', '2024-12-06', 2, 4, 282.50, 'pending', '2024-10-07 22:24:29', '2024-10-07 22:24:29', 'qqsd'),
(34, '2024-11-01', '2024-11-02', 1, 1, 188.50, 'pending', '2024-10-08 07:14:30', '2024-10-08 07:14:30', NULL),
(35, '2024-11-09', '2024-11-11', 2, 1, 283.00, 'pending', '2024-10-08 07:16:34', '2024-10-10 08:39:38', 'bvo'),
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
(54, '2024-10-16', '2024-10-17', 1, 1, 188.50, 'pending', '2024-10-08 10:25:55', '2024-10-08 10:25:55', NULL),
(55, '2025-01-24', '2025-01-25', 1, 1, 160.00, 'pending', '2024-10-08 12:20:22', '2024-10-08 12:20:22', NULL),
(56, '2025-01-09', '2025-01-10', 1, 1, 188.50, 'pending', '2024-10-08 12:25:11', '2024-10-08 12:25:11', 'aze'),
(57, '2024-12-25', '2024-12-26', 1, 1, 174.50, 'pending', '2024-10-08 14:07:49', '2024-10-08 14:07:49', NULL),
(58, '2025-01-29', '2025-01-30', 1, 1, 188.50, 'pending', '2024-10-08 14:08:41', '2024-10-08 14:08:41', NULL),
(59, '2025-01-20', '2025-01-22', 2, 1, 269.00, 'pending', '2024-10-08 14:21:41', '2024-10-08 14:22:58', NULL),
(60, '2024-10-23', '2024-10-24', 1, 3, 188.50, 'pending', '2024-10-09 11:57:12', '2024-10-09 11:57:12', NULL),
(61, '2024-11-03', '2024-11-04', 1, 3, 188.50, 'pending', '2024-10-09 11:57:53', '2024-10-09 11:57:53', NULL),
(62, '2025-02-04', '2025-02-12', 8, 3, 1086.50, 'pending', '2024-10-09 14:16:15', '2024-10-09 14:16:15', 'wxc'),
(63, '2025-02-01', '2025-02-04', 3, 1, 403.50, 'pending', '2024-10-09 14:20:05', '2024-10-09 14:20:05', 'wxc'),
(64, '2025-02-12', '2025-02-14', 2, 1, 268.00, 'pending', '2024-10-09 14:20:36', '2024-10-09 14:20:36', 'i'),
(65, '2024-10-17', '2024-10-18', 1, 3, 160.00, 'pending', '2024-10-09 14:24:02', '2024-10-09 14:24:02', NULL),
(66, '2024-11-17', '2024-11-18', 1, 5, 174.00, 'pending', '2024-10-09 16:11:45', '2024-10-09 16:11:45', 'qsd'),
(67, '2025-01-04', '2025-01-08', 4, 5, 552.00, 'pending', '2024-10-09 16:12:26', '2024-10-09 16:12:26', 'qsd\r\n\r\nIs here !'),
(68, '2024-10-28', '2024-10-29', 1, 1, 174.50, 'pending', '2024-10-10 08:41:08', '2024-10-10 08:41:08', NULL),
(69, '2024-10-19', '2024-10-20', 1, 3, 188.50, 'pending', '2024-10-10 09:02:02', '2024-10-10 09:02:02', NULL),
(70, '2024-10-20', '2024-10-21', 1, 1, 174.00, 'pending', '2024-10-10 09:02:30', '2024-10-10 09:03:00', 'aze'),
(71, '2025-01-10', '2025-01-15', 5, 1, 742.50, 'pending', '2024-10-10 09:04:32', '2024-10-10 09:04:32', 'dd'),
(72, '2025-02-14', '2025-02-15', 1, 1, 174.50, 'pending', '2024-10-10 09:13:18', '2024-10-10 09:13:18', NULL),
(73, '2025-01-16', '2025-01-17', 1, 1, 174.00, 'pending', '2024-10-10 10:05:41', '2024-10-10 10:05:41', NULL);

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
('rHOwyOBfIdYeFzJz7vTLmO9HocWt0O0EhCNFI4Wm', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZGtaeDZSTTY2ODRRNzYwejVNTUpZODd3bHNnRU85ZkJSWVgxd2ZTUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MztzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyOToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL29wdGlvbnMiO319', 1728563172);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
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
(1, 'Aze', 'aze@aze.aze', NULL, '2024-10-10 10:05:24', '$2y$12$9WAcAnxdJAxKsBOd86ce2O.KtPZo6Ut.c50iNRaiVJEABsvEdmKXW', 'qkYQYORGniUKEbfkw4Uaf8gwotZSA9o6j66YR42qQYhDmPa82ZmmO4WKmJtq', '2024-10-05 20:22:04', '2024-10-10 10:05:24', 'user', '0615166555', 'xDQqONi5AoO2aKxrXAPmRTlQGoRLb5fSOpdcufO4.jpg', NULL, 'Aze2'),
(2, 'M&c', 'moelleux@gmail.com_soft_deleted_1116', NULL, NULL, '$2y$12$qs9nYmFbsm3cijHImNleCe5K/a6K3Uh9mfpd3Vb06wtLl.gLV/sgS', NULL, '2024-10-05 20:27:35', '2024-10-05 20:32:52', 'user', '0615166111', 'wuMcVZOqX1aL5NKAhixnovTqcLMNaGvIn7RG5UqA.jpg', '2024-10-05 22:32:52', 'Ripert'),
(3, 'M&C', 'moelleux@gmail.com', NULL, '2024-10-10 10:23:59', '$2y$12$iK1zEjzRsfHbCOqKA9bXQ.vNFUWSqJkAYF9juzErAOyX5CqBed8Bq', 'xuP349aIuFCD1jEJjBGFZhFiVlKeBONqmeJMs7ubZRVAVCAthy6fFWvuPfnG', '2024-10-05 20:33:26', '2024-10-10 10:23:59', 'admin', '0615166111', 'Fb4JnY1Do477TANIUiyxifUrpg0jwkhYpKfwRKif.jpg', NULL, 'RIPERT'),
(4, 'Léo', 'leo.ripert0@gmail.com', NULL, '2024-10-07 21:12:53', '$2y$12$HFHzjDIpY.jxs.MlyzJQAuKqHHaGuvH.4bNChvo9JGZIemY3kGvum', NULL, '2024-10-07 20:32:10', '2024-10-07 21:12:53', 'user', '0615166490', 'IZL8pp7MGJNTeiS3VqyPt2Xlw709ho9WpCp86RGX.jpg', NULL, 'Léa'),
(5, 'qsd qsd', 'qsd@qsd.qsd', NULL, '2024-10-09 16:10:53', '$2y$12$2R0xusPIvj9a7Esh.bguE.lNI9.MMpBkdHmrOwdSgCNR.fnId3C6C', NULL, '2024-10-09 16:09:05', '2024-10-09 16:10:53', 'user', '0615161237', 'FHaWkjuEGAcK7FXiauAzukMc473tBXDxViur61Na.jpg', NULL, 'qsd2');

--
-- Indexes for dumped tables
--

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `option_reservation`
--
ALTER TABLE `option_reservation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

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
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
