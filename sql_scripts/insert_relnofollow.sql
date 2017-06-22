TRUNCATE TABLE wp_item_rel_nofollow;
INSERT INTO wp_item_rel_nofollow (item_id,is_rel_nofollow)
SELECT ID, 1
from wp_posts
WHERE post_type = 'item'
UNION
SELECT itemId, 1
from wp_apicache_items
