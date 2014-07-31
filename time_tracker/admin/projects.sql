-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 01, 2001 at 01:40 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `projects`
--

-- --------------------------------------------------------

--
-- Table structure for table `mm_project`
--

CREATE TABLE IF NOT EXISTS `mm_project` (
  `projects_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_title` varchar(200) NOT NULL,
  `project_desc` text NOT NULL,
  `project_by` varchar(200) NOT NULL,
  `project_uid` int(200) NOT NULL,
  PRIMARY KEY (`projects_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mm_project`
--

INSERT INTO `mm_project` (`projects_id`, `project_title`, `project_desc`, `project_by`, `project_uid`) VALUES
(1, 'Renu Store', '', 'Ajay ', 1),
(2, 'ThinkPoP', '', 'Sourav', 2),
(3, 'The Ring', '', 'Ajay ', 1),
(4, 'Sreev short', 'rsjdggs\r\nds\r\nsdd', 'ram', 4);

-- --------------------------------------------------------

--
-- Table structure for table `mm_project_work`
--

CREATE TABLE IF NOT EXISTS `mm_project_work` (
  `project_work_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `stop_time` datetime NOT NULL,
  `note` text,
  `work_type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`project_work_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `mm_project_work`
--

INSERT INTO `mm_project_work` (`project_work_id`, `project_id`, `user_id`, `start_time`, `stop_time`, `note`, `work_type`) VALUES
(1, 3, 1, '2014-01-21 03:19:48', '2014-01-21 03:20:36', ' iiihih ihihih', 0),
(2, 3, 1, '2014-01-21 03:20:36', '0000-00-00 00:00:00', ' jata ', 1),
(3, 1, 1, '2014-01-21 03:21:25', '2014-01-21 03:21:32', ' ', 0),
(4, 1, 1, '2014-01-21 03:21:32', '2014-01-21 03:21:59', '', 1),
(5, 1, 1, '2014-01-21 03:21:59', '2014-01-21 03:22:21', ' sdfsdf', 0),
(6, 1, 1, '2014-01-21 03:22:21', '2014-01-21 03:22:33', '', 1),
(7, 1, 1, '2014-01-21 03:22:33', '0000-00-00 00:00:00', ' ', 0),
(8, 3, 1, '2014-01-21 03:24:46', '2014-01-21 03:25:00', ' ', 0),
(9, 3, 1, '2014-01-21 03:25:00', '2014-01-21 03:25:09', '', 1),
(10, 3, 1, '2014-01-21 03:25:09', '2014-01-21 03:25:16', ' ', 0),
(11, 3, 1, '2014-01-21 03:25:16', '2014-01-21 03:25:28', '', 1),
(12, 3, 1, '2014-01-21 03:25:28', '2014-01-21 03:25:30', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mm_user`
--

CREATE TABLE IF NOT EXISTS `mm_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_vname` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mm_user`
--

INSERT INTO `mm_user` (`user_id`, `user_name`, `user_password`, `user_vname`, `user_email`) VALUES
(1, 'mekail', 'max123', 'Mekail Biswas', 'maxbiswas@gmail.com'),
(2, 'raj', 'raj123', 'Rahesh Halder', 'rajesh@gmail.com'),
(3, 'admin', 'admin', 'Mekail', 'max@mamj.com'),
(4, 'RAJ', 'rajesh9832', 'Rajesh Haldar', 'myrajeshhaldar@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tm_project_work_snap`
--

CREATE TABLE IF NOT EXISTS `tm_project_work_snap` (
  `project_work_snap_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_work_id` int(11) NOT NULL,
  `project_work_snap_time` datetime NOT NULL,
  PRIMARY KEY (`project_work_snap_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `tm_project_work_snap`
--

INSERT INTO `tm_project_work_snap` (`project_work_snap_id`, `project_work_id`, `project_work_snap_time`) VALUES
(1, 1, '2014-01-21 02:45:10'),
(2, 1, '2014-01-21 02:45:22'),
(3, 1, '2014-01-21 02:45:33'),
(4, 1, '2014-01-21 02:45:44'),
(5, 1, '2014-01-21 02:45:55'),
(6, 1, '2014-01-21 02:46:06'),
(7, 1, '2014-01-21 02:46:17'),
(8, 4, '2014-01-21 02:49:26'),
(9, 5, '2014-01-21 02:56:06'),
(10, 5, '2014-01-21 02:56:17'),
(11, 5, '2014-01-21 02:56:49'),
(12, 6, '2014-01-21 02:59:35'),
(13, 6, '2014-01-21 02:59:52'),
(14, 6, '2014-01-21 03:00:03'),
(15, 6, '2014-01-21 03:00:14'),
(16, 6, '2014-01-21 03:00:25'),
(17, 8, '2014-01-21 03:00:53'),
(18, 9, '2014-01-21 03:08:18'),
(19, 9, '2014-01-21 03:08:29'),
(20, 10, '2014-01-21 03:09:13'),
(21, 10, '2014-01-21 03:09:24'),
(22, 10, '2014-01-21 03:10:57'),
(23, 10, '2014-01-21 03:11:08'),
(24, 10, '2014-01-21 03:11:19'),
(25, 10, '2014-01-21 03:12:05'),
(26, 11, '2014-01-21 03:14:53'),
(27, 11, '2014-01-21 03:15:04'),
(28, 11, '2014-01-21 03:15:16'),
(29, 13, '2014-01-21 03:16:29'),
(30, 13, '2014-01-21 03:16:40'),
(31, 14, '2014-01-21 03:19:01'),
(32, 14, '2014-01-21 03:19:13'),
(33, 15, '2014-01-21 03:19:44'),
(34, 1, '2014-01-21 03:19:58'),
(35, 1, '2014-01-21 03:20:09'),
(36, 1, '2014-01-21 03:20:20'),
(37, 1, '2014-01-21 03:20:31'),
(38, 5, '2014-01-21 03:22:05'),
(39, 5, '2014-01-21 03:22:16'),
(40, 8, '2014-01-21 03:24:57');
