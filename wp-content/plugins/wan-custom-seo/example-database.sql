CREATE TABLE IF NOT EXISTS `wp_wan_custom_seo` (
  `id` integer NOT NULL AUTO_INCREMENT,
  `url` varchar(200) CHARACTER SET utf8 NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 NOT NULL,
  `meta_description` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;