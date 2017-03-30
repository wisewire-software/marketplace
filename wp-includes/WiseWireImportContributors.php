<?php

// load WiseWire API
require_once( ABSPATH . 'wp-includes/WiseWireApi.php' );

class WiseWireImportContributors {
	
	private $wpdb;
	private $json_url; 
	
	public function __construct() {
		global $wpdb;
		
		$this->wpdb = $wpdb;
		$this->json_url = WW_API_URL . '/content/listContributors?start=1&quantity=999&mediaType=json';
	}
	
	public function download() { 
		
		$ch = curl_init( $this->json_url );
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		curl_close($ch);
		
		return $data ? json_decode($data) : false;
	}
	
	public function import($data) {
		
		if ($data->numFound > 0) {
			
			foreach ($data->contributors->contributor as $v) {
				
				$sql = "SELECT * FROM `wp_apicache_contributors` WHERE `userId` = ".(int)$v->userId.";";
				$user = $this->wpdb->get_row($sql, ARRAY_A);
				
				if ($user) {
					$this->wpdb->update('wp_apicache_contributors', array(
						'fullName' => $v->fullName,
						'description' => $v->description
					), array(
						'userId' => $v->userId
					));
				} else {
					$this->wpdb->insert('wp_apicache_contributors', array(
						'userId' => $v->userId,
						'fullName' => $v->fullName,
						'description' => $v->description
					));
				}
			}
		}
	}
}