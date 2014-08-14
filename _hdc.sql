-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2014 at 03:04 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `_hdc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_session`
--

CREATE TABLE IF NOT EXISTS `admin_session` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token_id` text NOT NULL,
  `admin_type` int(11) NOT NULL,
  `session_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`session_id`),
  KEY `admin_type` (`admin_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `eid` int(11) unsigned NOT NULL DEFAULT '0',
  `etid` text NOT NULL,
  `edept` int(11) NOT NULL DEFAULT '1',
  `essn` varchar(10) NOT NULL DEFAULT '',
  `edob` date NOT NULL DEFAULT '0000-00-00',
  `ehire` date NOT NULL DEFAULT '0000-00-00',
  `eauth` text NOT NULL,
  `eterm` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `eed` text NOT NULL,
  `edes` text NOT NULL,
  PRIMARY KEY (`eid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='company employees';

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`eid`, `etid`, `edept`, `essn`, `edob`, `ehire`, `eauth`, `eterm`, `eed`, `edes`) VALUES
(101, '4', 2, '', '0000-00-00', '0000-00-00', 'all       ', '0000-00-00 00:00:00', '', ''),
(133, '5,6,7,1', 6, '', '0000-00-00', '0000-00-00', '   prd opr sls  own', '0000-00-00 00:00:00', '', ''),
(134, '9,5,7,1', 3, '', '0000-00-00', '0000-00-00', '  fin prd  sls  own', '0000-00-00 00:00:00', '', ''),
(140, '5,7,1', 5, '', '0000-00-00', '0000-00-00', '   prd  sls  own', '0000-00-00 00:00:00', '', ''),
(145, '7,10', 4, '', '0000-00-00', '0000-00-00', '     sls mkt ', '0000-00-00 00:00:00', '', ''),
(658, '7,10', 11, '', '0000-00-00', '0000-00-00', '     sls mkt ', '0000-00-00 00:00:00', '', ''),
(3942, '4', 2, '', '0000-00-00', '0000-00-00', 'all', '0000-00-00 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_session`
--

CREATE TABLE IF NOT EXISTS `user_session` (
  `session_id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `token_id` varchar(100) NOT NULL,
  `session_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `user_session`
--

INSERT INTO `user_session` (`session_id`, `user_id`, `token_id`, `session_time`) VALUES
(10, 3965, 'alina@gmai.com', '2014-08-14 18:46:09');
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
