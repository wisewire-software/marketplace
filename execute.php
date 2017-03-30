<?php

session_start();

// WordPress engine
require_once( dirname(__FILE__) . '/wp-load.php' );

// hide errors
error_reporting(E_ALL ^ E_NOTICE);

// no time limits
set_time_limit(0);

// more memory 
ini_set('memory_limit','512M');

$message = '';
$error = '';

if (isset($argv[1])) {
	$_SESSION['loged'] = true;
	$_REQUEST['action'] = $argv[1];
}

if ($_SESSION['loged']) {
	
	require_once( ABSPATH . 'wp-includes/WiseWireApi.php' );	
	
	switch ($_REQUEST['action']) {

		case 'update_featured_authors':

			global $wpdb;
			/* DELETE FEATURED 2 HOURS AFTER THEY WERE ADDED*/
			$sql = $wpdb->prepare("DELETE FROM `wp_cache_featured` WHERE `date_creation` <  DATE_SUB(NOW(),INTERVAL 2 HOUR)");				
			$wpdb->query($sql); 			
    		break;

		case 'get_merlot_materials':

			require_once( ABSPATH . 'wp-includes/MerlotApi.php' );

			$merlot_api = new MerlotApi();	
			$merlot_api->clearDataFromMerlot();
			$merlot_api->LoadDataFromMerlot();
    		break;	

    	case 'get_platform_categories_data':

			require_once( ABSPATH . 'wp-includes/WiseWireImportCategories.php' );

			$categoriesApi = new WiseWireImportCategories();			
			$categoriesApi->download();
			$categoriesApi->SaveInCategoriesTableSearch();
    		break;	    	
  }
}

?>