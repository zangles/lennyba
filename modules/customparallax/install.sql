DROP TABLE IF EXISTS `PREFIX_customparallax_module`;
CREATE TABLE `PREFIX_customparallax_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(10) unsigned NOT NULL,
  `position_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` tinyint(3) unsigned NOT NULL,
  `layout` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `content_type` enum('html','module') COLLATE utf8_unicode_ci NOT NULL,
  `module_name` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `module_hook` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `background_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `custom_class` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `params` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_customparallax_module_lang`;
CREATE TABLE `PREFIX_customparallax_module_lang` (
  `module_id` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`module_id`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

