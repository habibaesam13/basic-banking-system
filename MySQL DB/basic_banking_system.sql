-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2023 at 04:02 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `basic_banking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `sender_id` int(10) UNSIGNED NOT NULL,
  `receiver_id` int(10) UNSIGNED NOT NULL,
  `transaction_amount` int(11) NOT NULL,
  `send_at` datetime NOT NULL,
  `transaction_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `sender_id`, `receiver_id`, `transaction_amount`, `send_at`, `transaction_status`) VALUES
(5, 5, 1, 1050, '2023-09-09 17:25:23', 'not completed'),
(6, 5, 1, 1050, '2023-09-09 17:30:46', 'not completed'),
(7, 5, 1, 5000, '2023-09-09 17:31:50', 'not completed'),
(10, 5, 1, 1000, '2023-09-09 17:45:24', 'not completed'),
(11, 5, 1, 1000, '2023-09-09 17:48:10', 'completed'),
(12, 5, 1, 100, '2023-09-10 13:03:05', 'completed'),
(13, 5, 1, 100, '2023-09-10 13:03:21', 'completed'),
(14, 5, 1, 100, '2023-09-10 13:07:39', 'completed'),
(15, 5, 1, 3, '2023-09-10 13:09:15', 'not completed'),
(16, 5, 1, 50, '2023-09-10 13:10:30', 'completed'),
(17, 1, 2, 50, '2023-09-10 14:53:12', 'completed'),
(18, 2, 1, 100, '2023-09-10 15:06:36', 'completed'),
(19, 2, 1, 100, '2023-09-10 15:09:07', 'completed'),
(20, 1, 2, 120, '2023-09-10 16:45:49', 'completed'),
(21, 7, 9, 1000, '2023-09-10 16:46:49', 'completed'),
(22, 2, 7, 500, '2023-09-10 16:59:59', 'completed'),
(23, 6, 4, 2500, '2023-09-10 17:00:48', 'completed'),
(24, 6, 7, 200, '2023-09-10 17:01:15', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_Id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` text NOT NULL,
  `balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_Id`, `first_name`, `last_name`, `email`, `phone_number`, `balance`) VALUES
(1, 'habiba', 'esam', 'habebaesam13@gmail.com', '010225568789', 56630),
(2, 'ahmed', 'mohamed', 'ahmedmohamed@gmail.com', '01152888798', 13420),
(3, 'salma', 'ahmed', 'salma@gmail.com', '011205555468', 5200),
(4, 'sondos', 'said', 'sondossayd@gmail.com', '01523657895', 32500),
(5, 'maryem', 'khaled', 'maryemkahled@gmail.com', '01525356989', 400),
(6, 'fatma', 'ahmed', 'fatmaahmed@gmail.com', '0156898746', 24800),
(7, 'sayed', 'ashraf', 'sayed@gmail.com', '0102365987', 4720),
(8, 'mohamed', 'ahmed', 'mohamedahmed@gmail.com', '0115023569', 4000),
(9, 'sara', 'atef', 'saraatef@gmail.com', '0112554898', 11000),
(10, 'moaz', 'mohamed', 'moazmohamed@gmail.com', '0112578965', 7000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `sender_id` (`sender_id`,`receiver_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
