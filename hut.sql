-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 09:59 PM
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

--
-- Dumping data for table `admin_comments`
--

INSERT INTO `admin_comments` (`id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(18, 9, 'qsd:class=\"{ \'bg-gray-400 hover:bg-gray-400 cursor-not-allowed\': newCommentLength > 1000 || newComment.trim() === \'\' }\" \n                    :disabled=\"newCommentLength > 1000 || newComment.trim() === \'\'\"qsd:class=\"{ \'bg-gray-400 hover:bg-gray-400 cursor-not-allowed\': newCommentLength > 1000 || newComment.trim() === \'\' }\" \n                    :disabled=\"newCommentLength > 1000 || newComment.trim() === \'\'\"qsd:class=\"{ \'bg-gray-400 hover:bg-gray-400 cursor-not-allowed\': newCommentLength > 1000 || newComment.trim() === \'\' }\" \n                    :disabled=\"newCommentLength > 1000 || newComment.trim() === \'\'\"qsd:class=\"{ \'bg-gray-400 hover:bg-gray-400 cursor-not-allowed\': newCommentLength > 1000 || newComment.trim() === \'\' }\" \n                    :disabled=\"newCommentLength > 1000 || newComment.trim() === \'\'\"qsd:class=\"{ \'bg-gray-400 hover:bg-gray-400 cursor-not-allowed\': newCommentLength > 1000 || newComment.trim() === \'\' }\" \n                    :disabled=\"newCommentLength > 1000 ||', '2024-10-24 16:57:04', '2024-10-24 16:57:04'),
(20, 13, 'ml', '2024-10-24 17:26:03', '2024-10-24 17:26:03'),
(21, 13, 'qsd', '2024-10-24 17:27:20', '2024-10-24 17:27:20'),
(23, 11, 'wxcwxcqs', '2024-10-24 17:46:48', '2024-10-24 17:52:41');

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
(30, '2024_10_08_090745_add_by_day_to_option_reservation_table', 9),
(32, '2024_10_21_105942_add_default_value_to_name_in_users_table', 10),
(34, '2024_10_22_150554_make_name_nullable_in_users_table', 11),
(35, '2024_10_24_153821_create_admin_comments_table', 12);

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
(1, 'Jaccuzi', 'Quoi de mieux qu\'un jaccuzi pour profiter de la vue exceptionnelle ?', 0.00, 1, '2024-10-06 13:52:51', '2024-10-22 19:54:11', 1, 0, 0, 0),
(2, 'Petit déjeuné', 'Petit déjeuné complet pour deux personnes.', 14.00, 1, '2024-10-06 14:07:10', '2024-10-22 11:16:17', 0, 1, 0, 1),
(3, 'Plateau Dégustation - Fromages', 'Une séléction délicieuse de fromages régionnaux.\nPréparez vos papilles ! 🧀', 14.50, 1, '2024-10-06 14:08:22', '2024-10-23 13:45:38', 0, 1, 0, 0),
(9, 'aze', 'aze', NULL, 1, '2024-10-13 21:00:10', '2024-10-23 15:11:35', 0, 1, 0, 0),
(10, 'azertyuyiuiopiqsddfggfhjjhkklmwxcvxcbbvnazertyuiohjkazerty567890123456', 'lsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkpsdkflsdfkp', 567.89, 1, '2024-10-22 13:49:20', '2024-10-23 15:17:17', 1, 1, 0, 1),
(12, 'MWQOmwqomwqomwqomwqoMWQO', 'mwqomwqomwqomwqomwqomwqomwqo16', 16.00, 1, '2024-10-23 15:24:57', '2024-10-23 15:24:57', 0, 1, 0, 0);

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
(40, 19, 1, NULL, NULL, 0),
(41, 19, 2, NULL, NULL, 0),
(49, 23, 1, NULL, NULL, 0),
(50, 23, 2, NULL, NULL, 0),
(51, 23, 3, NULL, NULL, 0),
(68, 30, 1, NULL, NULL, 0),
(74, 33, 2, NULL, NULL, 0),
(75, 33, 3, NULL, NULL, 0),
(76, 19, 3, NULL, NULL, 0),
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
(194, 74, 2, NULL, NULL, 1),
(195, 74, 3, NULL, NULL, 0),
(196, 75, 1, NULL, NULL, 0),
(197, 75, 2, NULL, NULL, 1),
(198, 75, 3, NULL, NULL, 0),
(199, 76, 1, NULL, NULL, 0),
(200, 76, 2, NULL, NULL, 0),
(201, 76, 3, NULL, NULL, 0),
(202, 77, 1, NULL, NULL, 0),
(203, 78, 1, NULL, NULL, 0),
(204, 79, 1, NULL, NULL, 0),
(205, 79, 2, NULL, NULL, 1),
(206, 79, 3, NULL, NULL, 0),
(218, 83, 1, NULL, NULL, 0),
(219, 83, 2, NULL, NULL, 1),
(220, 83, 3, NULL, NULL, 0),
(221, 83, 9, NULL, NULL, 1),
(222, 84, 1, NULL, NULL, 0),
(223, 84, 2, NULL, NULL, 1),
(224, 84, 3, NULL, NULL, 1),
(225, 84, 9, NULL, NULL, 0),
(226, 85, 1, NULL, NULL, 0),
(227, 85, 2, NULL, NULL, 1),
(228, 85, 3, NULL, NULL, 0),
(230, 87, 1, NULL, NULL, 0),
(231, 88, 1, NULL, NULL, 0),
(237, 54, 9, NULL, NULL, 1),
(239, 91, 1, NULL, NULL, 0),
(240, 91, 2, NULL, NULL, 1),
(241, 91, 3, NULL, NULL, 0),
(242, 92, 2, NULL, NULL, 1),
(243, 92, 3, NULL, NULL, 0),
(244, 93, 1, NULL, NULL, 0),
(245, 93, 2, NULL, NULL, 1),
(246, 93, 3, NULL, NULL, 0),
(247, 94, 1, NULL, NULL, 0),
(248, 94, 2, NULL, NULL, 1),
(249, 94, 3, NULL, NULL, 0),
(250, 95, 1, NULL, NULL, 0),
(251, 95, 2, NULL, NULL, 0),
(252, 95, 3, NULL, NULL, 0),
(258, 97, 1, NULL, NULL, 0),
(259, 97, 2, NULL, NULL, 1),
(260, 98, 2, NULL, NULL, 1),
(261, 98, 3, NULL, NULL, 0),
(262, 98, 9, NULL, NULL, 1),
(263, 98, 10, NULL, NULL, 1),
(264, 99, 1, NULL, NULL, 0),
(265, 99, 2, NULL, NULL, 1),
(266, 99, 10, NULL, NULL, 1),
(267, 100, 2, NULL, NULL, 0),
(268, 100, 3, NULL, NULL, 1),
(269, 100, 10, NULL, NULL, 1),
(270, 101, 1, NULL, NULL, 0),
(271, 101, 3, NULL, NULL, 0),
(272, 101, 10, NULL, NULL, 0),
(273, 102, 2, NULL, NULL, 0),
(274, 102, 3, NULL, NULL, 1),
(275, 102, 10, NULL, NULL, 1),
(276, 103, 1, NULL, NULL, 0),
(277, 103, 2, NULL, NULL, 0),
(278, 103, 9, NULL, NULL, 1),
(279, 103, 10, NULL, NULL, 1),
(280, 104, 1, NULL, NULL, 0),
(281, 104, 2, NULL, NULL, 0),
(282, 104, 3, NULL, NULL, 1),
(283, 104, 10, NULL, NULL, 1),
(284, 105, 1, NULL, NULL, 0),
(285, 105, 10, NULL, NULL, 1),
(286, 106, 1, NULL, NULL, 0),
(287, 106, 3, NULL, NULL, 0),
(288, 106, 10, NULL, NULL, 1),
(289, 107, 1, NULL, NULL, 0),
(290, 107, 2, NULL, NULL, 1),
(291, 107, 3, NULL, NULL, 0),
(292, 107, 9, NULL, NULL, 1),
(293, 107, 10, NULL, NULL, 1),
(294, 108, 1, NULL, NULL, 0),
(295, 108, 10, NULL, NULL, 1),
(296, 109, 1, NULL, NULL, 0),
(297, 109, 3, NULL, NULL, 1),
(298, 109, 10, NULL, NULL, 1),
(302, 111, 1, NULL, NULL, 0),
(303, 111, 10, NULL, NULL, 1),
(304, 112, 1, NULL, NULL, 0),
(305, 112, 10, NULL, NULL, 1),
(306, 113, 1, NULL, NULL, 0),
(307, 113, 2, NULL, NULL, 1),
(308, 113, 3, NULL, NULL, 1),
(309, 113, 9, NULL, NULL, 0),
(312, 114, 10, NULL, NULL, 1),
(315, 35, 1, NULL, NULL, 0),
(316, 35, 10, NULL, NULL, 1),
(317, 115, 1, NULL, NULL, 0),
(318, 115, 10, NULL, NULL, 1),
(319, 114, 2, NULL, NULL, 1),
(320, 116, 1, NULL, NULL, 0),
(321, 116, 2, NULL, NULL, 1),
(322, 116, 3, NULL, NULL, 0),
(323, 116, 10, NULL, NULL, 1),
(327, 117, 2, NULL, NULL, 0),
(328, 117, 9, NULL, NULL, 1),
(331, 118, 3, NULL, NULL, 0),
(332, 118, 9, NULL, NULL, 0),
(334, 117, 1, NULL, NULL, 0),
(335, 117, 10, NULL, NULL, 1),
(343, 122, 2, NULL, NULL, 1),
(344, 122, 3, NULL, NULL, 0),
(345, 122, 9, NULL, NULL, 0),
(346, 122, 10, NULL, NULL, 1),
(347, 123, 1, NULL, NULL, 0),
(348, 123, 2, NULL, NULL, 0),
(349, 123, 3, NULL, NULL, 1),
(350, 123, 9, NULL, NULL, 0),
(351, 124, 1, NULL, NULL, 0),
(352, 124, 2, NULL, NULL, 1),
(353, 124, 10, NULL, NULL, 1),
(354, 125, 1, NULL, NULL, 0),
(355, 125, 10, NULL, NULL, 1),
(356, 126, 1, NULL, NULL, 0),
(357, 126, 10, NULL, NULL, 1),
(358, 127, 1, NULL, NULL, 0),
(359, 127, 10, NULL, NULL, 1),
(363, 128, 2, NULL, NULL, 0),
(367, 128, 1, NULL, NULL, 0),
(368, 129, 1, NULL, NULL, 0),
(369, 129, 10, NULL, NULL, 1),
(370, 130, 2, NULL, NULL, 1),
(375, 130, 1, NULL, NULL, 0),
(376, 131, 1, NULL, NULL, 0),
(377, 131, 10, NULL, NULL, 1);

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
(2, 'price_per_night_for_2_and_more_nights', 121, NULL, NULL);

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
(12, '2024-10-30', '2024-10-31', 1, 3, 160.00, 'pending', '2024-10-07 12:29:07', '2024-10-07 12:29:07', NULL),
(17, '2024-11-14', '2024-11-15', 1, 1, 160.00, 'pending', '2024-10-07 15:50:39', '2024-10-07 15:50:39', NULL),
(18, '2024-10-10', '2024-10-11', 1, 3, 160.00, 'pending', '2024-10-07 15:51:18', '2024-10-07 15:51:18', NULL),
(19, '2024-10-11', '2024-10-13', 2, 4, 297.00, 'pending', '2024-10-07 20:37:10', '2024-10-07 22:26:31', 'Hello dudes.\r\n\r\nNicely done !'),
(23, '2024-11-07', '2024-11-09', 2, 4, 282.50, 'pending', '2024-10-07 21:23:28', '2024-10-07 21:23:28', 'qsd\r\n\r\nqsdf\r\n\r\nwxcwxcwxc'),
(29, '2024-11-15', '2024-11-17', 2, 4, 240.00, 'pending', '2024-10-07 22:20:10', '2024-10-22 18:23:35', NULL),
(30, '2024-12-12', '2024-12-13', 1, 4, 160.00, 'pending', '2024-10-07 22:21:00', '2024-10-07 22:21:00', NULL),
(33, '2024-12-04', '2024-12-06', 2, 4, 282.50, 'pending', '2024-10-07 22:24:29', '2024-10-07 22:24:29', 'qqsd'),
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
(74, '2025-01-17', '2025-01-19', 2, 4, 282.50, 'pending', '2024-10-13 10:33:20', '2024-10-13 10:33:20', 'qsd'),
(75, '2024-12-01', '2024-12-02', 1, 4, 188.50, 'pending', '2024-10-13 10:36:38', '2024-10-13 10:36:38', NULL),
(76, '2024-12-11', '2024-12-12', 1, 4, 188.50, 'pending', '2024-10-13 10:41:13', '2024-10-13 10:41:13', NULL),
(77, '2024-12-08', '2024-12-09', 1, 4, 160.00, 'pending', '2024-10-13 10:45:04', '2024-10-13 10:45:04', NULL),
(78, '2024-12-15', '2024-12-16', 1, 4, 160.00, 'pending', '2024-10-13 10:49:24', '2024-10-13 10:49:24', NULL),
(79, '2024-12-22', '2024-12-23', 1, 4, 188.50, 'pending', '2024-10-13 10:52:30', '2024-10-13 10:52:30', 'ss'),
(83, '2025-02-24', '2025-02-26', 2, 4, 370.50, 'pending', '2024-10-15 16:13:41', '2024-10-15 16:13:41', 'aze'),
(84, '2025-03-10', '2025-03-12', 2, 4, 341.00, 'pending', '2024-10-15 16:23:36', '2024-10-15 16:23:36', 'aze'),
(85, '2025-03-18', '2025-03-20', 2, 4, 282.50, 'pending', '2024-10-15 16:25:48', '2024-10-15 16:25:48', 'd'),
(87, '2025-02-27', '2025-02-28', 1, 4, 160.00, 'pending', '2024-10-15 16:29:35', '2024-10-15 16:29:35', NULL),
(88, '2025-01-30', '2025-01-31', 1, 4, 160.00, 'pending', '2024-10-15 16:32:17', '2024-10-15 16:32:17', NULL),
(91, '2024-10-18', '2024-10-19', 1, 1, 188.50, 'pending', '2024-10-18 08:09:25', '2024-10-18 08:09:25', NULL),
(92, '2024-10-20', '2024-10-21', 1, 1, 188.50, 'pending', '2024-10-18 08:22:28', '2024-10-18 08:22:28', NULL),
(93, '2024-11-21', '2024-11-23', 2, 11, 282.50, 'pending', '2024-10-21 11:01:52', '2024-10-21 11:01:52', 'fgh'),
(94, '2025-01-27', '2025-01-29', 2, 11, 282.50, 'pending', '2024-10-21 11:06:42', '2024-10-21 11:06:42', 'c'),
(95, '2025-01-25', '2025-01-26', 1, 11, 188.50, 'pending', '2024-10-21 11:08:43', '2024-10-21 11:08:43', NULL),
(97, '2024-10-23', '2024-10-24', 1, 14, 174.00, 'pending', '2024-10-22 13:07:41', '2024-10-22 13:07:41', 'cvb'),
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
(112, '2024-10-31', '2024-11-01', 1, 1, 175.66, 'pending', '2024-10-22 17:59:00', '2024-10-22 17:59:00', NULL),
(113, '2024-11-01', '2024-11-02', 1, 1, 232.50, 'pending', '2024-10-22 18:01:10', '2024-10-22 18:01:10', NULL),
(114, '2024-10-22', '2024-10-23', 1, 1, 189.66, 'pending', '2024-10-22 18:02:05', '2024-10-22 18:04:52', NULL),
(115, '2024-10-26', '2024-10-27', 1, 1, 175.66, 'pending', '2024-10-22 18:04:05', '2024-10-22 18:04:05', NULL),
(116, '2025-03-06', '2025-03-08', 2, 4, 313.82, 'pending', '2024-10-22 18:06:06', '2024-10-22 18:06:06', 'aze'),
(117, '2025-04-03', '2025-04-05', 2, 4, 373.32, 'pending', '2024-10-22 18:07:13', '2024-10-22 18:18:42', 'qsd'),
(118, '2025-06-04', '2025-06-07', 3, 4, 418.50, 'pending', '2024-10-22 18:17:54', '2024-10-22 18:19:22', 'qsd'),
(121, '2025-03-14', '2025-03-16', 2, 4, 240.00, 'pending', '2024-10-22 18:44:14', '2024-10-22 18:44:14', NULL),
(122, '2025-02-21', '2025-02-23', 2, 4, 357.82, 'pending', '2024-10-22 18:45:11', '2024-10-22 18:45:11', 'qsc'),
(123, '2025-03-12', '2025-03-14', 2, 4, 327.00, 'pending', '2024-10-22 18:47:15', '2024-10-22 18:47:15', NULL),
(124, '2025-02-26', '2025-02-27', 1, 4, 189.66, 'pending', '2024-10-22 18:47:53', '2024-10-22 18:47:53', 'qc'),
(125, '2025-02-28', '2025-03-01', 1, 4, 175.66, 'pending', '2024-10-22 18:50:20', '2024-10-22 18:50:20', NULL),
(126, '2025-03-26', '2025-03-28', 2, 4, 271.32, 'pending', '2024-10-22 18:54:24', '2024-10-22 18:54:24', NULL),
(127, '2025-03-20', '2025-03-21', 1, 4, 175.66, 'pending', '2024-10-22 18:55:07', '2024-10-22 18:55:07', NULL),
(128, '2025-02-15', '2025-02-18', 3, 4, 374.00, 'pending', '2024-10-22 19:45:35', '2024-10-22 19:46:35', 'wc'),
(129, '2024-11-06', '2024-11-07', 1, 3, 175.66, 'pending', '2024-10-22 19:53:33', '2024-10-22 19:53:33', 'aez'),
(130, '2025-03-03', '2025-03-05', 2, 4, 270.00, 'pending', '2024-10-24 17:42:26', '2024-10-24 17:43:55', 'azez'),
(131, '2025-03-17', '2025-03-18', 1, 4, 727.89, 'pending', '2024-10-24 17:45:47', '2024-10-24 17:45:47', NULL);

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
('UX0hSXAbsePPpjD4h993axa0zfmCoyq52YLl7Mmh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoieHdzZW5Kc0Yxc0xYZ1hKU2N3U0docDlyTTd5Y0RTZkZud2RBb3FYbCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1729799591);

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
(1, 'Aze', 'aze@aze.aze', NULL, '2024-10-24 16:08:23', '$2y$12$T6ZelGPfKrEE.YgSagM3dO/qpl7Cxfp1L5K0N1QcUK6M.V9qu.4rW', 'LH6OWVdL87SaMBcSVvZTPYNgNlTDjToFJ2apzdi5b4iotFNYEBURqynQWQLw', '2024-10-05 20:22:04', '2024-10-24 16:08:23', 'user', '0615166554', 'L5hunwRq3iHZ9vvjpgTIXNXHYxOJnowLM6JciZU9.png', NULL, 'Aze2'),
(2, 'M&c', 'moelleux@gmail.com_soft_deleted_1116', NULL, NULL, '$2y$12$qs9nYmFbsm3cijHImNleCe5K/a6K3Uh9mfpd3Vb06wtLl.gLV/sgS', NULL, '2024-10-05 20:27:35', '2024-10-05 20:32:52', 'user', '0615166111', 'wuMcVZOqX1aL5NKAhixnovTqcLMNaGvIn7RG5UqA.jpg', '2024-10-05 22:32:52', 'Ripert'),
(3, 'M&C', 'moelleux@gmail.com', NULL, '2024-10-24 17:46:11', '$2y$12$iK1zEjzRsfHbCOqKA9bXQ.vNFUWSqJkAYF9juzErAOyX5CqBed8Bq', 'FWg3nuaQxJQhX3i3QRdklxaLIyNMfJosECpEe5ytl2exseF9TKpB0alAQq7v', '2024-10-05 20:33:26', '2024-10-24 17:46:11', 'admin', '0615166111', 'WbSimk07TG9d6wz4QsNzoG6Htz8psjeIRZRPHQgW.jpg', NULL, 'RIPERT'),
(4, 'Léo', 'leo.ripert0@gmail.com', NULL, '2024-10-24 17:41:50', '$2y$12$HClaP9XSalJgjhPrDtL/pOHD.mZ4psOWtIGiDtYQ473FPR9a9r46C', 'sQGQBYgpE8X0uZNDhtZHcjnsGc2ahPc6GtXlvtJUEEd10WHKMLCxeLttb6p6', '2024-10-07 20:32:10', '2024-10-24 17:41:50', 'user', '0615166490', 'IZL8pp7MGJNTeiS3VqyPt2Xlw709ho9WpCp86RGX.jpg', NULL, 'Léa'),
(5, 'qsd qsd', 'qsd@qsd.qsd', NULL, '2024-10-16 13:13:23', '$2y$12$2R0xusPIvj9a7Esh.bguE.lNI9.MMpBkdHmrOwdSgCNR.fnId3C6C', NULL, '2024-10-09 16:09:05', '2024-10-16 13:13:23', 'user', '0615161237', 'FHaWkjuEGAcK7FXiauAzukMc473tBXDxViur61Na.jpg', NULL, 'qsd2'),
(8, 'Admin', 'fake_admin@fake.admin', NULL, NULL, '$2y$12$QA0al68Mu7DBj9HqIPfSbO/Y0X9EOzk/Pv04t/fdjy9HLRzYM.Z26', NULL, '2024-10-15 15:23:14', '2024-10-15 15:32:35', 'fake_admin', NULL, 've4ED3XV5g4CSUX5Xh6m8OFN8q5YmzmdGRLnE9LC.jpg', NULL, NULL),
(9, 'Anonymous', 'qsdrtd@gmail.com', NULL, NULL, '$2y$12$tYula.L/2pT8uI/3TNxAiOuDwKwBwSjbNzLWSE0U9QBcyd9W2yNJ2', NULL, '2024-10-21 09:00:18', '2024-10-21 09:00:18', 'user', NULL, 'default_user.png', NULL, NULL),
(10, 'Profil', 'qsddrt@gmail.com', NULL, NULL, '$2y$12$wHuf.YLnDVVUHmqxp6CDC.CmxJO09Nwetbuc5fMYbJ1qvM1av6eGu', NULL, '2024-10-21 09:13:03', '2024-10-21 09:13:03', 'user', NULL, 'default_user.png', NULL, NULL),
(11, 'Profil', 'fgh@fgh.fgh', NULL, NULL, '$2y$12$Uo9Xa2ZvoyCveQiSQvxq/.SeFwdqw44Pacgb/Qdbv/oX3yNHA.OOm', NULL, '2024-10-21 11:01:32', '2024-10-21 11:01:32', 'user', NULL, 'default_user.png', NULL, NULL),
(12, 'ert', 'ert@ert.ert_soft_deleted_4317', NULL, NULL, '$2y$12$.bNZ9136RZBIev135.bvv.gzOCIvzuG8qo5Vp4pGUVhOiIY5FW9sq', NULL, '2024-10-21 11:25:53', '2024-10-21 11:26:54', 'user', '0564165564', 'ZrDoZPNuvNJpihqDk6SJdCnsTsLmS0SmJsJIgRXk.jpg', '2024-10-21 13:26:54', 'etttr'),
(13, 'qsd', 'aze@aze.azeqsd', NULL, '2024-10-22 12:45:12', '$2y$12$bQeD2ycf4KtvO4UrLMPdMOSaoz0svkhBHt9E0iE1wGB7gACwJmYF6', 'hWa5qJbJBZ5klqYvxPXpRROWqJi8u7qpW8TKmd3tuPtFRQHOZFYRbJMM4Yhk', '2024-10-22 12:42:49', '2024-10-22 12:54:36', 'user', '0564654633', 'rydDSO7qPInYkUaOp2kGAI5nBQ29FqiquQ2Y1N1e.jpg', NULL, 'ss'),
(14, NULL, 'cvb@cvb.cvbb', NULL, NULL, '$2y$12$8ZxYDbK52Zs0HbpLVAw8d.s3X80Jnmg1gmRQBIG.i1Ff0CN1lBRTG', NULL, '2024-10-22 13:07:22', '2024-10-22 13:07:22', 'user', NULL, 'default_user.png', NULL, NULL),
(15, NULL, 'qsd@qsd.qsdq', NULL, NULL, '$2y$12$.s3HNP5cTkAtQREynMrIAeXFFasYrm3sNSMZnCCcNjq8uIReR4P0C', NULL, '2024-10-22 13:12:18', '2024-10-22 13:12:18', 'user', NULL, 'default_user.png', NULL, NULL),
(16, 'tyu', 'tyu@tyu.tyu', NULL, '2024-10-24 11:27:42', '$2y$12$EdseYYH0XZQ8Q9vaGII9eOPQk7bYojciqn7MlVyVkE1cug7s1iqGO', NULL, '2024-10-24 11:13:04', '2024-10-24 11:27:42', 'user', '0615166490', 'default_user.png', NULL, 'yy'),
(17, 'qsd', 'qsdrt@gmail.comd', NULL, NULL, '$2y$12$GZ5ofdIEqJn9nJUrzUqj/OcdmP2gesD/Kw7GCuyP44uYQcWd05Aki', NULL, '2024-10-24 12:14:04', '2024-10-24 12:15:28', 'user', '0130245654', 'default_user.png', NULL, 'ss'),
(18, NULL, 'qsdrt@gmail.comqsq_soft_deleted_6268', NULL, NULL, '$2y$12$lbfLpEHStqxEJhp.oboQB./akkQsqUpxNERjIfuHbShEL97gZ0z0K', NULL, '2024-10-24 12:44:20', '2024-10-24 12:44:37', 'user', NULL, 'default_user.png', '2024-10-24 14:44:37', NULL),
(19, 'z\"', 'qsdrt@gmail.comqwxd_soft_deleted_8777', NULL, NULL, '$2y$12$6N0Ay1quwJwoIhM0RFOoZeREn4916q/vKpImBkp1C5/v68kj/3KZS', NULL, '2024-10-24 17:40:35', '2024-10-24 17:41:10', 'user', '0615166490', 'default_user.png', '2024-10-24 19:41:10', 'qs');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `option_reservation`
--
ALTER TABLE `option_reservation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=378;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
