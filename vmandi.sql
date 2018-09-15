-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2018 at 12:08 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vmandi`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `added_on` datetime NOT NULL,
  `valid_till` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `user_id`, `category_id`, `title`, `description`, `views`, `added_on`, `valid_till`, `status`) VALUES
(1, 1, 1, 'test', 'testing', 0, '2018-09-04 12:22:10', '1970-01-01 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `banner_heading` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `banner_heading`, `banner_description`, `banner_image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '<h1 class=\"head-title\">Welcome to <span class=\"year\">VMANDI</span></h1>', '<p>Buy And Sell Everything From Used Cars To Mobile Phones And Computers, <br> Or Search For Property,\r\n                        Jobs And More</p>', 'http://localhost/V_Mandi/monika/public/image/home_image/home-banner-1536866197.jpg', '2018-09-11 13:53:54', '2018-09-14 02:16:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `parent_category` int(11) NOT NULL DEFAULT '0',
  `added_on` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `parent_category`, `added_on`, `status`) VALUES
(1, 'Vehicles', 'http://localhost/V_Mandi/monika/public/image/category_image/Vehicles-1536563404.png', 0, '2018-09-10 07:10:04', 1),
(2, 'Cars', 'http://localhost/V_Mandi/monika/public/image/category_image/Cars-1536563413.png', 1, '2018-09-10 07:10:13', 1),
(3, 'Cycle', 'http://localhost/V_Mandi/monika/public/image/category_image/Cycle-1536570553.gif', 1, '2018-09-10 07:10:55', 1),
(4, 'Dogs', 'http://localhost/V_Mandi/monika/public/image/category_image/Dogs-1536641253.jpg', 0, '2018-09-11 04:47:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `email_verified` tinyint(4) NOT NULL DEFAULT '0',
  `phone_verified` tinyint(4) NOT NULL DEFAULT '0',
  `type` tinyint(4) NOT NULL COMMENT '1 => Seller, 2 => Buyer',
  `added_on` datetime NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `pincode` int(11) NOT NULL,
  `state` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`, `phone`, `email_verified`, `phone_verified`, `type`, `added_on`, `updated_on`, `status`, `address`, `city`, `pincode`, `state`) VALUES
(1, 'Mahesh kumar', 'mahesh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '8965471230', 0, 0, 0, '2018-09-04 10:35:37', '2018-09-04 10:40:35', 1, '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `market_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `market_name`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Hazratganj', 'Near Moti Mahal', '2018-09-10 16:19:46', '2018-09-10 16:19:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_09_03_094513_create_tests_table', 1),
(4, '2018_09_03_095447_create_testings_table', 1),
(5, '2018_09_05_084423_create_tests_table', 2),
(6, '2018_09_07_101609_create_vendors_table', 3),
(7, '2018_09_10_091904_create_locations_table', 4),
(8, '2018_09_11_050237_create_settings_table', 5),
(9, '2018_09_11_063632_create_banners_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('monika@compaddicts.com', '$2y$10$sHmU3gGjVMteF8u53hIVH.VEWXbfFqx4iJJUlrTQVfub6TIAr8GDS', '2018-09-07 04:51:56');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `banner_heading` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ad_banner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `banner_heading`, `banner_description`, `banner_image`, `ad_banner`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'WELCOME TO VMANDI', 'Buy And Sell Everything From Used Cars To Mobile Phones And Computers, \r\nOr Search For Property, Jobs And More', 'http://localhost/V_Mandi/monika/public/image/home_image/home-banner-1536646523.jpg', 'http://localhost/V_Mandi/monika/public/image/home_image/ad-banner-1536646523.gif', '2018-09-11 12:48:46', '2018-09-11 13:16:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Pradeep', '2018-09-05 03:16:30', '2018-09-05 03:16:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$gbQy8mt9lzPVQXoFOypPTOPrh3ZKSek3zWqxZEG2zBGJLhHg/nIXC', 'Q9jVsfnOWn6FAx8fN6BuiJgrBRI8XBg7UYI3a7hU2vPhZGMCwguz4ZjPc8j6', '2018-09-03 04:36:29', '2018-09-03 04:36:29'),
(2, 'Monika', 'monika@compaddicts.com', '$2y$10$f1Z70GqVRsB2roMBlaGsZ.i4CyvBTaY0m0DHrp1vp5EysO3yyJ7lu', 'PzQN5vJ0THUtuaajFq4wANYvtKjDQ8nVBuuqxcbQeCWVw3B96WCEQgr2GgJX', '2018-09-03 04:47:46', '2018-09-03 05:56:16');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `email`, `phone`, `password`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Somesh', 'somesh@gmail.com', '9459876541', '123456', 1, '2018-09-07 17:17:04', '2018-09-14 02:15:29', NULL),
(2, 'Mahesh', 'mahesh@gmail.com', '6541230987', '987456', 0, '2018-09-07 17:20:08', '2018-09-10 16:48:02', NULL),
(3, 'Rahul', 'rahul@gmail.com', '6541239870', 'p7whK734', 1, '2018-09-10 16:53:40', '2018-09-10 16:54:11', NULL),
(4, 'dfsdf', 'sdfs', '5345', '123', 1, '2018-09-13 07:50:49', '2018-09-13 07:50:49', NULL),
(5, 'abhay', 'abhayjeetsingh19@gmail.com', '1234567', '123456', 1, '2018-09-13 08:37:04', '2018-09-13 08:37:04', NULL),
(6, 'Arun', 'ar@gmail.com', '17678999', 'nGHkZ2Px', 1, '2018-09-14 01:42:34', '2018-09-14 01:42:34', NULL),
(7, 'abhayjeet Singh', 'dfd', '8173954043', 'GElQV2uz', 1, '2018-09-14 02:24:14', '2018-09-14 02:24:14', NULL),
(8, 'abhayjeet Singh', 'dgfdg', '6784535', 'nRiP1wFV', 1, '2018-09-14 02:25:53', '2018-09-14 02:25:53', NULL),
(9, 'dssf', 'dfsf', '565465756', 'hMaeK9q5', 1, '2018-09-14 02:27:11', '2018-09-14 02:27:11', NULL),
(10, 'fsdf', 'sdffs', '456546455', 'jn9cOxa7', 1, '2018-09-14 02:31:39', '2018-09-14 02:31:39', NULL),
(11, 'dfgdg', 'dfgdg', '34535435', '4e5kKUEW', 1, '2018-09-14 02:33:34', '2018-09-14 02:33:34', NULL),
(12, 'fgdg', 'fhggdsd', '86655', 'ncixUFgK', 1, '2018-09-14 02:36:04', '2018-09-14 02:36:04', NULL),
(13, 'fghfh', 'yrty', '4564', 'X5iGTBfV', 1, '2018-09-14 02:42:49', '2018-09-14 02:42:49', NULL),
(14, 'fdgd', 'rte', '445654', '5jCGd7un', 1, '2018-09-14 02:45:47', '2018-09-14 02:45:47', NULL),
(15, 'abhayjeet Singh', 'abhayjee@gmail.com', '37973933', 'pRqRkI81', 1, '2018-09-14 02:48:25', '2018-09-14 02:48:25', NULL),
(16, 'abhayjeet Singh', 'ddj', '37', 'k8karLad', 1, '2018-09-14 02:50:45', '2018-09-14 02:50:45', NULL),
(17, 'Abhya', 'asas8009@gmail.com', '456546', 'dIhiJYmQ', 1, '2018-09-14 02:54:41', '2018-09-14 02:54:41', NULL),
(18, 'fdg', 'erert', '4536', '2sdsvGs5', 1, '2018-09-14 02:57:25', '2018-09-14 02:57:25', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
