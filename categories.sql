-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2014 at 04:16 PM
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
-- Database: `_dog`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_slug` varchar(200) DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` longtext NOT NULL,
  `category_image` text,
  `parent_id` int(11) NOT NULL,
  `is_root` int(1) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `cat_slug` (`cat_slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `cat_slug`, `category_name`, `category_description`, `category_image`, `parent_id`, `is_root`) VALUES
(1, 'dog-chews', 'Himalayan Dog Chews', '<p>Himalayan Dog Chews were born from an ancient recipe for a hard cheese snack chewed by the people of the Himalayas. In the mountains surrounding Mt. Everest at more than 15,000 feet, it is made&nbsp;using traditional methods with yak and/or cow milk,and all natural products with no preservatives&nbsp;or binding agents. They&rsquo;re also gluten-free!</p>\r\n<p>Depending on the size and eating habits of the dog, this can be a very long-lasting dog chew. Dogs must work the end of the treat for hours, softening it with their mouths before small parts of it can be slowly chewed off. When you give this treat to your dog,&nbsp;you know that you are providing them with high-quality eating entertainment.</p>', 'category/croppedImg_18582.png', 9, 0),
(2, 'seasoning', 'Seasoning', '<p>Our Seasoning is made from the grainy powder&nbsp;of Himalayan Dog Chews which you can sprinkle <br />onto any dog or cat food for pets who just cannot seem to get enough of it. Add a little taste of the Himalayas to all of their food!<br /><br /></p>', '', 11, 0),
(3, 'yaky-nugget', 'Yaky Nugget', '<p>Yaky Nuggets are little bite sized Himalayan Dog Chews that must be popped/puffed in a microwave and given to dogs to enjoy the cheesy flavor. These can also be boiled for ten to fifteen minutes in water to make them soft and easy to chop into smaller bits that can be served with regular dog food. They are also cut to size for uniformity and are carefully tested for quality before being packaged.<br /><br /></p>', '', 11, 0),
(4, 'yaky-puff', 'Yaky Puff', '<p>From the beginning, we have tried numerous ways to utilize leftover Himalayan Dog Chews. After extensive research and hundreds of attempts later, we discovered that when Yaky Nuggets are microwaved, they puff up to about five times their original size. The result is a dog treat that is not too soft and not too hard, while maintaining the same cheesy flavor dogs love!&nbsp;</p>', '', 11, 0),
(5, 'yaky-crunch', 'Yaky Crunch', '<p>Yaky Crunch is made up of bite-sized Yaky Puffs which are made from the same ingredients as Himalayan Dog Chews (yak and/or cow milk,and all natural products). The result is a dog treat that is not too soft and not too hard, while maintaining the same cheesy flavor dogs love! <br /><br /></p>', '', 11, 0),
(6, 'yaky-yams', 'Yaky Yams', '<p>Yaky Yam is a baked gluten-free treat made of the same ingredients as Himalayan Dog Chews (100% yak and cow milk, salt, and lime juice) mixed with sweet potato and other healthy nourishing ingredients. Now with more rewarding flavor and nutrition! <br /><br /></p>\r\n<h2>&nbsp;</h2>', 'category/croppedImg_7103.png', 11, 0),
(7, 'yaky-sticks', 'Yaky Stick', '<p>Yaky Stick is the combination of two of dogs&rsquo; favorite treats; Himalayan Dog Chews wrapped around a Bully Stick, which is made using patented processes without using any binding agents or glue in the USA. Bully Sticks come from all free-range grass fed cattle and provide dogs with essential proteins while Himalayan Dog Chews provide them with essential minerals. Moreover, this combination allows the Bully Stick to have little or no saliva from the dogs, hence emitting very low or no odor. While some dogs go for the cheese of Himalayan Dog Chews and some go for the Bully Sticks, we guarantee that any dog will go for Yaky Sticks, enjoying them fairly longer than a regular Bully Stick.</p>\r\n<h2>&nbsp;</h2>', 'category/croppedImg_6452.png', 11, 0),
(8, 'yaky-charms', 'Yaky Charms', 'Yaky Charms', NULL, 11, 0),
(9, 'our-creations', 'Our Creations', '<p>Root Category</p>', 'category/croppedImg_15825.png', 0, 1),
(11, 'hdc_treats', 'Treats', '', NULL, 9, 0),
(12, 'hdc_toys', 'Toys', '', NULL, 9, 0);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
