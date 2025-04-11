-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 04:34 PM
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
-- Database: `quanlisinhvien`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `credits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `course_name`, `credits`) VALUES
(8, '#74619', 'LẬP TRÌNH HƯỚNG ĐỐI TƯỢNG', 3),
(9, '#19992', 'LẬP TRÌNH THIẾT BỊ DI DỘNG', 3),
(10, '#18235', 'THỰC HÀNH NGÔN NGỮ', 1),
(11, '#15887', 'PHÂN TÍCH THIẾT KẾ HỆ THỐNG', 3),
(12, '#12489', 'OOP', 3),
(13, '#90182', 'CÔNG CỤ VÀ PHÁT TRIỂN PHẦN MỀM', 3),
(14, '#11121', 'THỰC HÀNH TRUY XUẤT DỮ LIỆU', 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_registrations`
--

CREATE TABLE `course_registrations` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `course_id` int(11) NOT NULL,
  `registration_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_registrations`
--

INSERT INTO `course_registrations` (`id`, `username`, `course_id`, `registration_date`) VALUES
(7, 'user2', 8, '2025-04-01 13:53:26'),
(14, 'user3', 9, '2025-04-02 11:29:49'),
(15, 'user3', 10, '2025-04-02 11:29:49'),
(16, 'user3', 11, '2025-04-02 11:29:49'),
(19, 'user3', 8, '2025-04-02 11:53:22');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `upload_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `course_id`, `document_name`, `file_path`, `upload_date`) VALUES
(25, 8, 'TÀI LIỆU', '../documents/1743570625_asv1.jpg', '2025-04-02 12:10:25'),
(26, 14, 'TÀI LIỆU 2', '../documents/1743570698_bav3.jpg', '2025-04-02 12:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedule`
--

CREATE TABLE `exam_schedule` (
  `id` int(11) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `exam_date` date NOT NULL,
  `exam_time` time NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_schedule`
--

INSERT INTO `exam_schedule` (`id`, `course_code`, `exam_date`, `exam_time`, `location`) VALUES
(9, '#74619', '2025-02-04', '09:04:00', 'Khu E');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `mssv` varchar(20) NOT NULL,
  `ho_ten` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `username`, `subject`, `grade`, `mssv`, `ho_ten`) VALUES
(35, 'ADMIN', 'LẬP TRÌNH HƯỚNG ĐỐI TƯỢNG', '3', '2180607848', 'user2'),
(38, 'ADMIN', 'LẬP TRÌNH THIẾT BỊ DI DỘNG', '8', '1', 'user3'),
(39, 'ADMIN', 'THỰC HÀNH NGÔN NGỮ', '4', '1', 'user3'),
(40, 'ADMIN', 'THỰC HÀNH TRUY XUẤT DỮ LIỆU', '9', '1', 'user3');

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `id` int(11) NOT NULL,
  `lecturer_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`id`, `lecturer_id`, `name`, `email`, `phone`, `department`) VALUES
(1, '#1', 'PHƯƠNG NAM', 'nam@gmail.com', '0476246548', 'Công Nghệ Thông Tin'),
(2, '#2', 'PHƯƠNG MINH', 'minh@gmail.com', '0762397814', 'Hệ Thống Thông Tin');

-- --------------------------------------------------------

--
-- Table structure for table `teaching_schedule`
--

CREATE TABLE `teaching_schedule` (
  `id` int(11) NOT NULL,
  `lecturer_id` varchar(50) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `day` varchar(20) NOT NULL,
  `time` time NOT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `mssv` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `remember_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `mssv`, `username`, `email`, `mobile`, `password`, `address`, `role`, `created_at`, `updated_at`, `remember_token`) VALUES
(2, 'ADMIN', 'ADMIN', 'admin@gmail.com', '1111111111', '$2y$10$AXKT8.nHff5LTMbex5Qcyet4YOmRFyULfMIyTVZc4TsF3ovkPYedC', 'ADMIN', 'admin', '2025-04-01 06:11:13', '2025-04-01 06:11:26', NULL),
(3, '2180607848', 'user2', 'nam@gmail.com', '0762333773', '$2y$10$/EQUh.mTJapQgboLi7.kXuQHFOR5ubFl93IQ74FCx7i3ktJdcYZw.', '151A/4 Khu Phố 7', 'user', '2025-04-01 06:27:32', '2025-04-01 06:43:54', NULL),
(6, '2080607849', 'user4', 'user4@gmail.com', '0827384123', '$2y$10$8glNPla1Ek/KjQBmmGfT1uFaEGiVSq9PZpQeltSYPgkZpfH7PYaDe', '927d', 'user', '2025-04-02 04:38:11', '2025-04-02 04:38:11', NULL),
(7, '1980607849', 'user5', 'user5@gmail.com', '0827428733', '$2y$10$lhoog4FshhY33rcPdIElBOREChzglVhTCmIwkAC1O/uuz6uVPJ5yS', '12d9', 'user', '2025-04-02 04:41:47', '2025-04-02 04:41:47', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_registrations`
--
ALTER TABLE `course_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `exam_schedule`
--
ALTER TABLE `exam_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teaching_schedule`
--
ALTER TABLE `teaching_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mssv` (`mssv`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `course_registrations`
--
ALTER TABLE `course_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `exam_schedule`
--
ALTER TABLE `exam_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teaching_schedule`
--
ALTER TABLE `teaching_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_registrations`
--
ALTER TABLE `course_registrations`
  ADD CONSTRAINT `course_registrations_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
