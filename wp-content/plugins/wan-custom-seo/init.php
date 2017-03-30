<?php
/*
Plugin Name: wan-custom-seo
Description: Wan Custom Seo
Version: 1
Author: Words and Numbers
Author URI: http://wisewire.com
*/
// function to create the DB / Options / Defaults					
function ss_options_install() {

    global $wpdb;

    $table_name = $wpdb->prefix . "wan_custom_seo";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (            
            `id` integer NOT NULL AUTO_INCREMENT,
  			`url` varchar(200) CHARACTER SET utf8 NOT NULL,
  			`title` varchar(200) CHARACTER SET utf8 NOT NULL,
  			`meta_description` text CHARACTER SET utf8 NOT NULL,
            PRIMARY KEY (`id`)
          ) $charset_collate; ";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
}

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'ss_options_install');

//menu items
add_action('admin_menu','wp_wan_custom_seo_modifymenu');
function wp_wan_custom_seo_modifymenu() {
	
	//this is the main item for the menu
	add_menu_page('Custom SEO', //page title
	'Custom SEO', //menu title
	'manage_options', //capabilities
	'wp_wan_custom_seo_list', //menu slug
	'wp_wan_custom_seo_list' //function
	);
	
	//this is a submenu
	add_submenu_page('wp_wan_custom_seo_list', //parent slug
	'Add New Custom SEO', //page title
	'Add New', //menu title
	'manage_options', //capability
	'wp_wan_custom_seo_create', //menu slug
	'wp_wan_custom_seo_create'); //function
	
	//this submenu is HIDDEN, however, we need to add it anyways
	add_submenu_page(null, //parent slug
	'Update Custom SEO', //page title
	'Update', //menu title
	'manage_options', //capability
	'wp_wan_custom_seo_update', //menu slug
	'wp_wan_custom_seo_update'); //function
}
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'custom-seo-list.php');
require_once(ROOTDIR . 'custom-seo-create.php');
require_once(ROOTDIR . 'custom-seo-update.php');