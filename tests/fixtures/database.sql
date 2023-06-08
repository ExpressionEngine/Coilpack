-- -------------------------------------------------------------
-- TablePlus 4.5.2(402)
--
-- https://tableplus.com/
--
-- Database: cp_fresh
-- Generation Time: 2023-02-20 10:21:34.4650
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `exp_actions`;
CREATE TABLE `exp_actions` (
  `action_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `csrf_exempt` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`action_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_captcha`;
CREATE TABLE `exp_captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(10) unsigned NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `word` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_categories`;
CREATE TABLE `exp_categories` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_id` int(6) unsigned NOT NULL,
  `parent_id` int(4) unsigned NOT NULL,
  `cat_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_url_title` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_description` text COLLATE utf8mb4_unicode_ci,
  `cat_image` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat_order` int(4) unsigned NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `group_id` (`group_id`),
  KEY `parent_id` (`parent_id`),
  KEY `cat_name` (`cat_name`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_category_field_data`;
CREATE TABLE `exp_category_field_data` (
  `cat_id` int(4) unsigned NOT NULL,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_id` int(4) unsigned NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `site_id` (`site_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_category_field_data_field_1`;
CREATE TABLE `exp_category_field_data_field_1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(10) unsigned NOT NULL,
  `field_id_1` text COLLATE utf8mb4_unicode_ci,
  `field_ft_1` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_category_fields`;
CREATE TABLE `exp_category_fields` (
  `field_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_id` int(4) unsigned NOT NULL,
  `field_name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `field_label` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `field_type` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `field_list_items` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_maxl` smallint(3) NOT NULL DEFAULT '128',
  `field_ta_rows` tinyint(2) NOT NULL DEFAULT '8',
  `field_default_fmt` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `field_show_fmt` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `field_text_direction` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ltr',
  `field_required` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `field_order` int(3) unsigned NOT NULL,
  `field_settings` text COLLATE utf8mb4_unicode_ci,
  `legacy_field_data` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`field_id`),
  KEY `site_id` (`site_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_category_groups`;
CREATE TABLE `exp_category_groups` (
  `group_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a',
  `exclude_group` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `field_html_formatting` char(4) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all',
  `can_edit_categories` text COLLATE utf8mb4_unicode_ci,
  `can_delete_categories` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`group_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_category_posts`;
CREATE TABLE `exp_category_posts` (
  `entry_id` int(10) unsigned NOT NULL,
  `cat_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`entry_id`,`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data`;
CREATE TABLE `exp_channel_data` (
  `entry_id` int(10) unsigned NOT NULL,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `channel_id` int(4) unsigned NOT NULL,
  PRIMARY KEY (`entry_id`),
  KEY `channel_id` (`channel_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_1`;
CREATE TABLE `exp_channel_data_field_1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_1` text COLLATE utf8mb4_unicode_ci,
  `field_ft_1` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_10`;
CREATE TABLE `exp_channel_data_field_10` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_10` text COLLATE utf8mb4_unicode_ci,
  `field_ft_10` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_11`;
CREATE TABLE `exp_channel_data_field_11` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_11` text COLLATE utf8mb4_unicode_ci,
  `field_ft_11` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_12`;
CREATE TABLE `exp_channel_data_field_12` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_12` text COLLATE utf8mb4_unicode_ci,
  `field_ft_12` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_13`;
CREATE TABLE `exp_channel_data_field_13` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_13` text COLLATE utf8mb4_unicode_ci,
  `field_ft_13` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_14`;
CREATE TABLE `exp_channel_data_field_14` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_14` int(10) DEFAULT '0',
  `field_dt_14` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field_ft_14` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_15`;
CREATE TABLE `exp_channel_data_field_15` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_15` text COLLATE utf8mb4_unicode_ci,
  `field_ft_15` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_16`;
CREATE TABLE `exp_channel_data_field_16` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_16` text COLLATE utf8mb4_unicode_ci,
  `field_ft_16` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_17`;
CREATE TABLE `exp_channel_data_field_17` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_17` text COLLATE utf8mb4_unicode_ci,
  `field_ft_17` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_18`;
CREATE TABLE `exp_channel_data_field_18` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_18` text COLLATE utf8mb4_unicode_ci,
  `field_ft_18` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_19`;
CREATE TABLE `exp_channel_data_field_19` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_19` mediumtext COLLATE utf8mb4_unicode_ci,
  `field_ft_19` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_2`;
CREATE TABLE `exp_channel_data_field_2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_2` text COLLATE utf8mb4_unicode_ci,
  `field_ft_2` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_20`;
CREATE TABLE `exp_channel_data_field_20` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_20` text COLLATE utf8mb4_unicode_ci,
  `field_ft_20` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_21`;
CREATE TABLE `exp_channel_data_field_21` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_21` text COLLATE utf8mb4_unicode_ci,
  `field_ft_21` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_22`;
CREATE TABLE `exp_channel_data_field_22` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_22` text COLLATE utf8mb4_unicode_ci,
  `field_ft_22` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_23`;
CREATE TABLE `exp_channel_data_field_23` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_23` float DEFAULT '0',
  `field_ft_23` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_24`;
CREATE TABLE `exp_channel_data_field_24` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_24` text COLLATE utf8mb4_unicode_ci,
  `field_ft_24` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_25`;
CREATE TABLE `exp_channel_data_field_25` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_25` text COLLATE utf8mb4_unicode_ci,
  `field_ft_25` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_26`;
CREATE TABLE `exp_channel_data_field_26` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_26` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field_ft_26` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_27`;
CREATE TABLE `exp_channel_data_field_27` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_27` text COLLATE utf8mb4_unicode_ci,
  `field_ft_27` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_28`;
CREATE TABLE `exp_channel_data_field_28` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_28` text COLLATE utf8mb4_unicode_ci,
  `field_ft_28` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_29`;
CREATE TABLE `exp_channel_data_field_29` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_29` text COLLATE utf8mb4_unicode_ci,
  `field_ft_29` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_3`;
CREATE TABLE `exp_channel_data_field_3` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_3` text COLLATE utf8mb4_unicode_ci,
  `field_ft_3` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_30`;
CREATE TABLE `exp_channel_data_field_30` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_30` text COLLATE utf8mb4_unicode_ci,
  `field_ft_30` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_31`;
CREATE TABLE `exp_channel_data_field_31` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_31` text COLLATE utf8mb4_unicode_ci,
  `field_ft_31` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_32`;
CREATE TABLE `exp_channel_data_field_32` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_32` text COLLATE utf8mb4_unicode_ci,
  `field_ft_32` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_33`;
CREATE TABLE `exp_channel_data_field_33` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_33` tinyint(4) NOT NULL DEFAULT '0',
  `field_ft_33` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_34`;
CREATE TABLE `exp_channel_data_field_34` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_34` text COLLATE utf8mb4_unicode_ci,
  `field_ft_34` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_35`;
CREATE TABLE `exp_channel_data_field_35` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_35` float DEFAULT '0',
  `field_ft_35` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_4`;
CREATE TABLE `exp_channel_data_field_4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_4` text COLLATE utf8mb4_unicode_ci,
  `field_ft_4` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_5`;
CREATE TABLE `exp_channel_data_field_5` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_5` text COLLATE utf8mb4_unicode_ci,
  `field_ft_5` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_6`;
CREATE TABLE `exp_channel_data_field_6` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_6` text COLLATE utf8mb4_unicode_ci,
  `field_ft_6` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_7`;
CREATE TABLE `exp_channel_data_field_7` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_7` text COLLATE utf8mb4_unicode_ci,
  `field_ft_7` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_8`;
CREATE TABLE `exp_channel_data_field_8` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_8` text COLLATE utf8mb4_unicode_ci,
  `field_ft_8` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_data_field_9`;
CREATE TABLE `exp_channel_data_field_9` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `field_id_9` text COLLATE utf8mb4_unicode_ci,
  `field_ft_9` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_entries_autosave`;
CREATE TABLE `exp_channel_entries_autosave` (
  `entry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `original_entry_id` int(10) unsigned NOT NULL,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `channel_id` int(4) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL DEFAULT '0',
  `forum_topic_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `versioning_enabled` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `view_count_one` int(10) unsigned NOT NULL DEFAULT '0',
  `view_count_two` int(10) unsigned NOT NULL DEFAULT '0',
  `view_count_three` int(10) unsigned NOT NULL DEFAULT '0',
  `view_count_four` int(10) unsigned NOT NULL DEFAULT '0',
  `allow_comments` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `sticky` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `entry_date` int(10) NOT NULL,
  `year` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `month` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `day` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration_date` int(10) NOT NULL DEFAULT '0',
  `comment_expiration_date` int(10) NOT NULL DEFAULT '0',
  `edit_date` bigint(14) DEFAULT NULL,
  `recent_comment_date` int(10) DEFAULT NULL,
  `comment_total` int(4) unsigned NOT NULL DEFAULT '0',
  `entry_data` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`entry_id`),
  KEY `channel_id` (`channel_id`),
  KEY `author_id` (`author_id`),
  KEY `url_title` (`url_title`(191)),
  KEY `status` (`status`),
  KEY `entry_date` (`entry_date`),
  KEY `expiration_date` (`expiration_date`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_entry_hidden_fields`;
CREATE TABLE `exp_channel_entry_hidden_fields` (
  `entry_id` int(10) unsigned NOT NULL,
  `field_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`entry_id`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_field_groups_fields`;
CREATE TABLE `exp_channel_field_groups_fields` (
  `field_id` int(6) unsigned NOT NULL,
  `group_id` int(4) unsigned NOT NULL,
  PRIMARY KEY (`field_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_fields`;
CREATE TABLE `exp_channel_fields` (
  `field_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned DEFAULT '1',
  `field_name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_label` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_instructions` text COLLATE utf8mb4_unicode_ci,
  `field_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `field_list_items` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_pre_populate` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `field_pre_channel_id` int(6) unsigned DEFAULT NULL,
  `field_pre_field_id` int(6) unsigned DEFAULT NULL,
  `field_ta_rows` tinyint(2) DEFAULT '8',
  `field_maxl` smallint(3) DEFAULT NULL,
  `field_required` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `field_text_direction` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ltr',
  `field_search` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `field_is_hidden` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `field_is_conditional` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `field_fmt` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'xhtml',
  `field_show_fmt` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `field_order` int(3) unsigned NOT NULL,
  `field_content_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'any',
  `field_settings` text COLLATE utf8mb4_unicode_ci,
  `legacy_field_data` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `enable_frontedit` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  PRIMARY KEY (`field_id`),
  KEY `field_type` (`field_type`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_form_settings`;
CREATE TABLE `exp_channel_form_settings` (
  `channel_form_settings_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '0',
  `channel_id` int(6) unsigned NOT NULL DEFAULT '0',
  `default_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `allow_guest_posts` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `default_author` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`channel_form_settings_id`),
  KEY `site_id` (`site_id`),
  KEY `channel_id` (`channel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_grid_field_18`;
CREATE TABLE `exp_channel_grid_field_18` (
  `row_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned DEFAULT NULL,
  `row_order` int(10) unsigned DEFAULT NULL,
  `fluid_field_data_id` int(10) unsigned DEFAULT '0',
  `col_id_15` text COLLATE utf8mb4_unicode_ci,
  `col_id_16` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`row_id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_grid_field_20`;
CREATE TABLE `exp_channel_grid_field_20` (
  `row_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned DEFAULT NULL,
  `row_order` int(10) unsigned DEFAULT NULL,
  `fluid_field_data_id` int(10) unsigned DEFAULT '0',
  `col_id_17` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`row_id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_grid_field_3`;
CREATE TABLE `exp_channel_grid_field_3` (
  `row_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned DEFAULT NULL,
  `row_order` int(10) unsigned DEFAULT NULL,
  `fluid_field_data_id` int(10) unsigned DEFAULT '0',
  `col_id_1` text COLLATE utf8mb4_unicode_ci,
  `col_id_2` text COLLATE utf8mb4_unicode_ci,
  `col_id_3` text COLLATE utf8mb4_unicode_ci,
  `col_id_4` text COLLATE utf8mb4_unicode_ci,
  `col_id_5` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`row_id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_grid_field_4`;
CREATE TABLE `exp_channel_grid_field_4` (
  `row_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned DEFAULT NULL,
  `row_order` int(10) unsigned DEFAULT NULL,
  `fluid_field_data_id` int(10) unsigned DEFAULT '0',
  `col_id_6` text COLLATE utf8mb4_unicode_ci,
  `col_id_7` text COLLATE utf8mb4_unicode_ci,
  `col_id_8` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`row_id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_grid_field_5`;
CREATE TABLE `exp_channel_grid_field_5` (
  `row_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned DEFAULT NULL,
  `row_order` int(10) unsigned DEFAULT NULL,
  `fluid_field_data_id` int(10) unsigned DEFAULT '0',
  `col_id_9` text COLLATE utf8mb4_unicode_ci,
  `col_id_10` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`row_id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_grid_field_7`;
CREATE TABLE `exp_channel_grid_field_7` (
  `row_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned DEFAULT NULL,
  `row_order` int(10) unsigned DEFAULT NULL,
  `fluid_field_data_id` int(10) unsigned DEFAULT '0',
  `col_id_11` text COLLATE utf8mb4_unicode_ci,
  `col_id_12` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`row_id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_grid_field_8`;
CREATE TABLE `exp_channel_grid_field_8` (
  `row_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned DEFAULT NULL,
  `row_order` int(10) unsigned DEFAULT NULL,
  `fluid_field_data_id` int(10) unsigned DEFAULT '0',
  `col_id_13` text COLLATE utf8mb4_unicode_ci,
  `col_id_14` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`row_id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_member_roles`;
CREATE TABLE `exp_channel_member_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `channel_id` int(6) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channel_titles`;
CREATE TABLE `exp_channel_titles` (
  `entry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `channel_id` int(4) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL DEFAULT '0',
  `forum_topic_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` int(4) unsigned NOT NULL,
  `versioning_enabled` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `view_count_one` int(10) unsigned NOT NULL DEFAULT '0',
  `view_count_two` int(10) unsigned NOT NULL DEFAULT '0',
  `view_count_three` int(10) unsigned NOT NULL DEFAULT '0',
  `view_count_four` int(10) unsigned NOT NULL DEFAULT '0',
  `allow_comments` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `sticky` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `entry_date` int(10) NOT NULL,
  `year` char(4) COLLATE utf8mb4_unicode_ci NOT NULL,
  `month` char(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `day` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration_date` int(10) NOT NULL DEFAULT '0',
  `comment_expiration_date` int(10) NOT NULL DEFAULT '0',
  `edit_date` bigint(14) DEFAULT NULL,
  `recent_comment_date` int(10) DEFAULT NULL,
  `comment_total` int(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`entry_id`),
  KEY `channel_id` (`channel_id`),
  KEY `author_id` (`author_id`),
  KEY `url_title` (`url_title`(191)),
  KEY `status` (`status`),
  KEY `entry_date` (`entry_date`),
  KEY `expiration_date` (`expiration_date`),
  KEY `site_id` (`site_id`),
  KEY `sticky_date_id_idx` (`sticky`,`entry_date`,`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channels`;
CREATE TABLE `exp_channels` (
  `channel_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `channel_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `channel_lang` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_entries` mediumint(8) NOT NULL DEFAULT '0',
  `total_records` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `total_comments` mediumint(8) NOT NULL DEFAULT '0',
  `last_entry_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_comment_date` int(10) unsigned NOT NULL DEFAULT '0',
  `cat_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deft_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `search_excerpt` int(4) unsigned DEFAULT NULL,
  `deft_category` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deft_comments` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `channel_require_membership` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `channel_max_chars` int(5) unsigned DEFAULT NULL,
  `channel_html_formatting` char(4) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all',
  `channel_allow_img_urls` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `channel_auto_link_urls` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `channel_notify` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `channel_notify_emails` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sticky_enabled` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `enable_entry_cloning` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `comment_url` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment_system_enabled` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `comment_require_membership` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `comment_moderate` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `comment_max_chars` int(5) unsigned DEFAULT '5000',
  `comment_timelock` int(5) unsigned NOT NULL DEFAULT '0',
  `comment_require_email` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `comment_text_formatting` char(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'xhtml',
  `comment_html_formatting` char(4) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'safe',
  `comment_allow_img_urls` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `comment_auto_link_urls` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `comment_notify` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `comment_notify_authors` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `comment_notify_emails` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment_expiration` int(4) unsigned NOT NULL DEFAULT '0',
  `search_results_url` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rss_url` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enable_versioning` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `max_revisions` smallint(4) unsigned NOT NULL DEFAULT '10',
  `default_entry_title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_field_label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Title',
  `url_title_prefix` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enforce_auto_url_title` char(1) COLLATE utf8mb4_unicode_ci NOT NULL default 'n',
  `preview_url` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allow_preview` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `max_entries` int(10) unsigned NOT NULL DEFAULT '0',
  `conditional_sync_required` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `title_field_instructions` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`channel_id`),
  KEY `cat_group` (`cat_group`(191)),
  KEY `channel_name` (`channel_name`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channels_channel_field_groups`;
CREATE TABLE `exp_channels_channel_field_groups` (
  `channel_id` int(4) unsigned NOT NULL,
  `group_id` int(4) unsigned NOT NULL,
  PRIMARY KEY (`channel_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channels_channel_fields`;
CREATE TABLE `exp_channels_channel_fields` (
  `channel_id` int(4) unsigned NOT NULL,
  `field_id` int(6) unsigned NOT NULL,
  PRIMARY KEY (`channel_id`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_channels_statuses`;
CREATE TABLE `exp_channels_statuses` (
  `channel_id` int(4) unsigned NOT NULL,
  `status_id` int(4) unsigned NOT NULL,
  PRIMARY KEY (`channel_id`,`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_comment_subscriptions`;
CREATE TABLE `exp_comment_subscriptions` (
  `subscription_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned DEFAULT NULL,
  `member_id` int(10) DEFAULT '0',
  `email` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subscription_date` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_sent` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'n',
  `hash` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`subscription_id`),
  KEY `entry_id_member_id` (`entry_id`,`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_comments`;
CREATE TABLE `exp_comments` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) DEFAULT '1',
  `entry_id` int(10) unsigned DEFAULT '0',
  `channel_id` int(4) unsigned DEFAULT '1',
  `author_id` int(10) unsigned DEFAULT '0',
  `status` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(75) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment_date` int(10) DEFAULT NULL,
  `edit_date` int(10) DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`comment_id`),
  KEY `entry_id_channel_id_author_id_status_site_id` (`entry_id`,`channel_id`,`author_id`,`status`,`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_config`;
CREATE TABLE `exp_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(5) unsigned NOT NULL DEFAULT '0',
  `key` varchar(64) NOT NULL DEFAULT '',
  `value` text,
  PRIMARY KEY (`config_id`),
  KEY `site_key` (`site_id`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `exp_consent_audit_log`;
CREATE TABLE `exp_consent_audit_log` (
  `consent_audit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `consent_request_id` int(10) unsigned NOT NULL,
  `consent_request_version_id` int(10) unsigned DEFAULT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_date` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`consent_audit_id`),
  KEY `consent_request_id` (`consent_request_id`),
  KEY `consent_request_version_id` (`consent_request_version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_consent_request_version_cookies`;
CREATE TABLE `exp_consent_request_version_cookies` (
  `consent_request_version_id` int(10) unsigned NOT NULL,
  `cookie_id` int(10) unsigned NOT NULL,
  KEY `consent_request_version_cookies` (`consent_request_version_id`,`cookie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_consent_request_versions`;
CREATE TABLE `exp_consent_request_versions` (
  `consent_request_version_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `consent_request_id` int(10) unsigned NOT NULL,
  `request` mediumtext COLLATE utf8mb4_unicode_ci,
  `request_format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `create_date` int(10) NOT NULL DEFAULT '0',
  `author_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`consent_request_version_id`),
  KEY `consent_request_id` (`consent_request_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_consent_requests`;
CREATE TABLE `exp_consent_requests` (
  `consent_request_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `consent_request_version_id` int(10) unsigned DEFAULT NULL,
  `user_created` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consent_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `double_opt_in` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `retention_period` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`consent_request_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_consents`;
CREATE TABLE `exp_consents` (
  `consent_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `consent_request_id` int(10) unsigned NOT NULL,
  `consent_request_version_id` int(10) unsigned NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `request_copy` mediumtext COLLATE utf8mb4_unicode_ci,
  `request_format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `consent_given` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `consent_given_via` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiration_date` int(10) DEFAULT NULL,
  `response_date` int(10) DEFAULT NULL,
  PRIMARY KEY (`consent_id`),
  KEY `consent_request_version_id` (`consent_request_version_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_content_types`;
CREATE TABLE `exp_content_types` (
  `content_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`content_type_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_cookie_settings`;
CREATE TABLE `exp_cookie_settings` (
  `cookie_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cookie_provider` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cookie_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cookie_lifetime` int(10) unsigned DEFAULT NULL,
  `cookie_enforced_lifetime` int(10) unsigned DEFAULT NULL,
  `cookie_title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cookie_description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`cookie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_cp_log`;
CREATE TABLE `exp_cp_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `member_id` int(10) unsigned NOT NULL,
  `username` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `act_date` int(10) NOT NULL,
  `action` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_dashboard_layout_widgets`;
CREATE TABLE `exp_dashboard_layout_widgets` (
  `layout_id` int(10) unsigned NOT NULL,
  `widget_id` int(10) unsigned NOT NULL,
  KEY `layouts_widgets` (`layout_id`,`widget_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_dashboard_layouts`;
CREATE TABLE `exp_dashboard_layouts` (
  `layout_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned DEFAULT NULL,
  `role_id` int(10) unsigned DEFAULT NULL,
  `order` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`layout_id`),
  KEY `member_id` (`member_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_dashboard_widgets`;
CREATE TABLE `exp_dashboard_widgets` (
  `widget_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `widget_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `widget_data` mediumtext COLLATE utf8mb4_unicode_ci,
  `widget_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `widget_source` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `widget_file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`widget_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_developer_log`;
CREATE TABLE `exp_developer_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int(10) unsigned NOT NULL,
  `viewed` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `description` text COLLATE utf8mb4_unicode_ci,
  `function` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line` int(10) unsigned DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deprecated_since` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `use_instead` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_id` int(10) unsigned NOT NULL DEFAULT '0',
  `template_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_group` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addon_module` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addon_method` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `snippets` text COLLATE utf8mb4_unicode_ci,
  `hash` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_dock_prolets`;
CREATE TABLE `exp_dock_prolets` (
  `dock_id` int(10) unsigned NOT NULL,
  `prolet_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_docks`;
CREATE TABLE `exp_docks` (
  `dock_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`dock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_email_cache`;
CREATE TABLE `exp_email_cache` (
  `cache_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `cache_date` int(10) unsigned NOT NULL DEFAULT '0',
  `total_sent` int(6) unsigned NOT NULL,
  `from_name` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_email` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bcc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_array` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `plaintext_alt` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `mailtype` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text_fmt` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wordwrap` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `attachments` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`cache_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_email_cache_mg`;
CREATE TABLE `exp_email_cache_mg` (
  `cache_id` int(6) unsigned NOT NULL,
  `role_id` int(10) NOT NULL,
  PRIMARY KEY (`cache_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_email_cache_ml`;
CREATE TABLE `exp_email_cache_ml` (
  `cache_id` int(6) unsigned NOT NULL,
  `list_id` smallint(4) NOT NULL,
  PRIMARY KEY (`cache_id`,`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_email_console_cache`;
CREATE TABLE `exp_email_console_cache` (
  `cache_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `cache_date` int(10) unsigned NOT NULL DEFAULT '0',
  `member_id` int(10) unsigned NOT NULL,
  `member_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `recipient` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`cache_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_email_tracker`;
CREATE TABLE `exp_email_tracker` (
  `email_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_date` int(10) unsigned NOT NULL DEFAULT '0',
  `sender_ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_email` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_recipients` int(4) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_entry_manager_views`;
CREATE TABLE `exp_entry_manager_views` (
  `view_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `channel_id` int(6) unsigned NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `name` varchar(128) NOT NULL DEFAULT '',
  `columns` text NOT NULL,
  PRIMARY KEY (`view_id`),
  KEY `channel_id_member_id` (`channel_id`,`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `exp_entry_versioning`;
CREATE TABLE `exp_entry_versioning` (
  `version_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `channel_id` int(4) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  `version_date` int(10) NOT NULL,
  `version_data` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`version_id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_extensions`;
CREATE TABLE `exp_extensions` (
  `extension_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `method` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hook` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `settings` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` int(2) NOT NULL DEFAULT '10',
  `version` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `enabled` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  PRIMARY KEY (`extension_id`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_field_condition_sets`;
CREATE TABLE `exp_field_condition_sets` (
  `condition_set_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all',
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`condition_set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_field_condition_sets_channel_fields`;
CREATE TABLE `exp_field_condition_sets_channel_fields` (
  `condition_set_id` int(10) unsigned NOT NULL,
  `field_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`condition_set_id`,`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_field_conditions`;
CREATE TABLE `exp_field_conditions` (
  `condition_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `condition_set_id` int(10) unsigned NOT NULL,
  `condition_field_id` int(10) unsigned NOT NULL,
  `evaluation_rule` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`condition_id`),
  KEY `condition_set_id` (`condition_set_id`),
  KEY `condition_field_id` (`condition_field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_field_groups`;
CREATE TABLE `exp_field_groups` (
  `group_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned DEFAULT '1',
  `group_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_description` text COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`group_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_fieldtypes`;
CREATE TABLE `exp_fieldtypes` (
  `fieldtype_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci,
  `has_global_settings` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'n',
  PRIMARY KEY (`fieldtype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_file_categories`;
CREATE TABLE `exp_file_categories` (
  `file_id` int(10) unsigned NOT NULL,
  `cat_id` int(10) unsigned NOT NULL,
  `sort` int(10) unsigned DEFAULT '0',
  `is_cover` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'n',
  PRIMARY KEY (`file_id`,`cat_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_file_data`;
CREATE TABLE `exp_file_data` (
  `file_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_file_dimensions`;
CREATE TABLE `exp_file_dimensions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `upload_location_id` int(4) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `resize_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `width` int(10) DEFAULT '0',
  `height` int(10) DEFAULT '0',
  `quality` tinyint(1) unsigned DEFAULT '90',
  `watermark_id` int(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `upload_location_id` (`upload_location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_file_manager_views`;
CREATE TABLE `exp_file_manager_views` (
  `view_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `viewtype` varchar(10) NOT NULL DEFAULT 'list',
  `upload_id` int(6) unsigned NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `name` varchar(128) NOT NULL DEFAULT '',
  `columns` text NOT NULL,
  PRIMARY KEY (`view_id`),
  KEY `viewtype_upload_id_member_id` (`viewtype`,`upload_id`,`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `exp_file_usage`;
CREATE TABLE `exp_file_usage` (
  `file_id` int(10) unsigned NOT NULL,
  `entry_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cat_id` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `file_id` (`file_id`),
  KEY `entry_id` (`entry_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_file_watermarks`;
CREATE TABLE `exp_file_watermarks` (
  `wm_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `wm_name` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wm_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `wm_image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wm_test_image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wm_use_font` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'y',
  `wm_font` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wm_font_size` int(3) unsigned DEFAULT NULL,
  `wm_text` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wm_vrt_alignment` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'top',
  `wm_hor_alignment` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'left',
  `wm_padding` int(3) unsigned DEFAULT NULL,
  `wm_opacity` int(3) unsigned DEFAULT NULL,
  `wm_hor_offset` int(4) unsigned DEFAULT NULL,
  `wm_vrt_offset` int(4) unsigned DEFAULT NULL,
  `wm_x_transp` int(4) DEFAULT NULL,
  `wm_y_transp` int(4) DEFAULT NULL,
  `wm_font_color` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wm_use_drop_shadow` char(1) COLLATE utf8mb4_unicode_ci DEFAULT 'y',
  `wm_shadow_distance` int(3) unsigned DEFAULT NULL,
  `wm_shadow_color` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`wm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_files`;
CREATE TABLE `exp_files` (
  `file_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_type` enum('File','Directory') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'File',
  `site_id` int(4) unsigned DEFAULT '1',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upload_location_id` int(4) unsigned DEFAULT '0',
  `directory_id` int(10) unsigned DEFAULT '0',
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` int(10) DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `credit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_by_member_id` int(10) unsigned DEFAULT '0',
  `upload_date` int(10) DEFAULT NULL,
  `modified_by_member_id` int(10) unsigned DEFAULT '0',
  `modified_date` int(10) DEFAULT NULL,
  `file_hw_original` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `total_records` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`file_id`),
  KEY `model_type` (`model_type`),
  KEY `upload_location_id` (`upload_location_id`),
  KEY `directory_id` (`directory_id`),
  KEY `file_type` (`file_type`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_fluid_field_data`;
CREATE TABLE `exp_fluid_field_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fluid_field_id` int(11) unsigned NOT NULL,
  `entry_id` int(11) unsigned NOT NULL,
  `field_id` int(11) unsigned NOT NULL,
  `field_data_id` int(11) unsigned NOT NULL,
  `field_group_id` int(11) unsigned DEFAULT NULL,
  `order` int(5) unsigned NOT NULL DEFAULT '0',
  `group` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fluid_field_id_entry_id` (`fluid_field_id`,`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_global_variables`;
CREATE TABLE `exp_global_variables` (
  `variable_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `variable_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `variable_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `edit_date` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`variable_id`),
  KEY `variable_name` (`variable_name`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_grid_columns`;
CREATE TABLE `exp_grid_columns` (
  `col_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(10) unsigned DEFAULT NULL,
  `content_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_order` int(3) unsigned DEFAULT NULL,
  `col_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_name` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_instructions` text COLLATE utf8mb4_unicode_ci,
  `col_required` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_search` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_width` int(3) unsigned DEFAULT NULL,
  `col_settings` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`col_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_html_buttons`;
CREATE TABLE `exp_html_buttons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `member_id` int(10) NOT NULL DEFAULT '0',
  `tag_name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag_open` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag_close` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accesskey` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag_order` int(3) unsigned NOT NULL,
  `tag_row` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `classname` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_layout_publish`;
CREATE TABLE `exp_layout_publish` (
  `layout_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `channel_id` int(4) unsigned NOT NULL DEFAULT '0',
  `layout_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_layout` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`layout_id`),
  KEY `site_id` (`site_id`),
  KEY `channel_id` (`channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_layout_publish_member_roles`;
CREATE TABLE `exp_layout_publish_member_roles` (
  `layout_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`layout_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_member_bulletin_board`;
CREATE TABLE `exp_member_bulletin_board` (
  `bulletin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) unsigned NOT NULL,
  `bulletin_group` int(8) unsigned NOT NULL,
  `bulletin_date` int(10) unsigned NOT NULL,
  `hash` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `bulletin_expires` int(10) unsigned NOT NULL DEFAULT '0',
  `bulletin_message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`bulletin_id`),
  KEY `sender_id` (`sender_id`),
  KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_member_data`;
CREATE TABLE `exp_member_data` (
  `member_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_member_data_field_1`;
CREATE TABLE `exp_member_data_field_1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL,
  `m_field_id_1` text COLLATE utf8mb4_unicode_ci,
  `m_field_ft_1` tinytext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_member_fields`;
CREATE TABLE `exp_member_fields` (
  `m_field_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `m_field_name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `m_field_label` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `m_field_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `m_field_type` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `m_field_list_items` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `m_field_ta_rows` tinyint(2) DEFAULT '8',
  `m_field_maxl` smallint(3) DEFAULT NULL,
  `m_field_width` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `m_field_search` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `m_field_required` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `m_field_public` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `m_field_reg` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `m_field_cp_reg` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `m_field_fmt` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `m_field_show_fmt` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `m_field_exclude_from_anon` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `m_field_order` int(3) unsigned DEFAULT NULL,
  `m_field_text_direction` char(3) COLLATE utf8mb4_unicode_ci DEFAULT 'ltr',
  `m_field_settings` text COLLATE utf8mb4_unicode_ci,
  `m_legacy_field_data` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`m_field_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_member_news_views`;
CREATE TABLE `exp_member_news_views` (
  `news_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`news_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_member_search`;
CREATE TABLE `exp_member_search` (
  `search_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `search_date` int(10) unsigned NOT NULL,
  `keywords` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fields` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `total_results` int(8) unsigned NOT NULL,
  `query` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`search_id`),
  KEY `member_id` (`member_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_members`;
CREATE TABLE `exp_members` (
  `member_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) NOT NULL DEFAULT '0',
  `pending_role_id` int(10) NOT NULL DEFAULT '0',
  `username` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `screen_name` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `salt` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `unique_id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `crypt_key` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backup_mfa_code` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authcode` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `signature` text COLLATE utf8mb4_unicode_ci,
  `avatar_filename` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_width` int(4) unsigned DEFAULT NULL,
  `avatar_height` int(4) unsigned DEFAULT NULL,
  `photo_filename` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_width` int(4) unsigned DEFAULT NULL,
  `photo_height` int(4) unsigned DEFAULT NULL,
  `sig_img_filename` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sig_img_width` int(4) unsigned DEFAULT NULL,
  `sig_img_height` int(4) unsigned DEFAULT NULL,
  `ignore_list` text COLLATE utf8mb4_unicode_ci,
  `private_messages` int(4) unsigned NOT NULL DEFAULT '0',
  `accept_messages` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `last_view_bulletins` int(10) NOT NULL DEFAULT '0',
  `last_bulletin_date` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `join_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_visit` int(10) unsigned NOT NULL DEFAULT '0',
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `total_entries` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `total_comments` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `total_forum_topics` mediumint(8) NOT NULL DEFAULT '0',
  `total_forum_posts` mediumint(8) NOT NULL DEFAULT '0',
  `last_entry_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_comment_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_forum_post_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_email_date` int(10) unsigned NOT NULL DEFAULT '0',
  `in_authorlist` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `accept_admin_email` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `accept_user_email` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `notify_by_default` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `notify_of_pm` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `display_signatures` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `parse_smileys` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `smart_notifications` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `language` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_format` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_format` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `week_start` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `include_seconds` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_theme` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forum_theme` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracker` text COLLATE utf8mb4_unicode_ci,
  `template_size` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '28',
  `notepad` text COLLATE utf8mb4_unicode_ci,
  `notepad_size` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '18',
  `bookmarklets` text COLLATE utf8mb4_unicode_ci,
  `quick_links` text COLLATE utf8mb4_unicode_ci,
  `quick_tabs` text COLLATE utf8mb4_unicode_ci,
  `show_sidebar` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `pmember_id` int(10) NOT NULL DEFAULT '0',
  `cp_homepage` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cp_homepage_channel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cp_homepage_custom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dismissed_banner` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `enable_mfa` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`member_id`),
  KEY `role_id` (`role_id`),
  KEY `unique_id` (`unique_id`),
  KEY `password` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_members_role_groups`;
CREATE TABLE `exp_members_role_groups` (
  `member_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`member_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_members_roles`;
CREATE TABLE `exp_members_roles` (
  `member_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`member_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_menu_items`;
CREATE TABLE `exp_menu_items` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `set_id` int(10) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `set_id` (`set_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_menu_sets`;
CREATE TABLE `exp_menu_sets` (
  `set_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`set_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_message_attachments`;
CREATE TABLE `exp_message_attachments` (
  `attachment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) unsigned NOT NULL DEFAULT '0',
  `message_id` int(10) unsigned NOT NULL DEFAULT '0',
  `attachment_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `attachment_hash` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `attachment_extension` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `attachment_location` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `attachment_date` int(10) unsigned NOT NULL DEFAULT '0',
  `attachment_size` int(10) unsigned NOT NULL DEFAULT '0',
  `is_temp` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_message_copies`;
CREATE TABLE `exp_message_copies` (
  `copy_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sender_id` int(10) unsigned NOT NULL DEFAULT '0',
  `recipient_id` int(10) unsigned NOT NULL DEFAULT '0',
  `message_received` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `message_read` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `message_time_read` int(10) unsigned NOT NULL DEFAULT '0',
  `attachment_downloaded` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `message_folder` int(10) unsigned NOT NULL DEFAULT '1',
  `message_authcode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message_deleted` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `message_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`copy_id`),
  KEY `message_id` (`message_id`),
  KEY `recipient_id` (`recipient_id`),
  KEY `sender_id` (`sender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_message_data`;
CREATE TABLE `exp_message_data` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) unsigned NOT NULL DEFAULT '0',
  `message_date` int(10) unsigned NOT NULL DEFAULT '0',
  `message_subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message_body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_tracking` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `message_attachments` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `message_recipients` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message_cc` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message_hide_cc` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `message_sent_copy` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `total_recipients` int(5) unsigned NOT NULL DEFAULT '0',
  `message_status` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`message_id`),
  KEY `sender_id` (`sender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_message_folders`;
CREATE TABLE `exp_message_folders` (
  `member_id` int(10) unsigned NOT NULL DEFAULT '0',
  `folder1_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'InBox',
  `folder2_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Sent',
  `folder3_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `folder4_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `folder5_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `folder6_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `folder7_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `folder8_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `folder9_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `folder10_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_message_listed`;
CREATE TABLE `exp_message_listed` (
  `listed_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL DEFAULT '0',
  `listed_member` int(10) unsigned NOT NULL DEFAULT '0',
  `listed_description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `listed_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'blocked',
  PRIMARY KEY (`listed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_migrations`;
CREATE TABLE `exp_migrations` (
  `migration_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` text COLLATE utf8mb4_unicode_ci,
  `migration_location` text COLLATE utf8mb4_unicode_ci,
  `migration_group` int(10) unsigned DEFAULT NULL,
  `migration_run_date` datetime NOT NULL,
  PRIMARY KEY (`migration_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_module_member_roles`;
CREATE TABLE `exp_module_member_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `module_id` mediumint(5) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_modules`;
CREATE TABLE `exp_modules` (
  `module_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_version` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_cp_backend` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `has_publish_fields` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_online_users`;
CREATE TABLE `exp_online_users` (
  `online_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `member_id` int(10) NOT NULL DEFAULT '0',
  `in_forum` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `name` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `anon` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`online_id`),
  KEY `date` (`date`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_password_lockout`;
CREATE TABLE `exp_password_lockout` (
  `lockout_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login_date` int(10) unsigned NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`lockout_id`),
  KEY `login_date` (`login_date`),
  KEY `ip_address` (`ip_address`),
  KEY `user_agent` (`user_agent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_permissions`;
CREATE TABLE `exp_permissions` (
  `permission_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `site_id` int(5) unsigned NOT NULL,
  `permission` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`),
  KEY `role_id_site_id` (`role_id`,`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_plugins`;
CREATE TABLE `exp_plugins` (
  `plugin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plugin_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plugin_package` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plugin_version` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_typography_related` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`plugin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_pro_search_collections`;
CREATE TABLE `exp_pro_search_collections` (
  `collection_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL,
  `channel_id` int(6) unsigned NOT NULL,
  `collection_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `collection_label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modifier` decimal(4,1) unsigned NOT NULL DEFAULT '1.0',
  `excerpt` int(6) unsigned NOT NULL DEFAULT '0',
  `settings` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `edit_date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`collection_id`),
  KEY `site_id` (`site_id`),
  KEY `channel_id` (`channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_pro_search_groups`;
CREATE TABLE `exp_pro_search_groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL,
  `group_label` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_pro_search_indexes`;
CREATE TABLE `exp_pro_search_indexes` (
  `collection_id` int(10) unsigned NOT NULL,
  `entry_id` int(10) unsigned NOT NULL,
  `site_id` int(4) unsigned NOT NULL,
  `index_text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `index_date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`collection_id`,`entry_id`),
  KEY `collection_id` (`collection_id`),
  KEY `site_id` (`site_id`),
  FULLTEXT KEY `index_text` (`index_text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_pro_search_log`;
CREATE TABLE `exp_pro_search_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `search_date` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_results` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_pro_search_replace_log`;
CREATE TABLE `exp_pro_search_replace_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `replace_date` int(10) unsigned NOT NULL,
  `keywords` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `replacement` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fields` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `entries` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_pro_search_shortcuts`;
CREATE TABLE `exp_pro_search_shortcuts` (
  `shortcut_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL,
  `group_id` int(4) unsigned NOT NULL,
  `shortcut_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shortcut_label` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int(4) unsigned NOT NULL,
  PRIMARY KEY (`shortcut_id`),
  KEY `site_id` (`site_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_pro_search_words`;
CREATE TABLE `exp_pro_search_words` (
  `site_id` int(4) unsigned NOT NULL,
  `language` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `word` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `length` int(4) unsigned NOT NULL,
  `sound` char(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clean` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`site_id`,`language`,`word`),
  KEY `length` (`length`),
  KEY `sound` (`sound`),
  KEY `clean` (`clean`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_pro_variable_groups`;
CREATE TABLE `exp_pro_variable_groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_label` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_notes` text COLLATE utf8mb4_unicode_ci,
  `group_order` int(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_pro_variables`;
CREATE TABLE `exp_pro_variables` (
  `variable_id` int(10) unsigned NOT NULL,
  `group_id` int(6) unsigned NOT NULL DEFAULT '0',
  `variable_label` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variable_notes` text COLLATE utf8mb4_unicode_ci,
  `variable_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variable_settings` text COLLATE utf8mb4_unicode_ci,
  `variable_order` int(4) unsigned NOT NULL DEFAULT '0',
  `early_parsing` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `is_hidden` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `save_as_file` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `edit_date` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`variable_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_prolets`;
CREATE TABLE `exp_prolets` (
  `prolet_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `source` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`prolet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_relationships`;
CREATE TABLE `exp_relationships` (
  `relationship_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `child_id` int(10) unsigned NOT NULL DEFAULT '0',
  `field_id` int(10) unsigned NOT NULL DEFAULT '0',
  `fluid_field_data_id` int(10) unsigned NOT NULL DEFAULT '0',
  `grid_field_id` int(10) unsigned NOT NULL DEFAULT '0',
  `grid_col_id` int(10) unsigned NOT NULL DEFAULT '0',
  `grid_row_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`relationship_id`),
  KEY `parent_id` (`parent_id`),
  KEY `child_id` (`child_id`),
  KEY `field_id` (`field_id`),
  KEY `fluid_field_data_id` (`fluid_field_data_id`),
  KEY `grid_row_id` (`grid_row_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_remember_me`;
CREATE TABLE `exp_remember_me` (
  `remember_me_id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `member_id` int(10) DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `admin_sess` tinyint(1) DEFAULT '0',
  `site_id` int(4) DEFAULT '1',
  `expiration` int(10) DEFAULT '0',
  `last_refresh` int(10) DEFAULT '0',
  PRIMARY KEY (`remember_me_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_reset_password`;
CREATE TABLE `exp_reset_password` (
  `reset_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL,
  `resetcode` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` int(10) NOT NULL,
  PRIMARY KEY (`reset_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_revision_tracker`;
CREATE TABLE `exp_revision_tracker` (
  `tracker_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL,
  `item_table` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_field` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_date` int(10) NOT NULL,
  `item_author_id` int(10) unsigned NOT NULL,
  `item_data` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`tracker_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_role_groups`;
CREATE TABLE `exp_role_groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_role_settings`;
CREATE TABLE `exp_role_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `menu_set_id` int(5) unsigned NOT NULL DEFAULT '1',
  `mbr_delete_notify_emails` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exclude_from_moderation` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `search_flood_control` mediumint(5) unsigned NOT NULL,
  `prv_msg_send_limit` smallint(5) unsigned NOT NULL DEFAULT '20',
  `prv_msg_storage_limit` smallint(5) unsigned NOT NULL DEFAULT '60',
  `include_in_authorlist` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `include_in_memberlist` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `cp_homepage` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cp_homepage_channel` int(10) unsigned NOT NULL DEFAULT '0',
  `cp_homepage_custom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `require_mfa` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`),
  KEY `role_id_site_id` (`role_id`,`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_roles`;
CREATE TABLE `exp_roles` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `total_members` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `is_locked` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_roles_role_groups`;
CREATE TABLE `exp_roles_role_groups` (
  `role_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_rte_toolsets`;
CREATE TABLE `exp_rte_toolsets` (
  `toolset_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `toolset_name` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `toolset_type` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`toolset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_search`;
CREATE TABLE `exp_search` (
  `search_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_id` int(4) NOT NULL DEFAULT '1',
  `search_date` int(10) NOT NULL,
  `keywords` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_results` int(6) NOT NULL,
  `per_page` tinyint(3) unsigned NOT NULL,
  `query` mediumtext COLLATE utf8mb4_unicode_ci,
  `custom_fields` mediumtext COLLATE utf8mb4_unicode_ci,
  `result_page` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_result_page` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`search_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_search_log`;
CREATE TABLE `exp_search_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `member_id` int(10) unsigned NOT NULL,
  `screen_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `search_date` int(10) NOT NULL,
  `search_type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `search_terms` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_security_hashes`;
CREATE TABLE `exp_security_hashes` (
  `hash_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(10) unsigned NOT NULL,
  `session_id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `hash` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`hash_id`),
  KEY `session_id` (`session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_sessions`;
CREATE TABLE `exp_sessions` (
  `session_id` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `member_id` int(10) NOT NULL DEFAULT '0',
  `admin_sess` tinyint(1) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_state` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fingerprint` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sess_start` int(10) unsigned NOT NULL DEFAULT '0',
  `auth_timeout` int(10) unsigned NOT NULL DEFAULT '0',
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `can_debug` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `mfa_flag` enum('skip','show','required') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'skip',
  `pro_banner_seen` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`session_id`),
  KEY `member_id` (`member_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_sites`;
CREATE TABLE `exp_sites` (
  `site_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `site_label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `site_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `site_description` text COLLATE utf8mb4_unicode_ci,
  `site_color` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `site_bootstrap_checksums` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_pages` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`site_id`),
  KEY `site_name` (`site_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_snippets`;
CREATE TABLE `exp_snippets` (
  `snippet_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) NOT NULL,
  `snippet_name` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `snippet_contents` text COLLATE utf8mb4_unicode_ci,
  `edit_date` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`snippet_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_specialty_templates`;
CREATE TABLE `exp_specialty_templates` (
  `template_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `enable_template` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `template_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_title` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_type` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_subtype` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_notes` text COLLATE utf8mb4_unicode_ci,
  `edit_date` int(10) NOT NULL DEFAULT '0',
  `last_author_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`template_id`),
  KEY `template_name` (`template_name`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_stats`;
CREATE TABLE `exp_stats` (
  `stat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `total_members` mediumint(7) NOT NULL DEFAULT '0',
  `recent_member_id` int(10) NOT NULL DEFAULT '0',
  `recent_member` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_entries` mediumint(8) NOT NULL DEFAULT '0',
  `total_forum_topics` mediumint(8) NOT NULL DEFAULT '0',
  `total_forum_posts` mediumint(8) NOT NULL DEFAULT '0',
  `total_comments` mediumint(8) NOT NULL DEFAULT '0',
  `last_entry_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_forum_post_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_comment_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_visitor_date` int(10) unsigned NOT NULL DEFAULT '0',
  `most_visitors` mediumint(7) NOT NULL DEFAULT '0',
  `most_visitor_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_cache_clear` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`stat_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_statuses`;
CREATE TABLE `exp_statuses` (
  `status_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_order` int(3) unsigned NOT NULL,
  `highlight` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000000',
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_statuses_roles`;
CREATE TABLE `exp_statuses_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `status_id` int(6) unsigned NOT NULL,
  PRIMARY KEY (`status_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_structure`;
CREATE TABLE `exp_structure` (
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `entry_id` int(10) unsigned NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `channel_id` int(6) unsigned NOT NULL DEFAULT '0',
  `listing_cid` int(6) unsigned NOT NULL DEFAULT '0',
  `lft` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rgt` smallint(5) unsigned NOT NULL DEFAULT '0',
  `dead` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hidden` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `structure_url_title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_id` int(10) unsigned NOT NULL DEFAULT '0',
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_structure_channels`;
CREATE TABLE `exp_structure_channels` (
  `site_id` smallint(5) unsigned NOT NULL,
  `channel_id` mediumint(8) unsigned NOT NULL,
  `template_id` int(10) unsigned NOT NULL,
  `type` enum('page','listing','asset','unmanaged') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unmanaged',
  `split_assets` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `show_in_page_selector` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  PRIMARY KEY (`site_id`,`channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_structure_listings`;
CREATE TABLE `exp_structure_listings` (
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `entry_id` int(10) unsigned NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `channel_id` int(6) unsigned NOT NULL DEFAULT '0',
  `template_id` int(6) unsigned NOT NULL DEFAULT '0',
  `uri` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_structure_members`;
CREATE TABLE `exp_structure_members` (
  `member_id` int(10) unsigned NOT NULL DEFAULT '0',
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `nav_state` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`site_id`,`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_structure_nav_history`;
CREATE TABLE `exp_structure_nav_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` smallint(5) unsigned NOT NULL,
  `site_pages` longtext COLLATE utf8mb4_unicode_ci,
  `structure` longtext COLLATE utf8mb4_unicode_ci,
  `note` text COLLATE utf8mb4_unicode_ci,
  `structure_version` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `current` smallint(5) unsigned NOT NULL DEFAULT '0',
  `restored_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_structure_settings`;
CREATE TABLE `exp_structure_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(8) unsigned NOT NULL DEFAULT '1',
  `var` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `var_value` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_template_groups`;
CREATE TABLE `exp_template_groups` (
  `group_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_order` int(3) unsigned NOT NULL,
  `is_site_default` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`group_id`),
  KEY `site_id` (`site_id`),
  KEY `group_name_idx` (`group_name`),
  KEY `group_order_idx` (`group_order`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_template_groups_roles`;
CREATE TABLE `exp_template_groups_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `template_group_id` mediumint(5) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`template_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_template_routes`;
CREATE TABLE `exp_template_routes` (
  `route_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned NOT NULL,
  `order` int(10) unsigned DEFAULT NULL,
  `route` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_parsed` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_required` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`route_id`),
  KEY `template_id` (`template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_templates`;
CREATE TABLE `exp_templates` (
  `template_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_id` int(6) unsigned NOT NULL,
  `template_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'webpage',
  `template_engine` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_data` mediumtext COLLATE utf8mb4_unicode_ci,
  `template_notes` text COLLATE utf8mb4_unicode_ci,
  `edit_date` int(10) NOT NULL DEFAULT '0',
  `last_author_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cache` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `refresh` int(6) unsigned NOT NULL DEFAULT '0',
  `no_auth_bounce` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `enable_http_auth` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `allow_php` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `php_parse_location` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'o',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `protect_javascript` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `enable_frontedit` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  PRIMARY KEY (`template_id`),
  KEY `group_id` (`group_id`),
  KEY `template_name` (`template_name`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_templates_roles`;
CREATE TABLE `exp_templates_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `template_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`template_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_throttle`;
CREATE TABLE `exp_throttle` (
  `throttle_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL,
  `locked_out` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  PRIMARY KEY (`throttle_id`),
  KEY `ip_address` (`ip_address`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_update_log`;
CREATE TABLE `exp_update_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int(10) unsigned DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `method` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `line` int(10) unsigned DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_upload_prefs`;
CREATE TABLE `exp_upload_prefs` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adapter` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'local',
  `adapter_settings` text COLLATE utf8mb4_unicode_ci,
  `server_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allowed_types` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'img',
  `allow_subfolders` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `subfolders_on_top` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y',
  `default_modal_view` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'list',
  `max_size` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_height` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_width` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pre_format` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_format` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_properties` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_pre_format` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_post_format` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat_group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batch_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_id` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `exp_upload_prefs_roles`;
CREATE TABLE `exp_upload_prefs_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `upload_id` int(4) unsigned NOT NULL,
  PRIMARY KEY (`upload_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `exp_actions` (`action_id`, `class`, `method`, `csrf_exempt`) VALUES
(1, 'Channel', 'submit_entry', 0),
(2, 'Channel', 'smiley_pop', 0),
(3, 'Channel', 'combo_loader', 0),
(4, 'Channel', 'live_preview', 1),
(5, 'Comment', 'insert_new_comment', 0),
(6, 'Comment_mcp', 'delete_comment_notification', 0),
(7, 'Comment', 'comment_subscribe', 0),
(8, 'Comment', 'edit_comment', 0),
(9, 'Consent', 'grantConsent', 0),
(10, 'Consent', 'submitConsent', 0),
(11, 'Consent', 'withdrawConsent', 0),
(12, 'Member', 'registration_form', 0),
(13, 'Member', 'register_member', 0),
(14, 'Member', 'activate_member', 0),
(15, 'Member', 'member_login', 0),
(16, 'Member', 'member_logout', 0),
(17, 'Member', 'send_reset_token', 0),
(18, 'Member', 'process_reset_password', 0),
(19, 'Member', 'send_member_email', 0),
(20, 'Member', 'update_un_pw', 0),
(21, 'Member', 'do_member_search', 0),
(22, 'Member', 'member_delete', 0),
(23, 'Member', 'send_username', 0),
(24, 'Member', 'update_profile', 0),
(25, 'Member', 'upload_avatar', 0),
(26, 'Member', 'recaptcha_check', 1),
(27, 'Member', 'validate', 0),
(28, 'Rte', 'pages_autocomplete', 0),
(29, 'File', 'addonIcon', 1),
(30, 'Relationship', 'entryList', 0),
(31, 'Search', 'do_search', 1),
(32, 'Pro', 'setCookie', 0),
(33, 'Pro', 'qrCode', 0),
(34, 'Pro', 'validateMfa', 0),
(35, 'Pro', 'invokeMfa', 0),
(36, 'Pro', 'enableMfa', 0),
(37, 'Pro', 'disableMfa', 0),
(38, 'Pro', 'resetMfa', 0),
(39, 'Email', 'send_email', 0),
(40, 'Structure', 'ajax_move_set_data', 0),
(41, 'Pro_variables', 'sync', 0),
(42, 'Pro_search', 'catch_search', 1),
(43, 'Pro_search', 'build_index', 0),
(44, 'Pro_search', 'save_search', 0);

INSERT INTO `exp_categories` (`cat_id`, `site_id`, `group_id`, `parent_id`, `cat_name`, `cat_url_title`, `cat_description`, `cat_image`, `cat_order`) VALUES
(1, 1, 1, 0, 'News', 'news', NULL, NULL, 1),
(2, 1, 1, 0, 'Personal', 'personal', NULL, NULL, 2),
(3, 1, 1, 0, 'Photos', 'photos', NULL, NULL, 3),
(4, 1, 1, 0, 'Videos', 'videos', NULL, NULL, 4),
(5, 1, 1, 0, 'Music', 'music', NULL, NULL, 5),
(6, 1, 2, 0, 'Not Shown', 'not-shown', NULL, NULL, 1);

INSERT INTO `exp_category_field_data` (`cat_id`, `site_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 1, 1),
(4, 1, 1),
(5, 1, 1),
(6, 1, 2);

INSERT INTO `exp_category_fields` (`field_id`, `site_id`, `group_id`, `field_name`, `field_label`, `field_type`, `field_list_items`, `field_maxl`, `field_ta_rows`, `field_default_fmt`, `field_show_fmt`, `field_text_direction`, `field_required`, `field_order`, `field_settings`, `legacy_field_data`) VALUES
(1, 1, 1, 'blog_category_description', 'Blog Category Description', 'textarea', '', 128, 0, 'none', 'n', 'ltr', 'n', 1, '{\"field_show_file_selector\":\"n\",\"db_column_type\":\"text\",\"field_show_smileys\":\"n\",\"field_show_formatting_btns\":\"n\"}', 'n');

INSERT INTO `exp_category_groups` (`group_id`, `site_id`, `group_name`, `sort_order`, `exclude_group`, `field_html_formatting`, `can_edit_categories`, `can_delete_categories`) VALUES
(1, 1, 'Blog', 'c', 0, 'all', NULL, NULL),
(2, 1, 'Slideshow', 'a', 0, 'all', NULL, NULL);

INSERT INTO `exp_category_posts` (`entry_id`, `cat_id`) VALUES
(5, 1),
(6, 5),
(7, 4),
(8, 4),
(9, 3),
(11, 2),
(12, 5);

INSERT INTO `exp_channel_data` (`entry_id`, `site_id`, `channel_id`) VALUES
(1, 1, 3),
(2, 1, 1),
(3, 1, 1),
(4, 1, 1),
(5, 1, 2),
(6, 1, 2),
(7, 1, 2),
(8, 1, 2),
(9, 1, 2),
(10, 1, 2),
(11, 1, 2),
(12, 1, 2),
(13, 1, 4);

INSERT INTO `exp_channel_data_field_1` (`id`, `entry_id`, `field_id_1`, `field_ft_1`) VALUES
(1, 1, 'user@example.com', 'none');

INSERT INTO `exp_channel_data_field_10` (`id`, `entry_id`, `field_id_10`, `field_ft_10`) VALUES
(1, 1, 'Contact {site_name}', 'none'),
(2, 2, 'About {site_name}', 'none'),
(3, 3, 'Sub page one', 'none'),
(4, 4, 'Sub page two', 'none'),
(5, 5, 'This is one that is hipper than most.', 'none'),
(6, 6, 'Marrow and the broken bones.', 'none'),
(7, 7, 'Action Comedy', 'none'),
(8, 8, 'The one about cutting rope.', 'none'),
(9, 9, 'A beautiful photograph', 'none'),
(10, 10, 'Super old entry', 'none'),
(11, 11, 'A blog all about the joys of Bacon', 'none'),
(12, 12, 'Shaking it Off, a cover.', 'none');

INSERT INTO `exp_channel_data_field_11` (`id`, `entry_id`, `field_id_11`, `field_ft_11`) VALUES
(1, 1, 'Contact us, phone, mailing, email.', 'xhtml'),
(2, 2, 'This is a site to show you the power of ExpressionEngine, you can remove it, you can base your next site on it, you can just use it straight.', 'xhtml'),
(3, 3, 'Sub page examples', 'xhtml'),
(4, 4, 'Sub page examples', 'xhtml'),
(5, 5, 'A blog post about the hippest of the hipsters.', 'xhtml'),
(6, 6, 'An album for the intelligent and uncommon.', 'xhtml'),
(7, 7, 'This is how it\'s done, the incomparable Jackie Chan shows us the way.', 'xhtml'),
(8, 8, 'This is a quick video teaching you how to cut a rope.', 'xhtml'),
(9, 9, 'This is a very nice photograph I found, and I wanted to share.', 'xhtml'),
(10, 10, 'Super old entry', 'xhtml'),
(11, 11, 'This is a blog post about Bacon!', 'xhtml'),
(12, 12, 'This is how you shake it off, haters take note.', 'xhtml');

INSERT INTO `exp_channel_data_field_12` (`id`, `entry_id`, `field_id_12`, `field_ft_12`) VALUES
(1, 13, 'one|three', 'none'),
(2, 0, 'one', 'none'),
(3, 0, 'two', 'none');

INSERT INTO `exp_channel_data_field_13` (`id`, `entry_id`, `field_id_13`, `field_ft_13`) VALUES
(1, 13, '#FF0000', 'xhtml');

INSERT INTO `exp_channel_data_field_14` (`id`, `entry_id`, `field_id_14`, `field_dt_14`, `field_ft_14`) VALUES
(1, 13, 1667231340, '', 'xhtml'),
(2, 0, 1664639700, '', 'xhtml');

INSERT INTO `exp_channel_data_field_15` (`id`, `entry_id`, `field_id_15`, `field_ft_15`) VALUES
(1, 13, '61', 'xhtml');

INSERT INTO `exp_channel_data_field_16` (`id`, `entry_id`, `field_id_16`, `field_ft_16`) VALUES
(1, 13, 'test@example.com', 'xhtml');

INSERT INTO `exp_channel_data_field_17` (`id`, `entry_id`, `field_id_17`, `field_ft_17`) VALUES
(1, 13, '{file:1:url}', 'none');

INSERT INTO `exp_channel_data_field_18` (`id`, `entry_id`, `field_id_18`, `field_ft_18`) VALUES
(1, 13, NULL, 'xhtml');

INSERT INTO `exp_channel_data_field_19` (`id`, `entry_id`, `field_id_19`, `field_ft_19`) VALUES
(1, 13, 'one two  1664639700 <p>Test <strong>rich text</strong></p>  Textarea', 'xhtml');

INSERT INTO `exp_channel_data_field_2` (`id`, `entry_id`, `field_id_2`, `field_ft_2`) VALUES
(1, 1, '(555) 123-4567', 'none');

INSERT INTO `exp_channel_data_field_20` (`id`, `entry_id`, `field_id_20`, `field_ft_20`) VALUES
(1, 13, NULL, 'xhtml'),
(3, 0, NULL, 'xhtml');

INSERT INTO `exp_channel_data_field_21` (`id`, `entry_id`, `field_id_21`, `field_ft_21`) VALUES
(1, 13, 'One', 'none');

INSERT INTO `exp_channel_data_field_22` (`id`, `entry_id`, `field_id_22`, `field_ft_22`) VALUES
(1, 13, NULL, 'xhtml');

INSERT INTO `exp_channel_data_field_23` (`id`, `entry_id`, `field_id_23`, `field_ft_23`) VALUES
(1, 13, 123, 'xhtml');

INSERT INTO `exp_channel_data_field_24` (`id`, `entry_id`, `field_id_24`, `field_ft_24`) VALUES
(1, 13, 'one', 'none');

INSERT INTO `exp_channel_data_field_25` (`id`, `entry_id`, `field_id_25`, `field_ft_25`) VALUES
(1, 13, '5|10', 'xhtml');

INSERT INTO `exp_channel_data_field_26` (`id`, `entry_id`, `field_id_26`, `field_ft_26`) VALUES
(1, 13, NULL, 'xhtml');

INSERT INTO `exp_channel_data_field_27` (`id`, `entry_id`, `field_id_27`, `field_ft_27`) VALUES
(1, 13, '<p>Test <strong>strong</strong></p>', 'none'),
(2, 0, '<p>Test <strong>rich text</strong></p>', 'none');

INSERT INTO `exp_channel_data_field_28` (`id`, `entry_id`, `field_id_28`, `field_ft_28`) VALUES
(1, 13, 'one', 'none');

INSERT INTO `exp_channel_data_field_29` (`id`, `entry_id`, `field_id_29`, `field_ft_29`) VALUES
(1, 13, 'one', 'none');

INSERT INTO `exp_channel_data_field_3` (`id`, `entry_id`, `field_id_3`, `field_ft_3`) VALUES
(1, 1, NULL, 'xhtml');

INSERT INTO `exp_channel_data_field_30` (`id`, `entry_id`, `field_id_30`, `field_ft_30`) VALUES
(1, 13, '2', 'xhtml');

INSERT INTO `exp_channel_data_field_31` (`id`, `entry_id`, `field_id_31`, `field_ft_31`) VALUES
(1, 13, 'text input', 'none');

INSERT INTO `exp_channel_data_field_32` (`id`, `entry_id`, `field_id_32`, `field_ft_32`) VALUES
(1, 13, 'textarea', 'none'),
(3, 0, 'Textarea', 'none');

INSERT INTO `exp_channel_data_field_33` (`id`, `entry_id`, `field_id_33`, `field_ft_33`) VALUES
(1, 13, 1, 'xhtml');

INSERT INTO `exp_channel_data_field_34` (`id`, `entry_id`, `field_id_34`, `field_ft_34`) VALUES
(1, 13, 'http://test.com', 'xhtml');

INSERT INTO `exp_channel_data_field_35` (`id`, `entry_id`, `field_id_35`, `field_ft_35`) VALUES
(1, 13, 5, 'xhtml');

INSERT INTO `exp_channel_data_field_4` (`id`, `entry_id`, `field_id_4`, `field_ft_4`) VALUES
(1, 2, NULL, 'xhtml'),
(2, 3, NULL, 'xhtml'),
(3, 4, NULL, 'xhtml');

INSERT INTO `exp_channel_data_field_5` (`id`, `entry_id`, `field_id_5`, `field_ft_5`) VALUES
(1, 5, NULL, 'xhtml'),
(2, 6, NULL, 'xhtml'),
(3, 7, NULL, 'xhtml'),
(4, 8, NULL, 'xhtml'),
(5, 9, NULL, 'xhtml'),
(6, 10, NULL, 'xhtml'),
(7, 11, NULL, 'xhtml'),
(8, 12, NULL, 'xhtml');

INSERT INTO `exp_channel_data_field_6` (`id`, `entry_id`, `field_id_6`, `field_ft_6`) VALUES
(1, 5, 'Bacon ipsum dolor amet duis meatball magna irure short loin, aliquip rump ipsum minim chuck pork loin picanha. Velit pancetta pariatur sed. Spare ribs cillum nostrud labore, pariatur commodo proident jerky in velit quis doner sunt. Porchetta andouille aute swine. Culpa ut chuck tri-tip.\n\n<blockquote>Short ribs voluptate deserunt swine, spare ribs in doner elit ipsum do tri-tip. Laboris esse aliquip, reprehenderit magna ea shoulder short loin. Chicken velit eu incididunt prosciutto labore nisi. Et shoulder landjaeger jerky officia corned beef anim. Ea ut brisket, leberkas doner pork belly velit consectetur corned beef ham hock laboris labore. Incididunt magna kevin est ground round labore adipisicing kielbasa deserunt consectetur porchetta. Et strip steak deserunt ullamco.</blockquote>\n\nLorem ipsum dolor sit amet, <b>this is bold text</b> consectetur <strong>this text is strongly emphasized</strong> adipisicing elit, sed do eiusmod tempor incididunt <i>this is italic text</i> ut labore <em>this text is emphasized</em> et dolore magna aliqua. Ut enim ad minim veniam, <a href=\"\">this is a link</a> quis nostrud <a href=\"\" rel=\"external\">this is an external link</a> laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse <del>This text is deleted</del> <ins>this text is inserted</ins> cillum <code>this is a code sample</code> dolore eu <mark>this text is highlighted</mark> fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n\nTail t-bone andouille, aute rump elit culpa in sunt. Hamburger duis irure sint, laborum cillum ea officia proident corned beef et. Beef ribs meatloaf rump short loin turkey nulla cow ex voluptate strip steak dolore occaecat. Esse quis excepteur sirloin reprehenderit lorem shoulder pastrami flank pig shank nisi short ribs bacon.\n\nExercitation voluptate capicola ut, fatback sed t-bone id. Mollit meatloaf pig meatball brisket ea sed shank cupim spare ribs magna kevin sirloin deserunt. Flank minim incididunt velit consequat. Laborum ground round filet mignon chicken officia. Capicola shankle dolore, veniam adipisicing reprehenderit ut est laborum pork chop. Pork rump cillum turkey, sausage salami non tongue ex t-bone minim duis lorem voluptate. Aute pariatur elit, est rump in corned beef cupidatat pork pig tri-tip culpa aliqua.\n\nBacon ipsum dolor amet duis meatball magna irure short loin, aliquip rump ipsum minim chuck pork loin picanha. Velit pancetta pariatur sed. Spare ribs cillum nostrud labore, pariatur commodo proident jerky in velit quis doner sunt. Porchetta andouille aute swine. Culpa ut chuck tri-tip.\n \nShort ribs voluptate deserunt swine, spare ribs in doner elit ipsum do tri-tip. Laboris esse aliquip, reprehenderit magna ea shoulder short loin. Chicken velit eu incididunt prosciutto labore nisi. Et shoulder landjaeger jerky officia corned beef anim. Ea ut brisket, leberkas doner pork belly velit consectetur corned beef ham hock laboris labore. Incididunt magna kevin est ground round labore adipisicing kielbasa deserunt consectetur porchetta. Et strip steak deserunt ullamco.\n\n<ol>\n<li>This is a list item </li>\n<li>And another</li>\n<li>One more list item</li>\n</ol>\n\nIrure ut ut jerky id voluptate. Dolore andouille pancetta chicken, deserunt jowl enim strip steak ea ball tip cillum ham. Dolore picanha in prosciutto esse porchetta ullamco salami cupim. Tri-tip non esse, veniam spare ribs pastrami bresaola fatback.\n \nTail t-bone andouille, aute rump elit culpa in sunt. Hamburger duis irure sint, laborum cillum ea officia proident corned beef et. Beef ribs meatloaf rump short loin turkey nulla cow ex voluptate strip steak dolore occaecat. Esse quis excepteur sirloin reprehenderit lorem shoulder pastrami flank pig shank nisi short ribs bacon.\n\n<ul>\n<li>This is a list item</li>\n<li>And another</li>\n<li>One more list item</li>\n</ul>\n\nExercitation voluptate capicola ut, fatback sed t-bone id. Mollit meatloaf pig meatball brisket ea sed shank cupim spare ribs magna kevin sirloin deserunt. Flank minim incididunt velit consequat. Laborum ground round filet mignon chicken officia. Capicola shankle dolore, veniam adipisicing reprehenderit ut est laborum pork chop. Pork rump cillum turkey, sausage salami non tongue ex t-bone minim duis lorem voluptate. Aute pariatur elit, est rump in corned beef cupidatat pork pig tri-tip culpa aliqua.', 'xhtml'),
(2, 6, 'Lorem ipsum dolor sit amet, <b>this is bold text</b> consectetur <strong>this text is strongly emphasized</strong> adipisicing elit, sed do eiusmod tempor incididunt <i>this is italic text</i> ut labore <em>this text is emphasized</em> et dolore magna aliqua. Ut enim ad minim veniam, <a href=\"\">this is a link</a> quis nostrud <a href=\"\" rel=\"external\">this is an external link</a> laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse <del>This text is deleted</del> <ins>this text is inserted</ins> cillum <code>this is a code sample</code> dolore eu <mark>this text is highlighted</mark> fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'xhtml'),
(3, 7, 'Lorem ipsum dolor sit amet, <b>this is bold text</b> consectetur <strong>this text is strongly emphasized</strong> adipisicing elit, sed do eiusmod tempor incididunt <i>this is italic text</i> ut labore <em>this text is emphasized</em> et dolore magna aliqua. Ut enim ad minim veniam, <a href=\"\">this is a link</a> quis nostrud <a href=\"\" rel=\"external\">this is an external link</a> laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse <del>This text is deleted</del> <ins>this text is inserted</ins> cillum <code>this is a code sample</code> dolore eu <mark>this text is highlighted</mark> fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'xhtml'),
(4, 8, 'Lorem ipsum dolor sit amet, <b>this is bold text</b> consectetur <strong>this text is strongly emphasized</strong> adipisicing elit, sed do eiusmod tempor incididunt <i>this is italic text</i> ut labore <em>this text is emphasized</em> et dolore magna aliqua. Ut enim ad minim veniam, <a href=\"\">this is a link</a> quis nostrud <a href=\"\" rel=\"external\">this is an external link</a> laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse <del>This text is deleted</del> <ins>this text is inserted</ins> cillum <code>this is a code sample</code> dolore eu <mark>this text is highlighted</mark> fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'xhtml'),
(5, 9, 'Lorem ipsum dolor sit amet, <b>this is bold text</b> consectetur <strong>this text is strongly emphasized</strong> adipisicing elit, sed do eiusmod tempor incididunt <i>this is italic text</i> ut labore <em>this text is emphasized</em> et dolore magna aliqua. Ut enim ad minim veniam, <a href=\"\">this is a link</a> quis nostrud <a href=\"\" rel=\"external\">this is an external link</a> laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse <del>This text is deleted</del> <ins>this text is inserted</ins> cillum <code>this is a code sample</code> dolore eu <mark>this text is highlighted</mark> fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'xhtml'),
(6, 10, 'Lorem ipsum dolor sit amet, <b>this is bold text</b> consectetur <strong>this text is strongly emphasized</strong> adipisicing elit, sed do eiusmod tempor incididunt <i>this is italic text</i> ut labore <em>this text is emphasized</em> et dolore magna aliqua. Ut enim ad minim veniam, <a href=\"\">this is a link</a> quis nostrud <a href=\"\" rel=\"external\">this is an external link</a> laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse <del>This text is deleted</del> <ins>this text is inserted</ins> cillum <code>this is a code sample</code> dolore eu <mark>this text is highlighted</mark> fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'xhtml'),
(7, 11, 'Bacon ipsum dolor amet duis meatball magna irure short loin, aliquip rump ipsum minim chuck pork loin picanha. Velit pancetta pariatur sed. Spare ribs cillum nostrud labore, pariatur commodo proident jerky in velit quis doner sunt. Porchetta andouille aute swine. Culpa ut chuck tri-tip.\n\n<blockquote>Short ribs voluptate deserunt swine, spare ribs in doner elit ipsum do tri-tip. Laboris esse aliquip, reprehenderit magna ea shoulder short loin. Chicken velit eu incididunt prosciutto labore nisi. Et shoulder landjaeger jerky officia corned beef anim. Ea ut brisket, leberkas doner pork belly velit consectetur corned beef ham hock laboris labore. Incididunt magna kevin est ground round labore adipisicing kielbasa deserunt consectetur porchetta. Et strip steak deserunt ullamco.</blockquote>\n\nLorem ipsum dolor sit amet, <b>this is bold text</b> consectetur <strong>this text is strongly emphasized</strong> adipisicing elit, sed do eiusmod tempor incididunt <i>this is italic text</i> ut labore <em>this text is emphasized</em> et dolore magna aliqua. Ut enim ad minim veniam, <a href=\"\">this is a link</a> quis nostrud <a href=\"\" rel=\"external\">this is an external link</a> laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse <del>This text is deleted</del> <ins>this text is inserted</ins> cillum <code>this is a code sample</code> dolore eu <mark>this text is highlighted</mark> fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n\nTail t-bone andouille, aute rump elit culpa in sunt. Hamburger duis irure sint, laborum cillum ea officia proident corned beef et. Beef ribs meatloaf rump short loin turkey nulla cow ex voluptate strip steak dolore occaecat. Esse quis excepteur sirloin reprehenderit lorem shoulder pastrami flank pig shank nisi short ribs bacon.\n\nExercitation voluptate capicola ut, fatback sed t-bone id. Mollit meatloaf pig meatball brisket ea sed shank cupim spare ribs magna kevin sirloin deserunt. Flank minim incididunt velit consequat. Laborum ground round filet mignon chicken officia. Capicola shankle dolore, veniam adipisicing reprehenderit ut est laborum pork chop. Pork rump cillum turkey, sausage salami non tongue ex t-bone minim duis lorem voluptate. Aute pariatur elit, est rump in corned beef cupidatat pork pig tri-tip culpa aliqua.\n\nBacon ipsum dolor amet duis meatball magna irure short loin, aliquip rump ipsum minim chuck pork loin picanha. Velit pancetta pariatur sed. Spare ribs cillum nostrud labore, pariatur commodo proident jerky in velit quis doner sunt. Porchetta andouille aute swine. Culpa ut chuck tri-tip.\n \nShort ribs voluptate deserunt swine, spare ribs in doner elit ipsum do tri-tip. Laboris esse aliquip, reprehenderit magna ea shoulder short loin. Chicken velit eu incididunt prosciutto labore nisi. Et shoulder landjaeger jerky officia corned beef anim. Ea ut brisket, leberkas doner pork belly velit consectetur corned beef ham hock laboris labore. Incididunt magna kevin est ground round labore adipisicing kielbasa deserunt consectetur porchetta. Et strip steak deserunt ullamco.\n\n<ol>\n<li>This is a list item </li>\n<li>And another</li>\n<li>One more list item</li>\n</ol>\n\nIrure ut ut jerky id voluptate. Dolore andouille pancetta chicken, deserunt jowl enim strip steak ea ball tip cillum ham. Dolore picanha in prosciutto esse porchetta ullamco salami cupim. Tri-tip non esse, veniam spare ribs pastrami bresaola fatback.\n \nTail t-bone andouille, aute rump elit culpa in sunt. Hamburger duis irure sint, laborum cillum ea officia proident corned beef et. Beef ribs meatloaf rump short loin turkey nulla cow ex voluptate strip steak dolore occaecat. Esse quis excepteur sirloin reprehenderit lorem shoulder pastrami flank pig shank nisi short ribs bacon.\n\n<ul>\n<li>This is a list item</li>\n<li>And another</li>\n<li>One more list item</li>\n</ul>\n\nExercitation voluptate capicola ut, fatback sed t-bone id. Mollit meatloaf pig meatball brisket ea sed shank cupim spare ribs magna kevin sirloin deserunt. Flank minim incididunt velit consequat. Laborum ground round filet mignon chicken officia. Capicola shankle dolore, veniam adipisicing reprehenderit ut est laborum pork chop. Pork rump cillum turkey, sausage salami non tongue ex t-bone minim duis lorem voluptate. Aute pariatur elit, est rump in corned beef cupidatat pork pig tri-tip culpa aliqua.', 'xhtml'),
(8, 12, 'Lorem ipsum dolor sit amet, <b>this is bold text</b> consectetur <strong>this text is strongly emphasized</strong> adipisicing elit, sed do eiusmod tempor incididunt <i>this is italic text</i> ut labore <em>this text is emphasized</em> et dolore magna aliqua. Ut enim ad minim veniam, <a href=\"\">this is a link</a> quis nostrud <a href=\"\" rel=\"external\">this is an external link</a> laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse <del>This text is deleted</del> <ins>this text is inserted</ins> cillum <code>this is a code sample</code> dolore eu <mark>this text is highlighted</mark> fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'xhtml');

INSERT INTO `exp_channel_data_field_7` (`id`, `entry_id`, `field_id_7`, `field_ft_7`) VALUES
(1, 5, NULL, 'xhtml'),
(2, 6, NULL, 'xhtml'),
(3, 7, NULL, 'xhtml'),
(4, 8, NULL, 'xhtml'),
(5, 9, NULL, 'xhtml'),
(6, 10, NULL, 'xhtml'),
(7, 11, NULL, 'xhtml'),
(8, 12, NULL, 'xhtml');

INSERT INTO `exp_channel_data_field_8` (`id`, `entry_id`, `field_id_8`, `field_ft_8`) VALUES
(1, 5, NULL, 'xhtml'),
(2, 6, NULL, 'xhtml'),
(3, 7, NULL, 'xhtml'),
(4, 8, NULL, 'xhtml'),
(5, 9, NULL, 'xhtml'),
(6, 10, NULL, 'xhtml'),
(7, 11, NULL, 'xhtml'),
(8, 12, NULL, 'xhtml');

INSERT INTO `exp_channel_data_field_9` (`id`, `entry_id`, `field_id_9`, `field_ft_9`) VALUES
(1, 1, 'Cupcake ipsum dolor sit. Amet I love liquorice jujubes pudding croissant I love pudding. Apple pie macaroon toffee jujubes pie tart cookie applicake caramels. Halvah macaroon I love lollipop. Wypas I love pudding brownie cheesecake tart jelly-o. Bear claw cookie chocolate bar jujubes toffee.', 'xhtml'),
(2, 2, 'Bacon ipsum dolor amet duis meatball magna irure short loin, aliquip rump ipsum minim chuck pork loin picanha. Velit pancetta pariatur sed. Spare ribs cillum nostrud labore, pariatur commodo proident jerky in velit quis doner sunt. Porchetta andouille aute swine. Culpa ut chuck tri-tip.\n\n<blockquote>Short ribs voluptate deserunt swine, spare ribs in doner elit ipsum do tri-tip. Laboris esse aliquip, reprehenderit magna ea shoulder short loin. Chicken velit eu incididunt prosciutto labore nisi. Et shoulder landjaeger jerky officia corned beef anim. Ea ut brisket, leberkas doner pork belly velit consectetur corned beef ham hock laboris labore. Incididunt magna kevin est ground round labore adipisicing kielbasa deserunt consectetur porchetta. Et strip steak deserunt ullamco.</blockquote>\n\nLorem ipsum dolor sit amet, <b>this is bold text</b> consectetur <strong>this text is strongly emphasized</strong> adipisicing elit, sed do eiusmod tempor incididunt <i>this is italic text</i> ut labore <em>this text is emphasized</em> et dolore magna aliqua. Ut enim ad minim veniam, <a href=\"\">this is a link</a> quis nostrud <a href=\"\" rel=\"external\">this is an external link</a> laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse <del>This text is deleted</del> <ins>this text is inserted</ins> cillum <code>this is a code sample</code> dolore eu <mark>this text is highlighted</mark> fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n\nTail t-bone andouille, aute rump elit culpa in sunt. Hamburger duis irure sint, laborum cillum ea officia proident corned beef et. Beef ribs meatloaf rump short loin turkey nulla cow ex voluptate strip steak dolore occaecat. Esse quis excepteur sirloin reprehenderit lorem shoulder pastrami flank pig shank nisi short ribs bacon.\n\nExercitation voluptate capicola ut, fatback sed t-bone id. Mollit meatloaf pig meatball brisket ea sed shank cupim spare ribs magna kevin sirloin deserunt. Flank minim incididunt velit consequat. Laborum ground round filet mignon chicken officia. Capicola shankle dolore, veniam adipisicing reprehenderit ut est laborum pork chop. Pork rump cillum turkey, sausage salami non tongue ex t-bone minim duis lorem voluptate. Aute pariatur elit, est rump in corned beef cupidatat pork pig tri-tip culpa aliqua.\n\nBacon ipsum dolor amet duis meatball magna irure short loin, aliquip rump ipsum minim chuck pork loin picanha. Velit pancetta pariatur sed. Spare ribs cillum nostrud labore, pariatur commodo proident jerky in velit quis doner sunt. Porchetta andouille aute swine. Culpa ut chuck tri-tip.\n \nShort ribs voluptate deserunt swine, spare ribs in doner elit ipsum do tri-tip. Laboris esse aliquip, reprehenderit magna ea shoulder short loin. Chicken velit eu incididunt prosciutto labore nisi. Et shoulder landjaeger jerky officia corned beef anim. Ea ut brisket, leberkas doner pork belly velit consectetur corned beef ham hock laboris labore. Incididunt magna kevin est ground round labore adipisicing kielbasa deserunt consectetur porchetta. Et strip steak deserunt ullamco.\n\n<ol>\n<li>This is a list item </li>\n<li>And another</li>\n<li>One more list item</li>\n</ol>\n\nIrure ut ut jerky id voluptate. Dolore andouille pancetta chicken, deserunt jowl enim strip steak ea ball tip cillum ham. Dolore picanha in prosciutto esse porchetta ullamco salami cupim. Tri-tip non esse, veniam spare ribs pastrami bresaola fatback.\n \nTail t-bone andouille, aute rump elit culpa in sunt. Hamburger duis irure sint, laborum cillum ea officia proident corned beef et. Beef ribs meatloaf rump short loin turkey nulla cow ex voluptate strip steak dolore occaecat. Esse quis excepteur sirloin reprehenderit lorem shoulder pastrami flank pig shank nisi short ribs bacon.\n\n<ul>\n<li>This is a list item</li>\n<li>And another</li>\n<li>One more list item</li>\n</ul>\n\nExercitation voluptate capicola ut, fatback sed t-bone id. Mollit meatloaf pig meatball brisket ea sed shank cupim spare ribs magna kevin sirloin deserunt. Flank minim incididunt velit consequat. Laborum ground round filet mignon chicken officia. Capicola shankle dolore, veniam adipisicing reprehenderit ut est laborum pork chop. Pork rump cillum turkey, sausage salami non tongue ex t-bone minim duis lorem voluptate. Aute pariatur elit, est rump in corned beef cupidatat pork pig tri-tip culpa aliqua.', 'xhtml'),
(3, 3, 'Bacon ipsum dolor amet duis meatball magna irure short loin, aliquip rump ipsum minim chuck pork loin picanha. Velit pancetta pariatur sed. Spare ribs cillum nostrud labore, pariatur commodo proident jerky in velit quis doner sunt. Porchetta andouille aute swine. Culpa ut chuck tri-tip.\n\n<blockquote>Short ribs voluptate deserunt swine, spare ribs in doner elit ipsum do tri-tip. Laboris esse aliquip, reprehenderit magna ea shoulder short loin. Chicken velit eu incididunt prosciutto labore nisi. Et shoulder landjaeger jerky officia corned beef anim. Ea ut brisket, leberkas doner pork belly velit consectetur corned beef ham hock laboris labore. Incididunt magna kevin est ground round labore adipisicing kielbasa deserunt consectetur porchetta. Et strip steak deserunt ullamco.</blockquote>\n\nLorem ipsum dolor sit amet, <b>this is bold text</b> consectetur <strong>this text is strongly emphasized</strong> adipisicing elit, sed do eiusmod tempor incididunt <i>this is italic text</i> ut labore <em>this text is emphasized</em> et dolore magna aliqua. Ut enim ad minim veniam, <a href=\"\">this is a link</a> quis nostrud <a href=\"\" rel=\"external\">this is an external link</a> laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse <del>This text is deleted</del> <ins>this text is inserted</ins> cillum <code>this is a code sample</code> dolore eu <mark>this text is highlighted</mark> fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n\nTail t-bone andouille, aute rump elit culpa in sunt. Hamburger duis irure sint, laborum cillum ea officia proident corned beef et. Beef ribs meatloaf rump short loin turkey nulla cow ex voluptate strip steak dolore occaecat. Esse quis excepteur sirloin reprehenderit lorem shoulder pastrami flank pig shank nisi short ribs bacon.\n\nExercitation voluptate capicola ut, fatback sed t-bone id. Mollit meatloaf pig meatball brisket ea sed shank cupim spare ribs magna kevin sirloin deserunt. Flank minim incididunt velit consequat. Laborum ground round filet mignon chicken officia. Capicola shankle dolore, veniam adipisicing reprehenderit ut est laborum pork chop. Pork rump cillum turkey, sausage salami non tongue ex t-bone minim duis lorem voluptate. Aute pariatur elit, est rump in corned beef cupidatat pork pig tri-tip culpa aliqua.\n\nBacon ipsum dolor amet duis meatball magna irure short loin, aliquip rump ipsum minim chuck pork loin picanha. Velit pancetta pariatur sed. Spare ribs cillum nostrud labore, pariatur commodo proident jerky in velit quis doner sunt. Porchetta andouille aute swine. Culpa ut chuck tri-tip.\n \nShort ribs voluptate deserunt swine, spare ribs in doner elit ipsum do tri-tip. Laboris esse aliquip, reprehenderit magna ea shoulder short loin. Chicken velit eu incididunt prosciutto labore nisi. Et shoulder landjaeger jerky officia corned beef anim. Ea ut brisket, leberkas doner pork belly velit consectetur corned beef ham hock laboris labore. Incididunt magna kevin est ground round labore adipisicing kielbasa deserunt consectetur porchetta. Et strip steak deserunt ullamco.\n\n<ol>\n<li>This is a list item </li>\n<li>And another</li>\n<li>One more list item</li>\n</ol>\n\nIrure ut ut jerky id voluptate. Dolore andouille pancetta chicken, deserunt jowl enim strip steak ea ball tip cillum ham. Dolore picanha in prosciutto esse porchetta ullamco salami cupim. Tri-tip non esse, veniam spare ribs pastrami bresaola fatback.\n \nTail t-bone andouille, aute rump elit culpa in sunt. Hamburger duis irure sint, laborum cillum ea officia proident corned beef et. Beef ribs meatloaf rump short loin turkey nulla cow ex voluptate strip steak dolore occaecat. Esse quis excepteur sirloin reprehenderit lorem shoulder pastrami flank pig shank nisi short ribs bacon.\n\n<ul>\n<li>This is a list item</li>\n<li>And another</li>\n<li>One more list item</li>\n</ul>\n\nExercitation voluptate capicola ut, fatback sed t-bone id. Mollit meatloaf pig meatball brisket ea sed shank cupim spare ribs magna kevin sirloin deserunt. Flank minim incididunt velit consequat. Laborum ground round filet mignon chicken officia. Capicola shankle dolore, veniam adipisicing reprehenderit ut est laborum pork chop. Pork rump cillum turkey, sausage salami non tongue ex t-bone minim duis lorem voluptate. Aute pariatur elit, est rump in corned beef cupidatat pork pig tri-tip culpa aliqua.', 'xhtml'),
(4, 4, 'Bacon ipsum dolor amet duis meatball magna irure short loin, aliquip rump ipsum minim chuck pork loin picanha. Velit pancetta pariatur sed. Spare ribs cillum nostrud labore, pariatur commodo proident jerky in velit quis doner sunt. Porchetta andouille aute swine. Culpa ut chuck tri-tip.\n\n<blockquote>Short ribs voluptate deserunt swine, spare ribs in doner elit ipsum do tri-tip. Laboris esse aliquip, reprehenderit magna ea shoulder short loin. Chicken velit eu incididunt prosciutto labore nisi. Et shoulder landjaeger jerky officia corned beef anim. Ea ut brisket, leberkas doner pork belly velit consectetur corned beef ham hock laboris labore. Incididunt magna kevin est ground round labore adipisicing kielbasa deserunt consectetur porchetta. Et strip steak deserunt ullamco.</blockquote>\n\nLorem ipsum dolor sit amet, <b>this is bold text</b> consectetur <strong>this text is strongly emphasized</strong> adipisicing elit, sed do eiusmod tempor incididunt <i>this is italic text</i> ut labore <em>this text is emphasized</em> et dolore magna aliqua. Ut enim ad minim veniam, <a href=\"\">this is a link</a> quis nostrud <a href=\"\" rel=\"external\">this is an external link</a> laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse <del>This text is deleted</del> <ins>this text is inserted</ins> cillum <code>this is a code sample</code> dolore eu <mark>this text is highlighted</mark> fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n\nTail t-bone andouille, aute rump elit culpa in sunt. Hamburger duis irure sint, laborum cillum ea officia proident corned beef et. Beef ribs meatloaf rump short loin turkey nulla cow ex voluptate strip steak dolore occaecat. Esse quis excepteur sirloin reprehenderit lorem shoulder pastrami flank pig shank nisi short ribs bacon.\n\nExercitation voluptate capicola ut, fatback sed t-bone id. Mollit meatloaf pig meatball brisket ea sed shank cupim spare ribs magna kevin sirloin deserunt. Flank minim incididunt velit consequat. Laborum ground round filet mignon chicken officia. Capicola shankle dolore, veniam adipisicing reprehenderit ut est laborum pork chop. Pork rump cillum turkey, sausage salami non tongue ex t-bone minim duis lorem voluptate. Aute pariatur elit, est rump in corned beef cupidatat pork pig tri-tip culpa aliqua.\n\nBacon ipsum dolor amet duis meatball magna irure short loin, aliquip rump ipsum minim chuck pork loin picanha. Velit pancetta pariatur sed. Spare ribs cillum nostrud labore, pariatur commodo proident jerky in velit quis doner sunt. Porchetta andouille aute swine. Culpa ut chuck tri-tip.\n \nShort ribs voluptate deserunt swine, spare ribs in doner elit ipsum do tri-tip. Laboris esse aliquip, reprehenderit magna ea shoulder short loin. Chicken velit eu incididunt prosciutto labore nisi. Et shoulder landjaeger jerky officia corned beef anim. Ea ut brisket, leberkas doner pork belly velit consectetur corned beef ham hock laboris labore. Incididunt magna kevin est ground round labore adipisicing kielbasa deserunt consectetur porchetta. Et strip steak deserunt ullamco.\n\n<ol>\n<li>This is a list item </li>\n<li>And another</li>\n<li>One more list item</li>\n</ol>\n\nIrure ut ut jerky id voluptate. Dolore andouille pancetta chicken, deserunt jowl enim strip steak ea ball tip cillum ham. Dolore picanha in prosciutto esse porchetta ullamco salami cupim. Tri-tip non esse, veniam spare ribs pastrami bresaola fatback.\n \nTail t-bone andouille, aute rump elit culpa in sunt. Hamburger duis irure sint, laborum cillum ea officia proident corned beef et. Beef ribs meatloaf rump short loin turkey nulla cow ex voluptate strip steak dolore occaecat. Esse quis excepteur sirloin reprehenderit lorem shoulder pastrami flank pig shank nisi short ribs bacon.\n\n<ul>\n<li>This is a list item</li>\n<li>And another</li>\n<li>One more list item</li>\n</ul>\n\nExercitation voluptate capicola ut, fatback sed t-bone id. Mollit meatloaf pig meatball brisket ea sed shank cupim spare ribs magna kevin sirloin deserunt. Flank minim incididunt velit consequat. Laborum ground round filet mignon chicken officia. Capicola shankle dolore, veniam adipisicing reprehenderit ut est laborum pork chop. Pork rump cillum turkey, sausage salami non tongue ex t-bone minim duis lorem voluptate. Aute pariatur elit, est rump in corned beef cupidatat pork pig tri-tip culpa aliqua.', 'xhtml');

INSERT INTO `exp_channel_entry_hidden_fields` (`entry_id`, `field_id`) VALUES
(2, 1);

INSERT INTO `exp_channel_field_groups_fields` (`field_id`, `group_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 2),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 4),
(10, 5),
(11, 5),
(12, 6),
(13, 6),
(14, 6),
(15, 6),
(16, 6),
(17, 6),
(18, 6),
(19, 6),
(20, 6),
(21, 6),
(22, 6),
(23, 6),
(24, 6),
(25, 6),
(26, 6),
(27, 6),
(28, 6),
(29, 6),
(30, 6),
(31, 6),
(32, 6),
(33, 6),
(34, 6),
(35, 6);

INSERT INTO `exp_channel_fields` (`field_id`, `site_id`, `field_name`, `field_label`, `field_instructions`, `field_type`, `field_list_items`, `field_pre_populate`, `field_pre_channel_id`, `field_pre_field_id`, `field_ta_rows`, `field_maxl`, `field_required`, `field_text_direction`, `field_search`, `field_is_hidden`, `field_is_conditional`, `field_fmt`, `field_show_fmt`, `field_order`, `field_content_type`, `field_settings`, `legacy_field_data`, `enable_frontedit`) VALUES
(1, 0, 'contact_email', 'Contact Email', 'Email address someone can send Email to.', 'text', '', 'n', NULL, NULL, 8, 256, 'n', 'ltr', 'n', 'n', 'n', 'none', 'y', 6, '', 'YTo0OntzOjEwOiJmaWVsZF9tYXhsIjtpOjI1NjtzOjE4OiJmaWVsZF9jb250ZW50X3R5cGUiO3M6MDoiIjtzOjE4OiJmaWVsZF9zaG93X3NtaWxleXMiO3M6MToibiI7czoyNDoiZmllbGRfc2hvd19maWxlX3NlbGVjdG9yIjtzOjE6Im4iO30=', 'n', 'y'),
(2, 0, 'contact_phone', 'Contact Phone', 'Phone number someone can call.', 'text', '', 'n', NULL, NULL, 8, 256, 'n', 'ltr', 'n', 'n', 'n', 'none', 'y', 5, '', 'YTo0OntzOjEwOiJmaWVsZF9tYXhsIjtpOjI1NjtzOjE4OiJmaWVsZF9jb250ZW50X3R5cGUiO3M6MDoiIjtzOjE4OiJmaWVsZF9zaG93X3NtaWxleXMiO3M6MToibiI7czoyNDoiZmllbGRfc2hvd19maWxlX3NlbGVjdG9yIjtzOjE6Im4iO30=', 'n', 'y'),
(3, 0, 'contact_address', 'Contact Address', 'Address where someone can send mail.', 'grid', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 4, 'any', 'YTo0OntzOjEzOiJncmlkX21pbl9yb3dzIjtpOjA7czoxMzoiZ3JpZF9tYXhfcm93cyI7czowOiIiO3M6MTM6ImFsbG93X3Jlb3JkZXIiO3M6MToieSI7czoxNToidmVydGljYWxfbGF5b3V0IjtzOjE6Im4iO30=', 'n', 'y'),
(4, 0, 'about_image', 'About Image', 'Image for the about page.', 'grid', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 7, 'any', 'YTo0OntzOjEzOiJncmlkX21pbl9yb3dzIjtpOjA7czoxMzoiZ3JpZF9tYXhfcm93cyI7czowOiIiO3M6MTM6ImFsbG93X3Jlb3JkZXIiO3M6MToieSI7czoxNToidmVydGljYWxfbGF5b3V0IjtzOjE6Im4iO30=', 'n', 'y'),
(5, 0, 'blog_video', 'Video', 'Video for this blog.', 'grid', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 2, 'any', 'YTo0OntzOjEzOiJncmlkX21pbl9yb3dzIjtpOjA7czoxMzoiZ3JpZF9tYXhfcm93cyI7czowOiIiO3M6MTM6ImFsbG93X3Jlb3JkZXIiO3M6MToieSI7czoxNToidmVydGljYWxfbGF5b3V0IjtzOjE6Im4iO30=', 'n', 'y'),
(6, 0, 'blog_content', 'Content', 'Content for this blog entry.', 'textarea', '', 'n', NULL, NULL, 10, NULL, 'n', 'ltr', 'y', 'n', 'n', 'xhtml', 'y', 1, 'any', 'YTo0OntzOjI0OiJmaWVsZF9zaG93X2ZpbGVfc2VsZWN0b3IiO3M6MToibiI7czoxNDoiZGJfY29sdW1uX3R5cGUiO3M6NDoidGV4dCI7czoxODoiZmllbGRfc2hvd19zbWlsZXlzIjtzOjE6Im4iO3M6MjY6ImZpZWxkX3Nob3dfZm9ybWF0dGluZ19idG5zIjtzOjE6Im4iO30=', 'n', 'y'),
(7, 0, 'blog_image', 'Image', 'Photograph, comic, any image you like.', 'grid', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 4, 'any', 'YTo0OntzOjEzOiJncmlkX21pbl9yb3dzIjtpOjA7czoxMzoiZ3JpZF9tYXhfcm93cyI7czowOiIiO3M6MTM6ImFsbG93X3Jlb3JkZXIiO3M6MToieSI7czoxNToidmVydGljYWxfbGF5b3V0IjtzOjE6Im4iO30=', 'n', 'y'),
(8, 0, 'blog_audio', 'Audio', 'Audio clip for this blog.', 'grid', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 3, 'any', 'YTo0OntzOjEzOiJncmlkX21pbl9yb3dzIjtpOjA7czoxMzoiZ3JpZF9tYXhfcm93cyI7czowOiIiO3M6MTM6ImFsbG93X3Jlb3JkZXIiO3M6MToieSI7czoxNToidmVydGljYWxfbGF5b3V0IjtzOjE6Im4iO30=', 'n', 'y'),
(9, 0, 'page_content', 'Page Content', 'Content for this page.', 'textarea', '', 'n', NULL, NULL, 10, NULL, 'n', 'ltr', 'y', 'n', 'n', 'xhtml', 'y', 3, 'any', 'YTo0OntzOjI0OiJmaWVsZF9zaG93X2ZpbGVfc2VsZWN0b3IiO3M6MToibiI7czoxNDoiZGJfY29sdW1uX3R5cGUiO3M6NDoidGV4dCI7czoxODoiZmllbGRfc2hvd19zbWlsZXlzIjtzOjE6Im4iO3M6MjY6ImZpZWxkX3Nob3dfZm9ybWF0dGluZ19idG5zIjtzOjE6Im4iO30=', 'n', 'y'),
(10, 0, 'seo_title', 'SEO Title', 'Page title that will be added to browser titlebar/tab.', 'text', '', 'n', NULL, NULL, 8, 256, 'n', 'ltr', 'n', 'n', 'n', 'none', 'y', 5, '', 'YTo0OntzOjEwOiJmaWVsZF9tYXhsIjtpOjI1NjtzOjE4OiJmaWVsZF9jb250ZW50X3R5cGUiO3M6MDoiIjtzOjE4OiJmaWVsZF9zaG93X3NtaWxleXMiO3M6MToibiI7czoyNDoiZmllbGRfc2hvd19maWxlX3NlbGVjdG9yIjtzOjE6Im4iO30=', 'n', 'y'),
(11, 0, 'seo_desc', 'SEO Description', 'Page Description for use in HTML meta description tag, generally only seen by machines.', 'textarea', '', 'n', NULL, NULL, 2, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 6, 'any', 'YTo0OntzOjI0OiJmaWVsZF9zaG93X2ZpbGVfc2VsZWN0b3IiO3M6MToibiI7czoxNDoiZGJfY29sdW1uX3R5cGUiO3M6NDoidGV4dCI7czoxODoiZmllbGRfc2hvd19zbWlsZXlzIjtzOjE6Im4iO3M6MjY6ImZpZWxkX3Nob3dfZm9ybWF0dGluZ19idG5zIjtzOjE6Im4iO30=', 'n', 'y'),
(12, 0, 'test_checkboxes', 'test_checkboxes', '', 'checkboxes', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'none', 'y', 12, 'any', 'YToxOntzOjE3OiJ2YWx1ZV9sYWJlbF9wYWlycyI7YTozOntzOjM6Im9uZSI7czozOiJPbmUiO3M6MzoidHdvIjtzOjM6IlR3byI7czo1OiJ0aHJlZSI7czo1OiJUaHJlZSI7fX0=', 'n', 'y'),
(13, 0, 'test_colorpicker', 'test_colorpicker', '', 'colorpicker', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 13, 'any', 'YTo1OntzOjE0OiJhbGxvd2VkX2NvbG9ycyI7czozOiJhbnkiO3M6MjU6ImNvbG9ycGlja2VyX2RlZmF1bHRfY29sb3IiO3M6NzoiI0ZGMDAwMCI7czoxNDoidmFsdWVfc3dhdGNoZXMiO2E6MDp7fXM6MTU6Im1hbnVhbF9zd2F0Y2hlcyI7czowOiIiO3M6MTc6InBvcHVsYXRlX3N3YXRjaGVzIjtzOjE6InYiO30=', 'n', 'y'),
(14, 0, 'test_date', 'test_date', '', 'date', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 14, 'any', 'YTowOnt9', 'n', 'y'),
(15, 0, 'test_duration', 'test_duration', '', 'duration', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 15, 'any', 'YToxOntzOjU6InVuaXRzIjtzOjc6Im1pbnV0ZXMiO30=', 'n', 'y'),
(16, 0, 'test_email', 'test_email', '', 'email_address', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 16, 'any', 'YTowOnt9', 'n', 'y'),
(17, 0, 'test_file', 'test_file', '', 'file', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'none', 'y', 17, 'all', 'YTo1OntzOjE4OiJmaWVsZF9jb250ZW50X3R5cGUiO3M6MzoiYWxsIjtzOjE5OiJhbGxvd2VkX2RpcmVjdG9yaWVzIjtzOjM6ImFsbCI7czoxMzoic2hvd19leGlzdGluZyI7czoxOiJ5IjtzOjEyOiJudW1fZXhpc3RpbmciO3M6MjoiNTAiO3M6OToiZmllbGRfZm10IjtzOjQ6Im5vbmUiO30=', 'n', 'y'),
(18, 0, 'test_file_grid', 'test_file_grid', '', 'file_grid', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 18, 'image', 'YTo2OntzOjEzOiJncmlkX21pbl9yb3dzIjtpOjA7czoxMzoiZ3JpZF9tYXhfcm93cyI7czowOiIiO3M6MTM6ImFsbG93X3Jlb3JkZXIiO3M6MToieSI7czoxNToidmVydGljYWxfbGF5b3V0IjtzOjE6Im4iO3M6MTg6ImZpZWxkX2NvbnRlbnRfdHlwZSI7czo1OiJpbWFnZSI7czoxOToiYWxsb3dlZF9kaXJlY3RvcmllcyI7czozOiJhbGwiO30=', 'n', 'y'),
(19, 0, 'test_fluid', 'test_fluid', '', 'fluid_field', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 19, 'any', 'YToxOntzOjIwOiJmaWVsZF9jaGFubmVsX2ZpZWxkcyI7YTo2OntpOjA7czoyOiIxMiI7aToxO3M6MjoiMTQiO2k6MjtzOjI6IjE4IjtpOjM7czoyOiIyMCI7aTo0O3M6MjoiMjciO2k6NTtzOjI6IjMyIjt9fQ==', 'n', 'y'),
(20, 0, 'test_grid', 'test_grid', '', 'grid', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 20, 'any', 'YTo0OntzOjEzOiJncmlkX21pbl9yb3dzIjtpOjA7czoxMzoiZ3JpZF9tYXhfcm93cyI7czowOiIiO3M6MTM6ImFsbG93X3Jlb3JkZXIiO3M6MToieSI7czoxNToidmVydGljYWxfbGF5b3V0IjtzOjE6Im4iO30=', 'n', 'y'),
(21, 0, 'test_multi_select', 'test_multi_select', '', 'multi_select', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'none', 'y', 21, 'any', 'YToxOntzOjE3OiJ2YWx1ZV9sYWJlbF9wYWlycyI7YTozOntzOjM6Ik9uZSI7czozOiJvbmUiO3M6MzoiVHdvIjtzOjM6InR3byI7czo1OiJUaHJlZSI7czo1OiJ0aHJlZSI7fX0=', 'n', 'y'),
(22, 0, 'test_notes', 'test_notes', '', 'notes', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 22, 'any', 'YTozOntzOjEyOiJub3RlX2NvbnRlbnQiO3M6MDoiIjtzOjE2OiJmaWVsZF9oaWRlX3RpdGxlIjtiOjE7czozNDoiZmllbGRfaGlkZV9wdWJsaXNoX2xheW91dF9jb2xsYXBzZSI7YjoxO30=', 'n', 'y'),
(23, 0, 'test_number_input', 'test_number_input', '', 'number', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 23, 'numeric', 'YTo1OntzOjE1OiJmaWVsZF9taW5fdmFsdWUiO3M6MDoiIjtzOjE1OiJmaWVsZF9tYXhfdmFsdWUiO3M6MDoiIjtzOjEwOiJmaWVsZF9zdGVwIjtzOjA6IiI7czoxNDoiZGF0YWxpc3RfaXRlbXMiO3M6MDoiIjtzOjE4OiJmaWVsZF9jb250ZW50X3R5cGUiO3M6NzoibnVtZXJpYyI7fQ==', 'n', 'y'),
(24, 0, 'test_radio_buttons', 'test_radio_buttons', '', 'radio', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'none', 'y', 24, 'any', 'YToxOntzOjE3OiJ2YWx1ZV9sYWJlbF9wYWlycyI7YTozOntzOjM6Im9uZSI7czozOiJPbmUiO3M6MzoidHdvIjtzOjM6IlR3byI7czo1OiJ0aHJlZSI7czo1OiJUaHJlZSI7fX0=', 'n', 'y'),
(25, 0, 'test_range_slider', 'test_range_slider', '', 'range_slider', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 25, 'all', 'YTo3OntzOjE1OiJmaWVsZF9taW5fdmFsdWUiO3M6MToiMCI7czoxNToiZmllbGRfbWF4X3ZhbHVlIjtzOjM6IjEwMCI7czoxMDoiZmllbGRfc3RlcCI7czoxOiIxIjtzOjEyOiJmaWVsZF9wcmVmaXgiO3M6MDoiIjtzOjEyOiJmaWVsZF9zdWZmaXgiO3M6MDoiIjtzOjE0OiJkYXRhbGlzdF9pdGVtcyI7czowOiIiO3M6MTg6ImZpZWxkX2NvbnRlbnRfdHlwZSI7czozOiJhbGwiO30=', 'n', 'y'),
(26, 0, 'test_relationships', 'test_relationships', '', 'relationship', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 26, 'any', 'YToxNDp7czo4OiJjaGFubmVscyI7YTowOnt9czo3OiJleHBpcmVkIjtzOjA6IiI7czo2OiJmdXR1cmUiO3M6MDoiIjtzOjEwOiJjYXRlZ29yaWVzIjthOjA6e31zOjc6ImF1dGhvcnMiO2E6MDp7fXM6ODoic3RhdHVzZXMiO2E6MDp7fXM6NToibGltaXQiO3M6MzoiMTAwIjtzOjExOiJvcmRlcl9maWVsZCI7czo1OiJ0aXRsZSI7czo5OiJvcmRlcl9kaXIiO3M6MzoiYXNjIjtzOjE2OiJkaXNwbGF5X2VudHJ5X2lkIjtiOjA7czoxNjoiZGVmZXJyZWRfbG9hZGluZyI7YjowO3M6MTQ6ImFsbG93X211bHRpcGxlIjtiOjE7czo3OiJyZWxfbWluIjtzOjE6IjAiO3M6NzoicmVsX21heCI7czowOiIiO30=', 'n', 'y'),
(27, 0, 'test_rich_text_editor', 'test_rich_text_editor', '', 'rte', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'none', 'n', 27, 'any', 'YTo2OntzOjEwOiJ0b29sc2V0X2lkIjtzOjE6IjEiO3M6NToiZGVmZXIiO3M6MToibiI7czoxNDoiZGJfY29sdW1uX3R5cGUiO3M6NDoidGV4dCI7czoxMDoiZmllbGRfd2lkZSI7YjoxO3M6OToiZmllbGRfZm10IjtzOjQ6Im5vbmUiO3M6MTQ6ImZpZWxkX3Nob3dfZm10IjtzOjE6Im4iO30=', 'n', 'y'),
(28, 0, 'test_select_dropdown', 'test_select_dropdown', '', 'select', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'none', 'y', 28, 'any', 'YToxOntzOjE3OiJ2YWx1ZV9sYWJlbF9wYWlycyI7YTozOntzOjM6Im9uZSI7czozOiJPbmUiO3M6MzoidHdvIjtzOjM6IlR3byI7czo1OiJ0aHJlZSI7czo1OiJUaHJlZSI7fX0=', 'n', 'y'),
(29, 0, 'test_selectable_buttons', 'test_selectable_buttons', '', 'selectable_buttons', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'none', 'y', 29, 'any', 'YToyOntzOjE3OiJ2YWx1ZV9sYWJlbF9wYWlycyI7YTozOntzOjM6Im9uZSI7czozOiJPbmUiO3M6MzoidHdvIjtzOjM6IlR3byI7czo1OiJ0aHJlZSI7czo1OiJUaHJlZSI7fXM6MTQ6ImFsbG93X211bHRpcGxlIjtiOjA7fQ==', 'n', 'y'),
(30, 0, 'test_structure', 'test_structure', '', 'structure', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 30, 'any', 'YToxOntzOjE5OiJzdHJ1Y3R1cmVfbGlzdF90eXBlIjtzOjU6InBhZ2VzIjt9', 'n', 'y'),
(31, 0, 'test_text_input', 'test_text_input', '', 'text', '', 'n', NULL, NULL, 8, 0, 'n', 'ltr', 'n', 'n', 'n', 'none', 'n', 31, 'all', 'YTo0OntzOjEwOiJmaWVsZF9tYXhsIjtzOjE6IjAiO3M6MTg6ImZpZWxkX2NvbnRlbnRfdHlwZSI7czozOiJhbGwiO3M6MTg6ImZpZWxkX3Nob3dfc21pbGV5cyI7czoxOiJuIjtzOjI0OiJmaWVsZF9zaG93X2ZpbGVfc2VsZWN0b3IiO3M6MDoiIjt9', 'n', 'y'),
(32, 0, 'test_textarea', 'test_textarea', '', 'textarea', '', 'n', NULL, NULL, 0, NULL, 'n', 'ltr', 'n', 'n', 'n', 'none', 'n', 32, 'any', 'YTo0OntzOjI0OiJmaWVsZF9zaG93X2ZpbGVfc2VsZWN0b3IiO3M6MDoiIjtzOjE0OiJkYl9jb2x1bW5fdHlwZSI7czo0OiJ0ZXh0IjtzOjE4OiJmaWVsZF9zaG93X3NtaWxleXMiO3M6MToibiI7czoyNjoiZmllbGRfc2hvd19mb3JtYXR0aW5nX2J0bnMiO3M6MDoiIjt9', 'n', 'y'),
(33, 0, 'test_toggle', 'test_toggle', '', 'toggle', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 33, 'any', 'YToxOntzOjE5OiJmaWVsZF9kZWZhdWx0X3ZhbHVlIjtzOjE6IjAiO30=', 'n', 'y'),
(34, 0, 'test_url', 'test_url', '', 'url', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 34, 'any', 'YToyOntzOjE5OiJhbGxvd2VkX3VybF9zY2hlbWVzIjthOjI6e2k6MDtzOjc6Imh0dHA6Ly8iO2k6MTtzOjg6Imh0dHBzOi8vIjt9czoyMjoidXJsX3NjaGVtZV9wbGFjZWhvbGRlciI7czo3OiJodHRwOi8vIjt9', 'n', 'y'),
(35, 0, 'test_value_slider', 'test_value_slider', '', 'slider', '', 'n', NULL, NULL, 8, NULL, 'n', 'ltr', 'n', 'n', 'n', 'xhtml', 'y', 35, 'numeric', 'YTo3OntzOjE1OiJmaWVsZF9taW5fdmFsdWUiO3M6MToiMCI7czoxNToiZmllbGRfbWF4X3ZhbHVlIjtzOjM6IjEwMCI7czoxMDoiZmllbGRfc3RlcCI7czoxOiIxIjtzOjEyOiJmaWVsZF9wcmVmaXgiO3M6MDoiIjtzOjEyOiJmaWVsZF9zdWZmaXgiO3M6MDoiIjtzOjE0OiJkYXRhbGlzdF9pdGVtcyI7czowOiIiO3M6MTg6ImZpZWxkX2NvbnRlbnRfdHlwZSI7czo3OiJudW1lcmljIjt9', 'n', 'y');

INSERT INTO `exp_channel_form_settings` (`channel_form_settings_id`, `site_id`, `channel_id`, `default_status`, `allow_guest_posts`, `default_author`) VALUES
(1, 1, 4, '', 'n', 1);

INSERT INTO `exp_channel_grid_field_18` (`row_id`, `entry_id`, `row_order`, `fluid_field_data_id`, `col_id_15`, `col_id_16`) VALUES
(1, 13, 0, 0, '{file:1:url}', 'Col Text');

INSERT INTO `exp_channel_grid_field_20` (`row_id`, `entry_id`, `row_order`, `fluid_field_data_id`, `col_id_17`) VALUES
(1, 13, 0, 0, 'one'),
(2, 13, 1, 0, 'two'),
(3, 13, 2, 0, 'three'),
(4, 13, 0, 5, 'Row 1'),
(5, 13, 1, 5, 'Row 2'),
(6, 13, 0, 6, 'Test grid row one'),
(7, 13, 1, 6, 'Test grid row two');

INSERT INTO `exp_channel_grid_field_3` (`row_id`, `entry_id`, `row_order`, `fluid_field_data_id`, `col_id_1`, `col_id_2`, `col_id_3`, `col_id_4`, `col_id_5`) VALUES
(1, 1, 0, 0, '1234 Any Street', 'Suite 2', 'Anywhere', 'ES', '12345');

INSERT INTO `exp_channel_grid_field_4` (`row_id`, `entry_id`, `row_order`, `fluid_field_data_id`, `col_id_6`, `col_id_7`, `col_id_8`) VALUES
(1, 2, 0, 0, '{filedir_5}common.jpg', 'Dharmafrog, 2014', 'right'),
(2, 3, 0, 0, '{filedir_5}common.jpg', 'Dharmafrog, 2014', 'left'),
(3, 4, 0, 0, '{filedir_5}common.jpg', 'Dharmafrog, 2014', 'none');

INSERT INTO `exp_channel_grid_field_5` (`row_id`, `entry_id`, `row_order`, `fluid_field_data_id`, `col_id_9`, `col_id_10`) VALUES
(1, 7, 0, 0, '113439313', 'vimeo'),
(2, 8, 0, 0, 'eCNwxqP7l44', 'youtube');

INSERT INTO `exp_channel_grid_field_7` (`row_id`, `entry_id`, `row_order`, `fluid_field_data_id`, `col_id_11`, `col_id_12`) VALUES
(1, 9, 0, 0, '{filedir_4}blog.jpg', 'Dharmafrog, 2014');

INSERT INTO `exp_channel_grid_field_8` (`row_id`, `entry_id`, `row_order`, `fluid_field_data_id`, `col_id_13`, `col_id_14`) VALUES
(1, 6, 0, 0, '3925868830', 'bandcamp'),
(2, 12, 0, 0, '164768245', 'soundcloud');

INSERT INTO `exp_channel_titles` (`entry_id`, `site_id`, `channel_id`, `author_id`, `forum_topic_id`, `ip_address`, `title`, `url_title`, `status`, `status_id`, `versioning_enabled`, `view_count_one`, `view_count_two`, `view_count_three`, `view_count_four`, `allow_comments`, `sticky`, `entry_date`, `year`, `month`, `day`, `expiration_date`, `comment_expiration_date`, `edit_date`, `recent_comment_date`, `comment_total`) VALUES
(1, 1, 3, 1, NULL, '127.0.0.1', 'Contact Us', 'contact-us', 'open', 1, 'n', 0, 0, 0, 0, 'y', 'n', 1666304930, '2022', '10', '20', 0, 0, 1666304930, NULL, 0),
(2, 1, 1, 1, NULL, '127.0.0.1', 'About Default Theme', 'about-default-theme', 'Default Page', 3, 'n', 0, 0, 0, 0, 'y', 'n', 1666304880, '2022', '10', '20', 0, 0, 1668090787, NULL, 0),
(3, 1, 1, 1, NULL, '127.0.0.1', 'Sub Page One', 'sub-page-one', 'open', 1, 'n', 0, 0, 0, 0, 'y', 'n', 1666304880, '2022', '10', '20', 0, 0, 1668028739, NULL, 0),
(4, 1, 1, 1, NULL, '127.0.0.1', 'Sub Page Two', 'sub-page-two', 'open', 1, 'n', 0, 0, 0, 0, 'y', 'n', 1666304880, '2022', '10', '20', 0, 0, 1668028756, NULL, 0),
(5, 1, 2, 1, NULL, '127.0.0.1', 'Entry with text, and comments', 'the-hip-one', 'open', 1, 'n', 0, 0, 0, 0, 'y', 'n', 1666304930, '2022', '10', '20', 0, 0, 1666304930, 1666304939, 2),
(6, 1, 2, 1, NULL, '127.0.0.1', 'Entry with BandCamp audio, comments, and comments disabled', 'marrow-and-the-broken-bones', 'open', 1, 'n', 0, 0, 0, 0, 'n', 'n', 1666304930, '2022', '10', '20', 0, 0, 1666304930, 1666304939, 2),
(7, 1, 2, 1, NULL, '127.0.0.1', 'Entry with vimeo video, lots of comments', 'action-comedy-how-to', 'open', 1, 'n', 0, 0, 0, 0, 'y', 'n', 1666304930, '2022', '10', '20', 0, 0, 1666304930, 1666304949, 11),
(8, 1, 2, 1, NULL, '127.0.0.1', 'Entry with YouTube video', 'the-one-with-rope-cutting', 'open', 1, 'n', 0, 0, 0, 0, 'y', 'n', 1666304930, '2022', '10', '20', 0, 0, 1666304930, NULL, 0),
(9, 1, 2, 1, NULL, '127.0.0.1', 'EEntry with large photograph', 'a-photograph-for-the-ages', 'open', 1, 'n', 0, 0, 0, 0, 'y', 'n', 1666304930, '2022', '10', '20', 0, 0, 1666304930, NULL, 0),
(10, 1, 2, 1, NULL, '127.0.0.1', 'Super old entry.', 'super-old-entry', 'open', 1, 'n', 0, 0, 0, 0, 'n', 'n', 1666304930, '2022', '10', '20', 0, 0, 1666304930, NULL, 0),
(11, 1, 2, 1, NULL, '127.0.0.1', 'Entry with a lot of text, and comments disabled.', 'bacon-blog', 'open', 1, 'n', 0, 0, 0, 0, 'n', 'n', 1666304930, '2022', '10', '20', 0, 0, 1666304930, NULL, 0),
(12, 1, 2, 1, NULL, '127.0.0.1', 'Entry with SoundCloud audio', 'the-one-where-we-shake-it-ff', 'open', 1, 'n', 0, 0, 0, 0, 'y', 'n', 1666304930, '2022', '10', '20', 0, 0, 1666304930, NULL, 0),
(13, 1, 4, 1, NULL, '127.0.0.1', 'Test Fieldtypes', 'test-fieldtypes', 'open', 1, 'n', 0, 0, 0, 0, 'y', 'n', 1667245500, '2022', '10', '31', 0, 0, 1675990150, NULL, 0);

INSERT INTO `exp_channels` (`channel_id`, `site_id`, `channel_name`, `channel_title`, `channel_url`, `channel_description`, `channel_lang`, `total_entries`, `total_records`, `total_comments`, `last_entry_date`, `last_comment_date`, `cat_group`, `deft_status`, `search_excerpt`, `deft_category`, `deft_comments`, `channel_require_membership`, `channel_max_chars`, `channel_html_formatting`, `channel_allow_img_urls`, `channel_auto_link_urls`, `channel_notify`, `channel_notify_emails`, `sticky_enabled`, `enable_entry_cloning`, `comment_url`, `comment_system_enabled`, `comment_require_membership`, `comment_moderate`, `comment_max_chars`, `comment_timelock`, `comment_require_email`, `comment_text_formatting`, `comment_html_formatting`, `comment_allow_img_urls`, `comment_auto_link_urls`, `comment_notify`, `comment_notify_authors`, `comment_notify_emails`, `comment_expiration`, `search_results_url`, `rss_url`, `enable_versioning`, `max_revisions`, `default_entry_title`, `title_field_label`, `url_title_prefix`, `preview_url`, `allow_preview`, `max_entries`, `conditional_sync_required`, `title_field_instructions`) VALUES
(1, 1, 'about', 'About', '', NULL, 'en', 3, 3, 0, 1666304880, 0, NULL, 'open', NULL, NULL, 'y', 'y', NULL, 'all', 'y', 'n', 'n', NULL, 'n', 'y', NULL, 'y', 'n', 'n', 5000, 0, 'y', 'xhtml', 'safe', 'n', 'y', 'n', 'n', NULL, 0, NULL, NULL, 'n', 10, NULL, 'Title', NULL, '', 'y', 0, 'n', NULL),
(2, 1, 'blog', 'Blog', '{base_url}blog/entry', NULL, 'en', 8, 8, 0, 1666304930, 0, '1', 'open', NULL, NULL, 'y', 'y', NULL, 'all', 'y', 'n', 'n', NULL, 'n', 'y', NULL, 'y', 'n', 'n', 5000, 0, 'y', 'xhtml', 'safe', 'n', 'y', 'n', 'n', NULL, 0, NULL, NULL, 'n', 10, NULL, 'Title', NULL, '', 'y', 0, 'n', NULL),
(3, 1, 'contact', 'Contact', '', NULL, 'en', 1, 1, 0, 1666304930, 0, NULL, 'open', NULL, NULL, 'y', 'y', NULL, 'all', 'y', 'n', 'n', NULL, 'n', 'y', NULL, 'y', 'n', 'n', 5000, 0, 'y', 'xhtml', 'safe', 'n', 'y', 'n', 'n', NULL, 0, NULL, NULL, 'n', 10, NULL, 'Title', NULL, '', 'y', 0, 'n', NULL),
(4, 1, 'testing', 'Testing', 'http://coilpack-test.test/index.php', '', 'en', 1, 1, 0, 1667245500, 0, '', 'open', NULL, '', 'y', 'y', NULL, 'all', 'y', 'n', 'n', '', 'n', 'y', '', 'y', 'n', 'n', 5000, 0, 'y', 'xhtml', 'safe', 'n', 'y', 'n', 'n', '', 0, '', '', 'n', 10, '', 'Title', '', '', 'y', 0, 'n', NULL);

INSERT INTO `exp_channels_channel_field_groups` (`channel_id`, `group_id`) VALUES
(1, 2),
(1, 4),
(1, 5),
(2, 3),
(2, 5),
(3, 1),
(3, 4),
(3, 5),
(4, 6);

INSERT INTO `exp_channels_statuses` (`channel_id`, `status_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2);

INSERT INTO `exp_comments` (`comment_id`, `site_id`, `entry_id`, `channel_id`, `author_id`, `status`, `name`, `email`, `url`, `location`, `ip_address`, `comment_date`, `edit_date`, `comment`) VALUES
(1, 1, 5, 2, 1, 'o', 'admin', 'bryan@packettide.com', 'http://coilpack-test.test/', NULL, '127.0.0.1', 1666304938, NULL, 'This is an author comment.'),
(2, 1, 5, 2, 0, 'o', 'Guest one', 'example@example.com', '', '', '127.0.0.1', 1666304939, NULL, 'This is a guest comment.'),
(3, 1, 6, 2, 1, 'o', 'admin', 'bryan@packettide.com', 'http://coilpack-test.test/', NULL, '127.0.0.1', 1666304938, NULL, 'This is a comment.\n\nfugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(4, 1, 6, 2, 0, 'o', 'Quest one', 'example@example.com', '', '', '127.0.0.1', 1666304939, NULL, 'This is a comment from a Quest ;)\n\nfugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'),
(5, 1, 7, 2, 1, 'o', 'admin', 'bryan@packettide.com', 'http://coilpack-test.test/', NULL, '127.0.0.1', 1666304938, NULL, 'This is a great video! Thanks for sharing!'),
(6, 1, 7, 2, 1, 'o', 'admin', 'bryan@packettide.com', 'http://coilpack-test.test/', NULL, '127.0.0.1', 1666304939, NULL, 'Woot, love it!'),
(7, 1, 7, 2, 0, 'o', 'Guest one', 'example@example.com', 'http://example.com/', 'Everywhere', '127.0.0.1', 1666304940, NULL, 'This is a comment by a guest to the site, unregistered, with a url and a location.'),
(8, 1, 7, 2, 0, 'o', 'Guest two', 'example@example.com', '', '', '127.0.0.1', 1666304941, NULL, 'This is a comment by an unregistered guest without a url, or a location.'),
(9, 1, 7, 2, 1, 'o', 'admin', 'bryan@packettide.com', 'http://coilpack-test.test/', NULL, '127.0.0.1', 1666304942, NULL, 'I really can\'t get enough of this kind of appraisal.'),
(10, 1, 7, 2, 0, 'o', 'Mr. Meanie', 'example@example.com', '', '', '127.0.0.1', 1666304943, NULL, 'I\'m a bad person, and people should not like me, and I say troll things all the time.'),
(11, 1, 7, 2, 1, 'o', 'admin', 'bryan@packettide.com', 'http://coilpack-test.test/', NULL, '127.0.0.1', 1666304944, NULL, 'Ugh, what a troll.'),
(12, 1, 7, 2, 0, 'o', 'Peter Winkle', 'peter@example.com', '', '', '127.0.0.1', 1666304946, NULL, 'This is a guest comment, from one Mr. Peter Winkle.'),
(13, 1, 7, 2, 0, 'o', 'Fancy Falls', 'fancy@example.com', 'http://example.com', 'Fancy Factory', '127.0.0.1', 1666304947, NULL, 'Fancy, I do say!'),
(14, 1, 7, 2, 0, 'o', 'Pauline Paxton', 'pauline@example.com', '', '', '127.0.0.1', 1666304948, NULL, 'Hello my name is Pauline Paxton, and I lurve Jackie Chan.'),
(15, 1, 7, 2, 1, 'o', 'admin', 'bryan@packettide.com', 'http://coilpack-test.test/', NULL, '127.0.0.1', 1666304949, NULL, 'Test');

INSERT INTO `exp_config` (`config_id`, `site_id`, `key`, `value`) VALUES
(1, 1, 'is_site_on', 'y'),
(2, 1, 'base_url', 'http://laravel.test/'),
(3, 1, 'base_path', '/Users/bryannielsen/Code/EE/next/laravel/ee'),
(4, 1, 'site_index', ''),
(5, 1, 'site_url', 'http://laravel.test'),
(6, 1, 'cp_url', '{base_url}admin.php'),
(7, 1, 'theme_folder_url', '{base_url}themes/'),
(8, 1, 'theme_folder_path', '{base_path}/themes/'),
(9, 1, 'webmaster_email', 'bryan@packettide.com'),
(10, 1, 'webmaster_name', ''),
(11, 1, 'channel_nomenclature', 'channel'),
(12, 1, 'max_caches', '150'),
(13, 1, 'captcha_url', '{base_url}images/captchas/'),
(14, 1, 'captcha_path', '{base_path}images/captchas/'),
(15, 1, 'captcha_font', 'y'),
(16, 1, 'captcha_rand', 'y'),
(17, 1, 'captcha_require_members', 'n'),
(18, 1, 'require_captcha', 'n'),
(19, 1, 'enable_sql_caching', 'n'),
(20, 1, 'force_query_string', 'n'),
(21, 1, 'show_profiler', 'n'),
(22, 1, 'include_seconds', 'n'),
(23, 1, 'cookie_domain', ''),
(24, 1, 'cookie_path', '/'),
(25, 1, 'cookie_httponly', 'y'),
(26, 1, 'website_session_type', 'c'),
(27, 1, 'cp_session_type', 'c'),
(28, 1, 'allow_username_change', 'y'),
(29, 1, 'allow_multi_logins', 'y'),
(30, 1, 'password_lockout', 'y'),
(31, 1, 'password_lockout_interval', '1'),
(32, 1, 'require_ip_for_login', 'y'),
(33, 1, 'require_ip_for_posting', 'y'),
(34, 1, 'password_security_policy', 'basic'),
(35, 1, 'allow_dictionary_pw', 'y'),
(36, 1, 'name_of_dictionary_file', 'dictionary.txt'),
(37, 1, 'xss_clean_uploads', 'y'),
(38, 1, 'redirect_method', 'redirect'),
(39, 1, 'deft_lang', 'english'),
(40, 1, 'xml_lang', 'en'),
(41, 1, 'send_headers', 'y'),
(42, 1, 'gzip_output', 'n'),
(43, 1, 'default_site_timezone', 'UTC'),
(44, 1, 'date_format', '%n/%j/%Y'),
(45, 1, 'time_format', '12'),
(46, 1, 'mail_protocol', 'mail'),
(47, 1, 'email_newline', '\\n'),
(48, 1, 'smtp_server', ''),
(49, 1, 'smtp_username', ''),
(50, 1, 'smtp_password', ''),
(51, 1, 'email_smtp_crypto', 'ssl'),
(52, 1, 'email_debug', 'n'),
(53, 1, 'email_charset', 'utf-8'),
(54, 1, 'email_batchmode', 'n'),
(55, 1, 'email_batch_size', ''),
(56, 1, 'mail_format', 'plain'),
(57, 1, 'word_wrap', 'y'),
(58, 1, 'email_console_timelock', '5'),
(59, 1, 'log_email_console_msgs', 'y'),
(60, 1, 'log_search_terms', 'y'),
(61, 1, 'deny_duplicate_data', 'y'),
(62, 1, 'redirect_submitted_links', 'n'),
(63, 1, 'enable_censoring', 'n'),
(64, 1, 'censored_words', ''),
(65, 1, 'censor_replacement', ''),
(66, 1, 'banned_ips', ''),
(67, 1, 'banned_emails', ''),
(68, 1, 'banned_usernames', ''),
(69, 1, 'banned_screen_names', ''),
(70, 1, 'ban_action', 'restrict'),
(71, 1, 'ban_message', 'This site is currently unavailable'),
(72, 1, 'ban_destination', 'http://www.yahoo.com/'),
(73, 1, 'enable_emoticons', 'y'),
(74, 1, 'emoticon_url', '{base_url}images/smileys/'),
(75, 1, 'recount_batch_total', '1000'),
(76, 1, 'new_version_check', 'y'),
(77, 1, 'enable_throttling', 'n'),
(78, 1, 'banish_masked_ips', 'y'),
(79, 1, 'max_page_loads', '10'),
(80, 1, 'time_interval', '8'),
(81, 1, 'lockout_time', '30'),
(82, 1, 'banishment_type', 'message'),
(83, 1, 'banishment_url', ''),
(84, 1, 'banishment_message', 'You have exceeded the allowed page load frequency.'),
(85, 1, 'enable_search_log', 'y'),
(86, 1, 'max_logged_searches', '500'),
(87, 1, 'un_min_len', '4'),
(88, 1, 'pw_min_len', '5'),
(89, 1, 'allow_member_registration', 'n'),
(90, 1, 'allow_member_localization', 'y'),
(91, 1, 'req_mbr_activation', 'email'),
(92, 1, 'new_member_notification', 'n'),
(93, 1, 'mbr_notification_emails', ''),
(94, 1, 'require_terms_of_service', 'y'),
(95, 1, 'default_primary_role', '5'),
(96, 1, 'profile_trigger', 'member1666304930'),
(97, 1, 'member_theme', 'default'),
(98, 1, 'avatar_url', '{base_url}images/avatars/'),
(99, 1, 'avatar_path', '{base_path}images/avatars/'),
(100, 1, 'avatar_max_width', '100'),
(101, 1, 'avatar_max_height', '100'),
(102, 1, 'avatar_max_kb', '50'),
(103, 1, 'enable_photos', 'n'),
(104, 1, 'photo_url', '{base_url}images/member_photos/'),
(105, 1, 'photo_path', '/'),
(106, 1, 'photo_max_width', '100'),
(107, 1, 'photo_max_height', '100'),
(108, 1, 'photo_max_kb', '50'),
(109, 1, 'allow_signatures', 'y'),
(110, 1, 'sig_maxlength', '500'),
(111, 1, 'sig_allow_img_hotlink', 'n'),
(112, 1, 'sig_allow_img_upload', 'n'),
(113, 1, 'sig_img_url', '{base_url}images/signature_attachments/'),
(114, 1, 'sig_img_path', '{base_path}images/signature_attachments/'),
(115, 1, 'sig_img_max_width', '480'),
(116, 1, 'sig_img_max_height', '80'),
(117, 1, 'sig_img_max_kb', '30'),
(118, 1, 'prv_msg_enabled', 'y'),
(119, 1, 'prv_msg_allow_attachments', 'y'),
(120, 1, 'prv_msg_upload_path', '{base_path}images/pm_attachments/'),
(121, 1, 'prv_msg_max_attachments', '3'),
(122, 1, 'prv_msg_attach_maxsize', '250'),
(123, 1, 'prv_msg_attach_total', '100'),
(124, 1, 'prv_msg_html_format', 'safe'),
(125, 1, 'prv_msg_auto_links', 'y'),
(126, 1, 'prv_msg_max_chars', '6000'),
(127, 1, 'memberlist_order_by', 'member_id'),
(128, 1, 'memberlist_sort_order', 'desc'),
(129, 1, 'memberlist_row_limit', '20'),
(130, 1, 'site_404', 'home/404'),
(131, 1, 'save_tmpl_revisions', 'n'),
(132, 1, 'max_tmpl_revisions', '5'),
(133, 1, 'strict_urls', 'y'),
(134, 1, 'enable_template_routes', 'y'),
(135, 1, 'image_resize_protocol', 'gd2'),
(136, 1, 'image_library_path', ''),
(137, 1, 'word_separator', 'dash'),
(138, 1, 'use_category_name', 'n'),
(139, 1, 'reserved_category_word', 'category'),
(140, 1, 'auto_convert_high_ascii', 'n'),
(141, 1, 'new_posts_clear_caches', 'y'),
(142, 1, 'auto_assign_cat_parents', 'y'),
(143, 0, 'cache_driver', 'file'),
(144, 0, 'cookie_prefix', ''),
(145, 0, 'debug', '1'),
(146, 0, 'file_manager_compatibility_mode', 'n'),
(147, 0, 'is_system_on', 'y'),
(148, 0, 'cli_enabled', 'y'),
(149, 0, 'legacy_member_data', 'n'),
(150, 0, 'legacy_channel_data', 'n'),
(151, 0, 'legacy_category_field_data', 'n'),
(152, 0, 'enable_dock', 'y'),
(153, 0, 'enable_frontedit', 'y'),
(154, 0, 'automatic_frontedit_links', 'y'),
(155, 0, 'enable_mfa', 'y'),
(156, 0, 'autosave_interval_seconds', '10'),
(157, 1, 'save_tmpl_files', 'y'),
(158, 1, 'enable_comments', 'y');

INSERT INTO `exp_consent_request_versions` (`consent_request_version_id`, `consent_request_id`, `request`, `request_format`, `create_date`, `author_id`) VALUES
(1, 1, 'These cookies help us personalize content and functionality for you, including remembering changes you have made to parts of the website that you can customize, or selections for services made on previous visits. If you do not allow these cookies, some portions of our website may be less friendly and easy to use, forcing you to enter content or set your preferences on each visit.', 'none', 1666304930, 0),
(2, 2, 'These cookies allow us measure how visitors use our website, which pages are popular, and what our traffic sources are. This helps us improve how our website works and make it easier for all visitors to find what they are looking for. The information is aggregated and anonymous, and cannot be used to identify you. If you do not allow these cookies, we will be unable to use your visits to our website to help make improvements.', 'none', 1666304930, 0),
(3, 3, 'These cookies are usually placed by third-party advertising networks, which may use information about your website visits to develop a profile of your interests. This information may be shared with other advertisers and/or websites to deliver more relevant advertising to you across multiple websites. If you do not allow these cookies, visits to this website will not be shared with advertising partners and will not contribute to targeted advertising on other websites.', 'none', 1666304930, 0);

INSERT INTO `exp_consent_requests` (`consent_request_id`, `consent_request_version_id`, `user_created`, `title`, `consent_name`, `double_opt_in`, `retention_period`) VALUES
(1, 1, 'n', 'Functionality Cookies', 'ee:cookies_functionality', 'n', NULL),
(2, 2, 'n', 'Performance Cookies', 'ee:cookies_performance', 'n', NULL),
(3, 3, 'n', 'Targeting Cookies', 'ee:cookies_targeting', 'n', NULL);

INSERT INTO `exp_content_types` (`content_type_id`, `name`) VALUES
(1, 'grid'),
(2, 'channel'),
(3, 'pro_variables');

INSERT INTO `exp_cookie_settings` (`cookie_id`, `cookie_provider`, `cookie_name`, `cookie_lifetime`, `cookie_enforced_lifetime`, `cookie_title`, `cookie_description`) VALUES
(1, 'ee', 'csrf_token', 7200, NULL, 'CSRF Token', 'A security cookie used to identify the user and prevent Cross Site Request Forgery attacks.'),
(2, 'ee', 'flash', 0, NULL, 'Flash data', 'User feedback messages, encrypted for security.'),
(3, 'ee', 'remember', NULL, NULL, 'Remember Me', 'Determines whether a user is automatically logged in upon visiting the site.'),
(4, 'ee', 'sessionid', 3600, NULL, 'Session ID', 'Session id, used to associate a logged in user with their data.'),
(5, 'ee', 'visitor_consents', NULL, NULL, 'Visitor Consents', 'Saves responses to Consent requests for non-logged in visitors'),
(6, 'ee', 'last_activity', 31536000, NULL, 'Last Activity', 'Records the time of the last page load. Used in in calculating active sessions.'),
(7, 'ee', 'last_visit', 31536000, NULL, 'Last Visit', 'Date of the user’s last visit, based on the last_activity cookie. Can be shown as a statistic for members and used by forum and comments to show unread topics for both members and guests.'),
(8, 'ee', 'anon', NULL, NULL, 'Anonymize', 'Determines whether the user’s username is displayed in the list of currently logged in members.'),
(9, 'ee', 'tracker', 0, NULL, 'Tracker', 'Contains the last 5 pages viewed, encrypted for security. Typically used for form or error message returns.'),
(10, 'cp', 'viewtype', 31104000, NULL, 'Filemanager View Type', 'Determines View Type to be used in Filemanager (table or thumbs view)'),
(11, 'cp', 'cp_last_site_id', NULL, NULL, 'CP Last Site ID', 'MSM cookie indicating the last site accessed in the Control Panel.'),
(12, 'cp', 'ee_cp_viewmode', NULL, NULL, 'CP View Mode', 'Determines view mode for the Control Panel.'),
(13, 'cp', 'secondary_sidebar', NULL, NULL, 'Secondary Sidebar State', 'Determines whether secondary navigation sidebar in the Control Panel should be collapsed for each corresponding section.'),
(14, 'cp', 'collapsed_nav', NULL, NULL, 'Collapsed Navigation', 'Determines whether navigation sidebar in the Control Panel should be collapsed.'),
(15, 'pro', 'frontedit', NULL, NULL, 'Front-end editing', 'Determines whether ExpressioEngine front-end editing features should be enabled.'),
(16, 'comment', 'my_email', NULL, NULL, 'My email', 'Email address specified when posting a comment.'),
(17, 'comment', 'my_location', NULL, NULL, 'My location', 'Location specified when posting a comment.'),
(18, 'comment', 'my_name', NULL, NULL, 'My name', 'Name specified when posting a comment.'),
(19, 'comment', 'my_url', NULL, NULL, 'My URL', 'URL specified when posting a comment.'),
(20, 'comment', 'notify_me', NULL, NULL, 'Notify me', 'If set to ‘yes’, notifications will be sent to the saved email address when new comments are made.'),
(21, 'comment', 'save_info', NULL, NULL, 'Save info', 'If set to ‘yes’, allows additional cookies (my_email, my_location, my_name, my_url) to store guest user information for use when filling out comment forms. This cookie is only set if you submit a comment.');

INSERT INTO `exp_cp_log` (`id`, `site_id`, `member_id`, `username`, `ip_address`, `act_date`, `action`) VALUES
(1, 1, 1, 'admin', '127.0.0.1', 1666304967, 'Logged in'),
(2, 1, 1, 'admin', '127.0.0.1', 1666358111, 'Logged in'),
(3, 1, 1, 'admin', '127.0.0.1', 1666996992, 'Logged in'),
(4, 1, 1, 'admin', '127.0.0.1', 1666997361, 'Logged out'),
(5, 1, 1, 'admin', '127.0.0.1', 1667176214, 'Logged in'),
(6, 1, 1, 'admin', '127.0.0.1', 1667220733, 'Logged in'),
(7, 1, 1, 'admin', '127.0.0.1', 1667240661, 'Logged in'),
(8, 1, 1, 'admin', '127.0.0.1', 1667245549, 'Channel Created&nbsp;&nbsp;Testing'),
(9, 1, 1, 'admin', '127.0.0.1', 1667259828, 'Logged in'),
(10, 1, 1, 'admin', '127.0.0.1', 1667266142, 'Logged in'),
(11, 1, 1, 'admin', '127.0.0.1', 1667310468, 'Logged in'),
(12, 1, 1, 'admin', '127.0.0.1', 1667316383, 'Logged in'),
(13, 1, 1, 'admin', '127.0.0.1', 1667323480, 'Logged in'),
(14, 1, 1, 'admin', '127.0.0.1', 1667331997, 'Logged in'),
(15, 1, 1, 'admin', '127.0.0.1', 1668026632, 'Logged in'),
(16, 1, 1, 'admin', '127.0.0.1', 1668026639, 'Logged in'),
(17, 1, 1, 'admin', '127.0.0.1', 1668088947, 'Logged in'),
(18, 1, 1, 'admin', '127.0.0.1', 1668107108, 'Logged in'),
(19, 1, 1, 'admin', '127.0.0.1', 1668109495, 'Logged in'),
(20, 1, 1, 'admin', '127.0.0.1', 1668116849, 'Logged in'),
(21, 1, 1, 'admin', '127.0.0.1', 1669131552, 'Logged in'),
(22, 1, 1, 'admin', '127.0.0.1', 1669131560, 'Logged in'),
(23, 1, 1, 'admin', '127.0.0.1', 1673291461, 'Logged in'),
(24, 1, 1, 'admin', '127.0.0.1', 1673969473, 'Logged in'),
(25, 1, 1, 'admin', '127.0.0.1', 1673976308, 'Logged in'),
(26, 1, 1, 'admin', '127.0.0.1', 1675112629, 'Logged in'),
(27, 1, 1, 'admin', '127.0.0.1', 1675112635, 'Logged in'),
(28, 1, 1, 'admin', '127.0.0.1', 1675298766, 'Logged in'),
(29, 1, 1, 'admin', '127.0.0.1', 1675375334, 'Logged in'),
(30, 1, 1, 'admin', '127.0.0.1', 1675375336, 'Logged out'),
(31, 1, 1, 'admin', '127.0.0.1', 1675375338, 'Logged in'),
(32, 1, 1, 'admin', '127.0.0.1', 1675781374, 'Logged in'),
(33, 1, 1, 'admin', '127.0.0.1', 1675866990, 'Logged in'),
(34, 1, 1, 'admin', '127.0.0.1', 1675970974, 'Logged in'),
(35, 1, 1, 'admin', '127.0.0.1', 1675970979, 'Logged in'),
(36, 1, 1, 'admin', '127.0.0.1', 1675980392, 'Logged in'),
(37, 1, 1, 'admin', '127.0.0.1', 1675980396, 'Logged in'),
(38, 1, 1, 'admin', '127.0.0.1', 1675986535, 'Logged in'),
(39, 1, 1, 'admin', '127.0.0.1', 1676511348, 'Logged in');

INSERT INTO `exp_dashboard_widgets` (`widget_id`, `widget_name`, `widget_data`, `widget_type`, `widget_source`, `widget_file`) VALUES
(1, NULL, NULL, 'php', 'pro', 'comments'),
(2, NULL, NULL, 'php', 'pro', 'eecms_news'),
(3, NULL, NULL, 'php', 'pro', 'members'),
(4, NULL, NULL, 'php', 'pro', 'recent_entries'),
(5, NULL, NULL, 'php', 'pro', 'recent_templates'),
(6, NULL, NULL, 'html', 'pro', 'support');

INSERT INTO `exp_dock_prolets` (`dock_id`, `prolet_id`) VALUES
(1, 1),
(1, 2),
(1, 3);

INSERT INTO `exp_docks` (`dock_id`, `site_id`) VALUES
(1, 0);

INSERT INTO `exp_extensions` (`extension_id`, `class`, `method`, `hook`, `settings`, `priority`, `version`, `enabled`) VALUES
(1, 'Comment_ext', 'addCommentMenu', 'cp_custom_menu', 'a:0:{}', 10, '2.3.3', 'y'),
(2, 'Structure_ext', 'after_channel_entry_save', 'after_channel_entry_save', 'a:0:{}', 10, '6.0.0', 'y'),
(3, 'Structure_ext', 'sessions_end', 'sessions_end', 'a:0:{}', 10, '6.0.0', 'y'),
(4, 'Structure_ext', 'entry_submission_redirect', 'entry_submission_redirect', 'a:0:{}', 10, '6.0.0', 'y'),
(5, 'Structure_ext', 'cp_member_login', 'cp_member_login', 'a:0:{}', 10, '6.0.0', 'y'),
(6, 'Structure_ext', 'sessions_start', 'sessions_start', 'a:0:{}', 10, '6.0.0', 'y'),
(7, 'Structure_ext', 'pagination_create', 'pagination_create', 'a:0:{}', 10, '6.0.0', 'y'),
(8, 'Structure_ext', 'wygwam_config', 'wygwam_config', 'a:0:{}', 10, '6.0.0', 'y'),
(9, 'Structure_ext', 'core_template_route', 'core_template_route', 'a:0:{}', 10, '6.0.0', 'y'),
(10, 'Structure_ext', 'entry_submission_end', 'entry_submission_end', 'a:0:{}', 10, '6.0.0', 'y'),
(11, 'Structure_ext', 'channel_form_submit_entry_end', 'channel_form_submit_entry_end', 'a:0:{}', 10, '6.0.0', 'y'),
(12, 'Structure_ext', 'template_post_parse', 'template_post_parse', 'a:0:{}', 10, '6.0.0', 'y'),
(13, 'Structure_ext', 'cp_custom_menu', 'cp_custom_menu', 'a:0:{}', 10, '6.0.0', 'y'),
(14, 'Structure_ext', 'publish_live_preview_route', 'publish_live_preview_route', 'a:0:{}', 10, '6.0.0', 'y'),
(15, 'Structure_ext', 'entry_save_and_close_redirect', 'entry_save_and_close_redirect', 'a:0:{}', 10, '6.0.0', 'y'),
(16, 'Pro_variables_ext', 'sessions_end', 'sessions_end', 'a:7:{s:10:\"can_manage\";a:1:{i:0;i:1;}s:11:\"clear_cache\";s:1:\"n\";s:16:\"register_globals\";s:1:\"n\";s:13:\"save_as_files\";s:1:\"n\";s:9:\"file_path\";s:0:\"\";s:12:\"one_way_sync\";s:1:\"n\";s:13:\"enabled_types\";a:1:{i:0;s:12:\"pro_textarea\";}}', 2, '5.0.2', 'y'),
(17, 'Pro_variables_ext', 'template_fetch_template', 'template_fetch_template', 'a:7:{s:10:\"can_manage\";a:1:{i:0;i:1;}s:11:\"clear_cache\";s:1:\"n\";s:16:\"register_globals\";s:1:\"n\";s:13:\"save_as_files\";s:1:\"n\";s:9:\"file_path\";s:0:\"\";s:12:\"one_way_sync\";s:1:\"n\";s:13:\"enabled_types\";a:1:{i:0;s:12:\"pro_textarea\";}}', 2, '5.0.2', 'y'),
(18, 'Pro_search_ext', 'after_channel_entry_insert', 'after_channel_entry_insert', 'a:17:{s:12:\"encode_query\";s:1:\"y\";s:15:\"min_word_length\";s:1:\"4\";s:14:\"excerpt_length\";s:2:\"50\";s:14:\"excerpt_hilite\";s:0:\"\";s:12:\"title_hilite\";s:0:\"\";s:10:\"batch_size\";s:3:\"100\";s:19:\"default_result_page\";s:14:\"search/results\";s:15:\"search_log_size\";s:3:\"500\";s:12:\"ignore_words\";s:20:\"a an and the or of s\";s:16:\"disabled_filters\";a:0:{}s:10:\"stop_words\";s:3945:\"a\'s able about above according accordingly across actually after afterwards again against ain\'t\n            all allow allows almost alone along already also although always am among amongst an and another\n            any anybody anyhow anyone anything anyway anyways anywhere apart appear appreciate appropriate are\n            aren\'t around as aside ask asking associated at available away awfully be became because become\n            becomes becoming been before beforehand behind being believe below beside besides best better between\n            beyond both brief but by c\'mon c\'s came can can\'t cannot cant cause causes certain certainly changes\n            clearly co com come comes concerning consequently consider considering contain containing contains\n            corresponding could couldn\'t course currently definitely described despite did didn\'t different do\n            does doesn\'t doing don\'t done down downwards during each edu eg eight either else elsewhere enough\n            entirely especially et etc even ever every everybody everyone everything everywhere ex exactly example\n            except far few fifth first five followed following follows for former formerly forth four from further\n            furthermore get gets getting given gives go goes going gone got gotten greetings had hadn\'t happens\n            hardly has hasn\'t have haven\'t having he he\'s hello help hence her here here\'s hereafter hereby herein\n            hereupon hers herself hi him himself his hither hopefully how howbeit however i\'d i\'ll i\'m i\'ve ie if\n            ignored immediate in inasmuch inc indeed indicate indicated indicates inner insofar instead into\n            inward is isn\'t it it\'d it\'ll it\'s its itself just keep keeps kept know known knows last lately later\n            latter latterly least less lest let let\'s like liked likely little look looking looks ltd mainly many\n            may maybe me mean meanwhile merely might more moreover most mostly much must my myself name namely nd\n            near nearly necessary need needs neither never nevertheless new next nine no nobody non none noone nor\n            normally not nothing novel now nowhere obviously of off often oh ok okay old on once one ones only\n            onto or other others otherwise ought our ours ourselves out outside over overall own particular\n            particularly per perhaps placed please plus possible presumably probably provides que quite qv rather\n            rd re really reasonably regarding regardless regards relatively respectively right said same saw say\n            saying says second secondly see seeing seem seemed seeming seems seen self selves sensible sent\n            serious seriously seven several shall she should shouldn\'t since six so some somebody somehow someone\n            something sometime sometimes somewhat somewhere soon sorry specified specify specifying still sub such\n            sup sure t\'s take taken tell tends th than thank thanks thanx that that\'s thats the their theirs them\n            themselves then thence there there\'s thereafter thereby therefore therein theres thereupon these they\n            they\'d they\'ll they\'re they\'ve think third this thorough thoroughly those though three through\n            throughout thru thus to together too took toward towards tried tries truly try trying twice two un\n            under unfortunately unless unlikely until unto up upon us use used useful uses using usually value\n            various very via viz vs want wants was wasn\'t way we we\'d we\'ll we\'re we\'ve welcome well went were\n            weren\'t what what\'s whatever when whence whenever where where\'s whereafter whereas whereby wherein\n            whereupon wherever whether which while whither who who\'s whoever whole whom whose why will willing\n            wish with within without won\'t wonder would wouldn\'t yes yet you you\'d you\'ll you\'re you\'ve your\n            yours yourself yourselves zero\";s:10:\"can_manage\";a:0:{}s:20:\"can_manage_shortcuts\";a:0:{}s:18:\"can_manage_lexicon\";a:0:{}s:11:\"can_replace\";a:0:{}s:19:\"can_view_search_log\";a:0:{}s:20:\"can_view_replace_log\";a:0:{}}', 10, '8.0.0', 'y'),
(19, 'Pro_search_ext', 'after_channel_entry_update', 'after_channel_entry_update', 'a:17:{s:12:\"encode_query\";s:1:\"y\";s:15:\"min_word_length\";s:1:\"4\";s:14:\"excerpt_length\";s:2:\"50\";s:14:\"excerpt_hilite\";s:0:\"\";s:12:\"title_hilite\";s:0:\"\";s:10:\"batch_size\";s:3:\"100\";s:19:\"default_result_page\";s:14:\"search/results\";s:15:\"search_log_size\";s:3:\"500\";s:12:\"ignore_words\";s:20:\"a an and the or of s\";s:16:\"disabled_filters\";a:0:{}s:10:\"stop_words\";s:3945:\"a\'s able about above according accordingly across actually after afterwards again against ain\'t\n            all allow allows almost alone along already also although always am among amongst an and another\n            any anybody anyhow anyone anything anyway anyways anywhere apart appear appreciate appropriate are\n            aren\'t around as aside ask asking associated at available away awfully be became because become\n            becomes becoming been before beforehand behind being believe below beside besides best better between\n            beyond both brief but by c\'mon c\'s came can can\'t cannot cant cause causes certain certainly changes\n            clearly co com come comes concerning consequently consider considering contain containing contains\n            corresponding could couldn\'t course currently definitely described despite did didn\'t different do\n            does doesn\'t doing don\'t done down downwards during each edu eg eight either else elsewhere enough\n            entirely especially et etc even ever every everybody everyone everything everywhere ex exactly example\n            except far few fifth first five followed following follows for former formerly forth four from further\n            furthermore get gets getting given gives go goes going gone got gotten greetings had hadn\'t happens\n            hardly has hasn\'t have haven\'t having he he\'s hello help hence her here here\'s hereafter hereby herein\n            hereupon hers herself hi him himself his hither hopefully how howbeit however i\'d i\'ll i\'m i\'ve ie if\n            ignored immediate in inasmuch inc indeed indicate indicated indicates inner insofar instead into\n            inward is isn\'t it it\'d it\'ll it\'s its itself just keep keeps kept know known knows last lately later\n            latter latterly least less lest let let\'s like liked likely little look looking looks ltd mainly many\n            may maybe me mean meanwhile merely might more moreover most mostly much must my myself name namely nd\n            near nearly necessary need needs neither never nevertheless new next nine no nobody non none noone nor\n            normally not nothing novel now nowhere obviously of off often oh ok okay old on once one ones only\n            onto or other others otherwise ought our ours ourselves out outside over overall own particular\n            particularly per perhaps placed please plus possible presumably probably provides que quite qv rather\n            rd re really reasonably regarding regardless regards relatively respectively right said same saw say\n            saying says second secondly see seeing seem seemed seeming seems seen self selves sensible sent\n            serious seriously seven several shall she should shouldn\'t since six so some somebody somehow someone\n            something sometime sometimes somewhat somewhere soon sorry specified specify specifying still sub such\n            sup sure t\'s take taken tell tends th than thank thanks thanx that that\'s thats the their theirs them\n            themselves then thence there there\'s thereafter thereby therefore therein theres thereupon these they\n            they\'d they\'ll they\'re they\'ve think third this thorough thoroughly those though three through\n            throughout thru thus to together too took toward towards tried tries truly try trying twice two un\n            under unfortunately unless unlikely until unto up upon us use used useful uses using usually value\n            various very via viz vs want wants was wasn\'t way we we\'d we\'ll we\'re we\'ve welcome well went were\n            weren\'t what what\'s whatever when whence whenever where where\'s whereafter whereas whereby wherein\n            whereupon wherever whether which while whither who who\'s whoever whole whom whose why will willing\n            wish with within without won\'t wonder would wouldn\'t yes yet you you\'d you\'ll you\'re you\'ve your\n            yours yourself yourselves zero\";s:10:\"can_manage\";a:0:{}s:20:\"can_manage_shortcuts\";a:0:{}s:18:\"can_manage_lexicon\";a:0:{}s:11:\"can_replace\";a:0:{}s:19:\"can_view_search_log\";a:0:{}s:20:\"can_view_replace_log\";a:0:{}}', 10, '8.0.0', 'y'),
(20, 'Pro_search_ext', 'after_channel_entry_delete', 'after_channel_entry_delete', 'a:17:{s:12:\"encode_query\";s:1:\"y\";s:15:\"min_word_length\";s:1:\"4\";s:14:\"excerpt_length\";s:2:\"50\";s:14:\"excerpt_hilite\";s:0:\"\";s:12:\"title_hilite\";s:0:\"\";s:10:\"batch_size\";s:3:\"100\";s:19:\"default_result_page\";s:14:\"search/results\";s:15:\"search_log_size\";s:3:\"500\";s:12:\"ignore_words\";s:20:\"a an and the or of s\";s:16:\"disabled_filters\";a:0:{}s:10:\"stop_words\";s:3945:\"a\'s able about above according accordingly across actually after afterwards again against ain\'t\n            all allow allows almost alone along already also although always am among amongst an and another\n            any anybody anyhow anyone anything anyway anyways anywhere apart appear appreciate appropriate are\n            aren\'t around as aside ask asking associated at available away awfully be became because become\n            becomes becoming been before beforehand behind being believe below beside besides best better between\n            beyond both brief but by c\'mon c\'s came can can\'t cannot cant cause causes certain certainly changes\n            clearly co com come comes concerning consequently consider considering contain containing contains\n            corresponding could couldn\'t course currently definitely described despite did didn\'t different do\n            does doesn\'t doing don\'t done down downwards during each edu eg eight either else elsewhere enough\n            entirely especially et etc even ever every everybody everyone everything everywhere ex exactly example\n            except far few fifth first five followed following follows for former formerly forth four from further\n            furthermore get gets getting given gives go goes going gone got gotten greetings had hadn\'t happens\n            hardly has hasn\'t have haven\'t having he he\'s hello help hence her here here\'s hereafter hereby herein\n            hereupon hers herself hi him himself his hither hopefully how howbeit however i\'d i\'ll i\'m i\'ve ie if\n            ignored immediate in inasmuch inc indeed indicate indicated indicates inner insofar instead into\n            inward is isn\'t it it\'d it\'ll it\'s its itself just keep keeps kept know known knows last lately later\n            latter latterly least less lest let let\'s like liked likely little look looking looks ltd mainly many\n            may maybe me mean meanwhile merely might more moreover most mostly much must my myself name namely nd\n            near nearly necessary need needs neither never nevertheless new next nine no nobody non none noone nor\n            normally not nothing novel now nowhere obviously of off often oh ok okay old on once one ones only\n            onto or other others otherwise ought our ours ourselves out outside over overall own particular\n            particularly per perhaps placed please plus possible presumably probably provides que quite qv rather\n            rd re really reasonably regarding regardless regards relatively respectively right said same saw say\n            saying says second secondly see seeing seem seemed seeming seems seen self selves sensible sent\n            serious seriously seven several shall she should shouldn\'t since six so some somebody somehow someone\n            something sometime sometimes somewhat somewhere soon sorry specified specify specifying still sub such\n            sup sure t\'s take taken tell tends th than thank thanks thanx that that\'s thats the their theirs them\n            themselves then thence there there\'s thereafter thereby therefore therein theres thereupon these they\n            they\'d they\'ll they\'re they\'ve think third this thorough thoroughly those though three through\n            throughout thru thus to together too took toward towards tried tries truly try trying twice two un\n            under unfortunately unless unlikely until unto up upon us use used useful uses using usually value\n            various very via viz vs want wants was wasn\'t way we we\'d we\'ll we\'re we\'ve welcome well went were\n            weren\'t what what\'s whatever when whence whenever where where\'s whereafter whereas whereby wherein\n            whereupon wherever whether which while whither who who\'s whoever whole whom whose why will willing\n            wish with within without won\'t wonder would wouldn\'t yes yet you you\'d you\'ll you\'re you\'ve your\n            yours yourself yourselves zero\";s:10:\"can_manage\";a:0:{}s:20:\"can_manage_shortcuts\";a:0:{}s:18:\"can_manage_lexicon\";a:0:{}s:11:\"can_replace\";a:0:{}s:19:\"can_view_search_log\";a:0:{}s:20:\"can_view_replace_log\";a:0:{}}', 10, '8.0.0', 'y'),
(21, 'Pro_search_ext', 'channel_entries_query_result', 'channel_entries_query_result', 'a:17:{s:12:\"encode_query\";s:1:\"y\";s:15:\"min_word_length\";s:1:\"4\";s:14:\"excerpt_length\";s:2:\"50\";s:14:\"excerpt_hilite\";s:0:\"\";s:12:\"title_hilite\";s:0:\"\";s:10:\"batch_size\";s:3:\"100\";s:19:\"default_result_page\";s:14:\"search/results\";s:15:\"search_log_size\";s:3:\"500\";s:12:\"ignore_words\";s:20:\"a an and the or of s\";s:16:\"disabled_filters\";a:0:{}s:10:\"stop_words\";s:3945:\"a\'s able about above according accordingly across actually after afterwards again against ain\'t\n            all allow allows almost alone along already also although always am among amongst an and another\n            any anybody anyhow anyone anything anyway anyways anywhere apart appear appreciate appropriate are\n            aren\'t around as aside ask asking associated at available away awfully be became because become\n            becomes becoming been before beforehand behind being believe below beside besides best better between\n            beyond both brief but by c\'mon c\'s came can can\'t cannot cant cause causes certain certainly changes\n            clearly co com come comes concerning consequently consider considering contain containing contains\n            corresponding could couldn\'t course currently definitely described despite did didn\'t different do\n            does doesn\'t doing don\'t done down downwards during each edu eg eight either else elsewhere enough\n            entirely especially et etc even ever every everybody everyone everything everywhere ex exactly example\n            except far few fifth first five followed following follows for former formerly forth four from further\n            furthermore get gets getting given gives go goes going gone got gotten greetings had hadn\'t happens\n            hardly has hasn\'t have haven\'t having he he\'s hello help hence her here here\'s hereafter hereby herein\n            hereupon hers herself hi him himself his hither hopefully how howbeit however i\'d i\'ll i\'m i\'ve ie if\n            ignored immediate in inasmuch inc indeed indicate indicated indicates inner insofar instead into\n            inward is isn\'t it it\'d it\'ll it\'s its itself just keep keeps kept know known knows last lately later\n            latter latterly least less lest let let\'s like liked likely little look looking looks ltd mainly many\n            may maybe me mean meanwhile merely might more moreover most mostly much must my myself name namely nd\n            near nearly necessary need needs neither never nevertheless new next nine no nobody non none noone nor\n            normally not nothing novel now nowhere obviously of off often oh ok okay old on once one ones only\n            onto or other others otherwise ought our ours ourselves out outside over overall own particular\n            particularly per perhaps placed please plus possible presumably probably provides que quite qv rather\n            rd re really reasonably regarding regardless regards relatively respectively right said same saw say\n            saying says second secondly see seeing seem seemed seeming seems seen self selves sensible sent\n            serious seriously seven several shall she should shouldn\'t since six so some somebody somehow someone\n            something sometime sometimes somewhat somewhere soon sorry specified specify specifying still sub such\n            sup sure t\'s take taken tell tends th than thank thanks thanx that that\'s thats the their theirs them\n            themselves then thence there there\'s thereafter thereby therefore therein theres thereupon these they\n            they\'d they\'ll they\'re they\'ve think third this thorough thoroughly those though three through\n            throughout thru thus to together too took toward towards tried tries truly try trying twice two un\n            under unfortunately unless unlikely until unto up upon us use used useful uses using usually value\n            various very via viz vs want wants was wasn\'t way we we\'d we\'ll we\'re we\'ve welcome well went were\n            weren\'t what what\'s whatever when whence whenever where where\'s whereafter whereas whereby wherein\n            whereupon wherever whether which while whither who who\'s whoever whole whom whose why will willing\n            wish with within without won\'t wonder would wouldn\'t yes yet you you\'d you\'ll you\'re you\'ve your\n            yours yourself yourselves zero\";s:10:\"can_manage\";a:0:{}s:20:\"can_manage_shortcuts\";a:0:{}s:18:\"can_manage_lexicon\";a:0:{}s:11:\"can_replace\";a:0:{}s:19:\"can_view_search_log\";a:0:{}s:20:\"can_view_replace_log\";a:0:{}}', 10, '8.0.0', 'y'),
(22, 'Pro_search_ext', 'after_category_save', 'after_category_save', 'a:17:{s:12:\"encode_query\";s:1:\"y\";s:15:\"min_word_length\";s:1:\"4\";s:14:\"excerpt_length\";s:2:\"50\";s:14:\"excerpt_hilite\";s:0:\"\";s:12:\"title_hilite\";s:0:\"\";s:10:\"batch_size\";s:3:\"100\";s:19:\"default_result_page\";s:14:\"search/results\";s:15:\"search_log_size\";s:3:\"500\";s:12:\"ignore_words\";s:20:\"a an and the or of s\";s:16:\"disabled_filters\";a:0:{}s:10:\"stop_words\";s:3945:\"a\'s able about above according accordingly across actually after afterwards again against ain\'t\n            all allow allows almost alone along already also although always am among amongst an and another\n            any anybody anyhow anyone anything anyway anyways anywhere apart appear appreciate appropriate are\n            aren\'t around as aside ask asking associated at available away awfully be became because become\n            becomes becoming been before beforehand behind being believe below beside besides best better between\n            beyond both brief but by c\'mon c\'s came can can\'t cannot cant cause causes certain certainly changes\n            clearly co com come comes concerning consequently consider considering contain containing contains\n            corresponding could couldn\'t course currently definitely described despite did didn\'t different do\n            does doesn\'t doing don\'t done down downwards during each edu eg eight either else elsewhere enough\n            entirely especially et etc even ever every everybody everyone everything everywhere ex exactly example\n            except far few fifth first five followed following follows for former formerly forth four from further\n            furthermore get gets getting given gives go goes going gone got gotten greetings had hadn\'t happens\n            hardly has hasn\'t have haven\'t having he he\'s hello help hence her here here\'s hereafter hereby herein\n            hereupon hers herself hi him himself his hither hopefully how howbeit however i\'d i\'ll i\'m i\'ve ie if\n            ignored immediate in inasmuch inc indeed indicate indicated indicates inner insofar instead into\n            inward is isn\'t it it\'d it\'ll it\'s its itself just keep keeps kept know known knows last lately later\n            latter latterly least less lest let let\'s like liked likely little look looking looks ltd mainly many\n            may maybe me mean meanwhile merely might more moreover most mostly much must my myself name namely nd\n            near nearly necessary need needs neither never nevertheless new next nine no nobody non none noone nor\n            normally not nothing novel now nowhere obviously of off often oh ok okay old on once one ones only\n            onto or other others otherwise ought our ours ourselves out outside over overall own particular\n            particularly per perhaps placed please plus possible presumably probably provides que quite qv rather\n            rd re really reasonably regarding regardless regards relatively respectively right said same saw say\n            saying says second secondly see seeing seem seemed seeming seems seen self selves sensible sent\n            serious seriously seven several shall she should shouldn\'t since six so some somebody somehow someone\n            something sometime sometimes somewhat somewhere soon sorry specified specify specifying still sub such\n            sup sure t\'s take taken tell tends th than thank thanks thanx that that\'s thats the their theirs them\n            themselves then thence there there\'s thereafter thereby therefore therein theres thereupon these they\n            they\'d they\'ll they\'re they\'ve think third this thorough thoroughly those though three through\n            throughout thru thus to together too took toward towards tried tries truly try trying twice two un\n            under unfortunately unless unlikely until unto up upon us use used useful uses using usually value\n            various very via viz vs want wants was wasn\'t way we we\'d we\'ll we\'re we\'ve welcome well went were\n            weren\'t what what\'s whatever when whence whenever where where\'s whereafter whereas whereby wherein\n            whereupon wherever whether which while whither who who\'s whoever whole whom whose why will willing\n            wish with within without won\'t wonder would wouldn\'t yes yet you you\'d you\'ll you\'re you\'ve your\n            yours yourself yourselves zero\";s:10:\"can_manage\";a:0:{}s:20:\"can_manage_shortcuts\";a:0:{}s:18:\"can_manage_lexicon\";a:0:{}s:11:\"can_replace\";a:0:{}s:19:\"can_view_search_log\";a:0:{}s:20:\"can_view_replace_log\";a:0:{}}', 10, '8.0.0', 'y'),
(23, 'Pro_search_ext', 'after_category_delete', 'after_category_delete', 'a:17:{s:12:\"encode_query\";s:1:\"y\";s:15:\"min_word_length\";s:1:\"4\";s:14:\"excerpt_length\";s:2:\"50\";s:14:\"excerpt_hilite\";s:0:\"\";s:12:\"title_hilite\";s:0:\"\";s:10:\"batch_size\";s:3:\"100\";s:19:\"default_result_page\";s:14:\"search/results\";s:15:\"search_log_size\";s:3:\"500\";s:12:\"ignore_words\";s:20:\"a an and the or of s\";s:16:\"disabled_filters\";a:0:{}s:10:\"stop_words\";s:3945:\"a\'s able about above according accordingly across actually after afterwards again against ain\'t\n            all allow allows almost alone along already also although always am among amongst an and another\n            any anybody anyhow anyone anything anyway anyways anywhere apart appear appreciate appropriate are\n            aren\'t around as aside ask asking associated at available away awfully be became because become\n            becomes becoming been before beforehand behind being believe below beside besides best better between\n            beyond both brief but by c\'mon c\'s came can can\'t cannot cant cause causes certain certainly changes\n            clearly co com come comes concerning consequently consider considering contain containing contains\n            corresponding could couldn\'t course currently definitely described despite did didn\'t different do\n            does doesn\'t doing don\'t done down downwards during each edu eg eight either else elsewhere enough\n            entirely especially et etc even ever every everybody everyone everything everywhere ex exactly example\n            except far few fifth first five followed following follows for former formerly forth four from further\n            furthermore get gets getting given gives go goes going gone got gotten greetings had hadn\'t happens\n            hardly has hasn\'t have haven\'t having he he\'s hello help hence her here here\'s hereafter hereby herein\n            hereupon hers herself hi him himself his hither hopefully how howbeit however i\'d i\'ll i\'m i\'ve ie if\n            ignored immediate in inasmuch inc indeed indicate indicated indicates inner insofar instead into\n            inward is isn\'t it it\'d it\'ll it\'s its itself just keep keeps kept know known knows last lately later\n            latter latterly least less lest let let\'s like liked likely little look looking looks ltd mainly many\n            may maybe me mean meanwhile merely might more moreover most mostly much must my myself name namely nd\n            near nearly necessary need needs neither never nevertheless new next nine no nobody non none noone nor\n            normally not nothing novel now nowhere obviously of off often oh ok okay old on once one ones only\n            onto or other others otherwise ought our ours ourselves out outside over overall own particular\n            particularly per perhaps placed please plus possible presumably probably provides que quite qv rather\n            rd re really reasonably regarding regardless regards relatively respectively right said same saw say\n            saying says second secondly see seeing seem seemed seeming seems seen self selves sensible sent\n            serious seriously seven several shall she should shouldn\'t since six so some somebody somehow someone\n            something sometime sometimes somewhat somewhere soon sorry specified specify specifying still sub such\n            sup sure t\'s take taken tell tends th than thank thanks thanx that that\'s thats the their theirs them\n            themselves then thence there there\'s thereafter thereby therefore therein theres thereupon these they\n            they\'d they\'ll they\'re they\'ve think third this thorough thoroughly those though three through\n            throughout thru thus to together too took toward towards tried tries truly try trying twice two un\n            under unfortunately unless unlikely until unto up upon us use used useful uses using usually value\n            various very via viz vs want wants was wasn\'t way we we\'d we\'ll we\'re we\'ve welcome well went were\n            weren\'t what what\'s whatever when whence whenever where where\'s whereafter whereas whereby wherein\n            whereupon wherever whether which while whither who who\'s whoever whole whom whose why will willing\n            wish with within without won\'t wonder would wouldn\'t yes yet you you\'d you\'ll you\'re you\'ve your\n            yours yourself yourselves zero\";s:10:\"can_manage\";a:0:{}s:20:\"can_manage_shortcuts\";a:0:{}s:18:\"can_manage_lexicon\";a:0:{}s:11:\"can_replace\";a:0:{}s:19:\"can_view_search_log\";a:0:{}s:20:\"can_view_replace_log\";a:0:{}}', 10, '8.0.0', 'y'),
(24, 'Pro_search_ext', 'after_channel_field_delete', 'after_channel_field_delete', 'a:17:{s:12:\"encode_query\";s:1:\"y\";s:15:\"min_word_length\";s:1:\"4\";s:14:\"excerpt_length\";s:2:\"50\";s:14:\"excerpt_hilite\";s:0:\"\";s:12:\"title_hilite\";s:0:\"\";s:10:\"batch_size\";s:3:\"100\";s:19:\"default_result_page\";s:14:\"search/results\";s:15:\"search_log_size\";s:3:\"500\";s:12:\"ignore_words\";s:20:\"a an and the or of s\";s:16:\"disabled_filters\";a:0:{}s:10:\"stop_words\";s:3945:\"a\'s able about above according accordingly across actually after afterwards again against ain\'t\n            all allow allows almost alone along already also although always am among amongst an and another\n            any anybody anyhow anyone anything anyway anyways anywhere apart appear appreciate appropriate are\n            aren\'t around as aside ask asking associated at available away awfully be became because become\n            becomes becoming been before beforehand behind being believe below beside besides best better between\n            beyond both brief but by c\'mon c\'s came can can\'t cannot cant cause causes certain certainly changes\n            clearly co com come comes concerning consequently consider considering contain containing contains\n            corresponding could couldn\'t course currently definitely described despite did didn\'t different do\n            does doesn\'t doing don\'t done down downwards during each edu eg eight either else elsewhere enough\n            entirely especially et etc even ever every everybody everyone everything everywhere ex exactly example\n            except far few fifth first five followed following follows for former formerly forth four from further\n            furthermore get gets getting given gives go goes going gone got gotten greetings had hadn\'t happens\n            hardly has hasn\'t have haven\'t having he he\'s hello help hence her here here\'s hereafter hereby herein\n            hereupon hers herself hi him himself his hither hopefully how howbeit however i\'d i\'ll i\'m i\'ve ie if\n            ignored immediate in inasmuch inc indeed indicate indicated indicates inner insofar instead into\n            inward is isn\'t it it\'d it\'ll it\'s its itself just keep keeps kept know known knows last lately later\n            latter latterly least less lest let let\'s like liked likely little look looking looks ltd mainly many\n            may maybe me mean meanwhile merely might more moreover most mostly much must my myself name namely nd\n            near nearly necessary need needs neither never nevertheless new next nine no nobody non none noone nor\n            normally not nothing novel now nowhere obviously of off often oh ok okay old on once one ones only\n            onto or other others otherwise ought our ours ourselves out outside over overall own particular\n            particularly per perhaps placed please plus possible presumably probably provides que quite qv rather\n            rd re really reasonably regarding regardless regards relatively respectively right said same saw say\n            saying says second secondly see seeing seem seemed seeming seems seen self selves sensible sent\n            serious seriously seven several shall she should shouldn\'t since six so some somebody somehow someone\n            something sometime sometimes somewhat somewhere soon sorry specified specify specifying still sub such\n            sup sure t\'s take taken tell tends th than thank thanks thanx that that\'s thats the their theirs them\n            themselves then thence there there\'s thereafter thereby therefore therein theres thereupon these they\n            they\'d they\'ll they\'re they\'ve think third this thorough thoroughly those though three through\n            throughout thru thus to together too took toward towards tried tries truly try trying twice two un\n            under unfortunately unless unlikely until unto up upon us use used useful uses using usually value\n            various very via viz vs want wants was wasn\'t way we we\'d we\'ll we\'re we\'ve welcome well went were\n            weren\'t what what\'s whatever when whence whenever where where\'s whereafter whereas whereby wherein\n            whereupon wherever whether which while whither who who\'s whoever whole whom whose why will willing\n            wish with within without won\'t wonder would wouldn\'t yes yet you you\'d you\'ll you\'re you\'ve your\n            yours yourself yourselves zero\";s:10:\"can_manage\";a:0:{}s:20:\"can_manage_shortcuts\";a:0:{}s:18:\"can_manage_lexicon\";a:0:{}s:11:\"can_replace\";a:0:{}s:19:\"can_view_search_log\";a:0:{}s:20:\"can_view_replace_log\";a:0:{}}', 10, '8.0.0', 'y');

INSERT INTO `exp_field_groups` (`group_id`, `site_id`, `group_name`) VALUES
(1, 0, 'contact'),
(2, 0, 'about'),
(3, 0, 'blog'),
(4, 0, 'common'),
(5, 0, 'seo'),
(6, 0, 'testing');

INSERT INTO `exp_fieldtypes` (`fieldtype_id`, `name`, `version`, `settings`, `has_global_settings`) VALUES
(1, 'select', '1.0.0', 'YTowOnt9', 'n'),
(2, 'text', '1.0.0', 'YTowOnt9', 'n'),
(3, 'number', '1.0.0', 'YTowOnt9', 'n'),
(4, 'textarea', '1.0.0', 'YTowOnt9', 'n'),
(5, 'date', '1.0.0', 'YTowOnt9', 'n'),
(6, 'duration', '1.0.0', 'YTowOnt9', 'n'),
(7, 'email_address', '1.0.0', 'YTowOnt9', 'n'),
(8, 'file', '1.1.0', 'YTowOnt9', 'n'),
(9, 'fluid_field', '1.0.0', 'YTowOnt9', 'n'),
(10, 'grid', '1.0.0', 'YTowOnt9', 'n'),
(11, 'file_grid', '1.0.0', 'YTowOnt9', 'n'),
(12, 'multi_select', '1.0.0', 'YTowOnt9', 'n'),
(13, 'checkboxes', '1.0.0', 'YTowOnt9', 'n'),
(14, 'radio', '1.0.0', 'YTowOnt9', 'n'),
(15, 'relationship', '1.0.0', 'YTowOnt9', 'n'),
(16, 'rte', '2.1.0', 'YTowOnt9', 'n'),
(17, 'slider', '1.0.0', 'YTowOnt9', 'n'),
(18, 'range_slider', '1.0.0', 'YTowOnt9', 'n'),
(19, 'toggle', '1.0.0', 'YTowOnt9', 'n'),
(20, 'url', '1.0.0', 'YTowOnt9', 'n'),
(21, 'colorpicker', '1.0.0', 'YTowOnt9', 'n'),
(22, 'selectable_buttons', '1.0.0', 'YTowOnt9', 'n'),
(23, 'notes', '1.0.0', 'YTowOnt9', 'n'),
(24, 'structure', '6.0.0', 'YToxOntzOjE5OiJzdHJ1Y3R1cmVfbGlzdF90eXBlIjtzOjU6InBhZ2VzIjt9', 'n'),
(25, 'pro_variables', '5.0.2', 'YTowOnt9', 'n');

INSERT INTO `exp_file_dimensions` (`id`, `site_id`, `upload_location_id`, `title`, `short_name`, `resize_type`, `width`, `height`, `quality`, `watermark_id`) VALUES
(1, 1, 5, '', 'test', 'constrain', 100, 100, 90, 0);

INSERT INTO `exp_file_manager_views` (`view_id`, `viewtype`, `upload_id`, `member_id`, `name`, `columns`) VALUES
(1, 'list', 0, 1, '', 's:59:\"[\"title\",\"file_name\",\"file_type\",\"upload_date\",\"file_size\"]\";'),
(2, 'thumb', 0, 1, '', 's:21:\"[\"title\",\"file_size\"]\";');

INSERT INTO `exp_file_usage` (`file_id`, `entry_id`, `cat_id`) VALUES
(2, 3, 0),
(2, 4, 0),
(2, 2, 0),
(1, 13, 0);

INSERT INTO `exp_files` (`file_id`, `model_type`, `site_id`, `title`, `upload_location_id`, `directory_id`, `mime_type`, `file_type`, `file_name`, `file_size`, `description`, `credit`, `location`, `uploaded_by_member_id`, `upload_date`, `modified_by_member_id`, `modified_date`, `file_hw_original`, `total_records`) VALUES
(1, 'File', 1, 'blog.jpg', 4, 0, 'image/jpeg', 'img', 'blog.jpg', 339111, NULL, NULL, NULL, 0, 1666304930, 0, 1666304930, '900 1200', 1),
(2, 'File', 1, 'common.jpg', 5, 0, 'image/jpeg', 'img', 'common.jpg', 339111, NULL, NULL, NULL, 0, 1666304930, 0, 1666304930, '900 1200', 3),
(3, 'File', 1, 'path.jpg', 6, 0, 'image/jpeg', 'img', 'path.jpg', 289200, NULL, NULL, NULL, 0, 1666304930, 0, 1666304930, '502 1200', 0),
(4, 'File', 1, 'sky.jpg', 6, 0, 'image/jpeg', 'img', 'sky.jpg', 62326, NULL, NULL, NULL, 0, 1666304930, 0, 1666304930, '502 1200', 0),
(5, 'File', 1, 'lake.jpg', 6, 0, 'image/jpeg', 'img', 'lake.jpg', 286878, NULL, NULL, NULL, 0, 1666304930, 0, 1666304930, '502 1200', 0),
(6, 'File', 1, 'ocean.jpg', 6, 0, 'image/jpeg', 'img', 'ocean.jpg', 111529, NULL, NULL, NULL, 0, 1666304930, 0, 1666304930, '502 1200', 0);

INSERT INTO `exp_fluid_field_data` (`id`, `fluid_field_id`, `entry_id`, `field_id`, `field_data_id`, `order`) VALUES
(1, 19, 13, 12, 2, 1),
(2, 19, 13, 12, 3, 2),
(3, 19, 13, 14, 2, 3),
(6, 19, 13, 20, 3, 5),
(7, 19, 13, 27, 2, 4),
(8, 19, 13, 32, 3, 6);

INSERT INTO `exp_global_variables` (`variable_id`, `site_id`, `variable_name`, `variable_data`, `edit_date`) VALUES
(1, 0, 'gv_comment_expired', 'Commenting for this entry has <b>expired</b>.', 1669131554),
(2, 0, 'gv_entries_none', 'There are <b>no</b> entries in this channel.', 1669131554),
(3, 0, 'gv_sep', '&nbsp;/&nbsp;', 1669131554),
(4, 0, 'gv_comment_disabled', 'Commenting for this entry is <b>disabled</b>.', 1669131554),
(5, 0, 'gv_comment_ignore', 'You are ignoring', 1669131554),
(6, 0, 'gv_comment_none', 'There are <b>no</b> comments on this entry.', 1669131554),
(7, 1, 'gv_comment_expired', 'Commenting for this entry has <b>expired</b>.', 1670255034),
(8, 1, 'gv_entries_none', 'There are <b>no</b> entries in this channel.', 1670255034),
(9, 1, 'gv_sep', '&nbsp;/&nbsp;', 1670255034),
(10, 1, 'gv_comment_disabled', 'Commenting for this entry is <b>disabled</b>.', 1670255034),
(11, 1, 'gv_comment_ignore', 'You are ignoring', 1670255034),
(12, 1, 'gv_comment_none', 'There are <b>no</b> comments on this entry.', 1670255034),
(13, 0, 'rss_links', '<h5>RSS Feeds <img src=\"{site_url}themes/site/default/images/rss12.gif\" alt=\"RSS Icon\" class=\"rssicon\" /></h5>\n		<div id=\"news_rss\">\n			<p>Subscribe to our RSS Feeds</p>\n			<ul>\n				<li><a href=\"{path=\'news/rss\'}\">News RSS Feed</a></li>\n				<li><a href=\"{path=\'news/atom\'}\">News ATOM Feed</a></li>\n			</ul>\n		</div>', 1670255034),
(14, 0, 'html_close', '<p id=\"elapsed_time\">Elapsed time: <em>{elapsed_time}</em></p><p id=\"memory_usage\">Memory usage: <em>{memory_usage}</em></p></body>\n</html>', 1670255034),
(15, 0, 'branding_end', '</div> <!-- ending #branding_sub -->\n</div> <!-- ending #branding -->', 1670255034),
(16, 0, 'branding_begin', '<div id=\"branding\">\n	<div id=\"branding_logo\"></div>\n	<div id=\"branding_sub\">\n		<h1><a href=\"{site_url}\" title=\"Agile Records Home\"></a></h1>', 1670255034),
(17, 0, 'html_head', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n', 1670255034),
(18, 0, 'wrapper_close', '</div> <!-- ending #content_wrapper -->\n</div> <!-- ending #page -->', 1670255034),
(19, 0, '.htaccess', 'deny from all', 1670255034),
(20, 0, 'hp_featured', '1', 1670255034),
(21, 0, 'wrapper_begin', '<div id=\"page\">\n<div id=\"content_wrapper\">', 1670255034),
(22, 0, 'lv_test', '', 1670255034),
(23, 0, 'nav_access', '<ul id=\"nav_access\">\n	<li><a href=\"#navigation\">Skip to navigation</a></li>\n	<li><a href=\"#primary_content_wrapper\">Skip to content</a></li>\n</ul>', 1670255034),
(24, 0, 'favicon', '<!-- Favicon -->\n', 1670255034),
(25, 0, 'js', '<!-- JS -->\n<script src=\"http://code.jquery.com/jquery-1.12.1.min.js\" type=\"text/javascript\"></script>\n<script src=\"{site_url}themes/site/default/js/onload.js\" type=\"text/javascript\"></script>', 1670255034),
(26, 0, 'lv_checkbox', '2\n17\n18\n14\n1', 1670255034),
(27, 0, 'rss', '<!-- RSS -->\n<link href=\"{path=news/rss}\" rel=\"alternate\" type=\"application/rss+xml\" title=\"RSS Feed\" />', 1670255034),
(28, 0, 'html_head_end', '</head>\n', 1670255034),
(29, 0, 'comment_guidelines', '<div id=\"comment_guidelines\">\n	<h6>Comment Guidelines</h6>\n	<p>Basic HTML formatting permitted - <br />\n		<code>&lt;ul&gt;</code>, <code>&lt;li&gt;</code>, <code>&lt;strong&gt;</code>, <code>&lt;em&gt;</code>, <code>&lt;a href&gt;</code>, <code>&lt;blockquote&gt;</code>, <code>&lt;code&gt;</code></p>\n</div>', 1670255034),
(30, 1, 'rss_links', '<h5>RSS Feeds <img src=\"{site_url}themes/site/default/images/rss12.gif\" alt=\"RSS Icon\" class=\"rssicon\" /></h5>\n		<div id=\"news_rss\">\n			<p>Subscribe to our RSS Feeds</p>\n			<ul>\n				<li><a href=\"{path=\'news/rss\'}\">News RSS Feed</a></li>\n				<li><a href=\"{path=\'news/atom\'}\">News ATOM Feed</a></li>\n			</ul>\n		</div>', 1670255034),
(31, 1, 'html_close', '<p id=\"elapsed_time\">Elapsed time: <em>{elapsed_time}</em></p><p id=\"memory_usage\">Memory usage: <em>{memory_usage}</em></p></body>\n</html>', 1670255034),
(32, 1, 'branding_end', '</div> <!-- ending #branding_sub -->\n</div> <!-- ending #branding -->', 1670255034),
(33, 1, 'branding_begin', '<div id=\"branding\">\n	<div id=\"branding_logo\"></div>\n	<div id=\"branding_sub\">\n		<h1><a href=\"{site_url}\" title=\"Agile Records Home\"></a></h1>', 1670255034),
(34, 1, 'html_head', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n', 1670255034),
(35, 1, 'wrapper_close', '</div> <!-- ending #content_wrapper -->\n</div> <!-- ending #page -->', 1670255034),
(36, 1, '.htaccess', 'deny from all', 1670255034),
(37, 1, 'wrapper_begin', '<div id=\"page\">\n<div id=\"content_wrapper\">', 1670255034),
(38, 1, 'nav_access', '<ul id=\"nav_access\">\n	<li><a href=\"#navigation\">Skip to navigation</a></li>\n	<li><a href=\"#primary_content_wrapper\">Skip to content</a></li>\n</ul>', 1670255034),
(39, 1, 'favicon', '<!-- Favicon -->\n', 1670255034),
(40, 1, 'js', '<!-- JS -->\n<script src=\"http://code.jquery.com/jquery-1.12.1.min.js\" type=\"text/javascript\"></script>\n<script src=\"{site_url}themes/site/default/js/onload.js\" type=\"text/javascript\"></script>', 1670255034),
(41, 1, 'rss', '<!-- RSS -->\n<link href=\"{path=news/rss}\" rel=\"alternate\" type=\"application/rss+xml\" title=\"RSS Feed\" />', 1670255034),
(42, 1, 'html_head_end', '</head>\n', 1670255034),
(43, 1, 'comment_guidelines', '<div id=\"comment_guidelines\">\n	<h6>Comment Guidelines</h6>\n	<p>Basic HTML formatting permitted - <br />\n		<code>&lt;ul&gt;</code>, <code>&lt;li&gt;</code>, <code>&lt;strong&gt;</code>, <code>&lt;em&gt;</code>, <code>&lt;a href&gt;</code>, <code>&lt;blockquote&gt;</code>, <code>&lt;code&gt;</code></p>\n</div>', 1670255034);

INSERT INTO `exp_grid_columns` (`col_id`, `field_id`, `content_type`, `col_order`, `col_type`, `col_label`, `col_name`, `col_instructions`, `col_required`, `col_search`, `col_width`, `col_settings`) VALUES
(1, 3, 'channel', 0, 'text', 'Street', 'street', 'Street address', 'n', 'n', 0, '{\"field_fmt\":\"none\",\"field_content_type\":\"all\",\"field_text_direction\":\"ltr\",\"field_maxl\":\"256\",\"field_required\":\"n\"}'),
(2, 3, 'channel', 1, 'text', 'Street 2', 'street_2', 'Street address continued, e.g. Suite 2', 'n', 'n', 0, '{\"field_fmt\":\"none\",\"field_content_type\":\"all\",\"field_text_direction\":\"ltr\",\"field_maxl\":\"256\",\"field_required\":\"n\"}'),
(3, 3, 'channel', 2, 'text', 'City', 'city', '', 'n', 'n', 0, '{\"field_fmt\":\"none\",\"field_content_type\":\"all\",\"field_text_direction\":\"ltr\",\"field_maxl\":\"256\",\"field_required\":\"n\"}'),
(4, 3, 'channel', 3, 'text', 'State', 'state', '', 'n', 'n', 0, '{\"field_fmt\":\"none\",\"field_content_type\":\"all\",\"field_text_direction\":\"ltr\",\"field_maxl\":\"256\",\"field_required\":\"n\"}'),
(5, 3, 'channel', 4, 'text', 'ZIP', 'zip', '', 'n', 'n', 0, '{\"field_fmt\":\"none\",\"field_content_type\":\"all\",\"field_text_direction\":\"ltr\",\"field_maxl\":\"256\",\"field_required\":\"n\"}'),
(6, 4, 'channel', 0, 'file', 'Image', 'image', 'Upload the image you want to use.', 'n', 'n', 0, '{\"field_content_type\":\"image\",\"allowed_directories\":\"all\",\"show_existing\":\"y\",\"num_existing\":\"50\",\"field_fmt\":\"none\",\"field_required\":\"n\"}'),
(7, 4, 'channel', 1, 'text', 'Caption', 'caption', 'Credit and copyright for this image.', 'n', 'n', 0, '{\"field_fmt\":\"none\",\"field_content_type\":\"all\",\"field_text_direction\":\"ltr\",\"field_maxl\":\"256\",\"field_required\":\"n\"}'),
(8, 4, 'channel', 2, 'select', 'Alignment?', 'align', 'Align this image ot the left or right?', 'n', 'n', 0, '{\"field_fmt\":\"none\",\"field_pre_populate\":\"n\",\"field_pre_channel_id\":\"0\",\"field_pre_field_id\":\"0\",\"field_list_items\":\"none\\nleft\\nright\",\"value_label_pairs\":[],\"field_required\":\"n\"}'),
(9, 5, 'channel', 0, 'text', 'ID', 'id', 'Video ID, i.e. 8OcydG0RiqI', 'n', 'y', 0, '{\"field_fmt\":\"none\",\"field_content_type\":\"all\",\"field_text_direction\":\"ltr\",\"field_maxl\":\"256\",\"field_required\":\"n\"}'),
(10, 5, 'channel', 1, 'select', 'Type', 'type', 'Type of video, choose one.', 'n', 'y', 0, '{\"field_fmt\":\"none\",\"field_pre_populate\":\"n\",\"field_pre_channel_id\":\"0\",\"field_pre_field_id\":\"0\",\"field_list_items\":\"youtube\\nvimeo\",\"value_label_pairs\":[],\"field_required\":\"n\"}'),
(11, 7, 'channel', 0, 'file', 'Image', 'image', 'Upload the image you want to use.', 'n', 'y', 0, '{\"field_content_type\":\"image\",\"allowed_directories\":\"all\",\"show_existing\":\"y\",\"num_existing\":\"50\",\"field_fmt\":\"none\",\"field_required\":\"n\"}'),
(12, 7, 'channel', 1, 'text', 'Caption', 'caption', 'Credit and copyright for this image.', 'n', 'y', 0, '{\"field_fmt\":\"none\",\"field_content_type\":\"all\",\"field_text_direction\":\"ltr\",\"field_maxl\":\"256\",\"field_required\":\"n\"}'),
(13, 8, 'channel', 0, 'text', 'ID', 'id', 'Audio ID, i.e. 177363559', 'n', 'y', 0, '{\"field_fmt\":\"none\",\"field_content_type\":\"all\",\"field_text_direction\":\"ltr\",\"field_maxl\":\"256\",\"field_required\":\"n\"}'),
(14, 8, 'channel', 1, 'select', 'Type', 'type', 'Type of audio, choose one.', 'n', 'n', 0, '{\"field_fmt\":\"none\",\"field_pre_populate\":\"n\",\"field_pre_channel_id\":\"0\",\"field_pre_field_id\":\"0\",\"field_list_items\":\"soundcloud\\nbandcamp\",\"value_label_pairs\":[],\"field_required\":\"n\"}'),
(15, 18, 'channel', 0, 'file', 'File', 'file', '', 'n', 'y', 0, '{\"field_content_type\":\"image\",\"allowed_directories\":\"all\",\"show_existing\":\"\",\"num_existing\":0,\"field_fmt\":\"none\",\"field_required\":\"n\"}'),
(16, 18, 'channel', 1, 'text', 'test_file_grid_col', 'test_file_grid_col', '', 'n', 'n', 0, '{\"field_maxl\":\"256\",\"field_fmt\":\"none\",\"field_text_direction\":\"ltr\",\"field_content_type\":\"all\",\"field_required\":\"n\"}'),
(17, 20, 'channel', 0, 'text', 'test_grid_col', 'test_grid_col', '', 'n', 'n', 0, '{\"field_maxl\":\"256\",\"field_fmt\":\"none\",\"field_text_direction\":\"ltr\",\"field_content_type\":\"all\",\"field_required\":\"n\"}');

INSERT INTO `exp_html_buttons` (`id`, `site_id`, `member_id`, `tag_name`, `tag_open`, `tag_close`, `accesskey`, `tag_order`, `tag_row`, `classname`) VALUES
(1, 1, 0, 'html_btn_bold', '<strong>', '</strong>', 'b', 1, '1', 'html-bold'),
(2, 1, 0, 'html_btn_italic', '<em>', '</em>', 'i', 2, '1', 'html-italic'),
(3, 1, 0, 'html_btn_blockquote', '<blockquote>', '</blockquote>', 'q', 3, '1', 'html-quote'),
(4, 1, 0, 'html_btn_anchor', '<a href=\"[![Link:!:http://]!]\"(!( title=\"[![Title]!]\")!)>', '</a>', 'k', 4, '1', 'html-link'),
(5, 1, 0, 'html_btn_picture', '<img src=\"[![Link:!:http://]!]\" alt=\"[![Alternative text]!]\" />', '', '', 5, '1', 'html-upload');

INSERT INTO `exp_member_data` (`member_id`) VALUES
(1);

INSERT INTO `exp_member_fields` (`m_field_id`, `m_field_name`, `m_field_label`, `m_field_description`, `m_field_type`, `m_field_list_items`, `m_field_ta_rows`, `m_field_maxl`, `m_field_width`, `m_field_search`, `m_field_required`, `m_field_public`, `m_field_reg`, `m_field_cp_reg`, `m_field_fmt`, `m_field_show_fmt`, `m_field_exclude_from_anon`, `m_field_order`, `m_field_text_direction`, `m_field_settings`, `m_legacy_field_data`) VALUES
(1, 'custom_member_field', 'custom_member_field', '', 'textarea', '', 6, NULL, NULL, 'y', 'n', 'n', 'n', 'n', 'none', 'n', 'n', 1, 'ltr', '{\"field_show_file_selector\":\"n\",\"db_column_type\":\"text\",\"field_show_smileys\":\"n\",\"field_show_formatting_btns\":\"n\"}', 'n');

INSERT INTO `exp_member_news_views` (`news_id`, `version`, `member_id`) VALUES
(1, '7.0.2', 1);

INSERT INTO `exp_members` (`member_id`, `role_id`, `pending_role_id`, `username`, `screen_name`, `password`, `salt`, `unique_id`, `crypt_key`, `backup_mfa_code`, `authcode`, `email`, `signature`, `avatar_filename`, `avatar_width`, `avatar_height`, `photo_filename`, `photo_width`, `photo_height`, `sig_img_filename`, `sig_img_width`, `sig_img_height`, `ignore_list`, `private_messages`, `accept_messages`, `last_view_bulletins`, `last_bulletin_date`, `ip_address`, `join_date`, `last_visit`, `last_activity`, `total_entries`, `total_comments`, `total_forum_topics`, `total_forum_posts`, `last_entry_date`, `last_comment_date`, `last_forum_post_date`, `last_email_date`, `in_authorlist`, `accept_admin_email`, `accept_user_email`, `notify_by_default`, `notify_of_pm`, `display_signatures`, `parse_smileys`, `smart_notifications`, `language`, `timezone`, `time_format`, `date_format`, `include_seconds`, `profile_theme`, `forum_theme`, `tracker`, `template_size`, `notepad`, `notepad_size`, `bookmarklets`, `quick_links`, `quick_tabs`, `show_sidebar`, `pmember_id`, `cp_homepage`, `cp_homepage_channel`, `cp_homepage_custom`, `dismissed_banner`, `enable_mfa`) VALUES
(1, 1, 0, 'admin', 'admin', '$2y$10$sf.1VbpWyqNahvV.bxmRj.QjBPVyt12HDWjyretatpGjekQqVXvUy', '', '90167eb04b94d8e9e75e7a69b3f0bc6b97f07fc7', 'a0ee918a3d2db6d41cb852a691a8a8211338dcde', NULL, NULL, 'bryan@packettide.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'y', 0, 0, '127.0.0.1', 1666304930, 1676005278, 1676527607, 13, 7, 0, 0, 1667245500, 1666304949, 0, 0, 'n', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'english', 'UTC', NULL, NULL, NULL, NULL, NULL, NULL, '28', NULL, '18', NULL, '', NULL, 'n', 0, NULL, NULL, NULL, 'n', 'n');

INSERT INTO `exp_members_roles` (`member_id`, `role_id`) VALUES
(1, 1);

INSERT INTO `exp_menu_sets` (`set_id`, `name`) VALUES
(1, 'Default');

INSERT INTO `exp_modules` (`module_id`, `module_name`, `module_version`, `has_cp_backend`, `has_publish_fields`) VALUES
(1, 'Channel', '2.1.1', 'n', 'n'),
(2, 'Comment', '2.3.3', 'y', 'n'),
(3, 'Consent', '1.0.0', 'n', 'n'),
(4, 'Member', '2.3.0', 'n', 'n'),
(5, 'Stats', '2.2.0', 'n', 'n'),
(6, 'Rte', '2.1.0', 'y', 'n'),
(7, 'File', '1.1.0', 'n', 'n'),
(8, 'Filepicker', '1.0', 'y', 'n'),
(9, 'Relationship', '1.0.0', 'n', 'n'),
(10, 'Search', '2.3.0', 'n', 'n'),
(11, 'Pro', '2.0.0', 'n', 'n'),
(12, 'Email', '2.1.0', 'n', 'n'),
(13, 'Rss', '2.0.0', 'n', 'n'),
(14, 'Structure', '6.0.0', 'y', 'y'),
(15, 'Emoji', '1.0.0', 'n', 'n'),
(16, 'Pro_variables', '5.0.2', 'y', 'n'),
(17, 'Pro_search', '8.0.0', 'y', 'n');

INSERT INTO `exp_permissions` (`permission_id`, `role_id`, `site_id`, `permission`) VALUES
(1, 1, 1, 'can_view_offline_system'),
(2, 1, 1, 'can_access_cp'),
(3, 1, 1, 'can_access_dock'),
(4, 1, 1, 'can_access_footer_report_bug'),
(5, 1, 1, 'can_access_footer_new_ticket'),
(6, 1, 1, 'can_access_footer_user_guide'),
(7, 1, 1, 'can_view_homepage_news'),
(8, 1, 1, 'can_upload_new_files'),
(9, 1, 1, 'can_edit_files'),
(10, 1, 1, 'can_delete_files'),
(11, 1, 1, 'can_upload_new_toolsets'),
(12, 1, 1, 'can_edit_toolsets'),
(13, 1, 1, 'can_delete_toolsets'),
(14, 1, 1, 'can_create_upload_directories'),
(15, 1, 1, 'can_edit_upload_directories'),
(16, 1, 1, 'can_delete_upload_directories'),
(17, 1, 1, 'can_access_files'),
(18, 1, 1, 'can_access_design'),
(19, 1, 1, 'can_access_addons'),
(20, 1, 1, 'can_access_members'),
(21, 1, 1, 'can_access_sys_prefs'),
(22, 1, 1, 'can_access_comm'),
(23, 1, 1, 'can_access_utilities'),
(24, 1, 1, 'can_access_data'),
(25, 1, 1, 'can_access_logs'),
(26, 1, 1, 'can_admin_channels'),
(27, 1, 1, 'can_create_channels'),
(28, 1, 1, 'can_edit_channels'),
(29, 1, 1, 'can_delete_channels'),
(30, 1, 1, 'can_create_channel_fields'),
(31, 1, 1, 'can_edit_channel_fields'),
(32, 1, 1, 'can_delete_channel_fields'),
(33, 1, 1, 'can_create_statuses'),
(34, 1, 1, 'can_delete_statuses'),
(35, 1, 1, 'can_edit_statuses'),
(36, 1, 1, 'can_create_categories'),
(37, 1, 1, 'can_create_roles'),
(38, 1, 1, 'can_delete_roles'),
(39, 1, 1, 'can_edit_roles'),
(40, 1, 1, 'can_admin_design'),
(41, 1, 1, 'can_create_members'),
(42, 1, 1, 'can_edit_members'),
(43, 1, 1, 'can_delete_members'),
(44, 1, 1, 'can_admin_roles'),
(45, 1, 1, 'can_admin_mbr_templates'),
(46, 1, 1, 'can_ban_users'),
(47, 1, 1, 'can_admin_addons'),
(48, 1, 1, 'can_create_templates'),
(49, 1, 1, 'can_edit_templates'),
(50, 1, 1, 'can_delete_templates'),
(51, 1, 1, 'can_create_template_groups'),
(52, 1, 1, 'can_edit_template_groups'),
(53, 1, 1, 'can_delete_template_groups'),
(54, 1, 1, 'can_create_template_partials'),
(55, 1, 1, 'can_edit_template_partials'),
(56, 1, 1, 'can_delete_template_partials'),
(57, 1, 1, 'can_create_template_variables'),
(58, 1, 1, 'can_delete_template_variables'),
(59, 1, 1, 'can_edit_template_variables'),
(60, 1, 1, 'can_edit_categories'),
(61, 1, 1, 'can_delete_categories'),
(62, 1, 1, 'can_view_other_entries'),
(63, 1, 1, 'can_edit_other_entries'),
(64, 1, 1, 'can_assign_post_authors'),
(65, 1, 1, 'can_delete_self_entries'),
(66, 1, 1, 'can_delete_all_entries'),
(67, 1, 1, 'can_view_other_comments'),
(68, 1, 1, 'can_edit_own_comments'),
(69, 1, 1, 'can_delete_own_comments'),
(70, 1, 1, 'can_edit_all_comments'),
(71, 1, 1, 'can_delete_all_comments'),
(72, 1, 1, 'can_moderate_comments'),
(73, 1, 1, 'can_send_cached_email'),
(74, 1, 1, 'can_email_roles'),
(75, 1, 1, 'can_email_from_profile'),
(76, 1, 1, 'can_view_profiles'),
(77, 1, 1, 'can_edit_html_buttons'),
(78, 1, 1, 'can_post_comments'),
(79, 1, 1, 'can_delete_self'),
(80, 1, 1, 'can_send_private_messages'),
(81, 1, 1, 'can_attach_in_private_messages'),
(82, 1, 1, 'can_send_bulletins'),
(83, 1, 1, 'can_search'),
(84, 1, 1, 'can_create_entries'),
(85, 1, 1, 'can_edit_self_entries'),
(86, 1, 1, 'can_access_security_settings'),
(87, 1, 1, 'can_access_translate'),
(88, 1, 1, 'can_access_import'),
(89, 1, 1, 'can_access_sql_manager'),
(90, 1, 1, 'can_moderate_spam'),
(91, 1, 1, 'can_manage_consents'),
(92, 3, 1, 'can_view_online_system'),
(93, 4, 1, 'can_view_online_system'),
(94, 5, 1, 'can_view_online_system'),
(95, 5, 1, 'can_email_from_profile'),
(96, 5, 1, 'can_view_profiles'),
(97, 5, 1, 'can_edit_html_buttons'),
(98, 5, 1, 'can_delete_self'),
(99, 5, 1, 'can_send_private_messages'),
(100, 5, 1, 'can_attach_in_private_messages');

INSERT INTO `exp_plugins` (`plugin_id`, `plugin_name`, `plugin_package`, `plugin_version`, `is_typography_related`) VALUES
(1, 'Request', 'request', '1.0.1', 'n');

INSERT INTO `exp_pro_variables` (`variable_id`, `group_id`, `variable_label`, `variable_notes`, `variable_type`, `variable_settings`, `variable_order`, `early_parsing`, `is_hidden`, `save_as_file`, `edit_date`) VALUES
(1, 0, NULL, '', NULL, '', 0, 'n', 'n', 'n', 1668109514),
(2, 0, NULL, '', NULL, '', 1, 'n', 'n', 'n', 1668109514),
(3, 0, NULL, '', NULL, '', 2, 'n', 'n', 'n', 1668109514),
(4, 0, NULL, '', NULL, '', 3, 'n', 'n', 'n', 1668109514),
(5, 0, NULL, '', NULL, '', 4, 'n', 'n', 'n', 1668109514),
(6, 0, NULL, '', NULL, '', 5, 'n', 'n', 'n', 1668109514),
(7, 0, NULL, '', NULL, '', 6, 'n', 'n', 'n', 1668109514),
(8, 0, NULL, '', NULL, '', 7, 'n', 'n', 'n', 1668109514),
(9, 0, NULL, '', NULL, '', 8, 'n', 'n', 'n', 1668109514),
(10, 0, NULL, '', NULL, '', 9, 'n', 'n', 'n', 1668109514),
(11, 0, NULL, '', NULL, '', 10, 'n', 'n', 'n', 1668109514),
(12, 0, NULL, '', NULL, '', 11, 'n', 'n', 'n', 1668109514);

INSERT INTO `exp_prolets` (`prolet_id`, `source`, `class`) VALUES
(1, 'pro', 'Entries_pro'),
(2, 'structure', 'Structure_pro'),
(3, 'pro_variables', 'Pro_variables_pro');

INSERT INTO `exp_relationships` (`relationship_id`, `parent_id`, `child_id`, `field_id`, `fluid_field_data_id`, `grid_field_id`, `grid_col_id`, `grid_row_id`, `order`) VALUES
(9, 13, 12, 26, 0, 0, 0, 0, 1);

INSERT INTO `exp_role_settings` (`id`, `role_id`, `site_id`, `menu_set_id`, `mbr_delete_notify_emails`, `exclude_from_moderation`, `search_flood_control`, `prv_msg_send_limit`, `prv_msg_storage_limit`, `include_in_authorlist`, `include_in_memberlist`, `cp_homepage`, `cp_homepage_channel`, `cp_homepage_custom`, `require_mfa`) VALUES
(1, 1, 1, 1, NULL, 'y', 0, 20, 60, 'y', 'y', NULL, 0, NULL, 'n'),
(2, 2, 1, 1, NULL, 'n', 60, 20, 60, 'n', 'n', NULL, 0, NULL, 'n'),
(3, 3, 1, 1, NULL, 'n', 10, 20, 60, 'n', 'y', NULL, 0, NULL, 'n'),
(4, 4, 1, 1, NULL, 'n', 10, 20, 60, 'n', 'y', NULL, 0, NULL, 'n'),
(5, 5, 1, 1, NULL, 'n', 10, 20, 60, 'n', 'y', NULL, 0, NULL, 'n');

INSERT INTO `exp_roles` (`role_id`, `name`, `short_name`, `description`, `total_members`, `is_locked`) VALUES
(1, 'Super Admin', 'super_admin', NULL, 0, 'y'),
(2, 'Banned', 'banned', NULL, 0, 'n'),
(3, 'Guests', 'guests', NULL, 0, 'n'),
(4, 'Pending', 'pending', NULL, 0, 'n'),
(5, 'Members', 'members', NULL, 0, 'n');

INSERT INTO `exp_rte_toolsets` (`toolset_id`, `toolset_name`, `toolset_type`, `settings`) VALUES
(1, 'CKEditor Basic', 'ckeditor', 'YTo1OntzOjQ6InR5cGUiO3M6ODoiY2tlZGl0b3IiO3M6NzoidG9vbGJhciI7YTo2OntpOjA7czo0OiJib2xkIjtpOjE7czo2OiJpdGFsaWMiO2k6MjtzOjk6InVuZGVybGluZSI7aTozO3M6MTI6Im51bWJlcmVkTGlzdCI7aTo0O3M6MTI6ImJ1bGxldGVkTGlzdCI7aTo1O3M6NDoibGluayI7fXM6NjoiaGVpZ2h0IjtzOjM6IjIwMCI7czoxMDoidXBsb2FkX2RpciI7czozOiJhbGwiO3M6MTA6Im1lZGlhRW1iZWQiO2E6MTp7czoxNDoicHJldmlld3NJbkRhdGEiO2I6MTt9fQ=='),
(2, 'CKEditor Full', 'ckeditor', 'YTo1OntzOjQ6InR5cGUiO3M6ODoiY2tlZGl0b3IiO3M6NzoidG9vbGJhciI7YTozMDp7aTowO3M6NDoiYm9sZCI7aToxO3M6NjoiaXRhbGljIjtpOjI7czoxMzoic3RyaWtldGhyb3VnaCI7aTozO3M6OToidW5kZXJsaW5lIjtpOjQ7czo5OiJzdWJzY3JpcHQiO2k6NTtzOjExOiJzdXBlcnNjcmlwdCI7aTo2O3M6MTA6ImJsb2NrcXVvdGUiO2k6NztzOjQ6ImNvZGUiO2k6ODtzOjc6ImhlYWRpbmciO2k6OTtzOjEyOiJyZW1vdmVGb3JtYXQiO2k6MTA7czo0OiJ1bmRvIjtpOjExO3M6NDoicmVkbyI7aToxMjtzOjEyOiJudW1iZXJlZExpc3QiO2k6MTM7czoxMjoiYnVsbGV0ZWRMaXN0IjtpOjE0O3M6Nzoib3V0ZGVudCI7aToxNTtzOjY6ImluZGVudCI7aToxNjtzOjQ6ImxpbmsiO2k6MTc7czoxMToiZmlsZW1hbmFnZXIiO2k6MTg7czoxMToiaW5zZXJ0VGFibGUiO2k6MTk7czoxMDoibWVkaWFFbWJlZCI7aToyMDtzOjk6Imh0bWxFbWJlZCI7aToyMTtzOjE0OiJhbGlnbm1lbnQ6bGVmdCI7aToyMjtzOjE1OiJhbGlnbm1lbnQ6cmlnaHQiO2k6MjM7czoxNjoiYWxpZ25tZW50OmNlbnRlciI7aToyNDtzOjE3OiJhbGlnbm1lbnQ6anVzdGlmeSI7aToyNTtzOjE0OiJob3Jpem9udGFsTGluZSI7aToyNjtzOjE3OiJzcGVjaWFsQ2hhcmFjdGVycyI7aToyNztzOjg6InJlYWRNb3JlIjtpOjI4O3M6OToiZm9udENvbG9yIjtpOjI5O3M6MTk6ImZvbnRCYWNrZ3JvdW5kQ29sb3IiO31zOjY6ImhlaWdodCI7czozOiIyMDAiO3M6MTA6InVwbG9hZF9kaXIiO3M6MzoiYWxsIjtzOjEwOiJtZWRpYUVtYmVkIjthOjE6e3M6MTQ6InByZXZpZXdzSW5EYXRhIjtiOjE7fX0='),
(3, 'Redactor Basic', 'redactor', 'YTo0OntzOjQ6InR5cGUiO3M6ODoicmVkYWN0b3IiO3M6NzoidG9vbGJhciI7YToyOntzOjc6ImJ1dHRvbnMiO2E6Njp7aTowO3M6NDoiYm9sZCI7aToxO3M6NjoiaXRhbGljIjtpOjI7czo5OiJ1bmRlcmxpbmUiO2k6MztzOjI6Im9sIjtpOjQ7czoyOiJ1bCI7aTo1O3M6NDoibGluayI7fXM6NzoicGx1Z2lucyI7YTowOnt9fXM6NjoiaGVpZ2h0IjtzOjM6IjIwMCI7czoxMDoidXBsb2FkX2RpciI7czozOiJhbGwiO30='),
(4, 'Redactor Full', 'redactor', 'YTo0OntzOjQ6InR5cGUiO3M6ODoicmVkYWN0b3IiO3M6NzoidG9vbGJhciI7YToyOntzOjc6ImJ1dHRvbnMiO2E6MTY6e2k6MDtzOjQ6Imh0bWwiO2k6MTtzOjY6ImZvcm1hdCI7aToyO3M6NDoiYm9sZCI7aTozO3M6NjoiaXRhbGljIjtpOjQ7czo3OiJkZWxldGVkIjtpOjU7czo5OiJ1bmRlcmxpbmUiO2k6NjtzOjQ6InJlZG8iO2k6NztzOjQ6InVuZG8iO2k6ODtzOjI6Im9sIjtpOjk7czoyOiJ1bCI7aToxMDtzOjY6ImluZGVudCI7aToxMTtzOjc6Im91dGRlbnQiO2k6MTI7czozOiJzdXAiO2k6MTM7czozOiJzdWIiO2k6MTQ7czo0OiJsaW5rIjtpOjE1O3M6NDoibGluZSI7fXM6NzoicGx1Z2lucyI7YToxNTp7aTowO3M6OToiYWxpZ25tZW50IjtpOjE7czoxNjoicnRlX2RlZmluZWRsaW5rcyI7aToyO3M6MTE6ImZpbGVicm93c2VyIjtpOjM7czo1OiJwYWdlcyI7aTo0O3M6MTE6ImlubGluZXN0eWxlIjtpOjU7czo5OiJmb250Y29sb3IiO2k6NjtzOjc6ImxpbWl0ZXIiO2k6NztzOjc6ImNvdW50ZXIiO2k6ODtzOjEwOiJwcm9wZXJ0aWVzIjtpOjk7czoxMjoic3BlY2lhbGNoYXJzIjtpOjEwO3M6NToidGFibGUiO2k6MTE7czo1OiJ2aWRlbyI7aToxMjtzOjY6IndpZGdldCI7aToxMztzOjg6InJlYWRtb3JlIjtpOjE0O3M6MTA6ImZ1bGxzY3JlZW4iO319czo2OiJoZWlnaHQiO3M6MzoiMjAwIjtzOjEwOiJ1cGxvYWRfZGlyIjtzOjM6ImFsbCI7fQ==');

INSERT INTO `exp_security_hashes` (`hash_id`, `date`, `session_id`, `hash`) VALUES
(12, 1667329378, 'b569046174967322d9d7c2ec861d2094d42e2a5e', 'd0fa8b46c9efb6bfe1d3ff741f9eb139703b2481'),
(14, 1673297485, 'a073d3b4c2b696a43ff5b5a7ef96a74e672f2f77', '67abf6b4742755f9f57a95c6bae99b15be273562'),
(16, 1673973829, '04e544fd6258ff9d55e59bf7cd4a663afd6c4733', '7902993c433e89c3737008f34625e8f8d1ebc960'),
(17, 1675298767, 'ae0c4d09a6ba4b69206285ac07cc82e0e674b71e', 'c43496743d8cdc897ecf135c44163fbb0b81fecd');

INSERT INTO `exp_sites` (`site_id`, `site_label`, `site_name`, `site_description`, `site_color`, `site_bootstrap_checksums`, `site_pages`) VALUES
(1, 'Default Site', 'default_site', NULL, '', 'YToyOntzOjUzOiIvVXNlcnMvYnJ5YW5uaWVsc2VuL0NvZGUvY29pbHBhY2stdGVzdC8uL2VlL2luZGV4LnBocCI7czozMjoiNGE4YTA5ZjhmMjQ0ZDQ5NDFmODFiZGU4MmIzNjliNjEiO3M6NTU6Ii9Vc2Vycy9icnlhbm5pZWxzZW4vQ29kZS9FRS9uZXh0L2xhcmF2ZWwvLi9lZS9pbmRleC5waHAiO3M6MzI6IjRhOGEwOWY4ZjI0NGQ0OTQxZjgxYmRlODJiMzY5YjYxIjt9', 'YToxOntpOjE7YTozOntzOjM6InVybCI7czoyMDoiaHR0cDovL2xhcmF2ZWwudGVzdC8iO3M6NDoidXJpcyI7YTozOntpOjI7czoyMToiL2Fib3V0LWRlZmF1bHQtdGhlbWUvIjtpOjM7czozNDoiL2Fib3V0LWRlZmF1bHQtdGhlbWUvc3ViLXBhZ2Utb25lLyI7aTo0O3M6MzQ6Ii9hYm91dC1kZWZhdWx0LXRoZW1lL3N1Yi1wYWdlLXR3by8iO31zOjk6InRlbXBsYXRlcyI7YTozOntpOjI7aToxNDtpOjM7aToxNDtpOjQ7aToxNDt9fX0=');

INSERT INTO `exp_snippets` (`snippet_id`, `site_id`, `snippet_name`, `snippet_contents`, `edit_date`) VALUES
(1, 0, 'snp_blog_list_paginate', '{!-- pagination --}\n{paginate}\n	<div class=\"paginate\">\n		{pagination_links page_padding=\'1\'}\n			<ul>\n				{previous_page}\n					<li><a href=\"{pagination_url}\">Previous Page</a></li>\n				{/previous_page}\n				{page}\n					<li><a href=\"{pagination_url}\"{if current_page} class=\"act\"{/if}>{pagination_page_number}</a></li>\n				{/page}\n				{next_page}\n					<li><a href=\"{pagination_url}\">Next Page</a></li>\n				{/next_page}\n			</ul>\n		{/pagination_links}\n	</div>\n{/paginate}', 1669134532),
(2, 0, 'snp_main_nav', '					<ul class=\"main-nav\">\n						<li><a{if segment_1 == \'\'} class=\"act\"{/if} href=\"{homepage}\">Home</a></li>\n						<li><a{if segment_1 == \'about\'} class=\"act\"{/if} href=\"{path=\'about\'}\">About</a></li>\n						<li><a{if segment_1 == \'blog\'} class=\"act\"{/if} href=\"{path=\'blog\'}\">Blog</a></li>\n						<li><a{if segment_1 == \'contact\'} class=\"act\"{/if} href=\"{path=\'contact\'}\">Contact</a></li>\n					</ul>', 1669134532),
(3, 0, 'snp_blog_list', '<div class=\"entry\">\n	{!-- title --}\n	<h2><a href=\"{path=\'{p_url}/{p_url_entry}/{url_title}\'}\">{title}</a></h2>\n	<p><b>on:</b> {entry_date format=\'%n/%j/%Y\'}, <b>by:</b> <a href=\"{path=\'member/{author_id}\'}\">{author}</a>, <a href=\"{path=\'{p_url}/{p_url_entry}/{url_title}#comments\'}\">{comment_total} comment{if comment_total != 1}s{/if}</a></p>\n</div>', 1669134532),
(4, 0, 'global_footer', '<div id=\"siteinfo\">\n    <p>Copyright @ {exp:channel:entries limit=\"1\" sort=\"asc\" disable=\"custom_fields|comments|pagination|categories\"}\n\n{if \"{entry_date format=\'%Y\'}\" != \"{current_time format=\'%Y\'}\"}{entry_date format=\"%Y\"} - {/if}{/exp:channel:entries} {current_time format=\"%Y\"}, powered by <a href=\"http://expressionengine.com\">ExpressionEngine</a></p>\n    <p class=\"logo\"><a href=\"#\">Agile Records</a></p>\n	{if group_id == \"1\"}<p>{total_queries} queries in {elapsed_time} seconds</p>{/if}\n</div> <!-- ending #siteinfo -->', 1669134532),
(5, 0, 'global_strict_urls', '<!-- Strict URLS: https://docs.expressionengine.com/latest/cp/templates/global_template_preferences.html -->\n{if segment_2 != \'\'}\n  {redirect=\"404\"}\n{/if}', 1669134532),
(6, 0, 'news_categories', '<div id=\"sidebar_category_archives\">\n      		<h5>Categories</h5>\n  			<ul id=\"categories\">\n  				<!-- Weblog Categories tag: https://docs.expressionengine.com/latest/modules/weblog/categories.html -->\n				\n  				{exp:channel:categories channel=\"news\" style=\"linear\"}\n  				<li><a href=\"{path=\'news/archives\'}\">{category_name}</a></li>\n  				{/exp:channel:categories}\n  			</ul>\n  		</div>', 1669134532),
(7, 0, 'global_top_search', '<!-- Simple Search Form: https://docs.expressionengine.com/latest/modules/search/index.html#simple \n\nThe parameters here help to identify what templates to use and where to search:\n\nResults page - result_page: https://docs.expressionengine.com/latest/modules/search/simple.html#par_result_page\n\nNo Results found: no_result_page: https://docs.expressionengine.com/latest/modules/search/simple.html#par_no_result_page\n\nsearch_in - search in titles? titles and entries? titles, entries?  https://docs.expressionengine.com/latest/modules/search/simple.html#par_search_in-->\n\n{exp:search:simple_form channel=\"news\" result_page=\"search/results\" no_result_page=\"search/no_results\" search_in=\"everywhere\"}\n<fieldset>\n    <label for=\"search\">Search:</label>\n    <input type=\"text\" name=\"keywords\" id=\"search\" value=\"\"  />\n	<input type=\"image\" id=\"submit\" name=\"submit\" class=\"submit\" src=\"{site_url}themes/site/default/images/spacer.gif\" />\n</fieldset>\n{/exp:search:simple_form}', 1669134532),
(8, 0, 'global_stylesheets', '<!-- CSS -->\n<!-- This makes use of the stylesheet= parameter, which automatically appends a time stamp to allow for the browser\'s caching mechanism to cache the stylesheet.  This allows for faster page-loads times.\nStylesheet linking is documented at https://docs.expressionengine.com/latest/templates/globals/stylesheet.html -->\n    <link href=\"{stylesheet=global_embeds/site_css}\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" />\n    <!--[if IE 6]><link href=\"{stylesheet=global_embeds/css_screen-ie6}\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n    <!--[if IE 7]><link href=\"{stylesheet=global_embeds/css_screen-ie7}\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n', 1669134532),
(9, 0, '.htaccess', 'deny from all', 1669134532),
(10, 0, 'global_top_member', '<div id=\"member\">\n\n	<!-- Utilized member conditionals: https://docs.expressionengine.com/latest/templates/globals/conditionals.html-->\n            <h4>Hello{if logged_in} {screen_name}{/if}!</h4>\n            			<ul>\n				{if logged_in}\n                <li><a href=\"{path=\'member/profile\'}\">Your Home</a></li>\n                <li><a href=\"{path=LOGOUT}\">Log out</a></li>\n				{/if}\n				{if logged_out}\n				<li><a href=\"{path=\'member/register\'}\">Register</a></li>\n				<li><a href=\"{path=\'member/login\'}\">Log in</a></li>\n				{/if}\n            </ul>\n        </div> <!-- ending #member -->', 1669134532),
(11, 0, 'news_popular', '<h5>Popular News Items</h5>\n\n<!-- Channel Entries tag ordered by track views for \"popular posts\".  See Tracking Entry Views at https://docs.expressionengine.com/latest/modules/weblog/entry_tracking.html -->\n\n{exp:channel:entries channel=\"news\" limit=\"4\" disable=\"categories|custom_fields|category_fields|trackbacks|pagination|member_data\" dynamic=\"no\"}\n	{if count == \"1\"}<ul>{/if}\n		<li><a href=\"{comment_url_title_auto_path}\">{title}</a> </li>\n	{if count == total_results}</ul>{/if}\n{/exp:channel:entries}', 1669134532),
(12, 0, 'global_featured_band', '<div id=\"featured_band\">\n    <h2>Featured Band</h2>\n    {exp:channel:entries channel=\"news\" limit=\"1\" status=\"featured\" rdf=\"off\" disable=\"trackbacks\" category=\"2\" dynamic=\"no\"}\n    <div class=\"image\">\n        <h4><a href=\"{comment_url_title_auto_path}\"><span>{title}</span></a></h4>\n        {if news_image}\n			<img src=\"{news_image}\" alt=\"{title}\"/>\n		{/if}\n    </div>\n    {news_body}\n    {/exp:channel:entries}\n</div>', 1669134532),
(13, 0, 'global_featured_welcome', '<div id=\"welcome\">\n    {exp:channel:entries channel=\"about\" url_title=\"about_the_label\" dynamic=\"no\"  limit=\"1\" disable=\"pagination|member_date|categories|category_fields|trackbacks\"}\n    {if about_image != \"\"}\n        <img src=\"{about_image}\" alt=\"map\" width=\"210\" height=\"170\" />\n    {/if}\n    {about_body}\n    <a href=\"{comment_url_title_auto_path}\">Read more about us</a>\n    {/exp:channel:entries}\n</div>', 1669134532),
(14, 0, 'fluid_slide', '{fluid:slide}\n    <div class=\"slide\">\n    <small>Group Name: {fluid:current_group_name}</small>\n    <small>Previous/Next Groups: {fluid:prev_group_name}/{fluid:next_group_name}</small>\n    <h2>\n        {fields}\n            {fluid:heading}FIRST heading - {content}{/fluid:heading}\n        {/fields}\n    </h2>\n\n    <div style=\"color:red;\">\n        {fields}\n            {fluid:url}<p>url - {content}</p>{/fluid:url}\n        {/fields}\n    </div>\n\n    {fields}\n        {fluid:heading}<h1>heading - {content}</h1>{/fluid:heading}\n        {fluid:url}<p>url - {content}</p>{/fluid:url}\n        {fluid:people}\n            <table>\n                <thead>\n                    <tr>\n                        <th>First</th>\n                        <th>Last</th>\n                    </tr>\n                </thead>\n                <tbody>\n                    {content}\n                        <tr>\n                            <td>{content:first_name}</td>\n                            <td>{content:last_name}</td>\n                        </tr>\n                    {/content}\n                </tbody>\n            </table>\n        {/fluid:people}\n    {/fields}\n</div>\n{/fluid:slide}', 1669134532),
(15, 0, 'global_edit_this', '{if author_id == logged_in_member_id OR logged_in_group_id == \"1\"}&bull; <a href=\"{cp_url}?S={cp_session_id}&amp;D=cp&amp;C=content_publish&amp;M=entry_form&amp;channel_id={channel_id}&amp;entry_id={entry_id}\">Edit This</a>{/if}', 1669134532),
(16, 0, 'news_month_archives', '<div id=\"sidebar_date_archives\">\n    	    <h5>Date Archives</h5>\n    		<ul id=\"months\">\n    			{!-- Archive Month Link Tags: https://docs.expressionengine.com/latest/modules/weblog/archive_month_links.html --}\n		\n    			{exp:channel:month_links channel=\"news\" limit=\"50\"}\n    			<li><a href=\"{path=\'news/archives\'}\">{month}, {year}</a></li>\n    			{/exp:channel:month_links}\n    		</ul>\n    	</div>', 1669134532),
(17, 0, 'news_calendar', '<h5>Calendar</h5>\n		<div id=\"news_calendar\">\n			\n			<!-- Channel Calendar Tag: https://docs.expressionengine.com/latest/modules/channel/calendar.html -->\n			\n			{exp:channel:calendar switch=\"calendarToday|calendarCell\" channel=\"news\"}\n			<table class=\"calendarBG\" border=\"0\" cellpadding=\"6\" cellspacing=\"1\" summary=\"My Calendar\">\n			<tr class=\"calendarHeader\">\n			<th><div class=\"calendarMonthLinks\"><a href=\"{previous_path=\'news/archives\'}\">&lt;&lt;</a></div></th>\n			<th colspan=\"5\">{date format=\"%F %Y\"}</th>\n			<th><div class=\"calendarMonthLinks\"><a class=\"calendarMonthLinks\" href=\"{next_path=\'news/archives\'}\">&gt;&gt;</a></div></th>\n			</tr>\n			<tr>\n			{calendar_heading}\n			<td class=\"calendarDayHeading\">{lang:weekday_abrev}</td>\n			{/calendar_heading}\n			</tr>\n\n			{calendar_rows }\n			{row_start}<tr>{/row_start}\n\n			{if entries}\n			<td class=\'{switch}\' align=\'center\'><a href=\"{day_path=\'news/archives\'}\">{day_number}</a></td>\n			{/if}\n\n			{if not_entries}\n			<td class=\'{switch}\' align=\'center\'>{day_number}</td>\n			{/if}\n\n			{if blank}\n			<td class=\'calendarBlank\'>{day_number}</td>\n			{/if}\n\n			{row_end}</tr>{/row_end}\n			{/calendar_rows}\n			</table>\n			{/exp:channel:calendar}\n		</div> <!-- ending #news_calendar -->', 1669134532),
(18, 1, 'global_footer', '<div id=\"siteinfo\">\n    <p>Copyright @ {exp:channel:entries limit=\"1\" sort=\"asc\" disable=\"custom_fields|comments|pagination|categories\"}\n\n{if \"{entry_date format=\'%Y\'}\" != \"{current_time format=\'%Y\'}\"}{entry_date format=\"%Y\"} - {/if}{/exp:channel:entries} {current_time format=\"%Y\"}, powered by <a href=\"http://expressionengine.com\">ExpressionEngine</a></p>\n    <p class=\"logo\"><a href=\"#\">Agile Records</a></p>\n	{if group_id == \"1\"}<p>{total_queries} queries in {elapsed_time} seconds</p>{/if}\n</div> <!-- ending #siteinfo -->', 1669134532),
(19, 1, 'global_strict_urls', '<!-- Strict URLS: https://docs.expressionengine.com/latest/cp/templates/global_template_preferences.html -->\n{if segment_2 != \'\'}\n  {redirect=\"404\"}\n{/if}', 1669134532),
(20, 1, 'news_categories', '<div id=\"sidebar_category_archives\">\n      		<h5>Categories</h5>\n  			<ul id=\"categories\">\n  				<!-- Weblog Categories tag: https://docs.expressionengine.com/latest/modules/weblog/categories.html -->\n				\n  				{exp:channel:categories channel=\"news\" style=\"linear\"}\n  				<li><a href=\"{path=\'news/archives\'}\">{category_name}</a></li>\n  				{/exp:channel:categories}\n  			</ul>\n  		</div>', 1669134532),
(21, 1, 'global_top_search', '<!-- Simple Search Form: https://docs.expressionengine.com/latest/modules/search/index.html#simple \n\nThe parameters here help to identify what templates to use and where to search:\n\nResults page - result_page: https://docs.expressionengine.com/latest/modules/search/simple.html#par_result_page\n\nNo Results found: no_result_page: https://docs.expressionengine.com/latest/modules/search/simple.html#par_no_result_page\n\nsearch_in - search in titles? titles and entries? titles, entries?  https://docs.expressionengine.com/latest/modules/search/simple.html#par_search_in-->\n\n{exp:search:simple_form channel=\"news\" result_page=\"search/results\" no_result_page=\"search/no_results\" search_in=\"everywhere\"}\n<fieldset>\n    <label for=\"search\">Search:</label>\n    <input type=\"text\" name=\"keywords\" id=\"search\" value=\"\"  />\n	<input type=\"image\" id=\"submit\" name=\"submit\" class=\"submit\" src=\"{site_url}themes/site/default/images/spacer.gif\" />\n</fieldset>\n{/exp:search:simple_form}', 1669134532),
(22, 1, 'global_stylesheets', '<!-- CSS -->\n<!-- This makes use of the stylesheet= parameter, which automatically appends a time stamp to allow for the browser\'s caching mechanism to cache the stylesheet.  This allows for faster page-loads times.\nStylesheet linking is documented at https://docs.expressionengine.com/latest/templates/globals/stylesheet.html -->\n    <link href=\"{stylesheet=global_embeds/site_css}\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" />\n    <!--[if IE 6]><link href=\"{stylesheet=global_embeds/css_screen-ie6}\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n    <!--[if IE 7]><link href=\"{stylesheet=global_embeds/css_screen-ie7}\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n', 1669134532),
(23, 1, '.htaccess', 'deny from all', 1669134532),
(24, 1, 'global_top_member', '<div id=\"member\">\n\n	<!-- Utilized member conditionals: https://docs.expressionengine.com/latest/templates/globals/conditionals.html-->\n            <h4>Hello{if logged_in} {screen_name}{/if}!</h4>\n            			<ul>\n				{if logged_in}\n                <li><a href=\"{path=\'member/profile\'}\">Your Home</a></li>\n                <li><a href=\"{path=LOGOUT}\">Log out</a></li>\n				{/if}\n				{if logged_out}\n				<li><a href=\"{path=\'member/register\'}\">Register</a></li>\n				<li><a href=\"{path=\'member/login\'}\">Log in</a></li>\n				{/if}\n            </ul>\n        </div> <!-- ending #member -->', 1669134532),
(25, 1, 'news_popular', '<h5>Popular News Items</h5>\n\n<!-- Channel Entries tag ordered by track views for \"popular posts\".  See Tracking Entry Views at https://docs.expressionengine.com/latest/modules/weblog/entry_tracking.html -->\n\n{exp:channel:entries channel=\"news\" limit=\"4\" disable=\"categories|custom_fields|category_fields|trackbacks|pagination|member_data\" dynamic=\"no\"}\n	{if count == \"1\"}<ul>{/if}\n		<li><a href=\"{comment_url_title_auto_path}\">{title}</a> </li>\n	{if count == total_results}</ul>{/if}\n{/exp:channel:entries}', 1669134532),
(26, 1, 'global_featured_band', '<div id=\"featured_band\">\n    <h2>Featured Band</h2>\n    {exp:channel:entries channel=\"news\" limit=\"1\" status=\"featured\" rdf=\"off\" disable=\"trackbacks\" category=\"2\" dynamic=\"no\"}\n    <div class=\"image\">\n        <h4><a href=\"{comment_url_title_auto_path}\"><span>{title}</span></a></h4>\n        {if news_image}\n			<img src=\"{news_image}\" alt=\"{title}\"/>\n		{/if}\n    </div>\n    {news_body}\n    {/exp:channel:entries}\n</div>', 1669134532),
(27, 1, 'global_featured_welcome', '<div id=\"welcome\">\n    {exp:channel:entries channel=\"about\" url_title=\"about_the_label\" dynamic=\"no\"  limit=\"1\" disable=\"pagination|member_date|categories|category_fields|trackbacks\"}\n    {if about_image != \"\"}\n        <img src=\"{about_image}\" alt=\"map\" width=\"210\" height=\"170\" />\n    {/if}\n    {about_body}\n    <a href=\"{comment_url_title_auto_path}\">Read more about us</a>\n    {/exp:channel:entries}\n</div>', 1669134532),
(28, 1, 'global_edit_this', '{if author_id == logged_in_member_id OR logged_in_group_id == \"1\"}&bull; <a href=\"{cp_url}?S={cp_session_id}&amp;D=cp&amp;C=content_publish&amp;M=entry_form&amp;channel_id={channel_id}&amp;entry_id={entry_id}\">Edit This</a>{/if}', 1669134532),
(29, 1, 'news_month_archives', '<div id=\"sidebar_date_archives\">\n    	    <h5>Date Archives</h5>\n    		<ul id=\"months\">\n    			{!-- Archive Month Link Tags: https://docs.expressionengine.com/latest/modules/weblog/archive_month_links.html --}\n		\n    			{exp:channel:month_links channel=\"news\" limit=\"50\"}\n    			<li><a href=\"{path=\'news/archives\'}\">{month}, {year}</a></li>\n    			{/exp:channel:month_links}\n    		</ul>\n    	</div>', 1669134532),
(30, 1, 'news_calendar', '<h5>Calendar</h5>\n		<div id=\"news_calendar\">\n			\n			<!-- Channel Calendar Tag: https://docs.expressionengine.com/latest/modules/channel/calendar.html -->\n			\n			{exp:channel:calendar switch=\"calendarToday|calendarCell\" channel=\"news\"}\n			<table class=\"calendarBG\" border=\"0\" cellpadding=\"6\" cellspacing=\"1\" summary=\"My Calendar\">\n			<tr class=\"calendarHeader\">\n			<th><div class=\"calendarMonthLinks\"><a href=\"{previous_path=\'news/archives\'}\">&lt;&lt;</a></div></th>\n			<th colspan=\"5\">{date format=\"%F %Y\"}</th>\n			<th><div class=\"calendarMonthLinks\"><a class=\"calendarMonthLinks\" href=\"{next_path=\'news/archives\'}\">&gt;&gt;</a></div></th>\n			</tr>\n			<tr>\n			{calendar_heading}\n			<td class=\"calendarDayHeading\">{lang:weekday_abrev}</td>\n			{/calendar_heading}\n			</tr>\n\n			{calendar_rows }\n			{row_start}<tr>{/row_start}\n\n			{if entries}\n			<td class=\'{switch}\' align=\'center\'><a href=\"{day_path=\'news/archives\'}\">{day_number}</a></td>\n			{/if}\n\n			{if not_entries}\n			<td class=\'{switch}\' align=\'center\'>{day_number}</td>\n			{/if}\n\n			{if blank}\n			<td class=\'calendarBlank\'>{day_number}</td>\n			{/if}\n\n			{row_end}</tr>{/row_end}\n			{/calendar_rows}\n			</table>\n			{/exp:channel:calendar}\n		</div> <!-- ending #news_calendar -->', 1669134532);

INSERT INTO `exp_specialty_templates` (`template_id`, `site_id`, `enable_template`, `template_name`, `data_title`, `template_type`, `template_subtype`, `template_data`, `template_notes`, `edit_date`, `last_author_id`) VALUES
(1, 1, 'y', 'offline_template', '', 'system', NULL, '<!doctype html>\n<html dir=\"ltr\">\n    <head>\n        <title>System Offline</title>\n        <meta content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\"  name=\"viewport\">\n\n        <style type=\"text/css\">\n:root, body {\n    --ee-panel-bg: #fff;\n    --ee-panel-border: #dfe0ef;\n    --ee-text-normal: #0d0d19;\n    --ee-main-bg: #f7f7fb;\n    --ee-link: #5D63F1;\n    --ee-link-hover: #171feb;\n}\n\n*, :after, :before {\n    box-sizing: inherit;\n}\n\nhtml {\n    box-sizing: border-box;\n    font-size: 15px;\n    height: 100%;\n    line-height: 1.15;\n}\n\nbody {\n    font-family: -apple-system, BlinkMacSystemFont, segoe ui, helvetica neue, helvetica, Cantarell, Ubuntu, roboto, noto, arial, sans-serif;\n    height: 100%;\n    font-size: 1rem;\n    line-height: 1.6;\n    color: var(--ee-text-normal);\n    background: var(--ee-main-bg);\n    -webkit-font-smoothing: antialiased;\n    margin: 0;\n}\n\n.panel {\n    margin-bottom: 20px;\n    background-color: var(--ee-panel-bg);\n    border: 1px solid var(--ee-panel-border);\n    border-radius: 6px;\n}\n.redirect {\n	max-width: 700px;\n	min-width: 350px;\n    position: absolute;\n    top: 50%;\n    left: 50%;\n    transform: translate(-50%,-50%);\n}\n\n.panel-heading {\n    padding: 20px 25px;\n    position: relative;\n}\n\n.panel-body {\n    padding: 20px 25px;\n}\n\n.panel-body:after, .panel-body:before {\n    content: \" \";\n    display: table;\n}\n\n.redirect p {\n    margin-bottom: 20px;\n}\np {\n    line-height: 1.6;\n}\na, blockquote, code, h1, h2, h3, h4, h5, h6, ol, p, pre, ul {\n    color: inherit;\n    margin: 0;\n    padding: 0;\n    font-weight: inherit;\n}\n\na {\n    color: var(--ee-link);\n    text-decoration: none;\n    -webkit-transition: color .15s ease-in-out;\n    -moz-transition: color .15s ease-in-out;\n    -o-transition: color .15s ease-in-out;\n}\n\na:hover {\n    color: var(--ee-link-hover);\n}\n\nh3 {\n    font-size: 1.35em;\n    font-weight: 500;\n}\n\nol, ul {\n    padding-left: 0;\n}\n\nol li, ul li {\n    list-style-position: inside;\n}\n\n.panel-footer {\n    padding: 20px 25px;\n    position: relative;\n}\n\n\n        </style>\n    </head>\n    <body>\n        <section class=\"flex-wrap\">\n            <section class=\"wrap\">\n                <div class=\"panel redirect\">\n                    <div class=\"panel-heading\">\n                        <h3>System Offline</h3>\n                    </div>\n					<div class=\"panel-body\">\n					This site is currently offline\n                    </div>\n                </div>\n            </section>\n        </section>\n    </body>\n</html>', NULL, 1666304930, 0),
(2, 1, 'y', 'message_template', '', 'system', NULL, '<!doctype html>\n<html dir=\"ltr\">\n    <head>\n        <title>{title}</title>\n        <meta http-equiv=\"content-type\" content=\"text/html; charset={charset}\">\n        <meta content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\"  name=\"viewport\">\n        <meta name=\"referrer\" content=\"no-referrer\">\n        {meta_refresh}\n        <style type=\"text/css\">\n:root, body {\n    --ee-panel-bg: #fff;\n    --ee-panel-border: #dfe0ef;\n    --ee-text-normal: #0d0d19;\n    --ee-main-bg: #f7f7fb;\n    --ee-link: #5D63F1;\n    --ee-link-hover: #171feb;\n}\n\n*, :after, :before {\n    box-sizing: inherit;\n}\n\nhtml {\n    box-sizing: border-box;\n    font-size: 15px;\n    height: 100%;\n    line-height: 1.15;\n}\n\nbody {\n    font-family: -apple-system, BlinkMacSystemFont, segoe ui, helvetica neue, helvetica, Cantarell, Ubuntu, roboto, noto, arial, sans-serif;\n    height: 100%;\n    font-size: 1rem;\n    line-height: 1.6;\n    color: var(--ee-text-normal);\n    background: var(--ee-main-bg);\n    -webkit-font-smoothing: antialiased;\n    margin: 0;\n}\n\n.panel {\n    margin-bottom: 20px;\n    background-color: var(--ee-panel-bg);\n    border: 1px solid var(--ee-panel-border);\n    border-radius: 6px;\n}\n.redirect {\n	max-width: 700px;\n	min-width: 350px;\n    position: absolute;\n    top: 50%;\n    left: 50%;\n    transform: translate(-50%,-50%);\n}\n\n.panel-heading {\n    padding: 20px 25px;\n    position: relative;\n}\n\n.panel-body {\n    padding: 20px 25px;\n}\n\n.panel-body:after, .panel-body:before {\n    content: \" \";\n    display: table;\n}\n\n.redirect p {\n    margin-bottom: 20px;\n}\np {\n    line-height: 1.6;\n}\na, blockquote, code, h1, h2, h3, h4, h5, h6, ol, p, pre, ul {\n    color: inherit;\n    margin: 0;\n    padding: 0;\n    font-weight: inherit;\n}\n\na {\n    color: var(--ee-link);\n    text-decoration: none;\n    -webkit-transition: color .15s ease-in-out;\n    -moz-transition: color .15s ease-in-out;\n    -o-transition: color .15s ease-in-out;\n}\n\na:hover {\n    color: var(--ee-link-hover);\n}\n\nh3 {\n    font-size: 1.35em;\n    font-weight: 500;\n}\n\nol, ul {\n    padding-left: 0;\n}\n\nol li, ul li {\n    list-style-position: inside;\n}\n\n.panel-footer {\n    padding: 20px 25px;\n    position: relative;\n}\n\n\n        </style>\n    </head>\n    <body>\n        <section class=\"flex-wrap\">\n            <section class=\"wrap\">\n                <div class=\"panel redirect\">\n                    <div class=\"panel-heading\">\n                        <h3>{heading}</h3>\n                    </div>\n                    <div class=\"panel-body\">\n                        {content}\n\n\n                    </div>\n                    <div class=\"panel-footer\">\n                        {link}\n                    </div>\n                </div>\n            </section>\n        </section>\n    </body>\n</html>', NULL, 1666304930, 0),
(3, 1, 'y', 'post_install_message_template', '', 'system', NULL, '<!doctype html>\n<html>\n	<head>\n		<title>Welcome to ExpressionEngine!</title>\n		<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" lang=\"en-us\" dir=\"ltr\">\n		<meta content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\"  name=\"viewport\">\n		<link href=\"{theme_folder_url}cp/css/common.min.css\" rel=\"stylesheet\">\n			</head>\n	<body class=\"installer-page\">\n		<section class=\"flex-wrap\">\n			<section class=\"wrap\">\n				<div class=\"login__logo\">\n  <svg width=\"281px\" height=\"36px\" viewBox=\"0 0 281 36\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\">\n  <title>ExpressionEngine</title>\n  <defs>\n      <polygon id=\"path-1\" points=\"0.3862 0.1747 18.6557 0.1747 18.6557 21.5 0.3862 21.5\"></polygon>\n      <polygon id=\"path-3\" points=\"0.3926 0.17455 13.9915 0.17455 13.9915 15.43755 0.3926 15.43755\"></polygon>\n      <polygon id=\"path-5\" points=\"0 0.06905 25.8202 0.06905 25.8202 31.6178513 0 31.6178513\"></polygon>\n      <polygon id=\"path-7\" points=\"0.10635 0.204 25.9268587 0.204 25.9268587 31.7517 0.10635 31.7517\"></polygon>\n  </defs>\n  <g id=\"logo\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\">\n      <g id=\"expressionengine\">\n          <path d=\"M92.88015,27.0665 L89.28865,20.955 L94.66665,14.6405 L94.77265,13.9 L91.11315,13.9 L87.86765,17.95 C87.76015,18.0845 87.57265,18.353 87.30415,19.2645 C87.33065,18.353 87.14315,18.0845 87.08965,17.9775 L84.80915,13.9 L80.59815,13.9 L84.62115,20.8475 L78.21065,28.3045 L82.42165,28.3045 L86.04315,23.905 C86.23065,23.664 86.52565,23.154 86.66065,22.5915 C86.66065,23.154 86.79465,23.6905 86.92865,23.905 L89.42265,28.3045 L92.70265,28.3045 L92.88015,27.0665 Z\" id=\"Fill-1\"></path>\n          <path d=\"M80.2395,11.9686 L70.9585,11.9686 L70.288,16.6091 L78.7645,16.6091 L77.4495,19.6141 L69.751,19.6141 C69.805,19.8011 69.805,20.0156 69.778,20.1231 L69.027,25.3011 L78.3345,25.3011 L77.9055,28.3046 L65.003,28.3046 L67.7925,8.9651 L80.6685,8.9651 L80.2395,11.9686 Z\" id=\"Fill-3\"></path>\n          <path d=\"M102.3328,16.20735 C101.5283,16.20735 100.5628,16.34085 99.3558,17.11935 L98.1493,25.46185 C98.8998,25.83735 99.9723,25.99835 100.8848,25.99835 C103.0573,25.99835 104.2378,24.60235 104.7478,20.98085 C104.8548,20.28385 104.9083,19.69385 104.9083,19.18485 C104.9083,17.03835 104.0508,16.20735 102.3328,16.20735 M108.3418,20.98085 C107.6718,25.70235 105.5783,28.73385 100.5093,28.73385 C99.5708,28.73385 98.4978,28.54635 97.5313,28.08985 C97.6128,28.38435 97.6933,28.73385 97.6393,29.02935 L96.8073,34.79585 L93.2133,34.79585 L96.2178,13.89985 L98.7928,13.89985 L99.0878,15.08085 C100.3213,14.00685 101.7703,13.47035 103.1113,13.47035 C106.9473,13.47035 108.5023,15.69685 108.5023,19.05035 C108.5023,19.66735 108.4483,20.31135 108.3418,20.98085\" id=\"Fill-5\"></path>\n          <path d=\"M119.33865,16.69 C118.74815,16.609 118.13215,16.555 117.48715,16.555 C116.46815,16.555 115.39515,16.716 114.45615,17.28 L112.87415,28.3045 L109.27965,28.3045 L111.34515,13.8995 L114.29515,13.8995 L114.51115,15.0535 C115.71715,13.8995 116.92465,13.4705 118.21215,13.4705 C118.72265,13.4705 119.25865,13.5515 119.79515,13.659 L119.33865,16.69 Z\" id=\"Fill-7\"></path>\n          <path d=\"M127.43385,16.31455 C125.39585,16.31455 124.40285,17.09155 123.81285,19.61405 L129.71435,19.61405 C129.76785,19.29205 129.79435,18.99655 129.79435,18.72855 C129.79435,17.14555 129.01685,16.31455 127.43385,16.31455 M133.03985,22.13505 L123.35635,22.13505 C123.30235,22.56405 123.27685,22.93955 123.27685,23.28855 C123.27685,25.05905 124.08085,25.89105 126.06585,25.89105 C127.91685,25.89105 128.96335,25.08605 129.74035,23.90505 L132.44985,25.00505 C131.18885,27.41855 128.82885,28.73355 125.66385,28.73355 C121.58635,28.73355 119.73535,26.56055 119.73535,22.93955 C119.73535,22.34955 119.78885,21.73305 119.86985,21.08855 C120.64685,15.80405 122.95485,13.47055 127.86285,13.47055 C132.31635,13.47055 133.33585,16.60905 133.33585,19.29205 C133.33585,20.09655 133.17435,21.16955 133.03985,22.13505\" id=\"Fill-9\"></path>\n          <path d=\"M144.11795,17.70905 C143.60895,16.79705 142.66995,16.28705 141.19395,16.28705 C140.04145,16.28705 138.64595,16.52905 138.64595,17.97755 C138.64595,18.48755 138.88745,18.91655 139.53145,19.02405 L142.64245,19.58655 C144.60095,19.93605 146.20995,21.03455 146.20995,23.12755 C146.20995,27.23155 142.80295,28.73355 139.23545,28.73355 C136.71445,28.73355 134.73045,27.87555 133.76445,25.62255 L136.76845,24.52255 C137.33245,25.54155 138.24395,25.99805 139.61245,25.99805 C140.95345,25.99805 142.61595,25.59505 142.61595,23.93255 C142.61595,23.34255 142.34795,22.91355 141.56945,22.77855 L138.21645,22.16255 C136.66095,21.86655 135.13145,20.68655 135.13145,18.46005 C135.13145,14.65055 138.27045,13.47055 141.59695,13.47055 C144.57445,13.47055 146.20995,14.67805 146.93445,16.39455 L144.11795,17.70905 Z\" id=\"Fill-11\"></path>\n          <path d=\"M157.28835,17.70905 C156.77935,16.79705 155.84135,16.28705 154.36435,16.28705 C153.21235,16.28705 151.81785,16.52905 151.81785,17.97755 C151.81785,18.48755 152.05935,18.91655 152.70335,19.02405 L155.81435,19.58655 C157.77285,19.93605 159.38185,21.03455 159.38185,23.12755 C159.38185,27.23155 155.97385,28.73355 152.40635,28.73355 C149.88635,28.73355 147.90085,27.87555 146.93585,25.62255 L149.93885,24.52255 C150.50285,25.54155 151.41585,25.99805 152.78285,25.99805 C154.12535,25.99805 155.78685,25.59505 155.78685,23.93255 C155.78685,23.34255 155.51985,22.91355 154.74135,22.77855 L151.38835,22.16255 C149.83185,21.86655 148.30235,20.68655 148.30235,18.46005 C148.30235,14.65055 151.44085,13.47055 154.76885,13.47055 C157.74485,13.47055 159.38185,14.67805 160.10535,16.39455 L157.28835,17.70905 Z\" id=\"Fill-13\"></path>\n          <path d=\"M168.0188,11.0294 C167.9908,11.2714 167.9908,11.2714 167.7768,11.2714 L164.2888,11.2714 C164.0743,11.2714 164.0743,11.2714 164.1018,11.0294 L164.5858,7.7039 C164.6108,7.4359 164.6108,7.4084 164.8253,7.4084 L168.3133,7.4084 C168.5278,7.4084 168.5278,7.4359 168.5003,7.7039 L168.0188,11.0294 Z M167.2953,28.5464 L165.4688,28.5464 C163.3783,28.5464 162.3583,27.6334 162.3583,25.7564 C162.3583,25.4619 162.3853,25.1659 162.4378,24.8169 L163.5128,17.3874 C163.5378,17.1729 163.6728,16.8509 163.8873,16.6089 L161.2853,16.6089 L161.6618,13.8999 L167.5898,13.8999 L166.0328,24.8169 C166.0083,24.9514 166.0083,25.0864 166.0083,25.1934 C166.0083,25.5154 166.1398,25.6229 166.5443,25.6229 L167.6968,25.6229 L167.2953,28.5464 Z\" id=\"Fill-15\"></path>\n          <path d=\"M176.8977,16.31455 C174.6972,16.31455 173.6242,17.44105 173.0882,21.08855 C172.9807,21.81305 172.9262,22.45705 172.9262,22.99305 C172.9262,25.16605 173.7837,25.89105 175.5282,25.89105 C177.7007,25.89105 178.8562,24.76305 179.3922,21.08855 C179.4997,20.39105 179.5522,19.77455 179.5522,19.23855 C179.5522,17.03805 178.6662,16.31455 176.8977,16.31455 M182.9852,21.08855 C182.2617,26.07805 180.0887,28.73355 175.1262,28.73355 C170.8872,28.73355 169.3582,26.13155 169.3582,22.85955 C169.3582,22.29555 169.4132,21.67955 169.4927,21.08855 C170.2167,16.01905 172.3647,13.47055 177.3267,13.47055 C181.5377,13.47055 183.1197,15.93905 183.1197,19.26455 C183.1197,19.85455 183.0672,20.44455 182.9852,21.08855\" id=\"Fill-17\"></path>\n          <path d=\"M197.21265,19.23835 L195.89815,28.30435 L192.33015,28.30435 L193.64515,19.23835 C193.70015,18.91635 193.72465,18.59485 193.72465,18.29935 C193.72465,17.06535 193.24365,16.26085 191.90115,16.26085 C190.80115,16.26085 189.51415,16.87685 188.46865,17.52085 L186.91165,28.30435 L183.34415,28.30435 L185.41015,13.89985 L188.36115,13.89985 L188.60315,15.21435 C190.26465,13.89985 191.60665,13.47035 193.10865,13.47035 C196.11265,13.47035 197.32015,15.37535 197.32015,17.92385 C197.32015,18.35285 197.26715,18.78185 197.21265,19.23835\" id=\"Fill-19\"></path>\n          <path d=\"M214.45925,11.9686 L205.17825,11.9686 L204.51025,16.6091 L212.98475,16.6091 L211.67025,19.6141 L203.97075,19.6141 C204.02625,19.8011 204.02625,20.0156 203.99875,20.1231 L203.24775,25.3011 L212.55525,25.3011 L212.12675,28.3046 L199.22325,28.3046 L202.01525,8.9651 L214.89075,8.9651 L214.45925,11.9686 Z\" id=\"Fill-21\"></path>\n          <path d=\"M227.8411,19.23835 L226.5266,28.30435 L222.9586,28.30435 L224.2736,19.23835 C224.3261,18.91635 224.3531,18.59485 224.3531,18.29935 C224.3531,17.06535 223.8696,16.26085 222.5301,16.26085 C221.4296,16.26085 220.1426,16.87685 219.0946,17.52085 L217.5401,28.30435 L213.9726,28.30435 L216.0386,13.89985 L218.9871,13.89985 L219.2291,15.21435 C220.8931,13.89985 222.2331,13.47035 223.7371,13.47035 C226.7411,13.47035 227.9486,15.37535 227.9486,17.92385 C227.9486,18.35285 227.8936,18.78185 227.8411,19.23835\" id=\"Fill-23\"></path>\n          <g id=\"Group-27\" transform=\"translate(227.500000, 13.296000)\">\n              <mask id=\"mask-2\" fill=\"white\">\n                  <use xlink:href=\"#path-1\"></use>\n              </mask>\n              <g id=\"Clip-26\"></g>\n              <path d=\"M9.7742,2.9912 C7.7607,2.9912 6.6082,4.1452 6.6082,6.1297 C6.6082,7.4702 7.4667,8.0342 9.0232,8.0342 C11.0342,8.0342 12.1612,6.9617 12.1612,4.9772 C12.1612,3.6622 11.3832,2.9912 9.7742,2.9912 L9.7742,2.9912 Z M10.1207,15.0622 L5.0787,14.1227 C4.2757,14.9812 3.9262,15.5447 3.9262,16.7522 C3.9262,18.1197 4.8917,18.7372 7.4667,18.7372 C9.1557,18.7372 11.4907,18.4687 11.4907,16.2957 C11.4907,15.6262 11.1412,15.2507 10.1207,15.0622 L10.1207,15.0622 Z M18.3312,3.3132 L16.5872,3.3132 C16.3457,3.3132 15.7542,3.2867 15.3002,3.0722 C15.5672,3.7157 15.6742,4.4392 15.6742,5.0307 C15.6742,9.2142 12.3482,10.8237 8.6187,10.8237 C7.7882,10.8237 6.9852,10.7437 6.2862,10.5827 C6.1792,10.5552 6.0717,10.5292 5.9372,10.5292 C5.5352,10.5292 5.2932,10.7437 5.2932,11.1452 C5.2932,11.4137 5.4282,11.6017 6.0167,11.7092 L11.1962,12.6747 C14.0652,13.2112 15.0577,14.4447 15.0577,16.0277 C15.0577,20.6682 10.7122,21.5002 7.0647,21.5002 C4.1682,21.5002 0.3862,20.7217 0.3862,17.1002 C0.3862,15.2232 1.3767,13.6142 2.9857,12.6482 C2.6637,12.2457 2.5042,11.7902 2.5042,11.3597 C2.5042,10.3947 3.2007,9.6437 4.0062,9.2142 C3.4972,8.5707 3.0682,7.5517 3.0682,6.3717 C3.0682,2.1602 6.3387,0.1747 10.1757,0.1747 C11.5177,0.1747 12.9372,0.4167 13.9852,1.0862 L16.0537,0.6212 L18.6557,0.6212 L18.3312,3.3132 Z\" id=\"Fill-25\" mask=\"url(#mask-2)\"></path>\n          </g>\n          <path d=\"M251.54175,11.0294 C251.51675,11.2714 251.51675,11.2714 251.30225,11.2714 L247.81475,11.2714 C247.59975,11.2714 247.59975,11.2714 247.62725,11.0294 L248.10925,7.7039 C248.13625,7.4359 248.13625,7.4084 248.35075,7.4084 L251.83875,7.4084 C252.05275,7.4084 252.05275,7.4359 252.02575,7.7039 L251.54175,11.0294 Z M250.81825,28.5464 L248.99425,28.5464 C246.90175,28.5464 245.88375,27.6334 245.88375,25.7564 C245.88375,25.4619 245.91075,25.1659 245.96375,24.8169 L247.03575,17.3874 C247.06375,17.1729 247.19825,16.8509 247.41275,16.6089 L244.81075,16.6089 L245.18475,13.8999 L251.11275,13.8999 L249.55825,24.8169 C249.53125,24.9514 249.53125,25.0864 249.53125,25.1934 C249.53125,25.5154 249.66575,25.6229 250.06725,25.6229 L251.21975,25.6229 L250.81825,28.5464 Z\" id=\"Fill-28\"></path>\n          <path d=\"M266.32595,19.23835 L265.01095,28.30435 L261.44345,28.30435 L262.75845,19.23835 C262.81345,18.91635 262.83795,18.59485 262.83795,18.29935 C262.83795,17.06535 262.35695,16.26085 261.01445,16.26085 C259.91445,16.26085 258.62695,16.87685 257.58195,17.52085 L256.02445,28.30435 L252.45745,28.30435 L254.52345,13.89985 L257.47445,13.89985 L257.71645,15.21435 C259.37795,13.89985 260.71995,13.47035 262.22195,13.47035 C265.22595,13.47035 266.43345,15.37535 266.43345,17.92385 C266.43345,18.35285 266.38045,18.78185 266.32595,19.23835\" id=\"Fill-30\"></path>\n          <g id=\"Group-34\" transform=\"translate(267.000000, 13.296000)\">\n              <mask id=\"mask-4\" fill=\"white\">\n                  <use xlink:href=\"#path-3\"></use>\n              </mask>\n              <g id=\"Clip-33\"></g>\n              <path d=\"M8.0916,3.01855 C6.0531,3.01855 5.0606,3.79555 4.4691,6.31805 L10.3716,6.31805 C10.4241,5.99605 10.4516,5.70055 10.4516,5.43255 C10.4516,3.84955 9.6731,3.01855 8.0916,3.01855 M13.6971,8.83905 L4.0126,8.83905 C3.9596,9.26805 3.9326,9.64355 3.9326,9.99255 C3.9326,11.76305 4.7381,12.59505 6.7216,12.59505 C8.5731,12.59505 9.6211,11.79005 10.3961,10.60905 L13.1056,11.70905 C11.8461,14.12255 9.4861,15.43755 6.3201,15.43755 C2.2436,15.43755 0.3926,13.26455 0.3926,9.64355 C0.3926,9.05355 0.4446,8.43705 0.5271,7.79255 C1.3031,2.50805 3.6106,0.17455 8.5201,0.17455 C12.9736,0.17455 13.9916,3.31305 13.9916,5.99605 C13.9916,6.80055 13.8316,7.87355 13.6971,8.83905\" id=\"Fill-32\" mask=\"url(#mask-4)\"></path>\n          </g>\n          <path d=\"M20.60205,17.64605 C21.11355,14.75605 22.01655,12.45255 23.28405,10.79305 C24.18105,9.60555 25.17405,9.00405 26.23755,9.00405 C26.80055,9.00405 27.27705,9.22055 27.65305,9.64955 C28.01805,10.06905 28.20405,10.64605 28.20405,11.36305 C28.20405,13.02405 27.45705,14.53555 25.98455,15.86155 C24.91705,16.81355 23.20305,17.51055 20.89205,17.93305 L20.53855,17.99805 L20.60205,17.64605 Z M30.67305,21.68355 C29.37505,22.92855 28.23905,23.80705 27.31805,24.24655 C26.34905,24.70655 25.34805,24.93855 24.34355,24.93855 C23.11755,24.93855 22.12155,24.54805 21.38655,23.77655 C20.65105,23.00705 20.27805,21.90355 20.27805,20.49455 L20.37305,19.08355 L20.56855,19.05005 C24.00755,18.47005 26.60155,17.80655 28.27555,17.07555 C29.93155,16.35405 31.14005,15.49505 31.86855,14.52405 C32.59155,13.56105 32.95655,12.59155 32.95655,11.65055 C32.95655,10.50805 32.52355,9.59355 31.63105,8.84705 C30.73555,8.10155 29.44355,7.72455 27.79455,7.72455 C25.50305,7.72455 23.33455,8.25905 21.34955,9.31405 C19.36805,10.36805 17.78305,11.82905 16.64005,13.65605 C15.50005,15.48105 14.92155,17.41555 14.92155,19.40105 C14.92155,21.61755 15.60505,23.39505 16.95205,24.68005 C18.30455,25.96905 20.19355,26.62005 22.56705,26.62005 C24.25255,26.62005 25.84755,26.28155 27.30805,25.61355 C28.70455,24.97455 30.14905,23.86705 31.60805,22.37255 C31.33005,22.16805 30.87005,21.82855 30.67305,21.68355 L30.67305,21.68355 Z\" id=\"Fill-35\"></path>\n          <g id=\"Group-39\" transform=\"translate(0.000000, 2.796000)\">\n              <mask id=\"mask-6\" fill=\"white\">\n                  <use xlink:href=\"#path-5\"></use>\n              </mask>\n              <g id=\"Clip-38\"></g>\n              <path d=\"M7.2737,19.35005 C5.3202,11.70605 9.9462,3.71505 17.8897,0.06905 C17.6907,0.14055 17.5042,0.22255 17.3077,0.29605 C17.5087,0.20005 17.6882,0.11955 17.8272,0.07205 L2.9432,3.91255 L6.9112,6.26005 C1.7147,10.66105 -0.9663,16.11555 0.3187,21.14505 C2.3302,29.02005 13.3457,33.12605 25.8202,31.10805 C17.1117,31.75655 9.2257,26.99355 7.2737,19.35005\" id=\"Fill-37\" mask=\"url(#mask-6)\"></path>\n          </g>\n          <g id=\"Group-42\" transform=\"translate(23.500000, 0.296000)\">\n              <mask id=\"mask-8\" fill=\"white\">\n                  <use xlink:href=\"#path-7\"></use>\n              </mask>\n              <g id=\"Clip-41\"></g>\n              <path d=\"M18.65285,12.4697 C20.60635,20.1147 15.98135,28.1052 8.03735,31.7517 C8.23585,31.6797 8.42235,31.5977 8.61885,31.5232 C8.41785,31.6212 8.23835,31.7002 8.09935,31.7482 L22.98335,27.9087 L19.01585,25.5612 C24.21185,21.1597 26.89285,15.7042 25.60835,10.6747 C23.59635,2.8027 12.58085,-1.3053 0.10635,0.7142 C8.81435,0.0637 16.70135,4.8267 18.65285,12.4697\" id=\"Fill-40\" mask=\"url(#mask-8)\"></path>\n          </g>\n      </g>\n    </g>\n  </svg>\n</div>\n				<div class=\"panel warn\">\n  <div class=\"panel-heading\" style=\"text-align: center;\">\n    <h3>ExpressionEngine has been installed!</h3>\n  </div>\n  <div class=\"panel-body\">\n    <div class=\"updater-msg\">\n  		<p style=\"margin-bottom: 20px;\">If you see this message, then everything went well.</p>\n\n  		<div class=\"alert alert--attention\">\n            <div class=\"alert__icon\">\n              <i class=\"fal fa-info-circle fa-fw\"></i>\n            </div>\n            <div class=\"alert__content\">\n    			<p>If you are site owner, please login into your Control Panel and create your first template.</p>\n    		</div>\n  		</div>\n  		<div class=\"alert alert--attention\">\n            <div class=\"alert__icon\">\n              <i class=\"fal fa-info-circle fa-fw\"></i>\n            </div>\n            <div class=\"alert__content\">\n    			<p>If this is your first time using ExpressionEngine CMS, make sure to <a href=\"https://docs.expressionengine.com/latest/getting-started/the-big-picture.html\">check out the documentation</a> to get started.</p>\n    		</div>\n  		</div>\n  	</div>\n  </div>\n  <div class=\"panel-footer\">\n\n  </div>\n</div>\n			</div>\n			<section class=\"bar\">\n				<p style=\"float: left;\"><a href=\"https://expressionengine.com/\" rel=\"external\"><b>ExpressionEngine</b></a></p>\n				<p style=\"float: right;\">&copy;2022 <a href=\"https://packettide.com/\" rel=\"external\">Packet Tide</a>, LLC</p>\n			</section>\n		</section>\n\n	</body>\n</html>', NULL, 1666304930, 0),
(4, 1, 'y', 'mfa_template', '', 'system', NULL, '<!doctype html>\n        <html dir=\"ltr\">\n            <head>\n                <title>{title}</title>\n                <meta http-equiv=\"content-type\" content=\"text/html; charset={charset}\">\n                <meta content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\"  name=\"viewport\">\n                <meta name=\"referrer\" content=\"no-referrer\">\n                {meta_refresh}\n                <style type=\"text/css\">\n        :root, body {\n            --ee-panel-bg: #fff;\n            --ee-panel-border: #dfe0ef;\n            --ee-text-normal: #0d0d19;\n            --ee-text-secondary: #8f90b0;\n            --ee-main-bg: #f7f7fb;\n            --ee-link: #5D63F1;\n            --ee-link-hover: #171feb;\n            --ee-bg-blank: #fff;\n            --ee-code-border: #dfe0ef;\n\n            --ee-input-color: #0d0d19;\n            --ee-input-bg: #fff;\n            --ee-input-placeholder: #adaec5;\n            --ee-input-border: #cbcbda;\n            --ee-input-border-accent: #ecedf5;\n            --ee-input-focus-border: #5D63F1;\n            --ee-input-focus-shadow: 0 3px 6px -3px rgba(174,151,255,0.14),0 5px 10px -3px rgba(97,114,242,0.05);\n            --ee-button-primary-color: #fff;\n            --ee-button-primary-bg: #5D63F1;\n            --ee-button-primary-border: #5D63F1;\n\n            --ee-bg-0: #f7f7fb;\n            --ee-border: #dfe0ef;\n            --ee-error: #FA5252;\n            --ee-error-light: #fee7e7;\n            --ee-warning: #FFB40B;\n            --ee-warning-light: #fff6e1;\n        }\n\n        @font-face{font-family:Roboto;font-style:normal;font-weight:400;src:url({url_themes}webfonts/roboto-v20-latin-regular.eot);src:local(\"Roboto\"),local(\"Roboto-Regular\"),url({url_themes}webfonts/roboto-v20-latin-regular.eot?#iefix) format(\"embedded-opentype\"),url({url_themes}webfonts/roboto-v20-latin-regular.woff2) format(\"woff2\"),url({url_themes}webfonts/roboto-v20-latin-regular.woff) format(\"woff\"),url({url_themes}webfonts/roboto-v20-latin-regular.ttf) format(\"truetype\"),url({url_themes}webfonts/roboto-v20-latin-regular.svg#Roboto) format(\"svg\")}@font-face{font-family:Roboto;font-style:italic;font-weight:400;src:url({url_themes}webfonts/roboto-v20-latin-italic.eot);src:local(\"Roboto Italic\"),local(\"Roboto-Italic\"),url({url_themes}webfonts/roboto-v20-latin-italic.eot?#iefix) format(\"embedded-opentype\"),url({url_themes}webfonts/roboto-v20-latin-italic.woff2) format(\"woff2\"),url({url_themes}webfonts/roboto-v20-latin-italic.woff) format(\"woff\"),url({url_themes}webfonts/roboto-v20-latin-italic.ttf) format(\"truetype\"),url({url_themes}webfonts/roboto-v20-latin-italic.svg#Roboto) format(\"svg\")}@font-face{font-family:Roboto;font-style:normal;font-weight:500;src:url({url_themes}webfonts/roboto-v20-latin-500.eot);src:local(\"Roboto Medium\"),local(\"Roboto-Medium\"),url({url_themes}webfonts/roboto-v20-latin-500.eot?#iefix) format(\"embedded-opentype\"),url({url_themes}webfonts/roboto-v20-latin-500.woff2) format(\"woff2\"),url({url_themes}webfonts/roboto-v20-latin-500.woff) format(\"woff\"),url({url_themes}webfonts/roboto-v20-latin-500.ttf) format(\"truetype\"),url({url_themes}webfonts/roboto-v20-latin-500.svg#Roboto) format(\"svg\")}@font-face{font-family:Roboto;font-style:italic;font-weight:500;src:url({url_themes}webfonts/roboto-v20-latin-500italic.eot);src:local(\"Roboto Medium Italic\"),local(\"Roboto-MediumItalic\"),url({url_themes}webfonts/roboto-v20-latin-500italic.eot?#iefix) format(\"embedded-opentype\"),url({url_themes}webfonts/roboto-v20-latin-500italic.woff2) format(\"woff2\"),url({url_themes}webfonts/roboto-v20-latin-500italic.woff) format(\"woff\"),url({url_themes}webfonts/roboto-v20-latin-500italic.ttf) format(\"truetype\"),url({url_themes}webfonts/roboto-v20-latin-500italic.svg#Roboto) format(\"svg\")}@font-face{font-family:Roboto;font-style:normal;font-weight:700;src:url({url_themes}webfonts/roboto-v20-latin-700.eot);src:local(\"Roboto Bold\"),local(\"Roboto-Bold\"),url({url_themes}webfonts/roboto-v20-latin-700.eot?#iefix) format(\"embedded-opentype\"),url({url_themes}webfonts/roboto-v20-latin-700.woff2) format(\"woff2\"),url({url_themes}webfonts/roboto-v20-latin-700.woff) format(\"woff\"),url({url_themes}webfonts/roboto-v20-latin-700.ttf) format(\"truetype\"),url({url_themes}webfonts/roboto-v20-latin-700.svg#Roboto) format(\"svg\")}@font-face{font-family:Roboto;font-style:italic;font-weight:700;src:url({url_themes}webfonts/roboto-v20-latin-700italic.eot);src:local(\"Roboto Bold Italic\"),local(\"Roboto-BoldItalic\"),url({url_themes}webfonts/roboto-v20-latin-700italic.eot?#iefix) format(\"embedded-opentype\"),url({url_themes}webfonts/roboto-v20-latin-700italic.woff2) format(\"woff2\"),url({url_themes}webfonts/roboto-v20-latin-700italic.woff) format(\"woff\"),url({url_themes}webfonts/roboto-v20-latin-700italic.ttf) format(\"truetype\"),url({url_themes}webfonts/roboto-v20-latin-700italic.svg#Roboto) format(\"svg\")}\n        @font-face{font-family:\'Font Awesome 5 Free\';font-style:normal;font-weight:900;font-display:auto;src:url({url_themes}webfonts/fa-solid-900.eot);src:url({url_themes}webfonts/fa-solid-900.eot?#iefix) format(\"embedded-opentype\"),url({url_themes}webfonts/fa-solid-900.woff2) format(\"woff2\"),url({url_themes}webfonts/fa-solid-900.woff) format(\"woff\"),url({url_themes}webfonts/fa-solid-900.ttf) format(\"truetype\"),url({url_themes}webfonts/fa-solid-900.svg#fontawesome) format(\"svg\")}\n\n        *, :after, :before {\n            box-sizing: inherit;\n        }\n\n        html {\n            box-sizing: border-box;\n            font-size: 15px;\n            height: 100%;\n            line-height: 1.15;\n        }\n\n        body {\n            font-family: -apple-system, BlinkMacSystemFont, segoe ui, helvetica neue, helvetica, Cantarell, Ubuntu, roboto, noto, arial, sans-serif;\n            height: 100%;\n            font-size: 1rem;\n            line-height: 1.6;\n            color: var(--ee-text-normal);\n            background: var(--ee-main-bg);\n            -webkit-font-smoothing: antialiased;\n            margin: 0;\n        }\n\n        .panel {\n            margin-bottom: 20px;\n            background-color: var(--ee-panel-bg);\n            border: 1px solid var(--ee-panel-border);\n            border-radius: 6px;\n        }\n        .redirect {\n            max-width: 700px;\n            min-width: 350px;\n            position: absolute;\n            left: 50%;\n            top: 0;\n            transform: translate(-50%);\n            height: 100vh;\n            overflow-y: auto;\n            background: transparent;\n            border: none;\n            border-radius: 0;\n            display: flex;\n        }\n\n        .redirect-inner {\n          background-color: var(--ee-panel-bg);\n          border: 1px solid var(--ee-panel-border);\n          border-radius: 6px;\n          height: auto;\n          margin-top: auto;\n          margin-bottom: auto;\n        }\n\n        .redirect-inner .qr-code-wrap {\n            text-align: center;\n        }\n\n        .panel-heading {\n            padding: 20px 25px;\n            position: relative;\n        }\n\n        .panel-body {\n            padding: 20px 25px;\n        }\n\n        .panel-body:after, .panel-body:before {\n            content: \" \";\n            display: table;\n        }\n\n        .redirect p {\n            margin-bottom: 20px;\n        }\n        p {\n            line-height: 1.6;\n        }\n        a, blockquote, code, h1, h2, h3, h4, h5, h6, ol, p, pre, ul {\n            color: inherit;\n            margin: 0;\n            padding: 0;\n            font-weight: inherit;\n        }\n\n        code {\n            font-size: inherit;\n            margin: 0 2px;\n            padding: 3px 6px;\n            border-radius: 5px;\n            border: 1px solid var(--ee-code-border);\n            background-color: var(--ee-bg-blank);\n            font-size: .96em;\n            white-space: normal;\n        }\n\n        a {\n            color: var(--ee-link);\n            text-decoration: none;\n            -webkit-transition: color .15s ease-in-out;\n            -moz-transition: color .15s ease-in-out;\n            -o-transition: color .15s ease-in-out;\n        }\n\n        a:hover {\n            color: var(--ee-link-hover);\n        }\n\n        h3 {\n            font-size: 1.35em;\n            font-weight: 500;\n        }\n\n        ol, ul {\n            padding-left: 0;\n        }\n\n        ol li, ul li {\n            list-style-position: inside;\n        }\n\n        .panel-footer {\n            padding: 20px 25px;\n            position: relative;\n        }\n\n        fieldset {\n            margin: 0;\n            padding: 0;\n            margin-bottom: 20px;\n            border: 0;\n        }\n\n        fieldset.last {\n            margin-bottom: 0;\n        }\n\n        .field-instruct {\n            margin-bottom: 5px;\n        }\n\n        .field-instruct label {\n            display: block;\n            color: var(--ee-text-normal);\n            margin-bottom: 5px;\n            font-weight: 500;\n        }\n\n        .field-instruct :last-child {\n            margin-bottom: 0;\n        }\n\n        .field-instruct em {\n            color: var(--ee-text-secondary);\n            display: block;\n            font-size: .8rem;\n            font-style: normal;\n            margin-bottom: 10px;\n        }\n\n        .field-instruct label+em {\n            margin-top: -5px;\n        }\n\n        button, input, optgroup, select, textarea {\n            font-family: inherit;\n            font-size: 100%;\n            line-height: 1.15;\n            margin: 0;\n        }\n\n        input[type=text], input[type=password] {\n            display: block;\n            width: 100%;\n            padding: 8px 15px;\n            font-size: 1rem;\n            line-height: 1.6;\n            color: var(--ee-input-color);\n            background-color: var(--ee-input-bg);\n            background-image: none;\n            transition: border-color .2s ease,box-shadow .2s ease;\n            -webkit-appearance: none;\n            border: 1px solid var(--ee-input-border);\n            border-radius: 5px;\n        }\n\n        input[type=text]:focus, input[type=password]:focus {\n            border-color: var(--ee-input-focus-border);\n        }\n\n        input:focus {\n            outline: 0;\n        }\n\n        .button {\n            -webkit-appearance: none;\n            display: inline-block;\n            font-weight: 500;\n            text-align: center;\n            vertical-align: middle;\n            touch-action: manipulation;\n            background-image: none;\n            cursor: pointer;\n            border: 1px solid transparent;\n            white-space: nowrap;\n            -webkit-transition: background-color .15s ease-in-out;\n            -moz-transition: background-color .15s ease-in-out;\n            -o-transition: background-color .15s ease-in-out;\n            -webkit-user-select: none;\n            -moz-user-select: none;\n            -ms-user-select: none;\n            user-select: none;\n            padding: 8px 20px!important;\n            font-size: 1rem;\n            line-height: 1.6;\n            border-radius: 5px;\n        }\n\n        .button--wide {\n            display: block;\n            width: 100%;\n        }\n\n        .button--large {\n            padding: 10px 25px!important;\n            font-size: 1.2rem;\n            line-height: 1.7;\n            border-radius: 6px;\n        }\n\n        .button--primary {\n            color: var(--ee-button-primary-color);\n            background-color: var(--ee-button-primary-bg);\n            border-color: var(--ee-button-primary-border);\n        }\n\n        .button.disabled {\n            cursor: not-allowed;\n            opacity: .55;\n            box-shadow: none;\n        }\n\n        .app-notice {\n            border: 1px solid var(--ee-border);\n            overflow: hidden;\n            background-color: var(--ee-bg-0);\n            border-radius: 5px;\n            display: flex;\n            margin-bottom: 20px;\n        }\n\n        .app-notice---error {\n            border-color: var(--ee-error);\n            background-color: var(--ee-error-light);\n        }\n\n        .app-notice---error .app-notice__tag {\n            color: var(--ee-error);\n        }\n\n        .app-notice---important {\n            border-color: var(--ee-warning);\n            background-color: var(--ee-warning-light);\n        }\n\n        .app-notice---important .app-notice__tag {\n            color: var(--ee-warning);\n        }\n\n        .app-notice__tag {\n            padding: 15px 20px;\n            display: flex;\n            align-items: center;\n            justify-content: center;\n            font-size: 16px;\n        }\n\n        .app-notice__icon {\n            position: relative;\n        }\n\n        .app-notice__icon::before {\n            font-family: \'Font Awesome 5 Free\';\n            font-weight: 900;\n            content: \"\\\\f06a\";\n            position: relative;\n            z-index: 2;\n        }\n\n        .app-notice---error .app-notice__icon::after {\n            background: var(--ee-error-light);\n        }\n\n        .app-notice__tag+.app-notice__content {\n            padding-left: 0;\n        }\n\n        .app-notice__content {\n            flex: 1 1;\n            padding: 15px 20px;\n        }\n\n        .app-notice__content p {\n            margin: 0;\n            color: var(--ee-text-primary);\n            opacity: .6;\n        }\n\n                </style>\n            </head>\n            <body>\n                <section class=\"flex-wrap\">\n                    <section class=\"wrap\">\n                        <div class=\"panel redirect\">\n                            <div class=\"redirect-inner\">\n                                <div class=\"panel-heading\">\n                                    <h3>{heading}</h3>\n                                </div>\n                                <div class=\"panel-body\">\n                                    {content}\n                                </div>\n                                <div class=\"panel-footer\">\n                                    {link}\n                                </div>\n                            </div>\n                        </div>\n                    </section>\n                </section>\n            </body>\n        </html>', NULL, 1666304930, 0),
(5, 1, 'y', 'admin_notify_reg', 'Notification of new member registration', 'email', 'members', 'New member registration site: {site_name}\n\nScreen name: {name}\nUser name: {username}\nEmail: {email}\n\nYour control panel URL: {control_panel_url}', NULL, 1666304930, 0),
(6, 1, 'y', 'admin_notify_entry', 'A new channel entry has been posted', 'email', 'content', 'A new entry has been posted in the following channel:\n{channel_name}\n\nThe title of the entry is:\n{entry_title}\n\nPosted by: {name}\nEmail: {email}\n\nTo read the entry please visit:\n{entry_url}\n', NULL, 1666304930, 0),
(7, 1, 'y', 'admin_notify_comment', 'You have just received a comment', 'email', 'comments', 'You have just received a comment for the following channel:\n{channel_name}\n\nThe title of the entry is:\n{entry_title}\n\nLocated at:\n{comment_url}\n\nPosted by: {name}\nEmail: {email}\nURL: {url}\nLocation: {location}\n\n{comment}', NULL, 1666304930, 0),
(8, 1, 'y', 'mbr_activation_instructions', 'Enclosed is your activation code', 'email', 'members', 'Thank you for your new member registration.\n\nTo activate your new account, please visit the following URL:\n\n{unwrap}{activation_url}{/unwrap}\n\nThank You!\n\n{site_name}\n\n{site_url}', NULL, 1666304930, 0),
(9, 1, 'y', 'forgot_password_instructions', 'Login information', 'email', 'members', 'To reset your password, please go to the following page:\n\n{reset_url}\n\nThen log in with your username: {username}\n\nIf you do not wish to reset your password, ignore this message. It will expire in 24 hours.\n\n{site_name}\n{site_url}', NULL, 1666304930, 0),
(10, 1, 'y', 'password_changed_notification', 'Password changed', 'email', 'members', 'Your password was just changed.\n\nIf you didn\'t make this change yourself, please contact an administrator right away.\n\n{site_name}\n{site_url}', NULL, 1666304930, 0),
(11, 1, 'y', 'forgot_username_instructions', 'Username information', 'email', 'members', 'Your username is: {username}\n\nIf you didn\'t request your username yourself, please contact an administrator right away.\n\n{site_name}\n{site_url}', NULL, 1666304930, 0),
(12, 1, 'y', 'email_changed_notification', 'Email address changed', 'email', 'members', 'Your email address has been changed, and this email address is no longer associated with your account.\n\nIf you didn\'t make this change yourself, please contact an administrator right away.\n\n{site_name}\n{site_url}', NULL, 1666304930, 0),
(13, 1, 'y', 'validated_member_notify', 'Your membership account has been activated', 'email', 'members', 'Your membership account has been activated and is ready for use.\n\nThank You!\n\n{site_name}\n{site_url}', NULL, 1666304930, 0),
(14, 1, 'y', 'decline_member_validation', 'Your membership account has been declined', 'email', 'members', 'We\'re sorry but our staff has decided not to validate your membership.\n\n{site_name}\n{site_url}', NULL, 1666304930, 0),
(15, 1, 'y', 'comment_notification', 'Someone just responded to your comment', 'email', 'comments', '{name_of_commenter} just responded to the entry you subscribed to at:\n{channel_name}\n\nThe title of the entry is:\n{entry_title}\n\nYou can see the comment at the following URL:\n{comment_url}\n\n{comment}\n\nTo stop receiving notifications for this comment, click here:\n{notification_removal_url}', NULL, 1666304930, 0),
(16, 1, 'y', 'comments_opened_notification', 'New comments have been added', 'email', 'comments', 'Responses have been added to the entry you subscribed to at:\n{channel_name}\n\nThe title of the entry is:\n{entry_title}\n\nYou can see the comments at the following URL:\n{comment_url}\n\n{comments}\n{comment}\n{/comments}\n\nTo stop receiving notifications for this entry, click here:\n{notification_removal_url}', NULL, 1666304930, 0),
(17, 1, 'y', 'private_message_notification', 'Someone has sent you a Private Message', 'email', 'private_messages', '\n{recipient_name},\n\n{sender_name} has just sent you a Private Message titled ‘{message_subject}’.\n\nYou can see the Private Message by logging in and viewing your inbox at:\n{site_url}\n\nContent:\n\n{message_content}\n\nTo stop receiving notifications of Private Messages, turn the option off in your Email Settings.\n\n{site_name}\n{site_url}', NULL, 1666304930, 0),
(18, 1, 'y', 'pm_inbox_full', 'Your private message mailbox is full', 'email', 'private_messages', '{recipient_name},\n\n{sender_name} has just attempted to send you a Private Message,\nbut your inbox is full, exceeding the maximum of {pm_storage_limit}.\n\nPlease log in and remove unwanted messages from your inbox at:\n{site_url}', NULL, 1666304930, 0);

INSERT INTO `exp_stats` (`stat_id`, `site_id`, `total_members`, `recent_member_id`, `recent_member`, `total_entries`, `total_forum_topics`, `total_forum_posts`, `total_comments`, `last_entry_date`, `last_forum_post_date`, `last_comment_date`, `last_visitor_date`, `most_visitors`, `most_visitor_date`, `last_cache_clear`) VALUES
(1, 1, 1, 1, 'admin', 13, 0, 0, 15, 1667245500, 0, 1666304949, 0, 0, 0, 1677117185);

INSERT INTO `exp_statuses` (`status_id`, `status`, `status_order`, `highlight`) VALUES
(1, 'open', 1, '009933'),
(2, 'closed', 2, '990000'),
(3, 'Default Page', 3, '2051B3');

INSERT INTO `exp_statuses_roles` (`role_id`, `status_id`) VALUES
(5, 1),
(5, 2);

INSERT INTO `exp_structure` (`site_id`, `entry_id`, `parent_id`, `channel_id`, `listing_cid`, `lft`, `rgt`, `dead`, `hidden`, `structure_url_title`, `template_id`, `updated`) VALUES
(0, 0, 0, 4, 0, 1, 8, 'root', 'n', NULL, 0, '2022-10-31 00:30:25'),
(1, 2, 0, 1, 0, 2, 7, '', 'n', 'about-default-theme', 14, NULL),
(1, 3, 2, 1, 0, 3, 4, '', 'n', 'sub-page-one', 14, NULL),
(1, 4, 2, 1, 0, 5, 6, '', 'n', 'sub-page-two', 14, NULL);

INSERT INTO `exp_structure_channels` (`site_id`, `channel_id`, `template_id`, `type`, `split_assets`, `show_in_page_selector`) VALUES
(1, 1, 14, 'page', 'n', 'y'),
(1, 2, 0, 'unmanaged', 'n', 'y'),
(1, 3, 0, 'unmanaged', 'n', 'y'),
(1, 4, 0, 'unmanaged', 'n', 'y');

INSERT INTO `exp_structure_nav_history` (`id`, `site_id`, `site_pages`, `structure`, `note`, `structure_version`, `date`, `current`, `restored_date`) VALUES
(1, 1, 'YToxOntpOjE7YTozOntzOjM6InVybCI7czowOiIiO3M6NDoidXJpcyI7YToxOntpOjI7czoyMToiL2Fib3V0LWRlZmF1bHQtdGhlbWUvIjt9czo5OiJ0ZW1wbGF0ZXMiO2E6MTp7aToyO2k6MTQ7fX19', '[{\"site_id\":1,\"entry_id\":2,\"parent_id\":0,\"channel_id\":1,\"listing_cid\":0,\"lft\":2,\"rgt\":3,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"about-default-theme\",\"template_id\":14,\"updated\":null}]', 'Post saving entry  \"About Default Theme\"', '6.0.0', '2022-11-01 19:49:41', 0, NULL),
(2, 1, 'YToxOntpOjE7YTozOntzOjM6InVybCI7czowOiIiO3M6NDoidXJpcyI7YToyOntpOjI7czoyMToiL2Fib3V0LWRlZmF1bHQtdGhlbWUvIjtpOjM7czozNDoiL2Fib3V0LWRlZmF1bHQtdGhlbWUvc3ViLXBhZ2Utb25lLyI7fXM6OToidGVtcGxhdGVzIjthOjI6e2k6MjtpOjE0O2k6MztpOjE0O319fQ==', '[{\"site_id\":1,\"entry_id\":2,\"parent_id\":0,\"channel_id\":1,\"listing_cid\":0,\"lft\":2,\"rgt\":5,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"about-default-theme\",\"template_id\":14,\"updated\":null},{\"site_id\":1,\"entry_id\":3,\"parent_id\":2,\"channel_id\":1,\"listing_cid\":0,\"lft\":3,\"rgt\":4,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"sub-page-one\",\"template_id\":14,\"updated\":null}]', 'Post saving entry  \"Sub Page One\"', '6.0.0', '2022-11-09 21:18:59', 0, NULL),
(3, 1, 'YToxOntpOjE7YTozOntzOjM6InVybCI7czowOiIiO3M6NDoidXJpcyI7YTozOntpOjI7czoyMToiL2Fib3V0LWRlZmF1bHQtdGhlbWUvIjtpOjM7czozNDoiL2Fib3V0LWRlZmF1bHQtdGhlbWUvc3ViLXBhZ2Utb25lLyI7aTo0O3M6MzQ6Ii9hYm91dC1kZWZhdWx0LXRoZW1lL3N1Yi1wYWdlLXR3by8iO31zOjk6InRlbXBsYXRlcyI7YTozOntpOjI7aToxNDtpOjM7aToxNDtpOjQ7aToxNDt9fX0=', '[{\"site_id\":1,\"entry_id\":2,\"parent_id\":0,\"channel_id\":1,\"listing_cid\":0,\"lft\":2,\"rgt\":7,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"about-default-theme\",\"template_id\":14,\"updated\":null},{\"site_id\":1,\"entry_id\":3,\"parent_id\":2,\"channel_id\":1,\"listing_cid\":0,\"lft\":3,\"rgt\":4,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"sub-page-one\",\"template_id\":14,\"updated\":null},{\"site_id\":1,\"entry_id\":4,\"parent_id\":2,\"channel_id\":1,\"listing_cid\":0,\"lft\":5,\"rgt\":6,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"sub-page-two\",\"template_id\":14,\"updated\":null}]', 'Post saving entry  \"Sub Page Two\"', '6.0.0', '2022-11-09 21:19:16', 0, NULL),
(4, 1, 'YToxOntpOjE7YTozOntzOjM6InVybCI7czowOiIiO3M6NDoidXJpcyI7YTozOntpOjI7czoyMToiL2Fib3V0LWRlZmF1bHQtdGhlbWUvIjtpOjM7czozNDoiL2Fib3V0LWRlZmF1bHQtdGhlbWUvc3ViLXBhZ2Utb25lLyI7aTo0O3M6MzQ6Ii9hYm91dC1kZWZhdWx0LXRoZW1lL3N1Yi1wYWdlLXR3by8iO31zOjk6InRlbXBsYXRlcyI7YTozOntpOjI7aToxNDtpOjM7aToxNDtpOjQ7aToxNDt9fX0=', '[{\"site_id\":1,\"entry_id\":2,\"parent_id\":0,\"channel_id\":1,\"listing_cid\":0,\"lft\":2,\"rgt\":7,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"about-default-theme\",\"template_id\":14,\"updated\":null},{\"site_id\":1,\"entry_id\":3,\"parent_id\":2,\"channel_id\":1,\"listing_cid\":0,\"lft\":3,\"rgt\":4,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"sub-page-one\",\"template_id\":14,\"updated\":null},{\"site_id\":1,\"entry_id\":4,\"parent_id\":2,\"channel_id\":1,\"listing_cid\":0,\"lft\":5,\"rgt\":6,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"sub-page-two\",\"template_id\":14,\"updated\":null}]', 'Post saving entry  \"About Default Theme\"', '6.0.0', '2022-11-10 14:03:41', 0, NULL),
(5, 1, 'YToxOntpOjE7YTozOntzOjM6InVybCI7czowOiIiO3M6NDoidXJpcyI7YTozOntpOjI7czoyMToiL2Fib3V0LWRlZmF1bHQtdGhlbWUvIjtpOjM7czozNDoiL2Fib3V0LWRlZmF1bHQtdGhlbWUvc3ViLXBhZ2Utb25lLyI7aTo0O3M6MzQ6Ii9hYm91dC1kZWZhdWx0LXRoZW1lL3N1Yi1wYWdlLXR3by8iO31zOjk6InRlbXBsYXRlcyI7YTozOntpOjI7aToxNDtpOjM7aToxNDtpOjQ7aToxNDt9fX0=', '[{\"site_id\":1,\"entry_id\":2,\"parent_id\":0,\"channel_id\":1,\"listing_cid\":0,\"lft\":2,\"rgt\":7,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"about-default-theme\",\"template_id\":14,\"updated\":null},{\"site_id\":1,\"entry_id\":3,\"parent_id\":2,\"channel_id\":1,\"listing_cid\":0,\"lft\":3,\"rgt\":4,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"sub-page-one\",\"template_id\":14,\"updated\":null},{\"site_id\":1,\"entry_id\":4,\"parent_id\":2,\"channel_id\":1,\"listing_cid\":0,\"lft\":5,\"rgt\":6,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"sub-page-two\",\"template_id\":14,\"updated\":null}]', 'Post saving entry  \"About Default Theme\"', '6.0.0', '2022-11-10 14:32:55', 0, NULL),
(6, 1, 'YToxOntpOjE7YTozOntzOjM6InVybCI7czowOiIiO3M6NDoidXJpcyI7YTozOntpOjI7czoyMToiL2Fib3V0LWRlZmF1bHQtdGhlbWUvIjtpOjM7czozNDoiL2Fib3V0LWRlZmF1bHQtdGhlbWUvc3ViLXBhZ2Utb25lLyI7aTo0O3M6MzQ6Ii9hYm91dC1kZWZhdWx0LXRoZW1lL3N1Yi1wYWdlLXR3by8iO31zOjk6InRlbXBsYXRlcyI7YTozOntpOjI7aToxNDtpOjM7aToxNDtpOjQ7aToxNDt9fX0=', '[{\"site_id\":1,\"entry_id\":2,\"parent_id\":0,\"channel_id\":1,\"listing_cid\":0,\"lft\":2,\"rgt\":7,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"about-default-theme\",\"template_id\":14,\"updated\":null},{\"site_id\":1,\"entry_id\":3,\"parent_id\":2,\"channel_id\":1,\"listing_cid\":0,\"lft\":3,\"rgt\":4,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"sub-page-one\",\"template_id\":14,\"updated\":null},{\"site_id\":1,\"entry_id\":4,\"parent_id\":2,\"channel_id\":1,\"listing_cid\":0,\"lft\":5,\"rgt\":6,\"dead\":\"\",\"hidden\":\"n\",\"structure_url_title\":\"sub-page-two\",\"template_id\":14,\"updated\":null}]', 'Post saving entry  \"About Default Theme\"', '6.0.0', '2022-11-10 14:33:08', 1, NULL);

INSERT INTO `exp_structure_settings` (`id`, `site_id`, `var`, `var_value`) VALUES
(1, 0, 'action_ajax_move', '40'),
(2, 0, 'module_id', '14'),
(3, 1, 'show_picker', 'y'),
(4, 1, 'show_view_page', 'y'),
(5, 1, 'show_global_add_page', 'y'),
(6, 1, 'hide_hidden_templates', 'y'),
(7, 1, 'redirect_on_login', 'n'),
(8, 1, 'redirect_on_publish', 'n'),
(9, 1, 'add_trailing_slash', 'y');

INSERT INTO `exp_template_groups` (`group_id`, `site_id`, `group_name`, `group_order`, `is_site_default`) VALUES
(1, 1, 'pro-dashboard-widgets', 1, 'n'),
(2, 1, 'contact', 2, 'n'),
(3, 1, 'layouts', 3, 'n'),
(4, 1, 'home', 4, 'y'),
(5, 1, 'common', 5, 'n'),
(6, 1, 'about', 6, 'n'),
(7, 1, 'blog', 7, 'n'),
(8, 1, 'search', 8, 'n'),
(9, 1, 'blade', 9, 'n'),
(10, 1, 'news', 10, 'n'),
(11, 1, 'site', 11, 'n'),
(12, 1, 'relationships', 12, 'n'),
(13, 1, 'twig', 13, 'n'),
(14, 1, 'global_embeds', 14, 'n'),
(15, 1, 'fields', 15, 'n'),
(16, 1, 'pro', 16, 'n');

INSERT INTO `exp_templates` (`template_id`, `site_id`, `group_id`, `template_name`, `template_type`, `template_engine`, `template_data`, `template_notes`, `edit_date`, `last_author_id`, `cache`, `refresh`, `no_auth_bounce`, `enable_http_auth`, `allow_php`, `php_parse_location`, `hits`, `protect_javascript`, `enable_frontedit`) VALUES
(1, 1, 1, 'sample-widget', 'webpage', NULL, '{widget title=\"Demo dashboard widget\" width=\"half\"}\n\n<p>Random entry: {exp:channel:entries dynamic=\"no\" orderby=\"random\" limit=\"1\"}<a href=\"{cp_url}?/cp/publish/edit/entry/{entry_id}&S={cp_session_id}\">{title}</a>{/exp:channel:entries}</p>\n\n<p>To see this code please visit the template <a href=\"{cp_url}?/cp/design/template/edit/1&S={cp_session_id}\">pro-dashboard-widgets/sample-widget</a>.</p>\n', NULL, 1668996327, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(2, 1, 2, 'index', 'webpage', NULL, '{layout=\'layouts/_contact-layout\'}\n\n{!--\n	404 Redirect\n	============\n	This is a single entry channel page, it only needs a second segment when the form has been successfully submitted. So we use the following code to make sure the page sends a 404 if someone types in an incorrect URL in the browser address bar. i.e. http://example.com/page/nothing\n--}\n{if segment_2 AND segment_2 != \'thanks\'}\n	{redirect=\'404\'}\n{/if}\n\n{!-- page vars (prefix p_) --}\n{preload_replace:p_title=\'contact {site_name}\'}\n{preload_replace:p_description=\'contact {site_name}\'}\n{preload_replace:p_url=\'contact\'}\n{!-- channel vars (prefix ch_) --}\n{preload_replace:ch=\'contact\'}\n{preload_replace:ch_disable=\'categories|category_fields|member_data|pagination\'}\n{!-- layout vars, channel/page related --}\n{layout:set name=\'ch\' value=\'{ch}\'}\n{layout:set name=\'p_url\' value=\'{p_url}\'}\n{layout:set name=\'p_title\' value=\'{p_title}\'}\n{layout:set name=\'ch_disable\' value=\'{ch_disable}\'}\n\n		{exp:channel:entries channel=\'{ch}\' disable=\'{ch_disable}\' limit=\'1\'}\n			{!-- layout vars, dynamic, not output --}\n			{layout:set name=\'title\' value=\'{seo_title}{gv_sep}\'}\n			{layout:set name=\'description\' value=\'{seo_desc}\'}\n			{!-- OpenGraph meta output --}\n			{layout:set name=\'og_title\' value=\'{seo_title}\'}\n			{layout:set name=\'og_url\'}{path=\'{p_url}\'}{/layout:set}\n			{layout:set name=\'og_description\' value=\'{seo_desc}\'}\n			{!-- /layout vars, dynamic, not output --}\n\n			{!-- content output --}\n			<h1>{title} <span class=\"required\">Required Fields &#10033;</span></h1>\n			{!-- page_content is a textarea with HTML output we don\'t need to wrap this tag with HTML as that is already included in it\'s output. --}\n			{page_content}\n			{!-- /content output --}\n\n			{!--\n				no results redirect\n				===================\n				If the page doesn\'t exist, we redirect to 404.\n			--}\n			{if no_results}\n				{redirect=\'404\'}\n			{/if}\n		{/exp:channel:entries}\n\n		<div class=\"alert issue hide\"></div>\n		{!-- only show this thank you message if segment_2 is thanks --}\n		{if segment_2 == \'thanks\'}\n			<div class=\"alert success\">\n				<h3>email sent</h3>\n				<p>Thanks, your email was sent, we\'ll respond in 48 hours or less.</p>\n				<a class=\"close\" href=\"{path=\'{p_url}\'}\">&#10005; Close</a>\n			</div>\n		{/if}\n		{!-- email contact form --}\n\n		{exp:email:contact_form form_class=\'contact-form\' return=\'{site_url}index.php/{p_url}/thanks\' redirect=\'0\'}\n			<fieldset class=\"row\">\n				<section class=\"w-4 instruct\">\n					<label>Name</label>\n					<em>What do you want to be called?</em>\n				</section>\n				<section class=\"w-12 field\">\n					<input name=\"name\" type=\"text\" value=\"{member_name}\">\n				</section>\n			</fieldset>\n			<fieldset class=\"row\">\n				<section class=\"w-4 instruct\">\n					<label>Email <span class=\"required\" title=\"required field\">&#10033;</span></label>\n					<em>How do we contact you?</em>\n				</section>\n				<section class=\"w-12 field\">\n					<input class=\"required\" name=\"from\" type=\"text\" value=\"{member_email}\">\n				</section>\n			</fieldset>\n			<fieldset class=\"row\">\n				<section class=\"w-4 instruct\">\n					<label>Subject</label>\n					<em>What did you want to discuss?</em>\n				</section>\n				<section class=\"w-12 field\">\n					<input name=\"subject\" type=\"text\" value=\"\">\n				</section>\n			</fieldset>\n			<fieldset class=\"row\">\n				<section class=\"w-4 instruct\">\n					<label>Message <span class=\"required\" title=\"required field\">&#10033;</span></label>\n					<em>Please keep it kind, brief and courteous.</em>\n				</section>\n				<section class=\"w-12 field\">\n					<textarea class=\"required\" name=\"message\" cols=\"\" rows=\"\"></textarea>\n				</section>\n			</fieldset>\n			<fieldset class=\"ctrls\">\n				<input class=\"btn\" type=\"submit\" value=\"Send e-mail\">\n			</fieldset>\n		{/exp:email:contact_form}\n', NULL, 1669134083, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(3, 1, 3, '_blog-layout', 'webpage', NULL, '{layout=\'layouts/_html-wrapper\'}\n\n{!-- page vars (prefix p_) --}\n{preload_replace:p_url_cat=\'category\'}\n\n{!-- embed for breadcrumb, needed to pass arguments (embeds aren\'t evil) --}\n{layout:set name=\'breadcrumbs\'}\n	{embed=\'common/_breadcrumb\'\n		p_url=\'{layout:p_url}\'\n		p_title=\'{layout:p_title}\'\n		{if layout:entry_ch}entry_ch=\'{layout:entry_ch}\'{/if}\n		{if layout:search}search=\'{layout:search}\'{/if}\n		{if layout:cat_ch}cat_ch=\'{layout:cat_ch}\'{/if}\n	}\n{/layout:set}\n\n{layout:set name=\'scripts\'}\n	<script src=\"{theme_user_folder_url}site/default/asset/js/plugins/validate.min.js\"></script>\n	{layout:scripts}\n{/layout:set}\n\n		<section class=\"row pad\">\n			<section class=\"w-12\">\n				{layout:contents}\n			</section>\n			<section class=\"w-4\">\n				<div class=\"sidebar\">\n					{exp:search:simple_form\n						form_class=\'search\'\n						channel=\'{layout:ch}\'\n						search_in=\'everywhere\'\n						where=\'all\'\n						result_page=\'{layout:p_url}/search\'\n						no_result_page=\'{layout:p_url}/no-results\'\n						results=\'5\'\n					}\n						<input type=\"text\" name=\"keywords\" id=\"keywords\" value=\"\" placeholder=\"Type keywords, hit enter\">\n					{/exp:search:simple_form}\n					<h2>Categories</h2>\n					<ul class=\"list yes\">\n						{exp:channel:categories channel=\'{layout:ch}\' style=\'linear\'}\n							<li><a href=\"{path=\'{layout:p_url}/{p_url_cat}/{category_url_title}\'}\">{category_name}</a></li>\n						{/exp:channel:categories}\n					</ul>\n					<h2>RSS Feed</h2>\n					<ul class=\"list rss\">\n						<li><a href=\"{path=\'{layout:p_url}/rss\'}\">Subscribe to {layout:p_title}</a></li>\n					</ul>\n				</div>\n\n			</section>\n		</section>\n', NULL, 1669134083, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(4, 1, 3, '_about-layout', 'webpage', NULL, '{layout=\'layouts/_html-wrapper\'}\n\n{!-- embed for breadcrumb, needed to pass arguments (embeds aren\'t evil) --}\n{layout:set name=\'breadcrumbs\'}\n	{embed=\'common/_breadcrumb\'\n		p_url=\'{layout:p_url}\'\n		p_title=\'{layout:p_title}\'\n		{if layout:entry_ch}entry_ch=\'{layout:entry_ch}\'{/if}\n	}\n{/layout:set}\n\n		<section class=\"row reverse pad\">\n			<section class=\"w-12\">\n				{layout:contents}\n			</section>\n			<section class=\"w-4\">\n				<div class=\"sidebar\">\n					<ul class=\"list\">\n						{!--\n							sub navigation\n							==============\n							This is a dynamic way to create sub navigation for this section. I use the parameter dynamic=\'no\' to prevent the URL from changing the output of a channel entries tag. I also use a status of \'Default Page\' to determine the, well default page.\n							NOTE: A channel should only have one Default Page.\n						--}\n						{exp:channel:entries channel=\'{layout:ch}\' disable=\'{layout:ch_disable}\' dynamic=\'no\' orderby=\'status\' sort=\'asc\' status=\'{layout:ch_status}\'}\n							{!-- we need to treat the default page link a little differently so we check for the \'Default Page\' status and output it, then all other page links output below that. We use the orderby=\'status\' and sort=\'asc\' parameters to accomplish this. --}\n							{if status == \'Default Page\'}\n								<li><a{if segment_1 == \'{layout:p_url}\' AND segment_2 == \'\'} class=\"act\"{/if} href=\"{path=\'{layout:p_url}\'}\">{title}</a></li>\n							{if:else}\n								<li><a{if segment_2 == \'{url_title}\'} class=\"act\"{/if} href=\"{path=\'{layout:p_url}/{url_title}\'}\">{title}</a></li>\n							{/if}\n						{/exp:channel:entries}\n					</ul>\n				</div>\n			</section>\n		</section>', NULL, 1669134083, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(5, 1, 3, '_html-wrapper', 'webpage', NULL, '<!doctype html>\n<html dir=\"ltr\" lang=\"{lang}\">\n	<head>\n		<meta charset=\"utf-8\">\n		<title>{layout:title}{site_name}</title>\n		<meta name=\"viewport\" content=\"initial-scale=1\">\n\n		<!-- meta data -->\n		{if layout:meta_author}<meta name=\"author\" content=\"{layout:meta_author}\">{/if}\n		{if layout:meta_description}<meta name=\"description\" content=\"{layout:meta_description}\">{/if}\n\n		<!-- open graph common -->\n		<meta property=\"og:site_name\" content=\"{site_name}\">\n		<meta property=\"og:type\" content=\"website\">\n		<meta property=\"og:image\" content=\"{theme_user_folder_url}site/default/asset/img/og/default.jpg\"> {!-- square, 50*50 min --}\n\n		{if layout:og_title != \'\'}\n			<!-- open graph per page -->\n			<meta property=\"og:title\" content=\"{layout:og_title}\">\n			<meta property=\"og:url\" content=\"{layout:og_url}\">\n			<meta property=\"og:description\" content=\"{layout:og_description}\">\n		{/if}\n\n		<link href=\"{theme_user_folder_url}site/default/asset/style/default.min.css\" title=\"common-styles\" rel=\"stylesheet\">\n		<!-- <link href=\"{theme_user_folder_url}site/default/asset/style/debug.min.css\" title=\"common-styles\" rel=\"stylesheet\"> -->\n	</head>\n	<body>\n		<header class=\"full\">\n			<section class=\"row pad\">\n				<section class=\"w-8\">\n					<h1><a href=\"{homepage}\"><b>{site_name}</b> Website</a></h1>\n				</section>\n				<section class=\"w-8\">\n					{!-- creates a small menu link on smaller devices --}\n					<a class=\"small-menu\" href=\"#\"></a>\n					{!-- appears in both header and footer, so a snippet is used to keep it DRY --}\n					{snp_main_nav}\n				</section>\n			</section>\n		</header>\n\n		{layout:breadcrumbs}\n\n		<div class=\"content\">\n			{layout:contents}\n		</div>\n\n		<footer class=\"full\">\n			<section class=\"footer-content\">\n				{!-- appears in both header and footer, so a snippet is used to keep it DRY --}\n				{snp_main_nav}\n				<p>&copy;{current_time format=\'%Y\'}, all rights reserved. Built with <a href=\"https://expressionengine.com/\" rel=\"external\">ExpressionEngine&reg;</a></p>\n			</section>\n		</footer>\n		</section>\n		<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js\" ></script>\n		<script src=\"{theme_user_folder_url}site/default/asset/js/default.min.js\" ></script>\n		<script src=\"{theme_user_folder_url}site/default/asset/js/plugins/cycle2.min.js\"></script>\n		{layout:scripts}\n	</body>\n</html>\n', NULL, 1669134083, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(6, 1, 3, '_contact-layout', 'webpage', NULL, '{layout=\'layouts/_html-wrapper\'}\n\n{!-- embed for breadcrumb, needed to pass arguments (embeds aren\'t evil) --}\n{layout:set name=\'breadcrumbs\'}\n	{embed=\'common/_breadcrumb\'\n		p_url=\'{layout:p_url}\'\n		p_title=\'{layout:p_title}\'\n	}\n{/layout:set}\n\n{layout:set name=\'scripts\'}\n	<script src=\"{theme_user_folder_url}site/default/asset/js/plugins/validate.min.js\"></script>\n	{layout:scripts}\n{/layout:set}\n\n		<section class=\"row reverse pad\">\n			<section class=\"w-12\">\n				{layout:contents}\n			</section>\n			<section class=\"w-4\">\n				{!-- output contact info --}\n				{exp:channel:entries channel=\'{layout:ch}\' disable=\'{layout:ch_disable}\' limit=\'1\' dynamic=\'no\'}\n					<address class=\"v-card\">\n						<strong class=\"org\">{site_name}</strong>\n						{if contact_address}\n							{contact_address}\n								<span class=\"address\">\n									<span class=\"street\">{contact_address:street}</span>, <span class=\"street-2\">{contact_address:street_2}</span><br>\n									<span class=\"city\">{contact_address:city}</span>, <span class=\"state\">{contact_address:state}</span> <span class=\"zip\">{contact_address:zip}</span>\n								</span>\n							{/contact_address}\n						{/if}\n						{if contact_phone OR contact_email}\n							<span class=\"alternate\">\n								{if contact_phone}<span class=\"phone\">{contact_phone}</span>{/if}\n								{if contact_phone AND contact_email}<br>{/if}\n								{if contact_email}<span class=\"e-mail\">{contact_email}</span>{/if}\n							</span>\n						{/if}\n					</address>\n				{/exp:channel:entries}\n			</section>\n		</section>\n', NULL, 1669134083, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(7, 1, 4, 'index', 'webpage', NULL, '{layout=\'layouts/_html-wrapper\'}\n\n{!-- page vars (prefix p_) --}\n{preload_replace:p_url=\'blog\'}\n{preload_replace:p_url_entry=\'entry\'}\n{!-- channel vars (prefix ch_) --}\n{preload_replace:ch=\'blog\'}\n{preload_replace:ch_disable=\'category_fields|member_data\'}\n\n{layout:set name=\'scripts\'}{/layout:set}\n\n<h1>Nav</h1>\n{exp:structure:nav start_from=\"/\"}\n<h2>End Nav</h2>\n\n<section class=\"row content home pad\">\n	<section class=\"w-16\">\n		<figure class=\"cycle-slideshow\"\n			data-cycle-fx=\"scrollHorz\"\n			data-cycle-pause-on-hover=\"true\"\n			data-cycle-speed=\"500\"\n			data-cycle-prev=\".prev-slide\"\n    		data-cycle-next=\".next-slide\"\n		>\n			{!-- slideshow images from a specific directory, and category --}\n			{exp:file:entries directory_id=\'7\' dynamic=\'no\' limit=\'5\' disable=\'pagination\' category=\'not 25\'}\n				<img src=\"{file_url}\" alt=\"{file_name:attr_safe}\"{if count == 1} class=\"act\"{/if}>\n				{if count == 1}\n					<div class=\"slide-ctrls\">\n						<a class=\"prev-slide\" href=\"#\"></a>\n						<a class=\"next-slide\" href=\"#\"></a>\n					</div>\n				{/if}\n			{/exp:file:entries}\n		</figure>\n		<h1>Recent Blog Posts <a class=\"btn all\" href=\"{path=\'{p_url}\'}\">All Posts</a></h1>\n	</section>\n	<section class=\"w-8\">\n		<div class=\"entries\">\n			{exp:channel:entries channel=\'{ch}\' disable=\'{ch_disable}\' limit=\'4\'}\n				{!-- listing as a snippet, as it\'s used through more than one template --}\n				{snp_blog_list}\n				{!-- no results --}\n				{if no_results}\n					<div class=\"alert warn no-results\">\n						<p>{gv_entries_none}</p>\n					</div>\n				{/if}\n			{/exp:channel:entries}\n		</div>\n	</section>\n	<section class=\"w-8\">\n		<div class=\"entries\">\n			{!-- using the offset=\'\' parameter here to start the listing on the 5th item. which allows us to split it into two columns without any wonky math --}\n			{exp:channel:entries channel=\'{ch}\' disable=\'{ch_disable}\' limit=\'4\' offset=\'4\'}\n				{!-- listing as a snippet, as it\'s used through more than one template --}\n				{snp_blog_list}\n				{!-- no results --}\n				{if no_results}\n					<div class=\"alert warn no-results\">\n						<p>{gv_entries_none}</p>\n					</div>\n				{/if}\n			{/exp:channel:entries}\n		</div>\n	</section>\n</section>\n', '', 1669131554, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(8, 1, 4, '404', 'webpage', NULL, '{layout=\'layouts/_html-wrapper\'}\n\n<section class=\"row\">\n	<section class=\"w-4\">\n		<figure>\n			<img src=\"http://i.giphy.com/l3V0tk7V9uygwnWyk.gif\" alt=\"Doing Business!\">\n		</figure>\n	</section>\n	<section class=\"w-12\">\n		<h1>404 &mdash; Page <b>Not</b> Found</h1>\n		<p>Super sorry about that, but the page you are trying to access is nowhere to be found.</p>\n		<p>We searched our whole desk.</p>\n	</section>\n</section>\n', NULL, 1669134083, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(9, 1, 5, '_breadcrumb', 'webpage', NULL, '		<section class=\"row pad breadcrumb\">\n			<section class=\"w-16\">\n				<ul>\n					{!-- always show the homepage --}\n					<li><a href=\"{homepage}\">{site_name}</a></li>\n					{!-- check for channel, category --}\n					{if embed:entry_ch}\n						<li><a href=\"{path=\'{embed:p_url}\'}\">{embed:p_title}</a></li>\n						{exp:channel:entries channel=\'{embed:entry_ch}\' limit=\'1\'}\n							<li>{title}</li>\n						{/exp:channel:entries}\n					{if:elseif embed:cat_ch}\n						<li><a href=\"{path=\'{embed:p_url}\'}\">{embed:p_title}</a></li>\n						<li>{exp:channel:category_heading channel=\'{embed:cat_ch}\'}{category_name}{/exp:channel:category_heading}</li>\n					{if:else}\n						{!-- check for search results --}\n						{if embed:search}\n							<li><a href=\"{path=\'{embed:p_url}\'}\">{embed:p_title}</a></li>\n							{if embed:search == \'y\'}\n								<li>{exp:search:total_results} search result{if \'{exp:search:total_results}\' != 1}s{/if} for <mark>{exp:search:keywords}</mark></li>\n							{if:else}\n								<li>0 search results for <mark>{exp:search:keywords}</mark></li>\n							{/if}\n						{if:else}\n							<li>{embed:p_title}</li>\n						{/if}\n					{/if}\n				</ul>\n			</section>\n		</section>', NULL, 1669131554, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(10, 1, 5, 'index', 'webpage', NULL, '{!-- nothing to see here, so we redirect the users if they land on http://example.com/common/ --}\n{redirect=\'/\'}', NULL, 1669131554, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(11, 1, 5, '_layout', 'webpage', NULL, '{!-- template vars --}\n{!-- used double quotes in this one file, as og_url required it :( --}\n{preload_replace:t_inc=\"common/\"}\n\n{!-- embed the header --}\n{embed=\"{t_inc}_header\"\n	title=\"{layout:title}\"\n	desc=\"{layout:desc}\"\n	{if layout:ogtitle}\n		ogtitle=\"{layout:ogtitle}\"\n		og_url=\"{layout:og_url}\"\n		og_description=\"{layout:og_description}\"\n	{/if}\n}\n\n{!-- cALL the content --}\n{layout:contents}\n\n{!-- embed the footer --}\n{embed=\"{t_inc}_footer\"}', NULL, 1669131554, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(12, 1, 5, '_header', 'webpage', NULL, '<!doctype html>\n<html>\n	<head>\n		<title>{layout:title}{site_name}</title>\n		<meta http-equiv=\"content-type\" content=\"text/html\" charset=\"utf-8\" dir=\"ltr\" lang=\"en-us\">\n		<meta name=\"viewport\" content=\"initial-scale=1\">\n		<!-- meta data -->\n		<meta name=\"author\" content=\"\">\n		<meta name=\"description\" content=\"{if layout:desc}{layout:desc}{if:else}{/if}\">\n		<!-- open graph common -->\n		<meta property=\"og:site_name\" content=\"{site_name}\">\n		<meta property=\"og:type\" content=\"website\">\n		<meta property=\"og:image\" content=\"{theme_user_folder_url}site/default/asset/img/og/default.jpg\"> {!-- square, 50*50 min --}\n		<!-- open graph per page -->\n\n		{if layout:og_title != \'\'}\n			<!-- open graph per page -->\n			<meta property=\"og:title\" content=\"{layout:og_title}\">\n			<meta property=\"og:url\" content=\"{layout:og_url}\">\n			<meta property=\"og:description\" content=\"{layout:og_description}\">\n		{/if}\n\n		<link href=\"/robots.txt\" title=\"robots\" type=\"text/plain\" rel=\"help\">\n		<link href=\"{theme_user_folder_url}site/default/asset/style/common.min.css\" title=\"common-styles\" rel=\"stylesheet\">\n		<link href=\"{theme_user_folder_url}site/default/asset/style/debug.min.css\" title=\"common-styles\" rel=\"stylesheet\">\n	</head>\n	<body>\n		<header class=\"full\">\n			<section class=\"row\">\n				<section class=\"w-8\">\n					<h1><a href=\"{homepage}\"><b>{site_name}</b> Website</a></h1>\n				</section>\n				<section class=\"w-8\">\n					{!-- appears in both header and footer, so a snippet is used to keep it DRY --}\n					{snp_main_nav}\n				</section>\n			</section>\n		</header>\n', NULL, 1669131554, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(13, 1, 5, '_footer', 'webpage', NULL, '		<footer class=\"row\">\n			<section class=\"w-8\">\n				<p>&copy;{current_time format=\'%Y\'}, all rights reserved. Built with <a href=\"https://expressionengine.com/\" rel=\"external\">ExpressionEngine&reg;</a></p>\n			</section>\n			<section class=\"w-8\">\n				{!-- appears in both header and footer, so a snippet is used to keep it DRY --}\n				{snp_main_nav}\n			</section>\n		</footer>\n		<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js\" ></script>\n		<script src=\"{theme_user_folder_url}site/default/asset/js/plugins/validate.min.js\" ></script>\n		<script src=\"{theme_user_folder_url}site/default/asset/js/plugins/cycle2.min.js\" ></script>\n		<script src=\"{theme_user_folder_url}site/default/asset/js/common.min.js\" ></script>\n	</body>\n</html>\n', NULL, 1669134083, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(14, 1, 6, 'index', 'webpage', NULL, '{!-- Explanations and learning materials can be found in news/index and the other news template groups.  In-line comments here are only for features not introduced in news/index. --}\n{html_head}\n	<title>{site_name}: Contact Us</title>\n{global_stylesheets}\n\n{rss}\n{favicon}\n{html_head_end}\n	<body>\n{nav_access}\n	{branding_begin}\n			{embed=\"global_embeds/_top_nav\" loc=\"about\"}\n			{global_top_search}\n			{global_top_member}\n	{branding_end}\n	{wrapper_begin}\n{embed=\"global_embeds/_page_header\" header=\"About\"}\n\n\n<div id=\"feature\" class=\"about\">\n	{exp:channel:entries channel=\"about\" url_title=\"about_the_label\" dynamic=\"no\"  limit=\"1\" disable=\"pagination|member_data|categories|category_fields\"}\n		<h3 class=\"about\">{title}</h3>\n		{about_body}\n	{/exp:channel:entries}\n</div> <!-- ending #feature -->\n\n	<div class=\"feature_end\"></div>\n\n<div id=\"content_pri\" class=\"about\"> <!-- This is where all primary content, left column gets entered -->\n\n		<!-- Standard Channel Entries tag, but instead of relying on the URL for what to display, we request a specific entry for display via url-title:\n	https://docs.expressionengine.com/latest/modules/channel/parameters.html#par_url_title\n\n	and we force the channel entries tag to ignore the URL and always deliver the same content by using dynamic=\"no\":\n\n	https://docs.expressionengine.com/latest/modules/channel/parameters.html#par_dynamic\n	-->\n\n		{exp:channel:entries channel=\"about\" dynamic=\"no\" url_title=\"about_the_label\" limit=\"1\" disable=\"pagination|member_data|categories|category_fields\"}\n			{about_extended}\n		{/exp:channel:entries}\n</div>\n\n<div id=\"content_sec\" class=\"staff_profiles right green40\">\n		<h3 class=\"staff\">Staff Profiles</h3>\n		{exp:channel:entries channel=\"about\" limit=\"6\" category=\"3\" dynamic=\"off\" orderby=\"date\" sort=\"asc\"}\n			{if count == \"1\"}<ul class=\"staff_member\">{/if}\n				<li class=\"{switch=\"||end\"}\">\n					<h4>{title} <a href=\"#\">i</a></h4>\n					<div class=\"profile\">\n						{about_staff_title}\n					</div>\n					<img src=\"{about_image}\" alt=\"{title}\" />\n				</li>\n			{if count == total_results}</ul>{/if}\n		{/exp:channel:entries}\n\n</div>	<!-- ending #content_sec -->\n\n\n\n{global_footer}\n{wrapper_close}\n{js}\n{html_close}\n', NULL, 1669823317, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(15, 1, 7, 'index', 'webpage', NULL, '{layout=\'layouts/_blog-layout\'}\n\n{!--\n	404 Redirect\n	============\n	This is a listing page, it needs categories and pagination to work, but also needs to redirect if segment_2 is invalid . i.e. http://example.com/blog/nothing\n--}\n{if segment_2}\n	{if segment_2 != \'category\' AND segment_2  ~ \'/^(?!P\\d+).*/\'}\n		{redirect=\'404\'}\n	{/if}\n{/if}\n\n{!-- prevents 3rd ++ segments on non category listings --}\n{if segment_3}\n	{if segment_2 != \'category\'}\n		{redirect=\'{segment_1}/{segment_2}\'}\n	{/if}\n{/if}\n\n{!-- prevents 4th ++ segments on category listings --}\n{if segment_4}\n	{if segment_4 ~ \'/^(?!P\\d+).*/\'}\n		{redirect=\'{segment_1}/{segment_2}/{segment_3}\'}\n	{/if}\n{/if}\n\n{!-- prevents 5th ++ segments on paginated category listings --}\n{if segment_5}\n	{redirect=\'{segment_1}/{segment_2}/{segment_3}/{segment_4}\'}\n{/if}\n\n{!-- We use preload replace variables for in-template replacements for things\n     like tag parameters that we might repeat here. That way if we change things\n     down the road, we can just change it here instead of looking all over the\n     template for them. --}\n\n{!-- page vars (prefix p_) --}\n{preload_replace:p_title=\'My Blog\'}\n{preload_replace:p_description=\'A blog about things, things I like and things I do.\'}\n{preload_replace:p_url=\'blog\'}\n{preload_replace:p_url_entry=\'entry\'}\n{!-- channel vars (prefix ch_) --}\n{preload_replace:ch=\'blog\'}\n{preload_replace:ch_disable=\'category_fields|member_data\'}\n\n{!-- every template using the blog layout will set these which lets us use\n	 shared markup with customizable details. --}\n\n{!-- layout vars, channel/page related --}\n{layout:set name=\'ch\' value=\'{ch}\'}\n{layout:set name=\'p_url\' value=\'{p_url}\'}\n{layout:set name=\'p_title\' value=\'{p_title}\'}\n{!-- layout vars, static --}\n{layout:set name=\'title\' value=\'{p_title}{gv_sep}\'}\n{layout:set name=\'description\' value=\'{p_description}\'}\n{!-- OpenGraph meta output --}\n{layout:set name=\'og_title\' value=\'{p_title}\'}\n{layout:set name=\'og_url\'}{path=\'{p_url}\'}{/layout:set}\n{layout:set name=\'og_description\' value=\'{p_description}\'}\n\n{!-- Everything below is the \"meat\" of the template. We\'ll use tags to output content,\n	which will populate the layout:contents of the layouts/_blog-layout layout --}\n\n			{!-- Heading output is different in the case of category listings. --}\n			{if segment_2 == \'category\'}\n				{layout:set name=\'cat_ch\' value=\'{ch}\'}\n				{exp:channel:category_heading channel=\'{ch}\'}\n					<h1>{category_name}</h1>\n					{if category_description}\n						<p>{category_description}</p>\n					{/if}\n				{/exp:channel:category_heading}\n			{if:else}\n				<h1>{p_title}</h1>\n				<p>{p_description}</p>\n			{/if}\n			<div class=\"entries\">\n				{exp:channel:entries channel=\'{ch}\' disable=\'{ch_disable}\' limit=\'5\'}\n					{!-- listing as a snippet, as it\'s used through more than one template --}\n					{snp_blog_list}\n					{!-- no results output --}\n					{if no_results}\n						<div class=\"alert warn no-results\">\n							<p>{gv_entries_none}</p>\n						</div>\n					{/if}\n					{!-- pagination --}\n					{snp_blog_list_paginate}\n				{/exp:channel:entries}\n			</div>', NULL, 1669134083, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(16, 1, 7, 'rss', 'feed', NULL, '{!-- page vars (prefix p_) --}\n{preload_replace:p_title=\'My Blog\'}\n{preload_replace:p_url=\'blog\'}\n{preload_replace:p_url_entry=\'entry\'}\n{!-- channel vars (prefix ch_) --}\n{preload_replace:ch=\'blog\'}\n{preload_replace:ch_disable=\'member_data|pagination\'}\n\n{exp:rss:feed channel=\'{ch}\'}\n	<?xml version=\"1.0\" encoding=\"{encoding}\"?>\n	<rss version=\"2.0\"\n		xmlns:dc=\"http://purl.org/dc/elements/1.1/\"\n		xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\"\n		xmlns:admin=\"http://webns.net/mvcb/\"\n		xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"\n		xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">\n\n		<channel>\n\n			<title><![CDATA[{p_title} / {site_name}]]></title>\n			<link>{site_url}{p_url}/</link>\n			<description>{channel_description}</description>\n			<language>{channel_language}</language>\n			<managingEditor>{email} ({author})</managingEditor>\n			<copyright>Copyright {gmt_date format=\'%Y\'}</copyright>\n			<pubDate>{gmt_date format=\'%Y-%m-%dT%H:%i:%s%Q\'}</pubDate>\n			<admin:generatorAgent rdf:resource=\"{path=\'{p_url}\'}\" />\n\n			{exp:channel:entries channel=\'{ch}\' disable=\'{ch_disable}\' limit=\'10\' rdf=\'off\' dynamic_start=\'yes\'}\n				<item>\n					<title><![CDATA[{title}]]></title>\n					<link>{title_permalink=\'{p_url}/{p_url_entry}\'}</link>\n					<guid>{title_permalink=\'{p_url}/{p_url_entry}\'}</guid>\n					<author>{email} ({author})</author>\n					<description><![CDATA[{blog_content}<p><a href=\"{title_permalink=\"{p_url}/{p_url_entry}\"}\" title=\"{title}\">Read more</a></p>]]></description>\n					<dc:subject><![CDATA[{categories backspace=\'1\'}{category_name}, {/categories}]]></dc:subject>\n					<pubDate>{gmt_entry_date format=\'{DATE_RSS}\'}</pubDate>\n				</item>\n			{/exp:channel:entries}\n\n		</channel>\n	</rss>\n{/exp:rss:feed}', NULL, 1669134083, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(17, 1, 7, 'no-results', 'webpage', NULL, '{layout=\'layouts/_blog-layout\'}\n\n{!-- prevents 4th ++ segments on no results searches --}\n{if segment_4}\n	{redirect=\'{segment_1}/{segment_2}/{segment_3}\'}\n{/if}\n\n{!-- page vars --}\n{preload_replace:p_title=\'My Blog\'}\n{preload_replace:p_description=\'Search Results\'}\n{preload_replace:p_url=\'blog\'}\n{!-- channel vars (prefix ch_) --}\n{preload_replace:ch=\'blog\'}\n{!-- layout vars, channel/page related --}\n{layout:set name=\'ch\' value=\'{ch}\'}\n{layout:set name=\'p_url\' value=\'{p_url}\'}\n{layout:set name=\'p_title\' value=\'{p_title}\'}\n{layout:set name=\'search\' value=\'y\'}\n{!-- layout vars --}\n{layout:set name=\'title\' value=\'search results{gv_sep}{p_title}{gv_sep}\'}\n{layout:set name=\'description\' value=\'{p_description}\'}\n\n		<h1>Search Results, {p_title}</h1>\n		<div class=\"alert warn no-results\">\n			<p>Sorry, zero entries found matching \"<b>{exp:search:keywords}</b>\".</p>\n		</div>\n', NULL, 1669134083, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(18, 1, 7, '_comments', 'webpage', NULL, '{!-- comments --}\n<div id=\"comments\" class=\"comments\">\n	<h2>Commentary</h2>\n	{!-- comment entries --}\n	{exp:comment:entries channel=\'{embed:ch}\'}\n		<div class=\"comment{if author_id == entry_author_id} author{/if}\"{if count == total_results} id=\"last-comment\"{/if}>\n			<section class=\"row\">\n				<section class=\"w-12\">\n					{!-- change the comment text output if the commenter is being ignored by the logged in user. --}\n					{if is_ignored}\n						<div class=\"alert warn\">\n							<p>{gv_comment_ignore} <b>{name}</b>.</p>\n						</div>\n					{if:else}\n						{comment}\n					{/if}\n				</section>\n				<section class=\"w-4\">\n					{!-- mark the author of the post, and ignored differently than other commenters --}\n					<h3{if author_id == entry_author_id} class=\"author\" title=\"Author of Entry\"{if:elseif is_ignored} class=\"ignored\" title=\"Troll\"{/if}>\n						{if url}\n							<a href=\"{url}\" rel=\"external\">{name}</a>\n						{if:else}\n							{url_as_author}\n						{/if}\n					</h3>\n					<p>on {comment_date format=\"%n/%j/%Y\"}{if location}<br>from {location}{/if}</p>\n				</section>\n			</section>\n		</div>\n		{!--\n			no results output\n			===================\n			If there are no comments, show this message.\n		--}\n		{if no_results}\n			<div class=\"alert warn no-results\">\n				<p>{gv_comment_none}</p>\n			</div>\n		{/if}\n	{/exp:comment:entries}\n\n	{!-- comment form --}\n	<div class=\"alert issue hide\"></div>\n	{exp:comment:form channel=\'{embed:ch}\' form_class=\'comment-form\' return=\'{segment_1}/{segment_2}/{segment_3}#last-comment\'}\n		{!-- if the user is logged out show more fields for commenting --}\n		{if logged_out}\n			<h2>Comment as a guest <span class=\"required\">Required Fields &#10033;</span></h2>\n			<fieldset class=\"row\">\n				<section class=\"w-4 instruct\">\n					<label>Name <span class=\"required\" title=\"required field\">&#10033;</span></label>\n					<em>What do you want to be called?</em>\n				</section>\n				<section class=\"w-12 field\">\n					<input class=\"required\" name=\"name\" type=\"text\" value=\"{name}\">\n				</section>\n			</fieldset>\n			<fieldset class=\"row\">\n				<section class=\"w-4 instruct\">\n					<label>e-mail <span class=\"required\" title=\"required field\">&#10033;</span></label>\n					<em>How do we contact you?</em>\n				</section>\n				<section class=\"w-12 field\">\n					<input class=\"required\" name=\"email\" type=\"text\" value=\"{email}\">\n				</section>\n			</fieldset>\n			<fieldset class=\"row\">\n				<section class=\"w-4 instruct\">\n					<label>Location</label>\n					<em>Where are you commenting from?</em>\n				</section>\n				<section class=\"w-12 field\">\n					<input name=\"location\" type=\"text\" value=\"{location}\">\n				</section>\n			</fieldset>\n			<fieldset class=\"row\">\n				<section class=\"w-4 instruct\">\n					<label><abbr title=\"Unified Resource Locator\">URL</abbr></label>\n					<em>Do you have a website to share?</em>\n				</section>\n				<section class=\"w-12 field\">\n					<input name=\"url\" type=\"text\" value=\"{url}\">\n				</section>\n			</fieldset>\n		{if:else}\n			<h2>Comment as <b>{screen_name}</b> <span class=\"required\">&#10033; Required Fields</span></h2>\n		{/if}\n		<fieldset class=\"row\">\n			<section class=\"w-4 instruct\">\n				<label>Comment? <span class=\"required\" title=\"required field\">&#10033;</span></label>\n				<em>Please keep it kind, brief and courteous.</em>\n			</section>\n			<section class=\"w-12 field\">\n				<textarea class=\"required\" name=\"comment\" cols=\"\" rows=\"\"></textarea>\n			</section>\n		</fieldset>\n		<fieldset class=\"row\">\n			<section class=\"w-4 instruct\">\n				<label>Options</label>\n				<em>Extra stuff we can do!</em>\n			</section>\n			<section class=\"w-12 field checks\">\n				<label><input type=\"checkbox\" name=\"save_info\" value=\"yes\" {save_info}> Remember Me?</label>\n				<label><input type=\"checkbox\" name=\"notify_me\" value=\"yes\" {notify_me}> Notify Me?</label>\n			</section>\n		</fieldset>\n		<fieldset class=\"ctrls\">\n			<input class=\"btn\" type=\"submit\" value=\"Comment\">\n		</fieldset>\n		{!-- required to prevent EE from outputting text --}\n		{if comments_disabled}{/if}\n		{if comments_expired}{/if}\n	{/exp:comment:form}\n</div>\n', NULL, 1669134083, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(19, 1, 7, 'search', 'webpage', NULL, '{layout=\'layouts/_blog-layout\'}\n\n{!-- prevents 4th ++ segments on search results --}\n{if segment_4}\n	{if segment_4 ~ \'/^(?!P\\d+).*/\'}\n		{redirect=\'{segment_1}/{segment_2}/{segment_3}\'}\n	{/if}\n{/if}\n\n{!-- prevents 5th ++ segments on paginated search results --}\n{if segment_5}\n	{redirect=\'{segment_1}/{segment_2}/{segment_3}/{segment_4}\'}\n{/if}\n\n{!-- page vars --}\n{preload_replace:p_title=\'My Blog\'}\n{preload_replace:p_description=\'Search Results\'}\n{preload_replace:p_url=\'blog\'}\n{preload_replace:p_url_entry=\'entry\'}\n{!-- channel vars (prefix ch_) --}\n{preload_replace:ch=\'blog\'}\n{!-- layout vars, channel/page related --}\n{layout:set name=\'ch\' value=\'{ch}\'}\n{layout:set name=\'p_url\' value=\'{p_url}\'}\n{layout:set name=\'p_title\' value=\'{p_title}\'}\n{layout:set name=\'search\' value=\'y\'}\n{!-- layout vars --}\n{layout:set name=\'title\' value=\'search results{gv_sep}{p_title}{gv_sep}\'}\n{layout:set name=\'description\' value=\'{p_description}\'}\n\n		<h1>Search Results, {p_title}</h1>\n		<div class=\"entries\">\n			{exp:search:search_results}\n				{!-- listing as a snippet, as it\'s used through more than one template --}\n				{snp_blog_list}\n				{!-- pagination --}\n				{snp_blog_list_paginate}\n			{/exp:search:search_results}\n		</div>\n', NULL, 1669134083, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(20, 1, 7, 'entry', 'webpage', NULL, '{layout=\'layouts/_blog-layout\'}\n\n{!--\n	Redirect\n	============\n	This is a blog single entry page, it\'ll never need a fourth segment, so we use the following code to make sure the page redirects if someone types in an incorrect URL in the browser address bar, by adding new segments. i.e. http://example.com/blog/entry/title/nothing\n--}\n{if segment_4}\n	{redirect=\'{segment_1}/{segment_2}/{segment_3}\'}\n{/if}\n\n{!-- page vars (prefix p_) --}\n{preload_replace:p_title=\'My Blog\'}\n{preload_replace:p_description=\'A blog about things, things I like and things I do.\'}\n{preload_replace:p_url=\'blog\'}\n{preload_replace:p_url_entry=\'entry\'}\n{!-- channel vars (prefix ch_) --}\n{preload_replace:ch=\'blog\'}\n{preload_replace:ch_disable=\'category_fields|member_data|pagination\'}\n{!-- layout vars, channel/page related --}\n{layout:set name=\'ch\' value=\'{ch}\'}\n{layout:set name=\'p_url\' value=\'{p_url}\'}\n{layout:set name=\'p_title\' value=\'{p_title}\'}\n\n\n		{!-- single-entry pagination --}\n		<div class=\"paginate single\">\n			{exp:channel:prev_entry channel=\'{ch}\'}\n				<a class=\"page-prev\" href=\"{path=\'{p_url}/{p_url_entry}\'}\" title=\"{title}\">Previous</a>\n			{/exp:channel:prev_entry}\n			{exp:channel:next_entry channel=\'{ch}\'}\n				<a class=\"page-next\" href=\"{path=\'{p_url}/{p_url_entry}\'}\" title=\"{title}\">Next</a>\n			{/exp:channel:next_entry}\n		</div>\n		{!-- require_entry makes it so if someone types the wrong URL, they will get a 404 page --}\n		{exp:channel:entries channel=\'{ch}\' disable=\'{ch_disable}\' limit=\'1\' require_entry=\'yes\'}\n			{!-- layout vars, dynamic, not output --}\n			{layout:set name=\'title\' value=\'{seo_title}{gv_sep}{p_title}{gv_sep}\'}\n			{layout:set name=\'description\' value=\'{seo_desc}\'}\n			{layout:set name=\'entry_ch\' value=\'{ch}\'}\n			{!-- OpenGraph meta output --}\n			{layout:set name=\'og_title\' value=\'{seo_title}\'}\n			{layout:set name=\'og_url\'}{path=\'{p_url}\'}{/layout:set}\n			{layout:set name=\'og_description\' value=\'{seo_desc}\'}\n			{!-- /layout vars, dynamic, not output --}\n\n			{!-- content output --}\n			<h1>{title}</h1>\n			{!-- video, youtube or vimeo? (GRID) --}\n			{if blog_video}\n				{blog_video}\n					{if blog_video:type == \'youtube\'}\n						<figure class=\"video\">\n							<div class=\"player\">\n								<iframe width=\"940\" height=\"529\" src=\"http://www.youtube.com/embed/{blog_video:id}?rel=0&controls=2&color=white&autohide=1\" frameborder=\"0\" allowfullscreen></iframe>\n							</div>\n						</figure>\n					{/if}\n					{if blog_video:type == \'vimeo\'}\n						<figure class=\"video\">\n							<div class=\"player\">\n								<iframe src=\"//player.vimeo.com/video/{blog_video:id}?color=f0a400\" width=\"940\" height=\"529\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>\n							</div>\n						</figure>\n					{/if}\n				{/blog_video}\n			{/if}\n			{!-- audio, soundcloud or bandcamp? (GRID) --}\n			{if blog_audio}\n				{blog_audio}\n					{if blog_audio:type == \'soundcloud\'}\n						<figure class=\"audio-wrap\">\n							<iframe width=\"100%\" height=\"166\" scrolling=\"no\" frameborder=\"no\" src=\"https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/{blog_audio:id}&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false\"></iframe>\n						</figure>\n					{/if}\n					{if blog_audio:type == \'bandcamp\'}\n						<figure class=\"audio-wrap\">\n							<iframe style=\"border: 0; width: 100%; height: 120px;\" src=\"http://bandcamp.com/EmbeddedPlayer/album={blog_audio:id}/size=large/bgcol=ffffff/linkcol=0687f5/tracklist=false/artwork=small/transparent=true/\" seamless></iframe>\n						</figure>\n					{/if}\n				{/blog_audio}\n			{/if}\n			{!-- image (GRID) --}\n			{if blog_image}\n				{blog_image}\n					<figure>\n						<img src=\"{blog_image:image}\" alt=\"{blog_image:caption:attr_safe}\">\n						<figcaption>{blog_image:caption}</figcaption>\n					</figure>\n				{/blog_image}\n			{/if}\n			{!-- blog_content is a textarea with HTML output we don\'t need to wrap this tag with HTML as that is already included in it\'s output. --}\n			{blog_content}\n			{!-- /content output --}\n\n			{!--\n				no results redirect\n				===================\n				If the entry doesn\'t exist, we redirect to 404. This works in tandem with the require_entry=\'yes\' parameter on the channel entries tag.\n			--}\n			{if no_results}\n				{redirect=\'404\'}\n			{/if}\n			{!--\n				comments\n				comment:entries and comment:form are independent of channel:entries\n				we\'ve put them into a embed here to demonstrate how to get a specific\n				display on the front end of the site using allow_comments.\n				This would not work without the embed, as these tags would not parse\n				inside the channel:entries tag.\n			--}\n			{if allow_comments}\n				{embed=\'{p_url}/_comments\' ch=\'{ch}\'}\n			{if:else}\n				{if comment_total >= 1}\n					{embed=\'{p_url}/_comments\' ch=\'{ch}\'}\n				{/if}\n				<div class=\"alert warn no-results\">\n					{if comment_expiration_date < current_time AND comment_expiration_date != 0}\n						<p>{gv_comment_expired}</p>\n					{if:else}\n						<p>{gv_comment_disabled}</p>\n					{/if}\n				</div>\n			{/if}\n		{/exp:channel:entries}\n', NULL, 1669134083, 0, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(21, 1, 3, 'index', 'webpage', NULL, '', NULL, 1669131554, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(22, 1, 1, 'index', 'webpage', NULL, '', NULL, 1668996362, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(23, 1, 8, 'index', 'webpage', NULL, '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"\n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"{lang}\" lang=\"{lang}\">\n\n<head>\n<title>{site_name}{lang:search}</title>\n\n<meta http-equiv=\"content-type\" content=\"text/html; charset={charset}\" />\n\n<link rel=\'stylesheet\' type=\'text/css\' media=\'all\' href=\'{stylesheet=search/search_css}\' />\n<style type=\'text/css\' media=\'screen\'>@import \"{stylesheet=search/search_css}\";</style>\n\n</head>\n<body>\n\n<div id=\'pageheader\'>\n<div class=\"heading\">{lang:search_engine}</div>\n</div>\n\n<div id=\"content\">\n\n<div class=\'breadcrumb\'>\n<span class=\"defaultBold\">&nbsp; <a href=\"{homepage}\">{site_name}</a>&nbsp;&#8250;&nbsp;&nbsp;{lang:search}</span>\n</div>\n\n<div class=\'outerBorder\'>\n<div class=\'tablePad\'>\n\n{exp:search:advanced_form result_page=\"search/results\" cat_style=\"nested\"}\n\n<table cellpadding=\'4\' cellspacing=\'6\' border=\'0\' width=\'100%\'>\n<tr>\n<td width=\"50%\">\n\n<fieldset class=\"fieldset\">\n<legend>{lang:search_by_keyword}</legend>\n\n<input type=\"text\" class=\"input\" maxlength=\"100\" size=\"40\" name=\"keywords\" style=\"width:100%;\" />\n\n<div class=\"default\">\n<select name=\"search_in\">\n<option value=\"titles\" selected=\"selected\">{lang:search_in_titles}</option>\n<option value=\"entries\">{lang:search_in_entries}</option>\n<option value=\"everywhere\" >{lang:search_everywhere}</option>\n</select>\n\n</div>\n\n<div class=\"default\">\n<select name=\"where\">\n<option value=\"exact\" selected=\"selected\">{lang:exact_phrase_match}</option>\n<option value=\"any\">{lang:search_any_words}</option>\n<option value=\"all\" >{lang:search_all_words}</option>\n<option value=\"word\" >{lang:search_exact_word}</option>\n</select>\n</div>\n\n</fieldset>\n\n<div class=\"default\"><br /></div>\n\n<table cellpadding=\'0\' cellspacing=\'0\' border=\'0\'>\n<tr>\n<td valign=\"top\">\n\n<div class=\"defaultBold\">{lang:channels}</div>\n\n<select id=\"channel_id\" name=\'channel_id[]\' class=\'multiselect\' size=\'12\' multiple=\'multiple\' onchange=\'changemenu(this.selectedIndex);\'>\n{channel_names}\n</select>\n\n</td>\n<td valign=\"top\" width=\"16\">&nbsp;</td>\n<td valign=\"top\">\n\n<div class=\"defaultBold\">{lang:categories}</div>\n\n<select name=\'cat_id[]\' size=\'12\'  class=\'multiselect\' multiple=\'multiple\'>\n<option value=\'all\' selected=\"selected\">{lang:any_category}</option>\n</select>\n\n</td>\n</tr>\n</table>\n\n\n\n</td><td width=\"50%\" valign=\"top\">\n\n\n<fieldset class=\"fieldset\">\n<legend>{lang:search_by_member_name}</legend>\n\n<input type=\"text\" class=\"input\" maxlength=\"100\" size=\"40\" name=\"member_name\" style=\"width:100%;\" />\n<div class=\"default\"><input type=\"checkbox\" class=\"checkbox\" name=\"exact_match\" value=\"y\"  /> {lang:exact_name_match}</div>\n\n</fieldset>\n\n<div class=\"default\"><br /></div>\n\n\n<fieldset class=\"fieldset\">\n<legend>{lang:search_entries_from}</legend>\n\n<select name=\"date\" style=\"width:150px\">\n<option value=\"0\" selected=\"selected\">{lang:any_date}</option>\n<option value=\"1\" >{lang:today_and}</option>\n<option value=\"7\" >{lang:this_week_and}</option>\n<option value=\"30\" >{lang:one_month_ago_and}</option>\n<option value=\"90\" >{lang:three_months_ago_and}</option>\n<option value=\"180\" >{lang:six_months_ago_and}</option>\n<option value=\"365\" >{lang:one_year_ago_and}</option>\n</select>\n\n<div class=\"default\">\n<input type=\'radio\' name=\'date_order\' value=\'newer\' class=\'radio\' checked=\"checked\" />&nbsp;{lang:newer}\n<input type=\'radio\' name=\'date_order\' value=\'older\' class=\'radio\' />&nbsp;{lang:older}\n</div>\n\n</fieldset>\n\n<div class=\"default\"><br /></div>\n\n<fieldset class=\"fieldset\">\n<legend>{lang:sort_results_by}</legend>\n\n<select name=\"orderby\">\n<option value=\"date\" >{lang:date}</option>\n<option value=\"title\" >{lang:title}</option>\n<option value=\"most_comments\" >{lang:most_comments}</option>\n<option value=\"recent_comment\" >{lang:recent_comment}</option>\n</select>\n\n<div class=\"default\">\n<input type=\'radio\' name=\'sort_order\' class=\"radio\" value=\'desc\' checked=\"checked\" /> {lang:descending}\n<input type=\'radio\' name=\'sort_order\' class=\"radio\" value=\'asc\' /> {lang:ascending}\n</div>\n</fieldset>\n\n</td>\n</tr>\n</table>\n\n\n<div class=\'searchSubmit\'>\n\n<input type=\'submit\' value=\'Search\' class=\'submit\' />\n\n</div>\n\n{/exp:search:advanced_form}\n\n<div class=\'copyright\'><a href=\"https://expressionengine.com/\">Powered by ExpressionEngine</a></div>\n\n\n</div>\n</div>\n</div>\n\n</body>\n</html>', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(24, 1, 8, 'no_results', 'webpage', NULL, '{!-- Explanations and learning materials can be found in news/index and the other news template groups.  In-line comments here are only for features not introduced in news/index. --}\n{html_head}\n	<title>{site_name}: No Search Results</title>\n{global_stylesheets}\n{rss}\n{favicon}\n{html_head_end}\n	<body>\n{nav_access}\n	{branding_begin}\n			{embed=\"global_embeds/_top_nav\" loc=\"not_found\"}\n			{global_top_search}\n			{global_top_member}\n	{branding_end}\n	{wrapper_begin}\n{embed=\"global_embeds/_page_header\" header=\"Search Results\"}\n\n\n	<div id=\"content_pri\"> <!-- This is where all primary content, left column gets entered -->\n\n		<!-- No search results: https://docs.expressionengine.com/latest/modules/search/simple.html#par_no_result_page -->\n		<!-- This is delivered based on the no_result_page parameter of the search form  -->\n\n				<h3>Search Results</h3>\n\n				<!-- exp:search:keywords: https://docs.expressionengine.com/latest/modules/search/keywords.html -->\n				<!-- exp:search:keywords lets you echo out what search term was used -->\n					<p>Sorry, no results were found for \"<strong>{exp:search:keywords}</strong>\".  Please try again.</p>\n	</div>\n\n	<div id=\"content_sec\" class=\"right green40\">\n		<h3 class=\"oldernews\">Browse Older News</h3>\n		<div id=\"news_archives\">\n			<div id=\"categories_box\">\n			{news_categories}\n			</div>\n			<div id=\"month_box\">\n			{news_month_archives}\n			</div>\n		</div> <!-- ending #news_archives -->\n\n		{news_calendar}\n\n		{news_popular}\n\n	{rss_links}\n\n	</div>	<!-- ending #content_sec -->\n\n{global_footer}\n{wrapper_close}\n{js}\n{html_close}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(25, 1, 8, 'results', 'webpage', NULL, '{!-- Explanations and learning materials can be found in news/index and the other news template groups.  In-line comments here are only for features not introduced in news/index. --}\n{html_head}\n	<title>{site_name}: {exp:search:search_results}\n		{if count == \"1\"}\n			Search Results for \"{exp:search:keywords}\"\n		{/if}\n		{/exp:search:search_results}\n	</title>\n{global_stylesheets}\n{rss}\n{favicon}\n{html_head_end}\n	<body>\n{nav_access}\n	{branding_begin}\n		{embed=\"global_embeds/_top_nav\" loc=\"not_found\"}\n		{global_top_search}\n		{global_top_member}\n	{branding_end}\n	{wrapper_begin}\n	{embed=\"global_embeds/_page_header\" header=\"Search Results\"}\n\n	<div id=\"content_pri\"> <!-- This is where all primary content, left column gets entered -->\n\n		<!-- Search Results tag: https://docs.expressionengine.com/latest/modules/search/index.html#results -->\n\n		{exp:search:search_results}\n			{if count == \"1\"}\n				<!-- exp:search:keywords: https://docs.expressionengine.com/latest/modules/search/keywords.html -->\n				<!-- exp:search:keywords lets you echo out what search term was used -->\n\n				<h3>Search Results for \"<strong>{exp:search:keywords}</strong>\":</h3>\n				<ul id=\"news_listing\">\n			{/if}\n\n			<li>\n				<h4>\n					<a href=\"{comment_url_title_auto_path}\">{title}</a>  //\n					<!-- entry_date is a variable, and date formatting variables can be found at https://docs.expressionengine.com/latest/templates/date_variable_formatting.html -->\n					{entry_date format=\"%F %d %Y\"}\n				</h4>\n\n				<!-- news_body and news_image are  custom channel fields. https://docs.expressionengine.com/latest/cp/admin/channel_administration/custom_channel_fields.html -->\n				{if news_image}\n					<img src=\"{news_image}\" alt=\"{title}\" />\n				{/if}\n				{news_body}\n			</li>\n			{if count == total_results}</ul>{/if}\n\n			{paginate}\n				<div class=\"pagination\">\n					{pagination_links}\n						<ul>\n							{first_page}\n								<li><a href=\"{pagination_url}\" class=\"page-first\">First Page</a></li>\n							{/first_page}\n\n							{previous_page}\n								<li><a href=\"{pagination_url}\" class=\"page-previous\">Previous Page</a></li>\n							{/previous_page}\n\n							{page}\n								<li><a href=\"{pagination_url}\" class=\"page-{pagination_page_number} {if current_page}active{/if}\">{pagination_page_number}</a></li>\n							{/page}\n\n							{next_page}\n								<li><a href=\"{pagination_url}\" class=\"page-next\">Next Page</a></li>\n							{/next_page}\n\n							{last_page}\n								<li><a href=\"{pagination_url}\" class=\"page-last\">Last Page</a></li>\n							{/last_page}\n						</ul>\n					{/pagination_links}\n				</div> <!-- ending .pagination -->\n			{/paginate}\n		{/exp:search:search_results}\n	</div>\n\n	<div id=\"content_sec\" class=\"right green40\">\n		<h3 class=\"oldernews\">Browse Older News</h3>\n		<div id=\"news_archives\">\n			<div id=\"categories_box\">\n			{news_categories}\n			</div>\n			<div id=\"month_box\">\n			{news_month_archives}\n			</div>\n		</div> <!-- ending #news_archives -->\n\n		{news_calendar}\n\n		{news_popular}\n\n	{rss_links}\n\n	</div>	<!-- ending #content_sec -->\n\n{global_footer}\n{wrapper_close}\n{js}\n{html_close}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(26, 1, 9, 'index', 'webpage', NULL, '{!-- template:blade --}\n\n@php\n$entry = $exp->channel->entries->channel(\'about\')->first()\n@endphp\n\n<h1>{{ $entry->title }}</h1>\n<div>{!! $entry->page_content !!}</div>\n\n@include(\'ee::blade.blade_include\')', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(27, 1, 9, 'blade_include', 'webpage', NULL, '<div>\n    var: {{ $entry->title }}\n</div>', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(28, 1, 10, 'comment_preview', 'webpage', NULL, '{!-- Explanations and learning materials can be found in news/index and the other news template groups.  In-line comments here are only for features not introduced in news/index.\n	 NOTE:  This is an ExpressionEngine Comment and it will not appear in the rendered source.\n			https://docs.expressionengine.com/latest/templates/commenting.html\n--}\n{html_head}\n<!-- Below we use a channel entries tag to deliver a dynamic title element. -->\n	<title>{site_name}: Comment Preview for\n		{exp:channel:entries channel=\"news|about\" limit=\"1\" disable=\"categories|member_data|category_fields|pagination\"}{title}{/exp:channel:entries}</title>\n{global_stylesheets}\n{rss}\n{favicon}\n{html_head_end}\n	<body>\n{nav_access}\n	{branding_begin}\n			{embed=\"global_embeds/_top_nav\" loc=\"home\"}\n			{global_top_search}\n			{global_top_member}\n	{branding_end}\n	{wrapper_begin}\n{embed=\"global_embeds/_page_header\" header=\"News\"}\n	<div id=\"feature\">\n		{global_featured_welcome}\n		{global_featured_band}\n	    </div> <!-- ending #feature -->\n\n        	<div class=\"feature_end\"></div>\n\n	<div id=\"content_pri\"> <!-- This is where all primary content, left column gets entered -->\n		<!--  This is the channel entries tag.  Documentation for this parameter can be found at https://docs.expressionengine.com/latest/modules/channel/channel_entries.html\n				 Parameters are the items inside the opening exp:channel:entries tag that allow limiting, filtering, and sorting. They go in the format item=\"limiter\".  ie: channel=\"news\". Below are links to the parameters used in this particular instance of the channel entries tag.  These are documented here:\n\n				https://docs.expressionengine.com/latest/channels/weblog/parameters.html\n\n		channel= which channel to output, multiple channels may be piped in (channel_1|channel_2)\n		limit= limits the number of entries output in this instance of the tag\n		disable= turns off parsing of un-needed data\n		require_entry= forces ExpressionEngine to compare Segment 3 to existing URL titles.  If there is no match, then nothing is output.  Use this in combination with if no_results to force a redirect to 404. -->\n\n		{exp:channel:entries channel=\"news|about\" disable=\"categories|member_data|category_fields|pagination\" status=\"open|featured\"}\n		<!-- count is a single variable: https://docs.expressionengine.com/latest/modules/weblog/variables.html#var_count\n\n		In this case we\'ve combined the count single variable with a Conditional Global Variable:\n\n		https://docs.expressionengine.com/latest/templates/globals/conditionals.html\n\n		to create code that shows up only once, at the top of the list of outputted channel entries and only if there is 1 or more entries -->\n\n		{if count == \"1\"}\n		<h3 class=\"recentnews\">Recent News</h3>\n		<ul id=\"news_listing\">\n\n			<!-- Here we close the conditional after all of the conditional data is processed. -->\n\n		{/if}\n			<li>\n					<!-- comment_url_title_auto_path is a channel entries variable:\n\n					https://docs.expressionengine.com/latest/modules/channel/variables.html#var_comment_url_title_auto_path\n\n					This allows you to outpt a per-channel link to a single-entry page.  This can be used even if you are not using comments as a way to get a per-channel \"permalink\" page without writing your own conditional. -->\n\n				<h4><a href=\"{comment_url_title_auto_path}\">{title}</a>  //  <!-- entry_date is a variable, and date formatting variables can be found at https://docs.expressionengine.com/latest/templates/date_variable_formatting.html -->{entry_date format=\"%F %d %Y\"}</h4>\n\n				<!-- the following two lines are custom channel fields. https://docs.expressionengine.com/latest/cp/admin/channel_administration/custom_channel_fields.html -->\n\n				{if news_image}\n					<img src=\"{news_image}\" alt=\"{title}\" />\n				{/if}\n\n				<!-- Here we come a custom field variable with a global conditional to output the HTML only if he custom field is _not_ blank -->\n\n				{if about_image != \"\"}<img src=\"{about_image}\" alt=\"{title}\"  />{/if}\n				{news_body}\n				{about_body}\n				{news_extended}\n\n				<!-- Here we compare the channel short-name to a predefined word to output some information only if the entry occurs in a particular channel -->\n				{if channel_short_name == \"news\"}<p><a href=\"{comment_url_title_auto_path}#news_comments\">{comment_total} comments</a> <!-- edit_this is a Snippet: https://docs.expressionengine.com/latest/templates/globals/snippets.html --> {global_edit_this} </p> {/if}\n			</li>\n		<!-- Comparing two channel entries variables to output data only at the end of the list of outputted channel entries -->\n		{if count == total_results}</ul>{/if}\n		<!-- Closing the Channel Entries tag -->\n		{/exp:channel:entries}\n\n			<div id=\"news_comments\">\n			<!-- Comment Entries Tag outputs comments: https://docs.expressionengine.com/latest/ https://docs.expressionengine.com/latest/\n			Parameters found here: https://docs.expressionengine.com/latest/modules/comment/entries.html#parameters\n			sort= defines in what order to sort the comments\n			limit= how many comments to output\n			channel= what channels to show comments from\n			-->\n			{exp:comment:preview channel=\"news|about\"}\n			<h3>Comments</h3>\n			<ol>\n				<li>\n					<h5 class=\"commentdata\">\n						<!-- Comment Entries variable: https://docs.expressionengine.com/latest/modules/comment/entries.html#url_as_author\n						url_as_author outputs the URL if entered/in the member profile (if registered) or just the name if no URL-->\n						{url_as_author}\n						<!-- Comment date:\n						 https://docs.expressionengine.com/latest/modules/comment/entries.html#var_comment_date\n\n						Formatted with Date Variable Formatting:\n\n	https://docs.expressionengine.com/latest//templates/date_variable_formatting.html -->\n\n						<span>{comment_date format=\"%h:%i%a\"}, {comment_date format=\" %m/%d/%Y\"}</span>\n						<!-- Checks if the member has chosen an avatar and displays it if so\n\n	https://docs.expressionengine.com/latest/modules/comment/entries.html#conditionals\n						-->\n						{if avatar}\n							<img src=\"{avatar_url}\" width=\"{avatar_image_width}\" height=\"{avatar_image_height}\" alt=\"{author}\'s avatar\" />\n						{/if}\n					</h5>\n					{comment}\n\n                    <div style=\"clear: both;\"></div>\n				</li>\n			</ol>\n			{/exp:comment:preview}\n\n			<!-- Comment Submission Form:\n\n			https://docs.expressionengine.com/latest/ modules/comment/entries.html#submission_form\n\n			channel= parameter says which channel to submit this comment too.  This is very important to include if you use multiple channels that may have the same URL title.  It will stop the comment from being attached to the wrong entry.  channel= should always be included.\n			-->\n\n\n			{exp:comment:form channel=\"news\"}\n			<h3 class=\"leavecomment\">Leave a comment</h3>\n			<fieldset id=\"comment_fields\">\n			<!-- Show inputs only if the member is logged out.  If logged in, this information is pulled from the member\'s account details -->\n			{if logged_out}\n				<label for=\"name\">\n					<span>Name:</span>\n					<input type=\"text\" id=\"name\" name=\"name\" value=\"{name}\" size=\"50\" />\n				</label>\n				<label for=\"email\">\n					<span>Email:</span>\n					<input type=\"text\" id=\"email\" name=\"email\" value=\"{email}\" size=\"50\" />\n				</label>\n				<label for=\"location\">\n					<span>Location:</span>\n					 <input type=\"text\" id=\"location\" name=\"location\" value=\"{location}\" size=\"50\" />\n				</label>\n				<label for=\"url\">\n					<span>URL:</span>\n					<input type=\"text\" id=\"url\" name=\"url\" value=\"{url}\" size=\"50\" />\n				</label>\n			{/if}\n				<!-- comment_guidelines is a User Defined Global Variable: https://docs.expressionengine.com/latest/templates/globals/user_defined.html -->\n				{comment_guidelines}\n				<label for=\"comment\" class=\"comment\">\n					<span>Comment:</span>\n					<textarea id=\"comment\" name=\"comment\" rows=\"10\" cols=\"70\">{comment}</textarea>\n				</label>\n			</fieldset>\n\n				<fieldset id=\"comment_action\">\n				{if logged_out}\n				<label for=\"save_info\">Remember my personal info? <input type=\"checkbox\" name=\"save_info\" value=\"yes\" {save_info} /> </label>\n				{/if}\n				<label for=\"notify_me\">Notify me of follow-up comments? <input type=\"checkbox\" id=\"notify_me\" name=\"notify_me\" value=\"yes\" {notify_me} /></label>\n\n				<!-- Insert CAPTCHA.  Will show for those that are not exempt from needing the CAPTCHA as set in the member group preferences\n\n				-->\n				{if captcha}\n				<div id=\"captcha_box\">\n					<span>{captcha}</span>\n				</div>\n					<label for=\"captcha\">Please enter the word you see in the image above:\n<input type=\"text\" id=\"captcha\" name=\"captcha\" value=\"{captcha_word}\" maxlength=\"20\" />\n					</label>\n				{/if}\n				<input type=\"submit\" name=\"preview\" value=\"Preview Comment\" />\n				<input type=\"submit\" name=\"submit\" value=\"Submit\" id=\"submit_comment\" />\n			</fieldset>\n			{/exp:comment:form}\n\n	</div> <!-- ending #news_comments -->\n	</div> <!-- ending #content_pri -->\n\n	<div id=\"content_sec\" class=\"right green40\">\n		<h3 class=\"oldernews\">Browse Older News</h3>\n		<div id=\"news_archives\">\n			<!-- The period before the template in this embed indicates a \"hidden template\".  Hidden templates can not be viewed directly but can only be viewed when embedded in another template: https://docs.expressionengine.com/latest/templates/hidden_templates.html -->\n			<div id=\"categories_box\">\n			{news_categories}\n			</div>\n			<div id=\"month_box\">\n			{news_month_archives}\n			</div>\n		</div> <!-- ending #news_archives -->\n\n		{news_calendar}\n\n		{news_popular}\n\n	{rss_links}\n\n	</div>	<!-- ending #content_sec -->\n\n{global_footer}\n{wrapper_close}\n{js}\n{html_close}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(29, 1, 10, 'index', 'webpage', NULL, '{if segment_2 != \'\'}\n  {redirect=\"404\"}\n{/if}\n{html_head}\n	<title>{site_name}</title>\n{global_stylesheets}\n{rss}\n{favicon}\n{html_head_end}\n	<body>\n	{nav_access}\n	{branding_begin}\n			{embed=\"global_embeds/_top_nav\" loc=\"home\"}\n			{global_top_search}\n			{global_top_member}\n	{branding_end}\n	{wrapper_begin}\n{embed=\"global_embeds/_page_header\" header=\"News\"}\n	<div id=\"feature\" class=\"news\">\n			{global_featured_welcome}\n			{global_featured_band}\n	    </div> <!-- ending #feature -->\n\n        	<div class=\"feature_end\"></div>\n\n	<div id=\"content_pri\"> <!-- This is where all primary content, left column gets entered -->\n		<!--  This is the channel entries tag.  Documentation for this parameter can be found at https://docs.expressionengine.com/latest/modules/channel/channel_entries.html\n				 Parameter Explanation:\n		channel= which channel to output, multiple channels may be piped in (channel_1|channel_2)\n		limit= limits the number of entries output in this instance of the tag\n		disable= turns off parsing of un-needed data -->\n\n		{exp:channel:entries channel=\"news\" limit=\"3\" disable=\"categories|member_data|category_fields|pagination\"}\n\n		<!-- if no_results is a conditional variable, it can not be combined with advanced conditionals.  https://docs.expressionengine.com/latest/modules/channel/conditional_variables.html#cond_if_no_results -->\n\n		{if no_results}<p>Sample No Results Information</p>{/if}\n		{if count == \"1\"}\n		<h3 class=\"recentnews\">Recent News</h3>\n		<ul id=\"news_listing\">\n		{/if}\n			<li>\n				<h4><a href=\"{comment_url_title_auto_path}\">{title}</a>  //  <!-- entry_date is a variable, and date formatting variables can be found at https://docs.expressionengine.com/latest/templates/date_variable_formatting.html -->{entry_date format=\"%F %d %Y\"}</h4>\n\n				<!-- the following two lines are custom channel fields. https://docs.expressionengine.com/latest/cp/admin/channel_administration/custom_channel_fields.html -->\n\n				{if news_image}\n					<img src=\"{news_image}\" alt=\"{title}\" />\n				{/if}\n				{news_body}\n				<p><a href=\"{comment_url_title_auto_path}#news_comments\">{comment_total} comments</a> {global_edit_this}\n								{if news_extended != \"\"}  |  <a href=\"{comment_url_title_auto_path}\">Read more</a>{/if}</p>\n\n			</li>\n		{if count == total_results}</ul>{/if}\n		{/exp:channel:entries}\n\n\n\n\n	</div>\n\n	<div id=\"content_sec\" class=\"right green40\">\n		<h3 class=\"oldernews\">Browse Older News</h3>\n		<div id=\"news_archives\">\n			<div id=\"categories_box\">\n			{news_categories}\n			</div>\n			<div id=\"month_box\">\n			{news_month_archives}\n			</div>\n		</div> <!-- ending #news_archives -->\n\n		{news_calendar}\n\n		{news_popular}\n\n	{rss_links}\n\n	</div>	<!-- ending #content_sec -->\n\n{global_footer}\n{wrapper_close}\n{js}\n{html_close}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(30, 1, 10, 'Blade', 'webpage', NULL, '{!-- template:blade --!}\n\nThis is Blade! {{ $test }}', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(31, 1, 10, 'rss', 'feed', NULL, '{exp:rss:feed channel=\"news\"}\n\n<?xml version=\"1.0\" encoding=\"{encoding}\"?>\n<rss version=\"2.0\"\n	xmlns:dc=\"http://purl.org/dc/elements/1.1/\"\n	xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\"\n	xmlns:admin=\"http://webns.net/mvcb/\"\n	xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"\n	xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">\n\n	<channel>\n	\n	<title>{exp:xml_encode}{channel_name}{/exp:xml_encode}</title>\n	<link>{channel_url}</link>\n	<description>{channel_description}</description>\n	<dc:language>{channel_language}</dc:language>\n	<dc:creator>{email}</dc:creator>\n	<dc:rights>Copyright {gmt_date format=\"%Y\"}</dc:rights>\n	<dc:date>{gmt_date format=\"%Y-%m-%dT%H:%i:%s%Q\"}</dc:date>\n	<admin:generatorAgent rdf:resource=\"https://expressionengine.com/\" />\n	\n{exp:channel:entries channel=\"news\" limit=\"10\" dynamic_start=\"on\" disable=\"member_data\"}\n	<item>\n	  <title>{exp:xml_encode}{title}{/exp:xml_encode}</title>\n	  <link>{comment_url_title_auto_path}</link>\n	  <guid>{comment_url_title_auto_path}#When:{gmt_entry_date format=\"%H:%i:%sZ\"}</guid>\n	  <description><![CDATA[{news_body}]]></description> \n	  <dc:subject>{exp:xml_encode}{categories backspace=\"1\"}{category_name}, {/categories}{/exp:xml_encode}</dc:subject>\n	  <dc:date>{gmt_entry_date format=\"%Y-%m-%dT%H:%i:%s%Q\"}</dc:date>\n	</item>\n{/exp:channel:entries}\n	\n	</channel>\n</rss>\n\n{/exp:rss:feed}						', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(32, 1, 10, 'comments', 'webpage', NULL, '{!-- Explanations and learning materials can be found in news/index and the other news template groups.  In-line comments here are only for features not introduced in news/index.\n	 NOTE:  This is an ExpressionEngine Comment and it will not appear in the rendered source.\n			https://docs.expressionengine.com/latest/templates/commenting.html\n--}\n{html_head}\n<!-- Below we use a channel entries tag to deliver a dynamic title element. -->\n	<title>{site_name}: Comments  on\n		{exp:channel:entries channel=\"news|about\" limit=\"1\" disable=\"categories|member_data|category_fields|pagination\"}{title}{/exp:channel:entries}</title>\n{global_stylesheets}\n{rss}\n{favicon}\n{html_head_end}\n	<body>\n{nav_access}\n	{branding_begin}\n			{embed=\"global_embeds/_top_nav\" loc=\"home\"}\n			{global_top_search}\n			{global_top_member}\n	{branding_end}\n	{wrapper_begin}\n{embed=\"global_embeds/_page_header\" header=\"News\"}\n	<div id=\"feature\">\n			{global_featured_welcome}\n			{global_featured_band}\n	    </div> <!-- ending #feature -->\n\n        	<div class=\"feature_end\"></div>\n\n	<div id=\"content_pri\"> <!-- This is where all primary content, left column gets entered -->\n		<!--  This is the channel entries tag.  Documentation for this parameter can be found at https://docs.expressionengine.com/latest/modules/channel/channel_entries.html\n				 Parameters are the items inside the opening exp:channel:entries tag that allow limiting, filtering, and sorting. They go in the format item=\"limiter\".  ie: channel=\"news\". Below are links to the parameters used in this particular instance of the channel entries tag.  These are documented here:\n\n				https://docs.expressionengine.com/latest/channels/weblog/parameters.html\n\n		channel= which channel to output, multiple channels may be piped in (channel_1|channel_2)\n		limit= limits the number of entries output in this instance of the tag\n		disable= turns off parsing of un-needed data\n		require_entry= forces ExpressionEngine to compare Segment 3 to existing URL titles.  If there is no match, then nothing is output.  Use this in combination with if no_results to force a redirect to 404. -->\n\n		{exp:channel:entries channel=\"news|about\" limit=\"3\" disable=\"categories|member_data|category_fields|pagination\" require_entry=\"yes\" status=\"open|featured\"}\n\n		<!-- if no_results is a conditional variable, it can not be combined with advanced conditionals.  https://docs.expressionengine.com/latest/modules/channel/conditional_variables.html#cond_if_no_results\n\n		This is used here in combination with the require_entry parameter to ensure correct delivery of information or redirect to a 404 -->\n\n		{if no_results}{redirect=\"404\"}{/if}\n		<!-- count is a single variable: https://docs.expressionengine.com/latest/modules/weblog/variables.html#var_count\n\n		In this case we\'ve combined the count single variable with a Conditional Global Variable:\n\n		https://docs.expressionengine.com/latest/templates/globals/conditionals.html\n\n		to create code that shows up only once, at the top of the list of outputted channel entries and only if there is 1 or more entries -->\n\n		{if count == \"1\"}\n		<h3 class=\"recentnews\">Recent News</h3>\n		<ul id=\"news_listing\">\n\n			<!-- Here we close the conditional after all of the conditional data is processed. -->\n\n		{/if}\n			<li>\n					<!-- comment_url_title_auto_path is a channel entries variable:\n\n					https://docs.expressionengine.com/latest/modules/channel/variables.html#var_comment_url_title_auto_path\n\n					This allows you to outpt a per-channel link to a single-entry page.  This can be used even if you are not using comments as a way to get a per-channel \"permalink\" page without writing your own conditional. -->\n\n				<h4><a href=\"{comment_url_title_auto_path}\">{title}</a>  //  <!-- entry_date is a variable, and date formatting variables can be found at https://docs.expressionengine.com/latest/templates/date_variable_formatting.html -->{entry_date format=\"%F %d %Y\"}</h4>\n\n				<!-- the following two lines are custom channel fields. https://docs.expressionengine.com/latest/cp/admin/channel_administration/custom_channel_fields.html -->\n\n				{if news_image}\n					<img src=\"{news_image}\" alt=\"{title}\" />\n				{/if}\n\n				<!-- Here we come a custom field variable with a global conditional to output the HTML only if he custom field is _not_ blank -->\n\n				{if about_image != \"\"}<img src=\"{about_image}\" alt=\"{title}\"  />{/if}\n				{news_body}\n				{about_body}\n				{news_extended}\n\n				<!-- Here we compare the channel short-name to a predefined word to output some information only if the entry occurs in a particular channel -->\n				{if channel_short_name == \"news\"}<p><a href=\"{comment_url_title_auto_path}#news_comments\">{comment_total} comments</a> <!-- edit_this is a Snippet: https://docs.expressionengine.com/latest/templates/globals/snippets.html --> {global_edit_this} </p> {/if}\n			</li>\n		<!-- Comparing two channel entries variables to output data only at the end of the list of outputted channel entries -->\n		{if count == total_results}</ul>{/if}\n		<!-- Closing the Channel Entries tag -->\n		{/exp:channel:entries}\n\n			<div id=\"news_comments\">\n			<!-- Comment Entries Tag outputs comments: https://docs.expressionengine.com/latest/ https://docs.expressionengine.com/latest/\n			Parameters found here: https://docs.expressionengine.com/latest/modules/comment/entries.html#parameters\n			sort= defines in what order to sort the comments\n			limit= how many comments to output\n			channel= what channels to show comments from\n			-->\n			{exp:comment:entries sort=\"asc\" limit=\"20\" channel=\"news\"}\n			{if count == \"1\"}\n			<h3>Comments</h3>\n			<ol>{/if}\n				<li>\n					<h5 class=\"commentdata\">\n						<!-- Comment Entries variable: https://docs.expressionengine.com/latest/modules/comment/entries.html#url_as_author\n						url_as_author outputs the URL if entered/in the member profile (if registered) or just the name if no URL-->\n						{url_as_author}\n						<!-- Comment date:\n						 https://docs.expressionengine.com/latest/modules/comment/entries.html#var_comment_date\n\n						Formatted with Date Variable Formatting:\n\n	https://docs.expressionengine.com/latest//templates/date_variable_formatting.html -->\n\n						<span>{comment_date format=\"%h:%i%a\"}, {comment_date format=\" %m/%d/%Y\"}</span>\n						<!-- Checks if the member has chosen an avatar and displays it if so\n\n	https://docs.expressionengine.com/latest/modules/comment/entries.html#conditionals\n						-->\n						{if avatar}\n							<img src=\"{avatar_url}\" width=\"{avatar_image_width}\" height=\"{avatar_image_height}\" alt=\"{author}\'s avatar\" />\n						{/if}\n					</h5>\n					{comment}\n\n                    <div style=\"clear: both;\"></div>\n				</li>\n			{if count == total_results}</ol>{/if}\n			{/exp:comment:entries}\n\n			<!-- Comment Submission Form:\n\n			https://docs.expressionengine.com/latest/ modules/comment/entries.html#submission_form\n\n			channel= parameter says which channel to submit this comment too.  This is very important to include if you use multiple channels that may have the same URL title.  It will stop the comment from being attached to the wrong entry.  channel= should always be included.\n\n			-->\n\n			{exp:comment:form channel=\"news\" preview=\"news/comment_preview\"}\n			<h3 class=\"leavecomment\">Leave a comment</h3>\n			<fieldset id=\"comment_fields\">\n			<!-- Show inputs only if the member is logged out.  If logged in, this information is pulled from the member\'s account details -->\n			{if logged_out}\n				<label for=\"name\">\n					<span>Name:</span>\n					<input type=\"text\" id=\"name\" name=\"name\" value=\"{name}\" size=\"50\" />\n				</label>\n				<label for=\"email\">\n					<span>Email:</span>\n					<input type=\"text\" id=\"email\" name=\"email\" value=\"{email}\" size=\"50\" />\n				</label>\n				<label for=\"location\">\n					<span>Location:</span>\n					 <input type=\"text\" id=\"location\" name=\"location\" value=\"{location}\" size=\"50\" />\n				</label>\n				<label for=\"url\">\n					<span>URL:</span>\n					<input type=\"text\" id=\"url\" name=\"url\" value=\"{url}\" size=\"50\" />\n				</label>\n			{/if}\n				<!-- comment_guidelines is a User Defined Global Variable: https://docs.expressionengine.com/latest/templates/globals/user_defined.html -->\n				{comment_guidelines}\n				<label for=\"comment\" class=\"comment\">\n					<span>Comment:</span>\n					<textarea id=\"comment\" name=\"comment\" rows=\"10\" cols=\"70\">{comment}</textarea>\n				</label>\n			</fieldset>\n\n				<fieldset id=\"comment_action\">\n				{if logged_out}\n				<label for=\"save_info\">Remember my personal info? <input type=\"checkbox\" name=\"save_info\" value=\"yes\" {save_info} /> </label>\n				{/if}\n				<label for=\"notify_me\">Notify me of follow-up comments? <input type=\"checkbox\" id=\"notify_me\" name=\"notify_me\" value=\"yes\" {notify_me} /></label>\n\n				<!-- Insert CAPTCHA.  Will show for those that are not exempt from needing the CAPTCHA as set in the member group preferences\n\n				-->\n				{if captcha}\n				<div id=\"captcha_box\">\n					<span>{captcha}</span>\n				</div>\n					<label for=\"captcha\">Please enter the word you see in the image above:\n<input type=\"text\" id=\"captcha\" name=\"captcha\" value=\"{captcha_word}\" maxlength=\"20\" />\n					</label>\n				{/if}\n				<input type=\"submit\" name=\"preview\" value=\"Preview Comment\" />\n				<input type=\"submit\" name=\"submit\" value=\"Submit\" id=\"submit_comment\" />\n			</fieldset>\n			{/exp:comment:form}\n\n	</div> <!-- ending #news_comments -->\n	</div> <!-- ending #content_pri -->\n\n	<div id=\"content_sec\" class=\"right green40\">\n		<h3 class=\"oldernews\">Browse Older News</h3>\n		<div id=\"news_archives\">\n			<!-- The period before the template in this embed indicates a \"hidden template\".  Hidden templates can not be viewed directly but can only be viewed when embedded in another template: https://docs.expressionengine.com/latest/templates/hidden_templates.html -->\n			<div id=\"categories_box\">\n			{news_categories}\n			</div>\n			<div id=\"month_box\">\n			{news_month_archives}\n			</div>\n		</div> <!-- ending #news_archives -->\n\n		{news_calendar}\n\n		{news_popular}\n\n	{rss_links}\n\n	</div>	<!-- ending #content_sec -->\n\n{global_footer}\n{wrapper_close}\n{js}\n{html_close}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(33, 1, 10, 'test_embed', 'webpage', NULL, 'EE Template\n\n<code>\n{embed=\"news/twig\" test_var=\"bob\"}\n</code>\n\nBack to EE!', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(34, 1, 10, 'atom', 'feed', NULL, '{exp:rss:feed channel=\"news\"}\n\n<?xml version=\"1.0\" encoding=\"{encoding}\"?>\n<feed xmlns=\"http://www.w3.org/2005/Atom\" xml:lang=\"{channel_language}\">\n\n	<title type=\"text\">{exp:xml_encode}{channel_name}{/exp:xml_encode}</title>\n	<subtitle type=\"text\">{exp:xml_encode}{channel_name}:{channel_description}{/exp:xml_encode}</subtitle>\n	<link rel=\"alternate\" type=\"text/html\" href=\"{channel_url}\" />\n	<link rel=\"self\" type=\"application/atom+xml\" href=\"{path={atom_feed_location}}\" />\n	<updated>{gmt_edit_date format=\'%Y-%m-%dT%H:%i:%sZ\'}</updated>\n	<rights>Copyright (c) {gmt_date format=\"%Y\"}, {author}</rights>\n	<generator uri=\"https://expressionengine.com/\" version=\"{version}\">ExpressionEngine</generator>\n	<id>tag:{trimmed_url},{gmt_date format=\"%Y:%m:%d\"}</id>\n\n{exp:channel:entries channel=\"news\" limit=\"15\" dynamic_start=\"on\" disable=\"member_data\"}\n	<entry>\n	  <title>{exp:xml_encode}{title}{/exp:xml_encode}</title>\n	  <link rel=\"alternate\" type=\"text/html\" href=\"{comment_url_title_auto_path}\" />\n	  <id>tag:{trimmed_url},{gmt_entry_date format=\"%Y\"}:{relative_url}/{channel_id}.{entry_id}</id>\n	  <published>{gmt_entry_date format=\"%Y-%m-%dT%H:%i:%sZ\"}</published>\n	  <updated>{gmt_edit_date format=\'%Y-%m-%dT%H:%i:%sZ\'}</updated>\n	  <author>\n			<name>{author}</name>\n			<email>{email}</email>\n			{if url}<uri>{url}</uri>{/if}\n	  </author>\n{categories}\n	  <category term=\"{exp:xml_encode}{category_name}{/exp:xml_encode}\"\n		scheme=\"{path=news/index}\"\n		label=\"{exp:xml_encode}{category_name}{/exp:xml_encode}\" />{/categories}\n	  <content type=\"html\"><![CDATA[\n		{news_body} {news_extended}\n	  ]]></content>\n	</entry>\n{/exp:channel:entries}\n\n</feed>\n\n{/exp:rss:feed}						', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(35, 1, 10, 'Twig', 'webpage', NULL, '{!-- template:twig --!}\n\nThis is Twig! {{ test }}', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(36, 1, 10, 'archives', 'webpage', NULL, '{html_head}\n	<title>{site_name}: News Archives</title>\n{global_stylesheets}\n{rss}\n{favicon}\n{html_head_end}\n	<body>\n	{nav_access}\n	{branding_begin}\n			{embed=\"global_embeds/_top_nav\" loc=\"home\"}\n			{global_top_search}\n			{global_top_member}\n	{branding_end}\n	{wrapper_begin}\n{embed=\"global_embeds/_page_header\" header=\"News\"}\n	<div id=\"feature\">\n			{global_featured_welcome}\n			{global_featured_band}\n	    </div> <!-- ending #feature -->\n\n        	<div class=\"feature_end\"></div>\n\n	<div id=\"content_pri\" class=\"archive\"> <!-- This is where all primary content, left column gets entered -->\n\n			<!--  This is the channel entries tag.  Documentation for this tag can be found at https://docs.expressionengine.com/latest/modules/weblog/parameters.html\n\n			channel= which channel to output, multiple channels may be piped in (channel_1|channel_2)\n			limit= limits the number of entries output in this instance of the tag\n			disable= turns off parsing of un-needed data\n			relaxed_categories= allows you use the category indicator in your URLs with an entries tag specifying multiple weblogs that do not share category groups.\n\n			-->\n\n		{exp:channel:entries channel=\"news\" limit=\"3\" disable=\"member_data|category_fields|pagination\" status=\"open|featured\" relaxed_categories=\"yes\"}\n\n		<!-- if no_results is a conditional variable, it can not be combined with advanced conditionals.  https://docs.expressionengine.com/latest/modules/channel/conditional_variables.html#cond_if_no_results -->\n\n		{if no_results}<p>No Results</p>{/if}\n		{if count == \"1\"}\n		<h3 class=\"recentnews\">Recent News</h3>\n		<ul id=\"news_listing\">\n		{/if}\n			<li>\n				<h4><a href=\"{comment_url_title_auto_path}\">{title}</a>  //  {!-- entry_date is a variable, and date formatting variables can be found at https://docs.expressionengine.com/latest/templates/date_variable_formatting.html --}{entry_date format=\"%F %d %Y\"}</h4>\n\n				<!-- the following two lines are custom channel fields. https://docs.expressionengine.com/latest/cp/admin/channel_administration/custom_channel_fields.html -->\n\n				{if news_image}\n					<img src=\"{news_image}\" alt=\"{title}\" />\n				{/if}\n				{news_body}\n				<p><a href=\"{comment_url_title_auto_path}#news_comments\">{comment_total} comments</a> {global_edit_this}\n								{if news_extended != \"\"}  |  <a href=\"{comment_url_title_auto_path}\">Read more</a>{/if}</p>\n\n			</li>\n		{if count == total_results}</ul>{/if}\n		{/exp:channel:entries}\n\n\n\n\n	</div>\n\n	<div id=\"content_sec\" class=\"right green40\">\n		<h3 class=\"oldernews\">Browse Older News</h3>\n		<div id=\"news_archives\">\n			<div id=\"categories_box\">\n			{news_categories}\n			</div>\n			<div id=\"month_box\">\n			{news_month_archives}\n			</div>\n		</div> <!-- ending #news_archives -->\n\n		{news_calendar}\n\n		{news_popular}\n\n	{rss_links}\n\n	</div>	<!-- ending #content_sec -->\n\n{global_footer}\n{wrapper_close}\n{js}\n{html_close}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(37, 1, 11, 'index', 'webpage', NULL, '<h1>Test Site</h1>\n\n<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>\n<ul>\n   <li>Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</li>\n   <li>Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</li>\n   <li>Phasellus ultrices nulla quis nibh. Quisque a lectus. Donec consectetuer ligula vulputate sem tristique cursus. Nam nulla quam, gravida non, commodo a, sodales sit amet, nisi.</li>\n   <li>Pellentesque fermentum dolor. Aliquam quam lectus, facilisis auctor, ultrices ut, elementum vulputate, nunc.</li>\n</ul>', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(38, 1, 12, 'index', 'webpage', NULL, '<html>\n    <body>\n        <div class=\"open\">\n            {exp:channel:entries entry_id=\"1\"} \n                {related_news} \n                    <p>{related_news:title}</p>\n                {/related_news}\n            {/exp:channel:entries}\n        </div>\n        <div class=\"all\">\n            {exp:channel:entries entry_id=\"1\"} \n                {related_news status=\"open|Featured\"} \n                    <p>{related_news:title}</p>\n                {/related_news}\n            {/exp:channel:entries}\n        </div>\n        <div class=\"not_open\">\n            {exp:channel:entries entry_id=\"1\"} \n                {related_news status=\"not open\"} \n                    <p>{related_news:title}</p>\n                {/related_news}\n            {/exp:channel:entries}\n        </div>\n    </body>\n</html>\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(39, 1, 12, 'reverse', 'webpage', NULL, '<html>\n    <body>\n        <div class=\"all\">\n            {exp:channel:entries entry_id=\"2\"} \n                {parents} \n                    <p>{parents:title}</p>\n                {/parents}\n            {/exp:channel:entries}\n        </div>\n        <div class=\"not_open\">\n            {exp:channel:entries entry_id=\"2\"} \n                {parents status=\"not open\"} \n                    <p>{parents:title}</p>\n                {/parents}\n            {/exp:channel:entries}\n        </div>\n        <div class=\"not_all\">\n            {exp:channel:entries entry_id=\"2\"} \n                {parents status=\"not open|Featured\"} \n                    <p>{parents:title}</p>\n                {/parents}\n            {/exp:channel:entries}\n        </div>\n    </body>\n</html>\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(40, 1, 12, 'siblings', 'webpage', NULL, '<html>\n    <body>\n        <div class=\"all\">\n            {exp:channel:entries entry_id=\"{segment_3}\" status=\"open|Featured\"} \n                {siblings status=\"open|Featured\"} \n                    <p>{siblings:title}</p>\n                {/siblings}\n            {/exp:channel:entries}\n        </div>\n        <div class=\"open\">\n            {exp:channel:entries entry_id=\"{segment_3}\" status=\"open|Featured\"} \n                {siblings status=\"open\"} \n                    <p>{siblings:title}</p>\n                {/siblings}\n            {/exp:channel:entries}\n        </div>\n        <div class=\"not_open\">\n            {exp:channel:entries entry_id=\"{segment_3}\" status=\"open|Featured\"} \n                {siblings status=\"not open\"} \n                    <p>{siblings:title}</p>\n                {/siblings}\n            {/exp:channel:entries}\n        </div>\n    </body>\n</html>\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(41, 1, 13, 'index', 'webpage', NULL, '{!-- template:twig --}\n\n\n{% extends \"ee::default_site.twig._layout\" %}\n\n{% set entry = exp.channel.entries.channel(\'about\').first() %}\n\n{% block contents %}\n    <h1>{{ entry.title }}</h1>\n    <h2>{{ global.site_url}} </h2>\n    <div>{{ entry.page_content | raw }}</div>\n\n    {% include(\'ee::default_site.twig.twig_include\') %}\n\n{% endblock %}\n\n\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(42, 1, 13, '_layout', 'webpage', NULL, '<html>\n\n<body>\n    <h1>Layout</h1>\n    <div class=\"content\">\n        {% block contents %}{% endblock %}\n    </div>\n</body>\n\n</html>', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(43, 1, 13, 'test23', 'webpage', 'twig', 'test23333', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(44, 1, 13, 'another_test', 'webpage', NULL, '', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(45, 1, 13, 'ee', 'webpage', NULL, '{exp:channel:entries channel=\"about\" dynamic=\"no\"}\n	<h1>{title}</h1>\n	{embed=\"twig/_embed\" entry_id=\"{entry_id}\"}\n{/exp:channel:entries}', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(46, 1, 13, '_embed', 'webpage', NULL, '{!-- template:twig --}\n<h2>{{ embed.entry_id }} + 2 = {{ embed.entry_id + 2 }}</h2>', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(47, 1, 13, 'twig_include', 'webpage', NULL, '<div>\nvar: {{ entry.title }}\n</div>', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(48, 1, 14, 'index', 'webpage', NULL, '', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(49, 1, 14, 'site_css', 'css', NULL, 'html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,font,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,hr{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-size:100%;font-family:inherit;vertical-align:baseline;}:focus{outline:0;}body{line-height:1;color:black;background:white;}ol,ul{list-style:none;}table{border-collapse:collapse;border-spacing:0;}caption,th,td{text-align:left;font-weight:normal;}blockquote:before,blockquote:after,q:before,q:after{content:\"\";}blockquote,q{quotes:\"\"\"\";}@font-face{font-family:\'miso\';src:url(\'{site_url}themes/site/default/fonts/miso-bold.ttf\');}body{background:#ccc url({site_url}themes/site/default/images/body_bg.jpg) top center;font-size:13px;font-family:Arial,sans-serif;}ul#nav_access{position:absolute;top:-9999px;left:-9999px;}p,ul,dl,ol{margin-bottom:22px;line-height:22px;}ul{list-style:url({site_url}themes/site/default/images/bullet.jpg);}ul li{margin-left:12px;}ol{list-style:decimal;list-style-position:inside;}hr{height:0;border-top:1px solid #ccc;margin-bottom:22px;}abbr{border-bottom:1px dotted;}strong{font-weight:bold;}em{font-style:italic;}h1,h2,h3,h4,h5{font-weight:bold;}h2{color:#48482d;font-size:16px;margin-bottom:10px;}h3{margin-bottom:20px;}h4{margin-bottom:10px;}h5{margin-bottom:10px;}h6{text-transform:uppercase;font-size:11px;color:#666;letter-spacing:1px;margin-bottom:10px;}a:link,a:visited{color:#333;text-decoration:underline;}a:hover,a:focus{color:#111;}h2 a:link,h2 a:visited,h3 a:link,h3 a:visited,h4 a:link,h4 a:visited{text-decoration:none;}\n\n/* Tables */\n/* site_url explanation: https://docs.expressionengine.com/latest/templates/globals/single_variables.html#var_site_url */\n/* only site_url will be parsed, other variables will not be parsed unless you call the stylesheet using path= instead of stylesheet=:\n\nhttps://docs.expressionengine.com/latest/templates/globals/stylesheet.html */\n\ntable{background:url({site_url}themes/site/default/images/white_40.png);font-size:12px;}\ntr{border-bottom:1px dotted #999;}\ntr.alt{background:url({site_url}themes/site/default/images/white_20.png);}\nth,td{padding:10px;}\nth{background:url({site_url}themes/site/default/images/white_20.png);color:#666;font-weight:bold;font-size:13px;}\n.member_table{width:60%; margin:10px;}\n.member_console{width:100%;}\n\n/* Page Styles */\ndiv#branding{height:290px;background:url({site_url}themes/site/default/images/branding_bg.png) repeat-x center top;position:relative;z-index:2;}\ndiv#branding_sub{width:930px;margin:0 auto;position:relative;}\ndiv#page{width:950px;padding-top:50px;margin:0 auto;position:relative;top:0px;margin-top:-80px;z-index:1;background:url({site_url}themes/site/default/images/white_40.png);}\ndiv#content_wrapper{padding-top:30px;}\ndiv#feature{width:950px;background:url({site_url}themes/site/default/images/white_70.png);float:left;padding-top:30px;position:relative;bottom:30px;margin-bottom:-30px;}\n\ndiv.feature_end {background:transparent url({site_url}themes/site/default/images/agile_sprite.png) no-repeat scroll left -747px; border:none;outline:none;clear:both;height:35px;margin-top:-6px;margin-bottom:20px;width:950px;}\n\ndiv#legend{width:950px;background:url({site_url}themes/site/default/images/white_70.png);overflow:hidden;position:relative;top:30px;margin-top:-30px;padding:10px 0 30px 0;font-size:11px;}\nhr.legend_start{width:950px;clear:both;background:url({site_url}themes/site/default/images/white_70_top.png) no-repeat top left;height:35px;margin:0;margin-top:20px;border:none;}\ndiv#content_pri{width:610px;float:left;margin:0 30px 0 10px;}\ndiv#content_sec{width:270px;float:left;}\n\ninput.input { border:1px solid #aaa; position:relative; left:5px; background:url({site_url}themes/site/default/images/white_50.png);}\ninput.input:focus { background:url({site_url}themes/site/default/images/white_70.png); }\ntextarea { border:1px solid #aaa; background:url({site_url}themes/site/default/images/white_50.png); }\ntextarea:focus { background:url({site_url}themes/site/default/images/white_70.png); }\n\n\n\n\n/* Branding */\ndiv#branding_logo{background:url({site_url}themes/site/default/images/agile_sprite.png) no-repeat 9px -428px;margin:0 auto;position:relative;left:-80px;margin-bottom:-230px;height:230px;width:950px;}\ndiv#branding_logo img{display:none;}\ndiv#branding_sub h1 a {width:182px;height:196px;display:block;text-indent:-9999em;background:url({site_url}themes/site/default/images/agile_sprite.png) no-repeat -264px 15px;  padding-top:15px;}\ndiv#branding_sub form{position:absolute; right:130px;top:25px;width:240px;height:51px;background:url({site_url}themes/site/default/images/agile_sprite.png) no-repeat -534px -21px;}\ndiv#branding_sub form fieldset{position:relative;}\ndiv#branding_sub form label{text-indent:-9999em;margin-top:10px;width:60px;padding:5px;position:absolute;left:0px;display:inline;}\ndiv#branding_sub form input#search{background:none;border:none;position:absolute;top:13px;left:70px;width:100px;padding:2px 5px;font-size:11px;color:#fff;}\n\ndiv#branding_sub form input#submit{position:absolute;right:30px;top:6px; background:transparent url({site_url}themes/site/default/images/agile_sprite.png) no-repeat -587px -77px; width:24px; height:24px; display:block; font-size:1px; border:none; outline:none;}\n\ndiv#branding_sub div#member{position:absolute;right:0;top:20px;background:url({site_url}themes/site/default/images/brown_40.png);border:1px solid #846f65;color:#ccc;font-size:11px;padding:8px;}\ndiv#branding_sub div#member ul{margin:0;line-height:13px;list-style:disc;}\ndiv#branding_sub div#member h4{margin-bottom:4px;}\ndiv#branding_sub div#member a:link, div#branding_sub div#member a:visited{color:#ccc;}\ndiv#branding_sub div#member a:hover, div#branding_sub div#member a:focus{color:#fff;}\n\n/* Navigation */\nul#navigation_pri{list-style:none;margin:0 auto;padding:5px 15px;width:340px;max-height:100px;background:#2f261d;position:absolute;right:0;bottom:20px;}\nul#navigation_pri li{margin:0;float:left;font-size:16px;width:33%;}\nul#navigation_pri li a{font-family:\'Cooper Black\',miso,\'Georgia\',serif;font-weight:bold;color:#999999;text-decoration:none}\nul#navigation_pri li a:hover{color:#efefef;}\nul#navigation_pri li.cur a{color:#f47424}\n\n/* Footer */\ndiv#siteinfo{background:url({site_url}themes/site/default/images/agile_sprite.png) no-repeat left -287px;height:80px;padding-top:40px;position:relative;clear:both;font-size:12px;z-index:3;}\ndiv#siteinfo p{color:#5b5b42;font-weight:bold;margin:0 0 0 10px;}\ndiv#siteinfo p.logo{width:65px;height:70px;background:url({site_url}themes/site/default/images/agile_sprite.png); text-indent:-9999em;position:absolute;left:865px;bottom:15px;}\ndiv#siteinfo a {color:#5b5b42;text-decoration:underline;}\ndiv#siteinfo a:hover {color:#3B3A25;text-decoration:underline;}\ndiv#siteinfo p.logo a{display:block;}\n\n\n/* 11.PAGEHEADERS\n---------------------------------------------------------------------- */\n\ndiv#page_header { background:url({site_url}themes/site/default/images/agile_sprite.png) no-repeat left -205px; height:72px; z-index:3; position:relative; top:-25px; margin-bottom:-15px; }\n\ndiv#page_header h2 { float:left; font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-weight: normal; text-transform:uppercase; color:#ebebeb; letter-spacing: -0.01em; }\ndiv#page_header h2 a { display:block; }\n\ndiv#page_header h2 { margin:0; width:400px; height:15px; padding-top:30px; margin-left:10px;}\n\ndiv#page_header ol#breadcrumbs { float:left; list-style:none; margin:0; margin-left:10px; margin-top:26px; padding:0px 0 0 20px; background:url({site_url}themes/site/default/images/breadcrumbs_bg.png) no-repeat left center; }\ndiv#page_header ol#breadcrumbs li { margin:0; float:left; font-weight:bold; color:#d6d6d6; text-transform:uppercase; font-size:12px; }\ndiv#page_header ol#breadcrumbs li a { color:#d6d6d6; text-decoration:none; }\n\n\n/*  Featured Band / Welcome\n-------------------------------- */\ndiv#featured_band {width:450px; float:left; position:relative; z-index:5; bottom:52px; margin-bottom:-52px;}\ndiv#welcome {width:450px; float:left; margin:0 30px 0 10px;}\ndiv#welcome img {float:left; margin:0 30px 10px 0;}\ndiv#featured_band h2 {margin-bottom:38px; width:135px; height:14px; font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-weight: normal; text-transform:uppercase; color:#ebebeb; letter-spacing: -0.01em;}\n\ndiv#featured_band div.image { float:right; width:323px; height:243px; position:relative; left:50px; bottom:75px; margin: 0 0 -75px -50px; }\ndiv#featured_band div.image h4 { width:324px; height:243px; background:url({site_url}themes/site/default/images/featuredband_border.png) no-repeat top left; position:absolute; top:0; left:0; z-index:2; }\ndiv#featured_band div.image h4 span { position:absolute; top:177px; left:30px; background:url({site_url}themes/site/default/images/white_70.png); font-size:11px; padding:2px; padding-left:60px; }\ndiv#featured_band div.image img { position:absolute; top:20px; left:15px;}\n.green40 {background:transparent url({site_url}themes/site/default/images/green_40.png) repeat scroll 0 0; color:#EEEEEE; float:left; padding:10px;}\ndiv#feature p {margin-left:10px;}\n\n/* News\n---------------- */\nh3.oldernews {}\nul#news_listing { list-style:none; }\nul#news_listing li { margin:0 0 30px 0; overflow:hidden; }\nul#news_listing li img { float:left; margin:0 10px 10px 0;}\nul#news_listing li p { margin-bottom:10px; }\n\ndiv#news_archives { overflow:hidden; }\ndiv#news_archives div#categories_box {width:120px; float: left;}\ndiv#news_archives div#months_box {width:120px; float: right;}\ndiv#news_archives ul#categories { width:120px; float:left; margin-right:30px; }\ndiv#news_archives ul#months { width:120px; float:left; }\n\ndiv#news_calendar { padding:10px; background:url({site_url}themes/site/default/images/white_50.png); margin-bottom:40px; }\n\ndiv#news_calendar a:link,\ndiv#news_calendar a:visited { color:#666; }\ndiv#news_calendar a:hover,\ndiv#news_calendar a:focus { color:#333; }\n\ndiv#news_calendar h6 { position:relative; text-align:center; text-transform:uppercase; color:#666; padding:0 0 10px 0; }\ndiv#news_calendar h6 a.prev { position:absolute; left:0; top:-3px; font-size:16px; }\ndiv#news_calendar h6 a.next { position:absolute; right:0; top:-3px; font-size:16px; }\n\ndiv#news_calendar table { background:none; font-size:11px; width:250px; color:#666; }\ndiv#news_calendar table th { background:url({site_url}themes/site/default/images/green_50.png); color:#ccc; }\ndiv#news_calendar table th,\ndiv#news_calendar table td  { padding:5px 0; text-align:center; }\ndiv#news_calendar table tr { border:none; }\ndiv#news_calendar table td.unused { color:#999; }\ndiv#news_calendar table td.post { background:url({site_url}themes/site/default/images/white_20.png); }\ndiv#news_calendar table td.post:hover { background:url({site_url}themes/site/default/images/white_40.png); }\n\ndiv#news_rss { padding:10px; background:url({site_url}themes/site/default/images/white_50.png); color:#666; }\ndiv#news_rss ul { list-style:url({site_url}themes/site/default/images/bullet.jpg); margin:0; }\ndiv#news_rss a:link,\ndiv#news_rss a:visited { color:#666; }\ndiv#news_rss a:hover,\ndiv#news_rss a:focus { color:#333; }\n\n\n/* Staff Profiles */\ndiv#content_sec.staff_profiles {\nbackground:transparent url({site_url}themes/site/default/images/staff_bg.jpg) repeat scroll 0 0;float:right;margin-bottom:-110px;padding:10px;position:relative;top:-140px; right:10px; width:430px;}\n\n/* Comments */\ndiv#news_comments { border-top:#bfbebf 1px solid; padding-top:20px; }\n\ndiv#news_comments ol { list-style:none; border-top:1px dotted #ccc; margin-bottom:30px; }\ndiv#news_comments ol li { border-bottom:1px dotted #ccc; background:url({site_url}themes/site/default/images/white_70.png); padding:20px 10px 0 160px; font-size:12px; line-height:20px; }\ndiv#news_comments ol li.alt { background:url({site_url}themes/site/default/images/white_50.png); }\n\ndiv#news_comments ol li h5.commentdata { width:120px; float:left; position:relative; left:-150px; margin-right:-150px; font-size:13px; line-height:20px; }\ndiv#news_comments ol li h5.commentdata span { display:block; font-weight:normal; font-size:11px; }\ndiv#news_comments ol li h5.commentdata img { margin-top:10px; }\n\ndiv#news_comments h3.leavecomment {color:#47472C; font-family:\'Cooper Black\', miso, \'Georgia\', serif; font-size:20px;}\ndiv#news_comments form { position:relative; margin-bottom:30px; }\n\ndiv#news_comments fieldset#comment_fields label { display:block; overflow:hidden; font-size:12px; margin-bottom:20px; }\ndiv#news_comments fieldset#comment_fields label span { width:80px; float:left; position:relative; top:5px; }\ndiv#news_comments fieldset#comment_fields label input { border:1px solid #aaa; width:228px; float:left; background:url({site_url}themes/site/default/images/white_50.png); }\ndiv#news_comments fieldset#comment_fields label input:focus { background:url({site_url}themes/site/default/images/white_70.png); }\ndiv#news_comments fieldset#comment_fields label textarea { border:1px solid #aaa; float:left; height:150px; width:438px; background:url({site_url}themes/site/default/images/white_50.png); }\ndiv#news_comments fieldset#comment_fields label textarea:focus { background:url({site_url}themes/site/default/images/white_70.png); }\n\ndiv#news_comments div#comment_guidelines { width:418px; padding:10px; margin:10px 0 10px 80px; color:#fff; background:#9f9995; }\ndiv#news_comments div#comment_guidelines h6 { font-weight:normal; font-size:12px; margin-bottom:0; }\ndiv#news_comments div#comment_guidelines p { margin:10px 0 0 0 ; font-size:11px; line-height:16px; font-style:italic; }\n\ndiv#news_comments fieldset#comment_action { background:url({site_url}themes/site/default/images/orange_20.png); padding:10px; font-size:11px; position:relative; }\ndiv#news_comments fieldset#comment_action label { display:block; padding:5px 0; }\ndiv#news_comments fieldset#comment_action label input { position:relative; left:5px; }\ndiv#news_comments fieldset#comment_action input#submit_comment { position:absolute; bottom:10px; right:10px; font-size:12px; }\n\ndiv#captcha_box img {margin-left: 5px;}\n\ninput#captcha {display:block; margin: 5px 0 0 0; border:1px solid #aaa; width:228px; background:url({site_url}themes/site/default/images/white_50.png);}\ninput#captcha:focus {background:url({site_url}themes/site/default/images/white_70.png);}\n\n/* News Archive Page */\ndiv.archive ul#news_listing li img {float:right; margin:auto auto 10px 10px;}\ndiv.archive ul#news_listing li p {margin-bottom:10px; padding-left:0;}\n\n/* About */\ndiv#content_pri.about {width:450px;}\ndiv#feature.about p {color:#666666;font-weight:bold;margin-left:10px;width:450px;}\ndiv#feature h3.about {font-size:22px; font-family:\'Cooper Black\',miso,\'Georgia\',serif;font-weight:bold;color:#47472C;text-decoration:none; margin:10px 0 20px 10px; width:300px;}\n\n\ndiv#content_sec ul.staff_member li {float:left;height:180px;margin:0 35px 40px 0;overflow:hidden;position:relative;width:120px;}\n\ndiv#content_sec ul.staff_member { list-style:none; overflow:hidden; margin-bottom:-20px; }\ndiv#content_sec ul.staff_member li { width:120px; height:180px; overflow:hidden; position:relative; float:left; margin:0 35px 40px 0; }\ndiv#content_sec ul.staff_member li.end { margin-right:0; }\ndiv#content_sec ul.staff_member li h4 { font-size:12px; padding:5px 5px; background:#afafa8; position:absolute; bottom:0; left:0; z-index:3; color:#fff; width:110px; height:20px; cursor:pointer; }\ndiv#content_sec ul.staff_member li h4 a { position:absolute; right:5px; color:#eee; font-family:Georgia, \"Times New Roman\", Times, serif; font-style:italic; font-weight:bold; }\ndiv#content_sec ul.staff_member li div.profile { position:absolute; bottom:40px; left:0; background:url({site_url}themes/site/default/images/white_50.png); z-index:2; padding:5px; width:110px; }\ndiv#content_sec ul.staff_member li img { position:absolute; top:0; left:0; }\ndiv.profile {color:#000;}\n\n\n/* Contact */\ndiv#content_pri.contact { width:530px; margin-right:110px; }\ndiv#content_sec.contact {  width:270px; float:left; padding:10px; padding-bottom:0; background:url({site_url}themes/site/default/images/staff_bg.jpg); position:relative; top:-170px; margin-bottom:-140px; color:#eee; }\ndiv#feature.contact p {color:#666666;font-weight:bold;margin-left:10px;width:600px;}\n\n/*div#feature { padding-left:10px; padding-right:410px; width:530px; }*/\ndiv#feature h3.getintouch { width:140px; font-family:\'Cooper Black\',miso,\'Georgia\',serif;font-size:20px; color:#47472C;text-decoration:none; margin-left:10px;}\n\ndiv#content_pri form { position:relative; margin-bottom:30px; }\n\ndiv#content_pri fieldset#contact_fields label { display:block; overflow:hidden; font-size:12px; margin-bottom:20px; }\ndiv#content_pri fieldset#contact_fields label span { width:80px; float:left; position:relative; top:5px; }\ndiv#content_pri fieldset#contact_fields label input { border:1px solid #aaa; width:228px; float:left; background:url({site_url}themes/site/default/images/white_50.png); }\ndiv#content_pri fieldset#contact_fields label input:focus { background:url({site_url}themes/site/default/images/white_70.png); }\ndiv#content_pri fieldset#contact_fields label textarea { border:1px solid #aaa; float:left; height:150px; width:438px; background:url({site_url}themes/site/default/images/white_50.png); }\ndiv#content_pri fieldset#contact_fields label textarea:focus { background:url({site_url}themes/site/default/images/white_70.png); }\n\ndiv#content_pri div#contact_guidelines { position:absolute; top:0; right:0; width:170px; padding:10px; color:#fff; background:#9f9995; }\ndiv#content_pri div#contact_guidelines h6 { font-weight:normal; font-size:12px; margin-bottom:10px; }\ndiv#content_pri div#contact_guidelines p { margin:0; font-size:11px; line-height:16px; font-style:italic; }\n\ndiv#content_pri fieldset#contact_action { background:url({site_url}themes/site/default/images/orange_20.png); padding:10px; font-size:11px; position:relative; }\ndiv#content_pri fieldset#contact_action label { display:block; padding:5px 0; }\ndiv#content_pri fieldset#contact_action label input { position:relative; left:5px; }\ndiv#content_pri fieldset#contact_action input#contactSubmit { position:absolute; bottom:10px; right:10px; font-size:12px; }\n\n\n\n\n/*  Member Templates */\n/* 22.MEMBERS\n---------------------------------------------------------------------- */\n\n/* CONTROL PANEL */\ndiv#navigation_sec.member_cp { width:270px; padding:10px; float:left; background:url({site_url}themes/site/default/images/green_40.png); margin:35px 30px 30px 10px; font-size:11px; line-height:16px; }\n/*div#content_pri.member_cp  { width:610px; margin:0 0 0 10px; }*/\n\ndiv#page_header.member_cp  a.viewprofile { display:block; width:182px; height:22px; background:url({site_url}themes/site/default/images/member_viewprofile.jpg) no-repeat left top; text-indent:-9999em; position:absolute; right:10px; top:25px; }\n.member_cp div#page_header a.viewprofile:hover,\n.member_cp div#page_header a.viewprofile:focus { background-position:left bottom; }\n\ndiv#navigation_sec.member_cp h4 { color:#fff; border-bottom:1px solid #b1b1a9; font-size:12px; padding-bottom:5px; position:relative; }\ndiv#navigation_sec.member_cp h4 a.expand { position:absolute; right:0; top:0; display:block; height:14px; width:14px; background:url({site_url}themes/site/default/images/controlpanel_expand.jpg) no-repeat bottom left; text-indent:-9999em; }\ndiv#navigation_sec.member_cp h4 a.expand.open { background:url({site_url}themes/site/default/images/controlpanel_expand.jpg) no-repeat top left; }\ndiv#navigation_sec.member_cp a:link,\ndiv#navigation_sec.member_cp a:visited { color:#ddd; }\ndiv#navigation_sec.member_cp a:hover,\ndiv#navigation_sec.member_cp a:focus { color:#fff; }\n\ndiv#content_pri table { width:610px; background:none;}\ndiv#content_pri table th { background:none; }\ndiv#content_pri table tr { background:url({site_url}themes/site/default/images/white_60.png); }\ndiv#content_pri table tr.alt { background:url({site_url}themes/site/default/images/white_40.png); }\n\n/* PROFILE */\ndiv#content_pri.member_profile, div#content_pri.member_cp  { width:450px; float:left; margin:0 30px 30px 10px; }\ndiv#content_sec.member_profile, div#content_sec.member_cp  { width:450px; float:left; margin:0 0 30px 0; }\n\nh3.statistics {height:11px; font-family:\'Cooper Black\',miso,\'Georgia\',serif; color:#f47424; font-size:18px; }\nh3.personalinfo {height:11px; color:#47472C; font-family:\'Cooper Black\',miso,\'Georgia\',serif; font-size:18px;}\nh3.biography {height:11px; color:#47472C; font-family:\'Cooper Black\',miso,\'Georgia\',serif; font-size:18px; margin-top:20px;}\n\ndiv#memberprofile_main { background:url({site_url}themes/site/default/images/green_20.png); width:300px; padding:10px; margin:40px 0 0 10px; float:left; }\ndiv#memberprofile_main img { float:left; margin:0 10px 10px 0; }\ndiv#memberprofile_main h3 { margin:5px 0 10px 0; }\ndiv#memberprofile_main ul { clear:both; margin:0; padding:10px 0; font-size:12px; }\ndiv#memberprofile_main ul a { color:#666; }\n\ndiv#memberprofile_photo { float:left; width:250px; height:220px; background:url({site_url}themes/site/default/images/memberprofile_photo_bg.png) no-repeat center center; position:relative; left:-20px; }\ndiv#memberprofile_photo img { width:206px; height:176px; border:3px solid #6b5f57; position:absolute; top:20px; left:20px; }\n\ndiv#memberprofile_communicate { width:270px; padding:10px; margin:20px 10px 0 0; float:right; background:url({site_url}themes/site/default/images/green_40.png); }\ndiv#memberprofile_communicate h3.communicate { width:83px; height:12px; font-family:\"Helvetica Neue\",Helvetica,Arial,sans-serif; color:#EBEBEB; text-transform: uppercase; margin-bottom:10px; }\ndiv#memberprofile_communicate table { width:270px; font-size:10px; background:none; }\ndiv#memberprofile_communicate table tr { background:url({site_url}themes/site/default/images/white_40.png); }\ndiv#memberprofile_communicate table tr.alt { background:url({site_url}themes/site/default/images/white_20.png); }\ndiv#memberprofile_communicate table th { font-weight:normal; font-size:10px; background:none; padding:4px; }\ndiv#feature div#memberprofile_communicate table td { padding:4px; color:#444;}\n\ndiv#content_pri.member_cp table,\ndiv#content_sec.member_cp table { width:100%; background:none; margin-bottom:30px; }\ndiv#content_pri.member_cp table th,\ndiv#content_sec.member_cp table th { background:none; }\ndiv#content_pri.member_cp table tr,\ndiv#content_sec.member_cp table tr { background:url({site_url}themes/site/default/images/white_60.png); }\ndiv#content_pri.member_cp table tr.alt,\ndiv#content_sec.member_cp table tr.alt  { background:url({site_url}themes/site/default/images/white_40.png); }\n\n/* Private Messages: Move and Copy pop-up menu control */\n#movemenu {position: absolute !important; top: 410px !important; left: 390px !important; border: 0 !important;}\n#copymenu {position: absolute !important; top: 410px !important; left: 332px !important; border: 0 !important;}\n\n/* Search Results */\n.pagination ul { overflow: auto; }\n.pagination li { float: left; list-style: none; background: transparent url(http://expressionengine2/themes/site/default/images/green_40.png) repeat scroll 0 0; padding: 1px 7px; margin: 0 3px; }\n.pagination li.active { background: none; }\n.pagination li.active a { text-decoration: none; }', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(50, 1, 14, '_top_nav', 'webpage', NULL, ' <ul id=\"navigation_pri\">\n            <li id=\"home\" {if embed:loc== \"home\"}class=\"cur\"{/if}><a href=\"{homepage}\">Home</a></li>\n            <li id=\"events\" {if embed:loc == \"about\"}class=\"cur\"{/if}><a href=\"{path=\'about/index\'}\">About</a></li>\n            <li id=\"contact\" {if embed:loc==\"contact\"}class=\"cur\"{/if}><a href=\"{path=\'about/contact\'}\">Contact</a></li>\n        </ul>', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(51, 1, 14, 'css_screen-ie7', 'css', NULL, 'body {position:relative;}\ndiv#branding {margin:0 auto;}\n\n\ndiv#content_wrapper {position:relative;}\n\ndiv.feature_end {margin-top:0; }\ndiv#content_pri {float:left;margin:0 30px 0 10px;width:600px; padding-left:10px;}\ndiv#content_sec {float:left;width:270px; position:relative; z-index:999;}\n\ndiv#content_pri.contact {width:520px; margin-right:110px;}\ndiv#content_sec.contact {float:right; margin: 0 10px -140px auto; }\n\n\ndiv#page_header {position:relative;z-index:1;}\n\ndiv#feature{top:-10px;float:none;margin-bottom:30px;padding-top:25px;padding-top:10px;position:relative;width:950px;z-index:900;display:block;}\n\ndiv.feature_end {clear:none;height:35px;margin-bottom:20px;margin-top:-40px;width:950px;}\n\n/*#content_wrapper.member_cp {padding:0 10px;} */\n#content_wrapper.member_cp table {width:550px;}\n\ndiv#navigation_sec.member_cp { \n	width:150px; \n	left:10px;\n}\n\ndiv#content_wrapper.member_cp form {margin-left:200px;}', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(52, 1, 14, '_page_header', 'webpage', NULL, '<div id=\"page_header\">\n        <h2>{embed:header}</h2>\n    </div>\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(53, 1, 14, 'css_screen-ie6', 'css', NULL, '/*\n\n	AGILE RECORDS, EE2.0 EXAMPLE SITE by ERSKINE DESIGN\n	VERSION 1.0\n	IE6 OVERRIDE STYLES\n	\n	CONTENTS ----------\n	\n	\n	\n	-------------------\n	\n*/\n\n\n\nul#nav_access { position:static; display:none; }\n\ndiv#feature { margin-bottom:10px !important; }\nhr.legend_start,\nhr.feature_end { display:none !important; }\n\n/* TABLES */\n\ntable { background-image:none; background-color:#ddd; font-size:12px; }\ntr.alt { background-image:none; background-color:#eee; }\nth { background-image:none; background-color:#ddd; }\n\n\n\n/* LAYOUT */\n\ndiv#feature { width:950px; overflow:hidden; float:none; padding:30px 0; position:static; margin:0; background:url({site_url}themes/site/default/images/feature_bg.jpg); margin-bottom:30px; }\ndiv#page_header { background-image:none; background-color:#6b5f57; height:40px; z-index:3; position:static; top:0px; margin-bottom:0; padding-bottom:10px; }\n\ndiv#branding { height:290px; background:url({site_url}themes/site/default/images/ie_branding_bg.gif) repeat-x center top; position:relative; z-index:2; }\ndiv#branding_sub { width:930px; margin:0 auto; position:relative; }\n\ndiv#page { background:url({site_url}themes/site/default/images/page_bg.jpg); }\n\ndiv#content_pri { display:inline; }\ndiv#content_sec { }\n\n\n\n/* BRANDING/MASTHEAD */\n\ndiv#branding_logo { background:url({site_url}themes/site/default/images/ie_branding_sub_bg.gif) no-repeat left top; }\ndiv#branding_sub h1 a { position:static; background:url({site_url}themes/site/default/images/logo_bg.jpg) no-repeat bottom left; }\ndiv#branding_sub div#member { background:none; }\ndiv#branding_sub form { background:url({site_url}themes/site/default/images/ie_search_bg.jpg) no-repeat; }\n\n\n\n\n/* NAVIGATION */\n\nul#navigation_pri { background-image:none; background-color:#2f261d; }\nul#navigation_pri li { height:auto; text-indent:0; font-family:\"Cooper Black\",Arial; font-weight:bold; }\nul#navigation_pri li a:link,\nul#navigation_pri li a:visited { background:none; text-decoration:none; color:#a09f9d;}\nul#navigation_pri li a:hover,\nul#navigation_pri li a:focus { color:#ccc;}\nul#navigation_pri li.cur a:link,\nul#navigation_pri li.cur a:visited,\nul#navigation_pri li.cur a:hover,\nul#navigation_pri li.cur a:focus { color:#d55401; }\nul#navigation_pri li#home,\nul#navigation_pri li#events,\nul#navigation_pri li#contact { top:8px; }\nul#navigation_pri li#bands,\nul#navigation_pri li#news,\nul#navigation_pri li#forums { top:30px; }\nul#navigation_pri li#releases,\nul#navigation_pri li#about,\nul#navigation_pri li#wiki { top:54px; }\n\n\n\n/* HEADINGS */\ndiv#page_header { height:1px; z-index:99; position:static; top:0; margin-bottom:0; }\ndiv#page_header h2 { text-indent:0 !important; background:none !important; color:#e6e6e6 !important; padding-top:15px !important; float:left;}\ndiv#page_header ol#breadcrumbs { margin-top:10px; padding:0; background:none; }\ndiv#page_header ol#breadcrumbs li { margin-left:10px; }\n\nh2,h3 { text-indent:0 !important; background:none !important; width:auto !important; height:auto !important; }\n\n\n\n/* HOMEPAGE */\n\n.home div#feature div#featured_band { width:450px; float:left; position:static; margin:0px; }\n.home div#feature div#featured_band h2 { margin-bottom:5px; width:auto; height:auto; text-indent:0; background:none; }\n\n.home div#content_sec { display:inline; margin:0 30px 0 10px; }\n\n.home div#feature div#featured_band div.image { width:300px; height:200px; left:0; bottom:-10px; margin:0 10px 0 10px; padding:0; display:inline; }\n.home div#feature div#featured_band div.image h4 { height:auto; width:auto; background:none; margin:0; top:auto; bottom:0; }\n.home div#feature div#featured_band div.image h4 span { position:static; background:none; }\n.home div#feature div#featured_band div.image img { top:0; left:0; }\n\n.home div#homepage_events ul { padding-bottom:30px; }\n.home div#homepage_events ul li a { background:none !important; text-indent:0 !important; text-align:center; color:#fff; font-weight:bold; }\n\n.home div#homepage_forums ul,\n.home div#homepage_rss p,\n.home div#homepage_rss ul { background-image:none; background-color:#eee; }\n\n\n\n/* BANDS */\n\n.bands ul#bands1 li.one { width:450px; height:300px; left:-480px; top:0; margin-right:-450px; margin-bottom:30px; }\n.bands ul#bands1 li.one img { top:0; left:0; }\n \n.bands ul#bands1 li.two img,\n.bands ul#bands1 li.three img { padding:0; background:none; position:static; margin:0; margin:0 10px; }\n\n.band div#band_image { width:450px; height:300px; float:left; position:relative; left:10px; top:0px; margin:0 30px 30px 0; display:inline; }\n.band div#band_image img { top:0; left:0; }\n\ndiv#band_latestrelease { padding:20px; overflow:hidden; color:#d6d6d6; margin-left:10px; }\ndiv#band_latestrelease h3 { padding-top:20px; }\n\n.band div#content_pri { display:inline; }\n\n.band div#band_events ul { padding-bottom:30px; }\n.band div#band_events ul li a { background:none !important; text-indent:0 !important; text-align:center; color:#fff; font-weight:bold; }\n\n.band div#band_more ul { background-image:none; background-color:#eee; }\n\n\n\n/* RELEASES */\n\n.releases div#content_pri table th { background:none; text-indent:0; color:#fff; }\n.releases div#content_pri table th.release_details { width:360px; padding-right:30px; background:none; }\n.releases div#content_pri table th.release_catno { width:80px; background:none; }\n.releases div#content_pri table th.release_format { width:120px; background:none; text-align:center; }\n\n.releases div#content_pri table tr { background-image:none; background-color:#a3a39c; }\n.releases div#content_pri table tr.releases_head { background:none; }\n.releases div#content_pri table tr.alt { background-image:none; background-color:#c1c1bc; }\n\n.release div#content_pri { display:inline; padding-top:30px;}\n.release div#content_sec { padding:0; padding-top:30px; background:none; position:relative; left:-10px; }\n\n.release div#release_details { border-bottom:1px solid blue; }\n.release div#release_details span { font-family:Georgia,serif; font-style:italic; }\n.release div#release_details ul { list-style:url({site_url}themes/site/default/images/pixel.gif); }\n\n.release div#release_tracks div.release_format { float:left; padding-bottom:20px; margin-bottom:20px; }\n\n\n\n/* EVENTS */\n\n.events div#content_pri { display:inline; }\n\n\n\n/* NEWS */\n\n.news div#content_pri { display:inline; padding:30px 0; }\n.news div#content_sec { margin:30px 0 ; }\n\n.news div#news_calendar h6 a.prev { position:static; }\n.news div#news_calendar h6 a.next { position:static; }\n\n.news div#news_calendar { background-image:none; background-color:#cfcfcb; }\n.news div#news_calendar table td.post { background-image:none; background-color:#d7d7d3; }\n\n.news div#news_rss { background-image:none; background-color:#cfcfcb; }\n\ndiv#news_comments ol li { background-image:none; background-color:#f1f1f1; }\ndiv#news_comments ol li.alt { background-image:none; background-color:#e7e7e7; }\n\ndiv#news_comments fieldset#comment_fields label { display:block; width:320px; }\ndiv#news_comments fieldset#comment_fields label.comment { width:530px; }\ndiv#news_comments fieldset#comment_fields label span { width:80px; float:none; position:relative; top:20px; }\ndiv#news_comments fieldset#comment_fields label input { float:right; }\ndiv#news_comments fieldset#comment_fields label textarea { float:right; }\n\ndiv#news_comments fieldset#comment_fields label input,\ndiv#news_comments fieldset#comment_fields label textarea { background-image:none; background-color:#f1f1f1; }\n\n\n\n/* FORUMS */\n\n.forums div#content_pri { display:inline; }\n.forums div#content_sec { background-image:none; background-color:#f1f1f1; }\n\n.forums #page_header form { position:absolute; left:770px; padding-top:5px; }\n.forums #page_header form input.search { padding:1px; margin-right:10px;}\n.forums #page_header form input.submit { padding:0; position:relative; top:5px; }\n\n.forums div#content_pri h3 { background-color:#71715f !important; }\n\ndiv.forum_posts { background-image:none; background-color:#9e9e94; }\ndiv.forum_posts table tr td { background-image:none; background-color:#d0d0cc;}\ndiv.forum_posts table tr.alt td { background-image:none; background-color:#b3b3ab; }\n\ndiv.forum_posts table tr th { text-indent:0; color:#fff; }\ndiv.forum_posts table tr th.forum_name,\ndiv.forum_posts table tr th.forum_topics,\ndiv.forum_posts table tr th.forum_replies,\ndiv.forum_posts table tr th.forum_latest { background-image:none; }\n\ndiv.forum_posts table td.forum_newpostindicator img { position:static; }\n\n.forums div#legend div#forum_stats ul.legend { float:left; background-image:none; background-color:#cecec8; }\n.forums div#legend div#forum_stats p.most_visitors { background-image:none; background-color:#ecd2c3; }\n\n\n\n/* WIKI */\n\n.wiki div#navigation_sec { padding-top:57px; display:inline;  behavior: url(css/iepngfix/iepngfix.htc); }\n.wiki div#navigation_sec ul { background:url({site_url}themes/site/default/images/ie_wiki_menubg.jpg) repeat-y 5px top ; }\n.wiki div#navigation_sec div.bottom { behavior: url(css/iepngfix/iepngfix.htc); }\n\n\n\n/* MEMBERS CONTROL PANEL */\n\n.member_cp div#navigation_sec { display:inline; background-image:none; background-color:#9c9b92; }\n.member_cp div#navigation_sec h4 a.expand { display:none; }\n\n.member_cp div#content_pri table tr { background-image:none; background-color:#f1f1f1; }\n.member_cp div#content_pri table tr.alt { background-image:none; background-color:#e7e7e7; }\n.member_cp div#content_pri table tr th { background-image:none; background-color:#f1f1f1; }\n.member_cp div#content_pri table tr.alt th { background-image:none; background-color:#e7e7e7; }\n\n\n\n/* MEMBER PROFILE */\n\n.member_profile div#feature div#memberprofile_main { background-image:none; background-color:#cecec8; margin:20px 0 0 10px; }\n.member_profile div#feature div#memberprofile_main ul { padding:0 0 10px 0; }\n\n.member_profile div#feature div#memberprofile_photo { float:left; width:210px; height:180px; background:none; position:relative; left:-20px; }\n.member_profile div#feature div#memberprofile_photo img { width:206px; height:176px; border:3px solid #6b5f57; position:static; }\n\n.member_profile div#feature div#memberprofile_communicate { background-image:none; background-color:#adada3; margin-top:5px; } \n.member_profile div#feature div#memberprofile_communicate table tr { background-image:none; background-color:#cdcdc7; }\n.member_profile div#feature div#memberprofile_communicate table tr.alt { background-image:none; background-color:#bebeb7; }\n\n.member_profile div#content_pri table tr,\n.member_profile div#content_sec table tr { background-image:none; background-color:#f1f1f1; }\n.member_profile div#content_pri table tr.alt,\n.member_profile div#content_sec table tr.alt { background-image:none; background-color:#e7e7e7; }\n\n.member_profile div#content_pri table tr th,\n.member_profile div#content_sec table tr th { background-image:none; background-color:#f1f1f1; }\n.member_profile div#content_pri table tr.alt th,\n.member_profile div#content_sec table tr.alt th { background-image:none; background-color:#e7e7e7; }\n\n\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(54, 1, 6, 'contact', 'webpage', NULL, '{!-- Explanations and learning materials can be found in news/index and the other news template groups.  In-line comments here are only for features not introduced in news/index. --}\n{html_head}\n	<title>{site_name}: Contact Us</title>\n{global_stylesheets}\n\n{rss}\n{favicon}\n{html_head_end}\n	<body>\n{nav_access}\n	{branding_begin}\n			{embed=\"global_embeds/_top_nav\" loc=\"contact\"}\n			{global_top_search}\n			{global_top_member}\n	{branding_end}\n	{wrapper_begin}\n{embed=\"global_embeds/_page_header\" header=\"Contact Us\"}\n    <div id=\"feature\" class=\"contact\">\n		<h3 class=\"getintouch\">Get in Touch</h3>\n\n\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat .</p>\n</div> <!-- ending #feature -->\n\n	<div class=\"feature_end\"></div>\n\n	<div id=\"content_pri\" class=\"contact\"> <!-- This is where all primary content, left column gets entered -->\n\n			<!-- This uses the Email Module\'s Contact Form: https://docs.expressionengine.com/latest/modules/email/contact_form.html -->\n			{exp:email:contact_form user_recipients=\"false\" recipients=\"admin@example.com\" charset=\"utf-8\"}\n			<fieldset id=\"contact_fields\">\n			<label for=\"from\">\n				<span>Your Email:</span>\n				<input type=\"text\" id=\"from\" name=\"from\" value=\"{member_email}\" />\n			</label>\n\n			<label for=\"subject\">\n				<span>Subject:</span>\n				<input type=\"text\" id=\"subject\" name=\"subject\" size=\"40\" value=\"Contact Form\" />\n			</label>\n\n			<label for=\"message\">\n				<span>Message:</span>\n				<textarea id=\"message\" name=\"message\" rows=\"18\" cols=\"40\">Email from: {member_name}, Sent at: {current_time format=\"%Y %m %d\"}</textarea>\n			</label>\n			</fieldset>\n\n			<fieldset id=\"contact_action\">\n				<p>We will never pass on your details to third parties.</p>\n				<input name=\"submit\" type=\'submit\' value=\'Submit\' id=\'contactSubmit\' />\n			</fieldset>\n			{/exp:email:contact_form}\n	</div>\n\n	<div id=\"content_sec\" class=\"contact\">\n		<h3 class=\"address\">Address</h3>\n		 <p>\n			12343 Valencia Street,<br />\n			Mission District,<br />\n			San Francisco,<br />\n			California,<br />\n			ZIP 123\n			 </p>\n	<p><img src=\"{site_url}images/about/map2.jpg\" alt=\"\" /></p>\n\n	</div>	<!-- ending #content_sec -->\n\n{global_footer}\n{wrapper_close}\n{js}\n{html_close}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(55, 1, 6, '404', 'webpage', NULL, '{!-- Explanations and learning materials can be found in news/index and the other news template groups.  In-line comments here are only for features not introduced in news/index. --}\n{html_head}\n	<title>{site_name}: Not Found</title>\n{global_stylesheets}\n\n{rss}\n{favicon}\n{html_head_end}\n	<body>\n{nav_access}\n	{branding_begin}\n			{embed=\"global_embeds/_top_nav\" loc=\"contact\"}\n			{global_top_search}\n			{global_top_member}\n	{branding_end}\n	{wrapper_begin}\n{embed=\"global_embeds/_page_header\" header=\"Not Found\"}\n\n\n	<div id=\"content_pri\"> <!-- This is where all primary content, left column gets entered -->\n		<h4>Not Found</h4>\n				 <p>The page you attempted to load was Not Found.  Please try again.</p>\n	</div>\n\n\n		<div id=\"content_sec\" class=\"right green40\">\n			<h3 class=\"oldernews\">Browse Older News</h3>\n			<div id=\"news_archives\">\n				<div id=\"categories_box\">\n				{news_categories}\n				</div>\n				<div id=\"month_box\">\n				{news_month_archives}\n				</div>\n			</div> <!-- ending #news_archives -->\n\n			{news_calendar}\n\n			{news_popular}\n\n		{rss_links}\n\n		</div>	<!-- ending #content_sec -->\n\n	{global_footer}\n	{wrapper_close}\n	{js}\n	{html_close}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(56, 1, 15, 'index', 'webpage', NULL, '', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(57, 1, 15, 'conditional', 'webpage', NULL, '{exp:channel:entries channel=\"news\"}\n<h1>{title}</h1>\n\n<div class=\"news_body\">{news_body}</div>\n\n<div class=\"if_news_body\">{if news_body}if news_body{if:else}if not news_body{/if}</div>\n\n<div class=\"news_image\">{news_image}</div>\n\n<div class=\"if_news_image\">{if news_image}if news_image{if:else}if not news_image{/if}</div>\n\n<div class=\"cf_grid\">{cf_grid}{cf_grid:column}{/cf_grid}</div>\n\n<div class=\"cf_grid_table\">{cf_grid:table}</div>\n\n<div class=\"if_cf_grid\">{if cf_grid}if cf_grid{if:else}if not cf_grid{/if}</div>\n\n<div class=\"if_cf_grid_rows\">{if cf_grid:total_rows > 0}if cf_grid{if:else}if not cf_grid{/if}</div>\n\n<div class=\"related_news\">{related_news}{related_news:title}{/related_news}</div>\n\n<div class=\"if_related_news\">{if related_news}if related_news{if:else}if not related_news{/if}</div>\n\n<div class=\"fluid\">{cf_fluid}{cf_fluid:news_body}{content}{/cf_fluid:news_body}{/cf_fluid}</div>\n\n<div class=\"if_fluid\">{if cf_fluid}if cf_fluid{if:else}if not cf_fluid{/if}</div>\n\n\n{/exp:channel:entries}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(58, 1, 7, 'files', 'webpage', NULL, '{exp:file:entries}\n<p>{url} <br/>\n{extension}<br/>\n{path}</p>\n{/exp:file:entries}', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(59, 1, 7, 'view', 'webpage', NULL, '<h1>HTML Ipsum Presents</h1>\n	       \n<p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href=\"#\">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>\n\n<h2>Header Level 2</h2>\n	       \n<ol>\n   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>\n   <li>Aliquam tincidunt mauris eu risus.</li>\n</ol>\n\n<blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue. Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.</p></blockquote>\n\n<h3>Header Level 3</h3>\n\n<ul>\n   <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>\n   <li>Aliquam tincidunt mauris eu risus.</li>\n</ul>\n\n<pre><code>\n#header h1 a { \n	display: block; \n	width: 300px; \n	height: 80px; \n}\n</code></pre>', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(60, 1, 16, 'reverse-relationships', 'webpage', NULL, '<p>Testing Relationships</p>\n{exp:channel:entries dynamic=\"no\" entry_id=\"11\" limit=\"1\"}\n<div id=\"with-tag\">\n\n{parents field=\"rel_item\"}\n    {parents:title}\n{/parents}\n\n</div>\n{/exp:channel:entries}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(61, 1, 16, 'image', 'webpage', NULL, '{exp:channel:entries dynamic=\"no\" entry_id=\"2\" limit=\"1\"}\n<div id=\"img-tag\">\n    <p>Image tag</p>\n    <img \n    src=\"{news_image}\">\n</div>\n<div id=\"img-tag-2\">\n    <p>Image tag with single quotes</p>\n    <img alt=\"image\"  src=\'{news_image}\'>\n</div>\n<div id=\"img-tag-auto\">\n	<p>Image tae wrap=\"image\"</p>\n    {news_image wrap=\"image\"}\n</div>\n<div id=\"img-tag-autolink\">\n	<p>A tag wrap=\"link\"</p>\n    {news_image wrap=\"link\"}\n</div>\n<div id=\"img-tag-modifier\">\n	<p>Image tag with modifier</p>\n    <img src=\"{news_image:rotate angle=\"hor\"}\">\n</div>\n<div id=\"img-tag-pair\">\n    <p>Image tag as pair (inside src attribute)</p>\n    <img src=\"{news_image}{url}\n    {/news_image}\">\n</div>\n<div id=\"img-tag-pair-2\">\n    <p>Image tag as pair (outside img)</p>\n    {news_image}<img src=\"{url}\">{/news_image}\n</div>\n<div id=\"img-tag-pair-3\">\n    <p>Image tag pair, single quotes</p>\n    <img src=\'{news_image}{url}{/news_image}\'>\n</div>\n<div id=\"img-tag-pair-4\">\n    <p>Image tag as pair (outside img, single quotes)</p>\n    {news_image}<img src=\'{url}\'>{/news_image}\n</div>\n<div id=\"attr-tag-bg\">\n    <p>CSS background, single tag</p>\n    <div id=\"top\" class=\"hero-container valign-middle\" style=\"height: 100px; background-image:url(\'{news_image}\')\"></div>\n</div>\n<div id=\"attr-tag-pair-bg\">\n    <p>Css background, tag pair</p>\n    <div id=\"top\" class=\"hero-container valign-middle\" style=\"height: 100px; background-image:url(\'{news_image}{url}{/news_image}\')\"></div>\n</div>\n<div id=\"attr-tag-pair-bg-2\">\n    <p>CSS background, tag pair wrapped inside attribute</p>\n    <div id=\"top\" class=\"hero-container valign-middle\" style=\"height: 100px; {news_image}background-image:url(\'{url}\'){/news_image}\"\n    ></div>\n</div>\n<div id=\"attr-tag-pair-bg-3\">\n    <p>CSS background, tag pair wrapped around attribute</p>\n    <div id=\"top\" class=\"hero-container valign-middle\"{news_image} style=\"height: 100px; background-image:url(\'{url}\')\"{/news_image}></div>\n</div>\n{/exp:channel:entries}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(62, 1, 16, 'manual-links', 'webpage', NULL, '<p>Testing manual links</p>\n{exp:channel:entries dynamic=\"no\" entry_id=\"1\" limit=\"1\"}\n<h1>{title:frontedit}{title}</h1>\n{/exp:channel:entries}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(63, 1, 16, 'index', 'webpage', NULL, '{exp:channel:entries dynamic=\"no\" entry_id=\"1\" limit=\"1\"}\n<h1>{title}</h1>\n{if frontedit} \n<span class=\"frontedit-conditional-in\">frontedit</span>\n{/if}\n{/exp:channel:entries}\n\n{if frontedit} \n<span class=\"frontedit-conditional-out\">frontedit</span>\n{/if}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(64, 1, 16, 'fluid', 'webpage', NULL, '<p>Testing Fluid</p>\n{exp:channel:entries dynamic=\"no\" entry_id=\"11\" limit=\"1\"}\n{corpse}\n    {corpse:a_date}\n        {content format=\"%F %d %Y\"}\n    {/corpse:a_date}\n\n    {corpse:stupid_grid}\n    {content}\n      <div class=\"card\">\n        {content:text_one} ///\n        {content:text_two}\n      </div>\n    {/content}\n  {/corpse:stupid_grid}\n{/corpse}\n{/exp:channel:entries}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(65, 1, 16, 'disabled-with-comment', 'webpage', NULL, '{!-- disable frontedit --}\n{exp:channel:entries dynamic=\"no\" entry_id=\"1\" limit=\"1\"}\n<h1>{title} (disabled with comment)</h1>\n\n{/exp:channel:entries}\n\n{!-- //disable frontedit --}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(66, 1, 16, 'fluid-relationships', 'webpage', NULL, '<p>Testing Relationships in Fluid</p>\n{exp:channel:entries dynamic=\"no\" entry_id=\"11\" limit=\"1\"}\n{corpse}\n    {corpse:rel_item}\n        {content}\n        {if content:count == 1}<h3>Relationship {content:total_results}){/if}\n        {content:title}<br>\n        {/content}\n    {/corpse:rel_item}\n{/corpse}\n{/exp:channel:entries}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(67, 1, 16, 'relationships-fluid', 'webpage', NULL, '<p>Testing Relationships</p>\n{exp:channel:entries dynamic=\"no\" entry_id=\"1\" limit=\"1\"}\n<div id=\"with-tag\">\n<p>With tag</p>\n{rel_item} \n    <h3>{rel_item:title}</h3>\n	{rel_item:corpse}\n    {rel_item:corpse:a_date}\n        {content format=\"%F %d %Y\"}\n    {/rel_item:corpse:a_date}\n    {rel_item:corpse:electronic_mail_address}\n    	{content}\n    {/rel_item:corpse:electronic_mail_address}\n	{/rel_item:corpse}\n{/rel_item}\n</div>\n\n\n<div id=\"no-tag\">\n<p>No Tag</p>\n{rel_item} \n    {rel_item:title}\n	{rel_item:corpse}\n    {rel_item:corpse:a_date}\n        {content format=\"%F %d %Y\"}\n    {/rel_item:corpse:a_date}\n    {rel_item:corpse:electronic_mail_address}\n    	{content}\n    {/rel_item:corpse:electronic_mail_address}\n	{/rel_item:corpse}\n{/rel_item}\n\n</div>\n<div id=\"disabled-with-comment\">\n<p>Disabled with comment</p>\n{!-- disable frontedit --}\n{rel_item} \n    {rel_item:title}\n	{rel_item:corpse}\n    {rel_item:corpse:a_date}\n        {content format=\"%F %d %Y\"}\n    {/rel_item:corpse:a_date}\n    {rel_item:corpse:electronic_mail_address}\n    	{content}\n    {/rel_item:corpse:electronic_mail_address}\n	{/rel_item:corpse}\n{/rel_item}\n{!--//disable frontedit--}\n</div>\n<div id=\"disabled-with-param\">\n<p>Disabled with param</p>\n{rel_item disable=\"frontedit\"} \n    <p>{rel_item:title}</p>\n	{rel_item:corpse}\n    {rel_item:corpse:a_date}\n        {content format=\"%F %d %Y\"}\n    {/rel_item:corpse:a_date}\n    {rel_item:corpse:electronic_mail_address}\n    	{content}\n    {/rel_item:corpse:electronic_mail_address}\n	{/rel_item:corpse}\n{/rel_item}\n\n</div>\n\n{/exp:channel:entries}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(68, 1, 16, 'relationships', 'webpage', NULL, '<p>Testing Relationships</p>\n{exp:channel:entries dynamic=\"no\" entry_id=\"1\" limit=\"1\"}\n<div id=\"with-tag\">\n\n{rel_item} \n    <h3>{rel_item:title}</h3>\n{/rel_item}\n\n</div>\n<div id=\"no-tag\">\n\n{rel_item} \n    {rel_item:title}\n{/rel_item}\n\n</div>\n<div id=\"disabled-with-comment\">\n{!-- disable frontedit --}\n{rel_item} \n    {rel_item:title}\n{/rel_item}\n{!--//disable frontedit--}\n</div>\n<div id=\"disabled-with-param\">\n\n{rel_item disable=\"frontedit\"} \n    <p>{rel_item:title}</p>\n{/rel_item}\n\n</div>\n{/exp:channel:entries}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(69, 1, 16, 'grid', 'webpage', NULL, '{exp:channel:entries dynamic=\"no\" entry_id=\"5\" limit=\"1\"}\n<table>\n{file_grid}\n<tr id=\"row_{count}\">\n    <td>\n        {file_grid:file wrap=\"image\"}\n    </td>\n    <td>\n        {file_grid:text}\n    </td>\n    <td>\n        {file_grid:checkboxes markup=\'ul\'}\n    </td>\n    <td>\n        {file_grid:date format=\"%Y-%m-%d\"}\n    </td>\n    <td>\n        {file_grid:rte}\n    </td>\n    <td>\n        {file_grid:toggle}\n    </td>\n</tr>\n{/file_grid}\n</table>\n{/exp:channel:entries}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(70, 1, 16, 'conditionals', 'webpage', NULL, '{exp:channel:entries dynamic=\"no\" entry_id=\"2\" limit=\"1\"}\n<div id=\"title\">\n    {if title}<h1>{title}</h1>{/if}\n</div>\n<div id=\"title-2\">\n    {if title!=\'sample\'}<h1>{title}</h1>{/if}\n</div>\n<div id=\"title-3\">\n    {if title != \"sample\"}<h1>{title}</h1>{/if}\n</div>\n<div id=\"image\">\n    {if news_image:rotate}<h1>{news_image}</h1>{/if}\n</div>\n<div id=\"image-2\">\n    {if \"{news_image}{url}{/news_image}\" != \"\"}<h1>{news_image}</h1>{/if}\n</div>\n<div id=\"image-3\">\n    {news_image}{if \"{url}\" != \"\"}<h1>{url}</h1>{/if}{/news_image}\n</div>\n<div id=\"image-4\">\n    {if entry_date > 0}<h1>{news_image}</h1>{/if}\n</div>\n{/exp:channel:entries}\n\n{exp:channel:entries dynamic=\"no\" entry_id=\"5\" limit=\"1\"}\n<div id=\"grid\">\n    {if file_grid:total_rows > 0}<h1>{file_grid:table}</h1>{/if}\n</div>\n<div id=\"grid-2\">\n    {file_grid}\n    {if file_grid:toggle}<h1>{file_grid:total_rows}</h1>{/if}\n    {/file_grid}\n</div>\n\n{/exp:channel:entries}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(71, 1, 16, 'relationships-grid', 'webpage', NULL, '<p>Testing Relationships in Grid</p>\n{exp:channel:entries dynamic=\"no\" entry_id=\"3\" limit=\"1\"}\n<div id=\"with-tag\">\n{about_grid}\n{about_grid:rel} \n    <h3>{about_grid:rel:title}</h3>\n{/about_grid:rel}\n{/about_grid}\n\n</div>\n\n{/exp:channel:entries}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(72, 1, 16, 'encode', 'webpage', NULL, '<html>\n    <body>\n        {exp:channel:entries dynamic=\"no\" entry_id=\"3\" limit=\"1\"}\n        <p>{encode=\"{about_staff_title}\"}</p>\n\n        {/exp:channel:entries}\n    </body>\n</html>\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(73, 1, 16, 'mfa', 'webpage', NULL, '{if logged_in}\n  <p>{logged_in_username}</p>\n{/if}\n{exp:member:mfa_links}\n{if mfa_enabled}\n  <a href=\"{disable_mfa_link}\" id=\"disable_mfa_link\">Disable MFA</a>\n{if:else}\n  <a href=\"{enable_mfa_link}\" id=\"enable_mfa_link\">Enable MFA</a>\n{/if}\n{/exp:member:mfa_links}\n', NULL, 1676512207, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y'),
(74, 1, 4, 'test', 'webpage', NULL, '{exp:structure:entries parent_id=\"2\"}\n<h1>{title}</h1>\n{/exp:structure:entries}', '', 1676512487, 1, 'n', 0, '', 'n', 'n', 'o', 0, 'n', 'y');

INSERT INTO `exp_templates_roles` (`role_id`, `template_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(5, 4),
(1, 5),
(2, 5),
(3, 5),
(4, 5),
(5, 5),
(1, 6),
(2, 6),
(3, 6),
(4, 6),
(5, 6),
(2, 7),
(3, 7),
(4, 7),
(5, 7),
(1, 8),
(2, 8),
(3, 8),
(4, 8),
(5, 8),
(1, 9),
(2, 9),
(3, 9),
(4, 9),
(5, 9),
(1, 10),
(2, 10),
(3, 10),
(4, 10),
(5, 10),
(1, 11),
(2, 11),
(3, 11),
(4, 11),
(5, 11),
(1, 12),
(2, 12),
(3, 12),
(4, 12),
(5, 12),
(1, 13),
(2, 13),
(3, 13),
(4, 13),
(5, 13),
(1, 14),
(2, 14),
(3, 14),
(4, 14),
(5, 14),
(1, 15),
(2, 15),
(3, 15),
(4, 15),
(5, 15),
(1, 16),
(2, 16),
(3, 16),
(4, 16),
(5, 16),
(1, 17),
(2, 17),
(3, 17),
(4, 17),
(5, 17),
(1, 18),
(2, 18),
(3, 18),
(4, 18),
(5, 18),
(1, 19),
(2, 19),
(3, 19),
(4, 19),
(5, 19),
(1, 20),
(2, 20),
(3, 20),
(4, 20),
(5, 20),
(1, 21),
(2, 21),
(3, 21),
(4, 21),
(5, 21),
(1, 22),
(2, 22),
(3, 22),
(4, 22),
(5, 22),
(1, 23),
(2, 23),
(3, 23),
(4, 23),
(5, 23),
(1, 24),
(2, 24),
(3, 24),
(4, 24),
(5, 24),
(1, 25),
(2, 25),
(3, 25),
(4, 25),
(5, 25),
(1, 26),
(2, 26),
(3, 26),
(4, 26),
(5, 26),
(1, 27),
(2, 27),
(3, 27),
(4, 27),
(5, 27),
(1, 28),
(2, 28),
(3, 28),
(4, 28),
(5, 28),
(1, 29),
(2, 29),
(3, 29),
(4, 29),
(5, 29),
(1, 30),
(2, 30),
(3, 30),
(4, 30),
(5, 30),
(1, 31),
(2, 31),
(3, 31),
(4, 31),
(5, 31),
(1, 32),
(2, 32),
(3, 32),
(4, 32),
(5, 32),
(1, 33),
(2, 33),
(3, 33),
(4, 33),
(5, 33),
(1, 34),
(2, 34),
(3, 34),
(4, 34),
(5, 34),
(1, 35),
(2, 35),
(3, 35),
(4, 35),
(5, 35),
(1, 36),
(2, 36),
(3, 36),
(4, 36),
(5, 36),
(1, 37),
(2, 37),
(3, 37),
(4, 37),
(5, 37),
(1, 38),
(2, 38),
(3, 38),
(4, 38),
(5, 38),
(1, 39),
(2, 39),
(3, 39),
(4, 39),
(5, 39),
(1, 40),
(2, 40),
(3, 40),
(4, 40),
(5, 40),
(1, 41),
(2, 41),
(3, 41),
(4, 41),
(5, 41),
(1, 42),
(2, 42),
(3, 42),
(4, 42),
(5, 42),
(1, 43),
(2, 43),
(3, 43),
(4, 43),
(5, 43),
(1, 44),
(2, 44),
(3, 44),
(4, 44),
(5, 44),
(1, 45),
(2, 45),
(3, 45),
(4, 45),
(5, 45),
(1, 46),
(2, 46),
(3, 46),
(4, 46),
(5, 46),
(1, 47),
(2, 47),
(3, 47),
(4, 47),
(5, 47),
(1, 48),
(2, 48),
(3, 48),
(4, 48),
(5, 48),
(1, 49),
(2, 49),
(3, 49),
(4, 49),
(5, 49),
(1, 50),
(2, 50),
(3, 50),
(4, 50),
(5, 50),
(1, 51),
(2, 51),
(3, 51),
(4, 51),
(5, 51),
(1, 52),
(2, 52),
(3, 52),
(4, 52),
(5, 52),
(1, 53),
(2, 53),
(3, 53),
(4, 53),
(5, 53),
(1, 54),
(2, 54),
(3, 54),
(4, 54),
(5, 54),
(1, 55),
(2, 55),
(3, 55),
(4, 55),
(5, 55),
(1, 56),
(2, 56),
(3, 56),
(4, 56),
(5, 56),
(1, 57),
(2, 57),
(3, 57),
(4, 57),
(5, 57),
(1, 58),
(2, 58),
(3, 58),
(4, 58),
(5, 58),
(1, 59),
(2, 59),
(3, 59),
(4, 59),
(5, 59),
(1, 60),
(2, 60),
(3, 60),
(4, 60),
(5, 60),
(1, 61),
(2, 61),
(3, 61),
(4, 61),
(5, 61),
(1, 62),
(2, 62),
(3, 62),
(4, 62),
(5, 62),
(1, 63),
(2, 63),
(3, 63),
(4, 63),
(5, 63),
(1, 64),
(2, 64),
(3, 64),
(4, 64),
(5, 64),
(1, 65),
(2, 65),
(3, 65),
(4, 65),
(5, 65),
(1, 66),
(2, 66),
(3, 66),
(4, 66),
(5, 66),
(1, 67),
(2, 67),
(3, 67),
(4, 67),
(5, 67),
(1, 68),
(2, 68),
(3, 68),
(4, 68),
(5, 68),
(1, 69),
(2, 69),
(3, 69),
(4, 69),
(5, 69),
(1, 70),
(2, 70),
(3, 70),
(4, 70),
(5, 70),
(1, 71),
(2, 71),
(3, 71),
(4, 71),
(5, 71),
(1, 72),
(2, 72),
(3, 72),
(4, 72),
(5, 72),
(1, 73),
(2, 73),
(3, 73),
(4, 73),
(5, 73),
(2, 74),
(3, 74),
(4, 74),
(5, 74);

INSERT INTO `exp_update_log` (`log_id`, `timestamp`, `message`, `method`, `line`, `file`) VALUES
(1, 1666304930, 'Smartforge::add_key failed. Table \'exp_comments\' does not exist.', 'Smartforge::add_key', 106, '/Users/bryannielsen/Code/coilpack-test/ee/system/ee/ExpressionEngine/Addons/comment/upd.comment.php'),
(2, 1666304930, 'Smartforge::add_key failed. Table \'exp_dock_prolets\' does not exist.', 'Smartforge::add_key', 202, '/Users/bryannielsen/Code/coilpack-test/ee/system/ee/ExpressionEngine/Addons/pro/upd.pro.php'),
(3, 1676512203, 'Running database update step: runUpdateFile[ud_7_01_04.php]', NULL, NULL, NULL),
(4, 1676512203, 'Running database update step: runUpdateFile[ud_7_01_05.php]', NULL, NULL, NULL),
(5, 1676512203, 'Running database update step: runUpdateFile[ud_7_01_06.php]', NULL, NULL, NULL),
(6, 1676512204, 'Running database update step: runUpdateFile[ud_7_02_00.php]', NULL, NULL, NULL),
(7, 1676512204, 'Running database update step: runUpdateFile[ud_7_02_01.php]', NULL, NULL, NULL),
(8, 1676512204, 'Running database update step: runUpdateFile[ud_7_02_02.php]', NULL, NULL, NULL),
(9, 1676512204, 'Running database update step: runUpdateFile[ud_7_02_03.php]', NULL, NULL, NULL),
(10, 1676512204, 'Running database update step: runUpdateFile[ud_7_02_04.php]', NULL, NULL, NULL),
(11, 1676512204, 'Running database update step: runUpdateFile[ud_7_02_05.php]', NULL, NULL, NULL),
(12, 1676512205, 'Running database update step: runUpdateFile[ud_7_02_06.php]', NULL, NULL, NULL),
(13, 1676512205, 'Running database update step: runUpdateFile[ud_7_02_07.php]', NULL, NULL, NULL),
(14, 1676512205, 'Running database update step: runUpdateFile[ud_7_02_08.php]', NULL, NULL, NULL),
(15, 1676512205, 'Running database update step: runUpdateFile[ud_7_02_09.php]', NULL, NULL, NULL),
(16, 1676512205, 'Update complete. Now running version 7.2.9', NULL, NULL, NULL);

INSERT INTO `exp_upload_prefs` (`id`, `site_id`, `name`, `adapter`, `adapter_settings`, `server_path`, `url`, `allowed_types`, `allow_subfolders`, `subfolders_on_top`, `default_modal_view`, `max_size`, `max_height`, `max_width`, `properties`, `pre_format`, `post_format`, `file_properties`, `file_pre_format`, `file_post_format`, `cat_group`, `batch_location`, `module_id`) VALUES
(1, 1, 'Avatars', 'local', NULL, '{base_path}images/avatars/', '{base_url}images/avatars/', 'img', 'n', 'y', 'list', '50', '100', '100', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, 1, 'Signature Attachments', 'local', NULL, '{base_path}images/signature_attachments/', '{base_url}images/signature_attachments/', 'img', 'n', 'y', 'list', '30', '80', '480', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(3, 1, 'PM Attachments', 'local', NULL, '{base_path}images/pm_attachments/', '{base_url}images/pm_attachments/', 'img', 'n', 'y', 'list', '250', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(4, 1, 'Blog', 'local', NULL, '{base_path}/themes/user/site/default/asset/img/blog/', '{base_url}themes/user/site/default/asset/img/blog/', 'img', 'n', 'y', 'list', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 0),
(5, 1, 'Common', 'local', NULL, '{base_path}/themes/user/site/default/asset/img/common/', '{base_url}themes/user/site/default/asset/img/common/', 'img', 'n', 'y', 'list', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 0),
(6, 1, 'Home', 'local', NULL, '{base_path}/themes/user/site/default/asset/img/home/', '{base_url}themes/user/site/default/asset/img/home/', 'img', 'n', 'y', 'list', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, 0);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;