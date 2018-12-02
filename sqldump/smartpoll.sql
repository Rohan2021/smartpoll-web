-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2018 at 10:31 AM
-- Server version: 5.7.24-0ubuntu0.18.04.1
-- PHP Version: 7.0.32-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartpoll`
--

-- --------------------------------------------------------

--
-- Table structure for table `optionstable`
--

CREATE TABLE `optionstable` (
  `oID` int(255) NOT NULL,
  `options` varchar(1000) NOT NULL,
  `pID` int(255) NOT NULL,
  `link` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `optionstable`
--

INSERT INTO `optionstable` (`oID`, `options`, `pID`, `link`) VALUES
(1, 'Excellent', 1, ''),
(2, 'Very Good', 1, ''),
(3, 'Good', 1, ''),
(4, 'Bad', 1, ''),
(5, 'Very Bad', 1, ''),
(10, 'A', 10, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/T20RT0GgOB4\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(11, 'B', 10, '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/HJkHek3LK6Q\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(12, 'A', 18, '1543379134.png'),
(13, 'B', 18, '1543379134.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `presentation`
--

CREATE TABLE `presentation` (
  `pID` int(255) NOT NULL,
  `question` varchar(1000) NOT NULL,
  `uID` int(255) NOT NULL,
  `day` int(3) NOT NULL,
  `month` int(3) NOT NULL,
  `year` int(5) NOT NULL,
  `status` int(2) NOT NULL,
  `p_name` varchar(1000) NOT NULL,
  `p_code` varchar(50) NOT NULL,
  `option_type` int(11) NOT NULL COMMENT '0-text,1-video,2-image'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `presentation`
--

INSERT INTO `presentation` (`pID`, `question`, `uID`, `day`, `month`, `year`, `status`, `p_name`, `p_code`, `option_type`) VALUES
(1, 'This is test presentation. Rate this app', 3, 24, 11, 18, 1, 'Test', '921200', 0),
(10, 'which one video is fake please select from option', 3, 28, 11, 18, 1, 'Video Votting', '298259', 1),
(18, 'Select Company Logo', 3, 28, 11, 18, 1, 'Company Logo', '202668', 2);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `rID` int(255) NOT NULL,
  `oID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uID` int(255) UNSIGNED NOT NULL,
  `email` varchar(500) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `account_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uID`, `email`, `fullname`, `password`, `account_type`) VALUES
(3, 'alokupadhya0@gmail.com', 'Alok Upadhya', 'c0b8ef49edc451ccac554fe91eb3354b', 'SP');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `optionstable`
--
ALTER TABLE `optionstable`
  ADD PRIMARY KEY (`oID`);

--
-- Indexes for table `presentation`
--
ALTER TABLE `presentation`
  ADD PRIMARY KEY (`pID`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`rID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `optionstable`
--
ALTER TABLE `optionstable`
  MODIFY `oID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `presentation`
--
ALTER TABLE `presentation`
  MODIFY `pID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `rID` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uID` int(255) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
