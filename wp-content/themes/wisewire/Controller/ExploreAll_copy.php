<?php

class Controller_ExploreAllOLCOPY {

	protected $wpdb;
	protected $wp_query;

	public $grade;
	public $grades_ids;
	public $discipline;
	public $discipline_object;
	public $subdisciplines = array();

	public $filters_key;
	public $filter_content_types;
	public $filter_object_types;
	public $filter_standards;
	public $filter_contributors;
	public $filter_ranking;
	public $filter_dok;
	public $filter_grades;

	public $filters;
	public $order_by;

	public $posts_count = 0;
	public $page_nr;
	public $on_page;
	public $offset;
	public $pages_count;
	public $actual_on_page;

	public $list_view; // 'grid' or 'list';

	public $search = null;

	public $page = 'exploreall';

	public $cached_post_ids_by_meta_to_search = array();

	public function __construct($filters_key = null) {

		global $wpdb, $wp_query;

		$this->wpdb = $wpdb;
		$this->wp_query = $wp_query;

		// get query variables
		$this->grade = isset($this->wp_query->query['grade']) ? $this->wp_query->query['grade'] : 'middle';
		$this->discipline = isset($this->wp_query->query['discipline']) ? $this->wp_query->query['discipline'] : '';


		$this->filters_key = $filters_key ? $filters_key : $this->grade.';'.$this->discipline;

		// load discipline by $this->wp_query->query['discipline'];
		if ($this->discipline) {
			$sql = "SELECT * FROM {$this->wpdb->terms} WHERE `slug` = '".esc_sql($this->discipline)."' AND `api_type` = 'Discipline';";
			$this->discipline_object = $this->wpdb->get_row($sql);
		}

		$this->search = isset($this->wp_query->query['search']) ? urldecode($this->wp_query->query['search']) : false;

		// if discipline not found go back to explore page
		if ($this->page == 'exploreall' && !$this->discipline_object && $this->search === false) {
			wp_redirect( get_site_url().' /explore/'.$this->grade.'/');
		}




		// catch filters from ajax
		$this->catch_filters();

		/*if ($this->discipline_object) {
			$this->filters['discipline'] = array($this->discipline);
		}
		if ($this->grade) {
			$this->filters['grade'] = array($this->grade);
		}*/

		// load filters data
		$this->load_data_to_filters();

		$this->posts_count = $this->count_posts();

		$this->page_nr = isset($this->wp_query->query['page_nr']) ? $this->wp_query->query['page_nr'] : 1;
		$this->on_page = isset($_REQUEST['on_page']) ? $_REQUEST['on_page'] : 18;

		if ($this->posts_count > 0) {

			$this->pages_count = ceil($this->posts_count / $this->on_page);

			if ($this->page_nr < 1) {
				$this->page_nr = 1;
			}
			if ($this->page_nr > $this->pages_count) {
				$this->page_nr = $this->pages_count;
			}

			$this->offset = ( $this->page_nr - 1 ) * $this->on_page;

			if ( $this->posts_count > $this->offset + $this->on_page ) { # not last
				$this->actual_on_page = $this->on_page;
			} else if ( $this->offset > 0 ) { # last
				$this->actual_on_page = $this->posts_count % $this->offset;
			} else { # first
				$this->actual_on_page = $this->posts_count;
			}
		}
	}

	public function get_permalink() {
		if ($this->search !== false) {
			return get_site_url().'/explore/search/'.$this->search.'/';
		} else {
			return get_site_url().'/explore/'.$this->grade.'/'.$this->discipline.'/';
		}
	}

	/**
	 * Get SQL query for LO from WP database (POSTS)
	 * @param type $fields
	 * @param type $join
	 * @param type $where
	 * @param type $order_by
	 * @return string
	 */
	protected function get_query($fields, $join, $where, $order_by = '', $group_by = '') {

		if ($order_by === '') {
			switch ($this->order_by) {
				case 'most_recent':
					$order_by = 'm1.`meta_value` DESC';
					break;
				default:
					$order_by = 'm4.`meta_value` DESC';
			}
		}

		$sql = "SELECT ".$fields." "
			. "FROM {$this->wpdb->posts} p "
			. ' '.(is_array($join)?implode(' ',$join):$join) . " "
			. "WHERE p.`post_type` = 'item' " . ($where ? 'AND '.implode(' AND ',$where) : '') . " "
			. ( $group_by ? " GROUP BY ".$group_by : ( $group_by !== false ? " GROUP BY p.`ID` " : '' )) . " "
			. ( $order_by ? " ORDER BY ".$order_by : "" ) . " "
			. " ";

		return $sql;
	}

	/**
	 * Get SQL query for LO from API (PODS)
	 * @param type $fields
	 * @param type $join
	 * @param type $where
	 * @param type $order_by
	 * @return string
	 */
	protected function get_query_api($fields, $join, $where, $order_by = '', $group_by = '') {

		if ($order_by === '') {
			switch ($this->order_by) {
				case 'most_recent':
					$order_by = 'p.`created` DESC';
					break;
				default:
					$order_by = 'm4.`meta_value` DESC';
			}
		}

		$sql = "SELECT ".$fields." "
			. "FROM `wp_apicache_items` p "
			. ' '.(is_array($join)?implode(' ',$join):$join) . " "
			. ($where ? "WHERE ".implode(" AND ",$where) : '') . " "
			. ( $group_by ? " GROUP BY ".$group_by : ( $group_by !== false ? " GROUP BY p.`itemId` " : '' )) . " "
			. ( $order_by ? " ORDER BY ".$order_by : "" ) . " "
			. " ";

		return $sql;
	}

	public function count_posts() {

		$sum = 0;

		if ($this->search !== false && !$this->search) {
			return $sum;
		}

		$conditions = $this->get_filters();

		$sql = $this->get_query("COUNT(DISTINCT p.`ID`) AS `count`",
			$conditions['join'],
			$conditions['where'],
			false, false);

		$sql2 = $this->get_query_api("COUNT(DISTINCT p.`itemId`) AS `count`",
			$conditions['api']['join'],
			$conditions['api']['where'],
			false, false);

		if ($this->search !== false) {

			$results = $this->wpdb->get_row($sql);
			$results2 = $this->wpdb->get_row($sql2);

			$sum = $results ? $results->count : 0;
			$sum += $results2 ? $results2->count : 0;

		} else {

			$sum = wp_cache_get(md5($sql));

			if (!$sum) {

				$results = $this->wpdb->get_row($sql);
				$results2 = $this->wpdb->get_row($sql2);

				$sum = $results ? $results->count : 0;
				$sum += $results2 ? $results2->count : 0;

				wp_cache_set(md5($sql), $sum, '', 60);
			}
		}

		return $sum;
	}

	public function populate_posts() {


		if ($this->search !== false && !$this->search) {
			return false;
		}

		$conditions = $this->get_filters();

		$sql1 = $this->get_query("p.`ID`, "
			. "p.`post_author`, "
			. "p.`post_date`, "
			. "p.`post_title`, "
			. "p.`post_name`, "
			. "p.`post_type`, "
			. "(select IF(DATE(ipd.meta_value),DATE_FORMAT(ipd.meta_value,'%m/%d/%Y' ), DATE_FORMAT(STR_TO_DATE(ipd.meta_value,'%m/%d/%Y'),'%m/%d/%Y') ) from wp_postmeta ipd where ipd.post_id = p.ID and "
			. "ipd.meta_key = 'item_publish_date' limit 1) AS item_publish_date, "
			. "(select ipd.meta_value from wp_postmeta ipd where ipd.post_id = p.ID and "
			. "ipd.meta_key = 'item_content_type_icon' limit 1) AS item_content_type_icon, "
			. "(select ipd.meta_value from wp_postmeta ipd where ipd.post_id = p.ID and "
			. "ipd.meta_key = 'item_object_type' limit 1) AS item_object_type, "
			. "(select ipd.meta_value from wp_postmeta ipd where ipd.post_id = p.ID and "
			. "ipd.meta_key = 'item_ratings' limit 1) AS item_ratings, "
			. "(select ipd.meta_value from wp_postmeta ipd where ipd.post_id = p.ID and "
			. "ipd.meta_key = 'item_preview' limit 1) AS item_preview, "
			. "(select t.`name` from `wp_term_relationships` tr inner join `wp_terms` t "
			. "on t.`api_type` = 'Discipline' and t.`term_id` = tr.`term_taxonomy_id` "
			. "and t.`api_branch` = 2 where tr.`object_id` = p.`ID` limit 1) AS `subdiscipline`, "
			. "'' AS `previewURL`, "
			. "'item' AS `type`, "
			. "'CMS' as source, "
			. "'' as description ".$conditions['fields'],
			$conditions['join'],
			$conditions['where'],
			false);

		$sql2 = $this->get_query_api("p.`itemId` AS `ID`, "
			. "p.`userFullName` AS `post_author`, "
			. "p.`created` AS `post_date`, "
			. "p.`title` AS `post_title`, "
			. "'' AS `post_name`, "
			. "'pod' AS `post_type`, "
			. " DATE_FORMAT(p.`created`,'%m/%d/%Y') AS `item_publish_date`, "
			. "'Assessment' AS `item_content_type_icon`, "
			. "p.`itemType` AS `item_object_type`, "
			. "(select cm.meta_value from wp_apicache_meta cm where cm.itemId = p.itemId "
			. "and cm.meta_key = 'item_ratings' limit 1) AS item_ratings, "
			. "IF(`previewURL`!='','Y','N') AS `item_preview`, "
			. "(select t.`name` from `wp_apicache_categories` tr inner join `wp_terms` t "
			. "on t.`api_type` = 'Discipline' and t.`term_id` = tr.`categoryId` and "
			. "t.`api_branch` = 2 where tr.`itemId` = p.`itemId` limit 1 ) AS `subdiscipline`, "
			. "`previewURL`, "
			. "'pod' AS `type`, "
			. "'PLATFORM' as source, "
			. "p.description ".$conditions['api']['fields'],
			$conditions['api']['join'],
			$conditions['api']['where'],
			false,
			false
		);

		switch ($this->order_by) {
			case 'most_recent':
				$order_by = 'STR_TO_DATE(x.`item_publish_date`,"%m/%d/%Y") DESC';
				break;
			default:
				if ($this->search !== false) {
					$order_by = 'x.`rank_weight` DESC, x.`item_ratings` DESC';
				} else {
					$order_by = 'x.`item_ratings` DESC';
				}
		}

		$sql = "SELECT * FROM ($sql1 UNION $sql2) AS x ORDER BY $order_by LIMIT ".(int)$this->offset.", ".$this->on_page.";";



		$results = $this->wpdb->get_results($sql);

		return $results;
	}

	protected function get_filters($base = false) {

		$conditions = array(
			'fields' => '',
			'where' => array(),
			'join' => array(),
			'api' => array(
				'fields' => '',
				'join' => array(),
				'where' => array()
			)
		);

		if ($this->grade && $this->search === false) {
			$this->grades_ids = Controller_WiseWireItems::GetGradesIds($this->grade);

			$conditions ['join'] []= "INNER JOIN {$this->wpdb->term_relationships} trg ON trg.`object_id` = p.`ID` AND trg.`term_taxonomy_id` IN (" . implode( ',', $this->grades_ids ) . ") ";
			$conditions ['api']['join'] []= "INNER JOIN `wp_apicache_categories` trg ON trg.`itemId` = p.`itemId` AND trg.`categoryId` IN (" . implode( ',', $this->grades_ids ) . ") ";
		}

		if ($this->discipline_object) {
			$conditions['join'] []= "INNER JOIN {$this->wpdb->term_relationships} f ON f.`object_id` = p.`ID` AND f.`term_taxonomy_id` = ".(int)$this->discipline_object->term_id."";
			$conditions['api']['join'] []= "INNER JOIN `wp_apicache_categories` f ON f.`itemId` = p.`itemId` AND f.`categoryId` = ".(int)$this->discipline_object->term_id."";
		}

		$conditions['where'] []= 'p.`post_status` = \'publish\'';

		if ($this->filters && $base === false) {

			$i = 0;

			foreach ($this->filters as $name => $values) {

				if ($name === 'standard' || $name === 'subdiscipline' || $name === 'gradelevel') {

					foreach ($values as $value) {
						$conditions ['join'] []= "INNER JOIN {$this->wpdb->term_relationships} f$i ON f$i.`object_id` = p.`ID` AND f$i.`term_taxonomy_id` = ".(int)$value."";
						$conditions ['api']['join'] []= "INNER JOIN `wp_apicache_categories` f$i ON f$i.`itemId` = p.`itemId` AND f$i.`categoryId` = ".(int)$value."";
						$i ++;
					}

				} else if ($name === 'object_type') {

					foreach ($values as $value) {
						$conditions ['join'] []= "INNER JOIN {$this->wpdb->term_relationships} f$i ON f$i.`object_id` = p.`ID` AND f$i.`term_taxonomy_id` = ".(int)$value."";
						$conditions ['api']['where'] []= '1=0';
						$i ++;
					}

				} else if ($name === 'content_type') {

					foreach ($values as $value) {
						$conditions ['join'] []= "INNER JOIN {$this->wpdb->postmeta} f$i ON f$i.`post_id` = p.`ID` AND f$i.`meta_key` = 'item_content_type_icon' AND f$i.`meta_value` = '".esc_sql($value)."'";
						$conditions ['api']['where'] []= "'Assessment' = '".esc_sql($value)."'";
						$i ++;
					}
					/*
					 * $s = array();
					foreach ($values as $value) {
						$s []= '\''.esc_sql($value).'\'';
					}

					$conditions ['join'] []= "INNER JOIN {$this->wpdb->postmeta} f$i ON f$i.`post_id` = p.`ID` AND f$i.`meta_key` = 'item_content_type_icon' AND f$i.`meta_value` IN (".implode(',',$s).")";
					 */

				} else if ($name == 'ranking') {

					foreach ($values as $value) {
						$conditions ['join'] []= "LEFT JOIN {$this->wpdb->postmeta} f$i ON (f$i.`post_id` = p.`ID` AND f$i.`meta_key` = 'item_ratings') ";//.($value == 0 ? " OR f$i.`meta_value` IS NULL" : "")."";
						$conditions ['where'] []= "ROUND(IFNULL(f$i.`meta_value`,0)) = '".esc_sql($value)."'";
						$i ++;
						$conditions ['api']['join'] []= "LEFT JOIN `wp_apicache_meta` f$i ON (f$i.`itemId` = p.`itemId` AND f$i.`meta_key` = 'item_ratings')";//.($value == 0 ? " OR f$i.`meta_value` IS NULL" : "")."";
						$conditions ['api']['where'] []= "ROUND(IFNULL(f$i.`meta_value`,0)) = '".esc_sql($value)."'";
						$i ++;
					}

				} else if ($name == 'contributor') {

					foreach ($values as $value) {
						$conditions ['join'] []= "INNER JOIN {$this->wpdb->postmeta} f$i ON f$i.`post_id` = p.`ID` AND f$i.`meta_key` = 'item_contributor' AND f$i.`meta_value` = '".esc_sql($value)."'";
						$conditions ['api']['where'] []= "p.`userFullName` = '".esc_sql($value)."'";
						$i ++;
					}
				} else if ($name == 'dok') {

					foreach ($values as $value) {
						$conditions ['join'] []= "INNER JOIN {$this->wpdb->postmeta} f$i ON f$i.`post_id` = p.`ID` AND f$i.`meta_key` = 'item_dok' AND f$i.`meta_value` = '".esc_sql($value)."'";
						$conditions ['api']['where'] []= '1=0';
						$i ++;
					}
				}

				$i ++;
			}
		}

		/*

		if( $_SESSION['show_view_all_grades'] ){

			if (!isset($this->filters["gradelevel"])) {
				$this->filters["gradelevel"] = array();
			}
			$grades_ids_filter_view_all = Controller_WiseWireItems::GetGradesIds($this->grade);
			foreach ($grades_ids_filter_view_all as $value) {
				if($value != "15319"){
					$this->filters["gradelevel"][ ] = (string)$value;
				}
			}
			$this->filters["gradelevel"] = array_unique($this->filters["gradelevel"]);

			$_SESSION['show_view_all_grades'] = false;
		}*/


		$conditions['fields'] .=
			", '' AS `level1_label`, "
			. " '' AS `level2_label`, "
			. " '' AS `level3_label`, "
			. " '' AS `description_label`, "
			. " '' AS `code_label` ";

		$conditions['api']['fields'] .=
			" ,  pitl.`dis_level1` AS `level1_label`, "
			. "pitl.`cc_level2` AS `level2_label`, "
			. "pitl.`cc_level3` AS `level3_label`, "
			. "p.`description` AS `description_label`, "
			. "pitl.`cc_code` AS `code_label` ";

		$conditions['api']['join'][] = "LEFT JOIN `platform_item_tile_info` pitl on pitl.itemId = p.itemId ";

		if ($this->search !== false) {

			if (!$this->cached_post_ids_by_meta_to_search) {
				$sql = "SELECT `post_id` FROM `wp_postmeta` WHERE `meta_key` IN ('item_license_type','item_long_description','item_language','item_demo_subhead','item_read_more','item_contributor') AND `meta_value` LIKE '%".esc_sql($this->search)."%';";
				$cached_post_ids_by_meta_to_search = $this->wpdb->get_results($sql,ARRAY_N);
				if ($cached_post_ids_by_meta_to_search) {
					foreach ($cached_post_ids_by_meta_to_search as $v) {
						$this->cached_post_ids_by_meta_to_search []= $v[0];
					}
				}
			}


			$conditions['join'][] = " LEFT JOIN `wp_term_relationships` tagr ON tagr.`object_id` = p.`ID` "
				. "LEFT JOIN `wp_terms` tag ON tag.`term_id` = tagr.`term_taxonomy_id` "
				//. "RIGHT JOIN `wp_postmeta` long_desc ON long_desc.`post_id` = p.`ID` AND long_desc.`meta_key` IN ('item_license_type','item_long_description','item_language','item_demo_subhead','item_read_more','item_contributor') "
				//. "AND long_desc.`meta_value` LIKE '%".esc_sql($this->search)."%' "
				//  . "LEFT JOIN `wp_postmeta` read_more ON read_more.`post_id` = p.`ID` AND read_more.`meta_key` = 'item_read_more' "
				//  . "LEFT JOIN `wp_postmeta` license_type ON license_type.`post_id` = p.`ID` AND license_type.`meta_key` = 'item_license_type' "
			;

			$conditions['fields'] .= ", IF(tag.`name` LIKE '%".esc_sql($this->search)."%',1,0) AS `rank_weight`";

			$where_or = array();
			$where_or []= "p.`post_title` LIKE '%".esc_sql($this->search)."%' ".($this->cached_post_ids_by_meta_to_search ? "OR p.`ID` IN (".implode(',',$this->cached_post_ids_by_meta_to_search).")":"")."";
			$where_or []= "tag.`name` LIKE '%".esc_sql($this->search)."%'";
			//$where_or []= "long_desc.`meta_value` IS NOT NULL ";
			//$where_or []= "read_more.`meta_value` LIKE '%".esc_sql($this->search)."%'";
			//$where_or []= "license_type.`meta_value` LIKE '%".esc_sql($this->search)."%'";

			$conditions['where'][] = '('.implode(' OR ',$where_or).')';




			$where_or = array();
			$where_or []= "p.`title` LIKE '%".esc_sql($this->search)."%'";
			$where_or []= "p.`userFullName` LIKE '%".esc_sql($this->search)."%'";
			$where_or []= "exists(select * from `wp_apicache_tags` tag where tag.`itemId` = p.`itemId` and tag.`tag` LIKE '%".esc_sql($this->search)."%')";
			$where_or []= "p.`description` LIKE '%".esc_sql($this->search)."%'";
			$where_or []= "pitl.`dis_level1` LIKE '%".esc_sql($this->search)."%'";
			$where_or []= "pitl.`cc_level2` LIKE '%".esc_sql($this->search)."%'";
			$where_or []= "pitl.`cc_level3` LIKE '%".esc_sql($this->search)."%'";
			$where_or []= "pitl.`cc_code` LIKE '%".esc_sql($this->search)."%'";




			$conditions['api']['where'][] = '('.implode(' OR ',$where_or).')';

			$conditions['api']['fields'] .= ", (case when exists(select * from `wp_apicache_tags` tag where tag.`itemId` = p.`itemId` and tag.`tag` LIKE '%".esc_sql($this->search)."%') then 1 else 0 end) AS `rank_weight`";

		}

		//f_print_r($conditions);

		return $conditions;
	}

	public function catch_filters() {

		if ($this->search !== false) {
			if ($_SESSION['exploreall_search'] != $this->search || isset($_REQUEST['clear_filters'])) {
				$_SESSION['exploreall_filters'] = array();
			}
			$_SESSION['exploreall_search'] = $this->search;
		} else if (isset($_REQUEST['clear_filters'])) {
			$_SESSION['exploreall_filters'] = array();
		}

		$this->list_view = isset($_COOKIE['exploreall_list_view']) ? $_COOKIE['exploreall_list_view'] : 'grid';

		// catch list view
		/*if (isset($_REQUEST['list_view'])) {
			$this->list_view = $_SESSION['exploreall_list_view'] = $_REQUEST['list_view'];
		}*/

		$this->filters = isset($_SESSION['exploreall_filters'][$this->filters_key]) ? $_SESSION['exploreall_filters'][$this->filters_key] : array();
		$this->order_by = isset($_SESSION['exploreall_orderby']) ? $_SESSION['exploreall_orderby'] : array();

		// catch order by
		if (isset($this->order_by)) {
			$this->order_by = $_SESSION['exploreall_orderby'] = $_REQUEST['order_by'];
		}

		// catch new filter
		if (isset($_REQUEST['filter'])) {

			$fname = $_REQUEST['filter'];
			$fval = $_REQUEST['filter_value'];

			if (!isset($this->filters[$fname])) {
				$this->filters[$fname] = array();
			}

			$this->filters[$fname][ ] = $fval;
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

		if( !isset($_REQUEST['filter']) && !isset($_REQUEST['filter_remove']) && !isset($_POST['filter']) ) {

			if( !isset($_SESSION['exploreall_filters'])  && $this->search === false ){

				if (!isset($this->filters["gradelevel"])) {
					$this->filters["gradelevel"] = array();
				}
				$grades_ids_filter_view_all = Controller_WiseWireItems::GetGradesIds($this->grade);
				foreach ($grades_ids_filter_view_all as $value) {
					if($value != "15319"){
						$this->filters["gradelevel"][ ] = (string)$value;
					}
				}
				$this->filters["gradelevel"] = array_unique($this->filters["gradelevel"]);

			}


		}

		$_SESSION['exploreall_filters'][$this->filters_key] = $this->filters;
	}

	public function filter_requested($filter) {
		return isset($_POST['filter']) && $_POST['filter'] === $filter;
	}

	public function display_active_filters() {

		$s = '';

		if ($this->filters) {
			foreach ($this->filters as $name => $values) {
				if ($values) {
					foreach ($values as $value) {
						if ($name === 'standard') {
							$title = $this->find_standard_name($value);
						} else if ($name === 'subdiscipline') {
							$title = $this->find_subdiscipline_name($value);
						} else if ($name === 'gradelevel') {
							var_dump($value);
							$title = $this->find_gradelevel_name($value);
							echo $title."<br>";
						} else if ($name === 'object_type') {
							$title = $this->find_object_type_name($value);
						} else if ($name === 'discipline' || $name === 'grade') {
							continue;
						} else if ($name === 'ranking') {
							$title = 'RATING: '.(int)$value;
						} else if ($name === 'dok') {
							$title = 'DOK: '.$value;
						} else {
							$title = $value;
						}
						$s .= '<li><a href="#'.$value.'" data-filter="'.$name.'" class="filter-remove">'.$title.'</a></li>';
					}
				}
			}
		}

		die();
		return $s;
	}

	protected function find_gradelevel_name($id) {
		$name = '';
		if ($this->filter_grades) {
			foreach ($this->filter_grades as $grades) {
				if (is_array($grades)) {
					foreach ($grades as $v) {
						if (isset($v['term_id']) && $v['term_id'] === $id) {
							$name = $v['name'];
							break;
						}
					}
				}

			}
		}
		return $name;
	}

	protected function find_object_type_name($id) {
		$name = '';
		if ($this->filter_object_types) {
			foreach ($this->filter_object_types as $v) {
				if ($v['term_id'] === $id) {
					$name = $v['name'];
					break;
				}
			}
		}
		return $name;
	}

	protected function find_standard_name($id) {
		$name = '';
		if ($this->filter_standards) {
			foreach ($this->filter_standards as $v) {
				if ($v['term_id'] === $id) {
					$name = $v['name'];
					break;
				}
			}
		}
		return $name;
	}

	protected function find_subdiscipline_name($id) {
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

	protected function load_subdisciplines($c, $discipline_id) {

		$c['join'] []= "INNER JOIN {$this->wpdb->term_relationships} r ON r.`object_id` = p.`ID`";
		$c['join'] []= "LEFT JOIN {$this->wpdb->term_taxonomy} tt ON tt.`term_taxonomy_id` = r.`term_taxonomy_id` ";
		$c['join'] []= "LEFT JOIN {$this->wpdb->terms} t ON t.`term_id` = tt.`term_id` ";
		$c['where'] []= ($this->search !== false ? "" : "tt.`parent` = ".(int)$discipline_id." AND ")." t.`api_type` = 'Discipline' ";
		$sql1 = $this->get_query("t.`name`, t.`term_id`, COUNT(DISTINCT p.`ID`) AS `count`", $c['join'], $c['where'], false, "t.`name` ASC");

		$c['api']['join'] []= "INNER JOIN `wp_apicache_categories` r ON r.`itemId` = p.`itemId`";
		$c['api']['join'] []= "LEFT JOIN {$this->wpdb->term_taxonomy} tt ON tt.`term_taxonomy_id` = r.`categoryId` ";
		$c['api']['join'] []= "LEFT JOIN {$this->wpdb->terms} t ON t.`term_id` = tt.`term_id` ";
		$c['api']['where'] []= ($this->search !== false ? "" : "tt.`parent` = ".(int)$discipline_id." AND ")." t.`api_type` = 'Discipline' ";
		$sql2 = $this->get_query_api("t.`name`, t.`term_id`, COUNT(DISTINCT p.`itemId`) AS `count`", $c['api']['join'], $c['api']['where'],false,"t.`name` ASC");

		$sql = "SELECT x.`name`, x.`term_id`, SUM(x.`count`) AS `count` FROM (" . $sql1 . " UNION " . $sql2 . ") AS x WHERE x.`name` != '' GROUP BY x.`name` ASC;";

		$subdisciplines = wp_cache_get('subdisciplines_'.md5($sql));

		if (!$subdisciplines) {
			$subdisciplines = $this->wpdb->get_results($sql, ARRAY_A);
			wp_cache_set('subdisciplines_'.md5($sql), $subdisciplines, '', 3600);
		}

		$this->subdisciplines = $subdisciplines;
	}

	protected function load_content_types($c, $discipline_id) {

		$c ['join'] []= "LEFT JOIN `wp_postmeta` pm ON pm.`post_id` = p.`ID` AND pm.`meta_key` = 'item_content_type_icon' AND pm.`meta_value` != ''";
		$sql1 = $this->get_query('pm.`meta_value` AS `value`, COUNT(DISTINCT p.`ID`) AS `count`',$c['join'],$c['where'],false,'pm.`meta_value` ASC');

		$sql2 = $this->get_query_api('\'Assessment\' AS `value`, COUNT(DISTINCT p.`itemId`) AS `count`',$c['api']['join'],$c['api']['where'],false,false);

		$sql = "SELECT x.`value`, SUM(x.`count`) AS `count` FROM (" . $sql1 . " UNION " . $sql2 . ") AS x WHERE x.`value` != '' AND x.`count` > 0 GROUP BY x.`value` ASC;";

		$filter_content_types = wp_cache_get('filter_content_types_'.md5($sql));

		if (!$filter_content_types) {

			$filter_content_types = $this->wpdb->get_results($sql, ARRAY_A);
			wp_cache_set('filter_content_types_'.md5($sql), $filter_content_types, '', 3600);
		}

		$this->filter_content_types = $filter_content_types;
	}

	protected function load_object_types($c, $discipline_id) {

		$c['join'] []= "INNER JOIN {$this->wpdb->term_relationships} r ON r.`object_id` = p.`ID`";
		$c['join'] []= "INNER JOIN {$this->wpdb->term_taxonomy} tt ON tt.`term_taxonomy_id` = r.`term_taxonomy_id` AND tt.`taxonomy` = 'ObjectType'";
		$c['join'] []= "LEFT JOIN {$this->wpdb->terms} t ON t.`term_id` = tt.`term_id` ";
		$sql = $this->get_query("t.`name`, t.`term_id`, COUNT(DISTINCT p.`ID`) AS `count`", $c['join'], $c['where'],'1','t.`name` ASC');

		$filter_object_types = wp_cache_get('filter_object_types_'.md5($sql));

		if (!$filter_object_types) {
			$filter_object_types = $this->wpdb->get_results($sql, ARRAY_A);
			wp_cache_set('filter_object_types_'.md5($sql), $filter_object_types, '', 3600);
		}
		$this->filter_object_types = $filter_object_types;
	}

	protected function load_ranking($c, $discipline_id) {

		$c ['join'] []= "LEFT JOIN `wp_postmeta` pm ON pm.`post_id` = p.`ID` AND pm.`meta_key` = 'item_ratings' AND pm.`meta_value` != ''";
		$sql1 = $this->get_query('ROUND(pm.`meta_value`) AS `value`, COUNT(DISTINCT p.`ID`) AS `count`',$c['join'],$c['where'],false,'ROUND(pm.`meta_value`) ASC');

		$c ['api']['join'] []= "LEFT JOIN `wp_apicache_meta` pm ON pm.`itemId` = p.`itemId` AND pm.`meta_key` = 'item_ratings' AND pm.`meta_value` != ''";
		$sql2 = $this->get_query_api('ROUND(pm.`meta_value`,0) AS `value`, COUNT(DISTINCT p.`itemId`) AS `count`',$c['api']['join'],$c['api']['where'],false,'ROUND(pm.`meta_value`) ASC');

		$sql = "SELECT x.`value`, SUM(x.`count`) AS `count` FROM (" . $sql1 . " UNION " . $sql2 . ") AS x WHERE x.`count` > 0 GROUP BY x.`value` DESC;";

		$filter_ranking = wp_cache_get('filter_ranking_'.md5($sql));

		if (!$filter_ranking) {
			$filter_ranking = $this->wpdb->get_results($sql, ARRAY_A);
			wp_cache_set('filter_ranking_'.md5($sql), $filter_ranking, '', 3600);
		}
		$this->filter_ranking = $filter_ranking;
	}

	protected function load_standards($c, $discipline_id) {

		$c['join'] []= "INNER JOIN {$this->wpdb->term_relationships} r ON r.`object_id` = p.`ID`";
		$c['join'] []= "INNER JOIN {$this->wpdb->term_taxonomy} tt ON tt.`term_taxonomy_id` = r.`term_taxonomy_id` AND tt.`taxonomy` = 'Standards'";
		$c['join'] []= "LEFT JOIN {$this->wpdb->terms} t ON t.`term_id` = tt.`term_id` ";
		$sql = $this->get_query("t.`name`, t.`term_id`, COUNT(DISTINCT p.`ID`) AS `count`", $c['join'], $c['where'],'1','t.`name` ASC');

		$filter_standards = wp_cache_get('filter_standards_'.md5($sql));

		if (!$filter_standards) {
			$filter_standards = $this->wpdb->get_results( $sql, ARRAY_A);
			wp_cache_set('filter_standards_'.md5($sql), $filter_standards, '', 3600);
		}
		$this->filter_standards = $filter_standards;
	}

	protected function load_contributors($c, $discipline_id) {

		$c ['join'] []= "LEFT JOIN `wp_postmeta` pm ON pm.`post_id` = p.`ID` AND pm.`meta_key` = 'item_contributor' AND pm.`meta_value` != ''";
		$sql1 = $this->get_query('pm.`meta_value` AS `value`, COUNT(DISTINCT p.`ID`) AS `count` ',$c['join'],$c['where'],false,'pm.`meta_value` ASC');

		$sql2 = $this->get_query_api('`userFullName` AS `value`, COUNT(DISTINCT p.`itemId`) AS `count` ',$c['api']['join'],$c['api']['where'],false,'`userFullName` ASC');

		$sql = "SELECT x.`value`, SUM(x.`count`) AS `count` FROM (" . $sql1 . " UNION " . $sql2 . ") AS x WHERE x.`count` > 0 AND x.`value` != '' GROUP BY x.`value` ORDER BY TRIM(x.`value`);";

		$filter_contributors = wp_cache_get('filter_contributors_'.md5($sql));

		if (!$filter_contributors) {
			$filter_contributors = $this->wpdb->get_results($sql, ARRAY_A);
			wp_cache_set('filter_contributors_'.md5($sql), $filter_contributors, '', 3600);
		}
		$this->filter_contributors = $filter_contributors;
	}

	protected function load_dok($c, $discipline_id) {

		$c ['join'] []= "LEFT JOIN `wp_postmeta` pm ON pm.`post_id` = p.`ID` AND pm.`meta_key` = 'item_dok' AND pm.`meta_value` != ''";
		$c ['where'] []= 'pm.`meta_value` != \'\'';
		$sql = $this->get_query('pm.`meta_value` AS `value`, COUNT(DISTINCT p.`ID`) AS `count` ',$c['join'],$c['where'],false,'pm.`meta_value` ASC');

		//$sql2 = $this->get_query_api('`userFullName` AS `value`, COUNT(DISTINCT p.`itemId`) AS `count` ',$c['api']['join'],$c['api']['where'],false,'`userFullName` ASC');

		//$sql = "SELECT x.`value`, SUM(x.`count`) AS `count` FROM (" . $sql1 . " UNION " . $sql2 . ") AS x WHERE x.`count` > 0 AND x.`value` != '' GROUP BY x.`value` DESC;";

		$filter_dok = wp_cache_get('filter_dok_'.md5($sql));

		if (!$filter_dok) {
			$filter_dok = $this->wpdb->get_results($sql, ARRAY_A);
			wp_cache_set('filter_dok_'.md5($sql), $filter_dok, '', 3600);
		}
		$this->filter_dok = $filter_dok;
	}

	protected function load_grades($c) {

		$c['join'] []= "INNER JOIN {$this->wpdb->term_relationships} r ON r.`object_id` = p.`ID`";
		$c['join'] []= "LEFT JOIN {$this->wpdb->term_taxonomy} tt ON tt.`term_taxonomy_id` = r.`term_taxonomy_id` ";
		$c['join'] []= "INNER JOIN {$this->wpdb->terms} t ON t.`term_id` = r.`term_taxonomy_id` AND t.`api_type` = 'Student Level' AND t.`api_branch` = 2 ";
		//$c['where'] []= "  ";
		$sql1 = $this->get_query("t.`name`, t.`term_id`, tt.`parent`, COUNT(DISTINCT p.`ID`) AS `count`", $c['join'], $c['where'], false, "t.`name` ASC");

		$c['api']['join'] []= "INNER JOIN `wp_apicache_categories` r ON r.`itemId` = p.`itemId`";
		$c['api']['join'] []= "LEFT JOIN {$this->wpdb->term_taxonomy} tt ON tt.`term_taxonomy_id` = r.`categoryId` ";
		$c['api']['join'] []= "INNER JOIN {$this->wpdb->terms} t ON t.`term_id` = r.`categoryId` AND t.`api_type` = 'Student Level' AND t.`api_branch` = 2 ";
		//$c['api']['where'] []= "  ";
		$sql2 = $this->get_query_api("t.`name`, t.`term_id`, tt.`parent`, COUNT(DISTINCT p.`itemId`) AS `count`", $c['api']['join'], $c['api']['where'],false,"t.`name` ASC");

		$sql = "SELECT x.`name`, x.`term_id`, x.`parent`, SUM(x.`count`) AS `count` FROM (" . $sql1 . " UNION " . $sql2 . ") AS x WHERE x.`name` != '' GROUP BY x.`name` ORDER BY 4 DESC;";
		//echo $sql;
		$grades = wp_cache_get('grades_'.md5($sql));

		if (!$grades) {
			$grades = $this->wpdb->get_results($sql, ARRAY_A);
			wp_cache_set('grades_'.md5($sql), $grades, '', 3600);
		}

		$filter_grades = array(
			'' => array(
				'elementary' => array(
					'name' => 'Elementary',
					'count' => 0,
					'open' => false
				),
				'middle' => array(
					'name' => 'Middle',
					'count' => 0,
					'open' => false
				),
				'high-school' => array(
					'name' => 'High School',
					'count' => 0,
					'open' => false
				),
				'higher-education' => array(
					'name' => 'Higher Education',
					'count' => 0,
					'open' => false
				)
			)
		);
		foreach ($grades as $grade) {

			$parent_grade_name = Controller_WiseWireItems::GetGradeName(array($grade['term_id']));
			$filter_grades [$parent_grade_name] [$grade['term_id']]= $grade;
			$filter_grades [''][$parent_grade_name]['count'] += $grade['count'];

			if (isset($this->filters['gradelevel']) && in_array($grade['term_id'], $this->filters['gradelevel'])) {
				$filter_grades [''][$parent_grade_name]['open'] = true;
			}
		}

		$filter_grades[''] = f_sort_by_sub_value($filter_grades[''],'count',false,true);

		foreach ($filter_grades[''] as $k => $v) {
			if ($v['count'] == 0) {
				unset($filter_grades[''][$k]);
			}
		}


		$this->filter_grades = $filter_grades;

		//f_print_r($filter_grades);
	}

	protected function load_data_to_filters() {

		if ($this->search !== false && !$this->search) {
			return false;
		}

		$conditions = $this->get_filters(); // $this->search ? false : true

		$discipline_id = $this->discipline_object ? $this->discipline_object->term_id : '0';

		$this->load_subdisciplines($conditions, $discipline_id);

		$this->load_content_types($conditions, $discipline_id);

		$this->load_object_types($conditions, $discipline_id);

		$this->load_ranking($conditions, $discipline_id);

		$this->load_standards($conditions, $discipline_id);

		$this->load_contributors($conditions, $discipline_id);

		$this->load_dok($conditions, $discipline_id);

		//if ($this->search !== false || $this->page == 'mostviewed') {
		$this->load_grades($conditions);
		//}
	}
}