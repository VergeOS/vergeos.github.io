<?php

namespace Deep\WooCommerce\Elementor\Widgets\Products_Loop;

use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Up Sell Products.
 *
 * @since 5.0.0
 */
class Up_Sell_Products extends Products_Loop {

	/**
	 * @since 5.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}}';

	/**
	 * Retrieve the widget name.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'deep-woo-up-sell-products';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Product Upsells', 'deep' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'deep-widget deep-eicon-upsell-products';
	}

	/**
	 * Render CSS file.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function get_style_depends() {
		return array( 'deep-pagination' );
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function render() {

		$this->prepare_render();

		parent::render();

		$this->reset_render();
	}

	/**
	 * Get Default Query Args and Attributes
	 *
	 * @since 5.0.0
	 * @access public
	 *
	 * @return array
	 */
	public function get_default_query_attributes() {

		$atts = parent::get_default_query_attributes();

		return $atts;
	}

	/**
	 * Add Attributes from Settings
	 *
	 * @param array $atts
	 * @param array $settings
	 *
	 * @since 5.0.0
	 * @access public
	 *
	 * @return array
	 */
	public function parse_attributes( $atts, $settings ) {

		$atts = parent::parse_attributes( $atts, $settings );

		return $atts;
	}

	/**
	 * Prepare Query Args
	 *
	 * @param array  $query_args
	 * @param array  $attributes
	 * @param string $type
	 *
	 * @since 5.0.0
	 * @access public
	 *
	 * @return array
	 */
	public function prepare_query_args( $query_args, $attributes, $type ) {

		if ( false === strpos( $type, 'deep-woo-' ) ) {

			return $query_args;
		}

		$query_args = parent::prepare_query_args( $query_args, $attributes, $type );

		$p_id       = isset( $query_args['p'] ) ? $query_args['p'] : '';
		$q_post__in = isset( $query_args['post__in'] ) ? $query_args['post__in'] : '';
		$q_post__in = empty( $post__in ) && ! empty( $p_id ) ? array( $p_id ) : $q_post__in;

		if ( empty( $q_post__in ) ) {

			global $product;
			$upsell_products = is_a( $product, '\WC_Product' ) ? $product->get_upsell_ids() : array();
			$post__in        = $upsell_products;
		} else {

			$post__in = $q_post__in;
		}
		$query_args['p']        = '';
		$query_args['post__in'] = $post__in;

		return $query_args;
	}
}

