-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2017 at 03:21 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phonebook`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `message` text,
  `sender_id` varchar(255) NOT NULL DEFAULT '8801552146206',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `message`, `sender_id`, `created_at`, `updated_at`) VALUES
(1, 'IT Company', 'This is IT Company category.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'IGL client', 'This is IGL client category.\r\nEdit Category Message\r\nhttp://iglweb.com\r\n.\r\n...\r\n', '8801552146206', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'SMS Client', 'This is SMS Client category.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Business', 'IGL Web Ltd. Provides you Web Hosting, Domain Registration and Web Design.', '8801552146206', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'To let', '', '', '2017-07-04 07:07:29', '0000-00-00 00:00:00'),
(6, 'test', 'This is an test sms', '', '2017-07-11 08:07:51', '0000-00-00 00:00:00'),
(8, 'Test2', 'This is no sms for this category', '01686023434', '2017-07-11 15:07:15', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2017-07-01 18:01:00', '0000-00-00 00:00:00'),
(2, 'user', '2017-07-01 18:04:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `numbers`
--

CREATE TABLE `numbers` (
  `id` int(11) NOT NULL,
  `number` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `numbers`
--

INSERT INTO `numbers` (`id`, `number`, `category_id`, `added_by`, `created_at`, `updated_at`) VALUES
(83, '01686023434', 4, 4, '2017-07-04 08:07:06', '0000-00-00 00:00:00'),
(84, '01686023435', 4, 4, '2017-07-04 08:07:16', '0000-00-00 00:00:00'),
(85, '01686023436', 4, 9, '2017-07-04 08:07:03', '0000-00-00 00:00:00'),
(86, '01686023437', 2, 9, '2017-07-04 08:07:41', '0000-00-00 00:00:00'),
(87, '01683023432', 2, 9, '2017-07-04 08:07:20', '0000-00-00 00:00:00'),
(88, '01865987589', 1, 9, '2017-07-04 08:07:42', '0000-00-00 00:00:00'),
(89, '01767248799', 1, 9, '2017-07-04 08:07:13', '0000-00-00 00:00:00'),
(90, '01686023438', 3, 4, '2017-07-04 08:07:53', '0000-00-00 00:00:00'),
(91, '01686023439', 3, 4, '2017-07-04 08:07:19', '0000-00-00 00:00:00'),
(92, '01678037726', 4, 10, '2017-07-04 08:07:53', '0000-00-00 00:00:00'),
(93, '01823037730', 1, 10, '2017-07-04 08:07:33', '0000-00-00 00:00:00'),
(94, '01823037789', 1, 10, '2017-07-04 08:07:41', '0000-00-00 00:00:00'),
(95, '01747731115', 2, 9, '2017-07-04 08:07:38', '0000-00-00 00:00:00'),
(96, '01932384617', 2, 9, '2017-07-04 08:07:58', '0000-00-00 00:00:00'),
(97, '01686023411', 4, 5, '2017-07-04 08:07:44', '0000-00-00 00:00:00'),
(98, '01686023412', 4, 5, '2017-07-04 08:07:07', '0000-00-00 00:00:00'),
(99, '01811037726', 4, 5, '2017-07-04 08:07:56', '0000-00-00 00:00:00'),
(100, '01678334733', 4, 5, '2017-07-04 08:07:12', '0000-00-00 00:00:00'),
(101, '01856987558', 5, 11, '2017-07-09 06:07:13', '0000-00-00 00:00:00'),
(102, '01569875489', 5, 9, '2017-07-09 06:07:30', '0000-00-00 00:00:00'),
(103, '01548795865', 5, 4, '2017-07-09 06:07:50', '0000-00-00 00:00:00'),
(105, '01865987547', 3, 9, '2017-07-09 07:07:02', '0000-00-00 00:00:00'),
(106, '01965478956', 3, 9, '2017-07-09 07:07:36', '0000-00-00 00:00:00'),
(123, '01767248787', 4, 4, '2017-07-11 15:07:37', '0000-00-00 00:00:00'),
(124, '01767248797', 4, 4, '2017-07-11 15:07:24', '0000-00-00 00:00:00'),
(125, '01823037726', 4, 4, '2017-07-11 15:07:22', '0000-00-00 00:00:00'),
(126, '01678042908', 2, 4, '2017-07-11 15:07:35', '0000-00-00 00:00:00'),
(127, '01814445932', 2, 10, '2017-07-11 15:07:29', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `mobile`, `name`, `password`, `group_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'mehedi', '01767248797', 'Mehedi Hasan', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'monirul', '01686023434', 'Monirul Islam', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'm', '01823037726', '123', '2ac9a6746aca543af8dff39894cfe8173afba21eb01c6fae33d52947222855ef', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'mm', '01767248798', 'mm man', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'mmm', '01823037727', 'mmm', '2ac9a6746aca543af8dff39894cfe8173afba21eb01c6fae33d52947222855ef', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'm1', '01897586548', 'M1 man', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 2, '2017-07-09 06:07:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `numbers`
--
ALTER TABLE `numbers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD KEY `group_id` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `numbers`
--
ALTER TABLE `numbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `numbers`
--
ALTER TABLE `numbers`
  ADD CONSTRAINT `numbers_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
