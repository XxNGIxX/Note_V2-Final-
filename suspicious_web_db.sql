-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2025 at 09:31 AM
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
-- Database: `suspicious_web_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `user_id`) VALUES
(0, 'Null', 0),
(13, 'ddd', 3),
(19, 'gong', 1),
(20, 'ำดำไ', 1),
(21, 'eat', 6),
(22, 'gong', 8),
(23, 'ทำฟัน', 1);

-- --------------------------------------------------------

--
-- Table structure for table `priority`
--

CREATE TABLE `priority` (
  `priority_id` int(10) NOT NULL,
  `priority_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `priority`
--

INSERT INTO `priority` (`priority_id`, `priority_name`) VALUES
(0, 'no'),
(1, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(10) NOT NULL,
  `status_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_name`) VALUES
(0, 'no'),
(1, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `title` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `due_date` datetime NOT NULL,
  `priority_id` int(10) NOT NULL,
  `status_id` int(10) NOT NULL,
  `category_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `user_id`, `title`, `description`, `due_date`, `priority_id`, `status_id`, `category_id`) VALUES
(84, 0, 'v', 'v', '2024-10-11 00:00:00', 1, 1, 0),
(85, 3, 'yy', 'yy', '2024-10-12 00:00:00', 1, 0, 13),
(86, 3, 'yy', 'yyy', '2024-10-12 00:00:00', 0, 1, 13),
(106, 6, 'eat', 'milo', '2024-10-15 07:08:00', 0, 0, 0),
(107, 6, 'sleep', 'sleep', '2024-10-15 08:05:00', 1, 0, 21),
(111, 8, 'zdrh', 'we', '2024-10-19 11:53:00', 1, 0, 22),
(125, 1, 'w', 'w', '2024-10-19 12:54:00', 1, 1, 19),
(127, 1, 'rff', 'fff', '2024-10-19 12:55:00', 1, 1, 19),
(128, 1, 'fff', 'fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff', '2024-10-19 12:56:00', 1, 0, 19),
(129, 1, 'asc', '12345678+9101112131415', '2024-10-19 12:59:00', 1, 0, 19),
(130, 1, 'll', '\'jjj\'', '2024-10-19 12:59:00', 0, 0, 0),
(131, 1, 'rrrrr', 'rrrrr', '2024-10-19 03:04:00', 1, 0, 19),
(132, 1, 'บนา', 'ฝม\r\nญฐล', '2024-10-19 21:08:00', 0, 0, 23),
(133, 1, 'ดดดด', 'ดดดดดดดดดด', '2024-10-20 14:39:00', 1, 1, 0),
(135, 10, 'ww', 'ww', '2024-12-07 19:44:00', 0, 0, 0),
(136, 2, 'dd', 'dd', '2024-12-07 13:50:00', 1, 0, 0),
(137, 2, 'dddddd', 'ddd', '2025-03-01 14:30:00', 1, 0, 0),
(138, 2, 'dong gay', 'hi', '2025-03-09 15:45:00', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `username` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password`) VALUES
(0, 'Null', 'Null', 'Null'),
(1, 'fis', 'nihafis.nisamae@gmail.com', 'Hafis+1014324'),
(2, 'admin', 'oneookklub@gmail.com', 'Fis+1014324'),
(3, 'y', 'y@gmail.com', 'y'),
(4, 'donggay', 'dong@gmail.com', '555555'),
(6, 'aina', 'gg@gmail.com', 'g'),
(7, 'idill', 'teach@gmail.com', '1'),
(8, 'ggg', 'one@gmail.com', '1'),
(9, 'test', 'test@gmail.com', '888888888'),
(10, 'ggggg', 'gggg@gmail.com', '88888888');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `priority`
--
ALTER TABLE `priority`
  ADD PRIMARY KEY (`priority_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `priority_id` (`priority_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `task_ibfk_1` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `task_ibfk_4` FOREIGN KEY (`priority_id`) REFERENCES `priority` (`priority_id`),
  ADD CONSTRAINT `task_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
