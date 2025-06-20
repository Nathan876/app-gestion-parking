-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 20, 2025 at 08:32 PM
-- Server version: 8.0.35
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app-gestion-parking`
--

-- --------------------------------------------------------

--
-- Table structure for table `parkings`
--

CREATE TABLE `parkings` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `total_capacity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parkings`
--

INSERT INTO `parkings` (`id`, `name`, `address`, `city`, `postal_code`, `total_capacity`) VALUES
(1, 'Parking Centre-Ville', '12 Rue du Commerce', 'Paris', '75001', 100),
(2, 'Parking Gare', '1 Place de la Gare', 'Lyon', '69003', 150),
(3, 'Parking Université', '99 Avenue des Études', 'Toulouse', '31000', 80);

-- --------------------------------------------------------

--
-- Table structure for table `parking_spaces`
--

CREATE TABLE `parking_spaces` (
  `id` int NOT NULL,
  `parking_id` int NOT NULL,
  `space_number` int NOT NULL,
  `space_type` tinyint(1) NOT NULL,
  `is_free` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parking_spaces`
--

INSERT INTO `parking_spaces` (`id`, `parking_id`, `space_number`, `space_type`, `is_free`) VALUES
(7, 1, 1, 0, 1),
(8, 1, 2, 0, 1),
(9, 2, 2, 0, 1),
(10, 1, 2, 0, 1),
(3081, 1, 1, 0, 1),
(3082, 1, 2, 0, 1),
(3083, 1, 3, 0, 1),
(3084, 1, 4, 0, 1),
(3085, 1, 5, 0, 1),
(3086, 1, 6, 0, 1),
(3087, 1, 7, 0, 1),
(3088, 1, 8, 0, 1),
(3089, 1, 9, 0, 1),
(3090, 1, 10, 0, 1),
(3091, 1, 11, 0, 1),
(3092, 1, 12, 0, 1),
(3093, 1, 13, 0, 1),
(3094, 1, 14, 0, 1),
(3095, 1, 15, 0, 1),
(3096, 1, 16, 1, 1),
(3097, 1, 17, 1, 1),
(3098, 1, 18, 2, 1),
(3099, 1, 19, 2, 1),
(3100, 1, 20, 3, 1),
(3101, 2, 1, 0, 1),
(3102, 2, 2, 0, 1),
(3103, 2, 3, 0, 1),
(3104, 2, 4, 0, 1),
(3105, 2, 5, 0, 1),
(3106, 2, 6, 0, 1),
(3107, 2, 7, 0, 1),
(3108, 2, 8, 0, 1),
(3109, 2, 9, 0, 1),
(3110, 2, 10, 0, 1),
(3111, 2, 11, 0, 1),
(3112, 2, 12, 0, 1),
(3113, 2, 13, 0, 1),
(3114, 2, 14, 0, 1),
(3115, 2, 15, 0, 1),
(3116, 2, 16, 1, 1),
(3117, 2, 17, 1, 1),
(3118, 2, 18, 2, 1),
(3119, 2, 19, 2, 1),
(3120, 2, 20, 3, 1),
(3121, 1, 10, 1, 1),
(3122, 1, 10, 0, 1),
(3123, 1, 10000, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `id` int NOT NULL,
  `parking_id` int NOT NULL,
  `space_type` tinyint(1) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `week_day` varchar(10) NOT NULL,
  `price_per_hour` decimal(6,2) NOT NULL,
  `priority` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`id`, `parking_id`, `space_type`, `start_date`, `end_date`, `start_time`, `end_time`, `week_day`, `price_per_hour`, `priority`) VALUES
(1, 1, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Monday', 2.50, 0),
(2, 1, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Tuesday', 2.50, 0),
(3, 1, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Wednesday', 2.50, 0),
(4, 1, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Thursday', 2.50, 0),
(5, 1, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Friday', 2.50, 0),
(6, 1, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Saturday', 2.50, 0),
(7, 1, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Sunday', 2.50, 0),
(154, 1, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Monday', 2.00, 0),
(155, 1, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Tuesday', 2.00, 0),
(156, 1, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Wednesday', 2.00, 0),
(157, 1, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Thursday', 2.00, 0),
(158, 1, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Friday', 2.00, 0),
(159, 1, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Saturday', 2.00, 0),
(160, 1, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Sunday', 2.00, 0),
(161, 1, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Monday', 3.00, 0),
(162, 1, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Tuesday', 3.00, 0),
(163, 1, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Wednesday', 3.00, 0),
(164, 1, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Thursday', 3.00, 0),
(165, 1, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Friday', 3.00, 0),
(166, 1, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Saturday', 3.00, 0),
(167, 1, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Sunday', 3.00, 0),
(168, 1, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Monday', 3.00, 0),
(169, 1, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Tuesday', 3.00, 0),
(170, 1, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Wednesday', 3.00, 0),
(171, 1, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Thursday', 3.00, 0),
(172, 1, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Friday', 3.00, 0),
(173, 1, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Saturday', 3.00, 0),
(174, 1, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Sunday', 3.00, 0),
(175, 2, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Monday', 2.50, 0),
(176, 2, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Tuesday', 2.50, 0),
(177, 2, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Wednesday', 2.50, 0),
(178, 2, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Thursday', 2.50, 0),
(179, 2, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Friday', 2.50, 0),
(180, 2, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Saturday', 2.50, 0),
(181, 2, 0, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Sunday', 2.50, 0),
(182, 2, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Monday', 2.00, 0),
(183, 2, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Tuesday', 2.00, 0),
(184, 2, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Wednesday', 2.00, 0),
(185, 2, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Thursday', 2.00, 0),
(186, 2, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Friday', 2.00, 0),
(187, 2, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Saturday', 2.00, 0),
(188, 2, 1, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Sunday', 2.00, 0),
(189, 2, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Monday', 3.00, 0),
(190, 2, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Tuesday', 3.00, 0),
(191, 2, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Wednesday', 3.00, 0),
(192, 2, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Thursday', 3.00, 0),
(193, 2, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Friday', 3.00, 0),
(194, 2, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Saturday', 3.00, 0),
(195, 2, 2, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Sunday', 3.00, 0),
(196, 2, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Monday', 1.00, 0),
(197, 2, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Tuesday', 1.00, 0),
(198, 2, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Wednesday', 1.00, 0),
(199, 2, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Thursday', 1.00, 0),
(200, 2, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Friday', 1.00, 0),
(201, 2, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Saturday', 1.00, 0),
(202, 2, 3, '2024-01-01', '2030-12-31', '08:00:00', '20:00:00', 'Sunday', 1.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `parking_space_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `arrival_date` date NOT NULL,
  `arrival_time` time NOT NULL,
  `departure_date` date NOT NULL,
  `departure_time` time NOT NULL,
  `status` enum('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `notification_before_start` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `parking_space_id`, `amount`, `arrival_date`, `arrival_time`, `departure_date`, `departure_time`, `status`, `created_at`, `notification_before_start`) VALUES
(19, 1, 7, 5.00, '2025-06-01', '10:00:00', '2025-06-01', '11:30:00', 'pending', '2025-05-28 07:17:50', 0),
(20, 1, 7, 5.00, '2025-07-14', '08:00:00', '2025-07-14', '10:00:00', 'pending', '2025-05-28 07:27:43', 0),
(21, 1, 8, 5.00, '2025-07-14', '08:00:00', '2025-07-14', '10:00:00', 'pending', '2025-05-28 07:31:45', 0),
(22, 1, 7, 2.50, '2025-07-14', '10:00:00', '2025-07-14', '11:00:00', 'pending', '2025-05-28 07:34:30', 0),
(23, 1, 7, 7.50, '2025-07-14', '11:00:00', '2025-07-14', '12:00:00', 'pending', '2025-05-28 07:53:02', 0),
(25, 1, 7, 2.50, '2025-07-08', '10:00:00', '2025-07-08', '11:00:00', 'pending', '2025-06-02 16:18:32', 0),
(92, 4, 7, 0.00, '2025-06-20', '21:22:00', '2025-06-20', '21:30:00', 'pending', '2025-06-20 19:22:25', 0),
(93, 4, 8, 0.00, '2025-06-20', '21:22:00', '2025-06-20', '21:30:00', 'pending', '2025-06-20 19:26:56', 0),
(94, 4, 10, 0.00, '2025-06-20', '21:22:00', '2025-06-20', '22:30:00', 'pending', '2025-06-20 19:27:20', 0),
(95, 4, 7, 5.00, '2025-06-21', '10:00:00', '2025-06-21', '11:30:00', 'pending', '2025-06-20 19:28:14', 0),
(96, 4, 8, 5.00, '2025-06-21', '10:00:00', '2025-06-21', '11:30:00', 'pending', '2025-06-20 19:29:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `updated_at`) VALUES
(1, 'max_reservation_duration_hours', '72', '2025-06-20 10:09:36'),
(2, 'max_advance_booking_days', '30', '2025-06-20 10:09:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `role` tinyint(1) NOT NULL DEFAULT '0',
  `phone_number` varchar(20) DEFAULT NULL,
  `license_plate` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `active_account` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `email`, `password`, `birth_date`, `role`, `phone_number`, `license_plate`, `created_at`, `active_account`) VALUES
(1, 'Test', 'User', 'test@test.com', '$2y$10$DMEaiQOGj.n3epgEja6VOOXYx/nAXjwWCR/UjGe4czimWrmXoZT3G', '1990-01-01', 0, NULL, NULL, '2025-04-28 12:50:35', 1),
(3, 'Doe', 'John', 'john.doe@mail.com', '$2y$12$ZufWTH/m4zKfpxvYX1EtaOcdF4G8xZJ3rChxykjbTzYnZ5rON2.lO', NULL, 0, '0712345678', 'BA-123-BB', '2025-06-13 06:47:14', 1),
(4, 'Doe', 'John', 'doe.john@mail.com', '$2y$12$q2m5onr59u2uNLlt1Yb0A.QK2f1DdmnIH/GhLa33rnBHjKq3DYwvS', NULL, 0, '0712345678', 'BB-123-BB', '2025-06-13 06:58:50', 1),
(5, 'Doe', 'John', 'john.doe@gmail.com', '$2y$12$La7/zFPChdrLGZZAVG45uuqE70wmOb8ukgI5K.EndyQ0VDyhH4zpa', NULL, 1, '0712345678', 'BB-123-BB', '2025-06-13 06:59:52', 1),
(6, 'Dupont', 'Marie', 'marie.dupont@gmail.com', '$2y$12$wS4gqpo4.VqMTFLNjX8II.TEYzzZi88yOM9lKD9oWw29wUcZwWKRK', NULL, 1, '0712345678', 'BB-123-BB', '2025-06-13 07:03:58', 1),
(9, 'Dufour', 'Baptiste', 'bapt45@outlook.fr', '$2y$12$luhhwk56lN7N1kbRmUt79ujMXNiAmem4BWjtaLYO76fS8VV7G5WgK', '2005-06-10', 0, '0712345678', ' BB-123-BB', '2025-06-13 08:08:52', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `parkings`
--
ALTER TABLE `parkings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parking_spaces`
--
ALTER TABLE `parking_spaces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parking_id` (`parking_id`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parking_id` (`parking_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parking_space_id` (`parking_space_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

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
-- AUTO_INCREMENT for table `parkings`
--
ALTER TABLE `parkings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `parking_spaces`
--
ALTER TABLE `parking_spaces`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3124;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `parking_spaces`
--
ALTER TABLE `parking_spaces`
  ADD CONSTRAINT `parking_spaces_ibfk_1` FOREIGN KEY (`parking_id`) REFERENCES `parkings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prices`
--
ALTER TABLE `prices`
  ADD CONSTRAINT `prices_ibfk_1` FOREIGN KEY (`parking_id`) REFERENCES `parkings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`parking_space_id`) REFERENCES `parking_spaces` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
