-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2023 at 01:05 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

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
-- Table structure for table `criteria_acousticband`
--

CREATE TABLE `criteria_acousticband` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `criteria_balagtasan`
--

CREATE TABLE `criteria_balagtasan` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `criteria_cheerdance`
--

CREATE TABLE `criteria_cheerdance` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `criteria_hiphop`
--

CREATE TABLE `criteria_hiphop` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `criteria_jazzchant`
--

CREATE TABLE `criteria_jazzchant` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `criteria_jazzdance`
--

CREATE TABLE `criteria_jazzdance` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `criteria_oration`
--

CREATE TABLE `criteria_oration` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criteria_oration`
--

INSERT INTO `criteria_oration` (`id`, `title`, `percentage`, `created_at`, `updated_at`) VALUES
(1, 'DELIVERY', 40, '2023-02-17 06:55:58', '2023-02-17 06:55:58'),
(2, 'CRAFTMANSHIP', 30, '2023-02-17 06:55:58', '2023-02-17 06:55:58'),
(3, 'PERSONALITY', 20, '2023-02-17 06:57:41', '2023-02-17 06:57:41'),
(4, 'OVERALL IMPACT', 10, '2023-02-17 06:57:41', '2023-02-17 06:57:41');

-- --------------------------------------------------------

--
-- Table structure for table `criteria_tigsik`
--

CREATE TABLE `criteria_tigsik` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `criteria_vocalduet`
--

CREATE TABLE `criteria_vocalduet` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `criteria_vocalsolofemale`
--

CREATE TABLE `criteria_vocalsolofemale` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `criteria_vocalsolomale`
--

CREATE TABLE `criteria_vocalsolomale` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `percentage` float UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings_oration`
--

CREATE TABLE `ratings_oration` (
  `id` int(255) NOT NULL,
  `judge_id` int(10) UNSIGNED NOT NULL,
  `criteria_id` int(10) UNSIGNED NOT NULL,
  `team_id` int(10) UNSIGNED NOT NULL,
  `value` float UNSIGNED DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings_oration`
--

INSERT INTO `ratings_oration` (`id`, `judge_id`, `criteria_id`, `team_id`, `value`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, '2023-02-17 07:55:51', '2023-02-17 08:14:08'),
(2, 1, 2, 1, 0, '2023-02-17 08:38:51', '2023-02-17 08:38:51'),
(3, 1, 3, 1, 0, '2023-02-17 08:38:51', '2023-02-17 08:38:51'),
(4, 1, 4, 1, 0, '2023-02-17 08:41:15', '2023-02-17 08:41:15'),
(5, 1, 1, 2, 0, '2023-02-17 08:41:15', '2023-02-17 08:41:15'),
(6, 1, 2, 2, 0, '2023-02-17 08:41:15', '2023-02-17 08:41:15'),
(7, 1, 3, 2, 0, '2023-02-17 08:41:15', '2023-02-17 08:41:15'),
(8, 1, 4, 2, 0, '2023-02-17 08:41:15', '2023-02-17 08:41:15'),
(9, 1, 1, 3, 0, '2023-02-17 08:45:03', '2023-02-17 08:45:03'),
(10, 1, 2, 3, 0, '2023-02-17 08:45:03', '2023-02-17 08:45:03'),
(11, 1, 3, 3, 0, '2023-02-17 08:45:03', '2023-02-17 08:45:03'),
(12, 1, 4, 3, 0, '2023-02-17 08:45:03', '2023-02-17 08:45:03'),
(13, 2, 1, 1, 0, '2023-02-17 08:59:32', '2023-02-17 08:59:32'),
(14, 2, 2, 1, 0, '2023-02-17 08:59:32', '2023-02-17 08:59:32'),
(15, 2, 3, 1, 0, '2023-02-17 08:59:32', '2023-02-17 08:59:32'),
(16, 2, 4, 1, 0, '2023-02-17 08:59:32', '2023-02-17 08:59:32'),
(17, 2, 1, 2, 0, '2023-02-17 08:59:32', '2023-02-17 08:59:32'),
(18, 2, 2, 2, 0, '2023-02-17 08:59:32', '2023-02-17 08:59:32'),
(19, 2, 3, 2, 0, '2023-02-17 08:59:32', '2023-02-17 08:59:32'),
(20, 2, 4, 2, 0, '2023-02-17 08:59:32', '2023-02-17 08:59:32'),
(21, 2, 1, 3, 0, '2023-02-17 08:59:32', '2023-02-17 08:59:32'),
(22, 2, 2, 3, 0, '2023-02-17 08:59:32', '2023-02-17 08:59:32'),
(23, 2, 3, 3, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(24, 2, 4, 3, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(25, 3, 1, 1, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(26, 3, 2, 1, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(27, 3, 3, 1, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(28, 3, 4, 1, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(29, 3, 1, 2, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(30, 3, 2, 2, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(31, 3, 3, 2, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(32, 3, 4, 2, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(33, 3, 1, 3, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(34, 3, 2, 3, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(35, 3, 3, 3, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(36, 3, 4, 3, 0, '2023-02-17 09:12:31', '2023-02-17 09:12:31'),
(37, 4, 1, 1, 0, '2023-02-17 09:17:16', '2023-02-17 09:17:16'),
(38, 4, 2, 1, 0, '2023-02-17 09:17:16', '2023-02-17 09:17:16'),
(39, 4, 3, 1, 0, '2023-02-17 09:17:16', '2023-02-17 09:17:16'),
(40, 4, 4, 1, 0, '2023-02-17 09:17:16', '2023-02-17 09:17:16'),
(41, 4, 1, 2, 0, '2023-02-17 09:17:16', '2023-02-17 09:17:16'),
(42, 4, 2, 2, 0, '2023-02-17 09:17:16', '2023-02-17 09:17:16'),
(43, 4, 3, 2, 0, '2023-02-17 09:17:16', '2023-02-17 09:17:16'),
(44, 4, 4, 2, 0, '2023-02-17 09:17:16', '2023-02-17 09:17:16'),
(45, 4, 1, 3, 0, '2023-02-17 09:17:16', '2023-02-17 09:17:16'),
(46, 4, 2, 3, 0, '2023-02-17 09:17:16', '2023-02-17 09:17:16'),
(47, 4, 3, 3, 0, '2023-02-17 09:17:16', '2023-02-17 09:17:16'),
(48, 4, 4, 3, 0, '2023-02-17 09:17:16', '2023-02-17 09:17:16'),
(49, 5, 1, 1, 0, '2023-02-17 09:19:08', '2023-02-17 09:19:08'),
(50, 5, 2, 1, 0, '2023-02-17 09:19:08', '2023-02-17 09:19:08'),
(51, 5, 3, 1, 0, '2023-02-17 09:19:08', '2023-02-17 09:19:08'),
(52, 5, 4, 1, 0, '2023-02-17 09:19:08', '2023-02-17 09:19:08'),
(53, 5, 1, 2, 0, '2023-02-17 09:19:08', '2023-02-17 09:19:08'),
(54, 5, 2, 2, 0, '2023-02-17 09:19:08', '2023-02-17 09:19:08'),
(55, 5, 3, 2, 0, '2023-02-17 09:19:08', '2023-02-17 09:19:08'),
(56, 5, 4, 2, 0, '2023-02-17 09:19:08', '2023-02-17 09:19:08'),
(57, 5, 1, 3, 0, '2023-02-17 09:19:08', '2023-02-17 09:19:08'),
(58, 5, 2, 3, 0, '2023-02-17 09:19:08', '2023-02-17 09:19:08'),
(59, 5, 3, 3, 0, '2023-02-17 09:19:08', '2023-02-17 09:19:08'),
(60, 5, 4, 3, 0, '2023-02-17 09:19:08', '2023-02-17 09:19:08');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(3) UNSIGNED NOT NULL,
  `color` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `color`, `name`, `logo`) VALUES
(1, 'red', 'Fearless Dragons', ''),
(2, 'green', 'Furious Elves', ''),
(3, 'blue', 'Wise Wizards', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_admin`
--

CREATE TABLE `users_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `number` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_admin`
--

INSERT INTO `users_admin` (`id`, `fullname`, `number`, `username`, `password`, `avatar`) VALUES
(1, 'ADMIN', 1, 'admin', 'admin', 'image');

-- --------------------------------------------------------

--
-- Table structure for table `users_judge`
--

CREATE TABLE `users_judge` (
  `id` int(10) UNSIGNED NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `number` int(255) UNSIGNED NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_judge`
--

INSERT INTO `users_judge` (`id`, `fullname`, `username`, `password`, `number`, `avatar`) VALUES
(1, 'JUDGE01', 'judge01', 'judge01', 1, '0'),
(2, 'JUDGE02', 'judge02', 'judge02', 2, '0'),
(3, 'JUDGE03', 'judge03', 'judge03', 3, '0'),
(4, 'JUDGE04', 'judge04', 'judge04', 4, '0'),
(5, 'JUDGE05', 'judge05', 'judge05', 5, '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `criteria_acousticband`
--
ALTER TABLE `criteria_acousticband`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_balagtasan`
--
ALTER TABLE `criteria_balagtasan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_cheerdance`
--
ALTER TABLE `criteria_cheerdance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_hiphop`
--
ALTER TABLE `criteria_hiphop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_jazzchant`
--
ALTER TABLE `criteria_jazzchant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_jazzdance`
--
ALTER TABLE `criteria_jazzdance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_oration`
--
ALTER TABLE `criteria_oration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_tigsik`
--
ALTER TABLE `criteria_tigsik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_vocalduet`
--
ALTER TABLE `criteria_vocalduet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_vocalsolofemale`
--
ALTER TABLE `criteria_vocalsolofemale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria_vocalsolomale`
--
ALTER TABLE `criteria_vocalsolomale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings_oration`
--
ALTER TABLE `ratings_oration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `judge_id_2` (`judge_id`,`criteria_id`,`team_id`),
  ADD KEY `judge_id` (`judge_id`),
  ADD KEY `criteria_id` (`criteria_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_admin`
--
ALTER TABLE `users_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_judge`
--
ALTER TABLE `users_judge`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `criteria_acousticband`
--
ALTER TABLE `criteria_acousticband`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criteria_balagtasan`
--
ALTER TABLE `criteria_balagtasan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criteria_cheerdance`
--
ALTER TABLE `criteria_cheerdance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criteria_hiphop`
--
ALTER TABLE `criteria_hiphop`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criteria_jazzchant`
--
ALTER TABLE `criteria_jazzchant`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criteria_jazzdance`
--
ALTER TABLE `criteria_jazzdance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criteria_oration`
--
ALTER TABLE `criteria_oration`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `criteria_tigsik`
--
ALTER TABLE `criteria_tigsik`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criteria_vocalduet`
--
ALTER TABLE `criteria_vocalduet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criteria_vocalsolofemale`
--
ALTER TABLE `criteria_vocalsolofemale`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `criteria_vocalsolomale`
--
ALTER TABLE `criteria_vocalsolomale`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings_oration`
--
ALTER TABLE `ratings_oration`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users_admin`
--
ALTER TABLE `users_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_judge`
--
ALTER TABLE `users_judge`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ratings_oration`
--
ALTER TABLE `ratings_oration`
  ADD CONSTRAINT `ratings_oration_ibfk_1` FOREIGN KEY (`criteria_id`) REFERENCES `criteria_oration` (`id`),
  ADD CONSTRAINT `ratings_oration_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  ADD CONSTRAINT `ratings_oration_ibfk_3` FOREIGN KEY (`judge_id`) REFERENCES `users_judge` (`id`);

--
-- Constraints for table `users_judge`
--
ALTER TABLE `users_judge`
  ADD CONSTRAINT `users_judge_ibfk_1` FOREIGN KEY (`id`) REFERENCES `ratings_oration` (`judge_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
