-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 20, 2020 at 10:07 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_voting`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `candidates_table`
--

DROP TABLE IF EXISTS `candidates_table`;
CREATE TABLE IF NOT EXISTS `candidates_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position_id` int(11) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `image` text NOT NULL,
  `symbol` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `candidates_table`
--

INSERT INTO `candidates_table` (`id`, `position_id`, `first_name`, `last_name`, `image`, `symbol`) VALUES
(1, 1, 'Preeti...', 'Patel', 'CandidatesImage/1.jpg', 'CandidatesSymbol/1.jpg'),
(2, 1, 'Sristi', 'Patel', 'CandidatesImage/2.jpg', 'CandidatesSymbol/2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `election_table`
--

DROP TABLE IF EXISTS `election_table`;
CREATE TABLE IF NOT EXISTS `election_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `election_name` varchar(200) NOT NULL,
  `election_type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `election_table`
--

INSERT INTO `election_table` (`id`, `election_name`, `election_type`) VALUES
(1, 'qqqqqqq', 'Public'),
(3, 'aaaa2323', 'Private');

-- --------------------------------------------------------

--
-- Table structure for table `position_table`
--

DROP TABLE IF EXISTS `position_table`;
CREATE TABLE IF NOT EXISTS `position_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `election_id` int(11) NOT NULL,
  `position_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position_table`
--

INSERT INTO `position_table` (`id`, `election_id`, `position_name`) VALUES
(1, 1, 'Manager..'),
(3, 1, 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

DROP TABLE IF EXISTS `user_table`;
CREATE TABLE IF NOT EXISTS `user_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_id` text NOT NULL,
  `password` text NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`id`, `email_id`, `password`, `firstname`, `lastname`) VALUES
(1, 'admin@gmail.com', '0cc175b9c0f1b6a831c399e269772661', 'admin', 'admin'),
(2, 'p@gmail.com', '0cc175b9c0f1b6a831c399e269772661', 'preeti', 'hirani');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
