<?php

class Controller_Explore {
	
	private $wpdb;
	private $wp_query;
	
	public $grade;
	public $disciplines;
	
	public function __construct() {
		
		global $wpdb, $wp_query;
		
		$this->wpdb = $wpdb;
		$this->wp_query = $wp_query;
		
		// get query variables
		$this->grade = isset($this->wp_query->query['grade']) ? $this->wp_query->query['grade'] : 'elementary';
		
		// load all main categories / Disciplines
		$sql = "SELECT t.`name`, t.`term_id`, t.`slug` FROM {$this->wpdb->terms} t "
			. "LEFT JOIN {$this->wpdb->term_taxonomy} tt ON tt.`term_id` = t.`term_id` "
			. "WHERE t.`api_type` = 'Discipline' AND tt.`parent` = 0 "
			. "ORDER BY t.`name` ASC;";
		$this->disciplines = $this->wpdb->get_results( $sql, ARRAY_A );
		
	}
	
	/**
	 * Get items by discipline_id (term_id of this discipline)
	 * @param int $discipline_id 
	 */
	public function load_items_by_discipline($discipline_id, $limit = 12) {
		
		$sql = "SELECT p.*, m1.`meta_value` AS `item_publish_date`, "
			. "m2.`meta_value` AS `item_content_type_icon`, "
			. "m3.`meta_value` AS `item_object_type`, "
			. "m4.`meta_value` AS `item_ratings`, "
			. "m5.`meta_value` AS `item_preview` "
			. "FROM {$this->wpdb->posts} p "
			. "LEFT JOIN {$this->wpdb->postmeta} m1 ON m1.`post_id` = p.`ID` AND m1.`meta_key` = 'item_publish_date' "
			. "LEFT JOIN {$this->wpdb->postmeta} m2 ON m2.`post_id` = p.`ID` AND m2.`meta_key` = 'item_content_type_icon' "
			. "LEFT JOIN {$this->wpdb->postmeta} m3 ON m3.`post_id` = p.`ID` AND m3.`meta_key` = 'item_object_type' "
			. "LEFT JOIN {$this->wpdb->postmeta} m4 ON m4.`post_id` = p.`ID` AND m4.`meta_key` = 'item_ratings' "
			. "LEFT JOIN {$this->wpdb->postmeta} m5 ON m5.`post_id` = p.`ID` AND m5.`meta_key` = 'item_preview' "
			. "INNER JOIN {$this->wpdb->term_relationships} tr ON (tr.`object_id` = p.`ID` AND tr.`term_taxonomy_id` = ".(int)$discipline_id.") "
			. "WHERE p.`post_type` = 'item' "
			. "GROUP BY p.`ID` "
			. " LIMIT ".(int)$limit.";";
		
		$items = $this->wpdb->get_results($sql);
		
		return $items;
	}
}