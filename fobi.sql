-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2023 at 05:31 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fobi`
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
  `pinged_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `number`, `name`, `avatar`, `username`, `password`, `pinged_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'DEVELOPMENT', 'no-avatar.jpg', 'admin', 'admin', '2023-03-18 06:13:38', '2023-02-19 07:36:32', '2023-03-18 06:44:17');

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
(1, 1, 'attire', 'Attire', '2023-03-16 01:01:23', '2023-03-16 01:01:23'),
(2, 2, 'pageant-night', 'Pageant Night', '2023-03-18 06:14:24', '2023-03-18 06:14:24');

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
(1, 'preliminary', 'Preliminary Competitions', '2023-03-16 01:00:44', '2023-03-16 01:00:44'),
(2, 'pageant', 'Pageant Night', '2023-03-18 06:13:54', '2023-03-18 06:13:54');

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
(1, 1, 'Visual Impact', 30, '2023-03-16 01:03:50', '2023-03-16 01:03:50'),
(2, 1, 'Overall Presentation', 30, '2023-03-16 01:04:03', '2023-03-16 01:04:03'),
(3, 1, 'Walking Technique', 20, '2023-03-16 01:04:15', '2023-03-16 01:04:15'),
(4, 1, 'Stage Presence', 20, '2023-03-16 01:04:31', '2023-03-16 01:04:31'),
(5, 2, 'Visual Impact', 30, '2023-03-16 01:04:57', '2023-03-16 01:04:57'),
(6, 2, 'Overall Presentation', 30, '2023-03-16 01:05:09', '2023-03-16 01:05:09'),
(7, 2, 'Walking Technique', 20, '2023-03-16 01:05:22', '2023-03-16 01:05:22'),
(8, 2, 'Stage Presence', 20, '2023-03-16 01:05:37', '2023-03-16 01:05:37'),
(9, 3, 'Physique', 30, '2023-03-18 06:17:04', '2023-03-18 06:17:04'),
(10, 3, 'Overall Presentation', 30, '2023-03-18 06:17:21', '2023-03-18 06:17:21'),
(11, 3, 'Walking Technique', 20, '2023-03-18 06:17:35', '2023-03-18 06:17:35'),
(12, 3, 'Stage Presence', 20, '2023-03-18 06:17:53', '2023-03-18 06:17:53'),
(13, 4, 'Visual Impact', 30, '2023-03-18 06:18:25', '2023-03-18 06:19:38'),
(14, 4, 'Overall Presentation', 30, '2023-03-18 06:18:40', '2023-03-18 06:18:40'),
(15, 4, 'Walking Technique', 20, '2023-03-18 06:18:53', '2023-03-18 06:18:53'),
(16, 4, 'Stage Presence', 20, '2023-03-18 06:19:07', '2023-03-18 06:19:07'),
(17, 5, 'Poise, Posture, and Confidence', 50, '2023-03-18 06:20:35', '2023-03-18 06:20:35'),
(18, 5, 'Speech and Clarity of Voice', 25, '2023-03-18 06:20:53', '2023-03-18 06:20:53'),
(19, 5, 'Validity of Opinion', 25, '2023-03-18 06:21:06', '2023-03-18 06:21:06'),
(20, 6, 'Value', 100, '2023-03-18 06:28:14', '2023-03-18 06:28:14'),
(21, 7, 'Preliminary', 60, '2023-03-18 06:29:21', '2023-03-18 06:29:21'),
(22, 7, 'Swimsuit', 10, '2023-03-18 06:29:37', '2023-03-18 06:29:37'),
(23, 7, 'Evening Gown', 10, '2023-03-18 06:29:56', '2023-03-18 06:29:56'),
(24, 7, 'Q & A', 20, '2023-03-18 06:30:09', '2023-03-18 06:30:09');

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
  `id` mediumint(9) NOT NULL,
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
(1, 1, 'national-costume', 'National Costume', '2023-03-16 01:01:44', '2023-03-16 01:11:45'),
(2, 1, 'evening-gown', 'Evening Gown', '2023-03-16 01:01:58', '2023-03-16 01:11:48'),
(3, 2, 'swimsuit-2', 'Swimsuit', '2023-03-18 06:15:42', '2023-03-18 06:36:00'),
(4, 2, 'evening-gown-2', 'Evening Gown', '2023-03-18 06:16:04', '2023-03-18 06:36:05'),
(5, 2, 'qa', 'Q & A', '2023-03-18 06:16:17', '2023-03-18 06:16:17'),
(6, 2, 'prelim', 'Preliminary', '2023-03-18 06:28:03', '2023-03-18 06:28:03'),
(7, 2, 'final', 'Final Result', '2023-03-18 06:29:00', '2023-03-18 06:29:00');

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
  `pinged_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`id`, `number`, `name`, `avatar`, `username`, `password`, `pinged_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'JUDGE 01', 'no-avatar.jpg', 'judge01', 'judge01', '2023-03-18 06:50:09', '2023-02-19 08:58:05', '2023-03-18 06:50:09'),
(2, 2, 'JUDGE 02', 'no-avatar.jpg', 'judge02', 'judge02', '2023-03-16 15:21:23', '2023-02-19 08:58:16', '2023-03-18 06:42:37'),
(3, 3, 'JUDGE 03', 'no-avatar.jpg', 'judge03', 'judge03', '2023-03-16 15:30:00', '2023-02-19 08:58:32', '2023-03-18 06:42:43'),
(4, 4, 'JUDGE 04', 'no-avatar.jpg', 'judge04', 'judge04', '2023-03-16 15:30:00', '2023-02-21 05:32:22', '2023-03-18 06:42:46'),
(5, 5, 'JUDGE 05', 'no-avatar.jpg', 'judge05', 'judge05', '2023-03-16 15:30:03', '2023-02-21 05:32:22', '2023-03-18 06:42:49'),
(6, 6, 'JUDGE 06', 'no-avatar.jpg', 'judge06', 'judge06', '2023-03-16 15:30:00', '2023-03-16 01:06:51', '2023-03-18 06:42:52'),
(7, 7, 'JUDGE 07', 'no-avatar.jpg', 'judge07', 'judge07', '2023-03-16 15:30:00', '2023-03-16 01:07:07', '2023-03-18 06:42:56'),
(8, 8, 'JUDGE 08', 'no-avatar.jpg', 'judge08', 'judge08', '2023-03-16 15:30:01', '2023-03-16 01:07:16', '2023-03-18 06:43:00'),
(9, 1, 'PAGEANT 01', 'no-avatar.jpg', 'pageant01', 'pageant01', NULL, '2023-03-18 06:22:48', '2023-03-18 06:43:17'),
(10, 2, 'PAGEANT 02', 'no-avatar.jpg', 'pageant02', 'pageant02', NULL, '2023-03-18 06:22:52', '2023-03-18 06:41:30'),
(11, 3, 'PAGEANT 03', 'no-avatar.jpg', 'pageant03', 'pageant03', NULL, '2023-03-18 06:22:57', '2023-03-18 06:41:34'),
(12, 4, 'PAGEANT 04', 'no-avatar.jpg', 'pageant04', 'pageant04', NULL, '2023-03-18 06:23:02', '2023-03-18 06:41:38'),
(13, 5, 'PAGEANT 05', 'no-avatar.jpg', 'pageant05', 'pageant05', NULL, '2023-03-18 06:23:06', '2023-03-18 06:41:42'),
(14, 6, 'PAGEANT 06', 'no-avatar.jpg', 'pageant06', 'pageant06', NULL, '2023-03-18 06:23:10', '2023-03-18 06:41:47'),
(15, 7, 'PAGEANT 07', 'no-avatar.jpg', 'pageant07', 'pageant07', NULL, '2023-03-18 06:23:13', '2023-03-18 06:41:56'),
(16, 8, 'PAGEANT 08', 'no-avatar.jpg', 'pageant08', 'pageant08', NULL, '2023-03-18 06:23:16', '2023-03-18 06:42:01'),
(17, 9, 'PAGEANT 09', 'no-avatar.jpg', 'pageant09', 'pageant09', NULL, '2023-03-18 06:23:24', '2023-03-18 06:42:05'),
(18, 1, 'PRELIMINARY 01', 'no-avatar.jpg', 'prelim01', 'prelim01', NULL, '2023-03-18 06:23:28', '2023-03-18 06:42:09'),
(19, 1, 'RESULT 01', 'no-avatar.jpg', 'result01', 'result01', NULL, '2023-03-18 06:23:32', '2023-03-18 06:42:14');

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
(1, 1, 1, 1, '2023-03-16 01:12:42', '2023-03-18 06:46:40'),
(2, 1, 2, 1, '2023-03-16 01:12:42', '2023-03-18 06:46:42'),
(3, 2, 1, 0, '2023-03-16 01:12:42', '2023-03-16 01:12:42'),
(4, 2, 2, 0, '2023-03-16 01:12:42', '2023-03-16 01:12:42'),
(5, 3, 1, 0, '2023-03-16 01:12:42', '2023-03-16 01:12:42'),
(6, 3, 2, 0, '2023-03-16 01:12:42', '2023-03-16 01:12:42'),
(9, 5, 1, 0, '2023-03-16 01:12:42', '2023-03-18 06:46:32'),
(10, 5, 2, 0, '2023-03-16 01:12:42', '2023-03-18 06:46:35'),
(11, 6, 1, 0, '2023-03-16 01:12:42', '2023-03-16 01:12:42'),
(12, 6, 2, 0, '2023-03-16 01:12:42', '2023-03-16 01:12:42'),
(13, 7, 1, 0, '2023-03-16 01:12:42', '2023-03-16 01:12:42'),
(14, 7, 2, 0, '2023-03-16 01:12:42', '2023-03-16 01:12:42'),
(15, 8, 1, 0, '2023-03-16 01:12:42', '2023-03-16 01:12:42'),
(16, 8, 2, 0, '2023-03-16 01:12:42', '2023-03-16 01:12:42'),
(21, 18, 6, 0, '2023-03-18 06:30:58', '2023-03-18 06:30:58'),
(22, 19, 7, 0, '2023-03-18 06:31:09', '2023-03-18 06:31:09'),
(23, 9, 3, 0, '2023-03-18 06:32:09', '2023-03-18 06:32:09'),
(24, 9, 4, 0, '2023-03-18 06:32:15', '2023-03-18 06:32:15'),
(25, 9, 5, 0, '2023-03-18 06:32:18', '2023-03-18 06:32:18'),
(26, 10, 3, 0, '2023-03-18 06:32:24', '2023-03-18 06:32:24'),
(27, 10, 4, 0, '2023-03-18 06:32:27', '2023-03-18 06:32:27'),
(28, 10, 5, 0, '2023-03-18 06:32:31', '2023-03-18 06:32:31'),
(29, 11, 3, 0, '2023-03-18 06:32:38', '2023-03-18 06:32:38'),
(30, 11, 4, 0, '2023-03-18 06:32:40', '2023-03-18 06:32:40'),
(31, 11, 5, 0, '2023-03-18 06:32:43', '2023-03-18 06:32:43'),
(32, 12, 3, 0, '2023-03-18 06:32:51', '2023-03-18 06:32:51'),
(33, 12, 4, 0, '2023-03-18 06:32:54', '2023-03-18 06:32:54'),
(34, 12, 5, 0, '2023-03-18 06:32:56', '2023-03-18 06:32:56'),
(35, 13, 3, 0, '2023-03-18 06:33:04', '2023-03-18 06:33:04'),
(36, 13, 4, 0, '2023-03-18 06:33:07', '2023-03-18 06:33:07'),
(37, 13, 5, 0, '2023-03-18 06:33:10', '2023-03-18 06:33:10'),
(38, 14, 3, 0, '2023-03-18 06:33:29', '2023-03-18 06:33:29'),
(39, 14, 4, 0, '2023-03-18 06:33:32', '2023-03-18 06:33:32'),
(40, 14, 5, 0, '2023-03-18 06:33:34', '2023-03-18 06:33:34'),
(41, 15, 3, 0, '2023-03-18 06:34:43', '2023-03-18 06:34:43'),
(42, 15, 4, 0, '2023-03-18 06:34:47', '2023-03-18 06:34:47'),
(43, 15, 5, 0, '2023-03-18 06:34:51', '2023-03-18 06:34:51'),
(44, 16, 3, 0, '2023-03-18 06:34:57', '2023-03-18 06:34:57'),
(45, 16, 4, 0, '2023-03-18 06:35:00', '2023-03-18 06:35:00'),
(46, 16, 5, 0, '2023-03-18 06:35:04', '2023-03-18 06:35:04'),
(47, 17, 3, 0, '2023-03-18 06:35:10', '2023-03-18 06:35:10'),
(48, 17, 4, 0, '2023-03-18 06:35:13', '2023-03-18 06:35:13'),
(49, 17, 5, 0, '2023-03-18 06:35:16', '2023-03-18 06:35:16');

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
  `country` varchar(32) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `name`, `country`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'Maria Enriquez', 'Australia', 'australia.jpg', '2023-03-16 00:20:45', '2023-03-16 00:45:04'),
(2, 'Mira Fatullaeva', 'Azerbaijan', 'azerbaijan.jpg', '2023-03-16 00:21:08', '2023-03-16 00:45:20'),
(3, 'Anastasia Karitskaya', 'Belarus', 'belarus.jpg', '2023-03-16 00:21:34', '2023-03-16 00:45:34'),
(4, 'Stephanie Somers', 'Belgium', 'belgium.jpg', '2023-03-16 00:22:43', '2023-03-16 00:45:38'),
(5, 'Lili Vanhoolst', 'Benelux', 'benelux.jpg', '2023-03-16 00:22:58', '2023-03-16 00:45:41'),
(6, 'Caroline Dias', 'Brazil', 'brazil.jpg', '2023-03-16 00:23:12', '2023-03-16 00:45:46'),
(7, 'Aya Ehab Moussa Sharkawy', 'Egypt', 'egypt.jpg', '2023-03-16 00:23:33', '2023-03-16 00:45:50'),
(8, 'Tess Aleyia', 'Ethiopia', 'no-avatar.jpg', '2023-03-16 00:27:50', '2023-03-16 00:45:55'),
(9, 'Gitali Ram', 'Fiji', 'fiji.jpg', '2023-03-16 00:28:53', '2023-03-16 00:46:00'),
(10, 'Melissa Myllyoja', 'Finland', 'finland.jpg', '2023-03-16 00:29:13', '2023-03-16 00:46:04'),
(11, 'Kanako Hirayama', 'Japan', 'japan.jpg', '2023-03-16 00:29:32', '2023-03-16 00:46:09'),
(12, 'Cynthia Gloria Orengo', 'Kenya', 'kenya.jpg', '2023-03-16 00:34:20', '2023-03-16 00:46:14'),
(13, 'Seohyeong Pyo', 'Korea', 'korea.jpg', '2023-03-16 00:34:51', '2023-03-16 00:46:17'),
(14, 'Tan Ming Ching', 'Malaysia', 'malaysia.jpg', '2023-03-16 00:35:07', '2023-03-16 00:46:22'),
(15, 'Kaing Zar Thant', 'Myanmar', 'myanmar.jpg', '2023-03-16 00:35:42', '2023-03-16 00:46:28'),
(16, 'Jaylani Turner', 'New Zealand', 'new-zealand.jpg', '2023-03-16 00:36:03', '2023-03-16 00:54:40'),
(17, 'Janna Eloisa Lanuzga', 'Philippines', 'philippines.jpg', '2023-03-16 00:36:34', '2023-03-16 00:46:36'),
(18, 'Teresa Beatriz Pina', 'Portugal', 'no-avatar.jpg', '2023-03-16 00:37:25', '2023-03-16 00:46:42'),
(19, 'Alina But', 'Russia', 'russia.jpg', '2023-03-16 00:37:55', '2023-03-16 00:46:46'),
(20, 'Tashana Opelu', 'Samoa', 'samoa.jpg', '2023-03-16 00:38:14', '2023-03-16 00:46:49'),
(21, 'Sofia Lushchenko', 'Siberia', 'siberia.jpg', '2023-03-16 00:38:30', '2023-03-16 00:46:53'),
(22, 'Karleen Gueho', 'Solomon Islands', 'solomon-island.jpg', '2023-03-16 00:38:47', '2023-03-16 00:46:58'),
(23, 'Rose Esther Thema', 'South Africa', 'south-africa.jpg', '2023-03-16 00:39:10', '2023-03-16 00:47:02'),
(24, 'Chia-Pei Chen', 'Taiwan', 'taiwan.jpg', '2023-03-16 00:39:51', '2023-03-16 00:47:06'),
(25, 'Athita Payak', 'Thailand', 'thailand.jpg', '2023-03-16 00:40:09', '2023-03-16 00:47:09'),
(26, 'Vesalua Tupou', 'Tonga', 'tonga.jpg', '2023-03-16 00:40:25', '2023-03-16 00:47:13'),
(27, 'Precious Soko', 'Zambia', 'no-avatar.jpg', '2023-03-16 00:40:52', '2023-03-16 00:47:29');

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
  `pinged_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technicals`
--

INSERT INTO `technicals` (`id`, `number`, `name`, `avatar`, `username`, `password`, `pinged_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'TECHNICAL O1', 'no-avatar.jpg', 'technical01', 'technical01', NULL, '2023-02-19 08:58:58', '2023-02-26 06:04:50');

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

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `rank` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
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
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `competitions`
--
ALTER TABLE `competitions`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eliminations`
--
ALTER TABLE `eliminations`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `judge_event`
--
ALTER TABLE `judge_event`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

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
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `technicals`
--
ALTER TABLE `technicals`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `technical_event`
--
ALTER TABLE `technical_event`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT;

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
