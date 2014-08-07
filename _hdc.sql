-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2014 at 11:25 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

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
(24, 'a', 'a@com', '00000000000000000', 'a'),
(25, '', '', '', 'Array'),
(26, 'Rojan Shrestha', 'rojan.neo@gmail.com', 'this is a test nature', 'This is a test maessage'),
(27, 'Rojan Shrestha', 'rojan.neo@gmail.com', 'tes', 'test');

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
(5, 'guarantee', 'Guarantee', '<div class="account-menu">\n<ul>\n<li><a href="http://192.168.1.107/himalayan/account/pricing">Pricing</a></li>\n<li><a href="http://192.168.1.107/himalayan/account/forms">Forms</a></li>\n<li><a href="#">Distributors</a></li>\n<li><a href="http://192.168.1.107/himalayan/pages/view/guarantee">Guarantee</a></li>\n<li><a href="http://192.168.1.107/himalayan/pages/view/shipping">Shipping</a></li>\n</ul>\n</div>\nGuarantee Page'),
(6, 'shipping', 'Shipping', '<div class="account-menu">\n<ul>\n<li><a href="http://192.168.1.107/himalayan/account/pricing">Pricing</a></li>\n<li><a href="http://192.168.1.107/himalayan/account/forms">Forms</a></li>\n<li><a href="#">Distributors</a></li>\n<li><a href="http://192.168.1.107/himalayan/pages/view/guarantee">Guarantee</a></li>\n<li><a href="http://192.168.1.107/himalayan/pages/view/shipping">Shipping</a></li>\n</ul>\n</div>\nShipping Page');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pext` varchar(5) NOT NULL DEFAULT '',
  `mid` int(11) NOT NULL DEFAULT '0',
  `pdes` text NOT NULL,
  `pdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pconfirm` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='uploaded photos' AUTO_INCREMENT=13 ;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`pid`, `pext`, `mid`, `pdes`, `pdate`, `pconfirm`) VALUES
(2, 'jpg', 1, 'kancha experimenting at the Bellingham Expo', '2007-10-11 22:53:14', '1'),
(3, 'jpg', 1, 'Suman with pets', '2007-10-11 22:53:28', '1'),
(6, 'JPG', 102, 'Reilly with his "security blanket"', '2007-10-24 19:37:20', '1'),
(7, '', 445, 'Milo loves his chew', '2008-08-18 12:58:23', '0'),
(8, '', 145, 'Elvis enjoying his treat!', '2008-08-20 16:18:11', '0'),
(9, '', 145, 'Elvis enjoying his treat!', '2008-08-20 16:19:31', '0'),
(10, '', 488, 'Halo working on the medium  himalayan dog chew', '2008-09-17 23:07:39', '0'),
(11, 'JPG', 536, 'Elvis loves his Chew', '2008-10-23 21:48:07', '0'),
(12, 'JPG', 536, 'Elvis with his Chew', '2008-10-23 21:49:18', '0');

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
-- Table structure for table `user_session`
--

CREATE TABLE IF NOT EXISTS `user_session` (
  `session_id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(100) NOT NULL,
  `token_id` varchar(100) NOT NULL,
  `session_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `user_session`
--

INSERT INTO `user_session` (`session_id`, `user_id`, `token_id`, `session_time`) VALUES
(17, 3942, 'rojan_neo@hotmail.com', '2014-08-06 14:31:26'),
(18, 3942, 'rojan_neo@hotmail.com', '2014-08-07 14:28:14');
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
