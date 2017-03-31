-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2017 at 03:55 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tutorial`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `sizes` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `sizes`, `deleted`) VALUES
(10, 'Vincent Chase VC01', '59.00', '69.00', 21, '40', '/tutorial/images/products/0b3dd34aa23b9206eddab3caf96f570e.jpg', 'Full Frame  Specs\r\nEasy Fit\r\nVery Flexible \r\n', 1, 'Medium:10,Small:5,', 0),
(11, 'Vincent Chase VC02', '50.00', '60.00', 21, '51', '/tutorial/images/products/99752116831468df91aac94666e035c0.jpg', 'Full Frame Glasses\r\nSpecially Designed For women', 1, 'Medium:5,Large:5,', 0),
(12, 'Tommy Hilfiger TH 01', '50.00', '60.00', 18, '50', '/tutorial/images/products/9f1cce0c5342f8dec07f520801db7e81.jpg', 'Women Eye Glasses\r\nSpecially Designed For Women\r\nMust Try It', 1, 'Medium:5,Small:5,', 0),
(13, 'Tommy Hilfiger TH 02', '50.00', '60.00', 18, '47', '/tutorial/images/products/03714d10e61295e129583519ba52090a.jpg', 'Brand new Frame..!!!', 1, 'Medium:10,Small:3,Large:5,', 0),
(14, 'D&amp;G DG01', '100.00', '120.00', 23, '41', '/tutorial/images/products/87de4268fe4ce0e09eabe6e7e4c2ca75.jpg', 'Premium Glasses For Men', 1, 'Medium:10,Large:5,', 0),
(15, 'Mont Blanc', '120.00', '150.00', 25, '51', '/tutorial/images/products/310360416526f0a21b644de00d750e30.jpg', 'Elegentaly Designed Frame  ', 1, 'Medium:5,Small:10,', 0),
(16, 'Tom Ford TF01', '100.00', '130.00', 20, '45', '/tutorial/images/products/bb137b9a37cb1cb1493ed6d65267d29c.jpg', 'New Edition ', 1, 'Small:10,Large:5,', 0),
(17, 'Pume P01', '80.00', '100.00', 19, '47', '/tutorial/images/products/c159ad55634ab74dd594239756f5c8b3.jpg', 'Frameless \r\nvery Delicate', 1, 'Large:5,Small:10,', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
