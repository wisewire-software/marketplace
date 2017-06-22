/*
Navicat MySQL Data Transfer

Source Server         : WiseWire SErver QA
Source Server Version : 50555
Source Host           : 104.130.17.67:3306
Source Database       : wordpress

Target Server Type    : MYSQL
Target Server Version : 50555
File Encoding         : 65001

Date: 2017-06-21 15:53:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wp_item_rel_nofollow
-- ----------------------------
DROP TABLE IF EXISTS `wp_item_rel_nofollow`;
CREATE TABLE `wp_item_rel_nofollow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` varchar(42) DEFAULT NULL,
  `is_rel_nofollow` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`) USING BTREE
)
