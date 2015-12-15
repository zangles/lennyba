DROP TABLE IF EXISTS `PREFIX_ovic_backup_hook_module`;

CREATE TABLE `PREFIX_ovic_backup_hook_module` (
  `id_module` int(10) unsigned NOT NULL,
  `id_shop` int(11) unsigned NOT NULL DEFAULT '1',
  `id_hook` int(10) unsigned NOT NULL,
  `position` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`id_module`,`id_hook`,`id_shop`),
  KEY `id_hook` (`id_hook`),
  KEY `id_module` (`id_module`),
  KEY `position` (`id_shop`,`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `PREFIX_ovic_options`;

CREATE TABLE `PREFIX_ovic_options` (
  `id_option` int(6) NOT NULL AUTO_INCREMENT,
  `image` varchar(254) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `theme` varchar(50) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `column` varchar(10) NOT NULL,
  `active` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`id_option`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `PREFIX_ovic_options_hook_module`;

CREATE TABLE `PREFIX_ovic_options_hook_module` (
  `theme` varchar(50) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `hookname` varchar(64) NOT NULL,
  `modules` text NOT NULL,
  PRIMARY KEY (`theme`,`alias`,`hookname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `PREFIX_ovic_options_sidebar`;

CREATE TABLE `PREFIX_ovic_options_sidebar` (
  `theme` varchar(50) NOT NULL,
  `page` varchar(50) NOT NULL,
  `left` text,
  `right` text,
  `id_shop` int(6) NOT NULL,
  PRIMARY KEY (`theme`,`page`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `PREFIX_ovic_options_style`;

CREATE TABLE `PREFIX_ovic_options_style` (
  `theme` varchar(50) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `font` text,
  `color` text,
  PRIMARY KEY (`theme`,`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `PREFIX_ovic_options` (`id_option`, `image`, `name`, `theme`, `alias`, `column`, `active`) VALUES
(2,		'option1preview.jpg',	'Granada left layout',	'Granada',	'granada_left',	'1',	1),
(8,		'option2preview.jpg',	'Granada Option 2',	'Granada',	'granada_home2',	'3',	1),
(9,		'option3preview.jpg',	'Granada Option 3',	'Granada',	'granada_home3',	'3',	1),
(10,	'option4preview.jpg',	'Granada Option 4',	'Granada',	'granada_home4',	'3',	1),
(11,	'option5preview.jpg',	'Granada Option 5',	'Granada',	'granada_home5',	'3',	1),
(12,	'option6preview.jpg',	'Granada Option 6',	'Granada',	'granada_home6',	'3',	1),
(13,	'option7preview.jpg',	'Granada Option 7',	'Granada',	'granada_home7',	'3',	1),
(16,	'option8preview.jpg',	'Granada Option 8',	'Granada',	'granada_home8',	'3',	1),
(17,	'option9preview.jpg',	'Granada Option 9',	'Granada',	'granada_home9',	'3',	1),
(18,	'option10preview.jpg',	'Granada Option 10',	'Granada',	'granada_home10','3',1);

INSERT INTO `PREFIX_ovic_options_hook_module` (`theme`, `alias`, `hookname`, `modules`) VALUES
('Granada',	'granada_home10',	'displayBottomColumn',	'[[\"megaboxs\",\"displayBottomColumn\"]]'),
('Granada',	'granada_home10',	'displayFooter',	'[[\"statsdata\",\"displayFooter\"],[\"customhtml\",\"displayFooter\"]]'),
('Granada',	'granada_home10',	'displayHome',	'[[\"simplecategory\",\"displayHome\"]]'),
('Granada',	'granada_home10',	'displayHomeBottomColumn',	'[]'),
('Granada',	'granada_home10',	'displayHomeBottomContent',	'[]'),
('Granada',	'granada_home10',	'displayHomeTab',	'[]'),
('Granada',	'granada_home10',	'displayHomeTabContent',	'[]'),
('Granada',	'granada_home10',	'displayHomeTopColumn',	'[]'),
('Granada',	'granada_home10',	'displayHomeTopContent',	'[]'),
('Granada',	'granada_home10',	'displayNav',	'[[\"pagelink\",\"displayNav\"],[\"blockcart\",\"displayNav\"]]'),
('Granada',	'granada_home10',	'displayTop',	'[[\"pagesnotfound\",\"displayTop\"],[\"sekeywords\",\"displayTop\"]]'),
('Granada',	'granada_home10',	'displayTopColumn',	'[[\"megamenus\",\"displayTopColumn\"]]');

INSERT INTO `PREFIX_ovic_options_hook_module` (`theme`, `alias`, `hookname`, `modules`) VALUES
('Granada',	'granada_left',	'displayBottomColumn',	'[[\"megaboxs\",\"displayBottomColumn\"]]'),
('Granada',	'granada_left',	'displayFooter',	'[[\"statsdata\",\"displayFooter\"],[\"customhtml\",\"displayFooter\"]]'),
('Granada',	'granada_left',	'displayHome',	'[[\"customparallax\",\"displayCustomParallax1\"],[\"ovicparallaxblock\",\"displayHome\"],[\"customhtml\",\"displayHome\"],[\"customcontent\",\"displayHome\"],[\"customparallax\",\"displayHome\"],[\"smartbloghomelatestnews\",\"displayHome\"]]'),
('Granada',	'granada_left',	'displayHomeBottomColumn',	'[[\"megaboxs\",\"displayHomeBottomColumn\"]]'),
('Granada',	'granada_left',	'displayHomeBottomContent',	'[]'),
('Granada',	'granada_left',	'displayHomeTab',	'[]'),
('Granada',	'granada_left',	'displayHomeTabContent',	'[]'),
('Granada',	'granada_left',	'displayHomeTopContent',	'[[\"homeslider\",\"displayHome\"],[\"flexgroupbanners\",\"displayHome\"],[\"simplecategory\",\"displayHomeTopColumn\"]]'),
('Granada',	'granada_left',	'displayLeftColumn',	'[[\"megamenus\",\"displayVerticalMenu\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"simplecategory\",\"displayLeftColumn\"],[\"smartblogpopularposts\",\"displayLeftColumn\"],[\"smartbloglatestcomments\",\"displayLeftColumn\"],[\"simplecategory\",\"displaySimpleCategory\"],[\"blocktags\",\"displayLeftColumn\"],[\"customhtml\",\"displayLeftColumn\"],[\"customhtml\",\"CustomHtml\"]]'),
('Granada',	'granada_left',	'displayNav',	'[[\"pagelink\",\"displayNav\"]]'),
('Granada',	'granada_left',	'displayTop',	'[[\"imagesearchblock\",\"displayTop\"],[\"blockcart\",\"displayTop\"],[\"pagesnotfound\",\"displayTop\"],[\"sekeywords\",\"displayTop\"],[\"blockwishlist\",\"displayTop\"]]'),
('Granada',	'granada_left',	'displayTopColumn',	'[[\"megamenus\",\"displayTopColumn\"]]');

INSERT INTO `PREFIX_ovic_options_hook_module` (`theme`, `alias`, `hookname`, `modules`) VALUES
('Granada',	'granada_home2',	'displayBottomColumn',	'[[\"megaboxs\",\"displayBottomColumn\"]]'),
('Granada',	'granada_home2',	'displayFooter',	'[[\"statsdata\",\"displayFooter\"],[\"customhtml\",\"displayFooter\"]]'),
('Granada',	'granada_home2',	'displayHome',	'[[\"simplecategory\",\"displayHome\"],[\"customparallax\",\"displayHome\"],[\"simplecategory\",\"displaySimpleCategory\"],[\"customcontent\",\"displayHome\"],[\"smartbloghomelatestnews\",\"displayHome\"],[\"brandsslider\",\"displayHome\"]]'),
('Granada',	'granada_home2',	'displayHomeBottomColumn',	'[]'),
('Granada',	'granada_home2',	'displayHomeBottomContent',	'[]'),
('Granada',	'granada_home2',	'displayHomeTab',	'[]'),
('Granada',	'granada_home2',	'displayHomeTabContent',	'[]'),
('Granada',	'granada_home2',	'displayHomeTopColumn',	'[[\"homeslider\",\"displayTopColumn\"]]'),
('Granada',	'granada_home2',	'displayHomeTopContent',	'[[\"flexgroupbanners\",\"displayHomeTopContent\"]]'),
('Granada',	'granada_home2',	'displayNav',	'[[\"pagelink\",\"displayNav\"]]'),
('Granada',	'granada_home2',	'displayTop',	'[[\"imagesearchblock\",\"displayTop\"],[\"blockcart\",\"displayTop\"],[\"blockcurrencies\",\"displayTop\"],[\"blocklanguages\",\"displayNav\"],[\"pagesnotfound\",\"displayTop\"],[\"sekeywords\",\"displayTop\"],[\"blockwishlist\",\"displayTop\"]]'),
('Granada',	'granada_home2',	'displayTopColumn',	'[]');

INSERT INTO `PREFIX_ovic_options_hook_module` (`theme`, `alias`, `hookname`, `modules`) VALUES
('Granada',	'granada_home3',	'displayBottomColumn',	'[[\"megaboxs\",\"displayBottomColumn\"]]'),
('Granada',	'granada_home3',	'displayFooter',	'[[\"statsdata\",\"displayFooter\"],[\"customhtml\",\"displayFooter\"]]'),
('Granada',	'granada_home3',	'displayHome',	'[[\"smartbloghomelatestnews\",\"displayHome\"],[\"customparallax\",\"displayHome\"]]'),
('Granada',	'granada_home3',	'displayHomeBottomColumn',	'[[\"megaboxs\",\"displayHomeBottomColumn\"]]'),
('Granada',	'granada_home3',	'displayHomeBottomContent',	'[[\"customparallax\",\"displayHomeBottomContent\"],[\"customhtml\",\"displayHome\"],[\"customparallax\",\"displayCustomParallax1\"]]'),
('Granada',	'granada_home3',	'displayHomeTab',	'[]'),
('Granada',	'granada_home3',	'displayHomeTabContent',	'[]'),
('Granada',	'granada_home3',	'displayHomeTopColumn',	'[[\"customparallax\",\"displayHomeTopColumn\"],[\"bannerslider\",\"displayBannerSlider1\"]]'),
('Granada',	'granada_home3',	'displayHomeTopContent',	'[[\"customparallax\",\"displayHomeTopContent\"],[\"simplecategory\",\"displayHomeTopContent\"],[\"bannerslider\",\"displayBannerSlider2\"]]'),
('Granada',	'granada_home3',	'displayNav',	'[[\"pagelink\",\"displayNav\"],[\"blockcart\",\"displayTop\"]]'),
('Granada',	'granada_home3',	'displayTop',	'[[\"pagesnotfound\",\"displayTop\"],[\"sekeywords\",\"displayTop\"]]'),
('Granada',	'granada_home3',	'displayTopColumn',	'[[\"megamenus\",\"displayTopColumn\"]]');

INSERT INTO `PREFIX_ovic_options_hook_module` (`theme`, `alias`, `hookname`, `modules`) VALUES
('Granada',	'granada_home4',	'displayBottomColumn',	'[[\"megaboxs\",\"displayBottomColumn\"]]'),
('Granada',	'granada_home4',	'displayFooter',	'[[\"statsdata\",\"displayFooter\"],[\"customhtml\",\"displayFooter\"]]'),
('Granada',	'granada_home4',	'displayHome',	'[[\"simplecategory\",\"displayHome\"],[\"customparallax\",\"displayHome\"],[\"customcontent\",\"displayHome\"],[\"customhtml\",\"displayHome\"]]'),
('Granada',	'granada_home4',	'displayHomeBottomColumn',	'[[\"megaboxs\",\"displayHomeBottomColumn\"]]'),
('Granada',	'granada_home4',	'displayHomeBottomContent',	'[[\"customparallax\",\"displayCustomParallax1\"],[\"customcontent\",\"displayCustomContent1\"],[\"customhtml\",\"displayTopColumn\"],[\"customparallax\",\"displayCustomParallax2\"],[\"smartbloghomelatestnews\",\"displayHome\"]]'),
('Granada',	'granada_home4',	'displayHomeTab',	'[]'),
('Granada',	'granada_home4',	'displayHomeTabContent',	'[]'),
('Granada',	'granada_home4',	'displayHomeTopColumn',	'[[\"homeslider\",\"displayTopColumn\"]]'),
('Granada',	'granada_home4',	'displayHomeTopContent',	'[[\"simplecategory\",\"displayHomeTopContent\"],[\"bannerslider\",\"displayBannerSlider1\"]]'),
('Granada',	'granada_home4',	'displayNav',	'[[\"pagelink\",\"displayNav\"],[\"blockcart\",\"displayTop\"]]'),
('Granada',	'granada_home4',	'displayTop',	'[[\"pagesnotfound\",\"displayTop\"],[\"sekeywords\",\"displayTop\"]]'),
('Granada',	'granada_home4',	'displayTopColumn',	'[[\"megamenus\",\"displayTopColumn\"]]');

INSERT INTO `PREFIX_ovic_options_hook_module` (`theme`, `alias`, `hookname`, `modules`) VALUES
('Granada',	'granada_home5',	'displayBottomColumn',	'[[\"megaboxs\",\"displayBottomColumn\"]]'),
('Granada',	'granada_home5',	'displayFooter',	'[[\"statsdata\",\"displayFooter\"],[\"customhtml\",\"displayFooter\"]]'),
('Granada',	'granada_home5',	'displayHome',	'[]'),
('Granada',	'granada_home5',	'displayHomeBottomColumn',	'[[\"megaboxs\",\"displayHomeBottomColumn\"]]'),
('Granada',	'granada_home5',	'displayHomeBottomContent',	'[]'),
('Granada',	'granada_home5',	'displayHomeTab',	'[]'),
('Granada',	'granada_home5',	'displayHomeTabContent',	'[]'),
('Granada',	'granada_home5',	'displayHomeTopColumn',	'[[\"homeslider\",\"displayTopColumn\"]]'),
('Granada',	'granada_home5',	'displayHomeTopContent',	'[[\"simplecategory\",\"displayHomeTopContent\"],[\"flexgroupbanners\",\"displayHomeTopContent\"],[\"customhtml\",\"displayTopColumn\"],[\"simplecategory\",\"displaySimpleCategory\"],[\"customparallax\",\"displayHomeTopContent\"],[\"smartbloghomelatestnews\",\"displayHome\"],[\"brandsslider\",\"displayHome\"]]'),
('Granada',	'granada_home5',	'displayNav',	'[[\"pagelink\",\"displayNav\"]]'),
('Granada',	'granada_home5',	'displayTop',	'[[\"pagesnotfound\",\"displayTop\"],[\"sekeywords\",\"displayTop\"],[\"blockcart\",\"displayTop\"],[\"blockcurrencies\",\"displayTop\"],[\"blocklanguages\",\"displayTop\"]]'),
('Granada',	'granada_home5',	'displayTopColumn',	'[[\"megamenus\",\"displayTopColumn\"]]');

INSERT INTO `PREFIX_ovic_options_hook_module` (`theme`, `alias`, `hookname`, `modules`) VALUES
('Granada',	'granada_home6',	'displayBottomColumn',	'[[\"megaboxs\",\"displayBottomColumn\"]]'),
('Granada',	'granada_home6',	'displayFooter',	'[[\"statsdata\",\"displayFooter\"],[\"customhtml\",\"displayFooter\"]]'),
('Granada',	'granada_home6',	'displayHome',	'[[\"customparallax\",\"displayHome\"],[\"simplecategory\",\"displayHome\"],[\"smartbloghomelatestnews\",\"displayHome\"],[\"customparallax\",\"displayCustomParallax1\"],[\"simplecategory\",\"displaySimpleCategory\"],[\"brandsslider\",\"displayHome\"]]'),
('Granada',	'granada_home6',	'displayHomeBottomColumn',	'[[\"megaboxs\",\"displayHomeBottomColumn\"]]'),
('Granada',	'granada_home6',	'displayHomeBottomContent',	'[]'),
('Granada',	'granada_home6',	'displayHomeTab',	'[]'),
('Granada',	'granada_home6',	'displayHomeTabContent',	'[]'),
('Granada',	'granada_home6',	'displayHomeTopColumn',	'[[\"homeslider\",\"displayTopColumn\"],[\"flexgroupbanners\",\"displayHomeTopContent\"]]'),
('Granada',	'granada_home6',	'displayHomeTopContent',	'[[\"simplecategory\",\"displayHomeTopContent\"]]'),
('Granada',	'granada_home6',	'displayNav',	'[[\"pagelink\",\"displayNav\"]]'),
('Granada',	'granada_home6',	'displayTop',	'[[\"customhtml\",\"displayTop\"],[\"blockcart\",\"displayTop\"],[\"pagesnotfound\",\"displayTop\"],[\"sekeywords\",\"displayTop\"]]'),
('Granada',	'granada_home6',	'displayTopColumn',	'[[\"megamenus\",\"displayTopColumn\"]]');

INSERT INTO `PREFIX_ovic_options_hook_module` (`theme`, `alias`, `hookname`, `modules`) VALUES
('Granada',	'granada_home7',	'displayBeforeLogo',	'[]'),
('Granada',	'granada_home7',	'displayBottomColumn',	'[[\"megaboxs\",\"displayBottomColumn\"]]'),
('Granada',	'granada_home7',	'displayFooter',	'[[\"statsdata\",\"displayFooter\"],[\"customhtml\",\"displayFooter\"]]'),
('Granada',	'granada_home7',	'displayHome',	'[[\"flexgroupbanners\",\"displayHome\"],[\"simplecategory\",\"displayHome\"]]'),
('Granada',	'granada_home7',	'displayHomeBottomColumn',	'[[\"megaboxs\",\"displayHomeBottomColumn\"]]'),
('Granada',	'granada_home7',	'displayHomeBottomContent',	'[[\"brandsslider\",\"displayFooter\"]]'),
('Granada',	'granada_home7',	'displayHomeTab',	'[]'),
('Granada',	'granada_home7',	'displayHomeTabContent',	'[]'),
('Granada',	'granada_home7',	'displayHomeTopColumn',	'[[\"homeslider\",\"displayHome\"]]'),
('Granada',	'granada_home7',	'displayHomeTopContent',	'[[\"flexgroupbanners\",\"displayHomeTopContent\"],[\"simplecategory\",\"displayHomeTopContent\"]]'),
('Granada',	'granada_home7',	'displayNav',	'[[\"pagelink\",\"displayNav\"]]'),
('Granada',	'granada_home7',	'displayTop',	'[[\"imagesearchblock\",\"displayTop\"],[\"blockcart\",\"displayTop\"],[\"pagesnotfound\",\"displayTop\"],[\"sekeywords\",\"displayTop\"]]'),
('Granada',	'granada_home7',	'displayTopColumn',	'[[\"megamenus\",\"displayTopColumn\"]]');

INSERT INTO `PREFIX_ovic_options_hook_module` (`theme`, `alias`, `hookname`, `modules`) VALUES
('Granada',	'granada_home8',	'displayBottomColumn',	'[[\"megaboxs\",\"displayBottomColumn\"]]'),
('Granada',	'granada_home8',	'displayFooter',	'[[\"statsdata\",\"displayFooter\"],[\"customhtml\",\"displayFooter\"]]'),
('Granada',	'granada_home8',	'displayHome',	'[[\"customparallax\",\"displayHome\"],[\"flexgroupbanners\",\"displayHome\"],[\"customparallax\",\"displayCustomParallax1\"],[\"flexgroupbanners\",\"displayGroupBanner3\"]]'),
('Granada',	'granada_home8',	'displayHomeBottomColumn',	'[]'),
('Granada',	'granada_home8',	'displayHomeBottomContent',	'[]'),
('Granada',	'granada_home8',	'displayHomeTab',	'[]'),
('Granada',	'granada_home8',	'displayHomeTabContent',	'[]'),
('Granada',	'granada_home8',	'displayHomeTopColumn',	'[[\"homeslider\",\"displayTopColumn\"],[\"flexgroupbanners\",\"displayHomeTopColumn\"],[\"bannerslider\",\"displayBannerSlider2\"]]'),
('Granada',	'granada_home8',	'displayHomeTopContent',	'[[\"flexgroupbanners\",\"displayHomeTopContent\"]]'),
('Granada',	'granada_home8',	'displayNav',	'[[\"pagelink\",\"displayNav\"]]'),
('Granada',	'granada_home8',	'displayTop',	'[[\"imagesearchblock\",\"displayTop\"],[\"blockcart\",\"displayTop\"],[\"blockcurrencies\",\"displayTop\"],[\"blocklanguages\",\"displayNav\"],[\"pagesnotfound\",\"displayTop\"],[\"sekeywords\",\"displayTop\"],[\"blockwishlist\",\"displayTop\"]]'),
('Granada',	'granada_home8',	'displayTopColumn',	'[]');

INSERT INTO `PREFIX_ovic_options_hook_module` (`theme`, `alias`, `hookname`, `modules`) VALUES
('Granada',	'granada_home9',	'displayBottomColumn',	'[[\"megaboxs\",\"displayBottomColumn\"]]'),
('Granada',	'granada_home9',	'displayFooter',	'[[\"statsdata\",\"displayFooter\"],[\"customhtml\",\"displayFooter\"]]'),
('Granada',	'granada_home9',	'displayHome',	'[[\"customcontent\",\"displayHome\"]]'),
('Granada',	'granada_home9',	'displayHomeBottomColumn',	'[]'),
('Granada',	'granada_home9',	'displayHomeBottomContent',	'[]'),
('Granada',	'granada_home9',	'displayHomeTab',	'[]'),
('Granada',	'granada_home9',	'displayHomeTabContent',	'[]'),
('Granada',	'granada_home9',	'displayHomeTopColumn',	'[]'),
('Granada',	'granada_home9',	'displayHomeTopContent',	'[]'),
('Granada',	'granada_home9',	'displayNav',	'[[\"pagelink\",\"displayNav\"],[\"blockcart\",\"displayNav\"]]'),
('Granada',	'granada_home9',	'displayTop',	'[[\"pagesnotfound\",\"displayTop\"],[\"sekeywords\",\"displayTop\"]]'),
('Granada',	'granada_home9',	'displayTopColumn',	'[[\"megamenus\",\"displayTopColumn\"]]');

INSERT INTO `PREFIX_ovic_options_sidebar` (`theme`, `page`, `left`, `right`, `id_shop`) VALUES
('Granada',	'address',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'addresses',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'authentication',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'best-sales',	'[[\"customhtml\",\"displayLeftColumn\"]]',	'[[\"blockcategories\",\"displayLeftColumn\"]]',	1),
('Granada',	'cart',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'category',	'[[\"blockcategories\",\"displayLeftColumn\"],[\"blocklayered\",\"displayLeftColumn\"],[\"ovicsaleproducts\",\"displayLeftColumn\"],[\"flexbanner\",\"displayLeftColumn\"]]',	'[[\"blockcategories\",\"displayRightColumn\"],[\"blocklayered\",\"displayRightColumn\"],[\"simplecategory\",\"displayRightColumn\"],[\"customhtml\",\"displayRightColumn\"]]',	1),
('Granada',	'cms',	'[[\"blockmanufacturer\",\"displayLeftColumn\"],[\"simplecategory\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"],[\"smartblogpopularposts\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'contact',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'discount',	'[[\"blockcategories\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'guest-tracking',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'history',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'identity',	'[]',	NULL,	1),
('Granada',	'index',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'manufacturer',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"],[\"blockcategories\",\"displayLeftColumn\"],[\"blockbestsellers\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'module-bankwire-payment',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'module-bankwire-validation',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'module-blocknewsletter-verification',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'module-blockwishlist-mywishlist',	'[]',	NULL,	1),
('Granada',	'module-blockwishlist-view',	'[]',	NULL,	1),
('Granada',	'module-cheque-payment',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'module-cheque-validation',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'module-cronjobs-callback',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'module-productcomments-default',	'[[\"verticalmegamenus\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockbestsellers\",\"displayLeftColumn\"],[\"smartblogpopularposts\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"blockhtml\",\"displayLeftColumn\"],[\"ovicsaleproducts\",\"displayRightColumn\"],[\"flexbanner\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'module-smartblog-archive',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	'[[\"smartblogcategories\",\"displayRightColumn\"]]',	1),
('Granada',	'module-smartblog-category',	'[[\"smartblogcategories\",\"displayLeftColumn\"],[\"smartblogpopularposts\",\"displayLeftColumn\"],[\"smartblogtag\",\"displayLeftColumn\"]]',	'[[\"smartblogcategories\",\"displayLeftColumn\"],[\"smartbloghomelatestnews\",\"displayLeftColumn\"],[\"smartbloglatestcomments\",\"displayLeftColumn\"],[\"smartblogtag\",\"displayLeftColumn\"],[\"smartblogpopularposts\",\"displayLeftColumn\"],[\"customhtml\",\"displaySmartBlogRight\"]]',	1),
('Granada',	'module-smartblog-details',	'[[\"smartbloglatestcomments\",\"displayLeftColumn\"]]',	'[[\"smartblogcategories\",\"displayRightColumn\"],[\"smartbloglatestcomments\",\"displayLeftColumn\"],[\"smartblogpopularposts\",\"displayLeftColumn\"],[\"smartblogtag\",\"displayLeftColumn\"],[\"smartbloghomelatestnews\",\"displayLeftColumn\"]]',	1),
('Granada',	'module-smartblog-search',	'[[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'module-smartblog-tagpost',	'[[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"],[\"simplecategory\",\"displayLeftColumn\"],[\"smartblogpopularposts\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'my-account',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'new-products',	'[[\"blockmanufacturer\",\"displayLeftColumn\"],[\"simplecategory\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"],[\"smartblogpopularposts\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'order',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'order-confirmation',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'order-detail',	'[[\"verticalmegamenus\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockbestsellers\",\"displayLeftColumn\"],[\"smartblogpopularposts\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"blockhtml\",\"displayLeftColumn\"],[\"ovicsaleproducts\",\"displayRightColumn\"],[\"flexbanner\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'order-follow',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'order-opc',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'order-slip',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'pagenotfound',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'password',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'prices-drop',	'[[\"blockmanufacturer\",\"displayLeftColumn\"],[\"simplecategory\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"],[\"smartblogpopularposts\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'product',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'products-comparison',	'[]',	NULL,	1),
('Granada',	'search',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'sitemap',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'stores',	'[[\"blockbestsellers\",\"displayLeftColumn\"],[\"blockmanufacturer\",\"displayLeftColumn\"],[\"blockspecials\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"]]',	NULL,	1),
('Granada',	'supplier',	'[[\"blockmanufacturer\",\"displayLeftColumn\"],[\"simplecategory\",\"displayLeftColumn\"],[\"blocktags\",\"displayLeftColumn\"],[\"themeconfigurator\",\"displayLeftColumn\"],[\"smartblogpopularposts\",\"displayLeftColumn\"]]',	NULL,	1);

INSERT INTO `PREFIX_ovic_options_style` (`theme`, `alias`, `font`, `color`) VALUES
('Granada',	'granada_left',	'{\"font1\":\"\"}',	'{\"main\":\"#d8d2c5\",\"button\":\"#cbc6b2\",\"button_text\":\"#ffffff\",\"button_hover\":\"#e61446\",\"button_text_hover\":\"#FFFFFF\",\"second_button\":\"#cbc6b2\",\"second_button_text\":\"#FFFFFF\",\"second_button_hover\":\"#1694d6\",\"second_button_text_hover\":\"#FFFFFF\",\"text\":\"#7e786b\",\"text_hover\":\"#e61446\"}'),
('Granada',	'granada_home2',	'{\"font1\":\"\"}',	'{\"main\":\"#d8d2c5\",\"button\":\"#cbc6b2\",\"button_text\":\"#ffffff\",\"button_hover\":\"#e61446\",\"button_text_hover\":\"#FFFFFF\",\"second_button\":\"#cbc6b2\",\"second_button_text\":\"#FFFFFF\",\"second_button_hover\":\"#1694d6\",\"second_button_text_hover\":\"#FFFFFF\",\"text\":\"#7e786b\",\"text_hover\":\"#e61446\"}'),
('Granada',	'granada_home3',	'{\"font1\":\"\"}',	'{\"main\":\"#d8d2c5\",\"button\":\"#cbc6b2\",\"button_text\":\"#ffffff\",\"button_hover\":\"#e61446\",\"button_text_hover\":\"#FFFFFF\",\"second_button\":\"#e61446\",\"second_button_text\":\"#FFFFFF\",\"second_button_hover\":\"#cbc6b2\",\"second_button_text_hover\":\"#FFFFFF\",\"text\":\"#7e786b\",\"text_hover\":\"#e61446\"}'),
('Granada',	'granada_home4',	'{\"font1\":\"\"}',	'{\"main\":\"#d8d2c5\",\"button\":\"#cbc6b2\",\"button_text\":\"#ffffff\",\"button_hover\":\"#e61446\",\"button_text_hover\":\"#FFFFFF\",\"second_button\":\"#e61446\",\"second_button_text\":\"#FFFFFF\",\"second_button_hover\":\"#cbc6b2\",\"second_button_text_hover\":\"#FFFFFF\",\"text\":\"#7e786b\",\"text_hover\":\"#e61446\"}'),
('Granada',	'granada_home5',	'{\"font1\":\"\"}',	'{\"main\":\"#d8d2c5\",\"button\":\"#cbc6b2\",\"button_text\":\"#ffffff\",\"button_hover\":\"#e61446\",\"button_text_hover\":\"#FFFFFF\",\"second_button\":\"#cbc6b2\",\"second_button_text\":\"#FFFFFF\",\"second_button_hover\":\"#1694d6\",\"second_button_text_hover\":\"#FFFFFF\",\"text\":\"#7e786b\",\"text_hover\":\"#e61446\"}'),
('Granada',	'granada_home6',	'{\"font1\":\"\"}',	'{\"main\":\"#d8d2c5\",\"button\":\"#cbc6b2\",\"button_text\":\"#ffffff\",\"button_hover\":\"#e61446\",\"button_text_hover\":\"#FFFFFF\",\"second_button\":\"#cbc6b2\",\"second_button_text\":\"#FFFFFF\",\"second_button_hover\":\"#1694d6\",\"second_button_text_hover\":\"#FFFFFF\",\"text\":\"#7e786b\",\"text_hover\":\"#e61446\"}'),
('Granada',	'granada_home7',	'{\"font1\":\"\"}',	'{\"main\":\"#d8d2c5\",\"button\":\"#cbc6b2\",\"button_text\":\"#ffffff\",\"button_hover\":\"#e61446\",\"button_text_hover\":\"#FFFFFF\",\"second_button\":\"#cbc6b2\",\"second_button_text\":\"#FFFFFF\",\"second_button_hover\":\"#1694d6\",\"second_button_text_hover\":\"#FFFFFF\",\"text\":\"#7e786b\",\"text_hover\":\"#e61446\"}'),
('Granada',	'granada_home8',	'{\"font1\":\"\"}',	'{\"main\":\"#d8d2c5\",\"button\":\"#cbc6b2\",\"button_text\":\"#ffffff\",\"button_hover\":\"#e61446\",\"button_text_hover\":\"#FFFFFF\",\"second_button\":\"#cbc6b2\",\"second_button_text\":\"#FFFFFF\",\"second_button_hover\":\"#1694d6\",\"second_button_text_hover\":\"#FFFFFF\",\"text\":\"#7e786b\",\"text_hover\":\"#e61446\"}'),
('Granada',	'granada_home9',	'{\"font1\":\"\"}',	'{\"main\":\"#d8d2c5\",\"button\":\"#cbc6b2\",\"button_text\":\"#ffffff\",\"button_hover\":\"#e61446\",\"button_text_hover\":\"#FFFFFF\",\"second_button\":\"#cbc6b2\",\"second_button_text\":\"#FFFFFF\",\"second_button_hover\":\"#1694d6\",\"second_button_text_hover\":\"#FFFFFF\",\"text\":\"#7e786b\",\"text_hover\":\"#e61446\"}'),
('Granada',	'granada_home10',	'{\"font1\":\"\"}',	'{\"main\":\"#d8d2c5\",\"button\":\"#cbc6b2\",\"button_text\":\"#ffffff\",\"button_hover\":\"#e61446\",\"button_text_hover\":\"#FFFFFF\",\"second_button\":\"#cbc6b2\",\"second_button_text\":\"#FFFFFF\",\"second_button_hover\":\"#1694d6\",\"second_button_text_hover\":\"#FFFFFF\",\"text\":\"#7e786b\",\"text_hover\":\"#e61446\"}');