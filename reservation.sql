-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2020 at 01:55 PM
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
('1', 1, '', 'manjunath.naik@sakec.ac.in', '2020-09-10', 4, ''),
('1', 5, '', '', '2020-09-10', 5, ''),
('1', 22, '', '', '2020-09-10', 3, ''),
('2', 5, '', '', '2020-09-10', 2, ''),
('2', 7, '', '', '2020-09-10', 6, ''),
('2', 23, '', '', '2020-09-10', 5, ''),
('3', 4, '', '', '2020-09-10', 8, '104'),
('3', 8, '', '', '2020-09-10', 4, ''),
('3', 23, '', '', '2020-09-10', 2, ''),
('4', 4, '', '', '2020-09-10', 4, ''),
('4', 9, '', '', '2020-09-10', 4, ''),
('4', 19, '', '', '2020-09-10', 4, ''),
('5', 5, '', '', '2020-09-10', 4, ''),
('5', 8, '', '', '2020-09-10', 7, ''),
('5', 9, 'Manjunath', 'manumanjunath2000@gmail.com', '2020-09-10', 4, '101'),
('5', 14, 'Manjunath', 'manjunath2000@hotmail.com', '2020-09-10', 8, '102'),
('5', 15, 'manjunayh', 'fde@fd.com', '2020-09-10', 3, ''),
('5', 16, '', 'premkatre@gmail.com', '2020-09-10', 5, ''),
('5', 17, '', 'premkatre@gmail.com', '2020-09-10', 4, ''),
('5', 18, 'manjunayh', 'fde@fd.com', '2020-09-10', 2, ''),
('5', 19, 'manjunayh', 'fde@fd.com', '2020-09-10', 3, ''),
('5', 20, 'Manjunath', 'manjunath2000@hotmail.com', '2020-09-10', 7, '501'),
('5', 22, '', 'manjunath2000@hotmail.com', '2020-09-10', 4, ''),
('5', 23, '', '', '2020-09-10', 5, ''),
('6', 4, '', '', '2020-09-10', 5, ''),
('6', 9, '', '', '2020-09-10', 7, ''),
('6', 14, 'Manjunath', 'manjunath2000@hotmail.com', '2020-09-10', 4, ''),
('6', 15, 'manjunayh', 'fde@fd.com', '2020-09-10', 3, ''),
('6', 16, '', 'premkatre@gmail.com', '2020-09-10', 3, ''),
('6', 17, '', 'premkatre@gmail.com', '2020-09-10', 4, ''),
('6', 18, 'manjunayh', 'fde@fd.com', '2020-09-10', 5, ''),
('6', 19, '', '', '2020-09-10', 1, ''),
('6', 20, 'Manjunath', 'manjunath2000@hotmail.com', '2020-09-10', 8, '105'),
('6', 22, '', 'manjunath2000@hotmail.com', '2020-09-10', 7, '');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `tableID` varchar(10) NOT NULL,
  `capacity` int(11) NOT NULL,
  `reserved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`tableID`, `capacity`, `reserved`) VALUES
('1', 2, 0),
('12', 5, 0),
('2', 2, 0),
('3', 2, 0),
('4', 6, 1),
('5', 4, 0),
('6', 4, 0);

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
