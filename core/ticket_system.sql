-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2025 at 06:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticket_system`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_categories` ()   SELECT
*
FROM categories$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_tickets_not_pending` ()   SELECT
t.id AS 'ticket_id',
t.ticket_title,
t.ticket_desc,
t.status,
t.dev_id AS 'dev_id',
u.fullname,
t.attachment,
t.attachment_type
FROM tickets t
INNER JOIN users u
ON t.dev_id=u.id
WHERE t.status!='pending'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_tickets_pending` ()   SELECT
t.id AS 'ticket_id',
t.ticket_title,
t.ticket_desc,
t.status,
t.attachment,
t.attachment_type
FROM tickets t
WHERE t.status='pending'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_chat_by_ticket_id` (IN `ticket_id` INT)   SELECT
tc.id AS 'tc_id',
tc.messages,
tc.sender_id,
tc.sender_status,
u.fullname
FROM ticket_conversation tc
INNER JOIN tickets t
ON tc.ticket_id=t.id
INNER JOIN users u
ON tc.sender_id=u.id
WHERE tc.ticket_id=ticket_id ORDER BY tc.id DESC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_client_tickets` (IN `client_id` INT)   SELECT
t.id AS 'ticket_id',
t.ticket_title,
t.ticket_desc,
t.status,
t.dev_id AS 'dev_id',
t.attachment,
t.attachment_type
FROM tickets t
INNER JOIN users u
ON t.client_id=u.id AND t.client_id=client_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_devs` ()   SELECT
*
FROM users u
WHERE u.role='dev'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_dev_tickets` (IN `dev_id` INT)  NO SQL SELECT
t.id AS 'ticket_id',
t.ticket_title,
t.ticket_desc,
t.status,
t.client_id AS 'client_id',
t.attachment,
t.attachment_type
FROM tickets t
INNER JOIN users u
ON t.client_id=u.id AND t.dev_id=dev_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_sub_categories` (IN `cat_id` INT)  NO SQL SELECT
sc.id AS 'sub_id',
sc.sub_cat_name,
c.category_name
FROM sub_categories sc
INNER JOIN categories c
ON sc.cat_id=c.id AND sc.cat_id=cat_id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `status`) VALUES
(1, 'SAP', '1'),
(2, 'Microsoft Dynamics', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `sub_cat_name` varchar(255) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `sub_cat_name`, `cat_id`) VALUES
(1, 'SAP MM', 1),
(2, 'ABAP', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `ticket_id` varchar(255) DEFAULT NULL,
  `ticket_title` varchar(255) NOT NULL,
  `ticket_desc` text NOT NULL,
  `cat_id` int(11) NOT NULL,
  `sub_cat` text DEFAULT NULL,
  `status` enum('pending','progress','closed') NOT NULL DEFAULT 'pending',
  `client_id` int(11) NOT NULL,
  `dev_id` int(11) DEFAULT NULL,
  `attachment` text DEFAULT NULL,
  `attachment_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_id`, `ticket_title`, `ticket_desc`, `cat_id`, `sub_cat`, `status`, `client_id`, `dev_id`, `attachment`, `attachment_type`) VALUES
(6, 'INS0001', 'I need help', 'adasdasdasdasdasdsadasd', 1, 'SAP MM,ABAP', 'progress', 2, 8, 'abc.png', 'png');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_conversation`
--

CREATE TABLE `ticket_conversation` (
  `id` int(11) NOT NULL,
  `messages` text NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_status` enum('dev','client') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` int(11) NOT NULL,
  `reg_token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`id`, `reg_token`) VALUES
(1, 'RymIkHxgdu5OZLhjMKG2j/Y0ecJEILZGMDcGUGR1Xu4=');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dev','client') NOT NULL DEFAULT 'client',
  `status` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `phone`, `password`, `role`, `status`) VALUES
(1, 'Admin 123', 'admin', 'admin@gmail.com', NULL, '4297f44b13955235245b2497399d7a93', 'admin', '1'),
(2, 'Client 123', 'client', 'client@gmail.com', NULL, '4297f44b13955235245b2497399d7a93', 'client', '1'),
(8, 'Dev 1', 'dev1', 'dev@gmail.com', '1234412512312', '4297f44b13955235245b2497399d7a93', 'dev', '1'),
(9, 'Dev 2', 'dev2', 'dev2@gmail.com', NULL, '4297f44b13955235245b2497399d7a93', 'dev', '1'),
(10, 'Client 111', 'client2', 'client111@gmail.com', NULL, '4297f44b13955235245b2497399d7a93', 'client', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_id` (`ticket_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `dev_id` (`dev_id`);

--
-- Indexes for table `ticket_conversation`
--
ALTER TABLE `ticket_conversation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `ticket_conversation_ibfk_1` (`ticket_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket_conversation`
--
ALTER TABLE `ticket_conversation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`dev_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ticket_conversation`
--
ALTER TABLE `ticket_conversation`
  ADD CONSTRAINT `ticket_conversation_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ticket_conversation_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
