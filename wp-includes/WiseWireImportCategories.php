<?php

// load XML Simple Streamer
require_once( ABSPATH . 'wp-includes/SimpleXmlStreamer.php' ); 
require_once( ABSPATH . 'wp-includes/SimpleCategoryPlatformXmlStreamer.php' ); 

// load WiseWire API
require_once( ABSPATH . 'wp-includes/WiseWireApi.php' );

class WiseWireImportCategories {
	
	private $wpdb;
	private $xml_path;
	private $xml_url; 
	
	public function __construct() {
		global $wpdb;
		
		$this->wpdb = $wpdb;
		$this->xml_path = ABSPATH . 'tmp/categories.xml';
		$this->xml_url = WW_API_URL . '/categories?client_id=' . WW_API_CLIENT_ID . '&client_secret=' . WW_API_CLIENT_SECRET;
	}
	
	public function download() { 
		
		$fp = fopen($this->xml_path, 'w+');
		$ch = curl_init($this->xml_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		
		return true;
	}
	
	public function parseXml() {
		
		$streamer = new SimpleXmlStreamer($this->xml_path, $chunkSize = 16384, $customRootNode = 'categories');
		$streamer->parse();
		
		$categories = $streamer->get_categories();

		$actual = array();

		$results = $this->wpdb->get_results( "SELECT * FROM {$this->wpdb->terms} WHERE `api_id` > 0" );

		if ($results) {
			foreach ($results as $v) {
				$actual[$v->api_type][$v->slug] = $v->term_id;
			}
		}
 
		if ($categories) {
			
			$this->wpdb->query("SET autocommit=0;");
			
			$k = 0;
			
			foreach ($categories as $content_type => $items) {
				
				foreach ($items as $path => $category) {
					
					$k ++;

					if (isset($actual[$content_type][$path])) {

						$this->wpdb->update( $this->wpdb->terms, array( 
							'name' => $category['name'], 
							'api_id' => $category['api_id'],
							'api_type' => $category['api_type'],
							'api_branch' => $category['api_branch']
						), array(
							'term_id' => (int) $actual[$content_type][$path]
						) );

						$this->wpdb->update( $this->wpdb->term_taxonomy, array(
							'parent' => isset($actual[$content_type][$category['parent']]) ? $actual[$content_type][$category['parent']] : 0
						),array(
							'term_id' => (int) $actual[$content_type][$path]
						));
						
					} else {

						$this->wpdb->insert( $this->wpdb->terms, array( 
							'name' => $category['name'], 
							'slug' => $path, 
							'api_id' => $category['api_id'],
							'api_type' => $category['api_type'],
							'api_branch' => $category['api_branch']
						) );
						$term_id = $this->wpdb->insert_id;

						$actual[$content_type][$path] = $term_id;

						$this->wpdb->insert( $this->wpdb->term_taxonomy, array(
							'term_id' => $term_id,
							'taxonomy' => 'category',
							'parent' => isset($actual[$content_type][$category['parent']]) ? $actual[$content_type][$category['parent']] : 0
						));
					}
					
					if ($k%200 == 0 && $k > 1) {
						$this->wpdb->query("COMMIT;");
						$this->wpdb->query("SET autocommit=0;");
					}
				}
			}
			
			$this->wpdb->query("COMMIT;");
		}
		
		return true;
	}


	/*
	*	This Method stores the xml data saved into the tables:
	*	platform_category_levels and platform_category_labels
	*/

	public function SaveInCategoriesTableSearch() {

		$streamer_platform = new SimpleCategoryPlatformXmlStreamer($this->xml_path, $chunkSize = 16384, $customRootNode = 'categories');
		$streamer_platform->parse();
		
		$categories = $streamer_platform->get_categories();

		//Deletes all the data existing
		if ($categories){
			
			$this->wpdb->query("TRUNCATE `platform_category_levels`;");

			$content = "";
			
			foreach ($categories["terms"] as $term) {

				if( !empty($term["code"]) ){

					$sql = $this->wpdb->prepare("INSERT INTO `platform_category_levels` SET "
							. "`category_id` = %s, `category_type` = %s, "
							. "`level1_term` = %s, `level1_label` = %s, `level2_term` = %s, `level2_label` = %s,"
							. "`level3_term` = %s, `level3_label` = %s, " 
							. "`level4_term` = %s, `level4_label` = %s, `level5_term` = %s,"
							. "`level5_label` = %s, `code` = %s; ",					
							$term["categoryId"], 
							$term["categoryType"],
							$term["level1_term"],				
							$term["level1_label"],
							$term["level2_term"],
							$term["level2_label"],
							$term["level3_term"],
							$term["level3_label"],
							$term["level4_term"],
							$term["level4_label"],
							$term["level5_term"],
							$term["level5_label"],
							$term["code"]
					);

				} else {

					$sql = $this->wpdb->prepare("INSERT INTO `platform_category_levels` SET "
							. "`category_id` = %s, `category_type` = %s, "
							. "`level1_term` = %s, `level1_label` = %s, `level2_term` = %s, `level2_label` = %s,"
							. "`level3_term` = %s, `level3_label` = %s, " 
							. "`level4_term` = %s, `level4_label` = %s, `level5_term` = %s,"
							. "`level5_label` = %s; ",					
							$term["categoryId"], 
							$term["categoryType"],
							$term["level1_term"],				
							$term["level1_label"],
							$term["level2_term"],
							$term["level2_label"],
							$term["level3_term"],
							$term["level3_label"],
							$term["level4_term"],
							$term["level4_label"],
							$term["level5_term"],
							$term["level5_label"]						
					);

				}
				
				$this->wpdb->query($sql);		
			}	

		}

		return true;

	}
}