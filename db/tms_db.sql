-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2024 at 02:27 PM
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
-- Database: `tms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `opened` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`chat_id`, `from_id`, `to_id`, `message`, `opened`, `created_at`) VALUES
(1, 1, 3, 'hello', 1, '2024-05-07 18:16:50'),
(0, 7, 8, 'hello', 1, '2024-06-03 13:54:55'),
(0, 7, 6, 'mambo', 1, '2024-06-03 13:59:51'),
(0, 6, 7, 'poah mzima', 1, '2024-06-03 14:01:45'),
(0, 6, 1, 'sorry boss', 1, '2024-06-03 14:07:57'),
(0, 6, 2, 'mamb', 1, '2024-06-03 14:15:57'),
(0, 6, 3, 'na wew', 1, '2024-06-03 14:21:08'),
(0, 6, 2, 'sawa', 1, '2024-06-03 15:10:30'),
(0, 6, 3, 'mmmh', 1, '2024-06-03 15:14:01'),
(0, 3, 6, 'nimefanyeje', 0, '2024-06-03 15:16:02'),
(0, 3, 2, 'm', 0, '2024-06-03 15:20:23'),
(0, 3, 2, 'poah', 0, '2024-06-03 15:33:32'),
(0, 3, 1, 'hii boss kweman', 0, '2024-06-03 16:14:30'),
(0, 1, 13, 'sawa', 1, '2024-06-03 16:26:18'),
(0, 1, 8, 'hello', 1, '2024-06-05 00:28:36'),
(0, 1, 6, 'okay unaSEMAJE', 1, '2024-06-05 07:17:12'),
(0, 7, 1, 'mambo', 0, '2024-06-06 01:36:24'),
(0, 6, 7, 'niko poah\n', 1, '2024-06-12 23:52:47'),
(0, 18, 5, 'hello', 0, '2024-06-19 06:29:45'),
(0, 1, 18, 'hello', 1, '2024-06-20 05:07:49'),
(0, 2, 6, 'poah', 0, '2024-06-28 01:11:13'),
(0, 2, 1, 'hello', 0, '2024-06-28 01:13:06'),
(0, 18, 20, 'hello', 0, '2024-07-01 03:40:36'),
(0, 18, 1, 'hii\n', 0, '2024-07-01 12:02:08');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `mentioned_users` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `conversation_id` int(11) NOT NULL,
  `user_1` int(11) NOT NULL,
  `user_2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`conversation_id`, `user_1`, `user_2`) VALUES
(1, 1, 2),
(0, 7, 6),
(0, 6, 1),
(0, 6, 2),
(0, 6, 3),
(0, 3, 2),
(0, 3, 1),
(0, 1, 13),
(0, 1, 8),
(0, 7, 1),
(0, 18, 5),
(0, 1, 18),
(0, 18, 20);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `description`) VALUES
(3, 'ICT ', 'This department is responsible for information and communication issues'),
(4, 'Registry ', 'is responsible with receiving vistors and various latters'),
(7, 'Education', 'is responsible for managing  all schools requirements'),
(9, 'ACCOUNTS ', 'This department is Responsible for financial issues  such as preparation of financial statments'),
(10, 'Constraction', 'tis is the department which is responsible for constractions insues'),
(11, 'PLANNING', 'This department is dealing with for procurement issues'),
(12, 'HR', 'Responsible For hiring employee  and managing employee'),
(13, 'Mahusiano', 'love a');

-- --------------------------------------------------------

--
-- Table structure for table `department_chats`
--

CREATE TABLE `department_chats` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_chats`
--

INSERT INTO `department_chats` (`id`, `department_id`, `user_id`, `message`, `created_at`) VALUES
(32, 9, 18, 'hello', '2024-07-01 13:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `project_list`
--

CREATE TABLE `project_list` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `manager_id` int(11) NOT NULL,
  `user_ids` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_list`
--

INSERT INTO `project_list` (`id`, `name`, `description`, `status`, `start_date`, `end_date`, `manager_id`, `user_ids`, `date_created`) VALUES
(16, 'develpo voting system', 'OKAY', 0, '2024-07-01', '2024-08-31', 18, '', '2024-07-01 00:05:02'),
(17, 'develop soma', '                                hello                            ', 5, '2024-07-01', '2024-08-10', 18, '20', '2024-07-01 03:42:37'),
(18, 'build jengo', 'wel done', 0, '2024-07-01', '2024-08-10', 16, '4', '2024-07-01 06:08:02'),
(19, 'buy chalk', 'hello', 0, '2024-07-02', '2024-08-23', 17, '15,14', '2024-07-02 22:23:20'),
(20, 'make audit', 'haha', 0, '2024-07-02', '2024-07-06', 17, '10,14', '2024-07-02 22:26:00'),
(21, 'buy new', 'hello', 0, '2024-07-03', '2024-07-26', 18, '8', '2024-07-03 05:21:35');

-- --------------------------------------------------------

--
-- Table structure for table `stakeholders`
--

CREATE TABLE `stakeholders` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stakeholders`
--

INSERT INTO `stakeholders` (`id`, `company_name`, `address`, `location`, `department_id`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(2, 'Kimila', '2958 Kasulu', 'kasulu', 10, '1@gmail.com', '072310800', '2024-07-03 06:56:21', '2024-07-03 06:56:21');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'Task Management System', 'info@sample.comm', '+6948 8542 623', '2102  Caldwell Road, Rochester, New York, 14608', '');

-- --------------------------------------------------------

--
-- Table structure for table `task_list`
--

CREATE TABLE `task_list` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_list`
--

INSERT INTO `task_list` (`id`, `project_id`, `task`, `description`, `status`, `date_created`, `user_id`, `attachment`) VALUES
(52, 18, 'asFM,.', 'DCFSDNM', 2, '2024-07-01 07:49:07', 16, 'uploads/financial mangement.pdf'),
(53, 18, 'ASCMzxmv<x', 'ASdCM&amp;lt;', 2, '2024-07-01 07:52:20', 16, NULL),
(55, 18, '>ZXMV<X?>V<CZV>', 'ZXC&amp;gt;DGMFDFG', 3, '2024-07-01 07:54:14', 18, 'uploads/E-COMMERECE GRP ASSIGNMENT 2.pdf'),
(64, 17, 'hello', '								jhjlkjklklFLSDKG						', 3, '2024-07-01 08:22:22', 8, NULL),
(65, 17, 'wew apo', '				mwenyewe			', 1, '2024-07-01 12:23:42', 8, NULL),
(66, 19, 'survey', 'teaching material', 1, '2024-07-02 22:29:09', 15, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1 = admin, 2 = HOD, 3 = employee',
  `avatar` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `department_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `avatar`, `date_created`, `department_id`, `status`) VALUES
(1, 'ELLY', 'GERADY', 'mpangosogo@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 1, '1714864560_kasulu.png', '2020-11-26 10:57:04', 4, 'active'),
(4, 'George', 'Wilson', 'gwilson@sample.com', 'd40242fb23c45206fadee4e2418f274f', 3, '1606963560_avatar.jpg', '2020-12-03 10:46:41', 10, 'active'),
(5, 'Mike', 'Williams', 'cba@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, '1606963620_47446233-clean-noir-et-gradient-sombre-image-de-fond-abstrait-.jpg', '2020-12-03 10:47:06', 9, 'active'),
(6, 'mpango', 'kakoko', '1234@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 2, '1716974280_65adad0ced1c7_IMG-20230526-WA0022.jpg', '2024-05-01 16:46:39', 11, 'active'),
(7, 'mbby', 'lumoko', '12345@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, '', '2024-05-01 17:03:14', 4, 'active'),
(8, 'mobile', 'phone', '123456@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, '', '2024-05-04 07:44:43', 9, 'active'),
(10, 'mac', 'os', '12345678@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, '1714858920_kasulu.jpg', '2024-05-04 14:42:54', 3, 'active'),
(11, 'zd', 'kazi', '1234567@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, '1714859040_img1.avif', '2024-05-04 14:44:41', NULL, 'inactive'),
(12, 'pic', 'kali', 'abc@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, '1714859220_kasulu.png', '2024-05-04 14:47:51', NULL, 'active'),
(13, 'twijane', 'kulima', 'abcd@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, '1714860660_kasulu.jpg', '2024-05-04 15:11:29', NULL, 'active'),
(14, 'my', 'love', 'abcde@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, '1714860780_kasulu.png', '2024-05-04 15:13:09', 3, 'active'),
(15, 'mpango', 'kakoko', '12345679@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, '1716966900_65a7c6649a857_GROUP.jpg', '2024-05-29 00:15:19', 3, 'inactive'),
(16, 'ally', 'masudi', 'all@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 2, '', '2024-06-03 06:52:04', 10, 'active'),
(17, 'tra', 'nkonko', 'tra@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 2, '', '2024-06-03 08:19:41', 3, 'active'),
(18, 'hamali', 'yule', '123457@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 2, '1718796000_65a7c6649a857_GROUP.jpg', '2024-06-19 04:20:19', 9, 'active'),
(19, 'sawa', 'nawew', 'sawa@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, '1718875680_hero.jpg', '2024-06-20 02:28:07', 11, 'active'),
(20, 'zaburon', 'GERADY', '1@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 3, '', '2024-06-30 22:57:36', 9, 'inactive');

-- --------------------------------------------------------

--
-- Table structure for table `user_productivity`
--

CREATE TABLE `user_productivity` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `subject` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `user_id` int(11) NOT NULL,
  `time_rendered` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_productivity`
--

INSERT INTO `user_productivity` (`id`, `project_id`, `task_id`, `comment`, `subject`, `date`, `start_time`, `end_time`, `user_id`, `time_rendered`, `date_created`) VALUES
(1, 1, 1, '							&lt;p&gt;Sample Progress&lt;/p&gt;&lt;ul&gt;&lt;li&gt;Test 1&lt;/li&gt;&lt;li&gt;Test 2&lt;/li&gt;&lt;li&gt;Test 3&lt;/li&gt;&lt;/ul&gt;																			', 'Sample Progress', '2020-12-03', '08:00:00', '10:00:00', 1, 2, '2020-12-03 12:13:28'),
(2, 1, 1, '							Sample Progress						', 'Sample Progress 2', '2020-12-03', '13:00:00', '14:00:00', 1, 1, '2020-12-03 13:48:28'),
(3, 1, 2, '							Sample						', 'Test', '2020-12-03', '08:00:00', '09:00:00', 5, 1, '2020-12-03 13:57:22'),
(4, 1, 2, 'asdasdasd', 'Sample Progress', '2020-12-02', '08:00:00', '10:00:00', 2, 2, '2020-12-03 14:36:30'),
(5, 5, 6, 'Has finish', 'Demo', '2023-11-18', '09:47:00', '02:47:00', 1, -7, '2023-11-18 09:47:54'),
(6, 7, 0, '													', '', '0000-00-00', '00:00:00', '00:00:00', 7, 0, '2024-05-01 17:17:12'),
(7, 5, 6, '													', '', '0000-00-00', '00:00:00', '00:00:00', 1, 0, '2024-05-07 15:30:43'),
(8, 5, 6, '													', '', '0000-00-00', '00:00:00', '00:00:00', 1, 0, '2024-05-08 23:33:03'),
(9, 8, 0, '													', '', '0000-00-00', '00:00:00', '00:00:00', 12, 0, '2024-05-24 02:14:11'),
(10, 8, 0, '													', '', '0000-00-00', '00:00:00', '00:00:00', 12, 0, '2024-05-24 02:14:42'),
(11, 1, 1, 'complete', 'the form is ready started created', '2024-06-03', '12:51:00', '12:51:00', 3, 0, '2024-06-03 12:46:08'),
(12, 9, 9, 'duuh so touf', 'the form is ready started created', '2024-06-21', '07:20:00', '07:23:00', 18, 0.05, '2024-06-19 07:19:04'),
(13, 10, 0, 'duuuh', 'nimefikiah hapa', '2024-06-13', '00:38:00', '00:39:00', 17, 0.0166667, '2024-06-28 00:34:42'),
(14, 12, 12, 'hello', 'done', '2024-06-14', '00:46:00', '00:46:00', 17, 0, '2024-06-28 00:41:47'),
(16, 17, 19, 'okay', '', '2024-07-01', '04:24:00', '04:24:00', 20, 0, '2024-07-01 04:18:32'),
(17, 17, 0, '													', '', '0000-00-00', '00:00:00', '00:00:00', 18, 0, '2024-07-01 04:33:43'),
(18, 16, 18, '													', '', '0000-00-00', '00:00:00', '00:00:00', 20, 0, '2024-07-01 04:37:32'),
(19, 17, 21, '													', '', '0000-00-00', '00:00:00', '00:00:00', 16, 0, '2024-07-01 06:11:32'),
(20, 18, 55, 'hjghj', 'the form is ready started created', '2024-07-11', '12:09:00', '12:11:00', 18, 0.0333333, '2024-07-01 12:05:32'),
(21, 21, 0, '													', '', '0000-00-00', '00:00:00', '00:00:00', 8, 0, '2024-07-03 05:22:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_chats`
--
ALTER TABLE `department_chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_chats_ibfk_1` (`department_id`),
  ADD KEY `department_chats_ibfk_2` (`user_id`);

--
-- Indexes for table `project_list`
--
ALTER TABLE `project_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stakeholders`
--
ALTER TABLE `stakeholders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stakeholders_ibfk_1` (`department_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_list`
--
ALTER TABLE `task_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_department` (`department_id`);

--
-- Indexes for table `user_productivity`
--
ALTER TABLE `user_productivity`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `department_chats`
--
ALTER TABLE `department_chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `project_list`
--
ALTER TABLE `project_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `stakeholders`
--
ALTER TABLE `stakeholders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `task_list`
--
ALTER TABLE `task_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_productivity`
--
ALTER TABLE `user_productivity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department_chats`
--
ALTER TABLE `department_chats`
  ADD CONSTRAINT `department_chats_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `department_chats_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stakeholders`
--
ALTER TABLE `stakeholders`
  ADD CONSTRAINT `stakeholders_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task_list`
--
ALTER TABLE `task_list`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
