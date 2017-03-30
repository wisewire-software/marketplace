<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $woocommerce, $product;
if ( ! $product->is_purchasable() ) return;
	$current_user = wp_get_current_user();
	$purchasable_once = get_post_meta( get_the_ID(), 'woo_limit_one_select_dropdown', true );
	$purchasable_once_text = get_post_meta( get_the_ID(), 'woo_limit_one_purchased_text', true );
	if ( $purchasable_once == '1' and wc_customer_bought_product( $current_user->user_email, $current_user->ID, $product->id)) {
			if ($purchasable_once_text) {
				echo '<p class="woo-limit-one">'.$purchasable_once_text.'</p>';
			}else{
				echo '<p class="woo-limit-one">Purchased</p>'; 
			}
	}
	else{
		// Availability
		$availability = $product->get_availability();
		if ( $availability['availability'] )
			echo apply_filters( 'woocommerce_stock_html', '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>', $availability['availability'] );
		if ( $product->is_in_stock() ) : ?>
		<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
		<form class="cart" method="post" enctype='multipart/form-data'>
		 	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
		 	<?php
		 		if ( ! $product->is_sold_individually() )
		 			woocommerce_quantity_input( array(
		 				'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
		 				'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
		 			) );
		 	?>
		 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
		 	<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		</form>
		<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
		<?php endif;	
	}
?>