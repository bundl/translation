Translation Bundle
==================


Project Configuration

[bundl\translation]
translator = Cubex\I18n\Translator\Reversulator

register_service_as = bundl.translations
factory = \Cubex\Database\DatabaseFactory
engine  = mysql

hostname = localhost.dev
username = root
password =
database = translations


SQL Setup

CREATE TABLE IF NOT EXISTS `approvers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `originals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `lookup` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lookup` (`lookup`(100))
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `original_id` int(11) NOT NULL,
  `language` varchar(6) NOT NULL,
  `translated` mediumtext NOT NULL,
  `approved` tinyint(4) NOT NULL,
  `approved_on` datetime NOT NULL,
  `approver_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `original_id` (`original_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
