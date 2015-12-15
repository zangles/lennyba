DROP TABLE IF EXISTS `PREFIX_megaboxs_group`;
CREATE TABLE `PREFIX_megaboxs_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  `row_id` int(10) unsigned NOT NULL,
  `display_title` tinyint(3) unsigned NOT NULL,
  `custom_class` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('product','module','link','html','contact','twitter_feed','flickr_feed','store_map') COLLATE utf8_unicode_ci NOT NULL,
  `params` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `width` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_megaboxs_group_lang`;
CREATE TABLE `PREFIX_megaboxs_group_lang` (
  `group_id` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `html` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`group_id`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_megaboxs_menu`;
CREATE TABLE `PREFIX_megaboxs_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  `display_name` tinyint(3) unsigned NOT NULL,
  `background` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `icon_active` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `link_type` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `custom_class` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `width` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_megaboxs_menu_lang`;
CREATE TABLE `PREFIX_megaboxs_menu_lang` (
  `menu_id` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`menu_id`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_megaboxs_menuitem`;
CREATE TABLE `PREFIX_megaboxs_menuitem` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(5) unsigned NOT NULL,
  `menu_id` int(5) unsigned NOT NULL,
  `row_id` int(5) unsigned NOT NULL,
  `group_id` int(5) unsigned NOT NULL,
  `parent_id` int(5) unsigned NOT NULL,
  `menu_type` enum('link','image','html','module') COLLATE utf8_unicode_ci NOT NULL,
  `link_type` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `custom_class` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` tinyint(3) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `module_name` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `hook_name` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `icon` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `icon_active` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_megaboxs_menuitem_lang`;
CREATE TABLE `PREFIX_megaboxs_menuitem_lang` (
  `menuitem_id` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `imageAlt` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `html` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`menuitem_id`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_megaboxs_module`;
CREATE TABLE `PREFIX_megaboxs_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_shop` int(4) unsigned NOT NULL,
  `theme_directory` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `option_directory` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `position_name` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `layout` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` tinyint(3) unsigned NOT NULL,
  `show_count` tinyint(3) unsigned NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `params` varchar(511) COLLATE utf8_unicode_ci NOT NULL,
  `custom_class` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_megaboxs_module_lang`;
CREATE TABLE `PREFIX_megaboxs_module_lang` (
  `module_id` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`module_id`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_megaboxs_module_position`;
CREATE TABLE `PREFIX_megaboxs_module_position` (
  `module_id` int(10) unsigned NOT NULL,
  `position_id` int(10) unsigned NOT NULL,
  `position_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`module_id`,`position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_megaboxs_row`;
CREATE TABLE `PREFIX_megaboxs_row` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  `width` tinyint(3) unsigned NOT NULL,
  `ordering` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `custom_class` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `PREFIX_megaboxs_row_lang`;
CREATE TABLE `PREFIX_megaboxs_row_lang` (
  `row_id` int(10) unsigned NOT NULL,
  `id_lang` int(10) unsigned NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`row_id`,`id_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;