-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2026 at 09:28 PM
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
-- Database: `voting_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `ip_address`, `created_at`) VALUES
(1, 1, 'User Logged In', '::1', '2026-01-17 10:11:26'),
(2, 2, 'User Logged In', '::1', '2026-01-17 10:13:01'),
(3, 2, 'User Logged In', '::1', '2026-01-17 10:21:14'),
(4, 2, 'User Logged In', '::1', '2026-01-17 10:24:44'),
(5, 2, 'User Logged In', '::1', '2026-01-17 10:35:10'),
(6, 2, 'User Logged In', '::1', '2026-01-17 10:49:10'),
(7, 2, 'User Logged In', '::1', '2026-01-17 10:50:30'),
(8, 1, 'User Logged In', '::1', '2026-01-17 11:53:56'),
(9, 1, 'User Logged In', '::1', '2026-01-17 12:05:28'),
(10, 1, 'User Logged In', '::1', '2026-01-17 12:13:07'),
(11, 1, 'User Logged In', '::1', '2026-01-17 12:19:24'),
(12, 1, 'User Logged In', '::1', '2026-01-17 12:33:21'),
(13, 1, 'User Logged In', '::1', '2026-01-19 16:30:10'),
(14, 1, 'User Logged In', '::1', '2026-01-19 16:34:31'),
(15, 1, 'Added Election: Pakistan', '::1', '2026-01-19 16:34:40'),
(16, 1, 'User Logged In', '::1', '2026-01-19 16:34:54'),
(17, 1, 'Added Election: Pakistan', '::1', '2026-01-19 16:35:09'),
(18, 1, 'User Logged In', '::1', '2026-01-19 16:46:39'),
(19, 1, 'Created election \'Pakistan\' with candidates', '::1', '2026-01-19 16:47:20'),
(20, 2, 'User Logged In', '::1', '2026-01-19 16:48:56'),
(21, 2, 'User Logged In', '::1', '2026-01-19 17:52:30'),
(22, 2, 'User Logged In', '::1', '2026-01-19 17:54:00'),
(23, 2, 'User Logged In', '::1', '2026-01-19 17:57:52'),
(24, 2, 'Voted for candidate 1 in election 3', '::1', '2026-01-19 18:00:57'),
(25, 2, 'User Logged In', '::1', '2026-01-19 19:05:56'),
(26, 2, 'User Logged In', '::1', '2026-01-19 19:07:39'),
(27, 2, 'User Logged In', '::1', '2026-01-19 19:07:53'),
(28, 2, 'User Logged In', '::1', '2026-01-19 21:37:35'),
(29, 1, 'User Logged In', '::1', '2026-01-19 21:37:58'),
(30, 1, 'Created election \'Pakistan\' with candidates', '::1', '2026-01-19 21:38:18'),
(31, 1, 'Closed election ID 0', '::1', '2026-01-19 21:38:23'),
(32, 1, 'Closed election ID 0', '::1', '2026-01-19 21:38:26'),
(33, 2, 'User Logged In', '::1', '2026-01-19 21:39:13'),
(34, 1, 'User Logged In', '::1', '2026-01-19 21:39:27'),
(35, 1, 'Created election \'Pakistan\' with candidates', '::1', '2026-01-19 21:39:49'),
(36, 2, 'User Logged In', '::1', '2026-01-19 21:40:09'),
(37, 2, 'User Logged In', '::1', '2026-01-19 21:46:47'),
(38, 1, 'User Logged In', '::1', '2026-01-19 21:52:28'),
(39, 1, 'User Logged In', '::1', '2026-01-19 21:54:16'),
(40, 1, 'User Logged In', '::1', '2026-01-21 12:46:07'),
(41, 1, 'Closed election ID 0', '::1', '2026-01-21 12:46:33'),
(42, 1, 'User Logged In', '::1', '2026-01-21 13:07:23'),
(43, 1, 'User Logged In', '::1', '2026-01-21 13:08:12'),
(44, 1, 'User Logged In', '::1', '2026-01-21 13:32:27'),
(45, 1, 'User Logged In', '::1', '2026-01-21 13:49:38'),
(46, 2, 'User Logged In', '::1', '2026-01-21 18:44:38'),
(47, 2, 'User Logged In', '::1', '2026-01-21 18:47:46'),
(48, 1, 'User Logged In', '::1', '2026-01-21 18:48:04'),
(49, 2, 'User Logged In', '::1', '2026-01-21 18:54:24'),
(50, 1, 'User Logged In', '::1', '2026-01-21 20:01:26'),
(51, 2, 'User Logged In', '::1', '2026-01-21 20:21:42');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `election_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `election_id`, `name`) VALUES
(1, 3, 'Sameer'),
(2, 3, 'Imran'),
(3, 3, 'Salman'),
(4, 4, 'Sameer'),
(5, 4, 'Salman'),
(6, 4, 'Imran');

-- --------------------------------------------------------

--
-- Table structure for table `elections`
--

CREATE TABLE `elections` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `status` enum('active','closed') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elections`
--

INSERT INTO `elections` (`id`, `title`, `status`, `created_at`) VALUES
(3, 'Pakistan', 'active', '2026-01-19 16:47:20'),
(4, 'Pakistan', 'closed', '2026-01-19 21:38:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','voter') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'PUT_ADMIN_EMAIL_HERE', 'PUT_ADMIN_PASSWORD_HERE', 'admin', '2026-01-17 09:53:25'),
(2, 'Sameer', 'thatsameerkashif@gmail.com', '$2y$10$rW7FuwP/DsxHagFCDiYBUOKsiIlixhzl/odSU4oDeVKtJn521ev7y', 'voter', '2026-01-17 10:12:31');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `voter_id` int(11) DEFAULT NULL,
  `election_id` int(11) DEFAULT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `voted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `voter_id`, `election_id`, `candidate_id`, `voted_at`) VALUES
(2, 2, 3, 1, '2026-01-19 18:00:57'),
(3, 2, 4, 4, '2026-01-19 21:48:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `election_id` (`election_id`);

--
-- Indexes for table `elections`
--
ALTER TABLE `elections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `voter_id` (`voter_id`,`election_id`),
  ADD UNIQUE KEY `unique_vote` (`voter_id`,`election_id`),
  ADD KEY `election_id` (`election_id`),
  ADD KEY `candidate_id` (`candidate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `elections`
--
ALTER TABLE `elections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`election_id`) REFERENCES `elections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`voter_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`election_id`) REFERENCES `elections` (`id`),
  ADD CONSTRAINT `votes_ibfk_3` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
