DROP TABLE IF EXISTS `PREFIX_customcontent_item`;
CREATE TABLE `PREFIX_customcontent_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(10) unsigned NOT NULL,
  `link_type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `custom_class` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `icon` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `background` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `width` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_customcontent_item_lang`;
CREATE TABLE `PREFIX_customcontent_item_lang` (
  `item_id` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `before` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `after` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`item_id`,`id_lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_customcontent_module`;
CREATE TABLE `PREFIX_customcontent_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(10) unsigned NOT NULL,
  `position_name` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` tinyint(3) unsigned NOT NULL,
  `layout` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `custom_class` varchar(63) COLLATE utf8_unicode_ci NOT NULL,
  `background` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_customcontent_module_lang`;
CREATE TABLE `PREFIX_customcontent_module_lang` (
  `module_id` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `before` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `after` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`module_id`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;