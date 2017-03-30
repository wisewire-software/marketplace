<?php

/**

 * Loop Add to Cart

 *

 * @author 		WooThemes

 * @package 	WooCommerce/Templates

 * @version     2.1.0

 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

$current_user = wp_get_current_user();

$purchasable_once = get_post_meta( get_the_ID(), 'woo_limit_one_select_dropdown', true );
$purchasable_once_text = get_post_meta( get_the_ID(), 'woo_limit_one_purchased_text', true );

if ( $purchasable_once == '1' and wc_customer_bought_product( $current_user->user_email, $current_user->ID, $product->id)) {
	if ($purchasable_once_text) {
		echo $purchasable_once_text;
	}else{
		echo 'Purchased';
	}
}

else

{

echo apply_filters( 'woocommerce_loop_add_to_cart_link',

	sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s</a>',

		esc_url( $product->add_to_cart_url() ),

		esc_attr( $product->id ),

		esc_attr( $product->get_sku() ),

		$product->is_purchasable() ? 'add_to_cart_button' : '',

		esc_attr( $product->product_type ),

		esc_html( $product->add_to_cart_text() )

	),

$product );	

}