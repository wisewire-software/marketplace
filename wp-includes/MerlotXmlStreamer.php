<?php

// load XML Streamer
require_once( ABSPATH . 'wp-includes/XmlStreamer.php' );

/*
*	This class extends XmlStreamer library and 
*	processNode method
*/
class MerlotXmlStreamer extends XmlStreamer {
	
	private $items = array();
	private $totalMerlotItems;

    public function processNode($xmlString, $elementName, $nodeIndex) {
				
        $xml = simplexml_load_string($xmlString);		
		$row = array();

		//The API defines the total of items in the first Node	
		if( $nodeIndex == 0 ){
			$this->totalMerlotItems = $xml[0];			

		} else {

			$audiences = array();
			$categories = array();

			if( count($xml->audiences->audience)>0 ){
				foreach ($xml->audiences->audience as $audience) {
					$audience_value = (string) $audience;
					array_push($audiences, $audience_value);

				}
			}

			if( count($xml->categories->category)>0 ){
				foreach ($xml->categories->category as $category) {
					$category_value = (string) $category;
					array_push($categories, $category_value);

				}			
			}

			$data = array ( 'materialId' => (string) $xml->materialid,
							'URL' => (string) $xml->URL,
							'detailURL' => (string) $xml->detailURL,
							'title' => (string) $xml->title,
							'authorName' => (string) $xml->authorName,
							'authorOrg' => 'Merlot',//(string) $xml->authorOrg,
							'description' => (string) $xml->description,
							'materialType' => (string) $xml->materialType,
							'audiences' => $audiences,
							'categories' => $categories,
							'technicalrequirements' => (string) $xml->technicalrequirements,
							'creationDat' => (string) $xml->creationDate,
							'modifiedDate' => (string) $xml->modifiedDate
						);

			array_push($this->items, $data );
		}		

        return true;
    } 
	
	public function get_items() {
		return array('totalMerlotItems'=>$this->totalMerlotItems , 'items' => $this->items);
	}
}