<?php

// load XML Simple Streamer
require_once( ABSPATH . 'wp-includes/MerlotXmlStreamer.php' );

// Merlot credentials to access the API search
define('MERLOT_API_URL','https://wtest.merlot.org/merlot/materialsAdvanced.rest');
define('MERLOT_LICENSE_KEY','F124RCRTE9KHPN4LL1HNRKS7OUOEKS5EIXW');

class MerlotApi { 

	/* 
	* This are parameters that needs to be hardcoded to call the API
	* filters
	*/
	private $language = 'eng';
	private $cost1 = '0';
	private $cost2 = '_null_';
	private $sort = 'overallRating';
	private $createdSince = '2013-01-01';
	private $hasEditorReviews = 'true';

	//data proccessing
	private $merlot_xml_path;
	private $merlot_url;
	private $wpdb;
	private $customRootNode = 'merlothitlist';
	private $rowsPerPageMerlotItems = 10;
	private $actualPageMerlot = 1;
	private $totalMerlotItems;
	private $categories_found = array();
  	

	public function __construct() {		
		
		global $wpdb;
		
		$this->wpdb = $wpdb;
		$this->merlot_xml_path = ABSPATH . 'tmp/merlotResults.xml';
		
		/* hardcoded filters for the search */
		$filters = '&language=' . $this->language;
		$filters .= '&cost=' . $this->cost1;
		$filters .= '&cost=' . $this->cost2;
		$filters .= '&sort.property=' . $this->sort;
		$filters .= '&createdSince=' . $this->createdSince;
		$filters .= '&hasEditorReviews=' . $this->hasEditorReviews;
		$filters .= '&page={pageNumber}';

		$this->merlot_url = MERLOT_API_URL . '?licenseKey=' . MERLOT_LICENSE_KEY . $filters;			

	}


	/* This method deletes all records from
	*  wp_cache_items which 'source' field is equal to 'merlot'.
	*/
	public function clearDataFromMerlot(){
		
		$this->wpdb->query("DELETE 
							FROM `wp_apicache_items` 
							WHERE `source` = 2;");

		$this->wpdb->query("DELETE 
							FROM `wp_apicache_categories` 
							WHERE `source` = 2;");	
	}


	/*
	*	This Method invokes the method executeSearch() to call the API ,
	*	and also invokes the method parseMerlotResults() 
	*	to process the materials from the API.
	*/
	public function LoadDataFromMerlot(){		
				 
		//By default $this->actualPageMerlot is equal to 1 		
		if( $this->executeSearch( $this->actualPageMerlot ) ){

			//Call the method to Process the data
			$this->parseMerlotResults();

			//Evaluates if the total of items received is less than the total, 
			//if so, calls the API again.
			if( $this->rowsPerPageMerlotItems * $this->actualPageMerlot < $this->totalMerlotItems ){
				$this->actualPageMerlot++;			
				$this->LoadDataFromMerlot($this->actualPageMerlot);
			} else {

				//when there are no more materials to import
				$this->wpdb->query("UPDATE `wp_apicache_categories` c SET c.`term_id` = (SELECT t.`term_id` FROM `wp_terms` t WHERE t.`api_id` = c.`categoryId` LIMIT 1) WHERE source=2;");
				$this->wpdb->query("UPDATE `wp_apicache_categories` SET `categoryId` = `term_id` WHERE source=2;");
				$this->wpdb->query("INSERT INTO `wp_apicache_categories` (SELECT ac.`itemId`, tt.`parent`, 0 , 2 FROM `wp_terms` t 
        							LEFT JOIN `wp_term_taxonomy` tt ON tt.`term_id` = t.`term_id`
        							LEFT JOIN `wp_apicache_categories` ac ON ac.`categoryId` = t.`term_id`
        							WHERE t.`api_branch` = 2 AND t.`api_type` = 'Discipline' AND ac.`source`=2 AND ac.`categoryId` IS NOT NULL)");

				WiseWireApi::set_option( 'MERLOT_lasttime', date('Y-m-d H:i:s') );

			}						
		}
	}	


	/*
	*	This method calls the API search and stores the xml content in a file
	*	defined by the variable  $this->merlot_xml_path
	* 	receives the pageNumber	as a variable
	*/
	public function executeSearch($pageNumber) {		

		$merlot_url = str_replace('{pageNumber}',$pageNumber, $this->merlot_url);				
		$fp = fopen($this->merlot_xml_path, 'w+');
		$ch = curl_init($merlot_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		$curlResp = curl_exec($ch);

		if ($curlResp === FALSE) {
			error_log( "\n" . date("Y-m-d h:i:s") ." Error calling API url:" . $merlot_url , 3, ABSPATH . 'tmp/log/errors.log');
			return false;
		}

		curl_close($ch);
		fclose($fp);
		return true;					
	}


	/*
	*	This method processes the data stored in the executeSearch method.
	*	Stores the data into the table wp_apicache_items
	*/
	
	public function parseMerlotResults() {
		
		//Calls the Xml library to convert data from xml to array
		$streamer = new MerlotXmlStreamer($this->merlot_xml_path, $chunkSize = 16384);
		$streamer->parse();
		
		//Gets all the items formated and ready to insert into the table;
		$items = $streamer->get_items();
		
		$this->totalMerlotItems = $items["totalMerlotItems"];

				
		foreach ($items["items"] as $item) {
			
			$sql = $this->wpdb->prepare("INSERT INTO `wp_apicache_items` SET "
					. "`itemId` = %s, `title` = %s, "
					. "`contentType` = %s, `userId` = %s, `userFullName` = %s, " 
					. "`created` = %s, `updated` = %s, `repoId` = %s, "
		         	. "`previewURL` = %s, `description` = %s, `questions` = %s, "
		         	. "`instructionalTime` = %s, `type` = 'merlot',  `source` = 2; " ,
					$item["materialId"], 
					$item["title"],
					$item["materialType"],// $item->podType,
					null,//$item->userId,
					$item["authorName"],//$item->userFullName, 
					date('Y-m-d H:i:s', strtotime($item["creationDat"])),
					date('Y-m-d H:i:s', strtotime($item["modifiedDate"])),						
					null,//$item->repoId,						
		          	$item["URL"], //["detailURL"] $item->externalPreviewUrl,
		          	$item["description"],//$item->description,
		          	null,//$item->questions,
		          	null//$item->instructionalTime		          	
			);	

			$this->wpdb->query($sql);


			/*Inserting new categories from categories merlot*/
			$this->categories_found = array();

			if ( count($item["categories"]) > 0 ){
				
				foreach ($item["categories"] as $category) {					

					list($discipline, $subdiscipline) = explode("/", $category);

					$results = $this->wpdb->get_results("SELECT category_id from ww_merlot_discipline_map ww where ww.ml_discipline ='".$discipline."' and ww.ml_subdiscipline = '".$subdiscipline."'");
					
					if ($results) {						

						foreach ($results as $v) {

							if( !in_array($v->category_id, $this->categories_found) && $v->category_id!=0 ){						
						
								$sql = $this->wpdb->prepare("INSERT INTO `wp_apicache_categories` SET "
									. "`itemId` = %s, source=2, "
									. "`categoryId` = %s", 
									$item["materialId"],
									$v->category_id
									);																		
								
								$this->wpdb->query($sql);
								array_push($this->categories_found, $v->category_id);
							}

						}
					}										
				}
			}


			$this->categories_found = array();
			/*Inserting new categories from audiences merlot*/
			if ( count($item["audiences"]) > 0 ){				

				foreach ($item["audiences"] as $audience) {
					
					$results = $this->wpdb->get_results( "SELECT category_id from ww_merlot_grade_map ww where ww.ml_audience ='".$audience."'" );
					
					if ($results) {

						foreach ($results as $v) {														

							if( !in_array($v->category_id, $this->categories_found) && $v->category_id!=0 ){

								$sql = $this->wpdb->prepare("INSERT INTO `wp_apicache_categories` SET "
									. "`itemId` = %s, source=2, "
									. "`categoryId` = %s ;", 
									$item["materialId"],
									$v->category_id
									);							
										
								$this->wpdb->query($sql);
								array_push($this->categories_found, $v->category_id);
							}
						}
					}					
				}
			}

		}	
		
		return true;
	}

}