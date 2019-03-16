-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2019 at 12:44 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ec`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(4, 'levis'),
(8, 'nike'),
(9, 'zara'),
(10, 'puma'),
(11, 'adidas2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`) VALUES
(23, '[{\"id\":\"4\",\"size\":\"L\",\"quantity\":\"1\"},{\"id\":\"2\",\"size\":\"40\",\"quantity\":\"3\"},{\"id\":\"7\",\"size\":\"44\",\"quantity\":2},{\"id\":\"2\",\"size\":\"55\",\"quantity\":\"1\"},{\"id\":\"1\",\"size\":\"36\",\"quantity\":\"1\"}]', '2019-01-22 11:00:55', 0),
(24, '[{\"id\":\"1\",\"size\":\"36\",\"quantity\":\"1\"}]', '2019-04-15 12:37:09', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'men', 0),
(2, 'women', 0),
(3, 'boys', 0),
(4, 'watches', 1),
(5, 'shirts', 1),
(6, 'shoes', 1),
(7, 'pantalons', 1),
(8, 'skirts', 2),
(9, 'make up', 2),
(10, 'toys', 3),
(11, 'shoes', 3),
(12, 'wallets', 1),
(13, 'gifts', 0),
(14, 'birthday', 13),
(15, 'accessories', 0),
(16, 'watches', 15),
(17, 'shirts', 3),
(18, 'mobiles', 0),
(19, 'nokia', 18);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `sizes` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `sizes`, `deleted`) VALUES
(1, 'addidas jean', '49.99', '79.99', 1, 5, '/ecommerce/images/products/65bddea41a011dfcb6357f1c51d24f60.jpg', 'this jeans is very good and it&#039;s very comfortable and have a good wearing', 1, '36:5,44:4,32:7,40:6', 0),
(2, 'nike shirt', '40.99', '70.99', 2, 6, '/ecommerce/images/products/p2.jpg', 'is a style of unisex fabric shirt named after the T shape of its body and sleeves. It normally has short sleeves and a round neckline, known as a crew neck, which lacks a collar', 1, '40:3,44:6,55:3,32:9', 0),
(3, ' sss', '55.00', '54.00', 4, 14, '/ecommerce/images/products/027af4c31adc4bac36f6bba8068f33cf.jpg', '', 0, 'sss:2,', 1),
(4, ' SHIRT', '54.00', '322.00', 8, 7, '/ecommerce/images/products/a710dd02d700c0c6876f3311dad5baba.jpg', 'SSSSSSSSSSSSSS', 1, 'M:10,L:15', 0),
(7, ' nike football shoes', '100.00', '150.00', 8, 6, '/ecommerce/images/products/c8965cbeb9f656ba13a4d01f2fc755a8.jpg', 'amazing', 1, '44:3,45:2,', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `permisson` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `join_date`, `last_login`, `permisson`) VALUES
(1, 'mostafa elgazar', 'mostafa@gmail.com', '$2y$10$HCfKgBGPcCDFb5vvlZGg/.qLj5EnUasu06WXl7blvTiF/FSDrpe6W', '2018-12-20 12:30:04', '2018-12-23 00:00:00', 'admin,editor'),
(3, 'abo kamal', 'mostafa@ggg.com', '$2y$10$AVLhNK2aSzfqieZpC0MzYeZ3nwvAB/38QWhoJDIXdsnf2wVK5QuJ.', '2018-12-21 15:15:47', '2018-12-23 00:00:00', 'editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories` (`categories`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categories`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
