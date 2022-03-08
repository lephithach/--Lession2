-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2022 at 08:50 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lampart`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Nước ngọt', '2022-03-07 08:00:57', '2022-03-07 08:00:57'),
(2, 'Bia', '2022-03-07 08:00:57', '2022-03-07 08:00:57');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `category_id`, `image`, `created_at`, `updated_at`) VALUES
(24, '7UP', 1, './images/2022-03-08-08-06-14-7-up-lon-cao-1.jpg', '2022-03-08 14:06:14', '2022-03-08 14:06:14'),
(25, '7UP', 1, './images/2022-03-08-08-06-14-7-up-lon-cao-1.jpg', '2022-03-08 14:06:37', '2022-03-08 14:06:37'),
(26, '7UP', 1, './images/2022-03-08-08-06-14-7-up-lon-cao-1.jpg', '2022-03-08 14:06:39', '2022-03-08 14:06:39'),
(27, 'Tiger', 2, './images/2022-03-08-08-08-54-bia-tiger-lon-330ml.jpg', '2022-03-08 14:08:54', '2022-03-08 14:09:03'),
(28, 'Coca Cola', 1, './images/2022-03-08-08-10-09-d8d4a36f436bc147eb74a7965f97bd36.jpg', '2022-03-08 14:10:09', '2022-03-08 14:10:09'),
(29, 'Tiger bạc 1', 2, './images/2022-03-08-08-23-44-bia-tiger-lon-330ml.jpg', '2022-03-08 14:23:44', '2022-03-08 14:23:44'),
(30, 'Soda', 1, './images/2022-03-08-08-27-23-soda-shweppes-330ml-lon-2-org.jpg', '2022-03-08 14:27:23', '2022-03-08 14:27:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
