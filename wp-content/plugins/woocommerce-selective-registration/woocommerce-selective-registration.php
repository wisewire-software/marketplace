<?php
/*
Plugin Name: WooCommerce Selective Registration
Plugin URI: http://www.anthonyvalera.com
Description: A plugin for Woocommerce 2.2.2+ to require registration on selected products. Required Registration checkboxes can be found in product data on Edit Product page.
Version: 1.0
Author: Anthony Valera
Author URI: http://anthonyvalera.com
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class
 */

//Make sure woocommerce is running
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	class WC_Selective_Registration {

		/**
		 * Constructor
		 */
		public function __construct() {
			define( 'WC_SR_VERSION', '1.0' );
			define( 'WC_SR_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
			define( 'WC_SR_MAIN_FILE', __FILE__ );

			// Actions
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'wcsr_action_links' ) );
			add_action( 'plugins_loaded', array( $this, 'init' ), 0 );

			// Filters
			add_filter('woocommerce_get_sections_products', array($this, 'wcsr_add_section'));
		}


		/**
		 * Init files
		 */
		public function init() {

			//Include files
			include_once( 'admin/wcsr-admin-product-section.php' );
			include_once( 'includes/class-wcsr-main-functions.php');
			include_once( 'includes/class-wcsr-display-functions.php');

		}

		public function wcsr_action_links ( $links ) {
			$mylinks = array(
				'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=products&section=wcsr' ) . '">Settings</a>',
				'<a href="http://anthonyvalera.com/contact" target="_blank">Support</a>',
			);
			return array_merge( $links, $mylinks );
		}

		/**
		 * Create the section beneath the products tab
		 **/
		function wcsr_add_section( $sections ) {

			$sections['wcsr'] = __( 'Selective Registration', 'text-domain' );
			return $sections;

		}
	}

	new WC_Selective_Registration();
}

else {
	function wcsr_error_notice() {
		$class = "error";
		$message = "Error: WooCommerce Selective Registration requires Woocommerce. Please check that WooCommerce is activated and running properly.";
		echo"<div class=\"$class\"> <p>$message</p></div>";
	}
	add_action( 'admin_notices', 'wcsr_error_notice' );
}
