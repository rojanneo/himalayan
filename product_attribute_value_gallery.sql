-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2014 at 12:43 PM
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
-- Table structure for table `product_attribute_value_gallery`
--

CREATE TABLE IF NOT EXISTS `product_attribute_value_gallery` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `pavg_pid` int(11) NOT NULL,
  `value` text NOT NULL,
  `is_base_image` int(11) NOT NULL,
  `is_thumbnail_image` int(11) NOT NULL,
  PRIMARY KEY (`gid`),
  KEY `pavg_pid` (`pavg_pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
