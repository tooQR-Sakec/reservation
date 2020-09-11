-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2020 at 02:02 AM
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
  `tableID` int(11) NOT NULL,
  `slot` int(11) NOT NULL,
  `guestName` varchar(50) NOT NULL,
  `guestEmail` varchar(50) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `numberOfPeople` int(11) NOT NULL,
  `roomID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`tableID`, `slot`, `guestName`, `guestEmail`, `date`, `numberOfPeople`, `roomID`) VALUES
(3, 4, 'Adam', 'manjunath.naik@sakec.ac.in', '2020-09-10', 8, '104'),
(5, 9, 'Manjunath', 'manumanjunath2000@gmail.com', '2020-09-10', 4, '101'),
(5, 14, 'Manjunath', 'manjunath2000@hotmail.com', '2020-09-10', 8, '102'),
(5, 15, 'manjunayh', 'fde@fd.com', '2020-09-10', 3, ''),
(5, 16, 'Prem', 'premkatre@gmail.com', '2020-09-10', 5, ''),
(5, 17, 'Prem', 'premkatre@gmail.com', '2020-09-10', 4, ''),
(5, 18, 'manjunayh', 'fde@fd.com', '2020-09-10', 2, ''),
(5, 19, 'manjunayh', 'fde@fd.com', '2020-09-10', 3, ''),
(5, 20, 'Manjunath', 'manjunath2000@hotmail.com', '2020-09-10', 7, '501'),
(5, 22, 'Manjunath', 'manjunath2000@hotmail.com', '2020-09-10', 4, ''),
(6, 14, 'Manjunath', 'manjunath2000@hotmail.com', '2020-09-10', 4, ''),
(6, 15, 'manjunayh', 'fde@fd.com', '2020-09-10', 3, ''),
(6, 16, 'Prem', 'premkatre@gmail.com', '2020-09-10', 3, ''),
(6, 17, 'Prem', 'premkatre@gmail.com', '2020-09-10', 4, ''),
(6, 18, 'manjunayh', 'fde@fd.com', '2020-09-10', 5, ''),
(6, 20, 'Manjunath', 'manjunath2000@hotmail.com', '2020-09-10', 8, '105'),
(6, 22, 'Manjunath', 'manjunath2000@hotmail.com', '2020-09-10', 7, '');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `tableID` int(1) NOT NULL,
  `capacity` int(11) NOT NULL,
  `reserved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`tableID`, `capacity`, `reserved`) VALUES
(1, 2, 0),
(2, 2, 0),
(3, 2, 0),
(4, 6, 0),
(5, 2, 0),
(6, 2, 0),
(7, 2, 0),
(8, 4, 0),
(9, 2, 0),
(10, 2, 0),
(11, 2, 0),
(12, 2, 1),
(13, 4, 0),
(14, 2, 0),
(15, 2, 0),
(16, 2, 0),
(17, 2, 0),
(18, 2, 0),
(19, 4, 0),
(20, 2, 0),
(21, 2, 0),
(22, 2, 0),
(23, 2, 0),
(24, 2, 0),
(25, 2, 0),
(26, 2, 0),
(27, 4, 1),
(28, 4, 0),
(29, 4, 0),
(30, 4, 0),
(31, 4, 0),
(32, 4, 0),
(33, 4, 1),
(34, 4, 0),
(35, 2, 0),
(36, 4, 0),
(37, 4, 0),
(38, 4, 0),
(39, 4, 0),
(40, 4, 0),
(41, 2, 0),
(42, 4, 0),
(43, 4, 1),
(44, 4, 0),
(45, 4, 0),
(46, 4, 0),
(47, 4, 0),
(48, 2, 0),
(49, 4, 0),
(50, 4, 0),
(51, 7, 0),
(52, 8, 0),
(53, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `slot` int(11) NOT NULL,
  `time` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`slot`, `time`) VALUES
(1, '12:00 am to 1:00 am'),
(2, '1:00 am to 2:00 am'),
(3, '2:00 am to 3:00 am'),
(4, '3:00 am to 4:00 am'),
(5, '4:00 am to 5:00 am'),
(6, '5:00 am to 6:00 am'),
(7, '6:00 am to 7:00 am'),
(8, '7:00 am to 8:00 am'),
(9, '8:00 am to 9:00 am'),
(10, '9:00 am to 10:00 am'),
(11, '10:00 am to 11:00 am'),
(12, '11:00 am to 12:00 pm'),
(13, '12:00 pm to 1:00 pm'),
(14, '1:00 pm to 2:00 pm'),
(15, '2:00 pm to 3:00 pm'),
(16, '3:00 pm to 4:00 pm'),
(17, '4:00 pm to 5:00 pm'),
(18, '5:00 pm to 6:00 pm'),
(19, '6:00 pm to 7:00 pm'),
(20, '7:00 pm to 8:00 pm'),
(21, '8:00 pm to 9:00 pm'),
(22, '9:00 pm to 10:00 pm'),
(23, '10:00 pm to 11:00 pm'),
(24, '11:00 pm to 12:00 am');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`tableID`,`slot`,`date`),
  ADD KEY `tableID` (`tableID`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`tableID`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`slot`);

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
