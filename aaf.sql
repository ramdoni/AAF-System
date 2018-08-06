-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 31, 2018 at 03:36 PM
-- Server version: 5.7.22-0ubuntu18.04.1
-- PHP Version: 7.2.7-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aaf`
--

-- --------------------------------------------------------

--
-- Table structure for table `exit_interview_inventaris`
--

CREATE TABLE `exit_interview_inventaris` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_inventaris_id` int(11) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `exit_interview_id` int(11) DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exit_interview_inventaris_mobil`
--

CREATE TABLE `exit_interview_inventaris_mobil` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_inventaris_mobil_id` int(11) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `exit_interview_id` int(11) DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organisasi_position`
--

CREATE TABLE `organisasi_position` (
  `id` int(10) UNSIGNED NOT NULL,
  `organisasi_division_id` int(11) DEFAULT NULL,
  `organisasi_department_id` int(11) DEFAULT NULL,
  `organisasi_unit_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organisasi_position`
--

INSERT INTO `organisasi_position` (`id`, `organisasi_division_id`, `organisasi_department_id`, `organisasi_unit_id`, `name`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 'Asisten Manager', '2018-07-25 00:24:39', '2018-07-25 00:24:39'),
(2, NULL, NULL, NULL, 'President Director', '2018-07-25 00:24:50', '2018-07-25 00:24:50'),
(3, NULL, NULL, NULL, 'Director', '2018-07-25 00:24:59', '2018-07-25 00:24:59'),
(4, NULL, NULL, NULL, 'Area Manager', '2018-07-25 00:35:36', '2018-07-25 00:35:36'),
(5, NULL, NULL, NULL, 'Branch Manager', '2018-07-25 00:36:27', '2018-07-25 00:36:27'),
(6, NULL, NULL, NULL, 'Expatriat', '2018-07-25 00:36:39', '2018-07-25 00:36:39'),
(7, NULL, NULL, NULL, 'General Manager', '2018-07-25 00:36:53', '2018-07-25 00:36:53'),
(8, NULL, NULL, NULL, 'Head', '2018-07-25 00:37:02', '2018-07-25 00:37:02'),
(9, NULL, NULL, NULL, 'Manager', '2018-07-25 00:37:10', '2018-07-25 00:37:10'),
(10, NULL, NULL, NULL, 'Senior Advisor', '2018-07-25 00:37:42', '2018-07-25 00:37:42'),
(12, NULL, NULL, NULL, 'Senior Manager', '2018-07-25 00:38:27', '2018-07-25 00:38:27'),
(13, NULL, NULL, NULL, 'Staff', '2018-07-25 00:38:36', '2018-07-25 00:38:36'),
(14, NULL, NULL, NULL, 'Supervisor', '2018-07-25 00:38:49', '2018-07-25 00:38:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exit_interview_inventaris`
--
ALTER TABLE `exit_interview_inventaris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exit_interview_inventaris_mobil`
--
ALTER TABLE `exit_interview_inventaris_mobil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organisasi_position`
--
ALTER TABLE `organisasi_position`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exit_interview_inventaris`
--
ALTER TABLE `exit_interview_inventaris`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `exit_interview_inventaris_mobil`
--
ALTER TABLE `exit_interview_inventaris_mobil`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `organisasi_position`
--
ALTER TABLE `organisasi_position`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
