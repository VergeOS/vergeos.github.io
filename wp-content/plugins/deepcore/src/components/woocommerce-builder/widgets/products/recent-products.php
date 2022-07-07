<?php

namespace Deep\WooCommerce\Elementor\Widgets\Products_Loop;

use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Recent Products.
 *
 * @since 2.0.0
 */
class Recent_Products extends Products_Loop {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}}';

	/**
	 * Retrieve the widget name.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'deep-woo-recent-products';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Recent Products', 'deep' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'deep-widget deep-eicon-recent-products';
	}

	/**
	 * Render CSS file.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function get_style_depends() {
		return array( 'deep-pagination' );
	}

	/**
	 * Get Default Query Args and Attributes
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array
	 */
	public function get_default_query_attributes() {

		$atts = parent::get_default_query_attributes();

		$atts['orderby'] = 'id';
		$atts['order']   = 'DESC';

		return $atts;
	}

	/**
	 * Add Attributes from Settings
	 *
	 * @param array $atts
	 * @param array $settings
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array
	 */
	public function parse_attributes( $atts, $settings ) {

		// TOTO: Remove Method
		$atts = parent::parse_attributes( $atts, $settings );

		return $atts;
	}
}

