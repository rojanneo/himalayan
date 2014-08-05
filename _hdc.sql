-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2014 at 11:37 AM
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
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `category_description` longtext NOT NULL,
  `category_image` text NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_description`, `category_image`) VALUES
(1, 'Dog Chews', 'Chews', ''),
(2, 'Seasoning', 'Seasoning Powder', ''),
(3, 'Yaky Nugget', 'Yaky Nugget', ''),
(4, 'Yaky Puff', 'Yaky Puff', ''),
(5, 'Yaky Crunch', 'Yaky Crunch', ''),
(6, 'Yaky Yams', 'Yaky Yams', ''),
(7, 'Yaky Sticks', 'Yaky Sticks', ''),
(8, 'Yaky Charms', 'Yaky Charms', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE IF NOT EXISTS `contact_messages` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_name` varchar(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `message_nature` text NOT NULL,
  `message` longtext NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`contact_id`, `sender_name`, `sender_email`, `message_nature`, `message`) VALUES
(1, 'Rojan', 'Shrestha', 'test', 'test'),
(2, 'Rojan Srhestha', 'rojan.shrestha@test.com', 'test nature ', 'test mesage\r\n'),
(3, 'Rojan', 'Shrestha', 'test', 'test'),
(4, 'a', 'a', 'a', 'a'),
(5, 'a', 'a', 'a', 'a'),
(6, 'a', '', '', ''),
(7, '', '', '', ''),
(8, 'a', 'a@com', 'a', 'a'),
(9, 'Rojan Shrestha', 'rojan.neo@gmail.com', 'Test Nature', 'Test Message'),
(10, '', '', '', ''),
(11, '', '', '', ''),
(12, '', '', '', ''),
(13, '', '', '', ''),
(14, '', '', '', ''),
(15, '', '', '', ''),
(16, 'Rojan Shrestha', 'rojan.neo@gmail.com', ' test', 'dfasdf'),
(17, 'Rojan Shrestha', 'rojan.neo@gmail.com', '    sd', 'asdfasdf'),
(18, '', '', '', ''),
(19, '', '', '', ''),
(20, '', '', '', ''),
(21, '', '', '', ''),
(22, 'a', 'a@com', 'a', 'a'),
(23, 'a', 'a@com', '123', 'a'),
(24, 'a', 'a@com', '00000000000000000', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `faq_id` int(11) NOT NULL AUTO_INCREMENT,
  `faq_keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `faq_question` longtext COLLATE utf8_unicode_ci NOT NULL,
  `faq_answer` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`faq_id`),
  FULLTEXT KEY `faq_question` (`faq_question`,`faq_answer`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`faq_id`, `faq_keywords`, `faq_question`, `faq_answer`) VALUES
(1, 'bad, stop, feeding, dog, fibrous, white, light, green, blue, spots, mold, hazardous, zipper, replacement', 'How do I know if the chew is bad?', 'Although Himalayan Dog Chew rarely goes bad, please stop feeding the dog and call us immediately if you see fibrous white/light or green/blue spots on the chew. This is a sign of mold growth and is hazardous. We would appreciate these chews to be placed in a zipper bag and sent to us for testing. In replacement we can send you a replacement chew right away. know'),
(2, '', 'question 2', 'answer with blue'),
(3, '', 'question 3', 'answer with spots');

-- --------------------------------------------------------

--
-- Table structure for table `photo_gallery`
--

CREATE TABLE IF NOT EXISTS `photo_gallery` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT,
  `photo_image` longtext NOT NULL,
  `photo_caption` text NOT NULL,
  `photo_status` int(11) NOT NULL,
  PRIMARY KEY (`photo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `photo_gallery`
--

INSERT INTO `photo_gallery` (`photo_id`, `photo_image`, `photo_caption`, `photo_status`) VALUES
(1, 'uploads/photogallery/elle.jpg', 'Elle', 1),
(2, 'uploads/photogallery/hardyorama1.jpg', 'Hardy Orama', 1),
(3, 'uploads/photogallery/nepalfarmers.jpg', 'Nepal Farmers', 1),
(4, 'uploads/photogallery/vito.jpg', 'Vito', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `create_date`) VALUES
(1, 'alina', 'alina', '2014-08-04 12:34:40');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=141 ;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
