-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2023 at 12:22 PM
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `number`, `name`, `avatar`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'SUPER USER', 'no-avatar.jpg', 'admin', 'admin', '2023-02-19 07:36:32', '2023-02-26 06:05:06');

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
(3, 2, 'literary', 'Literary Competitions', '2023-02-19 06:38:21', '2023-02-19 06:38:53'),
(4, 2, 'music', 'Music Competitions', '2023-02-19 06:38:38', '2023-02-19 06:39:39'),
(5, 2, 'dance', 'Dance Competitions', '2023-02-19 06:40:04', '2023-02-19 06:40:04');

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
(1, 1, 'Delivery', 40, '2023-02-21 04:40:26', '2023-02-21 04:40:26'),
(2, 1, 'Craftmanship', 30, '2023-02-21 04:40:26', '2023-02-21 04:40:26'),
(3, 1, 'Personality', 20, '2023-02-21 04:40:26', '2023-02-21 04:40:26'),
(4, 1, 'Overall Impact', 10, '2023-02-21 04:40:26', '2023-02-21 04:40:26'),
(5, 2, 'Nilalaman', 30, '2023-02-21 04:46:07', '2023-02-21 04:46:07'),
(6, 2, 'Paraan ng Pagbigkas', 20, '2023-02-21 04:46:07', '2023-02-21 04:46:07'),
(7, 2, 'Interpretasyon', 20, '2023-02-21 04:46:07', '2023-02-21 04:52:38'),
(8, 2, 'Kaangkupan ng Kilos o Galaw', 20, '2023-02-21 04:47:41', '2023-02-21 04:47:41'),
(9, 2, 'Kasuotan at Props', 10, '2023-02-21 04:47:41', '2023-02-21 04:47:41'),
(10, 3, 'Nilalaman', 30, '2023-02-21 04:50:29', '2023-02-21 04:50:29'),
(11, 3, 'Paraan ng Pagbigkas', 20, '2023-02-21 04:50:29', '2023-02-21 04:50:29'),
(12, 3, 'Interpretasyon', 20, '2023-02-21 04:50:29', '2023-02-21 04:50:29'),
(13, 3, 'Kaangkupan ng Kilos o Galaw', 20, '2023-02-21 04:50:29', '2023-02-21 04:50:29'),
(14, 3, 'Kasuotan at Props', 10, '2023-02-21 04:50:29', '2023-02-21 04:50:29'),
(15, 4, 'Delivery', 30, '2023-02-21 04:57:23', '2023-02-21 04:57:23'),
(16, 4, 'Stress And Rhythm', 30, '2023-02-21 04:57:23', '2023-02-21 04:57:23'),
(17, 4, 'Mastery', 20, '2023-02-21 04:57:23', '2023-02-21 04:57:23'),
(18, 4, 'Choreography', 10, '2023-02-21 04:57:23', '2023-02-21 04:57:23'),
(19, 4, 'Costume, Props, Sound Effects', 10, '2023-02-21 04:57:23', '2023-02-21 04:57:23'),
(20, 5, 'Tone Quality', 40, '2023-02-21 05:00:26', '2023-02-21 05:00:26'),
(21, 5, 'Interpretation, Delivery, Dynamics', 40, '2023-02-21 05:00:26', '2023-02-21 05:00:26'),
(22, 5, 'Stage Presence', 20, '2023-02-21 05:00:26', '2023-02-21 05:00:26'),
(26, 6, 'Tone Quality', 40, '2023-02-21 05:04:10', '2023-02-21 05:04:10'),
(27, 6, 'Interpretation, Delivery, Dynamics', 40, '2023-02-21 05:04:10', '2023-02-21 05:04:10'),
(28, 6, 'Stage Presence', 20, '2023-02-21 05:04:10', '2023-02-21 05:04:10'),
(29, 7, 'Tone Quality', 40, '2023-02-21 05:06:02', '2023-02-21 05:06:02'),
(30, 7, 'Blending and Interpretation/Counterpoint', 40, '2023-02-21 05:06:02', '2023-02-21 05:06:02'),
(31, 7, 'Stage Presence', 20, '2023-02-21 05:06:02', '2023-02-21 05:06:02'),
(32, 8, 'Vocal Power', 40, '2023-02-21 05:11:35', '2023-02-21 05:11:35'),
(33, 8, 'Instrumental', 20, '2023-02-21 05:11:35', '2023-02-21 05:11:35'),
(34, 8, 'Creativity', 20, '2023-02-21 05:11:35', '2023-02-21 05:11:35'),
(35, 8, 'Audience Import', 10, '2023-02-21 05:11:35', '2023-02-21 05:11:35'),
(36, 8, 'Overall', 10, '2023-02-21 05:11:35', '2023-02-21 05:11:35'),
(37, 9, 'Performance', 30, '2023-02-21 05:12:34', '2023-02-21 05:15:02'),
(38, 9, 'Choreography', 20, '2023-02-21 05:17:10', '2023-02-21 05:17:10'),
(39, 9, 'Technique/Style', 20, '2023-02-21 05:17:10', '2023-02-21 05:17:10'),
(40, 9, 'Rhythm and Timing', 20, '2023-02-21 05:17:10', '2023-02-21 05:17:10'),
(41, 9, 'Costume/Props', 10, '2023-02-21 05:17:10', '2023-02-21 05:17:10'),
(42, 10, 'Performance', 30, '2023-02-21 05:20:17', '2023-02-21 05:20:17'),
(43, 10, 'Choreography and Originality', 20, '2023-02-21 05:20:17', '2023-02-21 05:20:17'),
(44, 10, 'Technique/Style', 20, '2023-02-21 05:20:17', '2023-02-21 05:20:17'),
(45, 10, 'Rhythm and Timing', 20, '2023-02-21 05:20:17', '2023-02-21 05:20:17'),
(46, 10, 'Costume', 10, '2023-02-21 05:20:17', '2023-02-21 05:20:17'),
(47, 11, 'Choreography', 35, '2023-02-21 05:23:25', '2023-02-21 05:23:25'),
(48, 11, 'Synchronization and Accuracy', 20, '2023-02-21 05:23:25', '2023-02-21 05:23:25'),
(49, 11, 'Cheers, Chants, & Yells', 10, '2023-02-21 05:23:25', '2023-02-21 05:23:25'),
(50, 11, 'Costume & Props', 10, '2023-02-21 05:27:50', '2023-02-21 05:27:50'),
(51, 11, 'Overall Performance', 15, '2023-02-21 05:27:50', '2023-02-21 05:27:50'),
(52, 11, 'Audience Impact', 10, '2023-02-21 05:27:50', '2023-02-21 05:27:50');

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
(1, 3, 'oration', 'Oration', '2023-02-21 02:05:03', '2023-02-21 02:05:03'),
(2, 3, 'balagtasan', 'Balagtasan', '2023-02-21 02:05:03', '2023-02-21 02:05:03'),
(3, 3, 'tigsik', 'Tigsik', '2023-02-21 02:16:39', '2023-02-21 02:16:39'),
(4, 3, 'jazz-chant', 'Jazz Chant', '2023-02-21 02:16:39', '2023-02-22 02:23:37'),
(5, 4, 'vocal-solo-male', 'Vocal Solo Male', '2023-02-21 02:16:39', '2023-02-22 02:25:52'),
(6, 4, 'vocal-solo-female', 'Vocal Solo Female', '2023-02-21 02:16:39', '2023-02-22 02:26:01'),
(7, 4, 'vocal-duet', 'Vocal Duet', '2023-02-21 02:16:39', '2023-02-22 02:26:07'),
(8, 4, 'acoustic-band', 'Acoustic Band', '2023-02-21 02:16:39', '2023-02-22 02:26:12'),
(9, 5, 'hip-hop', 'Hip Hop', '2023-02-21 02:16:39', '2023-02-22 02:26:17'),
(10, 5, 'jazz-dance', 'Jazz Dance', '2023-02-21 02:16:39', '2023-02-22 02:26:21'),
(11, 5, 'cheerdance', 'Cheerdance', '2023-02-21 02:16:39', '2023-02-22 02:26:36');

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE `judges` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `number` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `is_chairman` tinyint(1) NOT NULL DEFAULT 0,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`id`, `number`, `name`, `avatar`, `is_chairman`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'JUDGE 01', 'no-avatar.jpg', 1, 'judge01', 'judge01', '2023-02-19 08:58:05', '2023-02-26 06:04:23'),
(2, 2, 'JUDGE 02', 'no-avatar.jpg', 0, 'judge02', 'judge02', '2023-02-19 08:58:16', '2023-02-26 06:04:26'),
(3, 3, 'JUDGE 03', 'no-avatar.jpg', 0, 'judge03', 'judge03', '2023-02-19 08:58:32', '2023-02-26 06:04:28'),
(4, 4, 'JUDGE 04', 'no-avatar.jpg', 0, 'judge04', 'judge04', '2023-02-21 05:32:22', '2023-02-26 06:04:31'),
(5, 5, 'JUDGE 05', 'no-avatar.jpg', 0, 'judge05', 'judge05', '2023-02-21 05:32:22', '2023-02-26 06:04:33');

-- --------------------------------------------------------

--
-- Table structure for table `judge_events`
--

CREATE TABLE `judge_events` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `judge_id` tinyint(3) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `judge_events`
--

INSERT INTO `judge_events` (`id`, `judge_id`, `event_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(2, 1, 2, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(3, 1, 3, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(4, 1, 4, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(5, 1, 5, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(6, 1, 6, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(7, 1, 7, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(8, 1, 8, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(9, 1, 9, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(10, 1, 10, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(11, 1, 11, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(12, 2, 1, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(13, 2, 2, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(14, 2, 3, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(15, 2, 4, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(16, 2, 5, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(17, 2, 6, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(18, 2, 7, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(19, 2, 8, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(20, 2, 9, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(21, 2, 10, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(22, 2, 11, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(23, 3, 1, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(24, 3, 2, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(25, 3, 3, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(26, 3, 4, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(27, 3, 5, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(28, 3, 6, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(29, 3, 7, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(30, 3, 8, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(31, 3, 9, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(32, 3, 10, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(33, 3, 11, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(34, 4, 1, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(35, 4, 2, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(36, 4, 3, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(37, 4, 4, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(38, 4, 5, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(39, 4, 6, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(40, 4, 7, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(41, 4, 8, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(42, 4, 9, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(43, 4, 10, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(44, 4, 11, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(45, 5, 1, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(46, 5, 2, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(47, 5, 3, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(48, 5, 4, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(49, 5, 5, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(50, 5, 6, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(51, 5, 7, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(52, 5, 8, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(53, 5, 9, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(54, 5, 10, '2023-02-25 12:10:05', '2023-02-25 12:10:05'),
(55, 5, 11, '2023-02-25 12:10:05', '2023-02-25 12:10:05');

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
(1, 1, 1, 10, '2023-03-04 11:19:20', '2023-03-04 11:19:20'),
(2, 1, 2, 7, '2023-03-04 11:19:20', '2023-03-04 11:19:20'),
(3, 1, 3, 5, '2023-03-04 11:19:20', '2023-03-04 11:19:20'),
(4, 2, 1, 10, '2023-03-04 11:19:20', '2023-03-04 11:19:20'),
(5, 2, 2, 7, '2023-03-04 11:19:20', '2023-03-04 11:19:20'),
(6, 2, 3, 5, '2023-03-04 11:19:20', '2023-03-04 11:19:20'),
(7, 3, 1, 10, '2023-03-04 11:19:20', '2023-03-04 11:19:20'),
(8, 3, 2, 7, '2023-03-04 11:19:20', '2023-03-04 11:19:20'),
(9, 3, 3, 5, '2023-03-04 11:19:20', '2023-03-04 11:19:20'),
(10, 4, 1, 10, '2023-03-04 11:19:20', '2023-03-04 11:19:20'),
(11, 4, 2, 7, '2023-03-04 11:19:20', '2023-03-04 11:19:20'),
(12, 4, 3, 5, '2023-03-04 11:19:20', '2023-03-04 11:19:20'),
(13, 5, 1, 10, '2023-03-04 11:20:10', '2023-03-04 11:20:10'),
(14, 5, 2, 7, '2023-03-04 11:20:10', '2023-03-04 11:20:10'),
(15, 5, 3, 5, '2023-03-04 11:20:10', '2023-03-04 11:20:10'),
(16, 6, 1, 10, '2023-03-04 11:20:10', '2023-03-04 11:20:10'),
(17, 6, 2, 7, '2023-03-04 11:20:10', '2023-03-04 11:20:10'),
(18, 6, 3, 5, '2023-03-04 11:20:10', '2023-03-04 11:20:10'),
(19, 7, 1, 10, '2023-03-04 11:20:10', '2023-03-04 11:20:10'),
(20, 7, 2, 7, '2023-03-04 11:20:10', '2023-03-04 11:20:10'),
(21, 7, 3, 5, '2023-03-04 11:20:10', '2023-03-04 11:20:10'),
(22, 8, 1, 10, '2023-03-04 11:20:10', '2023-03-04 11:20:10'),
(23, 8, 2, 7, '2023-03-04 11:20:10', '2023-03-04 11:20:10'),
(24, 8, 3, 5, '2023-03-04 11:20:10', '2023-03-04 11:20:10'),
(25, 9, 1, 10, '2023-03-04 11:21:23', '2023-03-04 11:21:23'),
(26, 9, 2, 7, '2023-03-04 11:21:23', '2023-03-04 11:21:23'),
(27, 9, 3, 5, '2023-03-04 11:21:23', '2023-03-04 11:21:23'),
(28, 10, 1, 10, '2023-03-04 11:21:23', '2023-03-04 11:21:23'),
(29, 10, 2, 7, '2023-03-04 11:21:23', '2023-03-04 11:21:23'),
(30, 10, 3, 5, '2023-03-04 11:21:23', '2023-03-04 11:21:23'),
(31, 11, 1, 15, '2023-03-04 11:21:23', '2023-03-04 11:22:08'),
(32, 11, 2, 13, '2023-03-04 11:21:23', '2023-03-04 11:22:08'),
(33, 11, 3, 10, '2023-03-04 11:21:23', '2023-03-04 11:22:08');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technicals`
--

INSERT INTO `technicals` (`id`, `number`, `name`, `avatar`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 'TECHNICAL O1', 'no-avatar.jpg', 'technical01', 'technical01', '2023-02-19 08:58:58', '2023-02-26 06:04:50');

-- --------------------------------------------------------

--
-- Table structure for table `technical_events`
--

CREATE TABLE `technical_events` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `technical_id` tinyint(3) UNSIGNED NOT NULL,
  `event_id` smallint(5) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `technical_events`
--

INSERT INTO `technical_events` (`id`, `technical_id`, `event_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-02-25 12:11:34', '2023-02-25 12:11:34'),
(2, 1, 2, '2023-02-25 12:11:34', '2023-02-25 12:11:34'),
(3, 1, 3, '2023-02-25 12:11:34', '2023-02-25 12:11:34'),
(4, 1, 4, '2023-02-25 12:11:34', '2023-02-25 12:11:34'),
(5, 1, 5, '2023-02-25 12:11:35', '2023-02-25 12:11:35'),
(6, 1, 6, '2023-02-25 12:11:35', '2023-02-25 12:11:35'),
(7, 1, 7, '2023-02-25 12:11:35', '2023-02-25 12:11:35'),
(8, 1, 8, '2023-02-25 12:11:35', '2023-02-25 12:11:35'),
(9, 1, 9, '2023-02-25 12:11:35', '2023-02-25 12:11:35'),
(10, 1, 10, '2023-02-25 12:11:35', '2023-02-25 12:11:35'),
(11, 1, 11, '2023-02-25 12:11:35', '2023-02-25 12:11:35');

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
-- Indexes for table `judge_events`
--
ALTER TABLE `judge_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judge_id` (`judge_id`),
  ADD KEY `event_id` (`event_id`);

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
-- Indexes for table `technical_events`
--
ALTER TABLE `technical_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `judge_id` (`technical_id`),
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
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `competitions`
--
ALTER TABLE `competitions`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `judge_events`
--
ALTER TABLE `judge_events`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
-- AUTO_INCREMENT for table `technical_events`
--
ALTER TABLE `technical_events`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `judge_events`
--
ALTER TABLE `judge_events`
  ADD CONSTRAINT `judge_events_ibfk_1` FOREIGN KEY (`judge_id`) REFERENCES `judges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `judge_events_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `technical_events`
--
ALTER TABLE `technical_events`
  ADD CONSTRAINT `technical_events_ibfk_2` FOREIGN KEY (`technical_id`) REFERENCES `technicals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `technical_events_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
