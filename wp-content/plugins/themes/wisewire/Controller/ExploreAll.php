<?php

class Controller_ExploreAll {
	
	private $wpdb;
	private $wp_query;
	
	public $grade;
	public $discipline;
	public $discipline_object;
	public $subdisciplines = array();
	
	public $filter_content_types;
	public $filter_object_types;
	public $filter_standards;
	public $filter_contributors;
	
	public $filters;
	
	public function __construct() {
		
		global $wpdb, $wp_query;
		
		$this->wpdb = $wpdb;
		$this->wp_query = $wp_query;
		
		// get query variables
		$this->grade = isset($this->wp_query->query['grade']) ? $this->wp_query->query['grade'] : 'elementary';
		$this->discipline = isset($this->wp_query->query['discipline']) ? $this->wp_query->query['discipline'] : '';

		// load discipline by $this->wp_query->query['discipline'];
		$sql = "SELECT * FROM {$this->wpdb->terms} WHERE `slug` = '".esc_sql($this->discipline)."' AND `api_type` = 'Discipline';";
		$this->discipline_object = $this->wpdb->get_row($sql);

		// if discipline not found go back to explore page
		if (!$this->discipline_object) {
			wp_redirect( get_site_url().'/explore/'.$this->grade.'/');
		} 
		
		// load filters data
		$this->load_data_to_filters();
		
		$this->catch_filters();
	}
	
	public function populate_posts() {
		
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
			//. "LEFT JOIN {$this->wpdb->term_relationships} tr ON tr.`object_id` = p.`ID` "
			//. "LEFT JOIN {$this->wpdb->term_taxonomy} tt ON tr.`term_taxonomy_id` = tr.`term_taxonomy_id` "
			. "WHERE p.`post_type` = 'item' "
			. "GROUP BY p.`ID`;";
			
			//GROUP_CONCAT(tt.`term_id`)
			
		$results = $this->wpdb->get_results($sql);
		
		return $results;
	}
	
	public function catch_filters() {

		$this->filters = isset($_SESSION['exploreall_filters']) ? $_SESSION['exploreall_filters'] : array();
		
		// catch new filter
		if (isset($_REQUEST['filter'])) {
			
			$fname = $_REQUEST['filter'];
			$fval = $_REQUEST['filter_value'];
			
			if (!isset($this->filters[$fname])) {
				$this->filters[$fname] = array();
			}
			
			$this->filters[$fname][] = $fval;
			$this->filters[$fname] = array_unique($this->filters[$fname]);
		}
		
		// remove filter
		if (isset($_REQUEST['filter_remove'])) {
			$fname = $_REQUEST['filter_remove'];
			$fval = $_REQUEST['filter_value'];
			
			if (isset($this->filters[$fname])) { 
				
				$index = array_search($fval, $this->filters[$fname]);
				// remove value
				unset($this->filters[$fname][$index]);
			}
		}
		
		$_SESSION['exploreall_filters'] = $this->filters;
	}
	
	public function display_active_filters() {
		
		if ($this->filters) {
			foreach ($this->filters as $name => $values) {
				if ($values) {
					foreach ($values as $value) {
						if ($name === 'standard') {
							$title = $this->find_standard_name($value);
						} else if ($name === 'subdiscipline') {
							$title = $this->find_subdiscipline_name($value);
						} else {
							$title = $value;
						}
						echo '<li><a href="#'.$value.'" data-filter="'.$name.'" class="filter-remove">'.$title.'</a></li>';
					}
				}
			}
		}
	}
	
	private function find_standard_name($id) {
		$name = '';
		if ($this->filter_standards) {
			foreach ($this->filter_standards as $v) {
				if ($v['term_id'] === $id) {
					$name = $v['value'];
					break;
				}
			}
		}
		return $name;
	}
	
	private function find_subdiscipline_name($id) {
		$name = '';
		if ($this->subdisciplines) {
			foreach ($this->subdisciplines as $v) {
				if ($v['term_id'] === $id) {
					$name = $v['name'];
					break;
				}
			}
		}
		return $name;
	}
	
	private function load_data_to_filters() {
		
		// load subdisciplines
		$sql = "SELECT t.`name`, t.`term_id`, (SELECT COUNT(*) FROM {$this->wpdb->term_relationships} r WHERE r.`term_taxonomy_id` = tt.`term_taxonomy_id`) AS `count` FROM {$this->wpdb->term_taxonomy} tt "
			. "LEFT JOIN {$this->wpdb->terms} t ON t.`term_id` = tt.`term_id` "
			. "WHERE tt.`parent` = ".(int)$this->discipline_object->term_id." ORDER BY t.`name` ASC;";
		$this->subdisciplines = $this->wpdb->get_results($sql, ARRAY_A);
		
		// load content types
		$this->filter_content_types = $this->wpdb->get_results("SELECT `meta_value` AS `value`, COUNT(*) AS `count` FROM `wp_postmeta` WHERE `meta_key` = 'item_content_type_icon' AND `meta_value` != '' GROUP BY `meta_value` ASC;", ARRAY_A);
		
		// load object types
		$this->filter_object_types = $this->wpdb->get_results("SELECT `meta_value` AS `value`, COUNT(*) AS `count` FROM `wp_postmeta` WHERE `meta_key` = 'item_object_type' AND `meta_value` != '' GROUP BY `meta_value` ASC;", ARRAY_A);
		
		// load standards
		$sql = "SELECT t.`name` AS `value`, t.`term_id`, "
			. "(SELECT COUNT(*) FROM `wp_term_relationships` tr WHERE tr.`term_taxonomy_id` = tt.`term_taxonomy_id`) AS `count` "
			. "FROM `wp_terms` t "
			. "LEFT JOIN `wp_term_taxonomy` tt ON tt.`term_id` = t.`term_id` "
			. "WHERE t.`api_type` = 'Common Core' AND tt.`parent` = 0 GROUP BY t.`name`";
		$this->filter_standards = $this->wpdb->get_results( $sql, ARRAY_A);
		
		// load contributors
		$sql = "SELECT x.`value`,x.`count` FROM (SELECT `meta_value` AS `value`, COUNT(*) AS `count` "
			. "FROM `wp_postmeta` "
			. "WHERE `meta_key` = 'item_contributor' AND `meta_value` != '' "
			. "GROUP BY `meta_value` ASC "
			. "UNION "
			. "SELECT ai.`userFullName` AS `value`, COUNT(*) FROM `wp_apicache_items` ai "
			. "WHERE ai.`userFullName` != '' GROUP BY ai.`userFullName` ASC) AS x ORDER BY x.`value` ASC";
		$this->filter_contributors = $this->wpdb->get_results( $sql, ARRAY_A );
	}
}