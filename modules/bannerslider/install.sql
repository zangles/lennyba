DROP TABLE IF EXISTS `PREFIX_bannerslider_item`;
CREATE TABLE `PREFIX_bannerslider_item` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(3) unsigned NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `ordering` tinyint(3) unsigned NOT NULL,
  `custom_class` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `params` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_bannerslider_item_lang`;
CREATE TABLE `PREFIX_bannerslider_item_lang` (
  `item_id` int(3) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `image` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`item_id`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_bannerslider_module`;
CREATE TABLE `PREFIX_bannerslider_module` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(10) unsigned NOT NULL,
  `position_id` int(10) unsigned NOT NULL,
  `position_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `layout` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  `custom_class` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` tinyint(2) unsigned NOT NULL,
  `status` tinyint(2) unsigned NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `params` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_bannerslider_module_lang`;
CREATE TABLE `PREFIX_bannerslider_module_lang` (
  `item_id` int(3) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `link_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`item_id`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

