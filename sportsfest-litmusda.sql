-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 07:54 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportsfest-litmusda`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `number` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active_portion` varchar(255) DEFAULT NULL,
  `called_at` timestamp NULL DEFAULT NULL,
  `pinged_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `number`, `name`, `avatar`, `username`, `password`, `active_portion`, `called_at`, `pinged_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'SUPER USER', 'no-avatar.jpg', 'admin', 'admin', NULL, NULL, NULL, '2023-02-19 07:36:32', '2023-05-28 00:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `arrangements`
--

CREATE TABLE `arrangements` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `team_id` tinyint(3) UNSIGNED NOT NULL,
  `order` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `competition_id` tinyint(3) UNSIGNED NOT NULL,
  `slug` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `competition_id`, `slug`, `title`, `created_at`, `updated_at`) VALUES
(1, 1, 'ball', 'Ball Games', '2023-02-19 06:33:56', '2023-02-19 06:33:56'),
(2, 1, 'board', 'Board Games', '2023-02-19 06:34:11', '2023-02-19 06:34:11'),
(3, 1, 'athletics', 'Athletics', '2024-04-05 01:43:57', '2024-04-05 02:02:47'),
(4, 1, 'e-games', 'E-Games', '2024-04-05 02:30:37', '2024-04-05 02:51:15'),
(5, 2, 'literary', 'Literary Competitions', '2023-02-19 06:38:21', '2024-04-05 02:51:56'),
(6, 2, 'music', 'Music Competitions', '2023-02-19 06:38:38', '2024-04-05 02:51:52'),
(7, 2, 'dance', 'Dance Competitions', '2023-02-19 06:40:04', '2024-04-05 02:51:49');

-- --------------------------------------------------------

--
-- Table structure for table `competitions`
--

CREATE TABLE `competitions` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `slug` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `competitions`
--

INSERT INTO `competitions` (`id`, `slug`, `title`, `created_at`, `updated_at`) VALUES
(1, 'sports', 'Sports', '2023-02-19 06:14:39', '2023-02-19 06:40:47'),
(2, 'litmusda', 'Literary, Music, and Dance', '2023-02-19 06:14:39', '2023-02-19 06:14:59');

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `event_id`, `title`, `percentage`, `created_at`, `updated_at`) VALUES
(1, 1, 'Rating', 100, '2024-04-04 07:21:15', '2024-04-04 07:21:15'),
(2, 2, 'Rating', 100, '2024-04-04 07:21:47', '2024-04-04 07:21:47'),
(3, 5, 'Rating', 100, '2024-04-04 07:21:58', '2024-04-04 07:21:58'),
(4, 4, 'Rating', 100, '2024-04-04 07:22:09', '2024-04-04 07:22:09'),
(5, 3, 'Rating', 100, '2024-04-04 07:22:25', '2024-04-04 07:22:25'),
(6, 9, 'Rating', 100, '2024-04-04 07:22:53', '2024-04-04 07:22:53'),
(7, 6, 'Rating', 100, '2024-04-04 07:23:11', '2024-04-04 07:23:11'),
(8, 7, 'Rating', 100, '2024-04-04 07:23:24', '2024-04-04 07:23:24'),
(9, 13, 'Content', 40, '2024-04-05 01:15:42', '2024-04-05 01:15:42'),
(10, 13, 'Delivery', 30, '2024-04-05 01:15:51', '2024-04-05 01:15:51'),
(11, 13, 'Voice', 20, '2024-04-05 01:16:02', '2024-04-05 01:16:02'),
(12, 13, 'Personality', 10, '2024-04-05 01:16:13', '2024-04-05 01:16:13'),
(13, 15, 'Nilalaman', 30, '2024-04-05 01:16:48', '2024-04-05 01:16:48'),
(14, 15, 'Paraan ng Pagbigkas', 20, '2024-04-05 01:17:02', '2024-04-05 01:17:02'),
(15, 15, 'Interpretasyon', 20, '2024-04-05 01:17:17', '2024-04-05 01:17:17'),
(16, 15, 'Kaangkupan ng Kilos o Galaw', 20, '2024-04-05 01:17:34', '2024-04-05 01:17:34'),
(17, 15, 'Kasuotan at Props', 10, '2024-04-05 01:17:53', '2024-04-05 01:17:53'),
(18, 14, 'Speech Content', 40, '2024-04-05 01:18:19', '2024-04-05 01:18:19'),
(19, 14, 'Poise & Delivery', 30, '2024-04-05 01:18:30', '2024-04-05 01:18:30'),
(20, 14, 'Voice Quality', 20, '2024-04-05 01:18:42', '2024-04-05 01:18:42'),
(21, 14, 'Time', 5, '2024-04-05 01:18:49', '2024-04-05 01:18:49'),
(22, 14, 'Audience Response', 5, '2024-04-05 01:19:04', '2024-04-05 01:19:04'),
(23, 16, 'Tone Quality', 40, '2024-04-05 01:19:27', '2024-04-05 01:19:27'),
(24, 16, 'Interpretation, Delivery, Dynamics', 40, '2024-04-05 01:19:47', '2024-04-05 01:19:47'),
(25, 16, 'Stage Presence', 20, '2024-04-05 01:20:05', '2024-04-05 01:20:05'),
(26, 17, 'Tone Quality', 40, '2024-04-05 01:20:25', '2024-04-05 01:20:25'),
(27, 17, 'Interpretation, Delivery, Dynamics', 40, '2024-04-05 01:20:43', '2024-04-05 01:20:43'),
(28, 17, 'Stage Presence', 20, '2024-04-05 01:20:56', '2024-04-05 01:20:56'),
(29, 18, 'Tone Quality', 40, '2024-04-05 01:21:15', '2024-04-05 01:21:15'),
(30, 18, 'Blending and Interpretation/Counterpoint', 40, '2024-04-05 01:21:38', '2024-04-05 01:21:38'),
(31, 18, 'Stage Presence', 20, '2024-04-05 01:21:50', '2024-04-05 01:21:50'),
(32, 19, 'Performance', 30, '2024-04-05 01:23:00', '2024-04-05 01:23:00'),
(33, 19, 'Choreography and Originality', 20, '2024-04-05 01:23:17', '2024-04-05 01:23:17'),
(34, 19, 'Technique/Style', 20, '2024-04-05 01:23:31', '2024-04-05 01:23:31'),
(35, 19, 'Rhythm and Timing', 20, '2024-04-05 01:23:49', '2024-04-05 01:23:49'),
(36, 19, 'Costume', 10, '2024-04-05 01:23:58', '2024-04-05 01:23:58'),
(42, 10, 'Rating', 100, '2024-04-05 01:45:41', '2024-04-05 01:45:41'),
(43, 11, 'Rating', 100, '2024-04-05 02:41:03', '2024-04-05 02:41:03'),
(44, 12, 'Rating', 100, '2024-04-05 02:41:19', '2024-04-05 02:41:19'),
(45, 22, 'Adherence to the theme', 20, '2024-04-05 05:25:57', '2024-04-05 05:25:57'),
(46, 22, 'Technical Skills', 30, '2024-04-05 05:26:12', '2024-04-05 05:26:12'),
(47, 22, 'Routine', 25, '2024-04-05 05:26:24', '2024-04-05 05:26:24'),
(48, 22, 'Cheer and Yells', 15, '2024-04-05 05:26:40', '2024-04-05 05:26:40'),
(49, 22, 'Overall Impression', 10, '2024-04-05 05:27:05', '2024-04-05 05:27:05');

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `technical_id` tinyint(3) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `team_id` tinyint(3) UNSIGNED NOT NULL,
  `value` float UNSIGNED NOT NULL DEFAULT 0,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eliminations`
--

CREATE TABLE `eliminations` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `team_id` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `category_id` tinyint(3) UNSIGNED NOT NULL,
  `slug` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `category_id`, `slug`, `title`, `created_at`, `updated_at`) VALUES
(1, 1, 'basketball', 'Basketball', '2024-04-04 07:10:38', '2024-04-05 02:28:22'),
(2, 1, 'volleyball', 'Volleyball', '2024-04-04 07:11:31', '2024-04-05 02:28:27'),
(3, 1, 'sepak-takraw', 'Sepak Takraw', '2024-04-04 07:12:14', '2024-04-05 02:34:56'),
(4, 1, 'badminton', 'Badminton', '2024-04-04 07:12:02', '2024-04-05 02:35:05'),
(5, 1, 'table-tennis', 'Table Tennis', '2024-04-04 07:11:45', '2024-04-05 02:35:14'),
(6, 2, 'chess', 'Chess', '2024-04-04 07:12:27', '2024-04-05 02:35:41'),
(7, 2, 'word-factory', 'Word Factory', '2024-04-04 07:13:44', '2024-04-05 02:37:01'),
(9, 2, 'games-of-the-general', 'Games of the General', '2024-04-04 07:13:28', '2024-04-05 02:50:01'),
(10, 3, 'athletics', 'Athletics', '2024-04-05 01:44:38', '2024-04-05 02:50:10'),
(11, 4, 'mobile-legends-a', 'Mobile Legends (Category A)', '2024-04-05 02:31:07', '2024-04-05 02:50:42'),
(12, 4, 'mobile-legends-b', 'Mobile Legends (Category B)', '2024-04-05 02:32:32', '2024-04-05 02:50:44'),
(13, 5, 'oration', 'Oration', '2023-02-21 02:05:03', '2024-04-05 02:52:46'),
(14, 5, 'extemporaneous-speaking', 'Extemporaneous Speaking', '2024-04-04 07:16:44', '2024-04-05 02:52:54'),
(15, 5, 'tigsik', 'Tigsik', '2024-04-04 07:17:01', '2024-04-05 02:53:02'),
(16, 6, 'vocal-solo-male', 'Vocal Solo Male', '2023-02-21 02:16:39', '2024-04-05 02:53:13'),
(17, 6, 'vocal-solo-female', 'Vocal Solo Female', '2023-02-21 02:16:39', '2024-04-05 02:53:18'),
(18, 6, 'vocal-duet', 'Vocal Duet', '2023-02-21 02:16:39', '2024-04-05 02:53:23'),
(19, 7, 'jazz-dance', 'Jazz Dance', '2023-02-21 02:16:39', '2024-04-05 02:53:30'),
(20, 7, 'folk-dance', 'Folk Dance', '2023-02-21 02:16:39', '2024-04-05 02:53:34'),
(22, 7, 'cheerdance', 'Cheerdance', '2024-04-05 05:23:56', '2024-04-05 05:23:56'),
(23, 2, 'scrabble', 'Scrabble', '2024-04-05 05:31:34', '2024-04-05 05:31:34');

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE `judges` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `number` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active_portion` varchar(255) DEFAULT NULL,
  `called_at` timestamp NULL DEFAULT NULL,
  `pinged_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`id`, `number`, `name`, `avatar`, `username`, `password`, `active_portion`, `called_at`, `pinged_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tabulator', 'no-avatar.jpg', 'tabulator', 'tabulator01', NULL, NULL, NULL, '2024-04-05 01:29:50', '2024-04-05 02:54:15'),
(2, 1, 'Judge 01', 'no-avatar.jpg', 'judge01', 'judge01', NULL, NULL, NULL, '2024-04-05 01:57:56', '2024-04-05 02:54:19'),
(3, 2, 'Judge 02', 'no-avatar.jpg', 'judge02', 'judge02', NULL, NULL, NULL, '2024-04-05 01:58:16', '2024-04-05 02:54:22'),
(4, 3, 'Judge 03', 'no-avatar.jpg', 'judge03', 'judge03', NULL, NULL, NULL, '2024-04-05 01:58:36', '2024-04-05 02:54:26');

-- --------------------------------------------------------

--
-- Table structure for table `judge_event`
--

CREATE TABLE `judge_event` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `judge_id` tinyint(3) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `is_chairman` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `judge_event`
--

INSERT INTO `judge_event` (`id`, `judge_id`, `event_id`, `is_chairman`, `created_at`, `updated_at`) VALUES
(1, 2, 13, 0, '2024-04-05 02:09:00', '2024-04-05 02:55:24'),
(2, 2, 16, 0, '2024-04-05 02:09:07', '2024-04-05 02:55:26'),
(3, 2, 17, 0, '2024-04-05 02:09:28', '2024-04-05 02:55:28'),
(4, 2, 18, 0, '2024-04-05 02:09:34', '2024-04-05 02:55:32'),
(5, 2, 20, 0, '2024-04-05 02:09:41', '2024-04-05 02:55:35'),
(6, 2, 19, 0, '2024-04-05 02:09:48', '2024-04-05 02:55:37'),
(7, 2, 14, 0, '2024-04-05 02:09:55', '2024-04-05 02:55:39'),
(8, 2, 15, 0, '2024-04-05 02:10:02', '2024-04-05 02:55:41'),
(10, 3, 13, 0, '2024-04-05 02:10:21', '2024-04-05 02:55:45'),
(11, 3, 16, 0, '2024-04-05 02:10:29', '2024-04-05 02:55:47'),
(12, 3, 17, 0, '2024-04-05 02:11:06', '2024-04-05 02:55:56'),
(13, 3, 18, 0, '2024-04-05 02:11:12', '2024-04-05 02:55:58'),
(14, 3, 20, 0, '2024-04-05 02:11:19', '2024-04-05 02:56:01'),
(15, 3, 19, 0, '2024-04-05 02:11:25', '2024-04-05 02:56:04'),
(16, 3, 14, 0, '2024-04-05 02:11:36', '2024-04-05 02:56:07'),
(17, 3, 15, 0, '2024-04-05 02:11:43', '2024-04-05 02:56:17'),
(19, 4, 13, 0, '2024-04-05 02:12:07', '2024-04-05 02:56:24'),
(20, 4, 16, 0, '2024-04-05 02:12:13', '2024-04-05 02:56:27'),
(21, 4, 17, 0, '2024-04-05 02:12:19', '2024-04-05 02:56:30'),
(22, 4, 18, 0, '2024-04-05 02:12:27', '2024-04-05 02:56:37'),
(23, 4, 20, 0, '2024-04-05 02:12:32', '2024-04-05 02:56:51'),
(24, 4, 19, 0, '2024-04-05 02:12:40', '2024-04-05 02:57:01'),
(25, 4, 14, 0, '2024-04-05 02:12:56', '2024-04-05 02:57:04'),
(26, 4, 15, 0, '2024-04-05 02:13:06', '2024-04-05 02:57:08'),
(28, 1, 1, 0, '2024-04-05 02:13:37', '2024-04-05 02:57:15'),
(29, 1, 2, 0, '2024-04-05 02:13:44', '2024-04-05 02:57:18'),
(30, 1, 5, 0, '2024-04-05 02:13:52', '2024-04-05 02:57:26'),
(31, 1, 4, 0, '2024-04-05 02:14:01', '2024-04-05 02:57:30'),
(32, 1, 3, 0, '2024-04-05 02:14:08', '2024-04-05 02:57:41'),
(33, 1, 6, 0, '2024-04-05 02:14:15', '2024-04-05 02:57:44'),
(34, 1, 9, 0, '2024-04-05 02:14:22', '2024-04-05 02:57:47'),
(35, 1, 10, 0, '2024-04-05 02:14:30', '2024-04-05 02:57:49'),
(36, 1, 7, 0, '2024-04-05 02:15:11', '2024-04-05 02:57:54'),
(37, 1, 11, 0, '2024-04-05 02:44:19', '2024-04-05 02:58:20'),
(38, 1, 12, 0, '2024-04-05 02:44:25', '2024-04-05 02:58:24'),
(39, 2, 22, 0, '2024-04-05 05:27:46', '2024-04-05 05:27:46'),
(40, 3, 22, 0, '2024-04-05 05:27:56', '2024-04-05 05:27:56'),
(41, 4, 22, 0, '2024-04-05 05:28:06', '2024-04-05 05:28:06');

-- --------------------------------------------------------

--
-- Table structure for table `noshows`
--

CREATE TABLE `noshows` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `team_id` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `team_id` tinyint(3) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `number` smallint(5) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `rank` tinyint(3) UNSIGNED NOT NULL,
  `value` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `points`
--

INSERT INTO `points` (`id`, `event_id`, `rank`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 12, '2024-04-04 07:23:52', '2024-04-05 03:01:53'),
(2, 1, 2, 10, '2024-04-04 07:23:52', '2024-04-05 03:02:01'),
(3, 1, 3, 8, '2024-04-04 07:23:52', '2024-04-05 03:02:05'),
(4, 2, 1, 12, '2024-04-04 07:23:52', '2024-04-05 03:02:08'),
(5, 2, 2, 10, '2024-04-04 07:23:52', '2024-04-05 03:02:11'),
(6, 2, 3, 8, '2024-04-04 07:23:52', '2024-04-05 03:02:16'),
(7, 3, 1, 12, '2024-04-04 07:23:52', '2024-04-05 03:02:53'),
(8, 3, 2, 10, '2024-04-04 07:23:52', '2024-04-05 03:34:51'),
(9, 3, 3, 8, '2024-04-04 07:23:52', '2024-04-05 03:35:08'),
(10, 4, 1, 10, '2024-04-04 07:23:52', '2024-04-05 03:35:34'),
(11, 4, 2, 7, '2024-04-04 07:23:52', '2024-04-05 03:35:37'),
(12, 4, 3, 5, '2024-04-04 07:23:52', '2024-04-05 03:35:44'),
(13, 5, 1, 10, '2024-04-04 07:23:52', '2024-04-05 03:38:35'),
(14, 5, 2, 7, '2024-04-04 07:23:52', '2024-04-05 03:38:41'),
(15, 5, 3, 5, '2024-04-04 07:23:52', '2024-04-05 03:38:49'),
(16, 6, 1, 9, '2024-04-04 07:23:52', '2024-04-05 03:39:16'),
(17, 6, 2, 6, '2024-04-04 07:23:52', '2024-04-05 03:39:19'),
(18, 6, 3, 3, '2024-04-04 07:23:52', '2024-04-05 03:39:21'),
(19, 7, 1, 9, '2024-04-04 07:23:52', '2024-04-05 03:39:51'),
(20, 7, 2, 6, '2024-04-04 07:23:52', '2024-04-05 03:39:59'),
(21, 7, 3, 3, '2024-04-04 07:23:52', '2024-04-05 03:40:18'),
(22, 13, 1, 10, '2023-03-04 11:19:20', '2024-04-05 03:38:15'),
(23, 13, 2, 7, '2023-03-04 11:19:20', '2024-04-05 03:38:11'),
(24, 13, 3, 5, '2023-03-04 11:19:20', '2024-04-05 03:38:09'),
(25, 16, 1, 10, '2023-03-04 11:20:10', '2024-04-05 03:38:05'),
(26, 16, 2, 7, '2023-03-04 11:20:10', '2024-04-05 03:38:01'),
(27, 16, 3, 5, '2023-03-04 11:20:10', '2024-04-05 03:37:57'),
(28, 17, 1, 10, '2023-03-04 11:20:10', '2024-04-05 03:37:53'),
(29, 17, 2, 7, '2023-03-04 11:20:10', '2024-04-05 03:37:48'),
(30, 17, 3, 5, '2023-03-04 11:20:10', '2024-04-05 03:37:38'),
(31, 18, 1, 10, '2023-03-04 11:20:10', '2024-04-05 03:37:34'),
(32, 18, 2, 7, '2023-03-04 11:20:10', '2024-04-05 03:37:32'),
(33, 18, 3, 5, '2023-03-04 11:20:10', '2024-04-05 03:37:29'),
(34, 20, 1, 15, '2023-03-04 11:21:23', '2024-04-05 03:37:24'),
(35, 20, 2, 13, '2023-03-04 11:21:23', '2024-04-05 03:37:20'),
(36, 20, 3, 10, '2023-03-04 11:21:23', '2024-04-05 03:37:16'),
(37, 19, 1, 15, '2023-03-04 11:21:23', '2024-04-05 03:37:08'),
(38, 19, 2, 13, '2023-03-04 11:21:23', '2024-04-05 03:37:05'),
(39, 19, 3, 10, '2023-03-04 11:21:23', '2024-04-05 03:37:00'),
(52, 9, 1, 9, '2024-04-04 07:23:52', '2024-04-04 07:26:41'),
(53, 9, 2, 6, '2024-04-04 07:23:52', '2024-04-04 07:26:47'),
(54, 9, 3, 3, '2024-04-04 07:23:52', '2024-04-04 07:26:54'),
(58, 14, 1, 10, '2024-04-04 07:23:52', '2024-04-04 07:27:28'),
(59, 14, 2, 7, '2024-04-04 07:23:53', '2024-04-04 07:27:35'),
(60, 14, 3, 5, '2024-04-04 07:23:53', '2024-04-04 07:27:42'),
(61, 15, 1, 10, '2024-04-04 07:23:53', '2024-04-04 07:27:49'),
(62, 15, 2, 7, '2024-04-04 07:23:53', '2024-04-04 07:28:14'),
(63, 15, 3, 5, '2024-04-04 07:23:53', '2024-04-04 07:28:20'),
(67, 10, 1, 9, '2024-04-05 01:44:57', '2024-04-05 01:48:32'),
(68, 10, 2, 6, '2024-04-05 01:44:57', '2024-04-05 01:48:41'),
(69, 10, 3, 3, '2024-04-05 01:44:57', '2024-04-05 01:48:48'),
(70, 11, 1, 10, '2024-04-05 02:41:26', '2024-04-05 02:41:35'),
(71, 11, 2, 7, '2024-04-05 02:41:26', '2024-04-05 02:41:43'),
(72, 11, 3, 7, '2024-04-05 02:41:26', '2024-04-05 02:41:50'),
(73, 12, 1, 10, '2024-04-05 02:41:27', '2024-04-05 02:41:58'),
(74, 12, 2, 7, '2024-04-05 02:41:27', '2024-04-05 02:42:04'),
(75, 12, 3, 5, '2024-04-05 02:41:27', '2024-04-05 02:42:17'),
(76, 23, 1, 0, '2024-04-05 05:31:42', '2024-04-05 05:31:42'),
(77, 23, 2, 0, '2024-04-05 05:31:42', '2024-04-05 05:31:42'),
(78, 23, 3, 0, '2024-04-05 05:31:42', '2024-04-05 05:31:42'),
(79, 22, 1, 20, '2024-04-05 05:31:42', '2024-04-05 05:53:26'),
(80, 22, 2, 17, '2024-04-05 05:31:42', '2024-04-05 05:53:35'),
(81, 22, 3, 15, '2024-04-05 05:31:42', '2024-04-05 05:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `judge_id` tinyint(3) UNSIGNED NOT NULL,
  `criteria_id` smallint(5) UNSIGNED NOT NULL,
  `team_id` tinyint(3) UNSIGNED NOT NULL,
  `value` float UNSIGNED NOT NULL DEFAULT 0,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(32) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `color`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Fearless Dragons', 'red', 'red.png', '2023-02-19 06:45:06', '2023-02-25 12:02:01'),
(2, 'Furious  Elves', 'green', 'green.png', '2023-02-19 06:45:27', '2023-02-25 12:02:05'),
(3, 'Wise Wizards', 'blue', 'blue.png', '2023-02-19 06:45:42', '2023-02-25 12:02:08');

-- --------------------------------------------------------

--
-- Table structure for table `technicals`
--

CREATE TABLE `technicals` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `number` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active_portion` varchar(255) DEFAULT NULL,
  `called_at` timestamp NULL DEFAULT NULL,
  `pinged_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technicals`
--

INSERT INTO `technicals` (`id`, `number`, `name`, `avatar`, `username`, `password`, `active_portion`, `called_at`, `pinged_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'TECHNICAL O1', 'no-avatar.jpg', 'technical01', 'technical01', NULL, NULL, NULL, '2023-02-19 08:58:58', '2023-02-26 06:04:50');

-- --------------------------------------------------------

--
-- Table structure for table `technical_event`
--

CREATE TABLE `technical_event` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `technical_id` tinyint(3) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technical_event`
--

INSERT INTO `technical_event` (`id`, `technical_id`, `event_id`, `created_at`, `updated_at`) VALUES
(1, 1, 13, '2023-02-25 12:11:34', '2023-02-25 12:11:34'),
(2, 1, 16, '2023-02-25 12:11:35', '2024-04-05 03:41:19'),
(3, 1, 17, '2023-02-25 12:11:35', '2024-04-05 03:41:23'),
(4, 1, 18, '2023-02-25 12:11:35', '2024-04-05 03:41:25'),
(5, 1, 20, '2023-02-25 12:11:35', '2024-04-05 03:41:28'),
(6, 1, 19, '2023-02-25 12:11:35', '2024-04-05 03:41:30'),
(7, 1, 14, '2024-04-05 02:06:12', '2024-04-05 03:41:33'),
(8, 1, 15, '2024-04-05 02:06:44', '2024-04-05 03:41:36');

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `rank` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arrangements`
--
ALTER TABLE `arrangements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `competition_id` (`competition_id`);

--
-- Indexes for table `competitions`
--
ALTER TABLE `competitions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judge_id` (`technical_id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `eliminations`
--
ALTER TABLE `eliminations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area_id` (`category_id`);

--
-- Indexes for table `judges`
--
ALTER TABLE `judges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `judge_event`
--
ALTER TABLE `judge_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judge_id` (`judge_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `noshows`
--
ALTER TABLE `noshows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judge_id` (`judge_id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `criteria_id` (`criteria_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technicals`
--
ALTER TABLE `technicals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technical_event`
--
ALTER TABLE `technical_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judge_id` (`technical_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `arrangements`
--
ALTER TABLE `arrangements`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `competitions`
--
ALTER TABLE `competitions`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eliminations`
--
ALTER TABLE `eliminations`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `judge_event`
--
ALTER TABLE `judge_event`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `noshows`
--
ALTER TABLE `noshows`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `technicals`
--
ALTER TABLE `technicals`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `technical_event`
--
ALTER TABLE `technical_event`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arrangements`
--
ALTER TABLE `arrangements`
  ADD CONSTRAINT `arrangements_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `arrangements_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`competition_id`) REFERENCES `competitions` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `criteria`
--
ALTER TABLE `criteria`
  ADD CONSTRAINT `criteria_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `deductions`
--
ALTER TABLE `deductions`
  ADD CONSTRAINT `deductions_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deductions_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deductions_ibfk_3` FOREIGN KEY (`technical_id`) REFERENCES `technicals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eliminations`
--
ALTER TABLE `eliminations`
  ADD CONSTRAINT `eliminations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eliminations_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `judge_event`
--
ALTER TABLE `judge_event`
  ADD CONSTRAINT `judge_event_ibfk_1` FOREIGN KEY (`judge_id`) REFERENCES `judges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `judge_event_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `noshows`
--
ALTER TABLE `noshows`
  ADD CONSTRAINT `noshows_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `noshows_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participants_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `points`
--
ALTER TABLE `points`
  ADD CONSTRAINT `points_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`criteria_id`) REFERENCES `criteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_3` FOREIGN KEY (`judge_id`) REFERENCES `judges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `technical_event`
--
ALTER TABLE `technical_event`
  ADD CONSTRAINT `technical_event_ibfk_2` FOREIGN KEY (`technical_id`) REFERENCES `technicals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `technical_event_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `titles`
--
ALTER TABLE `titles`
  ADD CONSTRAINT `titles_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
