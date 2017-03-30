<?php

if (WAN_TEST_ENVIRONMENT){

	define('WW_API_URL','https://prodhub-elb-1796737886.us-east-1.elb.amazonaws.com/api');
	define('WW_API_CLIENT_ID','cbfcaed9525600b270a7');
	define('WW_API_CLIENT_SECRET','53266f9f4bd756ac97871eb212912ec06ccea810');

} else {

	define('WW_API_URL','https://platform.wisewire.com/api');
	define('WW_API_CLIENT_ID','cbfcaed9525600b270a7');
	define('WW_API_CLIENT_SECRET','53266f9f4bd756ac97871eb212912ec06ccea810');

}

class WiseWireApi { 

	public function __construct() {
		// initialize
	}
	
	public function search($pagesize, $pagenum, $filters = array()) {
		
		$action = '/content/search';
		
		$params = array(
			'keyword' => $filters['keyword'],
			'pageSize' => $pagesize,
			'pageNum' => $pagenum,
			'filter' => 'itemType:'.$filters['type'].','
				. 'userId:'.$filters['user_id'].','
				. 'categories:'.$filters['category'].','
				. 'tags:'.$filters['tags'].','
				. 'title:'.$filters['title'].'',
			'mediaType' => 'json'
		);
	}
	
	public function run() {
		
	}
	
	public function download($url, $destination) {
		
		$fp = fopen($destination, 'w+');
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 360);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		
		return true;
	}
	
	public static function set_option($option, $value) {
		global $wpdb;
    
		$option_name = 'wwapi_'.$option;

		if ( get_option( $option_name ) !== false ) {
      
			// The option already exists, so we just update it.
      $sql = "UPDATE `wp_options` SET `option_value` = '".esc_sql($value)."' WHERE `option_name` = '".esc_sql($option_name)."';";
      $wpdb->query($sql);
		
		} else {

			// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			add_option( $option_name, $value, $deprecated, $autoload );
		}
	}
	
	public static function get_option($option, $default_value = false) {
		
		$option_name = 'wwapi_'.$option;
		
		return get_option( $option_name, $default_value );
	}
}