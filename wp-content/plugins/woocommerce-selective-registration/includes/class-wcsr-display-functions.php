<?php

/*
 *
 * Display functions
 * These functions display and save the checkboxes on the admin product page
 *
 *
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WC_Selective_Registration_Display {

	/**
	 * Constructor
	 */
	public function __construct() {

		// Display Fields
		add_action( 'woocommerce_product_options_general_product_data', array( $this, 'wcsr_general_checkbox' ) );
		add_action( 'woocommerce_variation_options', array( $this, 'wcsr_variable_checkbox' ), 10, 3 );

		//JS to add fields for new variations
		add_action( 'woocommerce_product_after_variable_attributes_js', array( $this, 'wcsr_variable_checkbox_js' ) );

		// Save Fields
		add_action( 'woocommerce_process_product_meta', array( $this, 'wcsr_general_checkbox_save' ) );

		//Save variation fields
		add_action( 'woocommerce_process_product_meta_variable', array( $this, 'wcsr_variable_checkbox_save' ), 10, 1 );
	}


	/**
	 * Simple product checkbox
	 */
	public function wcsr_general_checkbox() {

		global $woocommerce, $post;

		echo '<div class="options_group">';

		woocommerce_wp_checkbox(
			array(
				'id'            => '_wcsr_general_required',
				'wrapper_class' => 'show_if_simple',
				'label'         => __('Require Registration', 'woocommerce' ),
				'description'   => __( 'Require user to register or login to purchase', 'woocommerce' ),
				'value'         => get_post_meta($post->ID, '_wcsr_required', true)
			)
		);

		echo '</div>';
	}

	/**
	 * Simple product checkbox save setting
	 */
	public function wcsr_general_checkbox_save($post_id) {

		// If general checkbox is set AND product type set to simple, save
		if (isset($_POST['_wcsr_general_required']) && $_POST['product-type'] == 'simple') {
			update_post_meta($post_id, '_wcsr_required', 'yes');
		}

		else {
			if (get_post_meta($post_id, '_wcsr_required', true)) {
				delete_post_meta($post_id, '_wcsr_required');
			}
		}
	}

	/**
	 * Variable product checkbox
	 */
	public function wcsr_variable_checkbox( $loop, $variation_data, $variation ) {
		$this->wcsr_variation_checkbox(
			array(
				'id'            => '_wcsr_required['.$loop.']',
				'label'         => __( 'Require Registration', 'woocommerce' ),
				'value'         => get_post_meta($variation->ID, '_wcsr_required', true),
				'class'         => 'checkbox variable_require_registration'
			)
		);
	}
	/**
	 * Variable product checkbox js
	 */
	public function wcsr_variable_checkbox_js() {
		$this->wcsr_variation_checkbox(
			array(
				'id'            => '_wcsr_required['.$loop.']',
				'label'         => __( 'Require Registration', 'woocommerce' ),
				'value'         => get_post_meta($variation->ID, '_wcsr_required', true),
				'class'         => 'checkbox variable_require_registration'
			)
		);
	}

	/**
	 * Variable product checkboxes save
	 */
	public function wcsr_variable_checkbox_save( $post_id ) {
		if (isset( $_POST['variable_sku'] ) ) :
		$variable_sku          = $_POST['variable_sku'];
		$variable_post_id      = $_POST['variable_post_id'];

		$_checkbox = $_POST['_wcsr_required'];
		for ( $i = 0; $i < sizeof( $variable_sku ); $i++ ) :
			$variation_id = (int) $variable_post_id[$i];
		if ( isset( $_checkbox[$i] ) ) {
			update_post_meta( $variation_id, '_wcsr_required', stripslashes( $_checkbox[$i] ) );
		}

		else {
			if (get_post_meta($variation_id, '_wcsr_required', true)) {
				delete_post_meta($variation_id, '_wcsr_required');
			}
		}
		endfor;
		endif;
	}


	/*
	 * Adds a custom checkbox for variations (without wrapped p and customized to look like other options)
	 *
	 */
	public function wcsr_variation_checkbox($field) {
		global $thepostid, $post;

		$thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
		$field['label']         = isset( $field['label'] ) ? $field['label'] : 'Require Registration';
		$field['class']         = isset( $field['class'] ) ? $field['class'] : 'checkbox';
		$field['style']         = isset( $field['style'] ) ? $field['style'] : '';
		$field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
		$field['value']         = isset( $field['value'] ) ? $field['value'] : get_post_meta( $thepostid, $field['id'], true );
		$field['cbvalue']       = isset( $field['cbvalue'] ) ? $field['cbvalue'] : 'yes';
		$field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
		$field['tip']           = isset( $field['tip'] ) ? $field['tip'] : 'Require user to register or login to purchase';

		// Custom attribute handling
		$custom_attributes = array();

		if ( ! empty( $field['custom_attributes'] ) && is_array( $field['custom_attributes'] ) ) {

			foreach ( $field['custom_attributes'] as $attribute => $value ){
				$custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
			}
		}

		echo '<label for="' . esc_attr( $field['id'] ) . '"><input type="checkbox" class="' . esc_attr( $field['class'] ) . '" style="' . esc_attr( $field['style'] ) . '" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['cbvalue'] ) . '" ' . checked( $field['value'], $field['cbvalue'], false ) . '  ' . implode( ' ', $custom_attributes ) . '/> ';
		echo wp_kses_post( $field['label'] );
		echo ' <a class="tips" data-tip="'.$field['tip'].'" href="#">[?]</a></label>';
	}
}

new WC_Selective_Registration_Display();