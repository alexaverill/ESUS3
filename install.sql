-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 31, 2014 at 01:00 AM
-- Server version: 5.5.35-0ubuntu0.13.10.2
-- PHP Version: 5.5.3-1ubuntu2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Table structure for table `event`
-- Holds custom number of slots for each event...

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `installID` int(5) NOT NULL,
  `event` varchar(200) NOT NULL,
  `slots` int(10) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Table structure for table `export`
--

CREATE TABLE IF NOT EXISTS `export` (
  `time_id` varchar(20) NOT NULL,
  `installID` int(5) NOT NULL,
  `event` varchar(20) NOT NULL,
  `team1` varchar(100) NOT NULL,
  `team2` varchar(100) NOT NULL,
  `team3` varchar(100) NOT NULL,
  `team4` varchar(100) NOT NULL,
  `team5` varchar(100) NOT NULL,
  `team6` varchar(100) NOT NULL,
  `team7` varchar(100) NOT NULL,
  `team8` varchar(100) NOT NULL,
  `team9` varchar(100) NOT NULL,
  `team10` varchar(100) NOT NULL,
  `team11` int(20) NOT NULL,
  `team12` int(20) NOT NULL,
   `team13` int(20) NOT NULL,
  `team14` int(20) NOT NULL,
  `team15` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `installID` int(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '0',
  `permissions` int(5) NOT NULL DEFAULT '0',
  UNIQUE KEY `id_2` (`id`),
  KEY `name` (`name`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

--
-- Dumping data for table `members`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `installID` int(50) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `slotNum` int(5) NOT NULL,
  `competitionName` varchar(255) NOT NULL,
  `enabled` int(5) NOT NULL DEFAULT '3',
  `start` varchar(10) NOT NULL DEFAULT '10',
  `end` varchar(10) NOT NULL DEFAULT '10',
  `st_time` varchar(10) NOT NULL DEFAULT '10',
  `en_time` varchar(10) NOT NULL DEFAULT '10'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--



-- --------------------------------------------------------

--
-- Table structure for table `slots`
--

CREATE TABLE IF NOT EXISTS `slots` (
  `time_slot` varchar(20) NOT NULL,
  `installID` int(5) NOT NULL,
  KEY `time_slot` (`time_slot`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `installID` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;


-- --------------------------------------------------------

--
-- Table structure for table `times`
--

CREATE TABLE IF NOT EXISTS `times` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `installID` int(5) NOT NULL,
  `time_id` varchar(100) NOT NULL,
  `event` varchar(40) NOT NULL,
  `team1` int(20) NOT NULL,
  `team2` int(20) NOT NULL,
  `team3` int(20) NOT NULL,
  `team4` int(20) NOT NULL,
  `team5` int(20) NOT NULL,
  `team6` int(20) NOT NULL,
  `team7` int(20) NOT NULL,
  `team8` int(20) NOT NULL,
  `team9` int(20) NOT NULL,
  `team10` int(20) NOT NULL,
  `team11` int(20) NOT NULL,
  `team12` int(20) NOT NULL,
   `team13` int(20) NOT NULL,
  `team14` int(20) NOT NULL,
  `team15` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `event` (`event`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
