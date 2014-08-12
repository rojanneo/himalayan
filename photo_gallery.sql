-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2014 at 06:35 AM
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
-- Table structure for table `photo_gallery`
--

CREATE TABLE IF NOT EXISTS `photo_gallery` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_image` longtext NOT NULL,
  `photo_image_resized` text NOT NULL,
  `photo_caption` text NOT NULL,
  `photo_status` int(11) NOT NULL,
  PRIMARY KEY (`photo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `photo_gallery`
--

INSERT INTO `photo_gallery` (`photo_id`, `photo_image`, `photo_image_resized`, `photo_caption`, `photo_status`) VALUES
(1, 'uploads/photogallery/elle.jpg', 'uploads/photogallery/cropped/elle.jpg', 'Elle', 1),
(2, 'uploads/photogallery/hardyorama1.jpg', 'uploads/photogallery/cropped/hardyorama1.jpg', 'Hardy Orama', 1),
(3, 'uploads/photogallery/nepalfarmers.jpg', 'uploads/photogallery/cropped/nepalfarmers.jpg', 'Nepal Farmers', 1),
(4, 'uploads/photogallery/vito.jpg', 'uploads/photogallery/cropped/vito.jpg', 'Vito', 1);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
