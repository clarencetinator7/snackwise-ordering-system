-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2022 at 08:58 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `snackwise`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `menu_id`, `quantity`) VALUES
(101, 105, 76, 1),
(102, 105, 65, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`) VALUES
(1, 'Combo'),
(2, 'Fries'),
(3, 'Burger'),
(4, 'Drinks');

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `holiday_id` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`holiday_id`, `date`) VALUES
(10, '2022-11-23');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` int(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `date` date NOT NULL,
  `availability` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `name`, `description`, `category`, `discount`, `price`, `date`, `availability`, `image`) VALUES
(65, 'Combo A', 'Includes: Regular Burger, Regular Fries, Blue Lemonade', 1, '0', 75, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(66, 'Combo B', 'Includes: Regular Burger, Carbonara, Blue Lemonade', 1, '0', 89, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(67, 'Combo C', 'Includes: Regular Hotdog, Regular Fries, Blue Lemonade', 1, '0', 80, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(68, 'Combo D', 'Includes: Regular Fries, Carbonara, Blue Lemonade', 1, '0', 85, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(69, 'Combo E', 'Includes: Regular Burger, Regular Fries, Spaghetti, Blue Lemonade', 1, '0', 120, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(70, 'Barkada Meal', 'Good for 4 People. Includes: 4 Regular Fries, 4 Regular Burger, 4 Blue Lemonade', 1, '0', 299, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(71, 'F1', 'Includes: Cheesy Fries, Blue Lemonade', 2, '0', 29, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(72, 'F2', 'Includes: Cheesy Fries, Hotdog, Blue Lemonade', 2, '0', 39, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(73, 'F3', 'Includes: Cheesy Fries, Nuggets, Blue Lemonade', 2, '0', 39, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(74, 'F4', 'Includes: Cheesy Fries, Cheese Sticks, Blue Lemonade', 2, '0', 39, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(75, 'Nacho Fries', 'Seasoned french fries, topped with nacho cheese sauce, and sautéed ground pork', 2, '0', 55, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(76, 'Regular Burger', 'A classic burger with beef patty, ketchup, and mayonnaise', 3, '0', 29, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(77, 'Bacon Cheese Burger', 'Burger with  bacon, beef patty, cheese, ketchup, and mayonnaise', 3, '0', 49, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(78, 'Chicken Burger', 'Burger with crispy seasoned chicken breast, topped with mayonnaise', 3, '0', 49, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(79, 'Double Dutch Frappé', 'Double Dutch flavored milk shake with kream puff, and pearl', 4, '0', 55, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(80, 'Cookies and Cream Frappé', 'Vanilla milk shake mixed with crushed oreo cookies, and pearl', 4, '0', 55, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(81, 'Buko Pandan Frappé', 'Buko pandan flavored milkshake with pandan jelly, coconut meat, and pearl', 4, '0', 55, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(82, 'Ube  Frappé', 'A classic flavoured milk shake vanilla mixed with purple yam (ube), and pearl', 4, '0', 55, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(83, 'Chocolate Milk Tea', 'Chocolate flavored milk tea with kream puff, and pearl', 4, '0', 55, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha'),
(84, 'Mango Cheese Cake Milk Tea', 'Mango flavored milk tea with a creamy cheesecake, and pearl', 4, '0', 55, '0000-00-00', 'available', 'v1668393471/SnackWise/Menu/Alpha');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `message`, `user_id`, `status`) VALUES
(26, 'order has been claimed', 1, 'read'),
(27, 'order has been claimed', 1, 'read'),
(28, 'order has been claimed', 1, 'read'),
(29, 'order has been claimed', 1, 'read'),
(30, 'order has been claimed', 1, 'read'),
(31, 'order has been claimed', 1, 'read'),
(32, 'order has been claimed', 1, 'read'),
(33, 'order has been claimed', 1, 'read'),
(34, 'order has been claimed', 1, 'read'),
(35, 'order has been claimed', 1, 'read'),
(36, 'order has been claimed', 1, 'read'),
(37, 'order has been claimed', 1, 'read'),
(38, 'order has been claimed', 1, 'read'),
(39, 'order has been claimed', 1, 'read'),
(40, 'order has been claimed', 1, 'read'),
(41, 'order has been claimed', 1, 'read'),
(42, 'order has been claimed', 1, 'read'),
(43, 'order has been claimed', 1, 'read'),
(44, 'order has been claimed', 1, 'read'),
(45, 'order has been claimed', 1, 'read'),
(46, 'order has been claimed', 1, 'read'),
(47, 'order has been claimed', 1, 'read'),
(48, 'order has been claimed', 1, 'read'),
(49, 'notif2', 1, 'unread'),
(50, 'Your order has been claimed', 1, 'unread'),
(51, 'Your order has been claimed', 1, 'unread'),
(52, 'Your order has been claimed', 1, 'unread'),
(53, 'Your order has been claimed', 1, 'unread'),
(54, 'Your order has been claimed', 1, 'unread'),
(55, 'notif1', 1, 'unread'),
(56, 'Your order has been claimed', 1, 'unread'),
(57, 'Your order has been claimed', 1, 'unread'),
(58, 'Your order has been claimed', 1, 'unread'),
(59, 'Your order has been claimed', 1, 'unread'),
(60, 'Your order has been claimed', 1, 'unread'),
(61, 'Your order has been claimed', 1, 'unread'),
(62, 'Your order has been claimed', 1, 'unread'),
(63, 'Your order has been claimed', 1, 'unread'),
(64, 'Your order has been claimed', 1, 'unread'),
(65, 'Your order has been claimed', 1, 'unread'),
(66, 'Your order has been claimed', 1, 'unread'),
(67, 'Your order has been claimed', 1, 'unread'),
(68, 'Your order has been claimed', 105, 'unread'),
(69, 'Your order has been claimed', 105, 'unread'),
(70, 'Your order has been claimed', 105, 'unread'),
(71, 'Your order has been claimed', 105, 'unread'),
(72, 'Your order has been claimed', 105, 'unread'),
(73, 'Your order has been claimed', 105, 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `orderlist_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderlist`
--

INSERT INTO `orderlist` (`orderlist_id`, `order_id`, `menu_id`, `quantity`) VALUES
(94, 4, 67, 1),
(95, 4, 65, 1),
(96, 5, 69, 1),
(97, 6, 69, 1),
(98, 7, 65, 1),
(99, 7, 67, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `qr_image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `date`, `time`, `qr_code`, `qr_image`, `status`) VALUES
(5, 105, '2022-11-14', '14:37:00', 'oueBLR0spf2B3X5G', 'v1668408032/SnackWise/QR/oueBLR0spf2B3X5G', 'Placed'),
(6, 105, '2022-11-14', '14:37:00', 'w0o3Tsb27G0gY59W', 'v1668408301/SnackWise/QR/w0o3Tsb27G0gY59W', 'Placed'),
(7, 105, '2022-11-14', '14:37:00', 'skMhlHQYCWsvmzrN', 'v1668408318/SnackWise/QR/skMhlHQYCWsvmzrN', 'Placed');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `order_id`, `user_id`, `date`, `price`) VALUES
(79, 4, 105, '2022-11-14', 80);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `attempt` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `code_expiration` datetime NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `username`, `email`, `contact`, `region`, `password`, `province`, `municipality`, `barangay`, `street`, `image`, `attempt`, `status`, `code`, `code_expiration`, `user_type`) VALUES
(94, 'SnackWise', 'SnackWise', 'SnackWise', 'snackwise.hagonoy@gmail.com', '01234567890', 'Region IV-A (CALABARZON)', '$2y$10$EEuIXZf5wXS6.xOh6WWDIuSER.fkrQw4Ow2JUQCZmqxL3fwHKoKOG', 'Cavite', 'Indang', 'Carasuchi', 'Bulacan', '', 0, 'verified', '0', '2022-11-14 03:45:54', 'admin'),
(105, 'Darwin', 'Ramos', 'darwin', 'darwinsanluis.ramos14@gmail.com', '09327887941', 'Region XII (SOCCSKSARGEN)', '$2y$10$Aji52BspPEJMghCBo1zK/OV8sjhvSQbfMaT7lPT3YAUy.yvUectai', 'Sultan Kudarat', 'Lebak', 'Ragandang', '123', '', 0, 'verified', '0', '2022-11-14 04:15:57', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`holiday_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `orderlist`
--
ALTER TABLE `orderlist`
  ADD PRIMARY KEY (`orderlist_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `holiday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `orderlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
