<?php

class Controller_Favorites {
	
	private $wpdb;
	private $wp_query;
	
	public function __construct() {
		
		global $wpdb, $wp_query;
		
		$this->wpdb = $wpdb;
		$this->wp_query = $wp_query;
	}
	
	/**
	 * @param int $user_id
	 */
	public function get_favorites() {
		
		$user_id = get_current_user_id();
		
		$sql = "SELECT p.*, "
			. "m1.`meta_value` AS `item_publish_date`, "
			. "m2.`meta_value` AS `item_content_type_icon`, "
			. "m3.`meta_value` AS `item_object_type`, "
			. "m4.`meta_value` AS `item_ratings`, "
			. "m5.`meta_value` AS `item_preview`, "
			. "f.`item_id` AS `item_object_id` "
			. "FROM `wp_favorites` f "
			. "LEFT JOIN {$this->wpdb->postmeta} pm ON pm.`meta_key` = 'item_object_id' AND pm.`meta_value` = f.`item_id` "
			. "LEFT JOIN {$this->wpdb->posts} p ON p.`ID` = pm.`post_id` "
			. "LEFT JOIN {$this->wpdb->postmeta} m1 ON m1.`post_id` = p.`ID` AND m1.`meta_key` = 'item_publish_date' "
			. "LEFT JOIN {$this->wpdb->postmeta} m2 ON m2.`post_id` = p.`ID` AND m2.`meta_key` = 'item_content_type_icon' "
			. "LEFT JOIN {$this->wpdb->postmeta} m3 ON m3.`post_id` = p.`ID` AND m3.`meta_key` = 'item_object_type' "
			. "LEFT JOIN {$this->wpdb->postmeta} m4 ON m4.`post_id` = p.`ID` AND m4.`meta_key` = 'item_ratings' "
			. "LEFT JOIN {$this->wpdb->postmeta} m5 ON m5.`post_id` = p.`ID` AND m5.`meta_key` = 'item_preview' "
			. "WHERE f.`user_id` = ".(int)$user_id." AND f.`item_type` = '';";
			
		//echo $sql;

		$favorites = $this->wpdb->get_results( $sql );
		
		return $favorites;
	}
	
	/**
	 * 
	 * @param int $user_id
	 * @param mixed $item_id
	 * @param int $item_type
	 */
	public function action_add() {
		
		$user_id = get_current_user_id();
		$item_id = isset($_REQUEST['item_id']) ? $_REQUEST['item_id'] : '';
		$item_type = isset($_REQUEST['item_type']) ? $_REQUEST['item_type'] : '' ;
		
		$this->wpdb->insert('wp_favorites',array(
			'fav_created' => date('Y-m-d H:i:s'),
			'user_id' => $user_id,
			'item_id' => $item_id,
			'item_type' => $item_type
		));
	}
	
	/**
	 * Require all field to make sure it is secured
	 * @param int $user_id
	 * @param mixed $item_id
	 * @param int $item_type
	 */
	public function action_remove() {
		
		$user_id = get_current_user_id();
		$item_id = $_REQUEST['item_id'];
		$item_type = $_REQUEST['item_type'];
		
		$this->wpdb->delete( 'wp_favorites', array(
			'user_id' => $user_id,
			'item_id' => $item_id,
			'item_type' => $item_type
		), array( '%d', '%s', '%s' ) );
	}
}