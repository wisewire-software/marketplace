<?php if (!defined('ABSPATH')) die(); ?>

<?php

// page controller

$gradelevels_nav = WiseWireApi::get_option('gradelevels_nav');
$gradelevels_lastchange = WiseWireApi::get_option('gradelevels_lastchange');

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
    
    ob_end_clean();

    require_once( ABSPATH . 'wp-includes/Helper_Plupload.php' );
    
    $upload = new Helper_Plupload();
    $upload_result = $upload->Upload( ABSPATH . '/tmp/' );

     if ($upload_result !== false) {
      
      //$message = 'Items from ZIP imported/updated';
      echo basename($upload_result);
    }

    die();
    
    break;
  
  case 'import_xlsx':
    
    ob_end_clean();
    
    set_time_limit(0);
    
    require_once( ABSPATH . 'wp-includes/WiseWireImportItems.php' );
    
    $upload_result = ABSPATH . '/tmp/' . basename($_REQUEST['file']);
    
    $import = new WiseWireImportItems(); 
    $import->import_single_file($upload_result); 

    unlink($upload_result);
    
    //$message = 'Items from XLSX imported/updated';

    die();
    
    break;
 
  case 'upload_import_images':
  
    ob_end_clean();
    
    require_once( ABSPATH . 'wp-includes/Helper_Plupload.php' );
    
    $upload = new Helper_Plupload();
    $upload_result = $upload->Upload( ABSPATH . '/tmp/' );

    if ($upload_result !== false) {
      
      //$message = 'Items from ZIP imported/updated';
      echo basename($upload_result);
    }
    
    die();
    
    break;
    
  case 'import_images':
  
    ob_end_clean(); 

    set_time_limit(0);

    require_once( ABSPATH . 'wp-includes/WiseWireImportItems.php' );
    
    $upload_result = ABSPATH . '/tmp/' . basename($_REQUEST['file']);
    
    mkdir('/var/www/html/tmp/unziped',0755,true);

    $zip = new ZipArchive;
    if ($zip->open($upload_result) === TRUE) {
        $zip->extractTo('/var/www/html/tmp/unziped/');
        $zip->close();
    }

    $dirname = str_replace('.zip','',basename($_REQUEST['file']));

    $import = new WiseWireImportItems();  
    $import->import_ziped_images('/var/www/html/tmp/unziped/');
    
    system("rm -rf ".escapeshellarg('/var/www/html/tmp/unziped/'));
      
    unlink($upload_result);
    
    die();
    
    break;
  
  case 'turn_on_fullnav':
    $gradelevels_nav = 'full';
    $gradelevels_lastchange = date('Y-m-d H:i:s');
    WiseWireApi::set_option('gradelevels_nav', $gradelevels_nav);
    WiseWireApi::set_option('gradelevels_lastchange', $gradelevels_lastchange);

    break;
  
  case 'turn_off_fullnav':
    $gradelevels_nav = 'limited';
    $gradelevels_lastchange = date('Y-m-d H:i:s');
    WiseWireApi::set_option('gradelevels_nav', $gradelevels_nav);
    WiseWireApi::set_option('gradelevels_lastchange', $gradelevels_lastchange);
    
    break;
}

?>

<style type="text/css">
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

<div class="wrap">
  <h1 style="border-bottom: 1px #ddd solid;margin-bottom: 20px;">WiseWire Control Panel</h1>
  
  
  
  <div style="float: left; width: 48%;clear: left;">

    <div style="border: 1px #ddd solid;background:#fff;padding:20px;ffont-size: 13px;margin-bottom: 20px;">
      <p style="font-size:18px;margin-top:0;font-weight:bold;">LO Items - Bulk Upload.</p>
      <p><strong>XLSX file:</strong><br>Please make sure that the columns match inside the Excel File otherwise the file won't be imported.</p>
      <p><strong>Assets:</strong><br>Please make sure that the zip folder has following structure:</p>
      
      <style type="text/css">
       .assets ul {
          list-style-type: disc;
          padding-left: 20px;
        }  
      </style>
      
      <div class="assets">
        <ul class="assets">
          <li>123456 <small>(ObjectID parent folder)</small></li>
          <ul>
            <li>main_ObjectID.jpg <small>(Main Thumbnail)</small></li>
            <li>demo_carousel_001_ObjectID.jpg <small>(Preview: Carousel image)</small></li>
            <li>demo_carousel_002_ObjectID.jpg <small>(Preview: Carousel image)</small></li>
            <li>demo_carousel_003_ObjectID.jpg <small>(Preview: Carousel image)</small></li>
            <li>demo_pdf_OBJECTID.jpg <small>(Preview: PDF file)</small></li>
            <li>pdf_cta_ObjectID.pdf <small>(CTA Button: PDF file)</small></li>
          </ul>
        </ul>
      </div>

    </div>
    		
		<div style="padding:20px;background-color: #fff;border: 1px #ddd solid;">
  		
  		<h3 style="margin-top:0;">LO Items - Bulk Upload</h3>
  		
      <!--h4>Direct upload by sending files</h4-->
      
      <div id="uploader1" style="position: relative;margin-bottom: 20px;">
  
  			<div>
          <button id="pickfile1" class="button button-primary">Upload XLSX files</button>
  				<div id="filelist1" class="uploadQueue">
  					<div id="upload-unavailable1">Your browser doesnt support HTML5, HTML4 and Flash.</div>
  				</div>
  			</div>
          
        <p style="display: none" class="import-progress">
          Upload has been completed.<br />
          XLSX file is now processed, <strong>please dont close this page...</strong> <span class="spinner is-active" style="float: none;"></span>
        </p>
        
        <p style="display: none" class="import-completed">
          LO have been correctly imported.
        </p>
      
  		</div>
      
      <div id="uploader2" style="position: relative;">
  
  			<div>
          <button id="pickfile2" class="button button-primary">Upload Assets as a ZIP archive</button>
  				<div id="filelist2" class="uploadQueue">
  					<div id="upload-unavailable2">Your browser doesnt support HTML5, HTML4 and Flash.</div>
  				</div>
  			</div>
          
        <p style="display: none" class="import-progress">
          Upload has been completed.<br />
          Assets are now processed, <strong>please dont close this page...</strong> <span class="spinner is-active" style="float: none;"></span>
        </p>
        
        <p style="display: none" class="import-completed">
          Assets have been correctly imported.
        </p>
      
  		</div>
  		
		</div>
    
    <!--hr>
    
    <h4>Indirect import using FTP</h4>
    
    <p>
			<a class="button" href="?page=wisewire-control-panel&amp;action=download_items">1. Download Learning Objects from client's FTP</a>
		</p>
		<p> 
			<a class="button" href="?page=wisewire-control-panel&amp;action=import_items">2. Import/Update Learning Objects from XSLX</a>
		</p>
		<p>
			<a class="button" href="?page=wisewire-control-panel&amp;action=import_items_images">3. Import/Rewrite images from directory</a>
		</p-->
    
    <hr>
		
		
  </div>
  
    
  <div style="width: 48%; float: right;">

    <div style="border: 1px #ddd solid;background:#fff;padding:20px;font-weight:bold;font-size: 13px;margin-bottom: 20px;color:red;">
      This section can be only used by developers so please do not click anything.
    </div>
    
    <div style="border: 1px #ddd solid;background:#fff;padding:20px;font-weight:bold;font-size: 13px;margin-bottom: 20px;">
      We automatically import items from the platform using CRON once daily at 00:00 server time. <br>
      0 0 * cd /var/www/html; php /var/www/html/import.php rebuild_cache > /dev/null 2>&1
    </div>    
  
    <?php  

		$sql = "SELECT COUNT(*) AS `count` FROM `wp_apicache_items`;";
		$cached_items = $wpdb->get_results($sql);
		
		$sql = "SELECT COUNT(*) AS `count` FROM `wp_apicache_categories`;";
		$cached_categories = $wpdb->get_results($sql);
		
		$sql = "SELECT COUNT(*) AS `count` FROM `wp_apicache_tags`;";
		$cached_tags = $wpdb->get_results($sql);

		?>
		
		<h3>API Cache Status</h3>

		<table class="wp-list-table widefat fixed striped">
			<tbody> 
				<tr>
					<th>Last Cache Request</th>
					<td><?php echo WiseWireApi::get_option( 'cache_lasttime' ) ?></td>
				</tr>
				<tr>
					<th>Last Cache Duration (seconds)</th>
					<td><?php echo WiseWireApi::get_option( 'caching_duration' ) ?></td>
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
		
    <div class="tablenav bottom" style="margin-bottom:20px;height: auto;">
      <p>Important: while caching items from API they are not visible on the marketplace site.</p>
      <p><a class="button button-primary" style="background-color:red; border-color: red;" href="?post_type=item&amp;page=wisewire-control-panel&amp;action=rebuild_cache">Refresh Cache</a></p>
      
    </div>
    
    <hr>
      
    <h3>Categories</h3>

    <?php 

    $api_categories_count = $wpdb->get_results("SELECT `api_type`, COUNT(*) AS `count` FROM {$wpdb->terms} WHERE `api_id` > 0 GROUP BY `api_type` ORDER BY 2 DESC;");

    ?>
    <p>All categories imported from API by Groups.</p>

    <table class="wp-list-table widefat fixed striped">
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

    <div class="tablenav bottom" style="margin-bottom:20px;height: auto;">
      <a class="button" href="?post_type=item&amp;page=wisewire-control-panel&amp;action=download_categories_xml">Download categories XML from API to server</a>
      <a class="button button-primary" style="float: right; background-color:red; border-color: red;" href="?post_type=item&amp;page=wisewire-control-panel&amp;action=import_categories">Import XML to WP database</a>
    </div>
    
    <?php  

		$sql = "SELECT * FROM `wp_ranks` ORDER BY `rank_id` DESC LIMIT 10;";

		$ranks = $wpdb->get_results($sql);
		
		?>
    
    <hr>
    
    <?php 

		$sql = "SELECT COUNT(*) AS `count`, t.`term_id`, term.`name`, term.`slug` FROM {$wpdb->posts} p "
		. "LEFT JOIN `wp_term_relationships` r ON r.`object_id` = p.`ID` "
		. "LEFT JOIN `wp_term_taxonomy` t ON t.`term_taxonomy_id` = r.`term_taxonomy_id` "
		. "LEFT JOIN `wp_terms` term ON term.`term_id` = t.`term_id` "
		. "WHERE p.`post_type` = 'item' AND t.`taxonomy` = 'category' "
		. "GROUP BY t.`term_id` ORDER BY 1 DESC LIMIT 15;";
		
		$api_items_count = $wpdb->get_results($sql);
		
		?>
		    
		<p>Items count by category in most popular categories.</p>
		
		<table class="wp-list-table widefat fixed striped" style="margin-bottom: 20px;">
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
		
		    
    <hr>
    
    
    <h3>Level Grades Navigation</h3>

		<table class="wp-list-table widefat fixed striped">
			<tbody> 
				<tr>
					<th>Last Change</th>
					<td><?php echo $gradelevels_lastchange ?></td>
				</tr>
				<tr>
					<th>Actual Navigation</th>
					<td><?php echo $gradelevels_nav == 'full' ? 'full with subgrades' : 'limited to main grades' ?></td>
				</tr>
			</tbody>
		</table>
		
    <div class="tablenav bottom" style="margin-bottom:20px;height: auto;">
      <?php if ($gradelevels_nav != 'full'): ?>
      <p><a class="button button-primary" style="" href="?post_type=item&amp;page=wisewire-control-panel&amp;action=turn_on_fullnav">Turn ON full navigation</a></p>
      <?php else: ?>
      <p><a class="button button-primary" style="background: red; border-color: red;" href="?post_type=item&amp;page=wisewire-control-panel&amp;action=turn_off_fullnav">Disable full navigation</a></p>
      <?php endif; ?>
      
    </div>    
		
		
		<?php
  		/*
		<h3>Ranks</h3>
		
		<p>Last 10 ranks</p>
		
		<table class="wp-list-table widefat fixed striped" style="margin-bottom: 20px;">
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
		*/ ?>
		
      
    
		<?php
  		/*
		
		<?php 

		$sql = "SELECT * FROM `wp_favorites` ORDER BY `fav_id` DESC LIMIT 10;";
		
		$ranks = $wpdb->get_results($sql);
		
		?>
    
    <hr>
		
		<h3>Favorite items</h3>
		
		<p>Last 10 favorite</p>
		
		<table class="wp-list-table widefat fixed striped" style="margin-bottom: 20px;">
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
		
		*/ ?>
    
  </div>

</div> 

<script type='text/javascript' src='https://code.jquery.com/jquery-1.9.1.min.js'></script>
<script type="text/javascript" src="/wp-includes/plupload/js/plupload.js"></script>
<script type="text/javascript" src="/wp-includes/plupload/js/plupload.flash.js"></script>
<script type="text/javascript" src="/wp-includes/plupload/js/plupload.html4.js"></script>
<script type="text/javascript" src="/wp-includes/plupload/js/plupload.html5.js"></script>

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
      url : '/wp-content/plugins/ww-sync-products/WiseWireSyncProducts.php?manual=1&import_test=1&action=upload_import_file',
      flash_swf_url : '/wp-includes/plugins/plupload/js/plupload.flash.swf',
      filters : [
        {title : "File XLSX", extensions : "xlsx,xls"}
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
    	console.log(up);
		console.log(file);
      	console.log( info );
      $('#uploader1').find('.import-progress').slideDown();
      
      $.post('/wp-content/plugins/ww-sync-products/WiseWireSyncProducts.php?manual=1&import_test=1&action=import_xlsx&file='+file.target_name,{},function(data){
        $('#uploader1').find('.import-progress').slideUp();
        if (data) {
        	
        	console.log(data);
          	// alert(data);
        } else {
          $('#uploader1').find('.import-completed').slideDown();
          setTimeout(function(){
            $('#uploader1').find('.import-completed').slideUp();
          },5000);  
        }
      });

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
    
    
    
    
    
    var uploader2 = new plupload.Uploader({
      drop_element: 'uploader2',
      runtimes : 'html5,html4,flash',
      browse_button : 'pickfile2',
      container: 'uploader2',
      max_file_size : '100mb', 
      chunk_size : '50kb',
      unique_names : false, 
      multi_selection: true,
      multipart: true,
      url : '/wp-content/plugins/ww-sync-products/WiseWireSyncProducts.php?manual=1&import_test=1&action=upload_import_images',
      flash_swf_url : '/wp-includes/plugins/plupload/js/plupload.flash.swf',
      filters : [
        {title : "ZIP file", extensions : "zip"}
      ],
      preinit : {
        UploadFile: function(up, file) {
          up.settings.multipart_params = {
            original_name: file.name
          };
        }
      }
    });
    uploader2.bind('Init', function(up, params) {
      $('#upload-unavailable2').remove();
      $('#filelist2').hide(); 
    });
    uploader2.init();
    uploader2.bind('FilesAdded', function(up, files) {
      for (var i in files) {
        $('#filelist2').show().append('<div id="' + files[i].id + '" class="uploadQueueItem">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ')<div class="uploadProgress"><div class="uploadProgressBar" style="width: 0%;"></div></div></div>');
      }
      uploader2.start();
    });
    uploader2.bind('FileUploaded',function(up, file, info) {

      //alert( info.response );
      $('#uploader2').find('.import-progress').slideDown();
      
      $.post('/wp-content/plugins/ww-sync-products/WiseWireSyncProducts.php?manual=1&import_test=1&action=import_images&file='+info.response,{},function(data){
        $('#uploader2').find('.import-progress').slideUp();
        $('#uploader2').find('.import-completed').slideDown();
        setTimeout(function(){
          $('#uploader2').find('.import-completed').slideUp();
        },5000); 
      });

      // hide upload progress
      $('#'+file.id).slideUp(400,function(){
        $(this).remove();
      });
    });
    uploader2.bind('UploadProgress', function(up, file) {
      $('#'+file.id+' .uploadProgress .uploadProgressBar').css('width', file.percent + "%");
      if (file.percent > 99) {
        $('#'+file.id).slideUp(400,function(){
          $(this).remove();
        });
      }
    });
    uploader2.bind('UploadComplete', function(up, files) {
      $('#filelist2').slideUp();
    });
  });
</script>