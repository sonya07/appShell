-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2018 at 10:50 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appshell`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `username` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `raw_password` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `extra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `raw_password`, `password`, `remember_token`, `created_at`, `updated_at`, `extra`) VALUES
(1, '1', '111', '1@gmail.com', '1', 'd41d8cd98f00b204e9800998ecf8427e', 'qy189bcd4i1t3k679gd1l', NULL, NULL, 1),
(24, 'Sonya Capanna', 'sonya', '14@gmail.com', '1', 'c4ca4238a0b923820dcc509a6f75849b', 'u9ftveu4rvcg9g9mhpxw6', NULL, NULL, 0),
(25, 'bob', 'bob', 'bob@gmail.com', 'b', '92eb5ffee6ae2fec3ad71c777531578f', NULL, NULL, NULL, 0),
(26, 'Bobby', 'Bobby', 'bobby@yahoo.com', 'bob', '9f9d51bc70ef21ca5c14f307980a29d8', 'tlh3e3o3xgaevgvk3rua', NULL, NULL, 0),
(27, 'Ron', 'Ronald', 'ron@gmail.com', 'ron', '45798f269709550d6f6e1d2cf4b7d485', NULL, NULL, NULL, 0),
(28, 'Ron', 'Ron', 'ron@yahoo.com', '1', 'c4ca4238a0b923820dcc509a6f75849b', NULL, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
