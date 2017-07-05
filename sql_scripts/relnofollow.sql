DROP TABLE IF EXISTS `wp_item_rel_nofollow`;
CREATE TABLE `wp_item_rel_nofollow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` varchar(42) DEFAULT NULL,
  `is_rel_nofollow` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`) USING BTREE
);
INSERT INTO wp_item_rel_nofollow (item_id,is_rel_nofollow)
SELECT ID, 1
from wp_posts
WHERE post_type = 'item'
UNION
SELECT itemId, 1
from wp_apicache_items

