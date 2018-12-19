-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2018 at 05:49 PM
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
  `description` text,
  `price` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT ' ',
  `breed_name` varchar(255) DEFAULT '',
  `address` text,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `location` text,
  `views` int(11) NOT NULL DEFAULT '0',
  `added_on` datetime NOT NULL,
  `valid_till` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `user_id`, `category_id`, `title`, `description`, `price`, `unit`, `brand_name`, `breed_name`, `address`, `city`, `state`, `pincode`, `location`, `views`, `added_on`, `valid_till`, `status`) VALUES
(36, 12, 37, 'Cow Milk', 'Milk is a nutrient-rich, white liquid food produced by the mammary glands of mammals. It is the primary source of nutrition for infant mammals before they are able to digest other types of food.', '79', 'litre', NULL, NULL, 'Balda road 23 Lucknow', 'Lucknow', '23', 212234, NULL, 66, '2018-12-14 15:24:54', '1970-01-01 05:30:00', 1),
(37, 12, 45, 'Cute Dog', 'The domestic dog is a member of the genus Canis, which forms part of the wolf-like canids, and is the most widely abundant terrestrial carnivore', '24000', 'piece', NULL, NULL, 'Balda road 23 Lucknow', 'Lucknow', 'UTTAR PRADESH', 212234, NULL, 27, '2018-12-14 15:29:50', '1970-01-01 05:30:00', 1),
(38, 12, 39, 'Jersy Cow', 'The Jersey is a breed of small dairy cattle. Originally bred in the Channel Island of Jersey, the breed is popular for the high butterfat content of its milk and the lower maintenance costs attending its lower bodyweight, as well as its genial disposition', '17000', 'piece', NULL, 'Jersy', 'Balda road 23 Lucknow', 'Lucknow', 'UTTAR PRADESH', 212234, NULL, 0, '2018-12-14 15:31:23', '1970-01-01 05:30:00', 1),
(39, 12, 41, 'Goat', 'The domestic goat or simply goat is a subspecies of C. aegagrus domesticated from the wild goat of Southwest Asia and Eastern Europe.', '2500', 'piece', NULL, NULL, 'Balda road 23', 'Lucknow', 'UTTAR PRADESH', 212234, NULL, 45, '2018-12-14 15:33:31', '1970-01-01 05:30:00', 1),
(40, 12, 43, 'Fish', 'Fish are gill-bearing aquatic craniate animals that lack limbs with digits. They form a sister group to the tunicates, together forming the olfactores', '160', 'dozen', NULL, NULL, 'Balda road 23 Lucknow', 'Lucknow', 'UTTAR PRADESH', 212234, NULL, 42, '2018-12-14 15:34:36', '1970-01-01 05:30:00', 1),
(41, 12, 63, 'Broadcasting', 'Broadcasting is the distribution of audio or video content to a dispersed audience via any electronic mass communications medium, but typically one using the electromagnetic spectrum (radio waves), in a one-to-many model.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2018-12-19 18:02:28', '1970-01-01 05:30:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dimension` int(11) DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advertisements`
--

INSERT INTO `advertisements` (`id`, `image`, `dimension`, `url`, `start_date`, `end_date`, `client`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(27, 'public/image/advertisement_image/advertisement-1545192569.png', 1, 'https://vmandi.com/', '2018-12-19', '2018-12-25', '1', '2018-12-19 04:09:29', '2018-12-19 04:09:29', NULL, 1),
(28, 'public/image/advertisement_image/advertisement-1545192588.jpg', 2, 'https://vmandi.com/', '2018-12-19', '2018-12-28', '1', '2018-12-19 04:09:48', '2018-12-19 04:09:48', NULL, 1),
(29, 'public/image/advertisement_image/advertisement-1545194926.jpg', 3, 'https://vmandi.com/', '2018-12-19', '2018-12-21', '1', '2018-12-19 04:48:46', '2018-12-19 04:48:46', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `advertisement_clients`
--

CREATE TABLE `advertisement_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `advertisement_clients`
--

INSERT INTO `advertisement_clients` (`id`, `name`, `email`, `mobile`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 'abhayjeet Singh', 'abhayjeetsingh19@gmail.com', '8173954048', '2018-12-17 06:48:41', '2018-12-17 06:48:41', NULL, 1),
(2, 'monika', 'monikacs0026@gmail.com', '9721552525', '2018-12-17 08:32:26', '2018-12-17 08:32:26', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ad_dimensions`
--

CREATE TABLE `ad_dimensions` (
  `id` int(10) UNSIGNED NOT NULL,
  `dimension` varchar(200) NOT NULL,
  `position_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ad_dimensions`
--

INSERT INTO `ad_dimensions` (`id`, `dimension`, `position_name`) VALUES
(1, '857X250', 'Home Top '),
(2, '822X240', 'Home Footer '),
(3, '250X480', 'Inner Page (Right)');

-- --------------------------------------------------------

--
-- Table structure for table `ad_enquiry`
--

CREATE TABLE `ad_enquiry` (
  `id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` tinyint(4) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ad_enquiry`
--

INSERT INTO `ad_enquiry` (`id`, `ad_id`, `user_id`, `user_type`, `message`, `created_at`) VALUES
(26, 30, 1, 1, 'ooo', '2018-12-13 15:26:09');

-- --------------------------------------------------------

--
-- Table structure for table `ad_images`
--

CREATE TABLE `ad_images` (
  `id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ad_images`
--

INSERT INTO `ad_images` (`id`, `ad_id`, `image`) VALUES
(124, 40, 'https://vmandi.com/admin_test/public/image/ad_images/40_1544781876_0.jpg'),
(123, 39, 'https://vmandi.com/admin_test/public/image/ad_images/39_1544781811_0.jpg'),
(122, 38, 'https://vmandi.com/admin_test/public/image/ad_images/38_1544781683_0.jpg'),
(121, 37, 'https://vmandi.com/admin_test/public/image/ad_images/37_1544781590_1.jpg'),
(120, 37, 'https://vmandi.com/admin_test/public/image/ad_images/37_1544781590_0.jpg'),
(118, 36, 'https://vmandi.com/admin_test/public/image/ad_images/36_1544781299_0.jpg'),
(119, 36, 'https://vmandi.com/admin_test/public/image/ad_images/36_1544781299_1.jpg'),
(125, 41, 'http://localhost/admin_test/public/image/ad_images/41_1545222748_0.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ad_locations`
--

CREATE TABLE `ad_locations` (
  `id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `location` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ad_units`
--

CREATE TABLE `ad_units` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ad_units`
--

INSERT INTO `ad_units` (`id`, `name`) VALUES
(1, 'piece'),
(2, 'litre'),
(3, 'dozen'),
(4, 'kilogram'),
(5, 'other');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `banner_heading` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `banner_description` text COLLATE utf8mb4_unicode_ci,
  `banner_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ad_banner` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loader` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_page_link` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_page_link` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instragram_page_link` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_page_lnik` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `android_play_store_link` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ios_app_store_link` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `banner_heading`, `banner_description`, `banner_image`, `ad_banner`, `logo`, `loader`, `email`, `mobile`, `fb_page_link`, `twitter_page_link`, `instragram_page_link`, `google_page_lnik`, `android_play_store_link`, `ios_app_store_link`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, '<p><span style=\"font-size: 24pt;\">India\'s Largest Mandi - VMandi</span></p>', NULL, 'public/image/home_image/home-banner-1544982143.jpg', NULL, 'public/image/home_image/logo-1544989485.png', 'public/image/logo/loader-1544981349.gif', NULL, '8956896790', 'https://www.facebook.com/VMandi-2186590064916467/?modal=admin_todo_tour', NULL, 'https://www.instagram.com/vmand1311/', NULL, NULL, NULL, '2018-12-16 17:29:09', '2018-12-16 19:44:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `unit` varchar(255) NOT NULL,
  `parent_category` int(11) NOT NULL DEFAULT '0',
  `category_order` int(11) NOT NULL DEFAULT '0',
  `added_on` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `description`, `unit`, `parent_category`, `category_order`, `added_on`, `status`) VALUES
(14, 'Dogs', 'http://vmandi.com/admin_test/public/image/category_image/Dogs-1542122480.png', 'The domestic dog is a member of the genus Canis, which forms part of the wolf-like canids, and is the most widely abundant terrestrial carnivore.', 'piece', 0, 4, '2018-09-18 05:45:16', 1),
(15, 'Fishries', 'http://vmandi.com/admin_test/public/image/category_image/Fishries-1542122469.png', 'Generally, a fishery is an entity engaged in raising or harvesting fish which is determined by some authority to be a fishery', 'dozen', 0, 3, '2018-09-18 05:46:46', 1),
(17, 'Piggry', 'http://vmandi.com/admin_test/public/image/category_image/Piggry-1542122496.png', 'Intensive pig farming is a subset of pig farming and of Industrial animal agriculture', 'piece', 0, 5, '2018-09-18 05:50:33', 1),
(18, 'Ask Doctor', 'http://vmandi.com/admin_test/public/image/category_image/Ask Doctor-1542122522.png', 'A physician, medical practitioner, medical doctor, or simply doctor is a professional', 'piece', 0, 7, '2018-09-18 05:51:26', 1),
(20, 'Grain', 'http://vmandi.com/admin_test/public/image/category_image/Grain-1542122509.png', 'A grain is a small, hard, dry seed, with or without an attached hull or fruit layer, harvested for human or animal consumption.', 'kg', 0, 6, '2018-09-18 05:51:56', 1),
(27, 'Poultry', 'http://vmandi.com/admin_test/public/image/category_image/Poultry-1542089333.png', 'Poultry are domesticated birds kept by humans for their eggs, their meat or their feathers.', 'piece', 0, 1, '2018-09-24 10:59:06', 1),
(28, 'Cattle', 'http://vmandi.com/admin_test/public/image/category_image/Cattle-1542122457.png', 'Cattle—colloquially cows—are the most common type of large domesticated ungulates', 'piece', 0, 2, '2018-09-24 10:59:30', 1),
(29, 'Broilers Chicks', 'http://vmandi.com/admin/public/image/category_image/Broilers Chicks-1537787005.png', 'Broilers Chicks', 'piece', 27, 0, '2018-09-24 11:03:25', 1),
(30, 'Layers Chicks', 'http://vmandi.com/admin/public/image/category_image/Layers Chicks-1537787021.png', 'Layers Chicks', 'piece', 27, 0, '2018-09-24 11:03:41', 1),
(31, 'Broilers', 'http://vmandi.com/admin/public/image/category_image/Broilers-1537787036.png', 'Broilers', 'piece', 27, 0, '2018-09-24 11:03:56', 1),
(32, 'Layers', 'http://vmandi.com/admin/public/image/category_image/Layers-1537787075.png', 'Layers', 'piece', 27, 0, '2018-09-24 11:04:35', 1),
(35, 'Breeder Eggs', 'http://vmandi.com/admin/public/image/category_image/Breeder Eggs-1537787144.png', 'Breeder Eggs', 'dozen', 27, 0, '2018-09-24 11:05:44', 1),
(37, 'Cow Milk', 'http://vmandi.com/admin/public/image/category_image/Cow Milk-1537787875.png', 'Cow Milk', 'litre', 28, 0, '2018-09-24 11:17:55', 1),
(38, 'Buffalo Milk', 'http://vmandi.com/admin/public/image/category_image/Buffalo Milk-1537787911.png', 'Buffalo Milk', 'litre', 28, 0, '2018-09-24 11:18:31', 1),
(39, 'Cow', 'http://vmandi.com/admin/public/image/category_image/Cow-1537787942.png', 'Cow', 'piece', 28, 0, '2018-09-24 11:19:02', 1),
(40, 'Buffalo', 'http://vmandi.com/admin/public/image/category_image/Buffalo-1537787958.png', 'Buffalo', 'piece', 28, 0, '2018-09-24 11:19:18', 1),
(41, 'Goat/Sheep', 'http://vmandi.com/admin/public/image/category_image/Goat/Sheep-1537787977.png', 'Goat/Sheep', 'piece', 28, 0, '2018-09-24 11:19:37', 1),
(42, 'Dairy Products', 'http://vmandi.com/admin/public/image/category_image/Dairy Products-1537788000.png', 'Dairy Products', 'piece', 28, 0, '2018-09-24 11:20:00', 1),
(43, 'Fish', 'http://vmandi.com/admin/public/image/category_image/Fish-1537788091.png', 'Fish', 'dozen', 15, 0, '2018-09-24 11:21:31', 1),
(44, 'Fish Eggs', 'http://vmandi.com/admin/public/image/category_image/Fish Eggs-1537788113.png', 'Fish Eggs', 'dozen', 15, 0, '2018-09-24 11:21:53', 1),
(45, 'Puppies', 'http://vmandi.com/admin/public/image/category_image/Puppies-1537788149.png', 'Puppies', 'piece', 14, 0, '2018-09-24 11:22:29', 1),
(46, 'Dog Parlour', 'http://vmandi.com/admin/public/image/category_image/Dog Parlour-1537788172.png', 'Dog Parlour', 'dog', 14, 0, '2018-09-24 11:22:52', 1),
(47, 'Training', 'http://vmandi.com/admin/public/image/category_image/Training-1537788189.png', 'Training', 'dog', 14, 0, '2018-09-24 11:23:09', 1),
(48, 'Dog Feed', 'http://vmandi.com/admin/public/image/category_image/Dog Feed-1537788214.png', 'Dog Feed', 'dog', 14, 0, '2018-09-24 11:23:34', 1),
(49, 'Piglets', 'http://vmandi.com/admin/public/image/category_image/Piglets-1537788253.png', 'Piglets', 'piece', 17, 0, '2018-09-24 11:24:13', 1),
(50, 'Pig', 'http://vmandi.com/admin/public/image/category_image/Pig-1537788263.png', 'Pig', 'piece', 17, 0, '2018-09-24 11:24:23', 1),
(51, 'Pig Feeds', 'http://vmandi.com/admin/public/image/category_image/Pig Feeds-1537788280.png', 'Pig Feeds', 'piece', 17, 0, '2018-09-24 11:24:40', 1),
(52, 'Maize', 'http://vmandi.com/admin/public/image/category_image/Maize-1537788341.png', 'Maize', 'kg', 20, 0, '2018-09-24 11:25:41', 1),
(53, 'Soya', 'http://vmandi.com/admin/public/image/category_image/Soya-1537788358.png', 'Soya', 'kg', 20, 0, '2018-09-24 11:25:58', 1),
(54, 'MDOC', 'http://vmandi.com/admin/public/image/category_image/MDOC-1537788375.png', 'MDOC', 'kg', 20, 0, '2018-09-24 11:26:15', 1),
(55, 'DORB', 'http://vmandi.com/admin/public/image/category_image/DORB-1537788394.png', 'DORB', 'kg', 20, 0, '2018-09-24 11:26:34', 1),
(56, 'Rice Polish', 'http://vmandi.com/admin/public/image/category_image/Rice Polish-1537788421.png', 'Rice Polish', 'kg', 20, 0, '2018-09-24 11:27:01', 1),
(57, 'DCP', 'http://vmandi.com/admin/public/image/category_image/DCP-1537788434.png', 'DCP', 'kg', 20, 0, '2018-09-24 11:27:14', 1),
(58, 'Poultry', 'http://vmandi.com/admin/public/image/category_image/Poultry-1537788550.png', 'Poultry', 'piece', 18, 0, '2018-09-24 11:29:10', 1),
(59, 'Cattle', 'http://vmandi.com/admin/public/image/category_image/Cattle-1537788571.png', 'Cattle', 'piece', 18, 0, '2018-09-24 11:29:31', 1),
(60, 'Fishries', 'http://vmandi.com/admin/public/image/category_image/Fishries-1537788592.png', 'Fishries', 'piece', 18, 0, '2018-09-24 11:29:52', 1),
(61, 'Dogs', 'http://vmandi.com/admin/public/image/category_image/Dogs-1537788615.png', 'Dogs', 'piece', 18, 0, '2018-09-24 11:30:15', 1),
(62, 'Piggry', 'http://vmandi.com/admin/public/image/category_image/Piggry-1537788652.png', 'Piggry', 'piece', 18, 0, '2018-09-24 11:30:52', 1),
(63, 'Broadcasting', 'http://vmandi.com/admin_test/public/image/category_image/Broadcasting-1542122533.png', 'Broadcasting is the distribution of audio or video content to a dispersed audience via any electronic mass communications medium', 'hour', 0, 8, '2018-09-24 11:35:12', 1),
(64, 'Commercial broadcasting', 'http://vmandi.com/admin/public/image/category_image/Commercial broadcasting-1537789070.png', 'Commercial broadcasting', 'hour', 63, 0, '2018-09-24 11:37:50', 1),
(65, 'Public broadcasting', 'http://vmandi.com/admin/public/image/category_image/Public broadcasting-1537789096.png', 'Public broadcasting', 'hour', 63, 0, '2018-09-24 11:38:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `id` int(11) NOT NULL,
  `title` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `title`, `content`) VALUES
(1, 1, '<p><strong><span style=\"color: #000000; font-size: 18pt;\">L<span style=\"font-family: Verdana, Arial, Helvetica, sans-serif; text-align: start;\"><em>orem Ipsum<span style=\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">&nbsp;is simply dummy text of the printing</span></em></span></span></strong></p>\r\n<p>&nbsp;</p>\r\n<p class=\"MsoNormal\">Video provides a powerful way to help you prove your point. When you click Online Video, you can paste in the embed code for the video you want to add. You can also type a keyword to search online for the video that best fits your document. To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. For example, you can add a matching cover page, header, and sidebar. Click Insert and then choose the elements you want from the different galleries. Themes and styles also help keep your document coordinated. When you click Design and choose a new Theme, the pictures, charts, and SmartArt graphics change to match your new theme. When you apply styles, your headings change to match the new theme. Save time in Word with new buttons that show up where you need them. To change the way a picture fits in your document, click it and a button for layout options appears next to it. When you work on a table, click where you want to add a row or a column, and then click the plus sign.</p>\r\n<p class=\"MsoNormal\">&nbsp;</p>\r\n<p class=\"MsoNormal\">Reading is easier, too, in the new Reading view. You can collapse parts of the document and focus on the text you want. If you need to stop reading before you reach the end, Word remembers where you left off - even on another device. Video provides a powerful way to help you prove your point. When you click Online Video, you can paste in the embed code for the video you want to add. You can also type a keyword to search online for the video that best fits your document. To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. For example, you can add a matching cover page, header, and sidebar. Click Insert and then choose the elements you want from the different galleries. Themes and styles also help keep your document coordinated. When you click Design and choose a new Theme, the pictures, charts, and SmartArt graphics change to match your new theme. When you apply styles, your headings change to match the new theme.</p>\r\n<p class=\"MsoNormal\">&nbsp;</p>\r\n<p class=\"MsoNormal\">Save time in Word with new buttons that show up where you need them. To change the way a picture fits in your document, click it and a button for layout options appears next to it. When you work on a table, click where you want to add a row or a column, and then click the plus sign. Reading is easier, too, in the new Reading view. You can collapse parts of the document and focus on the text you want. If you need to stop reading before you reach the end, Word remembers where you left off - even on another device. Video provides a powerful way to help you prove your point. When you click Online Video, you can paste in the embed code for the video you want to add. You can also type a keyword to search online for the video that best fits your document. To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. For example, you can add a matching cover page, header, and sidebar. Click Insert and then choose the elements you want from the different galleries.</p>\r\n<p class=\"MsoNormal\">&nbsp;</p>\r\n<p class=\"MsoNormal\">&nbsp;</p>'),
(2, 2, '<p><strong><span style=\"color: #000000; font-size: 18pt;\">L<span><em>orem Ipsum<span style=\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">&nbsp;is simply dummy text of the printing</span></em></span></span></strong></p>\r\n<p>&nbsp;</p>\r\n<p class=\"MsoNormal\">Video provides a powerful way to help you prove your point. When you click Online Video, you can paste in the embed code for the video you want to add. You can also type a keyword to search online for the video that best fits your document. To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. For example, you can add a matching cover page, header, and sidebar. Click Insert and then choose the elements you want from the different galleries. Themes and styles also help keep your document coordinated. When you click Design and choose a new Theme, the pictures, charts, and SmartArt graphics change to match your new theme. When you apply styles, your headings change to match the new theme. Save time in Word with new buttons that show up where you need them. To change the way a picture fits in your document, click it and a button for layout options appears next to it. When you work on a table, click where you want to add a row or a column, and then click the plus sign.</p>\r\n<p class=\"MsoNormal\">&nbsp;</p>\r\n<p class=\"MsoNormal\">Reading is easier, too, in the new Reading view. You can collapse parts of the document and focus on the text you want. If you need to stop reading before you reach the end, Word remembers where you left off - even on another device. Video provides a powerful way to help you prove your point. When you click Online Video, you can paste in the embed code for the video you want to add. You can also type a keyword to search online for the video that best fits your document. To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. For example, you can add a matching cover page, header, and sidebar. Click Insert and then choose the elements you want from the different galleries. Themes and styles also help keep your document coordinated. When you click Design and choose a new Theme, the pictures, charts, and SmartArt graphics change to match your new theme. When you apply styles, your headings change to match the new theme.</p>\r\n<p class=\"MsoNormal\">&nbsp;</p>\r\n<p class=\"MsoNormal\">Save time in Word with new buttons that show up where you need them. To change the way a picture fits in your document, click it and a button for layout options appears next to it. When you work on a table, click where you want to add a row or a column, and then click the plus sign. Reading is easier, too, in the new Reading view. You can collapse parts of the document and focus on the text you want. If you need to stop reading before you reach the end, Word remembers where you left off - even on another device. Video provides a powerful way to help you prove your point. When you click Online Video, you can paste in the embed code for the video you want to add. You can also type a keyword to search online for the video that best fits your document. To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. For example, you can add a matching cover page, header, and sidebar. Click Insert and then choose the elements you want from the different galleries.</p>\r\n<p class=\"MsoNormal\">&nbsp;</p>'),
(3, 3, '<p><strong><span style=\"color: #000000; font-size: 18pt;\">L<span><em>orem Ipsum<span style=\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">&nbsp;is simply dummy text of the printing</span></em></span></span></strong></p>\r\n<p>&nbsp;</p>\r\n<p class=\"MsoNormal\">Video provides a powerful way to help you prove your point. When you click Online Video, you can paste in the embed code for the video you want to add. You can also type a keyword to search online for the video that best fits your document. To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. For example, you can add a matching cover page, header, and sidebar. Click Insert and then choose the elements you want from the different galleries. Themes and styles also help keep your document coordinated. When you click Design and choose a new Theme, the pictures, charts, and SmartArt graphics change to match your new theme. When you apply styles, your headings change to match the new theme. Save time in Word with new buttons that show up where you need them. To change the way a picture fits in your document, click it and a button for layout options appears next to it. When you work on a table, click where you want to add a row or a column, and then click the plus sign.</p>\r\n<p class=\"MsoNormal\">&nbsp;</p>\r\n<p class=\"MsoNormal\">Reading is easier, too, in the new Reading view. You can collapse parts of the document and focus on the text you want. If you need to stop reading before you reach the end, Word remembers where you left off - even on another device. Video provides a powerful way to help you prove your point. When you click Online Video, you can paste in the embed code for the video you want to add. You can also type a keyword to search online for the video that best fits your document. To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. For example, you can add a matching cover page, header, and sidebar. Click Insert and then choose the elements you want from the different galleries. Themes and styles also help keep your document coordinated. When you click Design and choose a new Theme, the pictures, charts, and SmartArt graphics change to match your new theme. When you apply styles, your headings change to match the new theme.</p>\r\n<p class=\"MsoNormal\">&nbsp;</p>\r\n<p class=\"MsoNormal\">Save time in Word with new buttons that show up where you need them. To change the way a picture fits in your document, click it and a button for layout options appears next to it. When you work on a table, click where you want to add a row or a column, and then click the plus sign. Reading is easier, too, in the new Reading view. You can collapse parts of the document and focus on the text you want. If you need to stop reading before you reach the end, Word remembers where you left off - even on another device. Video provides a powerful way to help you prove your point. When you click Online Video, you can paste in the embed code for the video you want to add. You can also type a keyword to search online for the video that best fits your document. To make your document look professionally produced, Word provides header, footer, cover page, and text box designs that complement each other. For example, you can add a matching cover page, header, and sidebar. Click Insert and then choose the elements you want from the different galleries.</p>\r\n<p class=\"MsoNormal\">&nbsp;</p>');

-- --------------------------------------------------------

--
-- Table structure for table `cms_title`
--

CREATE TABLE `cms_title` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_title`
--

INSERT INTO `cms_title` (`id`, `title`, `title_key`) VALUES
(1, 'About Us', 'about-us'),
(2, 'Privacy Policy', 'privacy-policy'),
(3, 'Terms and conditions', 'terms-and-conditions'),
(4, 'Purchase Protection', 'purchase-protection');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `msg` text NOT NULL,
  `posted_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `mobile_no`, `subject`, `msg`, `posted_on`) VALUES
(1, 'Test', 'test@gmail.com', '9632587410', 'Testing contact', 'For other uses, see Message (disambiguation).\n\"Communiqué\" redirects here. For other uses, see Communiqué (disambiguation).\nNot to be confused with Massage or Messuage.', '2018-11-15 16:06:19'),
(2, 'abhayjeet Singh', 'abhayjeet.compaddicts@gmail.com', '8173954048', 'Subject', 'Hello', '2018-11-15 18:16:53'),
(3, 'abhayjeet Singh', 'a@gmail.com', '8173954048', 'Quality', 'safsf', '2018-11-15 18:20:14'),
(4, 'abhayjeet Singh', 'a@gmail.com', '8173954048', 'Quality', 'sada', '2018-11-15 18:23:07'),
(5, 'vmandi', 'abhayjeet@gmail.com', '8173954048', 'Quality', 'Message', '2018-12-07 16:29:18');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email_verified` tinyint(4) NOT NULL DEFAULT '0',
  `phone_verified` tinyint(4) NOT NULL DEFAULT '0',
  `added_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `provider_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'Hazratganj', 'Next to Central Bank of India, No.75, Mahatma Gandhi Marg, Sushanpura, Hazratganj, Lucknow, Uttar Pradesh 226001', '2018-09-10 16:19:46', '2018-11-13 10:38:18', NULL),
(2, 'Gomtinagar', 'NH 28, Vipin Khand, Gomti Nagar, Lucknow, Uttar Pradesh 226016', '2018-11-13 10:37:46', '2018-11-13 10:37:46', NULL),
(3, 'Lalbagh', 'Dhyanidhan Park Road, Lalbagh Crossing, Lucknow, Uttar Pradesh 226001', '2018-11-13 10:39:20', '2018-11-13 10:39:20', NULL),
(4, 'Alambagh', 'NH 25, Railway Colony, Alambagh, Lucknow, Uttar Pradesh 226005', '2018-11-13 10:40:10', '2018-11-13 10:40:10', NULL);

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
(9, '2018_09_11_063632_create_banners_table', 6),
(10, '2018_12_17_115441_create_testings_table', 7),
(11, '2018_12_17_120037_create_clients_table', 8),
(12, '2018_12_17_120735_create_clients_table', 9),
(13, '2018_12_17_121745_create_advertisement_clients_table', 10),
(14, '2018_12_17_122426_create_advertisements_table', 11);

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
('monika@compaddicts.com', '$2y$10$fEwxluOGGpUJn9NujUoyley4d2mBY38jwwt3VgkiINhMmLkL6.USe', '2018-09-16 05:15:21');

-- --------------------------------------------------------

--
-- Table structure for table `receive_alert_users`
--

CREATE TABLE `receive_alert_users` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `locality` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `receive_alert_users`
--

INSERT INTO `receive_alert_users` (`id`, `category`, `locality`, `email`, `mobile`) VALUES
(1, 29, 1, 'admin@gmail.com', '8173954047'),
(2, 56, 1, 'admin@gmail.com', '8173954048'),
(3, 29, 1, 'admin@gmail.com', '8173954048'),
(4, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(5, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(6, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(7, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(8, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(9, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(10, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(11, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(12, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(13, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(14, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(15, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(16, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(17, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(18, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(19, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(20, 37, 1, 'bhaskarastro@gmail.com', '7071459012'),
(21, 31, 1, 'sonal.gupta.cs@gmail.com', '9876543210'),
(22, 31, 1, 'sonal.gupta.cs@gmail.com', '9876543210'),
(23, 29, 1, 'team@compaddicts.in', '9169705400'),
(24, 29, 1, 'team@compaddicts.in', '9169705400'),
(25, 29, 1, 'team@compaddicts.in', '9169705400'),
(26, 29, 1, 'team@compaddicts.in', '9169705400'),
(27, 29, 2, 'abhayjeet.compaddicts@gmail.com', '8173954047'),
(28, 29, 2, 'abhayjeet.compaddicts@gmail.com', '8173954047'),
(29, 30, 1, 'abhayjeet.compaddicts@gmail.com', '8173954048'),
(30, 28, 1, 'abhayjeet.compaddicts@gmail.com', '8173954047'),
(31, 37, 1, 'abhayjeet.compaddicts@gmail.com', '8173954047'),
(32, 38, 1, 'abhayjeet.compaddicts@gmail.com', '8173954047'),
(33, 38, 1, 'abhayjeet.compaddicts@gmail.com', '8173954047'),
(34, 38, 2, 'abhayjeet.compaddicts@gmail.com', '8173954047'),
(35, 31, 2, 'abhayjeet.compaddicts@gmail.com', '8173954047'),
(36, 38, 1, 'a@gmail.com', '8173954047'),
(37, 30, 1, 'abhayjeet.compaddicts@gmail.com', '8173954047'),
(38, 38, 2, 'abhayjeet.compaddicts@gmail.com', '8173954048'),
(39, 38, 1, 'abhayjeet.compaddicts@gmail.com', '8173954048'),
(40, 43, 1, 'abhayjeet.compaddicts@gmail.com', '8173954047'),
(41, 44, 1, 'team@compaddicts.in', '9898878787'),
(42, 39, 2, 'monika.compaddicts@gmail.com', '9452932893'),
(43, 65, 2, 'monika.compaddicts@gmail.com', '9452932893'),
(44, 28, 2, 'abhayjeet@gmail.com', '8173954048'),
(45, 28, 2, 'abhayjeet@gmail.com', '8173954048');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `information` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `review` varchar(1200) NOT NULL,
  `rating` smallint(5) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `state_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `state_name`) VALUES
(1, 'ANDHRA PRADESH'),
(2, 'ASSAM'),
(3, 'ARUNACHAL PRADESH'),
(4, 'GUJRAT'),
(5, 'BIHAR'),
(6, 'HARYANA'),
(7, 'HIMACHAL PRADESH'),
(8, 'JAMMU & KASHMIR'),
(9, 'KARNATAKA'),
(10, 'KERALA'),
(11, 'MADHYA PRADESH'),
(12, 'MAHARASHTRA'),
(13, 'MANIPUR'),
(14, 'MEGHALAYA'),
(15, 'MIZORAM'),
(16, 'NAGALAND'),
(17, 'ORISSA'),
(18, 'PUNJAB'),
(19, 'RAJASTHAN'),
(20, 'SIKKIM'),
(21, 'TAMIL NADU'),
(22, 'TRIPURA'),
(23, 'UTTAR PRADESH'),
(24, 'WEST BENGAL'),
(25, 'DELHI'),
(26, 'GOA'),
(27, 'PONDICHERY'),
(28, 'LAKSHDWEEP'),
(29, 'DAMAN & DIU'),
(30, 'DADRA & NAGAR'),
(31, 'CHANDIGARH'),
(32, 'ANDAMAN & NICOBAR'),
(33, 'UTTARANCHAL'),
(34, 'JHARKHAND'),
(35, 'CHATTISGARH');

-- --------------------------------------------------------

--
-- Table structure for table `testings`
--

CREATE TABLE `testings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testings`
--

INSERT INTO `testings` (`id`, `name`, `email`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'werwr', 'wer@gmail.com', '2018-12-17 06:26:09', '2018-12-17 06:26:20', '2018-12-17 06:26:20');

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
-- Table structure for table `ticker`
--

CREATE TABLE `ticker` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticker`
--

INSERT INTO `ticker` (`id`, `product_name`, `product_price`) VALUES
(1, 'Fish', '20.00'),
(5, 'Eggs', '52.00'),
(6, 'Goat', '2398.23');

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
(1, 'Admin', 'admin@gmail.com', '$2y$10$qb5j9Hv7EoVUFr4jFiMZA.uOz/3nVgoy7074jyqR8hlf2Onu7DyIS', 'L3TA4KnxGeO6FzIl4dAt8FRn2uHZCz8ow61z7nRKwlJ7x7M5wCm1sbGzboqR', '2018-09-03 04:36:29', '2018-10-18 17:24:38'),
(2, 'Monika', 'monika.compaddicts@gmail.com', '$2y$10$OLn6IT9/XSJg9PZOs5XkHeW8cA1SN9HzE5hk6Kwu8zstBInVHl9SO', 'bcxQr0djakBlyC5zFIi0GoqtuMgxC9dUNYHUSVOxhs4qYLF3BVjUBg8VKYAD', '2018-09-03 04:47:46', '2018-10-18 11:28:19'),
(3, 'Bhaskar', 'bhaskar.compaddicts@gmail.com', '$2y$10$Yv2pKn.2fdNEjKyAqm37DOvjKSHKns5.juCai6Xt2CilAsCc2Fr2i', NULL, '2018-10-17 04:52:52', '2018-10-17 04:52:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL COMMENT '1 => Vendor, 2 => Customer',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `user_type`, `user_id`) VALUES
(11, 1, 29),
(12, 2, 2),
(13, 2, 3),
(14, 1, 32),
(15, 1, 33),
(16, 1, 34),
(17, 1, 35),
(18, 1, 36),
(19, 2, 6),
(20, 1, 37),
(21, 1, 38),
(22, 1, 39),
(23, 1, 40),
(24, 2, 7),
(25, 1, 41),
(26, 2, 8),
(27, 1, 42),
(28, 1, 43),
(29, 1, 44),
(30, 2, 9),
(31, 2, 10),
(32, 1, 45),
(33, 2, 11),
(34, 1, 46),
(35, 2, 12),
(36, 2, 13),
(37, 2, 14),
(38, 2, 15),
(39, 2, 16),
(40, 2, 17),
(41, 2, 18),
(42, 2, 19),
(43, 2, 20),
(44, 2, 21),
(45, 2, 22),
(46, 1, 47),
(47, 2, 23),
(48, 2, 24),
(49, 2, 25),
(50, 1, 48),
(51, 2, 26),
(52, 2, 27),
(53, 2, 28),
(54, 1, 49),
(55, 1, 50),
(56, 1, 51),
(57, 1, 52),
(58, 1, 53),
(59, 1, 54),
(60, 1, 55),
(61, 1, 56),
(62, 1, 57),
(63, 1, 58),
(64, 1, 59),
(65, 1, 60),
(66, 1, 61),
(67, 1, 62),
(68, 1, 63),
(69, 1, 64),
(70, 1, 65),
(71, 1, 66),
(72, 1, 1),
(73, 1, 2),
(74, 2, 1),
(75, 1, 3),
(76, 1, 4),
(77, 1, 5),
(78, 1, 6),
(79, 1, 7),
(80, 1, 8),
(81, 1, 9),
(82, 1, 10),
(83, 0, 2),
(84, 1, 11),
(85, 1, 12),
(86, 1, 13),
(87, 1, 14),
(88, 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `house` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `email`, `phone`, `password`, `status`, `house`, `address`, `pincode`, `city`, `created_at`, `updated_at`, `deleted_at`, `provider`, `provider_id`) VALUES
(12, 'abhayjeet Singh', 'abhayjeetsingh19@gmail.com', '8173954048', '123456', 1, NULL, NULL, '212234', NULL, '2018-12-14 15:24:54', '2018-12-18 03:43:42', NULL, NULL, NULL),
(13, 'Bhaskar Singh', 'bhaskar.compaddicts@gmail.com', NULL, 'sASm9DQ1', 1, NULL, NULL, NULL, NULL, '2018-12-14 16:20:45', '2018-12-14 16:20:45', NULL, 'GOOGLE', '110468191853434802635'),
(14, 'Bhaskar Singh', 'bhaskar.compaddicts@gmail.com', NULL, 'ofnElYAl', 1, NULL, NULL, NULL, NULL, '2018-12-14 16:20:45', '2018-12-14 16:20:45', NULL, 'GOOGLE', '110468191853434802635'),
(15, 'Priya Srivastava', 'sonal.compaddicts@gmail.com', NULL, 'EMNn1qmR', 1, NULL, NULL, NULL, NULL, '2018-12-14 17:38:58', '2018-12-14 17:38:58', NULL, 'FACEBOOK', '741186206243429');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `advertisement_clients`
--
ALTER TABLE `advertisement_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_dimensions`
--
ALTER TABLE `ad_dimensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_enquiry`
--
ALTER TABLE `ad_enquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_images`
--
ALTER TABLE `ad_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_locations`
--
ALTER TABLE `ad_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_units`
--
ALTER TABLE `ad_units`
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
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_title`
--
ALTER TABLE `cms_title`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
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
-- Indexes for table `receive_alert_users`
--
ALTER TABLE `receive_alert_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testings`
--
ALTER TABLE `testings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticker`
--
ALTER TABLE `ticker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `advertisement_clients`
--
ALTER TABLE `advertisement_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ad_dimensions`
--
ALTER TABLE `ad_dimensions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ad_enquiry`
--
ALTER TABLE `ad_enquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `ad_images`
--
ALTER TABLE `ad_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `ad_locations`
--
ALTER TABLE `ad_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ad_units`
--
ALTER TABLE `ad_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cms_title`
--
ALTER TABLE `cms_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `receive_alert_users`
--
ALTER TABLE `receive_alert_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `testings`
--
ALTER TABLE `testings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ticker`
--
ALTER TABLE `ticker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
