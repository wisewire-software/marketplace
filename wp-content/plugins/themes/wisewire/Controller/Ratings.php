<?php

class Controller_Ratings {
	
	private $wpdb;
	private $wp_query;
	
	public function __construct() {
		
		global $wpdb, $wp_query;
		
		$this->wpdb = $wpdb;
		$this->wp_query = $wp_query;
	}
	
	/**
	 * 
	 * @param int $user_id
	 * @param mixed $item_id
	 * @param int $item_type
	 * @param float $rate
	 */
	public function action_add() {
		
		$rate = $_REQUEST['rate'];
		$user_id = get_current_user_id();
		$item_id = $_REQUEST['item_id'];
		$item_type = $_REQUEST['item_type'];
		
		$this->wpdb->insert('wp_ranks',array(
			'rank_created' => date('Y-m-d H:i:s'),
			'user_id' => $user_id,
			'value' => $rate,
			'item_id' => $item_id,
			'item_type' => $item_type
		));
		
		$this->wpdb->get_row("SELECT AVG(`meta_value`) FROM `wp_apicache_meta` WHERE `itemId` = '".esc_sql($item_id)."', `meta_key` = 'item_ratings';", ARRAY_A);
		
		// get item
		if ($item_type = 'api') {
			
			$item_meta = $this->wpdb->get_row("SELECT * FROM `wp_apicache_meta` WHERE `itemId` = '".esc_sql($item_id)."', `meta_key` = 'item_ratings' LIMIT 1;", ARRAY_A);
			
			if (!$item_meta) {
				$this->wpdb->insert('wp_apicache_meta',array(
					'itemId' => $item_id,
					'meta_key' => 'item_ratings',
					'meta_value' => $rate
				));
			} else {
				$this->wpdb->update('wp_apicache_meta',array(
					'meta_value' => $rate
				),array(
					'itemId' => $item_id,
					'meta_key' => 'item_ratings'
				));
			}
		} else {
			
			$item_meta = $this->wpdb->get_row("SELECT * FROM `wp_postmeta` WHERE `post_id` = '".esc_sql($item_id)."', `meta_key` = 'item_ratings' LIMIT 1;", ARRAY_A);
			
			if (!$item_meta) {
				$this->wpdb->insert('wp_postmeta',array(
					'post_id' => $item_id,
					'meta_key' => 'item_ratings',
					'meta_value' => $rate
				));
			} else {
				$this->wpdb->update('wp_postmeta',array(
					'meta_value' => $rate
				),array(
					'post_id' => $item_id,
					'meta_key' => 'item_ratings'
				));
			}
		}
	}
}