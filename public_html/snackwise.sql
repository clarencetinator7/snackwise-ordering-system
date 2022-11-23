-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2022 at 12:10 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `menu_id`, `quantity`) VALUES
(137, 105, 65, 1),
(140, 105, 68, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `description` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `category` int(255) NOT NULL,
  `discount` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `price` double NOT NULL,
  `date` date NOT NULL,
  `availability` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `image` varchar(255) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `name`, `description`, `category`, `discount`, `price`, `date`, `availability`, `image`) VALUES
(65, 'Combo A', 'Includes: Regular Burger, Regular Fries, Blue Lemonade', 1, '0', 75, '2022-11-18', 'Available', 'v1668393471/SnackWise/Menu/Alpha'),
(66, 'Combo B', 'Includes: Regular Burger, Carbonara, Blue Lemonade', 1, '0', 890, '2022-11-18', 'Available', 'v1669200184/SnackWise/Menu/Combo B'),
(67, 'Combo C', 'Includes: Regular Hotdog, Regular Fries, Blue Lemonade', 1, '5', 80, '2022-11-18', 'Available', 'v1668702383/SnackWise/Menu/Combo C'),
(68, 'Combo D', 'Includes: Regular Fries, Carbonara, Blue Lemonade', 1, '10', 85, '2022-11-18', 'Available', 'v1669200230/SnackWise/Menu/Combo D'),
(69, 'Combo E', 'Includes: Regular Burger, Regular Fries, Spaghetti, Blue Lemonade', 1, '0', 120, '2022-11-18', 'Available', 'v1669200270/SnackWise/Menu/Combo E'),
(70, 'Barkada Meal', 'Good for 4 People. Includes: 4 Regular Fries, 4 Regular Burger, 4 Blue Lemonade', 1, '0', 299, '2022-11-18', 'Available', 'v1669200309/SnackWise/Menu/Barkada Meal'),
(71, 'F1', 'Includes: Cheesy Fries, Blue Lemonade', 2, '0', 29, '2022-11-18', 'Available', 'v1669200399/SnackWise/Menu/F1'),
(72, 'F2', 'Includes: Cheesy Fries, Hotdog, Blue Lemonade', 2, '0', 39, '2022-11-18', 'Available', 'v1669200414/SnackWise/Menu/F2'),
(73, 'F3', 'Includes: Cheesy Fries, Nuggets, Blue Lemonade', 2, '0', 39, '2022-11-18', 'Available', 'v1669200428/SnackWise/Menu/F3'),
(74, 'F4', 'Includes: Cheesy Fries, Cheese Sticks, Blue Lemonade', 2, '0', 39, '2022-11-18', 'Available', 'v1669200443/SnackWise/Menu/F4'),
(75, 'Nacho Fries', 'Seasoned french fries, topped with nacho cheese sauce, and sautéed ground pork', 2, '0', 55, '2022-11-18', 'Available', 'v1669200460/SnackWise/Menu/Nacho Fries'),
(76, 'Regular Burger', 'A classic burger with beef patty, ketchup, and mayonnaise', 3, '0', 29, '2022-11-18', 'Available', 'v1669200508/SnackWise/Menu/Regular Burger'),
(77, 'Bacon Cheese Burger', 'Burger with  bacon, beef patty, cheese, ketchup, and mayonnaise', 3, '0', 49, '2022-11-18', 'Available', 'v1669200525/SnackWise/Menu/Bacon Cheese Burger'),
(78, 'Chicken Burger', 'Burger with crispy seasoned chicken breast, topped with mayonnaise', 3, '0', 49, '2022-11-18', 'Available', 'v1669200541/SnackWise/Menu/Chicken Burger'),
(79, 'Double Dutch Frappé', 'Double Dutch flavored milk shake with kream puff, and pearl', 4, '0', 55, '2022-11-18', 'Available', 'v1669200567/SnackWise/Menu/Double Dutch Frappé'),
(80, 'Cookies and Cream Frappé', 'Vanilla milk shake mixed with crushed oreo cookies, and pearl', 4, '0', 55, '2022-11-18', 'Available', 'v1669200626/SnackWise/Menu/Cookies and Cream Frappé'),
(81, 'Buko Pandan Frappé', 'Buko pandan flavored milkshake with pandan jelly, coconut meat, and pearl', 4, '0', 55, '2022-11-18', 'Available', 'v1669200639/SnackWise/Menu/Buko Pandan Frappé'),
(82, 'Ube  Frappé', 'A classic flavoured milk shake vanilla mixed with purple yam (ube), and pearl', 4, '0', 55, '2022-11-18', 'Available', 'v1669201229/SnackWise/Menu/Ube  Frappé'),
(83, 'Chocolate Milk Tea', 'Chocolate flavored milk tea with kream puff, and pearl', 4, '0', 55, '2022-11-18', 'Available', 'v1669201266/SnackWise/Menu/Chocolate Milk Tea'),
(84, 'Mango Cheese Cake Milk Tea', 'Mango flavored milk tea with a creamy cheesecake, and pearl', 4, '0', 55, '2022-11-18', 'Available', 'v1669201285/SnackWise/Menu/Mango Cheese Cake Milk Tea'),
(87, 'testt', 'testt', 3, '21', 12, '2022-11-18', 'Available', 'v1668569366/SnackWise/Menu/testt');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `newsletter_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`newsletter_id`, `email`) VALUES
(1, 'darwinsanluis.ramos14@gmail.com'),
(2, 'rowenasanluis.ramos50@gmail.com'),
(3, 'darwin.ramos.sl@bulsu.edu.ph'),
(4, 'darwinsanluis.ramddddos14@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `message` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(255) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `message`, `user_id`, `date`, `status`) VALUES
(26, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(27, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(28, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(29, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(30, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(31, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(32, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(33, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(34, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(35, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(36, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(37, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(38, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(39, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(40, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(41, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(42, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(43, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(44, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(45, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(46, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(47, 'order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(48, 'order has been claimed', 1, '0000-00-00 00:00:00', 'read'),
(49, 'notif2', 1, '0000-00-00 00:00:00', 'unread'),
(50, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(51, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(52, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(53, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(54, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(55, 'notif1', 1, '0000-00-00 00:00:00', 'unread'),
(56, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(57, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(58, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(59, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(60, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(61, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(62, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(63, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(64, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(65, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(66, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(67, 'Your order has been claimed', 1, '0000-00-00 00:00:00', 'unread'),
(68, 'Your order has been claimed', 105, '0000-00-00 00:00:00', 'unread'),
(69, 'Your order has been claimed', 105, '0000-00-00 00:00:00', 'unread'),
(70, 'Your order has been claimed', 105, '0000-00-00 00:00:00', 'unread'),
(71, 'Your order has been claimed', 105, '0000-00-00 00:00:00', 'unread'),
(72, 'Your order has been claimed', 105, '0000-00-00 00:00:00', 'unread'),
(73, 'Your order has been claimed', 105, '0000-00-00 00:00:00', 'read'),
(74, 'Your order has been claimed', 107, '0000-00-00 00:00:00', 'read'),
(75, 'Item Unvailable', 105, '0000-00-00 00:00:00', 'read'),
(79, 'dsada', 105, '2022-11-19 07:56:56', 'unread'),
(80, 'Item Unvailable', 105, '2022-11-19 07:57:27', 'unread'),
(81, 'Your order has been claimed', 105, '2022-11-19 08:20:24', 'unread'),
(82, 'Your order has been claimed', 105, '2022-11-19 08:41:41', 'unread'),
(83, 'Your order has been claimed', 105, '2022-11-19 08:42:33', 'unread'),
(84, 'Your order has been claimed', 105, '2022-11-19 08:43:29', 'unread'),
(85, 'Your order has been claimed', 105, '2022-11-21 06:12:46', 'unread'),
(86, 'Your order has been claimed', 105, '2022-11-21 06:15:03', 'unread'),
(87, 'Your order has been claimed', 105, '2022-11-21 06:16:32', 'unread'),
(88, 'Your order has been claimed', 105, '2022-11-21 06:20:51', 'unread'),
(89, 'Item Unvailable', 105, '2022-11-21 06:21:01', 'unread'),
(90, 'dsada', 105, '2022-11-23 01:49:09', 'unread'),
(91, 'dsada', 105, '2022-11-23 01:49:59', 'unread'),
(92, 'Order: ........14 ready for pick up', 105, '2022-11-23 13:33:52', 'unread'),
(93, 'Order: 0000000020 ready for pick up', 105, '2022-11-23 13:42:23', 'unread'),
(94, 'Your order has been claimed', 105, '2022-11-23 13:44:56', 'unread'),
(95, 'Order: 0000000017 is being processed', 105, '2022-11-23 14:19:21', 'unread'),
(96, 'Order: 0000000017 is being prepared', 105, '2022-11-23 14:20:09', 'unread'),
(97, 'Order: 0000000017 ready for pick up', 105, '2022-11-23 14:20:29', 'unread'),
(98, 'Order: 0000000017 is being processed', 105, '2022-11-23 14:25:18', 'unread'),
(99, 'Order: 0000000015 is being processed', 105, '2022-11-23 14:25:35', 'unread'),
(100, 'Order: 0000000017 is being prepared', 105, '2022-11-23 14:26:44', 'unread'),
(101, 'Order: 0000000015 is being prepared', 105, '2022-11-23 14:26:46', 'unread'),
(102, 'Order: 0000000014 is being processed', 105, '2022-11-23 15:24:29', 'unread'),
(103, 'Order: 0000000017 is being processed', 105, '2022-11-23 15:24:30', 'unread'),
(104, 'Your order has been claimed', 105, '2022-11-23 16:02:49', 'unread'),
(105, 'Order: 0000000015 ready for pick up', 105, '2022-11-23 16:11:44', 'unread'),
(106, 'Order: 0000000017 is being prepared', 105, '2022-11-23 16:26:48', 'unread'),
(107, 'Order: 0000000017 ready for pick up', 105, '2022-11-23 16:26:50', 'unread'),
(108, 'Your order has been claimed', 105, '2022-11-23 16:26:53', 'unread'),
(109, 'Order: 0000000014 is being prepared', 105, '2022-11-23 16:26:56', 'unread'),
(110, 'Order: 0000000014 is being prepared', 105, '2022-11-23 16:33:30', 'unread'),
(111, 'Order: 0000000015 ready for pick up', 105, '2022-11-23 16:33:34', 'unread'),
(112, 'Order: 0000000014 ready for pick up', 105, '2022-11-23 16:34:57', 'unread'),
(113, 'Order: 0000000015 is being prepared', 105, '2022-11-23 16:59:50', 'unread'),
(114, 'Order: 0000000015 is being processed', 105, '2022-11-23 16:59:53', 'unread'),
(115, 'dsada', 105, '2022-11-23 17:26:54', 'unread'),
(116, 'Item Unvailable', 105, '2022-11-23 18:22:31', 'unread'),
(117, 'Item Unvailable', 105, '2022-11-23 18:23:39', 'unread'),
(118, 'Order: 0000000021 ready for pick up', 105, '2022-11-23 18:23:55', 'unread'),
(119, 'Your order has been claimed', 105, '2022-11-23 18:23:59', 'unread'),
(120, 'Order: 0000000015 ready for pick up', 105, '2022-11-23 18:24:23', 'unread'),
(121, 'Your order has been claimed', 105, '2022-11-23 18:24:28', 'unread'),
(122, 'Item Unvailable', 105, '2022-11-23 18:24:37', 'unread'),
(123, 'Item Unvailable', 105, '2022-11-23 18:34:24', 'unread'),
(124, 'Item Unvailable', 105, '2022-11-23 18:36:43', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `orderlist_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `orderlist`
--

INSERT INTO `orderlist` (`orderlist_id`, `order_id`, `menu_id`, `quantity`) VALUES
(94, 4, 67, 1),
(95, 4, 65, 1),
(96, 5, 69, 1),
(97, 6, 69, 1),
(98, 7, 65, 1),
(99, 7, 67, 1),
(100, 8, 75, 2),
(101, 8, 70, 1),
(102, 9, 66, 2),
(103, 10, 67, 3),
(104, 10, 65, 9),
(105, 11, 69, 2),
(106, 12, 68, 1),
(107, 13, 65, 82),
(108, 14, 67, 1),
(109, 14, 66, 2),
(110, 15, 66, 1),
(111, 16, 65, 1),
(112, 17, 70, 1),
(113, 18, 65, 2),
(114, 19, 65, 4),
(115, 20, 66, 1),
(116, 20, 67, 1),
(117, 20, 69, 2),
(118, 21, 78, 1),
(119, 21, 67, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `qr_code` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `qr_image` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `status` varchar(255) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `date`, `time`, `qr_code`, `qr_image`, `status`) VALUES
(13, 105, '2022-11-21', '13:17:00', 'BbjVxWdqK8OAMvu7', 'v1669007875/SnackWise/QR/BbjVxWdqK8OAMvu7', 'Placed'),
(14, 105, '2022-11-28', '13:17:00', 'fPXZ84HGZEd80a27', 'v1669007887/SnackWise/QR/fPXZ84HGZEd80a27', 'Placed'),
(18, 105, '2022-11-21', '18:39:00', 'h0FsU69uU3Jh7Kvi', 'v1669027186/SnackWise/QR/h0FsU69uU3Jh7Kvi', 'Placed');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `order_id`, `user_id`, `date`, `price`) VALUES
(79, 4, 105, '2022-11-14', 80),
(80, 8, 107, '2022-11-16', 110),
(81, 5, 105, '2022-11-19', 120),
(82, 7, 105, '2022-11-21', 75),
(83, 11, 105, '2022-11-21', 240),
(84, 6, 105, '2022-11-21', 120),
(85, 12, 105, '2022-11-21', 76.5),
(86, 20, 105, '2022-11-23', 890),
(87, 16, 105, '2022-11-23', 75),
(88, 17, 105, '2022-11-23', 299),
(89, 21, 105, '2022-11-23', 49),
(90, 15, 105, '2022-11-23', 890);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `lastname` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `username` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `email` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `contact` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `password` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `attempt` int(11) NOT NULL,
  `status` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `code` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `code_expiration` datetime NOT NULL,
  `user_type` varchar(255) COLLATE latin1_general_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `username`, `email`, `contact`, `password`, `attempt`, `status`, `code`, `code_expiration`, `user_type`) VALUES
(94, 'SnackWise', 'SnackWise', 'SnackWise', 'snackwise.hagonoy@gmail.com', '01234567890', '$2y$10$EEuIXZf5wXS6.xOh6WWDIuSER.fkrQw4Ow2JUQCZmqxL3fwHKoKOG', 0, 'verified', '', '2022-11-14 03:45:54', 'admin'),
(105, 'Darwin', 'Ramos', 'darwin', 'darwinsanluis.ramos14@gmail.com', '09327887941', '$2y$10$/VhKlCvXxIOjdE4J48vcy.H.LCzDDkezvaJGpULJwDvWB80B.OXYG', 0, 'verified', '', '2022-11-22 01:47:44', 'customer'),
(107, 'Angel', 'Padilla', 'angelpadilla', 'padilla.angel.g.7227@gmail.com', '09514401253', '$2y$10$z7q/bME693eSz2oTRnJ.KO5eQFx7yYrncMS.KIg1by2BWrvCjO0vm', 0, 'verified', '', '2022-11-16 16:04:06', 'customer');

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
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`newsletter_id`);

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

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
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `newsletter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `orderlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
