<?php

/**
 * Implement learning objects placeholders and colors
 */
class Controller_WiseWireItems {

	private $wpdb;

	private $types = array();
	private $icons = array();
	private $placeholders = array();
	private $map_subdisciplines = array();
	private $map_openstax_titles = array();

	public static $grade_name = 'middle';

  public static $subgrade_id = 0;

  private static $grades = array(
		'elementary' => array(
			15319 => 'Pre-K',
			15320 => 'kindergarden',
			15321 => 'first',
			15322 => 'second',
			15323 => 'third',
			15324 => 'fourth',
			15325 => 'fifth',
		),
		'middle' => array(
			15326 => 'sixth',
			15327 => 'seventh',
			15328 => 'eighth',
		),
		'high-school' => array(
			15330 => 'ninth',
			15331 => 'tenth',
			15332 => 'eleventh',
			15333 => 'twelfth',
		),
		'higher-education' => array(
			15335 => 'undergraduate',
			15336 => 'graduate'
		)
	);

	private static $gradesLabels = array(
		15329 => "HIGH SCHOOL",
		15332 => "Eleventh Grade",
		15330 => "Ninth Grade",
		15331 => "Tenth Grade ",
		15333 => "Twelfth Grade ",
		15334 => "HIGHER EDUCATION ",
		15336 => "Graduate ",
		15335 => "Undergraduate ",
		37230 => "MIDDLE SCHOOL",
		15328 => "Eighth Grade",
		15327 => "Seventh Grade",
		15326 => "Sixth Grade",
		15318 => "ELEMENTARY SCHOOL",
		15325 => "Fifth Grade",
		15321 => "First Grade",
		15324 =>"Fourth Grade",
		15320 => "Kindergarten",
		15319 => "Pre-K primary-school",
		15322 => "Second Grade",
		15323 => "Third Grade",
	);

	private static $grades_ids = array(
		'elementary' => array(
			15319, // pre-k
			15320, // kindergarden
			15321, // first grade
			15322, // second
			15323, // third
			15324, // fourth
			15325 // fifth
		),
		'middle' => array(
			15326, // sixth
			15327, // seventh
			15328 // eighth
		),
		'high-school' => array(
			15330, // ninth
			15331, // tenth
			15332, // eleventh
			15333 // twelfth
		),
		'higher-education' => array(
			15335, // undergraduate
			15336 // graduate
		)
	);

	public function __construct() {

		global $wpdb;

		$this->wpdb = $wpdb;

		$this->icons = array(
			1 => 'yellow',
			2 => 'blue',
			3 => 'green',
			4 => 'purple'
		);

		$this->placeholders = array(
			1 => 184,
			2 => 185,
			3 => 186,
			4 => 187
		);

		$this->map_subdisciplines = array(
			'algebra',
			'calculus',
			'geometry',
			'language',
			'measurement_and_data',
			'numbers_and_operations',
			'pre-calculus',
			'ratios_and_proportions',
			'reading_foundational_skills',
			'reading_history_social_studies',
			'reading_informational_text',
			'reading_literature',
			'reading_science_and_technical',
			'statistics_and_probability',
			'trigonometry',
			'writing'
		);

		$this->map_openstax_titles = array(
			'anatomy_and_physiology',
			'biology',
			'college_physics',
			'concepts_of_biology',
			'pre-calculus',
			'principles_of_economics',
			'sociology'
		);

		$this->types = array(
			'assessment' => array(
				'type' => 'ASSESSMENT MODULE',
				'color' => 1,
				'icon' => 'assessment'
			),
			'activity' => array(
				'type' => 'ACTIVITY MODULE',
				'color' => 1,
				'icon' => 'activity'
			),
			'lab' => array(
				'type' => 'LAB MODULE',
				'color' => 1,
				'icon' => 'lab'
			),
			'tutorial' => array(
				'type' => 'TUTORIAL MODULE',
				'color' => 1,
				'icon' => 'tutorial'
			),
			'lesson' => array(
				'type' => 'LESSON MODULE',
				'color' => 1,
				'icon' => ''
			),
			'open response' => array(
				'type' => 'OPEN RESPONSE',
				'color' => 1,
				'icon' => ''
			),
			'performance task' => array(
				'type' => 'PERFORMANCE TASK',
				'color' => 1,
				'icon' => ''
			),


			'coursework' => array(
				'type' => 'COURSEWARE MODULE',
				'color' => 2,
				'icon' => 'coursework'
			),
			'courseware' => array(
				'type' => 'COURSEWARE MODULE',
				'color' => 2,
				'icon' => 'coursework'
			),
			'textbook module' => array(
				'type' => 'TEXTBOOK MODULE',
				'color' => 2,
				'icon' => 'textbook'
			),
			'textbook' => array(
				'type' => 'TEXTBOOK MODULE',
				'color' => 2,
				'icon' => 'textbook'
			),
			'student resource' => array(
				'type' => 'STUDENT RESOURCE',
				'color' => 2,
				'icon' => 'student'
			),
			'teacher guide' => array(
				'type' => 'TEACHER GUIDE',
				'color' => 2,
				'icon' => 'teacher'
			),
			'reader' => array(
				'type' => 'READER MODULE',
				'color' => 2,
				'icon' => 'reader'
			),
			'proservices' => array(
				'type' => 'PROFESSIONAL DEVELOPMENT',
				'color' => 2,
				'icon' => 'proservices'
			),
			'reference' => array(
				'type' => 'REFERENCE',
				'color' => 2,
				'icon' => ''
			),
			'lesson plan' => array(
				'type' => 'LESSON PLAN',
				'color' => 2,
				'icon' => ''
			),



			'multimedia' => array(
				'type' => 'MULTIMEDIA MODULE',
				'color' => 3,
				'icon' => 'multimedia'
			),
			'game' => array(
				'type' => 'GAME MODULE',
				'color' => 3,
				'icon' => 'game'
			),
			'app' => array(
				'type' => 'APP MODULE',
				'color' => 3,
				'icon' => 'app'
			),



			'video' => array(
				'type' => 'VIDEO',
				'color' => 4,
				'icon' => 'video'
			)
		);
	}

	function get_color($content_type) {
		$content_type = strtolower($content_type);
		return isset($this->types[$content_type]) ? 'lo-content-type-'.$this->types[$content_type]['color'] : '';
	}

	function get_icon($content_type) {
		$content_type = strtolower($content_type);
		return isset($this->types[$content_type]) ? 'icon_'.$this->icons[$this->types[$content_type]['color']].'_'.$this->types[$content_type]['icon'] : '';
	}

	function get_type($content_type) {
		$content_type = strtolower($content_type);
		return isset($this->types[$content_type]) ? $this->types[$content_type]['type'] : '';
	}

	function get_image_size( $size ) {
		$sizes = $this->get_image_sizes();

		if ( isset( $sizes[ $size ] ) ) {
			return $sizes[ $size ];
		}

		return false;
	}

	function get_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array();

		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
				$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
				$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
				$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
				);
			}
		}

		return $sizes;
	}

	function validate_title($title){

		foreach ($this->map_openstax_titles as $value) {
            if ( strpos($title, $value) === 0 ){
                return $value;
        	}
        }
        return false;
	}

	/**
	 *
	 * @param string $content_type
	 * @param string $size thumn-related, thumb-vertical, home-carousel, home, detail, featured
	 * @param string $subdiscipline
	 * @return string html img tag
	 */
	function get_thumbnail($content_type, $size = 'thumb-related', $subdiscipline = '', $author = '', $title = '') {

		$subdiscipline = strtolower( str_replace(':', '', str_replace(array(" ","/"), "_", $subdiscipline) ) );
		$title = strtolower( str_replace(" ", "_", $title) );
		$url =  get_template_directory_uri();
		$width = $this->get_image_size($size)['width'];
		$height = $this->get_image_size($size)['height'];

		if( $title!= "" && $author == "OpenStax College" && $value_title = $this->validate_title($title) ){

			$attachment_image_src = $url."/img/thumbnails/openstax/".$value_title."/".$value_title."-". $width."x".$height.".jpg";

		} else if( $subdiscipline != "" && in_array($subdiscipline,  $this->map_subdisciplines) ) {

			$attachment_image_src = $url."/img/thumbnails/platform/".$subdiscipline."/".$subdiscipline."-". $width."x".$height.".jpg";

		} else {

			$content_type = strtolower($content_type);
			$placeholder_id = isset($this->types[$content_type])
				? $this->placeholders[$this->types[$content_type]['color']]
				: $this->placeholders[1];
			$attachment_image_src = wp_get_attachment_image_src( $placeholder_id, $size )[0];

		}
		return '<img src="'.$attachment_image_src.'" class="img-responsive">';

	}

    function get_thumbnail_by_discipline($item_id, $content_type, $size = 'thumb-related', $subdiscipline = '', $author = '', $title = '')
    {

        $subdiscipline = strtolower(str_replace(':', '', str_replace(array(" ", "/"), "_", $subdiscipline)));
        $title = strtolower(str_replace(" ", "_", $title));
        $url = get_template_directory_uri();
        $width = $this->get_image_size($size)['width'];
        $height = $this->get_image_size($size)['height'];
        $uploads = wp_upload_dir();


        if ($title != "" && $author == "OpenStax College" && $value_title = $this->validate_title($title)) {

            $attachment_image_src = $url . "/img/thumbnails/openstax/" . $value_title . "/" . $value_title . "-" . $width . "x" . $height . ".jpg";

        }else{
            if(preg_match('/[a-zA-Z]+/',$item_id)){
                if ($subdiscipline != "" && in_array($subdiscipline, $this->map_subdisciplines)){
                    $attachment_image_src = $url . "/img/thumbnails/platform/" . $subdiscipline . "/" . $subdiscipline . "-" . $width . "x" . $height . ".jpg";
                }else{
                    $content_type = strtolower($content_type);
                    $placeholder_id = isset($this->types[$content_type])
                        ? $this->placeholders[$this->types[$content_type]['color']]
                        : $this->placeholders[1];
                    $attachment_image_src = wp_get_attachment_image_src($placeholder_id, $size)[0];
                }
            }else{
                $discipline = isset($this->get_discipline($item_id)['slug']) ? $this->get_discipline($item_id)['slug'] : '';

                if ($discipline) {
                    $attachment_image_src = $uploads['baseurl'] . "/disciplines/" . $discipline . "/" . $discipline . "-" . $width . "x" . $height . ".jpg";
                } else {
                    $content_type = strtolower($content_type);
                    $placeholder_id = isset($this->types[$content_type])
                        ? $this->placeholders[$this->types[$content_type]['color']]
                        : $this->placeholders[1];
                    $attachment_image_src = wp_get_attachment_image_src($placeholder_id, $size)[0];
                }
            }
        }



/*        else if ($subdiscipline != "" && in_array($subdiscipline, $this->map_subdisciplines)) {

            $attachment_image_src = $url . "/img/thumbnails/platform/" . $subdiscipline . "/" . $subdiscipline . "-" . $width . "x" . $height . ".jpg";

        } else {
            $discipline = isset($this->get_discipline($item_id)['slug']) ? $this->get_discipline($item_id)['slug'] : '';

            if ($discipline) {
                $attachment_image_src = $uploads['baseurl'] . "/disciplines/" . $discipline . "/" . $discipline . "-" . $width . "x" . $height . ".jpg";
            } else {
                $content_type = strtolower($content_type);
                $placeholder_id = isset($this->types[$content_type])
                    ? $this->placeholders[$this->types[$content_type]['color']]
                    : $this->placeholders[1];
                $attachment_image_src = wp_get_attachment_image_src($placeholder_id, $size)[0];
            }
        }*/

        return '<img src="' . $attachment_image_src . '" class="img-responsive">';
    }

  /**
   * @return array of grades
   */
  public static function GetGrades() {
    return self::$grades;
  }

	/**
	 *
	 * @param string $grade eg elementary
	 * @return array of int ids of subgrades
	 */
	public static function GetGradesIds($grade) {
		return isset(self::$grades_ids) ? self::$grades_ids[$grade] : self::$grades_ids['middle'];
	}


	public static function GetGradesLabels($grade) {
		return isset(self::$gradesLabels) ? self::$gradesLabels[$grade] : self::$gradesLabels['middle'];
	}

  /**
	 *
	 * @param array of int $grades_ids
	 * @return string
	 */
	public static function GetGradeIdByName($grade) {

    // main grade (with subgrades)
    if (isset(self::$grades_ids[$grade])) {
       return self::$grades_ids[$grade];
    }

    // subgrade
		foreach (self::$grades as $grades) {
      foreach ($grades as $subgrade_id => $subgrade) {
        if ($subgrade == $grade) {
          return array($subgrade_id);
        }
      }
		}

    // default
    return self::$grades_ids['middle'];
  }

	/**
	 *
	 * @param array of int $grades_ids
	 * @return string
	 */
	public static function GetGradeName($grades_ids, $set_static_values = false) {

		$first_grade_id = array_pop($grades_ids);

		foreach (self::$grades_ids as $name => $grades) {
			if (in_array($first_grade_id, $grades)) {
        if ($set_static_values) {
          self::$subgrade_id = $first_grade_id;
          self::$grade_name = $name;
        } else {
          return $name;
        }
				break;
			}
		}

		return self::$grade_name;
	}

  public static function GetGradeByChild($child_id) {

    global $wpdb;

    $sql = "SELECT t.* FROM `wp_term_taxonomy` tt "
      . "LEFT JOIN `wp_terms` t ON t.`term_id` = tt.`parent` "
      . "WHERE tt.`term_id` = ".(int)$child_id.";";
    echo $sql;
    $row = $wpdb->get_row($sql);
    f_print_r($row);
    return $row;
  }

	public function get_grades($id, $implode = true, $merlot_item = false) {

		$s = array();

		$limit = 99;
		if ($implode) {
			$limit = 4;
		}

		if (preg_match('/[a-zA-Z]+/',$id) || $merlot_item ) {

			$sql = "SELECT t.`name`, t.`term_id` FROM `wp_apicache_categories` tr "
				. "INNER JOIN `wp_terms` t ON t.`api_type` = 'Student Level' AND t.`term_id` = tr.`categoryId` AND t.`api_branch` = 2 "
				. "WHERE tr.`itemId` = '".esc_sql($id)."' LIMIT ".$limit;

		} else {

			$sql = "SELECT t.`name`, t.`term_id` FROM `wp_term_relationships` tr "
				. "INNER JOIN `wp_terms` t ON t.`api_type` = 'Student Level' AND t.`term_id` = tr.`term_taxonomy_id` AND t.`api_branch` = 2 "
				. "WHERE tr.`object_id` = '".esc_sql($id)."' LIMIT ".$limit;

		}

		$grades = $this->wpdb->get_results($sql, ARRAY_A);

		if ($grades) {
			foreach ($grades as $v) {
				$s [$v['term_id']]= $v['name'];
			}
		}

		return $implode === true ? implode(', ',$s) : $s;

	}

	public function get_subdiscipline($id) {

		if (preg_match('/[a-zA-Z]+/',$id)) {

			$sql = "SELECT t.`name` FROM `wp_apicache_categories` tr "
				. "INNER JOIN `wp_terms` t ON t.`api_type` = 'Discipline' AND t.`term_id` = tr.`categoryId` "
				. "AND t.`api_branch` = 2 "
				. "WHERE tr.`itemId` = '".esc_sql($id)."' LIMIT 1";

		} else {

			$sql = "SELECT t.`name` FROM `wp_term_relationships` tr "
				. "INNER JOIN `wp_terms` t ON t.`api_type` = 'Discipline' AND t.`term_id` = tr.`term_taxonomy_id` "
				. "AND t.`api_branch` = 2 "
				. "WHERE tr.`object_id` = '".esc_sql($id)."' LIMIT 1";
			//echo $sql;
		}

		$subdisciplines = $this->wpdb->get_results($sql, ARRAY_A);

		if ($subdisciplines) {
			return $subdisciplines[0]['name'];
		}

		return '&nbsp;';
	}

	public function get_discipline($id) {

		if (preg_match('/[a-zA-Z]+/',$id)) {

			/*$sql = "SELECT t.* FROM `wp_apicache_categories` tr "
				. "INNER JOIN `wp_terms` t ON t.`api_type` = 'Discipline' AND t.`term_id` = tr.`categoryId` "
				. "AND t.`api_branch` = 1 "
				. "WHERE tr.`itemId` = '".esc_sql($id)."' LIMIT 1";*/

			$sql =	"SELECT tt.* FROM wp_apicache_categories catdis "
				.   "Inner join wp_terms tdis on tdis.term_id = catdis.term_id "
				.   "Inner join platform_category_levels cdis on cdis.category_id = tdis.api_id and cdis.category_type = 'Discipline' "
				.   "Inner join wp_apicache_items i on i.itemId = catdis.itemId "
				.	"Inner join wp_terms tt on tt.slug = cdis.level1_term and tt.api_type = 'Discipline' "
				.	"WHERE i.itemId = '".esc_sql($id)."';";


		} else {

			$sql = "SELECT t.* FROM `wp_term_relationships` tr "
				. "INNER JOIN `wp_terms` t ON t.`api_type` = 'Discipline' AND t.`term_id` = tr.`term_taxonomy_id` "
				. "AND t.`api_branch` = 1 "
				. "WHERE tr.`object_id` = '".esc_sql($id)."' LIMIT 1";
		}

		$disciplines = $this->wpdb->get_results($sql, ARRAY_A);

		if ($disciplines) {
			return $disciplines[0];
		}

		return '';
	}

	public function get_by_object_id($object_id, $limit = 1) {

		$limit = $limit ? (int)$limit : 1;

		if (!is_array($object_id)) {
			$object_id = array($object_id);
		}

		$sql = "SELECT p.*, m2.`meta_value` AS `item_content_type_icon` FROM `wp_posts` p "
			. "INNER JOIN `wp_postmeta` pm ON pm.`post_id` = p.`ID` AND pm.`meta_key` = 'item_object_id' AND pm.`meta_value` IN ('".implode("','",$object_id)."')"
			. "LEFT JOIN {$this->wpdb->postmeta} m2 ON m2.`post_id` = p.`ID` AND m2.`meta_key` = 'item_content_type_icon' "
			. "WHERE p.`post_status` = 'publish' ORDER BY RAND() LIMIT $limit;";
		$results = $this->wpdb->get_results($sql);

		if ($results) {
			return $results;
		}

		return false;
	}

  public function fix_publish_date() {
    $sql = "SELECT * FROM `wp_postmeta` WHERE `meta_key` LIKE 'item_publish_date' AND `meta_value` LIKE '%/%';";
    $results = $this->wpdb->get_results($sql);
    //f_print_r($results);
    if ($results) {
      foreach ($results as $row) {
        echo $row->meta_value;
        $fixed_date = date('Ymd',strtotime($row->meta_value));

        echo ' - '.$fixed_date.'<br />';
        $this->wpdb->update('wp_postmeta',array(
          'meta_value' => $fixed_date
        ),array(
          'meta_id' => $row->meta_id
        ));

      }
    }
  }
}