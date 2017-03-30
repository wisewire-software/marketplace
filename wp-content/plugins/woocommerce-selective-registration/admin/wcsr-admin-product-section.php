<?php
/*
 * Admin page for Woocommerce selective registration
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add settings to the specific section we created before
 */
add_filter( 'woocommerce_get_settings_products', 'wcsr_all_settings', 10, 2 );

function wcsr_all_settings( $settings, $current_section ) {
	$status = (get_option('wcsr_disable') == NULL || get_option('wcsr_disable') == 'no') ? '<span style="color: #7AD03A;">Active</span>' : '<span style="color: #D54E21;">Disabled</span>';
	/**
	 * Check the current section is what we want
	 **/
	if ( $current_section == 'wcsr' ) {
		$settings_wcsr = array();
		// Add Title to the Settings
		$settings_wcsr[] = array( 'name' => __( 'Woocommerce Selective Registration', 'text-domain' ), 'type' => 'title', 'desc' => __( 'The following options are used to configure Woocommerce Selective Registration. ', 'text-domain' ), 'id' => 'wcsr' );

		$settings_wcsr[] = array(
			'name'     => __( '', 'text-domain' ),
			'desc' => __( '<strong>Status:</strong> '.$status, 'text-domain' ),
			'type'     => 'title',
			'id'       => 'wcsr_status',
		);

		$settings_wcsr[] = array(
			'name'     => __( '', 'text-domain' ),
			'desc'     => '<hr/>',
			'type'     => 'title',
			'id'       => '',
		);

		// Add checkbox option
		$settings_wcsr[] = array(
			'name'     => __( 'Disable all', 'text-domain' ),
			'desc_tip' => __( 'This will temporarily disable all required registration for selected products.', 'text-domain' ),
			'id'       => 'wcsr_disable',
			'type'     => 'checkbox',
			'css'      => 'min-width:300px;',
			'desc'     => __( 'Disable Selective Registration', 'text-domain' ),
		);

		$settings_wcsr[] = array( 'type' => 'sectionend', 'id' => 'wcsr' );
		return $settings_wcsr;

		/**
		 * If not, return the standard settings
		 **/
	} else {
		return $settings;
	}
}