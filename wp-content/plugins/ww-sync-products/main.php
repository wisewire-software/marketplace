<?php
/*
Plugin Name: WiseWire Sync Products
Version: 1.0
*/


// Added by helloAri for Syncing WooCommerce Products

add_action( 'admin_enqueue_scripts', 'ww_sync_scripts' );

function ww_sync_scripts( $pagenow ) {
    if ($pagenow !== 'item_page_acf-options-wisewire-product-options'){
    	return;
    } else{
    	wp_enqueue_script( 'ww-sync-products', '/wp-content/plugins/ww-sync-products/js/ww-sync-products.js', array('jquery'), null, true );
	}
}

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'WiseWire Product Options',
		'menu_title'	=> 'WiseWire Product Options',
		'parent_slug'	=> 'edit.php?post_type=item',
	));	
	
}





// WOOCOMMERCE STUFF ////////////////////////////////////

function ww_woo_styles() {
		wp_enqueue_style( 'css-yubico-google', plugins_url('css/ww-woo-styles.css', __FILE__) );
}


add_action( 'wp_enqueue_scripts', 'ww_woo_styles'  );	


// ADD TO CART BUTTON FOR CMS ITEMS

function ww_add_cart_button(){
	global $wpdb,$post;
	$sku = get_post_meta($post->ID,'item_object_id',true);

	$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM wp_postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );

	if ( $product_id ){
		echo do_shortcode('[add_to_cart id="'.$product_id.'"]');
	} else{
	
		
	
	}
  
}

add_action( 'ww_add_to_cart', 'ww_add_cart_button' );

// ADD TO CART BUTTON FOR PLATFORM ITEMS

function ww_add_cart_button_platform(){
	global $wpdb,$item;
	
	// Retrieve product id by matching sku and the itemId
	$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM wp_postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $item ) );

	if ( $product_id ){
		echo do_shortcode('[add_to_cart id="'.$product_id.'"]');
	} else{
	
		
	
	}
  
}

add_action( 'ww_add_to_cart_platform', 'ww_add_cart_button_platform' );


// WooCommerce Wrapper

function ww_woo_startwrap(){
	echo '<div class="container">';
}

function ww_woo_endwrap(){
	echo '</div> <!-- End Woo Container -->';
}

add_action( 'woocommerce_before_main_content', 'ww_woo_startwrap' );

add_action( 'woocommerce_after_main_content', 'ww_woo_endwrap' );

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

add_action( 'woocommerce_before_my_page', 'wc_print_notices', 10 );


/* ADD TERMS ON WHEN PLUGIN IS FIRST ACTIVATED */

function insert_ww_terms(){

		wp_insert_term('Activity','product_cat');
		wp_insert_term('Assessment','product_cat');
		wp_insert_term('Courseware','product_cat');
		wp_insert_term('Game','product_cat');
		wp_insert_term('Lab','product_cat');
		wp_insert_term('Lesson','product_cat');
		wp_insert_term('Lesson Plan','product_cat');
		wp_insert_term('Multimedia','product_cat');
		wp_insert_term('Student Resource','product_cat');
		wp_insert_term('Teacher Guide','product_cat');
		wp_insert_term('Tutorial','product_cat');
		wp_insert_term('Assessment - Platform','product_cat', array(
			'description'=> '',
			'slug' => 'standard',
		  )
		);
		
		wp_insert_term('TEI','product_cat', array(
			'description'=> '',
			'slug' => 'tei',
		  )
		);
		
		$qid = wp_insert_term('Question','product_cat');
		
		$question = $qid['term_id'];

		wp_insert_term('Bar Graph','product_cat', array(
			'description'=> '',
			'slug' => 'bar_graph',
			'parent'=> $question
		  )
		);
		wp_insert_term('Cloze Matrix','product_cat', array(
			'description'=> '',
			'slug' => 'cloze_matrix',
			'parent'=> $question
		  )
		);
		wp_insert_term('Content Page','product_cat', array(
			'description'=> '',
			'slug' => 'content_page',
			'parent'=> $question
		  )
		);
		wp_insert_term('Drop Down','product_cat', array(
			'description'=> '',
			'slug' => 'drop_down',
			'parent'=> $question
		  )
		);
		wp_insert_term('Drop Down WP','product_cat', array(
			'description'=> '',
			'slug' => 'drop_down_wp',
			'parent'=> $question
		  )
		);
		wp_insert_term('Equation BUI','product_cat', array(
			'description'=> '',
			'slug' => 'equation_bui',
			'parent'=> $question
		  )
		);
		wp_insert_term('Free DD','product_cat', array(
			'description'=> '',
			'slug' => 'free_dd',
			'parent'=> $question
		  )
		);
		wp_insert_term('Free Textbook','product_cat', array(
			'description'=> '',
			'slug' => 'free_textbox',
			'parent'=> $question
		  )
		);
		wp_insert_term('Function GRA','product_cat', array(
			'description'=> '',
			'slug' => 'function_gra',
			'parent'=> $question
		  )
		);
		wp_insert_term('Graph Ineqa','product_cat', array(
			'description'=> '',
			'slug' => 'graph_inequa',
			'parent'=> $question
		  )
		);
		wp_insert_term('Guided Quest','product_cat', array(
			'description'=> '',
			'slug' => 'guided_quest',
			'parent'=> $question
		  )
		);
		wp_insert_term('Highlight','product_cat', array(
			'description'=> '',
			'slug' => 'highlight',
			'parent'=> $question
		  )
		);
		wp_insert_term('Highlight WP','product_cat', array(
			'description'=> '',
			'slug' => 'highlight_wp',
			'parent'=> $question
		  )
		);
		wp_insert_term('Hot Spot','product_cat', array(
			'description'=> '',
			'slug' => 'hot_spot',
			'parent'=> $question
		  )
		);
		wp_insert_term('Hot Spot WP','product_cat', array(
			'description'=> '',
			'slug' => 'hot_spot_wp',
			'parent'=> $question
		  )
		);
		wp_insert_term('In Text','product_cat', array(
			'description'=> '',
			'slug' => 'in_text',
			'parent'=> $question
		  )
		);
		wp_insert_term('In Text WP','product_cat', array(
			'description'=> '',
			'slug' => 'in_text_wp',
			'parent'=> $question
		  )
		);
		wp_insert_term('Line Plot','product_cat', array(
			'description'=> '',
			'slug' => 'line_plot',
			'parent'=> $question
		  )
		);
		wp_insert_term('Matching','product_cat', array(
			'description'=> '',
			'slug' => 'matching',
			'parent'=> $question
		  )
		);
		wp_insert_term('Matching WP','product_cat', array(
			'description'=> '',
			'slug' => 'matching_wp',
			'parent'=> $question
		  )
		);
		wp_insert_term('Multi Part','product_cat', array(
			'description'=> '',
			'slug' => 'multi_part',
			'parent'=> $question
		  )
		);
		wp_insert_term('Mulitple DD','product_cat', array(
			'description'=> '',
			'slug' => 'multiple_dd',
			'parent'=> $question
		  )
		);
		wp_insert_term('Multiple DD 2','product_cat', array(
			'description'=> '',
			'slug' => 'multiple_dd_',
			'parent'=> $question
		  )
		);
		wp_insert_term('Multiple Sel','product_cat', array(
			'description'=> '',
			'slug' => 'multiple_sel',
			'parent'=> $question
		  )
		);
		wp_insert_term('Number Line','product_cat', array(
			'description'=> '',
			'slug' => 'number_line',
			'parent'=> $question
		  )
		);
		wp_insert_term('Object Creat','product_cat', array(
			'description'=> '',
			'slug' => 'object_creat',
			'parent'=> $question
		  )
		);
		wp_insert_term('Plot Points','product_cat', array(
			'description'=> '',
			'slug' => 'plot_points',
			'parent'=> $question
		  )
		);
		wp_insert_term('Radio Button','product_cat', array(
			'description'=> '',
			'slug' => 'radio_button',
			'parent'=> $question
		  )
		);
		wp_insert_term('Simple DD','product_cat', array(
			'description'=> '',
			'slug' => 'simple_dd',
			'parent'=> $question
		  )
		);
		
		update_option( 'ww_terms_import', 'yes' ); // Adds value to wp_options so function only runs once

}

//First check it make sure this function has not been done
if (get_option('ww_terms_import') != "yes") {

	add_action( 'init', 'insert_ww_terms' );
	
} else{

//now that function has been run, set option so it wont run again


}


/*

Display prices for items. This price is displayed on:
home-loggedin.php
template-explore.php
template-exploreall.php
template-favorites.php
template-most-viewed.php
*/

function print_item_price($item){
	
	global $wpdb;
	
	$source = '';
	
	if($item->source == 'PLATFORM'){
		$source = 'platform';
		$itemID = $item->id;	
		$forsale = '';
	} else if($item->source == 'CMS' && $item->item_object_id){
		$source = 'cms';
		$itemID = $item->item_object_id;	
		$forsale = get_field('item_for_sale', $item->id);
		$post_type = get_post_type($item->id);
	} else{
	
		if($item->ID){
			$itemID = get_field('item_object_id',$item->ID);
			$forsale = get_field('item_for_sale', $item->ID);
			$t = 'a';
			$post_type = get_post_type($item->ID);
		}
		
		if($item->id){
			$itemID = get_field('item_object_id',$item->id);
			$forsale = get_field('item_for_sale', $item->id);
			$t = 'b';
			$post_type = get_post_type($item->id);
		}
		
		
	}
	
	
	$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM wp_postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $itemID  ) );
	
	

	if ( $product_id ){
		// echo do_shortcode('[add_to_cart id="'.$product_id.'"]');
		$price = get_field('_regular_price', $product_id);
		
	} else{
	
		$price = 0;
	
	}
	
	// LOGIC FOR PRICE DISPLAY
	
	$price_formatted = number_format((float)$price, 2, '.', ''); 
	$price_message = '<p class="tile-price"><strong>$'.$price_formatted.'</strong></p>';
	$price_message_free = '<p class="tile-price"><strong>FREE</strong></p>';	
	
	  if($forsale == 'Y' && $price === null){
		  
		  if($source == 'cms' || $post_type == 'item'){ // Check if CMS item or Platform
				  echo $price_message_free;
		  } else{ // If Platform
			  $price_formatted = number_format((float)$price, 2, '.', ''); 
			  echo '<p class="tile-price"><strong>$'.$price_formatted.'</strong></p>';	
		  }
		  
	  } else if($forsale == 'Y' && $price == 0){
		  echo $price_message_free;
	  } else if($forsale == 'Y' && $price > 0){
		  echo $price_message;
	  } else if($forsale == 'N' && $price === null){
		  // Display Nothing
	  } else if($forsale == 'N' && $price > 0){
		  echo $price_message;
	  } else if($source){
		  if($source == 'cms' || $post_type == 'item'){ // Check if CMS item or Platform
				  echo $price_message;
		  } else{ // If Platform
			  if($price_formatted == '0.00'){
				  echo $price_message_free;
			  } else{
			  	echo $price_message;
			  }
		  }  
	  }
	
}
add_action('product_tile_price','print_item_price');


// hide coupon form everywhere
function hide_coupon_field( $enabled ) {
	if ( is_cart() || is_checkout() ) {
		$enabled = false;
	}
	
	return $enabled;
}
//add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field' );


// remove Order Notes from checkout field in Woocommerce
add_filter( 'woocommerce_checkout_fields' , 'alter_woocommerce_checkout_fields' );
function alter_woocommerce_checkout_fields( $fields ) {
     // unset($fields['billing']['billing_first_name']); // remove the customer's First Name for billing
     // unset($fields['billing']['billing_last_name']); // remove the customer's last name for billing
     unset($fields['billing']['billing_company']); // remove the option to enter in a company
     unset($fields['billing']['billing_address_1']); // remove the first line of the address
     unset($fields['billing']['billing_address_2']); // remove the second line of the address
     unset($fields['billing']['billing_city']); // remove the billing city
     unset($fields['billing']['billing_postcode']); // remove the ZIP / postal code field
     unset($fields['billing']['billing_country']); // remove the billing country
     unset($fields['billing']['billing_state']); // remove the billing state
     // unset($fields['billing']['billing_email']); // remove the billing email address - note that the customer may not get a receipt!
     unset($fields['billing']['billing_phone']); // remove the option to enter in a billing phone number
     unset($fields['shipping']['shipping_first_name']);
     unset($fields['shipping']['shipping_last_name']);
     unset($fields['shipping']['shipping_company']);
     unset($fields['shipping']['shipping_address_1']);
     unset($fields['shipping']['shipping_address_2']);
     unset($fields['shipping']['shipping_city']);
     unset($fields['shipping']['shipping_postcode']);
     unset($fields['shipping']['shipping_country']);
     unset($fields['shipping']['shipping_state']);
     // unset($fields['account']['account_username']); // removing this or the two fields below would prevent users from creating an account, which you can do via normal WordPress + Woocommerce capabilities anyway
     // unset($fields['account']['account_password']);
     // unset($fields['account']['account_password-2']);
     unset($fields['order']['order_comments']); // removes the order comments / notes field
     return $fields;
}


// PRODUCT REDIRECTS 

add_action( 'wp', 'product_redirect' );
function product_redirect() {
	global $post;
	if ( is_product() && has_term( 'Question', 'product_cat' ) ) {
		$url = '/item/'.$post->post_name;
		wp_redirect($url,301);
	
	} else if(is_product() && !has_term( 'Question', 'product_cat' ) ){
		$url = '/item/'.sanitize_title($post->post_title);
		wp_redirect($url,301);	
	}
}

/* REGISTER API ITEMS ON PURCHASE */

// Load Registration Script
require_once( ABSPATH . 'wp-content/plugins/ww-sync-products/WiseWireRegisterPlatformItem.php' );


function sendAPI($order_id){
	$order = new WC_Order( $order_id );
	$platformItem = new WiseWireRegisterPlatformItem();
	$token = $platformItem->platform_access_calls();

	$items = $order->get_items();
	$_pf = new WC_Product_Factory();  
	foreach ($items as $item) {
		
		$pid = $item['product_id'];
		$_product = $_pf->get_product($pid);
		$item_id = $_product->get_sku();
		
		$term_list = wp_get_post_terms($pid, 'product_cat', array("fields" => "names"));
		
		if(in_array('Question',$term_list)){
			
			$type = 'item';
			$platformItem->register_items($item_id,$token,$type);

		}
		
		if(in_array('Assessment - Platform',$term_list)){
			
			$type = 'pod';
			$platformItem->register_items($item_id,$token,$type);

		}

	}

}
add_action('woocommerce_order_status_completed', 'sendAPI');

	
/**
 * Changes the redirect URL for the Return To Shop button in the cart.
 *
 * @return string
 */
function wc_empty_cart_redirect_url() {
	return '/explore/';
}
add_filter( 'woocommerce_return_to_shop_redirect', 'wc_empty_cart_redirect_url' );	



function wise_woo_menu(){
	
}
add_action('wise_woo_menu','wisewoo_menu');


// Remove Order Again Button from My Account Page
remove_action( 'woocommerce_order_details_after_order_table', 'woocommerce_order_again_button' );


// Search for downloadable file by file name

function find_wisefile($needle){
		$dirname = '/var/www/downloads';
		$findme  = $needle;
		$dirs    = glob($dirname.'*', GLOB_ONLYDIR);
		$files   = array();
		//--- search through each folder for the file
		//--- append results to $files
		foreach( $dirs as $d ) {
			$f = glob( $d .'/'. $findme );
			if( count( $f ) ) {
				$files = array_merge( $files, $f );
			}
		}
			 if( count($files) ) {
					foreach( $files as $f ) {
						return $f;
					}
			 } else{
				return false;	 
			 }
	}
	
	
	
// define the woocommerce_file_download_path callback 
function filter_woocommerce_file_download_path( $downloadable_files_key__file, $instance, $key ) { 
    
    // make filter magic happen here... 
	$filepath = $downloadable_files_key__file;
	$ext = pathinfo($filepath, PATHINFO_EXTENSION);
	$filename = basename($filepath, ".".$ext); // Look for file by filename without extension
	$foundfile = find_wisefile($filename."*");
	
	if($downloadable_files_key__file){
		if($foundfile){
			$downloadable_files_key__file = $foundfile;	
		} else{
			// echo 'not found';	
		}
	}
	
	
	// Redirect if product is from platform
	if (strpos($downloadable_files_key__file, 'platform.wisewire.com') !== false) {
		if(WAN_TEST_ENVIRONMENT){	
			$downloadable_files_key__file = str_replace('https://platform.wisewire.com','https://test-platform.wisewire.com',$downloadable_files_key__file);
    	} else{
    		$downloadable_files_key__file = str_replace('https://test-platform.wisewire.com','https://platform.wisewire.com',$downloadable_files_key__file);
    	}
	} else{
		
		if(file_exists($foundfile)){
		
		} else{
			// If File not found return error
			$downloadable_files_key__file = '/my-account/?e=404';
		}

    	
	}
	
	
	return $downloadable_files_key__file; 
}; 
         
// add the filter 
add_filter( 'woocommerce_file_download_path', 'filter_woocommerce_file_download_path', 10, 3 ); 


/**
* Add Checkout Link
*/
add_filter( 'wpmenucart_cart_link_item', 'wpmenucart_cart_checkout_buttons', 10, 1 );
function wpmenucart_cart_checkout_buttons($cart_link_item) {
// Overwrite default cart link item with 2 buttons linking to the cart and checkout
global $woocommerce;

// get urls
$checkout_url = $woocommerce->cart->get_checkout_url();
$cart_url = $woocommerce->cart->get_cart_url();

// make buttons
$checkout_button = sprintf('<a class="check" href="%s">Checkout</a>', $checkout_url);
$cart_button = sprintf('<a class="view" href="%s">View Cart</a>', $cart_url);

// menu item
$cart_link_item = sprintf('<li class="menu-item wpmenucart-submenu-item cart-link">%s%s</li>', $checkout_button, $cart_button);

return $cart_link_item;
}


// Hook into checkout
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
	
	$current_user = wp_get_current_user();
     $fields['billing']['billing_first_name']['default'] = $current_user->user_firstname;
	 $fields['billing']['billing_last_name']['default'] = $current_user->user_lastname;
     return $fields;
}


// Add continue shopping link to cart and checkout
function add_continue_shopping(){
	echo '<a class="button wc-backward" href="/explore">Continue Shopping</a>';
}
add_action('woocommerce_after_cart_totals','add_continue_shopping');
add_action('woocommerce_before_checkout_form','add_continue_shopping');


// Replaces PayPal Icon on checkout
function replacePayPalIcon($iconUrl) {
	return '/wp-content/plugins/ww-sync-products/images/paypal.png';
} 
add_filter('woocommerce_paypal_icon', 'replacePayPalIcon');


/**
 * Set page url when cart is empty
 */
add_filter('wpmenucart_emptyurl', 'add_wpmenucart_emptyurl', 1, 1);
function add_wpmenucart_emptyurl ($empty_url) {
	$empty_url = '/explore/';
	return $empty_url;
}

/**
 * Update product when LO Item is updated.
 *
 * @param int $post_id The post ID.
 * @param post $post The post object.
 * @param bool $update Whether this is an existing post being updated or not.
 */
function update_lo_product( $post_id, $post, $update ) {
	
    /*
     * In production code, $slug should be set only once in the plugin,
     * preferably as a class property, rather than in each function that needs it.
     */
    $slug = 'item';

    // If this isn't a 'book' post, don't update it.
    if ( $slug != $post->post_type ) {
        return;
    } else{
    	require_once( ABSPATH . 'wp-content/plugins/ww-sync-products/WiseWireSyncProducts.php' );
    	// - Update the product
		$pid = $post_id;
     	$products = new WiseWireSyncProducts();
	 	$products->sync_lo_products_single($pid);
	 	
	 }
	 
	 return;

}
add_action( 'save_post', 'update_lo_product', 10, 3 );

/* Disable WooCommerce Password Strength Requirement */
function wcvendors_remove_password_strength() {
	  if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
		    wp_dequeue_script( 'wc-password-strength-meter' );
	  }
}
add_action( 'wp_print_scripts', 'wcvendors_remove_password_strength', 100 );


?>