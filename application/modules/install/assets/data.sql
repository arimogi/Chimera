CREATE TABLE IF NOT EXISTS `auth_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--split--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

--split--

CREATE TABLE IF NOT EXISTS `auth_menus` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) NOT NULL DEFAULT '0',
  `code` varchar(50) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `type` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0 : all, 1: not authenticated, 2 : authenticated, 3 : authorized',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--split--

INSERT INTO `auth_menus` (`id`, `parent_id`, `code`, `name`, `description`, `type`) VALUES
(1, 0, 'main/forgot_password', 'Forgot Password', NULL, 1),
(2, 0, 'main/change_password', 'Change Password', NULL, 2),
(3, 0, 'main/manage_user', 'User Management', NULL, 3),
(4, 0, 'main/create_user', 'Create User', NULL, 3),
(5, 0, 'main/home', 'Home', NULL, 0),
(6, 5, 'lab', 'Lab', NULL, 3);

--split--

CREATE TABLE IF NOT EXISTS `auth_menus_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) NOT NULL,
  `menu_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--split--

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

--split--

INSERT INTO `auth_users` (`id`, `group_id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, 0, 2130706433, 'administrator', 'de93d5f4a8bdba5b47424b0ba4d8522f7f0a6fd9', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, 1268889823, 1316588862, 1, 'Admin', 'istrator', 'ADMIN', '0');

--split--

CREATE TABLE IF NOT EXISTS `auth_users_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) NOT NULL,
  `group_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--split--

INSERT INTO `auth_users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2);

--split--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--split--

CREATE TABLE IF NOT EXISTS `conf_config` (
  `key` varchar(20) NOT NULL DEFAULT '',
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--split--

INSERT INTO `conf_config` (`key`, `value`) VALUES
('site_title', 'Welcome to Chimera!'),
('site_slogan', 'A very special framework for your very special CMS'),
('site_copyright', 'Chimera CMS and default template &copy; goFrendiAsgard, goFrendiAsgard@gmail.com'),
('site_theme', 'default'),
('site_default_view', 'main/welcome_message');

--split--

CREATE TABLE IF NOT EXISTS `mod_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
