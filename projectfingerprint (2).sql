-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 06:08 AM
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
-- Database: `projectfingerprint`
--

-- --------------------------------------------------------

--
-- Table structure for table `dashboardinfo`
--

CREATE TABLE `dashboardinfo` (
  `ESP32SerialNumber` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `alert-attempt` varchar(250) NOT NULL,
  `alert-lastattempt` datetime NOT NULL,
  `doorlock-status` varchar(250) NOT NULL,
  `doorlock-lastunlocked` datetime NOT NULL,
  `doorlock-lastperson` varchar(250) NOT NULL,
  `device-status` varchar(250) NOT NULL,
  `device-ssid` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dashboardinfo`
--

INSERT INTO `dashboardinfo` (`ESP32SerialNumber`, `email`, `alert-attempt`, `alert-lastattempt`, `doorlock-status`, `doorlock-lastunlocked`, `doorlock-lastperson`, `device-status`, `device-ssid`) VALUES
('SN-DA101A0F', 'yrrielbuensuceso@gmail.com', 'LOCKED DUE TO MULTIPLE ATTEMPTS', '2024-12-19 11:21:21', 'LOCKED', '2024-12-19 11:21:29', 'Mr Duck', 'online', 'Yui2');

-- --------------------------------------------------------

--
-- Table structure for table `fingerprint_status`
--

CREATE TABLE `fingerprint_status` (
  `status` varchar(250) NOT NULL,
  `id` varchar(10) NOT NULL,
  `message` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fingerprint_status`
--

INSERT INTO `fingerprint_status` (`status`, `id`, `message`, `email`) VALUES
('waiting', '1', 'No message received', '');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `optionesp32` varchar(250) NOT NULL,
  `id` int(11) NOT NULL,
  `fingerprint_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`optionesp32`, `id`, `fingerprint_id`) VALUES
('3', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tablelistauditlogs`
--

CREATE TABLE `tablelistauditlogs` (
  `indexFingerprint` varchar(50) NOT NULL,
  `name` varchar(250) NOT NULL,
  `ESP32SerialNumber` varchar(250) NOT NULL,
  `DATE` datetime NOT NULL,
  `TYPE` varchar(250) NOT NULL,
  `DESCRIPTION` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablelistauditlogs`
--

INSERT INTO `tablelistauditlogs` (`indexFingerprint`, `name`, `ESP32SerialNumber`, `DATE`, `TYPE`, `DESCRIPTION`) VALUES
('2', 'LeftThumb', 'SN-DA101A0F', '2024-12-18 21:37:18', 'Access', 'Unlocks facility'),
('2', 'LeftThumb', 'SN-DA101A0F', '2024-12-18 21:37:48', 'Access', 'Unlocks facility'),
('2', 'LeftThumb', 'SN-DA101A0F', '2024-12-18 21:37:51', 'Access', 'Unlocks facility'),
('2', 'LeftThumb', 'SN-DA101A0F', '2024-12-18 21:37:52', 'Access', 'Unlocks facility'),
('2', 'LeftThumb', 'SN-DA101A0F', '2024-12-18 21:37:52', 'Access', 'Unlocks facility'),
('2', 'LeftThumb', 'SN-DA101A0F', '2024-12-18 21:37:53', 'Access', 'Unlocks facility'),
('1', 'Mr Duck', 'SN-DA101A0F', '2024-12-18 22:14:35', 'Access', 'Unlocks facility'),
('', '', 'SN-DA101A0F', '2024-12-19 08:31:05', 'SUSPICIOUS', 'Attempted to Open'),
('1', 'Mr Duck', 'SN-DA101A0F', '2024-12-19 08:32:00', 'Access', 'Unlocks facility'),
('1', 'Mr Duck', 'SN-DA101A0F', '2024-12-19 08:36:14', 'Access', 'Unlocks facility'),
('', 'Intruder', 'SN-DA101A0F', '2024-12-19 08:37:13', 'SUSPICIOUS', 'Attempted to Open'),
('', 'Intruder', 'SN-DA101A0F', '2024-12-19 10:37:04', 'SUSPICIOUS', 'Attempted to Open'),
('', 'Intruder', 'SN-DA101A0F', '2024-12-19 10:37:12', 'MALICIOUS', 'Attempted to Open'),
('1', 'Mr Duck', 'SN-DA101A0F', '2024-12-19 10:37:21', 'Access', 'Unlocks facility'),
('', 'Intruder', 'SN-DA101A0F', '2024-12-19 10:37:32', 'SUSPICIOUS', 'Attempted to Open'),
('', 'Intruder', 'SN-DA101A0F', '2024-12-19 11:20:30', 'SUSPICIOUS', 'Attempted to Open'),
('', 'Intruder', 'SN-DA101A0F', '2024-12-19 11:20:38', 'SUSPICIOUS', 'Attempted to Open'),
('', 'Intruder', 'SN-DA101A0F', '2024-12-19 11:20:51', 'LOCKED DUE TO MULTIPLE ATTEMPTS', 'Attempted to Open'),
('', 'Intruder', 'SN-DA101A0F', '2024-12-19 11:21:01', 'LOCKED DUE TO MULTIPLE ATTEMPTS', 'Attempted to Open'),
('', 'Intruder', 'SN-DA101A0F', '2024-12-19 11:21:21', 'LOCKED DUE TO MULTIPLE ATTEMPTS', 'Attempted to Open'),
('1', 'Mr Duck', 'SN-DA101A0F', '2024-12-19 11:21:32', 'Access', 'Unlocks facility');

-- --------------------------------------------------------

--
-- Table structure for table `tablelistfingerprintenrolled`
--

CREATE TABLE `tablelistfingerprintenrolled` (
  `email` varchar(50) NOT NULL,
  `ESP32SerialNumber` varchar(50) NOT NULL,
  `indexFingerprint` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablelistfingerprintenrolled`
--

INSERT INTO `tablelistfingerprintenrolled` (`email`, `ESP32SerialNumber`, `indexFingerprint`, `name`) VALUES
('duck@duck.com', 'SN-DA101A0F', '1', 'Mr Duck'),
('duck@duck.com', 'SN-DA101A0F', '2', 'LeftThumb');

-- --------------------------------------------------------

--
-- Table structure for table `tablelistowner`
--

CREATE TABLE `tablelistowner` (
  `UID` varchar(50) NOT NULL,
  `ESP32SerialNumber` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `loginattempts` int(3) NOT NULL DEFAULT 0,
  `suspendedtimeleft` datetime NOT NULL,
  `suspended_count` int(3) NOT NULL DEFAULT 0,
  `locked_account` varchar(5) NOT NULL DEFAULT 'FALSE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablelistowner`
--

INSERT INTO `tablelistowner` (`UID`, `ESP32SerialNumber`, `email`, `password`, `firstName`, `lastName`, `loginattempts`, `suspendedtimeleft`, `suspended_count`, `locked_account`) VALUES
('SN-8E863486', '', 'xejoto1983@bawsny.com', '123123', '', '', 0, '0000-00-00 00:00:00', 0, 'FALSE'),
('SN-A287973F', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, 'FALSE'),
('not set', 'SN-DA101A0F', 'yrrielbuensuceso@gmail.com', '123123', 'Right', 'Hand', 0, '0000-00-00 00:00:00', 0, 'FALSE'),
('SN-430BFE22', '', 'fisaw81091@evusd.com', 'fisaw81091@evusd.com', '', '', 0, '0000-00-00 00:00:00', 0, 'FALSE'),
('SN-3D7CE39C', '', 'lixixe4638@owube.com', 'lixixe4638@owube.com', '', '', 0, '0000-00-00 00:00:00', 0, 'FALSE');

-- --------------------------------------------------------

--
-- Table structure for table `verifications`
--

CREATE TABLE `verifications` (
  `email` varchar(250) NOT NULL,
  `token` varchar(250) NOT NULL,
  `transferemail` varchar(250) NOT NULL,
  `transfertoken` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verifications`
--

INSERT INTO `verifications` (`email`, `token`, `transferemail`, `transfertoken`) VALUES
('', '', 'm70455067@gmail.com', '73c5a717c5757e5b242d8713017e43c9');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
