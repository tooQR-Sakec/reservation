-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2020 at 09:28 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `tableID` varchar(10) NOT NULL,
  `slot` int(11) NOT NULL,
  `guestEmail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`tableID`, `slot`, `guestEmail`) VALUES
('1', 1, ''),
('1', 5, ''),
('1', 22, ''),
('2', 5, ''),
('2', 7, ''),
('2', 23, ''),
('3', 4, ''),
('3', 8, ''),
('3', 23, ''),
('4', 4, ''),
('4', 9, ''),
('4', 11, 'manjunath2000@hotmail.com'),
('4', 19, ''),
('5', 1, 'manjunath2000@hotmail.com'),
('5', 5, ''),
('5', 8, ''),
('5', 11, 'premkatre@gmail.com'),
('5', 16, 'premkatre@gmail.com'),
('5', 17, 'premkatre@gmail.com'),
('5', 22, 'manjunath2000@hotmail.com'),
('5', 23, ''),
('6', 1, 'manjunath2000@hotmail.com'),
('6', 4, ''),
('6', 9, ''),
('6', 11, 'premkatre@gmail.com'),
('6', 16, 'premkatre@gmail.com'),
('6', 17, 'premkatre@gmail.com'),
('6', 19, ''),
('6', 22, 'manjunath2000@hotmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `tableID` varchar(10) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`tableID`, `capacity`) VALUES
('1', 2),
('2', 2),
('3', 2),
('4', 4),
('5', 4),
('6', 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`tableID`,`slot`),
  ADD KEY `tableID` (`tableID`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`tableID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`tableID`) REFERENCES `tables` (`tableID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
