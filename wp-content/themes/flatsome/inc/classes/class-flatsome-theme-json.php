<?php
/**
 * Flatsome_Theme_JSON class.
 *
 * @author  UX Themes
 * @package Flatsome
 * @since   3.18.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Flatsome_Theme_JSON
 *
 * @package Flatsome
 */
final class Flatsome_Theme_JSON {

	/**
	 * Initialize.
	 */
	public function init() {
		add_filter( 'wp_theme_json_data_theme', [ $this, 'update_data' ] );
	}

	/**
	 * Modifies the `theme.json` values.
	 *
	 * @param WP_Theme_JSON_Data $theme_json Theme JSON data instance.
	 */
	public function update_data( $theme_json ) {
		$data = $theme_json->get_data();

		$this->update_color_values( $data );
		$this->update_custom_settings( $data );

		return $theme_json->update_with( $data );
	}

	/**
	 * Update color values.
	 *
	 * @param array $data Theme JSON data.
	 */
	private function update_color_values( &$data ) {
		$colors = array(
			'primary'   => get_theme_mod( 'color_primary', Flatsome_Default::COLOR_PRIMARY ),
			'secondary' => get_theme_mod( 'color_secondary', Flatsome_Default::COLOR_SECONDARY ),
			'success'   => get_theme_mod( 'color_success', Flatsome_Default::COLOR_SUCCESS ),
			'alert'     => get_theme_mod( 'color_alert', Flatsome_Default::COLOR_ALERT ),
		);

		if ( isset( $data['settings']['color']['palette']['theme'] ) ) {
			foreach ( $data['settings']['color']['palette']['theme'] as &$color ) {
				if ( isset( $color['slug'] ) && isset( $colors[ $color['slug'] ] ) ) {
					$color['color'] = $colors[ $color['slug'] ];
				}
			}
		}
	}

	/**
	 * Update custom settings.
	 *
	 * @param array $data Theme JSON data.
	 */
	private function update_custom_settings( &$data ) {
		$settings = array(
			'link' => array(
				'color'      => get_theme_mod( 'color_links' ) ?: Flatsome_Default::LINK_COLOR,
				'colorHover' => get_theme_mod( 'color_links_hover' ) ?: Flatsome_Default::LINK_COLOR_HOVER,
			),
		);

		if ( isset( $data['settings']['custom']['experimental'] ) ) {
			foreach ( $data['settings']['custom']['experimental'] as $key => &$value ) {
				if ( isset( $settings[ $key ] ) ) {
					$value = array_replace_recursive( $value, $settings[ $key ] );
				}
			}
		}
	}
}
