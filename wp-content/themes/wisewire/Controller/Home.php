<?php

class Controller_Home {
	
	private $wpdb;
	private $wp_query;
	
	public $recommendations = array();
	public $recently_viewed = array();
	public $other_viewed = array();
	public $pio;
	
	public function __construct() {
		
		global $wpdb, $wp_query;
		
		$this->wpdb = $wpdb;
		$this->wp_query = $wp_query;
		
		$this->pio = new PredictionIOController(); 
		
		$this->load_data();

		// load all featured authors
		$sql = "SELECT f.* FROM wp_cache_featured f ";
		$this->featured_authors = $this->wpdb->get_results( $sql, ARRAY_A );
	}
	
	public function load_data() {
		
		$this->load_recommendations();
		
		$this->load_recently_viewed();
		
		$this->load_other_viewed();
		
	}
	
	private function load_other_viewed() {
		
		$user_id = $this->pio->get_user_id();
		
		$sql = "SELECT `object_id` FROM `wp_object_views` WHERE `user_id` != '".esc_sql($user_id)."' GROUP BY `object_id` ORDER BY `datetime` DESC LIMIT 4";
		$recently_viewed = $this->wpdb->get_results($sql, ARRAY_N);
		
		if ($recently_viewed) {
			$r = array();
			foreach ($recently_viewed as $v) {
				$r []= $v[0];
			}
			
			$sql = "SELECT p.* FROM `wp_posts` p INNER JOIN `wp_postmeta` pm ON pm.`meta_key` = 'item_object_id' AND pm.`post_id` = p.`ID` "
				. "AND pm.`meta_value` IN ('"
					. implode('\',\'',$r)
				. "') "
				. "WHERE p.`post_status` = 'publish';";
			
			$this->other_viewed = $this->wpdb->get_results($sql);
		}
	}
	
	private function load_recently_viewed() {
		
		//$user_id = $this->pio->get_user_id();
		$user_id = get_current_user_id();
		
		//$sql = "SELECT `object_id` FROM `wp_object_views` WHERE `user_id` = '".esc_sql($user_id)."' GROUP BY `object_id` ORDER BY `datetime` DESC LIMIT 4";
		$sql = 	"SELECT t1.object_id ".
				"FROM wp_object_views t1 ".
				"LEFT JOIN wp_object_views t2 ON (t1.object_id = t2.object_id AND t1.datetime < t2.datetime) ".
				"WHERE t2.datetime IS NULL and t1.`user_id` = '".esc_sql($user_id)."' and t1.post_id!=0 ".
				"ORDER BY t1.`datetime` DESC ".
				"LIMIT 4;";
				
		$recently_viewed = $this->wpdb->get_results($sql, ARRAY_N);
		
		if ($recently_viewed) {
			$r = array();
			foreach ($recently_viewed as $v) {
				$r []= $v[0];
			}
			
			$sql = "SELECT p.* FROM `wp_posts` p INNER JOIN `wp_postmeta` pm ON pm.`meta_key` = 'item_object_id' AND pm.`post_id` = p.`ID` "
				. "AND pm.`meta_value` IN ('"
					. implode('\',\'',$r)
				. "') "
				. "WHERE p.`post_status` = 'publish';";
			
			$this->recently_viewed = $this->wpdb->get_results($sql);
		}
	}
	
	private function load_recommendations() {
		
		
		$recommendations = $this->pio->get_recommendations(3);
	
		$recommended = array();
		
		if ($recommendations->itemScores) {
			
			foreach ($recommendations->itemScores as $item) {
				$recommended []= $item->item;
			}
		}
		
		$sql = "SELECT p.* FROM `wp_posts` p INNER JOIN `wp_postmeta` pm ON pm.`meta_key` = 'item_object_id' AND pm.`post_id` = p.`ID` "
			. "AND pm.`meta_value` IN ('".implode('\',\'',$recommended)."') "
			. "WHERE p.`post_status` = 'publish';";
		
		$this->recommendations = $this->wpdb->get_results($sql);
	}
}