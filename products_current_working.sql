-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2014 at 05:54 PM
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
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE IF NOT EXISTS `attributes` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `acode` varchar(255) NOT NULL,
  `aname` varchar(255) NOT NULL,
  `atype` enum('int','text','select') NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`aid`, `acode`, `aname`, `atype`) VALUES
(1, 'weight', 'weight', 'int'),
(2, 'dog_size', 'Dog Size', 'select'),
(3, 'box_size', 'Box Size', 'text');

-- --------------------------------------------------------

--
-- Table structure for table `attributeset`
--

CREATE TABLE IF NOT EXISTS `attributeset` (
  `asid` int(11) NOT NULL AUTO_INCREMENT,
  `ascode` varchar(255) NOT NULL,
  `asname` varchar(255) NOT NULL,
  PRIMARY KEY (`asid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `attributeset`
--

INSERT INTO `attributeset` (`asid`, `ascode`, `asname`) VALUES
(1, 'chew', 'Chew'),
(2, 'yam', 'Yam');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_values`
--

CREATE TABLE IF NOT EXISTS `attribute_values` (
  `vid` int(11) NOT NULL AUTO_INCREMENT,
  `values_aid` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`vid`),
  KEY `values_aid` (`values_aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `attribute_values`
--

INSERT INTO `attribute_values` (`vid`, `values_aid`, `value`) VALUES
(1, 2, '65lbs'),
(2, 2, '40lbs');

-- --------------------------------------------------------

--
-- Table structure for table `a_as`
--

CREATE TABLE IF NOT EXISTS `a_as` (
  `aasid` int(11) NOT NULL AUTO_INCREMENT,
  `aas_aid` int(11) NOT NULL,
  `aas_asid` int(11) NOT NULL,
  PRIMARY KEY (`aasid`),
  KEY `aas_aid` (`aas_aid`,`aas_asid`),
  KEY `aas_asid` (`aas_asid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pname` varchar(255) NOT NULL,
  `psku` varchar(255) NOT NULL,
  `ptype` int(11) NOT NULL,
  `product_asid` int(11) NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `ptype` (`ptype`,`product_asid`),
  KEY `product_asid` (`product_asid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `pname`, `psku`, `ptype`, `product_asid`) VALUES
(1, 'HDC Red', 'hdc_red', 1, 1),
(2, 'Yaky Yam Fruity Fruit', 'fruity_fruit', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute_values_int`
--

CREATE TABLE IF NOT EXISTS `product_attribute_values_int` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pavi_pid` int(11) NOT NULL,
  `pavi_aid` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pavi_pid` (`pavi_pid`,`pavi_aid`),
  KEY `pavi_aid` (`pavi_aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `product_attribute_values_int`
--

INSERT INTO `product_attribute_values_int` (`id`, `pavi_pid`, `pavi_aid`, `value`) VALUES
(1, 1, 1, 4),
(2, 2, 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute_values_select`
--

CREATE TABLE IF NOT EXISTS `product_attribute_values_select` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pavs_pid` int(11) NOT NULL,
  `pavs_aid` int(11) NOT NULL,
  `pavs_vid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pavs_pid` (`pavs_pid`,`pavs_aid`,`pavs_vid`),
  KEY `pavs_aid` (`pavs_aid`),
  KEY `pavs_vid` (`pavs_vid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `product_attribute_values_select`
--

INSERT INTO `product_attribute_values_select` (`id`, `pavs_pid`, `pavs_aid`, `pavs_vid`) VALUES
(1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute_values_text`
--

CREATE TABLE IF NOT EXISTS `product_attribute_values_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pavt_pid` int(11) NOT NULL,
  `pavt_aid` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pavt_pid` (`pavt_pid`,`pavt_aid`),
  KEY `pavt_aid` (`pavt_aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `product_attribute_values_text`
--

INSERT INTO `product_attribute_values_text` (`id`, `pavt_pid`, `pavt_aid`, `value`) VALUES
(1, 2, 3, '40-43 pieces');

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute_values_varchar`
--

CREATE TABLE IF NOT EXISTS `product_attribute_values_varchar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pavv_pid` int(11) NOT NULL,
  `pavv_aid` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pavt_pid` (`pavv_pid`,`pavv_aid`),
  KEY `pavt_aid` (`pavv_aid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ptype`
--

CREATE TABLE IF NOT EXISTS `ptype` (
  `ptid` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`ptid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ptype`
--

INSERT INTO `ptype` (`ptid`, `type`) VALUES
(1, 'simple'),
(2, 'configurable');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD CONSTRAINT `attribute_values_ibfk_1` FOREIGN KEY (`values_aid`) REFERENCES `attributes` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `a_as`
--
ALTER TABLE `a_as`
  ADD CONSTRAINT `a_as_ibfk_2` FOREIGN KEY (`aas_asid`) REFERENCES `attributeset` (`asid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `a_as_ibfk_1` FOREIGN KEY (`aas_aid`) REFERENCES `attributes` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`product_asid`) REFERENCES `attributeset` (`asid`),
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`ptype`) REFERENCES `ptype` (`ptid`);

--
-- Constraints for table `product_attribute_values_int`
--
ALTER TABLE `product_attribute_values_int`
  ADD CONSTRAINT `product_attribute_values_int_ibfk_2` FOREIGN KEY (`pavi_aid`) REFERENCES `attributes` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_attribute_values_int_ibfk_1` FOREIGN KEY (`pavi_pid`) REFERENCES `products` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_attribute_values_select`
--
ALTER TABLE `product_attribute_values_select`
  ADD CONSTRAINT `product_attribute_values_select_ibfk_3` FOREIGN KEY (`pavs_vid`) REFERENCES `attribute_values` (`vid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_attribute_values_select_ibfk_1` FOREIGN KEY (`pavs_pid`) REFERENCES `products` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_attribute_values_select_ibfk_2` FOREIGN KEY (`pavs_aid`) REFERENCES `attributes` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_attribute_values_text`
--
ALTER TABLE `product_attribute_values_text`
  ADD CONSTRAINT `product_attribute_values_text_ibfk_2` FOREIGN KEY (`pavt_aid`) REFERENCES `attributes` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_attribute_values_text_ibfk_1` FOREIGN KEY (`pavt_pid`) REFERENCES `products` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_attribute_values_varchar`
--
ALTER TABLE `product_attribute_values_varchar`
  ADD CONSTRAINT `product_attribute_values_varchar_ibfk_2` FOREIGN KEY (`pavv_aid`) REFERENCES `attributes` (`aid`),
  ADD CONSTRAINT `product_attribute_values_varchar_ibfk_1` FOREIGN KEY (`pavv_pid`) REFERENCES `products` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
