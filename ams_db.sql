-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2018 at 02:57 PM
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

--
-- Dumping data for table `ams_chat`
--

INSERT INTO `ams_chat` (`id`, `sender`, `message`, `receiver`) VALUES
(1, 'admin', 'Hello imran', 'imran'),
(2, 'admin', 'hey peter', 'peter'),
(3, 'imran', 'Hey admin', 'admin'),
(4, 'imran', 'I want loan', 'admin'),
(5, 'peter', 'hahaha', 'admin'),
(6, 'admin', 'hihihi', 'peter'),
(7, 'admin', 'okay', 'imran');

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
  `loanGiven` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loan_apply`
--

INSERT INTO `loan_apply` (`id`, `username`, `name`, `nid`, `phone`, `address`, `amount`, `loanGiven`) VALUES
(1, 'imran', 'imran hadid', '123456789009876543', '3456789', 'dhaka, bangladesh', 55555, 5555),
(2, 'peter', 'peter', '98765432345678998', '87654567', 'usa', 9999, 9999);

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `money` int(11) DEFAULT NULL,
  `loan` int(11) DEFAULT NULL,
  `RequestWithdraw` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id`, `username`, `money`, `loan`, `RequestWithdraw`) VALUES
(1, 'imran', 11337, 5555, 10000),
(2, 'peter', 1007, 9999, 500);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `userEmail` varchar(50) NOT NULL,
  `userUsername` varchar(30) NOT NULL,
  `userPassword` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `userName`, `userEmail`, `userUsername`, `userPassword`) VALUES
(1, 'imran hadid', 'imran@mail.com', 'imran', '$2y$10$Y8qRQn4RN6FVWH497k.LeOmsPX6Xm4pq76tVjXTrpf7vrBRB585mu'),
(2, 'peter jhonson', 'peter@mail.com', 'peter', '$2y$10$y8c3QJEBVVNjW7ic..mID.s51.lcl1rC8gfMvp49qsM3ra3xHFcwO');

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
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `withdraw_status`
--

INSERT INTO `withdraw_status` (`id`, `username`, `beforeWithdraw`, `withdrawMoney`, `afterWithdraw`, `time`, `date`) VALUES
(1, 'peter', '1337', '330', '1007', '18:42:32', '2018-03-28'),
(2, 'imran', '31337', '20000', '11337', '18:45:42', '2018-03-28');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `loan_apply`
--
ALTER TABLE `loan_apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `withdraw_status`
--
ALTER TABLE `withdraw_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
