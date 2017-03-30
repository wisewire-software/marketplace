<?php

/**

Plugin Name: Woo Limit One Purchase

Plugin URI: http://

Description: This is a plugin to limit a product to one purchase. 

Author: Adam Bowen

Version: 1.2.1

Author URI: http://www.pnw-design.com/

*/



// Display Fields

add_action( 'woocommerce_product_options_general_product_data', 'woo_limit_one_general_fields' );

// Save Fields

add_action( 'woocommerce_process_product_meta', 'woo_limit_one_general_fields_save' );

function woo_limit_one_general_fields() {

  global $woocommerce, $post;

  echo '<div class="options_group">';

  woocommerce_wp_select( 

  array( 

    'id'      => 'woo_limit_one_select_dropdown', 

    'label'   => __( 'Can only purchase once', 'woocommerce' ), 

    'options' => array(

      '0'   => __( 'No', 'woocommerce' ),

      '1'   => __( 'Yes', 'woocommerce' )

      )

    )

  );

  // Text Field

  woocommerce_wp_text_input(

    array(

    'id' => 'woo_limit_one_purchased_text',

    'label' => __( 'Purchased Text', 'woocommerce' ),

    'placeholder' => 'If left empty default is "Purchased"',

    'desc_tip' => 'true',

    'description' => __( 'Enter the custom purchased text here. This is what displays if already purchased', 'woocommerce' )

    )

  ); 

  echo '</div>';

}

function woo_limit_one_general_fields_save( $post_id ){

  // Select

  $woocommerce_select = $_POST['woo_limit_one_select_dropdown'];

  update_post_meta( $post_id, 'woo_limit_one_select_dropdown', esc_attr( $woocommerce_select ) );  

  $woo_limit_one_purchased_text = $_POST['woo_limit_one_purchased_text'];

  update_post_meta( $post_id, 'woo_limit_one_purchased_text', esc_attr( $woo_limit_one_purchased_text ) ); 

}



function woo_limit_one_plugin_path() {

  // gets the absolute path to this plugin directory

  return untrailingslashit( plugin_dir_path( __FILE__ ) );

}

 

add_filter( 'woocommerce_locate_template', 'woo_limit_one_woocommerce_locate_template', 10, 3 );

function woo_limit_one_woocommerce_locate_template( $template, $template_name, $template_path ) {

global $woocommerce;

$_template = $template;



if ( ! $template_path ) $template_path = $woocommerce->template_url;

$plugin_path  = woo_limit_one_plugin_path() . '/woocommerce/';

// Look within passed path within the theme - this is priority

$template = locate_template(

  array(

    $template_path . $template_name,

    $template_name

  )

);

// Modification: Get the template from this plugin, if it exists

if ( ! $template && file_exists( $plugin_path . $template_name ) )

  $template = $plugin_path . $template_name;

// Use default template

if ( ! $template )

  $template = $_template;

// Return what we found

return $template;

}





add_action( 'template_redirect', 'remove_product_from_cart' );

function remove_product_from_cart() {

    // Run only in the Cart or Checkout Page

    if( is_cart() || is_checkout() ) {

        // Set the current user

        $current_user = wp_get_current_user();

        

        // Cycle through each product in the cart

        foreach( WC()->cart->cart_contents as $prod_in_cart ) {

            // Get the Variation or Product ID

            $prod_id = ( isset( $prod_in_cart['variation_id'] ) && $prod_in_cart['variation_id'] != 0 ) ? $prod_in_cart['variation_id'] : $prod_in_cart['product_id'];

 

            //Check each product and if its set to purchase once.

            $purchasable_once = get_post_meta( $prod_id, 'woo_limit_one_select_dropdown', true );



            // Check to see if IDs match

            if ( $purchasable_once == '1' and wc_customer_bought_product( $current_user->user_email, $current_user->ID, $prod_id)) {

                // Get it's unique ID within the Cart

                $prod_unique_id = WC()->cart->generate_cart_id( $prod_id );

                // Remove it from the cart by un-setting it

                unset( WC()->cart->cart_contents[$prod_unique_id] );
				
				wc_add_notice( 'You have already purchased this item.', $notice_type = 'error' );

            }

        }

 

    }

}