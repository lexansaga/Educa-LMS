-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2022 at 09:23 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `admin-database`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `id` int(11) NOT NULL,
  `start_date` varchar(50) NOT NULL,
  `end_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`id`, `start_date`, `end_date`) VALUES
(4, '2021-10-6', '2021-12-30'),
(5, '2021-10-6', '2022-01-06'),
(7, '2021-10-6', '2022-02-28'),
(8, '2021-10-23', '2022-04-28'),
(9, '2021-11-12', '2022-11-12'),
(10, '2021-11-12', '2022-04-30'),
(11, '2021-11-12', '2021-11-13'),
(12, '2021-11-12', '2021-11-14'),
(13, '2021-11-12', '2021-11-16'),
(14, '2021-11-12', '2021-11-20'),
(15, '2021-11-12', '2021-11-23'),
(16, '2021-11-13', '2021-12-13'),
(17, '2021-11-13', '2022-01-13'),
(18, '2021-11-13', '2022-02-13'),
(19, '2021-11-13', '2022-02-13'),
(20, '2021-11-13', '2022-06-13');

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `activityname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `questions` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `timestamp` datetime NOT NULL,
  `facultyload_id` int(11) NOT NULL,
  `activity_deadline` datetime NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activitytype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `maxscore` int(11) NOT NULL,
  `course` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tasktype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allowfileupload` tinyint(1) NOT NULL,
  `maxattempt` int(11) NOT NULL,
  `timer` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '(DC2Type:json)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activities_submitted`
--

CREATE TABLE `activities_submitted` (
  `id` int(11) NOT NULL,
  `activityid` int(11) NOT NULL,
  `studentid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` int(11) DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program_class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correctanswers` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `timestamp` datetime NOT NULL,
  `elapsedtime` datetime DEFAULT NULL,
  `isvalid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities_submitted`
--

INSERT INTO `activities_submitted` (`id`, `activityid`, `studentid`, `score`, `file`, `program_class`, `course`, `correctanswers`, `timestamp`, `elapsedtime`, `isvalid`) VALUES
(79, 55, '2022-1', 0, '[]', 'LET221A', 'Child and Adolescent Development and Learning Prin', '[{\"question\":\"adsd\",\"answer\":\"as\",\"type\":\"Identification\",\"points\":3,\"choices\":[\"\",\"\",\"\",\"\"],\"isCorrect\":false}]', '2022-07-26 14:26:13', NULL, 0),
(80, 55, '2022-1', 0, '[]', 'LET221A', 'Child and Adolescent Development and Learning Prin', '[{\"question\":\"adsd\",\"answer\":\"as\",\"type\":\"Identification\",\"points\":3,\"choices\":[\"\",\"\",\"\",\"\"],\"isCorrect\":false}]', '2022-07-26 14:26:59', NULL, 1),
(81, 59, '2022-1', 0, '[\"1632035523_Good_Moral.pdf\"]', 'LET221A', 'Child and Adolescent Development and Learning Prin', '[]', '2022-07-27 10:49:11', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `announcement` varchar(255) NOT NULL,
  `post_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `admin_name`, `announcement`, `post_date`) VALUES
(6, 'admin01@admin-aja.edu.com', 'Good day everyone! There will be an Cognizant Event this coming Wednesday, 27, 2021, 10:00 AM at the School Auditorium', 'October 22, 2021'),
(7, 'admin01@admin-aja.edu.com', 'There will be a meeting this coming Monday, October 11, 2021 3:00 PM', 'October 23, 2021'),
(9, 'admin01@admin-aja.edu.com', 'Hello World', 'November 13, 2021'),
(10, 'admin01@admin-aja.edu.com', 'Hello world ulet', 'November 13, 2021');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `program_name` varchar(100) NOT NULL,
  `program_code` varchar(20) NOT NULL,
  `pdescription` varchar(200) NOT NULL,
  `date_created` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `program_name`, `program_code`, `pdescription`, `date_created`) VALUES
(16, 'Licensure Examination for Teachers', 'LET0001', ' a test of the overall knowledge and proficiency of prospective teachers to provide a reliable structure, which the practice of prospective teachers can be measured and proven, and it gives access to ', 'July 26, 2022 | 6:30 PM'),
(17, 'Certified Treasury Professional', 'CTP0001', 'The term certified treasury professional (CTP) refers to a financial designation awarded to individuals experienced in cash management and who pass an exam demonstrating their expertise by the Associa', 'July 26, 2022 | 6:31 PM');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `units` int(10) NOT NULL,
  `entlev` varchar(20) NOT NULL,
  `program` varchar(50) NOT NULL,
  `reg_date` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `course_code`, `units`, `entlev`, `program`, `reg_date`, `status`) VALUES
(41, 'Child and Adolescent Development and Learning Prin', 'CADLP', 6, '', 'Licensure Examination for Teachers', 'July 26, 2022 | 7:24 PM', '');

-- --------------------------------------------------------

--
-- Table structure for table `course_enrolled`
--

CREATE TABLE `course_enrolled` (
  `id` int(11) NOT NULL,
  `idnum` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `year_term` varchar(50) NOT NULL,
  `program_class` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `Interim1` varchar(11) NOT NULL,
  `Midterm` varchar(11) NOT NULL,
  `Interim2` varchar(11) NOT NULL,
  `Final` varchar(11) NOT NULL,
  `Grade` varchar(11) NOT NULL,
  `Remarks` varchar(20) NOT NULL,
  `AY` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20211022025134', '2021-10-22 04:55:25', 3133),
('DoctrineMigrations\\Version20211105055522', '2021-11-05 06:56:05', 1376),
('DoctrineMigrations\\Version20211105060956', '2021-11-05 07:10:13', 265),
('DoctrineMigrations\\Version20211105061221', '2021-11-05 07:12:27', 227),
('DoctrineMigrations\\Version20211105061551', '2021-11-05 07:16:18', 2129),
('DoctrineMigrations\\Version20211105065256', '2021-11-05 07:53:02', 1559),
('DoctrineMigrations\\Version20211106045303', '2021-11-06 05:54:38', 2509),
('DoctrineMigrations\\Version20220621053043', '2022-06-21 07:31:30', 759),
('DoctrineMigrations\\Version20220621061333', '2022-06-21 08:13:45', 218),
('DoctrineMigrations\\Version20220621061649', '2022-06-21 08:17:37', 205),
('DoctrineMigrations\\Version20220623062623', '2022-06-23 08:26:51', 702),
('DoctrineMigrations\\Version20220623084359', '2022-06-23 10:44:09', 353),
('DoctrineMigrations\\Version20220626060939', '2022-06-26 08:09:55', 652),
('DoctrineMigrations\\Version20220626085156', '2022-06-26 10:52:10', 1053),
('DoctrineMigrations\\Version20220626085304', '2022-06-26 10:53:15', 155),
('DoctrineMigrations\\Version20220626105732', '2022-06-26 12:57:40', 170),
('DoctrineMigrations\\Version20220627070545', '2022-06-27 09:05:55', 579),
('DoctrineMigrations\\Version20220627071459', '2022-06-27 09:15:07', 315),
('DoctrineMigrations\\Version20220627084102', '2022-06-27 10:41:09', 253),
('DoctrineMigrations\\Version20220627085323', '2022-06-27 10:53:32', 206),
('DoctrineMigrations\\Version20220627091710', '2022-06-27 11:17:19', 409),
('DoctrineMigrations\\Version20220627103609', '2022-06-27 12:36:18', 275),
('DoctrineMigrations\\Version20220627112739', '2022-06-27 13:27:48', 879),
('DoctrineMigrations\\Version20220628065403', '2022-06-28 08:54:14', 814),
('DoctrineMigrations\\Version20220628072608', '2022-06-28 09:26:21', 175),
('DoctrineMigrations\\Version20220628073010', '2022-06-28 09:30:41', 204),
('DoctrineMigrations\\Version20220628135735', '2022-06-29 08:33:25', 181),
('DoctrineMigrations\\Version20220629062605', '2022-06-29 08:33:25', 25),
('DoctrineMigrations\\Version20220629155123', '2022-06-29 17:53:27', 259),
('DoctrineMigrations\\Version20220713150950', '2022-07-13 17:14:13', 1762),
('DoctrineMigrations\\Version20220713151648', '2022-07-13 17:16:56', 227),
('DoctrineMigrations\\Version20220716042328', '2022-07-16 06:23:47', 612),
('DoctrineMigrations\\Version20220717065541', '2022-07-17 08:55:53', 1768),
('DoctrineMigrations\\Version20220717082039', '2022-07-17 10:24:58', 209),
('DoctrineMigrations\\Version20220717082230', '2022-07-17 10:24:59', 28),
('DoctrineMigrations\\Version20220717082425', '2022-07-17 10:24:59', 27),
('DoctrineMigrations\\Version20220717084558', '2022-07-17 10:46:05', 267),
('DoctrineMigrations\\Version20220718134700', '2022-07-18 15:48:22', 1773),
('DoctrineMigrations\\Version20220722074702', '2022-07-22 09:47:25', 1516),
('DoctrineMigrations\\Version20220726132137', '2022-07-26 15:21:56', 1985),
('DoctrineMigrations\\Version20220729042001', '2022-07-29 06:20:26', 1935);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `faculty_id` varchar(50) NOT NULL,
  `special` varchar(100) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `reg_date` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `reviewcenter` varchar(255) DEFAULT NULL,
  `schedule` longtext DEFAULT NULL COMMENT '(DC2Type:json)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `faculty_loads`
--

CREATE TABLE `faculty_loads` (
  `id` int(11) NOT NULL,
  `faculty_id` varchar(50) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `modules` longtext DEFAULT NULL COMMENT '(DC2Type:json)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `program` varchar(100) NOT NULL,
  `class_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `program`, `class_name`) VALUES
(45, 'Licensure Examination for Teachers', '221'),
(46, 'Licensure Examination for Teachers', '221A'),
(51, 'Certified Treasury Professional', '335A');

-- --------------------------------------------------------

--
-- Table structure for table `studentrecords`
--

CREATE TABLE `studentrecords` (
  `id` int(11) NOT NULL,
  `idnum` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `entlev` varchar(20) NOT NULL,
  `term` varchar(20) NOT NULL,
  `program` varchar(50) NOT NULL,
  `class` varchar(20) NOT NULL,
  `enroll_date` varchar(50) NOT NULL,
  `startdate` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `idnum` varchar(10) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `entlev` varchar(20) DEFAULT NULL,
  `academic_year` varchar(50) DEFAULT NULL,
  `term` varchar(20) NOT NULL,
  `program` varchar(50) NOT NULL,
  `class` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `cnum` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `prevschool` varchar(80) DEFAULT NULL,
  `hea` varchar(50) DEFAULT NULL,
  `img` varchar(50) NOT NULL,
  `g_moral` varchar(50) NOT NULL,
  `NSO` varchar(50) NOT NULL,
  `reg_date` varchar(30) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `proofpayment` longtext DEFAULT NULL COMMENT '(DC2Type:json)',
  `reviewcenter` varchar(255) DEFAULT NULL,
  `extrafees` longtext DEFAULT NULL COMMENT '(DC2Type:json)',
  `username` varchar(255) NOT NULL,
  `balance` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `id_user` varchar(20) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `acctype` varchar(20) NOT NULL,
  `verified` tinyint(4) NOT NULL,
  `OTP` mediumint(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `reg_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `id_user`, `admin_name`, `username`, `email`, `acctype`, `verified`, `OTP`, `password`, `reg_date`) VALUES
(41, '2021-80001', 'Default Admin', 'admin01@educa.edu.ph', 'iammeksung@gmail.com', 'admin', 1, 0, '$2y$10$dUTC13gnR8TVvdylj3xwXOSzDuF/JICwato94cIgu18SfEb30AiVm', 'October 10, 2021'),
(44, '2021-80002', 'Mendez, Shawn, Gomez', 'Mendezsg@educa.edu.ph', 'shawnmendez@yahoo.com', 'admin', 1, 0, '$2y$10$00qmnxqSB1pXu50dSDCOHuKVmK1f9H8H7vSTUfZ/MOmqnE0opJwFu', 'October 10, 2021'),
(45, '2021-80003', 'Fuentes, Stephene Andrei, Siason', 'Fuentessas@educa.edu.ph', 'stepehene@gmail.com', 'admin', 1, 0, '$2y$10$RPw1mwZ.mEyccM/K.1Uehu3QTn4ZnOKX0kKMEp9.kUQ0gxkRIMTw2', 'October 10, 2021'),
(47, '2021-80004', 'Jackson, Jessica, Pompey', 'Jacksonjp@educa.edu.ph', 'jp@gmail.com', 'admin', 0, 844108, '$2y$10$4996rFicq06lfRYibZsyBu8ntDCZ.2oZkreYzgp7R.fbdo47iVl.q', 'October 10, 2021'),
(48, '2021-80005', 'vidallon, dave, vidallon', 'vidallondv@educa.edu.ph', 'iamdeybb@gmail.com', 'admin', 1, 0, '$2y$10$z9.yJa8UHtRlc2P.IEQGCuOzLPnpps28nTs1elaUjiXQz1BPfgU/y', 'October 23, 2021'),
(50, '2021-80006', 'odinson, loki, jones', 'odinsonlj@educa.edu.ph', 'loki@gmail.com', 'admin', 1, 0, '$2y$10$N.BZ.q4sdjUlJDdALD95mO/D4qatNQJvzExn8x7zjt1cBycOciycy', 'November 12, 2021'),
(51, '2021-80007', 'Legaspi, Marc Ace, Jumao-as', 'Legaspimaj@educa.edu.ph', 'marclegaspi2@gmail.com', 'admin', 1, 0, '$2y$10$5pF4BHp47Pv5Wm0YozVn1OupJngiFTjoRbLMERICLPuT8qtVzSQgu', 'November 13, 2021');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activities_submitted`
--
ALTER TABLE `activities_submitted`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_enrolled`
--
ALTER TABLE `course_enrolled`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty_loads`
--
ALTER TABLE `faculty_loads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentrecords`
--
ALTER TABLE `studentrecords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
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
-- AUTO_INCREMENT for table `academic_year`
--
ALTER TABLE `academic_year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `activities_submitted`
--
ALTER TABLE `activities_submitted`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `course_enrolled`
--
ALTER TABLE `course_enrolled`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `faculty_loads`
--
ALTER TABLE `faculty_loads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `studentrecords`
--
ALTER TABLE `studentrecords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
