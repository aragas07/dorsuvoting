-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2022 at 05:28 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dorsuvoting`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fname` varchar(45) DEFAULT NULL,
  `mname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fname`, `mname`, `lname`, `username`, `password`) VALUES
(1, 'Wervy', 'J', 'Golocino', 'wervy', 'golocino');

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `position_id` int(11) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `approved` tinyint(4) DEFAULT NULL,
  `grades` varchar(255) DEFAULT NULL,
  `cor` varchar(255) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `comment` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`position_id`, `student_id`, `approved`, `grades`, `cor`, `type`, `comment`) VALUES
(1, '2020-0002', 1, 'PXL_20211103_010350429.PORTRAIT.jpg', 'Intro.jpg', 1, NULL),
(2, '2020-0003', 1, 'consent-1.jpg', 'Sample Wireframe.png', 1, NULL),
(2, '2020-0005', 1, 'PXL_20211103_010350429.PORTRAIT.jpg', 'Sample Wireframe.png', 1, NULL),
(1, '2020-0008', 1, 'new_logo.png', 'JOE01972.JPG', 0, NULL),
(1, '2020-0010', 1, 'new_logo.png', '273026640_748957496086201_5658389762292723469_n.jpg', 1, NULL),
(8, '2020-0011', 0, 'PXL_20211103_010350429.PORTRAIT.jpg', 'Sample Wireframe.png', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `institute_id` int(11) NOT NULL,
  `acronyms` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course_name`, `institute_id`, `acronyms`) VALUES
(2, 'Bachelor of Science in Information Technology', 5, 'BSIT'),
(3, 'Bachelor of Industrial Technology Management', 5, 'BITM'),
(4, 'Bachelor of Science in Mathematics with Busin', 5, 'BSMath-Business'),
(5, 'Bachelor of Science in Civil Engineering', 5, 'BSCE'),
(6, 'Bachelor of Science in Business Administratio', 6, 'BSBA'),
(7, 'Bachelor of Science in Hotel and Restaurant M', 6, 'BSHRM'),
(8, 'Business of Science in Criminology', 6, 'BSCrim'),
(9, 'Bachelor of Elementary Education', 7, 'BSEEd'),
(10, 'Bachelor of Secondary Education major in Biol', 7, 'BSEd - biology'),
(11, 'Bachelor of Secondary Education major in Engl', 7, 'BSEd - English'),
(12, 'Bachelor of Secondary Education major in Math', 7, 'BSEd - Math'),
(13, 'Bachelor of Secondary Education major in Phys', 7, 'BSEd - Physics'),
(14, 'Bachelor of Physical Education', 7, 'BPE'),
(15, 'Bachelor of Agricultural Technology', 8, 'BAT'),
(16, 'Bachelor of Science in Agribusiness Managemen', 8, 'BSAM'),
(17, 'Bachelor of Science in Biology', 8, 'BSBio'),
(18, 'Bachelor of Science in Environmental Science', 8, 'BSES'),
(19, 'Bachelor of Science in Nursing', 8, 'BSN');

-- --------------------------------------------------------

--
-- Table structure for table `institute`
--

CREATE TABLE `institute` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `institute`
--

INSERT INTO `institute` (`id`, `name`) VALUES
(5, 'Institute of Computer Engineering - ICE'),
(6, 'IBPA'),
(7, 'IETT'),
(8, 'IALS');

-- --------------------------------------------------------

--
-- Table structure for table `open_elect`
--

CREATE TABLE `open_elect` (
  `id` int(11) NOT NULL,
  `application_open` date DEFAULT NULL,
  `application_close` date DEFAULT NULL,
  `vote_start` date DEFAULT NULL,
  `vote_end` date DEFAULT NULL,
  `sy` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `open_elect`
--

INSERT INTO `open_elect` (`id`, `application_open`, `application_close`, `vote_start`, `vote_end`, `sy`) VALUES
(1, '2022-06-26', '2022-06-29', '2022-06-30', '2022-07-13', '2022-2023');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `position_name` varchar(45) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `position_name`, `type`) VALUES
(1, 'Governor', 1),
(2, 'Vice Governor', 1),
(3, 'Secretary', 1),
(4, 'Treasurer', 1),
(5, 'Auditor', 1),
(6, 'P.I.O', 1),
(7, 'Sgt.at Arms', 1),
(8, 'President', 0),
(9, 'Vice President', 0),
(10, 'Secretary', 0),
(11, 'Treasurer', 0),
(12, 'Auditor', 0),
(13, 'P.I.O', 0),
(14, 'Sgt.at Arms', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` varchar(10) NOT NULL,
  `profile` longtext DEFAULT NULL,
  `fname` varchar(45) DEFAULT NULL,
  `mname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `gpa` double DEFAULT NULL,
  `affiliation` longtext DEFAULT NULL,
  `year` varchar(45) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `email` varchar(45) CHARACTER SET ascii DEFAULT NULL,
  `contact` varchar(45) DEFAULT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `profile`, `fname`, `mname`, `lname`, `birth`, `gpa`, `affiliation`, `year`, `status`, `email`, `contact`, `course_id`) VALUES
('2020-0001', NULL, 'Wervy', 'Golosino', 'Golosino', '1999-12-25', 1.5, NULL, '2nd', 0, 'wervy@gmail.com', '9107787149', 2),
('2020-0002', NULL, 'Leo', 'Maratas', 'Maratas', '1999-12-25', 1.5, NULL, '2nd', 1, 'leo@gmail.com', '9107787149', 8),
('2020-0003', NULL, 'AdLorenz', 'Cascas', 'Cascas', '1999-12-25', 1.5, 'sdfdf', '2nd', 1, 'lorenz@gmail.com', '9107787149', 8),
('2020-0004', NULL, 'Eussejyl', 'Bucio', 'Bucio', '1999-12-25', 1.5, NULL, '2nd', 1, 'eussejyl@gmail.com', '9107787149', 5),
('2020-0005', NULL, 'Jenny', 'Cua', 'Cua', '1999-12-25', 1.5, NULL, '2nd', 1, 'jenny@gmail.com', '9107787149', 6),
('2020-0006', NULL, 'Alvin', 'Pingot', 'Pingot', '1999-12-25', 1.5, NULL, '2nd', 1, 'alvin@gmail.com', '9107787149', 5),
('2020-0007', NULL, 'Japeth', 'Francisquete', 'Francisquete', '1999-12-25', 1.5, NULL, '2nd', 1, 'japeth@gmail.com', '9107787149', 6),
('2020-0008', NULL, 'Neff', 'Plaza', 'Plaza', '1999-12-25', 1.5, NULL, '2nd', 1, 'neff@gmail.com', '9107787149', 2),
('2020-0010', NULL, 'Iann', 'Balgos', 'Balgos', '1999-12-25', 1.5, NULL, '2nd', 1, 'iann@gmail.com', '9107787149', 6),
('2020-0011', NULL, 'Anfernee', 'Zaspa', 'Zaspa', '1999-12-25', 1.5, NULL, '2nd', 1, 'anfernee@gmail.com', '9107787149', 2),
('2020-0012', NULL, 'Riz Vincent', 'Ambayec', 'Ambayec', '1999-12-25', 1.5, NULL, '2nd', 1, 'vincent@gmail.com', '9107787149', 3),
('2020-0014', NULL, 'Rosendo', 'Mangarin', 'Mangarin', '1999-12-25', 1.5, NULL, '2nd', 0, 'rosendo@gmail.com', '9107787149', 6),
('2020-0015', NULL, 'Russel', 'Manlupig', 'Manlupig', '1999-12-25', 1.5, NULL, '2nd', 1, 'russel@gmail.com', '9107787149', 2);

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `student_id` varchar(10) NOT NULL,
  `candidate_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `fk_candidate_position_idx` (`position_id`),
  ADD KEY `fk_candidate_student1_idx` (`student_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_course_institute1_idx` (`institute_id`);

--
-- Indexes for table `institute`
--
ALTER TABLE `institute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `open_elect`
--
ALTER TABLE `open_elect`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student_course1_idx` (`course_id`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD KEY `fk_vote_student1_idx` (`student_id`),
  ADD KEY `fk_vote_candidate1_idx` (`candidate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `institute`
--
ALTER TABLE `institute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `open_elect`
--
ALTER TABLE `open_elect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidate`
--
ALTER TABLE `candidate`
  ADD CONSTRAINT `fk_candidate_position` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_candidate_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `fk_course_institute1` FOREIGN KEY (`institute_id`) REFERENCES `institute` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_course1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `fk_vote_candidate1` FOREIGN KEY (`candidate_id`) REFERENCES `candidate` (`student_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vote_student1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
