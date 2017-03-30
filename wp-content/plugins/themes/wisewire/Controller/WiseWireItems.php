<?php

/**
 * Implement learning objects placeholders and colors
 */
class Controller_WiseWireItems {
	
	private $types = array();
	private $icons = array();
	private $placeholders = array();
	
	public function __construct() {
		
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
	
	/**
	 * 
	 * @param string $content_type
	 * @param string $size thumn-related, thumb-vertical, home-carousel, home, detail, featured
	 * @return string html img tag
	 */
	function get_thumbnail($content_type, $size = 'thumb-related') {
		$content_type = strtolower($content_type);
		$placeholder_id = isset($this->types[$content_type]) 
			? $this->placeholders[$this->types[$content_type]['color']] 
			: $this->placeholders[1];
		$attachment_image_src = wp_get_attachment_image_src( $placeholder_id, $size )[0];
		return '<img src="'.$attachment_image_src.'" class="img-responsive">';
	}
	
	/**
	 * 
	 * @param string $grade eg elementary
	 * @return array of int ids of subgrades
	 */
	public function get_grades_ids($grade) {
		
		$ids = array();
		
		switch ($grade) {
			case 'elementary':
				$ids []= 8687; // pre-k
				$ids []= 8716; // kindergarden
				$ids []= 9376; // first grade
				$ids []= 8752; // second
				$ids []= 8789; // third
				$ids []= 8826; // fourth
				$ids []= 8863; // fifth
				break;
			
			case 'middle':
				$ids []= 8900; // sixth
				$ids []= 8937; // seventh
				$ids []= 8974; // eighth
				break;
			
			case 'high-school':
				$ids []= 9012; // ninth
				$ids []= 9052; // tenth
				$ids []= 9092; // eleventh
				$ids []= 9132; // twelfth
				break;
			
			case 'higher-education':
				$ids []= 9173; // undergraduate
				$ids []= 9206; // graduate
				
				break;
		}
		
		return $ids;
	}
}