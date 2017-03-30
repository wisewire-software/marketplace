<?php

// load XML Streamer
require_once( ABSPATH . 'wp-includes/XmlStreamer.php' );

class SimpleCategoryPlatformXmlStreamer extends XmlStreamer {
	
	private $categories = array();
	private $terms = array();
	private $labels = array();

    public function processNode($xmlString, $elementName, $nodeIndex) {
		
        $xml = simplexml_load_string($xmlString);				
		
		$levels = sizeof($xml->categoryLevels->categoryLevel);	

		$categoryId = (string)$xml->attributes()->categoryId;
		$categoryType = (string)$xml->attributes()->categoryType;
		$code = (string)$xml->attributes()->code;

		$cat_terms = array();
		
		$k = 0;

		foreach ($xml->categoryLevels->categoryLevel as $item) {			
				
			$term = (string)$item->attributes()->term;
			$level = (string)$item->attributes()->level;
			$label = (string)$item->attributes()->label;
			
			$cat_terms['level' . $level .'_term'] = $term;
			$cat_terms['level' . $level .'_label'] = $label;
		}

		$cat_terms['categoryId'] = $categoryId;
		$cat_terms['categoryType'] = $categoryType;
		$cat_terms['code'] = $code;

		array_push($this->terms, $cat_terms );		
        
    } 
	
	public function get_categories() {
		return array('terms'=>$this->terms);
	}
}