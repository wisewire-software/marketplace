<?php


add_action( 'admin_init', 'my_remove_menu_pages' );
function my_remove_menu_pages() {

    global $user_ID;
 	$user = get_user_by( 'ID', $user_ID );
    if ( in_array('wc_product_vendors_pending_vendor',$user->roles) || in_array('wc_product_vendors_admin_vendor',$user->roles) || in_array('wc_product_vendors_manager_vendor',$user->roles) ) {
			// remove_menu_page('wcpv-vendor-settings');
remove_menu_page('edit.php'); // Posts
remove_menu_page('upload.php'); // Media
remove_menu_page('link-manager.php'); // Links
remove_menu_page('edit-comments.php'); // Comments
remove_menu_page('edit.php?post_type=page'); // Pages
remove_menu_page('edit.php?post_type=product'); // Pages
remove_menu_page('plugins.php'); // Plugins
remove_menu_page('themes.php'); // Appearance
remove_menu_page('users.php'); // Users
remove_menu_page('tools.php'); // Tools
remove_menu_page('options-general.php'); // Settings
	// remove_menu_page( 'admin.php?page=wcpv-vendor-settings');
    }
}

function ur_theme_start_session()
{
    if (!session_id())
        session_start();
}
add_action("init", "ur_theme_start_session", 1);

/**
 * Ajax requests
 */
/*
function fb_filter_query( $query, $error = true ) {

if ( is_search() ) {
$query->is_search = false;
$query->query_vars[s] = false;
$query->query[s] = false;

// to error
if ( $error == true )
$query->is_404 = true;
}
}

add_action( 'parse_query', 'fb_filter_query' );
add_filter( 'get_search_form', create_function( '$a', "return null;" ) );*/

add_action( 'wp_ajax_add_favorite', 'ww_ajax_add_favorite' );
add_action( 'wp_ajax_nopriv_add_favorite', 'ww_ajax_add_favorite' );

// add item to favorites
function ww_ajax_add_favorite() {
  // Handle request then generate response using WP_Ajax_Response
  // load favorites menu structure
  require get_template_directory() . "/parts/favorites-menu.php";
  die();
}

add_action( 'wp_ajax_remove_favorite', 'ww_ajax_remove_favorite' );
add_action( 'wp_ajax_nopriv_remove_favorite', 'ww_ajax_remove_favorite' );

// remove item from favorites
function ww_ajax_remove_favorite() {
  // Handle request then generate response using WP_Ajax_Response
  // load favorites menu structure
  require get_template_directory() . "/parts/favorites-menu.php";
  die();
}

add_action( 'wp_ajax_do_rate', 'ww_ajax_do_rate' );
add_action( 'wp_ajax_nopriv_do_rate', 'ww_ajax_do_rate' );

// rate item
function ww_ajax_do_rate() {
  // Handle request then generate response using WP_Ajax_Response
  echo json_encode(array(
    'rate' => round($_REQUEST['item_avg_rate'],1),
    'br_widget' => rating_display_stars($_REQUEST['item_avg_rate'],'',true),
    'br_widget_medium' => rating_display_stars($_REQUEST['item_avg_rate'],'medium',true)
  ));
  die();
}

/**
 * Tell WordPress to run website_setup() when the 'after_setup_theme' hook is run.
 */
 
add_action( 'after_setup_theme', 'website_setup' );

if ( ! function_exists( 'website_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 */
function website_setup() {

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'website' ) );

	// Add support for a variety of post formats
	// add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

	// default thumb size
	set_post_thumbnail_size(237, 120, true);	
	
	// Add custom image sizes
	add_image_size( 'thumb-related', 237, 155, true );
	add_image_size( 'thumb-vertical', 235, 290, true );
	add_image_size( 'home-carousel', 480, 248, true );
	add_image_size( 'home', 680, 260, true );
	add_image_size( 'detail', 700, 280, true );
	add_image_size( 'featured', 940, 340, true );
	add_image_size( 'partner-logos', 280, 280);

}
endif; // website_setup

// Remove Image Sizes in WordPress

function remove_image_sizes( $sizes) {
  unset( $sizes['medium']);
  unset( $sizes['large']);
  return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'remove_image_sizes');


/************* CUSTOM LOGIN PAGE *****************/

// calling your own login css so you can style it

//Updated to proper 'enqueue' method
//http://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
function website_login_css() {
	wp_enqueue_style( 'website_login_css', get_template_directory_uri() . '/css/login.css', false );
}

// changing the logo link from wordpress.org to your site
function website_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function website_login_title() { return get_option('blogname'); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'website_login_css', 10 );
// add_filter('login_headerurl', 'website_login_url');
// add_filter('login_headertitle', 'website_login_title');


/************* CUSTOMIZE ADMIN *******************/

/*
I don't really recommend editing the admin too much
as things may get funky if WordPress updates. Here
are a few funtions which you can choose to use if
you like.
*/

// Custom Backend Footer
function website_custom_admin_footer() {
	_e('<span id="footer-thankyou">Developed by Words & Numbers</span>', 'website');
}

// Add it to the admin area
add_filter('admin_footer_text', 'website_custom_admin_footer');

/** Theme admin settings page (for WiseWire import and others) */

function theme_front_page_settings() {
  
  global $wpdb;
  
  // Check that the user is allowed to update options
  if (!current_user_can('edit_others_pages')) {
    wp_die('You do not have sufficient permissions to access this page.');
  }
  
  // no time limits
  set_time_limit(0);

  // more memory 
  ini_set('memory_limit','512M');
  
  include get_template_directory().'/settings-page.php';

}

function setup_theme_admin_menus() {
  add_submenu_page('edit.php?post_type=item', 
    'Wisewire Control Panel', 'Wisewire Control Panel', 'edit_others_pages', 
    'wisewire-control-panel', 'theme_front_page_settings'); 
}
 
// This tells WordPress to call the function named "setup_theme_admin_menus"
// when it's time to create the menu pages.
add_action("admin_menu", "setup_theme_admin_menus");

// Register Custom Post Type - Items
// https://codex.wordpress.org/Function_Reference/register_post_type

function custom_post_type() {

	$labels = array(
		'name'                => _x( 'LO Items', 'Post Type General Name', 'website' ),
		'singular_name'       => _x( 'Item', 'Post Type Singular Name', 'website' ),
		'menu_name'           => __( 'LO Items', 'website' ),
		'name_admin_bar'      => __( 'Book', 'website' ),
		'parent_item_colon'   => __( 'Parent Item:', 'website' ),
		'all_items'           => __( 'All Items', 'website' ),
		'add_new_item'        => __( 'Add New Item', 'website' ),
		'add_new'             => __( 'Add New', 'website' ),
		'new_item'            => __( 'New Item', 'website' ),
		'edit_item'           => __( 'Edit Item', 'website' ),
		'update_item'         => __( 'Update Item', 'website' ),
		'view_item'           => __( 'View Item', 'website' ),
		'search_items'        => __( 'Search Item', 'website' ),
		'not_found'           => __( 'Not found', 'website' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'website' ),
	);
	$args = array(
		'label'               => __( 'Item', 'website' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'type', 'page-attributes' ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page'
	);
	register_post_type( 'item', $args );

	$labels = array(
		'name'                => _x( 'Testimonials', 'Post Type General Name', 'website' ),
		'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'website' ),
		'menu_name'           => __( 'Testimonials', 'website' ),
		'name_admin_bar'      => __( 'Testimonial', 'website' ),
		'parent_item_colon'   => __( 'Parent Testimonial:', 'website' ),
		'all_items'           => __( 'All Testimonials', 'website' ),
		'add_new_item'        => __( 'Add New Testimonial', 'website' ),
		'add_new'             => __( 'Add New', 'website' ),
		'new_item'            => __( 'New Testimonial', 'website' ),
		'edit_item'           => __( 'Edit Testimonial', 'website' ),
		'update_item'         => __( 'Update Testimonial', 'website' ),
		'view_item'           => __( 'View Testimonial', 'website' ),
		'search_items'        => __( 'Search Testimonial', 'website' ),
		'not_found'           => __( 'Not found', 'website' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'website' ),
	);
	$args = array(
		'label'               => __( 'Testimonial', 'website' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'type' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page'
	);
	register_post_type( 'testimonial', $args );
	
	$labels = array(
		'name'                => _x( 'Partners', 'Post Type General Name', 'website' ),
		'singular_name'       => _x( 'Partner', 'Post Type Singular Name', 'website' ),
		'menu_name'           => __( 'Partners', 'website' ),
		'name_admin_bar'      => __( 'Partner', 'website' ),
		'parent_item_colon'   => __( 'Parent Partner:', 'website' ),
		'all_items'           => __( 'All Partners', 'website' ),
		'add_new_item'        => __( 'Add New Partner', 'website' ),
		'add_new'             => __( 'Add New', 'website' ),
		'new_item'            => __( 'New Partner', 'website' ),
		'edit_item'           => __( 'Edit Partner', 'website' ),
		'update_item'         => __( 'Update Partner', 'website' ),
		'view_item'           => __( 'View Partner', 'website' ),
		'search_items'        => __( 'Search Partner', 'website' ),
		'not_found'           => __( 'Not found', 'website' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'website' ),
	);
	$args = array(
		'label'               => __( 'Partner', 'website' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'type' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page'
	);
	register_post_type( 'partner', $args );	
	
	$labels = array(
		'name'                => _x( 'Contributors', 'Post Type General Name', 'website' ),
		'singular_name'       => _x( 'Contributor', 'Post Type Singular Name', 'website' ),
		'menu_name'           => __( 'Contributors', 'website' ),
		'name_admin_bar'      => __( 'Contributor', 'website' ),
		'parent_item_colon'   => __( 'Parent Contributor:', 'website' ),
		'all_items'           => __( 'All Contributors', 'website' ),
		'add_new_item'        => __( 'Add New Contributor', 'website' ),
		'add_new'             => __( 'Add New', 'website' ),
		'new_item'            => __( 'New Contributor', 'website' ),
		'edit_item'           => __( 'Edit Contributor', 'website' ),
		'update_item'         => __( 'Update Contributor', 'website' ),
		'view_item'           => __( 'View Contributor', 'website' ),
		'search_items'        => __( 'Search Contributor', 'website' ),
		'not_found'           => __( 'Not found', 'website' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'website' ),
	);
	$args = array(
		'label'               => __( 'Contributor', 'website' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'type' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 20,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => false,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page'
	);
	register_post_type( 'contributor', $args );		
	
}

add_action( 'init', 'custom_post_type', 0 );


/*
  Register Custom Taxonomy
  For fields that should be used like tags
  Standards, Language, Related Content
  https://generatewp.com/taxonomy/
*/

function item_taxonomy() {
  
  // Standards
  
	$labels = array(
		'name'                       => _x( 'Standards', 'Taxonomy General Name', 'website' ),
		'singular_name'              => _x( 'Standard', 'Taxonomy Singular Name', 'website' ),
		'menu_name'                  => __( 'Standards', 'website' ),
		'all_items'                  => __( 'All Items', 'website' ),
		'parent_item'                => __( 'Parent Item', 'website' ),
		'parent_item_colon'          => __( 'Parent Item:', 'website' ),
		'new_item_name'              => __( 'New Item Name', 'website' ),
		'add_new_item'               => __( 'Add New Item', 'website' ),
		'edit_item'                  => __( 'Edit Item', 'website' ),
		'update_item'                => __( 'Update Item', 'website' ),
		'view_item'                  => __( 'View Item', 'website' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'website' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'website' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'website' ),
		'popular_items'              => __( 'Popular Items', 'website' ),
		'search_items'               => __( 'Search Items', 'website' ),
		'not_found'                  => __( 'Not Found', 'website' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'Standards', array( 'item' ), $args );

  
  // Languages
  
	$labels = array(
		'name'                       => _x( 'Languages', 'Taxonomy General Name', 'website' ),
		'singular_name'              => _x( 'Language', 'Taxonomy Singular Name', 'website' ),
		'menu_name'                  => __( 'Languages', 'website' ),
		'all_items'                  => __( 'All Items', 'website' ),
		'parent_item'                => __( 'Parent Item', 'website' ),
		'parent_item_colon'          => __( 'Parent Item:', 'website' ),
		'new_item_name'              => __( 'New Item Name', 'website' ),
		'add_new_item'               => __( 'Add New Item', 'website' ),
		'edit_item'                  => __( 'Edit Item', 'website' ),
		'update_item'                => __( 'Update Item', 'website' ),
		'view_item'                  => __( 'View Item', 'website' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'website' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'website' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'website' ),
		'popular_items'              => __( 'Popular Items', 'website' ),
		'search_items'               => __( 'Search Items', 'website' ),
		'not_found'                  => __( 'Not Found', 'website' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'Languages', array( 'item' ), $args );

  // Related
  
	$labels = array(
		'name'                       => _x( 'Related Items From Batch Uploads', 'Taxonomy General Name', 'website' ),
		'singular_name'              => _x( 'Related Item', 'Taxonomy Singular Name', 'website' ),
		'menu_name'                  => __( 'Related', 'website' ),
		'all_items'                  => __( 'All Items', 'website' ),
		'parent_item'                => __( 'Parent Item', 'website' ),
		'parent_item_colon'          => __( 'Parent Item:', 'website' ),
		'new_item_name'              => __( 'New Item Name', 'website' ),
		'add_new_item'               => __( 'Add New Item', 'website' ),
		'edit_item'                  => __( 'Edit Item', 'website' ),
		'update_item'                => __( 'Update Item', 'website' ),
		'view_item'                  => __( 'View Item', 'website' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'website' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'website' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'website' ),
		'popular_items'              => __( 'Popular Items', 'website' ),
		'search_items'               => __( 'Search Items', 'website' ),
		'not_found'                  => __( 'Not Found', 'website' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'Related', array( 'item' ), $args );

	// Object Type
  
	$labels = array(
		'name'                       => _x( 'Object Types', 'Taxonomy General Name', 'website' ),
		'singular_name'              => _x( 'Object Type', 'Taxonomy Singular Name', 'website' ),
		'menu_name'                  => __( 'Object Type', 'website' ),
		'all_items'                  => __( 'All Items', 'website' ),
		'parent_item'                => __( 'Parent Item', 'website' ),
		'parent_item_colon'          => __( 'Parent Item:', 'website' ),
		'new_item_name'              => __( 'New Item Name', 'website' ),
		'add_new_item'               => __( 'Add New Item', 'website' ),
		'edit_item'                  => __( 'Edit Item', 'website' ),
		'update_item'                => __( 'Update Item', 'website' ),
		'view_item'                  => __( 'View Item', 'website' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'website' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'website' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'website' ),
		'popular_items'              => __( 'Popular Items', 'website' ),
		'search_items'               => __( 'Search Items', 'website' ),
		'not_found'                  => __( 'Not Found', 'website' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'ObjectType', array( 'item' ), $args );
	
}
add_action( 'init', 'item_taxonomy', 0 );


/*
  Add additional class to body on home page for not logged in users
  http://code.tutsplus.com/tutorials/adding-to-the-body-class-in-wordpress--cms-21077
*/

add_filter( 'body_class','my_body_classes' );
function my_body_classes( $classes ) {
  if ( (is_front_page()) && (!(is_user_logged_in()) ) ) {
      $classes[] = 'home-notlogged';
  } else {
    $classes[] = '';
  }
  
  return $classes;
}

// Remove unwanted dashboard widgets

function remove_dashboard_meta() {
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); //Removes the 'incoming links' widget
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); //Removes the 'plugins' widget
    remove_meta_box('dashboard_primary', 'dashboard', 'normal'); //Removes the 'WordPress News' widget
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); //Removes the secondary widget
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); //Removes the 'Quick Draft' widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); //Removes the 'Recent Drafts' widget
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); //Removes the 'Activity' widget
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); //Removes the 'At a Glance' widget
    remove_meta_box('dashboard_activity', 'dashboard', 'normal'); //Removes the 'Activity' widget (since 3.8)
}
add_action('admin_init', 'remove_dashboard_meta');

/*
    Remove WordPress Items From Top Admin Bar
*/
function remove_admin_bar_links() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
    $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
    $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
    $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
    $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');      // Remove the content link
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );


/*
    Remove Various Items From WordPress Admin Left Menu Bar
*/
function remove_menus(){
    remove_menu_page( 'edit.php' );                   //Posts
    remove_menu_page( 'edit-comments.php' );          //Comments
}
add_action( 'admin_menu', 'remove_menus' );

/*
  Disable Admin Bar for All Users Except for Administrators
  https://support.woothemes.com/hc/en-us/articles/203107607-Hide-WordPress-Admin-Bar-for-Users
*/
// 
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
  if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
  }
}

/*
  Disable emojicons introduced with WP 4.2
*/

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );;

/*
  Remove WP Generator Tag
*/
remove_action('wp_head', 'wp_generator');

/*
  Allow SVG through WordPress Media Uploader
  https://css-tricks.com/snippets/wordpress/allow-svg-through-wordpress-media-uploader/
*/

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/*
  Add Options Page
  http://www.advancedcustomfields.com/resources/options-page/
*/

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'WW Settings',
		'menu_title'	=> 'General',
		'menu_slug' 	=> 'wisewire-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'wisewire-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Forms and Modals',
		'menu_title'	=> 'Forms and Modals',
		'parent_slug'	=> 'wisewire-settings',
	));	
}

/**
 * Rewrite explore and explore-all links
 */

// add variables available from rewrite url in wp_query
add_filter('query_vars', function( $query_vars ){
  $query_vars[] = 'discipline';
  $query_vars[] = 'grade';
  $query_vars[] = 'page_nr';
  
  return $query_vars;
});

// do the rewrite (remember to use flush_rules!!)
add_action( 'init', function(){
  
  global $wp_rewrite;
  
  add_rewrite_rule(
    'explore/search/(.*)/([0-9]+)/?',
    'index.php?pagename=explore-all&search=$matches[1]&page_nr=$matches[2]',
    'top'
  );
 
  add_rewrite_rule(
    'explore/search/(.+)/?',
    'index.php?pagename=explore-all&search=$matches[1]',
    'top'
  );
	
	add_rewrite_rule(
    'explore/search/?',
    'index.php?pagename=explore-all&search=',
    'top'
  );
	
  add_rewrite_rule(
    'explore/([a-zA-Z0-9_-]+)/([a-zA-Z0-9_-]+)/([0-9]+)/?',
    'index.php?pagename=explore-all&grade=$matches[1]&discipline=$matches[2]&page_nr=$matches[3]',
    'top'
  );
	
  add_rewrite_rule(
    'explore/([a-zA-Z0-9_-]+)/([a-zA-Z0-9_-]+)/?',
    'index.php?pagename=explore-all&grade=$matches[1]&discipline=$matches[2]',
    'top'
  );

  add_rewrite_rule(
    'explore/([a-zA-Z0-9_-]+)/?',
    'index.php?pagename=explore&grade=$matches[1]',
    'top'
  );

  add_rewrite_rule(
    'most-viewed/([0-9]+)/?',
    'index.php?pagename=most-viewed&page_nr=$matches[1]',
    'top'
  );     

  add_rewrite_rule(
    'filtered/([0-9]+)/?',
    'index.php?pagename=filtered&page_nr=$matches[1]',
    'top'
  );     

  $wp_rewrite->flush_rules(false);  

	//echo var_export( $wp_rewrite->wp_rewrite_rules(), true );
} );

/**
 * Display rating stars
 * @param float $points eg. 3.5
 */
function rating_display_stars($points, $size = '', $return = false) {
	 
	$s = '<div class="br-widget br-widget-'.$size.'">';	
	
	for ($i = 1; $i<=5; $i++) {
		$s .= '<div class="'
			.( $points > 0 && $i/$points <= 1 ? 'br-selected' : '' ).' '
			.( $points > 0 && ($i-1)/(int)$points == 1 && ($points*10)%10 >= 5 ? 'br-selected selected-half' : '' )
		.'"></div>';
	}
	
	$s .= '</div>';
  
  if ($return) {
    return $s;
  }
  
  echo $s;
  
  return true;
}

/** 
 * Tools
 */
function f_print_r($variable) {
	echo '<pre>';
	print_r($variable);
	echo '</pre>';
}

function f_paginate($data, $limit = null, $current = null, $adjacents = null) {
	
    $result = array();

    if (isset($data, $limit) === true)
    {
        $result = range(1, ceil($data / $limit));

        if (isset($current, $adjacents) === true)
        {
            if (($adjacents = floor($adjacents / 2) * 2 + 1) >= 1)
            {
                $result = array_slice($result, max(0, min(count($result) - $adjacents, intval($current) - ceil($adjacents / 2))), $adjacents);
            }
        }
    }
	
	if ($current > $adjacents) {
		array_unshift($result, '...');
		array_unshift($result, '1');
	}
	
	if ($current < ceil($data/$limit) - $adjacents) {
		array_push($result, '...');
		array_push($result, ceil($data/$limit));
	}

    return $result;
}

/**
 * @param array $array
 * @param string $value
 * @param bool $asc - ASC (true) or DESC (false) sorting
 * @param bool $preserveKeys
 * @return array
 * */
function f_sort_by_sub_value($array, $value, $asc = true, $preserveKeys = false) {
    if (is_object(reset($array))) {
        $preserveKeys ? uasort($array, function ($a, $b) use ($value, $asc) {
            return $a->{$value} == $b->{$value} ? 0 : ($a->{$value} - $b->{$value}) * ($asc ? 1 : -1);
        }) : usort($array, function ($a, $b) use ($value, $asc) {
            return $a->{$value} == $b->{$value} ? 0 : ($a->{$value} - $b->{$value}) * ($asc ? 1 : -1);
        });
    } else {
        $preserveKeys ? uasort($array, function ($a, $b) use ($value, $asc) {
            return $a[$value] == $b[$value] ? 0 : ($a[$value] - $b[$value]) * ($asc ? 1 : -1);
        }) : usort($array, function ($a, $b) use ($value, $asc) {
            return $a[$value] == $b[$value] ? 0 : ($a[$value] - $b[$value]) * ($asc ? 1 : -1);
        });
    }
    return $array;
}

/**
*	Action to call Solr syncronization when an item from the CMS is deleted
*	First, it verifies if the post_type is item an then performs the
*	syncronization.
*/
add_action( 'admin_init', 'solr_sync_on_delete_init' );
function solr_sync_on_delete_init() {
    add_action( 'wp_trash_post', 'solr_sync_on_delete', 10 );
}

function solr_sync_on_delete( $pid ) {	
    global $wpdb;

    $post_info = get_post( $pid );
	$post_type = $post_info->post_type;

	if( $post_type == "item" ){    	
    	//Call Solr Syncronization
    		$URL = "http://localhost:8983/solr/summarizeditemmetadata/update?stream.body=<delete><query>(id:".$pid.")AND(type:item)AND(source:CMS)</query></delete>&commit=true";
			//$data = file_get_contents($URL);
			$curl = curl_init();
		  	curl_setopt_array( $curl, array(
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLOPT_URL => $URL ) );
		  	curl_exec($curl);
		  	curl_close($curl);    	
	}    
}


/**
 * Global controllers
 */

// Prediction IO
include ABSPATH . 'wp-includes/PredictionIOController.php';

// Default 
require_once( ABSPATH . 'wp-includes/WiseWireApi.php' );
require get_template_directory() . "/Controller.php";
require get_template_directory() . "/Controller/Ratings.php";
require get_template_directory() . "/Controller/Favorites.php";

$controller = new Controller();
$controller->execute_action(); // catch and execute actions from request

$fav_controller = new Controller_Favorites();

// Items helper
require get_template_directory() . "/Controller/WiseWireItems.php";

$WWItems = new Controller_WiseWireItems();

//$WWItems->fix_publish_date();

/*
  http://wordpress.stackexchange.com/a/199878 + some tweaks
*/

function item_platform_redirection( $wp ) {
  global $wp_query;
  if (!is_admin() && is_404() && preg_match( '/^item/', $wp->request ) ) {
    //wp_redirect( home_url( user_trailingslashit( 'item' ) ) );
    $wp_query->is_404 = false;
    load_template( dirname( __FILE__ ) . '/single-item-platform.php' );
    
    header("HTTP/1.1 200 OK");
    exit;
  }
}

add_action( 'wp', 'item_platform_redirection' );

/*
  Explore Page - WordPress, choose categories from the list using ACF plugin
  Show only parent categories
  http://support.advancedcustomfields.com/forums/topic/taxonomy-field-type-filter-to-only-show-parents/
  for future use http://www.advancedcustomfields.com/resources/acf-fields-relationship-query/
*/

add_filter('acf/fields/taxonomy/wp_list_categories', 'my_taxonomy_args', 10, 2);

function my_taxonomy_args( $args, $field ) {
  // do stuff to $args
  $args['depth'] = 1;
  return $args;
}

/**
 * Change Upload Directory for one Custom Post-Type
 *
 * This will change the upload directory for a custom post-type. Attachments for this custom post type will
 * now be uploaded to a seperate "uploads" directory. Make
 * sure you swap out "post-type" and the "my-dir" with the appropriate values...
 * credits to: http://wordpress.stackexchange.com/users/4044/jhdenham
 * and http://yoast.com/smarter-upload-handling-wp-plugins/
 */


add_filter('upload_dir', 'rrwd_upload_dir');
$upload = wp_upload_dir();
// remove_filter('upload_dir', 'rrwd_upload_dir');
function rrwd_upload_dir( $upload ) {
  $id = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : null;
  $parent = get_post( $id )->post_parent;
  // Check the post-type of the current post
  if( "item" == get_post_type( $id ) || "item" == get_post_type( $parent ) )
    $upload['subdir'] = '/items/' . $id . $upload['subdir'];
    $upload['path'] = $upload['basedir'] . $upload['subdir'];
    $upload['url']  = $upload['baseurl'] . $upload['subdir'];
    return $upload;
}

/*
  Delete Associated Media Upon Page Deletion
  http://wordpress.stackexchange.com/a/109803
*/

function delete_associated_media($id) {
    
    if ('item' !== get_post_type($id)) return;
    $upload_dir = wp_upload_dir();
    
    $media = get_children(array(
        'post_parent' => $id,
        'post_type' => 'attachment'
    ));
    if (empty($media)) return;

    foreach ($media as $file) {
        // pick what you want to do
        wp_delete_attachment($file->ID);
        unlink(get_attached_file($file->ID));
    }
  
    // TODO delete folder
    system("rm -rf ".escapeshellarg('/var/www/html/wp-content/uploads/items/'.(int)$id.''));
}
add_action('before_delete_post', 'delete_associated_media');

/*
  Get the keywords and put them as a meta keywords in the head section
  http://www.edwardstafford.com/2010/02/04/wordpress-use-custom-fields-to-add-keyword-meta-data-to-your-posts/
*/

function set_keywords() {
  global $post;
  
  if ('item' == get_post_type($post->ID)) {
  
    $keywords = get_the_tags();
    $keyword_tags = '';
    foreach((array) $keywords as $tag) {
      $keyword_tags .= $tag->name . ',';
    }
  	  
    $metatag= "";
  
    if (empty($keywords)){
      $keywords = '';
    }
  
    $metatag="\t";
    $metatag.= "<meta name=\"keywords\" content=\"";
    $metatag.= $keyword_tags;
    $metatag.= "\" />";
    $metatag.= "\n\n";
    
    echo $metatag;
  
  }
}
add_action('wp_head', 'set_keywords');

// Add new dashboard widgets
function wisewire_add_dashboard_widgets() {
    wp_add_dashboard_widget( 'wisewire_dashboard_welcome', 'Welcome to Wisewise CMS', 'wisewire_add_welcome_widget' );
}

function wisewire_add_welcome_widget(){ ?>
 
    <h4>Wisewise Control Panel</h4>
    <p>
      <a href="edit.php?post_type=item&page=wisewire-control-panel" class="button button-primary button-hero">Go to Batch Uploads</a>
    </p>
         
<?php }
add_action( 'wp_dashboard_setup', 'wisewire_add_dashboard_widgets' );

/*
  The password hint text.
  https://developer.wordpress.org/reference/functions/wp_get_password_hint/
  https://wordpress.org/support/topic/edit-wordpress-password-hint
*/

add_filter( 'password_hint', function( $text ){
    return __( 'Hint: The password should be at least six characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ &amp; ).', 'text-domain' );
});



/* API REST */

function add_new_featured( $request ) {
  
    global $wpdb;
    
 	$data_back = json_decode(file_get_contents('php://input'));
	$title = $data_back->{"title"};
    $externalPreviewURL = $data_back->{"externalPreviewURL"};
    $profilePicUrl = $data_back->{"profilePicUrl"};
    $author = $data_back->{"author"};
    $shortBio = $data_back->{"shortBio"};
    $itemType = $data_back->{"itemType"};	

	$sql = $wpdb->prepare("INSERT INTO `wp_cache_featured` SET "
					. "`title` = %s, `externalPreviewURL` = %s, `profilePicUrl` = %s, `author` = %s, `shortBio` = %s, `itemType` = %s, `date_creation` = now() ",
					$title,
					$externalPreviewURL,
					$profilePicUrl,
					$author,
					$shortBio,
					$itemType														
				);				
	$wpdb->query($sql);

	$response["data"] = array(
					'success'  => true,
					'status' => 200,
				);

	return new WP_REST_Response( $response, 200 );
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'featured', '/post', array(
        'methods' => 'POST',
        'callback' => 'add_new_featured',
        'permission_callback' => function () {
            return current_user_can( 'edit_others_posts' );
        }
    ) );
} );

add_action( 'wp_ajax_nopriv_list_featured', 'list_featured' );
add_action( 'wp_ajax_list_featured', 'list_featured' );

function list_featured() {
	
	global $wpdb;
	// load all featured 

	$sql = "SELECT t.* FROM wp_cache_featured t ";
	$featured_authors = $wpdb->get_results( $sql, ARRAY_A );

	echo json_encode($featured_authors);

	wp_die();
}


/* Add custom data before send mail*/

function wisesire_wpcf7_custom($wpcf7_data)
{

	$form_name = $wpcf7_data->name();
	$mail = $wpcf7_data->prop('mail');

	// remove white spaces to prevent <br> from mandrill
	$new_body = preg_replace("/(>\s+<)/", "><", $mail['body']);

	if ($form_name == 'feedback-form') {

		global $current_user;
		get_currentuserinfo();

		$data_body_message = array(
			'first-name' => $current_user->user_firstname,
			'last-name' => $current_user->user_lastname,
			'email' => $current_user->user_email
		);

		$custom_data = array(
			'[_user_first_name]' => $data_body_message['first-name'],
			'[_user_last_name]'  => $data_body_message['last-name'],
			'[_user_email]'   => $data_body_message['email'],
		);

		//Get page title for subject

		$slug = $_SERVER['REQUEST_URI'];
		$slug = substr($slug, 1);
		$items = explode('/', $slug);

		$page = get_page_by_path($items[1], OBJECT, $items[0]);

		if (!empty ($page->ID)) {
			$custom_data['[_url]'] = $data_body_message['reference_url'] = home_url() . "/wp-admin/post.php?post=" . $page->ID . "&action=edit";// get_edit_post_link($page->ID);
		}

		$page_title = !empty($page->ID) ? get_the_title($page->ID) : null;

		if (empty($page_title)) {
			global $wpdb;
			$item_object_id = $items[1];

			// Load item
			$page = $wpdb->get_row("SELECT p.*, m4.`meta_value` AS `item_ratings` "
				. "FROM `wp_apicache_items` p "
				. "LEFT JOIN `wp_apicache_meta` m4 ON m4.`itemId` = p.`itemId` AND m4.`meta_key` = 'item_ratings'"
				. "WHERE p.`itemId` = '" . esc_sql($item_object_id) . "';");

			$page_title = !empty($page->title) ? $page->title : null;

			if ($page->source == "platform") {
				$custom_data['[_url]'] = $data_body_message['reference_url'] = "https://test-platform.wisewire.com/editor/" . $item_object_id;
			}
		}

		$submission = WPCF7_Submission::get_instance();
		$posted_data = $submission->get_posted_data();
		$data_body_message['message'] = $posted_data['message'];
		$issues = implode("\n", $posted_data['issues']);

		if (empty($issues)) {
			$new_body = preg_replace('#<tr id="issues_data">(.*?)</tr><tr id="message_data">#','', $new_body);
			$data_body_message['issues'] = '';
		} else {
			$data_body_message['issues'] = !empty($issues) ? $issues : '-';
		}

		$page_title .= " - " . get_bloginfo();
		$page_title = html_entity_decode($page_title, ENT_QUOTES, 'UTF-8');
		$custom_data['[_page]'] = $data_body_message['reference_page'] = $page_title;

		//custom subject
		foreach ($custom_data as $key => $value) {
			$new_body = str_replace($key, $value, $new_body);
		}

		$mail['subject'] = $data_body_message['subject'] = "Feedback | $page_title";

	}else{
		$data = $_POST;
		foreach($data as $key => $value){
			$pos = strpos($key, '_wp');
			if ($pos === false) {
				$data_body_message[$key] = $value;
			}
		}

		$data_body_message['subject'] = $mail['subject'];
	}

	$mail['body'] = $new_body;
	$mail['form_name'] = $form_name;
	$mail['body_message'] = $data_body_message;
	$wpcf7_data->set_properties(array('mail' => $mail));

}
add_action("wpcf7_before_send_mail", "wisesire_wpcf7_custom");


function get_user_anonymous(){
	require_once( ABSPATH . 'wp-config.php' );
	include_once( ABSPATH . WPINC . '/class.wp_intercom.php' );

	if(!is_user_logged_in()){
		if(!isset($_COOKIE['intercom-user-id'])){
			$appid = WAN_TEST_ENVIRONMENT ? "vekhwzrt" : "umjqwdw0";
			$wp_intercom = new WP_Intercom($appid);
			$response = $wp_intercom->getUserAnonymous();
			setcookie( 'intercom-id', $response->user->anonymous_id, strtotime( '+20 years' ), COOKIEPATH,  COOKIE_DOMAIN, false);
			setcookie( 'intercom-user-id', $response->user->id, strtotime( '+20 years' ), COOKIEPATH, COOKIE_DOMAIN, false);
		}
	}
}

add_action("init", "get_user_anonymous");

function design_canonical($url) {
	global $post;
	global $wp_query;

	if ( get_post_type( $post->ID ) == 'page' && ($post->post_name == 'explore') ){

		if ( isset($wp_query->query['page_nr']) ){
			$_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

			return substr($_url, 0, strpos($_url, '/'.$wp_query->query['page_nr'].'/')) . "/";
		} else{
			return $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}

	} else {
		return $url;
	}
}
add_filter( 'wpseo_canonical', 'design_canonical' );

/* CUSTOM VENDOR FORM */

function gf_add_vendor(){
		$form_items = array();
		$current_user = wp_get_current_user();
		$vendor_name = $form_items['vendor_name'];
		$vendor_desc = $form_items['vendor_description'];

		$term_args = apply_filters( 'wcpv_registration_term_args', array(
			'description' => $vendor_desc,
		) );

		// add vendor name to taxonomy
		$term = wp_insert_term( $vendor_name, WC_PRODUCT_VENDORS_TAXONOMY, $term_args );

		// no errors, term added, continue
		if ( ! is_wp_error( $term ) && ! empty( $current_user ) ) {
			// add user to term meta
			$vendor_data = array();

			$vendor_data['admins'] = $current_user->ID;

			update_term_meta( $term['term_id'], 'vendor_data', $vendor_data );

			$args['user_id']     = $current_user->ID;
			$args['user_email']  = $current_user->user_email;
			$args['first_name']  = $current_user->user_firstname;
			$args['last_name']   = $current_user->user_lastname;
			$args['user_login']  = __( 'Same as your account login', 'woocommerce-product-vendors' );
			$args['user_pass']   = __( 'Same as your account password', 'woocommerce-product-vendors' );
			$args['vendor_name'] = $vendor_name;
			$args['vendor_desc'] = $vendor_desc;

			// change this user's role to pending vendor
			wp_update_user( array( 'ID' => $current_user->ID, 'role' => 'wc_product_vendors_pending_vendor' ) );
		}
}


add_action("wpcf7_before_send_mail", "wpcf7_do_something_else_with_the_data");
function wpcf7_do_something_else_with_the_data($contact_form){
	
	
	if ( $contact_form->id == 56762 ){
	$first = $_POST['name-first'];
	$last = $_POST['name-last'];
	$email = $_POST['account-email'];
	$vendor = $_POST['vendor-name'];
	$paypal = $_POST['vendor-paypal'];
	$country = $_POST['vendor-country'];
	$city = $_POST['vendor-city'];
	$stat = $_POST['vendor-state'];
	$postal = $_POST['vendor-postal'];
	$phone = $_POST['vendor-phone'];
	$message = $_POST['vendor-message'];

	$current_user = get_user_by('email',$email);
	$vendor_name = $vendor;
	$vendor_desc = $_POST['vendor-desc'];

	$term_args = apply_filters( 'wcpv_registration_term_args', array(
		'description' => $vendor_desc,
	) );

	// add vendor name to taxonomy
	$term = wp_insert_term( $vendor_name, WC_PRODUCT_VENDORS_TAXONOMY, $term_args );

	// no errors, term added, continue
		if ( ! is_wp_error( $term ) && ! empty( $current_user ) ) {
			// add user to term meta
			$vendor_data = array();

			$vendor_data['admins'] = $current_user->ID;
			$vendor_data['email'] = $email;
			$vendor_data['paypal'] = $paypal;
			$vendor_data['commission'] = get_option( 'wcpv_vendor_settings_default_commission', '0' );
			$vendor_data['notes'] = $message;
			update_term_meta( $term['term_id'], 'vendor_data', $vendor_data );

			$args['user_id']     = $current_user->ID;
			$args['user_email']  = $current_user->user_email;
			$args['first_name']  = $current_user->user_firstname;
			$args['last_name']   = $current_user->user_lastname;
			$args['user_login']  = __( 'Same as your account login', 'woocommerce-product-vendors' );
			$args['user_pass']   = __( 'Same as your account password', 'woocommerce-product-vendors' );
			$args['vendor_name'] = $vendor_name;
			$args['vendor_desc'] = $vendor_desc;

			// change this user's role to pending vendor

			if ( current_user_can( 'manage_options' ) ) {
				/* A user with admin privileges */
			} else {
				/* A user without admin privileges */
				wp_update_user( array( 'ID' => $current_user->ID, 'role' => 'wc_product_vendors_pending_vendor' ) );
			}

		}


    // Everything you should need is in this variable
    // var_dump($wpcf7_data);

    // I can skip sending the mail if I want to...
    // $contact_form->skip_mail = false;
	}
	return $contact_form;

}


add_filter( 'wpcf7_validate_email*', 'custom_email_confirmation_validation_filter', 20, 2 );

function custom_email_confirmation_validation_filter( $result, $tag ) {
    $tag = new WPCF7_Shortcode( $tag );
	$email = $_POST['account-email'];

    if ( 'account-email' == $tag->name ) {
        if( email_exists( $email )) {
      		/* stuff to do when email address exists */
   		} else{
			$result->invalidate( $tag, "Must be a current Wisewire account email." );
		}
    }

    return $result;
}


add_filter('wpseo_title','change_custom_title_page', 100);

function change_custom_title_page($data){

    global $post, $wp_query, $wpdb;

    if ( get_post_type( $post->ID ) == 'page' && !isset($wp_query->query['search']) && ($post->post_name == 'explore' || $post->post_name == 'explore-all') ){

    	$_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $table_name = $wpdb->prefix . "wan_custom_seo";
        $custom_seo = $wpdb->get_row("SELECT title from $table_name WHERE url='https://$_url';");
		$title = !empty($custom_seo->title) ? $custom_seo->title : null;

		if ($title == null){
	    	$grade_name = isset($wp_query->query['grade']) ? $wp_query->query['grade'] : 'middle';
	    	$discipline = isset($wp_query->query['discipline']) ? ' | '.$wp_query->query['discipline'] : '';

	    	return 'Explore School Resources for Teachers | '. ucwords( str_replace('-', ' ', $grade_name) ) . " School" . ucwords( str_replace('-', ' ', $discipline) ) . " | Wisewire";
    	} else {
    		return preg_replace('#[\r\n]#', ' ', $title) . " | Wisewire";
    	}



	} else {
		return $data;
	}
}

add_filter('wpseo_metadesc','change_custom_meta_description_page', 100);

function change_custom_meta_description_page($data){

    global $post, $wp_query, $wpdb;

    if ( get_post_type( $post->ID ) == 'page' && !isset($wp_query->query['search']) && ($post->post_name == 'explore' || $post->post_name == 'explore-all') ){

    	$_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    	if ( isset($wp_query->query['page_nr']) ){
            $_url = substr($_url, 0, strpos($_url, '/'.$wp_query->query['page_nr'].'/')) . "/";
        }

        $table_name = $wpdb->prefix . "wan_custom_seo";
        $custom_seo = $wpdb->get_row("SELECT meta_description from $table_name WHERE url='https://$_url';");
		$meta_description = !empty($custom_seo->meta_description) ? $custom_seo->meta_description : null;

    	if ($meta_description == null){
	    	$grade_name = isset($wp_query->query['grade']) ? $wp_query->query['grade'] : 'middle';
	    	$discipline = isset($wp_query->query['discipline']) ? $wp_query->query['discipline'] : '';

	    	return 'Explore School Resources for Teachers. '. ucwords( str_replace('-', ' ', $grade_name) ) . " Grade. " . ucwords( str_replace('-', ' ', $discipline) );
    	} else {
    		return preg_replace('#[\r\n]#', ' ', $meta_description);
    	}

	} else {
		return $data;
	}
}

function hide_dialog_favorite($username)
{
	if ($username) {
		if (isset($_COOKIE['is_hide_dialog_favorite'])  && $_COOKIE['is_hide_dialog_favorite'] == 1) {
			unset($_COOKIE['is_hide_dialog_favorite']);
			setcookie('is_hide_dialog_favorite', "");
		}
	}
}
add_action('wp_login', 'hide_dialog_favorite');

function add_rel_nofollow_to_item($item_id) {
    global $wpdb;

    if(!isset($item_id)){
        return "";
    }

    $table_name = $wpdb->prefix . 'item_rel_nofollow';
    $is_rel_nofollow = $wpdb->get_var($wpdb->prepare("SELECT is_rel_nofollow FROM  $table_name WHERE  item_id= '%s'", $item_id));

    if($is_rel_nofollow){
        return 'rel="nofollow"';
    }else{
        return '';
    }
}


/*** INTERCOM ***/
function send_intercom($array_v)
{
	require_once( ABSPATH . 'wp-config.php' );
	include_once(ABSPATH . WPINC . '/class.wp_intercom.php');
	//$contact_form = $this->contact_form;

	$appid = WAN_TEST_ENVIRONMENT ? "vekhwzrt" : "umjqwdw0";
	$appkey = WAN_TEST_ENVIRONMENT ? "cfed9b1d47102a26f1084fbe36fa0c510b995663" : "0cf09251b0a355fa787a0348463a7c453111331d";
	$wp_intercom = new WP_Intercom($appid, $appkey);

	$output = implode("\n", array_map(
		function ($v, $k) {
			return sprintf("%s: %s", $k, $v);
		},
		$array_v,
		array_keys($array_v)
	));

	$user_id = null;
	if (!is_user_logged_in()) {
		$user_id = $_COOKIE['intercom-user-id'];
	} else {
		$user_id = get_current_user_id();
		$user_info = get_userdata($user_id);
		$response = $wp_intercom->createUpdateUser($user_info->user_email);
		$user_id = $response->id;
	}

	$response = $wp_intercom->createMessage($user_id, $output);

	//var_dump($response);
	if (!$response) {
		return false;
	}

	return true;
}

?>