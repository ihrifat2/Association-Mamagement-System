-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2018 at 02:30 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ams_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `id` int(11) NOT NULL,
  `adminName` varchar(50) NOT NULL,
  `adminEmail` varchar(50) NOT NULL,
  `adminUsername` varchar(30) NOT NULL,
  `adminPassword` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`id`, `adminName`, `adminEmail`, `adminUsername`, `adminPassword`) VALUES
(1, 'admin', 'admin@mail.com', 'admin', '$2y$10$kL.jNZTKrLUQqa.TmMk9CuTtKUbkUlK8ir7czZu2FR9bRQd3zuqrO');

-- --------------------------------------------------------

--
-- Table structure for table `ams_chat`
--

CREATE TABLE `ams_chat` (
  `id` int(11) NOT NULL,
  `sender` varchar(30) NOT NULL,
  `message` mediumtext NOT NULL,
  `receiver` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ams_deposit`
--

CREATE TABLE `ams_deposit` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `depositMoney` int(11) NOT NULL,
  `totalMoney` int(11) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ams_loan`
--

CREATE TABLE `ams_loan` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `loan_Amount` int(11) NOT NULL,
  `weeklyInstallment` int(11) NOT NULL,
  `paid_Amount` int(11) NOT NULL,
  `present_Amount` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `week` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loan_apply`
--

CREATE TABLE `loan_apply` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `nid` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(30) NOT NULL,
  `amount` int(10) NOT NULL,
  `loanGiven` int(11) NOT NULL,
  `loanLimit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `money` int(11) NOT NULL,
  `loan` int(11) NOT NULL,
  `loanInterest` int(11) NOT NULL,
  `loanTotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id`, `username`, `money`, `loan`, `loanInterest`, `loanTotal`) VALUES
(1, 'imran', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `userEmail` varchar(50) NOT NULL,
  `userPhone` varchar(20) NOT NULL,
  `userPhoto` varchar(60) NOT NULL,
  `userNid` varchar(60) NOT NULL,
  `userReference` text NOT NULL,
  `userUsername` varchar(30) NOT NULL,
  `userPassword` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `userName`, `userEmail`, `userPhone`, `userPhoto`, `userNid`, `userReference`, `userUsername`, `userPassword`) VALUES
(1, 'imran hadid', 'imran@hadid.com', '23456789', 'c5459f6cd31085b017f5fa0d3809c3a7.jpg', 'eaaa789b6eb3a3b995cb003e65249341.jpg', 'kupa', 'imran', '$2y$10$zSgyTNEZPphfrdttxiU22eiNVG8ur9AOXmtTQB360tOHS8THiqHr6');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_status`
--

CREATE TABLE `withdraw_status` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `beforeWithdraw` varchar(10) NOT NULL,
  `withdrawMoney` varchar(10) NOT NULL,
  `afterWithdraw` varchar(10) NOT NULL,
  `time` varchar(8) NOT NULL,
  `date` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_info`
--
ALTER TABLE `admin_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ams_chat`
--
ALTER TABLE `ams_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ams_deposit`
--
ALTER TABLE `ams_deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ams_loan`
--
ALTER TABLE `ams_loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_apply`
--
ALTER TABLE `loan_apply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_status`
--
ALTER TABLE `withdraw_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_info`
--
ALTER TABLE `admin_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ams_chat`
--
ALTER TABLE `ams_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ams_deposit`
--
ALTER TABLE `ams_deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ams_loan`
--
ALTER TABLE `ams_loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `loan_apply`
--
ALTER TABLE `loan_apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `withdraw_status`
--
ALTER TABLE `withdraw_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
