-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2014 at 05:50 PM
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
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `pid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pnm` varchar(30) NOT NULL DEFAULT '',
  `upc` varchar(30) NOT NULL DEFAULT '',
  `pcode` varchar(30) NOT NULL DEFAULT '',
  `pwt` varchar(10) DEFAULT NULL,
  `ppr` float NOT NULL DEFAULT '0',
  `pdes` text NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `pcode` (`pcode`),
  KEY `upc` (`upc`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='products' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `pnm`, `upc`, `pcode`, `pwt`, `ppr`, `pdes`) VALUES
(1, 'Large Dog', '68946602895', 'HDC 103', '3.5 OZ', 4.75, 'Himalayan Dog Chew. Large Dog. 1 piece of 3.5 Oz per package'),
(2, 'Medium Dog', '68946602894', 'HDC 102', '2.5 Oz', 3.75, 'Himalayan Dog Chew. Medium Dog. 1 piece of 2.5 Oz per package'),
(3, 'Small Dog', '68946602893', 'HDC 101', '3.5 Oz', 4.75, 'Himalayan Dog Chew. Small Dog. 3-5 pieces of 3.5 Oz per package.');
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
