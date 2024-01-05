<?php

// PHP Excel 1.8
require_once ABSPATH . 'wp-includes/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

class Controller_TEI {
	
	private $wpdb;
	private $wp_query;
	
	public $tei_path = '';
	public $data = array();
	
	public function __construct() {
		
		global $wpdb, $wp_query;
		
		$this->wpdb = $wpdb;
		$this->wp_query = $wp_query;
		
		$this->tei_path = ABSPATH . 'wp-content/uploads/tei/';
		
		$this->load_data();
	}
	
	public function load_data() {
		
		// load xlsx list of tei
		$path = $this->tei_path . 'TEI_Items_Ready_Platform_Batch_1.xlsx';

		//  Read your Excel workbook
		try {
			$inputFileType = PHPExcel_IOFactory::identify($path);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($path);
		} catch (Exception $e) {
			die('Error loading file "' . pathinfo($path, PATHINFO_BASENAME) 
				. '": ' . $e->getMessage());
		}

		$sheets = $objPHPExcel->getSheetCount();
		
		$data = array(); 
		
		if ($sheets > 0) {
			for ( $i = 0; $i < $sheets; $i++ ) {
				$sheet = $objPHPExcel->getSheet($i); // first sheet (0..N-1)
				//
				//  Get worksheet dimensions
				$highestColumn = $sheet->getHighestColumn();
				$highestRow = $sheet->getHighestRow();
				
				// which row is first
				$startRow = 2;

				//  Loop through rows
				for ($row = $startRow; $row <= $highestRow; $row++) {
					//  Read a row of data into an array
					$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
					null, true, false);

					$data[$i][$row] = array();

					foreach($rowData[0] as $k=>$v) {
						$data[$i][$row][$this->get_col_letter($k+1)] = $v;
					}
				}
			}
			
			$this->data = $data;
		}
	}
	
	private function get_col_list($from, $to) {
		$from_i = get_col_index($from);
		$to_i = get_col_index($to);

		$list = array();
		for ($i = $from_i; $i<=$to_i; $i++) {
			$list []= get_col_letter($i);
		}
		return $list;
	}

	private function get_col_index($cell) {
		$index = 1;
		for ($i=0; $i<strlen($cell); $i++) {
			if ($i > 0) {

				$index *= 26;
				if ($i == 1) {
					$index ++;
				}
			}
			$index += (ord($cell{$i}) - 65);
		}
		return $index;
	}

	private function get_col_letter($index) {
		if ($index/26 > 1) {
			return chr(65+intval(($index-1)/26)-1).chr(65+(($index-1)%26));
		} else {
			return chr(65+(($index-1)%26));
		}
	}

	private function get_col_sum($col,$from,$to,$data) {
		$sum = 0;
		for($i=$from;$i<=$to;$i++) {
			$sum += $data[$col.$i];
		}
		return $sum;
	}
}