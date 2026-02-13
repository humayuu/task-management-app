-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2026 at 10:46 AM
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
-- Database: `task_manager_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `task_tbl`
--

CREATE TABLE `task_tbl` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `due_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` varchar(50) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `task_tbl`
--

INSERT INTO `task_tbl` (`id`, `title`, `description`, `due_date`, `user_id`, `status`, `created_at`) VALUES
(1, 'Magnam voluptates et', 'Eiusmod corporis cul', '2026-02-07 05:12:22', '2', 'pending', '2026-02-07 05:12:22'),
(2, 'Ex perspiciatis pla', 'Vel voluptatem dolor', '2002-11-11 19:00:00', '1', 'pending', '2026-02-07 05:17:12'),
(3, 'Nobis odio ut consec', 'Tempor temporibus ul', '2022-02-04 19:00:00', '1', 'pending', '2026-02-07 05:18:45'),
(4, 'Labore enim harum es', 'Ut obcaecati volupta', '2016-03-08 19:00:00', '2', 'pending', '2026-02-07 07:31:13'),
(5, 'Vel facilis rerum qu', 'Pariatur Quis in im', '1978-04-14 19:00:00', '1', 'pending', '2026-02-07 07:44:48'),
(6, 'Pariatur Sit mollit', 'Labore voluptatum Na', '2009-09-28 19:00:00', '1', 'pending', '2026-02-07 07:51:39'),
(7, 'Repellendus Possimu', 'Quasi dolores laudan', '1998-01-18 19:00:00', '3', 'pending', '2026-02-07 07:52:05'),
(8, 'Qui doloribus accusa', 'Sit voluptate veniam', '1973-04-28 19:00:00', '3', 'pending', '2026-02-07 08:48:58'),
(9, 'Nihil aut autem labo', 'Ex irure cupiditate ', '1981-08-07 19:00:00', '3', 'pending', '2026-02-07 09:10:25'),
(10, 'Cum vel vel iste et ', 'Itaque libero dolor ', '1977-05-10 19:00:00', '2', 'pending', '2026-02-07 09:12:49'),
(11, 'Lorem quos ea aut fu', 'Vel corporis eligend', '2023-06-12 19:00:00', '2', 'pending', '2026-02-07 09:13:27'),
(12, 'Tempore est non fac', 'Officiis qui delectu', '2026-02-13 19:00:00', '1', 'pending', '2026-02-07 09:18:48'),
(13, 'Dolorem sed eos inve', 'Reprehenderit volupt', '1992-09-15 19:00:00', '3', 'pending', '2026-02-07 09:44:32');

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `id` int(11) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` varchar(100) NOT NULL,
  `user_status` varchar(100) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`id`, `user_fullname`, `user_email`, `user_password`, `user_role`, `user_status`, `profile_image`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$h4y0kUIxd95ROT8/xFgrb.vipF4M.Niz30yMBSEfAAhn6Mx3.FCbe', 'admin', 'active', NULL, '2026-02-06 09:21:48'),
(2, 'Constance Graves', 'newyg@mailinator.com', '$2y$10$2pqqatOk4pWyUfUREf9xlOuyiFPIEdpWtdHLExr4ENW0kfoO2nlWe', 'manager', 'inactive', 'image_6985be0849d641770372616.png', '2026-02-06 10:10:16'),
(3, 'Uma Barrera', 'vyzubaty@mailinator.com', '$2y$10$dx8LnlWYIgJw0cFzZfw4Aeqo4m1PvTyrAkaYyzsTuGxlxNpAcrMmG', 'manager', 'active', NULL, '2026-02-07 07:42:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task_tbl`
--
ALTER TABLE `task_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task_tbl`
--
ALTER TABLE `task_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
