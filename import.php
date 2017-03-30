<?php

//error_reporting(E_ALL);
//ini_set('display_errors',1);

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

if ($_REQUEST['action'] == 'logout') {
  $_SESSION['loged'] = false;
}

if ($_REQUEST['action'] == 'login') {
	if ($_REQUEST['login'] == 'dev' && $_REQUEST['password'] == '1wwteam') {
		$_SESSION['loged'] = true;
	} else {
		$_SESSION['loged'] = false;
	}
}

if (isset($argv[1])) {
	$_SESSION['loged'] = true;
	$_REQUEST['action'] = $argv[1];
}

if ($_SESSION['loged']) {
	
	require_once( ABSPATH . 'wp-includes/WiseWireApi.php' );
	
	/*if ($_REQUEST['lol']) {	
		
		$file = 'Batch 02/WW_Bulk_Upload_Batch 02.xlsx';
		
		require_once( ABSPATH . 'wp-includes/WiseWireImportItems.php' );

		$import = new WiseWireImportItems(); 
		$import->hide_imported($file); 
	}*/

	switch ($_REQUEST['action']) {

		case 'download_categories_xml':

			require_once( ABSPATH . 'wp-includes/WiseWireImportCategories.php' );

			$import = new WiseWireImportCategories();
			$import->download(); 

			$message = 'Categories XML file downloaded to server, now You can import them to WP database';

    break;

		case 'import_categories':

			require_once( ABSPATH . 'wp-includes/WiseWireImportCategories.php' );

			$import = new WiseWireImportCategories();
			$import->parseXml(); 

			$message = 'Categories from XML imported into WP database';

    break;

		case 'download_items':
		
			require_once( ABSPATH . 'wp-includes/WiseWireImportItems.php' );

			$import = new WiseWireImportItems(); 
			$import->download_remote_files(); 

			$message = 'Files downloaded.';

    break;
			
		case 'import_items':

			require_once( ABSPATH . 'wp-includes/WiseWireImportItems.php' );

			$import = new WiseWireImportItems(); 
			$import->import(); 

			$message = 'Items from XLSX imported/updated';

    break;

		case 'import_items_images':

			require_once( ABSPATH . 'wp-includes/WiseWireImportItems.php' );

			$import = new WiseWireImportItems();
			$import->import_images(); 

			$message = 'Images imported';

    break;

		case 'rebuild_cache':

			require_once( ABSPATH . 'wp-includes/WiseWireApiCache.php' );

			$cache = new WiseWireApiCache();
			$cache->cache_pod(true);
			$cache->cache(true);
			
			// added by helloAri
			require_once( ABSPATH . 'wp-content/plugins/ww-sync-products/WiseWireSyncProducts.php' ); // helloAri
			$products = new WiseWireSyncProducts();
	 		$products->sync_api_products();

    break;

		case 'fix_thumbnails_relations':

			require_once( ABSPATH . 'wp-includes/WiseWireImportItems.php' );

			$import = new WiseWireImportItems();
			$import->fix_thumbnails_relations(); 

			$message = 'Images relations fixed';

    break;

		case 'download_contributors':

			require_once( ABSPATH . 'wp-includes/WiseWireImportContributors.php' );

			$import = new WiseWireImportContributors();
			$data = $import->download();
			$import->import($data);

			$message = 'Contributors downloaded successfully';

    break;
  
    case 'upload_import_file':

      require_once( ABSPATH . 'wp-includes/Helper_Plupload.php' );
      
      $upload = new Helper_Plupload();
      $upload_result = $upload->Upload( ABSPATH . '/tmp/' );

      if ($upload_result !== false) {
        
        require_once( ABSPATH . 'wp-includes/WiseWireImportItems.php' );

        $import = new WiseWireImportItems(); 
        $import->import_single_file($upload_result); 

        $message = 'Items from XLSX imported/updated';
        
        echo json_encode(array(
					'filename' => $upload_result
				));
        
        die();
      }

    break;
  }
}


?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Toolbox - Preview</title>

	<link rel="stylesheet" href="http://wisewire.wordsandnumbers.com/wp-content/themes/wisewire/css/main.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	
	<style type="text/css">
  	.form-import {
    	margin-top: 100px;
  	}
  	.form-import .form-control {
    	border: 1px solid #000;
  	}
    .uploadContainer {
      position: relative;
    }
    .uploadQueue {
      position:absolute;
      z-index:10;
      left: 0;
      color: #000;
    }
    .uploadQueueRight {
      right: 0;
      left: auto;
    }
    .uploadQueueItem {
      background-color: #F5F5F5;
      border: 2px solid #E5E5E5;
      font: 11px Verdana, Geneva, sans-serif;
      margin-top: 5px;
      padding: 10px;
      width: 350px;
    }
    .uploadError {
      background-color: #FDE5DD !important;
      border: 2px solid #FBCBBC !important;
    }
    .uploadQueueItem .cancel {
      float: right;
    }
    .uploadQueue .completed {
      background-color: #E5E5E5;
    }
    .uploadProgress {
      background-color: #E5E5E5;
      margin-top: 10px;
      width: 100%;
    }
    .uploadProgressBar {
      background-color: #0099FF;
      height: 3px;
      width: 1px;
    }
  </style>
  
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
    
	<?php if ($_SESSION['loged']): ?>
	<div class="container">
      
    <a href="?action=logout" class="btn" style="position: fixed; top: 0; right: 50px;">Logout</a>
		
		<h1>Toolkit - Preview</h1>

		<?php if ($message): ?>
		<div class="alert alert-success"><?php echo $message ?></div>
		<?php endif; ?>
		
		<h2>Categories</h2>

		<?php 

		$api_categories_count = $wpdb->get_results("SELECT `api_type`, COUNT(*) AS `count` FROM {$wpdb->terms} WHERE `api_id` > 0 GROUP BY `api_type` ORDER BY 2 DESC;");

		?>
		<p>All categories imported from API by Groups</p>

		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>Group name</th>
					<th>Categories count</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($api_categories_count): foreach ($api_categories_count as $v): ?>
				<tr>
					<td><?php echo $v->api_type ?></td>
					<td><?php echo $v->count ?></td>
				</tr>
				<?php endforeach; endif; ?>
			</tbody>
		</table>

		<a class="btn" href="?action=download_categories_xml">Download categories XML from API to server</a>
		<a class="btn pull-right" href="?action=import_categories">Import XML to WP database</a>
		
		<?php 

		$sql = "SELECT COUNT(*) AS `count`, t.`term_id`, term.`name`, term.`slug` FROM {$wpdb->posts} p "
		. "LEFT JOIN `wp_term_relationships` r ON r.`object_id` = p.`ID` "
		. "LEFT JOIN `wp_term_taxonomy` t ON t.`term_taxonomy_id` = r.`term_taxonomy_id` "
		. "LEFT JOIN `wp_terms` term ON term.`term_id` = t.`term_id` "
		. "WHERE p.`post_type` = 'item' AND t.`taxonomy` = 'category' "
		. "GROUP BY t.`term_id` ORDER BY 1 DESC LIMIT 15;";
		
		$api_items_count = $wpdb->get_results($sql);
		
		?>
		
		<h2>Learning Objects - Bulk Upload</h2>
		
		<p>Items count by category in most popular categories</p>
		
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>Category</th>
					<th>Path</th>
					<th>Items count</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($api_items_count): foreach ($api_items_count as $v): ?>
				<tr>
					<td><?php echo $v->name ?></td>
					<td><?php echo $v->slug ?></td>
					<td><?php echo $v->count ?></td>
				</tr>
				<?php endforeach; endif; ?>
			</tbody>
		</table>
		
		<p> 
			<a class="btn" href="?action=download_items">1. Download Learning Objects from client's FTP</a>
		</p>
		<p> 
			<a class="btn" href="?action=import_items">2. Import/Update Learning Objects from XSLX</a>
		</p>
		<p>
			<a class="btn" href="?action=import_items_images">3. Import/Rewrite images from directory</a>
		</p>
    
    <hr>
    
    <p id="uploader1">

			<div>
        <button id="pickfile1" class="btn">Upload XLSX files</button>
				<div id="filelist1" class="uploadQueue">
					<div id="upload-unavailable1">Your browser doesnt support HTML5, HTML4 and Flash.</div>
				</div>
			</div>
    
		</p>
    
    <hr>
		
		<?php  

		$sql = "SELECT * FROM `wp_ranks` ORDER BY `rank_id` DESC LIMIT 10;";
		
		$ranks = $wpdb->get_results($sql);
		
		?>
		
		<h2>Ranks</h2>
		
		<p>Last 10 ranks</p>
		
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>Item ID</th>
					<th>Item Type</th>
					<th>Date</th>
					<th>Value</th>
					<th>User ID</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($ranks): foreach ($ranks as $v): ?>
				<tr>
					<td><?php echo $v->item_id ?></td>
					<td><?php echo $v->item_type ? $v->item_type : 'Learning Object (WP)' ?></td>
					<td><?php echo $v->rank_created ?></td>
					<td><?php echo $v->value ?></td>
					<td><?php echo $v->user_id ?></td>
				</tr> 
				<?php endforeach; endif; ?>
			</tbody>
		</table>
		
		<?php 

		$sql = "SELECT * FROM `wp_favorites` ORDER BY `fav_id` DESC LIMIT 10;";
		
		$ranks = $wpdb->get_results($sql);
		
		?>
		
		<h2>Favorite items</h2>
		
		<p>Last 10 favorite</p>
		
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>Item ID</th>
					<th>Item Type</th>
					<th>Date</th>
					<th>User ID</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($ranks): foreach ($ranks as $v): ?>
				<tr>
					<td><?php echo $v->item_id ?></td>
					<td><?php echo $v->item_type ? $v->item_type : 'Learning Object (WP)' ?></td>
					<td><?php echo $v->fav_created ?></td>
					<td><?php echo $v->user_id ?></td>
				</tr> 
				<?php endforeach; endif; ?>
			</tbody>
		</table>
		
		<?php 

		$sql = "SELECT COUNT(*) AS `count` FROM `wp_apicache_items`;";
		$cached_items = $wpdb->get_results($sql);
		
		$sql = "SELECT COUNT(*) AS `count` FROM `wp_apicache_categories`;";
		$cached_categories = $wpdb->get_results($sql);
		
		$sql = "SELECT COUNT(*) AS `count` FROM `wp_apicache_tags`;";
		$cached_tags = $wpdb->get_results($sql);

		?>
		
		<h2>API Cache Status</h2>

		<table class="table table-bordered table-striped table-hover">
			<tbody> 
				<tr>
					<th>Last Cache Request</th>
					<td><?php echo WiseWireApi::get_option( 'cache_lasttime', 'unknown' ) ?></td>
				</tr>
				<tr>
					<th>Last Cache Duration (seconds)</th>
					<td><?php echo WiseWireApi::get_option( 'caching_duration', 'unknown' ) ?></td>
				</tr>
				<tr>
					<th style="max-width: 50%;">Cached Items</th>
					<td><?php echo $cached_items[0]->count ?></td>
				</tr>
				<tr>
					<th>Cached Items Categories</th>
					<td><?php echo $cached_categories[0]->count ?></td>
				</tr>
				<tr>
					<th>Cached Items Tags</th>
					<td><?php echo $cached_tags[0]->count ?></td>
				</tr>
			</tbody>
		</table>
		
		<a class="btn" href="?action=rebuild_cache">Refresh Cache</a> Be carefull while caching items from API will not be available on site.
		
    <?php /*
		<h2>Contributors</h2>

		<?php 

		$api_contributors = $wpdb->get_results("SELECT `userId`, `fullName` FROM `wp_apicache_contributors` ORDER BY `fullName`;");

		?>
		<p>All contributors imported from API</p>

		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($api_contributors): foreach ($api_contributors as $v): ?>
				<tr>
					<td><?php echo $v->userId ?></td>
					<td><?php echo $v->fullName ?></td>
				</tr>
				<?php endforeach; endif; ?>
			</tbody>
		</table>

		<a class="btn" href="?action=download_contributors">Download contributors from API</a>
	</div*/ ?>
	<?php else: ?>
	<div class="container">
		<form action="" method="post" class="form-import col-sm-4 col-sm-offset-4">
			<input type="hidden" name="action" value="login">
			<div class="form-group">
				<label>Login</label>
				<input type="text" name="login" class="form-control">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" name="password" class="form-control">
			</div>
			<input type="submit" class="btn" value="Login">
		</form>
	</div>
	<?php endif; ?>
    
  <script type='text/javascript' src='https://code.jquery.com/jquery-1.9.1.min.js'></script>
  <script type="text/javascript" src="http://wisewire.wordsandnumbers.com/wp-includes/plupload/js/plupload.js"></script>
  <script type="text/javascript" src="http://wisewire.wordsandnumbers.com/wp-includes/plupload/js/plupload.flash.js"></script>
  <script type="text/javascript" src="http://wisewire.wordsandnumbers.com/wp-includes/plupload/js/plupload.html4.js"></script>
  <script type="text/javascript" src="http://wisewire.wordsandnumbers.com/wp-includes/plupload/js/plupload.html5.js"></script>
    
  <script type="text/javascript">
    $(function(){
      var uploader = new plupload.Uploader({
        drop_element: 'uploader1',
        runtimes : 'html5,html4,flash',
        browse_button : 'pickfile1',
        container: 'uploader1',
        max_file_size : '30mb',
        chunk_size : '50kb',
        unique_names : true, 
        multi_selection: true,
        multipart: true,
        url : 'import.php?action=upload_import_file',
        flash_swf_url : 'http://wisewire.wordsandnumbers.com/wp-includes/plugins/plupload/js/plupload.flash.swf',
        filters : [
          {title : "File XLSX", extensions : "xlsx"}
        ],
        preinit : {
          UploadFile: function(up, file) {
            up.settings.multipart_params = {
              original_name: file.name
            };
          }
        }
      });
      uploader.bind('Init', function(up, params) {
        $('#upload-unavailable1').remove();
        $('#filelist1').hide(); 
      });
      uploader.init();
      uploader.bind('FilesAdded', function(up, files) {
        for (var i in files) {
          $('#filelist1').show().append('<div id="' + files[i].id + '" class="uploadQueueItem">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ')<div class="uploadProgress"><div class="uploadProgressBar" style="width: 0%;"></div></div></div>');
        }
        uploader.start();
      });
      uploader.bind('FileUploaded',function(up, file, info) {
        
        alert( info.response );
        
        // hide upload progress
        $('#'+file.id).slideUp(400,function(){
          $(this).remove();
        });
      });
      uploader.bind('UploadProgress', function(up, file) {
        $('#'+file.id+' .uploadProgress .uploadProgressBar').css('width', file.percent + "%");
        if (file.percent > 99) {
          $('#'+file.id).slideUp(400,function(){
            $(this).remove();
          });
        }
      });
      uploader.bind('UploadComplete', function(up, files) {
        $('#filelist1').slideUp();
      });
    });
  </script>
</body>
</html>