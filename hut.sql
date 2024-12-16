-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 05:42 PM
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
(28, 1, 'scgh', '2024-11-08 22:26:22', '2024-11-15 21:45:04'),
(29, 110, 'qs', '2024-11-13 08:52:32', '2024-11-13 08:52:32'),
(30, 110, 'c', '2024-11-15 22:27:05', '2024-11-15 22:27:05'),
(31, 121, 'qsdz', '2024-11-19 17:10:30', '2024-11-19 17:10:35'),
(33, 121, 'bgtr', '2024-11-19 17:10:42', '2024-11-19 17:10:42');

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
(35, '2024_10_24_153821_create_admin_comments_table', 12),
(36, '2024_10_30_123814_update_user_id_foreign_in_reservations_table', 13),
(37, '2024_11_06_121930_add_google_id_to_users_table', 14),
(39, '2024_11_07_175743_add_google_id_to_users_table', 15),
(41, '2024_11_07_180152_modify_user_id_foreign_in_reservations_table', 16),
(45, '2024_11_12_174627_insert_percent_reduction_into_prices_table', 17),
(48, '2024_11_13_092448_create_special_dates_prices_table', 18),
(49, '2024_12_01_121754_add_payed_to_reservations_table', 19),
(50, '2024_12_01_133026_add_card_fees_to_reservations_table', 20),
(51, '2024_12_03_111213_add_res_payed_to_reservations_table', 21);

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
(1, 'Jaccuzi', 'Quoi de mieux qu\'un jaccuzi pour profiter de la vue exceptionnelle ?', 0.00, 1, '2024-10-06 13:52:51', '2024-11-18 23:42:22', 1, 0, 0, 0),
(2, 'Petit-déjeuner', 'Petit déjeuné complet pour deux personnes.', 14.00, 1, '2024-10-06 14:07:10', '2024-10-30 19:16:14', 0, 1, 0, 1),
(3, 'Plateau Dégustation - Fromages', 'Une séléction délicieuse de fromages régionnaux.\nPréparez vos papilles ! 🧀', 14.50, 1, '2024-10-06 14:08:22', '2024-10-23 13:45:38', 0, 1, 0, 0),
(9, 'aze', 'aze', NULL, 1, '2024-10-13 21:00:10', '2024-10-23 15:11:35', 0, 1, 0, 0),
(16, 'sdf', 'dsfsdf\n\nwxc\nxcwxcwxcwxcwxcwxcwxc', -50.20, 1, '2024-11-21 12:53:47', '2024-11-21 12:53:47', 0, 1, 0, 0);

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
(79, 36, 1, NULL, NULL, 0),
(80, 36, 2, NULL, NULL, 0),
(81, 36, 3, NULL, NULL, 1),
(82, 37, 1, NULL, NULL, 0),
(83, 37, 2, NULL, NULL, 0),
(84, 37, 3, NULL, NULL, 1),
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
(158, 62, 1, NULL, NULL, 0),
(159, 62, 2, NULL, NULL, 1),
(160, 62, 3, NULL, NULL, 0),
(162, 63, 1, NULL, NULL, 0),
(163, 63, 3, NULL, NULL, 1),
(164, 64, 1, NULL, NULL, 0),
(165, 64, 2, NULL, NULL, 1),
(173, 67, 1, NULL, NULL, 0),
(174, 67, 2, NULL, NULL, 0),
(175, 67, 3, NULL, NULL, 1),
(187, 71, 1, NULL, NULL, 0),
(188, 71, 2, NULL, NULL, 0),
(189, 71, 3, NULL, NULL, 1),
(190, 72, 1, NULL, NULL, 0),
(191, 72, 3, NULL, NULL, 0),
(192, 73, 1, NULL, NULL, 0),
(193, 73, 2, NULL, NULL, 1),
(267, 100, 2, NULL, NULL, 0),
(268, 100, 3, NULL, NULL, 1),
(270, 101, 1, NULL, NULL, 0),
(271, 101, 3, NULL, NULL, 0),
(280, 104, 1, NULL, NULL, 0),
(281, 104, 2, NULL, NULL, 0),
(282, 104, 3, NULL, NULL, 1),
(286, 106, 1, NULL, NULL, 0),
(287, 106, 3, NULL, NULL, 0),
(289, 107, 1, NULL, NULL, 0),
(290, 107, 2, NULL, NULL, 1),
(291, 107, 3, NULL, NULL, 0),
(292, 107, 9, NULL, NULL, 1),
(296, 109, 1, NULL, NULL, 0),
(297, 109, 3, NULL, NULL, 1),
(413, 146, 1, NULL, NULL, 0),
(414, 147, 1, NULL, NULL, 0),
(415, 147, 2, NULL, NULL, 0),
(416, 147, 3, NULL, NULL, 1),
(420, 149, 1, NULL, NULL, 0),
(421, 149, 3, NULL, NULL, 0),
(422, 150, 1, NULL, NULL, 0),
(423, 151, 1, NULL, NULL, 0),
(424, 151, 2, NULL, NULL, 0),
(425, 151, 3, NULL, NULL, 1),
(426, 152, 1, NULL, NULL, 0),
(427, 152, 2, NULL, NULL, 0),
(428, 152, 3, NULL, NULL, 1),
(434, 155, 2, NULL, NULL, 0),
(435, 155, 3, NULL, NULL, 1),
(443, 158, 1, NULL, NULL, 0),
(444, 158, 2, NULL, NULL, 1),
(445, 158, 3, NULL, NULL, 1),
(446, 158, 9, NULL, NULL, 0),
(447, 159, 2, NULL, NULL, 1),
(448, 159, 3, NULL, NULL, 1),
(449, 159, 9, NULL, NULL, 0),
(450, 160, 1, NULL, NULL, 0),
(451, 160, 2, NULL, NULL, 1),
(452, 160, 9, NULL, NULL, 0),
(453, 161, 1, NULL, NULL, 0),
(454, 161, 2, NULL, NULL, 1),
(455, 161, 3, NULL, NULL, 1),
(456, 161, 9, NULL, NULL, 0),
(459, 163, 1, NULL, NULL, 0),
(460, 163, 2, NULL, NULL, 1),
(461, 163, 3, NULL, NULL, 0),
(462, 163, 16, NULL, NULL, 1),
(477, 167, 2, NULL, NULL, 1),
(478, 167, 3, NULL, NULL, 0),
(479, 167, 9, NULL, NULL, 0),
(480, 167, 16, NULL, NULL, 1),
(506, 174, 1, NULL, NULL, 0),
(526, 183, 1, NULL, NULL, 0),
(527, 183, 3, NULL, NULL, 0),
(533, 187, 1, NULL, NULL, 0),
(534, 187, 2, NULL, NULL, 1),
(535, 188, 1, NULL, NULL, 0),
(536, 188, 3, NULL, NULL, 1),
(537, 189, 1, NULL, NULL, 0),
(538, 189, 2, NULL, NULL, 1),
(539, 190, 1, NULL, NULL, 0),
(540, 190, 2, NULL, NULL, 1),
(541, 191, 1, NULL, NULL, 0),
(542, 192, 1, NULL, NULL, 0),
(543, 192, 3, NULL, NULL, 0),
(544, 193, 1, NULL, NULL, 0),
(545, 193, 2, NULL, NULL, 1),
(556, 197, 1, NULL, NULL, 0),
(557, 197, 2, NULL, NULL, 1),
(558, 197, 3, NULL, NULL, 0),
(559, 198, 1, NULL, NULL, 0),
(560, 198, 2, NULL, NULL, 1),
(561, 198, 3, NULL, NULL, 1),
(562, 198, 9, NULL, NULL, 0),
(563, 199, 1, NULL, NULL, 0),
(564, 199, 2, NULL, NULL, 1),
(565, 199, 3, NULL, NULL, 0),
(568, 201, 1, NULL, NULL, 0),
(569, 201, 2, NULL, NULL, 1),
(570, 201, 16, NULL, NULL, 0),
(595, 204, 1, NULL, NULL, 0),
(596, 204, 3, NULL, NULL, 0),
(599, 206, 1, NULL, NULL, 0),
(600, 206, 3, NULL, NULL, 0),
(601, 207, 1, NULL, NULL, 0),
(602, 207, 3, NULL, NULL, 0),
(603, 208, 1, NULL, NULL, 0),
(604, 208, 3, NULL, NULL, 0),
(605, 209, 1, NULL, NULL, 0),
(606, 209, 3, NULL, NULL, 0),
(607, 210, 1, NULL, NULL, 0),
(608, 210, 3, NULL, NULL, 0),
(609, 211, 1, NULL, NULL, 0),
(610, 211, 3, NULL, NULL, 0),
(611, 212, 1, NULL, NULL, 0),
(612, 212, 3, NULL, NULL, 0),
(613, 213, 1, NULL, NULL, 0),
(614, 213, 2, NULL, NULL, 1);

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
(2, 'price_per_night_for_2_and_more_nights', 120, NULL, NULL),
(3, 'percent_reduced_week', 10, '2024-11-12 16:46:49', '2024-11-12 16:46:49');

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
  `res_payed` decimal(8,2) NOT NULL DEFAULT 0.00,
  `payed` decimal(11,2) NOT NULL DEFAULT 0.00,
  `card_fees` decimal(11,2) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `res_comment` varchar(510) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `start_date`, `end_date`, `nights`, `user_id`, `res_price`, `res_payed`, `payed`, `card_fees`, `status`, `created_at`, `updated_at`, `res_comment`) VALUES
(36, '2024-12-06', '2024-12-08', 2, 1, 283.00, 0.00, 0.00, NULL, 'pending', '2024-10-08 07:58:28', '2024-10-08 14:18:18', 'qsd'),
(37, '2024-11-29', '2024-12-01', 2, 1, 283.00, 0.00, 0.00, NULL, 'pending', '2024-10-08 08:03:30', '2024-10-08 08:03:30', 'wxc\r\n\r\ncvxb'),
(39, '2024-12-18', '2024-12-20', 2, 1, 268.50, 0.00, 0.00, NULL, 'pending', '2024-10-08 08:05:49', '2024-10-08 08:05:49', NULL),
(40, '2024-12-23', '2024-12-25', 2, 1, 283.00, 0.00, 0.00, NULL, 'pending', '2024-10-08 08:07:50', '2024-10-08 08:07:50', NULL),
(41, '2024-12-26', '2024-12-28', 2, 1, 297.00, 0.00, 0.00, NULL, 'pending', '2024-10-08 08:08:58', '2024-10-08 08:08:58', NULL),
(42, '2024-12-16', '2024-12-18', 2, 1, 297.00, 0.00, 0.00, NULL, 'pending', '2024-10-08 08:09:14', '2024-10-08 08:09:14', NULL),
(44, '2024-12-02', '2024-12-04', 2, 1, 283.00, 0.00, 0.00, NULL, 'pending', '2024-10-08 08:16:52', '2024-10-08 08:16:52', NULL),
(45, '2024-12-20', '2024-12-22', 2, 1, 283.00, 0.00, 0.00, NULL, 'pending', '2024-10-08 08:18:09', '2024-10-08 08:18:09', NULL),
(46, '2024-12-30', '2025-01-02', 3, 1, 417.50, 0.00, 0.00, NULL, 'pending', '2024-10-08 08:18:30', '2024-10-08 12:26:34', 'azes'),
(47, '2025-01-15', '2025-01-16', 1, 1, 174.50, 0.00, 0.00, NULL, 'pending', '2024-10-08 08:19:52', '2024-10-08 14:26:11', 'qsd\r\n\r\nwsqd'),
(48, '2025-01-08', '2025-01-09', 1, 1, 188.50, 0.00, 0.00, NULL, 'pending', '2024-10-08 08:28:56', '2024-10-08 08:28:56', NULL),
(49, '2025-01-22', '2025-01-23', 1, 1, 188.50, 0.00, 0.00, NULL, 'pending', '2024-10-08 08:29:28', '2024-10-08 08:29:28', NULL),
(50, '2025-01-02', '2025-01-04', 2, 1, 283.00, 0.00, 0.00, NULL, 'pending', '2024-10-08 08:43:00', '2024-10-08 08:43:00', 'qsd\r\n\r\nwxc\r\nwxcgfdsf'),
(52, '2024-12-28', '2024-12-30', 2, 1, 282.50, 0.00, 0.00, NULL, 'pending', '2024-10-08 08:49:53', '2024-10-08 08:49:53', 'wxc'),
(55, '2025-01-24', '2025-01-25', 1, 1, 160.00, 0.00, 0.00, NULL, 'pending', '2024-10-08 12:20:22', '2024-10-08 12:20:22', NULL),
(56, '2025-01-09', '2025-01-10', 1, 1, 188.50, 0.00, 0.00, NULL, 'pending', '2024-10-08 12:25:11', '2024-10-08 12:25:11', 'aze'),
(57, '2024-12-25', '2024-12-26', 1, 1, 174.50, 0.00, 0.00, NULL, 'pending', '2024-10-08 14:07:49', '2024-10-08 14:07:49', NULL),
(58, '2025-01-29', '2025-01-30', 1, 1, 188.50, 0.00, 0.00, NULL, 'pending', '2024-10-08 14:08:41', '2024-10-08 14:08:41', NULL),
(59, '2025-01-20', '2025-01-22', 2, 1, 269.00, 0.00, 0.00, NULL, 'pending', '2024-10-08 14:21:41', '2024-10-08 14:22:58', NULL),
(62, '2025-02-04', '2025-02-12', 8, 3, 1086.50, 0.00, 0.00, NULL, 'pending', '2024-10-09 14:16:15', '2024-10-09 14:16:15', 'wxc'),
(63, '2025-02-01', '2025-02-04', 3, 1, 403.50, 0.00, 0.00, NULL, 'pending', '2024-10-09 14:20:05', '2024-10-09 14:20:05', 'wxc'),
(64, '2025-02-12', '2025-02-14', 2, 1, 268.00, 0.00, 0.00, NULL, 'pending', '2024-10-09 14:20:36', '2024-10-09 14:20:36', 'i'),
(67, '2025-01-04', '2025-01-08', 4, 5, 552.00, 0.00, 0.00, NULL, 'pending', '2024-10-09 16:12:26', '2024-10-09 16:12:26', 'qsd\r\n\r\nIs here !'),
(71, '2025-01-10', '2025-01-15', 5, 1, 742.50, 0.00, 0.00, NULL, 'pending', '2024-10-10 09:04:32', '2024-10-10 09:04:32', 'dd'),
(72, '2025-02-14', '2025-02-15', 1, 1, 174.50, 0.00, 0.00, NULL, 'pending', '2024-10-10 09:13:18', '2024-10-10 09:13:18', NULL),
(73, '2025-01-16', '2025-01-17', 1, 1, 174.00, 0.00, 0.00, NULL, 'pending', '2024-10-10 10:05:41', '2024-10-10 10:05:41', NULL),
(100, '2024-11-19', '2024-11-21', 2, 3, 314.32, 0.00, 0.00, NULL, 'pending', '2024-10-22 15:03:32', '2024-10-22 15:03:32', NULL),
(101, '2024-11-28', '2024-11-29', 1, 3, 190.16, 0.00, 0.00, NULL, 'pending', '2024-10-22 15:04:43', '2024-10-22 15:04:43', NULL),
(104, '2025-02-18', '2025-02-20', 2, 3, 314.32, 0.00, 0.00, NULL, 'pending', '2024-10-22 15:12:38', '2024-10-22 15:12:38', 'qsd'),
(106, '2025-01-23', '2025-01-24', 1, 1, 190.16, 0.00, 0.00, NULL, 'pending', '2024-10-22 17:44:09', '2024-10-22 17:44:09', 'aze'),
(107, '2025-01-31', '2025-02-01', 1, 1, 248.16, 0.00, 0.00, NULL, 'pending', '2024-10-22 17:44:58', '2024-10-22 17:44:58', 'aze'),
(109, '2025-02-20', '2025-02-21', 1, 1, 190.16, 0.00, 0.00, NULL, 'pending', '2024-10-22 17:48:42', '2024-10-22 17:48:42', NULL),
(146, '2024-11-22', '2024-11-23', 1, 118, 160.00, 0.00, 0.00, NULL, 'pending', '2024-11-11 20:17:49', '2024-11-11 20:17:49', NULL),
(147, '2025-02-21', '2025-02-28', 7, 118, 907.50, 0.00, 0.00, NULL, 'pending', '2024-11-12 15:47:33', '2024-11-12 15:50:53', NULL),
(149, '2024-11-21', '2024-11-22', 1, 118, 158.50, 0.00, 0.00, NULL, 'pending', '2024-11-18 20:52:36', '2024-11-18 20:52:36', NULL),
(150, '2024-11-23', '2024-11-25', 1, 1, 160.00, 0.00, 0.00, NULL, 'pending', '2024-11-18 20:53:13', '2024-11-18 20:53:13', 'aze'),
(151, '2025-01-17', '2025-01-19', 2, 118, 240.00, 0.00, 0.00, NULL, 'pending', '2024-11-19 13:52:12', '2024-11-19 13:52:12', 'hjk'),
(152, '2025-01-25', '2025-01-27', 2, 118, 240.00, 0.00, 0.00, NULL, 'pending', '2024-11-19 13:54:00', '2024-11-19 13:54:00', ',;'),
(155, '2025-03-20', '2025-03-21', 1, 118, 172.50, 0.00, 0.00, NULL, 'pending', '2024-11-19 16:03:03', '2024-11-19 16:27:05', 'qsdqs'),
(158, '2025-03-13', '2025-03-15', 2, 118, 285.00, 0.00, 0.00, NULL, 'pending', '2024-11-19 16:12:02', '2024-11-19 16:12:02', 'qsdc'),
(159, '2025-03-10', '2025-03-12', 2, 118, 273.00, 0.00, 0.00, NULL, 'pending', '2024-11-19 16:13:35', '2024-11-19 16:13:35', 'wxc'),
(160, '2025-01-30', '2025-01-31', 1, 118, 234.00, 0.00, 0.00, NULL, 'pending', '2024-11-19 16:16:39', '2024-11-19 16:16:39', 'q'),
(161, '2025-03-04', '2025-03-06', 2, 118, 273.00, 0.00, 0.00, NULL, 'pending', '2024-11-19 16:20:45', '2024-11-19 16:20:45', 'k;'),
(163, '2024-11-25', '2024-11-26', 1, 118, 122.30, 0.00, 0.00, NULL, 'pending', '2024-11-25 21:54:03', '2024-11-25 21:54:03', 'qsdc'),
(167, '2024-11-27', '2024-11-28', 1, 118, 122.30, 0.00, 0.00, NULL, 'pending', '2024-11-27 13:33:28', '2024-11-27 13:33:28', 'qs'),
(174, '2025-04-22', '2025-05-02', 10, 118, 1116.00, 0.00, 0.00, NULL, 'pending', '2024-11-29 09:53:20', '2024-11-29 09:53:20', NULL),
(183, '2024-12-01', '2024-12-02', 1, 118, 174.50, 0.00, 177.50, 3.00, 'pending', '2024-12-01 12:32:11', '2024-12-01 12:32:11', NULL),
(187, '2025-01-19', '2025-01-20', 1, 118, 174.00, 0.00, 0.00, NULL, 'pending', '2024-12-01 21:28:15', '2024-12-01 21:28:15', NULL),
(188, '2025-02-15', '2025-02-16', 1, 118, 174.50, 0.00, 0.00, NULL, 'pending', '2024-12-01 21:29:05', '2024-12-01 21:29:05', 'c'),
(189, '2025-02-17', '2025-02-18', 1, 118, 158.00, 0.00, 0.00, NULL, 'pending', '2024-12-01 21:36:57', '2024-12-01 21:36:57', NULL),
(190, '2025-01-28', '2025-01-29', 1, 118, 158.00, 0.00, 161.00, 3.00, 'pending', '2024-12-01 21:55:25', '2024-12-01 21:55:25', 'cs'),
(191, '2025-01-27', '2025-01-28', 1, 118, 144.00, 0.00, 0.00, NULL, 'pending', '2024-12-01 21:56:46', '2024-12-01 21:56:46', NULL),
(192, '2025-03-06', '2025-03-07', 1, 118, 158.50, 0.00, 0.00, NULL, 'pending', '2024-12-01 21:57:03', '2024-12-01 21:57:03', NULL),
(193, '2025-02-28', '2025-03-01', 1, 118, 174.00, 0.00, 177.00, 3.00, 'pending', '2024-12-01 21:57:27', '2024-12-01 21:57:27', NULL),
(197, '2024-12-11', '2024-12-13', 2, 118, 258.50, 0.00, 262.50, 4.00, 'pending', '2024-12-02 11:49:45', '2024-12-02 11:49:45', NULL),
(198, '2024-12-13', '2024-12-15', 2, 118, 297.00, 0.00, 302.00, 5.00, 'pending', '2024-12-02 11:51:56', '2024-12-02 11:51:56', 'qsd'),
(199, '2024-12-10', '2024-12-11', 1, 118, 172.50, 0.00, 175.50, 3.00, 'pending', '2024-12-02 12:03:25', '2024-12-02 12:03:25', NULL),
(201, '2024-12-15', '2024-12-16', 1, 118, 123.80, 0.00, 125.80, 2.00, 'pending', '2024-12-02 12:05:21', '2024-12-02 12:05:21', NULL),
(204, '2025-03-07', '2025-03-08', 1, 118, 174.50, 0.00, 177.50, 3.00, 'pending', '2024-12-03 10:21:29', '2024-12-03 10:21:29', NULL),
(206, '2024-12-05', '2024-12-06', 1, 118, 814.50, 814.50, 827.50, 13.00, 'pending', '2024-12-03 14:13:27', '2024-12-03 14:13:27', NULL),
(207, '2024-12-22', '2024-12-23', 1, 118, 174.50, 174.50, 177.50, 3.00, 'pending', '2024-12-03 15:38:38', '2024-12-03 15:38:38', NULL),
(208, '2025-02-16', '2025-02-17', 1, 118, 174.50, 175.00, 177.50, 3.00, 'pending', '2024-12-03 15:53:07', '2024-12-03 15:53:07', NULL),
(209, '2024-12-04', '2024-12-05', 1, 118, 158.50, 159.00, 162.00, 3.00, 'pending', '2024-12-03 15:58:25', '2024-12-03 15:58:25', NULL),
(210, '2024-12-08', '2024-12-09', 1, 118, 174.50, 174.50, 177.50, 3.00, 'pending', '2024-12-03 15:59:51', '2024-12-03 15:59:51', NULL),
(211, '2024-12-09', '2024-12-10', 1, 118, 158.50, 158.50, 160.87, 2.38, 'pending', '2024-12-03 16:01:34', '2024-12-03 16:01:34', NULL),
(212, '2025-03-01', '2025-03-02', 1, 118, 174.50, 174.50, 177.50, 3.00, 'pending', '2024-12-03 16:03:22', '2024-12-03 16:03:22', NULL),
(213, '2025-03-19', '2025-03-20', 1, 118, 158.00, 158.00, 161.00, 3.00, 'pending', '2024-12-03 16:29:43', '2024-12-03 16:29:43', NULL);

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
('PJOqXu1cDAQbKSniGOKi22HBLzuox8vNOH73boLd', 118, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiemk1UGNFSjUzd3ZMcWtiSDNST08zMnAxSXJQMzNUUjBTMzlGbzZESyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTE4O3M6NjoiX2ZsYXNoIjthOjI6e3M6MzoibmV3IjthOjA6e31zOjM6Im9sZCI7YTowOnt9fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvcHJvZmlsIjt9czoxNjoib3JpZ2luYWxfb3B0aW9ucyI7czo1ODM6Ilt7ImlkIjoxLCJuYW1lIjoiSmFjY3V6aSIsImRlc2NyaXB0aW9uIjoiUXVvaSBkZSBtaWV1eCBxdSd1biBqYWNjdXppIHBvdXIgcHJvZml0ZXIgZGUgbGEgdnVlIGV4Y2VwdGlvbm5lbGxlID8iLCJwcmljZSI6IjAuMDAiLCJhdmFpbGFibGUiOjEsImNyZWF0ZWRfYXQiOiIyMDI0LTEwLTA2VDEzOjUyOjUxLjAwMDAwMFoiLCJ1cGRhdGVkX2F0IjoiMjAyNC0xMS0xOFQyMzo0MjoyMi4wMDAwMDBaIiwicHJlc2VsZWN0ZWQiOjEsImJ5X2RheV9kaXNwbGF5IjowLCJieV9kYXkiOmZhbHNlLCJieV9kYXlfcHJlc2VsZWN0ZWQiOjB9LHsiaWQiOjIsIm5hbWUiOiJQZXRpdC1kw6lqZXVuZXIiLCJkZXNjcmlwdGlvbiI6IlBldGl0IGTDqWpldW7DqSBjb21wbGV0IHBvdXIgZGV1eCBwZXJzb25uZXMuIiwicHJpY2UiOiIxNC4wMCIsImF2YWlsYWJsZSI6MSwiY3JlYXRlZF9hdCI6IjIwMjQtMTAtMDZUMTQ6MDc6MTAuMDAwMDAwWiIsInVwZGF0ZWRfYXQiOiIyMDI0LTEwLTMwVDE5OjE2OjE0LjAwMDAwMFoiLCJwcmVzZWxlY3RlZCI6MCwiYnlfZGF5X2Rpc3BsYXkiOjEsImJ5X2RheSI6dHJ1ZSwiYnlfZGF5X3ByZXNlbGVjdGVkIjoxfV0iO30=', 1733243407);

-- --------------------------------------------------------

--
-- Table structure for table `specials_dates_prices`
--

CREATE TABLE `specials_dates_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `spe_date` date NOT NULL,
  `spe_price` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specials_dates_prices`
--

INSERT INTO `specials_dates_prices` (`id`, `spe_date`, `spe_price`, `created_at`, `updated_at`) VALUES
(6, '2024-11-06', 2.00, '2024-11-13 12:54:57', '2024-11-13 12:54:57'),
(7, '2024-11-06', 2.00, '2024-11-13 12:54:59', '2024-11-13 12:54:59'),
(8, '2024-11-06', 2.00, '2024-11-13 12:55:00', '2024-11-13 12:55:00'),
(10, '2024-10-08', 50.00, '2024-11-13 13:03:44', '2024-11-13 13:03:44'),
(15, '2024-11-06', 10.00, '2024-11-13 13:13:00', '2024-11-13 13:13:00'),
(16, '2024-11-05', 20.00, '2024-11-13 13:13:04', '2024-11-13 13:13:04'),
(43, '2024-11-28', 50.00, '2024-11-16 15:56:40', '2024-11-16 15:56:40'),
(45, '2024-12-02', 101.00, '2024-11-16 15:58:13', '2024-11-16 18:10:17'),
(46, '2024-11-18', 150.00, '2024-11-16 15:58:26', '2024-11-17 14:06:35'),
(47, '2024-12-29', 5896.99, '2024-11-17 17:55:22', '2024-11-17 17:55:22'),
(48, '2024-12-07', 500.00, '2024-11-17 19:05:19', '2024-11-17 19:05:19'),
(49, '2024-12-20', 60.00, '2024-11-17 19:05:26', '2024-11-17 19:05:26'),
(50, '2024-12-31', 321.00, '2024-11-17 19:05:37', '2024-11-19 17:19:07'),
(51, '2025-01-30', 220.00, '2024-11-17 19:05:53', '2024-11-17 19:05:53'),
(53, '2024-12-18', 500.00, '2024-11-17 19:09:20', '2024-11-17 19:09:20'),
(54, '2024-12-05', 800.00, '2024-11-17 19:09:45', '2024-11-17 19:09:45'),
(55, '2024-11-01', 100.00, '2024-11-17 19:09:54', '2024-11-17 19:09:54'),
(56, '2024-12-24', 500.00, '2024-11-17 19:10:06', '2024-11-17 19:10:06'),
(57, '2024-12-26', 500.00, '2024-11-18 23:42:48', '2024-11-18 23:42:48'),
(58, '2024-11-27', 2.00, '2024-11-19 17:19:11', '2024-11-19 17:19:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
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

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `email_verified_at`, `last_login`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `phone`, `picture`, `deleted_at`, `name2`) VALUES
(1, 'Aze', 'aze@aze.aze', NULL, '2024-10-30 11:31:30', '2024-12-03 10:02:52', '$2y$12$T6ZelGPfKrEE.YgSagM3dO/qpl7Cxfp1L5K0N1QcUK6M.V9qu.4rW', 'n7v7jKs0mWrsKMjVVud0fq9cmHAbWAraclQIJzSlcLJykX5BI99xPtc1kEWf', '2024-10-05 20:22:04', '2024-12-03 10:02:52', 'user', '0615166554', 'Hlf5WiAWVn9i6M4GBHmjxSjCa3E4F75wecRR981d.jpg', NULL, 'Aze2'),
(3, 'M&C', 'moelleux@gmail.com', NULL, '2024-10-30 11:31:30', '2024-12-03 10:04:42', '$2y$12$iK1zEjzRsfHbCOqKA9bXQ.vNFUWSqJkAYF9juzErAOyX5CqBed8Bq', 'uiOatWulXQlqkKJxgFwJjYi5XLUfgmGbA8cfhq0VjJUIoJfHDo2mK1V8otFc', '2024-10-05 20:33:26', '2024-12-03 10:04:42', 'admin', '0615166111', 'KxiNvAQgx6mlwXPGXgFIAZV5sHXHFJ4AdtG58Uh7.jpg', NULL, NULL),
(5, 'qsd qsd', 'qsd@qsd.qsd', NULL, '2024-10-30 11:31:30', '2024-11-17 14:40:51', '$2y$12$2R0xusPIvj9a7Esh.bguE.lNI9.MMpBkdHmrOwdSgCNR.fnId3C6C', NULL, '2024-10-09 16:09:05', '2024-11-17 14:40:51', 'user', '0615161237', 'FHaWkjuEGAcK7FXiauAzukMc473tBXDxViur61Na.jpg', NULL, 'qsd2'),
(8, 'Fake Admin', 'fake_admin@fake.admin', NULL, '2024-10-30 11:31:30', '2024-11-17 14:14:28', '$2y$12$QA0al68Mu7DBj9HqIPfSbO/Y0X9EOzk/Pv04t/fdjy9HLRzYM.Z26', NULL, '2024-10-15 15:23:14', '2024-11-17 14:14:28', 'fake_admin', NULL, 've4ED3XV5g4CSUX5Xh6m8OFN8q5YmzmdGRLnE9LC.jpg', NULL, NULL),
(110, NULL, 'qsd@qsd.qsdqsdd', NULL, NULL, NULL, '$2y$12$Im9./so9Awa8rPWGR1J4v.VEliHStmJxeGJ65DiPlzQvb6r.Mh0Z2', NULL, '2024-11-10 15:42:36', '2024-11-10 15:42:36', 'user', '0555555555', 'default_user.png', NULL, NULL),
(118, 'Léo RIPERT', 'leo.ripert0@gmail.com', '114392890091919744308', '2024-11-11 20:17:24', '2024-12-03 14:07:28', '$2y$12$fabWt3IC83jeZEPDWQ7Zr.b1ydVvVpThqXxQBhUcKWfErcI5KK/W.', NULL, '2024-11-11 20:17:24', '2024-12-03 14:07:28', 'user', '0554665468', 'Hoq8RAgaH9P3YN2V9Or4nLhIe0A2j7dK52yZKgfp.jpg', NULL, NULL),
(119, NULL, 'xcv@xcv.xcv', NULL, NULL, NULL, '$2y$12$5XKXFaVTkIiDu/77Dw84Le0WLLesDQwgMmlgweqPy3ZYHSBVPJnLu', NULL, '2024-11-18 20:51:47', '2024-11-18 20:51:47', 'user', NULL, 'default_user.png', NULL, NULL),
(120, NULL, 'aze@aze.azee', NULL, NULL, '2024-11-18 22:08:39', '$2y$12$b.EL5eE51uE65bmMsnrpSey2OL87nBZKCbudrn/IJB11xvzWS6abu', NULL, '2024-11-18 22:06:51', '2024-11-18 22:08:39', 'user', NULL, 'default_user.png', NULL, NULL),
(121, NULL, 'wxc@xc.wxc', NULL, NULL, NULL, '$2y$12$xTM8b6t.vVUOV2mkwcfAzOvRpJavudj9uZrW99CkhSLy7TRnxygci', NULL, '2024-11-18 22:11:59', '2024-11-18 22:11:59', 'user', NULL, 'default_user.png', NULL, NULL),
(122, NULL, 'wxc@xc.wxcc', NULL, NULL, NULL, '$2y$12$k77q9ORIUVRffxbe5/dkBOSA2zMCHvR8DQVWoUqoRgNw6FD8AfLo2', NULL, '2024-11-18 22:12:36', '2024-11-18 22:12:36', 'user', NULL, 'default_user.png', NULL, NULL),
(123, NULL, 'xcv@xcv.xcvv', NULL, NULL, NULL, '$2y$12$5Aber4giP4oZ7aGXzpEOK.35xn9ER3.P.LEPNbvszWooDXl2OJ1Lu', NULL, '2024-11-18 22:13:22', '2024-11-18 22:13:22', 'user', NULL, 'default_user.png', NULL, NULL),
(124, NULL, 'wxc@xc.wxcw', NULL, NULL, NULL, '$2y$12$y8H2vV3jfKuzhqlCgEP3w.uHd5Id9qLlfGxJitZED46u6hPzx/TsC', NULL, '2024-11-18 22:14:39', '2024-11-18 22:14:39', 'user', NULL, 'default_user.png', NULL, NULL),
(125, NULL, 'qsd@qsd.qsddd_soft_deleted_26591', NULL, NULL, NULL, '$2y$12$Iwtasp263.ex1m56a43KYuzkBqd/GkmtbtQuUcZRMqFDZrayQ.pdm', NULL, '2024-11-18 22:16:09', '2024-11-18 23:44:32', 'user', NULL, 'default_user.png', '2024-11-19 00:44:32', NULL),
(126, NULL, 'wxc@xc.wxcxx_soft_deleted_95150', NULL, NULL, NULL, '$2y$12$stCo1pEHKXohDoy/XQ2Pv.8TonxM2tMk7Lj.ZXjdGOIuCj.5FMWxC', NULL, '2024-11-18 22:19:04', '2024-11-18 23:44:20', 'user', NULL, 'default_user.png', '2024-11-19 00:44:20', NULL),
(127, NULL, 'wxc@xc.wxcs_soft_deleted_57841', NULL, NULL, NULL, '$2y$12$uEF7gzSLxU8S9vrk1vcSGOCx9mA3YWylXKkdZok0yHw9ELQzJyQg2', NULL, '2024-11-18 22:24:15', '2024-11-18 23:44:10', 'user', NULL, 'default_user.png', '2024-11-19 00:44:10', NULL),
(128, NULL, 'qsd@qsd.qsds', NULL, '2024-10-30 11:31:30', '2024-11-18 23:31:32', '$2y$12$xF6LDkItJHGrqsszFYqdW.tTDBxitOOpFtC.ZjkZutfJu2hoo6E4G', NULL, '2024-11-18 23:30:57', '2024-11-18 23:31:32', 'user', NULL, 'default_user.png', NULL, NULL),
(137, 'Léo RIPERT', 'leo.ripert@gmail.com_soft_deleted_49008', '106862800151048659852_soft_deleted_78862', '2024-12-03 09:30:51', NULL, '$2y$12$SJ0BPryd.YdMkF48hWZjUuffFH72BExEa5037yynf88Rwn4hXc4o.', NULL, '2024-12-03 09:30:51', '2024-12-03 09:39:37', 'user', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocIW3cUBAEhHpYVWwej7N8qrD2wPpcZoPYC2QrA8dmo1zi-w6rlb=s96-c', '2024-12-03 10:39:37', NULL),
(138, 'Léo RIPERT', 'leo.ripert@gmail.com', '106862800151048659852', '2024-12-03 09:39:46', NULL, '$2y$12$k6sj54TK/fv8pIXjhSYznO8hw0Y81ltwFCeL/P.EsDpjr5wU.ZRY6', NULL, '2024-12-03 09:39:46', '2024-12-03 09:39:46', 'user', NULL, 'https://lh3.googleusercontent.com/a/ACg8ocIW3cUBAEhHpYVWwej7N8qrD2wPpcZoPYC2QrA8dmo1zi-w6rlb=s96-c', NULL, NULL);

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
-- Indexes for table `specials_dates_prices`
--
ALTER TABLE `specials_dates_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_comments`
--
ALTER TABLE `admin_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `option_reservation`
--
ALTER TABLE `option_reservation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=615;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `specials_dates_prices`
--
ALTER TABLE `specials_dates_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

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
