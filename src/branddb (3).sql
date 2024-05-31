-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2024 at 02:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `branddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `cus_id_number` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `name`, `price`, `image`, `quantity`, `product_id`, `cus_id_number`) VALUES
(19, 'white star', 200, '../web/image/jacket/plainwhite.jpg', 1, 23, '0209111111112'),
(30, 'hoodie white', 70, '../web/image/shirt/plainblack.jpg', 1, 31, '0207280646085'),
(69, '     ', 275, '../web/image/jacket/blenowhite.jpg', 4, 77, '0106175503015');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cus_id_number` varchar(13) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cus_id_number`, `name`, `email`, `phone_number`, `password`) VALUES
('0106175503012', 'Nhlangano', 'cherltonmhangwana@gmail.com', '0784862655', 'Cherlton@23'),
('0106175503015', 'Nhlangano Cherlton', '221770915@tut4life.ac.za', '0652421927', 'Cherlton@23'),
('0202066004088', 'Mahlomola', 'mahlomola595@gmail.com', '0726086903', 'Gift@2007'),
('0207280646085', 'Bongeka ', 'bongekamdluli4@gmail.com', '0787655321', '@Emihle2009'),
('0209111111112', 'Nkosinathi Mahlangu', 'mahlanguzakhele063@gmail.com', '0796830593', '123'),
('0209166113077', 'phindulo vhumbani', 'peend@gmail.com', '0723387170', 'Phindulo@23'),
('0209166113081', 'Nkosinathi', 'nkosinathisidwellmahlangu@gmail.com', '0652421927', 'Nkosi@123'),
('0211070627081', 'phindulo vhumbani', 'peendue07@gmail.com', '0723387170', 'P7Ndue@77'),
('9012151234567', 'Nkosinathi Sidwell ', 'fdfd@gmail.com', '0796830593', 'Nkosi@123'),
('9912125274873', 'Simza ST', 'Simza@123', '0796830593', 'Simza@12');

-- --------------------------------------------------------

--
-- Table structure for table `design`
--

CREATE TABLE `design` (
  `design_id` int(11) NOT NULL,
  `cloth_type` varchar(30) DEFAULT NULL,
  `cloth_fabric` varchar(30) DEFAULT NULL,
  `cloth_color` varchar(30) DEFAULT NULL,
  `logo` varchar(30) DEFAULT NULL,
  `cloth_size` varchar(30) DEFAULT NULL,
  `cus_id_number` varchar(13) DEFAULT NULL,
  `text_color` varchar(25) NOT NULL,
  `text` varchar(100) NOT NULL,
  `text_size` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `design`
--

INSERT INTO `design` (`design_id`, `cloth_type`, `cloth_fabric`, `cloth_color`, `logo`, `cloth_size`, `cus_id_number`, `text_color`, `text`, `text_size`) VALUES
(86, 't-shirt', 'null', 'white', 'null', 'null', '0106175503012', '#000000', 'tumi', 24),
(87, 'shirt', 'cotton', 'white', '', 'small', '0106175503012', 'null', 'null', 0),
(88, 't-shirt', 'null', 'white', 'null', 'null', '0106175503012', '#000000', 'll', 24),
(89, 't-shirt', 'null', 'black', 'null', 'null', '0106175503012', '#000000', 'dfgds', 24),
(90, 'jacket', 'cotton', 'red', '', 'small', '0106175503012', 'null', 'null', 0),
(91, 't-shirt', 'null', 'white', 'null', 'null', '0106175503012', '#000000', 'dooo', 24),
(92, 'shirt', 'cotton', 'white', '', 'small', '0209166113081', 'null', 'null', 0),
(93, 't-shirt', 'null', 'blue', 'null', 'null', '0209166113081', '#000000', 'i love my baby girl', 24),
(94, 't-shirt', 'null', 'white', 'null', 'null', '0209166113081', '#000000', 'i love my baby girl', 24),
(95, 'jacket', 'cotton', 'red', '', 'small', '0209166113081', 'null', 'null', 0),
(96, 'hoodie', 'cotton', 'black', '', 'small', '0209166113081', 'null', 'null', 0),
(97, 'jacket', 'cotton', 'white', 'bleno', 'medium', '0106175503015', 'null', 'null', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `methodpay` varchar(30) DEFAULT NULL,
  `total_product` varchar(255) DEFAULT NULL,
  `total_price` int(11) DEFAULT NULL,
  `cus_id_number` varchar(13) DEFAULT NULL,
  `street` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `methodpay`, `total_product`, `total_price`, `cus_id_number`, `street`, `state`, `zip`) VALUES
(23, 'masd', '122', 12, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(24, 'kk', '122', 77, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(25, 'kk', '122', 22, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(26, 'kk', '122', 22, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(27, 'kk', '122', 11, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(28, 'kk', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(29, 'kk', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(30, 'kk', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(31, 'kk', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(32, 'kk', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(33, 'kk', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(35, 'paypal', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(36, 'paypal', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(37, 'paypal', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(38, 'paypal', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(40, 'paypal', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(41, 'paypal', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(42, 'paypal', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(43, 'paypal', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(44, 'visa', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(46, 'vaar', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(47, 'vaar', '122', 0, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(48, 'yess', '122', 295, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(49, 'mno', '122', 295, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(50, 'uu', '2', 295, '0106175503012', 'sosha', 'in', '0152'),
(51, 'wer', '', 745, '0106175503012', 'sosha', 'in', '0152'),
(52, 'wer', '', 745, '0106175503012', 'sosha', 'in', '0152'),
(53, 'wer', '', 745, '0106175503012', 'sosha', 'in', '0152'),
(54, 'wer', '', 745, '0106175503012', 'sosha', 'in', '0152'),
(55, 'paypal', '', 745, '0106175503012', 'sosha', 'in', '0152'),
(56, 'visa', '', 70, '0207280646085', 'sosha', 'in', '0152'),
(57, 'visa', '', 745, '0106175503012', 'sosha', 'in', '0152'),
(58, 'visa', '', 70, '0106175503012', 'sosha', 'in', '0152'),
(59, 'visa', '', 280, '0106175503012', 'sosha', 'in', '0152'),
(60, 'visa', '', 410, '0106175503012', 'sosha', 'in', '0152'),
(61, 'visa', '', 410, '0106175503012', 'sosha', 'in', '0152'),
(62, 'visa', '', 410, '0106175503012', 'sosha', 'in', '0152'),
(63, 'visa', '', 410, '0106175503012', 'sosha', 'in', '0152'),
(64, 'hhh', '', 410, '0106175503012', 'aubrey matlakala road', 'sos', '0152'),
(65, 'paypal', '', 410, '0106175503012', 'aubrey matlakala road', 'so', '0152'),
(66, 'paypal', '', 410, '0106175503012', 'aubrey matlakala', 'soso', '0152'),
(67, 'paypal', '', 225, '0106175503012', 'aubrey matlakala road', 'sosha', '0152'),
(68, 'visa', '', 70, '0106175503012', 'sosha', 'in', '0152'),
(69, 'visa', '', 270, '0106175503012', 'sosha', 'in', '0152'),
(70, 'paypal', '', 70, '0209166113081', 'sosha', 'in', '0152'),
(71, 'paypal', '', 350, '0209166113081', 'sosha', 'in', '0152');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `cus_id_number` varchar(13) NOT NULL,
  `total_price` decimal(10,0) NOT NULL,
  `card_number` varchar(10) NOT NULL,
  `expiry_date` varchar(25) DEFAULT NULL,
  `cvv` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`cus_id_number`, `total_price`, `card_number`, `expiry_date`, `cvv`) VALUES
('0106175503012', 12, '1111111111', '1111', 111),
('0106175503012', 12, '1234567890', '1233', 112),
('0207280646085', 70, '1111111111', '2222', 333),
('0106175503012', 12, '1111111111', '1111', 111),
('0106175503012', 200, '1111111111', '1111', 111),
('0106175503012', 200, '4444444444', '4444', 444),
('0106175503012', 200, '9900909090', '0090', 0),
('0106175503012', 200, '6666666666', '6666', 888),
('0106175503012', 225, '9898987989', '9898', 989),
('0106175503012', 70, '9999999999', '8888', 777),
('0106175503012', 200, '4666465465', '6746', 765),
('0209166113081', 70, '1323425', '3464', 354),
('0209166113081', 150, '6565655465', '6546', 654);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `design_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `cus_id_number` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `image`, `design_id`, `price`, `cus_id_number`) VALUES
(23, 'white star', '../web/image/jacket/plainwhite.jpg', 41, 200, '0209111111112'),
(24, 'hoodie white', '../web/image/hoodie/plainwhite.jpg', 42, 150, '0209111111112'),
(31, 'hoodie white', '../web/image/shirt/plainblack.jpg', 49, 70, '0207280646085'),
(62, 'km', 'plain shirt', 82, 70, '0106175503012'),
(63, 'tumisho', 'plain shirt', 83, 70, '0106175503012'),
(66, 'I want to love', 'plain shirt', 86, 70, '0106175503012'),
(67, 'y', '../web/image/shirt/plainwhite.jpg', 87, 70, '0106175503012'),
(68, 'pl', 'plain shirt', 88, 70, '0106175503012'),
(69, 'df', 'plain shirt', 89, 70, '0106175503012'),
(70, 'red', '../web/image/jacket/plainred.jpg', 90, 200, '0106175503012'),
(71, 'do', 'plain shirt', 91, 70, '0106175503012'),
(73, 'baby girl', 'plain shirt', 93, 70, '0209166113081'),
(74, 'baby girl', 'plain shirt', 94, 70, '0209166113081'),
(75, 'red', '../web/image/jacket/plainred.jpg', 95, 200, '0209166113081'),
(76, 'black', '../web/image/hoodie/plainblack.jpg', 96, 150, '0209166113081'),
(77, '     ', '../web/image/jacket/blenowhite.jpg', 97, 275, '0106175503015');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `cus_id_number` (`cus_id_number`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cus_id_number`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_customer_id_number` (`cus_id_number`);

--
-- Indexes for table `design`
--
ALTER TABLE `design`
  ADD PRIMARY KEY (`design_id`),
  ADD KEY `cus_id_number` (`cus_id_number`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `cus_id_number` (`cus_id_number`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD KEY `constraint_fk` (`cus_id_number`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `design_id` (`design_id`),
  ADD KEY `cus_id_number` (`cus_id_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `design`
--
ALTER TABLE `design`
  MODIFY `design_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `cus_id_number` FOREIGN KEY (`cus_id_number`) REFERENCES `customers` (`cus_id_number`);

--
-- Constraints for table `design`
--
ALTER TABLE `design`
  ADD CONSTRAINT `design_ibfk_1` FOREIGN KEY (`cus_id_number`) REFERENCES `customers` (`cus_id_number`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cus_id_number`) REFERENCES `customers` (`cus_id_number`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `constraint_fk` FOREIGN KEY (`cus_id_number`) REFERENCES `customers` (`cus_id_number`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`design_id`) REFERENCES `design` (`design_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`cus_id_number`) REFERENCES `customers` (`cus_id_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
