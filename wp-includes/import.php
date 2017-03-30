<?php

//error_reporting(E_ALL);
//ini_set('display_errors',1);

// WordPress engine
require_once( dirname(__FILE__) . '/wp-load.php' );

// hide errors
error_reporting(E_ALL ^ E_NOTICE);

require_once( ABSPATH . 'wp-includes/WiseWireImportItems.php' );

//$import = new WiseWireImportItems();
//$import->import(); 

require_once( ABSPATH . 'wp-includes/WiseWireImportCategories.php' );

$import = new WiseWireImportCategories();
$import->parseXml();

