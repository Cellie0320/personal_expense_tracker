-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 30, 2024 at 04:27 PM
-- Server version: 8.2.0
-- PHP Version: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expensetracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `user_id`, `name`) VALUES
(1, 1, 'Food'),
(2, 1, 'Transport'),
(3, 1, 'Entertainment'),
(4, 2, 'Groceries'),
(5, 2, 'Utilities'),
(6, 3, 'Clothing'),
(7, 3, 'Healthcare');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `category_id`, `amount`, `date`, `description`, `created_at`) VALUES
(1, 1, 1, 15.50, '2024-12-10', 'Lunch at restaurant', '2024-12-10 10:30:00'),
(2, 1, 2, 20.00, '2024-12-11', 'Taxi to work', '2024-12-11 06:00:00'),
(3, 1, 3, 50.00, '2024-12-12', 'Movie tickets', '2024-12-12 17:00:00'),
(4, 2, 4, 100.00, '2024-12-09', 'Weekly groceries', '2024-12-09 16:00:00'),
(5, 2, 5, 75.00, '2024-12-10', 'Electricity bill payment', '2024-12-10 12:00:00'),
(6, 3, 6, 120.00, '2024-12-08', 'New winter jacket', '2024-12-08 11:00:00'),
(7, 3, 7, 200.00, '2024-12-07', 'Doctor\'s appointment', '2024-12-07 08:00:00'),
(8, 1, 2, 250.00, '2023-12-20', 'Lunch at a restaurant', '2024-12-20 17:48:06'),
(9, 9, 3, 100.00, '2024-12-22', 'Netflix Subscription', '2024-12-22 15:06:58'),
(10, 9, 1, 100.00, '2024-12-22', 'Dinner at Steers', '2024-12-22 15:15:25'),
(11, 9, 4, 50.00, '2024-12-22', 'Shopping at Shoprite', '2024-12-22 15:31:06'),
(13, 4, 2, 150.00, '2024-12-21', 'Uber trip', '2024-12-22 17:14:14'),
(14, 9, 7, 3000.00, '2024-12-12', 'Emergency Visit', '2024-12-23 16:02:53'),
(50, 9, 4, 150.00, '2024-11-22', 'Shopping at Checkers', '2024-12-29 15:15:28'),
(51, 9, 1, 40.00, '2024-12-19', 'Food test', '2024-12-29 15:17:12'),
(53, 9, 1, 100.00, '2024-11-15', 'Grocery shopping', '2024-12-29 15:39:16'),
(54, 9, 1, 50.00, '2024-12-18', 'Dischem shopping ', '2024-12-29 15:49:16'),
(55, 9, 1, 150.00, '2024-11-14', 'Shopping at PEP', '2024-12-29 15:59:51'),
(56, 9, 1, 30.00, '2024-11-08', 'Bought a Red Bull', '2024-12-29 16:18:52'),
(57, 9, 1, 50.00, '2024-12-20', 'MR D purchase', '2024-12-29 16:35:31'),
(58, 9, 3, 70.00, '2024-11-24', 'YouTube Subscription', '2024-12-30 14:56:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'JohnDoe', 'john@example.com', 'hashed_password_1', '2024-12-14 12:51:51'),
(2, 'JaneSmith', 'jane@example.com', 'hashed_password_2', '2024-12-14 13:49:35'),
(3, 'AliceBrown', 'alice@example.com', 'hashed_password_3', '2024-12-14 13:50:21'),
(4, 'Cellie_0320', 'marceldelange20@gmail.com', '$2y$10$6vTQ1oG3JlQHmbg5OFTKPeh5Uq7Nb0rgEV2LWU0AwJnaXVscwfs5S', '2024-12-15 15:28:53'),
(7, 'Peet', 'peetdelange1@gmail.com', '$2y$10$HXD0sDTbsK8jisqBVffG7.wLDXsAnEP5ddy/DN0mC5PuUmxsV62Ly', '2024-12-17 17:37:45'),
(8, 'Luan', 'luanvd1@gmail.com', '$2y$10$XKIxwbUUlNacowtjEpcdI.ke7gZdDjd64wx4yrsWFXokBoYoZrNAe', '2024-12-18 14:57:59'),
(9, 'Peter_Pan', 'peter1@gmail.com', '$2y$10$uNduoYx89yL45F/VwtW.4e34sItfNt7zFQfVMeIzSS3PHWNFqoU8a', '2024-12-20 16:24:26'),
(10, 'Buddy', 'buddy1@gmail.com', '$2y$10$2LqWzf9xbrTkkBt9bu7aqe41pWQH71rFsQNlxm9xzy/uFcZuPErNO', '2024-12-24 14:27:09'),
(15, 'Bruce Wayne', 'batman1@gmail.com', '$2y$10$2JiA2d7.tqW/4Q4E3qmV0O4ef1a/rFcfUCe6/Bl3RNqg54N3XmHRm', '2024-12-27 17:33:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
