<?php

/*
 *
 * Main functions
 * These functions force registration on products with required registration checked.
 *
 *
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WC_Selective_Registration_Functions {
	/**
	 * Constructor
	 */
	public function __construct() {
		global $woocommerce;
		$this->woocommerce = $woocommerce;

		//Actions
		add_action( 'woocommerce_before_checkout_form', array( $this, 'wcsr_require_account_registration' ), -1 );
		add_action( 'woocommerce_checkout_fields',  array( $this, 'wcsr_account_fields' ), 10 );
		add_action( 'woocommerce_after_checkout_form',  array( $this, 'wcsr_restore_options' ), 100 );
		add_action( 'woocommerce_before_checkout_process',  array( $this, 'wcsr_set_account' ), 10);

		//Filters
		add_filter( 'woocommerce_params', array( $this, 'wcsr_change_guest_option' ), 10, 1 );
		add_filter( 'wc_checkout_params', array( $this, 'wcsr_change_guest_option' ), 10, 1 );
	}

	// Set WooCommerce ready to create account
	public function wcsr_set_account() {
		foreach ( $this->woocommerce->cart->get_cart() as $cart_item_key => $values ) {
			$_product = $values['data'];
			if (get_post_meta($_product->id, '_wcsr_required', true) || get_post_meta($_product->variation_id, '_wcsr_required', true)) {
				$_POST['createaccount'] = 1;
				break;
			}
		}
	}

	//Change Guest Checkout option to no
	public function wcsr_change_guest_option($woocommerce_params) {
		foreach ( $this->woocommerce->cart->get_cart() as $cart_item_key => $values ) {
			$_product = $values['data'];
			if (get_post_meta($_product->id, '_wcsr_required', true) || get_post_meta($_product->variation_id, '_wcsr_required', true)) {
				$woocommerce_params['option_guest_checkout'] = 'no';
				break;
			}
		}
		return $woocommerce_params;
	}

	// Require account registration and enable sign up
	public function wcsr_require_account_registration( $checkout = '' ) {
		foreach ( $this->woocommerce->cart->get_cart() as $cart_item_key => $values ) {
			$_product = $values['data'];
			if (get_post_meta($_product->id, '_wcsr_required', true) || get_post_meta($_product->variation_id, '_wcsr_required', true)) {
				// Make sure users can sign up
				if ( false === $checkout->enable_signup ) {
					$checkout->enable_signup = true;
				}

				// Make sure users are required to register an account
				if ( true === $checkout->enable_guest_checkout ) {
					$checkout->enable_guest_checkout = false;

					if ( ! is_user_logged_in() ) {
						$checkout->must_create_account = true;
					}
				}
			}
		}
	}

	//Make sure account fields are displayed and required
	public function wcsr_account_fields( $checkout_fields ) {
		foreach ( $this->woocommerce->cart->get_cart() as $cart_item_key => $values ) {
			$_product = $values['data'];
			if (get_post_meta($_product->id, '_wcsr_required', true) || get_post_meta($_product->variation_id, '_wcsr_required', true)) {
				$account_fields = array(
					'account_username',
					'account_password',
					'account_password-2',
				);

				foreach ( $account_fields as $account_field ) {
					if ( isset( $checkout_fields['account'][ $account_field ] ) ) {
						$checkout_fields['account'][ $account_field ]['required'] = true;
					}
				}
			}
		}
		return $checkout_fields;
	}

	//Restore default settings after checkout
	public function wcsr_restore_options( $checkout = '' ) {
		$checkout->enable_signup = true;
		$checkout->enable_guest_checkout = true;
		$checkout->must_create_account = false;
	}

}

//Don't run on front end if status is set to disable
if (get_option('wcsr_disable') == 'no' || !get_option('wcsr_disable')) {
	new WC_Selective_Registration_Functions();
}