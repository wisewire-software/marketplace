<?php

if($_GET['manual'] == 1 || $_POST['manual'] == 1){
	require_once('../../../wp-load.php' );
} else{
	require_once(ABSPATH.'wp-load.php' );
}

// no time limits
  	set_time_limit(0);

  	// more memory 
  	ini_set('memory_limit','512M');
	ini_set('display_errors',0);
	ini_set('display_startup_errors', 0);


if($_GET['import_test'] == 1 &&  $_GET['manual'] == 1){

		// page controller

		$gradelevels_nav = WiseWireApi::get_option('gradelevels_nav');
		$gradelevels_lastchange = WiseWireApi::get_option('gradelevels_lastchange');

		switch ($_REQUEST['action']) {

		  case 'download_categories_xml':

			require_once( '../../../wp-includes/WiseWireImportCategories.php' );

			$import = new WiseWireImportCategories();
			$import->download();

			$message = 'Categories XML file downloaded to server, now You can import them to WP database';

		  break;

		  case 'import_categories':

			require_once('../../../wp-includes/WiseWireImportCategories.php' );

			$import = new WiseWireImportCategories();
			$import->parseXml();

			$message = 'Categories from XML imported into WP database';

		  break;

		  case 'download_items':

			require_once( '../../../wp-includes/WiseWireImportItems.php' );

			$import = new WiseWireImportItems();
			$import->download_remote_files();

			$message = 'Files downloaded.';

		  break;

		  case 'import_items':

			require_once( '../../../wp-includes/WiseWireImportItems.php' );

			$import = new WiseWireImportItems();
			$import->import();

			$message = 'Items from XLSX imported/updated';

		  break;

		  case 'import_items_images':

			require_once( '../../../wp-includes/WiseWireImportItems.php' );

			$import = new WiseWireImportItems();
			$import->import_images();

			$message = 'Images imported';

		  break;

		  case 'rebuild_cache':

			require_once( '../../../wp-includes/WiseWireApiCache.php' );

			$cache = new WiseWireApiCache();
			$cache->cache_pod(true);
			$cache->cache(true);


		  break;

		  case 'fix_thumbnails_relations':

			require_once( '../../../wp-includes/WiseWireImportItems.php' );

			$import = new WiseWireImportItems();
			$import->fix_thumbnails_relations();

			$message = 'Images relations fixed';

		  break;

		  case 'download_contributors':

			require_once( '../../../wp-includes/WiseWireImportContributors.php' );

			$import = new WiseWireImportContributors();
			$data = $import->download();
			$import->import($data);

			$message = 'Contributors downloaded successfully';

		  break;

		  case 'upload_import_file':

			ob_end_clean();

			require_once( '../../../wp-includes/Helper_Plupload.php' );

			$upload = new Helper_Plupload();
			$upload_result = $upload->Upload( '../../../tmp/' );

			 if ($upload_result !== false) {

			  //$message = 'Items from ZIP imported/updated';
			  echo basename($upload_result);
			}

			die();

			break;

		  case 'import_xlsx':

			ob_end_clean();

			set_time_limit(0);

			require_once( '../../../wp-includes/WiseWireImportItems.php' );

			$upload_result ='../../../tmp/' . basename($_REQUEST['file']);

			$import = new WiseWireImportItems();
			$import->import_single_file($upload_result);

			unlink($upload_result);

			$message = 'Items from XLSX imported/updated';

			die();

			break;

		  case 'upload_import_images':

			ob_end_clean();

			require_once( '../../../wp-includes/Helper_Plupload.php' );

			$upload = new Helper_Plupload();
			$upload_result = $upload->Upload( '../../../tmp/' );

			if ($upload_result !== false) {

			  //$message = 'Items from ZIP imported/updated';
			  echo basename($upload_result);
			}

			echo $message;

			die();

			break;

		  case 'import_images':

			ob_end_clean();

			set_time_limit(0);

			require_once( '../../../wp-includes/WiseWireImportItems.php' );

			$upload_result = '../../../tmp/' . basename($_REQUEST['file']);

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

};


class WiseWireSyncProducts{

	private $wpdb;
 	
	public function __construct() {
		
		global $wpdb;
		
		$this->wpdb = $wpdb;
		
		// Get Default Prices  
  
		$price_assessment = $this->wpdb->get_results("SELECT option_value FROM `wp_options` WHERE `option_name` = 'options_ww_price_assessment'");
		$price_tei = $this->wpdb->get_results("SELECT option_value FROM `wp_options` WHERE `option_name` = 'options_ww_price_tei'");
		$price_non_tei = $wpdb->get_results("SELECT option_value FROM `wp_options` WHERE `option_name` = 'options_ww_price_non_tei'");

		$this->p_assessment = $price_assessment[0]->option_value;
		$this->p_price_tei = $price_tei[0]->option_value;
		$this->p_price_non_tei = $price_non_tei[0]->option_value;

    
	}

	
	/* Added by helloARI to sync WooCommerce Products */

	public function get_product_by_sku( $sku ) {

	  $product_id = $this->wpdb->get_var( $this->wpdb->prepare( "SELECT post_id FROM wp_postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );

	  if ( $product_id ) return $product_id;

	  return false;

	}
	
	public function get_lo_item_by_sku( $sku ) {

	  $lo_item_id = $this->wpdb->get_var( $this->wpdb->prepare( "SELECT ID FROM wp_posts wp INNER JOIN `wp_postmeta` wm ON (wm.`post_id` = wp.`ID`) WHERE wp.post_type = 'item' AND wm.meta_key = 'item_object_id' AND wm.meta_value = '%s' AND wp.post_status = 'publish' GROUP BY ID LIMIT 1", $sku ) );
	  
	  

	  if ( $lo_item_id ) return $lo_item_id;

	  return false;

	}
	
	
public function wisewire_vendor_by_email($vendor_email){
	global $wpdb;
	
	$is_user = get_user_by('email',$vendor_email);
	
	if($is_user){
        $vendor_id_pre = $wpdb->get_results( "SELECT term_id FROM wp_termmeta WHERE meta_key = 'vendor_data' AND meta_value LIKE '%".$is_user->ID."%'",OBJECT );
        $vendor_id = $vendor_id_pre[0]->term_id;
        $vendor_data_pre = $wpdb->get_results( "SELECT meta_value FROM wp_termmeta WHERE term_id = ".$vendor_id,OBJECT );
        $vendor_data = unserialize($vendor_data_pre[0]->meta_value);

        $vendor_admins = explode(',',$vendor_data['admins']);

        if (($key = array_search($is_user->ID, $vendor_admins)) === false) {
            unset($vendor_admins[$key]);
        }

        $vendor_admins = array_values(array_filter($vendor_admins));
        $vendor_admin = $vendor_admins[0];

        if($vendor_admin){
            $vid = $vendor_id;
        } else{
            $vid = '';
        }

        $user = $is_user;

        $vendor = array();
        $vendor['user'] = $user;
        $vendor['id'] = $vid;
        $vendor['data'] = $vendor_data;
        $vendor['admin'] = $vendor_admin;
	} else{
		unset($vendor);	
	
	}
		
	return $vendor;
}

public function wisewire_log_vendors($message){
	// Write To Log
		// file_put_contents( plugin_dir_path( __FILE__ ) ."log/vendor_errors.log",  date("Y-m-d h:i:sa")." - ".$message." - User Does Not Exist. \n" , FILE_APPEND );
	return;
}

public function wisewire_vendor_data($vendor_name){
	global $wpdb;
	$vendor_id_pre = $wpdb->get_results( "SELECT term_id FROM wp_terms WHERE name LIKE '".$vendor_name."'",OBJECT );
	$vendor_id = $vendor_id_pre[0]->term_id;
	$vendor_data_pre = $wpdb->get_results( "SELECT meta_value FROM wp_termmeta WHERE meta_key LIKE 'vendor_data' AND term_id = ".$vendor_id,OBJECT );
	$vendor_data = unserialize($vendor_data_pre[0]->meta_value);
	$vendor_admins = $vendor_data['admins'];	
	
	$user = get_user_by('id',$vendor_admins);
	$vendor = array();
	$vendor['user'] = $user;
	$vendor['id'] = $vendor_id;
	$vendor['data'] = $vendor_data;
	$vendor['admin'] = $vendor_admins;
	return $vendor;
}

public function get_id_by_meta($meta, $value){
	global $wpdb;
	$post = $wpdb->get_results("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '".$meta."' AND  meta_value = '".$value."' LIMIT 1", ARRAY_A);
	return $post;
}

public function get_previous_vendor($prod_id){
	global $wpdb;

	$test = $wpdb->get_results("SELECT wp_term_relationships.term_taxonomy_id 
		FROM wp_posts as m
	LEFT JOIN wp_term_relationships ON(m.ID = wp_term_relationships.object_id)
	LEFT JOIN wp_term_taxonomy ON(wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id)
	LEFT JOIN wp_terms ON(wp_term_taxonomy.term_id = wp_terms.term_id)  
	WHERE m.post_type = 'product' 
	AND m.ID = ".$prod_id."
	AND wp_term_taxonomy.taxonomy = 'wcpv_product_vendors'");
	return $test[0]->term_taxonomy_id;
	
}



/*-------------------------------------------------------------------------------------------------
 LO ITEM SCRIPTS
------------------------------------------------------------------------------------------------- */

/* ADD LO PRODUCT FROM DATABASE ----------------------------- */

	public function add_lo_product($post){
			wp_suspend_cache_addition(true);

			$product_price = $post->item_price;
			$forsale = $post->for_sale;
			$product_title = $post->post_title;
			$product_type = $post->item_type;
			$product_vendor = $post->contributor;
			// $product_file = $post->thefile;
			$product_desc = $post->thedescription;
			$product_sku = $post->sku;
			$product_lang = $post->language;
			$product_objtype = $post->object_type;
			
			$vendorId = $post->vendorId; // email
			
			// PRODUCT VENDORS
			if($vendorId){
				$commission      = get_option( 'wcpv_vendor_settings_default_commission' );
				$commission_type = get_option( 'wcpv_vendor_settings_default_commission_type' );
				$vendor_data = $this->wisewire_vendor_by_email($vendorId);
				$vendor_admin = $vendor_data['admin'];
				$vendor_id = $vendor_data['id'];		
				
				if($vendor_data){
					
				} else{
					
					// Vendor Doesn't Exist
					$this->wisewire_log_vendors($vendorId);	
				}
				
			} 
			
			
			$product_file = '/var/www/downloads/'.$product_sku.'.pdf';
			

			if($product_price === null){
				$price = 0;
			} else{
				$price = $product_price;
			}
	

			$_file_paths = array();
			// file paths will be stored in an array keyed off md5(file path)
			$downdloadArray =array('name'=>esc_sql($product_title), 'file' => $product_file);
			$file_path =md5($product_file);
			$_file_paths[$file_path ] = $downdloadArray;

			$this->wpdb->query("SET autocommit=0;");

			$sql = $this->wpdb->prepare('INSERT INTO wp_posts (post_type,post_title,post_content,post_name,post_date,post_date_gmt,post_modified,post_modified_gmt,post_author,post_status) VALUES ("product","'.esc_sql($product_title).'","'.esc_sql($product_desc).'","'.esc_sql($product_sku).'",now(),now(),now(),now(),1,"publish");');

			$this->wpdb->query($sql);
			/* Product Meta */
			$sid = $this->wpdb->insert_id;

			$sql = $this->wpdb->prepare("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (".$sid.", '_sku', '".$product_sku."'),(".$sid.", '_price', '".$price."'),(".$sid.", '_stock_status', 'instock'),(".$sid.", '_visibility', 'visible' ),(".$sid.", '_downloadable', 'yes'),(".$sid.", '_sold_individually', 'yes'),(".$sid.", '_virtual', 'yes'),(".$sid.", '_regular_price', '".$price."' ),(".$sid.", '_manage_stock', 'no' ),(".$sid.", '_backorders', 'no' ),(".$sid.", '_downloadable_files', '".serialize($_file_paths)."'),(".$sid.", 'woo_limit_one_select_dropdown', '1'),(".$sid.", 'woo_limit_one_purchased_text', 'You have already purchased this item.'),(".$sid.", '_wcpv_product_commission', '".$commission."'),(".$sid.", 'userEmail', '".$vendorId."'); ");
	

			$this->wpdb->query($sql);

			$catid = get_term_by('name', $product_type, 'product_cat');
			$objtype = get_term_by('name', $product_objtype, 'ObjectType');
			
			
			wp_set_post_terms( $sid, array($catid->term_id), 'product_cat' );
			wp_set_post_terms( $sid, array($objtype->term_id), 'ObjectType' );
			
			
			if($vendor_id){
	
				$sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (".$sid.", '".$vendor_id."', '0');");
			
				$this->wpdb->query($sql);
				
			} else{
				// Log Here
				/*
				*/	
				
			}
			// $this->wpdb->query($sql);

			$this->wpdb->query("COMMIT;");
			$this->wpdb->query("SET autocommit=1;");
	}

/*  UPDATE LO PRODUCT FROM DATABASE ----------------------------- */

	public function update_lo_product($post,$prod_id){

			$product_price = $post->item_price;
			$forsale = $post->for_sale;
			$product_title = $post->post_title;
			$product_type = $post->item_type;
			$product_vendor = $post->contributor;
			$commission = get_option( 'wcpv_vendor_settings_default_commission' );
			// $product_file = $post->thefile;
			$product_desc = $post->thedescription;
			$product_sku = $post->sku;
			$product_lang = $post->language;
			$product_objtype = $post->object_type;
			
			$vendorId = $post->vendorId; // email
			
			// PRODUCT VENDORS
			if($vendorId){
				$commission      = get_option( 'wcpv_vendor_settings_default_commission' );
				$commission_type = get_option( 'wcpv_vendor_settings_default_commission_type' );
				$vendor_data = $this->wisewire_vendor_by_email($vendorId);
				$vendor_admin = $vendor_data['admin'];
				$vendor_id = $vendor_data['id'];
			}
			
			$product_file = '/var/www/downloads/'.$product_sku.'.pdf';
			

			if($product_price === null){
				$price = 0;
			} else{
				$price = $product_price;
			}
			
			
	

			$post_id = $prod_id;

			$_file_paths = array();
			// file paths will be stored in an array keyed off md5(file path)
			$downdloadArray =array('name'=>$product_title, 'file' => $product_file);
			$file_path =md5($product_file);
			$_file_paths[$file_path ] = $downdloadArray;
			
			$this->wpdb->query("SET autocommit=0;");

			$sql = $this->wpdb->prepare("UPDATE wp_postmeta
				SET meta_value = (case when meta_key = '_sku' then '".$product_sku."'
				 when meta_key  = '_price' then '".$price."'
				when meta_key  = '_stock_status' then 'instock'
				when meta_key  = '_visibility' then 'visible'
				when meta_key  = '_downloadable' then 'yes'
				when meta_key  = '_sold_individually' then 'yes'
				when meta_key  = '_virtual' then 'yes'
				when meta_key  = '_regular_price' then '".$price."'
				when meta_key  = '_manage_stock' then 'no'
				when meta_key  = '_backorders' then 'no'
				when meta_key  = '_downloadable_files' then '".serialize($_file_paths)."'
				end)
				WHERE post_id = '".$prod_id."' ");

			$this->wpdb->query($sql);
			
			
			// Add Post Meta to restrict Product only 1 purchase per customer.
			
			$sql = $this->wpdb->prepare("DELETE FROM wp_postmeta WHERE post_id = ".$prod_id." AND meta_key = 'woo_limit_one_select_dropdown';");
	 		$this->wpdb->query($sql);
			
			$sql = $this->wpdb->prepare("DELETE FROM wp_postmeta WHERE post_id = ".$prod_id." AND meta_key = 'woo_limit_one_purchased_text';");
	 		$this->wpdb->query($sql);
			
			$sql = $this->wpdb->prepare("DELETE FROM wp_postmeta WHERE post_id = ".$prod_id." AND meta_key = '_wcpv_product_commission';");
	 		$this->wpdb->query($sql);
	  
			$sql = $this->wpdb->prepare("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (".$prod_id.", 'woo_limit_one_select_dropdown', '1'),(".$prod_id.", 'woo_limit_one_purchased_text', 'You have already purchased this item.'),(".$prod_id.", '_wcpv_product_commission', '".$commission."'); ");
			
			$this->wpdb->query($sql);
			
			// End Product Limit


			// Add Product Categories
			$catid = get_term_by('name', $product_type, 'product_cat');
			$objtype = get_term_by('name', $product_objtype, 'ObjectType');
			
			wp_set_post_terms( $prod_id, array($catid->term_id), 'product_cat' );
			wp_set_post_terms( $prod_id, array($objtype->term_id), 'ObjectType' );
	
			if($vendor_id){
	
				$sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (".$prod_id.", '".$vendor_id."', '0');");
			
				$this->wpdb->query($sql);
				
			} else{
				// Log Here
				/*
				*/	
				
			}
	
			$this->wpdb->query("COMMIT;");
			$this->wpdb->query("SET autocommit=1;");

			$stuff['errors'] = $this->wpdb->last_error;
			$stuff['cats'] = $product_type;

			return $stuff;
		
	}
	
	

/* ADD LO PRODUCT FROM UPLOAD ----------------------------- */

	public function add_lo_upload_product($post){
			wp_suspend_cache_addition(true);

		$product_price = $post['E'];
		$forsale = $post['V'];
		$product_title = $post['A'];
		$product_type = $post['L'];
		$product_vendor = $post['P'];
		// $product_file = $post['AI'];
		$product_desc = $post['Z'];
		$product_sku = $post['B'];
		$product_lang = $post['Y'];
		$product_objtype = $post['O'];
		
		$vendorId = $post['AM']; // email
	
		// PRODUCT VENDORS
		if($vendorId){
			$commission      = get_option( 'wcpv_vendor_settings_default_commission' );
			$commission_type = get_option( 'wcpv_vendor_settings_default_commission_type' );
			$vendor_data = $this->wisewire_vendor_by_email($vendorId);
			$vendor_admin = $vendor_data['admin'];
			$vendor_id = $vendor_data['id'];		
			
			if($vendor_data){
				
			} else{
				
				// Vendor Doesn't Exist
				$this->wisewire_log_vendors($vendorId);	
			}
			
		} 
			
		
		$product_file = '/var/www/downloads/'.$product_sku.'.pdf';


			if($product_price === null){
				$price = 0;
			} else{
				$price = $product_price;
			}
	

			$_file_paths = array();
			// file paths will be stored in an array keyed off md5(file path)
			$downdloadArray =array('name'=>esc_sql($product_title), 'file' => $product_file);
			$file_path =md5($product_file);
			$_file_paths[$file_path ] = $downdloadArray;

			$this->wpdb->query("SET autocommit=0;");

			$sql = $this->wpdb->prepare('INSERT INTO wp_posts (post_type,post_title,post_content,post_name,post_date,post_date_gmt,post_modified,post_modified_gmt,post_author,post_status) VALUES ("product","'.esc_sql($product_title).'","'.esc_sql($product_desc).'","'.$product_sku.'",now(),now(),now(),now(),1,"publish");');

			$this->wpdb->query($sql);
			/* Product Meta */
			$sid = $this->wpdb->insert_id;

			$sql = $this->wpdb->prepare("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (".$sid.", '_sku', '".$product_sku."'),(".$sid.", '_price', '".$price."'),(".$sid.", '_stock_status', 'instock'),(".$sid.", '_visibility', 'visible' ),(".$sid.", '_downloadable', 'yes'),(".$sid.", '_sold_individually', 'yes'),(".$sid.", '_virtual', 'yes'),(".$sid.", '_regular_price', '".$price."' ),(".$sid.", '_manage_stock', 'no' ),(".$sid.", '_backorders', 'no' ),(".$sid.", '_downloadable_files', '".addslashes(serialize($_file_paths))."'),(".$sid.", 'woo_limit_one_select_dropdown', '1'),(".$sid.", 'woo_limit_one_purchased_text', 'You have already purchased this item.'),(".$sid.", '_wcpv_product_commission', '".$commission."'),(".$sid.", 'userEmail', '".$vendorId."'); ");

			$this->wpdb->query($sql);
			
			$catid = get_term_by('name', $product_type, 'product_cat');
			$objtype = get_term_by('name', $product_objtype, 'ObjectType');
			
			
			if($vendor_id){
	
				$sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (".$sid.", '".$vendor_id."', '0');");
			
				$this->wpdb->query($sql);
				
			} else{
				// Log Here
				/*
				*/	
				
			}
			
			$sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (".$sid.", '".$catid->term_taxonomy_id."', '0');");


			$this->wpdb->query($sql);
	

			$this->wpdb->query("COMMIT;");
			$this->wpdb->query("SET autocommit=1;");
	}
	
	
	

/* UPDATE LO PRODUCT FROM UPLOAD ----------------------------- */


	public function update_lo_upload_product($post,$prod_id){

		$product_price = $post['E'];
		$forsale = $post['V'];
		$product_title = $post['A'];
		$product_type = $post['L'];
		$product_vendor = $post['P'];
		// $product_file = $post['AI'];
		$product_desc = $post['Z'];
		$product_sku = $post['B'];
		$product_lang = $post['Y'];
		$product_objtype = $post['O'];
		
		$vendorId = $post['AM'];
		
		$lo_post_id = $this->get_lo_item_by_sku($product_sku);
		
		// PRODUCT VENDORS
		if($vendorId){
			$commission      = get_option( 'wcpv_vendor_settings_default_commission' );
			$commission_type = get_option( 'wcpv_vendor_settings_default_commission_type' );
			$vendor_data = $this->wisewire_vendor_by_email($vendorId);
			$vendor_admin = $vendor_data['admin'];
			$vendor_id = $vendor_data['id'];		
			
			if($vendor_data){
				
			} else{
				
				// Vendor Doesn't Exist
				$this->wisewire_log_vendors($vendorId);	
			}
			
		} 
		
	
			
	
		$product_file = '/var/www/downloads/'.$product_sku.'.pdf';

			if($product_price === null){
				$price = 0;
			} else{
				$price = $product_price;
			}
	

			$post_id = $prod_id;

			$_file_paths = array();
			// file paths will be stored in an array keyed off md5(file path)
			$downdloadArray =array('name'=>$product_title, 'file' => $product_file);
			$file_path =md5($product_file);
			$_file_paths[$file_path ] = $downdloadArray;
			
			$this->wpdb->query("SET autocommit=0;");

			$sql = $this->wpdb->prepare("UPDATE wp_postmeta
				SET meta_value = (case when meta_key = '_sku' then '".$product_sku."'
				 when meta_key  = '_price' then '".$price."'
				when meta_key  = '_stock_status' then 'instock'
				when meta_key  = '_visibility' then 'visible'
				when meta_key  = '_downloadable' then 'yes'
				when meta_key  = '_sold_individually' then 'yes'
				when meta_key  = '_virtual' then 'yes'
				when meta_key  = '_regular_price' then '".$price."'
				when meta_key  = '_manage_stock' then 'no'
				when meta_key  = '_backorders' then 'no'
				when meta_key  = '_downloadable_files' then '".addslashes(serialize($_file_paths))."'
				end)
				WHERE post_id = '".$prod_id."' ");

			$this->wpdb->query($sql);
			
			// Add Post Meta to restrict Product only 1 purchase per customer.
			
			$sql = $this->wpdb->prepare("DELETE FROM wp_postmeta WHERE post_id = ".$prod_id." AND meta_key = 'woo_limit_one_select_dropdown';");
	 		$this->wpdb->query($sql);
			
			$sql = $this->wpdb->prepare("DELETE FROM wp_postmeta WHERE post_id = ".$prod_id." AND meta_key = 'woo_limit_one_purchased_text';");
	 		$this->wpdb->query($sql);
			
			$sql = $this->wpdb->prepare("DELETE FROM wp_postmeta WHERE post_id = ".$prod_id." AND meta_key = 'userEmail';");
	 		$this->wpdb->query($sql);
			
			
			
			
			// DELETE VENDOR
			
	
				// Get Previous Product Vendor
				$prev_vendor_id = $this->get_previous_vendor($prod_id);
				$sql = $this->wpdb->prepare("DELETE FROM wp_term_relationships WHERE object_id = ".$prod_id." AND term_taxonomy_id = ".$prev_vendor_id ."");
				$this->wpdb->query($sql);
				
				$sql = $this->wpdb->prepare("DELETE FROM wp_term_relationships WHERE object_id = ".$prod_id." AND term_taxonomy_id = ".$vendor_id."");
				$this->wpdb->query($sql);
		
	  
			$sql = $this->wpdb->prepare("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (".$prod_id.", 'woo_limit_one_select_dropdown', '1'),(".$prod_id.", 'woo_limit_one_purchased_text', 'You have already purchased this item.'),(".$lo_post_id.", 'userEmail', '".$vendorId."'); ");
			
			$this->wpdb->query($sql);
			
				// End Product Limit

				$catid = get_term_by('name', $product_type, 'product_cat');
				$objtype = get_term_by('name', $product_objtype, 'ObjectType');
			
			if($vendorId){
	
				$sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (".$prod_id.", '".$vendor_id."', '0');");
			
				$this->wpdb->query($sql);
	
				
			} else{
				// Log Here
				/*
				*/	
				
			}

			//Testing register grade
/*            if($post['M']){
                $data_grades = explode(',', $post['M']);

                if(count($data_grades)){
                    foreach ($data_grades as $grade){
                        $obj_grade = get_term_by('name', $grade, 'category');
                        $sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (".$prod_id.", '".$obj_grade->term_taxonomy_id."', '0');");
                        $this->wpdb->query($sql);
                    }
                }

            }*/

			
			$sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (".$prod_id.", '".$catid->term_taxonomy_id."', '0');");
			
			$this->wpdb->query($sql);

			$this->wpdb->query("COMMIT;");
			$this->wpdb->query("SET autocommit=1;");
		
	}
	
/*-------------------------------------------------------------------------------------------------
 API PLATFORM ITEM SCRIPTS
------------------------------------------------------------------------------------------------- */
	
/* ADD API PRODUCTS ------------------------------------ */
	
	public function add_api_product($post){
			wp_suspend_cache_addition(true);

			$product_price = $post->price; // Doesn't Exist
			$forsale = $post->for_sale; // Doesn't Exist
			$product_title = $post->title;
			$product_type = explode(',',$post->itemType);
			$product_subtype = $post->subType;
			$product_vendor = $post->userFullName;
			$product_file_pre = str_replace('external/' , '', $post->previewURL );
			$product_file = str_replace('preview/' , '', $product_file_pre );
			$product_desc = $post->description;
			$product_sku = $post->itemId;
			$ptype = $post->type;
			
			$vendorId = $post->vendorId; // email
	
			// PRODUCT VENDORS
			if($vendorId){
				$commission      = get_option( 'wcpv_vendor_settings_default_commission' );
				$commission_type = get_option( 'wcpv_vendor_settings_default_commission_type' );
				$vendor_data = $this->wisewire_vendor_by_email($vendorId);
				$vendor_admin = $vendor_data['admin'];
				$vendor_id = $vendor_data['id'];		
				
				if($vendor_data){
					
				} else{
					
					// Vendor Doesn't Exist
					$this->wisewire_log_vendors($vendorId);	
				}
				
			} 

			if($product_price != ''){
				$price = $product_price;
			} else{

				if(in_array('question',$product_type)){
					if($product_type[1] == 'tei'){
						$price = $this->p_price_tei;
					} else{
						$price = $this->p_price_non_tei;
					}
				} else if($ptype = 'pod'){
					$price = $this->p_assessment;
				} else if(in_array('tei',$product_type)){
					$price = $this->p_price_tei;
				}

			}

			$_file_paths = array();
			// file paths will be stored in an array keyed off md5(file path)
			$downdloadArray =array('name'=>esc_sql($product_title), 'file' => $product_file);
			$file_path =md5($product_file);
			$_file_paths[$file_path ] = $downdloadArray;

			$this->wpdb->query("SET autocommit=0;");

			$sql = $this->wpdb->prepare('INSERT INTO wp_posts (post_type,post_title,post_content,post_name,post_date,post_date_gmt,post_modified,post_modified_gmt,post_author,post_status) VALUES ("product","'.esc_sql($product_title).'","'.esc_sql($product_desc).'","'.esc_sql($product_sku).'",now(),now(),now(),now(),1,"publish");');

			$this->wpdb->query($sql);
			/* Product Meta */
			$sid = $this->wpdb->insert_id;

			$sql = $this->wpdb->prepare("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (".$sid.", '_sku', '".$product_sku."'),(".$sid.", '_price', '".$price."'),(".$sid.", '_stock_status', 'instock'),(".$sid.", '_visibility', 'visible' ),(".$sid.", '_downloadable', 'yes'),(".$sid.", '_sold_individually', 'yes'),(".$sid.", '_virtual', 'yes'),(".$sid.", '_regular_price', '".$price."' ),(".$sid.", '_manage_stock', 'no' ),(".$sid.", '_backorders', 'no' ),(".$sid.", '_downloadable_files', '".serialize($_file_paths)."'),(".$sid.", 'woo_limit_one_select_dropdown', '1'),(".$sid.", 'woo_limit_one_purchased_text', 'You have already purchased this item.'),(".$sid.", 'userEmail', '".$vendorId."'); ");
			
			

			$this->wpdb->query($sql);
			
			$sql = $this->wpdb->prepare("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (".$sid.", '_wcsr_required', 'yes'); ");
			
			$this->wpdb->query($sql);
			

			foreach($product_type as $product_cat){
			
				  $catid = get_term_by('slug', $product_cat, 'product_cat');
				  if($product_subtype && $product_cat == 'question'){
					  $subcatid = get_term_by('slug', $product_subtype, 'product_cat');
					  
					  $sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (".$sid.", '".$catid->term_taxonomy_id."', '0'),(".$sid.", '".$subcatid->term_taxonomy_id."', '0');");
				  } else{
					
					$sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (".$sid.", '".$catid->term_taxonomy_id."', '0');");
					  
				  }
				  
				  // wp_set_post_terms( $prod_id, array($catid->term_id,$subcatid->term_id), 'product_cat' );
				  // wp_set_post_terms( $prod_id, $subcatid->term_id, 'product_cat' );
				  // $objtype = get_term_by('name', $product_objtype, 'ObjectType');
	
				  $this->wpdb->query($sql);
			}
			
			
			if($vendor_id){
	
				$sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (".$sid.", '".$vendor_id."', '0');");
			
				$this->wpdb->query($sql);
				
			} else{
				// Log Here
				/*
				*/	
				
			}
			

			$this->wpdb->query("COMMIT;");
			$this->wpdb->query("SET autocommit=1;");
	}
	
/* UPDATE API PRODUCTS ------------------------------------ */
	
	public function update_api_product($post,$prod_id){

			$product_price = $post->price; // Doesn't Exist
			$forsale = $post->for_sale; // Doesn't Exist
			$product_title = $post->title;
			$product_type = explode(',',$post->itemType);
			$product_subtype = $post->subType;
			$product_vendor = $post->userFullName;
			$product_file_pre = str_replace('external/' , '', $post->previewURL );
			$product_file = str_replace('preview/' , '', $product_file_pre );
			$product_desc = $post->description;
			$product_sku = $post->itemId;
			$ptype = $post->type;
			
			$vendorId = $post->vendorId; // Email
	
			// PRODUCT VENDORS
			if($vendorId){
				$commission      = get_option( 'wcpv_vendor_settings_default_commission' );
				$commission_type = get_option( 'wcpv_vendor_settings_default_commission_type' );
				$vendor_data = $this->wisewire_vendor_by_email($vendorId);
				$vendor_admin = $vendor_data['admin'];
				$vendor_id = $vendor_data['id'];		
				
				if($vendor_data){
					
				} else{
					
					// Vendor Doesn't Exist
					$this->wisewire_log_vendors($vendorId);	
				}
				
			} 

			if($product_price != ''){
				$price = $product_price;
			} else{
				
				if(in_array('question',$product_type)){
					if($product_type[1] == 'tei'){
						$price = $this->p_price_tei;
					} else{
						$price = $this->p_price_non_tei;
					}
				} else if($ptype = 'pod'){
					$price = $this->p_assessment;
				} else if(in_array('tei',$product_type)){
					$price = $this->p_price_tei;
				}
			}

			$post_id = $prod_id;

			$_file_paths = array();
			// file paths will be stored in an array keyed off md5(file path)
			$downdloadArray =array('name'=>$product_title, 'file' => $product_file);
			$file_path =md5($product_file);
			$_file_paths[$file_path ] = $downdloadArray;
			$this->wpdb->query("SET autocommit=0;");

			$sql = $this->wpdb->prepare("UPDATE wp_postmeta
				SET meta_value = (case when meta_key = '_sku' then '".$product_sku."'
				 when meta_key  = '_price' then '".$price."'
				when meta_key  = '_stock_status' then 'instock'
				when meta_key  = '_visibility' then 'visible'
				when meta_key  = '_downloadable' then 'yes'
				when meta_key  = '_sold_individually' then 'yes'
				when meta_key  = '_virtual' then 'yes'
				when meta_key  = '_regular_price' then '".$price."'
				when meta_key  = '_manage_stock' then 'no'
				when meta_key  = '_backorders' then 'no'
				when meta_key  = '_downloadable_files' then '".serialize($_file_paths)."'
				end)
				WHERE post_id = '".$prod_id."' ");

			$this->wpdb->query($sql);
			
	
			$sql = $this->wpdb->prepare("DELETE FROM wp_postmeta WHERE post_id = ".$prod_id." AND meta_key = '_wcsr_required'");
			$this->wpdb->query($sql);
			$sql = $this->wpdb->prepare("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (".$prod_id.", '_wcsr_required', 'yes'); ");
			
			$this->wpdb->query($sql);
			
			// Add Post Meta to restrict Product only 1 purchase per customer.
			
			$sql = $this->wpdb->prepare("DELETE FROM wp_postmeta WHERE post_id = ".$prod_id." AND meta_key = 'woo_limit_one_select_dropdown';");
	 		$this->wpdb->query($sql);
			
			$sql = $this->wpdb->prepare("DELETE FROM wp_postmeta WHERE post_id = ".$prod_id." AND meta_key = 'woo_limit_one_purchased_text';");
	 		$this->wpdb->query($sql);
	  
			$sql = $this->wpdb->prepare("INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (".$prod_id.", 'woo_limit_one_select_dropdown', '1'),(".$prod_id.", 'woo_limit_one_purchased_text', 'You have already purchased this item.'); ");
			
			$this->wpdb->query($sql);
			
			
			// DELETE VENDOR
			
				// Get Previous Product Vendor
				$prev_vendor_id = $this->get_previous_vendor($prod_id);
				
				$sql = $this->wpdb->prepare("DELETE FROM wp_term_relationships WHERE object_id = ".$prod_id." AND term_taxonomy_id = ".$prev_vendor_id ."");
				$this->wpdb->query($sql);
				
			
				$sql = $this->wpdb->prepare("DELETE FROM wp_term_relationships WHERE object_id = ".$prod_id." AND term_taxonomy_id = ".$vendor_id."");
				$this->wpdb->query($sql);
			
			// End Product Limit
	
			foreach($product_type as $product_cat){
			
				  $catid = get_term_by('slug', $product_cat, 'product_cat');
				  if($product_subtype && $product_cat == 'question'){
					  $subcatid = get_term_by('slug', $product_subtype, 'product_cat');
					  
					  $sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (".$prod_id.", '".$catid->term_taxonomy_id."', '0'),(".$prod_id.", '".$subcatid->term_taxonomy_id."', '0');");
				  } else{
					
					$sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (".$prod_id.", '".$catid->term_taxonomy_id."', '0');");
					  
				  }
	
	
				  $this->wpdb->query($sql);
			}
			
			
			// ATTACH VENDOR
			if($vendor_id){
	
				$sql = $this->wpdb->prepare("INSERT INTO wp_term_relationships (object_id, term_taxonomy_id, term_order) VALUES (".$prod_id.", '".$vendor_id."', '0');");
			
				$this->wpdb->query($sql);
				
			} else{
				// Log Here
				/*
				*/	
				
			}

			$this->wpdb->query("COMMIT;");
			$this->wpdb->query("SET autocommit=1;");
			
			$stuff['errors'] = $this->wpdb->last_error;
			$stuff['ptype'] = $product_type;
			
	
		
	}
	

/*-------------------------------------------------------------------------------------------------
 SYNC LO SCRIPTS
------------------------------------------------------------------------------------------------- */


	
	public function	sync_lo_products(){
			wp_suspend_cache_addition(true);
			$items = $this->wpdb->get_results( "SELECT ID, post_title,
			GROUP_CONCAT(IF(meta_key = 'item_object_id',meta_value,NULL)) as sku,
			GROUP_CONCAT(IF(meta_key = 'item_price',meta_value,NULL)) as item_price,
			GROUP_CONCAT(IF(meta_key = 'item_grade_level',meta_value,NULL)) as grade_level,
			GROUP_CONCAT(IF(meta_key = 'item_long_description',meta_value,NULL)) as thedescription,
			GROUP_CONCAT(IF(meta_key = 'item_language',meta_value,NULL)) as language,
			GROUP_CONCAT(IF(meta_key = 'item_object_url',meta_value,NULL)) as thefile,
			GROUP_CONCAT(IF(meta_key = 'item_for_sale',meta_value,NULL)) as for_sale,
			GROUP_CONCAT(IF(meta_key = 'item_contributor',meta_value,NULL)) as contributor,
			GROUP_CONCAT(IF(meta_key = 'item_object_type',meta_value,NULL)) as object_type,
			GROUP_CONCAT(IF(meta_key = 'item_content_type_icon',meta_value,NULL)) as item_type,
			GROUP_CONCAT(IF(meta_key = 'item_for_sale',meta_value,NULL)) as for_sale,
			GROUP_CONCAT(IF(meta_key = 'userEmail',meta_value,NULL)) as vendorId
				FROM wp_posts wp
				INNER JOIN `wp_postmeta` wm ON (wm.`post_id` = wp.`ID`)
			WHERE wp.post_type = 'item'
			AND wp.post_status = 'publish'
			GROUP BY ID" );
			// echo count($items);
			$i = 0;
			$updated = 0;
			$added = 0;
			foreach($items as $post){
		
		
				$objid = $post->sku;
				$prod_id = $this->get_product_by_sku( $objid );
	
					if($prod_id){
						$updated++;
						$this->update_lo_product($post,$prod_id);
					} else{
						$added++;
						$errors = $this->add_lo_product($post);
					}
	
				$i++;
		
			}

	
			return true;
	}
	
/* UPDATE LO PRODUCTS W/ RETURN INFO ------------------------------------ */	

	public function	sync_lo_products_ajax(){
			wp_suspend_cache_addition(true);
			$items = $this->wpdb->get_results( "SELECT ID, post_title,
			GROUP_CONCAT(IF(meta_key = 'item_object_id',meta_value,NULL)) as sku,
			GROUP_CONCAT(IF(meta_key = 'item_price',meta_value,NULL)) as item_price,
			GROUP_CONCAT(IF(meta_key = 'item_grade_level',meta_value,NULL)) as grade_level,
			GROUP_CONCAT(IF(meta_key = 'item_long_description',meta_value,NULL)) as thedescription,
			GROUP_CONCAT(IF(meta_key = 'item_language',meta_value,NULL)) as language,
			GROUP_CONCAT(IF(meta_key = 'item_object_url',meta_value,NULL)) as thefile,
			GROUP_CONCAT(IF(meta_key = 'item_for_sale',meta_value,NULL)) as for_sale,
			GROUP_CONCAT(IF(meta_key = 'item_contributor',meta_value,NULL)) as contributor,
			GROUP_CONCAT(IF(meta_key = 'item_object_type',meta_value,NULL)) as object_type,
			GROUP_CONCAT(IF(meta_key = 'item_content_type_icon',meta_value,NULL)) as item_type,
			GROUP_CONCAT(IF(meta_key = 'item_for_sale',meta_value,NULL)) as for_sale,
			GROUP_CONCAT(IF(meta_key = 'userEmail',meta_value,NULL)) as vendorId
				FROM wp_posts wp
				INNER JOIN `wp_postmeta` wm ON (wm.`post_id` = wp.`ID`)
			WHERE wp.post_type = 'item'
			AND wp.post_status = 'publish'
			GROUP BY ID" );
			// echo count($items);
			$i = 0;
			$updated = 0;
			$added = 0;
			foreach($items as $post){
		
		
				$objid = $post->sku;
				$prod_id = $this->get_product_by_sku( $objid );
	
					if($prod_id){
						$updated++;
						$this->update_lo_product($post,$prod_id);
					} else{
						$added++;
						$errors = $this->add_lo_product($post);
					}
	
				$i++;
		
			}
			
			$results['count'] = $i;
			$results['updated'] = $updated;
			$results['added'] = $added;
			$results['errors'] = $errors;
			$results['which'] = 'A';
	
			echo json_encode($results);
			exit();
	}
	
	
	public function	sync_lo_products_database(){
			wp_suspend_cache_addition(true);
			$items = $this->wpdb->get_results( "SELECT ID, post_title,
			GROUP_CONCAT(IF(meta_key = 'item_object_id',meta_value,NULL)) as sku,
			GROUP_CONCAT(IF(meta_key = 'item_price',meta_value,NULL)) as item_price,
			GROUP_CONCAT(IF(meta_key = 'item_grade_level',meta_value,NULL)) as grade_level,
			GROUP_CONCAT(IF(meta_key = 'item_long_description',meta_value,NULL)) as thedescription,
			GROUP_CONCAT(IF(meta_key = 'item_language',meta_value,NULL)) as language,
			GROUP_CONCAT(IF(meta_key = 'item_object_url',meta_value,NULL)) as thefile,
			GROUP_CONCAT(IF(meta_key = 'item_for_sale',meta_value,NULL)) as for_sale,
			GROUP_CONCAT(IF(meta_key = 'item_contributor',meta_value,NULL)) as contributor,
			GROUP_CONCAT(IF(meta_key = 'item_object_type',meta_value,NULL)) as object_type,
			GROUP_CONCAT(IF(meta_key = 'item_content_type_icon',meta_value,NULL)) as item_type,
			GROUP_CONCAT(IF(meta_key = 'item_for_sale',meta_value,NULL)) as for_sale,
			GROUP_CONCAT(IF(meta_key = 'userEmail',meta_value,NULL)) as vendorId
				FROM wp_posts wp
				INNER JOIN `wp_postmeta` wm ON (wm.`post_id` = wp.`ID`)
			WHERE wp.post_type = 'item'
			AND wp.post_status = 'publish'
			GROUP BY ID" );
			// echo count($items);
			$i = 0;
			$updated = 0;
			$added = 0;
			foreach($items as $post){
		
		
				$objid = $post->sku;
				$prod_id = $this->get_product_by_sku( $objid );
	
					if($prod_id){
						$updated++;
						$this->update_lo_product($post,$prod_id);
					} else{
						$added++;
						$errors = $this->add_lo_product($post);
					}
	
				$i++;
		
			}
			
			return true;
	}
	
	
	
	public function	sync_lo_products_single($pid){
			wp_suspend_cache_addition(true);
			$items = $this->wpdb->get_results( "SELECT ID, post_title,
			GROUP_CONCAT(IF(meta_key = 'item_object_id',meta_value,NULL)) as sku,
			GROUP_CONCAT(IF(meta_key = 'item_price',meta_value,NULL)) as item_price,
			GROUP_CONCAT(IF(meta_key = 'item_grade_level',meta_value,NULL)) as grade_level,
			GROUP_CONCAT(IF(meta_key = 'item_long_description',meta_value,NULL)) as thedescription,
			GROUP_CONCAT(IF(meta_key = 'item_language',meta_value,NULL)) as language,
			GROUP_CONCAT(IF(meta_key = 'item_object_url',meta_value,NULL)) as thefile,
			GROUP_CONCAT(IF(meta_key = 'item_for_sale',meta_value,NULL)) as for_sale,
			GROUP_CONCAT(IF(meta_key = 'item_contributor',meta_value,NULL)) as contributor,
			GROUP_CONCAT(IF(meta_key = 'item_commission',meta_value,NULL)) as commission,
			GROUP_CONCAT(IF(meta_key = 'item_object_type',meta_value,NULL)) as object_type,
			GROUP_CONCAT(IF(meta_key = 'item_content_type_icon',meta_value,NULL)) as item_type,
			GROUP_CONCAT(IF(meta_key = 'item_for_sale',meta_value,NULL)) as for_sale,
			GROUP_CONCAT(IF(meta_key = 'userEmail',meta_value,NULL)) as vendorId
				FROM wp_posts wp
				INNER JOIN `wp_postmeta` wm ON (wm.`post_id` = wp.`ID`)
			WHERE wp.post_type = 'item'
			AND wp.ID = ".$pid."
			AND wp.post_status = 'publish'
			GROUP BY ID" );
			// echo count($items);
			$i = 0;
			$updated = 0;
			$added = 0;
			foreach($items as $post){
		
		
				$objid = $post->sku;
				$prod_id = $this->get_product_by_sku( $objid );
	
					if($prod_id){
						$updated++;
						$this->update_lo_product($post,$prod_id);
					} else{
						$added++;
						$errors = $this->add_lo_product($post);
					}
	
				$i++;
		
			}
			
			$results['count'] = $i;
			$results['updated'] = $updated;
			$results['added'] = $added;
			$results['errors'] = $errors;
	
			// echo json_encode($results);
			// return true;
	}
	
	
/*-------------------------------------------------------------------------------------------------
 SYNC API SCRIPTS
------------------------------------------------------------------------------------------------- */
	
	
	public function	sync_api_products($offset){
			wp_suspend_cache_addition(true);
	
			$items = $this->wpdb->get_results( "SELECT DISTINCT (wi.id), wi.itemId,wi.title,wi.itemType,wi.subType,wi.userId,wi.userFullName,wi.previewURL,wi.description,wi.price,wi.userEmail as vendorId,
GROUP_CONCAT(wc.categoryID SEPARATOR ', ') as categories
FROM wp_apicache_items wi
				INNER JOIN `wp_apicache_categories` wc ON (wc.`itemId` = wi.`itemId`)
			WHERE wi.source = '1'
            GROUP BY wi.id" );
		/*	
			wp_apicache_items
	▪	wp_apicache_categories
	▪	wp_apicache_tags
	▪	wp_apicache_contributors
	*/
	
		// echo count($items);
			$i = 0;
			$updated = 0;
			$added = 0;
			foreach($items as $post){
		
		
				$objid = $post->itemId;
				$prod_id = $this->get_product_by_sku( $objid );
	
					if($prod_id){
						$updated++;
						$this->update_api_product($post,$prod_id);
					} else{
						$added++;
						$errors = $this->add_api_product($post);
					}
	
				$i++;
				
				$totalcount = $i + $offset;
		
			}
			
	
			return true;
			
	}
	
	
/* UPDATE PLATFORM ITEMS W/ RETURN INFO ------------------------------------ */		
	public function	sync_api_products_ajax($offset){
			wp_suspend_cache_addition(true);
	
			$items = $this->wpdb->get_results( "SELECT DISTINCT (wi.id), wi.itemId,wi.title,wi.itemType,wi.subType,wi.userId,wi.userFullName,wi.previewURL,wi.description,wi.price,wi.userEmail as vendorId,
GROUP_CONCAT(wc.categoryID SEPARATOR ', ') as categories
FROM wp_apicache_items wi
				INNER JOIN `wp_apicache_categories` wc ON (wc.`itemId` = wi.`itemId`)
			WHERE wi.source = '1'
            GROUP BY wi.id" );
		/*	
			wp_apicache_items
	▪	wp_apicache_categories
	▪	wp_apicache_tags
	▪	wp_apicache_contributors
	*/
	
		// echo count($items);
			$i = 0;
			$updated = 0;
			$added = 0;
			foreach($items as $post){
		
		
				$objid = $post->itemId;
				$prod_id = $this->get_product_by_sku( $objid );
	
					if($prod_id){
						$updated++;
						$this->update_api_product($post,$prod_id);
					} else{
						$added++;
						$errors = $this->add_api_product($post);
					}
	
				$i++;
				
				$totalcount = $i + $offset;
		
			}
			
			
			$results['count'] = $totalcount;
			$results['updated'] = $updated;
			$results['added'] = $added;
			$results['errors'] = $errors;
			$results['which'] = 'B';
	
	
			echo json_encode($results);
			exit();
			
	}
	
/* UPDATE PLATFORM ITEMS VENDORS ------------------------------------ */		
	public function	sync_api_products_vendors($itemId){
			wp_suspend_cache_addition(true);
	
			$items = $this->wpdb->get_results( "SELECT DISTINCT (wi.id), wi.itemId,wi.title,wi.itemType,wi.subType,wi.userId,wi.userFullName,wi.previewURL,wi.description,wi.price,wi.userEmail as vendorId,
GROUP_CONCAT(wc.categoryID SEPARATOR ', ') as categories
FROM wp_apicache_items wi
				INNER JOIN `wp_apicache_categories` wc ON (wc.`itemId` = wi.`itemId`)
			WHERE wi.source = '1'
			AND wi.itemId = '$itemId'
			AND wi.userEmail IS NOT NULL
            GROUP BY wi.id" );
		/*	
			wp_apicache_items
	▪	wp_apicache_categories
	▪	wp_apicache_tags
	▪	wp_apicache_contributors
	*/
	
		// echo count($items);
			$i = 0;
			$updated = 0;
			$added = 0;
			foreach($items as $post){
		
		
				$objid = $post->itemId;
				$prod_id = $this->get_product_by_sku( $objid );
	
					if($prod_id){
						$updated++;
						$updated = $this->update_api_product($post,$prod_id);
					} else{
						$added++;
						$errors = $this->add_api_product($post);
					}
	
				$i++;
				
				$totalcount = $i + $offset;
		
			}
			
			
			$results['count'] = $totalcount;
			$results['updated'] = $updated;
			$results['added'] = $added;
			$results['errors'] = $errors;
			$results['which'] = 'C';
	
			echo json_encode($results);
			exit();
	}
	
/* UPDATE SINGLE PLATFORM ITEM  ------------------------------------ */	
	public function	sync_api_single($itemId){
			wp_suspend_cache_addition(true);
	
			$items = $this->wpdb->get_results( "SELECT DISTINCT (wi.id), wi.itemId,wi.title,wi.itemType,wi.subType,wi.userId,wi.userFullName,wi.previewURL,wi.description,wi.price,wi.userEmail as vendorId,
GROUP_CONCAT(wc.categoryID SEPARATOR ', ') as categories
FROM wp_apicache_items wi
				INNER JOIN `wp_apicache_categories` wc ON (wc.`itemId` = wi.`itemId`)
			WHERE wi.source = '1'
			AND wi.itemId = '$itemId'
            GROUP BY wi.id" );
	
			$i = 0;
			$updated = 0;
			$added = 0;
			foreach($items as $post){
		
		
				$objid = $post->itemId;
				$prod_id = $this->get_product_by_sku( $objid );
	
					if($prod_id){
						$updated++;
						$updated = $this->update_api_product($post,$prod_id);
					} else{
						$added++;
						$errors = $this->add_api_product($post);
					}
	
				$i++;
				
				$totalcount = $i;
		
			}
			
			$results['count'] = $totalcount;
			$results['updated'] = $updated;
			$results['added'] = $added;
			$results['errors'] = $errors;
			$results['which'] = 'C';
	
			echo json_encode($results);
			exit();
			
			
	}
	
/* GET ITEM COUNT ------------------------------------ */		
	public function api_item_count(){
	
		$count = $this->wpdb->get_results('SELECT COUNT(*) FROM wp_apicache_items WHERE type = "item"');
		return $count;
	}
	
	
}


/* ACTIONS ------------------------------------- */	

if($_GET['action']){
	$action = $_GET['action'];
} else{
	$action = $_POST['action'];
}


// CALLED FROM WISEWIRE PRODUCT OPTIONS

if($action == 'lo'){
	 $products = new WiseWireSyncProducts();
	 $products->sync_lo_products_ajax();
}

if($action == 'losingle'){
	 $pid = $_GET['itemId'];
	 $products = new WiseWireSyncProducts();
	 $products->sync_lo_products_single($pid);
	 // echo 'updated';
}


if($action == 'api'){
	 $products = new WiseWireSyncProducts();
	//  $offset = $_GET['offset']*1000;
	 $products->sync_api_products_ajax();

}


// USED FOR TESTING PURPOSES

if($action == 'apicount'){
	$products = new WiseWireSyncProducts();
	$apicount = $products->api_item_count();
	// print_r($apicount[0]);
}


if($action =='apisingle'){
	$products = new WiseWireSyncProducts();
	$itemId = $_GET['itemId'];
	$products->sync_api_single($itemId);
}

if($action == 'apivendors'){
	$products = new WiseWireSyncProducts();
	$itemId = $_GET['itemId'];
	$products->sync_api_products_vendors($itemId);
}





?>