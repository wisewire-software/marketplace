<?php

class PredictionIOController {
	
	private $application_name;
	private $access_key;
	private $api_host;
	private $cookie_name = 'piouid';
	
	public function __construct() {
		$this->api_host = 'http://localhost:7070/';
		$this->application_name = 'wisewire2';
		$this->access_key = 'hPTLCLoGcU7IKW1jqDSGpUj3hOLvl0mf2z5ESxggNPZUSgTSnC1mpVFhJtVeMx5f';
	}
	
	private function send_request($data, $props = array()) {
		
		$url = $this->api_host . 'events.json?accessKey=' . $this->access_key.'&'.http_build_query($props);
		//echo $url;
		
		$ch = curl_init($url);
		
		if ($data) {
			
			$data_string = json_encode($data);
			
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data_string))
			);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);

		return $result;
	}
	
	public function get_last_events() {
		$this->send_request('',array('eventTime'=>date('c',strtotime('-2 hours'))));
	}
	
	/**
	 * 
	 * @param type $num 
	 * @return type
	 */
	public function get_recommendations($num) {
		
		$user_id = $this->get_user_id();
		
		$url = 'http://localhost:8000/queries.json';
		
		$ch = curl_init($url);
	
		$data = array(
			"user" => $user_id,
			"num" => (int) $num
		);
		
		$data_string = json_encode($data);
			
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
		);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);

		return json_decode($result);
	}
	
	public function get_user_id() {
		
		if (get_current_user_id()) {
			$user_id = get_current_user_id();
		} else {
			if (isset($_COOKIE[ $this->cookie_name ])) {
				$user_id = $_COOKIE[ $this->cookie_name ];
			} else {
				$user_id = md5(microtime(true));
				setcookie($this->cookie_name, $user_id, time()+3600*24*100, COOKIEPATH, COOKIE_DOMAIN, false);
			}
		}
		
		return $user_id;
	}
	
	public function send_event($event, $item_id, $properties = array()) {
		
		global $wpdb;
		
		$user_id = $this->get_user_id();

		$data = array(
			'event' => $event,
			'entityType' => 'user',
			'entityId' => $user_id,
			'targetEntityType' => 'item',
			'targetEntityId' => $item_id,			
			'eventTime' => date('c')
		);
		
		if (is_array($properties) && sizeof($properties)) {
			$data['properties'] = $properties;
		}
		
		$result = $this->send_request($data);
		
		$item_type = strlen($item_id) == 36 ? 'question' : '';

		$post_id = 0;
		
		if ($item_type == '') {
			$post = $wpdb->get_row("SELECT `post_id` FROM `wp_postmeta` WHERE `meta_key` = 'item_object_id' AND `meta_value` = '".esc_sql($item_id)."';");
			if ($post) {
				$post_id = $post->post_id;
			}
		}
		
		// insert view action to our database 
		$wpdb->query("INSERT INTO `wp_object_views` VALUES(NULL, '".$item_id."', ".(int)$post_id.", '".$user_id."', NOW(), '".$item_type."');");
	}
}
