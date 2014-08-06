-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2014 at 11:39 AM
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
-- Table structure for table `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `form_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_name` varchar(255) NOT NULL,
  `form_description` text NOT NULL,
  `form_file` text NOT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`form_id`, `form_name`, `form_description`, `form_file`) VALUES
(1, 'Map', 'Map', 'forms/map.pdf'),
(2, 'Order Form ', 'Order Form', 'forms/order_form.pdf'),
(3, 'Order form 2012', 'ORder form 2012', 'forms/order_form_12/pdf'),
(4, 'Brochure', 'Brochure', 'forms/brochure.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `urlKey` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `urlKey` (`urlKey`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `urlKey`, `title`, `content`) VALUES
(1, 'about-us', 'About Us', '<div class="wrapper">\r\n                <div class="leftBody"><img src="http://192.168.1.107/himalayan/assets/images/about-image.png" alt=""></div>\r\n                <div class="rightBody">\r\n                    <h1>Our History</h1>\r\n                    <p>Co-founder Nishes Shrestha and Suman Shrestha discovered this healthy dog snack when they met for dinner in 2003. Suman spotted Nishes'' dog chewing in Himalayan hard cheese. Out of curiosity, the founder tried the cheese on their friends'' and families'' dogs. the positive responce encouraged them todo extensive research on cheese for canines, which they engaged in for four years. On September 2, 2007, Himalayan''s first producing Himalayan Dog Chew - was sold at dog show fain in Bellingham, Washington. After producing Himalayan Dog Chews in Nishes'' kitchen for three months, the operation moved to seattle under Sujan Shrestha''s leadersip in January 2008. We now distribute our products to over 5,000 retailers.</p>\r\n                    <h1>our farmers</h1>\r\n                    <p>We have created a consortium of rouchly 3,000 farmers in the Himalayas, mostly in Nepal. These farmers are trained, given five to six months'' lead time, and are paid promptly to produce Himalan Dog Chews. Each farmer milks about two to five cows and yaks everyday using traditional methods, without any modern devices. The cattle graze in natural pastures, where present, and are fed all natural leaves from the forest. farmers collect roughly six gallons of milk to make two pounds of Himalayan Dog Chews. On average, each farmer collect about 20 gallons of milk.</p>\r\n                    <a href="http://192.168.1.107/himalayan/pages/view/about-team" class="btn btn-blue">meet our team</a>\r\n                </div>\r\n            </div>'),
(3, 'about-team', 'About Our Team', '<div class="wrapper">\r\n                <div class="aboutteam">\r\n                    <img src="http://192.168.1.107/himalayan/assets/images/about-team.png" alt="">\r\n                    <ul>\r\n                        <li class="teamHeader">Himalayan Dog Chew Team 2014</li>\r\n                        <li>top row: Samantha, Amar, Mohamed, Henry, Henry, Joseph, Mohamed, Chris, Brice, Rita, Rocio, Vania, Laura, Julissa, jeremy, nathan</li>\r\n                        <li>middle row: Brandon, Lane, Renato, Cyrus, Ahmed, Jeff, Mahalis, Zena, Josephine, Andrew, Eyerusalem, Nancy, Grizelda, Fedra, Manisha</li>\r\n                        <li>bottom row: Jil, Luten, Suman, Bella, Nishes, Astha, Cherelle, Norge, Eddie, Akram, Mango, Derek, Kristi, Milisa</li>\r\n                    </ul>\r\n                    <a href="http://192.168.1.107/himalayan/pages/view/about-us" class="btn btn-blue">back</a>\r\n                    <div class="clearfix"></div>\r\n                </div>\r\n                <div class="clearfix"></div>\r\n            </div>'),
(4, 'our-mission', 'Our Mission', '<div class="wrapper">\r\n                <div class="half">\r\n                    <h1>Our Mission</h1>\r\n                    <p>Himalayan Corporation aspires to become the most prominient company in the pet industry while maintainin and building on our reputation for innovative, healthy, and high quality products. to ensure we uphold these standards in each new enterp[rise, we are driven by a set of core values:</p>\r\n                    <ul>\r\n                        <li>Provide exceptional customer service</li>\r\n                        <li>Treat employees with the utmost respect</li>\r\n                        <li>Produce and sell products of the highest quality</li>\r\n                        <li>Maximize savings, satisfaction and value for our customers</li>\r\n                        <li>Fuel growth through customer referrals, Innovation and reputation</li>\r\n                        <li>Actively impact the community through our presence and charitable contributions</li>\r\n                    </ul>\r\n                    <p>Himalayan Corporation embodies a collection of divers pet products with the highest aspirations.</p>\r\n                    <p><span class="heading">Our Vision</span> is to be recognized and respected for producin the healthiest and highest quality pet food and products in teh world.</p>\r\n                </div>\r\n            </div>\r\n            <div class="wrapper"><img src="http://192.168.1.107/himalayan/assets/images/homepage-banner.png" alt=""></div>'),
(5, 'guarantee', 'Guarantee', '<div class="account-menu">\n<ul>\n<li><a href="#">Pricing</a></li>\n<li><a href="http://192.168.1.107/himalayan/account/forms">Forms</a></li>\n<li><a href="#">Distributors</a></li>\n<li><a href="#">Guarantee</a></li>\n<li><a href="#">Shipping</a></li>\n</ul>\n</div>\nGuarantee Page'),
(6, 'shipping', 'Shipping', '<div class="account-menu">\n<ul>\n<li><a href="#">Pricing</a></li>\n<li><a href="http://192.168.1.107/himalayan/account/forms">Forms</a></li>\n<li><a href="#">Distributors</a></li>\n<li><a href="#">Guarantee</a></li>\n<li><a href="#">Shipping</a></li>\n</ul>\n</div>\nShipping Page');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `user_session`
--

INSERT INTO `user_session` (`session_id`, `user_id`, `token_id`, `session_time`) VALUES
(17, 3942, 'rojan_neo@hotmail.com', '2014-08-06 14:31:26');
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
