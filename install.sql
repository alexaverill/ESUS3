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

--
-- Database: `esus`
--

-- --------------------------------------------------------

--
-- Table structure for table `beds`
--

CREATE TABLE IF NOT EXISTS `beds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` varchar(11) NOT NULL,
  `first` varchar(100) NOT NULL,
  `last` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `arrive` int(11) NOT NULL,
  `depart` int(11) NOT NULL,
  `linens` varchar(10) NOT NULL,
  `occ` varchar(10) NOT NULL,
  `disability` varchar(10) NOT NULL,
  `role` varchar(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `paid` int(11) NOT NULL,
  `type` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=532 ;

--
-- Dumping data for table `beds`
--

INSERT INTO `beds` (`id`, `team_id`, `first`, `last`, `gender`, `arrive`, `depart`, `linens`, `occ`, `disability`, `role`, `date`, `paid`, `type`) VALUES
(519, '?', '?', '?', '?', 1, 1, '?', '?', '?', '?', '2014-04-23 15:33:38', 0, 0),
(520, '?', '?', '?', '?', 0, 0, '?', '?', '?', '?', '2014-04-23 15:35:00', 0, 0),
(521, '?', '?', '?', '?', 0, 0, '?', '?', '?', '?', '2014-04-23 15:35:24', 0, 0),
(522, '31', '', '', '', 0, 0, '', '', 'no', '', '2014-04-25 14:59:34', 0, 0),
(523, '31', '', '', '', 0, 0, '', '', '', '', '2014-04-25 01:16:05', 0, 0),
(524, '31', 'adfda', 'fadfdsa', 'm', 14, 14, '0', '1', 'yes', 'competitor', '2014-04-25 14:59:45', 0, 0),
(525, '31', 'LAeadadfdas', '', 'm', 15, 15, '0', '2', 'yes', 'competitor', '2014-04-25 14:59:50', 0, 0),
(526, '31', 'LAeadadfdas', '', 'm', 15, 15, '0', '2', 'no', 'competitor', '2014-04-25 01:28:11', 0, 0),
(527, '31', 'fafdafd', 'fdsfdsafdsa', 'm', 14, 14, '0', '2', 'no', 'competitor', '2014-04-25 01:29:03', 0, 0),
(528, '31', 'fadsfdsa', 'fdasfdsaf', 'm', 14, 14, '0', '2', 'no', 'competitor', '2014-04-25 01:38:25', 0, 0),
(529, '31', 'adfafdsa', 'fdsafdsafdsa', 'm', 14, 14, '0', '2', 'no', 'competitor', '2014-04-25 14:56:35', 0, 0),
(530, '40', 'Test', 'test', 'm', 14, 14, '0', '2', 'no', 'competitor', '2014-05-06 18:11:54', 0, 0),
(531, '40', 'test', 'tsaet', 'm', 14, 14, '0', '2', 'no', 'competitor', '2014-05-06 18:11:54', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zipcode` int(5) NOT NULL,
  `grade` int(10) NOT NULL,
  `student_email` varchar(100) NOT NULL,
  `special` varchar(10) NOT NULL,
  `comments` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `enable`
--

CREATE TABLE IF NOT EXISTS `enable` (
  `enabled` int(5) NOT NULL DEFAULT '3'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `enable`
--

INSERT INTO `enable` (`enabled`) VALUES
(3);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `event` varchar(200) NOT NULL,
  `slots` int(10) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `event`, `slots`) VALUES
(28, 'testing', 10);

-- --------------------------------------------------------

--
-- Table structure for table `export`
--

CREATE TABLE IF NOT EXISTS `export` (
  `time_id` varchar(20) NOT NULL,
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
  `team10` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(20) NOT NULL DEFAULT '550',
  `rank` int(2) NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(2400) NOT NULL,
  `perm` int(5) NOT NULL DEFAULT '0',
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `rank`, `name`, `password`, `email`, `perm`) VALUES
(550, 1, 'admin', '$2y$10$zmlZ2wknu7kYZD/p2VXhZ.JV3/jR4aq8Q44pbLPiNRmGDXQLJAoKK', 'admin', 0),
(550, 0, 'admin2', '$2y$10$.ZZCbbWOHo3d2ndqhNh/..D5LU.v3zobs/VCqZqHjKI.90r8YeToa', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `school_data`
--

CREATE TABLE IF NOT EXISTS `school_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(10) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zipcode` int(5) NOT NULL,
  `total_pay` int(10) NOT NULL,
  `total_to_pay` int(20) NOT NULL,
  `paid` int(10) NOT NULL,
  `type` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `tables` int(15) NOT NULL,
  `install` int(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`tables`, `install`) VALUES
(10, 3933);

-- --------------------------------------------------------

--
-- Table structure for table `signatures`
--

CREATE TABLE IF NOT EXISTS `signatures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_number` int(11) NOT NULL,
  `coach_name` varchar(15) NOT NULL,
  `coach_number` int(11) NOT NULL,
  `coach_email` varchar(50) NOT NULL,
  `prince_name` varchar(15) NOT NULL,
  `prince_sig` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `slots`
--

CREATE TABLE IF NOT EXISTS `slots` (
  `time_slot` varchar(20) NOT NULL,
  KEY `time_slot` (`time_slot`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE IF NOT EXISTS `team` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `name`, `email`, `username`, `password`) VALUES
(41, 'Solon High', 'alex.averill2013@gmail.com', 'solon', '$2y$10$Evq64KrTfV45Bj.qfFcZyepOUe0KbBM8GCabMceeTt2aIIZ90984W');

-- --------------------------------------------------------

--
-- Table structure for table `timer`
--

CREATE TABLE IF NOT EXISTS `timer` (
  `start_day` int(20) NOT NULL,
  `end_day` int(20) NOT NULL,
  `start_year` int(20) NOT NULL,
  `start_month` int(20) NOT NULL,
  `end_year` int(20) NOT NULL,
  `end_month` int(20) NOT NULL,
  `end_hour` int(10) NOT NULL,
  `start_hour` int(10) NOT NULL,
  `end_min` int(10) NOT NULL,
  `start_min` int(10) NOT NULL,
  `start` varchar(10) NOT NULL,
  `end` varchar(10) NOT NULL,
  `st_time` varchar(10) NOT NULL,
  `en_time` varchar(10) NOT NULL,
  `id` int(1) NOT NULL DEFAULT '1',
  KEY `start_day` (`start_day`),
  KEY `start_day_2` (`start_day`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `timer`
--

INSERT INTO `timer` (`start_day`, `end_day`, `start_year`, `start_month`, `end_year`, `end_month`, `end_hour`, `start_hour`, `end_min`, `start_min`, `start`, `end`, `st_time`, `en_time`, `id`) VALUES
(1, 29, 2010, 1, 2012, 10, 18, 9, 20, 10, '2014-07-01', '2014-07-31', '1:00', '1:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `times`
--

CREATE TABLE IF NOT EXISTS `times` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`),
  KEY `event` (`event`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

INSERT INTO `settings` (`tables`) VALUES ('10');

INSERT INTO `timer` (`start_day`, `end_day`, `start_year`, `start_month`, `end_year`, `end_month`, `end_hour`, `start_hour`, `end_min`, `start_min`, `start`, `end`, `st_time`, `en_time`, `id`) VALUES
(1, 29, 2010, 1, 2012, 10, 18, 9, 20, 10, '2014-07-01', '2014-07-31', '1:00', '1:00', 1);

INSERT INTO `enable` (`enabled`) VALUES ('1');
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
