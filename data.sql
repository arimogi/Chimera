-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 21, 2011 at 02:49 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.5

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `codeIgniter`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE IF NOT EXISTS `auth_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `auth_menus`
--

CREATE TABLE IF NOT EXISTS `auth_menus` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) NOT NULL DEFAULT '0',
  `code` varchar(50) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `type` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0 : all, 1: not authenticated, 2 : authenticated, 3 : authorized',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `auth_menus`
--

INSERT INTO `auth_menus` (`id`, `parent_id`, `code`, `name`, `description`, `type`) VALUES
(1, 0, 'main/forgot_password', 'Forgot Password', NULL, 1),
(2, 0, 'main/change_password', 'Change Password', NULL, 2),
(3, 0, 'main/manage_user', 'User Management', NULL, 3),
(4, 0, 'main/create_user', 'Create User', NULL, 3),
(5, 0, 'main/home', 'Home', NULL, 0),
(6, 5, 'lab', 'Lab', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `auth_menus_groups`
--

CREATE TABLE IF NOT EXISTS `auth_menus_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) NOT NULL,
  `menu_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `auth_menus_groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `auth_users`
--

CREATE TABLE IF NOT EXISTS `auth_users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) unsigned NOT NULL,
  `ip_address` int(10) unsigned NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `auth_users`
--

INSERT INTO `auth_users` (`id`, `group_id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, 0, 2130706433, 'administrator', 'de93d5f4a8bdba5b47424b0ba4d8522f7f0a6fd9', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, 1268889823, 1316588862, 1, 'Admin', 'istrator', 'ADMIN', '0');

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_groups`
--

CREATE TABLE IF NOT EXISTS `auth_users_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) NOT NULL,
  `group_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `auth_users_groups`
--

INSERT INTO `auth_users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('46fa2875ef9057d10db38fd7f241d265', '127.0.0.1', 'Opera/9.80 (X11; Linux i686; U; en) Presto/2.8.131 Version/11.10', 1316587747, ''),
('83ac02a5b9bd983d655dd2c864ee4730', '0.0.0.0', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.1 (KHTML, like Gecko) Ubuntu/10.10 Chromium/13.0.782.218 Chrome/13.0.782.2', 1316591239, ''),
('f6b27039588064156f8c1e51d38077fc', '0.0.0.0', 'Mozilla/5.0 (X11; Linux i686; rv:6.0.2) Gecko/20100101 Firefox/6.0.2', 1316590793, 'a:3:{s:8:"username";s:13:"administrator";s:5:"email";s:15:"admin@admin.com";s:7:"user_id";s:1:"1";}');

-- --------------------------------------------------------

--
-- Table structure for table `conf_config`
--

CREATE TABLE IF NOT EXISTS `conf_config` (
  `key` varchar(20) NOT NULL DEFAULT '',
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `conf_config`
--

INSERT INTO `conf_config` (`key`, `value`) VALUES
('site_title', 'Welcome to Chimera!'),
('site_slogan', 'A very special framework for your very special CMS'),
('site_copyright', 'Chimera CMS and default template &copy; goFrendiAsgard, goFrendiAsgard@gmail.com'),
('site_theme', 'default'),
('site_default_view', 'main/welcome_message');

-- --------------------------------------------------------

--
-- Table structure for table `mod_module`
--

CREATE TABLE IF NOT EXISTS `mod_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mod_module`
--

INSERT INTO `mod_module` (`id`, `menu`, `module`) VALUES
(1, 'welcome', 'welcome/index'),
(2, 'blog', 'blog/posts');

-- --------------------------------------------------------

--
-- Table structure for table `mod_privilege`
--

CREATE TABLE IF NOT EXISTS `mod_privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mod_privilege`
--

SET FOREIGN_KEY_CHECKS=1;

