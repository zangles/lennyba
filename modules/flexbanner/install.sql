DROP TABLE IF EXISTS `PREFIX_flexbanner_banner`;
CREATE TABLE `PREFIX_flexbanner_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(10) unsigned NOT NULL,
  `position_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `custom_class` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `width` tinyint(2) unsigned NOT NULL,
  `layout` varchar(64) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `params` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_flexbanner_banner_lang`;
CREATE TABLE `PREFIX_flexbanner_banner_lang` (
  `banner_id` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `image` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`banner_id`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_flexbanner_banner_position`;
CREATE TABLE `PREFIX_flexbanner_banner_position` (
  `banner_id` int(10) unsigned NOT NULL,
  `position_id` int(10) unsigned NOT NULL,
  `position_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`banner_id`,`position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
