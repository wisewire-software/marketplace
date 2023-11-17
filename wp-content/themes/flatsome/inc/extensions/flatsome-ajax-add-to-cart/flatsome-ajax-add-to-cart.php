<?php
/**
 * Flatsome Ajax add to cart extension.
 *
 * @package    Flatsome/Extensions
 * @since      3.17.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * To be enqueued script.
 */
function flatsome_ajax_add_to_cart_script() {
	wp_enqueue_script(
		'flatsome-ajax-add-to-cart-frontend',
		get_template_directory_uri() . '/assets/js/extensions/flatsome-ajax-add-to-cart-frontend.js',
		array( 'jquery' ),
		flatsome()->version(),
		true
	);
}

add_action( 'wp_enqueue_scripts', 'flatsome_ajax_add_to_cart_script' );

/**
 * Single product ajax add to cart.
 *
 * @deprecated 3.18 No alternative available.
 */
function flatsome_ajax_add_to_cart() {
	_deprecated_function( __FUNCTION__, '3.18' );

	die();
}
