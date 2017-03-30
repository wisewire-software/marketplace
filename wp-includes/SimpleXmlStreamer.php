<?php

// load XML Streamer
require_once( ABSPATH . 'wp-includes/XmlStreamer.php' );

class SimpleXmlStreamer extends XmlStreamer {
	
	private $categories = array();

    public function processNode($xmlString, $elementName, $nodeIndex) {
		
        $xml = simplexml_load_string($xmlString);
		
		//$attributes = $xml->attributes();
		//echo (string) $attributes->categoryId.'<br />';
		//echo (string) $attributes->categoryType.'<br />';
		//echo '<pre>';
		
		$path = '';
		$levels = sizeof($xml->categoryLevels->categoryLevel);
		$k = 0;
		foreach ($xml->categoryLevels->categoryLevel as $item) {
			
			$k ++;
			
			//echo (string) $level->attributes()->term.'<br />';
			//echo (string) $level->attributes()->label.'<br />';

			$term = (string)$item->attributes()->term;
			$label = (string)$item->attributes()->label;
			$api_id = (string)$xml->attributes()->categoryId;
			$api_type = (string)$xml->attributes()->categoryType;
			 
			//$level = (string)$item->attributes()->level;
 
			/*if ($level == 1 && $this->branch != $term) {
				$this->branch = $term;
			}*/
			 
			$path .= $path ? ';'.$term : $term;
			
			if (isset($this->categories[$api_type][$path])) {
				
				if ($k == $levels) {
					$this->categories[$api_type][$path]['api_id'] = $api_id;
				}
				
				$parent = (string)$path;
				
				continue;
			}

			$this->categories[$api_type][$path] = array(
				'name' => $label,
				'parent' => $parent,
				'api_id' => $k == $levels ? $api_id : 0,
				'api_type' => $api_type,
				'api_branch' => $k
			);
			
			$parent = $path;

		}

        return true;
    } 
	
	public function get_categories() {
		return $this->categories;
	}
}