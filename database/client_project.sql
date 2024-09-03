-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2024 at 11:32 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `client_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `c_banner` varchar(255) DEFAULT NULL,
  `c_desc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `img`, `c_banner`, `c_desc`) VALUES
(3, 'Test Category - 1', 'slider-1.jpeg', 'hero-section.png', 'Test Category Desc 1'),
(4, 'Tesct Category 2', 'blueberry.jpg', 'yellowbg-content.png', 'Test Category 2');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_code` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `var_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `product_price`, `product_qty`, `product_image`, `product_code`, `category_id`, `var_id`) VALUES
(9, 'BLUEBERRY BAGEL', 110.00, 1, 'blueberry-bagel.jpg', 'Cash On Deliver', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_variation`
--

CREATE TABLE `product_variation` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `var_id` int(11) NOT NULL,
  `sub_var_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variation`
--

INSERT INTO `product_variation` (`id`, `product_id`, `var_id`, `sub_var_id`) VALUES
(7, 9, 5, 5),
(8, 9, 6, 6),
(9, 9, 4, 4),
(10, 9, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sub_variation`
--

CREATE TABLE `sub_variation` (
  `id` int(11) NOT NULL,
  `sub_var_name` varchar(255) NOT NULL,
  `sub_var_price` decimal(10,2) DEFAULT NULL,
  `var_sub_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_variation`
--

INSERT INTO `sub_variation` (`id`, `sub_var_name`, `sub_var_price`, `var_sub_id`) VALUES
(4, 'Tets Sub Variation 1', 2.20, 4),
(5, 'Tets Sub Variation 2 ', 2.30, 5),
(6, 'Tets Sub Variation 3', 2.40, 6);

-- --------------------------------------------------------

--
-- Table structure for table `variation`
--

CREATE TABLE `variation` (
  `id` int(11) NOT NULL,
  `var_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `variation`
--

INSERT INTO `variation` (`id`, `var_name`) VALUES
(4, 'Test Variation 1'),
(5, 'Test Variation 1'),
(6, 'Test Variation 2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`product_code`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `var_id` (`var_id`);

--
-- Indexes for table `product_variation`
--
ALTER TABLE `product_variation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `var_id` (`var_id`),
  ADD KEY `sub_var_id` (`sub_var_id`);

--
-- Indexes for table `sub_variation`
--
ALTER TABLE `sub_variation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `var_sub_id` (`var_sub_id`);

--
-- Indexes for table `variation`
--
ALTER TABLE `variation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_variation`
--
ALTER TABLE `product_variation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sub_variation`
--
ALTER TABLE `sub_variation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `variation`
--
ALTER TABLE `variation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`var_id`) REFERENCES `variation` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_variation`
--
ALTER TABLE `product_variation`
  ADD CONSTRAINT `product_variation_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variation_ibfk_2` FOREIGN KEY (`var_id`) REFERENCES `variation` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variation_ibfk_3` FOREIGN KEY (`sub_var_id`) REFERENCES `sub_variation` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_variation`
--
ALTER TABLE `sub_variation`
  ADD CONSTRAINT `sub_variation_ibfk_1` FOREIGN KEY (`var_sub_id`) REFERENCES `variation` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
